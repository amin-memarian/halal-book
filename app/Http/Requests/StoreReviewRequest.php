<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreReviewRequest extends FormRequest
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
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'comment' => ['nullable', 'string'],
            'rate' => ['required', 'integer', 'between:1,5'],
            'recommendation' => ['required', 'integer', 'in:-1,0,1'],
        ];
    }

    public function messages(): array
    {
        return [
            'product_id.required' => 'شناسه محصول الزامی است.',
            'product_id.integer' => 'شناسه محصول باید عدد باشد.',
            'product_id.exists' => 'محصول انتخاب‌ شده معتبر نیست.',

            'comment.string' => 'نظر باید یک متن باشد.',

            'rate.required' => 'امتیاز دادن الزامی است.',
            'rate.integer' => 'امتیاز باید عدد باشد.',
            'rate.between' => 'امتیاز باید بین 1 تا 5 باشد.',

            'recommendation.required' => 'مقدار توصیه ضروری است.',
            'recommendation.integer' => 'مقدار توصیه باید عدد باشد.',
            'recommendation.in' => 'مقدار توصیه فقط می‌تواند -1، 0 یا 1 باشد.',
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
