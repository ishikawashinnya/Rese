@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/review.css') }}" />
@endsection

@section('content')
<div class="review__content">
    <div class="content__header">
        <div class="left__header">
            <div class="left__header-ttl">
                <div class="return__link">
                    <a href="{{ route('detail', $shop->id) }}" class="return__btn"><</a>
                </div>
                <p class="shop__name">{{ $shop->name }}</p>
            </div>
            
            <form action="{{ route('reviews.destroy', ['shop_id' => $shop->id]) }}" method="POST" class="delete__form">
                @csrf
                @method('DELETE')
                <button class="delete__btn" type="submit">削除する</button>
            </form>
        </div>
    </div>

    <div class="content__main">
        <div class="content__left">
            <div class="content__img">
                @if (filter_var($shop->image_url, FILTER_VALIDATE_URL))
                    <img src="{{ $shop->image_url }}" alt="{{ $shop->name }}">
                @else
                    <img src="{{ asset('storage/shop_images/' . $shop->image_url) }}" alt="{{ $shop->name }}">
                @endif
            </div>
        
            <div class="shop__information">
                <p>#{{ $shop->area->name }}</p>
                <p>#{{ $shop->genre->name }}</p>
            </div>

            <div class="shop__description">
                <p>{{ $shop->description }}</p>
            </div>
        </div>

        <div class="content__right">
            <form action="{{ route('reviews.update', ['shop_id' => $shop->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="shop_id" value="{{ $review->shop_id }}">

                <label class="rating__form-ttl">体験を評価してください</label>
                <div class="rating__radio-form">
                    <div class="rating__radio">
                        <input  id="rating1" type="radio" name="rating" value="1" {{ old('rating', $review->rating) == 1 ? 'checked' : ''}}>
                        <label for="rating1">1.非常に不満</label>
                    </div>
                    <div class="rating__radio">
                        <input id="rating2" type="radio" name="rating" value="2" {{ old('rating', $review->rating) == 2 ? 'checked' : ''}}>
                        <label for="rating2">2.不満</label>
                    </div>
                    <div class="rating__radio">
                        <input id="rating3" type="radio" name="rating" value="3" {{ old('rating', $review->rating) == 3 ? 'checked' : ''}}>
                        <label for="rating3">3.普通</label>
                    </div>
                    <div class="rating__radio">
                        <input id="rating4" type="radio" name="rating" value="4" {{ old('rating', $review->rating) == 4 ? 'checked' : ''}}>
                        <label for="rating4">4.満足</label>
                    </div>
                    <div class="rating__radio">
                        <input id="rating5" type="radio" name="rating" value="5" {{ old('rating', $review->rating) == 5 ? 'checked' : ''}}>
                        <label for="rating5">5.非常に満足</label>
                    </div>
                </div>

                <div class="comment">
                    <label for="comment"></label>
                    <textarea name="comment" class="comment__area" rows="11" id="comment" placeholder="コメント" maxlength="400">{{ old('comment', $review->comment) }}</textarea>
                    <div id="charCount" class="char-count">{{ strlen(old('comment', $review->comment)) }}/400(最高文字数)</div>
                </div>

                <div class="review__image">
                   <label class="review__image-ttl">画像</label>
                    <div class="review__image-form">
                        <input type="file" name="image_url" accept="image/jpeg, image/png"  class="review__image-item">
                    </div>
                    <div class="image__preview">
                        @if($review->image_url)
                            <img id ='imagePreview' src="{{ asset('storage/review_images/' . $review->image_url) }}" alt="画像プレビュー">
                        @else
                            <img id ='imagePreview' src="#" alt="画像プレビュー">
                        @endif
                    </div>
                </div>

                <div class="post__form">
                    <div class="review__btn">
                        <button class="submit__btn" type="submit">更新する</button>
                    </div>
                    
                    <div class="review__alert">
                        @if(session('success'))
                            <div class="alert__success">
                                <p class="alert__message">{{ session('success')}}</p> 
                            </div>
                        @endif
                    </div>
                    <div class="review__alert">
                        @if(session('error'))
                            <div class="alert__danger">
                                <p class="alert__message">{{ session('error') }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </form>
            
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const textarea = document.getElementById('comment');
        const charCount = document.getElementById('charCount');
        const maxLength = textarea.maxLength;

        function updateCharCount() {
            const currentLength = textarea.value.length;
            charCount.textContent = `${currentLength}/${maxLength}(最高文字数)`;
        }

        textarea.addEventListener('input', updateCharCount);
        updateCharCount();

        const imageInput = document.querySelector('.review__image-item');
        const imagePreview = document.getElementById('imagePreview');

        imageInput.addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    imagePreview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
            else {
                imagePreview.style.display = 'none';
            }
        })
    });
</script>
@endsection