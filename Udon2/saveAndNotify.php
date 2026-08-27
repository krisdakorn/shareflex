<?php 
    /**
     * saveAndNotify.php
     * -----------------
     * Endpoint รวมงานทั้งหมดไว้ที่เดียว:
     *   1. นับรหัสสมาชิก (memID) จาก Google Sheet  (server-side)
     *   2. อัปโหลดรูปภาพลงโฮสต์                      (server-side)
     *   3. ตอบ client ทันที (linkImg + memID)         ← client ได้แล้วไปส่ง Flex + ปิดหน้าต่าง
     *   --- หลังจากนี้ client ไม่ต้องรอ ---
     *   4. บันทึก Google Sheet ผ่าน Google Apps Script (background)
     *   5. ส่ง Telegram ข้อความ                        (background)
     *   6. ส่ง Telegram รูปภาพ                         (background)
     * 
     * วางไฟล์นี้ที่: controller/saveAndNotify.php (บน server)
     */

    require '../inc/function.php';

    header('Content-Type: application/json');

    $response = array(
        'status' => 0,
        'res' => '',
        'linkImg' => '',
        'memID' => ''
    );

    // ================================================================
    // CONFIG
    // ================================================================
    $link_main = "https://www.hofkrisda.com/motherfund_udon/";

    // Telegram (ย้ายมาจาก client-side เพื่อความปลอดภัย)
    $telegram_api = "https://api.telegram.org/bot";
    $telegram_ChatbotToken = "8595353994:AAEwm-tHTAU0cKpgVtP33zDhEk1Fh-ExVgo";
    $group_id = "-5498842320";

    // Google Apps Script
    $scriptURL = 'https://script.google.com/macros/s/AKfycbySzOEcmSkP-U8M5EHwumjBBEFzIYY6hC3XSW0b72xRb9wOfRkhKhFis6PHk8B8_sA/exec';

    // Google Sheet สำหรับนับรหัสสมาชิก
    $sheetCountURL = 'https://docs.google.com/spreadsheets/d/1hoplj4XkScirZsh_RPFroIH0TEcLv0MEfF6paXW_EaQ/gviz/tq?sheet=newform01';

    // ================================================================
    // รับข้อมูลจาก Client
    // ================================================================

    // --- ข้อมูลผู้รายงาน (สมาชิกหลัก) ---
    $in_mem_rp     = isset($_POST['in_mem_rp'])     ? trim($_POST['in_mem_rp']) : '';
    $in_rang_rp    = isset($_POST['in_rang_rp'])    ? trim($_POST['in_rang_rp']) : '';
    $in_name_rp    = isset($_POST['in_name_rp'])    ? trim($_POST['in_name_rp']) : '';
    $in_sname_rp   = isset($_POST['in_sname_rp'])   ? trim($_POST['in_sname_rp']) : '';
    $in_village_rp = isset($_POST['in_village_rp']) ? trim($_POST['in_village_rp']) : '';
    $in_cid_rp     = isset($_POST['in_cid_rp'])     ? trim($_POST['in_cid_rp']) : '';
    $in_subdist_rp = isset($_POST['in_subdist_rp']) ? trim($_POST['in_subdist_rp']) : '';
    $in_dist_rp    = isset($_POST['in_dist_rp'])    ? trim($_POST['in_dist_rp']) : '';
    $in_prov_rp    = isset($_POST['in_prov_rp'])    ? trim($_POST['in_prov_rp']) : '';

    // --- ข้อมูลสมาชิกใหม่ (ชั้นที่ 2) ---
    $in_typepeo  = isset($_POST['in_typepeo'])  ? trim($_POST['in_typepeo']) : '';
    $in_rang     = isset($_POST['in_rang'])     ? trim($_POST['in_rang']) : '';
    $in_name     = isset($_POST['in_name'])     ? trim($_POST['in_name']) : '';
    $in_sname    = isset($_POST['in_sname'])    ? trim($_POST['in_sname']) : '';
    $in_nickname = isset($_POST['in_nickname']) ? trim($_POST['in_nickname']) : '-';
    $in_cid      = isset($_POST['in_cid'])      ? trim($_POST['in_cid']) : '';
    $in_add      = isset($_POST['in_add'])      ? trim($_POST['in_add']) : '';
    $in_moo      = isset($_POST['in_moo'])      ? trim($_POST['in_moo']) : '';
    $in_subdist  = isset($_POST['in_subdist'])  ? trim($_POST['in_subdist']) : '';
    $in_dist     = isset($_POST['in_dist'])     ? trim($_POST['in_dist']) : '';
    $in_prov     = isset($_POST['in_prov'])     ? trim($_POST['in_prov']) : '';
    $in_phone    = isset($_POST['in_phone'])    ? trim($_POST['in_phone']) : '000';

    // --- LINE Profile ---
    $userId_line = isset($_POST['userId_line']) ? trim($_POST['userId_line']) : '';
    $nameLine    = isset($_POST['nameLine'])    ? trim($_POST['nameLine']) : '';
    $picUrl      = isset($_POST['picUrl'])      ? trim($_POST['picUrl']) : '';

    // --- วันที่ ---
    date_default_timezone_set("Asia/Bangkok");
    $thai_year  = date("Y") + 543;
    $dateNow    = date("d") . "-" . date("m") . "-" . $thai_year;       // 26-08-2569
    $dateReport = date("d") . "/" . date("m") . "/" . date("Y");         // 26/08/2026

    // ================================================================
    // STEP 1: นับรหัสสมาชิก จาก Google Sheet (server-side)
    // ================================================================
    $count = 1;
    $sheetData = @file_get_contents($sheetCountURL);

    if ($sheetData !== false) {
        // Google Visualization API response: google.visualization.Query.setResponse({...});
        $jsonStr = substr($sheetData, 47, -2);
        $jsonD = json_decode($jsonStr, true);

        if ($jsonD && isset($jsonD['table']['rows'])) {
            $rows = $jsonD['table']['rows'];
            $matchCount = 0;
            foreach ($rows as $row) {
                // column 4 = in_mem_rp (รหัสสมาชิกหลัก)
                if (isset($row['c'][4]['v']) && $row['c'][4]['v'] == $in_mem_rp) {
                    $matchCount++;
                }
            }
            $count = $matchCount + 1;
        }
    }

    $padded = str_pad($count, 3, '0', STR_PAD_LEFT);
    $memID  = $in_mem_rp . "_" . $padded;

    // ================================================================
    // STEP 2: อัปโหลดรูปภาพ (reuse uploadFile() จาก function.php)
    // ================================================================
    if (!empty($_FILES["file"])) {

        $resUpfile = uploadFile($_FILES["file"], $memID, "newform01");

        if ($resUpfile['status'] == 1) {
            $fileName  = $resUpfile['res'];
            $link_img  = $link_main . "img/newform01/" . $fileName;

            $response['status']  = 1;
            $response['res']     = $fileName;
            $response['linkImg'] = $link_img;
            $response['memID']   = $memID;
        } else {
            $response['status'] = 99;
            $response['res']    = $resUpfile['res'];
            echo json_encode($response);
            exit;
        }

    } else {
        $response['status'] = 99;
        $response['res']    = "ไม่สามารถอัพโหลดไฟล์ได้";
        echo json_encode($response);
        exit;
    }

    // ================================================================
    // STEP 3: ส่ง Response กลับ Client ทันที
    //         (client ได้ linkImg + memID → ไปทำ Flex Message + ปิดหน้าต่าง)
    // ================================================================
    ignore_user_abort(true);
    set_time_limit(120);

    $jsonResponse = json_encode($response);
    header('Content-Length: ' . strlen($jsonResponse));
    echo $jsonResponse;

    // Flush output ไปให้ client
    if (function_exists('fastcgi_finish_request')) {
        // PHP-FPM: ตัดการเชื่อมต่อ client ทันที
        fastcgi_finish_request();
    } else {
        // Apache mod_php: flush output buffer
        if (ob_get_level() > 0) {
            ob_end_flush();
        }
        flush();
    }

    // ================================================================
    // ===== BACKGROUND PROCESSING (client ได้ response แล้ว) =========
    // ================================================================

    // --- STEP 4: บันทึก Google Sheet ผ่าน Google Apps Script ---
    $gasData = array(
        'sheetName'      => 'newform01',
        'memID'          => $memID,
        'in_typepeo'     => $in_typepeo,
        'in_rang'        => $in_rang,
        'in_name'        => $in_name,
        'in_sname'       => $in_sname,
        'in_nickname'    => $in_nickname,
        'in_cid'         => $in_cid,
        'in_add'         => $in_add,
        'in_moo'         => $in_moo,
        'in_provText'    => $in_prov,
        'in_distText'    => $in_dist,
        'in_subdistText' => $in_subdist,
        'in_phone'       => $in_phone,
        'dateReport'     => $dateReport,
        'in_rang_rp'     => $in_rang_rp,
        'in_name_rp'     => $in_name_rp,
        'in_sname_rp'    => $in_sname_rp,
        'in_mem_rp'      => $in_mem_rp,
        'in_cid_rp'      => $in_village_rp,   // หมายเหตุ: โค้ดเดิมส่ง village_rp ในชื่อ in_cid_rp
        'in_subdist_rp'  => $in_subdist_rp,
        'in_dist_rp'     => $in_dist_rp,
        'in_prov_rp'     => $in_prov_rp,
        'userId_line'    => $userId_line,
        'nameLine'       => $nameLine,
        'picUrl'         => $picUrl,
        'linkImg'        => $link_img
    );

    $ch = curl_init($scriptURL);
    curl_setopt_array($ch, [
        CURLOPT_POST           => true,
        CURLOPT_POSTFIELDS     => $gasData,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_TIMEOUT        => 60,
        CURLOPT_SSL_VERIFYPEER => false
    ]);
    curl_exec($ch);
    curl_close($ch);

    // --- STEP 5: ส่ง Telegram ข้อความ (sendMessage) ---
    $in_name_sur    = $in_rang . " " . $in_name . "  " . $in_sname;
    $in_name_sur_rp = $in_rang_rp . " " . $in_name_rp . "  " . $in_sname_rp;

    $messageNotify = "กองทุนแม่ฯ ปปส.อุดรธานี\n======"
        . "\nสมาชิกทั่วไป\nรายงาน ประจำวันที่ : " . $dateNow
        . "\nชื่อ-สกุล เลข ปชช. สมาชิกใหม่"
        . "\nชื่อ-สกุล : " . $in_name_sur
        . "\nชื่อเล่น : " . $in_nickname
        . "\nเลขที่บัตรประชาชน : " . $in_cid
        . "\nประเภท : " . $in_typepeo
        . "\nที่อยู่บ้านเลขที่ : " . $in_add
        . "\nหมู่ : " . $in_moo
        . "\nต. : " . $in_subdist
        . "\nอ. : " . $in_dist
        . "\nจ. : " . $in_prov
        . "\nเบอร์ติดต่อ : " . $in_phone
        . "\n\nผู้รายงาน : " . $in_name_sur_rp
        . "\nหมู่บ้าน : " . $in_village_rp
        . "\n\nรูปประจำตัว ▼";

    @file_get_contents(
        $telegram_api . $telegram_ChatbotToken 
        . "/sendMessage?chat_id=" . $group_id 
        . "&text=" . urlencode($messageNotify)
    );

    // --- STEP 6: ส่ง Telegram รูปภาพ (sendPhoto) ---
    $filePath = "../img/newform01/" . $fileName;

    if (file_exists($filePath)) {
        $data = [
            'chat_id' => $group_id,
            'photo'   => new CURLFile(
                $filePath,
                mime_content_type($filePath),
                basename($filePath)
            )
        ];

        $ch = curl_init(
            $telegram_api . $telegram_ChatbotToken . "/sendPhoto"
        );
        curl_setopt_array($ch, [
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => $data,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => 60
        ]);
        curl_exec($ch);
        curl_close($ch);
    }

?>
