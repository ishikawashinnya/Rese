<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateShopRequest extends FormRequest
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
            'name' => ['required', 'string'],
            'area_id' => 'required',
            'genre_id' => 'required',
            'description' => ['required', 'string', 'max:150'],
            'address' => ['required', 'string'],
            'image_url' => ['file', 'mimes:jpeg,png']
        ];
    }
    
    public function messages()
    {
        return [
            'name.required' => '店名を入力してください',
            'name.string' => '店名を文字列で入力してください',
            'area_id.required' => 'エリアを選択してください',
            'genre_id.required' => 'ジャンルを選択してください',
            'description.required' => '店舗説明文を入力してください',
            'description.string' => '店舗説明文を文字列で入力してください',
            'description.max' => '店舗説明文を150文字以下で入力してください',
            'address.required' => '住所を入力してください',
            'address.string' => '住所を文字列で入力してください',
            'image_url.file' => '有効なファイルをアップロードしてください',
            'image_url.mimes' => 'ファイル形式はjpeg,pngのみ有効です'
        ];
    }
}
