<?php
    define('DB_HOST', 'localhost');    
    define('DB_PORT', '5432'); 
    define('DB_NAME', 'sistema_avaliacao');
    define('DB_USER', 'postgres');
    define('DB_PASSWORD', 'postgres');
    
    // Função para obter a string de conexão
    function getStringConn() {
        $connString = "host=" . DB_HOST . 
                        " port=" . DB_PORT . 
                        " dbname=" . DB_NAME . 
                        " user=" . DB_USER . 
                        " password=" . DB_PASSWORD;
        return $connString;
    }
?>