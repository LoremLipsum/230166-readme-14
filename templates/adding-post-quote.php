<section class="adding-post__quote tabs__content tabs__content--active">
    <h2 class="visually-hidden">Форма добавления цитаты</h2>
    <form class="adding-post__form form" action="/add.php?type_id=" method="post">
        <div class="form__text-inputs-wrapper">
            <div class="form__text-inputs">
                <!-- скрытое поле для типа контента -->
                <input type="hidden" type="text" name="type_id" value="2">

                <div class="adding-post__input-wrapper form__input-wrapper">
                    <label class="adding-post__label form__label" for="quote-heading">Заголовок <span class="form__input-required">*</span></label>
                    <div class="form__input-section <?= isset($errors['title']) ? 'form__input-section--error' : ''; ?>">
                        <input
                            class="adding-post__input form__input"
                            id="quote-heading"
                            type="text"
                            name="title"
                            placeholder="Введите заголовок"
                            value="<?= isset($post['title']) ? $post['title'] : ''; ?>"
                        >
                        <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                        <div class="form__error-text">
                            <h3 class="form__error-title">Заголовок сообщения</h3>
                            <p class="form__error-desc"><?= isset($errors['title']) ? $errors['title'] : ''; ?></p>
                        </div>
                    </div>
                </div>
                <div class="adding-post__input-wrapper form__textarea-wrapper">
                    <label class="adding-post__label form__label" for="cite-text">Текст цитаты <span class="form__input-required">*</span></label>
                    <div class="form__input-section <?= isset($errors['quote']) ? 'form__input-section--error' : ''; ?>">
                        <textarea
                            class="adding-post__textarea adding-post__textarea--quote form__textarea form__input"
                            id="cite-text"
                            placeholder="Текст цитаты"
                            name="quote"
                            value="<?= isset($post['quote']) ? $post['quote'] : ''; ?>"
                        ></textarea>
                        <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                        <div class="form__error-text">
                            <h3 class="form__error-title">Заголовок сообщения</h3>
                            <p class="form__error-desc"><?= isset($errors['quote']) ? $errors['quote'] : ''; ?></p>
                        </div>
                    </div>
                </div>
                <div class="adding-post__textarea-wrapper form__input-wrapper">
                    <label class="adding-post__label form__label" for="quote-author">Автор <span class="form__input-required">*</span></label>
                    <div class="form__input-section <?= isset($errors['caption']) ? 'form__input-section--error' : ''; ?>">
                        <input
                            class="adding-post__input form__input"
                            id="quote-author"
                            type="text"
                            name="caption"
                            value="<?= isset($post['caption']) ? $post['caption'] : ''; ?>"
                        >
                        <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                        <div class="form__error-text">
                            <h3 class="form__error-title">Заголовок сообщения</h3>
                            <p class="form__error-desc"><?= isset($errors['caption']) ? $errors['caption'] : ''; ?></p>
                        </div>
                    </div>
                </div>
                <div class="adding-post__input-wrapper form__input-wrapper">
                    <label class="adding-post__label form__label" for="post-tags">Теги</label>
                    <div class="form__input-section <?= isset($errors['tag']) ? 'form__input-section--error' : ''; ?>">
                        <input
                            class="adding-post__input form__input"
                            id="post-tags"
                            type="text"
                            name="tag"
                            placeholder="Введите теги"
                            value="<?= isset($post['tag']) ? $post['tag'] : ''; ?>"
                        >
                        <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                        <div class="form__error-text">
                            <h3 class="form__error-title">Заголовок сообщения</h3>
                            <p class="form__error-desc"><?= isset($errors['tag']) ? $errors['tag'] : ''; ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form__invalid-block">
                <b class="form__invalid-slogan">Пожалуйста, исправьте следующие ошибки:</b>
                <ul class="form__invalid-list">
                    <?php foreach($errors as $error): ?>
                        <li class="form__invalid-item"><?= $error ?></li>
                    <? endforeach ?>
                </ul>
            </div>
        </div>
        <div class="adding-post__buttons">
            <button class="adding-post__submit button button--main" type="submit">Опубликовать</button>
            <a class="adding-post__close" href="#">Закрыть</a>
        </div>
    </form>
</section>
