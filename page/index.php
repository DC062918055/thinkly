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
        //inform the page that page does not exist
        echo "<h2>Oops. We can't seem to find what you're looking for.</h2>";
        echo "<p>The page might have been deleted, or we might not have a page named that.<br>But it's okay! <a href='/thinkly/?page=home'>Click here to go back to the main site.</a></p>";
        die();
    }
    //update page name to represent user
    echo "<script type='text/javascript'>document.title='$page';</script>";
    //otherwise, fetch page's information
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
    echo "<div class='column1'>";
    echo "<h2>a <a href='/thinkly/profile/?u=$ownerName'>$ownerName</a> creation</h2>";
    echo "<p>$description<br>$visits views.</p>";
    echo "</div>";
    echo "<div class='column2'>";
    echo "<div class='newsfeed'>";
    echo "<hr>";
    //begin printout of posts
    $query="SELECT * FROM posts WHERE page=$id ORDER BY posted DESC";
    $result=$conn->query($query);
    while($post=$result->fetch_assoc()) {
        $query="SELECT username FROM members WHERE id=".$post['author'];
        $results=$conn->query($query);
        $row=$results->fetch_assoc();
        echo "<div class='post'>";
        echo "<a href='/thinkly/profile/?u=".$row['username']."'><h4>".$row['username']."</h4></a>";
        $day=getDay(substr($post['posted'],8,2));
        $month=getMonth(substr($post['posted'],5,2));
        $time=substr($post['posted'],11,5);
        echo "<p class='date'>$day $month, at $time</p>";
        if($post['type']=="text") {
            echo "<p class='posttext'>".$post['content']."</p>";
        }
        echo "</div>";
    }
    echo "</div>";
    echo "</body>";
    echo "</html>";
    function getDay($day) {
        if($day==1||$day==21||$day==31) {
            $date=$day."st";
        }
        else if($day==2||$day==22) {
            $date=$day."nd";
        }
        else if($day==3||$day==23) {
            $date=$day."rd";
        }
        else {
            $date=$day."th";
        }
        return $date;
    }
    function getMonth($month) {
        if($month==1) {
           $date="January";
        }
        else if($month==2) {
           $date="February";
        }
        else if($month==3) {
           $date="March";
        }
        else if($month==4) {
           $date="April";
        }
        else if($month==5) {
           $date="May";
        }
        else if($month==6) {
           $date="June";
        }
        else if($month==7) {
           $date="July";
        }
        else if($month==8) {
           $date="August";
        }
        else if($month==9) {
           $date="September";
        }
        else if($month==10) {
           $date="October";
        }
        else if($month==11) {
           $date="November";
        }
        else {
            $date="December";
        }
        return $date;
    }
?>
