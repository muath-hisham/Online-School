<?php
include "../../PhpConfig/config.php";
include "../../PhpConfig/OOP.php";
session_start();
$teacher = $_SESSION['user'];
?>
<?php 
if(isset($_GET['id'])){
$showData = "SELECT * FROM `student` where St_id = $_GET[id]";
$dataBaseRe = mysqli_query($conn, $showData);
$StudentvideoData = mysqli_fetch_assoc($dataBaseRe);
if(!(mysqli_num_rows($dataBaseRe)>0)){
header("location: t_material.php");
}
}else{
    header("location: t_material.php");  
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css"
        integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <!-- navbar -->
    <link rel="stylesheet" href="../../css/student/s_navbar.css">
    <!-- my css -->
    <link rel="stylesheet" href="../../css/student/s_profile.css">
</head>

<body>
      <!-- navbar -->
      <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#"><img src="../../images/logo.jpeg" alt="school"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="t_material.php">Material</a>
                </li>
                <!-- dd -->
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
                <!-- ff -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
                        <div class="chip">
                            <?php if ($teacher->getImg() != NULL) { ?>
                                <img src="../../upload/img/<?= $teacher->getImg() ?>" alt="Person" width="96" height="96">
                                <?php } else {
                                if ($teacher->getGender() == 'male') { ?>
                                    <img src="../../images/img_avatar.png" alt="Person" width="96" height="96">
                                <?php } else { ?>
                                    <img src="../../images/img_avatar2.png" alt="Person" width="96" height="96">
                            <?php }
                            }
                            echo $teacher->getFname();
                            ?>
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
                <?php
                if ($StudentvideoData['St_img'] != NULL) {
                    echo " <img src='../../upload/img/".$StudentvideoData['St_img'].
                    "' alt='Person' class='w-75'>";
                } else {
                    if ($StudentvideoData['St_gender'] == 'male') {
                        echo " <img src='../../images/img_avatar.png' alt='Person' class='w-75'>";
                    } else {
                        echo " <img src='../../images/img_avatar2.png' alt='Person' class='w-75'>";
                    }
                } ?>
                    <h3 class="mt-3 mb-3"><?=$StudentvideoData['St_fname']?></h3>
                    <p>Department: <?=  mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM `department` where D_id = $StudentvideoData[D_id]"))['D_name'];?></p>
                </div>
            </div>
            <div class="col-md-8 col-12">
                <div class="profile mt-4">
                    <table class="table table-striped">
                        <tbody>
                            <tr>
                                <th scope="row">First Name:</th>
                                <td><?=$StudentvideoData['St_fname']?></td>
                            </tr>
                            <tr>
                                <th scope="row">Last Name:</th>
                                <td><?=$StudentvideoData['St_lname']?></td>
                            </tr>
                            <tr>
                                <th scope="row">Email:</th>
                                <td><?=$StudentvideoData['St_email']?></td>
                            </tr>
                            <tr>
                                <th scope="row">Date of barth:</th>
                                <td><?=$StudentvideoData['St_DOB']?></td>
                            </tr>
                            <tr>
                                <th scope="row">Gender:</th>
                                <td><?=$StudentvideoData['St_gender']?></td>
                            </tr>
                            <tr>
                                <th scope="row">phone number:</th>
                                <td><?="0".$StudentvideoData['St_phNumber']?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- bootstrab js -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
        integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.min.js"
        integrity="sha384-VHvPCCyXqtD5DqJeNxl2dtTyhF78xXNXdkwX1CZeRusQfRKp+tA7hAShOK/B/fQ2"
        crossorigin="anonymous"></script>
        <script src="../../js/student/s_navbar.js"></script>
</body>

</html>