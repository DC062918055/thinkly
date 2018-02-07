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
    $user=strip_tags($_GET["u"]);
    //get profile data to be updated
    $nickname=$_POST["nickname"];
    $bday=$_POST["year"]."-".$_POST["month"]."-".$_POST["day"];
    $bio=$_POST["bio"];
    $website=$_POST["website"];
    //check user is the user
    if($_SESSION["userId"]==$user) {
        //if so, update their profile
        $query="UPDATE profile SET nickname='$nickname',bio='$bio',birthday='$bday',website='$website' WHERE id=$user";
        $conn->query($query);
    }
    //fetch username
    $query="SELECT username FROM members WHERE id=$user";
    $result=$conn->query($query);
    $row=$result->fetch_assoc();
    //if not, ignore - presume this is a mistake and return user to same page
    header("Location: /thinkly/profile/?u=".$row["username"]);
    die();
?>
