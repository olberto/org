<?php

/**
 * @author olberto
 * @copyright 2024
 */

define( 'MYSQL_HOST', '199.167.144.250' );
define( 'MYSQL_USER', 'weborga4_apache' );
define( 'MYSQL_PASSWORD', 'Admus260532%' );
define( 'MYSQL_DB_NAME', 'weborga4_main' );
define( 'MYSQL_CHARSET', 'utf8');
//define('ROOT_PATH', dirname(__FILE__));


try
{
    $pdo = new PDO( 'mysql:host=' . MYSQL_HOST . ';dbname=' . MYSQL_DB_NAME. ';charset=' . MYSQL_CHARSET, MYSQL_USER, MYSQL_PASSWORD );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch ( PDOException $e )
{
    echo 'Erro conex&atildeo MySQL: ' . $e->getMessage();
}


?>