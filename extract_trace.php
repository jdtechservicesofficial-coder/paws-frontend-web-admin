<?php
$file = 'storage/logs/laravel-2026-08-21.log';
$lines = file($file);
$found = [];
$capture = false;
$count = 0;
foreach ($lines as $line) {
    if (strpos($line, '1054') !== false && strpos($line, 'status') !== false) {
        $capture = true;
    }
    if ($capture) {
        $found[] = $line;
        $count++;
        if ($count > 30) {
            $capture = false;
            $count = 0;
            break;
        }
    }
}
echo implode('', $found);
