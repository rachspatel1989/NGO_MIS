<?php
include_once 'DB_Functions.php';
$db_handle = new DB_Functions();
if (!empty($_POST["village_name"])) {

    $villagename = $_POST["village_name"];
    # Prepare the SELECT Query
    $selectSQL = "SELECT * FROM list_of_families WHERE list_of_families.village_name = '$villagename'";
    # Execute the SELECT Query
    if (!( $selectRes = mysql_query($selectSQL) )) {
        echo 'Retrieval of data from Database Failed - #' . mysql_errno() . ': ' . mysql_error();
    } else {
        ?>

        <table class="table table-striped media-library table-lg">
            <thead>
                <tr>                                            
                    <th>Village Name</th>
                    <th>Name of Family Head</th>
                    <th>Selection Year</th>
                    <th>Poverty Status</th>
                    <th>Total Land</th>
                    <th>Cultivable Land</th>
                    <th>Irrigated Land</th>
                    <th>Monthly Income (Rs)</th>

                </tr>
            </thead>
            <tbody>

                <?php
                if (mysql_num_rows($selectRes) == 0) {
                    echo '<tr><td colspan="4">No Rows Returned</td></tr>';
                } else {
                    while ($row = mysql_fetch_assoc($selectRes)) {
                        echo "<tr>"
                        . "<td>{$row['village_name']}</td>"
                        . "<td>{$row['family_head']}</td>"
                        . "<td>{$row['selection_year']}</td>"
                        . "<td>{$row['poverty_status']}</td>"
                        . "<td>{$row['total_land']}</td>"
                        . "<td>{$row['cultivable_land']}</td>"
                        . "<td>{$row['irrigated_land']}</td>"
                        . "<td>{$row['monthly_income']}</td>"
                        . "</tr>\n";
                    }
                }
                ?>
                </tr>
            </tbody>
        </table><?php
    }
}    
    
?>