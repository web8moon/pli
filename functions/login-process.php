<?php

$errorMSG = "";

// NAME
if (empty($_POST["name"])) {
    $errorMSG = "Name is required ";
} else {
    $name = $_POST["name"];
}

// EMAIL
if (empty($_POST["passw"])) {
    $errorMSG .= "Password is required ";
} else {
    $password = $_POST["passw"];
}
/*
// MESSAGE
if (empty($_POST["message"])) {
    $errorMSG .= "Message is required ";
} else {
    $message = $_POST["message"];
}
*/

$EmailTo = "emailaddress@test.com";
$Subject = "New Message Received";

// prepare email body text
$Body = "";
$Body .= "Name: ";
$Body .= $name;
$Body .= "\n";
$Body .= "Email: ";
//$Body .= $email;
$Body .= "\n";
$Body .= "Message: ";
//$Body .= $message;
$Body .= "\n";

// send email
//$success = mail($EmailTo, $Subject, $Body, "From:".$email);
$success = true;
$errorMSG = "";
// redirect to success page
if ($success && $errorMSG == ""){
   session_start();
   $_SESSION['start'] = md5($_SERVER['HTTP_USER_AGENT']);
   echo "success";
}else{
    if($errorMSG == ""){
        echo "Something went wrong :(";
    } else {
        echo $errorMSG;
    }
}

?>