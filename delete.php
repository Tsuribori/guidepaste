<?php

require "config.php";
require "account_management.php";
session_start();

if ($_GET["id"] && $_SESSION["confirmation"]) {
    $db = new SQLite3($database_name . ".db");
    $search_paste_owner = $db->prepare("SELECT name FROM text WHERE id = ?");
    $search_paste_owner->bindValue(1, $_GET["id"]);
    if ($search_result = $search_paste_owner->execute()) {
        $owner = $search_result->fetchArray();
        if ($owner["name"] == $_SESSION["confirmation"]) {
            $db->close();
            unset($db);
            delete_paste($_GET["id"], $owner["name"]);
            exit();
        }
        else {
            error_message("You're not the owner!");
            exit();
        }
        
    }
    
}

else {
   header($header_var . "accounts.php?id=login");
   exit();
}
    

function delete_paste($id, $account_name) {
    global $database_name;
    global $header_var;
    $db = new SQLite3($database_name . ".db");
    $delete_statement = $db->prepare("DELETE FROM text WHERE id = ?");
    $delete_statement->bindValue(1, $id);
    if ($delete = $delete_statement->execute()) {
        $db->close();
        unset($db);
        header($header_var . "account.php?id=" . $account_name);
        exit();
    }
   
    else {
        error_message("Couldn't delete paste");
       
    }
}

