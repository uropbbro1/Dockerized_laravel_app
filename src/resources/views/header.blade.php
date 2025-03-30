<div class="header--info">
    <div class="logo">
        logo text
    </div>
    <div class="right-block">
        <div class="button primary" onclick="openPopup()">
            <img class="add--icon" src="./image/Plus.png">
            <span class="add--text">Добавить отзыв</span>
        </div>
        @if (!Auth::id())
            <div class="button" onclick="openPage('authentication')" not-authorized>
                Войти
            </div>
        @endif
        @if (Auth::id())
            <div class="person pointer" onclick="openPersonPopup()">
                @if(Auth::user()->image)
                    <img src="{{ Auth::user()->image }}" alt="User Avatar" width="50" height="50" style="border-radius: 50%;">
                @else
                    <img src="https://avatars.mds.yandex.net/i?id=e9213621c435c234cc2415b97ae55232_l-4571652-images-thumbs&n=13" alt="Default user Avatar" width="50" height="50" style="border-radius: 50%;">
                @endif
                <span class="person--nickname">{{ Auth::user()->login }}</span>
            </div>
        
            <div class="person-popup no-display" id="person-popup">
                <img class="arrow" src="./image/arrow-wrapper.svg">
                <div class="person-popup--items">
                    <div class="item pointer" onclick="openPage('profile')">
                        <img src="./image/mdi_account-outline.svg">
                        Мой профиль
                    </div>
                    <div class="item pointer" onclick="openPage('privacy-policy')">
                        <img src="./image/mdi_account-outline.svg">
                        Политика конфиденциальности
                    </div>
                    <div class="hr"></div>
                    <div class="item pointer">
                        <img src="./image/mdi_exit-to-app.svg">
                        <a href="{{ route('logout') }}">Выйти</a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
