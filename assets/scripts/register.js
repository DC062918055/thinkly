function check() {
    //run forename validation
    var fn=fn();
    //run surname validation
    var sn=sn();
    //run email validation
    var ea=ea();
    //run username validation
    var un=un();
    //run password validation
    var pw=pw();
    //if issue with forename, halt registration
    if(fn==false) {
        return false;
    }
    //if issue with surname, halt registration
    else if(sn==false) {
        return false;
    }
    //if issue with email, halt registration
    else if(ea==false) {
        return false;
    }
    //if issue with username, halt registration
    else if(un==false) {
        return false;
    }
    //if issue with password, halt registration
    else if(pw==false) {
        return false;
    }
    //otherwise, authorise form to be sent to server
    else {
        return true;
    }
}
function fn() {
    //get value entered by user
    var fName=document.getElementById('fName').value;
    //get error message element
    var fNameError=document.getElementById('fNameError');
    //find length
    var length=fName.length;
    //check length
    if(length==0) {
        //inform user no name has been entered
        fNameError.innerHTML="Please enter your first name to create an account.";
        //halt registration
        return false;
    }
    else if(length>255) {
        //inform user entered name was too long
        fNameError.innerHTML="Your name is too long to process. Try using a nickname."; 
        //halt registration
        return false;
    }
    else {
        //clear error messages
        fNameError.innerHTML="";
        //approve forename input
        return true;
    }
}
function sn() {
    //get value entered by user
    var sName=document.getElementById('sName').value;
    //get error message element
    var sNameError=document.getElementById('sNameError');
    //find length
    var length=sName.length;
    //check length
    if(length==0) {
        //inform user no name has been entered
        sNameError.innerHTML="Please enter your surname to create an account.";
        //halt registration
        return false;
    }
    else if(length>255) {
        //inform user entered name is too long
        sNameError.innerHTML="Your name is too long to process. Try to use a shorter name.";
        //halt registration
        return false;
    }
    else {
        //clear error messages
        sNameError.innerHTML="";
        //approve surname input
        return true;
    }
}
function ea() {
    //get value entered by user
    var eAddr=document.getElementById('eAddr').value;
    //get error message element
    var eAddrError=document.getElementById('eAddrError');
    //find length
    var length=eAddr.length;
    //check length
    if(length==0) {
        //inform user no email has been entered
        eAddrError.innerHTML="Please enter your email to create an account.";
        //halt registration
        return false;
    }
    else if(length>254) {
        //inform user of invalid email address
        eAddrError.innerHTML="This is an invalid email address. Please try again.";
        //halt registration
        return false;
    }
    else {
        //store validation regular expression
        var regex="/[0-z.-]{1,}[@]{1}[A-z.-]{1,}[.][A-z]{2,9}/g";
        //validate
        var correct=regex.test(eAddr);
        if(correct==true) {
            //clear error messages
            eAddrError.innerHTML="";
            //approve email for registration
            return true;
        }
        else {
            //inform user of invalid email address
            eAddrError.innerHTML="This is an invalid email address. Please try again.";
            //halt registration
            return false;
        }
    }
}
