<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetOptionsRequest;
use App\Http\Resources\Users\UserCollection;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Routing\Controller as BaseController;
use Symfony\Component\HttpFoundation\Response;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @var int
     */
    protected int $per_page = 20;

    /**
     * @param GetOptionsRequest $request
     */
    public function __construct(GetOptionsRequest $request)
    {
        $this->setListingParams($request);
    }

    /**
     * Возвращаем результат запроса.
     *
     * Результаты ошибок настроены в Exception (app/Exception/Handle)
     * в функции convertExceptionToArray()
     *
     * @param ResourceCollection|JsonResource|array $data
     * @param string|null $description
     * @return JsonResponse
     */
    public function ok(
        ResourceCollection|JsonResource|array $data = [],
        string $description = null
    ): JsonResponse
    {
        $response = [
            'ok' => true,
            'data' => $data,
            'description' => $description,
            'code' => Response::HTTP_OK
        ];

        if ($data instanceof ResourceCollection) {
            $response = array_merge($response, [
                'data' => $data->resource->items(),
                'per_page' => $data->resource->perPage(),
                'page' => $data->resource->currentPage(),
                'total' => $data->resource->total(),
                'count' => $data->resource->count(),
            ]);
        }

        return response()->json($response);
    }

    /**
     * Установка значений выборки по списку данных
     * @param GetOptionsRequest $request
     */
    protected function setListingParams(GetOptionsRequest $request)
    {
        $data = $request->validated();

        if (key_exists('per_page', $data)) {
            $this->per_page = $data['per_page'];
        }
    }

}
