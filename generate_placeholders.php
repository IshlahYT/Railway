<?php
// Script to generate placeholder images for HI 102 trolley website
// Run: php generate_placeholders.php

$images = [
    'public/images/trolley/img8_full_front.jpeg' => 'HI 102 Full Assembly\nTampak Depan',
    'public/images/trolley/img7_control_panel.jpeg' => 'Panel Kontrol\n& Kemudi',
    'public/images/trolley/img3_sprayer_boom.jpeg' => '4-Nozzle Airless\nSprayer Boom',
    'public/images/trolley/img1_pump_battery.jpeg' => 'Mesin Pompa\nAirless Mollar',
    'public/images/trolley/img2_pump_gauge.jpeg' => 'Manometer &\nKatup Tekanan',
    'public/images/trolley/img4_motor_handbrake.jpeg' => 'Motor BLDC &\nRem Tromol',
    'public/images/trolley/img5_rear_wheels.jpeg' => 'Roda Rel &\nBumper LED',
    'public/images/trolley/img6_top_seat.jpeg' => 'Kursi Operator &\nDual Battery',
    'public/images/trolley/blueprint_dimensi.png' => 'Blueprint CAD\nDimensi HI 102',
];

foreach ($images as $path => $label) {
    $fullPath = __DIR__ . '/' . $path;
    
    // Skip if file already exists
    if (file_exists($fullPath)) {
        echo "SKIP: $path (already exists)\n";
        continue;
    }
    
    $width = 800;
    $height = 600;
    $img = imagecreatetruecolor($width, $height);
    
    // Background gradient (dark zinc to dark)
    $bgColor = imagecolorallocate($img, 39, 39, 42); // zinc-800
    imagefill($img, 0, 0, $bgColor);
    
    // Orange accent rectangle
    $orange = imagecolorallocate($img, 249, 115, 22); // rail-500
    imagefilledrectangle($img, 0, $height - 6, $width, $height, $orange);
    
    // Border
    $borderColor = imagecolorallocate($img, 63, 63, 70); // zinc-700
    imagerectangle($img, 0, 0, $width - 1, $height - 1, $borderColor);
    
    // Text
    $white = imagecolorallocate($img, 255, 255, 255);
    $gray = imagecolorallocate($img, 161, 161, 170); // zinc-400
    
    // Draw label lines
    $lines = explode("\n", $label);
    $startY = ($height / 2) - (count($lines) * 12);
    foreach ($lines as $i => $line) {
        $line = trim($line);
        $textWidth = strlen($line) * 9;
        $x = ($width - $textWidth) / 2;
        imagestring($img, 5, (int)$x, (int)($startY + $i * 24), $line, $white);
    }
    
    // Draw "PLACEHOLDER" label
    $placeholderText = "[ PLACEHOLDER IMAGE ]";
    $ptWidth = strlen($placeholderText) * 7;
    imagestring($img, 3, (int)(($width - $ptWidth) / 2), $height - 40, $placeholderText, $gray);
    
    // HI 102 badge
    imagestring($img, 2, 20, 20, "HI 102 - Railway Electric Trolley", $orange);
    
    // Save
    if (str_ends_with($path, '.png')) {
        imagepng($img, $fullPath);
    } else {
        imagejpeg($img, $fullPath, 85);
    }
    imagedestroy($img);
    
    echo "OK: $path\n";
}

echo "\nDone! All placeholder images generated.\n";
