<?php 

class Utils {
    function __construct($initial_data = null) {
        $this->initial_data = $initial_data;
    }

    public static function recursively_mkdir($dir){
        if(!is_dir($dir)){
            $dir_p = explode('/', $dir);

            for( $a = 1; $a <= count($dir_p); $a++ ) {
                @mkdir( implode( '/',array_slice($dir_p,0,$a) ) );  
            }
        }
    }

    function get_thumbnail_info($post_id){
        $image_id = $this->get_image_id($post_id);


        $image = \wp_get_attachment_metadata($image_id);
        if(isset($image['image_meta'])){
            unset($image['image_meta']);
        }

        $image['file'] = wp_get_upload_dir()['baseurl'] . '/' . $image['file'];
        $sizes = \get_intermediate_image_sizes();
        $s = [];

        foreach($sizes as $size) {
            $att_src = wp_get_attachment_image_src($image_id, $size);
            try
            {
                $s[$size] = [
                    'url' => $att_src[0],
                    'width' => $att_src[1],
                    'height' => $att_src[2]
                ];
            } catch (Throwable $t) {
                var_dump( $t );
            }
        }

        $image['sizes'] = $s;

        return $image;
    }

    function get_image_url($size, $image_id = null, $post_id = null) {
        if (is_null($image_id)) {
            $image_id = $this->get_image_id($post_id);
        }
    
        $url = false;
        $thumb = \wp_get_attachment_image_src($image_id, $size, false);
        if ($thumb) {
            $url = $thumb[0];
        }
        return $url;
    }

    function get_image_id($post_id){
        $image_id = \get_post_thumbnail_id($post_id);

        if(!$image_id || isset($this->initial_data->featured_media) ){
            $image_id = $this->initial_data->featured_media;
        }

        return $image_id;
    }
}