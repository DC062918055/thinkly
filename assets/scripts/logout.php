<?php
    //access login session
    session_start();
    //remove all session values
    session_unset();
    //completely remove session
    session_destroy();
    //redirect to index
    header("Location: /thinkly/");
    die();
?>
