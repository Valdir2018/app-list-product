<?php

require_once "config.php";

class Connection {
    public static $host = HOST;
    public static $user = USER;
    public static $pass = PASS;
    public static $database = DBNAME;

    private static $connect = null;

    public static function openConnection() 
    {
        try {

            if (self::$connect == null) {
                self::$connect = new PDO("mysql:host=". self::$host . ";charset=utf8;dbname=" . self::$database, self::$user, self::$pass);
                print ">> successfully connected <<";
            }

        } catch(PDOException $error) {
            throw new Exception($error->getMessage(). 'error connecting to the database !');
        }
        self::$connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return self::$connect;
    }

}