<?php
// Include your database connection file here
// Assuming your connection file is named "connection.php"
require_once "..\login\connection.php";

// Function to sanitize input
function sanitize_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// Initialize variables
$location = $pincode = $weight = $total = "";
$error = "";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate input
    $location = sanitize_input($_POST["location"]);
    $pincode = sanitize_input($_POST["pincode"]);
    $weight = sanitize_input($_POST["weight"]);

    // Query the database to get the amount based on location or pincode
    $query = "SELECT amount, pincode FROM branchdetail WHERE locationName = '$location' OR pincode = '$pincode'";
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $amount = $row['amount'];
        $pincode = $row['pincode'];
        
        // Calculate total value
        $total = $amount * $weight;
    } else {
        $error = "Location or pincode not found";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Goods Value Calculator</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0">Goods Value Calculator | SS TRANSPORT</h5>
            </div>
            <div class="card-body">
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <div class="form-group">
                        <label for="location">Location Name:</label>
                        <div class="input-group">
                            <input type="text" id="location" name="location" class="form-control" placeholder="Enter Location Name" value="<?php echo $location; ?>">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button" id="locationMic"><i class="fas fa-microphone"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="pincode">Pincode :</label>
                        <div class="input-group">
                            <input type="text" id="pincode" name="pincode" class="form-control" placeholder="Enter Pincode" value="<?php echo $pincode; ?>">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button" id="pincodeMic"><i class="fas fa-microphone"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="weight">Weight of Goods In KG:</label>
                        <div class="input-group">
                            <input type="number" id="weight" name="weight" class="form-control" placeholder="Enter Weight In KG" value="<?php echo $weight; ?>">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button" id="weightMic"><i class="fas fa-microphone"></i></button>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Calculate</button>
                </form>

                <?php if ($_SERVER["REQUEST_METHOD"] == "POST" && empty($error)): ?>
                    <div id="result" class="mt-4">
                        <p>Location: <?php echo $location; ?></p>
                        <p>Pincode: <?php echo $pincode; ?></p>
                        <p>Total Value: <?php echo $total; ?></p>
                    </div>
                <?php elseif ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($error)): ?>
                    <div class="alert alert-danger mt-4" role="alert">
                        <?php echo $error; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        // Function to initialize speech recognition
        function initSpeechRecognition(fieldId) {
            const recognition = new webkitSpeechRecognition();
            recognition.lang = 'en-US';
            recognition.interimResults = false;
            recognition.maxAlternatives = 1;

            recognition.onresult = function(event) {
                const speechResult = event.results[0][0].transcript;
                document.getElementById(fieldId).value = speechResult;
            };

            recognition.onerror = function(event) {
                console.error('Speech recognition error:', event.error);
            };

            return recognition;
        }

        // Add event listeners to microphone buttons
        document.getElementById('locationMic').addEventListener('click', function() {
            const recognition = initSpeechRecognition('location');
            recognition.start();
        });

        document.getElementById('pincodeMic').addEventListener('click', function() {
            const recognition = initSpeechRecognition('pincode');
            recognition.start();
        });

        document.getElementById('weightMic').addEventListener('click', function() {
            const recognition = initSpeechRecognition('weight');
            recognition.start();
        });
    </script>
</body>
</html>
