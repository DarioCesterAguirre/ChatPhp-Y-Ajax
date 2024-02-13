<?php
    session_start();
    require '../db.php'; // Asegúrate de que este path sea correcto

    // Comprueba si se envió el formulario de registro
    if (isset($_POST['register'])) {
        // Comprueba si todos los campos requeridos están presentes
        if (isset($_POST['username'], $_POST['pass'], $_POST['email'])) {
            // Asigna los valores a variables
            $username = $_POST['username'];
            $password = $_POST['pass']; // Considera usar password_hash() para hashear la contraseña
            $email = $_POST['email'];

            // Prepara la sentencia SQL para insertar el nuevo usuario
            $sql = "INSERT INTO usuario (nombre, contrasena, correoElectronico, fotoPerfil) VALUES (:nombre, :contrasena, :correo, NULL)";
            $stmt = $pdo->prepare($sql);
            
            // Vincula los parámetros a la sentencia preparada
            $stmt->bindParam(':nombre', $username);
            $stmt->bindParam(':contrasena', password_hash($password, PASSWORD_DEFAULT)); // Hashea la contraseña
            $stmt->bindParam(':correo', $email);

            // Ejecuta la sentencia y comprueba si fue exitosa
            try {
                $stmt->execute();
                echo "Nuevo registro creado con éxito";
                // Redirecciona al usuario a una página de confirmación o al inicio de sesión
                header("Location: ../loginchatify.php"); // Cambia 'login.php' a la página deseada
                exit;
            } catch (PDOException $e) {
                // Si hay un error en la base de datos, por ejemplo, un duplicado
                if ($e->errorInfo[1] == 1062) {
                    // El correo electrónico o el nombre de usuario ya está registrado
                    $_SESSION['error'] = "El nombre de usuario o correo electrónico ya está registrado.";
                    header("Location: ../signUpChatify.php");
                    exit;
                } else {
                    // Otro tipo de error de base de datos
                    $_SESSION['error'] = "Error en la base de datos: " . $e->getMessage();
                    header("Location: ../signUpChatify.php");
                    exit;
                }
            }
        }
    } else {
        // El formulario no fue enviado con el botón de registro
        header("Location: ../signUpChatify.php");
        exit;
    }
?>
