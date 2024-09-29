@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}" />
@endsection

@section('content')
<div class="auth__content">
    <div class="auth__card">
        <div class="card__header">
            <p class="card__header-ttl">Login</p>
        </div>
        
        <div class="auth__content-form">
            <form class="form" action="/login" method="post">
                @csrf
                <div class="form__group-content">
                    <div class="form__input-text">
                        <div class="icon__img">
                            <img src="{{ asset('icon/mail.svg') }}" alt="" class="icon">
                        </div>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="Email" />
                    </div>
                    <div class="form__error">
                        @error('email')
                        {{ $message }}
                        @enderror
                    </div>
                </div>

                <div class="form__group-content">
                    <div class="form__input-text">
                        <div class="icon__img">
                            <img src="{{ asset('icon/key.svg') }}" alt="" class="icon">
                        </div>
                        <input type="password" name="password" placeholder="Password" />
                    </div>
                    <div class="form__error">
                        @error('password')
                        {{ $message }}
                        @enderror
                    </div>
                </div>

                <div class="form__button">
                    <button class="form__button-submit" type="submit">ログイン</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection