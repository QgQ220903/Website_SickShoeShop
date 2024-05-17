<?php

/**
 * Sử dụng htacess để có đường dẫn như sau
 * website/home/index/product
 * thay vì
 * website.php?u=abcxyz
 */
session_start();
$path = $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['SERVER_NAME'] . $_SERVER['PHP_SELF'];
$path = str_replace("index.php", "", $path);

define("ROOT", $path);
define("ASSETS", $path . "public/assets/");

include "./app/init.php";
$app = new App();
?>