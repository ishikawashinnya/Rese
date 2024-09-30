@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/reservation_edit.css') }}" />
@endsection

@section('content')
<div class="reservation_edit-content">
    <div class="content__left">
        <div class="content__left-ttl">
            <div class="return__link">
                <a href="{{ url()->previous() }}" class="return__btn"><</a>
            </div>
            <p class="shop__name">{{ $shop->name }}</p>
        </div>

        <div class="content__img">
            <img src="{{ filter_var($shop->image_url, FILTER_VALIDATE_URL) ? $shop->image_url : asset('storage/shop_images/' . $shop->image_url) }}" alt="{{ $shop->name }}">
        </div>
        
        <div class="shop__information">
            <p>#{{ $shop->area->name }}</p>
            <p>#{{ $shop->genre->name }}</p>
        </div>

        <div class="shop__description">
            <p>{{ $shop->description }}</p>
        </div>
    </div>

    <div class="content__right">
        <div class="reservation__form">
            <div class="form__ttl">
                <p>予約変更</p>
            </div>
            
            <form action="{{ route('reservation.update', ['id' => $reservation->id]) }}" method="POST" class="reservation__form-item">
                @csrf
                <input type="hidden" name="shop_id" value="{{ $shop->id }}">

                <div class="reservation__date">
                    <input type="date" name="reservation_date" id="reservation_date" value="{{ old('reservation_date', $reservation->reservation_date) }}" class="form__item" min="{{ $minDate }}">
                </div>

                <div class="reservation__time">
                    <select name="reservation_time" id="reservation_time" class="form__item">
                        <option value="" disabled {{ old('reservation_time', $reservation->reservation_time) ? '' : 'selected' }}>-- 時間を選択 --</option>
                        <option value="17:00" {{ old('reservation_time', $reservation->reservation_time) == '17:00' ? 'selected' : '' }}>17:00</option>
                        <option value="18:00" {{ old('reservation_time', $reservation->reservation_time) == '18:00' ? 'selected' : '' }}>18:00</option>
                        <option value="19:00" {{ old('reservation_time', $reservation->reservation_time) == '19:00' ? 'selected' : '' }}>19:00</option>
                        <option value="20:00" {{ old('reservation_time', $reservation->reservation_time) == '20:00' ? 'selected' : '' }}>20:00</option>
                        <option value="21:00" {{ old('reservation_time', $reservation->reservation_time) == '21:00' ? 'selected' : '' }}>21:00</option>
                        <option value="22:00" {{ old('reservation_time', $reservation->reservation_time) == '22:00' ? 'selected' : '' }}>22:00</option>
                    </select>
                </div>

                <div class="reservation__num">
                    <select name="reservation_num" id="reservation_num" class="form__item" >
                        <option value="" disabled {{ old('reservation_num', $reservation->reservation_num) ? '' : 'selected' }}>-- 人数を選択 --</option>
                        <option value="1" {{ old('reservation_num', $reservation->reservation_num) == '1' ? 'selected' : '' }}>1人</option>
                        <option value="2" {{ old('reservation_num', $reservation->reservation_num) == '2' ? 'selected' : '' }}>2人</option>
                        <option value="3" {{ old('reservation_num', $reservation->reservation_num) == '3' ? 'selected' : '' }}>3人</option>
                        <option value="4" {{ old('reservation_num', $reservation->reservation_num) == '4' ? 'selected' : '' }}>4人</option>
                        <option value="5" {{ old('reservation_num', $reservation->reservation_num) == '5' ? 'selected' : '' }}>5人</option>
                    </select>
                </div>

                <div class="reservation__confirmation">
                    <table class="reservation__confirmation-table">
                        <tr>
                            <th class="reservation__confirmation-ttl">Shop</th>
                            <td class="selected__shop">{{ $shop->name }}</td>
                        </tr>
                        <tr>
                            <th class="reservation__confirmation-ttl">Date</th>
                            <td class="selected__date"></td>
                        </tr>
                        <tr>
                            <th class="reservation__confirmation-ttl">Time</th>
                            <td class="selected__time"></td>
                        </tr>
                        <tr>
                            <th class="reservation__confirmation-ttl">Number</th>
                            <td class="selected__num"></td>
                        </tr>
                    </table>
                </div>

                <div class="reservation__form-btn">
                    <button class="reservation__btn" type="submit">変更する</button>
                </div>  
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const reservationDate = document.getElementById('reservation_date');
        const reservationTime = document.getElementById('reservation_time');
        const reservationNum = document.getElementById('reservation_num');

        const selectedDate = document.querySelector('.selected__date');
        const selectedTime = document.querySelector('.selected__time');
        const selectedNum = document.querySelector('.selected__num');

        // 初期値をセット
        selectedDate.textContent = reservationDate.value;
        selectedTime.textContent = reservationTime.value;
        selectedNum.textContent = reservationNum.value + '人';

        reservationDate.addEventListener('change', function() {
            selectedDate.textContent = this.value;
        });

        reservationTime.addEventListener('change', function() {
            selectedTime.textContent = this.value;
        });

        reservationNum.addEventListener('change', function() {
            selectedNum.textContent = this.value + '人';
        });
    });
</script>
@endsection