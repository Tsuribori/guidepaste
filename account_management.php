<?php
function verify_user($name, $password) {    #Verify the user by comparing the password in the "password" cookie to the one in database
   global $database_name;
   global $db;
   if ($db == NULL) {
      $db = new SQLite3($database_name . ".db");
   }
   $verify_statement = $db->prepare("SELECT password FROM users WHERE name = ?");  #Get the password which matches the name in the "name" cookie
   $verify_statement->bindValue(1, $name);
   if ($pass_array = $verify_statement->execute()) {
      $pass = $pass_array->fetchArray();
      $db_pass = $pass["password"];
      if (password_verify($password, $db_pass)) {
          return True;  #Return True if they match
      }
      else {
         return False;
      }
    }
   else {
      return False;   #Else return False
    }
}
?>
