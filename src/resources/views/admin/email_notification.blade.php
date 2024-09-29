@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin/email_notification.css') }}">
@endsection

@section('content')
<div class="notification__content">
    <div class="content__header">
        <div class="content__header-ttl">
            <h2>お知らせメール作成</h2>
        </div>  
        @if(session('success'))
            <div class="alert__success">
                {{ session('success') }}
            </div>
        @endif
    </div>
    
    <div class="content__main">
        <div class="content__wrap">
            <form action="{{ route('notification.send') }}" method="post" class="mail__form">
                @csrf
                <div class="mail__form-groupe">
                    <label for="destination" class="form__label">宛先</label>
                    <div class="mail__destination">
                        <select name="destination" id="destination"  class="destination__select">
                            <option value="" disabled selected>-- 宛先を選択 --</option>
                            <option value="user">ユーザー</option>
                            <option value="shop representative">店舗代表者</option>
                            <option value="admin">管理者</option>
                        </select>
                    </div>
                </div>

                <div class="mail__form-groupe">
                    <label for="textarea" class="form__label">本文</label>
                    <div class="mail__textarea">
                        <textarea id="textarea" class="textarea" name="message" rows="15" required></textarea>
                    </div>
                </div>

                <div class="form__button">
                    <div class="form__link">
                        <a href="{{ route('mypage') }}" class="back__button">戻る</a>
                    </div>
                    <button type="submit" class="form__button-btn">メール送信</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection