<!DOCTYPE html>
<html>
<head>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

    <script src="./libs/code.jquery.com/jquery-3.5.1.js"></script>
    <link href="./css/fontawesome/font-awesome.min.css" rel="stylesheet">
    <link href="./libs/bootstrap-4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="./libs/bootstrap-4.5.2/js/bootstrap.min.js"></script>

    <script src="./libs/jquery-ui-1.12.1/jquery-ui.js"></script>
    <link href="./libs/jquery-ui-1.12.1/jquery-ui.css" rel="stylesheet">
    <script src="./libs/jquery-timepicker-1.3.5/jquery.timepicker.js"></script>
    <link href="./libs/jquery-timepicker-1.3.5/jquery.timepicker.css" rel="stylesheet">
    <script src="./libs/webcamjs/1.0.25/webcam.min.js"></script>

    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>    
    <link rel="stylesheet" type="text/css" href="./css/style.css" />
    <script src="./js/index.js"></script>
</head>
<body>
    <div class="container" id="gmaps_div">
        <div class="jumbotron">

        </div>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Your Name: </label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="radio" name="pname" id="pname_alex" value="0" checked/>
                            <label for="pname_alex">Alex</label>&nbsp;&nbsp;
                            <input type="radio" name="pname" id="pname_mike" value="1"/>
                            <label for="pname_mike">Mike</label>&nbsp;&nbsp;
                            <input type="radio" name="pname" id="pname_marc" value="2"/>
                            <label for="pname_marc">Marc</label>&nbsp;&nbsp;
                            <input type="radio" name="pname" id="pname_jason" value="3"/>
                            <label for="pname_jason">Jason</label>&nbsp;&nbsp;
                            <input type="radio" name="pname" id="pname_other" value="4"/>
                            <label for="pname_other">Other</label>&nbsp;&nbsp;
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="text" id="inp_name_other" class="form-control" value="" placeholder="Enter your whole name." style="display:none;"/>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="inp_job">Job Name:</label>
                            <input type="text" id="inp_job" class="form-control required" maxlength="120" placeholder=""/>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="start_date">Start Date:</label>
                            <input type="text" id="start_date" class="form-control required" value=""/>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-8 mb-4">
                        <div class="iframe-container">
                            <!--The div elements for the map and message -->
                            <div id="map"></div>
                            <div id="infowindow-content-start">
                                <span id="place-name-start" class="title"></span><br />
                                <span id="place-address-start"></span>
                            </div>
                            <div id="infowindow-content-dest">
                                <span id="place-name-dest" class="title"></span><br />
                                <span id="place-address-dest"></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="form-group">
                            <div id="title">Autocomplete search</div>
                            <div id="type-selector" class="pac-controls d-flex flex-wrap justify-content-between">
                                <div>
                                    <input type="radio" name="type" id="changetype-all" checked="checked"/>
                                    <label for="changetype-all">All</label>
                                </div>
                                <div>
                                    <input type="radio" name="type" id="changetype-establishment" />
                                    <label for="changetype-establishment">Establishments</label>
                                </div>
                                <div>
                                    <input type="radio" name="type" id="changetype-address" />
                                    <label for="changetype-address">Addresses</label>
                                </div>
                                <div>
                                    <input type="radio" name="type" id="changetype-geocode" />
                                    <label for="changetype-geocode">Geocodes</label>
                                </div>
                            </div>
                            <div id="strict-bounds-selector" class="pac-controls">
                                <input type="checkbox" id="use-location-bias" value="" checked />
                                <label for="use-location-bias">Bias to map viewport</label>
                                
                                <input type="checkbox" id="use-strict-bounds" value="" />
                                <label for="use-strict-bounds">Strict bounds</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="pac-addr-start">Starting location:</label>
                            <input type="text" id="pac-addr-start" class="form-control required" />
                        </div>
                        <div class="form-group">
                            <label for="pac-addr-dest">Destination:</label>
                            <input type="text" id="pac-addr-dest" class="form-control required" />
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="sel_job_rooms">Rooms For Job: </label>
                            <select id="sel_job_rooms" class="form-control required">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="inp_job_hours">Job Hours: </label>
                            <input type="number" id="inp_job_hours" min="1" max="40" class="form-control required" value="1"/>
                        </div>
                    </div>
                    <div class="col-md-4">
                        
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Hotel: </label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="radio" name="has_hotel" id="hotel_yes" value="1" checked/>
                            <label for="hotel_yes">Yes</label>&nbsp;&nbsp;
                            <input type="radio" name="has_hotel" id="hotel_no" value="0"/>
                            <label for="hotel_no">No
                        </div>
                    </div>
                </div>
                <div id="hotel_info">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="inp_hotel_name">Name of hotel:</label>
                                <input type="text" id="inp_hotel_name" class="form-control" maxlength="120" placeholder=""/>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="inp_hotel_stayed">Nights stayed:</label>
                                <input type="number" id="inp_hotel_stayed" class="form-control" min="1" max="14" value="1"/>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Add an additional expense (excluding meals): </label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="radio" name="has_add_expense" id="add_expense_yes" value="1" checked/>
                            <label for="add_expense_yes">Yes</label>&nbsp;&nbsp;
                            <input type="radio" name="has_add_expense" id="add_expense_no" value="0"/>
                            <label for="add_expense_no">No
                        </div>
                    </div>
                </div>
                <div id="expense_info">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="paid_name">Name of company or person paid: </label>
                                <input type="text" id="paid_name" class="form-control" value="" maxlength="120"/>
                            </div>
                        </div>
                    </div>
                    <div id="expense_container">

                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="txt_note">Notes on entire trip: </label>
                            <textarea id="txt_note" name="txt_note" class="form-control" style="padding-bottom: 10%;" placeholder=""></textarea>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group" align="center">
                            <h5 id="msg"></h5>
                            <h6 id="msg2"></h6>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">

                    </div>
                    <div class="col-md-6">
                        <div class="form-group" align="center">
                            <button id="btn_reset" class="btn btn-danger" onclick="location.reload()"><i class="fa fa-undo"></i> Reset</button>
                            <button id="btn_info_submit" class="btn btn-success ml-5" onclick="delay_submit()"><i class="fa fa-paper-plane"></i> Submit</button>
                        </div>
                    </div>
                    <div class="col-md-3">
                        
                    </div>
                </div>
            </div>
        </div>  
    </div>
    <!--Load the API from the specified URL -- remember to replace YOUR_API_KEY-->
    
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAlF-d3rdfefTmBKRYTsXlm_b0lT1PkVf8&libraries=places&callback=initMap"></script>
    
</body>
</html>
<script language="javascript">
    var cur_name_sel = eval($("input[name='pname']:checked").val());
    var cur_index = 1;
    $(document).ready(function(){
        $("#start_date").datepicker({
            dateFormat: 'yy-mm-dd'
        });

        $("input[name='pname']").click(function(){
            cur_name_sel = eval($(this).val());
            if (cur_name_sel == 4)
                $("#inp_name_other").show();
            else
                $("#inp_name_other").hide();
            $("#pac-addr-start").val(g_addrs[cur_name_sel]);    
        });
        $("#pac-addr-start").val(g_addrs[cur_name_sel]);
        $("input[name='has_hotel']").click(function(){
            if (eval($(this).val()) == 1)
            {
                $("#hotel_info").slideDown("slow");
            }
            else
            {
                $("#hotel_info").slideUp("slow");
            }
        });

        $("input[name='has_add_expense']").click(function(){
            if (eval($(this).val()) == 1)
            {
                $("#expense_info").slideDown("slow");
            }
            else
            {
                $("#expense_info").slideUp("slow");
            }
        });

        add_expense_item(1);
    });

    function add_expense_item(index)
    {
        $("#btn_expense_add_" + (index - 1)).hide();
        if (index > 2)
            $("#btn_expense_del_" + (index - 1)).hide();
        var str_expense_div = ` <div class="expense" id="expense_${index}">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="inp_expense_amount_${index}">Amount:</label>
                                    <input type="text" id="inp_expense_amount_${index}" name="inp_expense_amount" class="form-control" value="" maxlength="120"/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="inp_expense_purpose_${index}">Purpose:</label>
                                    <input type="text" id="inp_expense_purpose_${index}" name="inp_expense_purpose" class="form-control" value="" maxlength="120"/>
                                </div>
                            </div>
                            <div class="col-md-2 m-auto pt-4" align="center">
                                <input type="checkbox" id="isExpenseEmailed_${index}" name="isExpenseEmailed" onclick="selBillType(this, ${index})"/>
                                <label for="isExpenseEmailed_${index}" style="color:blue">Emailed</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group" id="billImgType_div1_${index}">
                                    <label>Image of Bill: </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group" id="billImgType_div2_${index}">
                                    <input type="radio" onclick="selectImageType(this, ${index})" id="bill_upload_${index}" name="bill_img_type_${index}" value="1" checked/>
                                    <label for="bill_upload_${index}">Image Upload&nbsp;&nbsp;
                                    <input type="radio" onclick="selectImageType(this, ${index})" id="bill_capture_${index}" name="bill_img_type_${index}" value="2"/>
                                    <label for="bill_capture_${index}">Live Capture</label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group" align="center">
                                    <button id="btn_expense_add_${index}" class="btn btn-primary" onclick="add_expense_item(${index+1})">Add</button>
                                    ${index>1?`<button class='btn btn-danger' id='btn_expense_del_${index}' onclick="del_expense_item(${index})">Delete</button>`:''}
                                </div>
                            </div>
                        </div>
                        <div class="row" id="billImgCapture_div_${index}">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <img class="img-responsive" id="img_bill_${index}" name="img_bill_${index}" width="100%"/>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group" id="bill_upload_div_${index}">
                                    <label for="img_upload">Image for Upload: </label>
                                    <input accept="image/jpeg, image/png" autocomplete="off" type="file" tabindex="-1" class="form-control" onchange="uploadImageFile(this, ${index})"/>
                                </div>
                                <div class="form-group" id="bill_capture_div_${index}" style="display: none;">
                                    <div id="mycam_${index}"></div>
                                    <button class="btn btn-warning btn-lg" onclick="take_snapshot(${index})">
                                        <i class="fa fa-camera"></i> Capture
                                    </button>
                                    <input type="hidden" id="image_captured_${index}" name="image_captured_${index}" class="image-tag" value=""/>
                                </div>
                            </div>
                        </div>
                    </div>  `;
        if(index>1)
            str_expense_div="<hr/>"+str_expense_div;
        $(str_expense_div).appendTo($("#expense_container"));

        set_webcam(index);
    }

    function del_expense_item(index)
    {
        $("#btn_expense_add_" + (index - 1)).show();
        if (index > 2)
            $("#btn_expense_del_" + (index - 1)).show();
        $("#expense_" + index).remove();
    }
    function selBillType(e, index){
        if(e.checked){
            $("#billImgType_div1_"+index).hide();
            $("#billImgType_div2_"+index).hide();
            $("#billImgCapture_div_"+index).hide();
        }
        else{
            $("#billImgType_div1_"+index).show();
            $("#billImgType_div2_"+index).show();
            $("#billImgCapture_div_"+index).show();
        }
    }
    function selectImageType(e, index){
        if ($(e).val() == 1)
        {
            $("#bill_upload_div_"+index).show();
            $("#bill_capture_div_"+index).hide();
        }
        else
        {
            $("#bill_upload_div_"+index).hide();
            $("#bill_capture_div_"+index).show();
        }
        $("#img_bill_"+index).attr("src", "");
    }
    function uploadImageFile(e, index){
        readImageURL(e, index);
    }
    function readImageURL(input, index) 
    {
        if (input.files && input.files[0]) 
        {
            var reader = new FileReader();
            uploadImageName = input.files[0].name;
            reader.onload = function(e) 
            {
                $("#img_bill_"+index).attr("src", e.target.result);
                $("#image_captured_"+index).val(e.target.result);
            }
            reader.readAsDataURL(input.files[0]); // convert to base64 string
        }
    }

    function set_webcam(index)
    {
        //var cam_width = $("#bill_upload_div").width();
        //var cam_height = Math.floor(cam_width*3/4);
        
        Webcam.set({
            width: 400,
            height: 300,
            image_format: 'jpeg',
            jpeg_quality: 100
        });
        Webcam.attach('#mycam_'+index);
    }

    function take_snapshot(index)
    {
        Webcam.snap(function(data_uri){
            $("#img_bill_"+index).attr("src", data_uri);
            $("#image_captured_"+index).val(data_uri);
        } );
    }

    function delay_submit()
    {
        $("#btn_info_submit>i").attr('class', "fa fa-spinner fa-spin");

        calc_distance_expense();
        window.setTimeout(submit_trip_info, 3000);
    }

    function submit_trip_info()
    {
        $("#msg2").text("");
        var arr_expense_amount = [];
        var arr_expense_purpose = [];

        var pname = "";
        if (cur_name_sel == 4)
            pname = $("inp_other_name").val();
        else
            pname = g_names[cur_name_sel];

        var pjob = $("#inp_job").val();
        var start_date = $("#start_date").val();
        var job_rooms = $("#sel_job_rooms").val();
        var job_hours = $("#inp_job_hours").val();

        var has_hotel = $("input[name='has_hotel']:checked").val();
        var hotel_name = $("#inp_hotel_name").val();
        var hotel_stayed = $("#inp_hotel_stayed").val();

        var has_add_expense = $("input[name='has_add_expense']:checked").val();
        var paid_name = $("#paid_name").val();

        $("input[name='inp_expense_amount']").each(function(index){
            arr_expense_amount.push($(this).val());
        });

        $("input[name='inp_expense_purpose']").each(function(index){
            arr_expense_purpose.push($(this).val());
        });

        var expense_amount = arr_expense_amount.join('^');
        var expense_purpose = arr_expense_purpose.join('^');
        var trip_note = $("#txt_note").val();
        var dist_msg = $("#msg").text();
        var bill_image = [];
        $("input[id*='image_captured_']").filter(function(idx, el){
            var index = $(this).attr('id').split('image_captured_')[1];
            if(!$(this).val() || $("#isExpenseEmailed_"+index)[0].checked)
                return;
            bill_image.push($(this).val());
        });

        $.post(
            "sendmail.php",
            {
                pname: pname,
                pjob: pjob,
                start_date: start_date,
                job_rooms: job_rooms,
                job_hours: job_hours,
                has_hotel: has_hotel,
                hotel_name: hotel_name,
                hotel_stayed: hotel_stayed,
                has_add_expense: has_add_expense,
                paid_name: paid_name,
                expense_amount: expense_amount,
                expense_purpose: expense_purpose,
                trip_note: trip_note,
                dist_msg: dist_msg,
                bill_image: bill_image
            },
            function(res)
            {
                $("#btn_info_submit>i").attr('class', "fa fa-paper-plane");
                res = JSON.parse(res);
                if(res.state==1)
                    $("#msg2").text("All of trip information has been sent to your email.").css('color' ,'green');
                else
                    $("#msg2").text(res.msg).css('color', 'red');
            }
        );
    }
</script>
