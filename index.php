<?php
//if (isset($_REQUEST[session_name()])) session_start();

session_start();

require_once('functions' . DIRECTORY_SEPARATOR . 'main.php');

$QueqryUrl = [];
$QueqryUrl = parseQueryUrl(str_replace("q=", "", trim($_SERVER['QUERY_STRING'])));

$Conf = [];
$fileConfig = 'config' . DIRECTORY_SEPARATOR . 'main.php';
$Conf = loadConfig($fileConfig);

$Lang = [];
if (!isset($QueqryUrl[1])) $QueqryUrl[1] = $Conf['defaultLang'];
$Conf['currentLang'] = setLang($Conf['currentLang'], $QueqryUrl[1], $Conf['allowLanguages']);
$Lang = loadLang($Conf);

if (isset($QueqryUrl[0]) and (strlen($QueqryUrl[0]) > 1 and strlen($QueqryUrl[0]) < 30)) $Conf['currentAction'] = $QueqryUrl[0];

controler($Conf, $Lang);



/*
if ($Conf['currentAction'] == 'profile' and isset($_SESSION['start'])){
    print render('views/profileTemplate.php', ($Conf+$Lang));
} else {
    if($Conf['currentAction'] == 'profile' and !isset($_SESSION['start'])) {
        $Conf['currentAction'] == $Conf['defaultAction'];
        print render('views/newTemplate.php', ($Conf + $Lang));
    }
}
*/

if (in_array($Conf['currentAction'], $Conf['pageLinks'])){
	$template = checkTemplateExist($Conf['pageLinks'][$Conf['currentAction']]);
	if ($template) print render($template, ($Conf+$Lang));
}

if (!in_array($Conf['currentAction'], $Conf['serviceLinks']) && !in_array($Conf['currentAction'], $Conf['pageLinks'])){
	print render('views/newTemplate.php', ($Conf+$Lang));
}