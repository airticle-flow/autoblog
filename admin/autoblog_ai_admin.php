<?php

class AutoblogAiAdmin{


    public function run(){
        add_action('admin_enqueue_scripts', [$this,"admin_scripts"]);
        add_action( 'admin_menu', [$this,'autoblogai_admin_page'] );
        add_action('wp_ajax_save_token', [$this,'save_token']);
        add_action('wp_ajax_revoke_token', [$this,'revoke_token']);
        add_action('wp_ajax_generate_articles', [$this,'generate_articles']);
    }


    public function autoblogai_admin_page(){
        add_menu_page(
            'Autoblog-ai',
            'Autoblog-ai',
            'manage_options',
            'autoblog-ai',
            [$this,'display_main_admin_page'],
            '',
            20
        );

        add_submenu_page(
            'autoblog-ai',
            'Token setting',
            'Token setting',
            'manage_options',
            'autoblog-ai-token-settings',
            [$this, 'display_token_page']
        );
    }

    public function display_main_admin_page(){
        require plugin_dir_path(__FILE__) . 'partials/main_menu.php';

    }

    public function display_token_page(){
        require plugin_dir_path(__FILE__) . 'partials/token.php';
    }

    public function admin_scripts(){
        wp_enqueue_script('jquery');

        wp_enqueue_script("tailwind", "https://cdn.tailwindcss.com");
        $script_url = plugins_url('js/autoblog-ai.js', __FILE__);
        wp_enqueue_script("autoblog_main", $script_url, array('jquery'));
        wp_localize_script('autoblog_main', 'wp_vars', array(
            'ajax_url' => admin_url('admin-ajax.php')
        ));
    }

    public function save_token(){
        $token = sanitize_text_field($_POST['token']);
        add_user_meta(get_current_user_id(), 'autoblog-ai_token', $token, true);
        wp_die();
    }

    public function revoke_token(){

        delete_user_meta(get_current_user_id(), 'autoblog-ai_token');
        wp_die();
    }

    public function generate_articles(){
        if ( ! class_exists('SimpleCurl') ) {
            require AUTOBLOG_AI_PLUGIN_PATH . 'includes/Client.php';
        }
        $prompt = sanitize_text_field($_POST['prompt']);
        $client = new Client("http://dev.dragnsurvey.com/", get_user_meta(get_current_user_id(), 'autoblog-ai_token', true));
        $postData = ['prompt' => $prompt, 'quantity' => 1];
        $response = $client->post('api/articles', $postData);
        var_dump($response);
        echo json_encode($response);
        wp_die();
    }
}

