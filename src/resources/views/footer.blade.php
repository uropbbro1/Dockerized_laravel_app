<div class="left-block">
    <img src="./image/H_7%20semibold.png">
</div>
<div class="center">
    <div class="pointer" onclick="openPage('')">Главная</div>
    <div class="pointer" onclick="openPage('comments')">Отзывы</div>
    @if (Auth::id())
        <div class="pointer" authorized onclick="openPage('profile')">Мой профиль</div>
    @endif
    <div class="pointer" onclick="openPage('privacy-policy')">Политика обработки персональных данных</div>
</div>
<div class="right-block">Logo Text © 2010 — 2023</div>