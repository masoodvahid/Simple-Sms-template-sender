<?php

$box_numbers = 4;
$retry_box_numbers = 2;

// DB config 
$dbHost = 'localhost';
$dbUser = 'root';
$dbPass = '';
$dbname = 'sendsms';
$charset = 'utf8';
$timezone = 'Asia/Tehran';
$sql_conect = mysql_connect($dbHost, $dbUser, $dbPass) or die (" در اتصال به دیتابیس مشکلی به وجود آمده است. لطفا چند دقیقه صبر کنید و سپس مجددا اقدام فرمایید. در صورت بروز مجدد مشکل ، این خطا را به پشتیبان سایت اعلام فرمایید. ");
mysql_select_db($dbname,$sql_conect);
mysql_set_charset($charset,$sql_conect);
date_default_timezone_set($timezone);

$temp = mysql_query("SELECT * FROM settings ") or die ("خطایی رخ داده است :".mysql_error());
$settings = mysql_fetch_assoc($temp);
$settings['sending_method'] = 'WSDL';  // URL, WSDL, SERVICE, RESTFUL, ...
?>