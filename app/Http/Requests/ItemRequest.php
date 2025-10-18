<?php

namespace App\Http\Requests;

use App\Enums\ItemCondition;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ItemRequest extends FormRequest
{
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
            'items'                   => 'required|array|min:1',
            'images'           => $this->_method == 'put' ? 'nullable' : 'required'.'|array|min:1',
            'items.*.name'            => 'required|string|max:30|min:3',
            'items.*.brand_id'        => 'required|numeric',
            'items.*.category_id'     => 'required|numeric',
            'items.*.description'     => 'required|string|max:400|min:5',
            'items.*.condition'       => ['required', Rule::enum(ItemCondition::class)],
            'items.*.price'           => 'required|numeric|max:10000|min:5',
            'items.*.trans_lang'      => 'required|string|min:2|max:3',
            'items.*.id'              => $this->_method == 'put' ? 'required' : 'nullable'.'|numeric',
        ];
    }
}
