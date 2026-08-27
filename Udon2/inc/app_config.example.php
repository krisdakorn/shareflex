<?php
    /**
     * app_config.example.php
     * ----------------------
     * ⚠️ ไฟล์ตัวอย่าง — ห้าม push ไฟล์ app_config.php ที่มี Token จริงขึ้น GitHub!
     *
     * วิธีใช้:
     *   1. Copy ไฟล์นี้แล้วเปลี่ยนชื่อเป็น app_config.php
     *      $ cp app_config.example.php app_config.php
     *   2. ใส่ค่าจริงลงในไฟล์ app_config.php
     *   3. ไฟล์ app_config.php จะถูก .gitignore ไม่ให้ push ขึ้น Git
     */

    // ================================================================
    // SITE
    // ================================================================
    $link_main = "https://yourdomain.com/motherfund_udon/";

    // ================================================================
    // TELEGRAM
    // ================================================================
    $telegram_api            = "https://api.telegram.org/bot";
    $telegram_ChatbotToken   = "YOUR_TELEGRAM_BOT_TOKEN_HERE";     // ← ใส่ Bot Token ของคุณ
    $group_id                = "YOUR_TELEGRAM_GROUP_ID_HERE";       // ← ใส่ Group/Chat ID

    // ================================================================
    // GOOGLE APPS SCRIPT  (บันทึกลง Google Sheet)
    // ================================================================
    $scriptURL = 'YOUR_GOOGLE_APPS_SCRIPT_URL_HERE';               // ← ใส่ URL ของ Apps Script

    // ================================================================
    // GOOGLE SHEET  (นับรหัสสมาชิก)
    // ================================================================
    $sheetCountURL = 'YOUR_GOOGLE_SHEET_URL_HERE';                  // ← ใส่ URL ของ Google Sheet

    // ================================================================
    // LOG
    // ================================================================
    $logDir  = __DIR__ . '/../logs';
    $logFile = $logDir . '/saveAndNotify.log';
?>
