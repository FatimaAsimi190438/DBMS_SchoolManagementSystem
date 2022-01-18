<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Parent Info Form | Humarey Bachchey</title>

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
      <h1>Parent Information</h1><hr>
 
	<BODY>

	
	<center>
	
	<form action="" method="post">
		
		<p> Parent CNIC:     <input type="text" name="num" /></p>
		OR
	<p> Parent First Name: <input type="text" name="num1" /> <br><br> Parent Last Name :  <input type="text" name="num2" /> </p>
		<input type="submit" name="cal" value="Search the Record" />
	
		<hr>
	</form>
	
<?php  // creating a database connection 

	$Target_ID = " ";   //Parent ID
	$Target_ID1 = " ";	//Parent Fname
	$Target_ID2 = " ";	//Parent Lname
	
if(isset($_POST["cal"]) && (($_POST["num"]) || ($_POST["num1"] && $_POST["num2"]))){

	require 'dbh.php';

//If CNIC is given:
	if($_POST["num"]){
		$Target_ID  = $_POST["num"]; 
		$q1 = "select GENDER from parent where cnic = ".$Target_ID;
		$query_run= $mysqli->query($q1) or die ($mysqli->error);
		$row1 = $query_run->fetch_assoc();

	}
//If Name is given:	
	elseif($_POST["num1"] && $_POST["num2"]){
		$Target_ID1  = $_POST["num1"]; 
		$Target_ID2  = $_POST["num2"]; 

		$q1 = "select CNIC, GENDER from parent where fname = '".$Target_ID1."' and lname = '".$Target_ID2."'";		
		$query_run= $mysqli->query($q1) or die ($mysqli->error);
		$row1 = $query_run->fetch_assoc();
		$Target_ID =$row1["CNIC"];
	}
//If Incorrect:
	else{
			echo "Enter Both First and Last Name or Enter Correct CNIC<br><br>";
	}		
	$query_run= $mysqli->query($q1) or die ($mysqli->error);
	
	$row1 = $query_run->fetch_assoc();

//If Mother Name was Provided(Searches for Father):


	if($row1["GENDER"] == 'F'){
		$q3 = "select mother.fname, father.fname as HusbandName,father.cnic as FCNIC  from parent mother, parent father where (mother.GENDER='F' AND father.spouse= mother.cnic and mother.cnic = '".$Target_ID."')";
		
		
		$query_run= $mysqli->query($q3) or die ($mysqli->error);
		$row1 = $query_run->fetch_assoc();
		$Target_ID = $row1["FCNIC"];

	}
	
	$q2 = "select distinct s.classname,(s.reg_date - s.DOB)/365 as CHILD_AGE, G.NAME as GNAME, s.fname as SNAME, mother.fname as MANAME, father.fname as FANAME from parent mother, parent father, student s, guardian g where (mother.gender='F' AND father.spouse = mother.cnic AND s.father_cnic = father.cnic and g.cnic = s.guardian_cnic) and father.cnic = '".$Target_ID."'";
	
	$query_run= $mysqli->query($q2) or die ($mysqli->error);
	$row1 = $query_run->fetch_assoc();
	echo "<table border = 2>";
	
//Display Info:
	$i = 1;
	while($row = $query_run->fetch_assoc()) 
    {
	echo "<tr>";
	echo "<td width = 400> Child No: ".$i.":</td><td width = 500 align = left>";
			
	echo "Child Name: ".$row["SNAME"]."<br><br>";
	
	echo "Child Age: ".$row["CHILD_AGE"]."<br><br>";

	echo "Child Class: ".$row["classname"]."<br><br>";

	echo "Father Name: ".$row["FANAME"]."<br><br>";

	echo "Mother Name: ".$row["MANAME"]."<br><br>";

	echo "Gaurdian Name: ".$row["GNAME"]."<br><br>";
	
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
