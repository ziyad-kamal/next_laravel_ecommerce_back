<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BrandRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $method = $this->method();

        return [
            'brands'               => 'required|array|min:1',
            'brands.*.name'        => 'required|string|max:15|min:2',
            'brands.*.trans_lang'  => 'required|string|min:2',
            'brands.*.id'          => $method == 'put' ? 'required' : ''.'|string|min:2',
        ];
    }

    public function messages()
    {
        return [
            'required' => 'this field is required',
            'min'      => 'you should write at least 3 characters',
        ];
    }
}
