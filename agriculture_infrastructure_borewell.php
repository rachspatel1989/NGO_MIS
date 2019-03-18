<html lang="en">
    <head>
        <script type="text/javascript">
            $(function () {
                $("#communityhide2").hide();
                $("#communityYes2").on("input", function () {
                    $("#communityhide2").toggle();
                });
            });
        </script>
        <script type="text/javascript">
            $(function () {
                $("input[name='source_usability_bore']").click(function () {
                    if ($("#communityNo2").is(":checked")) {
                        $("#communityhide2").hide();
                    }
                    if ($("#communityYes2").is(":checked")) {
                        $("#communityhide2").show();
                    }

                });
            });
        </script>

        <script type="text/javascript">
            $(function () {
                $("#useirrigationhide2").hide();
                $("#useirrigationYes2").on("input", function () {
                    $("#communityhide2").toggle();
                });
            });
        </script>
        <script type="text/javascript">
            $(function () {
                $("input[name='issource_own_leasebore']").click(function () {
                    if ($("#useirrigationNo2").is(":checked")) {
                        $("#useirrigationhide2").hide();
                    }
                    if ($("#useirrigationYes2").is(":checked")) {
                        $("#useirrigationhide2").show();
                    }

                });
            });
        </script>
        <script type="text/javascript">
            $(document).ready(function () {
                //Uncheck the CheckBox initially
                $('#havesource_type_own2').removeAttr('checked');
                // Initially, Hide the SSN textbox when Web Form is loaded
                $('#havesource_type_ownhide2').hide();
                $('#havesource_type_own2').change(function () {
                    if (this.checked) {
                        $('#havesource_type_ownhide2').show();
                    } else {
                        $('#havesource_type_ownhide2').hide();
                    }
                });
            });
        </script>

        <script type="text/javascript">
            $(document).ready(function () {
                //Uncheck the CheckBox initially
                $('#havesource_type_lease2').removeAttr('checked');
                // Initially, Hide the SSN textbox when Web Form is loaded
                $('#havesource_type_leasehide2').hide();
                $('#havesource_type_lease2').change(function () {
                    if (this.checked) {
                        $('#havesource_type_leasehide2').show();
                    } else {
                        $('#havesource_type_leasehide2').hide();
                    }
                });
            });
        </script>

        <script type="text/javascript">
            $(document).ready(function () {
                //Uncheck the CheckBox initially
                $('#havesource_type_useingroup2').removeAttr('checked');
                // Initially, Hide the SSN textbox when Web Form is loaded
                $('#havesource_type_useingrouphide2').hide();
                $('#havesource_type_useingroup2').change(function () {
                    if (this.checked) {
                        $('#havesource_type_useingrouphide2').show();
                    } else {
                        $('#havesource_type_useingrouphide2').hide();
                    }
                });
            });
        </script>
    </head>
    <body>
        <div class="content">
            <div class="product-item float-clear" style="clear:both;">
<!--                <div class="form-group">
                    <div class="col-lg-12">
                        <input type="checkbox" name="item_index[]" />
                    </div>
                </div><br/>-->

                <div class="row" id="l3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <h3>Bore Well</h3>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <input type="hidden" name="source_type2" value="Bore Well"/>
<!--                            <select name="select" class="form-control" name="source_name[]">
                                <option value="null">Select</option>
                                <option value="Dug Well">Dug Well</option>
                                <option value="Bore Well">Bore Well</option>
                                <option value="Pipeline">Pipeline</option>
                            </select>-->
                            
                        </div>
                    </div>
                </div>

                <div class="row" id="Q11">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>11. Is the <b>[**Source**]</b> available in community (include source near your farm), whether you used or not?</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="radio">
                                <label class="radio-inline">
                                    <input type="radio" name="source_usability_bore" id="communityNo2" value="No" checked="">
                                    No
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="source_usability_bore" id="communityYes2" value="Yes">
                                    Yes
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="communityhide2">
                    <div class="row" id="Q12">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>12. Is the <b>[**Source**]</b> used for irrigation on your farm land (leased or own)?</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="radio">
                                    <label class="radio-inline">
                                        <input name="issource_own_lease_bore" id="useirrigationNo2" type="radio" value="No">
                                        No 
                                    </label>
                                    <label class="radio-inline">
                                        <input name="issource_own_lease_bore" id="useirrigationYes2" type="radio" value="Yes">
                                        Yes
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="useirrigationhide2">
                        <div class="row" id="Q13">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>13. Is this <b>[**Source**]</b> your own or use it on lease or use in group of farmes?</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="checkbox-inline" for="havesource_type_own2">
                                        <input name="havesource_type_bore" id="havesource_type_own2" type="checkbox" value="Own">
                                        <b>Own</b>
                                    </label>
                                    <label class="checkbox-inline" for="havesource_type_lease2">
                                        <input name="havesource_type_bore" id="havesource_type_lease2" type="checkbox" value="Lease">
                                        <b>Lease</b>
                                    </label>
                                    <label class="checkbox-inline" for="havesource_type_useingroup2">
                                        <input name="havesource_type_bore" id="havesource_type_useingroup2" type="checkbox" value="Use in group of farmers">
                                        <b>Use in group of farmers</b>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div id="havesource_type_ownhide2">
                            <div class="row" id="Q14">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>14. How many OWN <b>[**Source**]</b> do you have?</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" name="own_source_bore" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="row" id="Q151">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>15. Is the water from OWN<b>[**Source**]</b>adequate during Kharif/ Rabi/ Summer?</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>a. Kharif</label>
                                        <select name="select" class="form-control" name="iswater_own_kharif_bore">
                                            <option value="null">Select</option>
                                            <option value="Adequate">Adequate</option>
                                            <option value="Somewhat adequate">Somewhat adequate</option>
                                            <option value="Not adequate">Not adequate</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>b. Rabi</label>
                                        <select name="select" class="form-control" name="iswater_own_rabi_bore">
                                            <option value="null">Select</option>
                                            <option value="Adequate">Adequate</option>
                                            <option value="Somewhat adequate">Somewhat adequate</option>
                                            <option value="Not adequate">Not adequate</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>c. Summer</label>
                                        <select name="select" class="form-control" name="iswater_own_summer_bore">
                                            <option value="null">Select</option>
                                            <option value="Adequate">Adequate</option>
                                            <option value="Somewhat adequate">Somewhat adequate</option>
                                            <option value="Not adequate">Not adequate</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="havesource_type_leasehide2">
                            <div class="row" id="Q16">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>16. How many lease <b>[**Source**]</b> do you have?</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" name="lease_source_bore" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="row" id="Q171">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>17. Is the water from lease <b>[**Source**]</b> adequate during Kharif/ Rabi/ Summer?</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>a. Kharif</label>
                                        <select name="select" class="form-control" name="iswater_lease_kharif_bore">
                                            <option value="null">Select</option>
                                            <option value="Adequate">Adequate</option>
                                            <option value="Somewhat adequate">Somewhat adequate</option>
                                            <option value="Not adequate">Not adequate</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>b. Rabi</label>
                                        <select name="select" class="form-control" name="iswater_lease_rabi_bore">
                                            <option value="null">Select</option>
                                            <option value="Adequate">Adequate</option>
                                            <option value="Somewhat adequate">Somewhat adequate</option>
                                            <option value="Not adequate">Not adequate</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>c. Summer</label>
                                        <select name="select" class="form-control" name="iswater_lease_summer_bore">
                                            <option value="null">Select</option>
                                            <option value="Adequate">Adequate</option>
                                            <option value="Somewhat adequate">Somewhat adequate</option>
                                            <option value="Not adequate">Not adequate</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="havesource_type_useingrouphide2">
                            <div class="row" id="Q18">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>18. How many GROUP <b>[**Source**]</b> do you have?</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" name="group_source_bore" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="row" id="Q191">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>19. Is the water from GROUP <b>[**Source**]</b> adequate during Kharif/ Rabi/ Summer?</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>a. Kharif</label>
                                        <select name="select" class="form-control" name="iswater_group_kharif_bore">
                                            <option value="null">Select</option>
                                            <option value="Adequate">Adequate</option>
                                            <option value="Somewhat adequate">Somewhat adequate</option>
                                            <option value="Not adequate">Not adequate</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>b. Rabi</label>
                                        <select name="select" class="form-control" name="iswater_group_rabi_bore">
                                            <option value="null">Select</option>
                                            <option value="Adequate">Adequate</option>
                                            <option value="Somewhat adequate">Somewhat adequate</option>
                                            <option value="Not adequate">Not adequate</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>c. Summer</label>
                                        <select name="select" class="form-control" name="iswater_group_summer_bore">
                                            <option value="null">Select</option>
                                            <option value="Adequate">Adequate</option>
                                            <option value="Somewhat adequate">Somewhat adequate</option>
                                            <option value="Not adequate">Not adequate</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>