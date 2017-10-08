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
   global $database_name;
   global $account;
   global $host_var;
   $db = new SQLite3($database_name . ".db");
   $paste_statement = $db->prepare("SELECT id, paste FROM text WHERE name = ?");
   $paste_statement->bindValue(1, $account);
   if ($pastes = $paste_statement->execute()) {
     while ($result = $pastes->fetchArray(SQLITE3_ASSOC)) {
           #var_export($result);
           echo $result["paste"];
           echo "<a href=$host_var" . "paste.php?id=" . $result["id"] . ">Paste page</a>";
           echo "<a href=$host_var" . "delete.php?id=" . $result["id"] . ">Delete</a>";
     }
      
   }
    
   
   else {
      echo "not working";
   }
}

