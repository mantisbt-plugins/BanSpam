<?PHP
$ip_lo = $_REQUEST['ip_lo'];
$ip_hi = $_REQUEST['ip_hi'];
$reason = $_REQUEST['reason'];
	$query		= "select * from {plugin_BanSpam_bannedip} where '$ip_lo' = ip_lo and '$ip_hi' = ip_hi ";
	$result		= db_query( $query );
	$result2	= db_num_rows($result);
	if ($result2 === 0){
	$sql2 = "INSERT INTO {plugin_BanSpam_bannedip} ( ip_lo, ip_hi, reason, bandate ) values ('$ip_lo', '$ip_hi', '$reason', NOW()) ";
	$res2= db_query($sql2);
}
print_header_redirect( 'plugin.php?page=BanSpam/manage_banned_ip_page' );