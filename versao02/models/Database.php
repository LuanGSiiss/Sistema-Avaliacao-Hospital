<?php

require_once __DIR__ . '/../config_db.php';

class Database
{
    public function getConnection() 
    {
        $dsn = "pgsql:host=" . db_HOST . ";port=" . db_PORT . ";dbname=" . db_NAME;
        $pdo = new PDO($dsn, db_USER, db_PASSWORD, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);

        if (!$pdo) {
            throw new Exception("Erro ao conectar com o banco de dados.");
        }

        return $pdo;
    }
}