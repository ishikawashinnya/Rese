@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin/admin_mypage.css') }}" />
@endsection

@section('content')
<div class="admin__content">
    <div class="admin__header">
        <h2 class="header__ttl">管理者専用画面</h2>
    </div>

    <div class="admin__main">
        <div class="admin__link">
            <a href="{{ route('admin.create') }}" class="admin__link-item">
                <h3>店舗代表者作成</h3>
            </a>
        </div>
        <div class="admin__link">
            <a href="#" class="admin__link-item">
                <h3>メール作成</h3>
            </a>
        </div>                 
    </div>
</div>
@endsection