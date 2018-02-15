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
    //get entered name
    $page=$_POST["pagename"];
    //fetch page name
    $query="SELECT * FROM pages WHERE name=$page";
    $result=$conn->query($query);
    //check page name is not in use
    if($result->num_rows==0) {
        //if not, create page
        $query="INSERT INTO pages (owner,name) VALUES (".$_SESSION["userId"].",'$page')";
        $conn->query($query);
        $query="SELECT id FROM pages WHERE name='$page'";
        $result=$conn->query($query);
        $row=$result->fetch_assoc();
        $id=$row["id"];
        $query="INSERT INTO followers (member,page,level) VALUES (".$_SESSION["userId"].",$id,'owner')";
        $conn->query($query);
        //go to page
        header("Location: /thinkly/page/?p=$page");
        die();
    }
    else {
        //if is, alert session
        $_SESSION["pageTaken"]=True;
        header("Location: /thinkly/page");
        die();
    }
?>
