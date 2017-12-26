<?php
require_once "config.php";

global $database_name;
global $html_header;
global $html_end;
if (($id = $_GET["id"]) !== NULL) { #Get paste that matches page url
   $db = new SQLite3($database_name . ".db");
   $statement3 = $db->prepare("SELECT paste, title, code, date FROM text WHERE id = ?");
   $statement3->bindValue(1, $id, PDO::PARAM_INT);
   if (($content = $statement3->execute()) && ($content = $content->fetchArray())) { #Execute statement and check if it's not false
       $paste_title = $content["title"];
       $paste_content0 = $content["paste"];
       $paste_date = $content["date"];
       $paste_content = str_replace("\n", "<br>", $paste_content0); #Replace newline with html newline break
       
       echo $html_header;
       echo $page_header;
       echo "<div id='pastepage_title'><h2>".$paste_title."</h2></div><div id='pastepage_date'><p>Created ".$paste_date."</p></div><div id='pastepage_paste'>";      
       if ($content["code"] === 0) {
       echo "<p>".$paste_content."</p></div>";
       }
       elseif ($content["code"] === 1) {
       echo "<code id='white_space_code'>".$paste_content."</code></div>";
       }
       echo $page_footer;
       echo $html_end;
       exit();
    }
 
   else {
       error_message("Paste doesn't exist!"); #Let the visitor know if no paste matches the provided id
       exit();
  }

}


else {
    header($header_var."index.php"); #If no id, redirect to main page
}
?>

