<?php 
session_start();
require_once 'db.php';
require_once 'model/querys.php';
if (!isset($_SESSION['userid'])) {
    // Si no está establecida, redirige al usuario al login.php
    header("Location: loginChatify.php");
    exit(); // Asegúrate de que no se ejecute código adicional después de la redirección
}
if(isset($_SESSION['conversation'])){
    $hashImagen = md5(querys::findUserProfilePhoto($pdo, $_SESSION['user']['id'])['fotoPerfil']);
    $user = querys::findUserById($pdo, $_SESSION['user']['id']);
    $nombre = $user['nombre'];
	if(isset($_SESSION['user'])){
        echo '<div class="col-md-8 col-xl-6 chat h-100">
            <div class="card h-100">	
                <div class="card-header msg_head">
                    <div id="divProfile" class="d-flex bd-highlight">
                    <a href="profile.php?userprofile=1" class="d-flex fotoAumentada">
                    <div class="img_cont">
                    <img src="image.php?userid=' . $_SESSION['user']['id'] . '&hash=' . $hashImagen . '" class="rounded-circle user_img ">
            </div>
            <div class="user_info">
            <span>' .  $nombre . '</span>
        </div>
        </a>';}}