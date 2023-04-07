<?php
/**
 * Plugin Name: digikala affiliate
 * Plugin URI: https://mrrashidpour.ir/digi_affidigiaffi/
 * Description: By joining the affiliate system of DigiKala with this plugin, you can easily become a sales associate of DigiKala.
 * Version: 1.1.0
 * Author: Mohammadreza Rashidpour
 * Author URI: https://mrrashidpour.ir/
 * Text Domain: mrra_digi_affiliate
 * Domain Path: /languages
 * WC requires at least: 5.0.0
 * Requires PHP: 7.4
 *
 */

defined( 'ABSPATH' ) || exit;

load_plugin_textdomain('mrra_digi_affiliate');
define("digi_affi_IMG_URL", plugin_dir_url(__FILE__) . "/img/");
register_activation_hook(__FILE__, 'digi_affiInstall');
register_deactivation_hook(__FILE__, 'digi_affiDelete');

add_action("plugin_loaded" , function ()
{
    load_plugin_textdomain( 
        'mrra_digi_affiliate',
        false,
        dirname(plugin_basename(__FILE__)).'/languages'
    );
});

function menu_digi_affi() {
    load_plugin_textdomain('mrra_digi_affiliate');
    add_menu_page(__('digikala affiliate', 'mrra_digi_affiliate'), __('digikala affiliate', 'mrra_digi_affiliate'), 'manage_options', basename(__FILE__), 'digi_affiPreferences', digi_affi_IMG_URL . "logo-m.png");
}
add_action('admin_menu', 'menu_digi_affi');
function digi_affi_validate($a) {
    return $a;
}
add_action('admin_init', 'digi_affi_register_settings');
function digi_affi_register_settings() {
    register_setting('digi_affi_widget_id', 'digi_affi_widget_id', 'digi_affi_validate');
}
add_action('admin_post_wp_save_digi_affi', 'wp_save_digi_affi');
add_action('admin_post_nopriv_wp_save_digi_affi', 'wp_save_digi_affi');
add_action('wp_head', 'digi_affiAppend', 100000);

function digi_affiInstall() {
    return digi_affi::getInstance()->install();
}
function digi_affiDelete() {
    return digi_affi::getInstance()->delete();
}
function digi_affiAppend() {
    echo digi_affi::getInstance()->append(digi_affi::getInstance()->getId());
}
function digi_affiPreferences() {
    if (isset($_POST["widget_id"])) {
        digi_affi::getInstance()->save();
    }
    load_plugin_textdomain('mrra_digi_affiliate');
    echo digi_affi::getInstance()->render();
}
function wp_save_digi_affi() {
    $digi_affiError = null;
    if (trim($_POST['submit']) !== '' && wp_verify_nonce( $_POST['_wpnonce'], 'digi_affi_nonce'.get_current_user_id())) {
        $g_id = trim(sanitize_text_field($_POST['widget_id']));
        if ($g_id !== '') {

            if (preg_match("/https:\/\/migmig\.affilio\.ir\/api\/v1\/Click\/b\/[a-zA-Z0-9\-\.\/^?\%\=\&]+\{YOUR_BASE64_ENCODED_URL\}/", $g_id)) {

                if (get_option('digi_affi_widget_id') !== false) {
                    update_option('digi_affi_widget_id', $g_id);
                } else {
                    add_option('digi_affi_widget_id', $g_id, null, 'no');
                }
                $digi_affi = digi_affi::getInstance();
                $digi_affi->install();
                // Clear WP Rocket Cache if needed
                if (function_exists("rocket_clean_domain")) {
                    rocket_clean_domain();
                }
                // Clear WP Super Cache if needed
                if (function_exists("wp_cache_clean_cache")) {
                    global $file_prefix;
                    wp_cache_clean_cache($file_prefix, true);
                }        

            } else {
                $digi_affiError = __('The ID is invalid.', 'mrra_digi_affiliate');
            }
        } else {
            $digi_affiError =  __('The address cannot be empty.', 'mrra_digi_affiliate');
        }
        if($digi_affiError != null){
            set_transient('error_digi_affi', $digi_affiError);
        }else{
            set_transient('success_digi_affi', __('Saved successfully.', 'mrra_digi_affiliate'));
        }

    }
    wp_redirect($_SERVER['HTTP_REFERER']);
    exit();
}

class digi_affi {
    protected static $instance;

    private function __construct()
    {
        $this->widget_id = get_option('digi_affi_widget_id');
    }

    private $widget_id = '';

    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new digi_affi();
        }
        return self::$instance;
    }
    public function install()
    {
        if (!$this->widget_id) {
            if (($out = get_option('digi_affi_widget_id')) !== false) {
                $this->widget_id = $out;
            }
        }
        $this->save();
    }
    public function delete()
    {
        delete_transient('error_digi_affi');
        if (get_option('digi_affi_widget_id') !== false) {
            delete_option('digi_affi_widget_id');
        }
    }

    public function getId()
    {
        return $this->widget_id;
    }
    public function render()
    {
        $widget_id = $this->widget_id;
        require_once "setting.php";
    }
    public function append($widget_id = false)
    {

        if ($widget_id) {
            define( 'digiaffdigi_affi', $widget_id);

            

            function chenge_ferst_url($val)
            {
                $digibase64 = base64_encode($val[0]);                

                $content_new = str_replace('{YOUR_BASE64_ENCODED_URL}',$digibase64,digiaffdigi_affi);
               return $content_new;
            }


            /* Start chenge Url content */
            
            function link_words($content){

                function convertURLs($string)
                {
                    $url = '/(http|https|ftp|ftps)\:\/\/(www\.)*digikala\.com\/[a-zA-Z0-9\-\.\/^?\%\=\&]+/';   
                    return preg_replace_callback($url,'chenge_ferst_url', $string);
                }
  

                return convertURLs($content);
            }
            add_filter('the_content', 'link_words');
            add_filter('the_excerpt', 'link_words');
            
            /* End chenge Url content */
        }
    }

    public function save() {
        update_option('digi_affi_widget_id', $this->widget_id);
    }

}

?>