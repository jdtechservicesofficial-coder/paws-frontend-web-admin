<?php
$file = "ca/lib/screens/booking_module/add_booking_forms/grooming_service_screen.dart";
$lines = file($file);
$block = array_slice($lines, 250, 201);
file_put_contents("scratch.txt", implode("", $block));
?>
