<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReviewRequest extends FormRequest
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
            'rating' => 'required',
            'comment' => [
                'required',
                function ($attribute, $value, $fail) {
                    // 改行コードを統一してカウント
                    $cleanedValue = str_replace(["\r\n", "\r"], "\n", $value);
                    $length = mb_strlen($cleanedValue);

                    if ($length > 400) {
                        $fail('コメントは400文字以内で記入してください');
                    }
                },
            ],
            'image_url' => ['file', 'mimes:jpeg,png']
        ];
    }

    public function messages()
    {
        return [
            'rating.required' => '評価数を選択してください',
            'comment.required' => 'コメントを入力してください',
            'comment.max' => '400文字以内で記入してください',
            'image_url.file' => '有効なファイルをアップロードしてください',
            'image_url.mimes' => 'ファイル形式はjpeg,pngのみ有効です'
        ];
    }
}