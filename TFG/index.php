<?php
	session_start();
	require_once 'db.php';
	require_once 'model/querys.php';
	if (!isset($_SESSION['userid'])) {
		// Si no está establecida, redirige al usuario al login.php
		header("Location: loginchatify.php");
		exit(); // Asegúrate de que no se ejecute código adicional después de la redirección
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Chat</title>
		<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
		<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>

		<!-- Otros enlaces y scripts -->
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
		<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.js"></script>
		<link rel="stylesheet" type="text/css" href="css/plantilla.css">
		<script type="text/javascript" src="plantilla.js"></script>

		<!-- Tu script Ajax -->
		<script type="text/javascript" src="ajax.js"></script>
	</head>
	<!--Coded With Love By Mutiullah Samim-->
	<body>
		<div class="container-fluid h-100">
			<div class="row justify-content-center h-100">
				<div class="col-md-4 col-xl-3 chat h-100">
					<div class="card mb-sm-3 mb-md-0 contacts_card h-100">
					<form class="card-header" action="controller/chatController.php" method="POST">
						<div class="input-group">
							<input type="text" name="userSearched" placeholder="Buscar usuario" class="form-control search">
							<div class="input-group-prepend">
								<button type=submit name="searchUser" class="input-group-text search_btn"><i class="fas fa-search"></i></button>
							</div>
						</div>
					</form>
					<div class="card-body contacts_body">
						<ui id="contactsList" class="contacts">
						
						</ui>
					</div>
					
					<form id="logout" action="logout.php" method="POST" class="card-footer footer_contacts">
						<button class="logout-button"><i class="fas fa-sign-out-alt"></i>Cerrar Sesión</button>
					</form>
				</div></div>
				<?php if(isset($_SESSION['conversation'])){
					$hashImagen = md5(querys::findUserProfilePhoto($pdo, $_SESSION['user']['id'])['fotoPerfil']);
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
									<span>' . $_SESSION['user']['nombre'] . '</span>
								</div>
								</a>
								</div>
								<span id="action_menu_btn"><i class="fas fa-ellipsis-v"></i></span>
								<div class="action_menu">
									<ul>
										<li><i class="fas fa-user-circle"></i><a href="profile.php?profile=1" class="text-white text-decoration-none">Tu perfil</a></li>
										<li><i class="fas fa-ban"></i><a href="controller/chatController.php?block=1" class="text-white text-decoration-none">Bloquear usuario</a></li>
									</ul>
								</div>
							</div>
						
						<div id="chat" class="card-body msg_card_body">
							
						</div> 
							<div class="card-footer">
								<form id="messageForm" class="input-group" method="POST">
									
									<input id="messageInput" type="text" name="message" class="form-control type_msg" placeholder="Escribe tu mensaje..."></input>
									<div class="input-group-append">
										<button id="enviar" type="submit" name="messageSubmit" class="input-group-text send_btn"><i class="fas fa-location-arrow"></i></button>
									</div>
								</form>
							</div>';
							}
					}
					elseif(isset($_SESSION['isblocked'])){
						echo '<div class="card-body col-md-8 col-xl-6 mt-1 text-center chat h-75">
							<img id="imagen" src="images/ImagenDesbloquear.jpeg" class="img-fluid" alt="">
							<a href="controller/chatController.php?unblock=1" class="btn btn-success btn-lg mt-5">DESBLOQUEAR</a>
							<div id="chat" style="display:none;">
							</div>
						</div>';
					}
					else if(isset($_SESSION['blocked'])){
						echo '<div class="col-md-8 col-xl-6 chat h-100">
							<img id="imagen" src="images/ImagenBloqueado2.jpeg" class="img-fluid" alt="">
							<div id="chat" style="display:none;">
							</div>
						</div>';
					}
					else{
						echo '<div class="col-md-8 col-xl-6 chat h-100">
						
						<img id="imagen" src="images/ChatifyFondo.jpeg" class="img-fluid" alt="">
							<div id="chat" style="display:none;">
							</div>
						</div>';
					} ?>
					</div>
				</div>
			</div>
		</div>

	</body>
</html>