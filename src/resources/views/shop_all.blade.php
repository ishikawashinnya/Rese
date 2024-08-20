@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/shop_all.css') }}" />
@endsection

@section('header')
<form action="" class="header__right">
    <div class="header__search">
        <label class="select__box-label">
            <select name="area" class="search__form-select">
                <option value="">All area</option>
                @foreach($areas as $area)
                    <option value="{{ $area->id }}">{{ $area->name }}</option>
                @endforeach
            </select>
        </label>

        <label class="select__box-label">
            <select name="genre" class="search__form-select">
                <option value="">All genre</option>
                @foreach($genres as $genre)
                    <option value="{{ $genre->id }}">{{ $genre->name }}</option>
                @endforeach 
            </select>
        </label>

        <div class="text__search">
            <div class="search__button">
                <button type="submit">検索</button>
            </div>
            <label class="text__search-label">
                <input type="text" name="word" class="text__search-input" placeholder="Search ..." value="">
            </label>
        </div>
        
        
    </div>
</form>
@endsection

@section('content')
<div class="wrapper">
    @foreach($shops as $shop)
        <div class="card">
            <div class="shop__img">
                <img src="{{ $shop -> image_url }}" alt="{{ $shop->name }}">
            </div>

            <div class="card__item">
                <div class="shop__name">
                    <p>{{ $shop -> name }}</p>
                </div>
                <div class="text__box">
                    <p class="area">#{{ $shop->area->name }}</p>
                    <p class="genre">#{{ $shop->genre->name }}</p>
                </div>
            </div>

            <div class="card__btn">
                <div class="detail__link">
                    <a href="/detail/:shop_id" class="detail__link-btn">詳しくみる</a>
                </div>
                <div class="favorit__form">
                    <button type="button" class="favorit__form-btn">
                        <img src="{{ asset('icon/heart.svg') }}" alt="お気に入り" class="heart-icon">
                    </button>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection