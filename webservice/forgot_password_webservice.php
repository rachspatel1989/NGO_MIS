<?php

include_once '../include/DB_Functions.php';
$db = new DB_Functions();
date_default_timezone_set('Asia/Kolkata');

function randomPassword() {
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}

if (isset($_POST['login_email'])) {

    // receiving the post params
    $login_email = $_POST['login_email'];
    $password = randomPassword();
    
    $result = mysql_query("SELECT * from login_master WHERE login_uname = '" . $login_email . "'");
    $row = mysql_fetch_assoc($result);
    if (mysql_num_rows($result) == 1) { 

            mysql_query("UPDATE login_master set login_password = '" . $password . "' WHERE login_uname = '" . $login_email . "'");
            $update = mysql_query("SELECT * from login_master WHERE login_uname = '" . $login_email . "'");
            $rows = mysql_fetch_assoc($update);
            $pwd = $rows["login_password"];
            
            $to = $login_email;
            require '../mailer/Send_Mail.php';
            $subject = "Password Recovery";
            $body = "<div>" . $login_email . ",<br><br><p>Your random generated password is given below<br><b>" . $pwd .  "</b><br><br></p>Regards,<br> Admin.</div>";
            Send_Mail($to, $subject, $body);
            
            $response["response"] = 1;
            $response["message"] = "Password Changed and sent to Mail";
            echo json_encode($response);
    } else {
        // no products found
        $response["response"] = 3;
        $response["message"] = "No such Email found";
        echo json_encode($response);
    }
} else {
    // no products found
    $response["response"] = 4;
    $response["message"] = "Required Parameters missing";
    echo json_encode($response);
}

