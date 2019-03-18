<?php
include_once 'DB_Functions.php';
$db_handle = new DB_Functions();
if(!empty($_POST["block_id"])) {
	$query ="SELECT * FROM cluster_master WHERE block_id = '" . $_POST["block_id"] . "'";
	$results = $db_handle->runQuery($query);
?>
	<option value="">Select Cluster</option>
<?php
	foreach($results as $cluster) {
?>
	<option value="<?php echo $cluster["cluster_id"]; ?>"><?php echo $cluster["cluster_name"]; ?></option>
<?php
	}
}
?>