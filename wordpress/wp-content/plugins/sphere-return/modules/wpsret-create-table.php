<?php
/**
 * Created by PhpStorm.
 * User: WOLF
 * Date: 11/17/2019
 * Time: 1:53 AM
 */


add_action('init', 'create_returns_table');

function create_returns_table()
{
    global $wpdb;
    $oldVersion = get_option('wpsret')['version'];
    $newVersion = WPSRET_VERSION;
//    if (!(version_compare($oldVersion, $newVersion) < 0)) {
//        return FALSE;
//    }
    $charset_collate = $wpdb->get_charset_collate();
    $table_name = $wpdb->prefix . 'return';
    $sql = "CREATE TABLE $table_name (
             id int(11) NOT NULL AUTO_INCREMENT,
        `name` varchar(250) NOT NULL,
      `email` varchar(250) NOT NULL,
         `order` varchar(250) NOT NULL,
      `action` varchar(250) NOT NULL,
         `return` varchar(250) NOT NULL,
      `replacement` varchar(250) NOT NULL,
            `created_at` varchar(250) DEFAULT NULL,
       PRIMARY KEY (`id`)
        ) $charset_collate;";
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
    update_option('wpsret', array('version' => $newVersion));
}
//if($wpdb->get_var("show tables like '$table_name'") != $table_name)
