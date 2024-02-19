<?php

use JetBrains\PhpStorm\NoReturn;

include(plugin_dir_path(__FILE__) . 'tables/class.serialkey-table.php');

include( plugin_dir_path( __FILE__ ) . 'views/admin/serialkey-index.php');
include( plugin_dir_path( __FILE__ ) . 'views/admin/serialkey-new.php');

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

        add_action('admin_post_add_serial_key', array( 'SoftwareSales_Admin', 'handle_add_serial_key' ));
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
            'software_sales_serial_keys_new'
        );
    }

    #[NoReturn] public static function handle_add_serial_key(): void
    {
        // Verify nonce here if you decide to use one for security
        if (!isset($_POST['add_serial_key_nonce']) || !wp_verify_nonce($_POST['add_serial_key_nonce'], 'add_serial_key_action')) {
            // Nonce verification failed, handle the error accordingly.
            wp_die('Security check failed.');
        }

        // Sanitize and validate input data
        $key_text = sanitize_text_field($_POST['key_text']);
        $platform = sanitize_text_field($_POST['platform']);
        $user_order_item_id = sanitize_text_field($_POST['user_order_item_id']);

        // Convert user_order_item_id to NULL if it is 0 or less
        $user_order_item_id = intval($user_order_item_id) <= 0 ? NULL : $user_order_item_id;

        // Insert into database (Assuming global $wpdb is used and your table structure)
        global $wpdb;
        $table_name = $wpdb->prefix . 'serial_keys';
        $data = [
            'key_text' => $key_text,
            'platform' => $platform,
            'user_order_item_id' => $user_order_item_id,
        ];
        // Update the format array to handle NULL for user_order_item_id
        $format = ['%s', '%s', $user_order_item_id === NULL ? NULL : '%d']; // Use '%d' for integers, NULL for actual NULL values

        $wpdb->insert($table_name, $data, $format);

        $redirect_url = admin_url('admin.php?page=software-sales-serial-keys');
        wp_redirect($redirect_url);
        exit;
    }
}