<?php
session_start();
$websitename = "Test";
$database_name = "pastedatabase";
$html_header = 
"<!DOCTYPE html>
<html>
<head>
<meta charset=utf-8>
<meta name='viewport' content='width=device-width, initial-scale=1.0'>
<link rel='stylesheet' type='text/css' href='stylesheet.css'>
</head>
<body>";

$html_end =
"</body>
</html>";
$host = $_SERVER['HTTP_HOST'];
$uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');

$header_var = "Location: http://$host$uri/";
$host_var = "http://$host$uri/";

$logged_in = "<header id='header'>
       <h2 id='name'><a id='namelink' href='".$host_var."index.php'>$websitename</a></h2>
       <div id='headerbuttons'>
       <input type='button' id='headerbutton' onclick=\"location.href='".$host_var."account.php?id=" . $_SESSION["confirmation"]."';\" value='" . $_SESSION["confirmation"]. "'/>
      <input type='button' id='headerbutton' onclick=\"location.href='".$host_var."profile.php?id=logout';\" value='Log out'/>
      </div>
      </header>";

$not_logged_in = "<header id='header'>
       <h2 id='name'><a id='namelink' href='".$host_var."index.php'>$websitename</a></h2>
       <div id='headerbuttons'>
       <input type='button' id='headerbutton' onclick=\"location.href='".$host_var."accounts.php?id=login';\" value='Login'/>
       <input type='button' id='headerbutton' onclick=\"location.href='".$host_var."accounts.php?id=register';\" value='Register'/> </div>
      </header>";

if (isset($_SESSION["confirmation"])) {
   $page_header = $logged_in;
}

else {
   $page_header = $not_logged_in;
}


$index_page = "<div id=pastediv>
    <p>Title:</p>
    <input type='text' name='title' required maxlenght='150' form='pasteform'/>
    <p>Text:</p> 
    <textarea form='pasteform' id='paste_text_area' rows='100' cols='100' maxlenght='3116480' required name='paste'></textarea>
    <div id='formpaste'>
    <form action='db.php' id='pasteform' enctype='multipart/form-data' name='pasteform' method='POST'>    
    <button type='submit' id='pastebutton' value='Submit paste'>Submit paste</button>
    </form> </div> </div>

";
$register_page = "<div id='login_div'>
   <form action='profile.php?id=register' id='register_form' enctype='multipart/form-data' method='POST'/>
   <p>Username: </p><input type='text' name='name'/>
   <p>Password: </p><input type='password' name='password'/>
   <p>Verify password: </p><input type='password' name='password2'/>
   </form>
   <div id='login_button'>
   <button type='submit' form='register_form' id='pastebutton' value='Register'>Register</button>
   </div>
   </div>";

$login_page = "<div id='login_div'>
   <form action='profile.php?id=login' id='login_form' enctype='multipart/form-data' method='POST'/>
   <p>Username: </p><input type='text' name='name'/>
   <p>Password: </p><input type='password' name='password'/>
   </form>
   <div id='login_button'>
   <button type='submit' form='login_form' id='pastebutton' value='Login'>Login</button>
   </div>
   </div>";
   
$wrongpass = "<p>Incorrect password<p>";

function error_message($error_reason) {
   global $html_header;
   global $page_header;
   global $html_end; 
   echo $html_header;
   echo $page_header;
   echo "<h1 id='error_message'>$error_reason</h1>";
   echo $html_end;
}
   
?>
