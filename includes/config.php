<?php
session_start();
/* Lokal utveckling */
// define("DB_HOST", 'localhost');
// define("DB_USERNAME", 'root');
// define("DB_PASSWORD", 'yamo123');
// define("DB_NAME", 'opinion_blogportal');

/* Publikt */
define("DB_HOST", 'studentmysql.miun.se');
define("DB_USERNAME", 'yage1800');
define("DB_PASSWORD", 'j9jxpj24');
define("DB_NAME", 'yage1800');

function my_autoloader($class) {
    include 'classes/' . $class . '.class.php';
}

spl_autoload_register('my_autoloader');

error_reporting(E_ALL); 
ini_set('display_errors', TRUE); 
ini_set('display_startup_errors', TRUE);

?>