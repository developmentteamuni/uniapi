<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoomateRequest extends FormRequest
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
            'title' => 'required|string',
            'location' => 'required|string',
            'image' => 'required',
            'image.*' => 'image|mimes:jpeg,png,jpg,gif,svg',
            'description' => 'required|string',
            'clean' => 'required|string',
            'sleep_schdeule' => 'required|string',
            'noise_level' => 'required|string',
            'lots_of_time_in_room' => 'required|string',
            'company' => 'required|string',
            'social' => 'required|string',
            'study_location' => 'required|string',
            'requirements' => 'required|string',
            'campus' => 'required|string',
            'time_to_campus' => 'required',
            'sublease' => 'required|string',
        ];
    }
}
