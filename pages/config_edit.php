<?php
// authenticate
auth_reauthenticate();
access_ensure_global_level( config_get( 'manage_plugin_threshold' ) );
// Read results
$f_language			= gpc_get_string( 'language','en' );

// update results
plugin_config_set( 'language', $f_language );

// redirect
print_header_redirect( "manage_plugin_page.php" );