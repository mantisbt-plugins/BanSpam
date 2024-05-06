<?php
$id = $_REQUEST['message_id'];
layout_page_header();
layout_page_begin();
/* 
message_id = 1	=>	Note has been quarantained because of language and will be inspected by admin
message_id = 2	=>	Note has been rejected
message_id = 3	=>	Issue has been quarantained because of language and will be inspected by admin
message_id = 4	=>	Issue has been rejected
message_id = 5	=>  Your IP has been banned, you are not allowed to post.
*/
$string= 'message_';
$string .= $id;

?>
<div class="col-md-12 col-xs-12">
<div class="space-10"></div>
<div class="form-container" > 
<div class="widget-box widget-color-blue2">
<div class="widget-header widget-header-small">
	<h4 class="widget-title lighter">
		<i class="ace-icon fa fa-text-width"></i>
		<?php echo  plugin_lang_get( 'title' ).': ' . plugin_lang_get( 'message' )?>
	</h4>
</div>
<div class="widget-body">
<div class="widget-main no-padding">
<div class="table-responsive"> 
<table class="table table-bordered table-condensed table-striped"> 
<form action="index.php" method="post" >
<tr >
</tr>
<br>
    <div align="center">
               <tr>
			    <td ><center>
                    <?php 
					echo plugin_lang_get( "$string");
					if ( $id ==3 ) {
						echo " (". plugin_config_get( 'contact_mail'). ")";
					}
					?>
                </center></td>
            </tr>
			<tr>
			   <td> <center>
			   <input type="submit" class="button" value="<?php echo plugin_lang_get( 'ok' ) ?>" />
			   </center></td>
			</tr>
        </table>
    </div>
</form>

	
<?php
layout_page_end();