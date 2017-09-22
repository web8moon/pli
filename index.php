<?php
//if (isset($_REQUEST[session_name()])) session_start();
session_start();

require_once('functions'.DIRECTORY_SEPARATOR.'main.php');

$QueqryUrl = [];
$QueqryUrl = parseQueryUrl(str_replace("q=","",trim($_SERVER['QUERY_STRING'])));

$Conf = [];
$fileConfig = 'config'.DIRECTORY_SEPARATOR.'main.php';
$Conf = loadConfig($fileConfig);

if (isset($QueqryUrl[0]) and (strlen($QueqryUrl[0]) > 1 and strlen($QueqryUrl[0]) < 30)) $Conf['defaultAction'] = $QueqryUrl[0];

$Lang = [];
$Conf['defaultLang'] = setLang($Conf['defaultLang'], $QueqryUrl[1], $Conf['allowLanguages']);
$Lang = loadLang($Conf);


	echo 'POST:';
	var_dump($_POST);
	echo '<br>';

echo 'QUEQRY:';
var_dump($QueqryUrl);
echo '<br>';
print render('views/newTemplate.php', ($Conf+$Lang));
