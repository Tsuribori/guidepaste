<?php
require "config.php";
require "account_management.php";
session_start();

if (isset($_SESSION["confirmation"])) {
   $account = $_SESSION["confirmation"];
   echo $html_header;
   get_user_pastes($account);
   echo $html_end;
}

else {
   header($header_var . "accounts.php?id=login");
}


function get_user_pastes() {
   global $html_header;
   global $page_header;
   global $html_end;
   global $database_name;
   global $account;
   global $host_var;
   $db = new SQLite3($database_name . ".db");
   $paste_statement = $db->prepare("SELECT id, paste, title FROM text WHERE name = ?");
   $paste_statement->bindValue(1, $account);
   echo $html_header;
   echo $page_header;
   if ($pastes = $paste_statement->execute()) {
     while ($result = $pastes->fetchArray(SQLITE3_ASSOC)) {
           #var_export($result);
           $pasteid= $result["id"];
           echo "<div id='user_pastes'>";
           echo "<p>".$result["title"]."</p>";
           echo "<div id='paste_page_buttons'><a href=$host_var" . "paste.php?id=" . $result["id"] . ">View</a>";
           echo "   ";
           echo "<a href=$host_var" . "delete.php?id=" . $result["id"] . ">Delete</a> </div></div>";
     }
    echo $html_end;
   }
    
   
   else {
      error_message("Couldn't get user pastes");
   }
}

