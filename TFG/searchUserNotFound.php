<?php
    session_start();
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
		<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
		<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.js"></script>
		<link rel="stylesheet" type="text/css" href="css/plantilla.css">
	</head>
	<!--Coded With Love By Mutiullah Samim-->
	<body>
    <div class="container-fluid h-100">
        <div class="row justify-content-center h-100">
            <div class="col-md-8 col-xl-6 chat h-50">
                <div class="card h-100">
                    <div class="card-header msg_head">
                    <h3 class='text-center text-white mt-4 mb-2'>El nombre no coincide con ningún usuario.</h3>
                    </div>
                    <div id="chat-body" class="card-body msg_card_body d-flex flex-column align-items-center overflow-hidden">
    
                    </div>
                    <div class="card-footer">
                        <form class="d-flex justify-content-center" action="index.php" method="POST">
                            <button type="submit" class="btn btn-secondary btn-lg">VOLER AL CHAT</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </body>
</html>