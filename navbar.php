<?php

    $usr_id = $_SESSION["ID"];
    $query  = "SELECT * FROM tb_user WHERE usr_id = '$usr_id'";
    $result = $conn->query($query);

    $usr_sim = mysqli_query($conn, "SELECT * FROM tb_user WHERE usr_id = '$usr_id'");
    if (!$usr_sim) {
        { echo "Error: " . $conn->error; }
    }
    $row_user = $usr_sim->fetch_assoc();

    if( isset($_POST["ubahpassword"]) ){
        if( ubahPassword($_POST) > 0 ) {
            echo "<script>
                    window.onload = function() {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: 'Password berhasil diubah',
                            showConfirmButton: false,
                            timer: 1750
                        });
                    }
                    </script>";
        }
        else {
            echo mysqli_error($conn);
        }
    }

    if( isset($_POST["ubahuser"]) ){
        if( ubahUser($_POST) > 0 ) {
            // header("Location:index.php");
            echo "<script>
                    window.onload = function() {
                        Swal.fire({
                            icon: 'success',
                            title: 'Data berhasil diperbarui',
                            showConfirmButton: false,
                            timer: 1750
                        });
                    }
                    </script>";
        }
        else {
            echo mysqli_error($conn);
        }
    }

    if($result->num_rows > 0){
        $row = $result->fetch_assoc();
    }

    $nav_mesin_kondisi = mysqli_query($conn, "SELECT * FROM 
                                                tb_mesin_kondisi as mk JOIN tb_mesin as m 
                                                ON  mk.tb_mesin_msn_id = m.msn_id
                                                WHERE msn_status = 'Available'");

?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="css/style2.css">

<nav class="navbar navbar-expand-lg bg-primary">
  <div class="container container-fluid d-flex">
    <a class="navbar-brand text-white" href="index.php">SIMOWELD</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNavDropdown">
      <ul class="navbar-nav">

        <li class="nav-item">
            <a class="nav-link active text-white" aria-current="page" href="index.php">
                <i class="bi bi-house-door-fill"></i> &nbsp;Home
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link active text-white" aria-current="page" href="history_all.php">
                <i class="bi bi-clock-history"></i> &nbsp;History Perbaikan
            </a>
        </li>

<!-- monitor mesin -->
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-pc-display-horizontal"></i> &nbsp;Monitor Mesin
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <?php while($row_nav_mesin_kondisi = mysqli_fetch_array($nav_mesin_kondisi)): ?>
                            <li class="nav-item">
                                <a class="text-black dropdown-item" href="mesin_monitor.php?id=<?=$row_nav_mesin_kondisi['msn_id']?>">
                                    <?= $row_nav_mesin_kondisi['msn_id'] ?> - <?php
                                        if($row_nav_mesin_kondisi['mk_condition'] == 0) 
                                            echo "idle";
                                        else if($row_nav_mesin_kondisi['mk_condition'] == 1) 
                                            echo "running";
                                        ?>
                                </a>
                            </li>
                <?php endwhile; ?>

            </ul>
        </li>
<!-- end monitor -->

        <?php if($_SESSION["ROLE"] === "admin") :?>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-database-fill"></i>&nbsp;Data Welding
                </a>
                <ul class="dropdown-menu">
                    <li class="nav-item">
                        <a class="text-black dropdown-item" href="register.php">
                            <i class="bi bi-person-plus-fill"></i> Tambah User
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="text-black dropdown-item" href="user.php">
                            <i class="bi bi-people-fill"></i> Data User
                        </a>
                    </li>
                    <!-- <li class="nav-item">
                        <button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#statusmesin">
                            <i class="bi bi-exclamation-diamond-fill"></i> Status Mesin
                        </button>
                    </li> -->
                    <li class="nav-item">
                        <a class="text-black dropdown-item" href="mesin.php">
                            <i class="bi bi-exclamation-diamond-fill"></i> Status Alat
                        </a>
                    </li>
                </ul>
            </li>
        <!-- <li class="nav-item">
          <a class="nav-link active text-white" aria-current="page" href="user.php">Daftar User</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active text-white" aria-current="page" href="mesin.php">Daftar Mesin</a>
        </li> -->
        <?php endif; ?>
        
        
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-person-circle"></i>&nbsp;<?= $row_user["usr_name"]?>
          </a>
          <ul class="dropdown-menu">
            <li>
                <!-- <a class="dropdown-item" href="#">My profile</a> -->
                <button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#myprofile">
                    <i class="bi bi-person-fill"></i> My profile
                </button>
            </li>
            <li>
                <button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#gantipassword">
                    <i class="bi bi-key-fill"></i> Ganti password
                </button>
            </li>
            <li><a class="dropdown-item" href="logout.php">
                <i class="bi bi-box-arrow-right"></i> Logout
            </a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- Modal Myprofile-->
<div class="modal fade modal-lg" id="myprofile" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 style="color:black;" class="modal-title fs-5" id="staticBackdropLabel">My Profile</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="post">

                <div class="modal-body">
                    <div class="mb-3 row ms-5 me-5">
                        <label for="npk" class="col-sm-2 col-form-label">NPK</label>
                        <div class="col-sm-10">
                            <input readonly type="text" class="form-control" id="npk" name="npk" value="<?= $row["usr_id"]?>">
                        </div>
                    </div>
                    <div class="mb-3 row ms-5 me-5">
                        <label for="username" class="col-sm-2 col-form-label">Nama</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="username" name="username" value="<?= $row["usr_name"]?>">
                        </div>
                    </div>
                    <div class="mb-3 row ms-5 me-5">
                        <label for="telepon" class="col-sm-2 col-form-label">Telepon</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="telepon" name="telepon" value="<?= $row["usr_hp"]?>">
                        </div>
                    </div>
                    <div class="mb-3 row ms-5 me-5">
                        <label for="unitkerja" class="col-sm-2 col-form-label">Unit Kerja</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="unitkerja" name="unitkerja" value="<?= $row["usr_departemen"]?>" readonly>
                        </div>
                    </div>
                    <div class="mb-3 row ms-5 me-5">
                        <label for="role" class="col-sm-2 col-form-label">Role</label>
                        <div class="col-sm-10">
                            <input readonly type="text" class="form-control" id="role" name="role" value="<?= $row["usr_role"]?>" readonly>
                        </div>
                    </div>
                </div>
                            
                <div class="modal-footer">
                    <button class="btn btn-success" type="submit" name="ubahuser">Update</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Modal myprofile -->

<!-- Modal Ganti Password-->
<div class="modal fade modal-lg" id="gantipassword" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 style="color:black;" class="modal-title fs-5" id="staticBackdropLabel">Ganti Password</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="post">

                <div class="modal-body">
                    <div class="mb-3 row d-flex justify-content-center">
                        <label for="passwordlama" class="col-sm-2 col-form-label">Password Lama</label>
                        <div class="col-sm-5">
                            <input name="passwordlama" type="teks" class="form-control" id="passwordlama" value="<?php ?>" >
                        </div>
                    </div>
                    <div class="mb-3 row d-flex justify-content-center">
                        <label for="passwordbaru" class="col-sm-2 col-form-label">Password Baru</label>
                        <div class="col-sm-5">
                            <input name="passwordbaru" type="passwordbaru" class="form-control" id="passwordbaru">
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-success" type="submit" name="ubahpassword">
                        <i class="bi bi-floppy-fill"></i> Ganti Password
                    </button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle-fill"></i> Close
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Modal -->

<!-- Modal Status Mesin-->
<div class="modal fade modal-lg" id="statusmesin" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 style="color:black;" class="modal-title fs-5" id="staticBackdropLabel">Status Mesin</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="post">

                <div class="modal-body">
                    <div class="mb-3 row d-flex justify-content-center">
                        <label for="passwordlama" class="col-sm-2 col-form-label">Password Lama</label>
                        <div class="col-sm-5">
                            <input name="passwordlama" type="teks" class="form-control" id="passwordlama" value="<?php ?>" >
                        </div>
                    </div>
                    <div class="mb-3 row d-flex justify-content-center">
                        <label for="passwordbaru" class="col-sm-2 col-form-label">Password Baru</label>
                        <div class="col-sm-5">
                            <input name="passwordbaru" type="passwordbaru" class="form-control" id="passwordbaru">
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-success" type="submit" name="ubahpassword">
                        <i class="bi bi-floppy-fill"></i> Ganti Password
                    </button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle-fill"></i> Close
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Modal -->


