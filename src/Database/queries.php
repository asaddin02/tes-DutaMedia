<?php
namespace Api\Database;

use Api\Database\Connection;

class Queries extends Connection
{
    protected function perform($query, $param = [])
    {
        $stmt = $this->connect()->prepare($query);
        if(empty($param)){
            $stmt->execute();
        }else{
            $stmt->execute($param);
        }
        return $stmt;
    }
}