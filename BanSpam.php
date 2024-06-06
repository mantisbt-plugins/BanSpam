<?php
require_once( 'plugins/BanSpam/BanSpam_api.php' );  
/**
 * BanSpam plugin
 */
class BanSpamPlugin extends MantisPlugin  {
	/**
	 * A method that populates the plugin information and minimum requirements.
	 * @return void
	 */
	function register() {
		$this->name = plugin_lang_get( 'title' );
		$this->description = plugin_lang_get( 'desc' );
		$this->version = '1.20';
		$this->requires = array('MantisCore' => '2.3.0-dev',);
		$this->page      = 'config';
		$this->author = 'Cas Nuy';
		$this->contact = 'cas-at-nuy.info';
		$this->url = 'https://github.com/mantisbt-plugins/BanSpam';
	}

	function init() {
		event_declare( 'EVENT_LOGIN_CHECK' );
		event_declare( 'EVENT_SIGNUP_CHECK' );
		plugin_event_hook( 'EVENT_REPORT_BUG_DATA', 'check_new_issue' );
		plugin_event_hook( 'EVENT_BUGNOTE_DATA', 'check_new_note' );
		plugin_event_hook( 'EVENT_MENU_MANAGE', 'managemenu' );
		plugin_event_hook( 'EVENT_LOGIN_CHECK', 'check_login' );
		plugin_event_hook( 'EVENT_SIGNUP_CHECK', 'check_signup' );
	}
	
	function config() {
		return array(
			'language'		=> 'en',
			'default'		=> '??',
			'check_login'	=> OFF,
			'check_signup'	=> OFF,
			'contact_mail'	=> 'admin@yoursite.com', 
			'min_chars'		=> 25,
			'min_chars_ok'	=> OFF,
			'min_issues'	=> 5,
			'min_notes'		=> 5,
			);
	}

	function managemenu() {
		return array('<a href="'. plugin_page( 'manage_banspam_page.php' ) . '">' . plugin_lang_get( 'banspam' ) . '</a>' );
    }

	function check_login($event){
		$continue = check_ip();
	}

	function check_signup($event){
		$continue = check_ip_only();
	}
	
	function check_new_issue($event, $p_issue){
			// first check if ip-address of user is recorded and check if IP has been banned
			$continue = check_ip();
			// check if post is in accepted language
			$text = $p_issue->summary;
			$text .= ' ';
			$text .= $p_issue->description;
			$text .= ' ';
			$text .= $p_issue->steps_to_reproduce;
			$text .= ' ';
			$text .= $p_issue->additional_information;
			$detect = getTextLanguage($text, '??');
			if ( $detect <> plugin_config_get( 'language') ) {
				$min_issues = plugin_config_get( 'min_issues');
				$tot_issues = getnr_issues();
				if ( $tot_issues < $min_issues ){
					$user_id = auth_get_current_user_id();
					$data =  base64_encode( serialize( $p_issue ) );
					$t_query = 'insert into  {plugin_BanSpam_inspect} (user_id, bug_id, data, stored) values (' . db_param() . ', ' . db_param() . ', ' . db_param() . ', ' . db_param() . ' )';
					$now =  date("Y/m/d") ;
					db_query( $t_query, array($user_id, 0 , $data , $now ) );
					$link = "plugin.php?page=BanSpam/messages.php&message_id=";
					$link .= 3;
					print_header_redirect( $link );
					exit;
				}
			}
			return  $p_issue;
	}
	
	function check_new_note($event,$notetext,$p_bug_id){
			// first check if ip-address of user is recorded and check if IP has been banned
			$continue = check_ip();			
			// check if post is in accepted language
			$detect = getTextLanguage($notetext, '??');
			if ( $detect <> plugin_config_get( 'language') ) {
				$min_notes = plugin_config_get( 'min_notes');
				$tot_notes = getnr_notes();
				if ( $tot_notes < $min_notes ){
					$user_id = auth_get_current_user_id();
					db_param_push();
					$t_query = 'insert into  {plugin_BanSpam_inspect} (user_id, bug_id, data, stored) values (' . db_param() . ', ' . db_param() . ', ' . db_param() . ', ' . db_param() . ' )';
					$now =  date("Y/m/d") ;
					db_query( $t_query, array($user_id, $p_bug_id, $notetext , $now ) );
					$link = "plugin.php?page=BanSpam/messages.php&message_id=";
					$link .= 1;
					print_header_redirect( $link );
					exit;
				}
			}
			return $notetext;
	}

	function schema() {
        return array(
            # v1.00
            array('CreateTableSQL', array(plugin_table('userip'), "
				id  				I   			NOTNULL UNSIGNED AUTOINCREMENT PRIMARY,
				user				I				DEFAULT NULL,
				user_ip				C(15)			DEFAULT NULL,
				recorded			D				DEFAULT NULL
				" ) ),
				array('CreateTableSQL', array(plugin_table('bannedip'), "
				id  				I   			NOTNULL UNSIGNED AUTOINCREMENT PRIMARY,
				ip_lo   			C(15)   		DEFAULT NULL,
				ip_hi				C(15)			DEFAULT NULL,
				reason				C(255)			DEFAULT NULL,
				bandate		 		date			DEFAULT NULL
				" ) ),
				array('CreateTableSQL', array(plugin_table('inspect'), "
				id  				I   			NOTNULL UNSIGNED AUTOINCREMENT PRIMARY,
				user_id   			I   			DEFAULT NULL,
				bug_id   			I   			DEFAULT NULL,
				data				Blob			DEFAULT NULL,
				stored		 		date			DEFAULT NULL
				" ) ),
			);
    }		

}