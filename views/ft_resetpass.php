<?php
session_start();
if (!isset($_SESSION['reset'])) {
    header('Location: login.php');
    exit();
}
$error = '';
require_once('../admin/db.php');
if (isset($_POST['password']) && isset($_POST['cfpassword'])) {
    if (!empty($_POST['password']) && !empty($_POST['cfpassword'])) {
        if ($_POST['password'] != $_POST['cfpassword']) {
            $error = 'Password does not match';
        } else {
            $ft_result = updatePassword($_SESSION['reset'], $_POST['cfpassword']);
            if ($ft_result['code'] == 0) {
                header('Location: login.php');
            }
        }
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <title>Change password</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <h3 class="text-center text-secondary mt-5 mb-3">Reset Password</h3>
                <form method="post" action="" class="border rounded w-100 mb-5 mx-auto px-3 pt-3 bg-light">
                    <div class="form-group">
                        <label for="password">New Password</label>
                        <input name="password" id="password" type="password" class="form-control" placeholder="Enter your new password">
                    </div>
                    <div class="form-group">
                        <label for="password">Confirm Password</label>
                        <input name="cfpassword" id="cfpassword" type="password" class="form-control" placeholder="Confirm your new password">
                    </div>
                    <div class="form-group text-center">
                        <?php
                        if (!empty($error)) {
                            echo "<div class='alert alert-danger'>$error</div>";
                        }
                        ?>
                        <div class="form-group">
                            <p class="text-center">
                                <button class="btn btn-success px-5 h-5">Change</button>
                                <a href="logout.php" class="btn btn-danger px-5 h-5">Logout</a>
                            </p>
                        </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>