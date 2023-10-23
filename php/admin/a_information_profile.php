<?php
include("../../PhpConfig/config.php");

$choose = NULL;

if (isset($_GET['teacher_id'])) {
    $select = "SELECT * FROM (`teacher` NATURAL JOIN `subject`) NATURAL JOIN `department` WHERE T_id = " . $_GET['teacher_id'];
    $profile_teacher = mysqli_query($conn, $select);
    $profile_teacher2 = mysqli_fetch_assoc($profile_teacher);
    $choose = 'teacher';
}

if (isset($_GET['student'])) {
    $select = "SELECT * FROM `student` NATURAL JOIN `department` WHERE St_id = " . $_GET['student'];
    $profile_student = mysqli_query($conn, $select);
    $profile_student2 = mysqli_fetch_assoc($profile_student);
    $choose = 'student';
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Information</title>
    <!-- the font icon -->
    <link href="../../css/all.min.css" rel="stylesheet">
    <!-- bootstrab css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <!-- navbar -->
    <link rel="stylesheet" href="../../css/student/s_navbar.css">
    <!-- my css -->
    <link rel="stylesheet" href="../../css/student/s_profile.css">
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
    <?php if ($choose == 'teacher') { ?>
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-12 p-0">
                    <div class="profile-img">
                        <?php if ($profile_teacher2['T_img'] != NULL) {
                            echo " <img src='../../images/" . $profile_teacher2['T_img'] . "' alt='Person' class='image'>";
                        } else {
                            if ($profile_teacher2['T_gender'] == 'male') {
                                echo " <img src='../../images/img_avatar.png' alt='Person' class='image'>";
                            } else {
                                echo " <img src='../../images/img_avatar2.png' alt='Person' class='image'>";
                            }
                        }
                        ?>
                        <h3 class="mt-3 mb-3"><?= $profile_teacher2['T_fname'] ?>
                        </h3>
                        <p>Department: <?= $profile_teacher2['D_name'] ?></p>
                    </div>
                </div>
                <div class="col-md-8 col-12">
                    <div class="profile mt-1">
                        <table class="table table-striped">
                            <tbody>
                                <tr>
                                    <th scope="row">ID:</th>
                                    <td><?= $profile_teacher2['T_id'] ?></td>
                                </tr>
                                <tr>
                                    <th scope="row">Full Name:</th>
                                    <td><?= $profile_teacher2['T_fname'] . " " . $profile_teacher2['T_lname'] ?>
                                    </td>
                                </tr>
                                <th scope="row">Gender:</th>
                                <td><?= $profile_teacher2['T_gender'] ?></td>
                                </tr>
                                <tr>
                                    <th scope="row">Email:</th>
                                    <td><?= $profile_teacher2['T_email'] ?></td>
                                </tr>

                                <tr>
                                    <th scope="row">phone number:</th>
                                    <td><?= $profile_teacher2['T_phNumber'] ?></td>
                                </tr>
                                <tr>
                                    <th scope="row">subject:</th>
                                    <td><?= $profile_teacher2['S_name'] ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <form action="a_teacher.php" method="GET">
                        <input type="hidden" name="Tid" value="<?= $_GET['teacher_id'] ?>">
                        <input type="submit" value="delete" class="btn btn-outline-danger btn-block mt-3 mb-4">
                    </form>
                </div>
            </div>
        </div>
    <?php } elseif ($choose == 'student') { ?>
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-12 p-0">
                    <div class="profile-img">
                        <?php if ($profile_student2['St_img'] != NULL) {
                            echo " <img src='../../images/" . $profile_student2['St_img'] . "' alt='Person' class='image'>";
                        } else {
                            if ($profile_student2['St_gender'] == 'male') {
                                echo " <img src='../../images/img_avatar.png' alt='Person' class='image'>";
                            } else {
                                echo " <img src='../../images/img_avatar2.png' alt='Person' class='image'>";
                            }
                        }
                        ?>
                        <h3 class="mt-3 mb-3"><?= $profile_student2['St_fname'] ?>
                        </h3>
                        <p>Department: <?= $profile_student2['D_name'] ?></p>
                    </div>
                </div>
                <div class="col-md-8 col-12">
                    <div class="profile mt-3">
                        <table class="table table-striped">
                            <tbody>
                                <tr>
                                    <th scope="row">ID:</th>
                                    <td><?= $profile_student2['St_id'] ?></td>
                                </tr>
                                <tr>
                                    <th scope="row">Full Name:</th>
                                    <td><?= $profile_student2['St_fname'] . " " . $profile_student2['St_lname'] ?>
                                    </td>
                                </tr>
                                <th scope="row">Gender:</th>
                                <td><?= $profile_student2['St_gender'] ?></td>
                                </tr>
                                <tr>
                                    <th scope="row">Email:</th>
                                    <td><?= $profile_student2['St_email'] ?></td>
                                </tr>

                                <tr>
                                    <th scope="row">phone number:</th>
                                    <td><?= $profile_student2['St_phNumber'] ?></td>
                                </tr>
                                <tr>
                                    <th scope="row">DOB:</th>
                                    <td><?= $profile_student2['St_DOB'] ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
    <!-- bootstrab js -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.min.js" integrity="sha384-VHvPCCyXqtD5DqJeNxl2dtTyhF78xXNXdkwX1CZeRusQfRKp+tA7hAShOK/B/fQ2" crossorigin="anonymous"></script>
</body>

</html>