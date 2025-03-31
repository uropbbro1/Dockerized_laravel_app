<div class="comment-form">
    <form method="post" action="{{ route('add-review') }}" novalidate>
        @csrf
        <input type="number" value="{{ Auth::id() }}" name="user_id" id="user_id" hidden>
        <div class="popup--title">
            Новый отзыв
            <div class="close pointer" onclick="closePopup()">
                <img src="./image/close.svg">
            </div>
        </div>
        <div class="comment--info">
            <div class="field">
                <lable class="field--label">Заголовок отзыва одной фразой</lable>
                <div class="field--data">
                    <input type="text" name="title" id="title" required/>
                    @error('title')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="field">
                <label class="field--label">Ваш отзыв</label>
                <textarea class="field--data" rows="20" name="text" id="text" required></textarea>
                @error('text')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            @if(Auth::id())
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
                    @error('is_recommended')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            @else
                <div class="field">
                    Для того, чтобы оставить рекомендацию к отзыву, <a href="./authentication">войдите или зарегистрируйтесь</a>
                </div>
            @endif
            
        </div>
        <div class="comment--footer buttons">
            <button class="button primary" type="submit">Отправить отзыв</button>
            <div class="button" onclick="closePopup()">Назад</div>
        </div>
    </form>
</div>