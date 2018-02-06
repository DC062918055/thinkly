document.getElementById("bio").addEventListener("change",count);
document.getElementById("bio").addEventListener("keypress",count);
document.getElementById("bio").addEventListener("keyup",count);
function show() {
    document.getElementById("profiledisplay").style.display="block";
    document.getElementById("profile").style.display="block";
}
function hide() {
    document.getElementById("profiledisplay").style.display="none";
    document.getElementById("profile").style.display="none";
}
function check() {
    var nickname=document.getElementById("nickname").value;
    var day=document.getElementById("day").value;
    var month=document.getElementById("month").value;
    var year=document.getElementById("year").value;
    var bio=document.getElementById("bio").value;
    var website=document.getElementById("website").value;
    if(nickname.length>255) {
        document.getElementById("error").innerHTML="That username is too long.";
        return false;
    }
    if(day<1||day>31) {
        document.getElementById("error").innerHTML="Please enter a valid day.";
        return false;
    }
    else if(day>28&&month==2) {
        if(day!="29") {
            document.getElementById("error").innerHTML="Please enter a valid day.";
            return false;
        }
        else if(year%4!=0) {
            document.getElementById("error").innerHTML="Please enter a valid day.";
            return false;
        }
    }
    else if(day>30&&month==4||month=="6"||month=="9"||month=="11") {
        document.getElementById("error").innerHTML="Please enter a valid day.";
        return false;
    }
    if(month<1||month>12) {
        document.getElementById("error").innerHTML="Please enter a valid month.";
        return false;
    }
    if(year>=getFullYear()) {
        document.getElementById("error").innerHTML="Please enter a valid year. Birthdays this year are not permitted.";
        return false;
    }
    if(bio.length>240) {
        document.getElementById("error").innerHTML="Your biography is too long!";
        return false;
    }
    if(website.length>255) {
        document.getElementById("error").innerHTML="Please enter a valid website.";
        return false;
    }
    document.getElementById("error").innerHTML="";
    return true;
}
function count() {
    var content=document.getElementById("bio").value;
    document.getElementById("count").innerHTML=240-content.length;
    if(content.length>240) {
        document.getElementById("count").style.color="#FF0000";
    }
    else {
        document.getElementById("count").style.color="#00FF00";
    }
}
count();
