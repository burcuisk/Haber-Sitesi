<?php
function shorter($str) {
	if(strlen($str) > 300)
		$str = substr($str, 0, 300) . "...";
	return $str;
}

?>