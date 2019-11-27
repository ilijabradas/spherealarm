<?php

/**
 * Created by PhpStorm.
 * User: WOLF
 * Date: 11/17/2019
 * Time: 2:22 AM
 */
class WPSRET_Model
{

    static $primary_key = 'id';

    private static function _table()
    {
        global $wpdb;
        $tablename = 'return';
        return $wpdb->prefix . $tablename;
    }

    private static function _fetch_by_id($value)
    {
        global $wpdb;
        $sql = sprintf('SELECT * FROM %s WHERE %s = %%s', self::_table(), static::$primary_key);
        return $wpdb->prepare($sql, $value);
    }

    private static function _fetch_all($value)
    {
        global $wpdb;
        $sql = sprintf('SELECT * FROM %s', self::_table());
        return $wpdb->prepare($sql, $value);
    }

    static function getById($value)
    {
        global $wpdb;
        return $wpdb->get_row(self::_fetch_by_id($value));
    }

    static function getAll()
    {
        global $wpdb;
        return $wpdb->get_results(self::_fetch_all());
    }

    static function insert($data)
    {
        global $wpdb;
        $wpdb->insert(self::_table(), $data);
    }

    static function update($data, $where)
    {
        global $wpdb;
        $wpdb->update(self::_table(), $data, $where);
    }

    static function delete($value)
    {
        global $wpdb;
        $sql = sprintf('DELETE FROM %s WHERE %s = %%s', self::_table(), static::$primary_key);
        return $wpdb->query($wpdb->prepare($sql, $value));
    }

    static function insert_id()
    {
        global $wpdb;
        return $wpdb->insert_id;
    }

    static function time_to_date($time)
    {
        return gmdate('Y-m-d H:i:s', $time);
    }

    static function now()
    {
        return self::time_to_date(time());
    }

    static function date_to_time($date)
    {
        return strtotime($date . ' GMT');
    }

}
