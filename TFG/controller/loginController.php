<?php
    session_start();
    require '../db.php'; // Asegúrate de que este path sea correcto
    require_once '../model/querys.php';    
    // Comprueba si todos los campos requeridos están presentes
    if (isset($_POST['username']) && isset($_POST['pass']) && isset($_POST['loginSubmit'])) {
        $username = $_POST['username'];
        $pass = $_POST['pass'];
        $loginSuccess = querys::loginUser($pdo, $username, $pass);
        if($loginSuccess){
            $_SESSION['userid'] = $loginSuccess['id'];
            header("Location: ../index.php");
            exit();
        }
        else{
            $_SESSION['error'] = 'Los datos son incorrectos';
            header('Location: ../loginchatify.php');
            exit();
        }
    }
?>