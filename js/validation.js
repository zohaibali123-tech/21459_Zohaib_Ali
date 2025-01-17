function validateForm() {
    var flag = true;
	
    
    /*---------- Patterns Start -----------*/
        
        var alpha_pattern      = /^[A-Z]{1}[a-z]{2,}$/;
        var email_pattern      = /^[a-z]+\d*[@]{1}[a-z]+[.]{1}(com|net){1}$/;
        var password_pattern   = /^[0-9]{8}$/;


    /*---------- Target Start -----------*/

        var first_name         = document.getElementById("first_name").value;
        var last_name          = document.getElementById("last_name").value;
        var email              = document.getElementById("email").value;
        var password           = document.getElementById("password").value;
        var confirm_password   = document.getElementById("confirm_password").value;
        var gender             = document.querySelector("input[name='gender']:checked");
        var date_of_birth      = document.getElementById("date_of_birth").value;
        var file               = document.getElementById("file").value;
        var home_town          = document.getElementById("home_town").value;   


    /*---------- Target ERROR Messages Start -----------*/

        var first_name_msg         = document.getElementById("first_name_msg");
        var last_name_msg          = document.getElementById("last_name_msg");
        var email_msg              = document.getElementById("email_msg");
        var password_msg           = document.getElementById("password_msg");
        var confirm_password_msg   = document.getElementById("confirm_password_msg");
        var gender_msg             = document.getElementById("gender_msg");
        var dob_msg                = document.getElementById("date_msg");
        var file_msg               = document.getElementById("file_msg");
        var home_town_msg          = document.getElementById("home_town_msg");


    /*---------- First Name Start -----------*/

	if (first_name === "") {
        flag = false;
        first_name_msg.innerHTML = "First Name Is Required.";

    } else {
        first_name_msg.innerHTML = "";
        if (alpha_pattern.test(first_name) === false) {
            flag = false;
            first_name_msg.innerHTML = "First Alphabets Must Be Capital. ";
        }
    }

    /*---------- First Name END -----------*/

    /*---------- Last Name Start -----------*/

    if (last_name !== "") {
        last_name_msg.innerHTML = "";
        if (alpha_pattern.test(last_name) === false) {
            flag = false;
            last_name_msg.innerHTML = "First Alphabets Must Be Capital.";
        }

    } else {
        last_name_msg.innerHTML = "";
    }

    /*---------- Last Name END -----------*/

    /*---------- Email Start -----------*/
    
    if (email === "") {
        flag = false;
        email_msg.innerHTML = "Email Is Required.";

    } else {
        email_msg.innerHTML = "";
        if (email_pattern.test(email) === false) {
            flag = false;
            email_msg.innerHTML = "Email Must Be name@example.com|net name12@example.com|net.";
        }
    }

    /*---------- Email END -----------*/

    /*---------- Password Start -----------*/

    if (password === "") {
        flag = false;
        password_msg.innerHTML = "Password Is Required.";

    } else {
        password_msg.innerHTML = "";
        if (password_pattern.test(password) === false) {
            flag = false;
            password_msg.innerHTML = "Password Must Be Numeric And Up To 8 Digits.";
        }
    }

    /*---------- Password END -----------*/

    /*---------- Confirm Password Start-----------*/

    if (confirm_password === "") {
        flag = false;
        confirm_password_msg.innerHTML = "Confirm Password Is Required.";

    } else {
        confirm_password_msg.innerHTML = "";
        if (confirm_password !== password) {
            flag = false;
            confirm_password_msg.innerHTML = "Passwords Not Match.";
        }
    }

    /*---------- Confirm Password END -----------*/

    /*---------- Gender Start -----------*/

    if (!gender) {
        flag = false;
        gender_msg.innerHTML = "Gender Required.";

    } else {
        gender_msg.innerHTML = "";
    }

    /*---------- Gender END -----------*/

    /*---------- Date Of Birth Start ----------*/

    if (date_of_birth === "") {
        flag = false;
        dob_msg.innerHTML = "Date Of Birth Is Required.";
    } else {
        dob_msg.innerHTML = "";
    }

    /*---------- Date Of Birth END ----------*/

    /*---------- FILE Start ----------*/

    if (file === "") {
        flag = false;
        file_msg.innerHTML = "File Is Required.";
    
    } else {
        file_msg.innerHTML = "";
        if (file.size > 1024 * 1024) {
            file_msg.innerHTML = "File Size Must Be Less Than 1MB.";
        }
    }

    /*---------- FILE END ----------*/

    /*---------- Home Town Start ----------*/

    if (home_town === "") {
        flag = false;
        home_town_msg.innerHTML = "Home Town Is Required.";

    } else {
        home_town_msg.innerHTML = "";
    }

    /*---------- Home Town END ----------*/

    if (flag === true) {
        return true;
    } else {
        return false;
    }

}