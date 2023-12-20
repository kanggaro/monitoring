<?php

    require 'functions.php';
    // error_reporting(0);

    // belum login, tidak bisa akses
    if( !isset($_SESSION["login"]) ){
        header("Location:login.php");
        exit;
    }
    // bukan admin, tidak bisa akses
    if( $_SESSION["ROLE"] != 'admin'){
        header("Location:login.php");
        exit;
    }

    $user = mysqli_query($conn, "SELECT * FROM tb_user ORDER BY usr_role");

    if( isset($_POST["ubahuser"]) ){
        if( ubahUser($_POST) > 0 ) {
            echo "<script>
                    window.onload = function() {
                        Swal.fire({
                            icon: 'success',
                            title: 'Data user berhasil diperbarui',
                            showConfirmButton: false,
                            timer: 1750
                        });
            }
            </script>";
            // header("Location:user.php");
        }
        else {
            echo mysqli_error($conn);
        }
    }

    if( isset($_POST["search"]) ){

        $search = $conn->real_escape_string($_POST['cari']);
        $user = mysqli_query($conn, "SELECT * FROM tb_user WHERE usr_id LIKE '%".$search."%' OR usr_name LIKE '%".$search."%' ORDER BY usr_role ASC");
        
        if (empty($search)){
            $user = mysqli_query($conn, "SELECT * FROM tb_user ORDER BY usr_role");
        }

    }else
    {
        $user = mysqli_query($conn, "SELECT * FROM tb_user ORDER BY usr_role");
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
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>
        h1, h2, h3, h4, h5, h6, p, a, label {
            text-decoration: none;
            color: white;
            font-family: 'Poppins', sans-serif;
        }
        label{
            color:black;
        }
    </style>
    <title>Simoweld - data user</title>
</head>
<body>

    <?php include_once("navbar.php"); ?>

    <h1 class="d-flex justify-content-center" style="margin:50px 0 25px 0; color:#544021;">Data User</h1>
      
    <div class="container mt-4">
    <!-- content -->
        <div class="mb-3">
            <div class="row margin-tb d-flex justify-content-between">
                <div class="col-md-7 mb-3">
                    <a class="btn btn-success" href="register.php">
                        <i class="bi bi-person-plus-fill"></i> Tambah User
                    </a>
                </div>
                <div class="col-md-5 mb-3">
                    
                   <form class="d-flex" method="post" action="">
                    <input class="form-control me-2" type="search" placeholder="Search NPK or NAME" name="cari" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit" name="search">Search</button>
                  </form>
                </div>
            </div>
        </div>
    
        <!-- @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif -->
        <!-- Button trigger modal -->
        <!-- <button type="button" class="btn btn-primary" href="register.php">
        Tambah User
        </button> -->

        <table class="table">
            <tr>
                <th class="f">No</th>
                <th>NPK</th>
                <th>Nama</th>
                <th>Telepon</th>
                <th>Unit Kerja</th>
                <th>Role</th>
                <th class="l"></th>
                <!-- <th width="280px">Action</th> -->
            </tr>

            <?php $i = 1; ?>
            <?php while($row = mysqli_fetch_array($user)):?>
            <tr class="rowdata">
                <td class="f"><?= $i; ?></td>
                <td><?= $row["usr_id"] ?></td>
                <td><?= $row["usr_name"] ?></td>
                <td><?= $row["usr_hp"] ?></td>
                <td><?= $row["usr_departemen"] ?></td>
                <td><?= $row["usr_role"] ?></td>
                <td class="l">
                    <a class="btn btn-danger btn-del" href="hapus-u.php?id=<?=$row["usr_id"]?>">
                        <!-- onclick="return confirm('yakin?');" -->
                        <i class="bi bi-trash-fill"></i> hapus
                    </a>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#detailUser<?=$i?>">
                        <i class="bi bi-info-circle-fill"></i> detail
                    </button>

                    <!-- Modal -->
                    <div class="modal fade modal-lg" id="detailUser<?=$i?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 style="color:black;" class="modal-title fs-5" id="staticBackdropLabel">Detail User</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="" method="post">
                                    
                                    <div class="modal-body">
                                        <div class="mb-3 row ms-5 me-5">
                                            <label style="text-align:left;" for="npk" class="col-sm-2 col-form-label">NPK</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="npk" name="npk" readonly value="<?= $row["usr_id"]?>">
                                            </div>
                                        </div>
                                        <div class="mb-3 row ms-5 me-5">
                                            <label style="text-align:left;" for="username" class="col-sm-2 col-form-label">Nama</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="username" name="username" value="<?= $row["usr_name"]?>">
                                            </div>
                                        </div>
                                        <div class="mb-3 row ms-5 me-5">
                                            <label style="text-align:left;" for="telepon" class="col-sm-2 col-form-label">Telepon</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="telepon" name="telepon" value="<?= $row["usr_hp"]?>">
                                            </div>
                                        </div>
                                        <div class="mb-3 row ms-5 me-5">
                                            <!-- <label style="text-align:left;" for="unitkerja" class="col-sm-2 col-form-label">Unit Kerja</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="unitkerja" name="unitkerja" value="<?php //$row["usr_departemen"]?>" readonly>
                                            </div> -->
                                            <label style="text-align:left;" for="unitkerja" class="col-sm-2 col-form-label">Unit Kerja</label>
                                            <div class="col-sm-10">
                                                <select class="form-select" aria-label="Default select example" name="unitkerja" id="unitkerja">
                                                    <option selected><?= $row["usr_departemen"]?></option>
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
                                        <div class="mb-3 row ms-5 me-5">
                                            <label style="text-align:left;" for="role" class="col-sm-2 col-form-label">Role</label>
                                            <div class="col-sm-10">
                                                <select class="form-select" aria-label="Default select example" name="role" >
                                                    <option selected><?= $row["usr_role"]?></option>
                                                    <option value="admin">Admin</option>
                                                    <option value="user">User</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                                
                                    <div class="modal-footer">
                                        <button class="btn btn-success" type="submit" name="ubahuser">
                                            <i class="bi bi-floppy-fill"></i>&nbsp;Perbarui
                                        </button>
                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                                            <i class="bi bi-x-circle-fill"></i>&nbsp;Close
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            <?php $i++; ?>
            <?php endwhile; ?>
        </table>
    
    <!-- endsection content -->
    </div>

    <div style="margin-top:175px;">
        <?php include_once('footer.php') ?> 
    </div>

    <!-- untuk sweetalert data dihapus -->
    <?php if(isset($_GET['m'])) : ?>
            <div class="flash-data user" data-flashdata="<?=$_GET['m']?>"></div>
    <?php endif ?>
    <!-- end sweetalert -->
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <?php include_once("script/config.php"); ?>

</body>
</html>