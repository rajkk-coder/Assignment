<?php

$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];
$protocol = $_SERVER['SERVER_PROTOCOL'];
$headers = getallheaders();
?>  
<!-- // echo "$method $uri $protocol <br/>";
// foreach ($headers as $key => $header) {
//     echo "$key: $header <br/>";
// } -->

<!DOCTYPE html>
<html>
 <head>
  <title>Home Page</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js">
  </script>
 </head>
 <body>
   <p>
    <div class="container">
    <!-- <span class="align-middle">middle</span> -->
        <h1 align="center">
            Click Below
        </h1>
        <span>
        <button class="align-middle" onclick="window.open('./B190528CS_1.php','_self')">click me</button>
</span>
    </div>
   </p>
 </body>
</html>
