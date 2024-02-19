<?php

class SoftwareSales {
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
    }

    public static function plugin_activation(): void
    {
        add_option( 'Activated_SoftwareSales', true );
    }

    public static function plugin_deactivation() {
    }
}