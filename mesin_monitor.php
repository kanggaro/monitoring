<?php
    require "functions.php";

    $nomesin = $_GET["id"];

    $mesin = mysqli_query($conn, "SELECT * FROM tb_mesin WHERE msn_id = '$nomesin'");
    // $mesin = mysqli_query($conn, "SELECT * FROM tb_mesin WHERE msn_id = '$nomesin'");
    $new_hst = mysqli_query($conn, "SELECT * FROM tb_history WHERE tb_mesin_msn_id = '$nomesin' ORDER BY hst_id DESC LIMIT 1");
    $control = mysqli_query($conn, "SELECT * FROM tb_mesin_kondisi WHERE tb_mesin_msn_id = '$nomesin'");
    $location = mysqli_query($conn, "SELECT * FROM tb_location WHERE tb_mesin_msn_id = '$nomesin'");

    // merubah tampilan date dari database
    $location_date = mysqli_query($conn, "SELECT DATE_FORMAT( lct_date ,'%d %M %Y - %H:%i:%s') as lct_date_format FROM tb_location WHERE tb_mesin_msn_id = '$nomesin'");
    // $location_date = mysqli_query($conn, "SELECT DATE_FORMAT( DATE_ADD( lct_date ,  INTERVAL 1 HOUR),'%d %M %Y - %H:%i:%s') as lct_date_format FROM tb_location WHERE tb_mesin_msn_id = '$nomesin'");
    if (!$location_date) {
        { echo "Error: " . $conn->error; }
    }
    $row_lct_date = $location_date->fetch_assoc();
    // end merunah
    
    // table mesin
    if($mesin->num_rows > 0){
        $row_m = $mesin->fetch_assoc();
    }

    // cek status mesin
    if($nomesin == $row_m['msn_id'] && $row_m['msn_status'] == 'Unavailable'){
        header("Location:index.php");
    }

    // table mesin kondisi
    if (!$control) {
        { echo "Error: " . $conn->error; }
    }
    $row_c = $control->fetch_assoc();
    $row_c_usr_id = $row_c['tb_user_usr_id'];

    // query untuk siapa yang terakhir nyalakan dan matikan
    $control_pj = mysqli_query($conn, "SELECT * FROM tb_user WHERE usr_id = '$row_c_usr_id'");
    if (!$control_pj) {
        { echo "Error: " . $conn->error; }
    }
    $row_usr_id = $control_pj->fetch_assoc();
    // end
    // var_dump($row_c_usr_id);die;


    // if($control->num_rows > 0){
    //     $row_c = $control->fetch_assoc();
    // }

    // table location
    if (!$location) {
        { echo "Error: " . $conn->error; }
    }
    $row_l = $location->fetch_assoc();    
    
    // table mesin
    $msn_id = $row_m["msn_id"];
    $msn_merk = $row_m["msn_merk"];
    $msn_tipe = $row_m["msn_tipe"];
    $msn_ampere = $row_m["msn_ampere"];
    $msn_voltage = $row_m["msn_voltage"];

    // table mesin kondisi    
    $mk_condition = $row_c["mk_condition"];
    // echo "$row_l";
    // var_dump($row_usr_id);die;       

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="30;URL='mesin_monitor.php?id=<?=$nomesin?>'">

    <link rel="icon" href="img/PKT_V.png" type="image/ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="css/mesin_monitor.css">


    <title>Simoweld - Monitor <?= $msn_id?></title>
</head>
<body>

    <?php include_once("navbar.php") ?>

    <!-- <h3>awal map</h3> -->
    <!-- <div id="map-layer"></div> -->
    <!-- <h3>akhir map</h3> -->

    <!-- alert history -->
    <div class="container" style="margin-top:1rem;">
        <div class="row d-flex justify-content-around">
            <div class="col-3 col-sm-1 fw-bold p-3 m-1 d-flex justify-content-center alert-monitor">
                <?= $msn_id?>
            </div>
            <div class="col-10 col-sm-5 p-3 m-1 d-flex justify-content-center alert-monitor">
                Last Location : <?php
                                if($row_lct_date['lct_date_format'] == NULL)
                                    echo '..Not Found..';
                                else if($row_lct_date['lct_date_format'] != NULL)
                                    echo $row_lct_date['lct_date_format'];
                                ?>
            </div>
            <div class="col-10 col-sm-5 p-3 m-1 d-flex justify-content-center alert-monitor">
                Last Control : <?php
                                if($mk_condition == 0 && $row_c['tb_user_usr_id'] == NULL)
                                    echo '..';
                                else if($mk_condition == 0)
                                    echo 'OFF';
                                else if($mk_condition == 1)  
                                    echo 'ON';
                                ?><?php
                                    if($row_c['tb_user_usr_id'] == NULL){
                                        echo 'Not Found..';
                                    }else if($row_c['tb_user_usr_id'] != NULL){ ?>
                                        by <?=$row_usr_id['usr_name']?> (<?=$row_usr_id['usr_hp']?>)
                                <?php } ?>
            </div>
        </div>
    </div>
    <!-- end alert history -->

    <div class="container d-flex justify-content-center" style="margin-top:1rem;">
        
        <div class="row" style="width:100%;">
            <!-- kolom1 -->
            <div class="col-md-8 col-12 mb-3" id="maps">
                <div class="card" style="border:1px solid #f47920;">
                    <div class="card-header" style="background-color:#f47920; color:white; font-weight:600;">
                        Maps <?= $msn_id?>
                    </div>
                    <div class="card-body">
                            <?php
                            if($row_l === NULL)
                                echo "Maps belum tersedia...";
                            ?>
                            <!-- // }else if ($row_l){ -->
                            <?php
                                if($row_l !== NULL){
                            ?>
                                <iframe style="width: 100%; height: 70vh ;" src='https://www.google.com/maps?q=<?=$row_l['lct_lat']?>,<?=$row_l['lct_lng']?>&hl=es;z=14&output=embed'></iframe>
                            <?php ;}?>
                    </div>        
                    <!-- <div class="card-footer text-muted">
                        <h6>search for <a href="https://maps.app.goo.gl/CuD41Vhz8ApFGrqU8">location</a></h6>
                    </div> -->
                </div>
            </div>
            <!-- kolom2 -->
            <div class="col-md-4 col-12">
                
                <!-- switch -->
                <div class=" mb-3" id="button">
                    <div class="card" style="border:1px solid #f47920;">
                        <div class="card-header" style="background-color:#f47920; color:white; font-weight:600;">
                            Switch <?= $msn_id?>
                        </div>
                        <div class="card-body" style="background-color:#fff5ef;">
                            <h5 class="card-title d-flex justify-content-center">
                                <?php
                                if($mk_condition == NULL)
                                    echo 'Relay belum di set';
                                else if($mk_condition == 0)
                                    echo 'Mesin OFF';
                                else if($mk_condition == 1)  echo 'Mesin ON';
                                ?>
                            </h5>
                                <?php
                                    if($mk_condition == NULL)
                                        echo "<p class='d-flex justify-content-center'>...</p>";
                                    else if($mk_condition == 0)
                                        echo "<a href='aksi.php?channel=$nomesin&state=1' class='onmesin d-flex justify-content-center m-4'>
                                                <img class='bg1' src='img/bg-1.png'>   
                                            </a>";
                                        // echo "<a href='aksi.php?channel=$nomesin&state=1' class='btn btn-success onmesin d-flex justify-content-center m-4'>ON</a>";
                                    else if($mk_condition == 1)
                                        echo "<a href='aksi.php?channel=$nomesin&state=0' class='offmesin d-flex justify-content-center m-4'>
                                                <img class='bm1' src='img/bm-1.png'>   
                                            </a>";
                                        // echo "<a href='aksi.php?channel=$nomesin&state=0' class='btn btn-danger offmesin d-flex justify-content-center m-4'>OFF</a>";
                                ?>  

                                <!-- <a href='aksi.php?channel=$nomesin&state=1'>
                                    <img src="img/bg-1.png" alt="">   
                                </a> -->
                                                       
                        </div>
                    </div>
                </div>
                <!-- history -->
                <a href="mesin_history.php?id=<?=$nomesin?>" class="text-black text-decoration-none hst-href">
                    
                    <div class="" id="history">
                        <div class="card" style="border:1px solid #f47920;">
                            <div class="card-header" style="background-color:#f47920; color:white; font-weight:600;">
                                <div class="row">
                                    <div class="col">History <?= $msn_id?></div>
                                    <div class="col d-flex justify-content-end" style="color:white;">detail</div> 
                                </div>
                            </div>
                            <div class="card-body hst-body">
                                <div class="row mb-2">
                                    <ul class="list">
                                        <li class="list-group-item fw-semibold mb-1"><u>MESIN LAS <?= $msn_id?></u></li>
                                        <div class="row">
                                            <div class="col-5">
                                                <li class="fw-semibold list-group-item">Merk</li> 
                                                <li class="fw-semibold list-group-item">Tipe</li> 
                                            </div> 
                                            <div class="col-7">
                                                <li class="list-group-item"><?= $msn_merk?></li> 
                                                <li class="list-group-item"><?= $msn_tipe?></li> 
                                            </div>
                                        </div>
                                    </ul>
                                </div>
                                <div class="row">
                                    <ul class="list">
                                        <li class="list-group-item fw-semibold mb-1"><u>KAPASITAS MESIN</u></li>
                                        <div class="row">
                                            <div class="col-5">
                                                <li class="fw-semibold list-group-item">Ampere Max</li> 
                                                <li class="fw-semibold list-group-item">Voltage</li> 
                                            </div> 
                                            <div class="col-7">
                                                <li class="list-group-item"><?= $msn_ampere?></li> 
                                                <li class="list-group-item"><?= $msn_voltage?></li> 
                                            </div>
                                        </div>
                                    </ul>
                                </div>
                                <div class="row">  
                                    <ul class="list">
                                        <li class="list-group-item fw-semibold mb-1"><u>MAINTENANCE TERBARU</u></li>
                                        <div class="row">
                                            <div class="col-8">
                                                <li class="fw-semibold list-group-item">Kondisi Baterai</li> 
                                                <li class="fw-semibold list-group-item">Kondisi Mesin</li> 
                                                <li class="fw-semibold list-group-item">Maintenance Terakhir</li> 
                                                <li class="fw-semibold list-group-item">Maintenance Selanjutnya</li> 
                                            </div> 
                                            <div class="col-4">
                                                <?php
                                                    if($new_hst->num_rows > 0){
                                                        $row_h = $new_hst->fetch_assoc();

                                                        $hst_id = $row_h["hst_id"];
                                                        $hst_baterai = $row_h["hst_baterai"];
                                                        $hst_mesin = $row_h["hst_mesin"];
                                                        $hst_lastmaint = $row_h["hst_last_maint"];
                                                        $hst_nextmaint = $row_h["hst_next_maint"];
                                                ?>

                                                <li class="list-group-item"><?=$hst_baterai?>%</li>
                                                <li class="list-group-item"><?= $hst_mesin?>%</li> 
                                                <li class="list-group-item"><?= $hst_lastmaint?></li>                                                 
                                                <li class="list-group-item"><?= $hst_nextmaint?></li> 
                                                
                                                <?php
                                                    }else{
                                                        echo "
                                                            <li class=\"list-group-item\">tidak ada data..</li> 
                                                        ";
                                                    }
                                                ?> 
                                            </div>     
                                        </div>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    
    <div class="mt-2">
        <?php include_once('footer.php') ?> 
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script>
    function saveScrollPosition() {
                sessionStorage.setItem('scrollPosition', window.scrollY);
            }

            // Fungsi untuk memulihkan posisi gulir dari sessionStorage
            function restoreScrollPosition() {
                var scrollPosition = sessionStorage.getItem('scrollPosition');
                window.scrollTo(0, scrollPosition || 0);
            }

            // Event listener untuk menangkap aksi menyegarkan halaman
            window.addEventListener('beforeunload', saveScrollPosition);
            window.addEventListener('load', restoreScrollPosition);
    </script>
    <script>
        function longPolling() {
    $.ajax({
        url: 'getData.php',
        method: 'GET',
        success: function(data) {
            // Memeriksa perubahan data
            if (adaPerubahanData) {
                location.reload();
            } else {
                // Jika tidak ada perubahan, lakukan polling lagi
                longPolling();
            }
        },
        error: function() {
            // Handle error jika ada
        }
    });
}

// Memulai long polling saat halaman dimuat
$(document).ready(function() {
    longPolling();
});
    </script>
    <?php include_once("script/config.php"); ?>
    

</body>
</html>