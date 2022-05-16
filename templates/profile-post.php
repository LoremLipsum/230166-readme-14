<article class="profile__post post post-photo">
    <header class="post__header">
        <h2>
            <a href="post.php?post_id=<?= $post['id'] ?>"><?= esc($post['title']) ?></a>
        </h2>
    </header>
    <div class="post__main">
        <?php if ((int)$post['type_id'] === 1) : ?>
            <?= include_template('post-text.php', [
                    'text' => $post['text']
                ]);
            ?>
        <?php elseif((int)$post['type_id'] === 2) : ?>
            <?= include_template('post-quote.php', [
                    'quote' => $post['quote'],
                    'author' => $post['caption']
                ]);
            ?>
        <?php elseif ((int)$post['type_id'] === 3) : ?>
            <?= include_template('post-photo.php', [
                    'photo_url' => $post['photo_url'],
                ]);
            ?>
        <?php elseif ((int)$post['type_id'] === 4) : ?>
            <?= include_template('post-video.php', [
                    'video_url' => $post['video_url'],
                ]);
            ?>
        <?php elseif ((int)$post['type_id'] === 5) : ?>
            <?= include_template('post-link.php', [
                    'link_url' => $post['link_url'],
                    'title' => $post['title'],
                ]);
            ?>
        <? endif; ?>
    </div>
    <footer class="post__footer">
        <div class="post__indicators">
            <div class="post__buttons">
                <a
                    class="post__indicator post__indicator--likes button <?= $post['is_fav'] ? 'post__indicator--likes-active' : ''; ?>"
                    href="add-fav.php?post_id=<?= esc($post['id']) ?>"
                    title="Лайк"
                >
                    <svg class="post__indicator-icon" width="20" height="17">
                        <use xlink:href="#icon-heart"></use>
                    </svg>
                    <svg class="post__indicator-icon post__indicator-icon--like-active" width="20" height="17">
                        <use xlink:href="#icon-heart-active"></use>
                    </svg>
                    <span><?= $post['count_favs']; ?></span>
                    <span class="visually-hidden">количество лайков</span>
                </a>
                <a
                    class="post__indicator post__indicator--repost button"
                    href="#"
                    title="Репост"
                >
                    <svg class="post__indicator-icon" width="19" height="17">
                        <use xlink:href="#icon-repost"></use>
                    </svg>
                    <span>5</span>
                    <span class="visually-hidden">количество репостов</span>
                </a>
            </div>
            <time class="post__time"
                datetime="<?= $post['post_created_at'] ?>"
                title="<?= get_date_for_title($post['post_created_at']) ?>"
            ><?= get_relative_date($post['post_created_at']) ?></time>
        </div>
        <ul class="post__tags">
            <?php foreach ($post['tags'] as $tag) : ?>
                <li><a href="#"><?= $tag['text'] ?></a></li>
            <? endforeach; ?>
        </ul>
    </footer>
    <?php if ($post['is_show_comments']) : ?>
        <div class="comments">
            <a
                class="comments__button button"
                href="#"
            >Показать комментарии</a>
        </div>
    <? else : ?>
        <div class="comments">
            <div class="comments__list-wrapper">
                <ul class="comments__list">
                    <?php foreach ($post['comments'] as $comment) : ?>
                        <li class="comments__item user">
                            <div class="comments__avatar">
                                <a class="user__avatar-link" href="profile.php?user_id=<?= $comment['user_id'] ?>">
                                    <img class="comments__picture" src="<?= esc($comment['avatar']); ?>" alt="Аватар пользователя">
                                </a>
                            </div>
                            <div class="comments__info">
                                <div class="comments__name-wrapper">
                                    <a class="comments__user-name" href="profile.php?user_id=<?= $comment['user_id'] ?>">
                                        <span><?= esc($comment['login']); ?></span>
                                    </a>
                                    <time class="comments__time"
                                        datetime="<?= $comment['created_at']; ?>"
                                        title="<?= get_date_for_title($comment['created_at']); ?>"
                                    ><?= get_relative_date($comment['created_at']); ?></time>
                                </div>
                                <p class="comments__text">
                                    <?= esc($comment['text']) ?>
                                </p>
                            </div>
                        </li>
                    <? endforeach; ?>
                </ul>
                <?php if ($post['count_comments'] > 2 && !$post['is_show_comments']) : ?>
                    <a class="comments__more-link" href="#">
                        <span>Показать все комментарии</span>
                        <sup class="comments__amount"><?= esc($post['count_comments']); ?></sup>
                    </a>
                <? endif; ?>
            </div>
        </div>
        <form class="comments__form form" action="<?= $post['form_url']; ?>" method="post">
            <div class="comments__my-avatar">
                <img class="comments__picture" src="<?= $post['current_user']['avatar'] ?>" alt="Аватар пользователя">
            </div>
            <div class="form__input-section <?= $post['errors'] ? 'form__input-section--error' : ''; ?>">
                <textarea
                    class="comments__textarea form__textarea form__input"
                    placeholder="Ваш комментарий"
                    name="comment"
                ><?= $post['comment'] ?? ''; ?></textarea>
                <label class="visually-hidden">Ваш комментарий</label>
                <button class="form__error-button button" type="button">!</button>
                <div class="form__error-text">
                    <h3 class="form__error-title">Ошибка валидации</h3>
                    <p class="form__error-desc"><?= $post['errors'] ?? ''; ?></p>
                </div>
            </div>
            <button class="comments__submit button button--green" type="submit">Отправить</button>
        </form>
    <? endif ?>
</article>
