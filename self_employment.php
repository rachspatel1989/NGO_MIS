<?php
session_start();
include_once 'include/DB_Functions.php';
$users = new DB_Functions();
include_once 'self_employment_insert.php';

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
error_reporting(E_ALL ^ E_NOTICE);
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

        <!--checkbox-->

        <script type="text/javascript">
            $(function () {
                $("#familymemberNo").click(function () {
                    if ($(this).is(":checked")) {
                        $("#hidedata").hide();
                    } else {
                        $("#hidedata").show();
                    }
                });
            });
        </script>

        <script type="text/javascript">
            $(function () {
                $("#grantreceiveNo").click(function () {
                    if ($(this).is(":checked")) {
                        $("#hidedata1").hide();
                    } else {
                        $("#hidedata1").show();
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
                <!-- /main sidebar -->
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
                                    <li class="active"><a href="#activity" data-toggle="tab"><i class="icon-menu7 position-left"></i> <b>G. Self Employment</b></a></li>
                                </ul>
                            </div>
                        </div>
                        <!-- /toolbar -->
                    </div>
                    <!-- /page header -->

                    <!-- /page header -->
                    <!-- Content area -->
                    <div class="content">
                        <!-- Clickable title -->
                        <form method="post" id="frmform">
                            <div class="panel panel-flat">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <fieldset class="text-semibold">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>1. Enumerator:Is any member “Skilled artisan” or “Self-employed business / shop”present in the home?</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <!--  <div class="multi-select-full">
                                                                  <select style="display: none;" name="familymember" for="familymember" class="multiselect-filtering" multiple="multiple">
                                                                      <option value="No" id="familymemberNo">No (Go to section H)</option>
                                                                      <option value="Skilled artisan" id="familymemberskilled">Skilled artisan</option>
                                                                      <option value="Self-employed business / shop" id="familymemberself">Self-employed business / shop</option>
                                                                  </select>
                                                              </div> -->
                                                            <div class="form-group">
                                                                <label class="checkbox-inline" for="familymemberNo">
                                                                    <input name="familymember[]" id="familymemberNo" type="checkbox" value="No">
                                                                    No
                                                                </label>
                                                                <label class="checkbox-inline" for="familymemberskilled">
                                                                    <input name="familymember[]" id="familymemberskilled" type="checkbox" value="Skilled artisan">
                                                                    Skilled artisan
                                                                </label>
                                                                <label class="checkbox-inline" for="familymemberself">
                                                                    <input name="familymember[]" id="familymemberself" type="checkbox" value="Self-employed business / shop">
                                                                    Self-employed business / shop
                                                                </label>
                                                            </div>
                                                        </div>                                    
                                                    </div>
                                                </div>
                                                <div id="hidedata">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="display-block">2. Do you need any training for improvement in skill or self-employment business?</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="content-group-lg">
                                                                <label class="radio-inline">
                                                                    <input name="trainingrequired" id="trainingrequiredNoEnoughTraining" type="radio" value="No: We had enough training/ knowledge">
                                                                    No: We had enough training/ knowledge
                                                                </label><br/>
                                                                <label class="radio-inline">
                                                                    <input name="trainingrequired" id="trainingrequiredNoNeedTeaining" type="radio" value="No: We do not need the training">
                                                                    No: We do not need the training
                                                                </label><br/>
                                                                <label class="radio-inline">
                                                                    <input name="trainingrequired" id="trainingrequiredYes" type="radio" value="Yes">
                                                                    Yes
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>3. Have you got any grant or credit support for self employment? If yes, then from whom you took this grant or credit?</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <!-- <div class="form-group">
                                                                 <div class="multi-select-full">
                                                                     <select style="display: none;" class="multiselect-filtering" multiple="multiple" name="grantreceive" id="grantreceive"> 
                                                                         <option value="No">No(Go to section H)</option>
                                                                         <option value="Government">Government</option>
                                                                         <option value="DBMGF">DBMGF</option>
                                                                         <option value="NGO other than DBMGF">NGO other than DBMGF</option>
                                                                         <option value="MFG, Bank, money lander">MFG, Bank, money lander</option>
                                                                         <option value="Don’t know">Don’t know</option>
                                                                     </select>
                                                                 </div>
                                                             </div> -->

                                                            <div class="form-group">
                                                                <label class="checkbox-inline" for="grantreceiveNo">
                                                                    <input name="grantreceive[]" id="grantreceiveNo" type="checkbox" value="No">
                                                                    No
                                                                </label>
                                                                <label class="checkbox-inline" for="grantreceiveGovernment">
                                                                    <input name="grantreceive[]" id="grantreceiveGovernment" type="checkbox" value="Government">
                                                                    Government
                                                                </label>
                                                                <label class="checkbox-inline" for="grantreceiveDBMGF">
                                                                    <input name="grantreceive[]" id="grantreceiveDBMGF" type="checkbox" value="DBMGF">
                                                                    DBMGF
                                                                </label>
                                                                <label class="checkbox-inline" for="grantreceiveNGO">
                                                                    <input name="grantreceive[]" id="grantreceiveNGO" type="checkbox" value="NGO other than DBMGF">
                                                                    NGO other than DBMGF
                                                                </label>
                                                                <label class="checkbox-inline" for="grantreceiveMGF">
                                                                    <input name="grantreceive[]" id="grantreceiveMGF" type="checkbox" value="MFG, Bank, money lander">
                                                                    MFG, Bank, money lander
                                                                </label><br/>
                                                                <label class="checkbox-inline" for="grantreceiveDonot">
                                                                    <input name="grantreceive[]" id="grantreceiveDonot" type="checkbox" value="Don’t know">
                                                                    Don’t know
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="hidedata1">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>4. How much investment in entrepreneurship you got under Grant Support for self employment?</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <input type="text" name="investmentgrant" id="investmentgrant" class="form-control" placeholder="Rupees">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>5. How much investment in entrepreneurship you got under Credit Support for self employment?</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <input type="text" name="investmentcredit" id="investmentcredit" class="form-control" placeholder="Rupees">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="text-right stepy-finish">
                                                    <button type="submit" name="btn-save" class="btn btn-primary stepy-finish">Submit & Next <i class="icon-arrow-right14 position-right"></i></button>
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!-- /clickable title -->

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
        <script type="text/javascript">
            var form = document.getElementById("frmform");
            form.onclick = delegateFormClick;

            addChangeHandlers(form);

            function addChangeHandlers(form)
            {
                for (var i = 0; i < form.elements.length; i++)
                {
                    var element = form.elements[i];
                    if (element.tagName === "INPUT" && element.type === "checkbox")
                    {
                        if (!element.onchange)
                        {
                            element.onchange = checkBoxChanged;
                        }
                    }
                }
            }

            function delegateFormClick(evt)
            {
                var target;
                if (!evt)
                {
                    //Microsoft DOM
                    target = window.event.srcElement;
                } else if (evt)
                {
                    //w3c DOM 
                    target = evt.target;
                }
                if (target.nodeType === 1 && target.tagName === "INPUT" && target.type === "checkbox")
                {
                    if (target.checked)
                    {
                        disableCheckBoxes(target.id, document.getElementById("frmform"));
                    } else if (!target.checked)
                    {
                        enableCheckBoxes(document.getElementById("frmform"));
                    }
                }
            }

            function checkBoxChanged()
            {
                if (this.checked)
                {
                    disableCheckBoxes(this.id, document.getElementById("frmform"));
                } else if (!this.checked)
                {
                    enableCheckBoxes(document.getElementById("frmform"));
                }
            }

            function disableCheckBoxes(id, form)
            {
                var blacklist = [];
                if (id)
                {
                    switch (id)
                    {
                        case "familymemberNo":
                            blacklist = ["familymemberskilled", "familymemberself"];
                            break;
                        case "familymemberskilled":
                            blacklist = ["familymemberNo"];
                            break;
                        case "familymemberself":
                            blacklist = ["familymemberNo"];
                            break;
                        case "grantreceiveNo":
                            blacklist = ["grantreceiveGovernment", "grantreceiveDBMGF", "grantreceiveNGO", "grantreceiveMGF", "grantreceiveDonot"];
                            break;
                        case "grantreceiveGovernment":
                            blacklist = ["grantreceiveNo", "grantreceiveDonot"];
                            break;
                        case "grantreceiveDBMGF":
                            blacklist = ["grantreceiveNo", "grantreceiveDonot"];
                            break;
                        case "grantreceiveNGO":
                            blacklist = ["grantreceiveNo", "grantreceiveDonot"];
                            break;
                        case "grantreceiveMGF":
                            blacklist = ["grantreceiveNo", "grantreceiveDonot"];
                            break;
                        case "grantreceiveDonot":
                            blacklist = ["grantreceiveGovernment", "grantreceiveDBMGF", "grantreceiveNGO", "grantreceiveMGF", "grantreceiveNo"];
                            break;
                    }
                } else
                {
                    throw new Error("id is needed to hard-wire input blacklist");
                }
                for (var i = 0; i < blacklist.length; i++)
                {
                    var element = document.getElementById(blacklist[i]);
                    if (element && element.nodeType === 1)
                    {
                        //check for element
                        if (element.tagName === "INPUT" && element.type === "checkbox" && !element.checked)
                        {
                            element.disabled = "disabled";
                        }
                    } else if (!element || element.nodeType !== 1)
                    {
                        throw new Error("input blacklist item does not exist or is not an element");
                    }
                }
            }

            function enableCheckBoxes(form)
            {
                for (var i = 0; i < form.elements.length; i++)
                {
                    var element = form.elements[i];
                    if (element.tagName === "INPUT" && element.type === "checkbox" && !element.checked)
                    {
                        element.disabled = "";
                    }
                }
            }

        </script>

    </body>
</html>
