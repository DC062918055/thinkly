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
    //get page to be posted to
    $page=strip_tags($_GET["p"]);
    //get post data to be submitted
    $description=$_POST["description"];
    //fetch page name
    $query="SELECT name FROM pages WHERE id=$page";
    $result=$conn->query($query);
    $row=$result->fetch_assoc();
    $pagename=$row["name"];
    //check the user has post permissions
    $query="SELECT * FROM followers WHERE page=$page AND member=".$_SESSION["userId"];
    $result=$conn->query($query);
    $row=$result->fetch_assoc();
    if($result->num_rows!=0&&$row["level"]!="reader") {
        $query="UPDATE pages SET description='$description' WHERE id=$page";
        $conn->query($query);
    }
    else {
        $_SESSION["permissionError"]=True;
    }
    //return user to page
    header("Location: /thinkly/page?p=$pagename");
    die();
?>
