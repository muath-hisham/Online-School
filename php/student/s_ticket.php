<?php
include "../../PhpConfig/config.php";
include "../../PhpConfig/OOP.php";

session_start();

$student = $_SESSION['user'];
$Sid = $student->getId();

$select = "SELECT * FROM `ticket` WHERE St_id = $Sid ORDER BY Ti_status DESC";
$s = mysqli_query($conn, $select);

$counter = 1;

if (isset($_POST['ticket'])) {
    $ticket = $_POST['ticket'];
    $ticket = trim($ticket);
    if ($ticket != "") {
        $insert =  "INSERT INTO `ticket` VALUES (NULL,'$ticket','open','$Sid')";
        if (mysqli_query($conn, $insert)) {
            echo "<div class='alert alert-primary' role='alert'>Record insert successfully</div>";
        } else {
            echo "<div class='alert alert-danger' role='alert'>Error inserting record: </div>";
        }
        $_POST['ticket'] = "";
        header("location:s_ticket.php");
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
    <link rel="stylesheet" href="../../css/student/s_ticket.css">
    <title>Tickets</title>
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
                <li class="nav-item active">
                    <a class="nav-link active" href="s_ticket.php">Ticket</a>
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

    <!-- ticket contect -->
    <div class="container" style="padding: 50px !important;">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col" style="text-align: center;">Content of the Ticket</th>
                    <th scope="col">Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($s as $data) { ?>
                    <tr>
                        <th scope="row"><?php echo $counter ?></th>
                        <td><?php echo $data['Ti_ticket']; ?></td>
                        <td><?php echo $data['Ti_status']; ?></td>
                    </tr>
                <?php $counter++;
                } ?>
                <tr>
                    <td colspan="5"><button type="button" style="height: 50px;" id="add" name="add" class="btn btn-outline-success w-100"><i class="fas fa-plus-circle"></i></button></td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- div new ticket -->
    <div>
        <div class="ticket">
            <div class="cont">
                <i class="far fa-times-circle" id="exit" style="font-size: 30px; text-align: center; cursor: pointer;"></i>
                <h2>Ticket content</h2>
                <div style="text-align: center;">
                    <hr>
                    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
                        <textarea name="ticket" id="ticket" cols="65" rows="10"></textarea>
                        <input type="submit" value="Send" class="btn btn-info btn-block mt-4">
                    </form>
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
    <!-- my js -->
    <script src="../../js/student/s_ticket.js"></script>
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