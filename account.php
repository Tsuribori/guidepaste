<?php
require "config.php";
require "account_management.php";
session_start();

if (isset($_SESSION["confirmation"])) {
   $account = $_SESSION["confirmation"];
   get_user_pastes($account);
   exit();
   
}

else {
   header($header_var . "accounts.php?id=login");
   exit();
}


function get_user_pastes() {
   global $html_header;
   global $page_header;
   global $page_footer;
   global $html_end;
   global $database_name;
   global $account;
   global $host_var;
   $db = new SQLite3($database_name . ".db");
   $paste_statement = $db->prepare("SELECT id, title, date FROM text WHERE name = ?");
   $paste_statement->bindValue(1, $account);
   
   if ($pastes = $paste_statement->execute()) { #Check if user has any pastes
       if (!($result = $pastes->fetchArray(SQLITE3_ASSOC))) {
               error_message("Nothing here!");
          }
       
       else {
           $pastes = $paste_statement->execute(); #Need to call this again or the first paste won't be shown for some reason
           echo $html_header;
           echo $page_header;
           while ($result = $pastes->fetchArray(SQLITE3_ASSOC)) {  #Loop through all the pastes
               display_user_pastes($result);
               
           } 
        
             
           echo $page_footer;
           echo $html_end;
       
        }
    }
    
   
   else {
      error_message("Nothing here!");
   }
}

