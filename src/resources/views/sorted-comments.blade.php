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
        <link rel="stylesheet" href="{{ URL::asset('css/profile.css'); }}">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
        <script src="{{ URL::asset('js/base.js') }}"></script>
        <script src="{{ URL::asset('js/comments.js') }}"></script>
    </head>
    <body>
        <div id="header" class="header">@include('header')</div>
        <div id="menu" class="menu">@include('menu')</div>
        <div id="add-comment" class="add-comment no-display">@include('add-comment')</div>

        <div class="content with-pagination">
            <h2>Отзывы</h2>
            <div class="filters">
                <div class="search">
                    <form action="{{ route('search-reviews') }}" method="post" style="display:flex;flex-direction:column;" novalidate>
                        @csrf
                        <div style="display:flex;flex-direction:row;">
                            <img src="./image/Magnifier.svg" />
                            <input type="text" name="search_term" placeholder="Найти...">
                        </div>
                        <button class="search-button" type="submit">Поиск</button>
                        @error('search_term') <div class="alert alert-danger">{{ $message }}</div> @enderror
                    </form>  
                </div>
                <br><br>
                <div class="field">
                    <div class="sort">
                        Показывать: 
                            @if(!isset($complete_search))
                                <span onclick="updateSort('{{ route('comments') }}')" id="sort" class="down">по дате <img src="./image/arrow-wrapper-black.svg"></span>
                            @else
                                <span onclick="updateSort('{{ route('sort-reviews', ['is-searched' => $complete_search, 'is-sorted' => $sorted]) }}')" id="sort" class="down">по дате <img src="./image/arrow-wrapper-black.svg"></span>
                            @endif
                    </div>
                    <div class="all-count">
                        Найден(о) {{ $reviews_count }} отзыв(а/ов)
                    </div>
                </div>
            </div>

            <!--  циклом выдавать сюда отзывы  -->
            @foreach ($reviews as $review)
                <div class="comment">
                    <div class="person">
                        @if($review->image)
                            <img src="{{ $review->image }}" alt="User Avatar" width="100" height="100" style="border-radius: 50%;">
                        @else
                            <img src="https://avatars.mds.yandex.net/i?id=e9213621c435c234cc2415b97ae55232_l-4571652-images-thumbs&n=13" alt="Default user Avatar" width="100" height="100" style="border-radius: 50%;">
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
                        <p class="review-text" data-fulltext="{{ $review->text }}">
                            @if (mb_strlen($review->text) > 350 || substr_count($review->text, "\n") > 3)
                                {{ mb_substr($review->text, 0, 350) }}...
                            @else
                                {{ $review->text }}
                            @endif
                        </p>
                    </div>
                    @if (mb_strlen($review->text) > 350 || substr_count($review->text, "\n") > 3)
                        <div class="buttons">
                            <div class="button" onclick="showAll({{ $review->id }})">Читать весь отзыв</div>
                        </div>
                    @endif
                    @if(Auth::id() === $review->user_id)
                        <div class="buttons">
                            <button class="change-button" onclick="openReviewUpdate({{ $review->id }})">Редактировать</button>
                        </div>
                    @endif

                    <!-- высплывающее окно для каждого отзыва -->
                    <div id="popup-comment{{ $review->id }}" class="comment-focus popup-comment no-display">
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
                                        <img src="{{ $review->image }}" alt="User Avatar" width="100" height="100" style="border-radius: 50%;">
                                    @else
                                        <img src="https://avatars.mds.yandex.net/i?id=e9213621c435c234cc2415b97ae55232_l-4571652-images-thumbs&n=13" alt="Guest Avatar" width="100" height="100" style="border-radius: 50%;">
                                    @endif
                                    <span class="person--nickname">@if(!$review->login) Гость @else {{ $review->login }} @endif</span>
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
                    <div id="review-update{{ $review->id }}" class="comment-focus review-update no-display" novalidate>
                        <div class="comment-form">
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
                                        @error('title')<div class="alert alert-danger">{{ $message }}</div>@enderror 
                                    </div>
                                    <div class="field">
                                        <label class="field--label">Ваш новый отзыв</label>
                                        <textarea class="field--data" rows="20" name="text" id="text" required>{{ $review->text }}</textarea>
                                        @error('text')<div class="alert alert-danger">{{ $message }}</div>@enderror
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
                                        @error('is_recommended')<div class="alert alert-danger">{{ $message }}</div>@enderror                            
                                </div>
                                <div class="comment--footer buttons">
                                    <button class="button primary" type="submit">Редактировать отзыв</button>
                                    <div class="button" onclick="closeReviewPopup({{ $review->id }})">Назад</div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="pagination">
            {{ $reviews->links() }} <!-- Вывод ссылок пагинации -->
        </div>

        <div id="footer" class="footer">@include('footer')</div>
    </body>
</html>
@if(session('err'))
    <script>
        openReviewUpdate({{session('err')}});
    </script>
@endif
@if(session('error'))
    <script>
        openAddReview();
    </script>
@endif