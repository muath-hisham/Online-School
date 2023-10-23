<?php
include "../../PhpConfig/config.php";

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

    <!-- section chapters -->
    <br><br><br>
    <div>
        <div class="row ml-5 mr-5">
            <div class="col-12 col-sm-9">
                <?php if ($Tid != NULL) { ?>
                    <section>
                        <?php
                        $select = "SELECT * FROM `unit` WHERE T_id = $Tid";
                        $s = mysqli_query($conn, $select);
                        foreach ($s as $data) { ?>
                            <div class="chapter">
                                <h4>Chapter <?= $data['U_number'] ?></h4>
                                <?php
                                $select2 = "SELECT * FROM `video` WHERE U_id = " . $data['U_id'];
                                $s2 = mysqli_query($conn, $select2);
                                foreach ($s2 as $data2) { ?>
                                    <div class="video">
                                        <a class="btn" href="a_video.php?id=<?= $data2['V_id'] ?>">
                                            <img src="../../images/youtube-video.jpg" alt="...">
                                            <span class="my-span"><?= $data2['V_name'] ?></span>
                                        </a>
                                    </div>
                                <?php } ?>
                                <?php
                                $select3 = "SELECT * FROM `material` WHERE U_id = " . $data['U_id'];
                                $s3 = mysqli_query($conn, $select3);
                                foreach ($s3 as $data3) { ?>
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
                <?php } else { ?>
                    <p class="display-4 mt-5">Choose Teacher ...</p>
                <?php } ?>
            </div>
            <div class="col-3">
                <div class="ml-4 mt-5">
                    <h4 class="text-center">Teachers:</h4>
                    <?php $select = "SELECT * FROM `teacher` WHERE S_id= $Sid";
                    $s = mysqli_query($conn, $select);
                    foreach ($s as $data) { ?>
                        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
                            <input type="hidden" name="Tid" value="<?= $data['T_id'] ?>">
                            <input type="submit" value="<?= $data['T_fname'] . " " . $data['T_lname'] ?>" class="btn-block btn">
                        </form>
                    <?php  } ?>
                </div>
            </div>
        </div>
    </div>

    <!-- bootstrab js -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.min.js" integrity="sha384-VHvPCCyXqtD5DqJeNxl2dtTyhF78xXNXdkwX1CZeRusQfRKp+tA7hAShOK/B/fQ2" crossorigin="anonymous"></script>
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
    </script>
</body>

</html>