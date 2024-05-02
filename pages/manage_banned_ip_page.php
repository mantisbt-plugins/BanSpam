<?php
auth_reauthenticate();
access_ensure_global_level( config_get( 'manage_plugin_threshold' ) );
layout_page_header( lang_get( 'plugin_format_title' ) );
layout_page_begin( 'config.php' );
print_manage_menu();
$link1 = "plugin.php?page=BanSpam/manage_banspam_page.php";
$link2 = "plugin.php?page=BanSpam/manage_banned_ip.php";
$link3 = "plugin.php?page=BanSpam/import_blacklist.php";

?>
<div class="col-md-12 col-xs-12">
<div class="space-10"></div>
<div class="form-container" > 

<div class="widget-box widget-color-blue2">
<div class="widget-header widget-header-small">
	<h4 class="widget-title lighter">
		<i class="ace-icon fa fa-text-width"></i>
		<?php echo  plugin_lang_get( 'title' ).': ' . plugin_lang_get( 'bannedip' )?>
	</h4>
</div>
<div class="widget-body">
<div class="widget-main no-padding">
<div class="table-responsive"> 
<table class="table table-bordered table-condensed table-striped"> 
<form action="<?php echo plugin_page( 'iprange_add' ) ?>" method="post">
<tr >
<td class="category" colspan="3">
</td>
</tr>
<br>
<tr>

<td class="form-title" colspan="7" >
<?php print_link_button( $link1, plugin_lang_get( 'config'  ) );?>
&nbsp;&nbsp;&nbsp;&nbsp;
<?php print_link_button( $link2, plugin_lang_get( 'bannedip' ) );?>
&nbsp;&nbsp;&nbsp;&nbsp;
<?php print_link_button( $link3, plugin_lang_get( 'blacklist' ) );?>
</td>
</tr>

<tr class="row-category">
<td><div align="center"><?php echo plugin_lang_get( 'ip_lo' ) ?></div></td>
<td><div align="center"><?php echo plugin_lang_get( 'ip_hi' ); ?></div></td>
<td><div align="center"><?php echo plugin_lang_get( 'reason' ) ?></div></td>
<td><div align="center"><?php echo plugin_lang_get( 'bandate' ) ?></div></td>
<td></td>
<tr >
<td class="center">
<input type="text" name="ip_lo" size="15" maxlength="15"  >
</td>
<td class="center">
<input type="text" name="ip_hi" size="15" maxlength="15"  >
</td>
<td class="center">
<input type="text" name="reason" size="50" maxlength="250"  >
</td>
<td class="center">
<?php echo plugin_lang_get( 'automatic') ?>
</td>
<td class="center" colspan="3">
<input type="submit" class="btn btn-primary btn-white btn-round" value="<?php echo plugin_lang_get( 'add_iprange' ) ?>" />
</td>
</tr>

</form>

<?php
$sql = "select * from {plugin_BanSpam_bannedip} order by ip_lo";
$result = db_query($sql);
while ( $row = db_fetch_array( $result ) ) {
	?>
	<tr>
	<td><div align="center"><?php  echo $row["ip_lo"] ?>	</div></td>
	<td><div align="center"><?php echo $row["ip_hi"] ?></div></td>
	<td><div align="center"><?php echo $row["reason"] ?></div></td>
	<td><div align="center"><?PHP	echo $row["bandate"]?>	</div></td>
	<td><div align="center">
	<?PHP
	$link4 = "plugin.php?page=BanSpam/delete_ipban.php&delete_id=";
	$link4 .= $row["id"]  ;
	print_link_button( $link4, plugin_lang_get( 'remove_ban' ) );
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