<?php

$errorMSG = "";
global $Conf;

$errorMSG = 'Data connection Error ';
if (is_array($Conf)) {
    $link = mysqli_connect($Conf['dbhost'], $Conf['dbuser'], $Conf['dbpass'], $Conf['dbname']);
    if ($link) {
        $errorMSG = '';
// NAME
        if (empty($_POST["name"])) {
            $errorMSG = 'Login is required ';
        } else {
            $name = $_POST["name"];
        }
// EMAIL
        if (empty($_POST["passw"])) {
            $errorMSG .= 'Password is required ';
        } else {
            $password = $_POST["passw"];
        }




        mysqli_close($link);
    }
}


// send email
//$success = mail($EmailTo, $Subject, $Body, "From:".$email);
$success = true;
$errorMSG = "";
// redirect to success page
if ($success && $errorMSG == "") {
    session_start();
    $_SESSION['start'] = md5($_SERVER['HTTP_USER_AGENT']);
    echo "success";
} else {
    if ($errorMSG == "") {
        echo "Something went wrong :(";
    } else {
        echo $errorMSG;
    }
}

