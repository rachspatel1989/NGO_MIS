<html lang="en">
    <head>
        <script type="text/javascript">
            $(function () {
                $("#communityhide3").hide();
                $("#communityYes3").on("input", function () {
                    $("#communityhide3").toggle();
                });
            });
        </script>
        <script type="text/javascript">
            $(function () {
                $("input[name='source_usability_pipe']").click(function () {
                    if ($("#communityNo3").is(":checked")) {
                        $("#communityhide3").hide();
                    }
                    if ($("#communityYes3").is(":checked")) {
                        $("#communityhide3").show();
                    }

                });
            });
        </script>

        <script type="text/javascript">
            $(function () {
                $("#useirrigationhide3").hide();
                $("#useirrigationYes3").on("input", function () {
                    $("#communityhide3").toggle();
                });
            });
        </script>
        <script type="text/javascript">
            $(function () {
                $("input[name='issource_own_leasepipe']").click(function () {
                    if ($("#useirrigationNo3").is(":checked")) {
                        $("#useirrigationhide3").hide();
                    }
                    if ($("#useirrigationYes3").is(":checked")) {
                        $("#useirrigationhide3").show();
                    }

                });
            });
        </script>
        <script type="text/javascript">
            $(document).ready(function () {
                //Uncheck the CheckBox initially
                $('#havesource_type_own3').removeAttr('checked');
                // Initially, Hide the SSN textbox when Web Form is loaded
                $('#havesource_type_ownhide3').hide();
                $('#havesource_type_own3').change(function () {
                    if (this.checked) {
                        $('#havesource_type_ownhide3').show();
                    } else {
                        $('#havesource_type_ownhide3').hide();
                    }
                });
            });
        </script>

        <script type="text/javascript">
            $(document).ready(function () {
                //Uncheck the CheckBox initially
                $('#havesource_type_lease3').removeAttr('checked');
                // Initially, Hide the SSN textbox when Web Form is loaded
                $('#havesource_type_leasehide3').hide();
                $('#havesource_type_lease3').change(function () {
                    if (this.checked) {
                        $('#havesource_type_leasehide3').show();
                    } else {
                        $('#havesource_type_leasehide3').hide();
                    }
                });
            });
        </script>

        <script type="text/javascript">
            $(document).ready(function () {
                //Uncheck the CheckBox initially
                $('#havesource_type_useingroup3').removeAttr('checked');
                // Initially, Hide the SSN textbox when Web Form is loaded
                $('#havesource_type_useingrouphide3').hide();
                $('#havesource_type_useingroup3').change(function () {
                    if (this.checked) {
                        $('#havesource_type_useingrouphide3').show();
                    } else {
                        $('#havesource_type_useingrouphide3').hide();
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
                            <h3>Pipe Line</h3>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <input type="hidden" name="source_type3" value="Pipeline"/>
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
                                    <input type="radio" name="source_usability_pipe" id="communityNo3" value="No" checked="">
                                    No
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="source_usability_pipe" id="communityYes3" value="Yes">
                                    Yes
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="communityhide3">
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
                                        <input name="issource_own_lease_pipe" id="useirrigationNo3" type="radio" value="No">
                                        No 
                                    </label>
                                    <label class="radio-inline">
                                        <input name="issource_own_lease_pipe" id="useirrigationYes3" type="radio" value="Yes">
                                        Yes
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="useirrigationhide3">
                        <div class="row" id="Q13">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>13. Is this <b>[**Source**]</b> your own or use it on lease or use in group of farmes?</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="checkbox-inline" for="havesource_type_own2">
                                        <input name="havesource_type_pipe" id="havesource_type_own3" type="checkbox" value="Own">
                                        <b>Own</b>
                                    </label>
                                    <label class="checkbox-inline" for="havesource_type_lease2">
                                        <input name="havesource_type_pipe" id="havesource_type_lease3" type="checkbox" value="Lease">
                                        <b>Lease</b>
                                    </label>
                                    <label class="checkbox-inline" for="havesource_type_useingroup2">
                                        <input name="havesource_type_pipe" id="havesource_type_useingroup3" type="checkbox" value="Use in group of farmers">
                                        <b>Use in group of farmers</b>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div id="havesource_type_ownhide3">
                            <div class="row" id="Q14">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>14. How many OWN <b>[**Source**]</b> do you have?</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" name="own_source_pipe" class="form-control">
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
                                        <select name="select" class="form-control" name="iswater_own_kharif_pipe">
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
                                        <select name="select" class="form-control" name="iswater_own_rabi_pipe">
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
                                        <select name="select" class="form-control" name="iswater_own_summer_pipe">
                                            <option value="null">Select</option>
                                            <option value="Adequate">Adequate</option>
                                            <option value="Somewhat adequate">Somewhat adequate</option>
                                            <option value="Not adequate">Not adequate</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="havesource_type_leasehide3">
                            <div class="row" id="Q16">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>16. How many lease <b>[**Source**]</b> do you have?</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" name="lease_source_pipe" class="form-control">
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
                                        <select name="select" class="form-control" name="iswater_lease_kharif_pipe">
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
                                        <select name="select" class="form-control" name="iswater_lease_rabi_pipe">
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
                                        <select name="select" class="form-control" name="iswater_lease_summer_pipe">
                                            <option value="null">Select</option>
                                            <option value="Adequate">Adequate</option>
                                            <option value="Somewhat adequate">Somewhat adequate</option>
                                            <option value="Not adequate">Not adequate</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="havesource_type_useingrouphide3">
                            <div class="row" id="Q18">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>18. How many GROUP <b>[**Source**]</b> do you have?</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" name="group_source_pipe" class="form-control">
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
                                        <select name="select" class="form-control" name="iswater_group_kharif_pipe">
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
                                        <select name="select" class="form-control" name="iswater_group_rabi_pipe">
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
                                        <select name="select" class="form-control" name="iswater_group_summer_pipe">
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