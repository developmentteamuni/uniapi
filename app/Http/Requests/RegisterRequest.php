<?php

namespace App\Http\Requests;

use App\Rules\EmailRule;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            // 'email' => [
            //     'required',
            //     new EmailRule(),
            //     'unique:users,email',
            // ],
            'email' => 'required|email|unique:users',
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'university' => 'required',
            'major' => 'required',
            'password' => 'required|min:6',
            
        ];
    }
}
