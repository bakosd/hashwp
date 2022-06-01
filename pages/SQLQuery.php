<?php

class SQLQuery
{
    protected $query; // the query string
    protected $parameter_array; // the array for binding parameters
    protected $dbq; // the object for dbh
    protected $result; // the result from query

    /**
     * @param $query
     * @param $parameter_array
     */
    public function __construct($query, $parameter_array)
    {
        $this->query = $query;
        $this->parameter_array = $parameter_array;
        $this->result = null;
        $this->execute();
    }

    private function execute()
    {
        if(!defined('SECRET'))
            define("SECRET", "ogGM_pzr3ybW");
        require_once "db_config.php";
        try {
            $dbh = new PDO("mysql:host=" . HOST . ";dbname=" . DATABASE,
                USER, PASSWORD,
                [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"]);
        } catch (PDOException $e) {
            exit("Error: " . $e->getMessage());
        }
        $this->dbq = $dbh->prepare($this->query);
        try {
            if ($this->dbq->execute($this->parameter_array)) {
                $this->result = $this->dbq->fetchAll(PDO::FETCH_OBJ);
            }
        }catch (PDOException $e){
            error_log("********************SQL_QUERY********************");
            error_log("MESSAGE: ".$e->getMessage() . " FIILE: " . $e->getFile() ." LINE: ".$e->getLine());
            error_log("*************************************************");
        }
    }

    public function getResult()
    {
        return $this->result;
    }

    public function getDbq()
    {
        return $this->dbq;
    }
}