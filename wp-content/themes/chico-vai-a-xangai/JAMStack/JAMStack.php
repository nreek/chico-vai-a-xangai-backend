<?php 

class JAMStack {
    // public $allways_regenerate = [];

    function __construct($allways_regenerate = [ 'page', 'colunistas' ]){
        // $this->allways_regenerate = $allways_regenerate;

        $this->init();
        $this->hook();
    }
    
    // Basic environment setup
    function init(){
        if(!file_exists(WP_CONTENT_DIR.'/data')){
            mkdir(WP_CONTENT_DIR.'/data');
        }

        // Auto includes all data generator classes
        $filepath = dirname(__FILE__).'/generators/';
        $files = scandir($filepath);
    
        foreach ($files as $file) {
            if (substr($file,-4,4) == '.php' && $file != 'ContentGenerator.php') {
                require_once($filepath.$file);
            }
        }
    }

    function hook(){
        add_action( 'post_updated', ['JAMStack', 'save_post'], 1000, 2 );
    }

    function save_post(int $post_id, WP_Post $post){
        $request_body = file_get_contents('php://input');
        $request_data = json_decode($request_body);
        
        $ignore_post_types = [ 'Revision' ];
        
        $class_name = str_replace(' ', '', ucwords(str_replace('-', ' ', $post->post_type)));
        
        if(!in_array($class_name, $ignore_post_types)) {

            if ( !class_exists($class_name) ) {
                $class_name = 'ContentGenerator'; 
            }

            $generator = new $class_name($post, $request_data);
            $generator->save_post();

            $list_generator = new ListGenerator();
            $list_generator->generate_json();
        }

        // $terms_generator = new TermsGenerator($post, $request_data);
        $blog_generator = new BlogGenerator();
        $blog_generator->generate_json();

        // $this->allways_regenerate();
    }

    // function allways_regenerate(){
    //     $posts_query = new WP_Query( [
    //         'posts_per_page' => '-1',
    //         'post_type' => $this->allways_regenerate,
    //         'nopaging' => true
    //     ]);
    
    //     while($posts_query->have_posts()) {
    //         $posts_query->the_post();
    //         global $post; 
    
    //         $class_name = str_replace(' ', '', ucwords(str_replace('-', ' ', $post->post_type)));
    //         if ( !class_exists($class_name) ) {
    //             $class_name = 'ContentGenerator';
    //         }
    
    //         $generator = new $class_name($post, []);
    //         $generator->save_post();
    //     }
    
    //     wp_reset_postdata();
    // }
}