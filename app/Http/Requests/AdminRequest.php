<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class AdminRequest extends FormRequest
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
    public function rules()
    {
        $method = $this->method();

        if ($this->method() !== 'DELETE') {
            return [
                'name'     => 'required|string|max:50|min:3',
                'email'    => ['required', 'email', 'max:50', 'min:10', Rule::unique('admins')->ignore($this->admin)],
                'password' => ['required', 'confirmed', 'string', Password::min(8),

                    // ->mixedCase()
                    // ->numbers()
                    // ->symbols()
                ],
            ];
        }

        return [];
    }
}
