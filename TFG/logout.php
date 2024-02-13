<?php
    session_start();
    session_unset();
    session_destroy();
    header('Location: chatify.html');
    exit;
