<?php
include_once 'DB_Functions.php';
$db_handle = new DB_Functions();
if(!empty($_POST["gp_id"])) {
	$query ="SELECT * FROM village_master WHERE gp_id = '" . $_POST["gp_id"] . "'";
	$results = $db_handle->runQuery($query);
?>
	<option value="">Select Village</option>
<?php
	foreach($results as $village) {
?>
	<option value="<?php echo $village["village_name"]; ?>"><?php echo $village["village_name"]; ?></option>
<?php
	}
}
?>