<?php

// Set the reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Config
{
    public static function DB_NAME()
    {
        return 'web-library';
    }

    public static function DB_PORT()
    {
        return 3306;
    }

    public static function DB_USER()
    {
        return 'root';
    }

    public static function DB_PASSWORD()
    {
        return '';
    }

    public static function DB_HOST()
    {
        return '127.0.0.1';
    }

    public static function JWT_SECRET()
    {
        return 'lazarmatic';
    }
}

class Database
{
    private static $connection = null;

    public static function connect()
    {
        die('<pre>' .
            print_r([
                'FILE' => __FILE__,
                'HOST' => Config::DB_HOST(),
                'PORT' => Config::DB_PORT(),
                'DB' => Config::DB_NAME(),
                'USER' => Config::DB_USER(),
                'PASSWORD_LENGTH' => strlen((string)Config::DB_PASSWORD())
            ], true) .
            '</pre>');

        if (self::$connection === null) {
            try {
                self::$connection = new PDO(
                    "mysql:host=" . Config::DB_HOST() .
                        ";port=" . Config::DB_PORT() .
                        ";dbname=" . Config::DB_NAME(),
                    Config::DB_USER(),
                    Config::DB_PASSWORD(),
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                    ]
                );
            } catch (PDOException $e) {
                die("Connection failed: " . $e->getMessage());
            }
        }

        return self::$connection;
    }
}
