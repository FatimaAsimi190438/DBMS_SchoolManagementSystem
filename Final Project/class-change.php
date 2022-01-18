`<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Class Change Form | Humarey Bachchey</title>

    <link rel="stylesheet" href="style.css?v=<? echo time(); ?>">
    <link rel="shortcut icon" href="sch.ico">
  </head>
  <body>
    <div class="header">
        <center><table>
          <tr>
            <td>Humarey Bachchey</td>
          </tr>
        </table></center>
    </div>

    <div class="main">
      <h1>Class Assignment Form</h1><hr>
      <form action="" method="post">
        <h2>Student Information</h2><hr>
        <div class="form-input">
        <table>
            <tr>
            <td><label for="">Student ID: </label></td>
              <td><input type="text" name="stu-id" required></td>
            </tr>
            <tr>
              <td><label for="">Current Class: </label></td>
              <td><input type="text" name="old" required></td>
            </tr>
            <tr>
              <td><label for="">New Class: </label></td>
              <td><input type="text" name="new" required></td>
            </tr>
			<tr>
              <td><label for="">Reason for Change: </label></td>
              <td><textarea rows="4" cols="50"></textarea></td>
            </tr>
			<tr>
              <td><label for="">Change Approved By: </label></td>
              <td><input type="text" name="temp"></td>
            </tr>
          </table>
        </div>
		   <center><button type="submit" name="submit">Submit</button></center>
      </form>

<center>
<?php

require 'dbh.php';
if (isset($_POST["submit"])){

    $stu_id = $_POST["stu-id"];
	$old = $_POST["old"];
	$new  = $_POST["new"];
	
	$q = "select * from student where stu_id = '$stu_id'";
	$query_run= $mysqli->query($q) or die ($mysqli->error);
  $row = $query_run->fetch_array();
	
	if($row["STU_ID"]){
		
		$q = "select * from class where class_name = '$new'";
		$query_run= $mysqli->query($q) or die ($mysqli->error);
    $row = $query_run->fetch_array();
	
		if($row["CLASS_NAME"]){
			
			$q = "update student set classname = '$new' where stu_id = '$stu_id'";
      $query_run= $mysqli->query($q) or die ($mysqli->error);
      
			$q = "select serial_no from class_history order by serial_no desc";
      $query_run= $mysqli->query($q) or die ($mysqli->error);
      $row = $query_run->fetch_array();
			$serial = $row["serial_no"];
			$serial = $serial + 1;
			
			$q = "Insert into CLASS_HISTORY (SERIAL_NO,STU_ID,OLD_CLASS,NEW_CLASS) values ($serial,'$stu_id','$old','$new')";
      $query_run= $mysqli->query($q) or die ($mysqli->error);
     
      if($query_run){
				echo "<HR>Class Changed<HR>";
			}
			else{
				echo "<HR>Couldn't Change Class<hr>";
			}
		}
		else{
			echo "<hr>Class Doesn't Exist<hr>";
		}
	}	
	else{
		echo "<HR>Invalid Student ID<HR>";
	}
}
  
?>
</center>
</div>
</body>
</html>
