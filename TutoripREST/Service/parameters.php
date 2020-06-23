<?php
function prepareParam($param) {
	
	$param = htmlspecialchars(strip_tags($param));
	if($param=="") $param = null;
	
	return $param;
	
}
	
?>