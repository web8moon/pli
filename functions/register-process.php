<?php

$errorMSG = "";
$success = true;
global $Conf;
$errorMSG = 'Data connection Error 1' . $Conf["dbhost"];
if (is_array($Conf)) {
    $link = mysqli_connect($Conf['dbhost'], $Conf['dbuser'], $Conf['dbpass'], $Conf['dbname']);
    $errorMSG = 'Data connection Error 2';
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

        if ($errorMSG == ''){
            $select = 'SELECT UserEmail from users WHERE `UserEmail` like `' .  mysqli_real_escape_string ($link, $name) . '` LIMIT 1';
            if ($result = mysqli_query($link, $select)){
                if (mysqli_num_rows($result) > 0) {
                    $errorMSG .= 'Entered Email is already registred';
                    mysqli_free_result($result);
                }
            }

        }



        mysqli_close($link);
    }
}


// send email
//$success = mail($EmailTo, $Subject, $Body, "From:".$email);


// redirect to success page
if ($success && $errorMSG == '') {
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

