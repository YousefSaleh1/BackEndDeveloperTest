<?php

namespace App\Http\Requests\Auth;

use app\Traits\ApiResponseTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class LoginRequest extends FormRequest
{
    use ApiResponseTrait;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email'    => 'required|string|email',
            'password' => 'required|string',
        ];
    }

        /**
     * Get custom attribute names for validator errors.
     *
     * @return array
     */
    public function attributes(): array
    {
        return [
            'email'    => 'email address',
            'password' => 'password',
        ];
    }

    /**
     * Get custom messages for validation errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'required' => 'The :attribute is required and cannot be empty.',
            'string'   => 'The :attribute must be a valid string.',
            'email'    => 'The :attribute must be a valid email address.',
            'max'      => 'The :attribute cannot exceed :max characters.',
            'min'      => 'The :attribute must be at least :min characters.',
        ];
    }

    /**
     * Handles failure of Validation and returns a message.
     *
     * @param \Illuminate\Contracts\Validation\Validator $validator
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     * @return never
     */
    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors()->all();
        throw new HttpResponseException($this->errorResponse('validation_error', 422, $errors));
    }
}
