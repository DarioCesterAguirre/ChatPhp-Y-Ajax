<?php
    class querys{
        public static function loginUser($pdo, $name, $password){
            $stmt = $pdo->prepare("SELECT * FROM usuario WHERE nombre = :name");
            $stmt->bindParam(':name', $name);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Si el usuario existe y la contraseña es correcta
            if ($user && password_verify($password, $user['contrasena'])) {
                return $user; // El login es exitoso
            } else {
                return false; // El login falla
            }
        }
        public static function findUserByName($pdo, $name){
            $stmt = $pdo->prepare("SELECT * FROM usuario WHERE nombre = :name");
            $stmt->bindParam(':name', $name);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            return $user;
        }

        public static function findUserById($pdo, $userid){
            $stmt = $pdo->prepare("SELECT * FROM usuario WHERE id = :userid");
            $stmt->bindParam(':userid', $userid);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            return $user;
        }

        public static function findIdUserConversation($pdo, $userid, $idConversation){
            $stmt = $pdo->prepare("SELECT id_usuario FROM usuario_conversacion 
                                   WHERE id_usuario != :userid AND id_conversacion = :id_conversacion");
            $stmt->bindParam(':userid', $userid);
            $stmt->bindParam(':id_conversacion', $idConversation);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            return $user;
        }

        public static function findUserProfilePhoto($pdo, $userid){
            $stmt = $pdo->prepare("SELECT fotoPerfil FROM usuario WHERE id = :userid");
            $stmt->bindParam(':userid', $userid);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;
        }

        public static function getUserConversations($pdo, $userId) {
            $stmt = $pdo->prepare("SELECT c.*
                                    FROM conversacion c
                                    JOIN usuario_conversacion uc ON c.id = uc.id_conversacion
                                    WHERE uc.id_usuario = :userId;");
            $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        

        public static function findConversation($pdo, $user1, $user2){
            $stmt = $pdo->prepare("SELECT id_conversacion
                                    FROM usuario_conversacion
                                    WHERE id_usuario IN (:user1, :user2)
                                    GROUP BY id_conversacion
                                    HAVING COUNT(DISTINCT id_usuario) = 2;");
            $stmt->bindParam(':user1', $user1);
            $stmt->bindParam(':user2', $user2);
            $stmt->execute();
            $conversation = $stmt->fetch(PDO::FETCH_ASSOC);
            return $conversation;
        }

        public static function createConversation($pdo, $user1, $user2){
            $pdo->beginTransaction();
            try{
                $userid = $user1;
                $user2 = querys::findUserByName($pdo, $user2);
                $userid2 = $user2['id'];
                $conversation = querys::findConversation($pdo, $userid, $userid2);
                if(!$conversation){
                    $stmt = $pdo->prepare("INSERT INTO conversacion VALUES (NULL);");
                    $stmt->execute();
                    $id = $pdo->lastInsertId();

                    $stmt = $pdo->prepare("INSERT INTO usuario_conversacion (id_usuario, id_conversacion) VALUES (:id_usuario1, :id_conversacion)");
                    $stmt->bindParam(':id_usuario1', $userid);
                    $stmt->bindParam(':id_conversacion', $id);
                    $stmt->execute();
                    
                    $stmt = $pdo->prepare("INSERT INTO usuario_conversacion (id_usuario, id_conversacion) VALUES (:id_usuario2, :id_conversacion)");
                    $stmt->bindParam(':id_usuario2', $userid2);
                    $stmt->bindParam(':id_conversacion', $id);
                    $stmt->execute();
                    $pdo->commit();
                    unset($_SESSION['userSearched']);
                    header('Location: ../index.php');
                    exit();
                }
                else{
                    $pdo->commit();
                    unset($_SESSION['userSearched']);
                    header('Location: ../index.php');
                    exit();
                }
            } catch (Exception $e) {
                // Si algo sale mal, revertimos la transacción
                $pdo->rollBack();
                throw $e;
                header('Location: ../index.php');
                exit();
            }
        }
        public static function allUserWithConversation($pdo, $user1, $user2){
            $stmt = $pdo->prepare("SELECT * FROM usuario WHERE user1 = :usuario1 AND usuario2 = :user2");
            $stmt->bindParam(':user1', $user1);
            $stmt->bindParam(':user2', $user2);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            return $user;
        }

        public static function findMesagges($pdo, $id_conversacion){
            $stmt = $pdo->prepare("SELECT * FROM mensajes WHERE id_conversacion = :id_conversacion");
            $stmt->bindParam(':id_conversacion', $id_conversacion);
            $stmt->execute();
            $user = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $user;
        } 

        public static function insertMessage($pdo, $user, $message, $id_conversation){
            $fechaActual = date('Y-m-d H:i:s');
            $stmt = $pdo->prepare("INSERT INTO mensajes (id, contenido, fecha, remitente, id_conversacion)
                                    VALUES (NULL, :message, :fecha, :userid, :id_conversation)");
            $stmt->bindParam(':message', $message);
            $stmt->bindParam(':userid', $user);
            $stmt->bindParam(':fecha', $fechaActual);
            $stmt->bindParam(':id_conversation', $id_conversation);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            return $user;
        }

        public static function updateProfile($pdo, $userid, $name, $description, $image){
            if (!empty($name)) {
                $stmt = $pdo->prepare("UPDATE usuario SET nombre = :nombre WHERE id = :id");
                $stmt->bindParam(':nombre', $name);
                $stmt->bindParam(':id', $userid);
                $nombreExiste = querys::findUserByName($pdo, $name);
                if($nombreExiste){
                    $_SESSION['nombreExiste'] = 'Este nombre de usuario ya existe, prueba con otro.';
                }
                else{
                    $stmt->execute();
                }
            }
        
            if (!empty($description)) {
                $stmt = $pdo->prepare("UPDATE usuario SET descripcion = :descripcion WHERE id = :id");
                $stmt->bindParam(':descripcion', $description);
                $stmt->bindParam(':id', $userid);
                $stmt->execute();
            }
        
            if ($image['error'] == 0) {
                try {
                    $contenidoImagen = file_get_contents($image['tmp_name']);            
                    $stmt = $pdo->prepare("UPDATE usuario SET fotoPerfil = :fotoPerfil WHERE id = :id");
                    $stmt->bindParam(':fotoPerfil', $contenidoImagen, PDO::PARAM_LOB);
                    $stmt->bindParam(':id', $userid);
                    $stmt->execute();
                } catch (PDOException $e) {
                    // Manejar la excepción
                    echo "Error al actualizar la imagen: " . $e->getMessage();
                    $_SESSION['imageError'] = 'La imagen ocupa demasiado.';
                }
            }

        }

        public static function blockUser($pdo, $userid, $useridBlock){
            $stmt = $pdo->prepare("INSERT INTO usuarios_bloqueados (id_usuario, id_usuario_bloqueado)
                                   VALUES (:id_usuario, :id_usuario_bloqueado);");
            $stmt->bindParam(':id_usuario', $userid);
            $stmt->bindParam(':id_usuario_bloqueado', $useridBlock);
            $stmt->execute();
        }

        public static function isBlocked($pdo, $userid, $useridBlock){
            $stmt = $pdo->prepare("SELECT * FROM usuarios_bloqueados WHERE id_usuario = :id_usuario AND id_usuario_bloqueado = :id_usuario_bloqueado;");
            $stmt->bindParam(':id_usuario', $userid);
            $stmt->bindParam(':id_usuario_bloqueado', $useridBlock);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }

        public static function blocked($pdo, $userid, $useridBlock){
            $stmt = $pdo->prepare("SELECT * FROM usuarios_bloqueados WHERE id_usuario = :id_usuario AND id_usuario_bloqueado = :id_usuario_bloqueado;");
            $stmt->bindParam(':id_usuario', $useridBlock);
            $stmt->bindParam(':id_usuario_bloqueado', $userid);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }

        public static function unblock($pdo, $userid, $useridBlock){
            $stmt = $pdo->prepare("DELETE FROM usuarios_bloqueados WHERE id_usuario = :id_usuario AND id_usuario_bloqueado = :id_usuario_bloqueado");
            $stmt->bindParam(':id_usuario', $userid);
            $stmt->bindParam(':id_usuario_bloqueado', $useridBlock);
            $stmt->execute();
        }
    }