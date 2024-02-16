<?php

class SoftwareSales_Admin {
    private static $initiated = false;

    public static function init() {
        if ( ! self::$initiated ) {
            self::init_hooks();
        }
    }

    public static function init_hooks() {
        self::$initiated = true;

        add_action( 'admin_init', array( 'SoftwareSales_Admin', 'admin_init' ) );
        add_action('admin_menu', array( 'SoftwareSales_Admin', 'admin_menu' ) );
    }

    public static function admin_init() {
        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE {$wpdb->prefix}serial_keys (
            id int NOT NULL AUTO_INCREMENT,
            key_text TEXT NOT NULL,
            platform VARCHAR(128) NOT NULL,
            user_order_item_id INT DEFAULT NULL,
            PRIMARY KEY  (id)
        ) $charset_collate;";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );
    }

    public static function admin_menu() {
        add_menu_page(
            'Software Sales',
            'Software Sales',
            'manage_options',
            'software-sales',
            'software_sales_settings_page',
            'dashicons-desktop'
            // plugin_dir_url(__FILE__) . 'images/icon_wporg.png'
        );

        add_submenu_page(
            'software-sales',
            'Serial Keys',
            'Serial Keys',
            'manage_options',
            'my-plugin-serial-keys',
            'software_sales_serial_keys_page'
        );

        add_submenu_page(
            'software-sales',
            'Products',
            'Products',
            'manage_options',
            'my-plugin-products',
            'software_sales_products_page'
        );

        add_submenu_page(
            'software-sales',
            'Orders',
            'Orders',
            'manage_options',
            'my-plugin-orders',
            'software_sales_orders_page'
        );

        function software_sales_settings_page(){
            ?>
            <div class="wrap">
                <h1 class="wp-heading-inline">
                    <?php echo esc_html( get_admin_page_title() ); ?>
                </h1>
            </div>
            <?php
        }

        function software_sales_serial_keys_page(){
            ?>
            <div class="wrap">
                <h1 class="wp-heading-inline">
                    <?php echo esc_html( get_admin_page_title() ); ?>
                </h1>

                <?php
                printf(
                    '<a href="%1$s" class="page-title-action">%2$s</a>',
                    esc_url( admin_url( 'user-new.php' ) ),
                    esc_html__( 'Add New User' )
                );
                ?>
            </div>
            <?php
        }

        function software_sales_products_page() {
            ?>
            <div class="wrap">
                <h1 class="wp-heading-inline">
                    <?php echo esc_html( get_admin_page_title() ); ?>
                </h1>

                <?php
                printf(
                    '<a href="%1$s" class="page-title-action">%2$s</a>',
                    esc_url( admin_url( 'user-new.php' ) ),
                    esc_html__( 'Add New User' )
                );
                ?>
            </div>
            <?php
        }

        function software_sales_orders_page() {
            ?>
            <div class="wrap">
                <h1 class="wp-heading-inline">
                    <?php echo esc_html( get_admin_page_title() ); ?>
                </h1>

                <?php
                printf(
                    '<a href="%1$s" class="page-title-action">%2$s</a>',
                    esc_url( admin_url( 'user-new.php' ) ),
                    esc_html__( 'Add New User' )
                );
                ?>
            </div>
            <?php
        }
    }
}