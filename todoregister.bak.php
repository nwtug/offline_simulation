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
  </style>
  <script src="./jquery-1.10.2.js"></script>
  <script>
$(function(){

  
 function test_network_connection(url)
 {
        var flickerAPI = "http://api.flickr.com/services/feeds/photos_public.gne?jsoncallback=?";
        formdata = {};
        formdata['tags'] = 'yoweri museveni';
        formdata['tagmode'] = 'any';
        formdata['format'] = 'json';

//$("#images").html("<h1>Proccessing...</h1>");

console.log('Proccessing...');

         

        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: flickerAPI,
            timeout: 5000,
            data:formdata,
            success: function(data, textStatus ){
               console.log('request successful');
               $("#images").html("");

                $.each( data.items, function( i, item ) {
                $( "<img>" ).attr( "src", item.media.m ).appendTo( "#images" );

              });


                setTimeout(function(){ 
                test_network_connection('');}, 10000); 


            },
            error: function(xhr, textStatus, errorThrown){
               console.log('request failed');

                if (xhr.readyState == 4) {
            // HTTP error (can be checked by XMLHttpRequest.status and XMLHttpRequest.statusText)
            $("#images").html("<h1>Sever Did not Respond in Time </h1>");

            
                }
                else if (xhr.readyState == 0) {
                    // Network error (i.e. connection refused, access denied due to CORS, etc.)
                      $("#images").html("<h1>Network Error </h1>");

 
                }
                else {
                    // something weird is happening
                     // alert("Something Went Wrong");
                           $("#images").html("<h1>Something Went Wrong</h1>");

                }

              setTimeout(function(){ 
              test_network_connection('');}, 1000);
            }
          });
 }
 
              setTimeout(function(){ 
              test_network_connection('');}, 1000);




})
 
</script>

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
 <li><a href="#">New Todo </a> </li>
 <li> <a href="#">View Todo List </a> </li>
 <li>  <a href="#">View Log Status  </a> </li>
 </ul>
<br/>
<br/>

<div class="container" style="clear:both;   margin-top: 60px; display: block;  position: relative; ">
<table>

<tr>
<th colspan="2"> NEW TODO </th>
</tr>

<tr>
<td>Title </td>
<td> 
<input type="text" value="" name="title" id="title"  class="title" />
</td>
</tr>

<tr>
<td style="vertical-align: top;" >Details  </td>
<td> 
<textarea cols="50" rows="5"  class="details" id="details"> 
  
</textarea>
</td>
</tr>

<tr>
<td></td>
<td><button name="Save" id="save" class="save">Save </button>
<button type="reset"  class="save">Clear </button>
</td>
</tr>



</table>
</div>


<br/>
<br/>

<div id="images" style="display: block;"></div>

 


 <script type="text/javascript">
   
   $(function(){
    $("#save").click(function(){
        //get the title  and the  details 
        var title = $("#title").val();
        var details = $("#details").val();

        details = details.trim();

        if(title.length <= 0 &&  ( details.trim().length <= 5 || details == ' ' ) ) 
        {
          alert("Fill Blanks");
          return;
        }


        formdata = {};
        formdata['title'] = title;
        formdata['details'] = details.trim();



        //submit to the server
  // urld ="http://tenderportal.ppda.go.ug/sandbox/server_test/";

         $.ajax({

                              type: "GET",
                              url:  urld,
                              data: formdata,
                              dataType: 'jsonp',
                              async: false,
                              contentType: "application/json",
                              success: function(data, textStatus, jqXHR){
                              console.log(data);
                              },
                              error:function(data , textStatus, jqXHR)
                              {
                                  console.log('Data Error'+data+textStatus+jqXHR);
                              }

           });



        console.log(formdata);   

 
    })
   })
 </script>
</body>
</html>