<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class CategoryRequest extends FormRequest
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
            'categories'               => 'required|array|min:1',
            'image'                    => [
                'required_without:categories.0.id',
                File::types(['gif', 'png', 'jpg', 'jepg'])
                    ->max('10mb'),
            ],
            'categories.*.name'        => 'required|string|max:15|min:2',
            'categories.*.trans_lang'  => 'required_without:categories.0.id|string|min:2',
            'categories.*.id'          => 'required_without:categories.0.trans_lang|string|min:2',
        ];
    }
}
