<?php
    //begin session
    session_start();
    if(!isset($_SESSION["userId"])) {
        $_SESSION["userId"]="";
    }
    if(!isset($_SESSION["blank"])) {
        $_SESSION["blank"]="";
    }
    if(!isset($_SESSION["incorrect"])) {
        $_SESSION["incorrect"]="";
    }
    if(!isset($_SESSION["userTaken"])) {
        $_SESSION["userTaken"]="";
    }
    //get page to direct user
    if(isset($_GET["page"])) {
        $page=strip_tags($_GET["page"]);
    }
    else {
        $page="";
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
    echo "<link rel='icon' type='image/png' href='assets/favicon.png' />";
    //import stylesheet
    echo "<link rel='stylesheet' type='text/css' href='assets/style.css'>";
    echo "</head>";
    echo "<body>";
    //if no one logged in, show login link
    if($_SESSION["userId"]=="") {
        echo "<a class='link' href='/thinkly/?page=login'>Login or Register</a>";
    }
    //otherwise, connect to server and fetch username to provide link to profile/logout
    else {
        include "assets/scripts/connect.php";
        $query="SELECT username FROM members WHERE id=".$_SESSION["userId"];
        $result=$conn->query($query);
        $row=$result->fetch_assoc();
        $username=$row["username"];
        echo "<span class='link'><a href='/thinkly/profile/?u=$username'>$username</a> - <a href='/thinkly/assets/scripts/logout.php'>Logout</a></span>";
    }
    //show menu system
    echo "<details><summary>t</summary><p id='home'><a href='/thinkly/?page=home'>home</a></p><p id='page'><a href='/thinkly/page'>pages</a></p><p id='profile'><a href='/thinkly/profile'>profiles</a></p></details>";
    //if on home page, set the link for it to bold
    if($page=="home") {
        echo "<script type='text/javascript'>document.getElementById('home').style.fontWeight='700';</script>";
    }
    echo "<div class='content' id='contentDisplay'></div>";
    echo "<div class='content' id='contentBox'>";
    //see if user has logged in
    if($_SESSION["userId"]=="") {
        //if not, allow access to only non-registration pages
        if($page=="login") {
            echo "<div class='column1'>";
            echo "<h1>Login to thinkly.</h1>";
            echo "<p>Already a member? Welcome back! Login below.</p>";
            echo "<form action='assets/scripts/login.php' method='post' enctype='multipart/form-data'><input class='loginField' type='text' name='username' placeholder='Username' autofocus><br><div class='space'></div><input class='loginField' type='password' name='password' placeholder='Password'><br>";
            //use session to find errors encountered during login
            if($_SESSION["incorrect"]) {
                echo "<span class='registerError'>Incorrect username or password.</span>";
            }
            else if($_SESSION["blank"]) {
                echo "<span class='registerError'>Please enter your login details.</span>";
            }
            echo "<div class='space'></div>";
            echo "<input class='loginButton' type='submit' value='Login'></form>";
            echo "</div>";
            echo "<div class='column2'>";
            echo "<h1>Register for thinkly.</h1>";
            //import registration validation script
            echo "<script type='text/javascript' src='assets/scripts/register.js'></script>";
            echo "<p>Not yet a member? Welcome! Sign up below.</p>";
            echo "<form action='assets/scripts/register.php' method='post' enctype='multipart/form-data' onsubmit='return check()' autocomplete='off'><input type='text' class='loginField' id='fName' name='fName' placeholder='First Name'><br><span class='registerError' id='fNameError'></span><div class='space'></div><input type='text' class='loginField' id='sName' name='sName' placeholder='Surname'><br><span class='registerError' id='sNameError'></span><div class='space'></div><input type='text' class='loginField' id='eAddr' name='eAddr' placeholder='Email'><br><span class='registerError' id='eAddrError'></span><div class='space'></div><input type='text' class='loginField' id='uName' name='uName' placeholder='Username'><br><span class='registerError' id='uNameError'></span><div class='space'></div><input type='password' class='loginField' id='pWord' name='pWord' placeholder='Password'><br><span class='registerError' id='pWordError'></span><div class='space'></div><input type='password' class='loginField' id='cpWord' name='cpWord' placeholder='Confirm Password'><br><span class='registerError' id='cpWordError'></span><div class='space'></div><input class='loginButton' type='submit' value='Register'></form>";
            echo "</div>";
            //use session to find errors encountered in registration
            if($_SESSION["userTaken"]==True) {
                echo "<script type='text/javascript'>document.getElementById('uNameError').innerHTML='That username is already taken. Please choose another username.';</script>";
                $_SESSION["userTaken"]=False;
            }
        }
        else {
            echo "<h1>thinkly</h1>";
            echo "<span>the social concept, reimagined</span>";
            echo "<p>Connect. Contribute. Collaborate.<br><span>thinkly</span> is here for everyone.</p><hr><p>Knowledge. The world is full of it, whether about quantum physics or your favourite TV show. <span>thinkly</span> consists of a number of pages, dedicated to certain ideas or projects, which consist of concise knowledge contributed by our users.</p><p>Simplicity. Some people can't explain things concisely. Eww. <span>thinkly</span> solves that by training people to be concise. We have a 240 character limit on posts to encourage people to provide the most concise knowledge possible.</p><p>Answers. We know you don't like asking questions all the time. We aren't like that. <span>thinkly</span> is designed so that each page provides knowledge, which can be searched to find answers, meaning you don't have to keep asking.</p><p>Are you excited? We are. <a href='/thinkly/?page=login'>Click here to sign up.</a>";
        }
    }
    else {
        //otherwise, allow access to pages requiring registration
        if($page=="welcome") {
            echo "<h1>Welcome to thinkly!</h1>";
            echo "<div class='column1'><h2>Getting Started</h2><p><span>thinkly</span> is complex. We get that - we designed it! But we believe the more complex a system, the more you can learn, and therefore the more you can do. So bear with us while you get started...trust us, it'll pay off.</p><ul><li><a href='/thinkly/profile/'>find a user</a></li><li><a href='/thinkly/profile/?u=$username'>create your profile</a></li><li><a href='/thinkly/page'>find a page</a></li><li><a href='/thinkly/page'>create a page</a></li></ul><p>Or, you can do none of these things, and just have a browse. Why not have a look at what's trending, to your right?</p></div>";
            echo "<div class='column2'><h2>Discover</h2><div class='newfeed'><hr>";
            //select all recent posts
            $query="SELECT * FROM posts ORDER BY posted DESC LIMIT 50";
            $result=$conn->query($query);
            //display each post fetched from server
            while($post=$result->fetch_assoc()) {
                echo "<div class='post'>";
                //get author's username
                $query="SELECT username FROM members WHERE id=".$post["author"];
                $results=$conn->query($query);
                $row=$results->fetch_assoc();
                //display username and link to profile
                echo "<a href='/thinkly/profile/?u=".$row["username"]."'><h4>".$row["username"]."</h4></a>";
                //fetch page name
                $query="SELECT name FROM pages WHERE id=".$post["page"];
                $results=$conn->query($query);
                $row=$results->fetch_assoc();
                //display page name and link to it
                echo "<a href='/thinkly/page/?p=".$row["name"]."'><h5>".$row["name"]."</h5></a>";
                //format date and time using functions
                $day=getDay(substr($post["posted"],8,2));
                $month=getMonth(substr($post["posted"],5,2));
                $time=substr($post["posted"],11,5);
                //display date and time
                echo "<p class='date'>$day $month, at $time</p>";
                //if image post, display content and image
                if($post["type"]=="image") {
                    echo "<p class='posttext'>".$post["content"]."</p><img src='/thinkly".$post["attachment"]."' class='postimage'>";
                }
                //if music, display content and Spotify widget
                else if($post["type"]=="music") {
                    echo "<p class='posttext'>".$post["content"]."</p><iframe src='https://open.spotify.com/embed?uri=".$post["attachment"]."' width='430' height='80' frameborder='0' allowtransparency='true'></iframe>";
                }
                //otherwise, just display the content
                else {
                    echo "<p class='posttext'>".$post["content"]."</p>";
                }
                echo "</div>";
            }
            echo "</div>";
            echo "</div>";
        }
        else if($page=="home") {
            echo "<h1>thinkly</h1>";
            //fetch local time
            $date=date('Y/m/d H:i:s');
            //get hour
            $time=substr($date,11,2);
            //check what time of day it is, then display appropriate message
            if($time>4&&$time<12) {
                echo "<h2>Good morning!</h2>";
            }
            else if($time>11&&$time<18) {
                echo "<h2>Good afternoon!</h2>";
            }
            else if($time>17&&$time<22) {
                echo "<h2>Good evening!</h2>";
            }
            else {
                echo "<h2>Good night!</h2>";
            }
            //present newsfeed
            echo "<div class='column1'>";
            echo "<h3>Take a look at what you missed...</h3>";
            echo "<div class='newsfeed'>";
            //different post formats, to be merged later
            //simple text post
            echo "<hr>";
            //begin printout of posts
            //fetch the pages the user follows
            $query="SELECT page FROM followers WHERE member=".$_SESSION["userId"];
            $results=$conn->query($query);
            //construct query with all the pages
            $query="SELECT * FROM posts WHERE";
            while($row=$results->fetch_assoc()) {
                $query=$query." page=".$row["page"]." ||";
            }
            $query=substr($query,0,-3);
            $query=$query." ORDER BY posted DESC LIMIT 50";
            //run query
            $result=$conn->query($query);
            while($post=$result->fetch_assoc()) {
                echo "<div class='post'>";
                //get author's username
                $query="SELECT username FROM members WHERE id=".$post["author"];
                $results=$conn->query($query);
                $row=$results->fetch_assoc();
                //display username and link to profile
                echo "<a href='/thinkly/profile/?u=".$row["username"]."'><h4>".$row["username"]."</h4></a>";
                //fetch page name
                $query="SELECT name FROM pages WHERE id=".$post["page"];
                $results=$conn->query($query);
                $row=$results->fetch_assoc();
                //display page name and link to it
                echo "<a href='/thinkly/page/?p=".$row["name"]."'><h5>".$row["name"]."</h5></a>";
                //format date and time using functions
                $day=getDay(substr($post["posted"],8,2));
                $month=getMonth(substr($post["posted"],5,2));
                $time=substr($post["posted"],11,5);
                //display date and time
                echo "<p class='date'>$day $month, at $time</p>";
                //if image post, display content and image
                if($post["type"]=="image") {
                    echo "<p class='posttext'>".$post["content"]."</p><img src='/thinkly".$post["attachment"]."' class='postimage'>";
                }
                //if music, display content and Spotify widget
                else if($post["type"]=="music") {
                    echo "<p class='posttext'>".$post["content"]."</p><iframe src='https://open.spotify.com/embed?uri=".$post["attachment"]."' width='430' height='80' frameborder='0' allowtransparency='true'></iframe>";
                }
                //otherwise, just display the content
                else {
                    echo "<p class='posttext'>".$post["content"]."</p>";
                }
                echo "</div>";
            }
            echo "</div>";
            echo "</div>";
            echo "<div class='column2'>";
            echo "<h3>...or discover some more.</h3>";
            echo "<div class='newsfeed'>";
            echo "<hr>";
            //select all recent posts from database
            $query="SELECT * FROM posts ORDER BY posted DESC LIMIT 50";
            $result=$conn->query($query);
            while($post=$result->fetch_assoc()) {
                echo "<div class='post'>";
                //get author's username
                $query="SELECT username FROM members WHERE id=".$post["author"];
                $results=$conn->query($query);
                $row=$results->fetch_assoc();
                //display username and link to profile
                echo "<a href='/thinkly/profile/?u=".$row["username"]."'><h4>".$row["username"]."</h4></a>";
                //fetch page name
                $query="SELECT name FROM pages WHERE id=".$post["page"];
                $results=$conn->query($query);
                $row=$results->fetch_assoc();
                //display page name and link to it
                echo "<a href='/thinkly/page/?p=".$row["name"]."'><h5>".$row["name"]."</h5></a>";
                //format date and time using functions
                $day=getDay(substr($post["posted"],8,2));
                $month=getMonth(substr($post["posted"],5,2));
                $time=substr($post["posted"],11,5);
                //display date and time
                echo "<p class='date'>$day $month, at $time</p>";
                //if image post, display content and image
                if($post["type"]=="image") {
                    echo "<p class='posttext'>".$post["content"]."</p><img src='/thinkly".$post["attachment"]."' class='postimage'>";
                }
                //if music, display content and Spotify widget
                else if($post["type"]=="music") {
                    echo "<p class='posttext'>".$post["content"]."</p><iframe src='https://open.spotify.com/embed?uri=".$post["attachment"]."' width='430' height='80' frameborder='0' allowtransparency='true'></iframe>";
                }
                //otherwise, just display the content
                else {
                    echo "<p class='posttext'>".$post["content"]."</p>";
                }
                echo "</div>";
            }
            echo "</div>";
            echo "</div>";
        }
        else {
            echo "<script type='text/javascript'>window.location.assign('/thinkly/?page=home');</script>";
            die();
        }
    }
    echo "</div>";
    echo "<p class='information'>&#169 thinkly, 2018</span>";
    echo "</body>";
    echo "</html>";
    function getDay($day) {
        //get correct prefix for day
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
        if($day==0) {
            $date=="";
        }
        return $date;
    }
    function getMonth($month) {
        //convert integer month into string month
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
        else if($month==12) {
            $date="December";
        }
        else {
            $date="";
        }
        return $date;
    }
?>
