@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/done.css') }}" />
@endsection

@section('content')
<div class="done__content">
    <div class="card">
        <div class="done__message">
            <p class="message">ご予約ありがとうございます</p>
        </div>
        
        <div class="done__link">
            <a href="/" class="link__btn">戻る</a>
        </div>
    </div>
    
</div>
@endsection