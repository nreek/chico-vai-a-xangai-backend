<SmartBannerNutri 
title="<?= $instance['title'] ?>"
description="<?= $instance['description'] ?>"
title_right="<?= $instance['title_right'] ?>"
benefits="<?= $instance['benefits'] ?>"
button_text="<?= $instance['button_text'] ?>"
button_url="<?= $instance['button_url'] ?>"
image="<?= wp_get_attachment_image_src($instance['image'], 'card-medium')[0] ?>"
>
    <div style="background-color: #FCB823; display:flex; color:black; padding: 20px; font-weight: bold; text-align:center">
        <div style="max-width: 33.3%; flex: 0 0 33.3%; padding: 0 20px">
            <div style="color: #FCB823; font-size: 32px; text-transform:uppercase"><?= $instance['title'] ?></div>
            <div style="background-color: black; color: white; padding: 4px 20px;"><?= $instance['description'] ?></div>
        </div>

        <div style="max-width: 33.3%; flex: 0 0 33.3%">
            <img src="<?= wp_get_attachment_image_src($instance['image'], 'card-medium')[0] ?>" alt="">
        </div>

        <div style="max-width: 33.3%; flex: 0 0 33.3%">
            <div style="background-color: black; color: white; padding: 4px 20px; margin-bottom: 10px;"><?= $instance['title_right'] ?></div>
            <div><?= str_replace(';' ,'<br>', $instance['benefits']) ?></div>
            <div style="background-color: #DB0B0B; padding: 4px 20px; font-size: 14px; text-transform:uppercase; margin-bottom: 10px;"><?= $instance['button_text'] ?></div>
        </div>
    </div>
</SmartBannerNutri>