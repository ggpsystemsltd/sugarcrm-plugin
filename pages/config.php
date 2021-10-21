<?php
$t_db_hostname = plugin_config_get( 'db_hostname' );
$t_db_username = plugin_config_get( 'db_username' );
$t_db_password = plugin_config_get( 'db_password' );
$t_db_database = plugin_config_get( 'db_database' );
?>

<form action="<?php echo plugin_page( 'config_update' )?>" method="post">
    <?php echo form_security_field( 'plugin_SugarCRM_config_update' ) ?>
    <label>
        Database Host:
        <input name="db_hostname" value="<?php echo string_attribute( $t_db_hostname ) ?>" />
    </label>
    <br>
    <label>
        Database Username:
        <input name="db_username" value="<?php echo string_attribute( $t_db_username ) ?>" />
    </label>
    <br>
    <label>
        Database Password:
        <input name="db_password" type="password" value="<?php echo string_attribute( $t_db_password ) ?>" />
    </label>
    <br>
    <label>
        Database Name:
        <input name="db_database" value="<?php echo string_attribute( $t_db_database ) ?>" />
    </label>
    <br>
    <label>
        Reset
        <input type="checkbox" name="reset" />
    </label>
    <br>
    <input type="submit">
</form>
