<?php
// Test script to check PHP upload limits
echo "PHP Upload Configuration:\n";
echo "upload_max_filesize: " . ini_get('upload_max_filesize') . "\n";
echo "post_max_size: " . ini_get('post_max_size') . "\n";
echo "max_file_uploads: " . ini_get('max_file_uploads') . "\n";
echo "max_execution_time: " . ini_get('max_execution_time') . "\n";
echo "max_input_time: " . ini_get('max_input_time') . "\n";
echo "memory_limit: " . ini_get('memory_limit') . "\n";

// Convert to bytes for easier comparison
function convertToBytes($size) {
    $unit = strtolower(substr($size, -1));
    $value = (int) $size;
    
    switch($unit) {
        case 'g': return $value * 1024 * 1024 * 1024;
        case 'm': return $value * 1024 * 1024;
        case 'k': return $value * 1024;
        default: return $value;
    }
}

$uploadMaxBytes = convertToBytes(ini_get('upload_max_filesize'));
$postMaxBytes = convertToBytes(ini_get('post_max_size'));

echo "\nIn bytes:\n";
echo "upload_max_filesize: " . $uploadMaxBytes . " bytes (" . round($uploadMaxBytes / 1024 / 1024, 2) . " MB)\n";
echo "post_max_size: " . $postMaxBytes . " bytes (" . round($postMaxBytes / 1024 / 1024, 2) . " MB)\n";

echo "\nCan handle 8MB files: " . (($uploadMaxBytes >= 8388608 && $postMaxBytes >= 8388608) ? "YES" : "NO") . "\n";
?>
