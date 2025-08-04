<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     */
    public function report(Throwable $exception): void
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     */
    public function render($request, Throwable $exception): JsonResponse
    {
        return $this->handleException($request, $exception);
    }

    /**
     * Custom exception handling logic.
     */
    protected function handleException(Request $request, Throwable $exception): JsonResponse
    {
        if ($exception instanceof MethodNotAllowedHttpException) {
            return response()->json([
                'error' => 'The specified method for the request is invalid'
            ], 405);
        }

        if ($exception instanceof RouteNotFoundException || $exception instanceof NotFoundHttpException) {
            return response()->json([
                'error' => 'The specified URL cannot be found'
            ], 404);
        }

        if ($exception instanceof HttpException) {
            return response()->json([
                'error' => $exception->getMessage()
            ], $exception->getStatusCode());
        }

        if ($exception instanceof ValidationException) {
            $items = $exception->validator->errors()->getMessages();
            return response()->json([
                'errors' => $items
            ], 422);
        }

        if ($exception instanceof AuthenticationException) {
            return response()->json([
                'error' => $exception->getMessage()
            ], 401);
        }

        if ($exception instanceof AuthorizationException) {
            return response()->json([
                'error' => $exception->getMessage()
            ], 403);
        }

        return response()->json([
            'error' => $exception->getMessage(),
            'file'  => $exception->getFile(),
            'line'  => $exception->getLine(),
        ], 500);
    }
}
