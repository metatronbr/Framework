<?php
session_start();
require_once('config.inc.php');


class Database extends Config{

	
	public function conn(){
		$dsn = $this->sgdb.":host=".$this->dbserver.";port=".$this->port.";dbname=".$this->dbname.";charset=UTF-8";
		$opcoes = array(
    		PDO::ATTR_PERSISTENT => true,
    		PDO::ATTR_CASE => PDO::CASE_LOWER,
    		PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
		);
		try {
			$pdo = new PDO($dsn, $this->dbuser, $this->dbpass, $opcoes); 
		} catch (PDOException $e) {
			echo 'Erro: '.$e->getMessage();
		}
		return $pdo;
	}
	
	public function obtemRegistros($query,$values = NULL){
		$pdo = $this->conn();
		if(!$values){
			$stmt = $pdo->query($query);
		}else{
			$stmt = $pdo->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
			$stmt->execute($values);
		}
		while($obj = $stmt->fetch(PDO::FETCH_ASSOC)){
			$resultado[] = $obj;
		}
		
		return $resultado;	
	
	}
	
	
	public function executa($query,$values = NULL){
		$pdo = $this->conn();
		if(!$values){
			$exec = $pdo->exec($query);
		}else{
			$exec = $pdo->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
			$exec->execute($values);
		}
		if (!$exec) {
    		echo "\nPDO::errorInfo():\n";
   			print_r($pdo->errorInfo());
   			echo "<hr>".$query."<br>";
   			return;
		}
		
		$id = $pdo->lastInsertId();
		
		return $id;
	
	}

}
?>