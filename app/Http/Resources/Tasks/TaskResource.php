<?php

namespace App\Http\Resources\Tasks;

use App\Http\Resources\Users\UserShortCollection;
use App\Http\Resources\Users\UserShortResource;
use DateTimeImmutable;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     * @throws Exception
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->resource->id,
            'title' => $this->resource->task_name,
            'description' => $this->resource->note,
            'comment' => $this->resource->task_comment,
            'require_report' => $this->resource->require_report == 'Y',
            'result_text' => $this->resource->task_result,
            'verification_at' => $this->resource->date_check ? (new DateTimeImmutable($this->resource->date_check))->format('Y-m-d') : null,
            'finished_at' => $this->resource->date_finish ? (new DateTimeImmutable($this->resource->date_finish))->format('Y-m-d H:i:s') : null,
            'deadlines' => [
                'begin' => $this->resource->date_start ? (new DateTimeImmutable($this->resource->date_start))->format('Y-m-d') : null,
                'end' => $this->resource->date_end ? (new DateTimeImmutable($this->resource->date_end))->format('Y-m-d') : null,
            ],
            'creator' => new UserShortResource($this->resource->user),
            'contractors' => new UserShortCollection($this->resource->contractors),
            'type' => $this->resource->type,
            'status' => $this->resource->task_status,
            'created_at' => $this->resource->date_created ? (new DateTimeImmutable($this->resource->date_created))->format('Y-m-d H:i:s') : null,
        ];
    }
}
