function checkLicenseNo() {
    var licenseNo = document.getElementById("license_no").value;
    var errorElement = document.getElementById("licenseNoError");
    
    if (licenseNo.length > 0) {
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "../Controller/checkLicenseNo.php?license_no=" + licenseNo, true);
        
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                if (xhr.responseText == "exists") {
                    errorElement.innerHTML = "License Number already exists!";
                    errorElement.style.color = "red";
                } else {
                    errorElement.innerHTML = "✓ Available";
                    errorElement.style.color = "green";
                }
            }
        };
        xhr.send();
    } else {
        errorElement.innerHTML = "";
    }
}