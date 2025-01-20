@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/review_list.css') }}" />
@endsection

@section('content')
<div class="list__content">
    <div class="content__header">
        <div class="header__group">
            <div class="return__link">
                <a href="{{ url()->previous() }}" class="return__btn">＜</a>
            </div>
            <div class="header__ttl">
                <h2>レビュー一覧</h2>
            </div>
            @if(session('success'))
            <div class="alert__success">
                <p class="alert__message">{{ session('success')}}</p>
            </div>
            @endif
        </div>

        <div class="rating__average">
            <p class="star5__rating" data-rate="{{ number_format($averageRating, 1) }}"></p>
            <span class="number__rating">{{ number_format($averageRating, 1) }}</span>
        </div>
        <div class="review__num">
            <p>評価数: {{ $reviews->total() }}</p>
        </div>
    </div>

    <div class="content__main">
        @foreach($reviews as $review)
        <div class="review__container">
            <div class="container__group">
                <div class="user__name">
                    <p>{{ $review->user->name }}さん</p>
                </div>
                <div class="user__rating">
                    <p class="star5__rating" data-rate="{{ number_format($review->rating, 1) }}"></p>
                    <span class="number__rating">{{ number_format($review->rating, 1) }}</span>
                </div>
                @if (Auth::check() && Auth::user()->hasRole('admin'))
                <div class="delet__form">
                    <form action="{{ route('userreview.destroy', ['shop_id' => $shop->id, 'review_id' => $review->id]) }}" method="POST" class="delete__form">
                        @csrf
                        @method('DELETE')
                        <button class="delete__btn" type="submit" onclick="return confirm('口コミを削除しますか？')">口コミを削除</button>
                    </form>
                </div>
                @endif
            </div>

            <div class="user__comment">
                <p>{!! nl2br(e($review->comment)) !!}</p>
            </div>

            <div class="user__review-img">
                @if ($review->image_url)
                <label for="modalToggle" class="modal-open-button">
                    <img src="{{ asset('storage/review_images/' . $review->image_url) }}" alt="投稿画像" class="review__image">
                </label>
                <input type="checkbox" id="modalToggle" class="modal-checkbox">
                <div class="modal" id="modal">
                    <div class="modal-wrapper">
                        <label for="modalToggle" class="close">&times;</label>
                        <div class="modal-content">
                            <!-- ローカル -->
                            <img src="{{ asset('storage/review_images/' . $review->image_url) }}" alt="投稿画像" class="review__image">
                            <!-- s3 -->
                            <!-- <img src="{{ $review->image_url }}" alt="投稿画像" class="review__image"> -->
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
        @endforeach
    </div>

    <div class="pagenation">
        {{ $reviews->links('vendor/pagination/custom') }}
    </div>
</div>
@endsection