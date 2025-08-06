<?php

namespace App\Http\Controllers\Universities;

use App\Http\Controllers\Controller;
use App\Http\Resources\UniversityResource;
use App\Models\University;
use Illuminate\Http\Request;

class UniversityController extends Controller
{
    public function index()
    {
        $universities = University::query()
            ->get();

        return $this->successResponse('', UniversityResource::collection($universities));
    }
}
