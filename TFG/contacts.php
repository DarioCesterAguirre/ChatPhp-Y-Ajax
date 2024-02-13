<?php
    session_start();
    require_once 'db.php';
    require_once 'model/querys.php';
    if (!isset($_SESSION['userid'])) {
		// Si no está establecida, redirige al usuario al login.php
		header("Location: loginChatify.php");
		exit(); // Asegúrate de que no se ejecute código adicional después de la redirección
	}
    $conversations = querys::getUserConversations($pdo, $_SESSION['userid']);;
		foreach($conversations as $conversation){
			$idConversation = $conversation['id'];
			$userid = querys::findIdUserConversation($pdo, $_SESSION['userid'], $idConversation)['id_usuario'];
			$user = querys::findUserById($pdo, $userid);
			$username = $user['nombre'];
			$hashImagen = md5(querys::findUserProfilePhoto($pdo, $userid)['fotoPerfil']);
			echo '<li class="contacts">
			<a href="controller/chatController.php?userid=' . $userid . '"><div class="d-flex bd-highlight">
				<div class="img_cont">
					<img src="image.php?userid=' . $userid .  '&hash=' . $hashImagen . '" loading="lazy" class="rounded-circle user_img">
				</div>
				<div class="user_info">
					<span>' . $username . '</span>
				</div>
			</div><a/>
			</li><hr id="hrcontact"/>';
		}