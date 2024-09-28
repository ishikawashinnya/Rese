@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/representative/reservation_list.css') }}" />
@endsection

@section('content')
<div class="list__content">
    <div class="content__header">       
        <div class="return__link">
            <a href="{{ route('reservationshop.list') }}" class="back__button">戻る</a>
        </div>
        <div class="header__ttl">
            <h2>{{ $shop->name }}の予約状況 </h2>
        </div>     
    </div>

    <div class="date">
        <form action="{{ route('reservation.list', ['shopId' => $shop->id]) }}" method="get" class="date__form">
            @csrf
            <button class="before" name="date" value="{{ $yesterday->format('Y-m-d')}}"> &lt;</button>
        </form>
        <p class="date__today">
            {{ $today->format('Y-m-d') }}
        </p>
        <form action="{{ route('reservation.list', ['shopId' => $shop->id]) }}" method="get" class="date__form">
            @csrf
            <button class="after" name="date" type="date" value="{{ $tomorrow->format('Y-m-d') }}"> &gt;</button>
        </form>
    </div>

    <div class="content__main">
        <table class="reservation__table">
            <tr class="title__row">
                <th class="table__label">お客様名</th>
                <th class="table__label">予約日</th>
                <th class="table__label">予約時間</th>
                <th class="table__label">予約人数</th>
                <th class="table__label">予約状況</th>
            </tr>

            @foreach($reservations as $reservation)
                <tr class="value__row">
                    <td class="value__list">{{ $reservation->user->name }}様</td>
                    <td class="value__list">{{ $reservation->reservation_date }}</td>
                    <td class="value__list">{{ $reservation->reservation_time }}</td>
                    <td class="value__list">{{ $reservation->reservation_num }}名</td>
                    <td class="value__list">{{ $reservation->status }}</td>
                </tr>
            @endforeach
        </table>
    </div>

    <div class="pagenation">
        {{ $reservations->links('vendor/pagination/custom') }}
    </div>
    

@endsection