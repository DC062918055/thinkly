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
    //get page to be followed
    $page=strip_tags($_GET["p"]);
    //check the user does not already follow the page
    $query="SELECT * FROM followers WHERE page=$page AND member=".$_SESSION["userId"];
    $result=$conn->query($query);
    if($result->num_rows==0) {
        //if not, insert user's name into table
        $query="INSERT INTO followers (page,member,level) VALUES ('$page','".$_SESSION["userId"]."','reader')";
        $result=$conn->query($query);
    }
    //fetch page name
    $query="SELECT name FROM pages WHERE id=$page";
    $result=$conn->query($query);
    $row=$result->fetch_assoc();
    //return user to page
    header("Location: /thinkly/page?p=".$row["name"]);
    die();
?>
