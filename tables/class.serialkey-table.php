<?php

if( ! class_exists( 'WP_List_Table' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class SoftwareSales_SerialKey_Table extends WP_List_Table {
    public function get_columns(): array
    {
        return [
            'id' => __('ID'),
            'key_text' => __('Serial Key'),
            'platform' => __('Platform'),
            'user_order_item_id' => __('Order Item ID')
        ];
    }

    public function column_default($item, $column_name) {
        return match ($column_name) {
            'id', 'key_text', 'platform', 'user_order_item_id' => $item[$column_name],
            default => print_r($item, true),
        };
    }

    protected function get_sortable_columns(): array
    {
        return [
            'platform' => ['platform', false] // False means it's sorted ascending initially
        ];
    }

    public function prepare_items(): void
    {
        $columns = $this->get_columns();
        $hidden = [];
        $sortable = $this->get_sortable_columns();
        $this->_column_headers = [$columns, $hidden, $sortable];

        global $wpdb;
        $table_name = $wpdb->prefix . 'serial_keys';

        // Sorting
        $orderby = (!empty($_GET['orderby'])) ? $_GET['orderby'] : 'id'; // Default order by 'id'
        $order = (!empty($_GET['order'])) ? $_GET['order'] : 'asc'; // Default order direction
        $sql = "SELECT * FROM $table_name ORDER BY $orderby $order";

        $serial_keys = $wpdb->get_results($sql, ARRAY_A);

        $this->items = $serial_keys;
    }
}