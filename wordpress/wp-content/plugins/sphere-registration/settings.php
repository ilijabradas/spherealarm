<?php
/**
 * Created by PhpStorm.
 * User: WOLF
 * Date: 11/16/2019
 * Time: 11:45 PM
 */
require_once WPSR_PLUGIN_DIR . '/includes/wpsr-list-table.php';
require_once WPSR_PLUGIN_DIR . '/includes/wpsr-model.php';


class WPSR
{

    public static function load_modules()
    {

        self::load_module('wpsr-create-table');
        self::load_module('wpsr-rest-api');

    }

    protected static function load_module($mod)
    {
        $dir = WPSR_PLUGIN_MODULES_DIR;

        if (empty($dir) or !is_dir($dir)) {
            return false;
        }

        $file = path_join($dir, $mod . '.php');

        if (file_exists($file)) {
            include_once $file;
        }
    }

}

add_action('plugins_loaded', 'wpsr', 10, 0);

function wpsr()
{
    WPSR::load_modules();
}

add_action('init', 'wpsr_init', 10, 0);

function wpsr_init()
{
    do_action('wpsr_init');
}

function registration_admin_menu()
{

    $hook =  add_menu_page('Registration', 'Registration', 'manage_options', 'wpsr', 'registration_page_handler', 'dashicons-groups', 2);
     // This only displays the option field and apply button, saving and loading the data has to be defined separately.
     // WordPress provides a filter called set-screen-option to take care of this:
    add_action( "load-$hook", 'add_options' );
}

add_action('admin_menu', 'registration_admin_menu');

//Adding the checkboxes for hiding/showing the columns is done by WordPress automatically.
// You just have to make sure that your derived class is instantiated before the screen option panel
// is rendered so that the parent class can retrieve the column names.
// To accomplish this the corresponding code is moved into the method add_options():
function add_options() {
    global $obj;
    $option = 'per_page';
    $args = array(
        'label' => 'Records',
        'default' => 10,
        'option' => 'records_per_page'
    );
    add_screen_option( $option, $args );

    $obj = new Registration_List_Table;
}

add_filter('set-screen-option', 'wpsr_set_option', 10, 3);

//The option is stored in the table usermeta in the database so each user has his own setting.
//The first line tells WordPress to call the ‘wpsr_set_option’ function when it is applying the ‘set-screen-options’ filters,
// with a (default) priority of 10, and that our function will expect 3 parameters to be passed to it (the default is only 1 for add_filter).

//The function wpsr_set_option checks if the option that WordPress is processing is our ‘records_per_page’ option.
// If it is our option, we return the value so that WordPress will save it to the database.
function wpsr_set_option($status, $option, $value) {
    if ( 'records_per_page' == $option ) return $value;
    return $status;
}
/**
 * Here we create an instance of our class, prepare the items and call display() to display the table.
 */
function registration_page_handler()
{
    if (!current_user_can('manage_options')) {
        wp_die(__('You do not have sufficient permissions to access this page.'));
    }
    echo '<div class="wrap">';
    echo '<form method="post">';
    echo '<input type="hidden" name="page" value="wpsr" />';
    echo '<h1 class="wp-heading-inline">Registration Data</h1>';
    $obj = new Registration_List_Table;
    $obj->prepare_items();
    $obj->search_box('Search Registration', 'registration');
    $obj->display();
    echo '</form>';
    echo '</div>';
}

function cleanData(&$str)
{
    $str = preg_replace("/\t/", "\\t", $str);
    $str = preg_replace("/\r?\n/", "\\n", $str);
    if (strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
}

function csv_pull_wprs()
{
    global $wpdb;

    $data = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}registration;", ARRAY_A);

    $filename = "registration_data_" . date('Ymd') . ".xls";

    header("Content-Disposition: attachment; filename=\"$filename\"");
    header("Content-Type: application/vnd.ms-excel");

    $flag = false;
    foreach ($data as $row) {
        if (!$flag) {
            // display field/column names as first row
            echo implode("\t", array_keys($row)) . "\r\n";
            $flag = true;
        }
        array_walk($row, __NAMESPACE__ . '\cleanData');
        echo implode("\t", array_values($row)) . "\r\n";
    }
    exit;
}

add_action('wp_ajax_csv_pull', 'csv_pull_wprs');

//$special = array('_title', 'cb', 'comment', 'media', 'name', 'title', 'username', 'blogname');
//avoid some strings as keynames since they are treated by WordPress specially
