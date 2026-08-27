<?php
    /**
     * app_config.php
     * ---------------
     * ค่าตั้งค่าส่วนกลาง (Credentials & URLs)
     * แยกออกจากโค้ดหลักเพื่อความปลอดภัย
     */

    // ================================================================
    // SITE
    // ================================================================
    $link_main = "https://www.hofkrisda.com/motherfund_udon/";

    // ================================================================
    // TELEGRAM
    // ================================================================
    $telegram_api            = "https://api.telegram.org/bot";
    $telegram_ChatbotToken   = "8595353994:AAEwm-tHTAU0cKpgVtP33zDhEk1Fh-ExVgo";
    $group_id                = "-5498842320";

    // ================================================================
    // GOOGLE APPS SCRIPT  (บันทึกลง Google Sheet)
    // ================================================================
    $scriptURL = 'https://script.google.com/macros/s/AKfycbySzOEcmSkP-U8M5EHwumjBBEFzIYY6hC3XSW0b72xRb9wOfRkhKhFis6PHk8B8_sA/exec';

    // ================================================================
    // GOOGLE SHEET  (นับรหัสสมาชิก)
    // ================================================================
    $sheetCountURL = 'https://docs.google.com/spreadsheets/d/1hoplj4XkScirZsh_RPFroIH0TEcLv0MEfF6paXW_EaQ/gviz/tq?sheet=newform01';

    // ================================================================
    // LOG
    // ================================================================
    $logDir  = __DIR__ . '/../logs';
    $logFile = $logDir . '/saveAndNotify.log';
?>
