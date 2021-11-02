<?php

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
define("MYSQL_CONN_ERROR", "Unable to connect to database."); 


class dbConnect {
	
	private static $instance;
	protected $connection;
	private $username="";
	private $password="";
	private $host="";
	private $db="";
	
	 public function __construct()
	    {
			$this->connect();
	    }

	private function connect() {
	
		if(!isset(self::$connection)){
			try {
				$config = parse_ini_file('../config/dbconfig.ini');
				$this->username = $config['username'];
				$this->password =$config['password'];
				$this->host = $config['host'];
				$this->db = $config['db'];
				
				$this->connection = new mysqli($config['host'],$config['username'],$config['password'],$config['db']);
				
			} catch(mysqli_sql_exception $e){
				throw $e;
			}
			
		}
		
	}
	
	
	
	  // Get methods 
	public function getUsername (){
	    return $this->username;
	} 
	public function getPassword (){
	    return $this->password;
	} 
	public function getHost (){
	    return $this->host;
	}
	public function getDb (){
	    return $this->db;
	}
	
	public function getConnection(){
		return $this->connection;
	}

	public static function getInstance(){
		 if (! self::$instance) {
            self::$instance = new self();
        }
		return self::$instance;
	}

}