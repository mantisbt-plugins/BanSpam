<?php
$id = $_REQUEST['id'];
auth_reauthenticate();
access_ensure_global_level( config_get( 'manage_plugin_threshold' ) );
layout_page_header( lang_get( 'plugin_format_title' ) );
layout_page_begin( 'config.php' );
print_manage_menu();
$sql = "select * from {plugin_BanSpam_inspect} where id = $id";
$result = db_query($sql);
while ( $row = db_fetch_array( $result ) ) {
	$bugdata 		= unserialize( base64_decode( $row['data'] ) );
	$summary		= $bugdata->summary;
	$description	= $bugdata->description;
	$information	= $bugdata->steps_to_reproduce;
	$info			= $bugdata->additional_information;
	$username 		= user_get_username( $row["user_id"] );
	$stored			= $row["stored"];
	$duedate		= $bugdata->due_date;
	$project 		=  project_get_name ($bugdata->project_id);
	$category 		=  category_get_name ($bugdata->category_id);
}
?>
<div class="col-md-12 col-xs-12">
<div class="space-10"></div>
<div class="form-container" > 
<form action="<?php echo plugin_page( 'inspect_issues' ) ?>" method="post" >
<div class="widget-box widget-color-blue2">
<div class="widget-header widget-header-small">
	<h4 class="widget-title lighter">
		<i class="ace-icon fa fa-text-width"></i>
		<?php echo  plugin_lang_get( 'title' ).': ' . plugin_lang_get( 'inspect_issues' )?>
	</h4>
</div>
<div class="widget-body">
<div class="widget-main no-padding">
<div class="table-responsive"> 
<table class="table table-bordered table-condensed table-striped"> 
<tr >
<td class="category" colspan="5">
<?php // print_r($bugdata)?>
</td>
</tr>
<br>
<tr>

<td class="form-title" colspan="7" >
</td>
</tr>
<tr class="row-category">
	<td><div align="left"><?php echo lang_get( 'project' ) ?></div></td>
	<td ><div align="left"><?php  echo $project ?>	</div></td>
</tr>
<tr class="row-category">
	<td><div align="left"><?php echo lang_get( 'category' ) ?></div></td>
	<td ><div align="left"><?php  echo $category ?>	</div></td>
</tr>
<tr class="row-category">
	<td><div align="left"><?php echo lang_get( 'reporter' ) ?></div></td>
	<td ><div align="left"><?php  echo $username ?>	</div></td>
</tr>
<tr>
	<td><div align="left"><?php echo lang_get( 'summary' ) ?></div></td>
	<td ><div align="left"><textarea rows = "1" cols = "50" readonly><?php echo $summary  ?></textarea>
</tr>
<tr>
	<td><div align="left"><?php echo lang_get( 'description' ) ?></div></td>
	<td><div align="left"><textarea rows = "3" cols = "125" readonly><?php echo $description   ?></textarea></div></td>
</tr>
<tr>
	<td><div align="left"><?php echo lang_get( 'additional_information' ) ?></div></td>
	<td><div align="left"><textarea rows = "3" cols = "125" readonly><?php echo $info   ?></textarea></div></td>
</tr>
<tr>
	<td><div align="left"><?php echo lang_get( 'steps_to_reproduce' ) ?></div></td>
	<td><div align="left"><textarea rows = "3" cols = "125" readonly><?php echo $information   ?></textarea></div></td>
</tr>
<tr>
	<td><div align="left"><?php echo plugin_lang_get( 'recorded' ) ?></div></td>
	<td ><div align="left"><?PHP	echo $stored ?>	</div></td>
</tr>
<tr>
	<td><div align="left"><?php echo lang_get( 'due_date' ) ?></div></td>
	<td ><div align="left"><?PHP	echo date('Y-m-d', $duedate / 1000 ); ?>	</div></td>
</tr>
<tr><td></td>
	<td align="center"> 
   <input type="submit" class="button" value="<?php echo plugin_lang_get( 'ok' ) ?>" />
   </td>
 </tr>
</table>
</div>
</div>
</div>
</div>
</div>
</div>
<?php
layout_page_end();