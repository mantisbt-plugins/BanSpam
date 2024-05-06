<?PHP
$id = $_REQUEST['id'];
$action = $_REQUEST['action'];
// delete the issue
if ( $action == 'D' ) {
	$sql = "delete from {plugin_BanSpam_inspect} where id = $id";
	$result = db_query($sql);
	print_header_redirect( 'plugin.php?page=BanSpam/inspect_issues' );
	exit;
}
// release the issue
$sql = "select * from {plugin_BanSpam_inspect} where id = $id";
$result = db_query($sql);
while ( $row = db_fetch_array( $result ) ) {
	$bugdata = unserialize( base64_decode( $row['data'] ) );
}
	
# check due_date format
if( is_blank( $bugdata->due_date ) ) {
	$bugdata->due_date = date_get_null();
}
# check date submitted and last modified
if( is_blank( $bugdata->date_submitted ) ) {
	$bugdata->date_submitted = db_now();
}
if( is_blank( $bugdata->last_updated ) ) {
	$bugdata->last_updated = db_now();
}

	
# Insert text information
db_param_push();
$t_query = 'INSERT INTO {bug_text}
		    ( description, steps_to_reproduce, additional_information )
		  VALUES ( ' . db_param() . ',' . db_param() . ',' . db_param() . ')';
db_query( $t_query, array( $bugdata->description, $bugdata->steps_to_reproduce , $bugdata->additional_information ) );

# Get the id of the text information we just inserted
# NOTE: this is guaranteed to be the correct one.
# The value LAST_INSERT_ID is stored on a per-connection basis.

$t_text_id = db_insert_id( db_get_table( 'bug_text' ) );

# check to see if we want to assign this right off
$t_original_status = $bugdata->status;

# if not assigned, check if it should auto-assigned.
if( 0 == $bugdata->handler_id ) {
	# If a default user is associated with the category and we know that
	# the bug was not assigned to somebody, then assign it automatically.
	db_param_push();
	$t_query = 'SELECT user_id FROM {category} WHERE id=' . db_param();
	$t_result = db_query( $t_query, array( $bugdata->category_id ) );
	$t_handler = db_result( $t_result );

	if( $t_handler !== false && user_exists( $t_handler ) ) {
		$bugdata->handler_id = $t_handler;
	}
}

# Check if bug was pre-assigned or auto-assigned.
$t_status = bug_get_status_for_assign( NO_USER, $bugdata->handler_id, $bugdata->status);

# Insert the rest of the data
db_param_push();
$t_query = 'INSERT INTO {bug}
	    ( project_id,reporter_id, handler_id,duplicate_id, priority,severity, reproducibility,status,
		  resolution,projection, category_id,date_submitted,last_updated,eta, bug_text_id, os, os_build,platform, version,build,
		profile_id, summary, view_state, sponsorship_total, sticky, fixed_in_version,target_version, due_date )
					  VALUES
					    ( ' . db_param() . ',' . db_param() . ',' . db_param() . ',' . db_param() . ',
					      ' . db_param() . ',' . db_param() . ',' . db_param() . ',' . db_param() . ',
					      ' . db_param() . ',' . db_param() . ',' . db_param() . ',' . db_param() . ',
					      ' . db_param() . ',' . db_param() . ',' . db_param() . ',' . db_param() . ',
					      ' . db_param() . ',' . db_param() . ',' . db_param() . ',' . db_param() . ',
					      ' . db_param() . ',' . db_param() . ',' . db_param() . ',' . db_param() . ',
					      ' . db_param() . ',' . db_param() . ',' . db_param() . ',' . db_param() . ')';
db_query( $t_query, array( $bugdata->project_id, $bugdata->reporter_id, $bugdata->handler_id, $bugdata->duplicate_id, $bugdata->priority, $bugdata->severity, $bugdata->reproducibility, $t_status, $bugdata->resolution, $bugdata->projection, $bugdata->category_id, $bugdata->date_submitted, $bugdata->last_updated, $bugdata->eta, $t_text_id, $bugdata->os, $bugdata->os_build, $bugdata->platform, $bugdata->version, $bugdata->build, $bugdata->profile_id, $bugdata->summary, $bugdata->view_state, $bugdata->sponsorship_total, $bugdata->sticky, $bugdata->fixed_in_version, $bugdata->target_version, $bugdata->due_date ) );
$t_id = db_insert_id( db_get_table( 'bug' ) );

# log new bug
history_log_event_special( $t_id, NEW_BUG );

# log changes, if any (compare happens in history_log_event_direct)
history_log_event_direct( $t_id, 'status', $t_original_status, $t_status );
history_log_event_direct( $t_id, 'handler_id', 0, $bugdata->handler_id );

# send emails
email_bug_added( $t_id );

// now delete the issue from the inspection table
$sql = "delete from {plugin_BanSpam_inspect} where id = $id";
$result = db_query($sql);
print_header_redirect( 'plugin.php?page=BanSpam/inspect_issues' );