<?php

class db{
    private $host = 'localhost';
    private $user = 'root';
    private $password = '';
    private $dbname = 'lingonowdb';

    function connect(){
        $mysql_connect_str = "mysql:host=$this->host;dbname=$this->dbname";
        $dbConnect = new PDO($mysql_connect_str, $this->user, $this->password);
        $dbConnect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $dbConnect;
    }
}
