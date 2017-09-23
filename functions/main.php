<?php

function loadConfig($file){
	if(file_exists($file)) $conf = include_once ($file);
	return $conf;
}

function loadLang($Conf){
	$file = 'config'.DIRECTORY_SEPARATOR.'lang_' . $Conf['currentLang'] . '.php';
	
	if(file_exists($file)) {
		$lang = include_once ($file);
	} else {
		$file = 'config'.DIRECTORY_SEPARATOR.'lang_' . $Conf['defaultLang'] . '.php';
		$lang = include_once ($file);
	}
	
	return $lang;
}

function parseQueryUrl($queryString){
	if(!empty($queryString)){
		$queryString = urldecode($queryString);
		$query_params = explode("/",$queryString);
		foreach ($query_params as $query_param)
		if ($query_param != "")
			$query[] = $query_param;
		return $query;
	}
}

function render($pathToTemplate, $data){
	extract($data);
	ob_start();
	require $pathToTemplate;
	return trim(ob_get_clean());
}

function setLang($oldLang, $newLang, $allowLang){
    if(!empty($newLang) and !empty($allowLang) and in_array($newLang, $allowLang)){
        return $newLang;
    }
    else {
        return $oldLang;
    }
}

function controler($conf) {
	if ($conf['currentAction'] == 'logout') {
		$_SESSION = array();
		session_destroy();
		$path = $conf['defaultAction'] . '/' . $conf['currentLang'];
		header('Location: /' . $path);
	}
}