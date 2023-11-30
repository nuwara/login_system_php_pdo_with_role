<?php
session_start();
require_once 'dbconfig.php';

$message = '';
$username = '';
if (isset($_POST['login_btn'])) {
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);

    if (empty($username) || empty($password)) {
        $message = 'All fields are required';
    } else {

        // query the db and prepare statement
        $sql = 'SELECT * FROM usertbl WHERE username=:username';
        $stmt = $conn->prepare($sql);

        // execute
        $stmt->execute(array('username' => $username));

        // check if user exists
        if ($stmt->rowCount() > 0) {

            // fetch existing record
            $result = $stmt->fetch();

            // compare and verify password
            if (password_verify($password, $result['password'])) {

                // check user role
                if ($result['role'] === 'admin') {
                    session_regenerate_id();
                    $_SESSION['loggedIn'] = true;
                    $_SESSION['username'] = $username;
                    // redirect to the admin
                    header('location: admin.php');
                } elseif ($result['role'] === 'teacher') {
                    session_regenerate_id();
                    $_SESSION['loggedIn'] = true;
                    $_SESSION['username'] = $username;
                    // redirect to the admin
                    header('location: teacher.php');
                } elseif ($result['role'] === 'student') {
                    session_regenerate_id();
                    $_SESSION['loggedIn'] = true;
                    $_SESSION['username'] = $username;
                    // redirect to the admin
                    header('location: student.php');
                } else {
                    $message = 'No user with this role';
                }
            } else {
                $message = 'Username or password is incorrect';
            }
        } else {
            $message = 'User does not exist';
        }
    }
}
?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>

    <div class="container my-5 align-center">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <h1 class="my-5">Login page</h1>
                <p class="text-danger"><?= $message ?></p>
                <form method="post" action="">
                    <div class="row mb-3">
                        <label for="phone" class="col-sm-2 col-form-label">Username</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="username" value="<?= $username ?>">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="phone" class="col-sm-2 col-form-label">Password</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" name="password">
                        </div>
                    </div>

                    <a href="index.php" class="btn btn-secondary">Cancel</a>
                    <input type="submit" class="btn btn-primary" name="login_btn" value="Login">
                </form>
            </div>
            <div class="col-md-3"></div>
        </div>


        <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>