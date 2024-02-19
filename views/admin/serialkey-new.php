<?php

function software_sales_serial_keys_new(): void
{
    ?>
    <div class="wrap">
        <h1 class="wp-heading-inline">
            <?php echo esc_html( get_admin_page_title() ); ?>
        </h1>

        <div>
            <form method="post" action="<?php echo esc_html( admin_url('admin-post.php') ); ?>">
                <input type="hidden" name="action" value="add_serial_key">

                <table class="form-table">
                    <tbody>
                    <tr>
                        <th scope="row"><label for="key_text">Serial Key (required)</label></th>
                        <td><input name="key_text" id="key_text" type="text" class="regular-text" required></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="platform">Platform (required)</label></th>
                        <td>
                            <select name="platform" id="platform" required>
                                <option value="">Select Platform</option>
                                <option value="Steam">Steam</option>
                                <option value="EGS">Epic Games Store</option>
                                <option value="GOG">GOG</option>
                                <option value="Other">Other</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="user_order_item_id">Order Item ID</label></th>
                        <td><input name="user_order_item_id" id="user_order_item_id" type="number" class="regular-text"></td>
                    </tr>
                    </tbody>
                </table>

                <?php wp_nonce_field('add_serial_key_action', 'add_serial_key_nonce'); ?>
                <?php submit_button('Add Serial Key'); ?>
            </form>
        </div>
    </div>
    <?php
}