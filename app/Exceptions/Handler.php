<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Validation\ValidationException;
use JetBrains\PhpStorm\ArrayShape;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var string[]
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var string[]
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * @param Throwable $e
     * @return array
     */
    #[ArrayShape(['ok' => "false", 'errors' => "array|string[]", 'description' => "mixed|string", 'code' => "mixed"])] protected function convertExceptionToArray(Throwable $e): array
    {
        //
        $code = $this->isHttpException($e)
            ? $e->getStatusCode()
            : $e->getCode();

        if (!$code) $code = Response::HTTP_INTERNAL_SERVER_ERROR;

        //
        $errors = array_filter([$e->getMessage()]);
        if (Response::HTTP_NOT_FOUND == $code) {
            $errors[0] = __('response.no_results');
        }

        if (config('app.debug')) {
            $errors = collect($e->getTrace())->map(function ($trace) {
                return Arr::except($trace, ['args']);
            })->all();
        }

        return [
            'ok' => false,
            'errors' => $errors,
            'description' => Response::$statusTexts[$code],
            'code' => $code
        ];
    }

    /**
     * @param Request $request
     * @param ValidationException $exception
     * @return JsonResponse
     */
    protected function invalidJson($request, ValidationException $exception): JsonResponse
    {
        return response()->json([
            'ok' => false,
            'errors' => $exception->errors(),
            'description' => $exception->getMessage(),
            'code' => $exception->status
        ], $exception->status);
    }

    /**
     * Convert an authentication exception into a response.
     *
     * @param Request $request
     * @param AuthenticationException $exception
     * @return Response
     */
    protected function unauthenticated($request, AuthenticationException $exception): Response
    {
        return $request->expectsJson()
            ? response()->json([
                'ok' => false,
                'errors' => [],
                'description' => $exception->getMessage(),
                'code' => 401
            ], 401)
            : redirect()->guest($exception->redirectTo() ?? route('login'));
    }
}
