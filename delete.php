<?php

require "config.php";
require "account_management.php";

if ($_GET["id"] && $_COOKIE["Login"] && $_COOKIE["Password"]) {
    $db = new SQLite3($database_name . ".db");
    $search_paste_owner = $db->prepare("SELECT name FROM text WHERE id = ?");
    $search_paste_owner->bindValue(1, $_GET["id"]);
    if ($search_result = $search_paste_owner->execute()) {
        $owner = $search_result->fetchArray();
        if (($owner["name"] == $_COOKIE["Login"]) && (verify_user($owner["name"], $_COOKIE["Password"]))) {
            $db->close();
            unset($db);
            delete_paste($_GET["id"], $owner["name"]);
        }
    }
    
}

else {
   header($header_var . "accounts.php?id=login");
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
        echo "Couldn't delete paste";
    }
}

