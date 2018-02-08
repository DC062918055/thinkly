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
    //get user's id as extra level of security
    $page=strip_tags($_GET["p"]);
    //get password entered
    $pass=$_POST["delete"];
    //get username before delete
    $query="SELECT name FROM pages WHERE id=$page";
    $result=$conn->query($query);
    $row=$result->fetch_assoc();
    //check user is trying to delete their page
    if($_SESSION["userId"]==$user) {
        //check their password is correct
        if(password_verify($pass,$row["password"])) {
            //seems as if they are deleting, proceed
            $query="DELETE FROM pages WHERE id=$page";
            $conn->query($query);
            $query="DELETE FROM posts WHERE page=$page";
            $conn->query($query);
            $query="DELETE FROM followers WHERE page=$page";
            $conn->query($query);
        }
        else {
            //if password incorrect, alert session and give user opportunity to retry
            $_SESSION["incorrect"]="delete";
            header("Location: /thinkly/profile/?u=".$row["username"]);
            die();
        }
    }
    header("Location: /thinkly/");
    die();
?>
