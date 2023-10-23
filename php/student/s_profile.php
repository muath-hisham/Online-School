<?php
include "../../PhpConfig/config.php";
include "../../PhpConfig/OOP.php";

session_start();

$student = $_SESSION['user'];

$Did = $student->getDid();

$select = "SELECT * FROM `department` WHERE D_id = $Did";
$s = mysqli_query($conn, $select);
$ss = mysqli_fetch_assoc($s);


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fname = test_input($_POST['fn']);
    $lname = test_input($_POST['ln']);
    $phone = test_input($_POST['phone']);
    $old = test_input($_POST['old']);
    $new = test_input($_POST['new']);

    if ($old == $student->getPassword()) {
        $student->setFname($fname);
        $student->setLname($lname);
        $student->setPhNumber($phone);
        $student->setPassword($new);

        $id = $student->getId();
        $update = "UPDATE `student` SET St_fname = '$fname' , St_lname = '$lname' , St_phNumber = $phone , St_password = '$new' WHERE St_id = $id";
        // $s = mysqli_query($conn,$update);
        if (mysqli_query($conn, $update)) {
            echo "<div class='alert alert-primary' role='alert'>Record updated successfully</div>";
        } else {
            echo "<div class='alert alert-danger' role='alert'>Error updating record: </div>";
        }
    } else {
        echo "<div class='alert alert-danger'>password is wrong</div>";
    }
}

$lengthPass = strlen($student->getPassword());

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
                    <a class="nav-link" href="s_home.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="s_ticket.php">Ticket</a>
                </li>
                <li class="nav-item">
                    <button class="nav-link btn" id="bell"><i class="fas fa-bell"></i></button>
                    <div class="notification" id="notification">
                        <div class="card card-body" id="card">
                            <?php
                            $select2 = "SELECT * FROM `comment` WHERE St_id = " . $student->getId() . " ORDER BY C_id DESC";
                            $s2 = mysqli_query($conn, $select2);
                            ?>
                            <!-- ************************************* -->
                            <?php foreach ($s2 as $data) { ?>
                                <div class="comment">
                                    <?php if ($student->getImg() != NULL) {
                                        echo " <img src='../../upload/img/" . $student->getImg() . "' alt='Person' class='comm-img'>";
                                    } else {
                                        if ($student->getGender() == 'male') {
                                            echo " <img src='../../images/img_avatar.png' alt='Person' class='comm-img'>";
                                        } else {
                                            echo " <img src='../../images/img_avatar2.png' alt='Person' class='comm-img'>";
                                        }
                                    }
                                    ?>
                                    <div class="comm-cont">
                                        <p class="comm-name"><?= $student->getFname() . " " . $student->getLname() ?></p>
                                        <p class="comm-p"><?= $data['C_comment'] ?></p>
                                    </div>
                                    <?php
                                    $ss1 = "SELECT * FROM `answer` NATURAL JOIN `comment` NATURAL JOIN `video` NATURAL JOIN `unit` NATURAL JOIN `teacher` WHERE C_id = " . $data['C_id'];
                                    $ss2 = mysqli_query($conn, $ss1);

                                    foreach ($ss2 as $data2) {
                                    ?>
                                        <div class="answer">
                                            <?php if ($data2['T_img'] != NULL) {
                                                echo " <img src='../../upload/img/" . $data2['T_img'] . "' alt='Person' class='comm-img'>";
                                            } else {
                                                if ($data2['T_gender'] == 'male') {
                                                    echo " <img src='../../images/img_avatar.png' alt='Person' class='comm-img'>";
                                                } else {
                                                    echo " <img src='../../images/img_avatar2.png' alt='Person' class='comm-img'>";
                                                }
                                            }
                                            ?>
                                            <div class="comm-cont">
                                                <p class="comm-name"><?= $data2['T_fname'] . " " . $data2['T_lname'] ?></p>
                                                <p class="comm-p"><?= $data2['A_answer'] ?></p>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
                        <div class="chip">
                            <?php if ($student->getImg() != NULL) { ?>
                                <img src="../../upload/img/<?= $student->getImg() ?>" alt="Person" width="96" height="96">
                                <?php } else {
                                if ($student->getGender() == 'male') { ?>
                                    <img src="../../images/img_avatar.png" alt="Person" width="96" height="96">
                                <?php } else { ?>
                                    <img src="../../images/img_avatar2.png" alt="Person" width="96" height="96">
                            <?php }
                            }
                            echo $student->getFname();
                            ?>
                        </div>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="s_profile.php">profile</a>
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
                    <form action="s_profile.php" method="POST">
                        <?php if ($student->getImg() != NULL) { ?>
                            <img src="../../upload/img/<?= $student->getImg() ?>" alt="Person" class="image">
                            <?php } else {
                            if ($student->getGender() == 'male') { ?>
                                <img src="../../images/img_avatar.png" alt="Person" class="image">
                            <?php } else { ?>
                                <img src="../../images/img_avatar2.png" alt="Person" class="image">
                        <?php }
                        } ?>
                        <input type="file" id="input" name="image" hidden>
                    </form>
                    <h3 class="mt-3 mb-3"><?php echo $student->getFname(); ?></h3>
                    <p>Department: <?php echo $ss['D_name'] ?></p>
                </div>
            </div>
            <div class="col-md-8 col-12">
                <div class="profile">
                    <table class="table table-striped">
                        <tbody>
                            <tr>
                                <th scope="row">Full Name:</th>
                                <td><?php echo $student->getFname() . " " . $student->getLname(); ?></td>
                            </tr>
                            <tr>
                                <th scope="row">Email:</th>
                                <td><?php echo $student->getEmail(); ?></td>
                            </tr>
                            <tr>
                                <th scope="row">Date of barth:</th>
                                <td><?php echo $student->getDOB(); ?></td>
                            </tr>
                            <tr>
                                <th scope="row">Gender:</th>
                                <td><?php echo $student->getGender(); ?></td>
                            </tr>
                            <tr>
                                <th scope="row">phone number:</th>
                                <td><?php echo $student->getPhNumber(); ?></td>
                            </tr>
                            <tr>
                                <th scope="row">Password:</th>
                                <td><?php for ($i = 0; $i < $lengthPass; $i++) echo "*" ?></td>
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
                        <td><input type="text" id="fn" name="fn" class="form-control" value="<?php echo $student->getFname(); ?>"></td>
                    </tr>
                    <tr>
                        <th> <label for="ln">Last Name:</label></th>
                        <td><input type="text" id="ln" name="ln" class="form-control" value="<?php echo $student->getLname(); ?>"></td>
                    </tr>
                    <tr>
                        <th><label for="phone">phone number:</label></th>
                        <td><input type="text" id="phone" name="phone" class="form-control" value="<?php echo $student->getPhNumber(); ?>"></td>
                    </tr>
                    <tr>
                        <th><label for="old">Old Password:</label></th>
                        <td><input type="password" id="old" name="old" class="form-control"></td>
                    </tr>
                    <tr>
                        <th><label for="new">New Password:</label></th>
                        <td><input type="password" id="new" name="new" class="form-control"></td>
                    </tr>
                    <tr>
                        <td colspan="2"><button name="save" id="save" class="btn btn-info btn-block mt-4">Save Edit</button>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>

    <!-- bootstrab js -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.min.js" integrity="sha384-VHvPCCyXqtD5DqJeNxl2dtTyhF78xXNXdkwX1CZeRusQfRKp+tA7hAShOK/B/fQ2" crossorigin="anonymous"></script>
    <!-- my js -->
    <script src="../../js/student/s_profile.js"></script>
    <!-- navber js -->
    <script src="../../js/student/s_navbar.js"></script>
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
</body>

</html>