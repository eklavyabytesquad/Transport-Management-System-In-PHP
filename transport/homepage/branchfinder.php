<?php
// Include your database connection file here
// Assuming your connection file is named "connection.php"
require_once "../login/connection.php";

// Initialize variables
$locationName = $pincode = "";
$details = [];
//ksj;ogjas;okgsaoi
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the input values
    $locationName = $_POST["locationName"];
    $pincode = $_POST["pincode"];

    // Query to fetch details from the database based on either location name or pincode
    $query = "SELECT * FROM branchdetail WHERE locationName = ? OR pincode = ?";
    $stmt = mysqli_prepare($conn, $query);
    
    // Bind parameters
    mysqli_stmt_bind_param($stmt, "ss", $locationName, $pincode);
    
    // Execute the query
    mysqli_stmt_execute($stmt);
    
    // Get the result
    $result = mysqli_stmt_get_result($stmt);
    
    // Fetch data and store it in an array
    while ($row = mysqli_fetch_assoc($result)) {
        $details[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Location Details | SS TRANSPORT</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            max-width: 800px;
        }
        .card {
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0px 3px 10px rgba(0, 0, 0, 0.1);
        }
        .btn-copy {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Check Location Details | SS TRANSPORT</h2>
        <form method="POST">
            <div class="mb-3">
                <label for="locationName" class="form-label">Location Name</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="locationName" name="locationName" value="<?php echo $locationName; ?>" placeholder="Enter Location Name">
                    <button class="btn btn-outline-secondary" type="button" id="locationName-microphone" onclick="startSpeechRecognition('locationName')">&#128266;</button>
                </div>
            </div>
            <div class="mb-3">
                <label for="pincode" class="form-label">Pincode</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="pincode" name="pincode" value="<?php echo $pincode; ?>" placeholder="Enter Pincode">
                    <button class="btn btn-outline-secondary" type="button" id="pincode-microphone" onclick="startSpeechRecognition('pincode')">&#128266;</button>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>

        <!-- Display location details -->
        <?php if (!empty($details)) : ?>
            <div class="mt-5">
                <h3>Location Details</h3>
                <?php foreach ($details as $detail) : ?>
                    <div class="card mt-3">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $detail['locationName']; ?></h5>
                            <p class="card-text"><strong>Transport:</strong> <?php echo $detail['transport1']; ?></p>
                            <p class="card-text"><strong>Pincode:</strong> <?php echo $detail['pincode']; ?></p>
                            <p class="card-text"><strong>Address:</strong> <?php echo $detail['address']; ?></p>
                            <p class="card-text"><strong>GST No:</strong> <?php echo $detail['gstNo']; ?></p>
                            <p class="card-text"><strong>Contact Number:</strong> <?php echo $detail['number']; ?></p>
                            <button class="btn btn-success btn-copy" onclick="copyToClipboard('<?php echo $detail['number']; ?>')">Copy Number</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- JavaScript to copy the contact number to clipboard and handle microphone input -->
    <script>
        function copyToClipboard(text) {
            var input = document.createElement('input');
            input.setAttribute('value', text);
            document.body.appendChild(input);
            input.select();
            document.execCommand('copy');
            document.body.removeChild(input);
            alert('Contact number copied to clipboard: ' + text);
        }

        function startSpeechRecognition(inputId) {
            if ('SpeechRecognition' in window || 'webkitSpeechRecognition' in window) {
                var recognition = new (window.SpeechRecognition || window.webkitSpeechRecognition)();
                recognition.lang = 'en-US';

                recognition.onstart = function () {
                    console.log('Voice recognition started. Speak into the microphone.');
                };

                recognition.onresult = function (event) {
                    var transcript = event.results[0][0].transcript;
                    document.getElementById(inputId).value = transcript;
                };

                recognition.onerror = function (event) {
                    console.error('Speech recognition error:', event.error);
                };

                recognition.onend = function () {
                    console.log('Voice recognition ended.');
                };

                recognition.start();
            } else {
                alert('Speech recognition is not supported in your browser.');
            }
        }
    </script>
</body>
</html>
