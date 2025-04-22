<?php
//llama a las variables de entorno como requisito para que funcione el codigo
$config = require __DIR__ . '/../.env.php';
//el "." es para la concatenacion de cadenas. En este caso = __DIR__ + '/.env.php'
/* __DIR__ = ruta absoluta
$config = C:\xampp\htdocs\nexus/.env.php */

$server = $config['DB_HOST'];
$database = $config['DB_NAME'];
$username = $config['DB_USER'];
$password = $config['DB_PASSWORD'];

//CONEXION CON LA BASE DE DATOS CON POO
$mysqli = new mysqli($server, $username, $password, $database);

//verificacion de conexion
if($mysqli->connect_error){
    die("Conexión fallida: " . $mysqli->connect_error);
}
//die = mata el script