<?php

    namespace Bruno\Database;

    abstract class Connection
    {
        private static $conn;

        public static function getConn()
        {
            if (!self::$conn) {
                self::$conn = new \PDO('mysql: host=localhost; dbname=moat_builders', 'root','');
            }

            return self::$conn;
        }
    }