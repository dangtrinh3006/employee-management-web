<?php
if (!isset($_SESSION['user'])) {
    header('Location: ../views/login.php');
    exit();
}

require_once('../admin/db.php');
$user_id = $_SESSION['user'];
$id = get_department_user($user_id);
$data = get_task_department($id);
?>
<!doctype html>
<html lang="en">

<head>
    <title>Trưởng phòng</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
</head>


<body>
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
        <!-- Brand -->
        <div class="container">
            <a class="navbar-brand" href="../views/leader_index.php"><?= $_SESSION['fullname'] ?></a>
            <ul class="navbar-nav">
                <!-- Dropdown -->
                <div class="btn-group">
                    <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Quản lý
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="../views/dayoff_management.php">Quản lý ngày nghỉ</a>
                        <a class="dropdown-item" href="../views/leader_index.php">Quản lý nhiệm vụ</a>
                        <a class="dropdown-item" href="../views/employee_dayoff.php">Ngày nghỉ phép</a>
                    </div>
                </div>
                <div class="btn-group" style="margin-left: 10px;">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Cá nhân
                    </button>
                    <div class="dropdown-menu">
                        <a href="../views/employeeprofile.php?username=<?= $user_id ?>" class="dropdown-item">Thông tin cá nhân</a>
                        <a href="../views/resetpassword.php" class="dropdown-item">Đổi mật khẩu</a>
                        <a href="../views/logout.php" class="dropdown-item">Đăng xuất</a>
                    </div>
                </div>
            </ul>
        </div>
    </nav>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>


</html>