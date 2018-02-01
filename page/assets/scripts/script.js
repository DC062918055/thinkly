function show() {
    document.getElementById("newpostdisplay").style.display="block";
    document.getElementById("newpost").style.display="block";
}
function hide() {
    document.getElementById("newpostdisplay").style.display="none";
    document.getElementById("newpost").style.display="none";
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
function check() {
    var dropdown=document.getElementById("posttype");
    var entered=dropdown.options[dropdown.selectedIndex].text;
    if(entered=="music") {
        var uri=document.getElementById("uri").value;
        if(uri.length==0||uri.length>255) {
            document.getElementById("error").innerHTML="Please enter a valid length URI.";
            return false;
        }
    }
    var content=document.getElementById("newpostinput").value;
    if(entered=="text")
      if(content.length==0) {

    }
}
