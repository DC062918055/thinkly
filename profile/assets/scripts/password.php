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
    $user=strip_tags($_GET["u"]);
    //get passwords entered
    $original=$_POST["original"];
    $pass=password_hash($_POST["newpass"],PASSWORD_DEFAULT);
    $query="SELECT * FROM members WHERE id='$user'";
    $result=$conn->query($query);
    $row=$result->fetch_assoc();
    //check user is the user
    if($_SESSION["userId"]==$user) {
        //then, check a valid password was entered
        if(password_verify($original,$row["password"])) {
            //if so, update their password
            $query="UPDATE members SET password='$pass' WHERE id=$user";
            $conn->query($query);
        }
        else {
            //otherwise, inform session of invalid password
            $_SESSION["incorrect"]="password";
        }
    }
    header("Location: /thinkly/profile/?u=".$row["username"]);
    die();
?>
