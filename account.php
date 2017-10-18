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
   global $html_end;
   global $database_name;
   global $account;
   global $host_var;
   $db = new SQLite3($database_name . ".db");
   $paste_statement = $db->prepare("SELECT id, paste, title FROM text WHERE name = ?");
   $paste_statement->bindValue(1, $account);
   
   if ($pastes = $paste_statement->execute()) {
       while ($result = $pastes->fetchArray(SQLITE3_ASSOC)) {
           var_export($result);
           $pasteid = $result["id"];
           echo $html_header;
           echo $page_header;
           echo "<div id='user_pastes'>";
           echo "<h3>".$result["title"]."</h3>";
           echo "<div id='user_page_links0'><a id='user_page_links' href=$host_var" . "paste.php?id=" . $result["id"] . ">View</a>";
           echo "   ";
           echo "<a id='user_page_links' href=$host_var" . "delete.php?id=" . $result["id"] . ">Delete</a> </div></div>";           echo $html_end;
       }

       if (!($result = $pastes->fetchArray(SQLITE3_ASSOC))) {   #If user has no pastes in db, inform them (Check if db query gives a false)
           error_message("Nothing here!");
       }
       
        
   }
    
   
   else {
      error_message("Nothing here!");
   }
}

