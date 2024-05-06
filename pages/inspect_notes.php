<?php
auth_reauthenticate();
access_ensure_global_level( config_get( 'manage_plugin_threshold' ) );
layout_page_header( lang_get( 'plugin_format_title' ) );
layout_page_begin( 'config.php' );
print_manage_menu();
$link1 = "plugin.php?page=BanSpam/manage_banspam_page.php";
$link2 = "plugin.php?page=BanSpam/manage_banned_ip_page.php";
$link3 = "plugin.php?page=BanSpam/import_blacklist.php";
$link4 = "plugin.php?page=BanSpam/inspect_issues.php";
$link5 = "plugin.php?page=BanSpam/inspect_notes.php";
?>
<div class="col-md-12 col-xs-12">
<div class="space-10"></div>
<div class="form-container" > 
<div class="widget-box widget-color-blue2">
<div class="widget-header widget-header-small">
	<h4 class="widget-title lighter">
		<i class="ace-icon fa fa-text-width"></i>
		<?php echo  plugin_lang_get( 'title' ).': ' . plugin_lang_get( 'inspect_notes' )?>
	</h4>
</div>
<div class="widget-body">
<div class="widget-main no-padding">
<div class="table-responsive"> 
<table class="table table-bordered table-condensed table-striped"> 
<tr >
<td class="category" colspan="5">
</td>
</tr>
<br>
<tr>

<td class="form-title" colspan="7" >
<?php print_link_button( $link1, plugin_lang_get( 'user_ip'  ) );?>
&nbsp;&nbsp;&nbsp;&nbsp;
<?php print_link_button( $link2, plugin_lang_get( 'bannedip' ) );?>
&nbsp;&nbsp;&nbsp;&nbsp;
<?php print_link_button( $link3, plugin_lang_get( 'blacklist' ) );?>
&nbsp;&nbsp;&nbsp;&nbsp;
<?php print_link_button( $link4, plugin_lang_get( 'inspect_issues' ) );?>
&nbsp;&nbsp;&nbsp;&nbsp;
<?php print_link_button( $link5, plugin_lang_get( 'inspect_notes' ) );?>
</td>
</tr>

<tr class="row-category">
<td><div align="center"><?php echo lang_get( 'username' ) ?></div></td>
<td><div align="center"><?php echo lang_get( 'bug' ); ?></div></td>
<td><div align="center"><?php echo lang_get( 'bugnote' ) ?></div></td>
<td><div align="center"><?php echo plugin_lang_get( 'recorded' ) ?></div></td>
<td></td>
</tr>

<?php
$sql = "select * from {plugin_BanSpam_inspect} where bug_id <>0 order by stored";
$result = db_query($sql);
while ( $row = db_fetch_array( $result ) ) {
	?>
	<tr>
	<td><div align="center"><?php  echo user_get_username( $row["user_id"] ) ?>	</div></td>
	<td><div align="center"><?php echo $row["bug_id"] ?></div></td>
	<td><div align="center"><textarea rows = "3" cols = "150" readonly><?php echo $row['data']  ?></textarea></div></td>
	<td><div align="center"><?PHP	echo $row["stored"]?>	</div></td>
	<td><div align="center">
	<?PHP
	$link6 = "plugin.php?page=BanSpam/inspect_notes_action.php&action=D&id=";
	$link6 .= $row["id"]  ;
	$link7 = "plugin.php?page=BanSpam/inspect_notes_action.php&action=R&id=";
	$link7 .= $row["id"]  ;
	print_link_button( $link6, plugin_lang_get( 'delete_note' ) );
	print_link_button( $link7, plugin_lang_get( 'release_note' ) );
	?>
	</div></td>
	</tr>
	<?PHP
}
?>
</table>
</div>
</div>
</div>
</div>
</div>
</div>
<?php
layout_page_end();