<?php

require_once('modules/permissions.php');

// reverse the effects of magic quotes, if enabled
if(
	ini_get('magic_quotes_sybase') == 1 ||
	(ini_get('magic_quotes_sybase') == '' && get_magic_quotes_gpc())
){
	function stripslashes_recurse($var) {
		if (is_array($var)) {
			$var = array_map('stripslashes_recurse', $var);
		} else {
			if (ini_get('magic_quotes_sybase') == 1 && get_magic_quotes_gpc())
				$var = str_replace('\\\'', '\'', $var);
			else
				$var = stripslashes($var);
		}
		return $var;
	}
	$_REQUEST = stripslashes_recurse($_REQUEST);
}

?>
