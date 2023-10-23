<?php
include "../../PhpConfig/delete.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Students</title>
    <!-- the font icon -->
    <link href="../../css/all.min.css" rel="stylesheet">
    <!-- bootstrab css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <!-- navbar -->
    <link rel="stylesheet" href="../../css/student/s_navbar.css">
    <link rel="stylesheet" href="../../css/student/s_home.css">

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
                    <a class="nav-link active" href="a_subjects.php">Subjects</a>
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
    <div class="container">
        <?php
        $select = "SELECT * FROM `department`";
        $s = mysqli_query($conn, $select);
        foreach ($s as $data) {
            $select2 = "SELECT * FROM `subject` WHERE D_id = " . $data['D_id'];
            $s2 = mysqli_query($conn, $select2);
            echo "<h1 class='text-center text-primary display-3'>" . $data['D_name'] . "</h1>";
            foreach ($s2 as $data2) {
        ?>
                <div class="card" style="width: 18rem;">
                    <a href="a_material.php?id=<?php echo $data2['S_id'] ?>" class="btn" style="padding: 0%; margin: 0%;">
                        <img src="../../images/subject-default.jpg" class="card-img-top" alt="...">
                        <div class="card-body">
                            <p class="card-text"><?php echo $data2['S_name']; ?></p>
                        </div>
                    </a>
                </div>
        <?php }
        } ?>
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