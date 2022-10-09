<!DOCTYPE html>
<html>
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
        <h1 align="center">Company Details</h1><br>
        <!-- <h3 align="center">Student data</h3> -->
		<div class="col-md-8" style="margin:0 auto; float:none;">
        <?php

		echo " <h1 align='center'>";
		echo count(file("student.csv"));
		echo "\n</h1>";
		
		
        echo "<table class='table'>\n\n<thead>\n<tr>\n<th scope='col'>#</th>\n<th scope='col'>Company Name</th>\n<th scope='col'>Job Role</th>\n<th scope='col'>CTC</th>\n<th scope='col'>Status</th>\n<th scope='col'>Edit</th>\n<tr>\n";
        // Open a file
        $arr=array();
        $count=0;
        $file_open = fopen("temp.csv", "a+");

          if (($handle = fopen('student.csv', "r")) !== FALSE) {
               while (($data= fgetcsv($handle)) !== FALSE) {
                $tt=array($data[3],$data[0],$data[1],$data[2],$data[3]);
                array_push($arr,$tt);
                $count++;
            //    if ($roll_number != $data[2] ){
            //        fputcsv($file_open, $data);
            //    }
                }
            }
        if($count!=0){
            sort($arr);
            for($i=0; $i<$count; $i++){
                $farr=array($arr[$i][1],$arr[$i][2],$arr[$i][3],$arr[$i][4]);
                fputcsv($file_open,$farr);
            }
        }
        fclose($handle);
        fclose($file_open);
        unlink('student.csv');
        rename('temp.csv','student.csv');
		$count=1;
        $file = fopen("student.csv", "r");
        
        $func="window.open('/Assignment/B190528CS_2.php','_self')";
        // Fetching data from csv file row by row
		echo "<tbody >";
        while (($data = fgetcsv($file)) !== false) {
  
            // HTML tag for placing in row format
            echo "<tr class='table-success'>";
			echo "<th scope='row'>$count</th>";
            foreach ($data as $i) {
                if(!strcmp($i,"Applied")){
                    //echo $i;
                    //$tbl="table-success";
                    echo "<td class='text-success'>" . htmlspecialchars($i) 
                    . "</td>";
                }else if(!strcmp($i,"Rejected")){
                    //echo $i;
                    //$tbl="table-success";
                    echo "<td class='text-danger'>" . htmlspecialchars($i) 
                    . "</td>";
                }else if(!strcmp($i,"No Idea")){
                    //echo $i;
                    //$tbl="table-success";
                    echo "<td class='text-warning'>" . htmlspecialchars($i) 
                    . "</td>";
                }
                else{
                echo "<td>" . htmlspecialchars($i) 
                    . "</td>";
                }
            }
            echo "<td><button type='button' class = 'btn btn-warning'onclick='myfnc()'><img style='height:15px;width:20px;' src='./edit.png' alt='Submit'></button></td>";
            echo "</tr> \n";
			$count+=1;
        }
		echo "\n</tbody>";
        // Closing the file
        fclose($file);
  
        echo "\n</table>";
        ?>
        

	</div>
    
<script type="text/JavaScript">


function myfnc(){
    window.open('./B190528CS_1.php','_self');
}
</script>

</div>
</body>

</html>

