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
                    <?php
                        if (isset($_SESSION['userSearched'])) {
                            $useridFound = $_SESSION['userSearchedId'];
                            $name = $_SESSION['userSearched'];
                            $userid = $_SESSION['userid'];
                            $useridFound = $_SESSION['userSearchedId'];
                            if($userid != $useridFound){
                                echo "<h3 class='text-center text-white mt-4 mb-2'>Empieza tu conversación con " . $name . "</h3>";
                            }
                            else{
                                echo "<h3 class='text-center text-white mt-4 mb-2'>Asi te ven el resto de usuarios " . $name . "</h3>";
                            } 
                            
                        }
                        ?>
                    </div>
                    <div id="chat-body" class="card-body msg_card_body d-flex flex-column align-items-center overflow-hidden">
                        <img src="image.php?userid=<?php echo $useridFound?>" class="img-fluid rounded-circle mx-auto d-block my-auto" alt="Image" style="max-height: 100%;">
                    </div>
                    <div class="card-footer d-flex justify-content-center">
                        <?php 
                             if($userid != $useridFound){
                                echo '<form action="controller/chatController.php" method="POST">
                                <button type="submit" name="startChat" class="btn btn-success btn-lg" style="margin-right: 10%;">INICIAR CHAT</button>
                            </form>
                            <a href="index.php"><button type="submit" class="btn btn-secondary btn-lg" style="margin-left: 10%;">VOLER AL CHAT</button></a>';
                            }
                            else{
                                echo '<a href="index.php"><button type="submit" class="btn btn-secondary btn-lg">VOLER AL CHAT</button></a>';
                            } 
                        ?>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    </body>
</html>