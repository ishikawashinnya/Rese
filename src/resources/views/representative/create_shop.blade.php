@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/representative/shop_form.css') }}" />
@endsection

@section('content')
<div class="shop__form-content">
    <div class="content__left">
        <div class="content__left-ttl">
            <h2>店舗情報を入力</h2>
        </div>
        <form action="{{ route('shop.store') }}" method="POST" enctype="multipart/form-data" class="create__form">
            @csrf
            <div class="form__inner">
                <label for="name" class="form__label">店名</label>
                <div class="form__item">
                    <input type="text" name="name" id="name" class="input__item" value="{{ old('name') }}"/>
                    <div class="error__item">
                        @error('name')
                            <span class="error__message">{{ $message }}</span>
                        @enderror
                    </div>
                </div>  
            </div>
            <div class="form__inner">
                <label for="" class="form__label">エリア</label>
                <div class="form__item">
                    <select name="area_id" id="area_id" class="select__item">
                        <option value="" disabled {{ old('area_id') ? '' : 'selected' }}>-- エリアを選択 --</option>
                        @foreach ($areas as $area)
                            <option value="{{ $area->id }}" {{ old('area_id') == $area->id ? 'selected' : '' }}>{{ $area->name }}</option>
                        @endforeach
                    </select>
                    <div class="error__item">
                        @error('area_id')
                            <span class="error__message">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="form__inner">
                <label for="" class="form__label">ジャンル</label>
                <div class="form__item">
                    <select name="genre_id" id="genre_id" class="select__item">
                        <option value="" disabled {{ old('genre_id') ? '' : 'selected' }}>-- ジャンルを選択 --</option>
                        @foreach ($genres as $genre)
                            <option value="{{ $genre->id }}" {{ old('genre_id') == $genre->id ? 'selected' : '' }}>{{ $genre->name }}</option>
                        @endforeach
                    </select>
                    <div class="error__item">
                        @error('genre_id')
                            <span class="error__message">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="form__inner">
                <label for="address" class="form__label">住所</label>
                <div class="form__item">
                    <input type="text" name="address" id="address" class="input__item" value="{{ old('address') }}"/>
                    <div class="error__item">
                        @error('address')
                            <span class="error__message">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="form__inner">
                <div class="description__label">
                    <label for="description" class="form__label">店舗説明</label>
                    <div id="charCount" class="char-count">
                        0/150(最高文字数)
                    </div>
                </div>
                <div>
                    <textarea name="description" id="description" rows="8" maxlength="150" class="description_text">{{ old('description') }}</textarea>
                    
                    <div class="error__item">
                        @error('description')
                            <span class="error__message">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="form__inner">
                <label class="form__label">店舗画像</label>
                <div class="shop__image">
                    <input type="file" name="image_url" accept="image/jpeg, image/png"  class="shop__image-item">
                    <div class="error__item">
                        @error('image_url')
                            <span class="error__message">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="form__inner">
                <div class="form__btn">
                    <div class="form__link">
                        <a href="{{ route('mypage') }}" class="back__button">戻る</a>
                    </div>
                    <button class="submit__btn" type="submit">作成する</button>
                </div>
            </div>
        </form>
        <div class="create__alert">
            @if(session('success'))
                <div class="alert__success">
                    <p class="alert__message">{{ session('success')}}</p> 
                </div>
            @endif
        </div>
    </div>
    <div class="content__right">
        <div class="content__right-ttl">
            <h2>表示イメージ</h2>
        </div>
        
        <div class="content__right-waper">
            <div class="content__right-groupe">
                <div class="card__ttl"><h3>店舗一覧</h3></div>
                <div class="card">
                    <div class="image__preview">
                        <img id ='card__image' src="#" alt="画像プレビュー">
                    </div>

                    <div class="card__item">
                        <div class="shop__name">
                            <p id="name__preview">店名</p>
                        </div>
                        <div class="text__box">
                            <p id="area__preview" class="area">#エリア</p>
                            <p id="genre__preview" class="genre">#ジャンル</p>
                        </div>
                    </div>

                    <div class="card__btn">
                        <div class="detail__link">
                            <a href="#" class="detail__link-btn">詳しくみる</a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="content__right-groupe">
                <div class="detail__ttl"><h3>店舗詳細</h3></div>
                <div class="shop__detail">
                    <div class="left__header">
                        <div class="content__left-ttl">
                            <div class="return__link">
                                <a href="#" class="return__btn"><</a>
                            </div>
                            <p class="detail__name">店名</p>
                        </div>
                    </div>
                    <div class="detail__img">
                        <img id='detail__image' src="#" alt="画像プレビュー">
                    </div>
        
                    <div class="shop__information">
                        <p id="detail__area">#エリア</p>
                        <p id="detail__genre">#ジャンル</p>
                    </div>

                    <div class="shop__description">
                        <p id="detail__description">説明文</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
            // 店名のリアルタイム更新
            const nameInput = document.getElementById('name');
            const shopNamePreview = document.getElementById('name__preview');
            const detailShopName = document.querySelector('.detail__name');
        
            nameInput.addEventListener('input', function () {
                const nameValue = nameInput.value || '店名';
                shopNamePreview.textContent = nameValue;
                detailShopName.textContent = nameValue;
            });

            // エリアのリアルタイム更新
            const areaSelect = document.getElementById('area_id');
            const areaPreview = document.getElementById('area__preview');
            const detailArea = document.getElementById('detail__area');
        
            areaSelect.addEventListener('change', function () {
                const areaText = areaSelect.options[areaSelect.selectedIndex].text || '#エリア';
                areaPreview.textContent = `#${areaText}`;
                detailArea.textContent = `#${areaText}`;
            
            });

            // ジャンルのリアルタイム更新
            const genreSelect = document.getElementById('genre_id');
            const genrePreview = document.getElementById('genre__preview');
            const detailGenre = document.getElementById('detail__genre');
        
            genreSelect.addEventListener('change', function () {
                const genreText = genreSelect.options[genreSelect.selectedIndex].text || '#ジャンル';
                genrePreview.textContent = `#${genreText}`;
                detailGenre.textContent = `#${genreText}`;
            });

            // 店舗説明のリアルタイム更新
            const descriptionTextarea = document.getElementById('description');
            const detailDescription = document.getElementById('detail__description');

            descriptionTextarea.addEventListener('input', function () {
                detailDescription.textContent = descriptionTextarea.value || '説明文';
            })


            // 文字数カウントの更新
            const textarea = document.getElementById('description');
            const charCount = document.getElementById('charCount');
            const maxLength = textarea.maxLength;

            function updateCharCount() {
                const currentLength = textarea.value.length;
                charCount.textContent = `${currentLength}/${maxLength}(最高文字数)`;
            }

            textarea.addEventListener('input', updateCharCount);
            updateCharCount();

            // 画像プレビューのリアルタイム更新
            const imageInput = document.querySelector('.shop__image-item');
            const cardImagePreview = document.getElementById('card__image');
            const detailImagePreview = document.getElementById('detail__image');

            imageInput.addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        cardImagePreview.src = e.target.result;
                        detailImagePreview.src = e.target.result;
                        cardImagePreview.style.display = 'block';
                        detailImagePreview.style.display = 'block';
                        cardImagePreview.style.objectFit = 'cover';
                        detailImagePreview.style.objectFit = 'cover';
                    };
                    reader.readAsDataURL(file);
                }
                else {
                    cardImagePreview.style.display = 'none';
                    detailImagePreview.style.display = 'none';
                }
            })
    });
</script>
@endsection