@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin/csv.css') }}" />
@endsection

@section('content')
<div class="import__content">
    <div class="description">
        <p>csvをインポートすることで、店舗情報を追加することができます。</p>
        <p>店舗情報の上書きではなく新規店舗を追加するための機能です。</p>
        <p>下記リンクをクリックするとテンプレートのダウンロードが出来ます。</p>
        <a href="{{ route('csv.download') }}" class="link__button">
            CSVテンプレートをダウンロード
        </a>
        <p class="attention">※CSVファイル作成時の注意点</p>
        <ul class="attention__list">
            <li>CSVファイルの作成・編集は、Googleスプレッドシートで行ってください。</li>
            <li>全ての項目が入力必須です。</li>
            <li>店舗名は50文字以内で作成してください。</li>
            <li>ジャンルは「寿司」「焼肉」「居酒屋」「イタリアン」「ラーメン」のいずれかを入力してください。</li>
            <li>エリアは「東京都」「大阪府」「福岡県」のいずれかを入力してください。</li>
            <li>店舗説明は400文字以内で作成してください。</li>
            <li>画像URLは、「jpeg」「png」のみ使用可能です。</li>
        </ul>
    </div>

    <form action="{{ route('csv.import') }}" method="post" enctype="multipart/form-data" class="form">
        @csrf
        <div class="form__input">
            <input type="file" name="csvFile" class="input__item" id="csvFile" accept=".csv">
        </div>
        <div class="form__button">
            <button class="form__button-submit" type="submit">インポート</button>
        </div>
    </form>

    @if(session('success'))
    <div class="create__alert">
        <p class="alert__success">{{ session('success')}}</p>
    </div>
    @endif

    @if($errors->any())
    <div class="create__alert">
        <ul class="error__list">
            @foreach($errors->all() as $error)
            <li class="alert__error">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
</div>
@endsection