<?php
$file = "ca/lib/screens/booking_module/add_booking_forms/grooming_service_screen.dart";
$lines = file($file);

$startIdx = -1;
for ($i = 0; $i < count($lines); $i++) {
    if (strpos($lines[$i], "Text(\"Service Details\"") !== false) {
        // go back to the Container start
        for ($j = $i; $j >= 0; $j--) {
            if (strpos($lines[$j], "Container(") !== false) {
                $startIdx = $j;
                break;
            }
        }
        break;
    }
}

$endIdx = -1;
for ($i = 0; $i < count($lines); $i++) {
    if (strpos($lines[$i], "Text(\"Date & Time\"") !== false) {
        // go back to the 16.height before Container
        for ($j = $i; $j >= 0; $j--) {
            if (strpos($lines[$j], "16.height") !== false) {
                $endIdx = $j;
                break;
            }
        }
        break;
    }
}

$part1 = array_slice($lines, 0, $startIdx);
$part3 = array_slice($lines, $endIdx);

$serviceDetails = file_get_contents("scratch2.txt");
// extract from scratch2.txt the lines up to line 198 (which is the closing of Obx for branch/groomer)
$sdLines = explode("\n", $serviceDetails);
$sdClean = array_slice($sdLines, 0, 199); // 0 to 198

// Add Switch and Address blocks manually
$manual = [
"                        Obx(() {",
"                          if (groomingController.isPickupDropoffService && !groomingController.isHomeService) {",
"                            return Column(",
"                              children: [",
"                                32.height,",
"                                Container(",
"                                  decoration: boxDecorationDefault(color: context.cardColor),",
"                                  padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 4),",
"                                  child: Row(",
"                                    mainAxisAlignment: MainAxisAlignment.spaceBetween,",
"                                    children: [",
"                                      Text(locale.value.dropoffPickupAddress, style: primaryTextStyle()),",
"                                      Switch(",
"                                        activeColor: primaryColor,",
"                                        value: groomingController.isPickUpDropOff.value,",
"                                        onChanged: (val) {",
"                                          groomingController.isPickUpDropOff(val);",
"                                        },",
"                                      ),",
"                                    ],",
"                                  ),",
"                                ).paddingSymmetric(horizontal: 16),",
"                              ],",
"                            );",
"                          }",
"                          return const Offstage();",
"                        }),",
"                        Obx(() => (groomingController.isHomeService || (groomingController.isPickupDropoffService && groomingController.isPickUpDropOff.value))",
"                            ? Column(",
"                                children: [",
"                                  32.height,",
"                                  AppTextField(",
"                                    title: locale.value.address,",
"                                    textStyle: primaryTextStyle(size: 12),",
"                                    controller: groomingController.addressCont,",
"                                    textFieldType: TextFieldType.MULTILINE,",
"                                    minLines: 3,",
"                                    decoration: inputDecoration(context, hintText: locale.value.writeAddressHere, fillColor: context.cardColor, filled: true),",
"                                  ).paddingSymmetric(horizontal: 16),",
"                                ],",
"                              )",
"                            : const Offstage()),",
"                            ],",
"                          ),",
"                        ),"
];

$containerStart = [
"                        Container(",
"                          padding: const EdgeInsets.symmetric(vertical: 16),",
"                          margin: const EdgeInsets.symmetric(horizontal: 16),",
"                          decoration: boxDecorationDefault(color: context.cardColor, borderRadius: radius(16)),",
"                          child: Column(",
"                            crossAxisAlignment: CrossAxisAlignment.start,",
"                            children: [",
"                              Row(",
"                                children: ["
];

// Clean line endings from sdClean
foreach ($sdClean as &$line) {
    $line = rtrim($line, "\r\n");
}
foreach ($part1 as &$line) {
    $line = rtrim($line, "\r\n");
}
foreach ($part3 as &$line) {
    $line = rtrim($line, "\r\n");
}

$finalLines = array_merge($part1, $containerStart, $sdClean, $manual, $part3);
$finalStr = implode("\n", $finalLines);
file_put_contents($file, $finalStr);
echo "Done replacing!\n";
?>
