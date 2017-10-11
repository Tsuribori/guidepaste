<?php

$websitename = "Test";
$rows = 50;
$columns = 100;
$database_name = "pastedatabase";
$html_header = 
"<!DOCTYPE html>
<html>
<head>
<meta charset=utf-8>
<link rel='stylesheet' type='text/css' href='stylesheet.css'>
</head>";

$html_end =
"</html>";
$host = $_SERVER['HTTP_HOST'];
$uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');

$header_var = "Location: http://$host$uri/";
$host_var = "http://$host$uri/";

$page_header = "<div id='empty_space'></div>
      <div id='header'><h3>$websitename</h3></div>
      <div id='account_buttons'>
      <a href=".$host_var."accounts.php?id=login>Login</a>
      <a href=".$host_var."accounts.php?id=register>Register</a></div>";
$index_page = "<div id=pastediv><p>Title:</p><input type='text' name='title' required form='pasteform'/>
      <p>Text:</p> <textarea required form='pasteform' rows='$rows' cols='$columns' name='paste'></textarea>
      <form action='db.php' id='pasteform' enctype='multipart/form-data' method='POST'/>
      <input type='submit' value='Submit paste'/> </div>
";
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
