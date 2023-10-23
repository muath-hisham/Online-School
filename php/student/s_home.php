<?php
include "../../PhpConfig/config.php";
include "../../PhpConfig/OOP.php";

session_start();

$student = $_SESSION['user'];

$D_id = $student->getDid();

$select = "SELECT * FROM `subject` WHERE D_id = $D_id";
$s = mysqli_query($conn, $select);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>student page</title>
  <!-- the font icon -->
  <link href="../../css/all.min.css" rel="stylesheet">
  <!-- bootstrab css -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
  <!-- navbar -->
  <link rel="stylesheet" href="../../css/student/s_navbar.css">
  <!-- my css -->
  <link rel="stylesheet" href="../../css/student/s_home.css">

</head>

<body>
  <!-- navbar -->
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">
      <img src="../../images/logo.jpeg" alt="school logo">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item active">
          <a class="nav-link active" href="#">Home</a>
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

  <!--content-->
  <div class="container">
    <br><br><br>

    <?php foreach ($s as $data) { ?>
      <div class="card" style="width: 18rem;">
        <a href="s_material.php?id=<?php echo $data['S_id'] ?>" class="btn" style="padding: 0%; margin: 0%;">
          <img src="../../images/subject-default.jpg" class="card-img-top" alt="...">
          <div class="card-body">
            <p class="card-text"><?php echo $data['S_name']; ?></p>
          </div>
        </a>
      </div>
    <?php } ?>
  </div>

  <!-- bootstrab js -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.min.js" integrity="sha384-VHvPCCyXqtD5DqJeNxl2dtTyhF78xXNXdkwX1CZeRusQfRKp+tA7hAShOK/B/fQ2" crossorigin="anonymous"></script>
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