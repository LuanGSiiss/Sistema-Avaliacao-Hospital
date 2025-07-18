<?php

require_once 'configDb.php';

class Database
{
    public function getConnection() 
    {
        try {
            $dsn = "pgsql:host=" . db_HOST . ";port=" . db_PORT . ";dbname=" . db_NAME;
            $pdo = new PDO($dsn, db_USER, db_PASSWORD, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
        
            return $pdo;

        } catch (PDOException $e) {
            die("Erro de conexão: " . $e->getMessage());
        }
    }
}