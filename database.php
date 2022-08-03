<?php
class Database
{
	//class Attributes
	private $db_servername = "localhost";
	private $db_username   = "root";
	private $db_password   = "";
	private $db_name	   = "";
	
	private $conn		   = null;


	//class methods
	public function __construct(){
	try
		{
			$this->conn = new PDO("mysql:host=$this->db_servername;dbname=$this->db_name", $this->db_username, $this->db_password);
			$this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    		$statement  = $this->conn->prepare("SET NAMES 'utf8'");
    		$statement->execute();
            ini_set('default_charset', 'utf-8');
		}catch(PDOException $e) {
			echo "Connection failed: " . $e->getMessage();
		}
	}
	public function insertRow($table_name,$columns,$columns_value){
	 $sql = "INSERT INTO $table_name ($columns) VALUES ($columns_value)";
	  $stmt=$this->conn->prepare($sql);
	  if($stmt->execute()){
		$message = array("message" => "success");
		echo json_encode($message);
	  }
	}
	public function deleteRow($table_name,$pk_name,$pk_value){

		$sql="DELETE FROM $table_name WHERE $pk_name=$pk_value";
		$stmt=$this->conn->prepare($sql);
		$stmt->execute();
	}
	public function selectFieldsRow($fields='*', $table_name=""){
		$sql="SELECT $fields FROM $table_name ";
		$stmt=$this->conn->prepare($sql);
		$stmt->execute();
		return $stmt->fetchAll();
	}
	public function selectRow($table_name){
		$sql="SELECT * FROM $table_name ";
		$stmt=$this->conn->prepare($sql);
		$stmt->execute();
		return $stmt->fetchAll();
	}
	public function updateRow($table_name,$columns,$pk_name,$pk_value){
		$sql = "UPDATE $table_name SET $columns WHERE $pk_name=$pk_value ";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();
	}
	public function callStoredProcedure($StoredProcedure,$column_value){
		$sql=" CALL ".$StoredProcedure." (".$column_value.")";
		$con=$this->conn;
		$stmt=$con->prepare($sql);
		$stmt->execute();
	}
}
?>