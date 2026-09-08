<?php
$file = "ca/lib/screens/booking_module/add_booking_forms/grooming_service_screen.dart";
$lines = file($file);
$block = array_slice($lines, 100, 300); // 100 to 400
file_put_contents("scratch2.txt", implode("", $block));
?>
