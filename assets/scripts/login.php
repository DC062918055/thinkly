<?php
    //begin login session, initalise login variables
    session_start();
    $_SESSION["incorrect"]="";
    $_SESSION["blank"]="";
    //connect to MySQL database, using external server
    include "connect.php";
    //fetch enetered details
    $user=$_POST["username"];
    $pass=$_POST["password"];
    //check the submitted details are not blank
    if($user==""||$pass=="") {
        //if so, inform session and return user to login page
        $_SESSION["blank"]=True;
        header("Location: /?page=login");
        die();
    }
    //query database to fetch details from username entered
    $query="SELECT * FROM users WHERE username='".$user."'";
    $result=$conn->query($query);
    //check if username is in database
    if($result) {
        //if so, verify password
        $row=$result->fetch_assoc();
        if(password_verify($pass,$row["password"])) {
            //if correct password, inform session and redirect to homepage
            $_SESSION["userId"]=$row["id"];
            header("Location: /?page=home");
            die();
        }
        else {
            //otherwise, inform session of incorrect password and return user to login
            $_SESSION["incorrect"]=True;
            header("Location: /?page=login");
            die();
        }
    }
    else {
        //otherwise, inform user of incorrect username
        $_SESSION["incorrect"]=True;
        header("Location: /?page=login");
        die();
    }
?>
