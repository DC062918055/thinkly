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
    //get page to be unfollowed
    $page=strip_tags($_GET["p"]);
    //check the user does follow the page
    $query="SELECT * FROM followers WHERE page=$page AND member=".$_SESSION["userId"];
    $result=$conn->query($query);
    if($result->num_rows!=0) {
        //if not, delete user's name from table
        $query="DELETE FROM followers WHERE page=$page AND member=".$_SESSION["userId"];
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
