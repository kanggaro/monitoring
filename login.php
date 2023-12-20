<?php

    require 'functions.php';

    //redirect ke beranda user/admin, jika uda login 
    if( isset($_SESSION["login"]) ){
        header("Location: index.php");
    }

    if (isset($_POST['login'])) {
        
        $npk = $conn->real_escape_string($_POST['npk']);
        $password = $conn->real_escape_string($_POST['password']);
        
        // cek input
        if (!empty($npk) || !empty($password)) {
            $query  = "SELECT * FROM tb_user WHERE usr_id = '$npk'";
            $result = $conn->query($query);
            if($result->num_rows > 0){
                $row = $result->fetch_assoc();
                // cek password
                if ( password_verify( $password, $row["usr_password"]) ){
                    $_SESSION['login'] = true;
                    $_SESSION['ID'] = $row['usr_id'];
                    $_SESSION['ROLE'] = $row['usr_role'];
                    $_SESSION['NAME'] = $row['usr_name'];
                    header("Location: index.php");
                    die();  
                }else{
                    $error = true;
                }             
            }else{
                $erroruser = true;
            } 
        }else{
            $error = true;
        }
        // $error = true;
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
    <link rel="stylesheet" href="css/login.css">
    <title>Simoweld - login</title>
    <style>
        h1, h2, h3, h4, h5, h6, p, a {
            text-decoration: none;
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body>

<!-- body -->

<section class="vh-100" style="">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col col-xl-10">
        <div class="card bg-glass" style="border-radius: 1rem; border:1px solid white;">
          <div class="row g-0">
            <!-- <div class="col-md-6 col-lg-5 d-none d-md-block"> -->
              <img src="img/PKT_view.png"
                alt="login form" class="col-md-6 col-lg-7 d-none d-md-block img-fluid pkt_view" />
            <!-- </div> -->
            <div class="col-md-6 col-lg-5 d-flex align-items-center">
              <div class="card-body p-4 p-lg-5 text-black">

                <form action="" method="post">

                  <div class="d-flex align-items-center mb-3 pb-1">
                    <i class="fas fa-cubes fa-2x me-3" style="color: #ff6219;"></i>
                    <img class="img-pkt-h" src="img/PKT_H.png" alt="">
                    <!-- <span class="h1 fw-bold mb-0">logo</span> -->
                  </div>
                  <!-- <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">SIMOWELD</h5> -->

                    <div style="" class="d-flex justify-content-around">
                        <?php if( isset($error) ) :?>
                            <p class="alert-login" style="color:red">harap isi username/password yang benar</p>
                        <?php endif;?>
                    </div>
                            
                    <div style="" class="d-flex justify-content-around">
                        <?php if( isset($erroruser)) :?>
                            <p class="alert-login" style="color:red">NPK belum terdaftar, hubungi admin</p>
                        <?php endif; ?>
                    </div>                     

                    <div class="form-outline mb-4">
                        <label class="form-label" for="npk">NPK</label>
                        <input name="npk" type="text" class="form-control col-sm-2 " id="npk" value="">
                        <!-- <input type="email" id="form2Example17" class="form-control form-control-lg" /> -->
                    </div>

                    <div class="form-outline mb-4">
                        <label class="form-label" for="password">Password</label>
                        <input name="password" type="password" class="form-control col-sm-2 " id="password">
                        <!-- <input type="password" id="form2Example27" class="form-control form-control-lg" /> -->
                    </div>

                    <div class="pt-1 mb-4">
                        <button name="login" type="submit" class="btn-login p-2">Login SIMOWELD</button>
                    </div>

                  <!-- <a class="small text-muted" href="#!">Forgot password?</a>
                  <p class="mb-5 pb-lg-2" style="color: #393f81;">Don't have an account? <a href="#!"
                      style="color: #393f81;">Register here</a></p> -->
                  <a href="#!" class="small text-muted">&copy 2023.</a>
                  <a href="#!" class="small text-muted">PT Pupuk Kalimantan Timur</a>
                </form>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- old -->
    <!-- <div class="container">
        <div class="row d-flex justify-content-center">
            <img class="pkt_h" src="img/PKT_H.png" alt="">
        </div>

        
    </div>

    

    <div class="body"style="margin: 2rem;">
        <h1 class="d-flex justify-content-center" style="margin:180px 0 45px 0; color:#544021;">LOGIN</h1>

        <div style="" class="d-flex justify-content-around">
            <?php if( isset($error) ) :?>
                <p style="color:red">harap isi username/password yang benar</p>
            <?php endif;?>
        </div>
                
        <div style="" class="d-flex justify-content-around">
            <?php if( isset($erroruser)) :?>
                <p style="color:red">NPK belum terdaftar, hubungi admin</p>
                <div class="alert alert-danger" role="alert">
                    NPK belum terdaftar, hubungi admin!
                </div>
            <?php endif; ?>
        </div>

        <form action="" method="post">

            <div class="mb-3 row d-flex justify-content-center">
                <label for="npk" class="col-sm-2 col-form-label">NPK</label>
                <div class="col-sm-5">
                    <input name="npk" type="text" class="form-control" id="npk" value="">
                </div>
            </div>
            <div class="mb-3 row d-flex justify-content-center">
                <label for="password" class="col-sm-2 col-form-label">Password</label>
                <div class="col-sm-5">
                    <input name="password" type="password" class="form-control" id="password">
                </div>
            </div>
                        
            <div class="d-flex justify-content-center" style="margin-top:75px;">
                <button class="btn" type="submit" name="login" style="background-color:#f47920; font-weight: 600; color:white; padding:10px 200px">Login</button>
            </div>

        </form>
    </div> -->

<!-- end old -->

<!-- body     -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>