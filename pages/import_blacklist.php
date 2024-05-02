<?php
/*
csv import with columns
ip_lo	start of ragen
ip_hi	end or range
reason	reason for banning 
That's all

*/
auth_reauthenticate();
access_ensure_global_level( config_get( 'manage_plugin_threshold' ) );
layout_page_header( lang_get( 'plugin_format_title' ) );
layout_page_begin( 'config.php' );
print_manage_menu();
$link1 = "plugin.php?page=BanSpam/manage_banspam_page.php";
$link2 = "plugin.php?page=BanSpam/manage_banned_ip_page.php";
$link3 = "plugin.php?page=BanSpam/import_blacklist.php";
$import_file = "";
?>
<div class="col-md-12 col-xs-12">
<div class="space-10"></div>
<div class="form-container" > 
<div class="widget-box widget-color-blue2">
<div class="widget-header widget-header-small">
	<h4 class="widget-title lighter">
		<i class="ace-icon fa fa-text-width"></i>
		<?php echo  plugin_lang_get( 'title' ).': ' . plugin_lang_get( 'blacklist' )?>
	</h4>
</div>
<div class="widget-body">
<div class="widget-main no-padding">
<div class="table-responsive"> 
<table class="table table-bordered table-condensed table-striped"> 
<form action="<?php echo plugin_page( 'loadcsv' ) ?>" method="post" action="plugins/BanSpam/pages/loadcsv" enctype="multipart/form-data">
<tr >
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
<form method="post" enctype="multipart/form-data" action="<?php echo plugin_page('loadcsv')?> ">
<input type="hidden" name="import_file" value="<?php echo $import_file;  ?>">

    <div align="center">
        <table class="table table-bordered table-condensed table-striped"> 
              <tr>
			    <td class="category" width="15%">
                    <?php echo plugin_lang_get( 'col_sep' ) ?>
                </td>
                <td class="category">
                    <input name="edt_cell_separator" type="text" size="1" maxlength="1" value="," >
                </td>
				 <td><b>
                    <?php echo plugin_lang_get( 'col_sep2' ) ?>
                </b></td>
 
            </tr>
 
            <tr >
            	<td class="category" width="15%">
            		<?php echo lang_get( 'select_file' ) ?>
					<br>
             	</td>
            	<td width="85%" colspan="2">
            		<input type="file" name="import_file" accept=".csv" size="40">
               	</td>
            </tr>
			<tr>
			   <td> 
			   <input type="submit" class="button" value="<?php echo plugin_lang_get( 'import' ) ?>" />
			   </td>
			</tr>
        </table>
    </div>
</form>

	
<?php
layout_page_end();