<?PHP
$id = $_REQUEST['id'];
$action = $_REQUEST['action'];
// delete the note
if ( $action == 'D' ) {
	$sql = "delete from {plugin_BanSpam_inspect} where id = $id";
	$result = db_query($sql);
	print_header_redirect( 'plugin.php?page=BanSpam/inspect_notes' );
	exit;
}
// release the note
$sql = "select * from {plugin_BanSpam_inspect} where id = $id";
$result = db_query($sql);
while ( $row = db_fetch_array( $result ) ) {
	$p_bug_id		= $row['bug_id'];
	$p_user_id		= $row['user_id'];
	$p_bugnote_text	= $row['data'];
	$stored			= $row['stored'];
	$release = release_note($p_bug_id, $p_bugnote_text, '0:00', false,  BUGNOTE,  '', $p_user_id );
}
// now delete the note from the inspection table
$sql = "delete from {plugin_BanSpam_inspect} where id = $id";
$result = db_query($sql);
print_header_redirect( 'plugin.php?page=BanSpam/inspect_notes' );