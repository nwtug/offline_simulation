<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>jQuery.getJSON demo</title>
  <style>
  img {
    height: 100px;
    float: left;
  }
  .red{
   
    padding: 2px;
    color:#000; border: 1px  red solid;
  }

    .green{
   
      padding: 2px;
      color:#000;
      cursor: pointer; border: 1px green solid ;
  }
  </style>
  <script src="./jquery-1.10.2.js"></script>
 

</head>
<body>
 

 <style type="text/css">
 ul { clear: both;  }
ul li { float: left;  list-style:  none;  background: #eee; padding:15px; margin-left: 5px;  }
ul li  a { text-decoration: none; padding: 5px; color:#000;  }
 </style>

<hr/>
 <h1>TODO APP </h1>
 <ul class="nav">
 <li><a href="?level=add">New Todo </a> </li>
 <li> <a href="?level=view">View Todo List </a> </li>
 <li>  <a href="?level=log">View Log Status  </a> </li> <li  > 
<button  id="sync_online" disabled="disabled">  SYNC  </button> </li>
 </ul>
<br/>
<br/>

<div class="container" style="clear:both;   margin-top: 60px; display: block;  position: relative; ">

<?php
 
// ini_set('error_reporting', E_ALL);
// ini_set('display_errors', 1); 
include("con.php");

 



if(!empty($_GET['level']) && ( $_GET['level']  == 'log') )
{
  
  $sql = "SELECT * FROM events_log    ORDER BY dateadded DESC ";

  $query_string = mysql_query($sql) OR DIE("".mysql_error());

   $count = 0;
  ?>

<table>

    <tr>
    <td></td>
    <th>ACTION</th>
    <th>QUERY</th>
    <th>DATA ID </th>
    <th> STATUS  </th>
    <th> TABLE  </th>
    <th> DATEADDED  </th>
    </tr>
          <?php
          while($row = mysql_fetch_array($query_string))
          {
            $count ++;
            ?>
            <tr>
            <td> </td>
            <td><?=$row['action'];?></td>
            <td><?=$row['query_string'];?></td>
            <td><?=$row['row_id'];?></td>
             <td><?=$row['status'];?></td>
              <td><?=$row['tablename'];?></td>
              <td><?=$row['dateadded'];?></td>
            </tr>
            <?php
          }
          ?>
</table>
  <?php
  }


if(!empty($_GET['level']) && ( $_GET['level']  == 'view') )
{
  
 $sql = "SELECT * FROM todolist";

  $query_string = mysql_query($sql) OR DIE("".mysql_error());

   $count = 0;
  ?>

<table>
      <tr>
      <td></td>
      <th>Title</th>
      <th>Details</th>
      <th>Date Added </th>
      <th> Date Updated </th>
      </tr>
      <?php
      while($row = mysql_fetch_array($query_string))
      {
        $count ++;
        ?>
                  <tr>
                  <td><?='<a href="?level=add&id='.$row['id'].'">Edit</a>'; ?></td>
                  <td><?=$row['title'];?></td>
                  <td><?=$row['details'];?></td>
                  <td><?=$row['dateadded'];?></td>
                   <td><?=$row['dateupddated'];?></td>
                  </tr>
        <?php
      }
      ?>
</table>
  <?php
 
  }
if(!empty($_GET['level']) && ( $_GET['level']  == 'add') )
{

        if(!empty($_GET['id']))
        {
            $id = $_GET['id'];
            $sql = "SELECT * FROM todolist WHERE id = '".$id."' ";            
            $query_string = mysql_query($sql) OR DIE("".mysql_error());
            $records = mysql_fetch_array($query_string);
           # print_r($records);

         }


  ?>

<table>

<tr>
      <th colspan="2"> NEW TODO </th>
      </tr>
      <tr>
      <td>Title </td>
      <td> 
      <input type="text"   name="title" id="title" 
      value="<?=!empty($records['title'])  ? $records['title'] :''; ?>"  class="title" />
      </td>
      </tr>

      <tr>
      <td style="vertical-align: top;" >Details  </td>
      <td> 
      <textarea cols="50" rows="5"  class="details" id="details"> 
        <?=!empty($records['details'])  ?$records['details'] :''; ?>
      </textarea>
      <br/>
      <input type="hidden"   name="todoid" id="todoid" 
      value="<?=!empty($records['id'])  ? $records['id'] :''; ?>"  class="todoid" />
      </td>
      </tr>

      <tr>
      <td></td>
      <td><button name="Save" id="save" class="save">Save </button>
      <button type="reset"  class="save">Clear </button>
      </td>
      </tr>

</table>

<?php
}
?>

</div>


<br/>
 

 

 <script type="text/javascript">
   
   $(function(){



$("#sync_online").click(function(){

    //network status 
    if( network_status == 0){
      alert("You are currently Offline");
      return false;
    }
   
   

      url = "proccess.php";
      formdata = {};
      formdata['get_log'] = 'get_log';


      $.ajax({
                              type: "POST",
                              url:  url,
                              data: formdata,       
                              success: function(data, textStatus, jqXHR)
                              {
                                  console.log(data);

                                  var parsed = JSON.parse(data);
                                  var arr = [];
                                 for(var x in parsed){
                                     arr.push(parsed[x]);
                                  }

                                  // Send Data to Server 
                                  send_data_to_server(arr);

                              },
                              error:function(data , textStatus, jqXHR)
                              {
                                  console.log('Data Error'+data+textStatus+jqXHR);
                              }

           });


});



// Send to the server 
function send_data_to_server(data)
{

 



        //submit to the server
        urld ="http://tenderportal.ppda.go.ug/sandbox/server_test/save_offline_log/";
        console.log(urld);

         $.ajax({

                              type: "GET",
                              url:  urld,
                              data: {myData:data},
                              dataType: 'jsonp',                             
                              timeout: 5000,                              
                              success: function(data, textStatus, jqXHR){                           
                               
                              network_status = 1;
                              console.log(data);                              

                              var formdata = data;

                                 //Update Loclhost Log
                                 update_log(formdata);
                                 

 

                                
                              },
               error: function(xhr, textStatus, errorThrown){
               console.log('request failed');
               network_status = 0;
               }

           });



}

function update_log(data)
{
  console.log("MOVERS");

 
 console.log(data.length);


 var formdatax = {};


 for(var x = 0; x < data.length; x ++)
 {
     var data_records = Array(data[x]['id'],data[x]['status']);
    formdatax[x] =  data_records;
 }

  console.log(formdatax);


         urld = "update_log.php";         

         $.ajax({

                              type: "POST",
                              url:  urld,
                              data: formdatax,       
                              success: function(data, textStatus, jqXHR){
                                console.log(data);
                              
                                
                                  
                                    alert("syncing Succeful");
                                    location.reload(0);
                                                                      

                              },
                              error:function(data , textStatus, jqXHR)
                              {
                                  console.log('Data Error'+data+textStatus+jqXHR);
                              }

           });


}



  $("#save").click(function(){
        //get the title  and the  details 
        var title = $("#title").val();
        var details = $("#details").val();
        var todoid = $("#todoid").val();

        details = details.trim();

        if(title.length <= 0 &&  ( details.trim().length <= 5 || details == ' ' ) ) 
        {
          alert("Fill Blanks");
          return;
        }


        formdata = {};
        formdata['title'] = title;
        formdata['details'] = details.trim();
        formdata['todoid'] = todoid;



 
           urld = "proccess.php";

         $.ajax({

                              type: "POST",
                              url:  urld,
                              data: formdata,       
                              success: function(data, textStatus, jqXHR){
                                if(data == 1)
                                {
                                  alert("record Saved Succesfully ");
                                      $("#title").val('');
                                     $("#details").val('');

                                }
                                else
                                {
                                  console.log(data);

                                }
                                // console.log(data);
                              },
                              error:function(data , textStatus, jqXHR)
                              {
                                  console.log('Data Error'+data+textStatus+jqXHR);
                              }

           });



        console.log(formdata);   

 
    });

         network_status = 0;

    // Test Network 
function test_network(){



       var formdata = {};
   

   /*


                              type: "GET",
                              url:  urld,
                              data: formdata,
                              dataType: 'jsonp',
                              async: false,
                              contentType: "application/json",

                              */

        //submit to the server
        urld ="http://tenderportal.ppda.go.ug/sandbox/server_test/test_network_online/";
        console.log(urld);

         $.ajax({

                              type: "GET",
                              url:  urld,
                              data: formdata,
                              dataType: 'jsonp',                             
                               timeout: 5000,
                              
                              success: function(data, textStatus, jqXHR){
                              console.log(data);

                              /*
                                    this means I am calling the server and so I can make the sync button on : 
                              */
                              $("#sync_online").removeAttr('disabled');
                                $("#sync_online").addClass('green');
                                $("#sync_online").removeClass('red');

network_status = 1;


                                setTimeout(function(){ 
                                test_network('');}, 2000);


                              },
               error: function(xhr, textStatus, errorThrown){
               console.log('request failed');
               network_status = 0;

                 $("#sync_online").attr('disabled','disabled');
                  $("#sync_online").addClass('red');
                  $("#sync_online").removeClass('green');


                if (xhr.readyState == 4) {
            // HTTP error (can be checked by XMLHttpRequest.status and XMLHttpRequest.statusText)
            console.log("Sever Did not Respond in Time ");

            
                }
                else if (xhr.readyState == 0) {
                   
                         console.log(" Network Error ");


 
                }
                else {
                    
                     console.log(" Something Went Wrong  ");

                }

               setTimeout(function(){ 
                test_network('');}, 10000); 
            }

           });



      


}
   setTimeout(function(){ 
                test_network('');}, 10000); 




   })
 </script>
</body>
</html>