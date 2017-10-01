<?php

require "config.php";

echo $html_header;
echo "<h3>Hello world!</h3>";
echo "<textarea required form=\"pasteform\" rows=\"$rows\" cols=\"$columns\" name=\"paste\"> 
   </textarea>
   <form action=\"db.php\" id=\"pasteform\" method=\"POST\">
      <input type=\"submit\">
";
echo $html_end;
?>
