<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreChoiceRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'chapter_id'       => 'required|exists:chapters,id',
            'text'             => 'required|string|max:255',
            'target_chapter_id'=> 'nullable|exists:chapters,id',
            'impact'           => 'required|integer',
        ];
    }
}