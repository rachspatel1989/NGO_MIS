<?php
session_start();
include_once 'include/DB_Functions.php';
$db_handle = new DB_Functions();
$db = new DB_Functions();
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
$strs = "don't know/other";
$str = mysql_real_escape_string($strs);        
        $test = mysql_query("INSERT INTO exp_data (exp_name) VALUES('$str')");
        ?>
    </body>
</html>
