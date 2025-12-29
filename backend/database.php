<?php

require_once __DIR__ . '/config.php';

class Database {
    private static $connection = null;

    public static function connect() {
        if (self::$connection === null) {
            try {
                $options = [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ];
                
                // Enable SSL for production (DigitalOcean requires it)
                $host = Config::DB_HOST();
                if (strpos($host, 'ondigitalocean.com') !== false) {
                    $options[PDO::MYSQL_ATTR_SSL_CA] = true;
                    $options[PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT] = false;
                }
                
                self::$connection = new PDO(
                    "mysql:host=" . $host . 
                    ";port=" . Config::DB_PORT() . 
                    ";dbname=" . Config::DB_NAME(),
                    Config::DB_USER(),
                    Config::DB_PASSWORD(),
                    $options
                );
            } catch (PDOException $e) {
                die("Connection failed: " . $e->getMessage());
            }
        }
        return self::$connection;
    }
}
?>