<?php
    //simple workaround for use for development on computers which don't have access to the MySQL database
    session_start();
    $_SESSION["userId"]="1";
    header("Location: /thinkly/?page=home");
    die();
?>
