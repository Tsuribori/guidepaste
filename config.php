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

$header_var = "Location: http://$host$uri/";

$register_page = "<form action='profile.php?id=register' enctype='multipart/form-data' method='POST'/>
   <input type='text' name='name'/>
   <input type='password' name='password'/>
   <input type='submit' value='Register'/>";

$login_page = "<form action='profile.php?id=login' enctype='multipart/form-data' method='POST'/>
   <input type='text' name='name'/>
   <input type='password' name='password'/>
   <input type='submit' value='Login'/>";

$wrongpass = "<p>Incorrect password<p>";
   
?>
