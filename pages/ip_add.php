<?PHP
$ip = $_REQUEST['user_ip'];
$userid = $_REQUEST['userid'];
$sql1 = "select * from {plugin_BanSpam_userip}  where user = $userid ";
$res1		= db_query( $sql1 );
$result	= db_num_rows($res1);
if ($result === 0){
	$sql2 = "insert into {plugin_BanSpam_userip} (user, user_ip, recorded) values( $userid, '$ip' , NOW() )";
} else {
	$sql2 = "update {plugin_BanSpam_userip} set user_ip = '$ip' where user = $userid";
}
$res2= db_query($sql2);
print_header_redirect( 'plugin.php?page=BanSpam/manage_banspam_page' );