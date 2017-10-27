<?php
require "config.php";
require "account_management.php";

session_start();
#Create database if it doesn't exist
function create_database() {
    global $database_name;
    $db = "";
    if ($db  = new SQLite3($database_name . ".db")) {
        $db->exec('CREATE TABLE users (name TEXT PRIMARY KEY, password TEXT NOT NULL)');
        $db->exec('CREATE TABLE text (id INTEGER PRIMARY KEY, paste TEXT NOT NULL, title TEXT NOT NULL, name TEXT NOT NULL, code INTEGER NOT NULL)'); #Create table and columns
	echo "success";
        $create_values = $db->prepare("INSERT INTO users (name, password) VALUES ('FIRSTUSER', 'umadelicia')");
        $create_values->execute();
        $create_values2 = $db->prepare("INSERT INTO text (id, paste, title, name, code) VALUES (1, 'FIRST', 'FIRST', 'FIRST', 0)"); #Create the first row so that insert_paste() works
        $create_values2->execute();
        
    }
   else {
        die("Unable to create database!");
    }
}
$database_name = $database_name . ".db";
$db = new SQLite3($database_name);
#Insert the paste
function insert_paste() {
   global $database_name;
   global $db;
   if (!file_exists($database_name . ".db")) {   #Create table if it doesn't exist
   create_database();
   }
   $statement = $db->prepare("SELECT id FROM text WHERE id = (SELECT MAX(ID) FROM text)"); #Get the last id number
   if ($last_id = $statement->execute()) {
   }
   else {
      error_message("Could not get paste id!");
   }
   $desired_id = $last_id->fetchArray();
   $id = intval($desired_id["id"]) + 1; #Get the new id
   $paste = htmlspecialchars($_POST["paste"]);
   $title = htmlspecialchars($_POST["title"]);
   if ($_POST["iscode"] == "iscode") {
       $code = 1;
   }
   
   else {
       $code = 0;
   }
   $statement2 = $db->prepare("INSERT INTO text (id, paste, title, name, code) VALUES (?, ?, ?, ?, ?)"); #Prepare insert statement
   if ($_SESSION["confirmation"]) {
      $name = $_SESSION["confirmation"];
   }
   else {
      $name = "Anonymous";
   }
   $statement2->bindValue(1, $id, PDO::PARAM_INT);  #Bind parameters to statement
   $statement2->bindValue(2, $paste);
   $statement2->bindValue(3, $title);
   $statement2->bindValue(4, $name);
   $statement2->bindValue(5, $code); 
   if ($result = $statement2->execute()) {    #Execute the statement
      $id = $id;
      $db->close();
      unset($db);
      global $header_var;
      header($header_var . "paste.php?id=" . $id); #Redirect to paste page
      exit(); 
   }
   else {
      error_message("Could not insert paste into database!");
   }
}



if ($_SERVER["REQUEST_METHOD"] == "POST") {
   insert_paste();
   
}
?> 
