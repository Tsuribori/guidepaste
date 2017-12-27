<?php
require_once "config.php";
require_once "account_management.php";
require_once "create_database.php";
session_start();

if (!file_exists($database_name.".db")) {
    create_database();
    make_account();
}

else if ($_GET["id"] == "register") {   #Call register function if requested by accounts.php
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
   
   elseif (strcmp($name, "Anonymous") == 0) {   #Prevent people from gaining access to the 'Anonymous' pastes
      error_message("Name not allowed!");
      exit();
   }

   elseif (strlen($name) > 50) {
      error_message("Name too long. Must be under 50 characters.");
      exit();
   }
   
   elseif (strlen($_POST["password"]) > 50) {
      error_message("Password too long! Must be under 50 characters.");
      exit();
   }

   else {            #Else create the new account
      $register_statement = $db->prepare("INSERT INTO users (name, password) VALUES (?,?)");
      $register_statement->bindValue(1, $name);
      $register_statement->bindValue(2, $password);
      if ($registered = $register_statement->execute()) {
         global $header_var;
         $name = $name;
         $_SESSION["confirmation"] = $name;
	 $_SESSION["time"] = time();
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
	 $_SESSION["time"] = time();
         header($header_var . "account.php");
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
      header($header_var . "accounts.php?id=login");
      exit();
   }
  
  else {
      error_message("Could not logout");
      exit();
  }     
}

?>
      
   
