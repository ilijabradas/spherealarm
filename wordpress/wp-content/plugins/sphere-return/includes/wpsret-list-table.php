<?php
/**
 * Created by PhpStorm.
 * User: WOLF
 * Date: 11/21/2019
 * Time: 4:09 AM
 */
if (!class_exists('WP_List_Table')) { //check for required class
    require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
}

class Return_List_Table extends WP_List_Table
{

    /**
     * This is the method to get data which is to displayed
     *
     * @return mixed
     */
    function get_data()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'return';

        /* If the value is not NULL, do a search for it. */
        $search = $_POST['s'];
        if( isset($search) ){
            // Trim Search Term
            $search = trim($search);

            /* Notice how you can search multiple columns for your search term easily, and return one data set */
            $results = $wpdb->get_results($wpdb->prepare("SELECT * FROM ".$wpdb->prefix."return WHERE `name` LIKE '%%%s%%'
             OR `email` LIKE '%%%s%%' OR `order` LIKE '%%%s%%' OR `action` LIKE '%%%s%%' OR `return` LIKE '%%%s%%'",
                $search, $search, $search, $search, $search), ARRAY_A);
        }
        else {
            /* Here is your normal data query inside of the prepare_items() method */
            $results = $wpdb->get_results("SELECT * FROM $table_name", ARRAY_A);
        }
        return $results;
    }

    /**
     * This method creates respective column labels on top and bottom of our admin table.
     * Here id , name etc are our database table column names.
     * @return array
     */
    function get_columns()
    {
        $columns = array(
            'id' => 'ID',
            'name' => 'Name',
            'email' => 'Email',
            'order' => 'Order',
            'action' => 'Action',
            'return' => 'Return Reason',
            'replacement' => 'Wanted Product',
            'created_at' => 'Created At'
        );
        return $columns;
    }

    /**
     * Initially this method creates two arrays ($hidden,$sortable) for controlling the overall behavior of table.
     * Finally this method assigns the data (get_data()) to the class data representation variable items.
     */
    function prepare_items()
    {
        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();

        $data = $this->get_data();
        usort($data, array(&$this, 'usort_reorder'));
        $perPage = 10;
        $currentPage = $this->get_pagenum();
        $totalItems = count($data);
        $this->set_pagination_args(array(
            'total_items' => $totalItems,
            'per_page' => $perPage
        ));
        $data = array_slice($data, (($currentPage - 1) * $perPage), $perPage);
        $this->_column_headers = array($columns, $hidden, $sortable);
        $this->items = $data;
        $this->process_bulk_action();

    }

    /**
     * WordPress looks for methods called column_{key_name} , before actually displaying each column.
     * But there is an other method for every defined column.
     * This eliminate the need to create method for every column.The column_default will process any column.
     * @param object $item
     * @param string $column_name
     * @return mixed|void
     */
    function column_default($item, $column_name)
    {
        switch ($column_name) {
            case 'id':
            case 'name':
            case 'email':
            case 'order':
            case 'action':
            case 'return':
            case 'replacement':
            case 'created_at':
                return "<strong>".$item[$column_name]."</strong>";
            default:
                return print_r($item, true); //Show the whole array for troubleshooting purposes
        }
    }

    function get_sortable_columns()
    {
        $sortable_columns = array(
            'name' => array('name', false),
            'email' => array('email', false),
            'order' => array('order', false),
            'action' => array('action', false),
            'return' => array('return', false),
            'created_at' > array('created_at', false)
        );
        return $sortable_columns;
    }

    function usort_reorder($a, $b)
    {
       // If no sort, default to title
        $orderby = (!empty($_GET['orderby'])) ? $_GET['orderby'] : 'name';
      // If no order, default to asc
        $order = (!empty($_GET['order'])) ? $_GET['order'] : 'asc';
      // Determine sort order
        $result = strcmp($a[$orderby], $b[$orderby]);
       // Send final sort direction to usort
        return ($order === 'asc') ? $result : -$result;
    }

    function column_id($item)
    {
        $actions = array(
            'delete' => sprintf('<a href="?page=%s&action=%s&id=%s">Delete</a>', $_REQUEST['page'], 'delete', $item['id']),
        );
        return sprintf('%1$s %2$s', $item['id'], $this->row_actions($actions));
    }

//    function get_bulk_actions()
//    {
//        $actions = array(
//            'delete' => 'Delete'
//        );
//        return $actions;
//    }

    function column_cb($item)
    {
        return sprintf(
            '<input type="checkbox" name="id[]" value="%s" />', $item['id']
        );
    }

    function process_bulk_action()
    {

        global $wpdb;
        $table_name = $wpdb->prefix . "return";

        if ('delete' === $this->current_action()) {

            $ids = isset($_REQUEST['id']) ? $_REQUEST['id'] : array();
            if (is_array($ids)) $ids = implode(',', $ids);

            if (!empty($ids)) {
                $wpdb->query("DELETE FROM $table_name WHERE id IN($ids)");
            }

        }
    }

    function extra_tablenav($which)
    {
        $ajax_url = admin_url('admin-ajax.php?action=csv_pull_returns');
        if ($which == "top") {
            echo '<a style="line-height: 2; padding: .2em; text-decoration: none;" href=' . $ajax_url . '>Export Excel XML</a>';
        }
    }

}
