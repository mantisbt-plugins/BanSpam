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
		<?php echo  plugin_lang_get( 'title' ).': ' . plugin_lang_get( 'manage' )?>
	</h4>
</div>
<div class="widget-body">
<div class="widget-main no-padding">
<div class="table-responsive"> 
<table class="table table-bordered table-condensed table-striped"> 
<form action="<?php echo plugin_page( 'ip_add' ) ?>" method="post">
<tr >
<td class="category" colspan="7">
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
<td><div align="center"><?php echo lang_get( 'realname' ); ?></div></td>
<td><div align="center"><?php echo lang_get( 'email' ) ?></div></td>
<td><div align="center"><?php echo plugin_lang_get( 'user_ip' ) ?></div></td>
<td><div align="center"><?php echo plugin_lang_get( 'recorded' ) ?></div></td>
<td></td>
<tr >
<td class="center">
<select  name="userid"><option value="0">
<?php print_user_option_list( 0 ) ?>
</select></td>

</td>

<td class="center">
</td>
<td class="center">
</td>
<td class="center">
<input type="text" name="user_ip" size="15" maxlength="15"  >
</td>
<td></td>
<td class="center" colspan="3">
<input type="submit" class="btn btn-primary btn-white btn-round" value="<?php echo plugin_lang_get( 'add_ip' ) ?>" />
</td>
</tr>

</form>

<?php
$sql = "select user_ip, recorded , username, realname, email from {plugin_BanSpam_userip} a, {user} b where a.user=b.id order by username";
$result = db_query($sql);
while ( $row = db_fetch_array( $result ) ) {
	$ip 		= $row["user_ip"];
	$query1		= "select * from {plugin_BanSpam_bannedip} where '$ip' >= ip_lo and '$ip' <= ip_hi ";
	$result1	= db_query( $query1 );
	$result2	= db_num_rows($result1);
	if ($result2 === 0){
		$banned = false;
	} else {
		$banned = true;
	}
	?>
	<tr>
	<td><div align="center"><?php  echo $row["username"] ?>	</div></td>
	<td><div align="center"><?php echo $row["realname"] ?></div></td>
	<td><div align="center"><?php echo $row["email"] ?></div></td>
	<?php if ( $banned) { ?>
		<td bgcolor="red"><div align="center"><?php echo $row["user_ip"] ?></div></td>
	<?php } else { ?>
		<td><div align="center"><?php echo $row["user_ip"] ?></div></td>
	<?php } ?>
	<td><div align="center"><?PHP	echo $row["recorded"]?>	</div></td>
	<td><div align="center">
	<?PHP
	$link6 = "plugin.php?page=BanSpam/ban_this_ip.php&user_ip=";
	$link6 .= $row["user_ip"]  ;
	print_link_button( $link6, plugin_lang_get( 'ban_it' ) );
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