<?php
    // Database settings
    define('DB_URL', 'localhost');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', '');
    define('DB_NAME', 'vaccin_reservation');

    // Database connection
    function getPdo() {
        
        try {
            
            $pdo = new PDO("mysql:host=" . DB_URL . ";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_OBJ);

            return $pdo;
    
        } catch(PDOException $e) {
            die("ERROR: Could not connect. " . $e->getMessage());
        }

    }

    // Get redirect string
    function redstr($page) {
        return $_SERVER['PHP_SELF']."?page=$page";
    }

?>