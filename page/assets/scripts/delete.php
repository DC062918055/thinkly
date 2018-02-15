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
    echo $pass;
    //get pagename and owner before delete
    $query="SELECT * FROM pages WHERE id=$page";
    $result=$conn->query($query);
    $row=$result->fetch_assoc();
    $name=$row["name"];
    //check user is trying to delete their page
    if($_SESSION["userId"]==$row["owner"]) {
        //fetch password
        $query="SELECT * FROM members WHERE id=".$_SESSION["userId"];
        $result=$conn->query($query);
        $row=$result->fetch_assoc();
        //check is correct
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
            header("Location: /thinkly/page/?p=$name");
            die();
        }
    }
    header("Location: /thinkly/page/");
    die();
?>
