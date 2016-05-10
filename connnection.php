<?php

echo "passs";


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


 $sql = "SELECT * FROM todolist";

  $query_string = mysql_query($sql) OR DIE("".mysql_error());


  prinit_r($query_string);

?>