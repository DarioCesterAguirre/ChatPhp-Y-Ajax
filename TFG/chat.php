<?php
    session_start();
    require_once 'db.php';
    require_once 'model/querys.php';
    if (!isset($_SESSION['userid'])) {
        // Si no está establecida, redirige al usuario al login.php
        header("Location: login.php");
        exit(); // Asegúrate de que no se ejecute código adicional después de la redirección
    }
    if(isset($_SESSION['conversation'])){
        $idConversation = $_SESSION['conversation'];
        $messages = querys::findMesagges($pdo, $idConversation);
        foreach($messages as $message){
            $horaYMinutos = date('d-m-Y H:i', strtotime($message['fecha']));
            if($message['remitente'] == $_SESSION['userid']){
                echo '<div class="d-flex justify-content-end mb-9">											
                    <div class="msg_cotainer_send">' . $message['contenido'] .
                        '<span class="msg_time_send">' . $horaYMinutos . '</span>
                    </div>
                </div>';
                
            }
            else{
                echo '<div class="d-flex justify-content-start mb-9">
                    <div class="msg_cotainer">' . $message['contenido'] .													
                        '<span class="msg_time">' . $horaYMinutos .'</span>
                    </div>
                </div>';
            }										
        }
    }
    
