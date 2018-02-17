<?php
    //begin session
    session_start();
    if(!isset($_SESSION["userId"])) {
        $_SESSION["userId"]="";
    }
    //get user being searched
    if(isset($_GET["u"])) {
        $user=strip_tags($_GET["u"]);
    }
    else {
        $user="";
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
    echo "<details><summary>t</summary><p id='home'><a href='/thinkly/?page=home'>home</a></p><p id='page'><a href='/thinkly/page'>pages</a></p><p id='profilelink'><a href='/thinkly/profile'>profiles</a></p></details>";
    echo "<div class='content' id='contentDisplay'></div>";
    echo "<div class='content' id='contentBox'>";
    //check user has been entered
    if($user=="") {
        //set nav item as bold
        echo "<script type='text/javascript'>document.getElementById('profilelink').style.fontWeight='700';</script>";
        //set id to session id
        $id=$_SESSION["userId"];
        echo "<div class='column1'>";
        echo "<h1>Find a user.</h1>";
        //establish search form
        echo "<p><form action='' method='get' autocomplete='off'>";
        echo "<input type='text' class='singleregister' name='s' id='search' placeholder='Search' value='$search'>";
        echo "</form></p>";
        //if search query present, perform search
        if($search!="") {
            echo "<div class='newsfeed'>";
            //use MySQL wildcard to find likeness of entered term
            $query="SELECT * FROM members WHERE username LIKE '%$search%'";
            $result=$conn->query($query);
            //if user not found, tell user to check their spelling
            if($result->num_rows==0) {
                echo "<p>No users found with that name. Please check your spelling and try again.";
            }
            //otherwise, print out the users found in a list
            else {
                echo "<p><ul>";
                while($row=$result->fetch_assoc()) {
                    $uname=$row["username"];
                    echo "<li><a href='?u=$uname'>$uname</a></li>";
                }
                echo "</ul></p>";
            }
            echo "</div>";
        }
        echo "</div>";
        echo "<div class='column2'>";
        //if user is not logged in, show registration form
        if($id=="") {
            echo "<h1>Register for thinkly.</h1>";
            //import registration validation script
            echo "<script type='text/javascript' src='/thinkly/assets/scripts/register.js'></script>";
            echo "<p>View and create your own profile. Sign up now!</p>";
            echo "<form action='/thinkly/assets/scripts/register.php' class='register' method='post' enctype='multipart/form-data' onsubmit='return check()' autocomplete='off'><input type='text' class='singleregister' id='fName' name='fName' placeholder='First Name'><br><span class='registerError' id='fNameError'></span><div class='space'></div><input type='text' class='singleregister' id='sName' name='sName' placeholder='Surname'><br><span class='registerError' id='sNameError'></span><div class='space'></div><input type='text' class='singleregister' id='eAddr' name='eAddr' placeholder='Email'><br><span class='registerError' id='eAddrError'></span><div class='space'></div><input type='text' class='singleregister' id='uName' name='uName' placeholder='Username'><br><span class='registerError' id='uNameError'></span><div class='space'></div><input type='password' class='singleregister' id='pWord' name='pWord' placeholder='Password'><br><span class='registerError' id='pWordError'></span><div class='space'></div><input type='password' class='singleregister' id='cpWordregister' name='cpWord' placeholder='Confirm Password'><br><span class='registerError' id='cpWordError'></span><div class='space'></div><input class='submitregister' type='submit' value='Register'></form>";
        }
        //otherwise, show profile editing tools
        else {
            //get details about user for profile editing
            $query="SELECT * FROM members WHERE id=$id";
            $result=$conn->query($query);
            $row=$result->fetch_assoc();
            $username=$row["username"];
            $email=$row["email"];
            //fetch and format more information about user
            $query="SELECT * FROM profile WHERE id=$id";
            $result=$conn->query($query);
            $row=$result->fetch_assoc();
            $clearnickname=$row["nickname"];
            $nickname="\"".$row["nickname"]."\" ";
            $bio=$row["bio"];
            $birthday=$row["birthday"];
            $website=$row["website"];
            echo "<h1>Manage your profile.</h1>";
            echo "<p><ul>";
            //list all profile tools
            echo "<li><a href='?u=$username'>view my profile</a></li>";
            echo "<li><a onclick=\"show('edit')\">edit my profile</a></li>";
            echo "<li><a onclick=\"show('email')\">change my email</a></li>";
            echo "<li><a onclick=\"show('password')\">change my password</a></li>";
            echo "<li><a onclick=\"show('delete')\">delete my account</a></li>";
            echo "</ul></p>";
        }
        echo "</div>";
    }
    else {
        //find username
        $query="SELECT * FROM members WHERE username='$user'";
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
        $email=$row["email"];
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
            $day=getDay(substr($birthday,8,2));
            $month=getMonth(substr($birthday,5,2));
            echo "<p>Born on $day $month.</p>";
            //show the user their profile editing tools, if it is they viewing their profile
            if($_SESSION["userId"]==$id) {
                echo "<p><ul>";
                echo "<li><a onclick=\"show('edit')\">edit my profile</a></li>";
                echo "<li><a onclick=\"show('email')\">change my email</a></li>";
                echo "<li><a onclick=\"show('password')\">change my password</a></li>";
                echo "<li><a onclick=\"show('delete')\">delete my account</a></li>";
                echo "</ul></p>";
            }
            echo "</div>";
            echo "<div class='column2'>";
            echo "<hr>";
            //begin printout of posts
            $query="SELECT * FROM posts WHERE author=$id ORDER BY posted DESC";
            $result=$conn->query($query);
            while($post=$result->fetch_assoc()) {
                echo "<div class='post'>";
                //fetch page name
                $query="SELECT name FROM pages WHERE id=".$post["page"];
                $results=$conn->query($query);
                $row=$results->fetch_assoc();
                //display page name and link to it
                echo "<a href='/thinkly/page/?p=".$row["name"]."'><h4>".$row["name"]."</h4></a>";
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
        }
    }
    echo "</div>";
    //if the user is the user, then send the profile tools to client
    if($_SESSION["userId"]==$id) {
        echo "<div class='dialog' id='profiledisplay'></div>";
        echo "<div class='dialog' id='profile'>";
        echo "<a class='link' onclick=\"hide('edit')\">x</a><h1>Edit your profile.</h1>";
        echo "<form action='assets/scripts/update.php?u=$id' method='post' enctype='multipart/form-data' onsubmit=\"return check('profile')\" autocomplete='off'>";
        echo "<p><input type='text' name='nickname' class='single' placeholder='Nickname' value='$clearnickname' id='nickname'></p>";
        //split birthday for display
        if($birthday!="") {
            $day=substr($birthday,8,2);
            $month=substr($birthday,5,2);
            $year=substr($birthday,0,4);
        }
        echo "<p><input type='text' name='day' class='bday' placeholder='DD' value='$day' id='day'> / <input type='text' name='month' class='bday' placeholder='MM' value='$month' id='month'> / <input type='text' name='year' class='bday' placeholder='YYYY' value='$year' id='year'></p>";
        echo "<p><textarea name='bio' class='paragraph' placeholder='Biography' id='bio'>$bio</textarea>&nbsp;&nbsp;<span class='count' id='count'></span></p>";
        echo "<p><input type='text' name='website' class='single' placeholder='Website' value='$website' id='website'></p>";
        echo "<span class='error' id='profileerror'></span>";
        echo "<input type='submit' class='submitbutton' value='Update'>";
        echo "</form>";
        echo "</div>";
        echo "<div class='dialog' id='emaildisplay'></div>";
        echo "<div class='dialog' id='email'>";
        echo "<a class='link' onclick=\"hide('email')\">x</a><h1>Change your email.</h1>";
        echo "<form action='assets/scripts/email.php?u=$id' method='post' enctype='multipart/form-data' onsubmit=\"return check('email')\" autocomplete='off'>";
        //display current email
        echo "<p>Current Email: $email</p>";
        echo "<p><input type='text' name='newemail' class='single' id='newemail' placeholder='New Email'></p>";
        echo "<p><input type='text' name='confirmemail' class='single' id='confirmemail' placeholder='Confirm New Email'></p>";
        echo "<span class='error' id='emailerror'></span>";
        echo "<input type='submit' class='submitbutton' value='Update'>";
        echo "</form>";
        echo "</div>";
        echo "<div class='dialog' id='passworddisplay'></div>";
        echo "<div class='dialog' id='password'>";
        echo "<a class='link' onclick=\"hide('password')\">x</a><h1>Change your password.</h1>";
        echo "<form action='assets/scripts/password.php?u=$id' method='post' enctype='multipart/form-data' onsubmit=\"return check('password')\" autocomplete='off'>";
        echo "<p><input type='password' name='original' class='single' id='original' placeholder='Current Password'></p>";
        echo "<p><input type='password' name='newpass' class='single' id='newpass' placeholder='New Password'></p>";
        echo "<p><input type='password' name='confirmpass' class='single' id='confirmpass' placeholder='Confirm New Password'></p>";
        echo "<span class='error' id='passworderror'></span>";
        echo "<input type='submit' class='submitbutton' value='Update'>";
        echo "</form>";
        echo "</div>";
        echo "<div class='dialog' id='deletedisplay'></div>";
        echo "<div class='dialog' id='delete'>";
        echo "<a class='link' onclick=\"hide('delete')\">x</a><h1>Delete your account.</h1>";
        echo "<form action='assets/scripts/delete.php?u=$id' method='post' enctype='multipart/form-data' autocomplete='off'>";
        echo "<p><input type='password' name='delete' class='single' id='passdelete' placeholder='Current Password'></p>";
        echo "<span class='error' id='deleteerror'><span class='warning'>Warning:</span> this deletes your account permanently.</span>";
        echo "<input type='submit' class='submitbutton' value='Delete'>";
        echo "</form>";
        echo "</div>";
    }
    //reference JavaScript file for page
    echo "<script type='text/javascript' src='assets/scripts/script.js'></script>";
    //if an error has occurred, use session to display error
    if($_SESSION["incorrect"]!="") {
        echo "<script type='text/javascript'>error('".$_SESSION["incorrect"]."');</script>";
        $_SESSION["incorrect"]="";
    }
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
