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
    //get page to be unfollowed
    $page=strip_tags($_GET["p"]);
    //get post data to be submitted
    $type=$_POST["type"];
    $content=$_POST["content"];
    $attachment=$_POST["uri"];
    $posted=date('Y/m/d H:i:s');
    //fetch page name
    $query="SELECT name FROM pages WHERE id=$page";
    $result=$conn->query($query);
    $row=$result->fetch_assoc();
    $pagename=$row["name"];
    //upload image to server, if image attached
    if($type=="image") {
        //primitive upload procedure - see required vs. desired
        $dir="/thinkly/images/";
        //generate name based on page and timestamp
        $fileExtension = strtolower(pathinfo($_FILES["image"]["name"],PATHINFO_EXTENSION));
        $file=$dir.$pagename."_".substr($posted,0,10)."_".substr($posted,11,8).".".$fileExtension;
        //upload the file
        echo $file;
        print_r($_FILES);
        $upload=move_uploaded_file($_FILES["image"]["tmp_name"],$file);
        //if there was an error, let the user know
        if(!$upload) {
            echo "There was an error uploading your file. Click <a href='/thinkly/page/?p=$pagename'>here</a> to try again.";
            die();
        }
        $attachment=$file;
    }
    //check the user has post permissions
    $query="SELECT * FROM followers WHERE page=$page AND member=".$_SESSION["userId"];
    $result=$conn->query($query);
    $row=$result->fetch_assoc();
    if($result->num_rows!=0&&$row["level"]!="reader") {
        $query="INSERT INTO posts (author,page,type,content,attachment,posted) VALUES (".$_SESSION["userId"].",$page,'$type','$content','$attachment','$posted')";
        $result=$conn->query($query);
    }
    else {
        $_SESSION["permissionError"]=True;
    }
    //return user to page
    header("Location: /thinkly/page?p=$pagename");
    die();
?>
