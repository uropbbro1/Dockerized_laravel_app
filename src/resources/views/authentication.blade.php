<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="{{ URL::asset('css/base.css'); }}">
        <link rel="stylesheet" href="{{ URL::asset('css/header.css'); }}">
        <link rel="stylesheet" href="{{ URL::asset('css/menu.css'); }}">
        <link rel="stylesheet" href="{{ URL::asset('css/footer.css'); }}">
        <link rel="stylesheet" href="{{ URL::asset('css/popup.css'); }}">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
        <script src="{{ URL::asset('js/base.js') }}"></script>
        <script src="{{ URL::asset('js/authentication.js') }}"></script>
    </head>
    <body>
        <div id="header" class="header">@include('header')</div>
        <div id="menu" class="menu">
            <div class="menu--item pointer active" onclick="openPage('')">Главная</div>
            <div class="menu--item pointer" onclick="openPage('comments')">Отзывы</div>
            @if (Auth::id())
                <div class="menu--item pointer" onclick="openPage('profile')">Мой профиль</div>
            @endif
        </div>
        <div id="add-comment" class="add-comment no-display">@include('add-comment')</div>

        <div class="content">
            <div class="popup">
                <div class="popup--tabs" id="popup-tabs">
                    <div id="auth" class="tab pointer active">Вход</div>
                    <div id="registration" class="tab pointer">Регистрация</div>
                </div>
                <div id="auth-data" class="popup--fields">
                    <form method="post" action="{{route('auth')}}" novalidate>
                        @csrf
                        <div class="field">
                            <label class="field--label">E-mail</label>
                            <div class="field--data">
                                <input id="email" type="text" value=""  name="email" id="email" required>
                            </div>
                            @error('email')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="field">
                            <label class="field--label">Пароль</label>
                            <div class="field--data">
                                <input type="password" value="" name="password" id="password" required>
                                <span class="password-toggle" onclick="togglePasswordVisibility()"></span>
                            </div>
                            @error('password')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="field text-right">
                            <a class="no-decoration" href="./password-recovery">Забыли пароль?</a>
                        </div>
                        <div class="field">
                            <button class="button primary" type="submit">
                                Войти
                            </button>
                        </div>
                    </form>
                </div>
                <div id="registration-data" class="popup--fields no-display">
                    <form method="post" action="{{ route('register') }}" novalidate>
                        @csrf
                        <div class="field">
                            <label class="field--label">Логин / Имя пользователя</label>
                            <div class="field--data">
                                <input type="text" value="" name="login_reg" id="login_reg" required>
                            </div>
                            @error('login_reg')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="field">
                            <label class="field--label">E-mail</label>
                            <div class="field--data">
                                <input type="text" value="" name="email_reg" id="email_reg" required>
                            </div>
                            @error('email_reg')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="field">
                            <label class="field--label">Пароль</label>
                            <div class="field--data">
                                <input type="password" value="" name="password_reg" id="password_reg" required>
                                <span class="password-toggle-reg" onclick="togglePasswordVisibilityReg()"></span>
                            </div>
                            @error('password_reg')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="field">
                            <label class="field--label">Повторите пароль</label>
                            <div class="field--data">
                                <input type="password" value="" name="password_confirmation" id="password_confirmation" required>
                                <span class="password-toggle-reg1" onclick="togglePasswordVisibilityReg()"></span>
                            </div>
                            @error('password_confirmation')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="field">
                            <input type="checkbox" name="agreement_check"/>
                            <span>Я даю согласие на <a href="./privacy-policy">обработку моих персональных данных</a></span>
                            @error('agreement_check')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="field">
                            <button class="button primary" type="submit">
                                Зарегистрироваться
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div id="footer" class="footer">@include('footer')</div>
    </body>
</html>
@if(session('error'))
    <script>
        openAddReview();
    </script>
@endif