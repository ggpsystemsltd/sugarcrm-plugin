<?php
form_security_validate( 'plugin_SugarCRM_config_update' );

$f_db_hostname = gpc_get_string( 'db_hostname' );
$f_db_username = gpc_get_string( 'db_username' );
$f_db_password = gpc_get_string( 'db_password' );
$f_db_database = gpc_get_string( 'db_database' );
$f_reset = gpc_get_bool( 'reset', false );

form_security_purge( 'plugin_SugarCRM_config_update' );

if( $f_reset ) {
    plugin_config_delete( 'db_hostname' );
    plugin_config_delete( 'db_username' );
    plugin_config_delete( 'db_password' );
    plugin_config_delete( 'db_database' );
} elseif( $f_db_hostname != '' ) {
    plugin_config_set( 'db_hostname', $f_db_hostname );
    plugin_config_set( 'db_username', $f_db_username );
    plugin_config_set( 'db_password', $f_db_password );
    plugin_config_set( 'db_database', $f_db_database );
} else {
    error_parameters( 'db_hostname', string_attribute( $f_db_hostname ));
    trigger_error( ERROR_CONFIG_OPT_INVALID, ERROR );
}

print_successful_redirect( plugin_page( 'config', true ));