<?php

include_once '../include/DB_Functions.php';
$db = new DB_Functions();

if (isset($_POST['email_id']) && isset($_POST['password'])) {

    // receiving the post params
    $email_id = $_POST['email_id'];
    $password = $_POST['password'];

    $result = mysql_query("SELECT login_master.login_id,login_master.login_type, register_master.reg_first_name, register_master.reg_last_name, register_master.reg_user_email, register_master.reg_contact_no, register_master.reg_address, register_master.reg_cluster, cluster_master.cluster_name, register_master.reg_created_date,district_master.district_name,block_master.block_name,district_master.district_id,block_master.block_id from login_master INNER JOIN register_master ON login_master.login_uid = register_master.reg_id INNER JOIN cluster_master ON register_master.reg_cluster = cluster_master.cluster_id INNER JOIN district_master ON register_master.reg_district = district_master.district_id INNER JOIN block_master ON register_master.reg_block = block_master.block_id WHERE login_uname = '$email_id' and login_password = '$password'");

    if (mysql_num_rows($result) == 1) {
        // response
        $response["response"] = 1;

        while ($row = mysql_fetch_assoc($result)) {

            // temp user array
            $response["login_id"] = $row["login_id"];
            $response["login_type"] = $row["login_type"];
            $response["reg_first_name"] = $row["reg_first_name"];
            $response["reg_last_name"] = $row["reg_last_name"];
            $response["reg_user_email"] = $row["reg_user_email"];
            $response["reg_contact_no"] = $row["reg_contact_no"];
            $response["reg_address"] = $row["reg_address"];
            $response["reg_created_date"] = $row["reg_created_date"];
            $response["reg_cluster"] = $row["reg_cluster"];
            $response["cluster_name"] = $row["cluster_name"];
            $response["district_id"] = $row["district_id"];
            $response["district_name"] = $row["district_name"];
            $response["block_id"] = $row["block_id"];
            $response["block_name"] = $row["block_name"];
        }

        // echoing JSON response
        echo json_encode($response);
    } else {
        // no products found
        $response["response"] = 2;
        $response["message"] = "Username or Password Invalid";

        // echo no users JSON
        echo json_encode($response);
    }
} else {
    // no products found
    $response["response"] = 3;
    $response["message"] = "Required Parameters missing";

    // echo no users JSON
    echo json_encode($response);
}

