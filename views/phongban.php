<?php 
    session_start();
    if (!isset($_SESSION['user'])) {
        header('Location: ../views/login.php');
        exit();
    }

    if ($_SESSION['possition'] != "admin") {
        header('Location: unknown.php');
        exit();
    }
    
    include_once "../views/navbar_admin.php";
    require_once("../admin/db.php");
    
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $data = get_department($id);
        if ($data['id'] != $id  ){
            header('Location: unknown.php');
        }
    }
    

    $error = "";

    if (isset($_GET['id']))
    {
        $id = $_GET['id'];
        $data = get_department($id);
        $data1 = getEmployeebyDepartment($id);
        $data2 = get_department_leader($id);

        $name = '';
        $userN = '';

        if ($data2['code'] == 0) {
            $tmp = $data2['data']->fetch_assoc();
            $name = $tmp['fullname'];
            $userN = $tmp['username'];
        }
        else
        {
            $name = "Chưa có trưởng phòng";
        }
    }

    if (isset($_POST['update'])) {
        if (empty($_POST['pb']) || empty($_POST['sophong']) || empty($_POST['comment']))
        {
            $error = "Invalid input";
        }
        else
        {
            $pb = $_POST['pb'];
            $sophong = $_POST['sophong'];
            $comment = $_POST['comment'];
            $id = $_GET['id'];

            if (empty($_POST['managet'])){
                $manager = $_POST['manager'];
                $result2 = down_manager($userN, $id);
                $result1 = update_manager($manager, $id);
            }
    
            $result = update_department($id, $pb, $sophong, $comment);
            header('Location: ../views/department_management.php');
        }
    }
    
?>


<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
            <h2 class="text-center text-dark mt-5 mb-3">Thông tin phòng ban</h2>
            <form action="" method="post" class="border rounded w-100 mb-5 mx-auto px-3 pt-3 bg-light">
                <div class="form-group">
                    <label for="id">Mã phòng ban</label>
                    <input disabled value="<?= $data['id'] ?>" type="text" name="mpb" id="mpb" class="form-control">
                </div>    
                <div class="form-group">
                    <label for="name">Tên phòng ban</label>
                    <input type="text" value="<?= $data['name'] ?>" name="pb" id="pb" class="form-control">
                </div>
                <div class="form-group">
                    <label for="sophong">Số phòng</label>
                    <input type="text" value="<?= $data['room'] ?>" name="sophong" id="sophong" class="form-control">
                </div>
                <div class="form-group">
                    <label for="">Trưởng phòng hiện tại</label>
                    <input type="text" value="<?= $name ?>" class="form-control" disabled> 
                </div>
                <div class="form-group">
                    <label for="comment">Mô tả</label>
                    <textarea name="comment" id="comment" rows="5" class="form-control"><?= $data['detail'] ?></textarea>
                </div>
                <div class="form-group">
                    <label for="">Thay trưởng phòng mới (nếu muốn)</label>
                    <select class="form-control" id="manager" name="manager">
                        <option value='<?php echo $employee = $userN ?>'><?= $name ?></option>
                        <?php 
                            if ($data1['code'] == 0) {
                                while ($row = $data1['data']->fetch_assoc()) {
                                    ?>
                                        <option value='<?php echo $employee = $row["username"] ?>'><?= $row['fullname'] ?></option>
                                    <?php
                                }
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group text-center">
                    <?php
                        if (!empty($error)) {
                            echo "<div class='alert alert-danger'>$error</div>";
                        }
                    ?>
                    <button class="btn btn-success px-5 h-5" type="submit" name="update">Update</button>
                    <a href="../views/department_management.php" class="btn btn-danger px-5 h-5">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>  
