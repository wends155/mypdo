<h1>List of Students</h1>
<a href='insert.php'>Insert new Student</a>
<ol>
<?php
	require "student.php";
	$students = Student::getAll();
	foreach($students as $stud){
		echo "<li>" . $stud->fullName() . "</li>";
	}

?>
</ol>
