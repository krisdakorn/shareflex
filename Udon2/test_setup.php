<?php
/**
 * test_setup.php — ตรวจสอบว่า PHP environment พร้อมทำงาน
 */
header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>กองทุนแม่ฯ — ทดสอบระบบ</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; max-width: 700px; margin: 40px auto; padding: 20px; }
        h1 { color: #00AAF5; }
        .ok { color: #22c55e; font-weight: bold; }
        .fail { color: #ef4444; font-weight: bold; }
        table { border-collapse: collapse; width: 100%; margin-top: 15px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background-color: #f0f9ff; }
    </style>
</head>
<body>
    <h1>🔧 ทดสอบระบบกองทุนแม่ฯ</h1>
    <p>PHP Version: <strong><?= PHP_VERSION ?></strong></p>

    <table>
        <tr><th>รายการตรวจสอบ</th><th>สถานะ</th></tr>
        <?php
        $checks = [
            'PHP >= 8.0'           => version_compare(PHP_VERSION, '8.0.0', '>='),
            'cURL extension'       => extension_loaded('curl'),
            'fileinfo extension'   => extension_loaded('fileinfo'),
            'JSON extension'       => extension_loaded('json'),
            'mbstring extension'   => extension_loaded('mbstring'),
            'controller/ exists'   => is_dir(__DIR__ . '/controller'),
            'inc/ exists'          => is_dir(__DIR__ . '/inc'),
            'img/newform01/ exists'=> is_dir(__DIR__ . '/img/newform01'),
            'logs/ exists'         => is_dir(__DIR__ . '/logs'),
            'logs/ writable'       => is_writable(__DIR__ . '/logs'),
            'function.php'         => file_exists(__DIR__ . '/inc/function.php'),
            'app_config.php'       => file_exists(__DIR__ . '/inc/app_config.php'),
            'saveAndNotify.php'    => file_exists(__DIR__ . '/controller/saveAndNotify.php'),
        ];

        $allOk = true;
        foreach ($checks as $label => $ok) {
            $class = $ok ? 'ok' : 'fail';
            $icon  = $ok ? '✅' : '❌';
            if (!$ok) $allOk = false;
            echo "<tr><td>{$label}</td><td class='{$class}'>{$icon}</td></tr>\n";
        }
        ?>
    </table>

    <h2 style="margin-top:30px;">
        <?= $allOk ? '✅ ระบบพร้อมทำงาน!' : '⚠️ มีรายการที่ยังไม่พร้อม กรุณาตรวจสอบ' ?>
    </h2>

    <h3>📂 โครงสร้างไฟล์</h3>
    <pre><?php
    function listTree($dir, $prefix = '') {
        $items = scandir($dir);
        $items = array_diff($items, ['.', '..']);
        $items = array_values($items);
        
        for ($i = 0; $i < count($items); $i++) {
            $path = $dir . DIRECTORY_SEPARATOR . $items[$i];
            $isLast = ($i === count($items) - 1);
            $connector = $isLast ? '└── ' : '├── ';
            $subPrefix = $isLast ? '    ' : '│   ';
            
            echo $prefix . $connector . $items[$i] . "\n";
            
            if (is_dir($path) && $items[$i] !== 'assets' && $items[$i] !== 'vendor') {
                listTree($path, $prefix . $subPrefix);
            }
        }
    }
    listTree(__DIR__);
    ?></pre>
</body>
</html>
