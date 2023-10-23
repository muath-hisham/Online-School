<?php
include "../../PhpConfig/config.php";
include "../../PhpConfig/OOP.php";

session_start();

$student = $_SESSION['user'];

$Sid = $_GET['id'];

$Tid = NULL;
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $Tid = $_POST['Tid'];
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- the font icon -->
    <link href="../../css/all.min.css" rel="stylesheet">
    <!-- bootestrab css -->
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <!-- navbar -->
    <link rel="stylesheet" href="../../css/student/s_navbar.css">
    <!-- my css -->
    <link rel="stylesheet" href="../../css/student/s_material.css">
    <title>materials</title>
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

    <!-- section chapters -->
    <br><br><br>
    <div>
        <div class="row ml-5 mr-5">
            <div class="col-12 col-sm-9">
                <?php if($Tid != NULL){ ?>
                <section>
                    <?php 
                    $select = "SELECT * FROM `unit` WHERE T_id = $Tid";
                    $s = mysqli_query($conn,$select);
                    foreach($s as $data){ ?>
                    <div class="chapter">
                        <h4>Chapter <?= $data['U_number'] ?></h4>
                        <?php 
                        $select2 = "SELECT * FROM `video` WHERE U_id = " . $data['U_id'];
                        $s2 = mysqli_query($conn,$select2);
                        foreach($s2 as $data2){ ?>
                        <div class="video">
                            <a class="btn" href="s_video.php?id=<?= $data2['V_id'] ?>">
                                <img src="../../images/youtube-video.jpg" alt="...">
                                <span class="my-span"><?= $data2['V_name'] ?></span>
                            </a>
                        </div>
                        <?php } ?>
                        <?php 
                        $select3 = "SELECT * FROM `material` WHERE U_id = " . $data['U_id'];
                        $s3 = mysqli_query($conn,$select3);
                        foreach($s3 as $data3){ ?>
                        <div class="pdf">
                            <button class="btn">
                                <img src="../../images/pdf.png" alt="PDF:">
                                <a href="../../upload/PDF/<?= $data3['M_path'] ?>" download><span class="my-span"><?php echo $data3['M_name'] ?></span></a>
                            </button>
                        </div>
                        <?php } ?>
                    </div>
                    <?php } ?>
                </section>
                <?php }else{ ?>
                    <p class="display-4 mt-5">Choose Teacher ...</p>
                <?php } ?>
            </div>
            <div class="col-3">
            <h4 class="m-5"> Teacher </h4>
                <!-- === -->
                <nav class="rightSlide">
                    <ul>
                        <?php $select = "SELECT * FROM `teacher` WHERE S_id= $Sid";
            $s = mysqli_query($conn, $select);
            foreach ($s as $data) { ?>
                        <li>
                            <?php
               if ($data['T_img'] != NULL) {
                    echo " <img src='../../upload/img/".$data['T_img'].
                    "' alt='Person' class='TIMG'>";
                } else {
                    if ($data['T_gender'] == 'male') {
                          echo " <img src='../../images/img_avatar.png' alt='Person' class='TIMG'>";
                    } else {
                         echo " <img src='../../images/img_avatar2.png' alt='Person' class='TIMG'>";
                    }
                }
            ?>
                            <div class="cont">
                                <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
                                    <input type="hidden" name="Tid" value="<?= $data['T_id'] ?>">
                                    <input type="submit" value="<?= $data['T_fname'] . " " . $data['T_lname'] ?>"
                                        class="btn-block btn">
                                </form>
                            </div>
                        </li>
                        <?php  } ?>
                    </ul>
                </nav>
                <!-- ==== -->
            </div>
        </div>
    </div>

    <!-- bootstrab js -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.min.js" integrity="sha384-VHvPCCyXqtD5DqJeNxl2dtTyhF78xXNXdkwX1CZeRusQfRKp+tA7hAShOK/B/fQ2" crossorigin="anonymous"></script>
    <!-- navbar js -->
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


<style>
.cont {
	transform:  translateX(0px) rotateY(90deg);
    background: white!important;
    position: absolute;
    top:25%;
    transition:all .4s;
}
.rightSlide {
    float: right;
	position: relative;
    top: -8%;
    left: -60%;
	background: transparent;
}
.rightSlide ul {
	text-align: center;
}

.rightSlide ul li {
    padding: 5px;
	position: relative;
    width: 80px;
	background-color: #E2E8F0 !important;
	transition:all .4s ease-out;
}
.rightSlide ul li:hover {
	transform: translateX(-70px);
}
.rightSlide ul li:hover>.cont {
	transform: translateX(70px) rotateY(0deg);
    transition:all .4s ;
}
.TIMG{
    width: 70px;
    height: 70px;
    border-radius: 5px;
}
@media (max-width: 765px){
    .rightSlide {
    left: 168%;
} 
}
</style>

