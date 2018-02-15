<?php
    //begin session
    session_start();
    //connect to the MySQL server
    $address="localhost";
    $username="login";
    $password="N3ufNzUZW15qDDk8";
    $name="thinkly";
    $conn=new mysqli($address,$username,$password,$name);
    if($conn->connect_error) {
        die();
    }
    //get AJAX details
    $page=$_POST["page"];
    $submit=$_POST["submit"];
    $user=$_POST["username"];
    $level=$_POST["level"];
    //fetch user's id
    $query="SELECT id FROM members WHERE username='$user'";
    $result=$conn->query($query);
    $row=$result->fetch_assoc();
    $id=$row["id"];
    echo $id;
    //check user is user
    if($submit==$_SESSION["userId"]) {
        //then, check that user has permission
        $query="SELECT level FROM followers WHERE member=$submit AND page=$page";
        $result=$conn->query($query);
        $row=$result->fetch_assoc();
        if($row["level"]=="admin"||$row["level"]=="owner") {
            //finally check user has permission to set permission
            if($row["level"]=="admin"&&$level!="admin") {
                $query="UPDATE followers SET level='$level' WHERE member=$id AND page=$page";
                $conn->query($query);
                die();
            }
            else if($row["level"]=="owner") {
                $query="UPDATE followers SET level='$level' WHERE member=$id AND page=$page";
                $conn->query($query);
                die();
            }
        }
    }
    //if not happened, something has gone wrong client side - this was not accidental, terminate
    die();
?>
