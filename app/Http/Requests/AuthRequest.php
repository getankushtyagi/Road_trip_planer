<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules($data, $type)
    {
        $rules = [];

        switch ($type) {
            case 'login':
                $rules = [
                    'email' => 'required|string|email',
                    'password' => 'required|string',
                ];
                break;
            case 'register':
                $rules = [
                    'name' => 'required|string|max:255',
                    'email' => 'required|string|email|max:255|unique:users',
                    'password' => 'required|string|min:6',
                    'role' => 'required|in:1,2',
                ];
                break;
            case 'reset':
                $rules = [
                    'password' => 'required|string|min:6|confirmed'
                ];
                break;
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'email.required' => 'The email field is required.',
            'email.email' => 'Please enter a valid email address.',
            'password.required' => 'The password field is required.',
        ];
    }
}
