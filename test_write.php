<?php
$test_file = 'assets/images/games/test.txt';
if (file_put_contents($test_file, 'test')) {
    echo "Directory is writable. File created: $test_file";
    unlink($test_file);
} else {
    echo "Directory is NOT writable. Failed to create file in: assets/images/games/";
}
?>
