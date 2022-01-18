<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Dormant Info Form | Humarey Bachchey</title>

    <link rel="stylesheet" href="style.css?v=<? echo time(); ?>">
    <link rel="shortcut icon" href="sch.ico">
  </head>
  
	    <div class="header">
        <center><table>
          <tr>
            <td>Humarey Bachchey</td>
          </tr>
        </table></center>
    </div>
  
   <div class="main">
      <h1>List of Dormant Students</h1><hr>
 
	<BODY>	

	<center>
	
	
	<form action="" method="post">
		<p> Enter Number of Months:     <input type="text" name="num" /></p>
			OR
		<p> Enter Number of Years: <input type="text" name="num1" /> <br></p>
		
		<input type="submit" name="cal" value="Search the Record" />
		<hr>
	</form>
	
<?php  // creating a database connection 

	$Target_ID = " "; //Months or Years
	
if(isset($_POST["cal"]) && (($_POST["num"]) || ($_POST["num1"]))){


	require 'dbh.php';

//If Months Given:	
	if($_POST["num"]){
		$Target_ID  = $_POST["num"]; 
	}
//If Years Given:

	else if($_POST["num1"]){
		$Target_ID  = $_POST["num1"]; 
		$Target_ID = $Target_ID * 12;
	}
//Query:
	$q1 = "select stu_id,fname,classname,reg_date,floor(DATEDIFF(NOW(),reg_date)/12) AS DORMANT_FOR from student where floor(DATEDIFF(NOW(),reg_date)/12) >= '".$Target_ID."'";
	$query_run = $mysqli->query($q1) or die ($mysqli->error);
	$r1 = $query_run->fetch_assoc();


//Display:	
	echo "<table border = 2>";
	$i = 1;
	while($row = $query_run->fetch_assoc()) {
		
		echo "<tr>";
		echo "<td width = 400> Student No: ".$i.":</td><td width = 500 align = left>";
		echo "Student ID:  ".$row["stu_id"]."<br><br>";
		echo "Student Name:  ".$row["fname"]."<br><br>";
		echo "Student Class:  ".$row["classname"]."<br><br>";
		echo "Registration Date:  ".$row["reg_date"]."<br><br>";
		
		if($row["DORMANT_FOR"] < 12){
			echo "Dormant for:  ".$row["DORMANT_FOR"]." Months.<br><br>";
		}
		else{
			$year = $row["DORMANT_FOR"];
			$month = $year - 12;
			$year = $year / 12;
			echo "Dormant for:  ".intval($year)." Years and ".$month." Months <br><br>";		
		}	
		
		$i = $i + 1;
	}
	if($i == 1){
			echo "No Record Found.<br>";
	}
	echo "</table>";

	
}

?>
</center>
</div>
</body>
</html>