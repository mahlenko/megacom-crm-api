<?php

namespace App\Console;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

trait ValidationData
{
    /**
     * @param array $data
     * @param FormRequest $request
     * @return array
     * @throws ValidationException
     */
    protected function validated(array $data, FormRequest $request)
    {
        try {
            return Validator::validate(
                $data,
                $request->rules(),
                $request->messages()
            );
        } catch (ValidationException $exception) {
            $this->validationShowError($exception);
            throw $exception;
        }
    }

    /**
     * @param ValidationException $exception
     */
    private function validationShowError(ValidationException $exception): void
    {
        foreach ($exception->errors() as $field => $errors) {
            foreach ($errors as $error) {
                $this->error($error);
            }
        }
    }
}
