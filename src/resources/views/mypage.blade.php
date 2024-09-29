@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}" />
@endsection

@section('content')
<div class="mypage__content">
    <!-- ログイン中のユーザー名表示 -->
    <div class="mypage__header">
        @if(Auth::check())
            <p class="mypage__header-ttl">{{ \Auth::user()->name }}さん</p>
        @endif
    </div>

    <div class="mypage__main">
        <div class="mypage__main-left">
            <div class="main-left__ttl">
                <p class="main__ttl">予約状況</p>
                <div class="payment">
                    <form action="{{ asset('charge') }}" method="POST" class="payment__form">
                    @csrf
                        <script src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                            data-key="{{ config('services.stripe.key') }}"
                            data-amount="1000"
                            data-name="stripe決済"
                            data-label="決済をする"
                            data-description="これはデモ決済です"
                            data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
                            data-locale="auto"
                            data-currency="JPY">
                        </script>
                    </form>
                </div>  
            </div>

            @foreach($reservations as $reservation)
                <div class="reservation__confirmation">
                    <div class="confirmation__header">
                        <div class="confirmation__header-left">
                            <div class="header__img">
                                <img src="{{ asset('icon/clock.svg') }}" alt="時計">
                            </div>
                            <div class="header-ttl">
                                <p>予約{{ $loop->iteration }}</p>
                            </div>
                        </div>

                        <div class="confirmation__header-right">
                            <form action="{{ route('reservation.edit', ['id' => $reservation->id]) }}" method='get' class="reservation__form">
                                @csrf
                                <div class="header__right-img">
                                    <button type="submit" class="reservation__form-btn">
                                        <img src="{{ asset('icon/pencil.svg') }}" alt="予約変更">
                                    </button>
                                </div>
                            </form>

                            <form action="{{ route('reservation.delete', ['id' => $reservation->id]) }}" method='post' class="reservation__form">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="id" value="{{ $reservation->id }}">
                                <div class="header__right-img">
                                    <button type="submit" class="reservation__form-btn">
                                        <img src="{{ asset('icon/batsu.svg') }}" alt="予約取消">
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                    <table class="reservation__confirmation-table">
                        <tr>
                            <th class="reservation__confirmation-ttl">Shop</th>
                            <td class="selected__shop">{{ $reservation->shop->name }}</td>
                        </tr>
                        <tr>
                            <th class="reservation__confirmation-ttl">Date</th>
                            <td class="selected__date">{{ $reservation->reservation_date }}</td>
                        </tr>
                        <tr>
                            <th class="reservation__confirmation-ttl">Time</th>
                            <td class="selected__time">{{ $reservation->reservation_time }}</td>
                        </tr>
                        <tr>
                            <th class="reservation__confirmation-ttl">Number</th>
                            <td class="selected__num">{{ $reservation->reservation_num }}人</td>
                        </tr>
                    </table>
                </div>
            @endforeach
        </div>

        <div class="mypage__main-right">
            <div class="main-right__ttl">
                <p class="main__ttl">お気に入り店舗</p>
            </div>

            <div class="favolit__list">
                <div class="wrapper">
                    @foreach($favorites as $favorite)
                        <div class="card">
                            <div class="shop__img">
                                <img src="{{ filter_var($favorite->shop->image_url, FILTER_VALIDATE_URL) ? $favorite->shop->image_url : asset('storage/shop_images/' . $favorite->shop->image_url) }}" alt="{{ $favorite->shop->name }}">
                            </div>

                            <div class="card__item">
                                <div class="shop__name">
                                    <p>{{ $favorite->shop->name  }}</p>
                                </div>
                                <div class="text__box">
                                    <p class="area">#{{ $favorite->shop->area->name }}</p>
                                    <p class="genre">#{{ $favorite->shop->genre->name }}</p>
                                </div>
                            </div>
        
                            <div class="card__btn">
                                <div class="detail__link">
                                    <a href="{{ route('detail', ['shop_id' => $favorite->shop->id, 'from_mypage' => 1]) }}" class="detail__link-btn">詳しく見る</a>
                                </div>
                                <div class="shop__favorit">
                                    <form action="{{ route('favorites.destroy', $favorite->shop->id) }}" method="POST" class="shop__favorit-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="favorit__form-btn">
                                            <img src="{{ asset('icon/heart_color.svg') }}" alt="お気に入り解除" class="heart-icon">
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection