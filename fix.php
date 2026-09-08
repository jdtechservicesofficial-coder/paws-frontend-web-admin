<?php
$file = "ca/lib/screens/booking_module/add_booking_forms/grooming_service_screen.dart";
$lines = file($file);

$startIndex = 0;
for ($i = 0; $i < count($lines); $i++) {
    if (strpos($lines[$i], "// ignore_for_file: deprecated_member_use") !== false) {
        $startIndex = $i;
    }
}
$validLines = array_slice($lines, $startIndex);

$outLines = [];
$skip = 0;
for ($i = 0; $i < count($validLines); $i++) {
    if ($skip > 0) {
        $skip--;
        continue;
    }
    if (isset($validLines[$i+5]) && 
        trim($validLines[$i]) === "]," &&
        trim($validLines[$i+1]) === ")," &&
        trim($validLines[$i+2]) === ")," &&
        trim($validLines[$i+3]) === "]," &&
        trim($validLines[$i+4]) === ")," &&
        trim($validLines[$i+5]) === "),") {
        
        $outLines[] = $validLines[$i];
        $outLines[] = $validLines[$i+1];
        $outLines[] = $validLines[$i+2];
        $skip = 5; 
        continue;
    }
    $outLines[] = $validLines[$i];
}

file_put_contents($file, implode("", $outLines));
echo "Fixed!";
?>
