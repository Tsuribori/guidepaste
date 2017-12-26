<?php
require "config.php";

#Create databse if it doesn't exist
function create_database() {
    global $database_name;
    $db = "";
    if ($db  = new SQLite3($database_name . ".db")) {
        $db->exec('CREATE TABLE users (name TEXT PRIMARY KEY, password TEXT NOT NULL)');
        $db->exec('CREATE TABLE text (id INTEGER PRIMARY KEY, paste TEXT NOT NULL, title TEXT NOT NULL, name TEXT NOT NULL, code INTEGER NOT NULL, date TEXT NOT NULL)'); #Create table and columns
	$create_values = $db->prepare("INSERT INTO users (name, password) VALUES ('FIRSTUSER', 'umadelicia')");
        $create_values->execute();
        $create_values2 = $db->prepare("INSERT INTO text (id, paste, title, name, code, date) VALUES (1, 'FIRST', 'FIRST', 'FIRST', 0, 'Monday morning')"); #Create the first row so that insert_paste() works
        $create_values2->execute();
        $db->close();
       	return; 
    }
   else {
        error_message("Unable to create database!");
        exit();
    }
}

?>


