<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LoginResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'fisrtname' => $this->profile->firstname,
            'lastname'  => $this->profile->lastname,
            'surname'   => $this->profile->surname,
            'login' =>$this->login,
            'is_active' =>$this->is_active,
            'roles' => $this->getRoleNames()
        ];
    }
}
