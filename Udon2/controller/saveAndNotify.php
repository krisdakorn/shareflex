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

    require __DIR__ . '/../inc/function.php';
    require __DIR__ . '/../inc/app_config.php';

    header('Content-Type: application/json');

    $response = array(
        'status' => 0,
        'res' => '',
        'linkImg' => '',
        'memID' => ''
    );

    // ================================================================
    // LOGGING HELPER
    // ================================================================
    function writeLog($message, $level = 'INFO') {
        global $logFile, $logDir;
        
        if (!is_dir($logDir)) {
            @mkdir($logDir, 0755, true);
        }
        
        $timestamp = date('Y-m-d H:i:s');
        $logEntry  = "[{$timestamp}] [{$level}] {$message}" . PHP_EOL;
        @file_put_contents($logFile, $logEntry, FILE_APPEND | LOCK_EX);
    }

    // ================================================================
    // INPUT VALIDATION
    // ================================================================
    function validateCID($cid) {
        // เลขบัตรประชาชน 13 หลัก
        return preg_match('/^\d{13}$/', $cid);
    }

    function validatePhone($phone) {
        // เบอร์โทร 9-10 หลัก หรือ "000"
        return $phone === '000' || preg_match('/^\d{9,10}$/', $phone);
    }

    function sanitizeInput($value) {
        return htmlspecialchars(strip_tags(trim($value)), ENT_QUOTES, 'UTF-8');
    }

    // ================================================================
    // รับข้อมูลจาก Client
    // ================================================================

    // --- ข้อมูลผู้รายงาน (สมาชิกหลัก) ---
    $in_mem_rp     = isset($_POST['in_mem_rp'])     ? sanitizeInput($_POST['in_mem_rp']) : '';
    $in_rang_rp    = isset($_POST['in_rang_rp'])    ? sanitizeInput($_POST['in_rang_rp']) : '';
    $in_name_rp    = isset($_POST['in_name_rp'])    ? sanitizeInput($_POST['in_name_rp']) : '';
    $in_sname_rp   = isset($_POST['in_sname_rp'])   ? sanitizeInput($_POST['in_sname_rp']) : '';
    $in_village_rp = isset($_POST['in_village_rp']) ? sanitizeInput($_POST['in_village_rp']) : '';
    $in_cid_rp     = isset($_POST['in_cid_rp'])     ? sanitizeInput($_POST['in_cid_rp']) : '';
    $in_subdist_rp = isset($_POST['in_subdist_rp']) ? sanitizeInput($_POST['in_subdist_rp']) : '';
    $in_dist_rp    = isset($_POST['in_dist_rp'])    ? sanitizeInput($_POST['in_dist_rp']) : '';
    $in_prov_rp    = isset($_POST['in_prov_rp'])    ? sanitizeInput($_POST['in_prov_rp']) : '';

    // --- ข้อมูลสมาชิกใหม่ (ชั้นที่ 2) ---
    $in_typepeo  = isset($_POST['in_typepeo'])  ? sanitizeInput($_POST['in_typepeo']) : '';
    $in_rang     = isset($_POST['in_rang'])     ? sanitizeInput($_POST['in_rang']) : '';
    $in_name     = isset($_POST['in_name'])     ? sanitizeInput($_POST['in_name']) : '';
    $in_sname    = isset($_POST['in_sname'])    ? sanitizeInput($_POST['in_sname']) : '';
    $in_nickname = isset($_POST['in_nickname']) ? sanitizeInput($_POST['in_nickname']) : '-';
    $in_cid      = isset($_POST['in_cid'])      ? trim($_POST['in_cid']) : '';
    $in_add      = isset($_POST['in_add'])      ? sanitizeInput($_POST['in_add']) : '';
    $in_moo      = isset($_POST['in_moo'])      ? sanitizeInput($_POST['in_moo']) : '';
    $in_subdist  = isset($_POST['in_subdist'])  ? sanitizeInput($_POST['in_subdist']) : '';
    $in_dist     = isset($_POST['in_dist'])     ? sanitizeInput($_POST['in_dist']) : '';
    $in_prov     = isset($_POST['in_prov'])     ? sanitizeInput($_POST['in_prov']) : '';
    $in_phone    = isset($_POST['in_phone'])    ? trim($_POST['in_phone']) : '000';

    // --- LINE Profile ---
    $userId_line = isset($_POST['userId_line']) ? trim($_POST['userId_line']) : '';
    $nameLine    = isset($_POST['nameLine'])    ? sanitizeInput($_POST['nameLine']) : '';
    $picUrl      = isset($_POST['picUrl'])      ? trim($_POST['picUrl']) : '';

    // --- Validation ---
    if (empty($in_mem_rp) || empty($in_name) || empty($in_sname)) {
        $response['status'] = 99;
        $response['res']    = "ข้อมูลไม่ครบ กรุณากรอกให้ครบถ้วน";
        writeLog("Validation failed: missing required fields (mem_rp={$in_mem_rp}, name={$in_name})", 'WARN');
        echo json_encode($response);
        exit;
    }

    if (!empty($in_cid) && !validateCID($in_cid)) {
        $response['status'] = 99;
        $response['res']    = "เลขบัตรประชาชนไม่ถูกต้อง (ต้อง 13 หลัก)";
        writeLog("Validation failed: invalid CID '{$in_cid}'", 'WARN');
        echo json_encode($response);
        exit;
    }

    // --- วันที่ ---
    date_default_timezone_set("Asia/Bangkok");
    $thai_year  = date("Y") + 543;
    $dateNow    = date("d") . "-" . date("m") . "-" . $thai_year;       // 26-08-2569
    $dateReport = date("d") . "/" . date("m") . "/" . date("Y");         // 26/08/2026

    writeLog("=== START === memID_rp={$in_mem_rp}, name={$in_rang} {$in_name} {$in_sname}");

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
        writeLog("STEP 1: Sheet count done. matchCount={$matchCount}, newCount={$count}");
    } else {
        writeLog("STEP 1: WARNING - Could not fetch sheet data from Google", 'WARN');
    }

    $padded = str_pad($count, 3, '0', STR_PAD_LEFT);
    $memID  = $in_mem_rp . "_" . $padded;

    writeLog("STEP 1: Generated memID={$memID}");

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

            writeLog("STEP 2: Upload OK. file={$fileName}, link={$link_img}");
        } else {
            $response['status'] = 99;
            $response['res']    = $resUpfile['res'];
            writeLog("STEP 2: Upload FAILED. error={$resUpfile['res']}", 'ERROR');
            echo json_encode($response);
            exit;
        }

    } else {
        $response['status'] = 99;
        $response['res']    = "ไม่สามารถอัพโหลดไฟล์ได้";
        writeLog("STEP 2: No file received", 'ERROR');
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

    writeLog("STEP 3: Response sent to client. status=1, memID={$memID}");

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
    $gasResponse = curl_exec($ch);
    $gasError    = curl_error($ch);
    $gasHttpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($gasError) {
        writeLog("STEP 4: Google Sheet FAILED. curl_error={$gasError}", 'ERROR');
    } else {
        writeLog("STEP 4: Google Sheet done. HTTP={$gasHttpCode}, response=" . substr($gasResponse, 0, 200));
    }

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

    $tgMsgResult = @file_get_contents(
        $telegram_api . $telegram_ChatbotToken 
        . "/sendMessage?chat_id=" . $group_id 
        . "&text=" . urlencode($messageNotify)
    );

    if ($tgMsgResult === false) {
        writeLog("STEP 5: Telegram sendMessage FAILED", 'ERROR');
    } else {
        writeLog("STEP 5: Telegram sendMessage OK");
    }

    // --- STEP 6: ส่ง Telegram รูปภาพ (sendPhoto) ---
    $filePath = __DIR__ . "/../img/newform01/" . $fileName;

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
        $tgPhotoResult = curl_exec($ch);
        $tgPhotoError  = curl_error($ch);
        curl_close($ch);

        if ($tgPhotoError) {
            writeLog("STEP 6: Telegram sendPhoto FAILED. curl_error={$tgPhotoError}", 'ERROR');
        } else {
            writeLog("STEP 6: Telegram sendPhoto OK");
        }
    } else {
        writeLog("STEP 6: File not found for Telegram photo: {$filePath}", 'WARN');
    }

    writeLog("=== DONE === memID={$memID}");

?>
