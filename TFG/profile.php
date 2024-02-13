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
	</head>
	<body>
	<div class="container">
      <div class="row align-items-center" style="min-height: 90vh;">
        <div class="card " style="width: 100rem;">
		<?php 
			$edit = false;
			if(isset($_GET['userprofile'])){
				$userId = $_SESSION['user']['id'];
				$user = querys::findUserById($pdo, $userId);
				$name = $user['nombre'];
				$description = $user['descripcion'];
				if($description == ''){
					$description = "Este usuario no tiene una descripción aún.";
				}
			}
			else{
				$user = querys::findUserById($pdo, $_SESSION['userid']);
				$userId = $_SESSION['userid'];
				$name = $user['nombre'];
				$description = $user['descripcion'];
				if($description == ''){
					$description = "Añade una descripción para que el resto de usuarios sepa más de ti.";
				}
				$edit = true;
			}?>
		<h3 class="card-title text-center mt-4 text-white"><?php echo $name?></h3>
		<!-- Contenido de la tarjeta -->
		<div class="card-body msg_card_body d-flex flex-column align-items-center overflow-hidden">
			<img src="image.php?userid=<?php echo $userId?>" class="rounded-circle" alt="Image" style="max-height: 50%;">
			<p class="card-text mt-3"><?php echo $description?></p>
			<?php
			if(isset($_SESSION['nombreExiste'])){
				echo '<p class="text-white">' . $_SESSION['nombreExiste'] . '</p>';
				unset($_SESSION['nombreExiste']);
			}
			if (isset($_SESSION['updateError'])) {
				echo '<p class="text-white">' . $_SESSION['updateError'] . '</p>';
				unset($_SESSION['updateError']);
			}
			if (isset($_SESSION['imageError'])) {
				echo '<p class="text-white">' . $_SESSION['imageError'] . '</p>';
				unset($_SESSION['imageError']);
			}?>
			
		</div>
		<div class="card-footer d-flex justify-content-center">
			<?php 
			if($edit == true){
				echo '<a href="editProfile.php" class="btn btn-primary mr-4">Editar Perfil</a>';
			}
			?>
			<a href="index.php" class="btn btn-secondary">Cerrar</a>
		</div>
      </div>
	  </div>
	</div>

	</body>
</html>