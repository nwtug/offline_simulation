<?php


$servername = "localhost";
$username = "root";
$password = "P@ssword?";

// Create connection
$link = mysql_connect($servername, $username, $password);
if (!$link) {
    die('Could not connect: ' . mysql_error());
}
//echo 'Connected successfully';
$db_selected = mysql_select_db('todoapp');




?>