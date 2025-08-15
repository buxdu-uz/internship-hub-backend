<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApplicationBallResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'ball' => $this->ball,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'comment' => $this->comment,
        ];
    }

}
