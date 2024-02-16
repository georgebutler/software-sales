<?php

class SoftwareSales {
    private static $initiated = false;

    public static function init() {
        if ( ! self::$initiated ) {
            self::init_hooks();
        }
    }

    public static function init_hooks() {
        self::$initiated = true;
    }

    public static function plugin_activation() {
        add_option( 'Activated_SoftwareSales', true );
    }

    public static function plugin_deactivation() {
    }
}