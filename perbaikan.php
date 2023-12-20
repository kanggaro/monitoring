<?php

    require 'functions.php';
    $nomesin = $_GET["id"];

    if( !isset($_SESSION["login"]) ){
        header("Location:login.php");
        exit;
    }

    if( isset($_POST["perbaikan"]) ){
        if( perbaikan($_POST) > 0 ) {
            header("Location:mesin_history.php?id=$nomesin");
            echo "<script>
                    alert('perbaikan berhasil ditambahkan!');
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

    <title>Simoweld - Perbaikan <?= $nomesin?></title>
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
    
<?php include_once("navbar.php") ?>

<!-- body -->
    <div class="body vh-50">
            <h1 class="d-flex justify-content-center" style="margin: 100px 0 65px 0; color:#544021;">Tambah Perbaikan</h1>

        <form action="" method="post">
            
            <input name="nomesin" type="text" class="form-control" id="nomesin" value="<?= $nomesin ?>" hidden>
            <div class="mb-3 row d-flex justify-content-center">
                <label for="baterai" class="col-10 col-sm-2 col-form-label">Kondisi Baterai</label>
                <div class="col-10 col-sm-5">
                    <input required name="baterai" type="number" class="form-control" id="baterai">
                </div>
            </div>
            <div class="mb-3 row d-flex justify-content-center">
                <label for="mesin" class="col-10 col-sm-2 col-form-label">Kondisi Mesin</label>
                <div class="col-10 col-sm-5">
                    <input required name="mesin" type="number" class="form-control" id="mesin">
                </div>
            </div>
            <div class="mb-3 row d-flex justify-content-center">
                <label for="lastmaint" class="col-10 col-sm-2 col-form-label">Maintenance Terakhir</label>
                <div class="col-10 col-sm-5">
                    <input required name="lastmaint" type="date" class="form-control" id="lastmaint" min="<?php echo date('Y-m-d'); ?>">
                </div>
            </div>
            <div class="mb-3 row d-flex justify-content-center">
                <label for="nextmaint" class="col-10 col-sm-2 col-form-label">Maintenance Selanjutnya</label>
                <div class="col-10 col-sm-5">
                    <input required name="nextmaint" type="date" class="form-control" id="nextmaint" min="<?php echo date('Y-m-d'); ?>">
                </div>
            </div>
            <div class="mb-3 row d-flex justify-content-center">
                <label for="keterangan" class="col-10 col-sm-2 col-form-label">Keterangan</label>
                <div class="col-10 col-sm-5">
                    <textarea name="keterangan" class="form-control" placeholder="Leave a comment here" id="keterangan" style="height: 100px"></textarea>
                </div>
            </div>

            <div class="row d-flex justify-content-center" style="margin-top:65px;">
                <button class="btn col-6 col-md-3" type="submit" name="perbaikan" style="background-color:#f47920; font-weight: 600; color:white;">Kirim</button>
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