<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

if ($_SESSION['possition'] != "employee") {
    header('Location: unknown.php');
    exit();
}
include_once "../views/navbar_employee.php";
require_once('../admin/db.php');

    if (isset($_GET['id']))
    {
        $id = $_GET['id'];
        $data = get_task_id($id);
        
        if ($data['tag_file'] == "") 
        {
            $namefile='';
        }
        else {
            $file=explode("/",$data['tag_file']); 
            if (isset($file['2'])) {
                $namefile = $file['2'];
            }
        }
    }
    else {
        header('Location: unknown.php');
        exit();
    }

if (isset($_POST['update'])) {

    $id = $_GET['id'];

    $result = update_task_status($id, "In progress");
    $p = update_task_process($id, "Chưa hoàn thành");

    if ($_SESSION['possition'] === "leader") {
        header('Location: ../views/leader_index.php');
    }
    header('Location: ../views/employee_index.php');
}
?>


<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                <h2 class="text-center text-dark mt-2 mb-3">Nhiệm vụ</h2>
                <form action="" method="post" class="border rounded w-100 mb-5 mx-auto px-3 pt-3 bg-light">
                    <div class="form-group">
                        <label for="name">Ngày giao</label>
                        <input type="text" name="ngaygiao" id="ngaygiao" value="<?= $data['start_day'] ?>" class="form-control" disabled>
                    </div>
                    <div class="form-group">
                        <label for="id">Hạn chót</label>
                        <input type="text" name="hanchot" id="hanchot" value="<?= $data['deadline'] ?>" class="form-control" disabled>
                    </div>
                    <div class="form-group">
                        <label for="">Trạng thái</label>
                        <input type="text" name="trạng thái" id="trạng thái" value="<?= $data['status'] ?>" class="form-control" disabled>
                    </div>
                    <div class="form-group">
                        <label for="user">Thông tin chi tiết:</label>
                        <textarea name="comment" id="comment" rows="5" class="form-control" disabled><?= $data['detail'] ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="">Tệp đính kèm: <a href="<?php echo $data['tag_file'] ?>" download><?= $namefile ?></a></label>
                    </div>
                    <div class="form-group text-center">
                        <button class="btn btn-success px-5 h-5" type="submit" name="update">Start</button>
                        <a href="../views/employee_index.php" class="btn btn-danger px-5 h-5">Return</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
