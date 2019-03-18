<?php
include_once 'DB_Functions.php';
$db_handle = new DB_Functions();
if(!empty($_POST["cluster_id"])) {
	$query ="SELECT * FROM gp_master WHERE cluster_id = '" . $_POST["cluster_id"] . "'";
	$results = $db_handle->runQuery($query);
?>
	<option value="">Select GP</option>
<?php
	foreach($results as $gp) {
?>
	<option value="<?php echo $gp["gp_id"]; ?>"><?php echo $gp["gp_name"]; ?></option>
<?php
	}
}
?>