<?php $image = wp_get_attachment_image_src($instance['image'], 'full') ?>
<div class="banner small panel <?= !empty($image) ? 'has-image' : '' ?> <?= $instance['align'] ?>" style="background-image: url('<?= $image[0] ?>')">
    <h3 class="banner__title"><?= $instance['title'] ?></h3>

    <div class="banner__content"><?= $instance['text'] ?></div>

    <?php if(!empty('button_url')): ?>
        <a href="<?= $instance['button_url'] ?>" class="btn btn-primary"><?= $instance['button_text'] ?></a>
    <?php endif; ?>    
</div>