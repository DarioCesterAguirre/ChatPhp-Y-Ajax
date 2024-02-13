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
		
	</head>
	<!--Coded With Love By Mutiullah Samim-->
	<body>
<div class="container">
    <div class="row align-items-center" style="min-height: 90vh;">
        <div class="card " style="width: 100rem;">
        <?php 
            $user = querys::findUserById($pdo, $_SESSION['userid']);
            $userId = $_SESSION['userid'];
            $name = $user['nombre'];
            $description = $user['descripcion'];
            if($description == ''){
                $description = "Añade una descripción para que el resto de usuarios sepa más de ti.";
            }	
        ?>
            <h3 class="card-title text-center mb-5 mt-4 text-white">
                <span contenteditable="true" id="editableName"><?php echo $name; ?></span>
                <i class="fas fa-edit text-white"></i>
            </h3>
                
            <!-- Contenido de la tarjeta -->
            <div class="card-body msg_card_body d-flex flex-column align-items-center overflow-hidden">
                
                <img src="image.php?userid=<?php echo $userId?>" class="img-fluid rounded-circle mb-3 editImage" id="imagePreview" alt="Image" style="max-height: 50%;">
                <i class="fas fa-edit text-white"></i>
                <p class="card-text mt-3">
                    <span contenteditable="true" id="editableDescription"><?php echo $description?></span>
                    <i class="fas fa-edit text-white"></i>
                </p>                 
            </div>
            <div class="card-footer d-flex justify-content-center">
                <form action="controller/chatController.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="name" id="hiddenName">
                    <input type="hidden" name="description" id="hiddenDescription">
                    <input type="file" id="fileInput" name="image" style="display: none;">
                    <input type="submit" class="btn btn-primary ml-2" name="editSubmit" value="Guardar Cambios">
                    <a href="profile.php" class="btn btn-secondary ml-2">Cancelar</a>
                </form>
            </div>
            
        </div>
    </div>
</div>

	</body>
    <script>
    document.getElementById('editableName').addEventListener('input', function() {
    document.getElementById('hiddenName').value = this.textContent;
    });

    document.getElementById('editableDescription').addEventListener('input', function() {
        document.getElementById('hiddenDescription').value = this.textContent;
    });
    document.getElementById('imagePreview').addEventListener('click', function() {
        document.getElementById('fileInput').click();
    });

    // Escucha el evento 'change' del input de tipo file
    document.getElementById('fileInput').addEventListener('change', function(event) {
        var file = event.target.files[0]; // Obtiene el archivo
        var reader = new FileReader();

        // Cuando el archivo se haya leído...
        reader.onload = function(e) {
            // Actualiza el atributo 'src' de tu imagen con el contenido del archivo
            document.getElementById('imagePreview').src = e.target.result;
        };

        // Lee el archivo como una URL de datos
        reader.readAsDataURL(file);
    });

</script>

</html>

