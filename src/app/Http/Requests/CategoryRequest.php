<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
        $rules =  [
            'name' => ['required', 'string', 'max:10']
        ];

        // カテゴリ作成時のみ'unique'ルールを適用
        if ($this->route()->getName() === 'categories') {
            $rules['name'][] = 'unique:categories,name';
        }

        return $rules;
    }

    public function messages() {
        return [
            'name.required' => 'カテゴリを入力してください',
            'name.string' => 'カテゴリを文字列で入力してください',
            'name.max' => 'カテゴリを10文字以下で入力してください',
            'name.unique' => 'カテゴリがすでに存在しています',
        ];
    }
}
