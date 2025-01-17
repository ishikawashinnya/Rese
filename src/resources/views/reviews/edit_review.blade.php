@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/review.css') }}" />
@endsection

@section('content')
<div class="review__content">
    <div class="content__main">
        <div class="content__left">
            <div class="left__header">
                <p class="left__ttl">今回のご利用はいかがでしたか？</p>
            </div>
            <div class=" card">
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
        </div>

        <div class="content__right">
            <form action="{{ route('reviews.update', ['shop_id' => $shop->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <label class="rating__form-ttl">体験を評価してください</label>
                <div class="rating__radio-form">
                    <input class="rating__input" id="rating5" type="radio" name="rating" value="5" {{ old('rating', $review->rating) == 5 ? 'checked' : ''}}>
                    <label for="rating5" class="rating__star">&#9733;</label>

                    <input class="rating__input" id="rating4" type="radio" name="rating" value="4" {{ old('rating', $review->rating) == 4 ? 'checked' : ''}}>
                    <label for="rating4" class="rating__star">&#9733;</label>

                    <input class="rating__input" id="rating3" type="radio" name="rating" value="3" {{ old('rating', $review->rating) == 3 ? 'checked' : ''}}>
                    <label for="rating3" class="rating__star">&#9733;</label>

                    <input class="rating__input" id="rating2" type="radio" name="rating" value="2" {{ old('rating', $review->rating) == 2 ? 'checked' : ''}}>
                    <label for="rating2" class="rating__star">&#9733;</label>

                    <input class="rating__input" id="rating1" type="radio" name="rating" value="1" {{ old('rating', $review->rating) == 1 ? 'checked' : ''}}>
                    <label for="rating1" class="rating__star">&#9733;</label>
                </div>
                <div class="alert__danger">
                    @error('rating')
                    <span class="error__message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="comment">
                    <label for="comment" class="comment__ttl">口コミを投稿</label>
                    <textarea name="comment" class="comment__area" rows="11" id="comment" placeholder="カジュアルな夜のお出かけにおすすめのスポット" maxlength="400">{{ old('comment', $review->comment) }}</textarea>
                    <div id="charCount" class="char-count">0/400(最高文字数)</div>
                </div>
                <div class="alert__danger">
                    @error('comment')
                    <span class="error__message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="review__image">
                    <label class="review__image-ttl">画像の追加</label>
                    <div class="image__preview">
                        <img id='imagePreview' src="{{ asset('storage/review_images/' . $review->image_url) }}" alt="" class="image__preview-field">
                    </div>
                    <div class="image__select">
                        <label for="image" class="image__select-label">
                            クリックして写真を追加</br>
                            <span class="sub__label">またはドラッグアンドドロップ</span>
                        </label>
                        <input type="file" name="image_url" accept="image/jpeg, image/png" class="review__image-item" id="image" style="display: none;">
                    </div>
                </div>
                <div class="alert__danger">
                    @error('image_url')
                    <span class="error__message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="post__form">
                    <div class="review__btn">
                        <button class="submit__btn" type="submit">口コミを更新する</button>
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
    document.addEventListener('DOMContentLoaded', function() {
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
        const imageSelectLabel = document.querySelector('.image__select-label');
        const imagePreviewContainer = document.getElementById('imagePreviewContainer');
        const imageSelect = document.querySelector('.image__select');

        imageInput.addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    imagePreview.style.display = 'block';
                    imagePreviewContainer.style.backgroundColor = 'transparent';
                    imageSelect.style.display = 'none';
                };
                reader.readAsDataURL(file);
            } else {
                imagePreview.src = '';
                imagePreview.style.display = 'none';
                imagePreviewContainer.style.backgroundColor = '#f1f1f1';
                imageSelect.style.display = 'block';
            }
        });

        // ドラッグオーバー (ドラッグ中の処理)
        imagePreviewContainer.addEventListener('dragover', function(event) {
            event.preventDefault(); // ドラッグ中でもファイルがドロップできるようにする
            imagePreviewContainer.classList.add('dragover'); // CSSクラスでスタイル変更
        });

        // ドラッグが離れた時 (ドラッグを離した時に呼ばれる)
        imagePreviewContainer.addEventListener('dragleave', function() {
            imagePreviewContainer.classList.remove('dragover'); // CSSクラスでスタイル変更
        });

        // ドロップされた時 (実際にドロップされたときに呼ばれる)
        imagePreviewContainer.addEventListener('drop', function(event) {
            event.preventDefault();
            imagePreviewContainer.classList.remove('dragover'); // CSSクラスでスタイル変更

            const file = event.dataTransfer.files[0]; // ドロップしたファイルを取得
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    imagePreview.style.display = 'block';
                    imagePreviewContainer.style.backgroundColor = 'transparent'; // プレビュー背景を透明に
                    imageSelect.style.display = 'none'; // 画像が選択されたら「追加」ラベル非表示
                };
                reader.readAsDataURL(file);
            }
        });
    });
</script>
@endsection