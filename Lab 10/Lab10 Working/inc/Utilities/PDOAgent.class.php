<?php

//Reference: https://culttt.com/2012/10/01/roll-your-own-pdo-php-class/

class PDOAgent    {

    //Get all the params for the database (Set in config.inc.php)
    private $host = DB_HOST;  
    private $user = DB_USER;  
    private $pass = DB_PASS;  
    private $dbname = DB_NAME;

    //The connection string for the database
    private $dsn = "";

    //Save the class type
    private $className;

    //The PDO object
    private $pdo;
    //Any error
    private $error;

    //Statement
    private $stmt;


    
    public function __construct(String $className)    {

        //Record the class name
        $this->className = $className;
        // Set DSN  
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;  

        // Set options  
        $options = array(  
            PDO::ATTR_PERSISTENT => true,  
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION  
            ); 

        //Initialize the PDO Object
        try {  
            $this->pdo = new PDO($dsn, $this->user, $this->pass, $options);  
            //Catch any errors
        } catch (PDOException $e) {  
            $this->error = $e->getMessage();  
        }  
        
    }

    //Take a query, store it as a prepared statement
    public function query(string $query) {
            //Take the query and prepare a statement, store it in the class for later execution
            $this->stmt = $this->pdo->prepare($query);  
    }

    //Bind Parmemters and values for the prepared statement 
    public function bind(string $param,string $value, $type = null)  {

        if (is_null($type)) {  
            switch (true) {  
                case is_int($value):  
                $type = PDO::PARAM_INT;  
                break;  
                case is_bool($value):  
                $type = PDO::PARAM_BOOL;  
                break;  
                case is_null($value):  
                $type = PDO::PARAM_NULL;  
                break;  
                default:  
                $type = PDO::PARAM_STR;  
            }  
        }

        $this->stmt->bindValue($param, $value, $type); 
    }
    
    //Execute the prepared statement
    public function execute($data = null)   {
        if (is_null($data)) {  
            return $this->stmt->execute();  
        } else {
            return $this->stmt->execute($data);
        }
    }


    //Return the resultset (more than one record)
    public function resultSet(){  
        $this->execute();  
        //$this->stmt->setFetchMode(PDO::FETCH_CLASS, $this->className);
        return $this->stmt->fetchAll(PDO::FETCH_CLASS, $this->className);  
    }

    //Return a single result (single record)
    public function singleResult(){  
        $this->execute();  
        $this->stmt->setFetchMode(PDO::FETCH_CLASS, $this->className);
        return $this->stmt->fetch(PDO::FETCH_CLASS);  
    }  

    //Return the rowCount
    public function rowCount(): int{  
        return $this->stmt->rowCount();  
    }
    
    //Get the lastInsertedID
    public function lastInsertId(): int{  
        return $this->pdo->lastInsertId();  
    }

    public function rowsAffected(): int {
        return $this->stmt->rowCount();
    }

    //Get the debug parms;
    public function debugDumpParams(){  
        return $this->stmt->debugDumpParams();  
    }  

}

?>