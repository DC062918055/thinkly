document.getElementById("postcontent").addEventListener("change",count);
document.getElementById("postcontent").addEventListener("keypress",count);
document.getElementById("postcontent").addEventListener("keyup",count);
function show(show) {
    if(show=="post") {
        document.getElementById("newpostdisplay").style.display="block";
        document.getElementById("newpost").style.display="block";
    }
    else if(show=="delete") {
        document.getElementById("deletedisplay").style.display="block";
        document.getElementById("delete").style.display="block";
    }
}
function hide(hide) {
    if(hide=="post") {
        document.getElementById("newpostdisplay").style.display="none";
        document.getElementById("newpost").style.display="none";
    }
    else if(hide=="delete") {
        document.getElementById("deletedisplay").style.display="none";
        document.getElementById("delete").style.display="none";
    }
}
function change() {
    var dropdown=document.getElementById("posttype");
    var entered=dropdown.options[dropdown.selectedIndex].text;
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
    if(type=="post") {
        alert("You do not have permission to post to this page. Please contact the owner for more information.");
    }
}
function check(form) {
    if(form=="post") {
        var dropdown=document.getElementById("posttype");
        var entered=dropdown.options[dropdown.selectedIndex].text;
        var content=document.getElementById("postcontent").value;
        if(entered=="music") {
            var uri=document.getElementById("uri").value;
            if(uri.length==0||uri.length>255) {
                document.getElementById("error").innerHTML="Please enter a valid length URI.";
                return false;
            }
        }
        else if(entered=="text") {
            if(content.length==0) {
                document.getElementById("error").innerHTML="Please write a post.";
                return false;
            }
        }
        if(content.length>240) {
            document.getElementById("error").innerHTML="Your post is too long!";
            return false;
        }
        else {
            document.getElementById("error").innerHTML="";
            return true;
        }
    }
    else if(form=="delete") {
        var pass=document.getElementById("passdelete").value;
        if(pass.length==0) {
            document.getElementById("deleteerror").innerHTML="Please enter a password.";
            return false;
        }
        else if(pass.length<6||pass.length>24) {
            document.getElementById("deleteerror").innerHTML="Please enter a valid password.";
            return true;
        }
        document.getElementById("deleteerror").innerHTML="";
        return true;
    }
}
function count() {
    var content=document.getElementById("postcontent").value;
    document.getElementById("count").innerHTML=240-content.length;
    if(content.length>240) {
        document.getElementById("count").style.color="#FF0000";
    }
    else {
        document.getElementById("count").style.color="#00FF00";
    }
}
count();
