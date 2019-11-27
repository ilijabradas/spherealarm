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

    add_menu_page('Registration', 'Registration', 'manage_options', 'wpsr', 'registration_page_handler', 'dashicons-groups', 2);
}

add_action('admin_menu', 'registration_admin_menu');

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
