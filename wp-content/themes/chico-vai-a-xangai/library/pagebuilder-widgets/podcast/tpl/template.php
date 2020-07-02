<SmartPodcast 
title="<?= $instance['title'] ?>"
description="<?= $instance['description'] ?>"
image="<?= wp_get_attachment_image_src($instance['image'])[0] ?>"
podcast_url="<?= $instance['podcast_url'] ?>"
:button="{
    text : '<?= $instance['button_text'] ?>',
    url : '<?= $instance['button_url'] ?>'
}"
>
    <div class="networks-links">
        <span><?= $instance['network_text'] ?></span>
        <?php 
        foreach ( $instance['networks'] as $network ) {
            $icon = $network['icon'];

            if ( empty($icon) ){
                $icon = '<img src="' . wp_get_attachment_image_src($network['image'])[0] . '" />';
            }
            ?>
            <a href="<?= $network['url'] ?>" target="_blank"><?= $icon ?></a>
            <?php
        }
        ?>
    </div>
</SmartPodcast>