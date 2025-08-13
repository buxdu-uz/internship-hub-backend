<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApplicationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {


        return [
            'id' => $this->id,
            'direction' => $this->direction,
            'duration' => $this->durationCalculate($this->start_at, $this->end_at),
            'date' => $this->date->format('Y-m-d'),
            'reason' => $this->reason,
            'plan' => $this->plan,
            'status' => $this->status,
            'start_at' => $this->start_at->format('Y-m-d H:i:s'),
            'end_at' => $this->end_at->format('Y-m-d H:i:s'),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'enterprise' => new EnterPriseResource($this->enterprise),
            'teacher' => new UserResource($this->teacher),
            'files' => FileResource::collection($this->files),
            'check' => new ApplicationCheckResource($this->checkApplication),
        ];
    }

    public function durationCalculate($start_at,$end_at)
    {
        $start = Carbon::parse($start_at);
        $end   = Carbon::parse($end_at);

        $diff = $start->diff($end);

        if ($diff->y > 0 && $diff->m == 0 && $diff->d == 0) {
            $duration = "{$diff->y} yil";
        } elseif ($diff->m > 0 && $diff->d == 0 && $diff->y == 0) {
            $duration = "{$diff->m} oy";
        } elseif ($diff->d > 0 && $diff->y == 0 && $diff->m == 0) {
            $duration = "{$diff->d} kun";
        } else {
            // Agar kombinatsiya bo‘lsa (masalan 1 yil 2 oy), hammasini ko‘rsatamiz
            $duration = trim(
                ($diff->y ? "{$diff->y} yil " : '') .
                ($diff->m ? "{$diff->m} oy " : '') .
                ($diff->d ? "{$diff->d} kun" : '')
            );
        }

        return $duration;
    }
}
