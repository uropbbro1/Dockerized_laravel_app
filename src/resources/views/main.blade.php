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
        <div id="menu" class="menu">@include('menu')</div>
        <div id="add-comment" class="add-comment no-display">@include('add-comment')</div>

        <div class="content">
            <h2>Главная</h2>
            <div class="paragraph">
            <p>ГОЛ!</p>
                <p>Данная страница является домашней страницей, и служит для перехода в остальные разделы.</p>
                <p>Нажмите “Отзывы” для перехода к странице с отзывами.</p>
                <p>Нажмите “Мой профиль” для просмотра своего профиля. (Отображается только в авторизованном варианте страницы)</p>
                <p>Авторизуйтесь для просмотра своего профиля. (Отображается только в неавторизованном варианте страницы)</p>
            </div>

        </div>

        <div id="footer" class="footer">@include('footer')</div>
    </body>
</html>
