<?php
session_start();
ini_set('memory_limit', '256M');
require_once('config.inc.php');

class Database extends Config{

	public function conn($bd,$banco = NULL){
		if($bd == 1) {
			// MYSQL
			if($banco == null){
				$link = mysql_connect($this->dbserver, $this->dbuser, $this->dbpass);
				$conn = mysql_select_db($this->dbname, $link);
			}elseif ($banco == 'databyte'){
				$link = mysql_connect($this->databyte['dbserver'], $this->databyte['dbuser'], $this->databyte['dbpass']);
				$conn = mysql_select_db($this->databyte['dbname'], $link);
			}
			
			mysql_set_charset('utf8',$link); 
						
		} else if($bd == 2){
			// PostgreSQL
			$link = pg_connect($this->dbserver, $this->dbuser_cep, $this->dbpass);
			$conn = pg_select_db($this->dbname_cep, $link);
		}else if($bd == 3){
			// ORACLE
			$conn = oci_connect($this->dbuser, $this->dbpass, $this->dbserver."/".$this->dbname);
			$link = $conn;
			
		}
		
		return $link;
	}
	
	public function obtemRegistros($query,$banco = NULL,$cript = NULL){
		if($this->dbtype == 1){
			// MYSQL
			$this->conn(1,$banco);
			if($cript) $this->getCriptPass();
			$result = mysql_query($query)or die(mysql_error()."<br>Query: ".$query);
			$resultado = array();
			//if($this->mpdebug == "1") echo "<!-- $query -->";
			while ($row = mysql_fetch_assoc($result)) {
				$resultado[] = $row;
			}
		}else if($this->dbtype == 2){
			// POSTGRESQL
			
		}else if($this->dbtype == 3){
			// ORACLE
			$conn = $this->conn(3);
			$stid = oci_parse($conn, $query);
			oci_execute($stid);
			$result = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS);
		}
		return $resultado;	
	
	}
	
	
	public function executa($query){
	
		$this->conn(1);
		$exec = mysql_query($query)or die(mysql_error()."<br>Query: ".$query);
		if($this->mpdebug == "1") echo "<!-- $query -->";
		
		return $exec;
	
	}
	
	public function transaction($tipo){
		if($tipo){
			$this->conn(1);
			if($tipo == "B") mysql_query("BEGIN");
			if($tipo == "C") mysql_query("COMMIT");
			if($tipo == "R") mysql_query("ROLLBACK");
			return;
		}
	}

}
?>