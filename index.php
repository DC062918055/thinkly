<?php
    session_start();
    echo "<!DOCTYPE html>";
    echo "<html>";
    echo "<head>";
    echo "<title>thinkly</title>";
    echo "<link href='https://fonts.googleapis.com/css?family=Noto+Sans|Noto+Serif' rel='stylesheet' />";
    echo "<link rel='icon' type='image/png' href='assets/favicon.png' />";
    echo "<link rel='stylesheet' type='text/css' href='assets/style.css'>";
    echo "<script type='text/javascript' src='assets/scripts/register.js'></script>";
    echo "</head>";
    echo "<body>";
    echo "<div class='content' id='contentDisplay'></div>";
    echo "<div class='content' id='contentBox'>";
    $page=$_GET["page"];
    if($_SESSION["userId"]=="") {
        if($page=="login") {
            echo "<div class='column1'>";
            echo "<h1>Login to thinkly.</h1>";
            echo "<p>Already a member? Welcome back! Login below.</p>";
            echo "<form action='assets/scripts/login.php' method='post' enctype='multipart/form-data'><input class='loginField' type='text' name='username' placeholder='Username' autofocus><br><div class='space'></div><input class='loginField' type='password' name='password' placeholder='Password'><br>";
            if($_SESSION["incorrect"]) {
                echo "<p>Incorrect username or password.</p>";
            }
            else if($_SESSION["blank"]) {
                echo "<p>Please enter your login details.</p>";
            }
            else {
                echo "<div class='space'></div>";
            }
            echo "<input class='loginButton' type='submit' value='Login'></form>";
            echo "</div>";
            echo "<div class='column2'>";
            echo "<h1>Register for thinkly.</h1>";
            echo "<p>Not yet a member? Welcome! Sign up below.</p>";
            echo "<form action='assets/scripts/register.php' method='post' enctype='multipart/form-data' onsubmit='return check()' autocomplete='off'><input type='text' class='loginField' id='fName' name='fName' placeholder='First Name'><span class='registerError' id='fNameError'></span><div class='space'></div><input type='text' class='loginField' id='sName' name='sName' placeholder='Surname'><span class='registerError' id='sNameError'></span><div class='space'></div><input type='text' class='loginField' id='eAddr' name='eAddr' placeholder='Email'><span class='registerError' id='eAddrError'></span><div class='space'></div><input type='text' class='loginField' id='uName' name='uName' placeholder='Username'><span class='registerError' id='uNameError'></span><div class='space'></div><input type='password' class='loginField' id='pWord' name='pWord' placeholder='Password'><div class='space'></div><input type='password' class='loginField' id='cpWord' name='cpWord' placeholder='Confirm Password'><div class='space'></div><input class='loginButton' type='submit' value='Register'></form>";
            echo "</div>";
        }
        else {
            echo "<h1>thinkly</h1><a id='loginlink' href='/thinkly/?page=login'>Login or Register</a>";
            echo "<span>the social concept, reimagined</span>";
            echo "<p>Connect. Contribute. Collaborate.<br><span>thinkly</span> is here for everyone.</p><hr><p>Knowledge. The world is full of it, whether about quantum physics or your favourite TV show. <span>thinkly</span> consists of a number of pages, dedicated to certain ideas or projects, which consist of concise knowledge contributed by our users.</p><p>Simplicity. Some people can't explain things concisely. Eww. <span>thinkly</span> solves that by training people to be concise. We have a 250 character limit on posts to encourage people to provide the most concise knowledge possible.</p><p>Answers. We know you don't like asking questions all the time. We aren't like that. <span>thinkly</span> is designed so that each page provides knowledge, which can be searched to find answers, meaning you don't have to keep asking.</p><p>Are you excited? We are. <a href='/thinkly/?page=login'>Click here to sign up.</a>";
        }
    }
    else {
        if($page=="welcome") {
            echo "<h1>Welcome to thinkly!</h1>";
            echo "<div class='column1'><h2>Getting Started</h2><p><span>thinkly</span> is complex. We get that - we designed it! But we believe the more complex a system, the more you can learn, and therefore the more you can do. So bear with us while you get started...trust us, it'll pay off.</p><ul><li>create your profile</li><li>find a page</li><li>create a page</li><li>find a group</li><li>create a group</li></ul><p>Or, you can do none of these things, and just have a browse. Why not have a look at what's trending, to your right?</p></div>";
            echo "<div class='column2'><h2>Trending</h2><hr><p>This is a trending post...</p><hr></div>";
        }
        if($page=="home") {
            echo "<h1>thinkly</h1><a id='loginlink' href='/thinkly/assets/scripts/logout.php'>Logout</a>";
            $date=date('Y/m/d H:i:s');
        }
        else {
            header("Location: /thinkly/?page=home");
            die();
        }
    }
    echo "</div>";
    echo "</body>";
    echo "</html>";
?>
