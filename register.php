<?php

    require 'functions.php';

    if( !isset($_SESSION["login"]) ){
        header("Location:login.php");
        exit;
    }

    if( $_SESSION["ROLE"] != 'admin'){
        header("Location:login.php");
        exit;
    }

    if( isset($_POST["register"]) ){
        if( registrasi($_POST) > 0 ) {
            header("Location:user.php");
            echo "<script>
                    alert('User berhasil ditambahkan!');
                    </script>";
        }
        else {
            echo mysqli_error($conn);
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="img/PKT_V.png" type="image/ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <title>Simoweld - Registrasi</title>
    <style>
        h1, h2, h3, h4, h5, h6, p, a, label {
            text-decoration: none;
            color: white;
            font-family: 'Poppins', sans-serif;
        }

        label {
            color: black;
        }
    </style>
</head>
<body>

<?php include_once("navbar.php"); ?>

<!-- body -->
    <div class="body vh-50">
            <h1 class="d-flex justify-content-center" style="margin:100px 0 65px 0; color:#544021;">REGISTER USER</h1>

        <form action="" method="post">

            <div class="mb-3 row d-flex justify-content-center">
                <label for="npk" class="col-10 col-sm-2 col-form-label">NPK</label>
                <div class="col-10 col-sm-5">
                    <input required name="npk" type="text" class="form-control" id="npk" value="">
                </div>
            </div>
            <div class="mb-3 row d-flex justify-content-center">
                <label for="username" class="col-10 col-sm-2 col-form-label">Username</label>
                <div class="col-10 col-sm-5">
                    <input required name="username" type="text" class="form-control" id="username" value="">
                </div>
            </div>
            <div class="mb-3 row d-flex justify-content-center">
                <label for="telepon" class="col-10 col-sm-2 col-form-label">Telepon</label>
                <div class="col-10 col-sm-5">
                    <input required name="telepon" type="text" class="form-control" id="telepon">
                </div>
            </div>
            <div class="mb-3 row d-flex justify-content-center">
                <label for="unitkerja" class="col-10 col-sm-2 col-form-label">Unit Kerja</label>
                <div class="col-10 col-sm-5">
                    <!-- <input name="unitkerja" type="text" class="form-control" id="unitkerja" value="Departemen Bengkel dan Alat Berat"> -->
                    <select required class="form-select" aria-label="Default select example" name="unitkerja" id="unitkerja">
                    <option selected disabled>Pilih Unit Kerja</option>
                        <option value="Departement Pengelasan dan Perpipaan">Departement Pengelasan dan Perpipaan</option>
                        <option value="Departement Bengkel dan Alat Berat">Departement Bengkel dan Alat Berat</option>
                        <option value="Departement Inspeksi Teknik">Departement Inspeksi Teknik</option>
                        <option value="Departement Kelistrikan">Departement Kelistrikan</option>
                        <option value="Departement Manajemen Aset">Departement Manajemen Aset</option>
                        <option value="Departement Perencanaan & Pemeliharaan 2">Departement Perencanaan & Pemeliharaan 2</option>
                        <option value="Departement Operation & Maintenance">Departement Operation & Maintenance</option>
                        <option value="Departement Teknik Kontrol Kualitas">Departement Teknik Kontrol Kualitas</option>
                    </select>
                </div>
            </div>
            <div class="mb-3 row d-flex justify-content-center">
                <label for="password" class="col-10 col-sm-2 col-form-label">Password</label>
                <div class="col-10 col-sm-5">
                    <input required name="password" type="password" class="form-control" id="password">
                </div>
            </div>
            <div class="mb-3 row d-flex justify-content-center">
                <label for="role" class="col-10 col-sm-2 col-form-label">Role</label>
                <div class="col-10 col-sm-5">
                    <select required class="form-select" aria-label="Default select example" name="role">
                    <option selected disabled>Pilih Role</option>
                        <option value="admin">Admin</option>
                        <option value="user">User</option>
                    </select>
                </div>
                <!-- <div class="col-sm-5">
                    <input name="role" type="text" class="form-control" id="role">
                </div> -->
            </div>
            <!-- <div class="mb-3 row d-flex justify-content-center">
                <label for="password2" class="col-sm-2 col-form-label">Konfirmasi Password</label>
                <div class="col-sm-5">
                    <input name="password2" type="password" class="form-control" id="password">
                </div>
            </div> -->
                        
            <div class="row d-flex justify-content-center" style="margin-top:75px;">
                <button class="btn col-6 col-md-3" type="submit" name="register" style="background-color:#f47920; font-weight: 600; color:white;">Register</button>
            </div>
        </form>

        <div style="margin-top:175px;">
            <?php include_once('footer.php') ?> 
        </div>
    </div>
<!-- end body     -->


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

</body>
</html>