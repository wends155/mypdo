<?php
	class Database {
		private static $_inst = null;
		private static 	$dsn = 'mysql:host=localhost;dbname=oop',
						$user= 'root',
						$pass = '';
		
		private function __construct(){
			try {
				self::$_inst = new PDO(self::$dsn,self::$user,self::$pass);
			} catch (PDOException $e){
				throw $e;
			}
		}
		
		public static function getDB(){
			
			if(!(self::$_inst instanceof PDO)){
				new Database();
			}
			
			return self::$_inst;
		}
		
		public static function sql($sql){
			$conn = self::getDB();
			try {
				$statement = $conn->query($sql);
				
				if (  !($statement instanceof PDOStatement)){
					
					throw new PDOException("Statement error: '$sql'");
				}
				
				$result = $statement->fetchall(PDO::FETCH_ASSOC);
				
				if($result){
					if(count($result) > 1){
						return $result;
					}
					return $result[0];
				} elseif( $statement->rowCount() ){
					return true;
				}
				
				return false;
			} catch(PDOException $e){
				throw $e;
			}
		}
		
						
		public static function prepare($sql,$params=null){
			$conn = self::getDB();
			
			try{
				$stmt = $conn->prepare($sql);
				
				if (  !($stmt instanceof PDOStatement)){
					
					throw new Exception("Statement error: '$sql'");
				}
				
				if (is_array($params)){
					$stmt->execute($params);
				} else {
					$stmt->execute( array($params) );
				}
				
				$result = $stmt->fetchall(PDO::FETCH_ASSOC);
				if ($result){
					if( count($result) > 1 ){
						return $result;
					}
					return $result[0];
				}elseif( $stmt->rowCount() ){
					return true;
				}
				return false;
			
			}catch(PDOException $e){
				throw $e;
			}
		}
		
		public static function insert($sql,$params,$table){
			$conn = self::getDB();
			
			try{
				$stmt = $conn->prepare($sql);
				
				if (  !($stmt instanceof PDOStatement)){
					
					throw new Exception("Statement error: '$sql'");
				}
				
				if( is_array($params) ){
					$stmt->execute($params);
				} else {
					$stmt->execute( array($params) );
				}
				
			} catch (Exception $e){
				throw $e;
			}
			
			if( $stmt->rowCount() ){
				$lastID = $conn->lastInsertId();
				return self::sql("SELECT * FROM $table WHERE id IN ($lastID)");
			}
			return false;
		}
		
		public static function insert_array($array,$table){
			if( is_array($array) ){
				$fields = self::getFields($array);
				$params = self::getParams($array);
				$sql = "INSERT INTO $table ($fields) VALUES ($params)";
				return self::insert($sql,$array,$table);
			}
			throw new Exception("First parameter must be an array.");
		}
		
		private static function getFields($params){
			if( is_array($params) ){
				$out = "";
				foreach(array_keys($params) as $key => $val){
					if($key == 0){
						$out = $out . $val;
						continue;
					}
					$out = $out . ",$val";
				}
				return $out;
			} 
			throw new Exception("Parameter must be an array");
		}
		
		private static function getParams($params){
			if( is_array($params) ){
				$out = "";
				foreach(array_keys($params) as $key => $val){
					if($key == 0){
						$out = $out . ":$val";
						continue;
					}
					$out = $out . ",:$val";
				}
				return $out;
			} 
			throw new Exception("Parameter must be an array");
		}
		
	}
	
?>
