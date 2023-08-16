<?php
$dir = "/img/";
$files = glob($dir . "*.{jpg,jpeg,png,gif}", GLOB_BRACE);

foreach ($files as $file) {
    echo "<a href='{$file}'></a>\n";
}
?>
