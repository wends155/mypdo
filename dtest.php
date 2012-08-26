<?php
	require "db.php";
	header('Content-Type: text/plain');
	
	try{
		//$sql = "insert into `students`(`student_id`,`fname`,`lname`,`mname`) values ('2010-10031','asdf','asf','asdf');";
		$studentId = "2010-10031";
		$sql = "SELECT * from students where student_id = '$studentId' limit 1";
		//$stmt = DB::exec($sql);
		$stmt = DB::query($sql);
		$student = $stmt->fetch();
		if(is_array($student)){
			var_dump($student);
		}
		if(DB::hasError()){
			var_dump(DB::errorInfo());
		}
	}catch(Exception $e){
		echo $e->getMessage();
	}

?>
