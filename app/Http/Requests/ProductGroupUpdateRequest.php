<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductGroupUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['string', 'max:255', 'required'],
            'product_id' => ['integer', 'required', 'exists:products,id'],
            'active' => ['nullable', 'boolean'],
        ];
    }
}
