<?php 
session_start();

//connection string
require("../inc/config.php");

//page access
require('includes/server.php');

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

    $filename = $_FILES['image']['name'];
    $size = $_FILES['image']['size'];
    $filepath= "../uploads/" . $_FILES['image']['name'];
    $ext = pathinfo($filepath, PATHINFO_EXTENSION);
    $image = $filename;

    $extarray = ['png','jpg','jpeg'];
    if(!in_array($ext, $extarray)){
        array_push($error, "Invalid Extension");
    }

    if($size > 500000){
        array_push($error, "File is too large");
    }

    if(file_exists($filepath)){
        array_push($error, "The file already exist");
    }


    if(count($error) == 0){

        move_uploaded_file($_FILES['image']['tmp_name'], $filepath);

        $ownersname = $_SESSION['fullname'];
        $ownersid = $_SESSION['id'];

        $insert = "INSERT INTO cars(name,model, platenumber,color,image,
        ownersname,ownersid) 
        VALUES('$carname','$carmodel', '$platenumber','$carcolor', 
        '$image','$ownersname','$ownersid') ";

        if(mysqli_query($connect, $insert)){
            echo "<script>alert('Car added  Successfully')</script>";
        }else{
            echo "<script>alert('An error occured, please try agin')</script>";
        }

       
    }

}

if(isset($_GET['delete'])){
  $id= $_GET['delete'];
  $sql = "DELETE from cars where id='$id'";

  if(mysqli_query($connect, $sql)){
    echo "<script>alert('Car Deleted')</script>";
  }else{
    echo "<script>alert('Please try again')</script>";
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

    <link href="https://getbootstrap.com/docs/5.3/dist/css/bootstrap.min.css" rel="stylesheet">

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
                    <form action="<?=$_SERVER['PHP_SELF'] ?>" method="post" 
                      enctype="multipart/form-data">
                        <h4>Add a New Car</h4>
                        <div class="form-group">
                          <label for="carname">Car Name</label>
                          <input type="text" name="carname" class="form-control">
                        </div>
                        <div class="form-group">
                          <label for="carmodel">Car Model</label>
                          <input type="text" name="carmodel" class="form-control">
                        </div>
                        <div class="form-group">
                          <label for="platenumber">Plate Number</label>
                          <input type="text" name="platenumber" class="form-control">
                        </div>
                        <div class="form-group">
                          <label for="carcolor">Car Color</label>
                          <input type="color" name="carcolor" class="form-control">
                        </div>
                        <div class="form-group">
                          <label for="image">Car Photo</label>
                          <input type="file" name="image" class="form-control">
                        </div>
                        <div class="form-group">
                          <input type="submit" name="add" class="btn btn-primary">
                        </div>
                    </form>
                </div>
              </div>

              <div class="row">
                <?php 
                  $select = "SELECT * FROM cars where ownersid={$_SESSION['id']} ";
                  $result = mysqli_query($connect, $select);
                  while($row = mysqli_fetch_assoc($result)){
                ?>
                  <div class="col-md-4 my-2">
                    <div class="card">
                      <div class="card-body">
                        <img src="../uploads/<?=$row['image']?>" alt="car" 
                          class="img-fluid">
                        <hr>
                        <p class="text-center">
                          <?=$row['name']?> <br> <?=$row['model']?>
                          <br>
                          <i><?=$row['platenumber']?></i>
                        </p>
                        <p class="text-center">
                          <button onclick="if(confirm('Are you sure you want to delete'))
                          {location.href='cars.php?delete=<?=$row['id']?>'}" 
                            class="btn btn-danger">Delete</button>
                          <a href="editcar.php?id=<?=$row['id']?>" 
                            class="btn btn-success">Edit</a>
                        </p>
                      </div>
                    </div>
                  </div>
                <?php  } ?>

              </div>
              
            </main>
        </div>
    </div>


    <script src="https://getbootstrap.com/docs/5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>

      <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script><script src="https://cdn.jsdelivr.net/npm/chart.js@4.2.1/dist/chart.umd.min.js" integrity="sha384-gdQErvCNWvHQZj6XZM0dNsAoY4v+j5P1XDpNkcM3HJG1Yx04ecqIHk7+4VBOCHOG" crossorigin="anonymous"></script><script src="dashboard.js"></script>
  </body>
</html>
