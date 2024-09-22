@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/thanks.css') }}" />
@endsection

@section('content')
<div class="content__warp">
    <div class="card">
        <div class="content__message">
            <p class="message">ご予約ありがとうございます</p>
        </div>
        
        <div class="content__link">
            <a href="{{ route('mypage') }}" class="link__btn">戻る</a>
        </div>
    </div>
    
</div>
@endsection