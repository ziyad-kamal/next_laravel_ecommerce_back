<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserRequest extends FormRequest
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
        if ($this->routeIs('admin.*')) {
            $email_rule = Rule::unique('admins')->ignore($this->admin);
        } else {
            $email_rule = Rule::unique('users')->ignore($this->user);
        }

        return [
            'name'     => 'required|string|max:50|min:3',
            'email'    => ['required', 'email', 'max:50', 'min:10', $email_rule],
            'password' => ['required', 'confirmed', 'string', Password::min(8),

                // ->mixedCase()
                // ->numbers()
                // ->symbols()
            ],
        ];
    }

    protected function passedValidation(): void
    {
        $this->merge(['password' => Hash::make($this->password)]);
    }
}
