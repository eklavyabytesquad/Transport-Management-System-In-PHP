<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enquiry Form SS TRANSPORT</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-center text-primary">Enquiry Form जानकारी फॉर्म</h5>
                        <h5 class="card-title text-center text-primary">बोलने के लिए माइक दबाएं</h5>
                        <?php
                        if (isset($_POST["submit"])) {
                            $fullName = $_POST["fullname"];
                            $mobileno = $_POST["mobileno"];
                            $companyname = $_POST["companyname"];
                            $gstno = $_POST["gstno"];

                            require_once "connection.php";
                            $sql = "INSERT INTO users (fullName, mobileno, companyname, gstno) VALUES (?, ?, ?, ?)";
                            $stmt = mysqli_stmt_init($conn);
                            if (mysqli_stmt_prepare($stmt, $sql)) {
                                mysqli_stmt_bind_param($stmt, "ssss", $fullName, $mobileno, $companyname, $gstno);
                                mysqli_stmt_execute($stmt);
                                echo "<div class='alert alert-success'>You are registered successfully.</div>";
                            } else {
                                // Display SQL error
                                echo "<div class='alert alert-danger'>Error: " . mysqli_error($conn) . "</div>";
                            }
                        }
                        ?>
                        <form action="enquiry.php" method="post">
                            <div class="mb-3">
                                <label for="fullname" class="form-label text-primary">Full Name पूरा नाम</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="fullname" id="fullname" placeholder="Full Name पूरा नाम " required>
                                    <button type="button" class="btn btn-outline-secondary" id="fullname-mic"><i class="fas fa-microphone-alt"></i></button>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="mobileno" class="form-label text-primary">Mobile Number मोबाइल नंबर</label>
                                <div class="input-group">
                                    <input type="tel" class="form-control" name="mobileno" id="mobileno" placeholder="Mobile Number मोबाइल नंबर" required>
                                    <button type="button" class="btn btn-outline-secondary" id="mobileno-mic"><i class="fas fa-microphone-alt"></i></button>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="companyname" class="form-label text-primary">Company Name कंपनी का नाम</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="companyname" id="companyname" placeholder="Company Name कंपनी का नाम" required>
                                    <button type="button" class="btn btn-outline-secondary" id="companyname-mic"><i class="fas fa-microphone-alt"></i></button>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="gstno" class="form-label text-primary">GST NO जी-एस-टी नं</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="gstno" id="gstno" placeholder="GST NO जी-एस-टी नं" required>
                                    <button type="button" class="btn btn-outline-secondary" id="gstno-mic"><i class="fas fa-microphone-alt"></i></button>
                                </div>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary" name="submit">Register</button>
                            </div>
                        </form>
                        <div class="mt-3 text-center">
                            <p>WANT TO GO BACK <a href="../index.php">Main Page</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Font Awesome JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
    <script>
        // Function to handle voice input
        function handleVoiceInput(inputFieldId) {
            const recognition = new webkitSpeechRecognition(); // For Chrome
            recognition.continuous = false;
            recognition.lang = 'en-US';
            recognition.interimResults = false;
            recognition.maxAlternatives = 1;

            recognition.onresult = function(event) {
                const result = event.results[0][0].transcript;
                document.getElementById(inputFieldId).value = result;
            }

            recognition.start();
        }

        // Event listeners for voice input buttons
        document.getElementById('fullname-mic').addEventListener('click', function() {
            handleVoiceInput('fullname');
        });

        document.getElementById('mobileno-mic').addEventListener('click', function() {
            handleVoiceInput('mobileno');
        });

        document.getElementById('companyname-mic').addEventListener('click', function() {
            handleVoiceInput('companyname');
        });

        document.getElementById('gstno-mic').addEventListener('click', function() {
            handleVoiceInput('gstno');
        });


        // Function to store form field values in cookies
function setCookie(name, value, days) {
    var expires = "";
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "") + expires + "; path=/";
}

// Function to retrieve form field values from cookies
function getCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1, c.length);
        }
        if (c.indexOf(nameEQ) == 0) {
            return c.substring(nameEQ.length, c.length);
        }
    }
    return null;
}

// Function to set form field values from cookies if available
function setFormValuesFromCookies() {
    document.getElementById('fullname').value = getCookie('fullname') || '';
    document.getElementById('mobileno').value = getCookie('mobileno') || '';
    document.getElementById('companyname').value = getCookie('companyname') || '';
    document.getElementById('gstno').value = getCookie('gstno') || '';
}

// Call function to set form field values from cookies when the page loads
window.onload = function() {
    setFormValuesFromCookies();
}

// Event listener for form submission to store field values in cookies
document.querySelector('form').addEventListener('submit', function() {
    setCookie('fullname', document.getElementById('fullname').value, 30);
    setCookie('mobileno', document.getElementById('mobileno').value, 30);
    setCookie('companyname', document.getElementById('companyname').value, 30);
    setCookie('gstno', document.getElementById('gstno').value, 30);
});

    </script>
</body>
</html>
