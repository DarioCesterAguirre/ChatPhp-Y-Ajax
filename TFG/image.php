<?php
session_start();
require 'db.php';
require 'model/querys.php';

if (!isset($_SESSION['userid'])) {
    // Si no está establecida, redirige al usuario al login.php
    header("Location: loginchatify.php");
    exit(); // Asegúrate de que no se ejecute código adicional después de la redirección
}

$userid = $_GET['userid'];
$result = querys::findUserProfilePhoto($pdo, $userid);

// Verifica si se obtuvo un resultado y si fotoPerfil no es NULL ni cadena vacía
if ($result && !empty($result['fotoPerfil'])) {
    // Si se encuentra una foto de perfil y no está vacía, envía los datos de la imagen
    $contenidoImagen = $result['fotoPerfil'];
    $hashImagen = md5($contenidoImagen);
    $imageData = getimagesizefromstring($result['fotoPerfil']);
    header('Content-Type: ' . $imageData['mime']);
    echo $contenidoImagen;
} else {
    // Si no hay foto de perfil, envía la imagen predeterminada
    $defaultImage = 'images/DefaultPhoto.png';
    $hashImagen = md5_file($defaultImage); 
    $imageData = getimagesize($defaultImage);
    header('Content-Type: ' . $imageData['mime']);
    readfile($defaultImage);
}
?>
