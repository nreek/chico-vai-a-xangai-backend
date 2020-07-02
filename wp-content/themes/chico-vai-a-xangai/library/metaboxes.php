<?php
add_action('cmb2_admin_init', function () {

    $cmb_post = new_cmb2_box(array(
        'id' => 'post_metabox',
        'title' => "Opções de Post",
        'object_types' => array('post'), 
        'context' => 'normal',
        'priority' => 'high',
        'show_names' => true,
    ));

    $cmb_post_side = new_cmb2_box(array(
        'id' => 'post_metabox_side',
        'title' => "Infos de Post",
        'object_types' => array('post'), 
        'context' => 'side',
        'priority' => 'low',
        'show_names' => true,
    ));

    $cmb_post->add_field(array(
        'name' => 'Autor',
        'id' => 'author',
        'defaul' => 'Redação',
        'type' => 'text'
    ));

    $cmb_post_side->add_field(array(
        'name' => 'Foi de ajuda?',
        'id' => 'helpful',
        'defaul' => '0',
        'type' => 'text'
    ));

    $colunistas = ['' => 'Nenhum'];
    $colunistas_query = new WP_Query([
        'post_type' => 'colunistas',
        'posts_per_page'       => -1,
        'post_status' => 'publish'
    ]);
    
    while($colunistas_query->have_posts()) {
        $colunistas_query->the_post();
        $colunistas[get_the_ID()] = get_the_title();
    }
    wp_reset_postdata();
    wp_reset_query();

    $cmb_post->add_field(array(
        'name' => 'Colunista',
        'id' => 'colunista',
        'type' => 'select',
        'options' => $colunistas
    ));

    if( isset($_GET['post']) ) {
        $related_posts_meta = get_post_meta($_GET['post'], 'related_posts', true);
        
        if ( empty($related_posts_meta) || count($related_posts_meta) == 0 ) {
            $tags = wp_get_post_tags($_GET['post']);
            if ($tags) {
                $tag_ids = array();
                foreach($tags as $individual_tag) $tag_ids[] = $individual_tag->term_id;
                $args=array(
                    'tag__in' => $tag_ids,
                    'post__not_in' => array($_GET['post']),
                    'posts_per_page'=> 4, // Number of related posts to display.
                    'caller_get_posts'=>1
                );
            
                $my_query = new wp_query( $args );
                $related_posts = [];
                while( $my_query->have_posts() ) {
                    $my_query->the_post();

                    $related_posts[] = get_the_ID();
                }

                add_post_meta( $_GET['post'], 'related_posts', $related_posts );

                wp_reset_postdata();
                wp_reset_query();
            }
        }

        $cmb_post->add_field( array(
            'name'    => __( 'Posts Relacionados', 'yourtextdomain' ),
            'id'      => 'related_posts',
            'type'    => 'custom_attached_posts',
            'column'  => true, // Output in the admin post-listing as a custom column. https://github.com/CMB2/CMB2/wiki/Field-Parameters#column
            'options' => array(
                'show_thumbnails' => false, // Show thumbnails on the left
                'filter_boxes'    => true, // Show a text box for filtering the results
                'query_args'      => array(
                    'posts_per_page' => 30,
                    'post_type'      => 'post',
                ), // override the get_posts args
            ),
        ) );
    }

    $cmb_newsletter = new_cmb2_box(array(
        'id' => 'newsletter_metabox',
        'title' => "Informações do cadastro",
        'object_types' => array('newsletter'), 
        'context' => 'normal',
        'priority' => 'high',
        'show_names' => true,
    ));

    $cmb_newsletter->add_field(array(
        'name' => 'Editorias',
        'id' => 'editorials',
        'type' => 'text'
    ));

    $cmb_suggestion = new_cmb2_box(array(
        'id' => 'suggestion_metabox',
        'title' => "Informações do cadastro",
        'object_types' => array('suggestion'), 
        'context' => 'normal',
        'priority' => 'high',
        'show_names' => true,
    ));

    $cmb_suggestion->add_field(array(
        'name' => 'Post',
        'id' => 'parent_id',
        'type' => 'text'
    ));

    $cmb_colunistas = new_cmb2_box(array(
        'id' => 'colunista_metabox',
        'title' => "Opções de Colunista",
        'object_types' => array('colunistas'), 
        'context' => 'normal',
        'priority' => 'high',
        'show_names' => true,
    ));

    $nav_menus = wp_get_nav_menus(); 
    $menus = ['' => 'Nenhum'];

    foreach ($nav_menus as $menu){
        $menus[$menu->slug] = $menu->name;
    }

    $cmb_colunistas->add_field(array(
        'name' => 'Menu principal',
        'id' => 'colunista_menu-principal',
        'type' => 'select',
        'options' => $menus,
    ));

    $cmb_colunistas->add_field(array(
        'name' => 'Menu de Redes Sociais',
        'id' => 'colunista_redes-sociais',
        'type' => 'select',
        'options' => $menus,
    ));

    $cmb_film = new_cmb2_box(array(
        'id' => 'film_metabox',
        'title' => "Informações do Filme",
        'object_types' => array('film'), 
        'context' => 'normal',
        'priority' => 'high',
        'show_names' => true,
    ));


});
