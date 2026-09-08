<?php
/**
 * Exact Mapping Renaming Script
 * This maps specific file numbers to exact product IDs.
 */

$folderPath = __DIR__ . '/public/bulk_image';

if (!is_dir($folderPath)) {
    die("Error: folder public/bulk_image not found.\n");
}

$files = scandir($folderPath);
$renamed = 0;
$skipped = 0;

$map = [
    '1' => '1192',
    '2' => '1193',
    '3' => '1194',
    '4' => '1195',
    '5' => '1196',
    '6' => '1197',
    '7' => '1198',
    '30' => '1204',
    '32' => '1223',
    '33' => '1224',
    '34' => '1225',
    '36' => '1226',
    '37' => '1227',
    '38' => '1228',
    '39' => '1229',
    '41' => '1230',
    '42' => '1231',
    '43' => '1232',
    '46' => '1235',
    '47' => '1236',
    '48' => '1237',
    '49' => '1238',
    '50' => '1239',
    '51' => '1240',
    '52' => '1241',
    '53' => '1242',
    '54' => '1243',
    '56' => '1245',
    '57' => '1246',
    '58' => '1248',
    '59' => '1249',
    '62' => '1252',
    '63' => '1253',
    '64' => '1254',
    '65' => '1255',
    '66' => '1256',
    '67' => '1257',
    '68' => '1258',
    '69' => '1259',
    '70' => '1260',
    '71' => '1261',
    '72' => '1262',
    '73' => '1263',
    '74' => '1264',
    '75' => '1265',
    '76' => '1266',
    '77' => '1267',
    '78' => '1268',
    '79' => '1269',
    '81' => '1270',
    '82' => '1271',
    '83' => '1272',
    '84' => '1273',
    '86' => '1274',
    '87' => '1276',
    '88' => '1277',
    '89' => '1278',
    '90' => '1279',
    '91' => '1280',
    '92' => '1281',
    '94' => '1282',
    '96' => '1284',
    '98' => '1286',
    '99' => '1288'
];

echo "Starting rename process...\n";
echo str_repeat("-", 40) . "\n";

foreach ($files as $file) {
    if ($file === '.' || $file === '..') {
        continue;
    }

    $filePath = $folderPath . '/' . $file;

    if (is_file($filePath)) {
        $pathInfo = pathinfo($file);
        $filename = $pathInfo['filename'];
        $extension = isset($pathInfo['extension']) ? '.' . $pathInfo['extension'] : '';

        if (isset($map[$filename])) {
            $newFilename = $map[$filename] . $extension;
            $newFilePath = $folderPath . '/' . $newFilename;

            if (rename($filePath, $newFilePath)) {
                echo "Renamed: {$file} -> {$newFilename}\n";
                $renamed++;
            } else {
                echo "Failed to rename: {$file}\n";
                $skipped++;
            }
        } else {
            echo "Skipped (not mapped): {$file}\n";
            $skipped++;
        }
    }
}

echo str_repeat("-", 40) . "\n";
echo "Done! Successfully renamed {$renamed} files.\n";
