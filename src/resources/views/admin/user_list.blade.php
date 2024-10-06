@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin/user_list.css') }}" />
@endsection

@section('content')
<div class="user__list-content">
    <div class="user__list-header">
        <div class="user__list-ttl">
            <h2>ユーザー一覧</h2>
        </div>
    </div>

    <div class="user__list">
        <table class="user__list-table">
            <tr class="title__row">
                <th class="table__label">ユーザーID</th>
                <th class="table__label">名前</th>
                <th class="table__label">メールアドレス</th>
            </tr>

            @foreach ($users as $user)
                <tr class="value__row">
                    <td class="value__list">
                        {{ $user->id }}
                    </td>
                    <td class="value__list">
                        {{ $user->name }}
                    </td>
                    <td class="value__list">
                        {{ $user->email }}
                    </td>
                </tr>
            @endforeach
        </table>
    </div>

    <div class="pagination">
        {{ $users->links('vendor/pagination/custom') }}
    </div>
</div>
@endsection