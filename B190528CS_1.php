<?php
//index.php

$error = '';
$company_name = '';
$Status = '';
$job_role = '';
$ctc = '';
$fun="para";
function clean_text($string)
{
 $string = trim($string);
 $string = stripslashes($string);
 $string = htmlspecialchars($string);
 return $string;
}

if(isset($_POST["submit"]))
{
 if(empty($_POST["company_name"]))
 {
     $error .= '<script type="text/JavaScript"> alert("Fill all mandatory field");</script>';
 }
 else
 {
  $company_name = clean_text($_POST["company_name"]);
  if(!preg_match("/^[a-zA-Z ]*$/",$company_name))
  {
     $error .= '<script type="text/JavaScript"> alert("Only letters and white space allowed");</script>';
  }
 }
 if(empty($_POST["Status"]))
 {
     $error .= '<script type="text/JavaScript"> alert("Fill all mandatory field");</script>';
 }
 else
 {
  $Status = clean_text($_POST["Status"]);
 
 }
 if(empty($_POST["job_role"]))
 {
     $error .= '<script type="text/JavaScript"> alert("Fill all mandatory field");</script>';
 }
 else
 {
  $job_role = clean_text($_POST["job_role"]);
  if(!preg_match("/^[a-zA-Z ]*$/",$job_role)){
     
     $error .= '<script type="text/JavaScript"> alert("Only letters and white space allowed");</script>';
  }
 }
 if(empty($_POST["ctc"]))
 {
     $error .= '<script type="text/JavaScript"> alert("Fill all mandatory field");</script>';
 }
 else
 {
  $ctc = clean_text($_POST["ctc"]);
 }

 if($error == ''){
  $file_open = fopen("student.csv", "a");
  $no_rows = count(file("student.csv"));
  
  $form_data = array(
   'company_name'  => $company_name,
   'job_role' => $job_role,
   'ctc' => $ctc,
   'Status'  => $Status
  );
  $check=1;
  $file=fopen("student.csv","r");
  while (($data = fgetcsv($file)) !== false){
     if($company_name==$data[0]){
          $check=0;
     }
  }
     if($check){
          fputcsv($file_open, $form_data);
     
          echo "<script type='text/JavaScript'> alert('Inserted Successfully');</script>";
     }else{
          echo "<script type='text/JavaScript'> alert('Already exists!');</script>";
     }
  $company_name = '';
  $job_role = '';
  $ctc = '';
  $Status = '';
 }
 
}


if(isset($_POST['update'])){   
     if(!empty($_POST["company_name"]))
     {
          $company_name = clean_text($_POST["company_name"]);
          if(!preg_match("/^[a-zA-Z ]*$/",$company_name))
          {
               
          echo "<script type='text/JavaScript'> alert('Fill mondatory fields');</script>";
          }
     }
     if(!empty($_POST["Status"]))
     {
          $Status = clean_text($_POST["Status"]);

     }
     if(!empty($_POST["job_role"]))
     {
          $job_role = clean_text($_POST["job_role"]);
     }
     if(empty($_POST["ctc"]))
     {
          echo "<script type='text/JavaScript'> alert('Fill CTC');</script>";
     }
     else
     {
          $ctc = clean_text($_POST["ctc"]);
     }
     
     if($error == '')
     {
          $ctc=clean_text($_POST['ctc']);
          $file_open = fopen("temp.csv", "a+");
          $count=0;
          if (($handle = fopen('student.csv', "r")) !== FALSE) {
               while (($data= fgetcsv($handle)) !== FALSE) {
               if ($ctc != $data[2] ){
               //     $list = array($data);
                   fputcsv($file_open, $data);
               }else{
                    if($company_name==''){
                         $company_name=data[0];
                    }
                    if($job_role==''){
                         $job_role=$data[1];
                    }
                    if($Status==''){
                         $Status=$data[3];
                    }
                    $form_data = array(
                         'company_name'  => $company_name,
                         'job_role' => $job_role,
                         'ctc' => $ctc,
                         'Status'  => $Status
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
               echo "<script type='text/JavaScript'> alert('Updated Successfully');</script>";
          }else{
               echo "<script type='text/JavaScript'> alert('Oops!');</script>";
          }
          $company_name = '';
          $job_role = '';
          $ctc = '';
          $Status = '';
     }
  
}
}
?>
<!DOCTYPE html>
<html>
 <head>
  <title>Enter Company Detail</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js">
  </script>
  <style>
     /* body{background-color: green;} */
     .form-group.required .control-label:after { 
    color: #d00;
    content: "*";
    position: absolute;
    margin-left: 5px;
    top:20px;
}
.form-group.required .control-labl:after { 
    color: #d00;
    content: "*";
    position: absolute;
    margin-left: 5px;
    top:95px;
}
.form-group.required .control-lbl:after { 
    color: #d00;
    content: "*";
    position: absolute;
    margin-left: 5px;
    top:170px;
}
  </style>
 </head>
 <body>
  <br />
  <div class="container">
   <h2 align="center">Enter Company Details</h2>
   <br />
   <div class="col-md-6" style="margin:0 auto; float:none;">
    <form method="post">
     <br />
     <!-- <?php echo $error; 
          //echo '<script>alert(';echo$error;echo')</script>';     
     ?> -->
     <div class="form-group required">
      <label class="control-label">Company Name</label>
          <input type="text" reuired="required" name="company_name" placeholder="Enter company name" class="form-control" value="<?php echo $company_name; ?>" />
     </div>

     <div class="form-group required">
      <label class="control-labl">Job Role</label>
      <input type="text" name="job_role" class="form-control" placeholder="Enter job role" value="<?php echo $job_role; ?>" />
     </div>

     <div class="form-group required">
      <label class="control-lbl">CTC</label>
      <input name="ctc" pattern="^\d*(\.\d{0,2})?$" class="form-control" placeholder="Enter CTC" value="<?php echo $ctc; ?>"/>
     </div>

     <div class="form-group">
      <label>Status</label>
      <input type="text" name="Status" class="form-control" placeholder="Enter Status" value="<?php echo $Status; ?>" />
     </div>

     <div class="form-group" align="center">
          <div class="col-md-12 bg-light text-right">
               <input type="submit" name="submit" class="btn btn-info" value="Insert" />
               <!-- <input type="submit" name="delete" class="btn btn-danger" value="Delete" />
               <input type="submit" name="search" class="btn btn-success" value="Search" /> -->
               <input type="submit" name="update" class="btn btn-warning" value="Update" />
               <button type="button" class="btn btn-primary" onclick="window.open('/Assignment/B190528CS_2.php','_self')">Display</button>
          </div>
    </div>
    </form>
   </div>
  </div>
 </body>
</html>