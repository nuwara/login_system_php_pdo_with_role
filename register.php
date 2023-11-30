<?php
session_start();
require_once 'dbconfig.php';

$message = '';
$name = $email = $username = $password = '';
if (isset($_POST['register_btn'])) {
    $name = filter_input(INPUT_POST, 'fullname', FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_SPECIAL_CHARS);
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);
    $roll = filter_input(INPUT_POST, 'usertype', FILTER_SANITIZE_SPECIAL_CHARS);

    // encrypt the password
    $password = password_hash($password, PASSWORD_DEFAULT);

    if (empty($name) || empty($email) || empty($username) || empty($password) || empty($roll)) {
        $message = 'All field are are required';
    } else {

        // query the db and prepare statement
        $sql = 'INSERT INTO usertbl(name, email, username, password, roll) VALUES(:name, :email, :username, :password, :roll)';
        $stmt = $conn->prepare($sql);

        // bind the statement
        $stmt->bindValue(':name', $name);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':username', $username);
        $stmt->bindValue(':password', $password);
        $stmt->bindValue(':roll', $roll);

        // execute
        $result = $stmt->execute();
        if ($result) {
            header('location: login.php');
        } else {
            echo 'Error: ' . $stmt->errorInfo();
        }
    }
}

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>

    <div class="container my-5 align-center">

        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <h1>Register</h1>
                <p class="text-danger"><?= $message ?></p>
                <form method="post" action="">

                    <div class="row mb-3">
                        <label for="name" class="col-sm-2 col-form-label">Full Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="fullname" value="<?= $name ?>">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="phone" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="email" value="<?= $email ?>">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="phone" class="col-sm-2 col-form-label">Username</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="username" value="<?= $username ?>">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="phone" class="col-sm-2 col-form-label">User type</label>
                        <div class="col-sm-10">
                            <select class="form-select" name="usertype">
                                <option value="admin">admin</option>
                                <option value="teacher">teacher</option>
                                <option value="student">student</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="phone" class="col-sm-2 col-form-label">Password</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" name="password" value="<?= $password ?>">
                        </div>
                    </div>

                    <a href="index.php" class="btn btn-secondary">Cancel</a>
                    <input type="submit" class="btn btn-primary" name="register_btn" value="Register">

                </form>
            </div>
            <div class="col-md-2"></div>
        </div>


        <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>