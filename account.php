<?php
require "config.php";
require "account_management.php";

if (verify_user($_COOKIE["Login"], $_COOKIE["Password"])) {
   $account = $_GET["id"];
   get_user_pastes($account);

   echo $html_header;
   echo $html_end;
}

else {
   header($header_var . "index.php");
}


function get_user_pastes() {
   global $database_name;
   global $account;
   $db = new SQLite3($database_name . ".db");
   $paste_statement = $db->prepare("SELECT paste FROM text WHERE name = ?");
   $paste_statement->bindValue(1, $account);
   if ($pastes = $paste_statement->execute()) {
      $paste_fetch = $pastes->fetchArray();
      var_export($paste_fetch);
      get_values($paste_fetch);
      echo "works"; 
         
         
      }
    
   
   else {
      echo "not working";
   }
}

function get_values($array){
    foreach($array as $key => $value){
        if(is_array($array[$key])){
            print_r (array_values($array[$key]));
        }
    }
}


