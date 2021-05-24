<?php

// show error reporting
error_reporting(E_ALL);

// set your default time-zone
date_default_timezone_set('Europe/Bucharest');

// JWT
define('JWT_KEY', "sql_games_key");
define('JWT_ISSUER', "http://localhost:8000/");
define('JWT_ISSUED_AT', time());
define('JWT_EXPIRATION', time() + (60 * 60 * 24)); // valabil o zi
