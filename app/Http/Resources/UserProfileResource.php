<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'fisrtname' => $this->firstname,
            'lastname'  => $this->lastname,
            'surname'   => $this->surname,
            'phone'   => $this->phone,
            'birth'   => $this->birth,
            'sex'   => $this->sex,
            'organization'   => $this->organization,
            'bio'   => $this->bio,
        ];
    }
}
