<?php

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