<?php

include_once '../include/DB_Functions.php';
$db = new DB_Functions();

if (isset($_POST['login_uid']) && isset($_POST['currentpassword']) && isset($_POST['newpassword'])) {

    // receiving the post params
    $login_uid = $_POST['login_uid'];
    $currentpassword = $_POST['currentpassword'];
    $newpassword = $_POST['newpassword'];

    $result = mysql_query("SELECT * from login_master WHERE login_uid = '" . $login_uid . "'");
    $row = mysql_fetch_assoc($result);
    if (mysql_num_rows($result) == 1) {

        if ($currentpassword == $row["login_password"]) {

            mysql_query("UPDATE login_master set login_password = '" . $_POST["newpassword"] . "' WHERE login_uid = '" . $login_uid . "'");

            $response["response"] = 1;
            $response["message"] = "Password Changed";
            echo json_encode($response);
        } else {
            
            $response["response"] = 2;
            $response["message"] = "Current Password is not correct";
            echo json_encode($response);
        }
       
    } else {
        // no products found
        $response["response"] = 3;
        $response["message"] = "No data found";
        echo json_encode($response);
    }
} else {
    // no products found
    $response["response"] = 4;
    $response["message"] = "Required Parameters missing";
    echo json_encode($response);
}

