<?php
	function check_ip(){
		$reporter = auth_get_current_user_id();

		$ip = getUserIpAddr();
		// is the user recorded with thsi ip-address
		$t_query	= "select * from {plugin_BanSpam_userip} where user = $reporter";

		$t_result	= db_query($t_query);
		$t_records	= db_num_rows( $t_result );
		if ( $t_records == 0) {
			// add to db
			$t_query_1 = "insert into {plugin_BanSpam_userip} (user, user_ip, recorded) values( $reporter, '$ip' , NOW() )";
		} else {
			// update db
			$t_query_1 = "update {plugin_BanSpam_userip} set user_ip = '$ip' where user = $reporter";
		}
		$t_result_1	= db_query($t_query_1);
		// Next check if IP has been banned
		$t_query_2 = "select * from {plugin_BanSpam_bannedip} where '$ip' >= ip_lo and '$ip' <= ip_hi ";
		$t_result_2	= db_query($t_query_2);
		$t_records	= db_num_rows( $t_result_2 );
		if ( $t_records > 0) {
			trigger_error( 'ERROR_USER_IP_BANNED', ERROR );
		}
		return;
	}
	
	function getUserIpAddr(){
		if(!empty($_SERVER['HTTP_CLIENT_IP'])){
			//ip from share internet
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
			//ip pass from proxy
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}else{
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		return $ip;
	}

function getTextLanguage($text, $default) {
    $supported_languages = array(
          'en',
		  'de',
		  'fr',
		  'es',
      );
      
	// German word list
    // from http://wortschatz.uni-leipzig.de/Papers/top100de.txt
	// or from https://www.thegermanprofessor.com/top-500-german-words/
    $wordList['de'] = array ('der','und', 'sein', 'ein', 'zu', 'haben', 
						'ich', 'werden', 'sie' ,'von', 'nicht' ,'mit', 
						'es', 'sich' ,'auch' ,	'auf', 'für', 'an', 
						'er', 'so' ,'dass', 'können', 'dies', 'wir' ,
						'ihr', 'die', 'das', 'bei', 'oder', 'wenn');

    // English word list
    // from http://en.wikipedia.org/wiki/Most_common_words_in_English
    $wordList['en'] = array ('the','be', 'to', 'of', 'and', 'a', 'in',
						'that', 'have' ,'I', 'it' ,'for', 'not', 'on' ,
						'with' ,'he', 'as', 'you', 'do', 'at' ,'this', 
						'but', 'his', 'by' ,'from', 'they', 'we', 'say', 
						'she', 'or');

    // French word list
    // from https://1000mostcommonwords.com/1000-most-common-french-words/
    $wordList['fr'] = array ('comme','je', 'son', 'que', 'il', 'était', 
						'pour', 'sur', 'sont' ,'avec', 'ils' ,'être', 
						'à', 'un' ,'avoir' ,'ce', 'à partir de', 'par', 
						'chaud', 'mot' ,'mais', 'que', 'certains', 'est' ,
						'il', 'vous', 'ou', 'eu', 'la', 'de');

 
	// Spanish word list
    // from https://spanishforyourjob.com/commonwords/
    $wordList['es'] = array ('que','de', 'no', 'a', 'el', 'es', 'y', 
						'en', 'lo' ,'un', 'por' ,'qué', 'me', 'una' ,
						'te' ,'los', 'se', 'con', 'para', 'mi' ,'está', 
						'si', 'bien', 'pero' ,'yo', 'eso', 'las', 'sí', 
						'su', 'la');
						 
	
    // clean out the input string - note we don't have any non-ASCII 
    // characters in the word lists... change this if it is not the 
    // case in your language wordlists!
    $text = preg_replace("/[^A-Za-z]/", ' ', $text);
      
	// count the occurrences of the most frequent words
    foreach ($supported_languages as $language) {
		$counter[$language]=0;
    }
    for ($i = 0; $i < 30; $i++) {
        foreach ($supported_languages as $language) {
			$counter[$language] = $counter[$language] + 
            // I believe this is way faster than fancy RegEx solutions
            substr_count($text, ' ' .$wordList[$language][$i] . ' ');;
        }
    }

    // get max counter value
    // from http://stackoverflow.com/a/1461363
    $max = max($counter);
    $maxs = array_keys($counter, $max);
    // if there are two winners - fall back to default!
    if (count($maxs) == 1) {
        $winner = $maxs[0];
        $second = 0;
        // get runner-up (second place)
        foreach ($supported_languages as $language) {
			if ($language <> $winner) {
				if ($counter[$language]>$second) {
					$second = $counter[$language];
				}
			}
        }

        // apply arbitrary threshold of 10%
        if (($second / $max) < 0.1) {
			return $winner;
        } 
    }
    return $default;
}