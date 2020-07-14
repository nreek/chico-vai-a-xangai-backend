<div class="flex flex-wrap">
    <?php 
    $processed_query = siteorigin_widget_post_selector_process_query( $instance['posts'] );
    $posts_query = new WP_Query( $processed_query );

    
    if($posts_query->have_posts()){
        while($posts_query->have_posts()){
            $posts_query->the_post();

            $image_id = \get_post_thumbnail_id(get_the_ID());
            $image = wp_get_attachment_image_src($image_id, 'card-small')[0];
            ?>
            <CBoxProfile 
            cover="<?= $image ?>"
            permalink="<?= get_permalink() ?>"
            >
                <div class="box-profile flex">
                    <img src="<?= $image ?>" alt="" class="box-profile__image">
                    <div class="flex-1">
                        <h4 class="box-profile__title mb-4"><?= get_the_title() ?></h4>
                        <div class="box-profile__body">
                            <?php 
                                if( $instance['body'] == 'content' ) {
                                    the_content();
                                } else {
                                    the_excerpt();
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </CBoxProfile>
            <?php 
        }
    }

    wp_reset_postdata();
    ?>
</div>