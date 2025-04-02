<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'          => ['required', 'string', 'max:255'],
            'last_name'     => ['required', 'string', 'max:255'],
            'password'      => ['required', 'string', 'min:8'],
            'gender'        => ['required', 'in:male,female,other'],
            'date_of_brith' => ['required', 'before:today'],
            'about'         => ['nullable', 'string', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'          => 'نام الزامی است.',
            'last_name.required'     => 'نام خانوادگی الزامی است.',
            'password.min'           => 'رمز عبور باید حداقل ۸ کاراکتر باشد.',
            'gender.in'              => 'جنسیت باید یکی از گزینه‌های male, female یا other باشد.',
            'date_of_brith.before'   => 'تاریخ تولد باید قبل از امروز باشد.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'خطا در اعتبارسنجی!',
            'field'   => $validator->errors()->keys()[0],
            'error'   => $validator->errors()->first(),
        ], 422));
    }

}
