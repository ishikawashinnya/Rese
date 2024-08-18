@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/shop_detail.css') }}" />
@endsection

@section('content')
<div class="shop_detail-content">
    <div class="content__left">
        <div class="content__left-ttl">
            <a href="" class="return__btn">戻る</a>
            <p class="shop__name">仙人</p>
        </div>

        <div class="content__img">
            <img src="https://coachtech-matter.s3-ap-northeast-1.amazonaws.com/image/sushi.jpg" alt="写真">
        </div>
        
        <div class="shop__information">
            <p>#エリア</p>
            <p>#ジャンル</p>
        </div>

        <div class="shop__description">
            <p>料理長厳選の食材から作る寿司を用いたコースをぜひお楽しみください。食材・味・価格、お客様の満足度を徹底的に追及したお店です。特別な日のお食事、ビジネス接待まで気軽に使用することができます。</p>
        </div>
    </div>

    <div class="content__right">
        <div class="reservation__form">
            <div class="form__ttl">
                <p>予約</p>
            </div>
            
            <form action="" class="reservation__form-item">
                <div class="reservation__date">
                    <input type="date" name="date" value="2021-04-01">
                </div>

                <div class="reservation__time">
                    <select name="time" id="time">
                        <option value="17:00">17:00</option>
                        <option value="18:00">18:00</option>
                        <option value="19:00">19:00</option>
                        <option value="20:00">20:00</option>
                        <option value="21:00">21:00</option>
                        <option value="22:00">22:00</option>
                    </select>
                </div>

                <div class="reservation__num">
                    <select name="number" id="number">
                        <option value="1人">1人</option>
                        <option value="2人">2人</option>
                        <option value="3人">3人</option>
                        <option value="4人">4人</option>
                        <option value="5人">5人</option>
                    </select>
                </div>

                <div class="reservation__confirmation">
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

                <div class="reservation__form-btn">
                    <button class="reservation__btn" type="submit">予約する</button>
                </div>  
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('date').addEventListener('change', function() {
        document.getElementById('selected_date').textContent = this.value;
    });

    document.getElementById('time').addEventListener('change', function() {
        document.getElementById('selected_time').textContent = this.value;
    });

    document.getElementById('people').addEventListener('change', function() {
        document.getElementById('selected_people').textContent = this.value;
    });
</script>
@endsection