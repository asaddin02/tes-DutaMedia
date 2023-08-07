<?php
namespace Api\Database;

use PDO;
use PDOException;

class Connection {
    private $host = 'localhost';
    private $username = 'root';
    private $password = '';
    private $dbname = 'tes';

    protected function connect() {
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
        try{
            $pdo = new PDO($dsn,$this->username,$this->password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        }catch(PDOException $e){
        }
        return $pdo;
    }
}
