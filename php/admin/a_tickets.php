<?php
include "../../PhpConfig/config.php";

$select = "SELECT * FROM `ticket` INNER JOIN `student` ON ticket.St_id = student.St_id ORDER BY Ti_status DESC";
$s = mysqli_query($conn, $select);

if (isset($_GET['id'])) {
  $update = "UPDATE `ticket` SET Ti_status = 'close' WHERE Ti_id = " . $_GET['id'];
  if (mysqli_query($conn, $update)) {
    echo "<div class='alert alert-primary' role='alert'>Record update successfully</div>";
    header("location:a_tickets.php");
  } else {
    echo mysqli_error($conn);
    echo "<div class='alert alert-danger' role='alert'>Error updating record: </div>";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tickets</title>
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
          <a class="nav-link active" href="a_tickets.php">tickets</a>
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
    <table class="table table-striped table-hover">
      <thead>
        <tr class="text-center">
          <th scope="col">#</th>
          <th scope="col">Name</th>
          <th scope="col">Email</th>
          <th scope="col">Phone</th>
          <th scope="col">Content</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php $counter = 1;
        foreach ($s as $data) { ?>
          <tr>
            <th scope="row"><?= $counter ?></th>
            <td><?= $data['St_fname'] ?></td>
            <td><?= $data['St_email'] ?></td>
            <td>0<?= $data['St_phNumber'] ?></td>
            <td><?= $data['Ti_ticket'] ?></td>
            <td>
              <?php if ($data['Ti_status'] == 'open') { ?>
                <form method="GET" action="<?= $_SERVER['PHP_SELF'] ?>">
                  <input type="hidden" name="id" value="<?= $data['Ti_id'] ?>">
                  <input type="submit" value="Close" class="btn btn-success">
                </form>
              <?php } else { ?>
                Closed
              <?php } ?>
            </td>
          </tr>
        <?php $counter++;
        } ?>
      </tbody>
    </table>
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