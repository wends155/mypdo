<?php
	header('Content-Type: text/plain');
	require "student.php";
	try{
		$stdnt = Student::getStudentId("2010-10031");
		$s = Student::getId(1);
		var_dump($stdnt);
		var_dump($s);
	}catch(Exception $e){
		echo $e->getMessage() . "\n";
	}

?>
