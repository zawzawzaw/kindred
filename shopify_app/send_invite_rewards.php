<?php
$inputs = file_get_contents('php://input');

$myfile = fopen("newfile.txt", "w") or die("Unable to open file!");
fwrite($myfile, $inputs);
fclose($myfile);

header("HTTP/1.1 200 OK");
?>