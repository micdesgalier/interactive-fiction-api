<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreChapterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'story_id' => 'required|exists:stories,id',
            'title'    => 'required|string|max:255',
            'content'  => 'required|string',
            'order'    => 'required|integer|min:0',
        ];
    }
}