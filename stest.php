<?php
	header('Content-Type: text/plain');
	require "student.php";
	try{
		
		$coll = Student::getAll();
		var_dump($coll);
	}catch(Exception $e){
		echo $e->getMessage() . "\n";
	}

?>
