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
        <div id="menu" class="menu">@include('menu')</div>
        <div id="add-comment" class="add-comment no-display">@include('add-comment')</div>

        <div class="content">
            <div class="popup">
                <div class="popup--tabs" id="popup-tabs">
                    <div id="auth" class="tab pointer active">Вход</div>
                    <div id="registration" class="tab pointer">Регистрация</div>
                </div>
                <div id="auth-data" class="popup--fields">
                    <form method="post" action="{{route('auth')}}">
                        @csrf
                        <div class="field">
                            <label class="field--label">E-mail</label>
                            <div class="field--data">
                                <input id="email" type="text" value=""  name="email" id="email" required>
                            </div>
                        </div>
                        <div class="field">
                            <label class="field--label">Пароль</label>
                            <div class="field--data with-image">
                                <input type="password" value="" name="password" id="password" required>
                                <span class="private" onclick="showPassword(this)"></span>
                            </div>
                        </div>
                        <div class="field text-right">
                            <a href="./password-recovery">Забыли пароль?</a>
                        </div>
                        <div class="field">
                            <button class="button primary" type="submit">
                                Войти
                            </button>
                        </div>
                    </form>
                </div>
                <div id="registration-data" class="popup--fields no-display">
                    <form method="post" action="{{ route('register') }}">
                        @csrf
                        <div class="field">
                            <label class="field--label">Логин / Имя пользователя</label>
                            <div class="field--data">
                                <input type="text" value="" name="login" id="login" required>
                            </div>
                        </div>
                        <div class="field">
                            <label class="field--label">E-mail</label>
                            <div class="field--data">
                                <input type="text" value="" name="email" id="email" required>
                            </div>
                        </div>
                        <div class="field">
                            <label class="field--label">Пароль</label>
                            <div class="field--data with-image">
                                <input type="text" value="" name="password" id="password" required>
                                <span class="private" onclick="showPassword(this)"></span>
                            </div>
                        </div>
                        <div class="field">
                            <label class="field--label">Повторите пароль</label>
                            <div class="field--data with-image">
                                <input type="text" value="" name="repeat_password" id="repeat_password" required>
                                <span class="private" onclick="showPassword(this)"></span>
                            </div>
                        </div>
                        <div class="field">
                            <input type="checkbox" name="agreement_check"/>
                            <span>Я даю согласие на <a href="./privacy-policy">обработку моих персональных данных</a></span>
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
