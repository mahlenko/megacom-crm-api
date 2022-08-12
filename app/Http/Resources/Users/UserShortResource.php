<?php

namespace App\Http\Resources\Users;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JetBrains\PhpStorm\ArrayShape;

class UserShortResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    #[ArrayShape(['id' => "int", 'name' => "string", 'email' => "string", 'sip' => "array"])] public function toArray($request): array
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->user_name,
            'email' => $this->resource->user_mail,
            'sip' => [
                'number' => $this->resource->user_phone,
                'forward' => $this->resource->forward_phone
            ],
        ];
    }
}
