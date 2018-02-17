<?php
    //begin session
    session_start();
    if(!isset($_SESSION["userId"])) {
        $_SESSION["userId"]="";
    }
    if(!isset($_SESSION["nameTaken"])) {
        $_SESSION["nameTaken"]="";
    }
    if(!isset($_SESSION["permissionError"])) {
        $_SESSION["permissionError"]="";
    }
    //get page being searched
    if(isset($_GET["p"])) {
        $page=strip_tags($_GET["p"]);
    }
    else {
        $page="";
    }
    if(isset($_GET["s"])) {
        $search=strip_tags($_GET["s"]);
    }
    else {
        $search="";
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
    //if no one logged in, show login link
    if($_SESSION["userId"]=="") {
        echo "<a class='link' href='/thinkly/?page=login'>Login or Register</a>";
    }
    //otherwise, fetch username to provide link to profile/logout
    else {
        $query="SELECT username FROM members WHERE id=".$_SESSION["userId"];
        $result=$conn->query($query);
        $row=$result->fetch_assoc();
        $username=$row["username"];
        echo "<span class='link'><a href='/thinkly/profile/?u=$username'>$username</a> - <a href='/thinkly/assets/scripts/logout.php'>Logout</a></span>";
    }
    //show menu system
    echo "<details><summary>t</summary><p id='home'><a href='/thinkly/?page=home'>home</a></p><p id='page'><a href='/thinkly/page'>pages</a></p><p id='profile'><a href='/thinkly/profile'>profiles</a></p></details>";
    echo "<div class='content' id='contentDisplay'></div>";
    echo "<div class='content' id='contentBox'>";
    if($page=="") {
        //set nav item as bold
        echo "<script type='text/javascript'>document.getElementById('page').style.fontWeight='700';</script>";
        //if not, display home profile page
        echo "<div class='column1'>";
        echo "<h1>Find a page.</h1>";
        //establish search form
        echo "<p><form action='' method='get' autocomplete='off'>";
        echo "<input type='text' class='singleregister' name='s' id='search' placeholder='Search' value='$search'>";
        echo "</form></p>";
        //if search query present, perform search
        if($search!="") {
            echo "<div class='newsfeed'>";
            //use MySQL wildcard to find likenesses of entered term
            $query="SELECT * FROM pages WHERE name LIKE '%$search%'";
            $result=$conn->query($query);
            //if page not found, tell user to check spelling
            if($result->num_rows==0) {
                echo "<p>No pages found with that name. Please check your spelling and try again.";
            }
            //otherwise, print out pages found in a list
            else {
                echo "<p><ul>";
                while($row=$result->fetch_assoc()) {
                    $pname=$row["name"];
                    echo "<li><a href='?p=$pname'>$pname</a></li>";
                }
                echo "</ul></p>";
            }
            echo "</div>";
        }
        echo "</div>";
        echo "<div class='column2'>";
        //if user is not logged in, show registration form
        if($_SESSION["userId"]=="") {
            echo "<h1>Register for thinkly.</h1>";
            //import registration validation script
            echo "<script type='text/javascript' src='/thinkly/assets/scripts/register.js'></script>";
            echo "<p>View and create your own pages. Sign up now!</p>";
            echo "<form action='/thinkly/assets/scripts/register.php' class='register' method='post' enctype='multipart/form-data' onsubmit='return check()' autocomplete='off'><input type='text' class='singleregister' id='fName' name='fName' placeholder='First Name'><br><span class='registerError' id='fNameError'></span><div class='space'></div><input type='text' class='singleregister' id='sName' name='sName' placeholder='Surname'><br><span class='registerError' id='sNameError'></span><div class='space'></div><input type='text' class='singleregister' id='eAddr' name='eAddr' placeholder='Email'><br><span class='registerError' id='eAddrError'></span><div class='space'></div><input type='text' class='singleregister' id='uName' name='uName' placeholder='Username'><br><span class='registerError' id='uNameError'></span><div class='space'></div><input type='password' class='singleregister' id='pWord' name='pWord' placeholder='Password'><br><span class='registerError' id='pWordError'></span><div class='space'></div><input type='password' class='singleregister' id='cpWordregister' name='cpWord' placeholder='Confirm Password'><br><span class='registerError' id='cpWordError'></span><div class='space'></div><input class='submitregister' type='submit' value='Register'></form>";
        }
        //otherwise show page creation and management tools
        else {
            echo "<h1>Create a page.</h1>";
            echo "<p><form action='assets/scripts/create.php' class='register' method='post' enctype='multipart/form-data' onsubmit=\"return check('create')\" autocomplete='off'>";
            echo "<input type='text' class='singleregister' id='pagename' name='pagename' placeholder='Name'><br><span class='registerError' id='pageerror'></span><div class='space'></div>";
            echo "<input class='submitregister' type='submit' value='Create'>";
            echo "</form></p>";
            echo "<h1>Manage your pages.</h1>";
            echo "<div class='pagelist'>";
            //fetch pages user owns
            $query="SELECT * FROM pages WHERE owner=".$_SESSION["userId"];
            $result=$conn->query($query);
            //if none, ask if want to create
            if($result->num_rows==0) {
                echo "<p>You don't own any pages. Why not create one above?";
            }
            //otherwise, display pages in list
            else {
                echo "<p><ul>";
                while($row=$result->fetch_assoc()) {
                    $pname=$row["name"];
                    echo "<li><a href='?p=$pname'>$pname</a></li>";
                }
                echo "</ul></p>";
            }
            echo "</div>";
        }
        echo "</div>";
        echo "</div>";
    }
    else {
        //find page
        $query="SELECT * FROM pages WHERE name='$page'";
        $result=$conn->query($query);
        if($result->num_rows==0) {
            //inform the page that page does not exist
            echo "<h2>Oops. We can't seem to find what you're looking for.</h2>";
            echo "<p>The page might have been deleted, or we might not have a page named that.<br>But it's okay! <a href='/thinkly/?page=home'>Click here to go back to the main site.</a></p>";
            die();
        }
        //update page name to represent page
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
        //increase the visits variable
        $visits=$row["visits"]+1;
        //send this to server
        $query="UPDATE pages SET visits=$visits WHERE id=$id";
        $conn->query($query);
        //get owner's username
        $query="SELECT username FROM members WHERE id=$owner";
        $result=$conn->query($query);
        $row=$result->fetch_assoc();
        $ownerName=$row["username"];
        //start displaying page data
        echo "<h1>$page</h1>";
        echo "<div class='column1'>";
        echo "<h2>a <a href='/thinkly/profile/?u=$ownerName'>$ownerName</a> creation</h2>";
        echo "<p>$description<br>$visits views.</p>";
        //if a user is logged in, allow tools access
        if($_SESSION["userId"]!="") {
            //find user's role from database
            $query="SELECT level FROM followers WHERE page=$id && member=".$_SESSION["userId"];
            $result=$conn->query($query);
            $row=$result->fetch_assoc();
            $status=$row["level"];
            echo "<p><ul>";
            //if not following, give option to follow
            if($status=="") {
                echo "<li><a href='assets/scripts/follow.php?p=$id' id='follow'>follow $page</a></li>";
            }
            //if following, allow to unfollow, but cannot unfollow if owns
            else if($status!="owner") {
                echo "<li><a href='assets/scripts/unfollow.php?p=$id' id='unfollow'>unfollow $page</a></li>";
            }
            //if a writer or above, show post box
            if($status!=""&&$status!="reader") {
                echo "<li><a onclick=\"show('post')\">write a post</a></li>";
            }
            //if an admin or owner, show permission editing box
            if($status=="admin"||$status=="owner") {
                echo "<li><a onclick=\"show('update')\">change the description</a></li>";
                echo "<li><a onclick=\"show('permission')\">change the editors</a></li>";
            }
            //if owner, give option to delete page
            if($status=="owner") {
                echo "<li><a onclick=\"show('delete')\">delete this page</a></li>";
            }
            echo "</ul></p>";
        }
        echo "</div>";
        echo "<div class='column2'>";
        echo "<div class='newsfeed'>";
        echo "<hr>";
        //begin printout of posts
        $query="SELECT * FROM posts WHERE page=$id ORDER BY posted DESC";
        $result=$conn->query($query);
        while($post=$result->fetch_assoc()) {
            echo "<div class='post'>";
            //get author's username
            $query="SELECT username FROM members WHERE id=".$post["author"];
            $results=$conn->query($query);
            $row=$results->fetch_assoc();
            //display username and link to profile
            echo "<a href='/thinkly/profile/?u=".$row["username"]."'><h4>".$row["username"]."</h4></a>";
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
        //if user allowed to contribute, send post box to client
        if($status!=""||$status!="reader") {
            echo "<div class='dialog' id='newpostdisplay'></div>";
            echo "<div class='dialog' id='newpost'>";
            echo "<a class='link' onclick=\"hide('post')\">x</a><h1>Post to $page.</h1>";
            echo "<form action='assets/post.php?p=$id' method='post' enctype='multipart/form-data' onsubmit=\"return check('post')\" autocomplete='off'>";
            echo "<select onchange='change()' name='type' id='posttype'><option value='text'>text</option><option value='image'>image</option><option value='music'>music</option></select><br><br>";
            echo "<textarea name='content' class='paragraph' id='postcontent' placeholder='post'></textarea>&nbsp;&nbsp;<span class='count' id='countpost'></span><br><br>";
            echo "<input type='file' name='image' class='newpost' id='image'>";
            echo "<input type='text' name='attachment' class='single' id='uri' placeholder='Spotify URI'>";
            echo "<span class='error' id='error'></span>";
            echo "<input type='submit' class='submitbutton' value='Post'>";
            echo "</form>";
            echo "</div>";
        }
        //if user is admin/owner, send description box and permission box to client
        if($status=="admin"||$status=="owner") {
            echo "<div class='dialog' id='updatedisplay'></div>";
            echo "<div class='dialog' id='update'>";
            echo "<a class='link' onclick=\"hide('update')\">x</a><h1>Update $page's description.</h1>";
            echo "<form action='assets/scripts/update.php?p=$id' method='post' enctype='multipart/form-data' onsubmit=\"return check('update')\" autocomplete='off'>";
            echo "<p><textarea name='description' class='paragraph' id='updatecontent' placeholder='description'>$description</textarea>&nbsp;&nbsp;<span class='count' id='countupdate'></span></p>";
            echo "<span class='error' id='updateerror'></span>";
            echo "<input type='submit' class='submitbutton' value='Update'>";
            echo "</form>";
            echo "</div>";
            echo "<div class='dialog' id='permissiondisplay'></div>";
            echo "<div class='dialog' id='permission'>";
            echo "<a class='link' onclick=\"hide('permission')\">x</a><h1>Change $page's editors.</h1>";
            echo "<hr>";
            echo "<div class='permissionlist'>";
            //fetch those who follow the page
            $query="SELECT * FROM followers WHERE page=$id";
            $results=$conn->query($query);
            while($list=$results->fetch_assoc()) {
                //fetch username from server
                $query="SELECT username FROM members WHERE id=".$list["member"];
                $result=$conn->query($query);
                $row=$result->fetch_assoc();
                $username=$row["username"];
                $level=$list["level"];
                //display users
                echo "<div class='post'><p>";
                echo $username;
                //if the user is the owner, allow all permissions to be changed except their own
                if($status=="owner") {
                    if($level=="owner") {
                        echo "<span class='link'>$level</span>";
                    }
                    else {
                        //onchange of box, run script which uses AJAX to contact server
                        echo "<select class='permissionselect' name='perms' id='$username' onchange=\"send($id,".$_SESSION["userId"].",'$username')\"><option value='reader'>reader</option><option value='writer'>writer</option><option value='admin'>admin</option></select>";
                        //set the value of the box to the level of the user
                        echo "<script type='text/javascript'>document.getElementById('$username').value='$level';</script>";
                    }
                }
                //if user is admin, allow them to change from reader to writer
                else {
                    if($level=="owner"||$level=="admin") {
                        echo "<span class='link'>$level</span>";
                    }
                    else {
                        //onchange of box, run script which uses AJAX to contact server
                        echo "<select class='permissionselect' name='perms' id='$username' onchange=\"send($id,".$_SESSION["userId"].",'$username')\"><option value='reader'>reader</option><option value='writer'>writer</option></select>";
                        //set the value of the box to the level of the user
                        echo "<script type='text/javascript'>document.getElementById('$username').value='$level';</script>";
                    }
                }
                echo "</div></p>";

            }
            echo "</div>";
            echo "</div>";
        }
        //if the user is the owner, send the delete box to the client
        if($_SESSION["userId"]==$owner) {
            echo "<div class='dialog' id='deletedisplay'></div>";
            echo "<div class='dialog' id='delete'>";
            echo "<a class='link' onclick=\"hide('delete')\">x</a><h1>Delete $page.</h1>";
            echo "<form action='assets/scripts/delete.php?p=$id' method='post' enctype='multipart/form-data' autocomplete='off'>";
            echo "<p><input type='password' name='delete' class='single' id='passdelete' placeholder='Current Password'></p>";
            echo "<span class='error' id='deleteerror'><span class='warning'>Warning:</span> this deletes your page permanently, including all posts.</span>";
            echo "<input type='submit' class='submitbutton' value='Delete'>";
            echo "</form>";
            echo "</div>";
        }
        //display error if permission error occurred
        if($_SESSION["permissionError"]==True) {
            echo "<script type='text/javascript'>error('post');</script>";
        }
    }
    //reference JavaScript file for page
    echo "<script type='text/javascript' src='assets/scripts/script.js'></script>";
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
