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
    //get post data to be submitted
    $type=$_GET["type"];
    $content=$_GET["content"];
    $attachment=$_GET["attachment"];
    $posted=date('Y/m/d H:i:s');
    //check the user has post permissions
    $query="SELECT * FROM followers WHERE page=$page AND member=".$_SESSION["userId"];
    $result=$conn->query($query);
    $row=$result->fetch_assoc();
    if($result->num_rows!=0&&$row["level"]!="reader") {
        $query="INSERT INTO posts (author,page,type,content,attachment,posted) VALUES (".$_SESSION["userId"].",$page,$type,$content,$attachment,$posted)";
        $result=$conn->query($query);
    }
    else {
        $_SESSION["permissionError"]=True;
    }
    //fetch page name
    $query="SELECT name FROM pages WHERE id=$page";
    $result=$conn->query($query);
    $row=$result->fetch_assoc();
    //return user to page
    header("Location: /thinkly/page?p=".$row["name"]);
    die();
?>
