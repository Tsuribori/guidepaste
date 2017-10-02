<?php

$rows = 50;
$columns = 100;
$database_name = "pastedatabase";
$html_header = 
"<!DOCTYPE html>
<html>
<head>
<meta charset=utf-8>
</head>";

$html_end =
"</html>";
$host = $_SERVER['HTTP_HOST'];
$uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');

$header_var = "Location: http://$host$uri/;
?>
