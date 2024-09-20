@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin/create_representative.css') }}" />
@endsection

@section('content')
<div class="create__content">
    <div class="create__card">
        <div class="card__header">
            <div class="card__header-ttl">
                <p>店舗代表者作成</p>
                @if(session('success'))
                    <div class="alert__success">
                        <p class="alert__message">{{ session('success')}}</p> 
                    </div>
                @endif
            </div>
        </div>
        
        <div class="create__content-form">
            <form class="form" action="{{ route('admin.store') }}" method="post">
                @csrf
                <div class="form__group-content">
                    <div class="form__input--text">
                        <input type="text" name="name" value="{{ old('name') }}" placeholder="代表者名" />
                    </div>
                    <div class="form__error">
                        @error('name')
                        {{ $message }}
                        @enderror
                    </div>
                </div>

                <div class="form__group-content">
                    <div class="form__input--text">
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="メールアドレス" />
                    </div>
                    <div class="form__error">
                        @error('email')
                        {{ $message }}
                        @enderror
                    </div>
                </div>

                <div class="form__group-content">
                    <div class="form__input--text">
                        <input type="password" name="password" placeholder="パスワード" />
                    </div>
                    <div class="form__error">
                        @error('password')
                        {{ $message }}
                        @enderror
                    </div>
                </div>

                <div class="card__footer">
                    <div class="footer__link">
                        <button class="link__button">
                            <a href="{{ route('mypage') }}" class="back__link">戻る</a>
                        </button>
                    </div>
                    <div class="form__button">
                        <button class="form__button-submit" type="submit">作成</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection