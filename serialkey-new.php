<?php
?>

<div class="wrap">
    <h1 id="add-new-user">
        <?php
        if ( current_user_can( 'create_users' ) ) {
            _e( 'Add New User' );
        } elseif ( current_user_can( 'promote_users' ) ) {
            _e( 'Add Existing User' );
        }
        ?>
    </h1>
</div>
