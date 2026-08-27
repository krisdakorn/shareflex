<?php 
    include("./config.php");

    $typePeo = array(
        "ผู้นำ",
        "ชรบ.",
        "อสม.",
        "ชาวบ้านทั่วไป",
        "เยาวชน",
        "เด็ก",
        "สมาชิกพิเศษ"
    );

    $timestamp = strtotime($date_now);
    $thai_year = date("Y", $timestamp) + 543;
    $dateNow = date("d", $timestamp) . "-" . date("m", $timestamp) . "-" . $thai_year;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แบบฟอร์มสมัครสมาชิกทั่วไป</title>

    <link rel="icon" type="image/x-icon" href="./assets/img/logoM.png">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet">

    <!--DatePicker -->
    <link type="text/css" href="assets/vendor/datepicker/css/ui-lightness/jquery-ui-1.8.10.custom.css" rel="stylesheet" />

    <!-- scipt date datepicker have to insert brefor -->
    <script type="text/javascript" src="assets/vendor/datepicker/js/jquery-1.4.4.min.js"></script>
    <script type="text/javascript" src="assets/vendor/datepicker/js/datePic.js"></script>

    <style>
        .loader {
            position: absolute;
            left: 50%;
            top: 85%;
            z-index: 1;
            width: 120px;
            height: 120px;
            margin: -76px 0 0 -76px;
            border: 16px solid #f3f3f3;
            border-radius: 50%;
            border-top: 16px solid #1cc88a;
            -webkit-animation: spin 2s linear infinite;
            animation: spin 2s linear infinite;
        }

        @-webkit-keyframes spin {
            0% { -webkit-transform: rotate(0deg); }
            100% { -webkit-transform: rotate(360deg); }
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .label_radio {
            position:relative;
            padding-left:2ch;
            display: block;
        }

        .label_radio > [type=radio] {
            position: absolute;
            left: 0;
        }
    </style>
</head>
<body>
    <main id="main">
        <div class="container" data-aos="fade-up" data-aos-delay="50">

            <div id="loaderSave" class="loader" style="display:none;"></div>

            <div class="form-group row p-2 mb-3 justify-content-center" style="background-color:#c1e7f7;">

                <div class="col-12 col-md-8 mt-2 mb-2" style="text-align:center;">
                    <img src="./assets/img/bannernew1.png" class="img-fluid mb-2 w-100" alt="bannernew1">
                </div>

                <div class="col-12 col-md-8 mb-3 text-center" style="color: #f3f3f3; background-color: #00AAF5; border-radius:10px 10px 0 0;">
                    <label class="p-2"><strong>แบบฟอร์มสมัครสมาชิกทั่วไป</strong></label>
                </div>

                <div class="col-12 col-md-8 mb-2 text-center">
                    <label><strong>แบบฟอร์มนี้จำเป็นต้องกรอกข้อมูลให้ครบถ้วน <br> และถูกต้อง เพื่อใช้เป็นข้อมูลพื้นฐานต่อไป</strong></label>
                </div>

                <input type="hidden" id="in_cid_rp" name="in_cid_rp">
                <input type="hidden" id="in_subdist_rp" name="in_subdist_rp">
                <input type="hidden" id="in_dist_rp" name="in_dist_rp">
                <input type="hidden" id="in_prov_rp" name="in_prov_rp">

                <div class="col-12 col-md-8 mb-2">
                    <label><strong><u>ข้อมูลสมาชิกหลัก/ชื่อผู้รายงาน</u></strong></label>
                </div>

                <div class="col-6 col-md-8 mb-2">
                    <label><strong><font color="red">*</font><u>รหัสสมาชิก</u></strong></label>
                    <input type="text" name="in_mem_rp" class="form-control" id="in_mem_rp" placeholder="" required readonly>
                </div>

                <div class="col-6 col-md-8 mb-2">
                    <label><strong><font color="red">*</font><u>หมู่บ้าน</u></strong></label>
                    <input type="text" name="in_village_rp" class="form-control" id="in_village_rp" placeholder="" required readonly>
                </div>

                <div class="col-12 col-md-8 mb-2">
                    <label><strong><font color="red">*</font>คำนำหน้า</strong></label>
                    <select class="form-control" id="in_rang_rp" name="in_rang_rp" onchange="" disabled>
                        <option value="0"></option>
                        <?php
                            foreach ($rang as $r) {
                        ?>
                                <option value="<?= $r ?>"><?= $r ?></option>
                        <?php
                            }
                        ?>
                    </select>
                </div>

                <div class="col-12 col-md-8 mb-2">
                    <label><strong><font color="red">*</font>ชื่อ</strong></label>
                    <input type="text" name="in_name_rp" class="form-control" id="in_name_rp" placeholder="" required readonly>
                </div>

                <div class="col-12 col-md-8 mb-2">
                    <label><strong><font color="red">*</font>นามสกุล</strong></label>
                    <input type="text" name="in_sname_rp" class="form-control" id="in_sname_rp" placeholder="" required readonly>
                </div>

                <div class="col-12 col-md-8 mb-2">
                    <hr style="height:5px;border-width:0;color:#bf0404;background-color:#bf0404;opacity: 1;">
                </div>

                <div class="col-12 col-md-8 mb-2">
                    <p style="font-size: 17px;"><strong><font color="red">ข้อมูลสมาชิกใหม่</font></strong></p>
                </div>

                <div class="col-12 col-md-8 mb-2">
                    <label><strong><font color="red">*</font>ประเภท :</strong></label>
                    <select class="form-control" id="in_typepeo" name="in_typepeo" onchange="">
                        <option value="0"></option>
                        <?php
                            foreach ($typePeo as $peo) {
                        ?>
                                <option value="<?= $peo ?>"><?= $peo ?></option>
                        <?php
                            }
                        ?>
                    </select>
                </div>

                <div class="col-12 col-md-8 mb-2">
                    <label><strong><font color="red">*</font>คำนำหน้า :</strong></label>
                    <select class="form-control" id="in_rang" name="in_rang" onchange="">
                        <option value="0"></option>
                        <?php
                            foreach ($rang as $r) {
                        ?>
                                <option value="<?= $r ?>"><?= $r ?></option>
                        <?php
                            }
                        ?>
                    </select>
                </div>

                <div class="col-12 col-md-8 mb-2">
                    <label><strong><font color="red">*</font>ชื่อ :</strong></label>
                    <input type="text" name="in_name" class="form-control" id="in_name" placeholder="" required>
                </div>

                <div class="col-12 col-md-8 mb-2">
                    <label><strong><font color="red">*</font>นามสกุล :</strong></label>
                    <input type="text" name="in_sname" class="form-control" id="in_sname" placeholder="" required>
                </div>

                <div class="col-12 col-md-8 mb-2">
                    <label><strong>ชื่อเล่น :</strong>(ถ้ามี)</label>
                    <input type="text" name="in_nickname" class="form-control" id="in_nickname" placeholder="" required>
                </div>

                <div class="col-12 col-md-8 mb-2">
                    <label><strong><font color="red">*</font>เลขบัตร ปชช. 13 หลัก :</strong></label>
                    <input type="number" class="form-control" id="in_cid" name="in_cid" pattern="\d*"
                            oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                            placeholder="" maxlength="13">
                </div>

                <div class="col-12 col-md-8 mb-2">
                    <label><strong><font color="red">*</font>ที่อยู่ :</strong> (เฉพาะบ้านเลขที่)</label>
                    <input type="text" name="in_add" class="form-control" id="in_add" required></input>
                </div>

                <div class="col-12 col-md-8 mb-2">
                    <label><strong><font color="red">*</font>หมู่ที่ :</strong></label>
                    <input type="text" name="in_moo" class="form-control" id="in_moo" required></input>
                </div>

                <div class="col-12 col-md-8 mb-2">
                    <label><strong><font color="red">*</font>ตำบล :</strong></label>
                    <input type="text" name="in_subdist" class="form-control" id="in_subdist" required></input>
                </div>

                <div class="col-12 col-md-8 mb-2">
                    <label><strong><font color="red">*</font>อำเภอ :</strong></label>
                    <input type="text" name="in_dist" class="form-control" id="in_dist" required></input>
                </div>

                <div class="col-12 col-md-8 mb-2">
                    <label><strong><font color="red">*</font>จังหวัด :</strong></label>
                    <input type="text" name="in_prov" class="form-control" id="in_prov" required></input>
                </div>

                <div class="col-12 col-md-8 mb-2">
                    <label><strong>โทรศัพท์ :</strong></label>
                    <input type="number" class="form-control" id="in_phone" name="in_phone" pattern="\d*"
                            oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                            placeholder="" maxlength="10">
                </div>

                <div class="col-12 col-md-8 mb-3">
                    <label>
                        <strong><font color="red">*</font>แนบภาพถ่ายปัจจุบัน :</strong><font color="red"> <br> (ไฟล์ .jpg .png ขนาดไม่เกิน 5 mb.)</font>
                    </label>
                    <input type="file" class="form-control mr-1" id="in_file" name="in_file" accept="image/*">
                </div>

                <div class="row justify-content-center">
                    <div class="col-6 col-md-6 mb-2 text-center">
                        <button type="button" class="btn btn-danger" id="reset_btn" onClick="reset();" title="reset">Reset</button>
                    </div>
                    <div class="col-6 col-md-6 mb-2 text-center">
                        <button type="button" class="btn btn-info" id="confirm_btn" onClick="saveData();" title="confirm">- ยืนยัน -</button>
                    </div>
                </div>

                <div class="col-12 col-md-8 mb-3 text-center">
                    <p style="font-size: 13px;">“ <?= $title_f ?> ”</p>
                </div>


            </div>

        </div>
    </main>

    <script>
        var date = new Date();
        var toDay = date.getDate() + '-' + (date.getMonth() + 1) + '-' + (date.getFullYear() + 543);
        const arr_dayNames = ['อาทิตย์','จันทร์','อังคาร','พุธ','พฤหัสบดี','ศุกร์','เสาร์'];
        const arr_dayNamesMin = ['อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'];
        const arr_monthNames = ['มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'];
        const arr_monthNamesShort = ['ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.']

        $("#datepicker-th-1").datepicker({ 
            changeMonth: true, 
            changeYear: false, 
            dateFormat: 'dd-mm-yy', 
            isBuddhist: true, 
            defaultDate: toDay,
            dayNames: arr_dayNames,
            dayNamesMin: arr_dayNamesMin,
            monthNames: arr_monthNames,
            monthNamesShort: arr_monthNamesShort
        });
    </script>

     <!-- Vendor JS Files -->
    <script src="assets/vendor/aos/aos.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>
    <script src="assets/vendor/purecounter/purecounter.js"></script>
    <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="assets/js/jquery/jquery.min.js"></script>

    <!-- <script src="https://static.line-scdn.net/liff/edge/versions/2.9.0/sdk.js"></script> -->
    <script src="https://static.line-scdn.net/liff/edge/versions/2.28.0/sdk.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>

    <script>
        function reset() {
            location.reload();
        }

        function dateAdjust(datepicker) {

            const dateArray = datepicker.split("-");
            var d = dateArray[0];
            var m = dateArray[1];
            var y_th = dateArray[2];

            var y = y_th - 543;

            return d + "/" + m + "/" + y;
        }


        function fetchDataSheet () {
            var url = 'https://docs.google.com/spreadsheets/d/1JRrQYaSdJCpYxe2t4AMYljbZRauol1TrI5iGV19wr0A/gviz/tq?sheet=register';

            fetch(url)
            .then(res => res.text())
            .then(data => {
                const temp = data.substr(47).slice(0, -2);
                const jsonD = JSON.parse(temp);
                const rows = jsonD.table.rows;

                if(rows.length >= 1) {
                    for (var i=0 ; i < rows.length ; i++){
                        var colArray = rows[i]['c'];

                        if (colArray.hasOwnProperty("1")) {
                            var v_col1 = colArray["1"]["v"];

                            if(v_col1 == userId_line) {

                                // console.log(colArray);

                                if (colArray.hasOwnProperty("4")) {
                                    var v_col4 = colArray["4"]["v"];
                                    $("#in_mem_rp").val(v_col4);
                                }

                                var v_rang_rp = "";
                                if (colArray.hasOwnProperty("5")) {
                                    v_rang_rp = colArray["5"]["v"];
                                }

                                var v_name_rp = "";
                                if (colArray.hasOwnProperty("6")) {
                                    v_name_rp = colArray["6"]["v"];
                                }

                                var v_sname_rp = "";
                                if (colArray.hasOwnProperty("7")) {
                                    v_sname_rp = colArray["7"]["v"];
                                }

                                $("#in_rang_rp").val(v_rang_rp);
                                $("#in_name_rp").val(v_name_rp);
                                $("#in_sname_rp").val(v_sname_rp);

                                var v_village_rp = "";
                                if (colArray.hasOwnProperty("13")) {
                                    v_village_rp = colArray["13"]["v"];
                                }

                                var v_cid_rp = "";
                                if (colArray.hasOwnProperty("8")) {
                                    v_cid_rp = colArray["8"]["v"];
                                }

                                var v_subdist_rp = "";
                                if (colArray.hasOwnProperty("10")) {
                                    v_subdist_rp = colArray["10"]["v"];
                                }

                                var v_dist_rp = "";
                                if (colArray.hasOwnProperty("11")) {
                                    v_dist_rp = colArray["11"]["v"];
                                }

                                var v_prov_rp = "";
                                if (colArray.hasOwnProperty("12")) {
                                    v_prov_rp = colArray["12"]["v"];
                                }

                                $("#in_village_rp").val(v_village_rp);
                                $("#in_cid_rp").val(v_cid_rp);
                                $("#in_subdist_rp").val(v_subdist_rp);
                                $("#in_dist_rp").val(v_dist_rp);
                                $("#in_prov_rp").val(v_prov_rp);

                                break;
                            }
                        }
                    }
                }
            });
        }


        async function saveData(){
            document.getElementById("loaderSave").style.display = "block";

            var in_rang_rp = $("#in_rang_rp").val();
            var in_name_rp = $("#in_name_rp").val();
            var in_sname_rp = $("#in_sname_rp").val();

            var in_mem_rp = $("#in_mem_rp").val();
            var in_village_rp = $("#in_village_rp").val();
            var in_cid_rp = $("#in_cid_rp").val();

            var in_subdist_rp = $("#in_subdist_rp").val();
            var in_dist_rp = $("#in_dist_rp").val();
            var in_prov_rp = $("#in_prov_rp").val();

            var in_typepeo = $("#in_typepeo").val();
            var in_rang = $("#in_rang").val();
            var in_name = $("#in_name").val();
            var in_sname = $("#in_sname").val();
            var in_nickname = $("#in_nickname").val();
            var in_cid = $("#in_cid").val();

            var in_add = $("#in_add").val();
            var in_moo = $("#in_moo").val();
            var in_subdist = $("#in_subdist").val();
            var in_dist = $("#in_dist").val();
            var in_prov = $("#in_prov").val();
            
            var in_phone = $("#in_phone").val();
            var fileName = document.getElementById("in_file").value;
            var fileImg = $('#in_file')[0].files[0];

            if(in_typepeo == 0){
                alert("กรุณากรอก : ประเภท");
                $("#in_typepeo").focus();
                document.getElementById("loaderSave").style.display = "none";
                return false;
            }

            if(in_rang == 0){
                alert("กรุณากรอก : คำนำหน้า");
                $("#in_rang").focus();
                document.getElementById("loaderSave").style.display = "none";
                return false;
            }

            if(in_name == ""){
                alert("กรุณากรอก : ชื่อ ภาษาไทย");
                $("#in_name").focus();
                document.getElementById("loaderSave").style.display = "none";
                return false;
            }

            if(in_sname == ""){
                alert("กรุณากรอก : นามสกุล ภาษาไทย");
                $("#in_sname").focus();
                document.getElementById("loaderSave").style.display = "none";
                return false;
            }

            if(in_nickname == ""){
                in_nickname = "-";
            }

            if(in_cid == ""){
                alert("กรุณากรอก : เลขที่บัตรประชาชน");
                $("#in_cid").focus();
                document.getElementById("loaderSave").style.display = "none";
                return false;
            }

            if(in_add == ""){
                alert("กรุณากรอก : ที่อยู่");
                $("#in_add").focus();
                document.getElementById("loaderSave").style.display = "none";
                return false;
            }

            if(in_moo == ""){
                alert("กรุณากรอก : หมู่");
                $("#in_moo").focus();
                document.getElementById("loaderSave").style.display = "none";
                return false;
            }

            if(in_subdist == ""){
                alert("กรุณากรอก : ตำบล");
                $("#in_subdist").focus();
                document.getElementById("loaderSave").style.display = "none";
                return false;
            }

            if(in_dist == ""){
                alert("กรุณากรอก : อำเภอ");
                $("#in_dist").focus();
                document.getElementById("loaderSave").style.display = "none";
                return false;
            }

            if(in_prov == ""){
                alert("กรุณากรอก : จังหวัด");
                $("#in_prov").focus();
                document.getElementById("loaderSave").style.display = "none";
                return false;
            }

            if(in_phone == ""){
                in_phone = "000";
            }

            if(fileName == ""){
                alert("กรุณา : แนบรูป");
                $("#in_file").focus();
                document.getElementById("loaderSave").style.display = "none";
                return;
            }

            var dateNow = "<?= $dateNow ?>";

            // === ส่งข้อมูลทั้งหมด + รูปภาพ ไป server ครั้งเดียว ===
            var frmdta = new FormData();
            frmdta.append('file', fileImg);

            // ข้อมูลผู้รายงาน
            frmdta.append('in_rang_rp', in_rang_rp);
            frmdta.append('in_name_rp', in_name_rp);
            frmdta.append('in_sname_rp', in_sname_rp);
            frmdta.append('in_mem_rp', in_mem_rp);
            frmdta.append('in_village_rp', in_village_rp);
            frmdta.append('in_cid_rp', in_cid_rp);
            frmdta.append('in_subdist_rp', in_subdist_rp);
            frmdta.append('in_dist_rp', in_dist_rp);
            frmdta.append('in_prov_rp', in_prov_rp);

            // ข้อมูลสมาชิกใหม่
            frmdta.append('in_typepeo', in_typepeo);
            frmdta.append('in_rang', in_rang);
            frmdta.append('in_name', in_name);
            frmdta.append('in_sname', in_sname);
            frmdta.append('in_nickname', in_nickname);
            frmdta.append('in_cid', in_cid);
            frmdta.append('in_add', in_add);
            frmdta.append('in_moo', in_moo);
            frmdta.append('in_subdist', in_subdist);
            frmdta.append('in_dist', in_dist);
            frmdta.append('in_prov', in_prov);
            frmdta.append('in_phone', in_phone);

            // LINE Profile
            frmdta.append('userId_line', userId_line);
            frmdta.append('nameLine', nameLine);
            frmdta.append('picUrl', picUrl);

            document.getElementById("reset_btn").disabled = true;
            document.getElementById("confirm_btn").disabled = true;

            $.ajax({
                url: './controller/saveAndNotify.php',
                data: frmdta,
                cache: false,
                contentType: false,
                processData: false,
                type: 'post',
                dataType: 'json',
                success: function(response){
                    if (response.status == 1) {
                        var link_img = response.linkImg;

                        var in_name_sur = in_rang + " " + in_name + "  " + in_sname;
                        var in_name_sur_rp = in_rang_rp + " " + in_name_rp + "  " + in_sname_rp;

                        var in_address = in_add + "\n"
                                + " หมู่ที่ " + in_moo + "\n"
                                + " ต." + in_subdist + "\n"
                                + " อ." + in_dist + "\n"
                                + " จ." + in_prov;

                        // ส่ง LINE Flex Message ทันที (Google Sheet + Telegram ทำบน server background)
                        sendMessageLine (dateNow, in_name_sur, in_cid, in_typepeo, in_address, in_phone, in_name_sur_rp, in_village_rp, link_img, in_mem_rp);

                    } else {
                        Swal.fire({
                            icon: "warning",
                            title: response.res,
                            didClose: () => {
                                document.getElementById("loaderSave").style.display = "none";
                                document.getElementById("reset_btn").disabled = false;
                                document.getElementById("confirm_btn").disabled = false;
                            }
                        });
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: "error",
                        title: "เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง",
                        didClose: () => {
                            document.getElementById("loaderSave").style.display = "none";
                            document.getElementById("reset_btn").disabled = false;
                            document.getElementById("confirm_btn").disabled = false;
                        }
                    });
                }
            });
        }

        var userId_line = "";
        var nameLine = "";
        var picUrl = "https://hofkrisda.com/ndc/deer/assets/img/anonymous.png";

        function runApp () {
            liff.getProfile().then(profile => {

                userId_line = profile.userId;
                nameLine = profile.displayName;
                
                var pic_url = profile.pictureUrl;

                if (typeof pic_url !== 'undefined') {
                    picUrl = profile.pictureUrl;
                }

                fetchDataSheet();

            }).catch(err => console.error(err));
        }

        initializeLIFF();

        async function initializeLIFF() {
            await liff.init({ liffId: "2011195913-J8h4XTRQ" });

            const isLoggedIn = liff.isLoggedIn();
            if (!isLoggedIn) { return liff.login(); }

            const friendship = await liff.getFriendship();
            
            if (!friendship.friendFlag) {

                await liff.requestFriendship();

                const verifyFriendship = await liff.getFriendship();

                if (verifyFriendship.friendFlag) {
                    runApp();
                }else {
                    liff.closeWindow();
                }

            }else {
                runApp();
            }
        }

        function sendMessageLine (dateNow, in_name_sur, in_cid, in_typepeo, in_add, in_phone, in_name_sur_rp, in_village_rp, pictureUrl, in_mem_rp) {
            var messages = [
                {
                    "type": "flex",
                    "altText": "sended",
                    "contents":
                    //--เริ่ม Json โค้ด Flex--------
                        {
                        "type": "bubble",
                        "size": "kilo",
                        "header": {
                            "type": "box",
                            "layout": "vertical",
                            "contents": [
                            {
                                "type": "text",
                                "text": "form 1.1",
                                "color": "#79716B",
                                "size": "sm",
                                "align": "end"
                            }
                            ],
                            "paddingBottom": "sm"
                        },
                        "hero": {
                            "type": "box",
                            "layout": "vertical",
                            "contents": [
                            {
                                "type": "text",
                                "text": "กองทุนแม่ฯ ปปส.อุดรธานี",
                                "weight": "bold",
                                "size": "21px"
                            },
                            {
                                "type": "separator",
                                "margin": "sm",
                                "color": "#000000"
                            },
                            {
                                "type": "text",
                                "text": "สมาชิกทั่วไป",
                                "color": "#0000ff",
                                "size": "md",
                                "weight": "bold",
                                "margin": "xs",
                                "wrap": true
                            },
                            {
                                "type": "text",
                                "text": "รายงานประจำวันที่ : " + dateNow,
                                "size": "sm",
                                "wrap": true,
                                "margin": "sm",
                                "align": "end",
                                "color": "#79716B",
                                "offsetEnd": "md"
                            }
                            ],
                            "paddingTop": "none",
                            "paddingBottom": "none",
                            "paddingStart": "xl",
                            "offsetStart": "sm",
                            "paddingEnd": "md"
                        },
                        "body": {
                            "type": "box",
                            "layout": "vertical",
                            "margin": "xxl",
                            "spacing": "sm",
                            "contents": [
                            {
                                "type": "box",
                                "layout": "vertical",
                                "contents": [
                                {
                                    "type": "text",
                                    "text": "ชื่อ-สกุล เลข ปชช. สมาชิกใหม่",
                                    "color": "#ffffff",
                                    "offsetStart": "md",
                                    "size": "sm",
                                    "weight": "bold",
                                    "wrap": true
                                },
                                {
                                    "type": "box",
                                    "layout": "vertical",
                                    "contents": [
                                    {
                                        "type": "text",
                                        "text": in_name_sur,
                                        "size": "sm",
                                        "wrap": true
                                    },
                                    {
                                        "type": "text",
                                        "text": "เลขบัตร ปชช. : " + in_cid,
                                        "size": "sm",
                                        "wrap": true
                                    }
                                    ],
                                    "backgroundColor": "#ffffff",
                                    "paddingTop": "sm",
                                    "paddingStart": "md",
                                    "paddingEnd": "md",
                                    "paddingBottom": "sm"
                                }
                                ],
                                "backgroundColor": "#44403B",
                                "margin": "md",
                                "paddingTop": "xs",
                                "borderColor": "#44403B",
                                "borderWidth": "normal",
                                "cornerRadius": "sm"
                            },
                            {
                                "type": "box",
                                "layout": "horizontal",
                                "contents": [
                                {
                                    "type": "box",
                                    "layout": "vertical",
                                    "contents": [
                                    {
                                        "type": "text",
                                        "text": "ประเภท",
                                        "color": "#ffffff",
                                        "offsetStart": "md",
                                        "size": "sm",
                                        "weight": "bold"
                                    },
                                    {
                                        "type": "box",
                                        "layout": "vertical",
                                        "contents": [
                                        {
                                            "type": "text",
                                            "text": in_typepeo,
                                            "size": "sm",
                                            "wrap": true
                                        }
                                        ],
                                        "backgroundColor": "#ffffff",
                                        "paddingTop": "sm",
                                        "paddingStart": "md",
                                        "paddingEnd": "md",
                                        "paddingBottom": "sm"
                                    }
                                    ],
                                    "backgroundColor": "#44403B",
                                    "margin": "xs",
                                    "paddingTop": "sm",
                                    "borderColor": "#44403B",
                                    "borderWidth": "normal",
                                    "cornerRadius": "sm",
                                    "paddingStart": "none",
                                    "paddingEnd": "xs"
                                }
                                ],
                                "backgroundColor": "#44403B",
                                "margin": "md",
                                "paddingTop": "xs",
                                "borderColor": "#44403B",
                                "borderWidth": "normal",
                                "cornerRadius": "sm"
                            },
                            {
                                "type": "box",
                                "layout": "vertical",
                                "contents": [
                                {
                                    "type": "text",
                                    "text": "ที่อยู่บ้านเลขที่",
                                    "color": "#ffffff",
                                    "offsetStart": "md",
                                    "size": "sm",
                                    "weight": "bold",
                                    "wrap": true
                                },
                                {
                                    "type": "box",
                                    "layout": "vertical",
                                    "contents": [
                                    {
                                        "type": "text",
                                        "text": in_add,
                                        "size": "sm",
                                        "wrap": true
                                    }
                                    ],
                                    "backgroundColor": "#ffffff",
                                    "paddingTop": "sm",
                                    "paddingStart": "md",
                                    "paddingEnd": "md",
                                    "paddingBottom": "sm"
                                }
                                ],
                                "backgroundColor": "#44403B",
                                "margin": "md",
                                "paddingTop": "xs",
                                "borderColor": "#44403B",
                                "borderWidth": "normal",
                                "cornerRadius": "sm"
                            },
                            {
                                "type": "box",
                                "layout": "vertical",
                                "contents": [
                                {
                                    "type": "text",
                                    "text": "เบอร์ติดต่อ",
                                    "color": "#ffffff",
                                    "offsetStart": "md",
                                    "size": "sm",
                                    "weight": "bold",
                                    "wrap": true
                                },
                                {
                                    "type": "box",
                                    "layout": "vertical",
                                    "contents": [
                                    {
                                        "type": "text",
                                        "text": in_phone,
                                        "size": "sm",
                                        "wrap": true
                                    }
                                    ],
                                    "backgroundColor": "#ffffff",
                                    "paddingTop": "sm",
                                    "paddingStart": "md",
                                    "paddingEnd": "md",
                                    "paddingBottom": "sm"
                                }
                                ],
                                "backgroundColor": "#44403B",
                                "margin": "md",
                                "paddingTop": "xs",
                                "borderColor": "#44403B",
                                "borderWidth": "normal",
                                "cornerRadius": "sm"
                            },
                            {
                                "type": "box",
                                "layout": "vertical",
                                "contents": [
                                {
                                    "type": "text",
                                    "text": "ภาพสมาชิกใหม่",
                                    "color": "#ffffff",
                                    "offsetStart": "md",
                                    "size": "sm",
                                    "weight": "bold",
                                    "wrap": true
                                },
                                {
                                    "type": "box",
                                    "layout": "vertical",
                                    "contents": [
                                    {
                                        "type": "image",
                                        "url": pictureUrl,
                                        "size": "full",
                                        "aspectRatio": "4:3",
                                        "aspectMode": "cover",
                                        "action": {
                                        "type": "uri",
                                        "label": "action",
                                        "uri": pictureUrl
                                        }
                                    }
                                    ],
                                    "backgroundColor": "#ffffff",
                                    "paddingAll": "sm"
                                }
                                ],
                                "backgroundColor": "#44403B",
                                "margin": "md",
                                "paddingTop": "xs",
                                "borderColor": "#44403B",
                                "borderWidth": "normal",
                                "cornerRadius": "sm"
                            }
                            ],
                            "paddingTop": "sm"
                        },
                        "footer": {
                            "type": "box",
                            "layout": "vertical",
                            "margin": "md",
                            "contents": [
                                {
                                    "type": "box",
                                    "layout": "horizontal",
                                    "margin": "md",
                                    "contents": [
                                    {
                                        "type": "text",
                                        "text": "ผู้รายงาน :",
                                        "size": "xs",
                                        "color": "#79716B",
                                        "flex": 0
                                    },
                                    {
                                        "type": "text",
                                        "text": in_name_sur_rp,
                                        "color": "#79716B",
                                        "size": "xs",
                                        "align": "end"
                                    }
                                    ],
                                    "paddingTop": "none"
                                },
                                {
                                    "type": "box",
                                    "layout": "horizontal",
                                    "margin": "md",
                                    "contents": [
                                    {
                                        "type": "text",
                                        "text": "รหัสผู้รายงาน :",
                                        "size": "xs",
                                        "color": "#79716B",
                                        "flex": 0
                                    },
                                    {
                                        "type": "text",
                                        "text": in_mem_rp,
                                        "color": "#79716B",
                                        "size": "xs",
                                        "align": "end"
                                    }
                                    ],
                                    "paddingTop": "none"
                                },
                                {
                                    "type": "box",
                                    "layout": "horizontal",
                                    "margin": "md",
                                    "contents": [
                                    {
                                        "type": "text",
                                        "text": "หมู่บ้าน :",
                                        "size": "xs",
                                        "color": "#79716B",
                                        "flex": 0
                                    },
                                    {
                                        "type": "text",
                                        "text": in_village_rp,
                                        "color": "#79716B",
                                        "size": "xs",
                                        "align": "end"
                                    }
                                    ],
                                    "paddingTop": "none"
                                }
                            ],
                            "paddingTop": "none"
                        },
                        "styles": {
                            "footer": {
                            "separator": true
                            }
                        }
                    }
                //--จบ Json โค้ด--------
                }
            ];
        

            liff.sendMessages(messages).then(() => {
                liff.closeWindow();
            }).catch((err) => {
                alert('Error : ', err);
            });
        }


    </script>
</body>
</html>
