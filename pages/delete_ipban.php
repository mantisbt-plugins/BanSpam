<?PHP
$delete_it			= $_REQUEST['delete_id'];
$query		= "delete from {plugin_BanSpam_bannedip} where id= $delete_it ";

$result		= db_query( $query );
print_header_redirect( 'plugin.php?page=BanSpam/manage_banned_ip_page' );