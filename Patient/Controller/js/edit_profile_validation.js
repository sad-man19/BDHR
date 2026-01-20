function validateForm(){
    clearErrors();

    let errors=[];

    //phone
    const phone = document.getElementById("phone").value.trim();
    if(phone===""){
        errors.push("phone number is required");
        document.getElementById("phoneErr").innerHTML="phone number is required";
    }else if(!/^01[0-9]{9}$/.test(phone)){
        errors.push("Phone number must be 11 digits");
        document.getElementById("phoneError").innerHTML = "Invalid phone number";

    }

    //address
    const address =document.getElementById("address").value.trim();
    if(address ===""){
        errors.push("address is required");
        document.getElementById("addressErr").innerHTML="address is required";
    }else if(address.length <10){
        errors.push("address must be at least 10 characters");
        document.getElementById("addressErr").innerHTML="address must be at least 10 characters";
    }


    //password
    const currentPass = document.getElementById("current_password").value;
    const newPass =document.getElementById("new_password").value;
    const confirmPass= document.getElementById("confirm_password").value;

    const isChangingPassword = currentPass !=="" || newPass !=="" || confirmPass !=="";

    if(isChangingPassword) {
        if(currentPass === "") {
            errors.push("Current password is required");
            document.getElementById("currentPassErr").innerHTML = "Current password is required";
        }
        if(newPass === ""){
            errors.push("new password is required");
            document.getElementById("newPassErr").innerHTML = "new password is required";
        }else if(newPass.length<6){
            errors.push("new password must be at least 6 characters");
            document.getElementById("newPassErr").innerHTML = "new password must be at least 6 characters";
        }

        if(confirmPass === ""){
            errors.push("password must be confirmed");
            document.getElementById("newPassErr").innerHTML = "password must be confirmed";
        }else if(newPass !== confirmPass){
            errors.push("passwords do not match");
            document.getElementById("newPassErr").innerHTML = "passwords do not match";
        }

    }

    if(errors.length>0){
        alert("Please fix these:\n\n"+errors.join("\n"));
        return false;
    }
    return confirm("Are you sure to update your profile?");

}

function clearErrors(){
    const errorIds=["phoneErr", "addressErr", "currentPassErr", "newPassErr", "confirmPassErr"];
    errorIds.forEach(function(id){
        document.getElementById(id).innerHTML="";
    });
}