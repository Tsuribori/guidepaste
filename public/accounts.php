<?php
require_once "config.php";

if ($_GET["id"] == "register") {    #Display registering page if requested
  echo $html_header;
  echo $page_header;
  echo $register_page;
  echo $page_footer;
  echo $html_end;
  exit();
}

else if ($_GET["id"] == "login") {   #Display login page if requested
  echo $html_header;
  echo $page_header;
  echo $login_page;
  echo $page_footer;
  echo $html_end;
  exit();
}

else {
  header($header_var . "index.php");
  exit();
}

?>
