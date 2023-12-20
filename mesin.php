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

    $mesin = mysqli_query($conn, "SELECT * FROM tb_mesin ORDER BY msn_id");
    // $mesin_token = mysqli_query($conn, "SELECT * FROM tb_mesin_kondisi WHERE ");

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
    <title>Simoweld - data mesin</title>
</head>
<body>

    <?php include_once("navbar.php"); ?>


    <h1 class="d-flex justify-content-center text-center" style="margin:50px 0 50px 0; color:#544021;">
        Data Mesin Las Diesel Pupuk Kaltim
        <!-- <span><img class="" width="350px" src="img/PKT_H.png" alt=""></span> -->
    </h1>

    <div class="container mt-4">
    <!-- content -->

        <table class="table">
            <tr>
                <th class="f">No</th>
                <th>No Mesin</th>
                <th>Merk</th>
                <th>Tipe</th>
                <th>Ampere</th>
                <th>Voltage</th>
                <th>Token</th>
                <th class="l">Status Alat</th>
                <!-- <th width="280px">Action</th> -->
            </tr>

            <?php $i = 1; ?>
            <?php while($row = mysqli_fetch_array($mesin)):?>
            <tr class="rowdata">
                <td class="f"><?= $i; ?></td>
                <td><?= $row["msn_id"] ?></td>
                <td><?= $row["msn_merk"] ?></td>
                <td><?= $row["msn_tipe"] ?></td>
                <td><?= $row["msn_ampere"] ?></td>
                <td><?= $row["msn_voltage"] ?></td>
                <td>
                    <?php 
                        $mesin_id = $row["msn_id"];
                        $token = mysqli_query($conn, "SELECT * FROM tb_mesin INNER JOIN tb_mesin_kondisi ON tb_mesin_msn_id = '$mesin_id'");
                        if($token->num_rows > 0)
                            $token_mesin = $token->fetch_assoc();
                    ?>
                    <?= $token_mesin['mk_token'] ?>
                </td>
                <td class="h">
                    <!-- <a href=""><?= $row["msn_status"] ?></a> -->
                    <div class="dropdown">
                        <button class="btn 
                            <?php
                                if($row["msn_status"] == "Available"){
                                    echo "btn-success";
                                }else if($row["msn_status"] == "Unavailable"){
                                    echo "btn-danger";
                                }
                            ?> 
                            dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                            <?= $row["msn_status"] ?>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                            <li><a class="dropdown-item" href="crud/mesin-status.php?nomesin=<?=$row["msn_id"]?>&status=Available">Available</a></li>
                            <li><a class="dropdown-item" href="crud/mesin-status.php?nomesin=<?=$row["msn_id"]?>&status=Unavailable">Unavailable</a></li>
                        </ul>
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
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <?php include_once("script/config.php"); ?>

</body>
</html>