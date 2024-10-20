<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TodoRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'content' => ['required', 'string', 'max:20'],
            'name' => ['required', 'string', 'max:10'],
        ];
    }

    public function messages()
    {
        return [
            'content.required' => 'Todoを入力してください',
            'content.string' => 'Todoを文字列で入力してください',
            'content.max' => 'Todoを20文字以下で入力してください',
            'name.required' => 'カテゴリを入力してください',
            'name.string' => 'カテゴリを文字列で入力してください',
            'name.max' => 'カテゴリを10文字以下で入力してください',
        ];
    }
}
