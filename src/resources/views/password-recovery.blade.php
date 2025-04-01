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
                <div class="popup--info">
                    <h2>Восстановление пароля</h2>
                    <div>Введите свою почту и мы отправим Вам ссылку на восстановление пароля</div>
                </div>
                <div id="auth-data" class="popup--fields">
                    <form action="{{ route('password.recovery') }}" method="POST">
                        @csrf
                        <div class="field">
                            <label class="field--label">E-mail</label>
                            <div class="field--data">
                                <input type="text" name="email" value="{{ old('email') }}">
                                @error('email')
                                    <div class="error">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="field buttons">
                            @if(Auth::id())
                                <a href="./profile"><div class="button">Назад</div></a>
                            @else
                                <a href="./authentication" class="no-decoration"><div class="button">Назад</div></a>
                            @endif                        
                            <button type="submit" class="button primary">Далее</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div id="footer" class="footer">@include('footer')</div>

        @if(session('status'))
            <script>
                alert("{{ session('status') }}");
            </script>
        @endif
    </body>
</html>