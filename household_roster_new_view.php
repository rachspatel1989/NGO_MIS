<?php
session_start();
include_once 'include/DB_Functions.php';
$users = new DB_Functions();
include_once 'householdroster_update.php';

ini_set('max_execution_time', 3000);
//mysql_set_charset("UTF8");
$login_id = $_SESSION['login_id'];
$login_uid = $_SESSION['login_uid'];
$login_type = $_SESSION['login_type'];
if ($login_id != "") {
    $admin_id = $_SESSION['login_id'];
    $result_sa = mysql_query("SELECT * from register_master WHERE reg_id = '$login_uid'");
    $data_sa = mysql_fetch_array($result_sa);
    $reg_id = $data_sa['reg_id'];
    $reg_name = $data_sa['reg_first_name'] . ' ' . $data_sa['reg_last_name'];
    $reg_img = $data_sa['reg_profile_img_path'];
    $reg_desi = $data_sa['reg_designation'];
    $reg_email = $data_sa['reg_user_email'];
    $reg_phone = $data_sa['reg_contact_no'];

    $family_sql = mysql_query("SELECT * from family_master");
    $family_row = mysql_num_rows($family_sql);
} else {
    header("location:index.php");
}
if (isset($_GET['q']) == 'logout') {
    header("location:index.php");
}
error_reporting(0);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Desh Bandhu & Manju Gupta (DBMG) Foundation</title>

        <!-- Global stylesheets -->
        <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
        <link href="assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
        <link href="assets/css/minified/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="assets/css/minified/core.min.css" rel="stylesheet" type="text/css">
        <link href="assets/css/minified/components.min.css" rel="stylesheet" type="text/css">
        <link href="assets/css/minified/colors.min.css" rel="stylesheet" type="text/css">
        <!-- /global stylesheets -->

        <!-- Core JS files -->
        <script type="text/javascript" src="assets/js/plugins/loaders/pace.min.js"></script>
        <script type="text/javascript" src="assets/js/core/libraries/jquery.min.js"></script>
        <script type="text/javascript" src="assets/js/core/libraries/bootstrap.min.js"></script>
        <script type="text/javascript" src="assets/js/plugins/loaders/blockui.min.js"></script>
        <!-- /core JS files -->

        <!-- Theme JS files -->
        <script type="text/javascript" src="assets/js/plugins/forms/wizards/stepy.min.js"></script>
        <script type="text/javascript" src="assets/js/plugins/forms/selects/select2.min.js"></script>
        <script type="text/javascript" src="assets/js/plugins/forms/styling/uniform.min.js"></script>
        <script type="text/javascript" src="assets/js/core/libraries/jasny_bootstrap.min.js"></script>
        <script type="text/javascript" src="assets/js/plugins/forms/validation/validate.min.js"></script>
        <script type="text/javascript" src="assets/js/core/libraries/jquery_ui/datepicker.min.js"></script>
        <script type="text/javascript" src="assets/js/core/libraries/jquery_ui/effects.min.js"></script>
        <script type="text/javascript" src="assets/js/plugins/notifications/jgrowl.min.js"></script>
        <script type="text/javascript" src="assets/js/plugins/ui/moment/moment.min.js"></script>
        <script type="text/javascript" src="assets/js/plugins/pickers/daterangepicker.js"></script>
        <script type="text/javascript" src="assets/js/plugins/pickers/anytime.min.js"></script>
        <script type="text/javascript" src="assets/js/plugins/pickers/pickadate/picker.js"></script>
        <script type="text/javascript" src="assets/js/plugins/pickers/pickadate/picker.date.js"></script>
        <script type="text/javascript" src="assets/js/plugins/pickers/pickadate/picker.time.js"></script>
        <script type="text/javascript" src="assets/js/plugins/pickers/pickadate/legacy.js"></script>
        <script type="text/javascript" src="assets/js/plugins/forms/selects/bootstrap_multiselect.js"></script>
        <script type="text/javascript" src="assets/js/core/app.js"></script>
        <script type="text/javascript" src="assets/js/pages/wizard_stepy.js"></script>
        <script type="text/javascript" src="assets/js/pages/picker_date.js"></script>
        <script type="text/javascript" src="assets/js/pages/form_multiselect.js"></script>
        <!-- /theme JS files -->   

        <!--Dropdown Selection(SectionB) -->
        <script type="text/javascript">
            $(function () {
                $("#hideeduction").hide();
                $("#school_attended").on("input", function () {
                    $("#hideeduction").toggle();
                });
            });
        </script>
        <script type="text/javascript">
            $(function () {
                $('#school_attended').change(function () {
                    $('#hideeduction').hide();
                    if ($(this).val() === "Yes") {
                        $('#hideeduction').show();
                    } else {
                        $('#hideeduction').hide();
                    }
                });
            });
        </script>    

        <!--Page Load Hide Div -->
        <script type="text/javascript">
            $(function () {
                $("#table2").hide();
                $("#occupation_id").on("input", function () {
                    $("#table2").toggle();
                });
            });
        </script>
        <script type="text/javascript">
            $(function () {
                $('#occupation_id').change(function () {
                    $('.table table-bordered').hide();
                    if ($(this).val() === "Government Service" || $(this).val() === "Private Service") {
                        $('#table2').show();
                    } else {
                        $('#table2').hide();
                    }
                });
            });
        </script>      
        <!--Page Load Hide Div -->
        <script type="text/javascript">
            $(function () {
                $("#lessthan6").hide();
                $("#greaterthan6").hide();
                $("#greaterthan61").hide();
                $("#greaterthan18").hide();
                $("#greaterthan181").hide();
                $("#greaterthan182").hide();
                $("#field1").on("input", function () {
                    $("#lessthan6, #greaterthan6,#greaterthan61,#greaterthan18,#greaterthan181,#greaterthan182").toggle();
                });
            });
        </script>

        <!--Age wise Hide and Show-->
        <script type="text/javascript">
            $(function () {
                $("#field1").on('input', function () {
                    if ($(this).val() === "") {
                        $("#lessthan6").hide();
                        $("#greaterthan6").hide();
                        $("#greaterthan61").hide();
                        $("#greaterthan18").hide();
                        $("#greaterthan181").hide();
                        $("#greaterthan182").hide();
                    } else if ($(this).val() >= 0 && $(this).val() < 6) {
                        $("#lessthan6").show();
                        $("#greaterthan6").hide();
                        $("#greaterthan61").hide();
                        $("#greaterthan18").hide();
                        $("#greaterthan181").hide();
                        $("#greaterthan182").hide();
                    } else if ($(this).val() >= 6 && $(this).val() < 18) {
                        $("#lessthan6").show();
                        $("#greaterthan6").show();
                        $("#greaterthan61").show();
                        $("#greaterthan18").hide();
                        $("#greaterthan181").hide();
                        $("#greaterthan182").hide();
                    } else if ($(this).val() >= 18) {
                        $("#lessthan6").show();
                        $("#greaterthan6").show();
                        $("#greaterthan61").show();
                        $("#greaterthan18").show();
                        $("#greaterthan181").show();
                        $("#greaterthan182").show();
                    }

                });
            });
        </script>

        <script type="text/javascript">
            $(function () {
                $("#women").hide();
                $("#female").on("input", function () {
                    $("#women").toggle();
                });
            });
        </script>
        <script type="text/javascript">
            $(function () {
                $("input[name='fm_gender']").click(function () {
                    if ($("#female").is(":checked")) {
                        $("#women").show();
                    }
                    if ($("#male").is(":checked")) {
                        $("#women").hide();
                    }
                });
            });
        </script>

    </head>

    <body>
        <input type="hidden" name="userType" id="userType" value=<?php echo $login_type; ?> >
        <!-- Main navbar -->
        <?php include 'include/header.php'; ?>
        <!-- /main navbar -->

        <!-- Page container -->
        <div class="page-container" style="min-height:933px">
            <!-- Page content -->
            <div class="page-content">
                <!-- Main sidebar -->
                <?php include 'include/sidemenu.php'; ?>

                <!-- Main content -->
                <div class="content-wrapper">

                    <!-- Page header -->
                    <div class="page-header">
                        <div class="page-header-content">
                            <div class="page-title">
                                <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Desh Bandhu & Manju Gupta (DBMG) Foundation</h4>
                            </div>
                        </div>
                        <!-- /header content -->
                        <!-- Toolbar -->
                        <div class="navbar navbar-default navbar-component navbar-xs">
                            <ul class="nav navbar-nav visible-xs-block">
                                <li class="full-width text-center"><a data-toggle="collapse" data-target="#navbar-filter"><i class="icon-menu7"></i></a></li>
                            </ul>

                            <div class="navbar-collapse collapse" id="navbar-filter">
                                <ul class="nav navbar-nav element-active-slate-400">
                                    <li class="active"><a href="#activity" data-toggle="tab"><i class="icon-menu7 position-left"></i> <b>B. Household Roster</b></a></li>
                                </ul>
                            </div>
                        </div>
                        <!-- /toolbar -->
                    </div>
                    <!-- /page header -->

                    <!-- /page header -->
                    <!-- Content area -->
                    <div class="content">
                        <?php
                        $sql_fet_sql = mysql_query("SELECT family_id FROM family_master where family_id='$_GET[getid]'");
                        $row_data = mysql_fetch_array($sql_fet_sql);
                        $fam_id = $row_data['family_id'];
                        $sql_fet_sql1 = mysql_query("SELECT family_member_master.fm_id,family_member_master.fm_age,family_member_master.fm_gender,family_member_master.fm_member_name,family_master.member_no,family_member_master.family_id FROM family_master ,family_member_master WHERE family_master.family_id = family_member_master.family_id AND family_member_master.family_id = '$fam_id'");
                        $sql_fm_rows = mysql_num_rows($sql_fet_sql1);
                        if ($sql_fm_rows == 0) {
                            
                        } else {
                            ?>
                            <div class="panel panel-flat">
                            <?php
//                            while($row_data1 = mysql_fetch_array($sql_fet_sql1))
//                                {
                            ?>                                 
                                <table class="table datatable-responsive">
                                    <thead>
                                        <tr>                                            
                                            <th>Family ID</th>
                                            <th>Member Name</th>
                                            <th>Number of Member</th>
                                            <th>Age</th>
                                            <th>Gender</th>
                                            <th>Action</th>
                                            <!--<th>Telephone/ land line no</th>-->
                                            <!--<th class="text-center">Action</th>-->
                                        </tr>
                                    </thead>
                                    <tbody>
    <?php
//                                        if (mysql_num_rows($selectRes) == 0) {
//                                            echo '<tr><td>No Rows Returned</td><td></td><td></td><td></td><td></td><td></td><td></td></tr>';
//                                        } else {
//                                            while ($row = mysql_fetch_assoc($selectRes)) {
    while ($row_data1 = mysql_fetch_array($sql_fet_sql1)) {
        $fmm_id = $row_data1['family_id'];
        $mem_name = $row_data1['fm_member_name'];
        $mem_age = $row_data1['fm_age'];
        $mem_gen = $row_data1['fm_gender'];
        $mem_number = $row_data1['member_no'];
//                                                $contact = $row['family_phone'];
        ?>
                                            <tr id="family_del<?php echo $fmm_id; ?>">
                                                <td><?php echo $fmm_id ?></td>
                                                <td><?php echo $mem_name ?></td>
                                                <td><?php echo $mem_number ?></td>
                                                <td><?php echo $mem_age ?></td>
                                                <td><?php echo $mem_gen ?></a></td>
                                                <td>                                      
                                                    <a href="?getid=<?php echo $_GET['getid'] ?>&mid=<?php echo $row_data1['fm_id']; ?>" title="Edit"><button class="btn btn-primary btn-xs" style="padding: 5px 5px;font-size: 8px"><i class="icon-pencil"></i></button></a>                                                        
                                                </td>

        <!--                                                    <td><?php //echo $salary  ?></a></td>
        <td><?php //echo $contact  ?></td>-->
        <!--                                                    <td class="text-center">
            <form name="form" method="POST" action="activityeligibility.php">
                <input value="<?php //echo $family_id;  ?>" type="hidden" name="familyid" name="familyid">
                <button type="submit" name="btn-save" class="btn bg-teal-400">Select<i class="icon-arrow-right14 position-right"></i></button>
            </form>
            <button class="btn bg-teal-400 btn-xs"><a href="family_activities.php?family_id=<?php //echo $family_id  ?>" style="color:white">&nbsp;Select&nbsp;</a></button>
        </td>-->
        <?php
//                                                }
//                                            }
        ?>
                                            </tr>
                                                <?php
                                            }
                                            ?>
                                    </tbody>
                                </table>
                                        <?php
//                            }
                                        ?>
                            </div>                        
                                <?php
                            }
                            if ($_GET['mid']) {
                                ?>                        

                            <!-- Clickable title -->
                            <form method="post" id="frmProduct">
                                <div class="panel panel-flat">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <fieldset class="text-semibold">
                                                    <div class="row">
                                                        <div class="content-group">                                                        
    <?php
    $sqlmem = mysql_query("SELECT family_master.member_no FROM family_master WHERE family_master.family_id = $_GET[getid]");
    $rowmem = mysql_fetch_array($sqlmem);
    $memberno = $rowmem['member_no'];
    $fetch_member = mysql_query("SELECT * FROM family_master ,family_member_master WHERE family_master.family_id = family_member_master.family_id AND family_member_master.family_id = '$fam_id' AND fm_id='$_GET[mid]'");
    $fm_row = mysql_fetch_array($fetch_member);
    ?>
                                                            <input type="hidden" name="getid" value="<?php echo $_GET['getid'] ?>"/>
                                                            <input type="hidden" name="fmid" value="<?php echo $_GET['mid'] ?>"/>
                                                            <div class="row">
                                                                <div class="form-group">
                                                                    <label class="control-label col-lg-6">1. What is your household size? </label>
                                                                    <div class="col-lg-6">
                                                                        <input type="text" class="form-control" id="noofmembers" name="noofmembers" value="<?php echo $memberno ?>" placeholder="Number of members (1-20)" disabled>
                                                                    </div>
                                                                </div>
                                                            </div><br/>                                                                         
                                                            <div class="row">
                                                                <div class="form-group">
                                                                    <label class="control-label col-lg-6">2. Name of the Person of HH</label>
                                                                    <div class="col-lg-6">
                                                                        <input type="text" class="form-control" name="fm_member_name" value="<?php echo $fm_row['fm_member_name'] ?>" placeholder="Name of Person" required>
                                                                    </div>
                                                                </div>
                                                            </div><br/>
                                                            <div class="row">
                                                                <div class="form-group">
                                                                    <label class="control-label col-lg-6">3. What is gender of the <b>[**PERSON**]</b>?</label>
                                                                    <div class="col-lg-6">
                                                                        <label class="radio-inline" for="fm_gender">
                                                                            <input type="radio" name="fm_gender" id="male" value="Male" required="">
                                                                            Male
                                                                        </label>
                                                                        <label class="radio-inline" for="fm_gender">
                                                                            <input type="radio" name="fm_gender" id="female" value="Female" required="">
                                                                            Female
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div><br/>
                                                            <div class="row">
                                                                <div class="form-group">
                                                                    <label class="control-label col-lg-6">4. What is <b>[**PERSON**]</b> Age?</label>
                                                                    <div class="col-lg-6">
                                                                        <input type="text" class="form-control" name="fm_age"value="<?php echo $fm_row['fm_age'] ?>" id="field1" placeholder="For children under 1 year, report 0 for age" required>
                                                                    </div>
                                                                </div>
                                                            </div><br/>
                                                            <div class="row">
                                                                <div class="form-group" id="lessthan6">
                                                                    <label class="control-label col-lg-6">5. Has <b>[**PERSON**]</b> ever attended Anganwaadi?</label>
                                                                    <div class="col-lg-6">
                                                                        <select class="form-control" name="fm_anganwaadi_attended">
                                                                            <option value="<?php echo $fm_row['fm_anganwaadi_attended'] ?>"><?php echo $fm_row['fm_anganwaadi_attended'] ?></option>
    <?php
//                                                                        if($fm_row['fm_anganwaadi_attended'] == 'Never')
//                                                                        {
//                                                                            
//                                                                        }
//                                                                        else
//                                                                        {
    ?>
                                                                            <option value="Never">Never</option>
                                                                            <?php
//                                                                        }
                                                                            ?>
                                                                            <option value="Yes,attending">Yes, attending</option>
                                                                            <option value="Yes,but not now">Yes, but not now</option>
                                                                            <option value="Don’t know">Don’t know</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div><br/>
                                                            <div class="row">
                                                                <div class="form-group" id="greaterthan6">
                                                                    <label class="control-label col-lg-6"> 6. Has <b>[**PERSON**]</b> ever attended school?</label>
                                                                    <div class="col-lg-6">
                                                                        <select class="form-control" name="fm_school_attended" id="school_attended">                                                                        
                                                                            <option value="<?php echo $fm_row['fm_school_attended'] ?>"><?php echo $fm_row['fm_school_attended'] ?></option>
                                                                            <option value="Yes">Yes</option>
                                                                            <option value="No">No</option>
                                                                            <option value="Don’t know">Don’t know</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div><br/>
                                                            <div class="row" id="hideeduction">
                                                                <div class="form-group" id="greaterthan61">
                                                                    <label class="control-label col-lg-6">7. What is the highest standard / year education <b>[**PERSON**]</b> completed? </label>
                                                                    <div class="col-lg-6">
                                                                        <input type="text" class="form-control" name="fm_education" value="<?php echo $fm_row['fm_education'] ?>" id="education" placeholder="Education">
                                                                    </div>
                                                                </div>
                                                            </div><br/>
                                                            <div class="row">
                                                                <div class="form-group" id="greaterthan18">
                                                                    <label class="control-label col-lg-6">8. What is <b>[**PERSON**]'s</b> main work?</label>
                                                                    <div class="col-lg-6">
                                                                        <select class="form-control" name="fm_occupation_id" id="occupation_id">
                                                                            <option value="<?php echo $fm_row['fm_occupation_id'] ?>"><?php echo $fm_row['fm_occupation_id'] ?></option>
                                                                            <option value="Not working nor looking for work">Not working nor looking for work</option>
                                                                            <option value="Too young/ too old to work">Too young/ too old to work</option>
                                                                            <option value="Work on own farm">Work on own farm</option>
                                                                            <option value="Work on own and other’s farm">Work on own and other’s farm</option>
                                                                            <option value="Farm labor">Farm labor</option>
                                                                            <option value="Construction labor">Construction labor</option>
                                                                            <option value="Skilled artisan">Skilled artisan</option>
                                                                            <option value="Factory worker">Factory worker</option>
                                                                            <option value="Government Service">Government Service</option>
                                                                            <option value="Private Service">Private Service</option>
                                                                            <option value="Professional">Professional</option>
                                                                            <option value="Self-employed business / shop">Self-employed business / shop</option>
                                                                            <option value="Housewife">Housewife</option>
                                                                            <option value="Household labor/ Petty assistant">Household labor/ Petty assistant</option>
                                                                            <option value="Not currently working">Not currently working</option>
                                                                            <option value="Other">Other</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div><br/>
                                                            <div class="row">
                                                                <div class="form-group" id="greaterthan181">
                                                                    <label class="control-label col-lg-6">9. Is <b>[**PERSON**]</b> interest to work outside the village or start own enterprise?</label>
                                                                    <div class="col-lg-6">
                                                                        <select class="form-control" name="fm_work_interest">
                                                                            <option value="<?php echo $fm_row['fm_work_interest'] ?>"><?php echo $fm_row['fm_work_interest'] ?></option>
                                                                            <option value="No">No</option>
                                                                            <option value="Interested to go for job outside the village">Interested to go for job outside the village</option>
                                                                            <option value="Interested to start own enterprise">Interested to start own enterprise</option>
                                                                            <option value="Interested but not now">Interested but not now </option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div><br/>
                                                            <div class="row" id="women">
                                                                <div class="form-group" id="greaterthan182">
                                                                    <label class="control-label col-lg-6">10. Is <b>[**PERSON**]</b> interested to participate in Women Self help group (SHG)?</label>
                                                                    <div class="col-lg-6">
                                                                        <select class="form-control" name="fm_women_sgh">
                                                                            <option value="<?php echo $fm_row['fm_women_sgh'] ?>"><?php echo $fm_row['fm_women_sgh'] ?></option>
                                                                            <option value="Not Interested to Participate in Women SHG">Not Interested to Participate in Women SHG</option>
                                                                            <option value="Interested to Participate in Women SHG">Interested to Participate in Women SHG</option>
                                                                            <option value="Already part of Women SHG">Already part of Women SHG</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div><br/>
                                                            <div class="row" id="table2">
                                                                <div class="form-group">
                                                                    <label><b>B11. Filter the above table where member reports work type as “Government/ Private Service�? in B8.</b></label>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="control-label col-lg-6">B11. Name of <b>[**PERSON**]</b> who are doing “Government/ Private service (as per B8)</label>
                                                                    <div class="col-lg-6">
                                                                        <input type="text" class="form-control" name="fm_emp_name" value="<?php echo $fm_row['fm_emp_name'] ?>" placeholder="Name of Person">
                                                                    </div>
                                                                </div><br/><br/>
                                                                <div class="form-group">
                                                                    <label class="control-label col-lg-6">B12. What is the per month salary of <b>[**PERSON**]?</b></label>
                                                                    <div class="col-lg-6">
                                                                        <input type="text" class="form-control" name="fm_per_month_salary" value="<?php echo $fm_row['fm_per_month_salary'] ?>" placeholder="Rupees">
                                                                    </div>
                                                                </div>
                                                            </div><br/>
                                                        </div>
                                                        <br/>
                                                        <div class="text-right">
                                                            <button type="submit" class="btn btn-primary" name="btn-save" value="save">Update</button>
                                                        </div>                                                
                                                        <!-- /clickable title -->
                                                    </div>
                                                    <!-- /content area -->
                                                </fieldset>
                                            </div>
                                            <!-- /main content -->
                                        </div>
                                    </div>
                                </div>
                                <!-- /page content -->
                            </form>
    <?php
}
?>                        

                        <!-- Footer -->
<?php include 'include/footer.php'; ?>
                        <!-- /footer -->
                    </div>
                    <!-- /content area -->
                </div>
                <!-- /main content -->
            </div>
            <!-- /page content -->
        </div>
        <!-- /page container -->
    </body>
</html>
