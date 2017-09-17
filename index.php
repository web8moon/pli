<?php

require_once('functions'.DIRECTORY_SEPARATOR.'main.php');

$QueqryUrl = [];
$QueqryUrl = parseQueryUrl(str_replace("q=","",trim($_SERVER['QUERY_STRING'])));

$Conf = [];
$fileConfig = 'config'.DIRECTORY_SEPARATOR.'main.php';
$Conf = loadConfig($fileConfig);

$Conf['defaultLang'] = setLang($Conf['defaultLang'], $QueqryUrl[1], $Conf['allowLanguages']);

var_dump($QueqryUrl);
print render('views/newTemplate.php', $Conf);
