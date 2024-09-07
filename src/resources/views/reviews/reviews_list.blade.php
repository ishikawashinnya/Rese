@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/review_list.css') }}" />
@endsection

@section('content')
<div class="list__content">
    <div class="content__header">
        <div class="header__ttl">
            <h2>レビュー一覧</h2>
        </div>
        <div class="rating__average">
            <p class="result__rating-average">平均評価:
                <span class="star5__rating" data-rate="3.8"></span>
                <span class="number__rating">3.8</span>
            </p>
        </div>
        <div class="review__num">
            <p>評価数</p>
        </div>
    </div>

    <div class="content__main">
        <div class="user__name"></div>
        <div class="user__rating"></div>
        <div class="user__comment"></div>
        <div class="user__review-img">画像をクリックすると、大きい画像がモーダルで表示</div>
    </div>
    <div class="pagenation">
        10件ごとにページネーション
        ページネーションは次へと前へだけでいい
    </div>

@endsection