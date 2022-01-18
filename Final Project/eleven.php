<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Student Per Class Form | Humarey Bachchey</title>

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
      <h1>Student Per Class</h1><hr>

	<BODY>

		
	<form action="student-admission.php" method="post">
	<p style="text-align:left;">
	<input type="submit" name="test" value="ADD NEW STUDENT +" />
	</p>
	</form>


	<center>
	<form action="" method="post">
		<hr>
		
		<p> Enter Student ID: <input type="text" name="Enum" /></p>
		OR
		<p> Enter Student First Name: <input type="text" name="Enum1" /> <br><br> Enter Student Last Name :  <input type="text" name="Enum2" /> </p>
		<input type="submit" name="cal" value="Search the Record" />
		
		<hr>
	</form>
	

<?php  // creating a database connection 

	$Target_ID = " "; 	//STUDENT ID
	$Target_ID1 = " ";	//First Name
	$Target_ID2 = " ";	//Last Name

	require 'dbh.php';

//IF DELETE:
if(isset($_POST["delete"])){

//Delete Student Info:	
	 $Target_ID = $_POST["delete"];
	
	 $sql = " DELETE FROM fee WHERE stu_id = '$Target_ID'";
	 
	if ($mysqli->query($sql) === TRUE) {
		echo "Record deleted successfully";
	  } else {
		echo "Error deleting record: " . $mysqli->error;
	  }


	 $q = " DELETE FROM class_history WHERE stu_id = '$Target_ID'";

	 if ($mysqli->query($q) === TRUE) {
		echo "Record deleted successfully";
	  } else {
		echo "Error deleting record: " . $mysqli->error;
	  }



	 $q = " DELETE FROM student WHERE stu_id = '$Target_ID'";
	 
	 if($mysqli->query($q)) {
		echo "Record Deleted<br>";
	 }
	 else {
		 echo "Record not Deleted!<br>";
		 $e = oci_error($query_id);  
		 echo $e['message'];
	 }

}
	
//IF UPDATE:
if(isset($_POST["val"])){
	
		$s_id = $_POST["s_id"];
		$s_fname = $_POST["s_fname"];
		$s_lname = $_POST["s_lname"];
		$s_dob = $_POST["s_dob"];
		$s_gender = $_POST["s_gender"];
		$s_reg = $_POST["s_reg"];
		$s_class = $_POST["s_class"];
			
		require 'dbh.php';

//Updating Student Info:
		$q="update student set fname = '$s_fname', lname = '$s_lname', dob = '$s_dob' , reg_date='$s_reg', gender='$s_gender' , classname='$s_class' where stu_id = '$s_id'";
		$query_run= $mysqli->query($q) or die ($mysqli->error);
		
//Updating Father Info:	
if(isset($_POST["f_cnic"])){
	
		$f_cnic = $_POST["f_cnic"];
		$f_fname = $_POST["f_fname"];
		$f_lname = $_POST["f_lname"];
		$f_address = $_POST["f_address"];
		$f_gender = $_POST["f_gender"];
		$f_contact = $_POST["f_contact"];
		$f_email = $_POST["f_email"];


	 $q="update parent set fname = '$f_fname', lname = '$f_lname', gender = '$f_gender', contact = '$f_contact', email = '$f_email', address = '$f_address' where cnic = '$f_cnic'";
	 	
		$query_run= $mysqli->query($q) or die ($mysqli->error);
	}

//Update Mother Info:
if(isset($_POST["m_cnic"])){
	
		$m_cnic = $_POST["m_cnic"];
		$m_fname = $_POST["m_fname"];
		$m_lname = $_POST["m_lname"];
		$m_address = $_POST["m_address"];
		$m_gender = $_POST["m_gender"];
		$m_contact = $_POST["m_contact"];
		$m_email = $_POST["m_email"];
}

//Update Guardian Info:
if(isset($_POST["g_cnic"])){

	 $q="update parent set fname = '$m_fname', lname = '$m_lname', gender = '$m_gender', contact = '$m_contact', email = '$m_email', address = '$m_address' where cnic = '$m_cnic'";
	 
	 $query_run= $mysqli->query($q) or die ($mysqli->error);
		$g_cnic = $_POST["g_cnic"];
		$g_name = $_POST["g_name"];
		$g_gender = $_POST["g_gender"];
		$g_contact = $_POST["g_contact"];
		$g_relation = $_POST["g_relation"];


	 $q="update guardian set name = '$g_name', gender = '$g_gender', contact = '$g_contact', relation = '$g_relation' where cnic = '$g_cnic'";
	 
	 $query_run= $mysqli->query($q) or die ($mysqli->error);
}	
	 if($query_run){
			 echo "Record Updated";
	 }
	 else{
		 echo "Record not Updated!<br>";
		 $e = $mysqli->error($query_id);  
		 echo $e['message'];
	 }

}

//Search one Specific Record:	
if(isset($_POST["cal"]) && (($_POST["Enum"]) || ($_POST["Enum1"] && $_POST["Enum2"]))){

//With ID:
	if($_POST["Enum"]){
		$Target_ID  = $_POST["Enum"]; 

		$q2 = "select stu_id,classname, fname, lname, (reg_date - DOB)/365 as CHILD_AGE ,gender from student where stu_id = '".$Target_ID."'";

	}
//With Name:
	elseif($_POST["Enum1"] && $_POST["Enum2"]){
		$Target_ID1  = $_POST["Enum1"]; 
		$Target_ID2  = $_POST["Enum2"]; 

		$q2 = "select stu_id,classname, fname, lname, (reg_date - DOB)/365 as CHILD_AGE ,gender from student where fname = '".$Target_ID1."' and lname = '".$Target_ID2."'";
				
	}
	else{
		echo "Enter Both First and Last Name or Enter Correct Roll Number<br><br>";
	}

	$result = $mysqli->query($q2) or die($mysqli->error);
	$row1 = $result->fetch_assoc();

	$q1 = "select classname, count(classname) as Total from student group by classname having classname = '".$row1["classname"]."'";

	$result = $mysqli->query($q1);
	$row = $result->fetch_assoc();
//DISPLAY:	
	echo "<table border = 2>";

		echo "<tr>";
		echo "<td width = 800> Class Name: ".$row["classname"]." ( Total Students ".$row["Total"]." ): <br><br>";

		echo "<table border = 1>";
	
			echo "<tr>";
			echo "<td width = 250> Roll No: ".$row1["stu_id"]."&emsp; &emsp; </td>";
			echo "<td width = 300> Name: ".$row1["fname"]." ".$row1["lname"]." &emsp; &emsp; </td>";
			echo "<td width = 200> Age(years): ".$row1["CHILD_AGE"]."&emsp; &emsp; </td>";
			echo "<td width = 150> Gender: ".$row1["gender"]."&emsp; &emsp; </td>";
			
			$temp = $row1["fname"]." ".$row1["lname"];

			$temp1 = $row1["stu_id"]; //STUDENT ID
		
//--UPDATE BUTTON	
			echo "<td width = 150>";
			echo "<form action=\"update-stu.php\" method=\"post\">";
            echo '<button name="update" value='.$row1["stu_id"].' type="submit">UPDATE</button>';
			echo "</form> </td>";
			
//---DELETE BUTTON			
			echo "<td width = 150>";	
			echo "<form action=\"\" method=\"post\">";
	        echo '<button name="delete" value='.$row1["stu_id"].' type="submit">DELETE</button>';
			echo "</form> </td>";
			echo "</tr></td>";
			echo "</table><br><br>";
			echo "</table>";
		
}

//SHOW All Records
else{
	$q1 = "select classname, count(classname) as Total from student group by classname having classname";
	$result = $mysqli->query($q1);
	echo "<table border = 2>";
	$i = 1;
//Display:	
	while($row = $result->fetch_assoc()) 
    {	
		echo "<tr>";
		echo "<td width = 800> Class Name: ".$row["classname"]." ( Total Students ".$row["Total"]." ): <br><br>";
		$q2 = "select stu_id, fname,lname, (reg_date - DOB)/365 as CHILD_AGE ,gender from student where classname = '".$row["classname"]."'";
		$result1 = $mysqli->query($q2) or die($mysqli->error);
		echo "<table border = 1>";
		if ($mysqli->connect_error){
			die("connection failed".$mysqli->connect_error);
		}
		while($row1= $result1->fetch_assoc()) 
		{
		
			echo "<tr>";
			echo "<td width = 250> Roll No: ".$row1["stu_id"]."&emsp; &emsp; </td>";
			echo "<td width = 300> Name: ".$row1["fname"]." ".$row1["lname"]." &emsp; &emsp; </td>";
			echo "<td width = 200> Age(years): ".$row1["CHILD_AGE"]."&emsp; &emsp; </td>";
			echo "<td width = 150> Gender: ".$row1["gender"]."&emsp; &emsp; </td>";

//---UPDATE BUTTON			
			echo "<td width = 150>";
			echo "<form action=\"update-stu.php\" method=\"post\">";
            echo '<button name="update" value='.$row1["stu_id"].' type="submit">UPDATE</button>';
			echo "</form> </td>";
			
//---DELETE BUTTON			
			echo "<td width = 150>";	
			echo "<form action=\"\" method=\"post\">";
	        echo '<button name="delete" value='.$row1["stu_id"].' type="submit">DELETE</button>';
			echo "</form> </td>";
			
			echo "</tr>";
	
			$i = $i + 1;

		}
	
		echo "</table><br><br></td>";

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
