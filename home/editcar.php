<?php 
session_start();

//connection string
require("../inc/config.php");

//page access
require('includes/server.php');

$id= "";
if(isset($_GET['id'])){
  $id= $_GET['id'];
}
$error = [];
if(isset($_POST['add'])){
    function cleaninput($formdata){
        $data = trim($formdata);
        $data = stripslashes($formdata);
        $data = htmlspecialchars($formdata);
        return $data;
    }
    $carname = cleaninput($_POST['carname']);
    $carmodel = cleaninput($_POST['carmodel']);
    $platenumber = cleaninput($_POST['platenumber']);
    $carcolor = cleaninput($_POST['carcolor']);
    $carid = cleaninput($_POST['carid']);

    if(empty($carname)){
        array_push($error, "Enter your carname");
    }
    if(empty($carmodel)){
      array_push($error, "Enter your carmodel");
    }
    if(empty($platenumber)){
        array_push($error, "Enter your platenumber");
    }
    if(empty($carcolor)){
      array_push($error, "Enter your carcolor");
    }


    if(count($error) == 0){

        $sql = "UPDATE cars SET name='$carname', model='$carmodel', 
            platenumber='$platenumber', color='$carcolor' where id='$carid' ";
            
        $update = mysqli_query($connect, $sql);
        if($update){
            echo "<script>location='cars.php'</script>";
            $_SESSION['msg'] = "Car Updated";
        }else{
            echo "<script>alert('An error occured, please try agin')</script>";
        }

       
    }

}

?>

<!doctype html>
<html lang="en" data-bs-theme="auto">
  <head><script src="https://getbootstrap.com/docs/5.3/assets/js/color-modes.js"></script>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.111.3">
    <title>Dashboard Template · Bootstrap v5.3</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/dashboard/">

    <link href="https://getbootstrap.com/docs/5.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

    <!-- Favicons -->
    <link rel="apple-touch-icon" href="https://getbootstrap.com/docs/5.3/assets/img/favicons/apple-touch-icon.png" sizes="180x180">
    <link rel="icon" href="https://getbootstrap.com/docs/5.3/assets/img/favicons/favicon-32x32.png" sizes="32x32" type="image/png">
    <link rel="icon" href="https://getbootstrap.com/docs/5.3/assets/img/favicons/favicon-16x16.png" sizes="16x16" type="image/png">
    <link rel="manifest" href="https://getbootstrap.com/docs/5.3/assets/img/favicons/manifest.json">
    <link rel="mask-icon" href="https://getbootstrap.com/docs/5.3/assets/img/favicons/safari-pinned-tab.svg" color="#712cf9">
    <link rel="icon" href="https://getbootstrap.com/docs/5.3/assets/img/favicons/favicon.ico">
    <meta name="theme-color" content="#712cf9">

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }

      .b-example-divider {
        width: 100%;
        height: 3rem;
        background-color: rgba(0, 0, 0, .1);
        border: solid rgba(0, 0, 0, .15);
        border-width: 1px 0;
        box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
      }

      .b-example-vr {
        flex-shrink: 0;
        width: 1.5rem;
        height: 100vh;
      }

      .bi {
        vertical-align: -.125em;
        fill: currentColor;
      }

      .nav-scroller {
        position: relative;
        z-index: 2;
        height: 2.75rem;
        overflow-y: hidden;
      }

      .nav-scroller .nav {
        display: flex;
        flex-wrap: nowrap;
        padding-bottom: 1rem;
        margin-top: -1px;
        overflow-x: auto;
        text-align: center;
        white-space: nowrap;
        -webkit-overflow-scrolling: touch;
      }

      .btn-bd-primary {
        --bd-violet-bg: #712cf9;
        --bd-violet-rgb: 112.520718, 44.062154, 249.437846;

        --bs-btn-font-weight: 600;
        --bs-btn-color: var(--bs-white);
        --bs-btn-bg: var(--bd-violet-bg);
        --bs-btn-border-color: var(--bd-violet-bg);
        --bs-btn-hover-color: var(--bs-white);
        --bs-btn-hover-bg: #6528e0;
        --bs-btn-hover-border-color: #6528e0;
        --bs-btn-focus-shadow-rgb: var(--bd-violet-rgb);
        --bs-btn-active-color: var(--bs-btn-hover-color);
        --bs-btn-active-bg: #5a23c8;
        --bs-btn-active-border-color: #5a23c8;
      }
      .bd-mode-toggle {
        z-index: 1500;
      }
    </style>

    <!-- Custom styles for this template -->
    <link href="dashboard.css" rel="stylesheet">
  </head>
  <body>
    <?php include("includes/header.php") ?>

    <div class="container-fluid">
        <div class="row">
            <?php include("includes/nav.php") ?>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
              <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                  <h1 class="h2">My Cars</h1>
              </div>

              <div class="row justify-content-center">
                <div class="col-md-5">
                  <?php
                    //to show errors, loop through the errors array
                        foreach($error as $car){
                            echo "<span style='color:red'>". $car . "<br> </span>";
                        }
                    ?>

                    <?php 
                        $select = "SELECT * FROM cars where id=$id ";
                        $result = mysqli_query($connect, $select);
                        while($row = mysqli_fetch_assoc($result)){
                    ?>
                    <form action="<?=$_SERVER['PHP_SELF'] ?>" method="post" 
                      enctype="multipart/form-data">
                        <h4>Edit  <?=$row['name']?> <?=$row['model']?></h4>
                        <input type="hidden" value="<?=$id?>" name="carid">
                        <div class="form-group">
                          <label for="carname">Car Name</label>
                          <input type="text" value="<?=$row['name']?>" name="carname" class="form-control">
                        </div>
                        <div class="form-group">
                          <label for="carmodel">Car Model</label>
                          <input type="text" value="<?=$row['model']?>" name="carmodel" class="form-control">
                        </div>
                        <div class="form-group">
                          <label for="platenumber">Plate Number</label>
                          <input type="text" value="<?=$row['platenumber']?>" name="platenumber" class="form-control">
                        </div>
                        <div class="form-group">
                          <label for="carcolor">Car Color</label>
                          <input type="color" value="<?=$row['color']?>" name="carcolor" class="form-control">
                        </div>
                        <div class="form-group">
                          <input type="submit" name="add" class="btn btn-primary">
                        </div>
                    </form>

                    <?php  } ?>
                </div>
              </div>

              
            </main>
        </div>
    </div>


    <script src="https://getbootstrap.com/docs/5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>

      <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script><script src="https://cdn.jsdelivr.net/npm/chart.js@4.2.1/dist/chart.umd.min.js" integrity="sha384-gdQErvCNWvHQZj6XZM0dNsAoY4v+j5P1XDpNkcM3HJG1Yx04ecqIHk7+4VBOCHOG" crossorigin="anonymous"></script><script src="dashboard.js"></script>
  </body>
</html>
