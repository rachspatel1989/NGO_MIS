<?php

include_once 'DB_Functions.php';
$db = new DB_Functions();
 
  $placeId = $_POST['placeId'];

  $query = "SELECT * from cluster_master";
  $result = mysql_query($query) or die('Query failed: ' . mysql_error());
  while ($row = mysql_fetch_assoc($result)) {
    if ($placeId == $row['cluster_id']){
      echo json_encode($row);
    }
  }
?>

