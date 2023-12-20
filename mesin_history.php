<?php

// error_reporting(0);
    require 'functions.php';
    $nomesin = $_GET["id"];

    $mesin = mysqli_query($conn, "SELECT * FROM tb_mesin WHERE msn_id = '$nomesin'");

    if($mesin->num_rows > 0){
        $row_m = $mesin->fetch_assoc();
    }    
    $msn_id = $row_m["msn_id"];
    $msn_merk = $row_m["msn_merk"];
    $msn_tipe = $row_m["msn_tipe"];
    $msn_ampere = $row_m["msn_ampere"];
    $msn_voltage = $row_m["msn_voltage"];

    $history = mysqli_query($conn, "SELECT * FROM tb_history WHERE tb_mesin_msn_id = '$nomesin'");
    // if($history->num_rows > 0){
    //     $row_h = $history->fetch_assoc();
    // }
    // $usr_id = $row_h["tb_user_usr_id"];

    // $usr_id = $_SESSION['ID'];

    // // var_dump($usr_id);die;
    
    // $user = mysqli_query($conn, "SELECT * FROM tb_history JOIN tb_user WHERE usr_id = '$usr_id'");
    // if($user->num_rows > 0){
    //     $row_u = $user->fetch_assoc();
    // }
    // $usr_name = $row_u['usr_name'];
    // $usr_hp = $row_u['usr_hp'];

    // belum login, tidak bisa akses
    if( !isset($_SESSION["login"]) ){
        header("Location:login.php");
        exit;
    }

    if( isset($_POST["ubahhistory"]) ){
        if( ubahHistory($_POST) > 0 ) {
            // header("Location:mesin_history.php?id=$nomesin");
            echo "<script>
                    window.onload = function() {
                        Swal.fire({
                            icon: 'success',
                            title: 'History berhasil diperbarui',
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

    if( isset($_POST["search"]) ){

        $search = $conn->real_escape_string($_POST['cari']);
        $history = mysqli_query($conn, "SELECT * FROM tb_history WHERE tb_mesin_msn_id = '$nomesin' AND hst_id LIKE '%".$search."%'");
        
        if (empty($search)){
            $history = mysqli_query($conn, "SELECT * FROM tb_history WHERE tb_mesin_msn_id = '$nomesin'");
        }

    }else
    {
        $history = mysqli_query($conn, "SELECT * FROM tb_history WHERE tb_mesin_msn_id = '$nomesin'");
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
    
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <style>
        *{
            /* border: 1px solid red; */
        }
        
        h1, h2, h3, h4, h5, h6, p, a, label {
            text-decoration: none;
            color: white;
            font-family: 'Poppins', sans-serif;
        }
        label{
            color:black;
        }
    </style>

    <title>Simoweld - History <?= $nomesin ?></title>
</head>
<body>

    <?php include_once("navbar.php"); ?>

    <h1 class="d-flex justify-content-center" style="margin:50px 0 25px 0; color:#544021;">Histori Mesin <?= $_GET['id']?></h1>
      
    <div class="container mt-4">
    <!-- content -->
        <div class="mb-3">
            <div class="row d-flex justify-content-between">
                <div class="col-md-7 mb-3">
                    <a class="btn btn-success" href="perbaikan.php?id=<?= $_GET['id']?>">
                        <i class="bi bi-file-earmark-plus-fill"></i> perbaikan
                    </a>
                </div>
                <div class="col-md-5 mb-3">
                    <form class="d-flex" method="post" action="">
                        <input class="form-control me-2" type="search" placeholder="Search id history" name="cari" aria-label="Search">
                        <button class="btn btn-outline-success" type="submit" name="search">Search</button>
                    </form>
                </div>
            </div>
        </div>

        <table class="table">
            <tr>
                <th class="f">No</th>
                <th>ID History</th>
                <th>Kondisi Baterai</th>
                <th>Kondisi Mesin</th>
                <th>Maintenance Terakhir</th>
                <th>Maintenance Selanjutnya</th>
                <th>Penanggung Jawab</th>
                <th class="l"></th>
                <!-- <th width="280px">Action</th> -->
            </tr>

            <?php $i = 1; ?>
            <?php while($row = mysqli_fetch_array($history)):?>
            <tr>
                <td class="f"><?= $i; ?></td>
                <td><?= $row["hst_id"] ?></td>
                <td class="h"><?= $row["hst_baterai"] ?>%</td>
                <td class="h"><?= $row["hst_mesin"] ?>%</td>
                <td class="h"><?= $row["hst_last_maint"] ?></td>
                <td class="h"><?= $row["hst_next_maint"] ?></td>
                <td>
                    <?php
                        $npk = $row['tb_user_usr_id'];
                        if ($npk == NULL){
                            echo "PJ dihapus dari database..";
                        }
                        else{
                            $peng = mysqli_query($conn, "SELECT * FROM tb_history INNER JOIN tb_user ON usr_id = '$npk'");
                            if($peng->num_rows > 0){
                                $row_tu = $peng->fetch_assoc();
                            }?>
                            <!-- echo $row_tu['usr_name'] + '(' + $row_tu['usr_hp'] + ')'; -->
                            <?=$row_tu['usr_name']?> (<?= $row_tu['usr_hp']?>)
                    <?php } ?>
                </td>
                <!-- <td><?= $usr_name ?> (<?= $usr_hp ?>)</td> -->
                <td class="l">
                    <a class="btn btn-danger hst-del" href="hapus-h.php?id=<?=$row["hst_id"]?>&nomesin=<?=$nomesin?>">
                    <!-- <a class="btn btn-danger" href="hapus-h.php?nomesin=<?=$nomesin?>" onclick="return confirm('yakin?');"> -->
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
                                    <h1 style="color:black;" class="modal-title fs-5" id="staticBackdropLabel">Detail Perbaikan</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="" method="post">
                                
                                    <div class="modal-body">
                                        <div class="mb-3 row ms-5 me-5">
                                            <label style="text-align:left;" for="idhst" class="col-sm-5 col-form-label">ID Histori</label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control" id="idhst" name="idhst" readonly value="<?= $row["hst_id"]?>">
                                            </div>
                                        </div>                                    
                                        <div class="mb-3 row ms-5 me-5">
                                            <label style="text-align:left;" for="pj" class="col-sm-5 col-form-label">Penanggung Jawab</label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control" id="pj" name="pj" 
                                                    value="<?php
                                                                $npk = $row['tb_user_usr_id'];
                                                                if ($npk == NULL){
                                                                    echo "PJ dihapus dari database..";
                                                                }
                                                                else{
                                                                    $peng = mysqli_query($conn, "SELECT * FROM tb_history INNER JOIN tb_user ON usr_id = '$npk'");
                                                                    if($peng->num_rows > 0){
                                                                        $row_tu = $peng->fetch_assoc();
                                                                    }?><?=$row_tu['usr_id']?> - <?=$row_tu['usr_name']?> (<?= $row_tu['usr_hp']?>)
                                                            <?php } ?>
                                                    " readonly>
                                            </div>
                                        </div>
                                        <div class="mb-3 row ms-5 me-5">
                                            <label style="text-align:left;" for="merk" class="col-sm-5 col-form-label">Merk</label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control" id="merk" name="merk" readonly value="<?= $msn_merk ?>">
                                            </div>
                                        </div>
                                        <div class="mb-3 row ms-5 me-5">
                                            <label style="text-align:left;" for="tipe" class="col-sm-5 col-form-label">Tipe</label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control" id="tipe" name="tipe" readonly value="<?= $msn_tipe ?>">
                                            </div>
                                        </div>
                                        <div class="mb-3 row ms-5 me-5">
                                            <label style="text-align:left;" for="ampere" class="col-sm-5 col-form-label">Ampere</label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control" id="ampere" name="ampere" readonly value="<?= $msn_ampere ?>">
                                            </div>
                                        </div>
                                        <div class="mb-3 row ms-5 me-5">
                                            <label style="text-align:left;" for="voltage" class="col-sm-5 col-form-label">Voltage</label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control" id="voltage" name="voltage" readonly value="<?= $msn_voltage ?>">
                                            </div>
                                        </div>
                                        <div class="mb-3 row ms-5 me-5">
                                            <label style="text-align:left;" for="baterai" class="col-sm-5 col-form-label">Kondisi Baterai</label>
                                            <div class="col-sm-7">
                                                <input type="number" class="form-control" id="baterai" name="baterai" placeholder="<?= $row["hst_baterai"]?> %" value="">
                                            </div>
                                        </div>
                                        <div class="mb-3 row ms-5 me-5">
                                            <label style="text-align:left;" for="mesin" class="col-sm-5 col-form-label">Kondisi Mesin</label>
                                            <div class="col-sm-7">
                                                <input type="number" class="form-control" id="mesin" name="mesin" placeholder="<?= $row["hst_mesin"]?> %" value="">
                                            </div>
                                        </div>
                                        <div class="mb-3 row ms-5 me-5">
                                            <label style="text-align:left;" for="lastmaint" class="col-sm-5 col-form-label">Maintenance Terakhir</label>
                                            <div class="col-sm-7">
                                                <input type="date" class="form-control" id="lastmaint" name="lastmaint" value="<?= $row["hst_last_maint"]?>">
                                            </div>
                                        </div>
                                        <div class="mb-3 row ms-5 me-5">
                                            <label style="text-align:left;" for="nextmaint" class="col-sm-5 col-form-label">Maintenance Selanjutnya</label>
                                            <div class="col-sm-7">
                                                <input type="date" class="form-control" id="nextmaint" name="nextmaint" value=<?= $row["hst_next_maint"]?>>
                                            </div>
                                        </div>
                                        <div class="mb-3 row ms-5 me-5">
                                            <label style="text-align:left;" for="keterangan" class="col-sm-5 col-form-label">Keterangan Perbaikan</label>
                                            <div class="col-sm-7">
                                                <textarea name="keterangan" class="form-control" id="keterangan"><?= $row["hst_keterangan"]?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                                
                                    <div class="modal-footer">
                                        <button class="btn btn-success" type="submit" name="ubahhistory">
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
            <div class="flash-data hst-del" data-flashdata="<?=$_GET['m']?>"></div>
    <?php endif ?>
    <!-- end sweetalert -->
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <?php include_once("script/config.php"); ?>

</body>
</html>