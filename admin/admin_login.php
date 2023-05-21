<?php 
include '../components/connect.php';


$error_message = '';

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // RETRIEVE USER FROM DATABASE
    $stmt = $conn->prepare("SELECT * FROM `admin` WHERE username=:username");
    $stmt->bindParam(":username", $username, PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (password_verify($password, $row['password'])) {
            // START SESSION AND REDIRECT TO HOME PAGE
            session_start();
            $_SESSION['admin_id'] = $row['id'];
        } else {
            $error_message = "Incorrect email or password.";
        }
    } else {
        $error_message = "Incorrect email or password.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN PAGE</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <form class="p-5 bg-light" method="POST">
            <h1 class="mb-4 text-center" style="color: blue;">Login Form</h1>
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">LOGIN</button>
            <div class="help">
            <span>If you don't have an account please.. <a href="admin_register.php">register here.</a></span>
            </div>
        </form>
    </div>

    <!-- SWEETALERT SCRIPT -->
    <?php if (isset($_SESSION['user_id'])): ?>
        <script>
            swal("Success", "You have successfully logged in!", "success")
                .then(function() {
                    window.location.href = 'dashboard.php';
                });
        </script>
    <?php endif ?>

    <?php if ($error_message): ?>
        <script>
            swal("Error", "<?= $error_message ?>", "error");
        </script>
    <?php endif ?>

</body>
</html>