//run the count script when changes made to bio
document.getElementById("bio").addEventListener("change",count);
document.getElementById("bio").addEventListener("keypress",count);
document.getElementById("bio").addEventListener("keyup",count);
function show(show) {
    //show dialog boxes on request
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
    //hide dialog boxes on request
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
    //display error messages if requested
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
    //check requested forms
    if(form=="profile") {
        //get values
        var nickname=document.getElementById("nickname").value;
        var day=document.getElementById("day").value;
        var month=document.getElementById("month").value;
        var year=document.getElementById("year").value;
        var bio=document.getElementById("bio").value;
        var website=document.getElementById("website").value;
        //if nickname over 255, alert user/end script
        if(nickname.length>255) {
            document.getElementById("profileerror").innerHTML="That nickname is too long.";
            return false;
        }
        //if day outside accepted range, alert user/end script
        if(day<1||day>31) {
            document.getElementById("profileerror").innerHTML="Please enter a valid day.";
            return false;
        }
        //check Feb dates
        else if(day>28&&month==2) {
            //if it is not the 29th and in a year divisible by 4 (a leap year), alert user/end script.
            if(day!=29) {
                document.getElementById("profileerror").innerHTML="Please enter a valid day.";
                return false;
            }
            else if(year%4!=0) {
                document.getElementById("profileerror").innerHTML="Please enter a valid day.";
                return false;
            }
        }
        //check they 30 day months, if not correct alert user/end script
        else if(day>30&&month==4||month==6||month==9||month==11) {
            document.getElementById("profileerror").innerHTML="Please enter a valid day.";
            return false;
        }
        //if month out of range, alert user/end script
        if(month<1||month>12) {
            document.getElementById("profileerror").innerHTML="Please enter a valid month.";
            return false;
        }
        //get date
        var current=new Date();
        //if not in the past, alert user/end script
        if(year>=current.getFullYear()) {
            document.getElementById("profileerror").innerHTML="Please enter a valid year. Birthdays this year are not permitted.";
            return false;
        }
        //if bio too long, alert user/end script
        if(bio.length>240) {
            document.getElementById("profileerror").innerHTML="Your biography is too long!";
            return false;
        }
        //if website unacceptable, alert user/end script
        if(website.length>255) {
            document.getElementById("profileerror").innerHTML="That website is too long. Try and use a link shortener.";
            return false;
        }
        //otherwise, clear errors and proceed
        document.getElementById("profileerror").innerHTML="";
        return true;
    }
    else if(form=="email") {
        //get values
        var email=document.getElementById("newemail").value;
        var confirm=document.getElementById("confirmemail").value;
        //if emailed not entered, alert user/end script
        if(email.length==0) {
            document.getElementById("emailerror").innerHTML="Please enter an email."
            return false;
        }
        //if email too long, alert user/end script
        else if(email.length>254) {
            document.getElementById("emailerror").innerHTML="Please enter a valid email.";
            return false;
        }
        //validate email with regex
        else {
            //establish regex
            var regex=/[0-z.-]{1,}[@]{1}[A-z.-]{1,}[.][A-z]{2,9}/g;
            //test
            var correct=regex.test(email);
            //if testing successful, proceed
            if(correct==true) {
                //if email matches, clear errors and approve
                if(email==confirm) {
                    document.getElementById("emailerror").innerHTML="";
                    return true;
                }
                //otherwise, alert user/end script
                else {
                    document.getElementById("emailerror").innerHTML="Please ensure the two emails match.";
                    return false;
                }
            }
            //otherwise, alert user/end script
            else {
                document.getElementById("emailerror").innerHTML="Please enter a valid email.";
                return false;
            }
        }
    }
    else if(form=="password") {
        //get values
        var original=document.getElementById("original").value;
        var newpass=document.getElementById("newpass").value;
        var confirm=document.getElementById("confirmpass").value;
        //check a password has been entered, if not, alert user/end script
        if(original.length==0) {
            document.getElementById("passworderror").innerHTML="Please enter your current password.";
            return false;
        }
        //do the same, if not, alert user/end script
        else if(newpass.length==0) {
            document.getElementById("passworderror").innerHTML="Please enter a new password.";
            return false;
        }
        //repeat, if not, alert user/end script
        else if(confirm.length==0) {
            document.getElementById("passworderror").innerHTML="Please confirm your new password.";
            return false;
        }
        //check acceptable length, if not, alert user/end script
        else if(original.length<6||original.length>24) {
            document.getElementById("passworderror").innerHTML="Please enter a valid, current password.";
            return false;
        }
        //check new password is in length range, if not, alert user/end script
        else if(newpass.length<6||newpass.length>24) {
            document.getElementById("passworderror").innerHTML="Your new password is too short (less than six) or too long (more than twenty-four).";
            return false;
        }
        //check passwords match, if not, alert user/end script
        else if(newpass!=confirm) {
            document.getElementById("passworderror").innerHTML="Please ensure your new passwords match.";
            return false;
        }
        //otherwise, clear errors and approve
        document.getElementById("passworderror").innerHTML="";
        return true;
    }
    else if(form=="delete") {
        //get value
        var pass=document.getElementById("passdelete").value;
        //if no password, alert user/end script
        if(pass.length==0) {
            document.getElementById("deleteerror").innerHTML="Please enter a password.";
            return false;
        }
        //if password out of range, alert user/end script
        else if(pass.length<6||pass.length>24) {
            document.getElementById("deleteerror").innerHTML="Please enter a valid password.";
            return true;
        }
        //else, clear errors and approve
        document.getElementById("deleteerror").innerHTML="";
        return true;
    }
}
function count() {
    //get value
    var content=document.getElementById("bio").value;
    //set value to number of characters remaining
    document.getElementById("count").innerHTML=240-content.length;
    //if long, turn red
    if(content.length>240) {
        document.getElementById("count").style.color="#FF0000";
    }
    //otherwise, set green
    else {
        document.getElementById("count").style.color="#00FF00";
    }
}
//run count for initial value
count();
