<?php
session_start();
$websitename = "Guidepaste";
$database_name = "../pastedatabase";  #Name of the database, best to leave this alone

error_reporting(-1); #Report errors
$max_chars = 20000; #Define character limit for pastes
$max_title_chars = 500; #Define character limit for titles
$html_header = 
"<!DOCTYPE html>
<html>
<head>
<meta charset='utf-8'>
<meta name='viewport' content='width=device-width, initial-scale=1.0, shrink-to-fit=no'>
<meta http-equiv='Content-Security-Policy' content=\"default-src 'self'\">
<meta name='robots' content='index, follow'>
<meta name='googlebot' content='index, follow'>
<meta name='rating' content='General'>
<meta name='description' content='Post guides or other snippets of text to share easily to others!'>
<meta name='subject' content='Share text!'>
<title>$websitename - Share text!</title>
<link rel='stylesheet' type='text/css' href='stylesheet.css'>
<link rel='shortcut icon' href='icon.ico'>
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
       <div id='newpaste_button_div'>
       <a id='newpaste_button' href='".$host_var."index.php'>New paste</a> 
       </div>
       <div id='headerbuttons'>
       <a id='headerbutton' href='".$host_var."account.php'>Profile</a>
       <a id='headerbutton' href='".$host_var."profile.php?id=logout'>Log out</a>
       </div>
       </header>";

$not_logged_in = "<header id='header'>
       <h2 id='name'><a id='namelink' href='".$host_var."index.php'>$websitename</a></h2>
       <div id='newpaste_button_div'>
       <a id='newpaste_button' href='".$host_var."index.php'>New paste</a>
       </div>
       <div id='headerbuttons'>
       <a id='headerbutton' href='".$host_var."accounts.php?id=login'>Login</a>
       <a id='headerbutton' href='".$host_var."accounts.php?id=register'>Register</a>
       </div>
       </header>";

if (isset($_SESSION["confirmation"])) {
   $page_header = $logged_in;
}

else {
   $page_header = $not_logged_in;
   $_SESSION["confirmation"] = NULL;
}

$page_footer= "<footer id='footer'>
    <a href='https://github.com/Tsuribori/guidepaste'>Github</a>
    </footer>";

$index_page = "<div id=pastediv>
    <p>Title:</p>
    <input type='text' name='title' required size='30' maxlenght='150' form='pasteform'/>
    <p>Text:</p>
    <input type='checkbox' id='code' name='iscode' value='iscode' form='pasteform'/> <p id='code'>Code</p>
    <textarea form='pasteform' id='paste_text_area' rows='25' maxlenght='3116480' required name='paste'></textarea>
    <div id='formpaste'>
    <form action='db.php' id='pasteform' enctype='multipart/form-data' name='pasteform' method='POST'>    
    <button type='submit' id='pastebutton' value='Submit paste'>Submit paste</button>
    </form> 
    </div> 
    </div>

";
$register_page = "<div id='login_notice'>
   <h4>Why register?</h4>
   <ul>
   <li>Keep track of your pastes.</li>
   <li>Delete pastes.</li>
   </ul>
   </div>
   <div id='login_div'>
   <form action='profile.php?id=register' id='register_form' enctype='multipart/form-data' method='POST'/>
   <p>Username: </p><input type='text' required name='name'/>
   <p>Password: </p><input type='password' required name='password'/>
   <p>Verify password: </p><input type='password' required name='password2'/>
   </form>
   <div id='login_button'>
   <button type='submit' form='register_form' id='pastebutton' value='Register'>Register</button>
   </div>
   </div>";

$login_page = "<div id='login_div'>
   <form action='profile.php?id=login' id='login_form' enctype='multipart/form-data' method='POST'/>
   <p>Username: </p><input type='text' required name='name'/>
   <p>Password: </p><input type='password' required name='password'/>
   </form>
   <div id='login_button'>
   <button type='submit' form='login_form' id='pastebutton' value='Login'>Login</button>
   </div>
   </div>";
   
if (!function_exists('error_message')) {
    function error_message($error_reason) {
       global $html_header;
       global $page_header;
       global $page_footer;
       global $html_end; 
       echo $html_header;
       echo $page_header;
       echo "<h2 id='error_message'>$error_reason</h2>";
       echo $page_footer;
       echo $html_end;
   }
}

if (!function_exists('display_user_pastes')) {

    function display_user_pastes($result) {
        global $host_var; 
        echo "<div id='user_pastes'>
             <h3>".$result["title"]."</h3>         
             <p id='user_page_date'>".$result["date"]."</p>
         
             <div id='user_page_links0'>
             <a id='user_page_links' href='$host_var" . "paste.php?id=" . $result["id"] . "'>View</a>    " .  
         "   <a id='user_page_links' onclick=\"return confirm('Are you sure?');\" href='$host_var" . "delete.php?id=" . $result["id"] . "'>Delete</a> </div></div>";  
    }
}
   
?>
