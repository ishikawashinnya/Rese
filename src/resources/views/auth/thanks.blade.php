@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/thanks.css') }}" />
@endsection

@section('content')
<div class="thanks__content">
    <div class="card">
        <div class="thanks__message">
            <p class="message">ご登録ありがとうございます</p>
        </div>
        
        <div class="thanks__link">
            <a class="link__btn" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                ログインする
            </a>
        </div>
    </div>
    
</div>
@endsection