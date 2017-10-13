<?php
require "config.php";
require "account_management.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

if ($_GET["id"] == "register") {   #Call register function if requested by accounts.php
   if ($_POST["password"] === $_POST["password2"]) {
       make_account();
   }
   
   else {
       error_message("Passwords do not match!");
       exit();
   }
       
}

else if ($_GET["id"] == "login") {  #Else if call login function if requested by accounts.php
   log_in();
}

else if ($_GET["id"] == "logout") { #Destroy login session if requested
   log_out();
}

function make_account() {   #Create new account
   global $database_name;
   $name = $_POST["name"];
   $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
   $db = new SQLite3($database_name.".db");
   $check_name = $db->prepare("SELECT name FROM users WHERE name = ?"); #Check if name already in use
   $check_name->bindValue(1, $name);
   $name_in_use = $check_name->execute();
   $name_check = $name_in_use->fetchArray();
   $name_in_use2 = $name_check["name"];
   if (strcmp($name, $name_in_use2) == 0) {
      error_message("Username already taken");
      exit();
   }
   else {            #Else create the new account
      $register_statement = $db->prepare("INSERT INTO users (name, password) VALUES (?,?)");
      $register_statement->bindValue(1, $name);
      $register_statement->bindValue(2, $password);
      if ($registered = $register_statement->execute()) {
         global $header_var;
         $name = $name;
         session_start();
         $_SESSION["confirmation"] = $name;
         header($header_var . "account.php?id=" . $name);      #Redirect to account page
         exit();
      }
   }
}

function log_in () {     #Log the user in
   global $database_name;
   global $header_var;
   $name = $_POST["name"];
   $password = $_POST["password"];
   if (verify_user($name, $password)) {
         session_start();
         $_SESSION["confirmation"] = $name;
         header($header_var . "account.php?id=" . $name);
         exit();
      }
      
   else {
         error_message("Incorrect password.");
         exit();
      }
}  
function log_out () {
   if (isset($_SESSION["confirmation"])) {   #Destroy session variables and redirect to main page
      global $header_var;
      session_destroy();
      header($header_var . "index.php");
      exit();
   }
  
  else {
      error_message("Could not logout");
   
  }     
}

?>
      
   
