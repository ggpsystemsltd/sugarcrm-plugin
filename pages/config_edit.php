<?php
form_security_validate( 'plugin_SugarCRM_config_update' );

auth_reauthenticate( );
access_ensure_global_level( config_get( 'manage_plugin_threshold' ) );

$f_db_hostname = gpc_get_string( 'db_hostname' );
$f_db_username = gpc_get_string( 'db_username' );
$f_db_password = gpc_get_string( 'db_password' );
$f_db_database = gpc_get_string( 'db_database' );
$f_reset = gpc_get_bool( 'reset', false );

if( plugin_config_get( 'db_hostname' ) != $f_db_hostname ) {
    plugin_config_set( 'db_hostname', $f_db_hostname );
}

if( plugin_config_get( 'db_username' ) != $f_db_username ) {
    plugin_config_set( 'db_username', $f_db_username );
}

if( plugin_config_get( 'db_password' ) != $f_db_password ) {
    plugin_config_set( 'db_password', $f_db_password );
}

if( plugin_config_get( 'db_database' ) != $f_db_database ) {
    plugin_config_set( 'db_database', $f_db_database );
}

form_security_purge( 'plugin_SugarCRM_config_update' );

print_successful_redirect( plugin_page( 'config', true ));