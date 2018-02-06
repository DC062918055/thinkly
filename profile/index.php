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
    //find username
    $query="SELECT id, forename, surname FROM members WHERE username='$user'";
    $result=$conn->query($query);
    if($result->num_rows==0) {
        //inform the user that user does not exist
        echo "<h2>Oops. We can't seem to find who you're looking for.</h2>";
        echo "<p>The user may have deleted their account, or we might not have a user under that name.<br>But it's okay! <a href='/thinkly/?page=home'>Click here to go back to the main site.</a></p>";
        die();
    }
    //update page name to represent user
    echo "<script type='text/javascript'>document.title='$user on thinkly';</script>";
    //otherwise, fetch user's information
    $row=$result->fetch_assoc();
    $id=$row["id"];
    $forename=$row["forename"]." ";
    $surname=$row["surname"];
    //fetch more information about user
    $query="SELECT * FROM profile WHERE id=$id";
    $result=$conn->query($query);
    $row=$result->fetch_assoc();
    $clearnickname=$row["nickname"];
    $nickname="\"".$row["nickname"]."\" ";
    $bio=$row["bio"];
    $birthday=$row["birthday"];
    $website=$row["website"];
    //generate user's name
    if($nickname!="\"\" ") {
        //concatenate names
        $name=$forename.$nickname.$surname;
    }
    else {
        //otherwise, exclude $nickname
        $name=$forename.$surname;
    }
    //see if user has logged in
    if($_SESSION["userId"]=="") {
        //if not, display only basic information
        echo "<h1>$name on thinkly.</h1>";
        echo "<h2>$user</h2>";
        echo "<p>$bio<br><a href='$website'>$website</a></p>";
        //prompt user to register
        echo "<span>To connect with and see $name's posts, <a href='/thinkly/?page=login'>join thinkly</a>.</span>";
    }
    else {
        //if so, show user full details
        echo "<h1>$name on thinkly.</h1>";
        echo "<div class='column1'>";
        echo "<h2>$user</h2>";
        echo "<p>$bio<br><a href='$website'>$website</a></p>";
        //include "/thinkly/assets/functions.php";
        $day=getDay(substr($birthday,8,2));
        $month=getMonth(substr($birthday,5,2));
        echo "<p>Born on $day $month.</p>";
        if($_SESSION["userId"]==$id) {
            echo "<p><ul><li><a onclick='show()'>edit my profile</a></li></ul></p>";
        }
        echo "</div>";
        echo "<div class='column2'>";
        echo "<hr>";
        //begin printout of posts
        $query="SELECT * FROM posts WHERE author=$id ORDER BY posted DESC";
        $result=$conn->query($query);
        while($post=$result->fetch_assoc()) {
            $query="SELECT name FROM pages WHERE id=".$post["page"];
            $results=$conn->query($query);
            $row=$results->fetch_assoc();
            echo "<div class='post'>";
            echo "<a href='/thinkly/page/?p=".$row["name"]."'><h4>".$row["name"]."</h4></a>";
            $day=getDay(substr($post["posted"],8,2));
            $month=getMonth(substr($post["posted"],5,2));
            $time=substr($post["posted"],11,5);
            echo "<p class='date'>$day $month, at $time</p>";
            if($post["type"]=="image") {
                echo "<p class='posttext'>".$post["content"]."</p><img src='/thinkly".$post["attachment"]."' class='postimage'>";
            }
            else if($post["type"]=="music") {
                echo "<p class='posttext'>".$post["content"]."</p><iframe src='https://open.spotify.com/embed?uri=".$post["attachment"]."' width='430' height='80' frameborder='0' allowtransparency='true'></iframe>";
            }
            else {
                echo "<p class='posttext'>".$post["content"]."</p>";
            }
            echo "</div>";
        }
        echo "</div>";
    }
    echo "</div>";
    if($_SESSION["userId"]==$id) {
        echo "<div class='dialog' id='profiledisplay'></div>";
        echo "<div class='dialog' id='profile'>";
        echo "<a class='link' onclick='hide()'>x</a><h1>Edit your profile.</h1>";
        echo "<form action='assets/scripts/update.php?u=$id' method='post' enctype='multipart/form-data' onsubmit='return check()' autocomplete='off'>";
        echo "<p><input type='text' name='nickname' class='single' placeholder='Nickname' value='$clearnickname' id='nickname'></p>";
        if($birthday!="") {
            $day=substr($birthday,8,2);
            $month=substr($birthday,5,2);
            $year=substr($birthday,0,4);
        }
        echo "<p><input type='text' name='day' class='bday' placeholder='DD' value='$day' id='day'> / <input type='text' name='month' class='bday' placeholder='MM' value='$month' id='month'> / <input type='text' name='year' class='bday' placeholder='YYYY' value='$year' id='year'></p>";
        echo "<p><input type='text' name='bio' class='paragraph' placeholder='Biography' id='bio' value='$bio'>&nbsp;&nbsp;<span class='count' id='count'></span></p>";
        echo "<p><input type='text' name='website' class='single' placeholder='Website' value='$website' id='website'></p>";
        echo "<span class='error' id='error'></span>";
        echo "<input type='submit' class='submitbutton' value='Update'>";
        echo "</form>";
        echo "</div>";
    }
    //reference JavaScript file for page
    echo "<script type='text/javascript' src='assets/scripts/script.js'></script>";
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
