<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStoryRequest extends FormRequest
{
    public function rules()
    {
        return [
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
        ];
    }

    public function authorize() { return true; }
}