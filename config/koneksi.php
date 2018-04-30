<?php
//config database
$DBuser = "your username";
$DBpass = "your password";
$DBhost = "your host or localhost";
$DBname = "your name of database";


  $DBcon = new MySQLi($DBhost,$DBuser,$DBpass,$DBname);
    
     if ($DBcon->connect_errno) {
         die("ERROR : -> ".$DBcon->connect_error);
     }
  

?>
