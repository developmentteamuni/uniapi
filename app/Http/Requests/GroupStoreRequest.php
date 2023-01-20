<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GroupStoreRequest extends FormRequest
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
            'group_name' => 'required|string',
            'group_type' => 'required|string',
            'requirements' => 'required',
            'link' => 'required|url',
            'entrace' => 'required',
            'describe' => 'required|min:3',
            'description' => 'required|min:3',
            'image' => 'required',
            'image.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'attendance' => 'required',
            'fee' => 'required',
        ];
    }
}
