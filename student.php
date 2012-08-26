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
			return false;
		}
	}
	
}

?>
