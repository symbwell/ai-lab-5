<?php
    /** @var $comment ?\App\Model\Comment */
?>

<div class="form-group">
    <label for="post_id">Post ID</label>
    <input type="number" id="post_id" name="comment[post_id]" value="<?= $comment ? $comment->getPostId() : '' ?>">
</div>

<div class="form-group">
    <label for="author">Author</label>
    <input type="text" id="author" name="comment[author]" value="<?= $comment ? $comment->getAuthor() : '' ?>">
</div>

<div class="form-group">
    <label for="content">Content</label>
    <textarea id="content" name="comment[content]"><?= $comment ? $comment->getContent() : '' ?></textarea>
</div>

<div class="form-group">
    <label></label>
    <input type="submit" value="Submit">
</div>