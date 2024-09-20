@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/representative/representative_mypage.css') }}" />
@endsection

@section('content')
<div class="representative__content">
    <div class="representative__header">
        <h2 class="header__ttl">店舗代表者専用画面</h2>
    </div>

    <div class="representative__main">
        <div class="representative__link">
            <a href="{{ route('shop.create') }}" class="representative__link-item">
                <p>新規店舗情報作成</p>
            </a>
        </div>
        <div class="representative__link">
            @if ($shop)
                <a href="{{ route('shop.edit', ['id' => $representative->id]) }}" class="representative__link-item">
                    <p>店舗情報変更</p>
                </a>   
                <a href="{{ route('reservation.list') }}" class="representative__link-item">
                    <p>店舗予約状況確認</p>
                </a>
            @endif
        </div>
        <div class="representative__link">
            <a href="{{ route('notificatino.create') }}" class="representative__link-item">
                <p>メールフォーム</p>
            </a>
        </div>
    </div>
</div>
@endsection