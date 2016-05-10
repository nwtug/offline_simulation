<?php

/* 
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);  */

include("con.php");

 
$db_selected = mysql_select_db('todoapp');

if(!empty($_POST['get_log']))
{
  $sql = "SELECT * FROM events_log WHERE status ='pending'   ORDER BY dateadded ASC  LIMIT 20  ";

  $query_string = mysql_query($sql) OR DIE("".mysql_error());

    $record  = array();
    while($row = mysql_fetch_array($query_string))
    {
      $record[] = $row;
    }

  echo json_encode($record);



}
 

elseif(!empty($_POST['title']))
{
             #print_r($_POST);
             #INSERT 
            if(!empty($_POST['todoid']))
            {
                 $sql = " UPDATE  todolist  SET title='".$_POST['title']."',details='".$_POST['details']."',dateadded =  NOW()
                 WHERE  todolist.id = '".$_POST['todoid']."' ";
                 $action = 'update';
                 $table =  "todolist";
                 $row_id = $_POST['todoid'];
            }
            else
            {
               $sql = "INSERT INTO  todolist (title,details,dateadded)
              VALUES ( '".$_POST['title']."', '".$_POST['details']."', NOW())";  
              $action = 'insert';
              $table =  "todolist";
              $row_id  = "";
            }


              $saved_q = mysql_query($sql) OR DIE("".mysql_error());

              if($saved_q){
             

            $query_string =  mysql_real_escape_string($sql);
            $status = 'pending';
             
            $isactive = 'Y';   
             
                $query  = "INSERT INTO  events_log (action, query_string,row_id,status,dateadded,isactive,tablename) VALUES ('".$action."','".$query_string."','".$row_id."','".$status."',NOW(),'".$isactive."','".$table."');";  

                 $saved_q = mysql_query($query) OR DIE("".mysql_error());  


                echo "1";    
              }

}
else
{}

  mysql_close($link);
?>