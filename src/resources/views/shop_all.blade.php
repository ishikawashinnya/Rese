@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/shop_all.css') }}" />
@endsection

@section('header')

@endsection

@section('content')
<div class="wrapper">
    <div class="card">
        <div class="shop__img">
            <img src="https://coachtech-matter.s3-ap-northeast-1.amazonaws.com/image/sushi.jpg" alt="画像がありません">
        </div>

        <div class="card__item">
            <div class="shop__name">
                <h2>店名</h2>
            </div>
            <div class="text__box">
                <p class="area">#エリア</p>
                <p class="genre">#ジャンル</p>
            </div>
        </div>

        <div class="card__btn">
            <div class="detail__link">
                <a href="" class="detail__link-btn">詳しく見る</a>
            </div>
            <div class="favorit__form">
                <button type="submit" class="favorit__form-btn">
                    <img src="{{ asset('icon/heart.svg') }}" alt="お気に入り" class="heart-icon">
                </button>
            </div>
        </div>
    </div>
    
    
</div>
@endsection

