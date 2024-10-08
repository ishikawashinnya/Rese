<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReservationRequest extends FormRequest
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
            'reservation_date' => 'required',
            'reservation_time' => 'required',
            'reservation_num' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'reservation_date.required' => '日付を選択してください',
            'reservation_time.required' => '時間を選択してください',
            'reservation_num.required' => '人数を選択してください',
        ];
    }
}
