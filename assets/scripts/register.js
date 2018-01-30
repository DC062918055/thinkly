function check() {
    //run forename validation
    var fn=firstnameValid();
    //run surname validation
    var sn=surnameValid();
    //run email validation
    var ea=emailaddressValid();
    //run username validation
    var un=usernameValid();
    //run password validation
    var pw=passwordValid();
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
function firstnameValid() {
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
function surnameValid() {
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
function emailaddressValid() {
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
function usernameValid() {
    //get value entered by user
    var uName=document.getElementById('uName').value;
    //get error message element
    var uNameError=document.getElementById('uNameError');
    //find length
    var length=uName.length;
    //check length
    if(length==0) {
        //inform user no username has been entered
        uNameError.innerHTML="Please enter a username.";
        //halt registration
        return false;
    }
    else if(length>16) {
        //inform user of invalid username
        uNameError.innerHTML="That username is too long (more than sixteen), please try a shorter one.";
        //halt registration
        return false;
    }
    else {
        //store validation regular expression
        var regex="/[0-z]/g";
        //validate
        var correct=regex.test(uName);
        //validate
        if(correct==true) {
            //clear error messages
            uNameError.innerHTML="";
            //approve username for registration
            return true;
        }
        else {
            //inform user of invalid username
            uNameError.innerHTML="This is an invalid username, please ensure your username is simply characters and numbers.";
            //halt registration
            return false;
        }
    }
}
function passwordValid() {
    //get value entered by user
    var pWord=document.getElementById('pWord').value;
    //get error message element
    var pWordError=document.getElementById('pWordError');
    //find length
    var length=pWord.length;
    //check length
    if(length==0) {
        //inform user no password has been entered
        pWordError.innerHTML="Please enter a password.";
        //halt registration
        return false;
    }
    else if(length<6||length>24) {
        //inform user of invalid password
        pWordError.innerHTML="Your password is too short (less than six) or too long (more than twenty-four).)";
        //halt registration
        return false;
    }
    else {
        //get confirm password from user
        var cpWord=document.getElementById('cpWord').value;
        //get matching password error
        var cpWordError=document.getElementById('cpWordError');
        //check passwords match
        if(pWord==cpWord) {
            //clear any errors
            cpWordError.innerHTML="";
            //approve password for registration
            return true;
        }
        else {
            //otherwise, inform user
            cpWordError.innerHTML="The passwords entered do not match, please ensure they do.";
            //halt registration
            return false;
        }
    }
}
