<?php
include "../../PhpConfig/delete.php";

$Vid = $_GET['id'];

$select = "SELECT * FROM `video` WHERE V_id = " . $Vid;
$s = mysqli_query($conn, $select);
$ss = mysqli_fetch_assoc($s);

if (isset($_POST['deleteID'])) {
    deleteComment($_POST['deleteID'], $conn);
}

if (isset($_POST['BlockID'])) {
    $St_id = $_POST['BlockID'];
    $comment = $_POST['comment'];
    $sql = "INSERT INTO block VALUES (NULL,$St_id,'admin','$comment')";
    if (!mysqli_query($conn, $sql)) {
        echo "error" . mysqli_error($conn);
    } else {
        echo "<div class='alert alert-primary'> Blocked </div>";
    }
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
    <link rel="stylesheet" href="../../css/student/s_video.css">
    <link rel="stylesheet" href="../../css/teacher/t_video.css">
    <title>video</title>
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

    <!-- body -->
    <div class="space"></div>
    <div class="ml-5 mr-5 container-style">
        <div class="row">
            <div class="col-md-7 col-12">
                <div class="cont">
                    <iframe class="video" src="<?= $ss['V_path'] ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
            </div>
            <div class="col-md-5 col-12">
                <div id="all-comments">
                    <?php
                    $select = "SELECT * FROM `comment` NATURAL JOIN `student` WHERE V_id = " . $ss['V_id'] . " ORDER BY C_id DESC";
                    $s = mysqli_query($conn, $select);
                    foreach ($s as $data) {
                        $s3 = mysqli_query($conn, "SELECT * FROM `block` WHERE St_id = " . $data['St_id']);
                        if (mysqli_num_rows($s3) == 0) {
                    ?>
                            <div class="comment">
                                <?php if ($data['St_img'] != NULL) {
                                    echo " <img src='../../images/" . $data['St_img'] . "' alt='Person' class='comm-img'>";
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
                                <div class="action">
                                    <i class="fas fa-ellipsis-h" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
                                    </i>
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="a_information_profile.php?student=<?= $data['St_id'] ?>">profile</a>
                                        <form action="a_video.php?id=<?= $Vid ?>" method="POST">
                                            <input type="hidden" name="deleteID" value="<?= $data['C_id'] ?>">
                                            <input type="submit" class="dropdown-item" value="Delete">
                                        </form>
                                        <form action="a_video.php?id=<?= $Vid ?>" method="POST">
                                            <input type="hidden" name="BlockID" value="<?= $data['St_id'] ?>">
                                            <input type="hidden" name="comment" value="<?= $data['C_comment'] ?>">
                                            <input type="submit" class="dropdown-item" value="Block">
                                        </form>
                                    </div>
                                </div>
                                <?php
                                $select2 = "SELECT * FROM `answer` NATURAL JOIN `comment` NATURAL JOIN `video` NATURAL JOIN `unit` NATURAL JOIN `teacher` WHERE C_id = " . $data['C_id'];
                                $s2 = mysqli_query($conn, $select2);
                                foreach ($s2 as $data2) {
                                ?>
                                    <div class="answer">
                                        <?php if ($data2['T_img'] != NULL) {
                                            echo " <img src='../../images/" . $data2['T_img'] . "' alt='Person' class='comm-img'>";
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
                    <?php }
                    } ?>
                </div>

            </div>
        </div>
    </div>

    <!-- bootestrab js -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous">
    </script>
    <!-- nice scroll -->
    <script src="../../js/jquery.nicescroll.min.js"></script>
    <script>
        $("#all-comments").niceScroll({
            cursorcolor: "#707070",
            cursoropacitymin: 1,
            cursoropacitymin: 1,
            cursorwidth: "7px"
        });
        $(document).on('mouseover', '#all-comments', function() {
            $(this).getNiceScroll().resize();
        });
    </script>
</body>

</html>