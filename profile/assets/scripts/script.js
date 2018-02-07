document.getElementById("bio").addEventListener("change",count);
document.getElementById("bio").addEventListener("keypress",count);
document.getElementById("bio").addEventListener("keyup",count);
function show(show) {
    if(show=="edit") {
        document.getElementById("profiledisplay").style.display="block";
        document.getElementById("profile").style.display="block";
    }
    else if(show=="email") {
        document.getElementById("emaildisplay").style.display="block";
        document.getElementById("email").style.display="block";
    }
    else if(show=="password") {
        document.getElementById("passworddisplay").style.display="block";
        document.getElementById("password").style.display="block";
    }
    else if(show=="delete") {
        document.getElementById("deletedisplay").style.display="block";
        document.getElementById("delete").style.display="block";
    }
}
function hide(hide) {
    if(hide=="edit") {
        document.getElementById("profiledisplay").style.display="none";
        document.getElementById("profile").style.display="none";
    }
    else if(hide=="email") {
        document.getElementById("emaildisplay").style.display="none";
        document.getElementById("email").style.display="none";
    }
    else if(hide=="password") {
        document.getElementById("passworddisplay").style.display="none";
        document.getElementById("password").style.display="none";
    }
    else if(hide=="delete") {
        document.getElementById("deletedisplay").style.display="none";
        document.getElementById("delete").style.display="none";
    }
}
function error(type) {
    if(type=="password") {
        show("password");
        document.getElementById("passworderror").innerHTML="Your password was incorrect. Please try again.";
    }
    else if(type=="delete") {
        show("delete");
        document.getElementById("deleteerror").innerHTML="Your password was incorrect. Please try again.";
    }
}
function check(form) {
    if(form=="profile") {
        var nickname=document.getElementById("nickname").value;
        var day=document.getElementById("day").value;
        var month=document.getElementById("month").value;
        var year=document.getElementById("year").value;
        var bio=document.getElementById("bio").value;
        var website=document.getElementById("website").value;
        if(nickname.length>255) {
            document.getElementById("profileerror").innerHTML="That nickname is too long.";
            return false;
        }
        if(day<1||day>31) {
            document.getElementById("profileerror").innerHTML="Please enter a valid day.";
            return false;
        }
        else if(day>28&&month==2) {
            if(day!="29") {
                document.getElementById("profileerror").innerHTML="Please enter a valid day.";
                return false;
            }
            else if(year%4!=0) {
                document.getElementById("profileerror").innerHTML="Please enter a valid day.";
                return false;
            }
        }
        else if(day>30&&month==4||month=="6"||month=="9"||month=="11") {
            document.getElementById("profileerror").innerHTML="Please enter a valid day.";
            return false;
        }
        if(month<1||month>12) {
            document.getElementById("profileerror").innerHTML="Please enter a valid month.";
            return false;
        }
        if(year>=getFullYear()) {
            document.getElementById("profileerror").innerHTML="Please enter a valid year. Birthdays this year are not permitted.";
            return false;
        }
        if(bio.length>240) {
            document.getElementById("profileerror").innerHTML="Your biography is too long!";
            return false;
        }
        if(website.length>255) {
            document.getElementById("profileerror").innerHTML="Please enter a valid website.";
            return false;
        }
        document.getElementById("profileerror").innerHTML="";
        return true;
    }
    else if(form=="password") {
        var original=document.getElementById("original").value;
        var newpass=document.getElementById("newpass").value;
        var confirm=document.getElementById("confirmpass").value;
        if(original.length==0) {
            document.getElementById("passworderror").innerHTML="Please enter your current password.";
            return false;
        }
        else if(newpass.length==0) {
            document.getElementById("passworderror").innerHTML="Please enter a new password.";
            return false;
        }
        else if(confirm.length==0) {
            document.getElementById("passworderror").innerHTML="Please confirm your new password.";
            return false;
        }
        else if(original.length<6||original.length>24) {
            document.getElementById("passworderror").innerHTML="Please enter a valid, current password.";
            return false;
        }
        else if(newpass.length<6||newpass.length>24) {
            document.getElementById("passworderror").innerHTML="Your new password is too short (less than six) or too long (more than twenty-four).";
            return false;
        }
        else if(newpass!=confirm) {
            document.getElementById("passworderror").innerHTML="Please ensure your new passwords match.";
            return false;
        }
        document.getElementById("passworderror").innerHTML="";
        return true;
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
