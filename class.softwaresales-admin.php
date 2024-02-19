<?php

if( ! class_exists( 'WP_List_Table' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class SoftwareSales_SerialKey_Table extends WP_List_Table {
    // Define columns for the table
    public function get_columns(): array
    {
        return [
            'id' => __('ID', 'textdomain'),
            'key_text' => __('Serial Key', 'textdomain'),
            'platform' => __('Platform', 'textdomain'),
            'user_order_item_id' => __('Order Item ID', 'textdomain')
        ];
    }

    // Prepare table items
    public function prepare_items(): void
    {
        $columns = $this->get_columns();
        $hidden = []; // You can specify hidden columns if needed
        $sortable = $this->get_sortable_columns(); // Implement this method if you want sortable columns
        $this->_column_headers = [$columns, $hidden, $sortable];

        global $wpdb;
        $table_name = $wpdb->prefix . 'serial_keys';
        $serial_keys = $wpdb->get_results("SELECT * FROM $table_name", ARRAY_A);

        $this->items = $serial_keys;
    }

    // Default column rendering
    public function column_default($item, $column_name) {
        switch ($column_name) {
            case 'id':
            case 'key_text':
            case 'platform':
            case 'user_order_item_id':
                return $item[$column_name];
            default:
                return print_r($item, true); //Show the whole array for troubleshooting purposes
        }
    }
}

class SoftwareSales_Admin {
    private static bool $initiated = false;

    public static function init(): void
    {
        if ( ! self::$initiated ) {
            self::init_hooks();
        }
    }

    public static function init_hooks(): void
    {
        self::$initiated = true;

        add_action( 'admin_init', array( 'SoftwareSales_Admin', 'admin_init' ) );
        add_action('admin_menu', array( 'SoftwareSales_Admin', 'admin_menu' ) );
    }

    public static function admin_init(): void
    {
        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE {$wpdb->prefix}serial_keys (
            id INT NOT NULL AUTO_INCREMENT,
            key_text VARCHAR(255) NOT NULL,
            platform VARCHAR(128) NOT NULL,
            user_order_item_id INT DEFAULT NULL,
            PRIMARY KEY (id),
            UNIQUE (key_text)
        ) $charset_collate;";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );
    }

    public static function admin_menu(): void
    {
        add_menu_page(
            'Serial Keys',
            'Serial Keys',
            'manage_options',
            'software-sales-serial-keys',
            false,
            'dashicons-admin-network'
            // plugin_dir_url(__FILE__) . 'images/icon_wporg.png'
        );

        add_submenu_page(
            'software-sales-serial-keys',
            'Serial Keys',
            'All Serial Keys',
            'manage_options',
            'software-sales-serial-keys',
            'software_sales_serial_keys_index'
        );

        add_submenu_page(
            'software-sales-serial-keys',
            'Add New Serial Key',
            'Add New Serial Key',
            'manage_options',
            'software-sales-serial-keys-new',
            'software_sales_serial_keys_create'
        );

        function software_sales_serial_keys_index(): void
        {
            $listTable = new SoftwareSales_SerialKey_Table();
            $listTable->prepare_items();
            ?>
            <div class="wrap">
                <h1 class="wp-heading-inline">
                    <?php echo esc_html( get_admin_page_title() ); ?>
                </h1>

                <?php
                printf(
                    '<a href="%1$s" class="page-title-action">%2$s</a>',
                    esc_url( admin_url( 'admin.php?page=software-sales-serial-keys-new' ) ),
                    esc_html__( 'Add New Serial Key' )
                );

                $listTable->display();
                ?>
            </div>
            <?php
        }

        function software_sales_serial_keys_create(): void
        {
            ?>
            <div class="wrap">
                <h1 class="wp-heading-inline">
                    <?php echo esc_html( get_admin_page_title() ); ?>
                </h1>
            </div>
            <?php
        }
    }
}