<?php
//index.php

$error = '';
$first_name = '';
$email = '';
$last_name = '';
$roll_number = '';

function clean_text($string)
{
 $string = trim($string);
 $string = stripslashes($string);
 $string = htmlspecialchars($string);
 return $string;
}

if(isset($_POST["submit"]))
{
 if(empty($_POST["first_name"]))
 {
  $error .= '<p><label class="text-danger">Please Enter your Name</label></p>';
 }
 else
 {
  $first_name = clean_text($_POST["first_name"]);
  if(!preg_match("/^[a-zA-Z ]*$/",$first_name))
  {
   $error .= '<p><label class="text-danger">Only letters and white space allowed</label></p>';
  }
 }
 if(empty($_POST["email"]))
 {
  $error .= '<p><label class="text-danger">Please Enter your Email</label></p>';
 }
 else
 {
  $email = clean_text($_POST["email"]);
  if(!preg_match("/@nitc.ac.in$/",$email))
  {
   $error .= '<p><label class="text-danger">Invalid email format</label></p>';
  }
 }
 if(empty($_POST["last_name"]))
 {
  $error .= '<p><label class="text-danger">Last Name is required</label></p>';
 }
 else
 {
  $last_name = clean_text($_POST["last_name"]);
 }
 if(empty($_POST["roll_number"]))
 {
  $error .= '<p><label class="text-danger">Roll Number is required</label></p>';
 }
 else
 {
  $roll_number = clean_text($_POST["roll_number"]);
 }

 if($error == '')
 {
  $file_open = fopen("student.csv", "a");
  $no_rows = count(file("student.csv"));
  
  $form_data = array(
   'first_name'  => $first_name,
   'last_name' => $last_name,
   'roll_number' => $roll_number,
   'email'  => $email
  );
  $check=1;
  $file=fopen("student.csv","r");
  while (($data = fgetcsv($file)) !== false){
     if($roll_number==$data[2]){
          $check=0;
     }
  }
  if($check){
     fputcsv($file_open, $form_data);
     $error = '<label class="text-success">Data inserted</label>';
}else{
     $error = '<label class="text-warning">Detail already Exist with given roll number !!</label>';
}
  $first_name = '';
  $last_name = '';
  $roll_number = '';
  $email = '';
 }
}

if(isset($_POST["delete"]))
{
     
     if(empty($_POST["roll_number"])){
          $error='<label class="text-warning">Roll Number is required</label>';
     }else{
          $roll_number=clean_text($_POST['roll_number']);
          $file_open = fopen("temp.csv", "a+");

          if (($handle = fopen('student.csv', "r")) !== FALSE) {
               while (($data= fgetcsv($handle)) !== FALSE) {
               if ($roll_number != $data[2] ){
                   fputcsv($file_open, $data);
               }
          }
          fclose($handle);
          fclose($file_open);
          unlink('student.csv');
          rename('temp.csv','student.csv');
          $roll_number='';
     }
     }
}
if(isset($_POST['search'])){
     if(empty($_POST["roll_number"])){
          $error='<label class="text-warning">Roll Number is required</label>';
     }else{
          $roll_number=clean_text($_POST['roll_number']);
          //$file_open = fopen("temp.csv", "a+");
          $count=0;
          if (($handle = fopen('student.csv', "r")) !== FALSE) {
               while (($data= fgetcsv($handle)) !== FALSE) {
                    if($roll_number==$data[2]){
                         $first_name=$data[0];
                         $last_name=$data[1];
                         $email=$data[3];
                         $count=1;
                    }
               }
          }
          fclose($handle);
          if($count){
               $error='<label class="text-success">Details Found!!</label>';
          }else{
               $error='<label class="text-warning">Result not found !</label>';
               $roll_number='';
          }
     }
     
}

if(isset($_POST['update'])){   
     if(!empty($_POST["first_name"]))
     {
          $first_name = clean_text($_POST["first_name"]);
          if(!preg_match("/^[a-zA-Z ]*$/",$first_name))
          {
               $error .= '<p><label class="text-danger">Only letters and white space allowed</label></p>';
          }
     }
     if(!empty($_POST["email"]))
     {
          $email = clean_text($_POST["email"]);
          if(!filter_var($email, FILTER_VALIDATE_EMAIL))
          {
               $error .= '<p><label class="text-danger">Invalid email format</label></p>';
          }
     }
     if(!empty($_POST["last_name"]))
     {
          $last_name = clean_text($_POST["last_name"]);
     }
     if(empty($_POST["roll_number"]))
     {
          $error .= '<p><label class="text-danger">Roll Number is required</label></p>';
     }
     else
     {
          $roll_number = clean_text($_POST["roll_number"]);
     }
     
     if($error == '')
     {
          $roll_number=clean_text($_POST['roll_number']);
          $file_open = fopen("temp.csv", "a+");
          $count=0;
          if (($handle = fopen('student.csv', "r")) !== FALSE) {
               while (($data= fgetcsv($handle)) !== FALSE) {
               if ($roll_number != $data[2] ){
               //     $list = array($data);
                   fputcsv($file_open, $data);
               }else{
                    if($first_name==''){
                         $first_name=data[0];
                    }
                    if($last_name==''){
                         $last_name=$data[1];
                    }
                    if($email==''){
                         $email=$data[3];
                    }
                    $form_data = array(
                         'first_name'  => $first_name,
                         'last_name' => $last_name,
                         'roll_number' => $roll_number,
                         'email'  => $email
                    );
                    fputcsv($file_open, $form_data);
                    $count=1;
               }
          }
          fclose($handle);
          fclose($file_open);
          unlink('student.csv');
          rename('temp.csv','student.csv');
          if($count){
               $error = '<label class="text-success">Updated Successfuly</label>';
          }else{
               $error = '<label class="text-warning">Student details not found</label>';
          }
          $first_name = '';
          $last_name = '';
          $roll_number = '';
          $email = '';
     }
  
}
}
?>
<!DOCTYPE html>
<html>
 <head>
  <title>Enter student deatil</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 </head>
 <body>
  <br />
  <div class="container">
   <h2 align="center">Enter Student Details</h2>
   <br />
   <div class="col-md-6" style="margin:0 auto; float:none;">
    <form method="post">
     <br />
     <?php echo $error; ?>
     <div class="form-group">
      <label>First Name</label>
          <input type="text" name="first_name" placeholder="Enter First Name" class="form-control" value="<?php echo $first_name; ?>" />
     </div>

     <div class="form-group">
      <label>Last Name</label>
      <input type="text" name="last_name" class="form-control" placeholder="Enter Last Name" value="<?php echo $last_name; ?>" />
     </div>

     <div class="form-group">
      <label>Roll Number</label>
      <input name="roll_number" class="form-control" placeholder="Enter Roll Number" value="<?php echo $roll_number; ?>"/>
     </div>

     <div class="form-group">
      <label>Email</label>
      <input type="text" name="email" class="form-control" placeholder="Enter Email" value="<?php echo $email; ?>" />
     </div>

     <div class="form-group" align="center">
          <div class="col-md-12 bg-light text-right">
               <input type="submit" name="submit" class="btn btn-info" value="Insert" />
               <input type="submit" name="delete" class="btn btn-danger" value="Delete" />
               <input type="submit" name="search" class="btn btn-success" value="Search" />
               <input type="submit" name="update" class="btn btn-warning" value="Update" />
               <button type="button" class="btn btn-primary" onclick="location.href='/Assignment/B190528CS_2.php'">Display</button>
          </div>
    </div>
    </form>
   </div>
  </div>
 </body>
</html>