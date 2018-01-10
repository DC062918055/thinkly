<?php
    //begin session
    session_start();
    //get page being searched
    $page=strip_tags($_GET["p"]);
    //check page has been entered
    if($page=="") {
        //redirect the user
        header("Location: /thinkly/?page=home");
        die();
    }
    //connect to the MySQL server
    $address="localhost";
    $username="login";
    $password="N3ufNzUZW15qDDk8";
    $name="thinkly";
    $conn=new mysqli($address,$username,$password,$name);
    if($conn->connect_error) {
        die();
    }
    //start HTML printout
    echo "<!DOCTYPE html>";
    echo "<html>";
    echo "<head>";
    //set title in browser navigation bar
    echo "<title>thinkly</title>";
    //import fonts from Google, Noto Sans and Serif
    echo "<link href='https://fonts.googleapis.com/css?family=Noto+Sans|Noto+Serif' rel='stylesheet' />";
    //place the favicon in the navigation bar
    echo "<link rel='icon' type='image/png' href='/thinkly/assets/favicon.png' />";
    //import stylesheet
    echo "<link rel='stylesheet' type='text/css' href='assets/style.css'>";
    echo "</head>";
    echo "<body>";
    echo "<div class='content' id='contentDisplay'></div>";
    echo "<div class='content' id='contentBox'>";
    //find page
    $query="SELECT * FROM pages WHERE name='$page'";
    $result=$conn->query($query);
    if($result->num_rows==0) {
        //inform the user that user does not exist
        echo "<h2>Oops. We can't seem to find what you're looking for.</h2>";
        echo "<p>The page might have been deleted, or we might not have a page named that.<br>But it's okay! <a href='/thinkly/?page=home'>Click here to go back to the main site.</a></p>";
        die();
    }
    //update page name to represent user
    echo "<script type='text/javascript'>document.title='$page';</script>";
    //otherwise, fetch user's information
    $row=$result->fetch_assoc();
    $id=$row["id"];
    $owner=$row["owner"]; //this will be fetched from members table
    $description=$row["description"];
    $img=$row["picture"];
    //set background image, if provided
    if($img) {
        echo "<script type='text/javascript'>document.body.style.backgroundImage=url('/thinkly/images/$img');</script>";
    }
    $visits=$row["visits"]+1;
    //send new number of visits to database
    $query="UPDATE pages SET visits=$visits WHERE id=$id";
    $conn->query($query);
    $query="SELECT username FROM members WHERE id=$owner";
    $result=$conn->query($query);
    $row=$result->fetch_assoc();
    $ownerName=$row["username"];
    //start displaying page data
    echo "<h1>$page</h1>";
    echo "<h2>a <a href'/thinkly/profile/?u=$ownerName'>$ownerName</a> creation</h2>";
    echo "<p>$description<br>$views views.</p>"
    echo "</div>";
    echo "</body>";
    echo "</html>";
?>
