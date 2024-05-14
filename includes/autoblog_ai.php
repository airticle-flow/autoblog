<?php


class AutoblogAi{

    protected $loader;
    protected $plugin_name;
    protected $version;
    public function __construct() {
        if ( defined( 'AUTOBLOGAI_PLUGIN_NAME_VERSION' ) ) {
            $this->version = AUTOBLOGAI_PLUGIN_NAME_VERSION;
        } else {
            $this->version = '1.0.0';
        }
        $this->plugin_name = 'Autoblog-ai';

        $this->load_dependencies();
      //  $this->set_locale();
      //  $this->define_admin_hooks();
      //  $this->define_public_hooks();

    }


    private function load_dependencies() {

        /**
         * The class responsible for orchestrating the actions and filters of the
         * core plugin.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/autoblog_ai_loader.php';



        $this->loader = new AutoblogAI_Loader();

    }

    public function run() {
        $this->loader->run();
    }


    /**
     * The name of the plugin used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     *
     * @since     1.0.0
     * @return    string    The name of the plugin.
     */
    public function get_plugin_name() {
        return $this->plugin_name;
    }

    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     *
     * @since     1.0.0
     * @return    AutoblogAI_Loader    Orchestrates the hooks of the plugin.
     */
    public function get_loader() {
        return $this->loader;
    }

    /**
     * Retrieve the version number of the plugin.
     *
     * @since     1.0.0
     * @return    string    The version number of the plugin.
     */
    public function get_version() {
        return $this->version;
    }
}
