<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user'];

if ($_SESSION['possition'] == "admin") {
    include_once "../views/navbar_admin.php";
} else if ($_SESSION['possition'] == "leader") {
    include_once "../views/navbar_leader.php";
} else {
    include_once "../views/navbar_employee.php";
}
require_once('../admin/db.php');
$error = '';
if (isset($_POST['newpass']) || isset($_POST['conpass']) || isset($_POST['pass'])) {
    if (strlen($_POST['newpass']) < 6) {
        $error = "Your new password must have at least 6 characters";
    }
    else if ($_POST['newpass'] != $_POST['conpass']) {
        $error = "Password does not match";
    }
    else {
        $login = login($_SESSION['user'], $_POST['pass']);
        if ($login['code'] == 3) {
            $error = "Your current password is not correct";
        } else {
            $ft_result = updatePassword($_SESSION['user'], $_POST['newpass']);
            if ($ft_result['code'] == 0) {
                header('Location: login.php');
            }
        }
    }
}


?>

<!doctype html>
<html lang="en">




    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <h3 class="text-center text-secondary mt-5 mb-3">Change Password</h3>
                <form method="post" action="resetpassword.php" class="border rounded w-100 mb-5 mx-auto px-3 pt-3 bg-light">
                    <div class="form-group">
                        <label for="password">Username</label>
                        <input disabled class="form-control" value="<?php echo $_SESSION['user'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="password">Current Password</label>
                        <input required name="pass" id="password" type="password" class="form-control" placeholder="Enter your current password">
                    </div>
                    <div class="form-group">
                        <label for="password">New Password</label>
                        <input required name="newpass" id="newpass" type="password" class="form-control" placeholder="Enter your new password">
                    </div>
                    <div class="form-group">
                        <label for="password">Confirm Password</label>
                        <input required name="conpass" id="conpass" type="password" class="form-control" placeholder="Confirm your new password">
                    </div>
                    <div class="form-group">
                        <?php
                        if (!empty($error)) {
                            echo "<div class='alert alert-danger'>$error</div>";
                        }
                        if ($_SESSION['possition'] === "leader") {
                        ?>
                            <p class="text-center">
                                <button type="submit" class="btn btn-success px-5 h-5">Change</button></span>
                                <a href="leader_index.php" class="btn btn-danger px-5 h-5">Cancel</a></span>
                            </p>
                        <?php
                        } else {
                        ?>
                            <p class="text-center">
                                <button type="submit" class="btn btn-success px-5 h-5">Change</button></span>
                                <a href="employee_index.php" class="btn btn-danger px-5 h-5">Cancel</a></span>
                            </p>
                        <?php
                        }
                        ?>
                    </div>
                </form>
            </div>
        </div>
    </div>
