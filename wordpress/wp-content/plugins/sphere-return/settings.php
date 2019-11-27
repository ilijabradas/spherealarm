<?php
/**
 * Created by PhpStorm.
 * User: WOLF
 * Date: 11/16/2019
 * Time: 11:45 PM
 */
require_once WPSRET_PLUGIN_DIR . '/includes/wpsret-list-table.php';
require_once WPSRET_PLUGIN_DIR . '/includes/wpsret-model.php';


class WPSRET
{

    public static function load_modules()
    {

        self::load_module('wpsret-create-table');
        self::load_module('wpsret-rest-api');

    }

    protected static function load_module($mod)
    {
        $dir = WPSRET_PLUGIN_MODULES_DIR;

        if (empty($dir) or !is_dir($dir)) {
            return false;
        }

        $file = path_join($dir, $mod . '.php');

        if (file_exists($file)) {
            include_once $file;
        }
    }

}

add_action('plugins_loaded', 'wpsret', 10, 0);

function wpsret()
{
    WPSRET::load_modules();
}

add_action('init', 'wpsret_init', 10, 0);

function wpsret_init()
{
    do_action('wpsret_init');
}

function return_admin_menu()
{

    add_menu_page('Return', 'Return', 'manage_options', 'wpsret', 'return_page_handler', 'dashicons-groups', 2);
}

add_action('admin_menu', 'return_admin_menu');

/**
 * Here we create an instance of our class, prepare the items and call display() to display the table.
 */
function return_page_handler()
{
    if (!current_user_can('manage_options')) {
        wp_die(__('You do not have sufficient permissions to access this page.'));
    }
    echo '<div class="wrap">';
    echo '<form method="post">';
    echo '<input type="hidden" name="page" value="wpsret" />';
    echo '<h1 class="wp-heading-inline">Returns Data</h1>';
    $obj = new Return_List_Table;
    $obj->prepare_items();
    $obj->search_box('Search Returns', 'return');
    $obj->display();
    echo '</form>';
    echo '</div>';
}

function cleanReturnData(&$str)
{
    $str = preg_replace("/\t/", "\\t", $str);
    $str = preg_replace("/\r?\n/", "\\n", $str);
    if (strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
}

function csv_pull_wpsret()
{
    global $wpdb;

    $data = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}return;", ARRAY_A);

    $filename = "return_data_" . date('Ymd') . ".xls";

    header("Content-Disposition: attachment; filename=\"$filename\"");
    header("Content-Type: application/vnd.ms-excel");

    $flag = false;
    foreach ($data as $row) {
        if (!$flag) {
            // display field/column names as first row
            echo implode("\t", array_keys($row)) . "\r\n";
            $flag = true;
        }
        array_walk($row, __NAMESPACE__ . '\cleanReturnData');
        echo implode("\t", array_values($row)) . "\r\n";
    }
    exit;
}

add_action('wp_ajax_csv_pull_returns', 'csv_pull_wpsret');
