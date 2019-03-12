<?php
session_start();
define("DB_HOST", 'localhost');
define("DB_USERNAME", 'root');
define("DB_PASSWORD", 'yamo123');
define("DB_NAME", 'opinion_blogportal');

function my_autoloader($class) {
    include 'classes/' . $class . '.class.php';
}

spl_autoload_register('my_autoloader');

?>