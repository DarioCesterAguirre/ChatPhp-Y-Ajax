<?php
$host = 'localhost'; // o 'localhost'
$db   = 'chatify';
$user = 'root'; // El usuario predeterminado para MySQL es 'root'
$password = ''; // La contraseña predeterminada es una cadena vacía
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
try {
     $pdo = new PDO($dsn, $user, $password);
} catch (\PDOException $e) {
     throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
?>
