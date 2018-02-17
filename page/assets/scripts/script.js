//run the count script when changes made to post
document.getElementById("postcontent").addEventListener("change",countPost);
document.getElementById("postcontent").addEventListener("keypress",countPost);
document.getElementById("postcontent").addEventListener("keyup",countPost);
//run the count script when changes made to description
document.getElementById("updatecontent").addEventListener("change",countUpdate);
document.getElementById("updatecontent").addEventListener("keypress",countUpdate);
document.getElementById("updatecontent").addEventListener("keyup",countUpdate);
function show(show) {
    //show dialog boxes on request
    if(show=="post") {
        document.getElementById("newpostdisplay").style.display="block";
        document.getElementById("newpost").style.display="block";
    }
    else if(show=="update") {
        document.getElementById("updatedisplay").style.display="block";
        document.getElementById("update").style.display="block";
    }
    else if(show=="permission") {
        document.getElementById("permissiondisplay").style.display="block";
        document.getElementById("permission").style.display="block";
    }
    else if(show=="delete") {
        document.getElementById("deletedisplay").style.display="block";
        document.getElementById("delete").style.display="block";
    }
}
function hide(hide) {
    //hide dialog boxes on request
    if(hide=="post") {
        document.getElementById("newpostdisplay").style.display="none";
        document.getElementById("newpost").style.display="none";
    }
    else if(hide=="update") {
        document.getElementById("updatedisplay").style.display="none";
        document.getElementById("update").style.display="none";
    }
    else if(hide=="permission") {
        document.getElementById("permissiondisplay").style.display="none";
        document.getElementById("permission").style.display="none";
    }
    else if(hide=="delete") {
        document.getElementById("deletedisplay").style.display="none";
        document.getElementById("delete").style.display="none";
    }
}
function change() {
    //get values
    var dropdown=document.getElementById("posttype");
    var entered=dropdown.options[dropdown.selectedIndex].text;
    //based on value, display correct image elements
    if(entered=="image") {
        document.getElementById("image").style.display="block";
        document.getElementById("uri").style.display="none";
    }
    else if(entered=="music") {
        document.getElementById("image").style.display="none";
        document.getElementById("uri").style.display="block";
    }
    else {
        document.getElementById("image").style.display="none";
        document.getElementById("uri").style.display="none";
    }
}
function error(type) {
    //if a session error occurs on server, this script displays an error
    if(type=="post") {
        alert("You do not have permission to post to this page. Please contact the owner for more information.");
    }
}
function check(form) {
    //check requested form
    if(form=="post") {
        //get values
        var dropdown=document.getElementById("posttype");
        var entered=dropdown.options[dropdown.selectedIndex].text;
        var content=document.getElementById("postcontent").value;
        //check a valid length uri has been entered, if not, alert user/end script
        if(entered=="music") {
            var uri=document.getElementById("uri").value;
            if(uri.length==0||uri.length>255) {
                document.getElementById("error").innerHTML="Please enter a valid length URI.";
                return false;
            }
        }
        //if a text post has been chosen, a value must be entered, if not, alert user/end script
        else if(entered=="text"&&content.length==0) {
            document.getElementById("error").innerHTML="Please write a post.";
            return false;
        }
        //if too long, alert user/end script
        if(content.length>240) {
            document.getElementById("error").innerHTML="Your post is too long!";
            return false;
        }
        //otherwise, clear errors and approve
        else {
            document.getElementById("error").innerHTML="";
            return true;
        }
    }
    else if(form=="delete") {
        //get value
        var pass=document.getElementById("passdelete").value;
        //if no password entered, alert user/end script
        if(pass.length==0) {
            document.getElementById("deleteerror").innerHTML="Please enter a password.";
            return false;
        }
        //if not of valid length, alert user/end script
        else if(pass.length<6||pass.length>24) {
            document.getElementById("deleteerror").innerHTML="Please enter a valid password.";
            return true;
        }
        //otherwise, clear errors and approve
        document.getElementById("deleteerror").innerHTML="";
        return true;
    }
    else if(form=="create") {
        //get value
        var name=document.getElementById("pagename").value;
        //if no page name entered, alert user/end script
        if(name.length==0) {
            document.getElementById("pageerror").innerHTML="Please enter a name for the new page.";
            return false;
        }
        //if name too long, alert user/end script
        else if(name.length>50) {
            document.getElementById("pageerror").innerHTML="Please ensure your page name does not exceed fifty characters.";
            return false;
        }
        //otherwise, clear errors and approve
        document.getElementById("pageerror").innerHTML="";
        return true;
    }
}
function countPost() {
    //get value
    var content=document.getElementById("postcontent").value;
    //set value to number of characters remaining
    document.getElementById("countpost").innerHTML=240-content.length;
    //if long, turn red
    if(content.length>240) {
        document.getElementById("countpost").style.color="#FF0000";
    }
    //otherwise, set green
    else {
        document.getElementById("countpost").style.color="#00FF00";
    }
}
function countUpdate() {
    //get value
    var content=document.getElementById("updatecontent").value;
    //set value to number of characters remaining
    document.getElementById("countupdate").innerHTML=240-content.length;
    //if long, turn red
    if(content.length>240) {
        document.getElementById("countupdate").style.color="#FF0000";
    }
    //otherwise, set green
    else {
        document.getElementById("countupdate").style.color="#00FF00";
    }
}
//run for initial values
countPost();
countUpdate();
function send(page,submit,user) {
    //get value not submitted
    var dropdown=document.getElementById(user);
    var entered=dropdown.options[dropdown.selectedIndex].text;
    //reference AJAX
    var request=new XMLHttpRequest();
    //open connection to server
    request.open("POST","assets/scripts/permission.php",true);
    //tell it is form data
    request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    //send request to server with data
    request.send("page="+page+"&submit="+submit+"&username="+user+"&level="+entered);
}
