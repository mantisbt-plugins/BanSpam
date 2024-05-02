<?PHP
$delete_id			= $_REQUEST['delete_id'];
$query		= "delete fom {plugin_BanSpam_bannedip} where id= $delete_id ";
$result		= db_query( $query );
print_header_redirect( 'plugin.php?page=BanSpam/manage_banned_ip_page' );