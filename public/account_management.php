<?php
function verify_user($name, $password) {    #Verify the user by comparing the password to the on in the database 
   global $database_name;
   global $db;
   if ($db == NULL) {
      $db = new SQLite3($database_name . ".db");  #Sphagetti solution for when $db is set or not set 
   }
   $verify_statement = $db->prepare("SELECT password FROM users WHERE name = ?");  #Get the password which matches the name  
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

function overdue($time) {
    if (1800 > (time() - $time)) {  #Return True when user has been on site for more than 30 min
        return True;
    }
    else {
	return False;
    }
}
?>
