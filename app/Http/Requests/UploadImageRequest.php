<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadImageRequest extends FormRequest
{
    /**
     * 認証しているユーザーが使えるかどうか
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
            'image' => 'image|mimes:jpg,jpeg,png|max:2048'
        ];
    }

    public function messages()
    {
        return [
            'image' => '指定されたファイルが画像ではありません',
            'mimes' => '指定された拡張子が（jpg/jpeg/png)ではありません',
            'max' => 'ファイルサイズは2MB以内にしてください',
        ];
    }
}
