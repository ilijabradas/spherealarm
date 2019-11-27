<?php
/**
 * Created by PhpStorm.
 * User: WOLF
 * Date: 11/17/2019
 * Time: 1:53 AM
 */


add_action('init', 'create_registration_table');

function create_registration_table()
{
    global $wpdb;
    $oldVersion = get_option('wpsr')['version'];
    $newVersion = WPSR_VERSION;
//    if (!(version_compare($oldVersion, $newVersion) < 0)) {
//        return FALSE;
//    }
    $charset_collate = $wpdb->get_charset_collate();
    $table_name = $wpdb->prefix . 'registration';
    $sql = "CREATE TABLE $table_name (
             id int(11) NOT NULL AUTO_INCREMENT,
        `name` varchar(250) NOT NULL,
      `street` varchar(250) NOT NULL,
         `city` varchar(250) NOT NULL,
      `state` varchar(250) NOT NULL,
         `zip` varchar(250) NOT NULL,
      `phone` varchar(250) NOT NULL,
         `id_number` varchar(250) NOT NULL,
      `usage` varchar(250) NOT NULL,
         `entries` varchar(250) NOT NULL,
      `reason` varchar(250) NOT NULL,
         `people` varchar(250) NOT NULL,
      `other` varchar(250) DEFAULT NULL,
       `created_at` varchar(250) DEFAULT NULL,
       PRIMARY KEY (`id`)
        ) $charset_collate;";
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
    update_option('wpsr', array('version' => $newVersion));
}
//if($wpdb->get_var("show tables like '$table_name'") != $table_name)
