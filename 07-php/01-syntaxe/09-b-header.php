<?php 
/* 
    "refresh:" allows the page to refresh
    after a few seconds.
    If we add "url=" separated by a ";"
    it becomes a redirection after a few seconds.
*/
header("refresh:5; url=09-a-header.php");
/* The second parameter can be a boolean,
default is true, which indicates whether the header 
should replace the previous one or just be added to it.

The third parameter allows you to set a status code 
for the page. However, this third parameter is only 
used if the first one is not empty. */
$title = " header page 2";
require("../ressources/template/_header.php");
?>
<h1>Welcome to page 2... temporarily.</h1>
<?php
require("../ressources/template/_footer.php");
?>
