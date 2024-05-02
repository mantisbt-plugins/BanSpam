<?php
$f_import_file = gpc_get_string( 'import_file' );
$f_separator = gpc_get_string('edt_cell_separator');     
# Check given parameters - File
$f_import_file = gpc_get_file( 'import_file', -1 ); 
$t_file_content = array();
$t_file_content = file( $f_import_file['tmp_name'] );
# Import file content
$t_first_run = true;
foreach( $t_file_content as $t_file_row ) 	{
	# Check if first row skipped
	if( $t_first_run  ) {
		$t_first_run = false;
		continue;
	}
	# Explode into elements
	$t_file_row = explode( $f_separator, $t_file_row );

	# Variables
	$f_ip_lo        = $t_file_row[0];
	$f_ip_hi        = $t_file_row[1];
	$f_reason       = $t_file_row[2];

	# check if range already exists
	$query		= "select * from {plugin_BanSpam_bannedip} where '$f_ip_lo' = ip_lo and '$f_ip_hi' = ip_hi ";
	$result		= db_query( $query );
	$result2	= db_num_rows($result);
	if ($result2 > 0){
		continue;
	}

	# add range
	$t_query = "INSERT INTO {plugin_BanSpam_bannedip} ( ip_lo, ip_hi, reason, bandate ) values ('$f_ip_lo', '$f_ip_hi', '$f_reason', NOW() )";
	db_query( $t_query );
}
print_header_redirect( 'plugin.php?page=BanSpam/manage_banspam_page' );