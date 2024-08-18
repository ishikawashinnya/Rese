@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}" />
@endsection

@section('content')
<div class="mypage__content">
    <div class="mypage__header">
        <!-- ログイン中のユーザー名表示 -->
        <p class="mypage__header-ttl">testさん</p>  
    </div>

    <div class="mypage__main">
        <div class="mypage__main-left">
            <div class="main-left__ttl">
                <p class="mypage__main-ttl">予約状況</p>
            </div>

            <div class="reservation__confirmation">
                <div class="confirmation__header">
                    <div class="confirmation__header-left">
                        <div class="header__img">
                            <img src="{{ asset('icon/clock.svg') }}" alt="時計">
                        </div>
                        <div class="header-ttl">
                            <p>予約1</p>
                        </div>
                    </div>

                    <div class="header__right">
                        <div class="header__right-img">
                            <button type="submit" class="reservation__form-btn">
                                <img src="{{ asset('icon/batsu.svg') }}" alt="取り消し">
                            </button>
                            
                        </div>
                    </div>
                   
                </div>
                <table class="reservation__confirmation-table">
                    <tr>
                        <th class="reservation__confirmation-ttl">Shop</th>
                        <td class="selected__shop">店名</td>
                    </tr>
                    <tr>
                        <th class="reservation__confirmation-ttl">Date</th>
                        <td class="selected__date">日付</td>
                    </tr>
                    <tr>
                        <th class="reservation__confirmation-ttl">Time</th>
                        <td class="selected__time">時間</td>
                    </tr>
                    <tr>
                        <th class="reservation__confirmation-ttl">Number</th>
                        <td class="selected__num">人数</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="mypage__main-right">
            <div class="main-left__ttl">
                <p class="mypage__main-ttl">お気に入り店舗</p>
            </div>

            <div class="favolit__list">
                <div class="wrapper">
                    <div class="card">
                        <div class="shop__img">
                            <img src="https://coachtech-matter.s3-ap-northeast-1.amazonaws.com/image/sushi.jpg" alt="画像がありません">
                        </div>

                        <div class="card__item">
                            <div class="shop__name">
                                <p>店名</p>
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
            </div>
        </div>
    </div>
</div>
@endsection