<?php
require "config.php";
require "create_database.php";
session_start();

#Insert the paste
function insert_paste() {
   global $database_name;
   global $max_chars;
   global $max_title_chars;
   $db = $database_name . ".db";
   if (!file_exists($db)) {   #Create table if it doesn't exist
       create_database();
   }
   $db = new SQLite3($database_name.".db");
   $statement = $db->prepare("SELECT id FROM text WHERE id = (SELECT MAX(ID) FROM text)"); #Get the last id number
   if ($last_id = $statement->execute()) {
   }
   else {
      error_message("Could not get paste id!");
      exit();
   }
   $desired_id = $last_id->fetchArray();
   $id = intval($desired_id["id"]) + 1; #Get the new id
   $paste = htmlspecialchars($_POST["paste"]);
   $title = htmlspecialchars($_POST["title"]);

   if (strlen($paste) > $max_chars) {  #Disallow pastes over character limit
       error_message("Paste is too long. Maximum characters allowed is $max_chars");
       exit();
   }

   else if (strlen($title) > $max_title_chars) {  #Disallow titles over charcter limit
       error_message("Title too long. Maximum characters allowed is $max_title_chars");
       exit();
   }
   
   if ($_POST["iscode"] == "iscode") {
       $code = 1;
   }
   
   else {
       $code = 0;
   }
   $statement2 = $db->prepare("INSERT INTO text (id, paste, title, name, code, date) VALUES (?, ?, ?, ?, ?, ?)"); #Prepare insert statement
   if ($_SESSION["confirmation"]) {
      $name = $_SESSION["confirmation"];
   }
   else {
      $name = "Anonymous";
   }
 
   $date = date("d.m.Y, g:i a"); 
   $statement2->bindValue(1, $id, PDO::PARAM_INT);  #Bind parameters to statement
   $statement2->bindValue(2, $paste);
   $statement2->bindValue(3, $title);
   $statement2->bindValue(4, $name);
   $statement2->bindValue(5, $code); 
   $statement2->bindValue(6, $date);
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
      exit();
   }
}



if ($_SERVER["REQUEST_METHOD"] == "POST") {
   insert_paste();
   
}
?> 
