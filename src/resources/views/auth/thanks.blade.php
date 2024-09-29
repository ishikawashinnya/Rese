@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/thanks.css') }}" />
@endsection

@section('content')
<div class="content__warp">
    <div class="card">
        <div class="content__message">
            <p class="message">ご登録ありがとうございます</p>
        </div>
        
        <div class="content__link">
            <a class="link__btn" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                ログインする
            </a>
        </div>
    </div>  
</div>
@endsection