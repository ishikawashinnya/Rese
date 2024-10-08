<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rese</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    @yield('css')
</head>

<body>
    <header>
        <div class="header__left">
            <div class="hamburger__menu">
                <input type="checkbox" id="menu__btn-check" class="menu__hidden">
                <label for="menu__btn-check" class="menu__btn"><span></span></label>
                <!--ここからメニュー-->
                <nav class="menu__content">
                    <ul class="menu__list">
                        <li class="menu__item">
                            <a class="menu__item-link" href="/">Home</a>
                        </li>
                        @if (Auth::check())
                            <li class="menu__item">
                                <form id="logout-form" action="/logout" method="POST" style="display: none;">
                                    @csrf
                                </form>
                                <a class="menu__item-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Logout
                                </a>
                            </li>
                            <li class="menu__item">
                                <a class="menu__item-link" href="/mypage">Mypage</a>
                            </li>
                        @else
                            <li class="menu__item">
                                <a class="menu__item-link" href="/register">Register</a>
                            </li>
                            <li class="menu__item">
                                <a class="menu__item-link" href="/login">Login</a>                      
                            </li>
                        @endif
                    </ul>
                </nav>
                <!--ここまでメニュー-->
            </div>
            <div class="header__logo">
                <h2>Rese</h2>
            </div>
        </div>
        @yield('header')
    </header>
    
    <main>
        @yield('content')
    </main>
</body>
</html>