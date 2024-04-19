<?php

class AutoblogAiAdmin{


    public function __construct(){
        require_once(ABSPATH . 'wp-admin/includes/media.php');
        require_once(ABSPATH . 'wp-admin/includes/file.php');
        require_once(ABSPATH . 'wp-admin/includes/image.php');
    }

    public function run(){
        add_action('admin_enqueue_scripts', [$this,"admin_scripts"]);
        add_action( 'admin_menu', [$this,'autoblogai_admin_page'] );
        add_action('wp_ajax_save_token', [$this,'save_token']);
        add_action('wp_ajax_revoke_token', [$this,'revoke_token']);
        add_action('wp_ajax_get_projects', [$this,'get_projects']);
        add_action('wp_ajax_publish_articles', [$this,'publish_articles']);
        add_action('wp_ajax_set_featured_image', [$this,'addImage']);
    }


    public function autoblogai_admin_page(){
        add_menu_page(
            'AIrticle-flow',
            'AIrticle-flow',
            'manage_options',
            'airticle-flow',
            [$this,'display_main_admin_page'],
            plugin_dir_url(__FILE__) . 'img/menu_icon.svg',
            20
        );

        add_submenu_page(
            'airticle-flow',
            'Token setting',
            'Token setting',
            'manage_options',
            'airticle-flow-token-settings',
            [$this, 'display_token_page']
        );
    }

    public function display_main_admin_page(){
        $script_url = plugins_url('js/articles.js', __FILE__);
        wp_enqueue_script("autoblog_articles", $script_url, array('jquery'));
        require plugin_dir_path(__FILE__) . 'partials/main_menu.php';

    }

    public function display_token_page(){
        require plugin_dir_path(__FILE__) . 'partials/token.php';
    }

    public function admin_scripts(){

        $nonce = wp_create_nonce('autoblog-ai-nonce');

        wp_enqueue_script('jquery');
        $css_url = plugins_url('css/autoblog_ai.css', __FILE__);
        wp_enqueue_style("autoblog-css", $css_url);
        $script_url = plugins_url('js/autoblog-ai.js', __FILE__);
        wp_enqueue_script("autoblog_main", $script_url, array('jquery'));
        wp_localize_script('autoblog_main', 'wp_vars', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => $nonce
        ));
    }


    public function save_token(){
        if (!current_user_can('manage_options')) {
            wp_die('You do not have sufficient permissions to access this page.');
        }
        if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash ( $_POST['nonce'] ) ) , 'autoblog-ai-nonce' ) ){
            wp_die('Nonce verification failed!');
        }
        $token = sanitize_text_field($_POST['token']);
        add_user_meta(get_current_user_id(), 'autoblog-ai_token', $token, true);
        wp_die();
    }

    public function revoke_token(){
        if (!current_user_can('manage_options')) {
            wp_die('You do not have sufficient permissions to access this page.');
        }
        if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash ( $_POST['nonce'] ) ) , 'autoblog-ai-nonce' ) ){
            wp_die('Nonce verification failed!');
        }
        delete_user_meta(get_current_user_id(), 'autoblog-ai_token');
        wp_die();
    }


    public function get_projects(){
        if (!current_user_can('manage_options')) {
            wp_die('You do not have sufficient permissions to access this page.');
        }

        if ( ! isset( $_GET['nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash ( $_GET['nonce'] ) ) , 'autoblog-ai-nonce' ) ){
            wp_die('Nonce verification failed!');
        }
        $url = 'https://airticle-flow.com/api/projects';
        $token = get_user_meta(get_current_user_id(), 'autoblog-ai_token', true);
        $headers = array(
            'Authorization' => 'Bearer ' . $token
        );


        $response = wp_remote_get($url, array(
            'headers' => $headers,
            'method'  => 'GET'
        ));
        if (!is_wp_error($response)) {
            $body = wp_remote_retrieve_body($response);
            $body = json_decode($body);
            echo wp_json_encode($body);

        }
        wp_die();
    }

    public function publish_articles(){
        if (!current_user_can('manage_options')) {
            wp_die('You do not have sufficient permissions to access this page.');
        }
        if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash ( $_POST['nonce'] ) ) , 'autoblog-ai-nonce' ) ){
            wp_die('Nonce verification failed!');
        }
        $projectId = (int) $_POST['project_id'];
        $category_id = (int) $_POST['category_id'];
        $schedule = sanitize_text_field($_POST['schedule']);
        $planning = $_POST['planning']; //this is a nested array, all fields will be sanitized when accessed

        $post_status = "publish";
        if($schedule === "draft"){
            $post_status = "draft";
        }

        if($schedule === "drip"){
            if(!empty($planning)){
                $post_status = "future";
                $period_time = (int) $_POST['planning']['period_time'];
                $period_type = sanitize_text_field($_POST['planning']['period_type']);
                $frequency_type = sanitize_text_field($_POST['planning']['frequency_type']);
                if($frequency_type === "static"){
                    $frequency_hours = (int) $_POST['planning']['frequency_hours'];
                    $frequency_minutes = (int) $_POST['planning']['frequency_minutes'];
                }
            }
            else{
                wp_die('Malformed Request', 'Malformed Request', array( 'response' => 400 ));
            }
        }

        $url = 'https://airticle-flow.com/api/projects/'.$projectId.'/articles';

        $token = get_user_meta(get_current_user_id(), 'autoblog-ai_token', true);
        $headers = array(
            'Authorization' => 'Bearer ' . $token
        );


        $response = wp_remote_get($url, array(
            'headers' => $headers,
            'method'  => 'GET'
        ));
        $body = wp_remote_retrieve_body($response);
        $articles = json_decode($body);

        $postIds = [];
        $initialDay = new DateTime();
        foreach ($articles as $index => $article){

            $post_data = array(
                'post_title'    => sanitize_text_field($article->title),
                'post_content'  => wp_kses_post($article->content),
                'post_status'   => $post_status,
                'post_author'   => get_current_user_id(),
            );

            if(!empty($category_id)){
                $post_data['post_category'] = array( $category_id );
            }
            if($post_status === "future"){
                $post_date = $initialDay->modify("+$period_time $period_type");
                if($frequency_type === "static"){
                    $post_date->setTime($frequency_hours, $frequency_minutes);
                }
                else{
                    $randomHours = rand(0, 23);
                    $randomMinutes = rand(0, 59);
                    $post_date->setTime($randomHours, $randomMinutes);
                }
                $post_data['post_date'] = $post_date->format("Y-m-d H:i:s");
            }

            $postIds[] = wp_insert_post( $post_data );

        }
        echo wp_json_encode($postIds);
        wp_die();
    }

    public function addImage(){
        if (!current_user_can('manage_options')) {
            wp_die('You do not have sufficient permissions to access this page.');
        }
        if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash ( $_POST['nonce'] ) ) , 'autoblog-ai-nonce' ) ){
            wp_die('Nonce verification failed!');
        }
        $post_id = (int) $_POST['post_id'];
        $post = get_post($post_id);
        $content = $post->post_content;
        $this->setFeaturedImage($content, $post_id);
    }

    private function setFeaturedImage($html, $post_id){
        if ( ! class_exists('Autoblogai_DomParser') ) {
            require AUTOBLOGAI_PLUGIN_PATH . 'includes/Autoblogai_DomParser.php';
        }
        $domParser = new Autoblogai_DomParser();
        $image_url = $domParser->get_first_img_src($html);
        if(!empty($image_url)){
            $media = media_sideload_image($image_url, $post_id);
            // Check if there was an error sideloading the image.
            if (is_wp_error($media)) {
                return;
            }
            $attachments = get_posts(array(
                'post_type' => 'attachment',
                'numberposts' => 1,
                'post_status' => 'any',
                'post_parent' => $post_id,
                'orderby' => 'post_date',
                'order' => 'DESC'
            ));
            if ($attachments) {
                $attachment_id = $attachments[0]->ID;

                // Set the post thumbnail.
                set_post_thumbnail($post_id, $attachment_id);
            }
        }
    }
}

