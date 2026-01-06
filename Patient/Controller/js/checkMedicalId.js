function checkMedicalId() {
    var medicalId = document.getElementById("medical_id").value;
    var errorElement = document.getElementById("medicalIdError");
    
    if (medicalId.length > 0) {
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "../Controller/checkMedicalId.php?medical_id=" + medicalId, true);
        
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                if (xhr.responseText == "exists") {
                    errorElement.innerHTML = "Medical ID already exists!";
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