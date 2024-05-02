<?PHP
$ip			= $_REQUEST['user_ip'];
$query		= "select * from {plugin_BanSpam_bannedip} where '$ip' >= ip_lo and '$ip' <= ip_hi ";
$result		= db_query( $query );
$result2	= db_num_rows($result);
if ($result2 === 0){
	$query = "INSERT INTO {plugin_BanSpam_bannedip} ( ip_lo,ip_hi, reason, bandate ) VALUES ( '$ip', '$ip','Manual via UI' ,NOW() )";
	$continue = db_query($query)){
}
print_header_redirect( 'plugin.php?page=BanSpam/manage_banspam_page' );