<?php
require "config.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_GET["id"] == "register") {   #Call register function if requested by accounts.php
   make_account();
}

else if ($_GET["id"] == "login") {  #Else if call login function if requested by accounts.php
   log_in();
}

function make_account() {   #Create new account
   global $database_name;
   $name = $_POST["name"];
   $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
   $db = new SQLite3($database_name . ".db");
   $check_name = $db->prepare("SELECT name FROM users WHERE name = ?"); #Check if name already in use
   $check_name->bindValue(1, $name);
   $name_in_use = $check_name->execute();
   $name_check = $name_in_use->fetchArray();
   $name_in_use2 = $name_check["name"];
   if (strcmp($name, $name_in_use2) == 0) {
      die("Username already taken");
   }
   else {            #Else create the new account
      $register_statement = $db->prepare("INSERT INTO users (name, password) VALUES (?,?)");
      $register_statement->bindValue(1, $name);
      $register_statement->bindValue(2, $password);
      if ($registered = $register_statement->execute()) {
         global $header_var;
         $name = $name;
         $password = $password;
         setcookie("Login", $name, time() + 1600);  #Set the "logged in" cookie
         setcookie("Password", $password, time() + 1600);
         header($header_var . "account.php?id=" . $name);      #Redirect to account page
         exit;
      }
   }
}

function log_in () {     #Log the user in
   global $database_name;
   global $header_var;
   $name = $_POST["name"];
   $password = $_POST["password"];
   $db = new SQLite3($database_name . ".db");
   $get_password = $db->prepare("SELECT password FROM users WHERE name = ?");
   $get_password->bindValue(1, $name);
   if ($database_pass = $get_password->execute()) {   #Check if the password is correct
      $database_pass2 = $database_pass->fetchArray();
      $database_pass3 = $database_pass2["password"];
      if (password_verify($password, $database_pass3)) {
         setcookie("Login", $name, time() + 1600);
         setcookie("Password", $password, time() + 1600);
         header($header_var . "account.php?id=" . $name);
         exit;
      }
      
      else {
         echo $wrongpass;
         exit();
      }
  }   
  else {
      exit();
  }   
}


function log_out () {
   
}     

?>
      
   
