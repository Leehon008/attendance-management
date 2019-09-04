<?php
include './../config/config.php';
include './includes/dbConnection.php';
//include '../helpers/format_helper.php';

session_start();
if(!isset($_SESSION["admin_id"])){
    header("location:./login.php");
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="<?php echo(SITE_AUTHOR); ?>" content="Lee Hon and Bootstrap contributors">
    <title><?php echo SITE_TITTLE; ?> </title>
    <link rel="shortcut icon" type="image/png" href="teacher_image/stc_icon.png">
      <!-- testing-->
      <script src="../libraries/js/jquery.min.js"></script>
      <script src="../libraries/js/dataTables.min.js"></script>
      <script src="../libraries/js/bootstrap4.min.js"></script>
      <script src="../libraries/js/bootstrap.min.js"></script>
      <script src="../libraries/js/jquery.datatables.min.js"></script>
      <script src="../libraries/js/popper.min.js"></script>
    <!-- Bootstrap core CSS -->
      <link href="../libraries/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
      <link rel="stylesheet" href="../libraries/css/custom_style.css">
      <link href="./../libraries/css/bootstrap4.min.css" rel="stylesheet"/>
    <!-- Custom styles for this template -->
      <link href="../libraries/css/datepicker.css" rel="stylesheet" />
      <link href="../libraries/css/starter-template.css" rel="stylesheet"/>

      <link href="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.slim.min.js" />
      <script type="text/javascript" src="../libraries/js/bootstrap-datepicker.js"></script>
      <script type="text/javascript" src="./../libraries/js/bootstrap.bundle.min.js"></script>

  </head>
  <body>
    <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
  <a class="navbar-brand" href="<?php echo $base_url; ?>admin/">Home</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarsExampleDefault">
    <ul class="navbar-nav mr-auto">
         <li class="nav-item ">
             <a class="nav-link" href="./grade.php">Grade</a>
         </li>
        <li class="nav-item">
            <a class="nav-link" href="./teacher.php">Teacher</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="./student.php">Student</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="./attendance.php">Attendance</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="./logout.php">Logout</a>
        </li>
    </ul>
  </div>
</nav>



