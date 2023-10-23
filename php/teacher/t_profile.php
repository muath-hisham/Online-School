<?php
include "../../PhpConfig/config.php";
include "../../PhpConfig/OOP.php";

session_start();

$teacher = $_SESSION['user'];

$password = strlen($teacher->getPassword());

if (isset($_POST['old'])) {
    $fname = test_input($_POST['fn']);
    $lname = test_input($_POST['ln']);
    $phone = test_input($_POST['phone']);
    $new = test_input($_POST['new']);
    $old = test_input($_POST['old']);

    if ($teacher->getPassword() == $old) {
        $teacher->setFname($fname);
        $teacher->setLname($lname);
        $teacher->setPhNumber($phone);
        $teacher->setPassword($new);

        $update = "UPDATE `teacher` SET T_fname = '$fname' , T_lname = '$lname' , T_phNumber = $phone , T_password = '$new'";

        if (mysqli_query($conn, $update)) {
            echo "<div class='alert alert-primary' role='alert'>Record update successfully</div>";
        } else {
            echo "<div class='alert alert-danger' role='alert'>Error updateing record: </div>";
        }
        // header("location:t_profile.php");
    } else {
        echo "<div class='alert alert-danger' role='alert'>Error the old password is wrong record: </div>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
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
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#"><img src="../../images/logo.jpeg" alt="school logo"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="t_material.php">Material</a>
                </li>
                <li class="nav-item">
                    <button class="nav-link btn" id="bell"><i class="fas fa-bell"></i></button>
                    <div class="notification" id="notification">
                        <div class="card card-body" id="card">
                            <?php
                            $select2 = "SELECT * FROM `comment`NATURAL JOIN `student` NATURAL JOIN `video` NATURAL JOIN `unit` WHERE T_id = " . $teacher->getId();
                            $s2 = mysqli_query($conn, $select2);
                            ?>
                            <!-- ************************************* -->
                            <?php
                            if (mysqli_num_rows($s2) != 0) {
                                foreach ($s2 as $data) {
                                    $ss1 = "SELECT * FROM `answer` NATURAL JOIN `comment` WHERE C_id = " . $data['C_id'];
                                    $ss2 = mysqli_query($conn, $ss1);
                                    $numrow = mysqli_num_rows($ss2);
                                    if ($numrow == 0) {
                            ?>
                                        <div class="comment">
                                            <a href="t_video.php?id=<?= $data['V_id'] ?>" style="text-decoration: none;">
                                                <?php if ($data['St_img'] != NULL) {
                                                    echo " <img src='../../upload/img/" . $data['St_img'] . "' alt='Person' class='comm-img'>";
                                                } else {
                                                    if ($data['St_gender'] == 'male') {
                                                        echo " <img src='../../images/img_avatar.png' alt='Person' class='comm-img'>";
                                                    } else {
                                                        echo " <img src='../../images/img_avatar2.png' alt='Person' class='comm-img'>";
                                                    }
                                                }
                                                ?>
                                                <div class="comm-cont">
                                                    <p class="comm-name"><?= $data['St_fname'] . " " . $data['St_lname'] ?></p>
                                                    <p class="comm-p"><?= $data['C_comment'] ?></p>
                                                </div>
                                            </a>
                                        </div>
                            <?php }
                                }
                            } else {
                                echo "<div class='text-center w-100'><p class='display-5 text-danger mt-3'>No Comments</p></div>";
                            } ?>
                        </div>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
                        <div class="chip">
                            <?php if ($teacher->getImg() != NULL) {
                                echo " <img src='../../upload/img/" . $teacher->getImg() . "' alt='Person' width='96' height='96'>";
                            } else {
                                if ($teacher->getGender() == 'male') {
                                    echo " <img src='../../images/img_avatar.png' alt='Person' width='96' height='96'>";
                                } else {
                                    echo " <img src='../../images/img_avatar2.png' alt='Person' width='96' height='96'>";
                                }
                            }
                            ?>

                            <?= $teacher->getFname() ?>
                        </div>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="t_profile.php">profile</a>
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
        <div class="row">
            <div class="col-md-4 col-12 p-0">
                <div class="profile-img">
                    <?php if ($teacher->getImg() != NULL) {
                        echo " <img src='../../upload/img/" . $teacher->getImg() . "' alt='Person' class='image'>";
                    } else {
                        if ($teacher->getGender() == 'male') {
                            echo " <img src='../../images/img_avatar.png' alt='Person' class='image'>";
                        } else {
                            echo " <img src='../../images/img_avatar2.png' alt='Person' class='image'>";
                        }
                    }
                    ?>
                    <h3 class="mt-3 mb-3"><?= $teacher->getFname() ?></h3>
                </div>
            </div>
            <div class="col-md-8 col-12">
                <div class="profile">
                    <table class="table table-striped">
                        <tbody>
                            <tr>
                                <th scope="row">Full Name:</th>
                                <td><?= $teacher->getFname() . " " . $teacher->getLname() ?></td>
                            </tr>
                            <tr>
                                <th scope="row">Email:</th>
                                <td><?= $teacher->getEmail() ?></td>
                            </tr>
                            <tr>
                                <th scope="row">Gender:</th>
                                <td><?= $teacher->getGender() ?></td>
                            </tr>
                            <tr>
                                <th scope="row">phone number:</th>
                                <td><?= $teacher->getPhNumber() ?></td>
                            </tr>
                            <tr>
                                <th scope="row">Password:</th>
                                <td>
                                    <?php for ($i = 0; $i <= $password; $i++) {
                                        echo "*";
                                    }
                                    ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="text-center">
                    <button id="edit" name="edit" class="btn btn-info my-btn"><i class="fas fa-user-edit"></i></button>
                </div>
            </div>
        </div>
    </div>

    <!-- edit -->
    <div class="back-edit">
        <div class="edit">
            <i class="far fa-times-circle" id="exit" style="font-size: 30px; text-align: center; cursor: pointer;"></i>
            <h3 class="text-danger">Edit my data</h3>
            <hr>
            <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
                <table class="table-edit">
                    <tr>
                        <th><label for="fn">First Name:</label></th>
                        <td><input type="text" id="fn" name="fn" class="form-control" value="<?= $teacher->getFname() ?>" required></td>
                    </tr>
                    <tr>
                        <th> <label for="ln">Last Name:</label></th>
                        <td><input type="text" id="ln" name="ln" class="form-control" value="<?= $teacher->getLname() ?>" required></td>
                    </tr>
                    <tr>
                        <th><label for="phone">phone number:</label></th>
                        <td><input type="text" id="phone" name="phone" class="form-control" value="<?= $teacher->getPhNumber() ?>" required></td>
                    </tr>
                    <tr>
                        <th><label for="old">Old Password:</label></th>
                        <td><input type="password" id="old" name="old" class="form-control" required></td>
                    </tr>
                    <tr>
                        <th><label for="new">New Password:</label></th>
                        <td><input type="password" id="new" name="new" class="form-control" required></td>
                    </tr>
                    <tr>
                        <td colspan="2"><input type="submit" value="Save" name="save" id="save" class="btn btn-info btn-block mt-4"></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>

    <!-- bootstrab js -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.min.js" integrity="sha384-VHvPCCyXqtD5DqJeNxl2dtTyhF78xXNXdkwX1CZeRusQfRKp+tA7hAShOK/B/fQ2" crossorigin="anonymous"></script>
    <!-- nice scroll -->
    <script src="../../js/jquery.nicescroll.min.js"></script>
    <script>
        $("#card").niceScroll({
            cursorcolor: "#707070",
            cursoropacitymin: 1,
            cursoropacitymin: 1,
            cursorwidth: "7px"
        });
        $(document).on('mouseover', '#card', function() {
            $(this).getNiceScroll().resize();
        });
    </script>
    <!-- my js -->
    <script src="../../js/student/s_profile.js"></script>
    <script src="../../js/student/s_navbar.js"></script>
</body>

</html>