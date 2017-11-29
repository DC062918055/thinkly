<?php
    session_start();
    echo "<!DOCTYPE html>";
    echo "<html>";
    echo "<head>";
    echo "<title>thinkly</title>";
    echo "<link href='https://fonts.googleapis.com/css?family=Noto+Sans|Noto+Serif' rel='stylesheet' />";
    echo "<link rel='icon' type='image/png' href='assets/favicon.png' />";
    echo "<link rel='stylesheet' type='text/css' href='assets/style.css'>";
    echo "</head>";
    echo "<body>";
    //echo "<img class='logo' src='assets/logo.svg'>";
    echo "<div class='content' id='contentDisplay'></div>";
    echo "<div class='content' id='contentBox'>";
    $page=$_GET["page"];
    if($page=="login") {
        echo "<div class='column1'>";
        echo "<h1>Login to thinkly.</h1>";
        echo "<p>Already a member? Login using your details below.</p>";
        echo "<form action='assets/scripts/login.php' method='post' enctype='multipart/form-data'><input class='loginField' type='text' name='username' placeholder='Username' autofocus><br><div class='space'></div><input class='loginField' type='password' name='password' placeholder='Password'><br>";
        //if($_SESSION["incorrect']) {
            echo "<p>Incorrect username or password.</p>";
        //}
        //else if($_SESSION["blank"]) {
            echo "<p>Please enter your login details.</p>";
        //}
        //else {
            echo "<div class='space'></div>";
        //}
        echo "<input class='loginButton' type='submit' value='Login'></form>";
        echo "</div>";
        echo "<div class='column2'>";
        echo "<h1>Register for thinkly.</h1>";
        echo "<p>Not yet a member? Enter your details below to sign up.</p>";
        echo "</div>";
    }
    else {
        echo "<h1>Welcome to thinkly!</h1><a id='loginlink' href='/thinkly/?page=login'>Login or Register</a>";
        echo "<span>the social concept, reimagined</span>";
        echo "<p>Connect. Contribute. Collaborate.<br><span>thinkly</span> is here for everyone.</p><hr><p>Knowledge. The world is full of it, whether about quantum physics or your favourite TV show. <span>thinkly</span> consists of a number of pages, dedicated to certain ideas or projects, which consist of concise knowledge contributed by our users.</p><p>Simplicity. Some people can't explain things concisely. Eww. <span>thinkly</span> solves that by training people to be concise. We have a 250 character limit on posts to train people to provide the most concise knowledge possible.</p><p>Answers. We know you don't like asking questions all the time. We aren't like that. <span>thinkly</span> is designed so that each page provides knowledge, which can be searched to find answers, meaning you don't have to keep asking.</p><p>Are you excited? We are. <a href='/thinkly/?page=login'>Click here to sign up.</a>";
    }
    echo "</div>";
    echo "</body>";
    echo "</html>";
?>
