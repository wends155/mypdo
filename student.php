<?php
require "db.php";
class Student{
	private $data = array();
	
	private function __construct($data){
		if(is_array($data)){
			$this->data = $data;
		}else{ 
			throw new Exception('student parameter error');
		}
	}
	
	public function __get($name){
		if(isset($this->data[$name])){
			return $this->data[$name];
		}
		return false;
	}
	
	public function __set($name, $value){
		if(isset($this->data[$name])){
			$this->data[$name] = strtoupper($value);
		}else {
			throw new Exception("No key $name");
		}
	}
	
	public function fullName(){
		$fname = $this->data['fname'];
		$lname = $this->data['lname'];
		$mname = $this->data['mname'][0];
		return "$lname, $fname $mname.";
	}
	
	public function save(){
		$studentId = $this->data['student_id'];
		$fname = $this->data['fname'];
		$lname = $this->data['lname'];
		$mname = $this->data['mname'];
		$id = $this->data['id'];
		
		$sql = "UPDATE `students` SET 
				`student_id` = '$studentId',
				`lname` = UCASE('$lname'),
				`fname` = UCASE('$fname'),
				`mname` = UCASE('$mname')
				WHERE `id` = '$id' LIMIT 1;";
		DB::exec($sql);
	
	}
	
	public static function getId($id){
		try{
			$sql = "select * from students where id=$id limit 1";
			$stmt = DB::query($sql);
			$data = $stmt->fetch(PDO::FETCH_ASSOC);
			return new Student($data);
		}catch(Exception $e){
			return false;
		}
	}
	
	public static function getStudentId($studentId){
		try{
			if($studentId){
				$sql = "SELECT * from students where student_id = '$studentId' limit 1";
				$stmt = DB::query($sql);
				$data = $stmt->fetch(PDO::FETCH_ASSOC);
				return new Student($data);
			}
			return false;
		}catch(Exception $e){
			throw $e;
		}
	}
	
	public static function getLatest(){
		$lastID = DB::lastInsertId();
		return self::getId($lastID);
	}
	
	public static function newStudent($data){
		if(!is_array($data)){
			throw new Exception("parameter must be an array.");
		}
		
		$studentId = trim($data['student_id']);
		$fname = trim($data['fname']);
		$lname = trim($data['lname']);
		$mname = trim($data['mname']);
		
		if($studentId && $fname && $lname && $mname){
			$sql = "INSERT INTO `students`(`student_id`,`fname`,`lname`,`mname`) 
					values ('$studentId',UCASE('$fname'),UCASE('$lname'),UCASE('$mname'));";
			try{
				$stmt = DB::exec($sql);
				return self::getLatest();
			}catch(Exception $e){
				throw $e;
			}
		}
		
		throw new Exception("incomplete data");
	}
	
	public static function insertStudent($studentId,$fname,$lname,$mname){
		
		if($studentId && $fname && $lname && $mname){
			
			$data = array('student_id' 	=> $studentId, 
						  'fname'		=> $fname,
						  'lname'		=> $lname,
						  'mname'		=> $mname);
			return self::newStudent($data);			  
		}
		throw new Exception("paramter incomplete");
	}
	
	public static function getAll(){
		$stmt = DB::query("SELECT * FROM students");
		$collection = array();
		while ($data = $stmt->fetch(PDO::FETCH_ASSOC)){
			$collection[] = new Student($data);
		}
		return $collection;
	}
	
}

?>
