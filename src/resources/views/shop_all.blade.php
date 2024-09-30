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
                    <option value="{{ $area->id }}" {{ request('area') == $area->id ? 'selected' : '' }}>{{ $area->name }}</option>
                @endforeach
            </select>
        </label>

        <label class="select__box-label">
            <select name="genre" class="search__form-select">
                <option value="">All genre</option>
                @foreach($genres as $genre)
                    <option value="{{ $genre->id }}" {{ request('genre') == $genre->id ? 'selected' : '' }}>{{ $genre->name }}</option>
                @endforeach 
            </select>
        </label>

        <div class="text__search">
            <div class="search__icon">
                <button type="submit" class="search__btn">検索</button>
            </div>
            <label class="text__search-label">
                <input type="text" name="word" class="text__search-input" placeholder="Search ..." value="{{ request('word') }}">
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
                @if (filter_var($shop->image_url, FILTER_VALIDATE_URL))
                    <img src="{{ $shop->image_url }}" alt="{{ $shop->name }}">
                @else
                    <img src="{{ asset('storage/shop_images/' . $shop->image_url) }}" alt="{{ $shop->name }}">
                @endif
            </div>

            <div class="card__item">
                <div class="shop__name">
                    <p>{{ $shop->name }}</p>
                </div>
                <div class="text__box">
                    <p class="area">#{{ $shop->area->name }}</p>
                    <p class="genre">#{{ $shop->genre->name }}</p>
                </div>
            </div>

            <div class="card__btn">
                <div class="detail__link">
                    <a href="{{ route('detail', $shop->id) }}" class="detail__link-btn">詳しくみる</a>
                </div>
                <div class="shop__favorit">
                    @if (Auth::check())
                        @if (in_array($shop->id, $favorites))
                            <form action="{{ route('favorites.destroy', $shop->id) }}" method="POST" class="shop__favorit-form">
                                <input type="hidden" name="shop_id" value="{{ $shop->id }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="favorit__form-btn">
                                    <img src="{{ asset('icon/heart_color.svg') }}" alt="お気に入り解除" class="heart-icon">
                                </button>
                            </form>
                        @else
                            <form action="{{ route('favorites.create') }}" method="POST" class="shop__favorit-form">
                                @csrf
                                <input type="hidden" name="shop_id" value="{{ $shop->id }}">
                                <button type="submit" class="favorit__form-btn">
                                    <img src="{{ asset('icon/heart.svg') }}" alt="お気に入り登録" class="heart-icon">
                                </button>
                            </form>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection