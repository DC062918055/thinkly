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
    //get email
    $email=$_POST["newemail"];
    //check user is the user
    if($_SESSION["userId"]==$user) {
        //if so, update the email
        $query="UPDATE members SET email='$email' WHERE id=$user";
        $conn->query($query);
    }
    //return user to profile page
    $query="SELECT username FROM members WHERE id=$user";
    header("Location: /thinkly/profile/?u=$user");
    die();
?>
