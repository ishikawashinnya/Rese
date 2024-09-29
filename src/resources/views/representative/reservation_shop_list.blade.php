@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/representative/shop_list.css') }}" />
@endsection

@section('content')
<div class="list__content">
    <div class="content__header">       
        <div class="return__link">
            <a href="{{ route('mypage') }}" class="back__button">戻る</a>
        </div>
        <div class="header__ttl">
            <h2>{{ $user->name }}様の店舗一覧</h2>
        </div>     
    </div>

    <div class="content__main">
        <div class="list__ttl">
            <h3>予約状況を確認する店舗を選択してください</h3>
        </div>
        <div class="shop__list-wrapper">
            <ul class="shop__list">
                @foreach($representatives as $representative)
                    <li class="shop__list-item">
                        <a href="{{ route('reservation.list', ['shopId' => $representative->shop->id]) }}" class="shop__edit-link">{{ $representative->shop->name }}</a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <div class="pagenation">
        {{ $representatives->links('vendor/pagination/custom') }}
    </div>
</div>
@endsection