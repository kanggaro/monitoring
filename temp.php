<?php
    // session_start();
    require "functions.php";

    // if( !isset($_SESSION["login"]) ){
    //     header("Location:login.php");
    //     exit;
    // }

    if( isset($_POST["ubahpassword"]) ){
        if( ubahPassword($_POST) > 0 ) {
            // header("Location:login.php");
            echo "<script>
                    alert('Password berhasil diubah!');
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
                    alert('Datamu berhasil diubah!');
                    </script>";
        }
        else {
            echo mysqli_error($conn);
        }
    }

    // if (isset($_POST['monitor'])) {
        
    //     $msn_id = $conn->real_escape_string($_POST['idmesin']);

    //     $query  = "SELECT * FROM tb_mesin WHERE msn_id = '$msn_id'";
    //     $result = $conn->query($query);
    //     if($result->num_rows > 0){

    //         $row = $result->fetch_assoc();

    //         $_SESSION['idmesin'] = $row['idmesin'];
    //         header("Location: index.php");
    //         die();

    //     }else{
    //         $erroruser = true;
    //     }

    // }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    
    <title>Document</title>
</head>
<body>
    <?php include_once('navbar.php') ?> 
    
    <div class="container">

        <!-- <?php
            if($_SESSION["ROLE"] === "admin"){
                echo "<h2>halaman admin</h2>";
            }
            elseif($_SESSION["ROLE"] === "user"){
                echo "<h2>halaman user</h2>";
            }
        ?> -->

        <h3 class="m-4">Welcome, <?=$_SESSION['NAME']?> <?php if($_SESSION["ROLE"] === "admin") echo"(admin)"?></h3>

        <!-- <?php if($_SESSION["ROLE"] === "admin") :?>
            <button><a href="register.php">register</a></button>
        <?php endif; ?>
        <?php if($_SESSION["ROLE"] === "admin") :?>
            <button><a href="user.php">daftar user</a></button>
        <?php endif; ?>
        user
        <button><a href="history_all.php">History</a></button>
        <button><a href="logout.php">logout</a></button> -->

            <?php
                // echo $_SESSION['ID'];

                // if (mysqli_num_rows($password_lama) > 0) {
                //     while($rowData = mysqli_fetch_array($password_lama)){
                //           echo $rowData["usr_password"].'<br>';
                //     }
                // }
            ?>

<!-- ganti password -->
        <!-- <form action="" method="post">
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
                        
            <div class="d-flex justify-content-center" style="margin-top:75px;">
                <button class="btn" type="submit" name="ubahpassword" style="background-color:#CDAC76; font-weight: 600; color:white; padding:10px 150px">Ubah Password</button>
            </div>
        </form> -->
<!-- akhir ganti password -->

        <?php
        $mesin = mysqli_query($conn, "SELECT * FROM tb_mesin ORDER BY msn_status ASC");
        ?>
        <div class="row">
            <!-- kolom button -->
            <div class="col-md-2">
                <?php if($_SESSION["ROLE"] === "admin") :?>
                    <a class="btn text-decoration-none mb-3" style="background-color:#1268b3;color:white; width:100%;" href="register.php">register</a>
                <?php endif; ?>
                <?php if($_SESSION["ROLE"] === "admin") :?>
                    <a class="btn text-decoration-none mb-3" style="background-color:#1268b3;color:white; width:100%;" href="user.php">daftar user</a>
                <?php endif; ?>
                <a class="btn text-decoration-none mb-3" style="background-color:#1268b3; color:white; width:100%;" href="history_all.php">History</a>
            </div>
            <!-- kolom mesin -->
            <div class="col-md-10 scrollspy-example" data-bs-spy="scroll">
                <?php while($row = mysqli_fetch_array($mesin)):?> 

                <div class="container">

                    <?php if($row['msn_status'] == 'available'){?>
                    <a class="text-decoration-none" href="mesin_monitor.php?id=<?= $row['msn_id']?>">
                        <div class="row" style="1px solid red"></div>
                        <div class="row p-5 list-mesin mb-3" style="border:1px solid red">
                            <div class="col d-flex justify-content-center img m-2">
                                <img src="img/700.jpeg" alt="">
                            </div>
                            <div class="col d-flex justify-content-center align-items-center m-2"><p><?= $row['msn_id']?></p></div>
                            <div class="col d-flex flex-column justify-content-center m-2">
                                <div class="row"><?= $row['msn_merk']?></div>
                                <div class="row"><?= $row['msn_tipe']?></div>
                            </div>
                        </div>
                    </a>
                    
                    <?php }if($row['msn_status'] == 'unavailable'){?>
                    <a class="text-decoration-none" href="mesin_monitor.php?id=<?= $row['msn_id']?>" style="pointer-events: none;">
                        <div class="row" style="1px solid red"></div>
                        <div class="row p-5 list-mesin mb-3" style="border:1px solid red">
                            <div class="col d-flex justify-content-center img m-2">
                                <img src="img/700.jpeg" alt="">
                            </div>
                            <div class="col d-flex justify-content-center align-items-center m-2"><p><?= $row['msn_id']?></p></div>
                            <div class="col d-flex flex-column justify-content-center m-2">
                                <div class="row"><?= $row['msn_merk']?></div>
                                <div class="row"><?= $row['msn_tipe']?></div>
                            </div>
                        </div>
                    </a>
                    <?php } ?>

                </div>


                <?php endwhile; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.js"></script>
</body>
</html>