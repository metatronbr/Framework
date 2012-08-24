<?php

class Config{
	public function __construct(){

		$this->mpdebug = 0; // 1 liga - 0 desliga
		
		
		// CONFIGURAÇÕES DO BANCO DE DADOS

			$this->dbserver = "localhost"; // endereço do servidor de bd
			$this->dbname = "sismail"; // nome da base de dados
			$this->dbuser = "root";	// nome do usuario da base de dados	
			$this->dbpass = ""; // senha da base de dados
			$this->dbtype = 1; // 1 = Mysql , 2 = Postgresql , 3 = Oracle , 4 = SQL Server
			$this->sgdb = 'mysql';
			$this->port = '3306'; // porta do Mysql		

			// CONFIGURAÇÕES GERAIS
			define("TITLE", "Caffé Mail System");
			define("LOGO", "img/logo.png");
			define("EMPRESA", "Agencia Caffé");
			define("EMAIL","alexandre@agenciacaffe.com.br");
			define("SITE","http://www.agencicacaffe.com.br");
			
			
			
		
	}	
}


?>