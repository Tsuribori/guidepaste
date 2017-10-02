<?php

if ($_GET["id"] == "register") {
   make_account();
}

function make_account() {
   global $database_name;
   $name = $_POST["name"];
   $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
   $db = new SQLite3($database_name . ".db");
   $check_name = $db->prepare("SELECT name FROM users WHERE name = ?");
   $check_name->bindValue(1, $name);
   if ($name_in_use = $check_name->execute()) {
      die("Username already taken");
   }
   else { 
      $register_statement = $db->prepare("INSERT INTO users (name, password) VALUES (?,?)");
      $register_statement->bindValue(1, $name);
      $register_statement->bindValue(2, $password);
      if ($registered = $register_statement->execute()) {
         global $header_var;
         $name = $name;
         $password = $password;
         setcookie("Login", $name, time() + 1600);
         header($header_var . "account.php?id=" . $name);
         exit;
      }

function log_in () {
   global $database_name;
   $name = $_POST["name"];
   $password = $_POST["password"];
   $db = new SQLite3($database_name . ".db")
   $get_password = $db->prepare("SELECT password FROM users WHERE name = ?");
   $get_password->bindValue(1, $name);
   if ($database_pass = $get_password->execute()) {
      

      
   
