<?php

namespace App\Http\Requests\Task;

use App\Services\ApiResponseService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades\Auth;

class StoreTaskRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title'       => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'status'      => 'required|in:pending,completed',
            'due_date'    => 'required|date_format:Y-m-d\TH:i|after_or_equal:now',
        ];
    }

    /**
     * Get custom attribute names for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'title'       => 'task title',
            'description' => 'task description',
            'status'      => 'task status',
            'due_date'    => 'due date',
        ];
    }

    /**
     * Get custom messages for validation errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'required'       => 'The :attribute is required and cannot be empty.',
            'string'         => 'The :attribute must be a valid string.',
            'max'            => 'The :attribute cannot exceed :max characters.',
            'status.in'      => 'The :attribute must be either "pending" or "completed".',
            'date'           => 'The :attribute must be a valid date.',
            'after_or_equal' => 'The :attribute must be today or a future date.',
        ];
    }

    /**
     *  method handles failure of Validation and return message
     * @param \Illuminate\Contracts\Validation\Validator $Validator
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     * @return never
     */
    protected function failedValidation(Validator $Validator)
    {
        $errors = $Validator->errors()->all();
        throw new HttpResponseException(ApiResponseService::errorResponse('validation_error', 422, $errors));
    }
}
