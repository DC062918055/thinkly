document.getElementById("new").addEventListener("click", function() {
    document.getElementById("newpostdisplay").style.display="block";
    document.getElementById("newpost").style.display="block";
});
function error(var type) {
    if(type=="post") {
        alert("You do not have permission to post to this page. Please contact the owner.");
    }
}
