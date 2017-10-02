<?php
require_once "config.php";
global $database_name;
$db = new SQLite3($database_name . ".db");
global $html_header;
global $html_end;
   $id = $_GET["id"];
   $statement3 = $db->prepare("SELECT paste FROM text WHERE id = ?");
   $statement3->bindValue(1, $id, PDO::PARAM_INT);
   if ($content = $statement3->execute()) {
       $content = $content->fetchArray();
       $paste_content = $content["paste"];
       echo $html_header;
       echo $paste_content;
       echo $html_end;
       
   }

?>

