<?php
	$student_id = $_POST['student_id'];
	$fname = $_POST['fname'];
	$lname = $_POST['lname'];
	$mname = $_POST['mname'];
	
	if($student_id && $fname && $lname && $mname){
		
		require "student.php";
		$stud = Student::insertStudent($student_id,$fname,$lname,$mname);
		if($stud){
			header('Location: students.php');
		}
	}

?>
<h1>Insert New Student</h1>
<form method='post'>
StudentID: <input type='text' name='student_id' /><br />
Last Name: <input type='text' name='lname' /><br />
First Name: <input type='text' name='fname' /><br />
Middle Name: <input type='text' name='mname' /><br />
<input type='submit' value='Insert' />
</form>
