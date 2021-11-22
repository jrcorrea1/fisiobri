<?php


function getConnection()
{
    $host = "localhost";
    $dbport = "3306";
    $database = "test1";
    $dbuser = "root";
    $dbpassword = "";
    $dbconn = null;
    try {
        $conn_string = "mysql:host=" . $host . ":" . $dbport . ";dbname=" . $database;
        $dbconn = new PDO($conn_string, $dbuser, $dbpassword);
        $dbconn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (Exception $e) {
        die('No se ha podido conectar: ' . $e->getMessage());
    }
    date_default_timezone_set('America/Asuncion');
    return $dbconn;
}




function closeConnection($dbconn)
{
    mysqli_close($dbconn);
}
