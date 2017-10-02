<?php
require "config.php";
if ($_GET["id"] == "register") {    #Display registering page if requested
  echo $html_header;
  echo $register_page;
  echo $html_end;
}

else if ($_GET["id"] == "login") {   #Display login page if requested
  echo $html_header;
  echo $login_page;
  echo $html_end;
}

?>
