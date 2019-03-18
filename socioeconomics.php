<?php
session_start();
include_once 'include/DB_Functions.php';
$users = new DB_Functions();
include_once 'socioeconomics_insert.php';

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
        <script type="text/javascript" src="assets/js/plugins/ui/nicescroll.min.js"></script>
        <script type="text/javascript" src="assets/js/plugins/ui/drilldown.js"></script>
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
        <script type="text/javascript" src="assets/js/core/libraries/jquery_ui/interactions.min.js"></script>
        <script type="text/javascript" src="assets/js/core/libraries/jquery_ui/touch.min.js"></script>
        <script type="text/javascript" src="assets/js/core/app.js"></script>
        <script type="text/javascript" src="assets/js/pages/components_navs.js"></script>

        <!-- /theme JS files -->
        <script type="text/javascript">
            $(function () {
                $("#house").hide();
                $("#houseconstructed").on("input", function () {
                    $("#house").toggle();
                });
            });
        </script>
        <script type="text/javascript">
            $(function () {
                $("#house").hide();
                $("#housenotconstructed").on("input", function () {
                    $("#house").toggle();
                });
            });
        </script>
        <script type="text/javascript">
            $(function () {
                $("#house1").hide();
                $("#renthouse").on("input", function () {
                    $("#house1").toggle();
                });
            });
        </script>
        <!-- Radio Section C -->
        <script type="text/javascript">
            $(function () {
                $("input[name='availability']").click(function () {
                    if ($("#houseconstructed").is(":checked")) {
                        $("#house").show();
                        $("#house1").hide();
                    }
                    if ($("#housenotconstructed").is(":checked")) {
                        $("#house").show();
                        $("#house1").hide();
                    }
                    if ($("#renthouse").is(":checked")) {
                        $("#house").hide();
                        $("#house1").show();
                    }
                });
            });
        </script>
        <script type="text/javascript">
            $(function () {
                $("#quantity1").hide();
                $("#consumeYes").on("input", function () {
                    $("#quantity1").toggle();
                });
            });
        </script>
        <script type="text/javascript">
            $(function () {
                $("#wages").hide();
                $("#consumeNo").on("input", function () {
                    $("#wages").toggle();
                });
            });
        </script>
        <script type="text/javascript">
            $(function () {
                $("input[name='consumefood']").click(function () {
                    if ($("#consumeNo").is(":checked")) {
                        $("#wages").show();
                        $("#quantity1").hide();
                    }
                    if ($("#consumeYes").is(":checked")) {
                        $("#quantity1").show();
                        $("#wages").hide();
                    }
                });
            });
        </script>
        <script type="text/javascript">
            $(function () {
                $("#quantity2").hide();
                $("#wagesYes").on("input", function () {
                    $("#quantity2").toggle();
                });
            });
        </script>
        <script type="text/javascript">
            $(function () {
                $("#observedrainfall").hide();
                $("#wagesNo").on("input", function () {
                    $("#observedrainfall").toggle();
                });
            });
        </script>
        <script type="text/javascript">
            $(function () {
                $("input[name='receivedwages']").click(function () {
                    if ($("#wagesNo").is(":checked")) {
                        $("#observedrainfall").show();
                        $("#quantity2").hide();
                    }
                    if ($("#wagesYes").is(":checked")) {
                        $("#quantity2").show();
                        $("#observedrainfall").hide();
                    }
                });
            });
        </script>
        <script type="text/javascript">
            $(function () {
                $("#nonfood").hide();
                $("#migratedYes").on("input", function () {
                    $("#nonfood").toggle();
                });
            });
        </script>
        <script type="text/javascript">
            $(function () {
                $("input[name='migrated']").click(function () {
                    if ($("#migratedNo").is(":checked")) {
                        $("#nonfood").hide();
                    }
                    if ($("#migratedYes").is(":checked")) {
                        $("#nonfood").show();
                    }
                });
            });
        </script>
        <!--Income validation start-->
        <script type="text/javascript">
            $(function () {
                $(".incomebox11").change(function () {
                    var income_id = $(this).attr("id");
//                    alert(income_id);  
                    var income1 = $("input[name='income_textbox1']").val();
//                    alert(income1); 

                    if (income1 < 1000 || income1 > 200000)
                    {
                        $(".validate1").html('Give Range(1000 to 200000)');
                        $(".hint1").hide();
                    } else
                    {
                        $(".validate1").html('');
                        $(".hint1").show();
                    }
                });
                $(".incomebox12").change(function () {
                    var income_id = $(this).attr("id");
//                    alert(income_id);  
                    var income2 = $("input[name='income_textbox2']").val();
//                    alert(income2); 

                    if (income2 < 1000 || income2 > 300000)
                    {
                        $(".validate2").html('Give Range(1000 to 300000)');
                        $(".hint2").hide();
                    } else
                    {
                        $(".validate2").html('');
                        $(".hint2").show();
                    }
                });
                $(".incomebox13").change(function () {
                    var income_id = $(this).attr("id");
//                    alert(income_id);  
                    var income3 = $("input[name='income_textbox3']").val();
//                    alert(income3); 

                    if (income3 < 1000 || income3 > 300000)
                    {
                        $(".validate3").html('Give Range(1000 to 300000)');
                        $(".hint3").hide();
                    } else
                    {
                        $(".validate3").html('');
                        $(".hint3").show();
                    }
                });
                $(".incomebox14").change(function () {
                    var income_id = $(this).attr("id");
//                    alert(income_id);  
                    var income4 = $("input[name='income_textbox4']").val();
//                    alert(income4); 

                    if (income4 < 1000 || income4 > 300000)
                    {
                        $(".validate4").html('Give Range(1000 to 300000)');
                        $(".hint4").hide();
                    } else
                    {
                        $(".validate4").html('');
                        $(".hint4").show();
                    }
                });
                $(".incomebox15").change(function () {
                    var income_id = $(this).attr("id");
//                    alert(income_id);  
                    var income5 = $("input[name='income_textbox5']").val();
//                    alert(income4); 

                    if (income5 < 1000 || income5 > 300000)
                    {
                        $(".validate5").html('Give Range(1000 to 300000)');
                        $(".hint5").hide();
                    } else
                    {
                        $(".validate5").html('');
                        $(".hint5").show();
                    }
                });
                $(".incomebox16").change(function () {
                    var income_id = $(this).attr("id");
//                    alert(income_id);  
                    var income6 = $("input[name='income_textbox6']").val();
//                    alert(income4); 

                    if (income6 < 1000 || income6 > 300000)
                    {
                        $(".validate6").html('Give Range(1000 to 300000)');
                        $(".hint6").hide();
                    } else
                    {
                        $(".validate6").html('');
                        $(".hint6").show();
                    }
                });
                $(".incomebox17").change(function () {
                    var income_id = $(this).attr("id");
//                    alert(income_id);  
                    var income7 = $("input[name='income_textbox7']").val();
//                    alert(income4); 

                    if (income7 < 1000 || income7 > 300000)
                    {
                        $(".validate7").html('Give Range(1000 to 300000)');
                        $(".hint7").hide();
                    } else
                    {
                        $(".validate7").html('');
                        $(".hint7").show();
                    }
                });
                $(".incomebox18").change(function () {
                    var income_id = $(this).attr("id");
//                    alert(income_id);  
                    var income8 = $("input[name='income_textbox8']").val();
//                    alert(income4); 

                    if (income8 < 1000 || income8 > 300000)
                    {
                        $(".validate8").html('Give Range(1000 to 300000)');
                        $(".hint8").hide();
                    } else
                    {
                        $(".validate8").html('');
                        $(".hint8").show();
                    }
                });
                $(".incomebox19").change(function () {
                    var income_id = $(this).attr("id");
//                    alert(income_id);  
                    var income9 = $("input[name='income_textbox9']").val();
//                    alert(income4); 

                    if (income9 < 1000 || income9 > 300000)
                    {
                        $(".validate9").html('Give Range(1000 to 300000)');
                        $(".hint9").hide();
                    } else
                    {
                        $(".validate9").html('');
                        $(".hint9").show();
                    }
                });
                $(".incomebox110").change(function () {
                    var income_id = $(this).attr("id");
//                    alert(income_id);  
                    var income10 = $("input[name='income_textbox10']").val();
//                    alert(income4); 

                    if (income10 < 1000 || income10 > 300000)
                    {
                        $(".validate10").html('Give Range(1000 to 300000)');
                        $(".hint10").hide();
                    } else
                    {
                        $(".validate10").html('');
                        $(".hint10").show();
                    }
                });
                $(".incomebox111").change(function () {
                    var income_id = $(this).attr("id");
//                    alert(income_id);  
                    var income11 = $("input[name='income_textbox11']").val();
//                    alert(income4); 

                    if (income11 < 1000 || income11 > 300000)
                    {
                        $(".validate11").html('Give Range(1000 to 100000)');
                        $(".hint11").hide();
                    } else
                    {
                        $(".validate11").html('');
                        $(".hint11").show();
                    }
                });
                $(".incomebox112").change(function () {
                    var income_id = $(this).attr("id");
//                    alert(income_id);  
                    var income12 = $("input[name='income_textbox12']").val();
//                    alert(income4); 

                    if (income12 < 1000 || income12 > 300000)
                    {
                        $(".validate12").html('Give Range(1000 to 300000)');
                        $(".hint12").hide();
                    } else
                    {
                        $(".validate12").html('');
                        $(".hint12").show();
                    }
                });
                $(".incomebox113").change(function () {
                    var income_id = $(this).attr("id");
//                    alert(income_id);  
                    var income13 = $("input[name='income_textbox13']").val();
//                    alert(income4); 

                    if (income13 < 1000 || income13 > 300000)
                    {
                        $(".validate13").html('Give Range(1000 to 300000)');
                        $(".hint13").hide();
                    } else
                    {
                        $(".validate13").html('');
                        $(".hint13").show();
                    }
                });
                $(".incomebox114").change(function () {
                    var income_id = $(this).attr("id");
//                    alert(income_id);  
                    var income14 = $("input[name='income_textbox14']").val();
//                    alert(income4); 

                    if (income14 < 1000 || income14 > 300000)
                    {
                        $(".validate14").html('Give Range(1000 to 300000)');
                        $(".hint14").hide();
                    } else
                    {
                        $(".validate14").html('');
                        $(".hint14").show();
                    }
                });
            });
        </script>
        <style type="text/css">
            .validate1 
            {
                color: red;
                float: left;
            }
            .validate2 
            {
                color: red;                
                float: left;
            }
            .validate3 
            {
                color: red;
                float: left;
            }
            .validate4 
            {
                color: red;
                float: left;
            }
            .validate5 
            {
                color: red;
                float: left;
            }
            .validate6 
            {
                color: red;
                float: left;
            }
            .validate7 
            {
                color: red;
                float: left;
            }
            .validate8 
            {
                color: red;
                float: left;
            }
            .validate9 
            {
                color: red;
                float: left;
            }
            .validate10 
            {
                color: red;
                float: left;
            }
            .validate11 
            {
                color: red;
                float: left;
            }
            .validate12 
            {
                color: red;
                float: left;
            }
            .validate13 
            {
                color: red;
                float: left;
            }
            .validate14 
            {
                color: red;
                float: left;
            }            
            .hint1 
            {
                color: #444;
                float: left;
            } 
            .hint2 
            {
                color: #444;
                float: left;
            } 
            .hint3 
            {
                color: #444;
                float: left;
            } 
            .hint4 
            {
                color: #444;
                float: left;
            } 
            .hint5 
            {
                color: #444;
                float: left;
            } 
            .hint6 
            {
                color: #444;
                float: left;
            } 
            .hint7 
            {
                color: #444;
                float: left;
            } 
            .hint8 
            {
                color: #444;
                float: left;
            }     
            .hint9 
            {
                color: #444;
                float: left;
            }   
            .hint10 
            {
                color: #444;
                float: left;
            }
            .hint11 
            {
                color: #444;
                float: left;
            }
            .hint12 
            {
                color: #444;
                float: left;
            }
            .hint13 
            {
                color: #444;
                float: left;
            }
            .hint14 
            {
                color: #444;
                float: left;
            }            
        </style>
        <!--Income Validation End-->
        <!--Asset validation start-->
        <script type="text/javascript">
            $(function () {
                $(".asset_box11").change(function () {
                    var income_id = $(this).attr("id");
//                    alert(income_id);  
                    var income1 = $("input[name='asset_textbox1']").val();
//                    alert(income1); 

                    if (income1 < 01 || income1 > 10)
                    {
                        $(".asset_validate1").html('Give Range(01 to 10)');
                        $(".asset_hint1").hide();
                    } else
                    {
                        $(".asset_validate1").html('');
                        $(".asset_hint1").show();
                    }
                });
                $(".asset_box12").change(function () {
                    var income_id = $(this).attr("id");
//                    alert(income_id);  
                    var income2 = $("input[name='asset_textbox2']").val();
//                    alert(income2); 

                    if (income2 < 01 || income2 > 02)
                    {
                        $(".asset_validate2").html('Give Range(01 to 02)');
                        $(".asset_hint2").hide();
                    } else
                    {
                        $(".asset_validate2").html('');
                        $(".asset_hint2").show();
                    }
                });
                $(".asset_box13").change(function () {
                    var income_id = $(this).attr("id");
//                    alert(income_id);  
                    var income3 = $("input[name='asset_textbox3']").val();
//                    alert(income3); 

                    if (income3 < 01 || income3 > 05)
                    {
                        $(".asset_validate3").html('Give Range(01 to 05)');
                        $(".asset_hint3").hide();
                    } else
                    {
                        $(".asset_validate3").html('');
                        $(".asset_hint3").show();
                    }
                });
                $(".asset_box14").change(function () {
                    var income_id = $(this).attr("id");
//                    alert(income_id);  
                    var income4 = $("input[name='asset_textbox4']").val();
//                    alert(income4); 

                    if (income4 < 01 || income4 > 10)
                    {
                        $(".asset_validate4").html('Give Range(01 to 10)');
                        $(".asset_hint4").hide();
                    } else
                    {
                        $(".asset_validate4").html('');
                        $(".asset_hint4").show();
                    }
                });
                $(".asset_box15").change(function () {
                    var income_id = $(this).attr("id");
//                    alert(income_id);  
                    var income5 = $("input[name='asset_textbox5']").val();
//                    alert(income4); 

                    if (income5 < 01 || income5 > 05)
                    {
                        $(".asset_validate5").html('Give Range(01 to 05)');
                        $(".asset_hint5").hide();
                    } else
                    {
                        $(".asset_validate5").html('');
                        $(".asset_hint5").show();
                    }
                });
                $(".asset_box16").change(function () {
                    var income_id = $(this).attr("id");
//                    alert(income_id);  
                    var income6 = $("input[name='asset_textbox6']").val();
//                    alert(income4); 

                    if (income6 < 01 || income6 > 03)
                    {
                        $(".asset_validate6").html('Give Range(01 to 03)');
                        $(".asset_hint6").hide();
                    } else
                    {
                        $(".asset_validate6").html('');
                        $(".asset_hint6").show();
                    }
                });
                $(".asset_box17").change(function () {
                    var income_id = $(this).attr("id");
//                    alert(income_id);  
                    var income7 = $("input[name='asset_textbox7']").val();
//                    alert(income4); 

                    if (income7 < 01 || income7 > 10)
                    {
                        $(".asset_validate7").html('Give Range(01 to 10)');
                        $(".asset_hint7").hide();
                    } else
                    {
                        $(".asset_validate7").html('');
                        $(".asset_hint7").show();
                    }
                });
                $(".asset_box18").change(function () {
                    var income_id = $(this).attr("id");
//                    alert(income_id);  
                    var income8 = $("input[name='asset_textbox8']").val();
//                    alert(income4); 

                    if (income8 < 01 || income8 > 10)
                    {
                        $(".asset_validate8").html('Give Range(01 to 10)');
                        $(".asset_hint8").hide();
                    } else
                    {
                        $(".asset_validate8").html('');
                        $(".asset_hint8").show();
                    }
                });
                $(".asset_box19").change(function () {
                    var income_id = $(this).attr("id");
//                    alert(income_id);  
                    var income9 = $("input[name='asset_textbox9']").val();
//                    alert(income4); 

                    if (income9 < 01 || income9 > 05)
                    {
                        $(".asset_validate9").html('Give Range(01 to 05)');
                        $(".asset_hint9").hide();
                    } else
                    {
                        $(".asset_validate9").html('');
                        $(".asset_hint9").show();
                    }
                });
                $(".asset_box110").change(function () {
                    var income_id = $(this).attr("id");
//                    alert(income_id);  
                    var income10 = $("input[name='asset_textbox10']").val();
//                    alert(income4); 

                    if (income10 < 01 || income10 > 10)
                    {
                        $(".asset_validate10").html('Give Range(01 to 10)');
                        $(".asset_hint10").hide();
                    } else
                    {
                        $(".asset_validate10").html('');
                        $(".asset_hint10").show();
                    }
                });
                $(".asset_box111").change(function () {
                    var income_id = $(this).attr("id");
//                    alert(income_id);  
                    var income11 = $("input[name='asset_textbox11']").val();
//                    alert(income4); 

                    if (income11 < 01 || income11 > 25)
                    {
                        $(".asset_validate11").html('Give Range(01 to 25)');
                        $(".asset_hint11").hide();
                    } else
                    {
                        $(".asset_validate11").html('');
                        $(".asset_hint11").show();
                    }
                });
                $(".asset_box112").change(function () {
                    var income_id = $(this).attr("id");
//                    alert(income_id);  
                    var income12 = $("input[name='asset_textbox12']").val();
//                    alert(income4); 

                    if (income12 < 01 || income12 > 30)
                    {
                        $(".asset_validate12").html('Give Range(01 to 30)');
                        $(".asset_hint12").hide();
                    } else
                    {
                        $(".asset_validate12").html('');
                        $(".asset_hint12").show();
                    }
                });
                $(".asset_box113").change(function () {
                    var income_id = $(this).attr("id");
//                    alert(income_id);  
                    var income13 = $("input[name='asset_textbox13']").val();
//                    alert(income4); 

                    if (income13 < 01 || income13 > 10)
                    {
                        $(".asset_validate13").html('Give Range(01 to 10)');
                        $(".asset_hint13").hide();
                    } else
                    {
                        $(".asset_validate13").html('');
                        $(".asset_hint13").show();
                    }
                });
                $(".asset_box114").change(function () {
                    var income_id = $(this).attr("id");
//                    alert(income_id);  
                    var income14 = $("input[name='asset_textbox14']").val();
//                    alert(income4); 

                    if (income14 < 01 || income14 > 10)
                    {
                        $(".asset_validate14").html('Give Range(01 to 10)');
                        $(".asset_hint14").hide();
                    } else
                    {
                        $(".asset_validate14").html('');
                        $(".asset_hint14").show();
                    }
                });
            });
        </script>
        <style type="text/css">
            .asset_validate1 
            {
                color: red;
                float: left;
            }
            .asset_validate2 
            {
                color: red;                
                float: left;
            }
            .asset_validate3 
            {
                color: red;
                float: left;
            }
            .asset_validate4 
            {
                color: red;
                float: left;
            }
            .asset_validate5 
            {
                color: red;
                float: left;
            }
            .asset_validate6 
            {
                color: red;
                float: left;
            }
            .asset_validate7 
            {
                color: red;
                float: left;
            }
            .asset_validate8 
            {
                color: red;
                float: left;
            }
            .asset_validate9 
            {
                color: red;
                float: left;
            }
            .asset_validate10 
            {
                color: red;
                float: left;
            }
            .asset_validate11 
            {
                color: red;
                float: left;
            }
            .asset_validate12 
            {
                color: red;
                float: left;
            }
            .asset_validate13 
            {
                color: red;
                float: left;
            }
            .asset_validate14 
            {
                color: red;
                float: left;
            }            
            .asset_hint1 
            {
                color: #444;
                float: left;
            } 
            .asset_hint2 
            {
                color: #444;
                float: left;
            } 
            .asset_hint3 
            {
                color: #444;
                float: left;
            } 
            .asset_hint4 
            {
                color: #444;
                float: left;
            } 
            .asset_hint5 
            {
                color: #444;
                float: left;
            } 
            .asset_hint6 
            {
                color: #444;
                float: left;
            } 
            .asset_hint7 
            {
                color: #444;
                float: left;
            } 
            .asset_hint8 
            {
                color: #444;
                float: left;
            }     
            .asset_hint9 
            {
                color: #444;
                float: left;
            }   
            .asset_hint10 
            {
                color: #444;
                float: left;
            }
            .asset_hint11 
            {
                color: #444;
                float: left;
            }
            .asset_hint12 
            {
                color: #444;
                float: left;
            }
            .asset_hint13 
            {
                color: #444;
                float: left;
            }
            .asset_hint14 
            {
                color: #444;
                float: left;
            }            
        </style>
        <!--Asset Validation End-->
        <!--Savings validation start-->
        <script type="text/javascript">
            $(function () {
                $(".sav_box11").change(function () {
                    var income_id = $(this).attr("id");
//                    alert(income_id);  
                    var income1 = $("input[name='sav_textbox1']").val();
//                    alert(income1); 

                    if (income1 < 1000 || income1 > 5000)
                    {
                        $(".sav_validate1").html('Give Range(1000 to 5000)');
                        $(".sav_hint1").hide();
                    } else
                    {
                        $(".sav_validate1").html('');
                        $(".sav_hint1").show();
                    }
                });
                $(".sav_box12").change(function () {
                    var income_id = $(this).attr("id");
//                    alert(income_id);  
                    var income2 = $("input[name='sav_textbox2']").val();
//                    alert(income2); 

                    if (income2 < 500 || income2 > 50000)
                    {
                        $(".sav_validate2").html('Give Range(1000 to 50000)');
                        $(".sav_hint2").hide();
                    } else
                    {
                        $(".sav_validate2").html('');
                        $(".sav_hint2").show();
                    }
                });
                $(".sav_box13").change(function () {
                    var income_id = $(this).attr("id");
//                    alert(income_id);  
                    var income3 = $("input[name='sav_textbox3']").val();
//                    alert(income3); 

                    if (income3 < 1000 || income3 > 50000)
                    {
                        $(".sav_validate3").html('Give Range(1000 to 50000)');
                        $(".sav_hint3").hide();
                    } else
                    {
                        $(".sav_validate3").html('');
                        $(".sav_hint3").show();
                    }
                });
                $(".sav_box14").change(function () {
                    var income_id = $(this).attr("id");
//                    alert(income_id);  
                    var income4 = $("input[name='sav_textbox4']").val();
//                    alert(income4); 

                    if (income4 < 1000 || income4 > 500000)
                    {
                        $(".sav_validate4").html('Give Range(1000 to 500000)');
                        $(".sav_hint4").hide();
                    } else
                    {
                        $(".sav_validate4").html('');
                        $(".sav_hint4").show();
                    }
                });
                $(".sav_box15").change(function () {
                    var income_id = $(this).attr("id");
//                    alert(income_id);  
                    var income5 = $("input[name='sav_textbox5']").val();
//                    alert(income4); 

                    if (income5 < 1000 || income5 > 100000)
                    {
                        $(".sav_validate5").html('Give Range(1000 to 100000)');
                        $(".sav_hint5").hide();
                    } else
                    {
                        $(".sav_validate5").html('');
                        $(".sav_hint5").show();
                    }
                });
                $(".sav_box16").change(function () {
                    var income_id = $(this).attr("id");
//                    alert(income_id);  
                    var income6 = $("input[name='sav_textbox6']").val();
//                    alert(income4); 

                    if (income6 < 1000 || income6 > 100000)
                    {
                        $(".sav_validate6").html('Give Range(1000 to 100000)');
                        $(".sav_hint6").hide();
                    } else
                    {
                        $(".sav_validate6").html('');
                        $(".sav_hint6").show();
                    }
                });
                $(".sav_box17").change(function () {
                    var income_id = $(this).attr("id");
//                    alert(income_id);  
                    var income7 = $("input[name='sav_textbox7']").val();
//                    alert(income4); 

                    if (income7 < 1000 || income7 > 50000)
                    {
                        $(".sav_validate7").html('Give Range(1000 to 50000)');
                        $(".sav_hint7").hide();
                    } else
                    {
                        $(".sav_validate7").html('');
                        $(".sav_hint7").show();
                    }
                });
                $(".sav_box18").change(function () {
                    var income_id = $(this).attr("id");
//                    alert(income_id);  
                    var income8 = $("input[name='sav_textbox8']").val();
//                    alert(income4); 

                    if (income8 < 1000 || income8 > 50000)
                    {
                        $(".sav_validate8").html('Give Range(1000 to 50000)');
                        $(".sav_hint8").hide();
                    } else
                    {
                        $(".sav_validate8").html('');
                        $(".sav_hint8").show();
                    }
                });
                $(".sav_box19").change(function () {
                    var income_id = $(this).attr("id");
//                    alert(income_id);  
                    var income9 = $("input[name='sav_textbox9']").val();
//                    alert(income4); 

                    if (income9 < 0 || income9 > 1000000)
                    {
                        $(".sav_validate9").html('Give Range Numbers Only');
                        $(".sav_hint9").hide();
                    } else
                    {
                        $(".sav_validate9").html('');
                        $(".sav_hint9").show();
                    }
                });
            });
        </script>
        <style type="text/css">
            .sav_validate1 
            {
                color: red;
                float: left;
            }
            .sav_validate2 
            {
                color: red;                
                float: left;
            }
            .sav_validate3 
            {
                color: red;
                float: left;
            }
            .sav_validate4 
            {
                color: red;
                float: left;
            }
            .sav_validate5 
            {
                color: red;
                float: left;
            }
            .sav_validate6 
            {
                color: red;
                float: left;
            }
            .sav_validate7 
            {
                color: red;
                float: left;
            }
            .sav_validate8 
            {
                color: red;
                float: left;
            }
            .sav_validate9 
            {
                color: red;
                float: left;
            }            
            .sav_hint1 
            {
                color: #444;
                float: left;
            } 
            .sav_hint2 
            {
                color: #444;
                float: left;
            } 
            .sav_hint3 
            {
                color: #444;
                float: left;
            } 
            .sav_hint4 
            {
                color: #444;
                float: left;
            } 
            .sav_hint5 
            {
                color: #444;
                float: left;
            } 
            .sav_hint6 
            {
                color: #444;
                float: left;
            } 
            .sav_hint7 
            {
                color: #444;
                float: left;
            } 
            .sav_hint8 
            {
                color: #444;
                float: left;
            }     
            .sav_hint9 
            {
                color: #444;
                float: left;
            }              
        </style>
        <!--Savings Validation End-->
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
                                    <li class="active"><a href="#activity" data-toggle="tab"><i class="icon-menu7 position-left"></i> <b>C. SocioEconomics</b></a></li>
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
                        <form method="post" action="" id="frmform">
                            <div class="panel panel-flat">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <fieldset class="text-semibold">
                                                <div class="row">                                
                                                    <div class="col-md-6">
                                                        <div class="content-group-lg">
                                                            <label class="display-block">1. What is the government assigned category of your caste?</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="radio-inline">
                                                            <input name="caste" id="caste" type="radio" value="SC">
                                                            SC
                                                        </label>
                                                        <label class="radio-inline">
                                                            <input name="caste" id="caste" type="radio" value="ST">
                                                            ST
                                                        </label>
                                                        <label class="radio-inline">
                                                            <input name="caste" id="caste" type="radio" value="NT">
                                                            NT
                                                        </label>
                                                        <label class="radio-inline">
                                                            <input name="caste" id="caste" type="radio" value="OBC">
                                                            OBC
                                                        </label>
                                                        <label class="radio-inline">
                                                            <input name="caste" id="caste" type="radio" value="Open/general">
                                                            Open/general
                                                        </label>
                                                        <label class="radio-inline">
                                                            <input name="caste" id="caste" type="radio" value="No caste/refused to tell caste">
                                                            No caste/refused to tell caste
                                                        </label>
                                                        <label class="radio-inline">
                                                            <input name="caste" id="caste" type="radio" value="Don't know/Not sure">
                                                            Don't know/Not sure
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>2. Are you below poverty line (BPL) or above poverty line (APL)?</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <div class="radio">
                                                                <label class="radio-inline">
                                                                    <input name="povertyline" id="povertyline" type="radio" value="Below poverty line(BPL)">
                                                                    Below poverty line(BPL) (Yelow ration card)
                                                                </label>
                                                                <label class="radio-inline">
                                                                    <input name="povertyline" id="povertyline" type="radio" value="Above poverty line(APL)">
                                                                    Above poverty line(APL) (Orange/ White ration card)
                                                                </label>
                                                                <br/>
                                                                <label class="radio-inline">
                                                                    <input name="povertyline" id="povertyline" type="radio" value="Don't know/not sure">
                                                                    Don't know/not sure
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>3. Does your family own this house or is it rented?</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <div class="radio">
                                                                <label class="radio-inline" for="availability">
                                                                    <input name="availability" type="radio" id="houseconstructed" value="Constructed">
                                                                    We own house (<b>Constructed</b> under Indira Awas Yojana (IAY))
                                                                </label>
                                                                <label class="radio-inline" for="availability">
                                                                    <input name="availability" type="radio" id="housenotconstructed" value="Not Constructed">
                                                                    We own house (<b>Not Constructed</b> under IAY)
                                                                </label>
                                                                <br/>
                                                                <label class="radio-inline" for="availability">
                                                                    <input name="availability" type="radio" id="renthouse" value="Rent House">
                                                                    We rent the house
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row" id="house">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="housevalue">4. What do you think would be the market value of your house today? <br/> <b>(Record -9 if don't know)</b></label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <input type="text" name="housevalue" class="form-control" placeholder="Rs.20000 to Rs.1500000" id="housevalue">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row" id="house1">
                                                    <div class="col-md-6" >
                                                        <div class="form-group">
                                                            <label for="monthrent">5. How much rent do you pay each month? <br/> <b>(Record -9 if respondent does not know the answer or is not sure)</b></label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <input type="text" name="monthrent" class="form-control" placeholder="Rs.1000 to Rs.10000" id="monthrent">
                                                        </div>
                                                    </div>
                                                </div>
                                                <h6 class="center-block"><b>FOOD EXPENDITURES</b></h6>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>6. How much did you spend to buy food items in the last 30 days?<b> Food includes all cereals, pulses, vegetables, oils, meat, dairy, spices and any such thing you eat or use to prepare food.(Record -9 if dont know)</b></label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <input type="text" name="buyfood" class="form-control" placeholder="Rupees" id="buyfood">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="content-group-lg">
                                                            <label>7. In last 30 days, did you consume food that was grown or produced by the household? </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="radio-inline" for="consumefood">
                                                                <input type="radio" name="consumefood" id="consumeNo">
                                                                No
                                                            </label>
                                                            <label class="radio-inline" for="consumefood">
                                                                <input type="radio" name="consumefood" id="consumeYes">
                                                                Yes
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row" id="quantity1">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>8. How much would it cost to buy the quantity of food that was consumed in last 30 days? <b>(Record -9 if dont know)</b></label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <input type="text" name="quantityoffood" id="quantityoffood" class="form-control" placeholder="Rupees">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row" id="wages">
                                                    <div class="col-md-6" >
                                                        <div class="content-group-lg">
                                                            <label>9. In last 30 days, did you consume food that was received as wages-in-kind for work?</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="radio-inline" for="receivedwages">
                                                                <input name="receivedwages" type="radio" id="wagesNo">
                                                                No
                                                            </label>
                                                            <label class="radio-inline" for="receivedwages">
                                                                <input name="receivedwages" type="radio" id="wagesYes">
                                                                Yes
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row" id="quantity2">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>10. How much would it cost to buy the quantity of food that was consumed? <b>(Record -9 if dont know)</b></label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <input type="text" name="costfood" id="costfood" class="form-control" placeholder="Rupees">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row" id="observedrainfall">
                                                    <div class="col-md-6">
                                                        <div class="content-group-lg">
                                                            <label>11. Which type of rainfall mostly observed in your village? <b>(Read the option)</b></label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="radio-inline">
                                                                <input name="rainfall" type="radio">
                                                                Very low 
                                                            </label>
                                                            <label class="radio-inline">
                                                                <input name="rainfall" type="radio">
                                                                Normal
                                                            </label>
                                                            <label class="radio-inline">
                                                                <input name="rainfall" type="radio">
                                                                Medium
                                                            </label>
                                                            <label class="radio-inline">
                                                                <input name="rainfall" type="radio">
                                                                Heavy
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <h6 class="center-block"><b>MIGRATION STATUS</b></h6>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="content-group-lg">
                                                            <label>12. In last one year, does any member of the household migrated to another village/ district/ state for the work?</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="radio-inline" for="migrated">
                                                                <input name="migrated" type="radio" id="migratedNo">
                                                                No
                                                            </label>
                                                            <label class="radio-inline" for="migrated">
                                                                <input name="migrated" type="radio" id="migratedYes">
                                                                Yes
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>13. Why they are migrating?</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="radio-inline">
                                                                <input name="migrating" type="radio" value="Low income from farming">
                                                                Low income from farming
                                                            </label>
                                                            <label class="radio-inline">
                                                                <input name="migrating" type="radio" value="Limited livelihood sources">
                                                                Limited livelihood sources
                                                            </label>
                                                            <label class="radio-inline">
                                                                <input name="migrating" type="radio" value="Low rainfall">
                                                                Low rainfall 
                                                            </label>
                                                            <label class="radio-inline">
                                                                Other
                                                            </label>
                                                            <label class="form-group">
                                                                <input type="text" name="migrating" class="form-control" placeholder="If Other than Specify">
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>14. How many members of the household migrated to another village/ district/ state for the work?</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <input type="text" name="totalmembers" id="totalmembers" class="form-control" placeholder="Number of Members">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>15.  How many times in last year they migrated to another village/ district/ state for the work? <b>(Include all members)</b></label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <input type="text" name="totaltime" id="totaltime" class="form-control" placeholder="Number of Times">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>16. Total how many days they have worked in the migrated area? <b>(Include all members)</b></label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <input type="text" name="totaldays" id="totaldays" class="form-control" placeholder="Number of Days">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="content-group-lg">
                                                            <label>17. Do you think that in last 1 year they have reduced <b>the number of trips of migration?</b> </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="radio-inline">
                                                                <input name="reducedtrips" type="radio" value="Reduced">
                                                                Reduced
                                                            </label>
                                                            <label class="radio-inline">
                                                                <input name="reducedtrips" type="radio" value="No change">
                                                                No change
                                                            </label>
                                                            <label class="radio-inline">
                                                                <input name="reducedtrips" type="radio" value="Increased">
                                                                Increased
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="content-group-lg">
                                                            <label>18. Do you think that in last 1 year they have reduced <b>total number of days of migration? </b> </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="radio-inline">
                                                                <input name="reduceddays" type="radio" value="Reduced">
                                                                Reduced
                                                            </label>
                                                            <label class="radio-inline">
                                                                <input name="reduceddays" type="radio" value="No change">
                                                                No change
                                                            </label>
                                                            <label class="radio-inline">
                                                                <input name="reduceddays" type="radio" value="Increased">
                                                                Increased
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="panel-group panel-group-control content-group-lg" id="accordion-control">
                                                    <div class="panel panel-white" id="nonfood">
                                                        <div class="panel-heading">
                                                            <h6 class="panel-title">
                                                                <a data-toggle="collapse" data-parent="#accordion-control" href="#accordion-control-group1" aria-expanded="false" class="collapsed"><b>NON-FOOD EXPENDITURES</b></a>
                                                            </h6>
                                                        </div>
                                                        <div id="accordion-control-group1" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                                                            <div class="panel-body">
                                                                <label>Think about the money you have spent in last 1 year. Please tell me one by one</label>
                                                                <div class="table-responsive" name="cars[]">
                                                                    <input name="h" type="hidden" id="h" value="0" />
                                                                    <?php
                                                                    # Prepare the SELECT Query
                                                                    $selectSQL = 'SELECT * FROM expense_master';
                                                                    # Execute the SELECT Query
                                                                    if (!( $selectRes = mysql_query($selectSQL) )) {
                                                                        echo 'Retrieval of data from Database Failed - #' . mysql_errno() . ': ' . mysql_error();
                                                                    } else {
                                                                        ?>
                                                                        <table class="table table-bordered">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>Expenses</th>
                                                                                    <th>19. How much do you typically spend on [**EXPENSES**] in an year?<b>(Record -9 if don't know)</b></th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <?php
                                                                                if (mysql_num_rows($selectRes) == 0) {
                                                                                    echo '<tr><td colspan="4">No Rows Returned</td></tr>';
                                                                                } else {
                                                                                    while ($row = mysql_fetch_assoc($selectRes)) {
                                                                                        $expense_id = $row['expense_id'];
                                                                                        $expense_desc = $row['expense_desc'];
                                                                                        ?>
                                                                                        <tr>
                                                                                            <td id="expense_desc<?php echo $expense_desc; ?>"><?php echo $expense_desc; ?></td>
                                                                                            <td id="expense_id"><input type="text" class="form-control" placeholder="Rupees" id="expense_id<?php echo $expense_id; ?>"> </td>
                                                                                            <?php
                                                                                            "</tr>\n";
                                                                                        }
                                                                                    }
                                                                                    ?>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="panel panel-white">
                                                        <div class="panel-heading">
                                                            <h6 class="panel-title">
                                                                <a class="collapsed" data-toggle="collapse" data-parent="#accordion-control" href="#accordion-control-group2" aria-expanded="false"><b>INCOME</b></a>
                                                            </h6>
                                                        </div>
                                                        <div id="accordion-control-group2" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                                                            <div class="panel-body">
                                                                <div class="table-responsive">

                                                                    <?php
                                                                    # Prepare the SELECT Query
                                                                    $selectSQL = 'SELECT * FROM income_type_master';
                                                                    # Execute the SELECT Query
                                                                    if (!( $selectRes = mysql_query($selectSQL) )) {
                                                                        echo 'Retrieval of data from Database Failed - #' . mysql_errno() . ': ' . mysql_error();
                                                                    } else {
                                                                        ?>
                                                                        <table class="table table-bordered">
                                                                            <thead>
                                                                                <tr>
                                                                                    <td colspan="2">20. Please tell me which of the following <b>[**SOURCE**]</b> of income your household has received <b>during the last 12 months.</b> </td>
                                                                                    <td>21. How much is the "net" income your household earned from <b>[**SOURCE**]</b> in last 12 months?<br/> <b>(Net income is revenue – any expense)<br/>(-9) Don’t know </b></td>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <?php
                                                                                if (mysql_num_rows($selectRes) == 0) {
                                                                                    echo '<tr><td colspan="4">No Rows Returned</td></tr>';
                                                                                } else {
                                                                                    while ($row = mysql_fetch_assoc($selectRes)) {
                                                                                        echo "<tr>"
                                                                                        . "<td>{$row['income_type']}</td>"
                                                                                        ?>
                                                                                    <td>
                                                                                        <div class="form-group">
                                                                                            <select name="income<?php echo $row['income_id']; ?>" class="form-control">
                                                                                                <option value="">Select</option>
                                                                                                <option value="No">No(Skip to next source)</option>
                                                                                                <option value="Yes">Yes</option>
                                                                                                <option value="Don't know">Don't know(Skip to next source)</option>
                                                                                            </select>
                                                                                        </div>
                                                                                    </td>
                                                                                    <!--<input type="hidden" name="income_id"/>-->
            <!--                                                                                    <td><input id="<?php echo $row['income_id']; ?>" type="text" class="form-control incomebox1<?php //echo $row['income_id'];   ?>" placeholder="Rupees Earned" name="sub" onchange="handleChange('//incomeBox1<?php //echo $row['income_id'];   ?>');" /></td>-->
                                                                                    <td><input type="number" id="<?php echo $row['income_id']; ?>" class="form-control incomebox1<?php echo $row['income_id']; ?>" placeholder="Rupees Earned" name="income_textbox<?php echo $row['income_id']; ?>"/>
            <!--                                                                                        <p class="validate<?php //echo $row['income_id'];   ?>">*Give Range(100 to 15000)</p>
                                                                                        <p class="validate<?php //echo $row['income_id'];   ?>">*Give Range(500 to 25000)</p>-->
                                                                                        <p class="validate<?php echo $row['income_id']; ?>"></p>
                                                                                        <!--<p class="validate<?php //echo $row['income_id'];   ?>"></p>-->  
                                                                                        <?php
                                                                                        if ($row['income_id'] == 1) {
                                                                                            ?>
                                                                                            <p class="hint<?php echo $row['income_id']; ?>">Hint Give Range (1000 to 200000)</p>
                                                                                            <?php
                                                                                        } elseif ($row['income_id'] == 2) {
                                                                                            ?>
                                                                                            <p class="hint<?php echo $row['income_id']; ?>">Hint Give Range (1000 to 300000)</p>
                                                                                            <?php
                                                                                        } elseif ($row['income_id'] == 3) {
                                                                                            ?>
                                                                                            <p class="hint<?php echo $row['income_id']; ?>">Hint Give Range (1000 to 300000)</p>
                                                                                            <?php
                                                                                        } elseif ($row['income_id'] == 4) {
                                                                                            ?>
                                                                                            <p class="hint<?php echo $row['income_id']; ?>">Hint Give Range (1000 to 300000)</p>
                                                                                            <?php
                                                                                        } elseif ($row['income_id'] == 5) {
                                                                                            ?>
                                                                                            <p class="hint<?php echo $row['income_id']; ?>">Hint Give Range (1000 to 300000)</p>
                                                                                            <?php
                                                                                        } elseif ($row['income_id'] == 6) {
                                                                                            ?>
                                                                                            <p class="hint<?php echo $row['income_id']; ?>">Hint Give Range (1000 to 300000)</p>
                                                                                            <?php
                                                                                        } elseif ($row['income_id'] == 7) {
                                                                                            ?>
                                                                                            <p class="hint<?php echo $row['income_id']; ?>">Hint Give Range (1000 to 300000)</p>
                                                                                            <?php
                                                                                        } elseif ($row['income_id'] == 8) {
                                                                                            ?>
                                                                                            <p class="hint<?php echo $row['income_id']; ?>">Hint Give Range (1000 to 300000)</p>
                                                                                            <?php
                                                                                        } elseif ($row['income_id'] == 9) {
                                                                                            ?>
                                                                                            <p class="hint<?php echo $row['income_id']; ?>">Hint Give Range (1000 to 300000)</p>
                                                                                            <?php
                                                                                        } elseif ($row['income_id'] == 10) {
                                                                                            ?>
                                                                                            <p class="hint<?php echo $row['income_id']; ?>">Hint Give Range (1000 to 300000)</p>
                                                                                            <?php
                                                                                        } elseif ($row['income_id'] == 11) {
                                                                                            ?>
                                                                                            <p class="hint<?php echo $row['income_id']; ?>">Hint Give Range (1000 to 100000)</p>
                                                                                            <?php
                                                                                        } elseif ($row['income_id'] == 12) {
                                                                                            ?>
                                                                                            <p class="hint<?php echo $row['income_id']; ?>">Hint Give Range (1000 to 300000)</p>
                                                                                            <?php
                                                                                        } elseif ($row['income_id'] == 13) {
                                                                                            ?>
                                                                                            <p class="hint<?php echo $row['income_id']; ?>">Hint Give Range (1000 to 300000)</p>
                                                                                            <?php
                                                                                        } elseif ($row['income_id'] == 14) {
                                                                                            ?>
                                                                                            <p class="hint<?php echo $row['income_id']; ?>">Hint Give Range (1000 to 300000)</p>
                                                                                            <?php
                                                                                        }
                                                                                        ?>                                                                                        
                                                                                    </td>                                                                                    
                                                                                    <?php
                                                                                    "</tr>\n";
                                                                                }
                                                                            }
                                                                            ?>
                                                                            </tr>
                                                                            </tbody>
                                                                        </table>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="panel panel-white">
                                                        <div class="panel-heading">
                                                            <h6 class="panel-title">
                                                                <a class="collapsed" data-toggle="collapse" data-parent="#accordion-control" href="#accordion-control-group3" aria-expanded="false"><b>ASSET / CONSUMER DURABLES</b></a>
                                                            </h6>
                                                        </div>
                                                        <div id="accordion-control-group3" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                                                            <div class="panel-body">
                                                                <div class="table-responsive">
                                                                    <?php
                                                                    # Prepare the SELECT Query
                                                                    $selectSQL = 'SELECT * FROM asset_type_master';
                                                                    # Execute the SELECT Query
                                                                    if (!( $selectRes = mysql_query($selectSQL) )) {
                                                                        echo 'Retrieval of data from Database Failed - #' . mysql_errno() . ': ' . mysql_error();
                                                                    } else {
                                                                        ?>
                                                                        <table class="table table-bordered">
                                                                            <thead>
                                                                                <tr>
                                                                                    <td>Asset / consumer durables</td>
                                                                                    <td>22. How many <b>[**ASSETS**]</b> does your household have?</td>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <?php
                                                                                if (mysql_num_rows($selectRes) == 0) {
                                                                                    echo '<tr><td colspan="4">No Rows Returned</td></tr>';
                                                                                } else {
                                                                                    while ($row = mysql_fetch_assoc($selectRes)) {
                                                                                        echo "<tr>"
                                                                                        . "<td>{$row['asset_name']}</td>"
                                                                                        ?>
                                                                                                    <!--<td><input type="text" class="form-control" placeholder="Number" name="sub<?php //echo $row;    ?>"/></td>-->
                                                                                    <td><input type="number" id="<?php echo $row['asset_type_id']; ?>" class="form-control asset_box1<?php echo $row['asset_type_id']; ?>" placeholder="Number" name="asset_textbox<?php echo $row['asset_type_id']; ?>"/>
            <!--                                                                                        <p class="validate<?php //echo $row['income_id'];   ?>">*Give Range(100 to 15000)</p>
                                                                                        <p class="validate<?php //echo $row['income_id'];  ?>">*Give Range(500 to 25000)</p>-->
                                                                                        <p class="asset_validate<?php echo $row['asset_type_id']; ?>"></p>
                                                                                        <!--<p class="validate<?php //echo $row['income_id'];  ?>"></p>-->  
                                                                                        <?php
                                                                                        if ($row['asset_type_id'] == 1) {
                                                                                            ?>
                                                                                            <p class="asset_hint<?php echo $row['asset_type_id']; ?>">Hint Give Range (01 to 10)</p>
                                                                                            <?php
                                                                                        } elseif ($row['asset_type_id'] == 2) {
                                                                                            ?>
                                                                                            <p class="asset_hint<?php echo $row['asset_type_id']; ?>">Hint Give Range (01 to 02)</p>
                                                                                            <?php
                                                                                        } elseif ($row['asset_type_id'] == 3) {
                                                                                            ?>
                                                                                            <p class="asset_hint<?php echo $row['asset_type_id']; ?>">Hint Give Range (01 to 05)</p>
                                                                                            <?php
                                                                                        } elseif ($row['asset_type_id'] == 4) {
                                                                                            ?>
                                                                                            <p class="asset_hint<?php echo $row['asset_type_id']; ?>">Hint Give Range (01 to 10)</p>
                                                                                            <?php
                                                                                        } elseif ($row['asset_type_id'] == 5) {
                                                                                            ?>
                                                                                            <p class="asset_hint<?php echo $row['asset_type_id']; ?>">Hint Give Range (01 to 05)</p>
                                                                                            <?php
                                                                                        } elseif ($row['asset_type_id'] == 6) {
                                                                                            ?>
                                                                                            <p class="asset_hint<?php echo $row['asset_type_id']; ?>">Hint Give Range (01 to 03)</p>
                                                                                            <?php
                                                                                        } elseif ($row['asset_type_id'] == 7) {
                                                                                            ?>
                                                                                            <p class="asset_hint<?php echo $row['asset_type_id']; ?>">Hint Give Range (01 to 10)</p>
                                                                                            <?php
                                                                                        } elseif ($row['asset_type_id'] == 8) {
                                                                                            ?>
                                                                                            <p class="asset_hint<?php echo $row['asset_type_id']; ?>">Hint Give Range (01 to 10)</p>
                                                                                            <?php
                                                                                        } elseif ($row['asset_type_id'] == 9) {
                                                                                            ?>
                                                                                            <p class="asset_hint<?php echo $row['asset_type_id']; ?>">Hint Give Range (01 to 05)</p>
                                                                                            <?php
                                                                                        } elseif ($row['asset_type_id'] == 10) {
                                                                                            ?>
                                                                                            <p class="asset_hint<?php echo $row['asset_type_id']; ?>">Hint Give Range (01 to 10)</p>
                                                                                            <?php
                                                                                        } elseif ($row['asset_type_id'] == 11) {
                                                                                            ?>
                                                                                            <p class="asset_hint<?php echo $row['asset_type_id']; ?>">Hint Give Range (01 to 25)</p>
                                                                                            <?php
                                                                                        } elseif ($row['asset_type_id'] == 12) {
                                                                                            ?>
                                                                                            <p class="asset_hint<?php echo $row['asset_type_id']; ?>">Hint Give Range (01 to 30)</p>
                                                                                            <?php
                                                                                        } elseif ($row['asset_type_id'] == 13) {
                                                                                            ?>
                                                                                            <p class="asset_hint<?php echo $row['asset_type_id']; ?>">Hint Give Range (01 to 10)</p>
                                                                                            <?php
                                                                                        } elseif ($row['asset_type_id'] == 14) {
                                                                                            ?>
                                                                                            <p class="asset_hint<?php echo $row['asset_type_id']; ?>">Hint Give Range (01 to 10)</p>
                                                                                            <?php
                                                                                        }
                                                                                        ?>                                                                                        
                                                                                    </td>                                                                            
                                                                                    <?php
                                                                                    "</tr>\n";
                                                                                }
                                                                            }
                                                                            ?>
                                                                            </tr>
                                                                            </tbody>
                                                                        </table>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="panel panel-white">
                                                        <div class="panel-heading">
                                                            <h6 class="panel-title">
                                                                <a class="collapsed" data-toggle="collapse" data-parent="#accordion-control" href="#accordion-control-group4" aria-expanded="false"><b>SAVINGS</b></a>
                                                            </h6>
                                                        </div>
                                                        <div id="accordion-control-group4" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                                                            <div class="panel-body">
                                                                <div class="table-responsive">
                                                                    <?php
                                                                    # Prepare the SELECT Query
                                                                    $selectSQL = 'SELECT * FROM savings_master';
                                                                    # Execute the SELECT Query
                                                                    if (!( $selectRes = mysql_query($selectSQL) )) {
                                                                        echo 'Retrieval of data from Database Failed - #' . mysql_errno() . ': ' . mysql_error();
                                                                    } else {
                                                                        ?>
                                                                        <table class="table table-bordered">
                                                                            <thead>
                                                                                <tr>
                                                                                    <td>Sources of Saving in this Neighborhood or Locality</td>
                                                                                    <td>23. Has your household saved at <b>[**SOURCE**]</b> in the last 12 months?</td>
                                                                                    <td>24. How much have you saved at <b>[**SOURCE**]</b> in last 12 months? <br/> <br/>(-9) Don’t know/ refuse to tell</td>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <?php
                                                                                if (mysql_num_rows($selectRes) == 0) {
                                                                                    echo '<tr><td colspan="4">No Rows Returned</td></tr>';
                                                                                } else {
                                                                                    while ($row = mysql_fetch_assoc($selectRes)) {
                                                                                        echo "<tr>"
                                                                                        . "<td>{$row['savings_source']}</td>"
                                                                                        ?>
                                                                                    <td>
                                                                                        <div class="form-group">
                                                                                            <select name="savings<?php echo $row['savings_id']; ?>" class="form-control">
                                                                                                <option value="null">select</option>
                                                                                                <option value="No">No(Skip to next source)</option>
                                                                                                <option value="Yes">Yes</option>
                                                                                                <option value="Don't know">Don't know(Skip to next source)</option>
                                                                                            </select>
                                                                                        </div>
                                                                                    </td>
                                                                                    <!--<td><input type="text" class="form-control" placeholder="Rupees" name="sub<?php //echo $row;    ?>"> </td>-->
                                                                                    <td><input type="number" id="<?php echo $row['savings_id']; ?>" class="form-control sav_box1<?php echo $row['savings_id']; ?>" placeholder="Rupees" name="sav_textbox<?php echo $row['savings_id']; ?>"/>
            <!--                                                                                        <p class="validate<?php //echo $row['income_id'];  ?>">*Give Range(100 to 15000)</p>
                                                                                        <p class="validate<?php //echo $row['income_id'];  ?>">*Give Range(500 to 25000)</p>-->
                                                                                        <p class="sav_validate<?php echo $row['savings_id']; ?>"></p>
                                                                                        <!--<p class="validate<?php //echo $row['income_id'];   ?>"></p>-->  
                                                                                        <?php
                                                                                        if ($row['savings_id'] == 1) {
                                                                                            ?>
                                                                                            <p class="sav_hint<?php echo $row['savings_id']; ?>">Hint Give Range (1000 to 5000)</p>
                                                                                            <?php
                                                                                        } elseif ($row['savings_id'] == 2) {
                                                                                            ?>
                                                                                            <p class="sav_hint<?php echo $row['savings_id']; ?>">Hint Give Range (500 to 50000)</p>
                                                                                            <?php
                                                                                        } elseif ($row['savings_id'] == 3) {
                                                                                            ?>
                                                                                            <p class="sav_hint<?php echo $row['savings_id']; ?>">Hint Give Range (1000 to 50000)</p>
                                                                                            <?php
                                                                                        } elseif ($row['savings_id'] == 4) {
                                                                                            ?>
                                                                                            <p class="sav_hint<?php echo $row['savings_id']; ?>">Hint Give Range (1000 to 500000)</p>
                                                                                            <?php
                                                                                        } elseif ($row['savings_id'] == 5) {
                                                                                            ?>
                                                                                            <p class="sav_hint<?php echo $row['savings_id']; ?>">Hint Give Range (1000 to 100000)</p>
                                                                                            <?php
                                                                                        } elseif ($row['savings_id'] == 6) {
                                                                                            ?>
                                                                                            <p class="sav_hint<?php echo $row['savings_id']; ?>">Hint Give Range (1000 to 100000)</p>
                                                                                            <?php
                                                                                        } elseif ($row['savings_id'] == 7) {
                                                                                            ?>
                                                                                            <p class="sav_hint<?php echo $row['savings_id']; ?>">Hint Give Range (1000 to 50000)</p>
                                                                                            <?php
                                                                                        } elseif ($row['savings_id'] == 8) {
                                                                                            ?>
                                                                                            <p class="sav_hint<?php echo $row['savings_id']; ?>">Hint Give Range (1000 to 50000)</p>
                                                                                            <?php
                                                                                        } elseif ($row['savings_id'] == 9) {
                                                                                            ?>
                                                                                            <p class="sav_hint<?php echo $row['savings_id']; ?>">Hint Give Range Number Only</p>
                                                                                            <?php
                                                                                        }
                                                                                        ?>                                                                                        
                                                                                    </td>                                                                                    
                                                                                    <?php
                                                                                    "</tr>\n";
                                                                                }
                                                                            }
                                                                            ?>
                                                                            </tr>
                                                                            </tbody>
                                                                        </table>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="text-right">
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
    </body>
</html>
