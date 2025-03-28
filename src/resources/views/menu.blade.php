<div class="menu--item pointer active" onclick="openPage('')">Главная</div>
<div class="menu--item pointer" onclick="openPage('comments')">Отзывы</div>
@if (Auth::id())
    <div class="menu--item pointer" onclick="openPage('profile')">Мой профиль</div>
@endif
