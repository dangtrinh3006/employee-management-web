<?php
session_start();
if (isset($_SESSION['user'])) {
    if ($_SESSION['possition'] == 'admin') {
        header('Location: admin_index.php');
        exit();

    }

    if ($_SESSION['possition'] == 'leader') {
        header('Location: leader_index.php');
        exit();

    }

    if ($_SESSION['possition'] == 'employee') {
        header('Location: employee_index.php');
        exit();

    }
}

require_once('../admin/db.php');

$error = '';

$user = '';
$pass = '';

if (isset($_POST['user']) && isset($_POST['pass'])) {
    $user = $_POST['user'];
    $pass = $_POST['pass'];


    if (empty($user)) {
        $error = 'Please enter your username';
    } else if (empty($pass)) {
        $error = 'Please enter your password';
    } else if (strlen($pass) < 6 && $pass != $user) {
        $error = 'Password must have at least 6 characters';
    } else {
        $result = login($user, $pass);

        if ($result['code'] == 0) {
            $data = $result['data'];
            $_SESSION['user'] = $user;
            $_SESSION['fullname'] = $data['fullname'];
            $_SESSION['possition'] = $data['possition'];
            if ($_SESSION['possition'] === 'admin') {
                header('Location: ../views/admin_index.php');
            } else if ($_SESSION['possition'] === 'employee') {
                header('Location: ../views/employee_index.php');
            } else {
                header('Location: leader_index.php');
            }
            exit();
        } else if ($result['code'] == 100) {
            $_SESSION['reset'] = $user;
            header('Location:ft_resetpass.php');
            exit();
        } else {
            $error = $result['error'];
        }
    }
}
?>


<!doctype html>
<html lang="en">

<head>
    <title>Đăng nhập</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <h2 class="text-center text-danger mt-5 mb-3">QUẢN LÝ NHÂN SỰ</h1>
                <h3 class="text-center text-primary mt-5 mb-3">Đăng nhập</h3>
                <form method="post" action="" class="border rounded w-100 mb-5 mx-auto px-3 pt-3 bg-light">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input name="user" id="user" type="text" class="form-control" placeholder="Nhập Username">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input name="pass" id="password" type="password" class="form-control" placeholder="Nhập Password">
                    </div>
                    <div class="form-group text-center">
                        <?php
                        if (!empty($error)) {
                            echo "<div class='alert alert-danger'>$error</div>";
                        }
                        ?>
                        <button class="btn btn-success px-5">Login</button>
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