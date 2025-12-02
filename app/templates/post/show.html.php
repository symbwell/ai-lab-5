<?php

/** @var \App\Model\Post $post */
/** @var \App\Service\Router $router */

$title = "{$post->getSubject()} ({$post->getId()})";
$bodyClass = 'show';

ob_start(); ?>
    <h1><?= $post->getSubject() ?></h1>
    <article>
        <?= nl2br($post->getContent()); // nl2br dla lepszego formatowania ?>
    </article>

    <ul class="action-list">
        <li> <a href="<?= $router->generatePath('post-index') ?>">Back to list</a></li>
        <li><a href="<?= $router->generatePath('post-edit', ['id'=> $post->getId()]) ?>">Edit</a></li>
    </ul>

    <hr>

    <section id="comments">
        <h2>Comments (<?= $post->getCommentsCount() ?>)</h2>

        <!-- Formularz dodawania komentarza -->
        <div class="add-comment">
            <h3>Add a comment</h3>
            <form action="<?= $router->generatePath('comment-create') ?>" method="post">
                <input type="hidden" name="action" value="comment-create">
                <!-- Automatyczne przypisanie ID posta -->
                <input type="hidden" name="comment[post_id]" value="<?= $post->getId() ?>">
                
                <div class="form-group">
                    <label for="author">Name:</label>
                    <input type="text" id="author" name="comment[author]" required>
                </div>
                
                <div class="form-group">
                    <label for="content">Comment:</label>
                    <textarea id="content" name="comment[content]" required></textarea>
                </div>
                
                <div class="form-group">
                    <input type="submit" value="Add Comment">
                </div>
            </form>
        </div>

        <?php if ($comments = $post->getComments()): ?>
            <ul class="comments-list">
                <?php foreach ($comments as $comment): ?>
                    <li style="border-bottom: 1px solid #ccc; padding: 10px 0;">
                        <strong><?= $comment->getAuthor() ?></strong> wrote:
                        <p><?= nl2br($comment->getContent()) ?></p>
                        <small>
                            <a href="<?= $router->generatePath('comment-edit', ['id' => $comment->getId()]) ?>">Edit</a>
                        </small>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No comments yet. Be the first to comment!</p>
        <?php endif; ?>
    </section>

<?php $main = ob_get_clean();

include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'base.html.php';