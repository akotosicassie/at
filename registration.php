<?php 
include 'components/connect.php';
if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (strlen($password) < 8) {
        $error_message = "Password must be at least 8 characters long.";
    } else {
        $password = password_hash($password, PASSWORD_DEFAULT);

        // INSERTING INTO DATABASE
        $stmt = $conn->prepare("INSERT INTO `users` (name, username, password) VALUES (:name, :username, :password)");
        $stmt->bindParam(":name", $name, PDO::PARAM_STR);
        $stmt->bindParam(":username", $username, PDO::PARAM_STR);
        $stmt->bindParam(":password", $password, PDO::PARAM_STR);
        $stmt->execute();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BCASH REGISTRATION</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>

<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <form class="p-5 bg-light" method="POST">
            <h1 class="mb-4 text-center" style="color: blue;">Registration Form</h1>
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
            <div class="help">
            <span>If you already have an account please.. <a href="login.php">Login</a></span>
            </div>
        </form>
    </div>
<!-- SWEETALERT SCRIPT -->
<script>
    // Show success message when form is submitted successfully
    <?php if (isset($stmt) && $stmt->rowCount() > 0 && !isset($error_message)) { ?>
        swal("Registration Successful", "You have successfully registered.", "success")
            .then(function() {
                window.location.href = 'login.php';
            });
    <?php } ?>

    // Show error message if there was an error
    <?php if (isset($error_message)) { ?>
        swal("Registration Failed", "<?php echo $error_message; ?>", "error");
    <?php } ?>
</script> 

</body>
</html>