<SmartBannerCoach 
title="<?= $instance['title'] ?>"
description="<?= $instance['description'] ?>"
button_text="<?= $instance['button_text'] ?>"
button_url="<?= $instance['button_url'] ?>"
image="<?= wp_get_attachment_image_src($instance['image'], 'card-medium')[0] ?>"
>
<div style="background-color: black; display:flex; color:white; padding: 20px">
    <div style="max-width: 33.3%; flex: 0 0 33.3%; padding: 0 20px">
        <div style="color: #FCB823;"><?= $instance['title'] ?></div>
        <div style="background-color: #DB0B0B; padding: 4px 20px; font-size: 14px; text-transform:uppercase; "><?= $instance['button_text'] ?></div>
    </div>

    <div style="max-width: 33.3%; flex: 0 0 33.3%">
        <img src="<?= wp_get_attachment_image_src($instance['image'], 'card-medium')[0] ?>" alt="">
    </div>

    <div style="max-width: 33.3%; flex: 0 0 33.3%">
        <div style="margin-bottom: 20px"><?= $instance['description'] ?></div>
    </div>
</div>
</SmartBannerCoach>