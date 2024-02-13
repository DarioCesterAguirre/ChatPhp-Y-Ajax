<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="css/chatify.css">
  </head>
  <body>
</head>
<body>
    <div class="container-fluid">
        <div class="row h-100 justify-content-center align-items-center" style="min-height: 90vh;">
            <div class="col-10 col-sm-8 col-md-7 col-lg-4">
                <div class="card bg-dark">
                    <div class="card-body">
                        <a href="chatify.html" type="button" class="btn-close btn-close-white" aria-label="Close"></a>
                        <img src="images/Logo.jpeg" alt="Logo" class="img-fluid  w-25 mx-auto d-block">
                        <h3 class="card-title text-center mb-5 mt-4 text-white">Inicia Sesión en chatify</h3>
                        <form action="controller/loginController.php" method="POST">
                            <div class="mb-4">
                                <label for="username" class="form-label text-white">Nombre de usuario</label>
                                <i class="fas fa-user text-white"></i>
                                <input type="text" class="form-control" id="username" name="username" placeholder="Usuario" required>
                            </div>
                            <div class="mb-4">
                                <label for="password" class="form-label text-white">Contraseña</label>
                                <i class="fas fa-lock text-white"></i>
                                <input type="password" class="form-control" id="password" name="pass" placeholder="Contraseña" required>
                            </div>
                            <?php
                            if(isset($_SESSION['error'])){
                                echo '<p class="text-white">' . $_SESSION['error'] . '</p>';
                                unset($_SESSION['error']);
                            }
                            ?>
                            <div class="text-center">
                                <button type="submit" name="loginSubmit" class="btn btn-primary w-75 rounded-pill mt-4 mb-4">Entrar</button>        
                            </div>                 
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center mt-4">
            <p class="mb-0 text-white">&copy; 2024 Chatify Desarrollado por Darío Cester Aguirre</p>
        </div> 
    </div>
</body>
</html>