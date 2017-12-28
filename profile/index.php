<?php
    //begin session
    session_start();
    //get user being searched
    $user=strip_tags($_GET["u"]);
    //check user has been entered
    if($user=="") {
        //redirect the user
        header("Location: /thinkly/?page=home");
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
    //connect to MySQL database
    include "/thinkly/assets/scripts/connect.php";
    //find username
    $query="SELECT * FROM members WHERE username='".$user."'";
    $result=$conn->query($query);
    if(!$result) {
        //inform the user that user does not exist
        echo "<h2>Oops. We can't seem to find who you're looking for.</h2>";
        echo "<p>The user may have deleted their account, or we might not have a user under that name.<br>But it's okay! <a href='/thinkly/?page=home'>Click here to go back to the main site.</a></p>";
    }
    //otherwise, fetch user's id
    $row=$result->fetch_assoc();
    $id=$row["id"];
    $forename=$row["forename"]+" ";
    $surname=$row["surname"];
    //fetch more information about user
    $query="SELECT * FROM profile WHERE id=''".$id."''";
    $result=$conn->query($query);
    $nickname="\""+$row["nickname"]+"\" ";
    $bio=$row["bio"];
    $birthday=$row["birthday"];
    $website=$row["website"];
    //generate user's name
    if($nickname!="\"\" ") {
        //concatenate names
        $name=$forename+$nickname+$surname;
    }
    //otherwise, exclude $nickname
    $name=$forename+$surname;
    //see if user has logged in
    if($_SESSION["userId"]=="") {
        //if not, display only basic information
        echo "<h1>$name on thinkly</h1>";
        echo "<h2>$user</h2>";
        echo "<p>$bio</p>";
        //prompt user to register
        echo "<p>To connect with and see $name's posts, <a href='/thinkly/?page=login'>join thinkly</a>.</p>";
    }
    echo "</div>";
    echo "</body>";
    echo "</html>";
?>
