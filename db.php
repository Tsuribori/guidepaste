<?php

require "config.php";
require_once "paste.php";
#require "index.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);
#Create database if it doesn't exist
function create_database() {
    global $database_name;
    $db = "";

    if ($db  = new SQLite3($database_name . ".db")){
        $db->exec("CREATE TABLE text (id INTEGER PRIMARY KEY, paste TEXT, )"); #Create table and columns
	echo "success";
        $create_values = $db->prepare("INSERT INTO text (id, paste) VALUES (1, 'FIRST')"); #Create the first row so that insert_paste() works
        $create_values->execute();
        
    }
   else {
        die("Unable to create database!");
    }
}

if (!file_exists($database_name . ".db")) {   #Create table if it doesn't exist
   create_database();
}
$database_name = $database_name . ".db";
$db = new SQLite3($database_name);

#Insert the paste
function insert_paste() {
   global $database_name;
   global $db;
   $statement = $db->prepare("SELECT id FROM text WHERE id = (SELECT MAX(ID) FROM text)"); #Get the last id number
   if ($last_id = $statement->execute()) {
   }
   else {
      echo "Could not get paste id!";
   }
   $desired_id = $last_id->fetchArray();
   $id = intval($desired_id["id"]) + 1; #Get the new id
   $paste = $_POST["paste"];
   $statement2 = $db->prepare("INSERT INTO text (id, paste) VALUES (?, ?)"); #Prepare insert statement
   $statement2->bindValue(1, $id, PDO::PARAM_INT);  #Bind parameters to statement
   $statement2->bindValue(2, $paste);  
   if ($result = $statement2->execute()) {    #Execute the statement
      $id = $id;
      $host  = $_SERVER['HTTP_HOST'];
      $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
      $extra = 'paste.php';
      header("Location: http://$host$uri/$extra?id=$id");    #Redirect to created paste
      
   }
   else {
      echo "Could not insert paste into database!";
   }
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
   insert_paste();
   
}
?>
