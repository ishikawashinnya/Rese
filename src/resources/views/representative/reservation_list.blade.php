@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/representative/reservation_list.css') }}" />
@endsection

@section('content')
<div class="list__content">
    <div class="content__header">       
        <div class="return__link">
            <a href="{{ route('mypage') }}" class="return__btn"><</a>
        </div>
        <div class="header__ttl">
            <h2>{{ $shop->name }}の予約状況 </h2>
        </div>     
    </div>

    <div class="content__main">
        <table class="reservation__table">
            <tr class="title__row">
                <th class="table__label">お客様名</th>
                <th class="table__label">予約日</th>
                <th class="table__label">予約時間</th>
                <th class="table__label">予約人数</th>
            </tr>

            @foreach($reservations as $reservation)
                <tr class="value__row">
                    <td class="value__list">{{ $reservation->user->name }}様</td>
                    <td class="value__list">{{ $reservation->reservation_date }}</td>
                    <td class="value__list">{{ $reservation->reservation_time }}</td>
                    <td class="value__list">{{ $reservation->reservation_num }}名</td>
                </tr>
            @endforeach
        </table>
    </div>

    <div class="pagenation">
        {{ $reservations->links() }}
    </div>
    

@endsection