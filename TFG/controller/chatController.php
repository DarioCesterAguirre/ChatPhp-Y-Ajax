<?php
    session_start();
    require '../db.php'; // Asegúrate de que este path sea correcto
    require_once '../model/querys.php';
    
    if (isset($_POST['userSearched']) && isset($_POST['searchUser'])) {
        $userSearched = $_POST['userSearched'];
        $user = querys::findUserByName($pdo, $userSearched);
        if($user){
            $_SESSION['userSearched'] = $userSearched;
            header('Location: ../searchUserFound.php');
        }
        else{
            header('Location: ../searchUserNotFound.php');
        }
    }

    if (isset($_POST['userSearched']) && isset($_POST['searchUser'])) {
        $userSearched = $_POST['userSearched'];
        $user = querys::findUserByName($pdo, $userSearched);
        if($user){
            $_SESSION['userSearchedId'] = $user['id'];
            $_SESSION['userSearched'] = $userSearched;
            header('Location: ../searchUserFound.php');
        }
        else{
            header('Location: ../searchUserNotFound.php');
        }
    }

    if (isset($_POST['startChat'])) {
        $userid = $_SESSION['userid'];
        $userSearched = $_SESSION['userSearched'];
        $conversation = querys::createConversation($pdo, $userid, $userSearched);
    }

    if (isset($_GET['userid'])) {
        unset($_SESSION['user']);
        unset($_SESSION['messages']);
        unset($_SESSION['conversation']);
        unset($_SESSION['isblocked']);
        unset($_SESSION['blocked']);
        $userid = $_GET['userid'];
        $userLogin = $_SESSION['userid'];
        $user = querys::findUserById($pdo, $userid);
        $_SESSION['user'] = $user;
        $isblocked = querys::isBlocked($pdo, $userLogin, $userid);
        $blocked = querys::blocked($pdo, $userLogin, $userid);
        if($isblocked){
            $_SESSION['isblocked'] = 'isblocked';
        }
        else if($blocked){
            $_SESSION['blocked'] = 'blocked';
        }
        else{
            $user = querys::findUserById($pdo, $userid);
            $idConversation = querys::findConversation($pdo, $userid, $userLogin)['id_conversacion'];
            $messages = querys::findMesagges($pdo, $idConversation);
            $_SESSION['user'] = $user;
            $_SESSION['conversation'] = $idConversation;
            $_SESSION['messages'] = $messages;
        }
        header('Location: ../index.php');
    }

    if (isset($_POST['message'])) {
        $userid = $_SESSION['userid'];
        $idConversation = $_SESSION['conversation'];
        $message = $_POST['message'];
        if($message == ''){
            exit;
        }
        else{
            $insertMessage = querys::insertMessage($pdo, $userid, $message, $idConversation);
            exit;
        }
    }

    if (isset($_POST['editSubmit'])) {
        $userid = $_SESSION['userid'];
        $name = $_POST['name'];
        $description = $_POST['description'];
        $image = $_FILES['image'] ?? null;
        $updateData = querys::updateProfile($pdo, $userid, $name, $description, $image);
        header('Location: ../profile.php');
    }

    if (isset($_GET['profile'])) {
        $userLogin = $_SESSION['userid'];
        $user = querys::findUserById($pdo, $userLogin);
        header('Location: ../index.php');
    }

    if (isset($_GET['block'])) {
        $userLogin = $_SESSION['userid'];
        $userBlock = $_SESSION['user']['id'];
        $user = querys::blockUser($pdo, $userLogin, $userBlock);
        header('Location: ../index.php');
    }

    if (isset($_GET['unblock'])) {
        $userLogin = $_SESSION['userid'];
        $userBlock = $_SESSION['user']['id'];
        $user = querys::unblock($pdo, $userLogin, $userBlock);
        header('Location: ../index.php');
        exit();
    }
?>