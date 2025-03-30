<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="{{ URL::asset('css/base.css'); }}">
        <link rel="stylesheet" href="{{ URL::asset('css/header.css'); }}">
        <link rel="stylesheet" href="{{ URL::asset('css/menu.css'); }}">
        <link rel="stylesheet" href="{{ URL::asset('css/footer.css'); }}">
        <link rel="stylesheet" href="{{ URL::asset('css/popup.css'); }}">
        <link rel="stylesheet" href="{{ URL::asset('css/comments.css'); }}">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
        <script src="{{ URL::asset('js/base.js') }}"></script>
        <script src="{{ URL::asset('js/comments.js') }}"></script>
    </head>
    <body>
        <div id="header" class="header">@include('header')</div>
        <div id="menu" class="menu">@include('menu')</div>
        <div id="add-comment" class="add-comment no-display">@include('add-comment')</div>

        <div class="content">
            <h2>Мой профиль</h2>
            <div class="profile">
                <div class="my-profile">
                    <div class="photo">
                        @if(Auth::user()->image)
                            <img src="{{ Auth::user()->image }}" alt="User Avatar" width="100" height="100">
                        @else
                            <img src="https://avatars.mds.yandex.net/i?id=e9213621c435c234cc2415b97ae55232_l-4571652-images-thumbs&n=13" alt="Default user Avatar" width="100" height="100">
                        @endif
                    </div>
                    <div class="info">
                        <div class="info--nickname">{{ Auth::user()->login }}</div>
                        <div>ID: {{Auth::user()->id}}</div>
                        <div class="info--update-photo pointer" onclick="openChangeAvatar()">Заменить фото</div>
                    </div>

                    <div id="change-avatar-block" class="no-display">
                        <form method="post" action="{{ route('change-avatar') }}" enctype="multipart/form-data">
                            @csrf
                            <input type="number" name="id" id="id" value="{{Auth::user()->id}}" hidden>
                            <input type="file" id="image" name="image" accept="image/*">
                            <button type="submit" class="button primary">Заменить фото</div>
                        </form>
                    </div>
                </div>
                <div class="update-data">
                    <form method="post" action="{{ route('update-data') }}">
                        @csrf
                        <div class="fields">
                            <div class="field">
                                <label class="field--label">Логин / Имя пользователя</label>
                                <div class="field--data">
                                    <input type="text" value="{{ Auth::user()->login }}" name="login" id="login" required>
                                </div>
                            </div>
                        </div>
                        <div class="fields">
                            <div class="field">
                                <label class="field--label">E-mail</label>
                                <div class="field--data">
                                    <input type="text" value="{{ Auth::user()->email }}" name="email" id="email" required>
                                </div>
                            </div>
                        </div>
                        @if(session('checkedPass'))
                            <div class="field">
                                <label class="field--label">Пароль</label>
                                <div class="field--data">
                                    <input type="text" value="{{ session('checkedPass') }}" placeholder="Введите пароль чтобы изменить данные аккаунта" name="password" id="password" onchange="changePassValue(this)" required>
                                    <span class="private" onclick="showPassword(this)"></span>
                                </div>
                            </div>
                        @else
                            <div class="field">
                                <label class="field--label">Пароль</label>
                                <div class="field--data">
                                    <input type="text" value="" placeholder="Введите пароль чтобы изменить данные аккаунта" name="password" id="password" onchange="changePassValue(this)" required>
                                    <span class="private" onclick="showPassword(this)"></span>
                                </div>
                            </div>
                        @endif
                        <button class="button primary" type="submit">Сохранить</button>
                    </form>
                    @if (session('checkPassStatus'))
                        @if(session('checkPassStatus') == 'yes')
                            <div class="password-changer">
                                <form method="post" action="{{ route('change-password') }}">
                                    @csrf
                                    <div class="field">
                                        <label class="field--label">Новый пароль</label>
                                        <div class="field--data with-image">
                                            <input type="text" value="" placeholder="Введите новый пароль" name="to_change_password" id="to_change_password" required>
                                            <span class="private" onclick="showPassword(this)"></span>
                                        </div>
                                    </div>
                                    <div class="field">
                                        <label class="field--label">Повторите пароль</label>
                                        <div class="field--data with-image">
                                            <input type="text" value="" placeholder="Повторите новый пароль" name="repeat_password" id="repeat_password" required>
                                            <span class="private" onclick="showPassword(this)"></span>
                                        </div>
                                    </div>
                                    <button class="button primary" type="submit">Сменить пароль</button>
                                </form>
                            </div>
                        @else
                            <form method="post" action="{{ route('check-password') }}">
                                @csrf
                                <input name="password_to_check" id="password_to_check" hidden value="">
                                <button class="btn btn-danger" type="submit">Сменить пароль</button>
                                @if(session('checkPassStatus') === 'no')<span style="color:red;">Неправильный пароль</span>@endif
                            </form>
                        @endif
                    @else
                        <form method="post" action="{{ route('check-password') }}">
                            @csrf
                            <input name="password_to_check" id="password_to_check" hidden value="">
                            <button class="btn btn-danger" type="submit">Сменить пароль</button>
                        </form>            
                    @endif
                </div>               
            </div>

            <h2>Мои отзывы ({{count($reviews)}})</h2>
            
            @if(!isset($reviews))
                <p style="color: blue;">Вы еще не оставили ни одного отзыва!</p>
            @else
                @foreach ($reviews as $review)
                    <div class="comment">
                        <div class="person">
                            @if(Auth::user()->image)
                                <img src="{{ Auth::user()->image }}" alt="User Avatar" width="50" height="50" style="border-radius: 50%;">
                            @else
                                <img src="https://avatars.mds.yandex.net/i?id=e9213621c435c234cc2415b97ae55232_l-4571652-images-thumbs&n=13" alt="Default user Avatar" width="50" height="50" style="border-radius: 50%;">
                            @endif
                            <span class="person--nickname">@if(!$review->login) Гость @else {{ $review->login }} @endif</span>
                        </div>
                        
                        <div class="date">
                            Отзыв от: {{ explode(' ', $review->created_at)[0] }}
                        </div>
                        
                        <div class="date">
                            Отзыв изменен: {{ explode(' ', $review->updated_at)[0] }}
                        </div>
                        
                        <div class="comment--title">
                            {{ $review->title }}
                        </div>
                        
                        <div class="comment--data">
                            {{ $review->text }}
                        </div>
                        
                        <div class="buttons">
                            <div class="button" onclick="showAll({{ $review->id }})">Читать весь отзыв</div>
                        </div>

                        <div class="buttons">
                            <button class="button" onclick="openReviewUpdate({{ $review->id }})">Редактировать</button>
                        </div>

                        <!-- высплывающее окно для каждого отзыва -->
                        <div id="popup-comment{{ $review->id }}" class="add-comment popup-comment no-display">
                            <div class="comment-form">
                                <div class="popup--title">
                                    Отзыв
                                    <div class="close pointer" onclick="closeReviewPopup({{ $review->id }})">
                                        <img src="./image/close.svg">
                                    </div>
                                </div>
                                <div class="comment--info">
                                    <div class="person">
                                        @if($review->image)
                                            <img src="{{ Auth::user()->image }}" width="50" height="50" style="border-radius: 50%;">
                                        @else
                                            <img src="https://avatars.mds.yandex.net/i?id=e9213621c435c234cc2415b97ae55232_l-4571652-images-thumbs&n=13" width="50" height="50" style="border-radius: 50%;">
                                        @endif
                                        <span class="person--nickname">{{ $review->login }}</span>
                                    </div>
                                    <div class="comment--title">
                                        {{ $review->title }}
                                    </div>
                                    <div class="comment--data">
                                        {{ $review->text }}
                                    </div>
                                    @if($review->is_recommended === 'yes')
                                        <div class="recommend">
                                            <img src="./image/mdi_thumb-up-outline.svg">
                                            <div>
                                                <div class="nickname">{{ $review->login }}</div>
                                                <div class="status">рекомендует</div>
                                            </div>
                                        </div>
                                    @elseif($review->is_recommended === 'no')
                                        <div class="recommend no-recommend">
                                            <img src="./image/mdi_thumb-up-outline-red.svg">
                                            <div>
                                                <div class="nickname">{{ $review->login }}</div>
                                                <div class="status">нерекомендует</div>
                                            </div>
                                        </div>
                                    @else
                                    @endif
                                </div>
                                <div class="comment--footer buttons">
                                    <div class="button" onclick="closeReviewPopup({{ $review->id }})">Назад</div>
                                </div>
                            </div>
                        </div>

                        <!-- высплывающее окно для реадактирования каждого отзыва -->
                        <div id="review-update{{ $review->id }}" class="comment-form review-update no-display" style="margin-top:20px;">
                            <form method="post" action="{{ route('update-review') }}">
                                @csrf
                                <input type="number" value="{{ $review->id }}" name="id" id="id" hidden>
                                <div class="popup--title">
                                    Редактировать отзыв
                                    <div class="close pointer" onclick="closeReviewPopup({{ $review->id }})">
                                        <img src="./image/close.svg">
                                    </div>
                                </div>
                                <div class="comment--info">
                                    <div class="field">
                                        <lable class="field--label">Новый заголовок отзыва одной фразой</lable>
                                        <div class="field--data">
                                            <input type="text" name="title" id="title" value="{{ $review->title }}" required/>
                                        </div>
                                    </div>
                                    <div class="field">
                                        <label class="field--label">Ваш новый отзыв</label>
                                        <textarea class="field--data" rows="20" name="text" id="text" required>{{ $review->text }}</textarea>
                                    </div>
                                        <div class="field--radio">
                                            <label class="field--label">Вы бы порекомендовали это?</label>
                                            <div class="field--data">
                                                <input type="radio" name="is_recommended" id="is_recommended" value="yes"/>
                                                <label>Да</label>
                                            </div>
                                            <div class="field--data">
                                                <input type="radio" name="is_recommended" id="is_recommended" value="no"/>
                                                <label>Нет</label>
                                            </div>
                                        </div>                                
                                </div>
                                <div class="comment--footer buttons">
                                    <button class="button primary" type="submit">Редактировать отзыв</button>
                                    <div class="button" onclick="closeReviewPopup({{ $review->id }})">Назад</div>
                                </div>
                            </form>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        <div id="footer" class="footer">@include('footer')</div>
    </body>
</html>
