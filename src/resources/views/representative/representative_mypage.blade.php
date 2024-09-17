@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin/representative_index.css') }}" />
@endsection

@section('content')
<div class="representative__content">
    <div class="representative__header">
        <h2 class="header__ttl">店舗代表者専用画面</h2>
    </div>

    <div class="representative__main">
        <div class="representative__link">
            <ul>
                <li>
                    <a href="{{ route('shop.create') }}" class="representative__link-item"><h3>新規店舗情報作成</h3></a>
                </li>

                @if ($shop)
                    <li>
                        <a href="{{ route('shop.edit', ['id' => $representative->id]) }}" class="representative__link-item"><h3>店舗情報変更</h3></a>
                    </li>
                    <li>
                        <a href="{{ route('reservation.list') }}" class="representative__link-item"><h3>店舗予約状況確認</h3></a>
                    </li>
                @endif
                
                <li>
                    <a href="#" class="representative__link-item"><h3>メール作成</h3></a>
                </li>
            </ul>  
        </div>
    </div>
</div>
@endsection