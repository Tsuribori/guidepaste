<?php
require_once "config.php";
error_reporting(E_ALL);
ini_set("display_errors", 1);

global $database_name;
global $html_header;
global $html_end;
if ($id = $_GET["id"]) {
   $db = new SQLite3($database_name . ".db");
   $statement3 = $db->prepare("SELECT paste FROM text WHERE id = ?");
   $statement3->bindValue(1, $id, PDO::PARAM_INT);
   if ($content = $statement3->execute()) {
       $content = $content->fetchArray();
       $paste_content = $content["paste"];
       echo $html_header;
       echo $paste_content;
       echo $html_end;
       
   }
}
?>

