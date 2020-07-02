<div class="container">
    <div class="row">
        <?php 
        $processed_query = siteorigin_widget_post_selector_process_query( $instance['posts'] );
        $posts_query = new WP_Query( $processed_query );

        if($posts_query->have_posts()){
            while($posts_query->have_posts()){
                $posts_query->the_post();
                ?>
                <div class="col-md-<?= 12 / $instance['columns'] ?>">
                    <?php template_part('featured-card', [ 'show' => $instance['show'] ]); ?>
                </div>
                <?php 
            }
        }

        wp_reset_postdata();
        ?>
    </div>
</div>