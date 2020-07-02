<div class="related-posts <?= $instance['size'] ?>">
    <h5 class="related-posts__title"><?= $instance['title'] ?></h5>

    <ul>
    <?php 
    if($query->have_posts()){
        while($query->have_posts()){
            $query->the_post();
            ?>
            <li class="related-posts__post">
                <a href="<?= replace_home_url(get_the_permalink( get_the_ID() )); ?>">
                    <h6 class="related-posts__post-title"> <?php the_title() ?> </h6>
                    <?php if( has_excerpt() ) : ?>
                    <div class="related-posts__post-excerpt">
                        <?php the_excerpt(); ?>
                    </div>
                    <?php endif; ?>
                </a>
            </li>
            <?php
        }
    }
    wp_reset_postdata();
    ?>
    </ul>
</div>