<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Download Branch List</title>
<!-- Bootstrap CSS -->
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h2 class="text-center">Download Branch List  <br>SS TRASNPORT</h2>
                </div>
                <div class="card-body text-center">
                    <button class="btn btn-primary" onclick="downloadBranchList()">Download</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function downloadBranchList() {
    // Redirect to the PHP script to generate the branch list
    window.location.href = 'generate_branch_list.php';
}
</script>

</body>
</html>
