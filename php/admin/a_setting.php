<?php
include "../../PhpConfig/delete.php";

if (isset($_GET['id'])) {
    deleteDepartment($_GET['id'], $conn);
    header("location: a_setting.php");
}

if (isset($_POST['department'])) {
    $Dname = $_POST['department'];
    $insert = "INSERT INTO `department` VALUES (NULL,'$Dname')";
    if (mysqli_query($conn, $insert)) {
        echo "<div class='alert alert-primary' role='alert'>Record insert successfully</div>";
        header("location:a_setting.php");
    } else {
        echo mysqli_error($conn);
        echo "<div class='alert alert-danger' role='alert'>Error inserting record: </div>";
    }
}

$select2 = "SELECT * FROM `subject` INNER JOIN `department` ON subject.D_id = department.D_id";
$s2 = mysqli_query($conn, $select2);

if (isset($_GET['idSubject'])) {
    deleteSubject($_GET['idSubject'], $conn);
    header("location: a_setting.php");
}

if (isset($_POST['subject'])) {
    $Sname = $_POST['subject'];
    $Did = $_POST['Did'];
    $insert = "INSERT INTO `subject` VALUES (NULL,'$Sname',$Did)";
    if (mysqli_query($conn, $insert)) {
        echo "<div class='alert alert-primary' role='alert'>Record insert successfully</div>";
        header("location:a_setting.php");
    } else {
        echo mysqli_error($conn);
        echo "<div class='alert alert-danger' role='alert'>Error inserting record: </div>";
    }
}

if (isset($_GET['remBlock'])) {
    deleteBlock($_GET['remBlock'], $conn);
    header("location:a_setting.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
    <!-- the font icon -->
    <link href="../../css/all.min.css" rel="stylesheet">
    <!-- bootstrab css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <!-- navbar -->
    <link rel="stylesheet" href="../../css/student/s_navbar.css">
    <!-- my css -->
    <link rel="stylesheet" href="../../css/student/s_profile.css">
    <link rel="stylesheet" href="../../css/admin/a_setting.css">
</head>

<body>
    <!-- navbar -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <a class="navbar-brand" href="#"><img src="../../images/logo.jpeg" alt="school logo"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="a_subjects.php">Subjects</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="a_teacher.php">Teachers</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="a_students.php">Students</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="a_tickets.php">tickets</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="a_home.php">Home</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
                        <div class="chip">
                            <img src="../../images/img_avatar.png" alt="Person" width="96" height="96">
                            Admin
                        </div>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="a_setting.php">Settings</a>
                        <a class="dropdown-item" href="#">اللغه العربيه</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="../home.php">log out</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>

    <br><br><br><br><br>
    <!-- body -->
    <div class="container">
        <div class="accordion" id="accordionExample">
            <div class="card">
                <div id="btn1" class="btn-toggle btn-block active" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    Departments
                    <i id="ibtn1" class="float-right fas fa-caret-right"></i>
                </div>
                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                    <div class="card-body pr-5 pl-5">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Department</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $select = "SELECT * FROM `department`";
                                $s = mysqli_query($conn, $select);
                                $counter = 1;
                                foreach ($s as $data) { ?>
                                    <tr>
                                        <th scope="row"><?= $counter ?></th>
                                        <td><?php echo $data['D_name'] ?></td>
                                        <td>
                                            <form action="<?= $_SERVER['PHP_SELF'] ?>" method="GET">
                                                <input type="hidden" name="id" value="<?= $data['D_id'] ?>">
                                                <input type="submit" value="Delete" class="btn btn-danger">
                                            </form>
                                        </td>
                                    </tr>
                                <?php $counter++;
                                } ?>
                            </tbody>
                        </table>
                        <button class="btn btn-outline-success btn-block" id="newDepartment"><i class="fas fa-plus-circle"></i></button>
                    </div>
                </div>
            </div>
            <div class="card">
                <div id="btn2" class="btn-toggle btn-block" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    Subjects
                    <i id="ibtn2" class="float-right fas fa-caret-right"></i>
                </div>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                    <div class="card-body pr-5 pl-5">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Department</th>
                                    <th scope="col">Subject</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $counter = 1;
                                foreach ($s2 as $data) { ?>
                                    <tr>
                                        <th scope="row"><?= $counter ?></th>
                                        <td><?= $data['D_name'] ?></td>
                                        <td><?= $data['S_name'] ?></td>
                                        <td>
                                            <form action="<?= $_SERVER['PHP_SELF'] ?>" method="GET">
                                                <input type="hidden" name="idSubject" value="<?= $data['S_id'] ?>">
                                                <input type="submit" value="Delete" class="btn btn-danger">
                                            </form>
                                        </td>
                                    </tr>
                                <?php $counter++;
                                } ?>
                            </tbody>
                        </table>
                        <button class="btn btn-outline-success btn-block" id="newSubject"><i class="fas fa-plus-circle"></i></button>
                    </div>
                </div>
            </div>
            <div class="card mb-5">
                <div id="btn3" class="btn-toggle btn-block" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                    Block list
                    <i id="ibtn3" class="float-right fas fa-caret-right"></i>
                </div>
                <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                    <div class="card-body pr-5 pl-5">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Full Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col">Teacher name</th>
                                    <th scope="col">Comment</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $select = "SELECT * FROM `block` NATURAL JOIN `student`";
                                $s = mysqli_query($conn, $select);
                                foreach ($s as $data) {
                                ?>
                                    <tr>
                                        <th scope="row"><?= $data['B_id'] ?></th>
                                        <td><?= $data['St_fname'] . " " . $data['St_lname'] ?></td>
                                        <td><?= $data['St_email'] ?></td>
                                        <td><?= $data['St_phNumber'] ?></td>
                                        <td><?= $data['T_name'] ?></td>
                                        <td><?= $data['comment'] ?></td>
                                        <td>
                                            <form action="a_setting.php" method="GET">
                                                <input type="hidden" name="remBlock" value="<?= $data['St_id'] ?>">
                                                <button type="submit" class="btn btn-info">remove block</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- add department -->
    <div>
        <div class="department">
            <div class="cont">
                <i class="far fa-times-circle" id="exit" style="font-size: 30px; text-align: center; cursor: pointer;"></i>
                <h2>Department name:</h2>
                <div style="text-align: center;">
                    <hr>
                    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
                        <br>
                        <input type="text" class="form-control" name="department" id="department" require>
                        <input type="submit" value="Add" id="add" class="btn btn-info btn-block mt-4">
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- add subject -->
    <div>
        <div class="subject">
            <div class="cont">
                <i class="far fa-times-circle" id="exit2" style="font-size: 30px; text-align: center; cursor: pointer;"></i>
                <h2>Subject name:</h2>
                <div style="text-align: center;">
                    <hr>
                    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
                        <select name="Did" class="form-control" require>
                            <option selected>Choose Department...</option>
                            <?php
                            $select = "SELECT * FROM `department`";
                            $s = mysqli_query($conn, $select);
                            foreach ($s as $data) { ?>
                                <option value="<?= $data['D_id'] ?>"><?= $data['D_name'] ?></option>
                            <?php } ?>
                        </select>
                        <br>
                        <input type="text" class="form-control" placeholder="subject name" name="subject" id="subject" require>
                        <input type="submit" value="Add" id="addSubject" class="btn btn-info btn-block mt-4">
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- bootstrab js -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.min.js" integrity="sha384-VHvPCCyXqtD5DqJeNxl2dtTyhF78xXNXdkwX1CZeRusQfRKp+tA7hAShOK/B/fQ2" crossorigin="anonymous"></script>
    <!-- my js -->
    <script src="../../js/admin/a_setting.js"></script>
    <!-- nice scroll -->
    <script src="../../js/jquery.nicescroll.min.js"></script>
    <script>
        $("body").niceScroll({
            cursorcolor: "#707070",
            cursoropacitymin: 1,
            cursoropacitymin: 1,
            cursorwidth: "10px",
            zindex: "auto" | [1000]
        });
        $(document).on('mouseover', 'body', function() {
            $(this).getNiceScroll().resize();
        });
    </script>
</body>

</html>