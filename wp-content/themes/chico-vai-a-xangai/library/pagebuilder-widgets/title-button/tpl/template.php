<div class="title-button">
    <h3><?= $instance['title'] ?></h3>

    <?php if(!empty($instance['button_url'])): ?>
        <a href="<?= $instance['button_url'] ?>"><?= $instance['button_text'] ?></a>
    <?php endif; ?>
</div>