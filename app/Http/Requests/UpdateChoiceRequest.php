<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateChoiceRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'text'             => 'sometimes|required|string|max:255',
            'target_chapter_id'=> 'sometimes|nullable|exists:chapters,id',
            'impact'           => 'sometimes|required|integer',
        ];
    }
}