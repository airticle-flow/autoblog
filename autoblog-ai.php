<?php

/**
 * Autoblog-ai
 *
 * @package           Autoblog-ai
 * @author            Roman STEC
 * @copyright         2023 Roman STEC
 * @license           GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       Autoblog-ai
 * Plugin URI:        https://airticle-flow.com
 * Description:       Import AIrticle projects and publish associated articles
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Roman STEC
 * Text Domain:       AIrticle-flow
 * License:           GPL v2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}


if (!defined('AUTOBLOGAI_PLUGIN_PATH')) {
    define('AUTOBLOGAI_PLUGIN_PATH', plugin_dir_path(__FILE__));
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
const AUTOBLOGAI_PLUGIN_NAME_VERSION = '1.0.0';

register_activation_hook(
    __FILE__,
    'autoblogai_activate'
);
register_deactivation_hook( __FILE__, 'autoblogai_deactivate' );

function autoblogai_activate(){

}

function autoblogai_deactivate(){

}


require plugin_dir_path( __FILE__ ) . 'includes/autoblog_ai.php';


function autoblogai_run_autoblog_ai(){
    $autoblogAi = new AutoblogAi();
    $autoblogAi->run();
}

autoblogai_run_autoblog_ai();
