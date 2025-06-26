<?php
// file: /core/PDOConnection.php

class PDOConnection {
	private static $db_singleton = null;

	public static function getInstance() {
		if (self::$db_singleton == null) {
			$dbhost = getenv("DATABASE_HOST");
            $dbport = getenv("DATABASE_PORT");
	        $dbname = getenv("DATABASE_NAME");
	        $dbuser = getenv("DATABASE_USERNAME");
	        $dbpass = getenv("DATABASE_PASSWORD");

            self::$db_singleton = new PDO(
                "pgsql:host=$dbhost;port=$dbport;dbname=$dbname;", // connection string
                $dbuser,
                $dbpass,
                array( // options
                    PDO::ATTR_EMULATE_PREPARES => false,
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                )
            );
            
	    }

	return self::$db_singleton;
}
}
?>