<?php

namespace App\Http\Resources\Users;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JetBrains\PhpStorm\ArrayShape;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    #[ArrayShape(['id' => "int", 'name' => "string", 'email' => "string", 'external_user' => "mixed"])] public function toArray($request): array
    {
        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'external' => null,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
        ];

        if (env('EXTERNAL_APP')) {
            $data['external'] = new UserShortResource($this->external);
        } else {
            unset($data['external']);
        }

        return $data;
    }
}
