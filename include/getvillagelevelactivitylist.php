<?php
include_once 'DB_Functions.php';
$db_handle = new DB_Functions();
if (!empty($_POST["village"])) {

    $village = $_POST["village"];
    # Prepare the SELECT Query
    $selectSQL = "SELECT * FROM village_level_activity WHERE village = '$village'";
    # Execute the SELECT Query
    if (!( $village_sql = mysql_query($selectSQL) )) {
        echo 'Retrieval of data from Database Failed - #' . mysql_errno() . ': ' . mysql_error();
    } else {
        ?>
        <table class="table table-striped media-library table-lg">
            <thead>
                <tr>
                    <th>Family Name</th>
                    <th>Sector Name</th>
                    <th>Activity</th>
                    <th>Sub-Activity</th>
                    <th>Date</th>
                    <th>Unit</th>
                    <th>Unit Cost</th>
                    <th>Total Units</th>
                    <th>DBMGF</th>
                    <th>Beneficiary</th>
                    <th>MF</th>
                    <th>Bank Loans</th>
                    <th>Govt.</th>
                    <th>NABARD</th>
                    <th>Others</th>
                    <th>Total</th>
                </tr>
            </thead>
            <?php
            while ($village_row = mysql_fetch_array($village_sql)) {
                $family_id = $village_row['family_id'];
                $sectorname = $village_row['sectorname'];
                $activity = $village_row['activity'];
                $sub_activity = $village_row['sub_activity'];
                $date_of_activity = $village_row['date_of_activity'];
                $unit = $village_row['unit'];
                $unit_cost = $village_row['unit_cost'];
                $total_units = $village_row['total_units'];
                $dbmgf_grant = $village_row['dbmgf_grant'];
                $beneficiary_contribution = $village_row['beneficiary_contribution'];
                $mf = $village_row['mf'];
                $bank_loan = $village_row['bank_loan'];
                $government = $village_row['government'];
                $nabard = $village_row['nabard'];
                $others = $village_row['others'];
                $total = $village_row['total'];
                ?>                                          
                <tbody>                                        
                    <tr>
                        <td><?php echo $family_id ?></td>
                        <td><?php echo $sectorname ?></td>
                        <td><?php echo $activity ?></td>
                        <td><?php echo $sub_activity ?></td>
                        <td><?php echo $date_of_activity ?></a></td>
                        <td><?php echo $unit ?></td>                                              
                        <td><?php echo $unit_cost ?></td>
                        <td><?php echo $total_units ?></td>
                        <td><?php echo $dbmgf_grant ?></td>
                        <td><?php echo $beneficiary_contribution ?></td>
                        <td><?php echo $mf ?></td>
                        <td><?php echo $bank_loan ?></a></td>
                        <td><?php echo $government ?></td>                                              
                        <td><?php echo $nabard ?></td>
                        <td><?php echo $others ?></td>
                        <td><?php echo $total ?></td>
                    </tr>
                </tbody>
            </table><?php
        }
    }
}
?>