<?php
include("../../PhpConfig/delete.php");

if (isset($_GET['Tid'])) {
  deleteTeacher($_GET['Tid'], $conn);
  header("location: a_teacher.php");
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- bootstrab css -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
  <!-- icon -->
  <link href="../../css/all.min.css" rel="stylesheet">
  <!--css links-->
  <link rel="stylesheet" href="../../css/admin/a_teacher.css">
  <link rel="stylesheet" href="../../css/student/s_navbar.css">
  <link rel="stylesheet" href="../../css/admin/a_controls.css">

  <title>teacher list</title>
</head>

<body>
  <!-- navbar -->
  <nav class="navbar navbar-expand-lg navbar-light">
    <a class="navbar-brand" href="#">
      <img src="../../images/logo.jpeg" alt="school logo">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" href="a_subjects.php">Subjects</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="a_teacher.php">Teachers</a>
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

  <br><br><br>
  <!-- controls -->
  <span class="filterIcon position-fixed"><i class="fas fa-filter"></i></span>
  <div class="d position-fixed">
    <form action="a_teacher.php" class="con" method="POST">
      <div>
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="search">
      </div>
      <div class="form-check form-switch">
        <input class="form-check-input" type="checkbox" role="switch" id="subject" checked>
        <label class="form-check-label" for="flexSwitchCheckChecked">subject </label>
        <?php
        $all_subject = mysqli_query($conn, 'select * from `subject`');
        $number_of_subject = 1;
        while ($res = mysqli_fetch_array($all_subject)) {
        ?>
          <div class="form-check">
            <input class="form-check-input subject" type="radio" name="subject" id="exampleRadios1" value="<?= $number_of_subject ?>">
            <label class="form-check-label" for="exampleRadios1">
              <?php echo $res['S_name'] ?>
            </label>
          </div>
        <?php
          $number_of_subject += 1;
        }
        ?>

      </div>

      <div class="form-check form-switch">
        <input class="form-check-input" type="checkbox" role="switch" id="gender" name="genderOn" value="open" checked>

        <label class="form-check-label" for="flexSwitchCheckChecked">gender</label>
        <div class="form-check">
          <input class="form-check-input gender" type="radio" name="gender" id="exampleRadios1" value="male">
          <label class="form-check-label" for="exampleRadios1">
            Male
          </label>
        </div>
        <div class="form-check">
          <input class="form-check-input gender" type="radio" name="gender" id="exampleRadios1" value="female">
          <label class="form-check-label" for="exampleRadios1">
            Female
          </label>
        </div>
      </div>



      <div class="form-check form-switch">
        <input class="form-check-input" type="checkbox" role="switch" id="Scientific" checked>
        <label class="form-check-label" for="flexSwitchCheckChecked">Scientific Division</label>
        <div class="form-check">
          <input class="form-check-input Scientific" type="radio" name="Scientific" id="exampleRadios1" value="2">
          <label class="form-check-label" for="exampleRadios1">
            ادبي
          </label>
        </div>
        <div class="form-check">
          <input class="form-check-input Scientific" type="radio" name="Scientific" id="exampleRadios1" value="1">
          <label class="form-check-label" for="exampleRadios1">
            علمي
          </label>
        </div>
      </div>
      <input type="submit" value="Filter" class="btn btn-outline-info btn-block mt-5">
    </form>
  </div>

  <!-- contant -->

  <div class="container">
    <div class="row">

      <!-- ********************************************** -->
      <?php
      //if no filter is on
      if (
        !isset($_POST['gender']) && !isset($_POST['subject']) &&
        !isset($_POST['Scientific']) && !isset($_POST['search'])
      ) {
        $all_teacher = mysqli_query($conn, 'select * from teacher');
        while ($res = mysqli_fetch_array($all_teacher)) {
          include("./include/teacher_content.php");
        }
      }

      if (
        !isset($_POST['gender']) && !isset($_POST['subject']) &&
        !isset($_POST['Scientific']) && isset($_POST['search'])
      ) {

        if ($_POST['search'] == NULL) {
          $all_teacher = mysqli_query($conn, 'select * from teacher');
          while ($res = mysqli_fetch_array($all_teacher)) {
            include("./include/teacher_content.php");
          }
        }
      } elseif (isset($_POST['genderOn'])) // check if gender button is on
      {
        // felter on male
        if (
          isset($_POST['gender']) && !isset($_POST['subject']) &&
          !isset($_POST['Scientific']) && isset($_POST['search'])
        ) {

          if ($_POST['search'] == NULL) {
            $gender_filter = $_POST['gender']; {
              $male = mysqli_query($conn, 'select * from teacher WHERE T_gender="' . $gender_filter . '"');
              while ($res = mysqli_fetch_array($male)) {
                include("./include/teacher_content.php");
              }
            }
          }
        }
      }


      //filter on name
      if (
        isset($_POST['search']) && $_POST['search'] != NULL && !isset($_POST['gender']) && !isset($_POST['subject']) &&
        !isset($_POST['Scientific'])
      ) {
        $search_teacher = $_POST["search"];
        $search_teacher_db = mysqli_query($conn, 'select * from teacher where 
                    T_fname= "' . $search_teacher . '" OR T_lname= "' . $search_teacher . '"');

        while ($res = mysqli_fetch_array($search_teacher_db)) {
          include("./include/teacher_content.php");
        }
      }
      //filter on name && gender
      if (
        isset($_POST['search']) && $_POST['search'] != NULL && isset($_POST['gender']) && !isset($_POST['subject'])
        && !isset($_POST['Scientific'])
      ) {
        if ($_POST["search"] != NULL) {

          $search_teacher = $_POST["search"];
          $gender_filter = $_POST['gender'];
          $male_name_filter = mysqli_query($conn, 'select * from teacher WHERE T_gender="' . $gender_filter . '"
                     AND T_fname= "' . $search_teacher . '" OR T_lname= "' . $search_teacher . '" ');
          while ($res = mysqli_fetch_array($male_name_filter)) {
            include("./include/teacher_content.php");
          }
        }
      }
      ?>

      <?php //filtor on subject only
      if (
        !isset($_POST['gender']) && isset($_POST['subject']) &&
        !isset($_POST['Scientific']) && isset($_POST['search'])
      ) {
        if ($_POST['search'] == NULL) {
      ?>
          <div class="container">
            <div class="row">
          <?php
          $subject_filter = $_POST["subject"];
          $all_teacher = mysqli_query($conn, 'select * from teacher WHERE S_id ="' . $subject_filter . '"');
          while ($res = mysqli_fetch_array($all_teacher)) {
            include("./include/teacher_content.php");
          }
        }
      }
          ?>

          <?php //filtor on subject     and       name
          if (
            !isset($_POST['gender']) && isset($_POST['subject']) &&
            !isset($_POST['Scientific']) && isset($_POST['search'])
          ) {
            if ($_POST['search'] != NULL) {
          ?>
              <div class="container">
                <div class="row">
              <?php
              $subject_filter = $_POST["subject"];
              $search_teacher = $_POST["search"];
              $all_teacher = mysqli_query($conn, 'select * from teacher WHERE S_id ="' . $subject_filter . '"
    AND T_fname= "' . $search_teacher . '" OR T_lname= "' . $search_teacher . '"');
              while ($res = mysqli_fetch_array($all_teacher)) {
                include("./include/teacher_content.php");
              }
            }
          }
              ?>

              <?php //filtor on       subject   and           gender
              if (
                isset($_POST['gender']) && isset($_POST['subject']) &&
                !isset($_POST['Scientific']) && isset($_POST['search'])
              ) {
                if ($_POST['search'] == NULL) {

                  $gender_filter = $_POST['gender'];
                  $subject_filter = $_POST["subject"];
                  $male_subject = mysqli_query($conn, 'select * from teacher WHERE T_gender="' . $gender_filter . '" AND 
          S_id ="' . $subject_filter . '"');
                  while ($res = mysqli_fetch_array($male_subject)) {
                    include("./include/teacher_content.php");
                  }
                }
              }

              //filtor on       subject   and           name   and   gender
              if (
                isset($_POST['gender']) && isset($_POST['subject']) &&
                !isset($_POST['Scientific']) && isset($_POST['search'])
              ) {
                if ($_POST['search'] != NULL) {
                  $gender_filter = $_POST['gender'];
                  $subject_filter = $_POST["subject"];
                  $search_teacher = $_POST["search"];
                  $male_subject = mysqli_query($conn, 'select * from teacher WHERE T_gender="' . $gender_filter . '" AND 
        T_fname= "' . $search_teacher . '" OR T_lname= "' . $search_teacher . '" AND S_id ="' . $subject_filter . '"');
                  while ($res = mysqli_fetch_array($male_subject)) {
                    include("./include/teacher_content.php");
                  }
                }
              }
              ?>

              <?php // filter is on  department only 
              if (
                !isset($_POST['gender']) && !isset($_POST['subject']) &&
                isset($_POST['Scientific']) && isset($_POST['search'])
              ) {
                if ($_POST['search'] == NULL) {

                  $Scientific_teacher = $_POST["Scientific"];
                  $department_filter = mysqli_query($conn, 'SELECT T_gender, S_id, T_fname,T_lname, D_id , T_img
     FROM `teacher` NATURAL JOIN `subject` WHERE D_id="' . $Scientific_teacher . '"');
                  while ($res = mysqli_fetch_array($department_filter)) {
                    include("./include/teacher_content.php");
                  }
                }
              }



              // filter  on    department  and    name
              if (
                !isset($_POST['gender']) && !isset($_POST['subject']) &&
                isset($_POST['Scientific']) && isset($_POST['search'])
              ) {
                if ($_POST['search'] != NULL) {

                  $search_teacher = $_POST["search"];
                  $Scientific_teacher = $_POST["Scientific"];
                  $department_search_name = mysqli_query($conn, 'SELECT T_gender, S_id, T_fname,T_lname, D_id, T_img
     FROM `teacher` NATURAL JOIN `subject` WHERE D_id="' . $Scientific_teacher . '" AND 
    T_fname= "' . $search_teacher . '" OR T_lname= "' . $search_teacher . '"');
                  while ($res = mysqli_fetch_array($department_search_name)) {
                    include("./include/teacher_content.php");
                  }
                }
              }

              // filter  on    department  and    name  and  gender
              if (
                isset($_POST['gender']) && !isset($_POST['subject']) &&
                isset($_POST['Scientific']) && isset($_POST['search'])
              ) {
                if ($_POST['search'] != NULL) {

                  $gender_filter = $_POST['gender'];
                  $search_teacher = $_POST["search"];
                  $Scientific_teacher = $_POST["Scientific"];
                  $department_search_name = mysqli_query($conn, 'SELECT T_gender, S_id, T_fname,T_lname, D_id , T_img FROM `teacher` 
    NATURAL JOIN `subject` WHERE D_id="' . $Scientific_teacher . '" AND 
    T_fname= "' . $search_teacher . '" OR T_lname= "' . $search_teacher . '" AND 
    T_gender ="' . $gender_filter . '"');
                  while ($res = mysqli_fetch_array($department_search_name)) {
                    include("./include/teacher_content.php");
                  }
                }
              }


              // filter  on    department  and    name  and  subject
              if (
                !isset($_POST['gender']) && isset($_POST['subject']) &&
                isset($_POST['Scientific']) && isset($_POST['search'])
              ) {
                if ($_POST['search'] != NULL) {

                  $subject_filter = $_POST["subject"];
                  $search_teacher = $_POST["search"];
                  $Scientific_teacher = $_POST["Scientific"];
                  $department_search_name = mysqli_query($conn, 'SELECT T_gender, S_id, T_fname,T_lname, D_id , T_img FROM `teacher` 
    NATURAL JOIN `subject` WHERE D_id="' . $Scientific_teacher . '" AND 
    T_fname= "' . $search_teacher . '" OR T_lname= "' . $search_teacher . '" AND 
    S_id ="' . $subject_filter . '"');
                  while ($res = mysqli_fetch_array($department_search_name)) {
                    include("./include/teacher_content.php");
                  }
                }
              }



              // filter  on  department and  subject
              if (
                !isset($_POST['gender']) && isset($_POST['subject']) &&
                isset($_POST['Scientific']) && isset($_POST['search'])
              ) {
                if ($_POST['search'] == NULL) {

                  $subject_filter = $_POST["subject"];
                  $Scientific_teacher = $_POST["Scientific"];
                  $department_filter = mysqli_query($conn, 'SELECT T_gender, S_id, T_fname,T_lname, D_id , T_img FROM `teacher` 
    NATURAL JOIN `subject` WHERE D_id="' . $Scientific_teacher . '" AND 
                  S_id ="' . $subject_filter . '"');
                  while ($res = mysqli_fetch_array($department_filter)) {
                    include("./include/teacher_content.php");
                  }
                }
              } ?>

              <?php // filter  on  department and  gender
              if (
                isset($_POST['gender']) && !isset($_POST['subject']) &&
                isset($_POST['Scientific']) && isset($_POST['search'])
              ) {
                if ($_POST['search'] == NULL) {

                  $gender_filter = $_POST["gender"];
                  $Scientific_teacher = $_POST["Scientific"];
                  $department_filter = mysqli_query($conn, 'SELECT T_gender, S_id, T_fname,T_lname, D_id , T_img FROM `teacher` 
    NATURAL JOIN `subject` WHERE D_id="' . $Scientific_teacher . '" AND 
                  T_gender ="' . $gender_filter . '"');
                  while ($res = mysqli_fetch_array($department_filter)) {
                    include("./include/teacher_content.php");
                  }
                }
              } ?>


              <?php // filter  on  department   and   subject   and   name  and  gender
              if (
                isset($_POST['gender']) && isset($_POST['subject']) &&
                isset($_POST['Scientific']) && isset($_POST['search'])
              ) {
                if ($_POST['search'] != NULL) {

                  $gender_filter = $_POST['gender'];
                  $subject_filter = $_POST["subject"];
                  $search_teacher = $_POST["search"];
                  $Scientific_teacher = $_POST["Scientific"];
                  $department_filter = mysqli_query($conn, 'SELECT T_gender, S_id, T_fname,T_lname, D_id , T_img 
    FROM `teacher` NATURAL JOIN `subject` WHERE' . 'T_gender="' . $gender_filter . '" AND 
        T_fname= "' . $search_teacher . '" OR T_lname= "' . $search_teacher . '" AND S_id ="' . $subject_filter . '"
        AND D_id="' . $Scientific_teacher . '"');
                  while ($res = mysqli_fetch_array($department_filter)) {
                    include("./include/teacher_content.php");
                  }
                }
              }
              ?>


              <!--end contant-->




              <!-- start new teacher -->
              <div class="col-12 col-lg-4">
                <div class="teacherCard">
                  <button class="btn btn-outline-success addT"><i class="fas fa-plus-circle"></i></button>
                </div>
              </div>


              <!-- new teacher -->
              <div class="create">
                <div class="cont">
                  <i class="far fa-times-circle" id="exit" style="font-size: 30px; text-align: center; cursor: pointer;"></i>
                  <h2>Add new teacher:</h2>
                  <hr>


                  <form class="was-validated" action="a_teacher.php" method="POST">
                    <div class="form-row">
                      <div class="col-md-6 mb-3">
                        <input type="text" class="form-control is-invalid" aria-describedby="validatedInputGroupPrepend" placeholder="first name" name="first_name" required>
                      </div>
                      <div class="col-md-6 mb-3">
                        <input type="text" class="form-control is-invalid" aria-describedby="validatedInputGroupPrepend" placeholder="last name" name="last_name" required>
                      </div>
                      <input type="text" class="form-control is-invalid s1" maxlength="11" aria-describedby="validatedInputGroupPrepend" placeholder="phone number" name="phone_number" required>
                      <label class="style-2">Gender:</label>
                      <div class="div-1">
                        <label for="male" class="gender">Male</label>
                        <input type="radio" id="male" name="gender" value="male" class="radio">
                      </div>
                      <div class="div-1">
                        <label for="female" class="gender">Female</label>
                        <input type="radio" id="female" name="gender" value="female" class="radio">
                      </div>
                      <select id="inputState" class="form-control mt-3" name="subject_id">
                        <option selected>Choose Subject...</option>
                        <?php

                        $all_subject = mysqli_query($conn, 'SELECT * FROM (`department` NATURAL JOIN `subject`) ');
                        while ($res = mysqli_fetch_array($all_subject)) { ?>
                          <option value="<?= $res['S_id'] ?>">
                            <?= $res['D_name'] ?> - <?= $res['S_name'] ?>
                          </option>
                        <?php } ?>
                      </select>
                      <input type="submit" value="Add teacher" class="btn btn-success addTeasher">
                    </div>
                  </form>
                </div>
              </div>

              <?php
              if (
                isset($_POST['first_name']) && isset($_POST['last_name']) &&
                isset($_POST['phone_number']) && isset($_POST['gender']) && isset($_POST['subject_id'])
              ) {
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                  $sql = "insert into teacher (T_fname,T_lname,T_phNumber,T_gender,S_id,T_password) values(
                          '$_POST[first_name]','$_POST[last_name]' ,$_POST[phone_number] 
                          ,'$_POST[gender]','$_POST[subject_id]', '123456')";

                  if (!mysqli_query($conn, $sql)) {
                    echo "error" . mysqli_error($conn);
                  } else {
                    $all_teacher = mysqli_query($conn, 'SELECT * from `teacher` ORDER BY T_id DESC LIMIT 1');
                    $my_teacher = mysqli_fetch_assoc($all_teacher);
                    $new_email = $my_teacher['T_fname'] . "." . $my_teacher['T_lname'] . "." . $my_teacher['T_id'] . "@teacher.school.edu";
                    $sql = "UPDATE `teacher` SET `T_email` = '$new_email' WHERE T_id = $my_teacher[T_id]";
                    mysqli_query($conn, $sql);
                  }
                }
              }
              // header("location: a_teacher.php");
              ?>



              <!-- my js -->

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
                $(document).on('mouseover', 'body', function() {
                  $(this).getNiceScroll().resize();
                });
              </script>
              <script src="../../js/admin/a_teacher.js"></script>
</body>

</html>