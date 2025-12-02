<?php

/** @var \App\Model\Comment $comment */
/** @var \App\Service\Router $router */

$title = "Comment #{$comment->getId()}";
$bodyClass = 'show';

ob_start(); ?>
    
    <div style="background: #f9f9f9; padding: 20px; border: 1px solid #ddd; margin-bottom: 20px;">
        <h1>Comment Details</h1>
        
        <p><strong>Author:</strong> <?= $comment->getAuthor() ?></p>
        <p><strong>Content:</strong></p>
        <blockquote style="background: white; padding: 15px; border-left: 5px solid #eee;">
            <?= nl2br($comment->getContent()) ?>
        </blockquote>

        <p style="margin-top: 20px;">
            This comment belongs to Post ID: <strong><?= $comment->getPostId() ?></strong>
        </p>
    </div>

    <ul class="action-list">
        <li>
            <a href="<?= $router->generatePath('post-show', ['id' => $comment->getPostId()]) ?>">
                &laquo; Go to Post
            </a>
        </li>
        <li>
            <a href="<?= $router->generatePath('comment-index') ?>">
                Back to all comments list
            </a>
        </li>
        <li>
            <a href="<?= $router->generatePath('comment-edit', ['id' => $comment->getId()]) ?>">
                Edit this comment
            </a>
        </li>
    </ul>

<?php $main = ob_get_clean();

include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'base.html.php';