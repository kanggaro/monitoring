<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "db_monitor");

define('GOOGLE_MAP_API_KEY', 'AIzaSyAFRhCcfzENPIhfaYeLJS8Ww8d91jeg3cg');
define('ESP32_API_KEY', 'Ad5F10jkBM0');
define('POST_DATA_URL', 'gpsdata.php');
date_default_timezone_set('Asia/Karachi');

function query($query) {
    global $conn;

    $result = mysqli_query($conn, $query);
    $rows = [];
    while( $row = mysqli_fetch_assoc($result) ) {
        $rows[] = $row;
    }
    return $rows;
}

function hapus($id) {
    global $conn;
    // mysqli_query($conn, "UPDATE tb_history SET tb_user_usr_id = NULL");
    // mysqli_query($conn, "UPDATE tb_user SET usr_id = NULL");
    mysqli_query($conn, "DELETE FROM tb_user WHERE usr_id = '$id'");
    return mysqli_affected_rows($conn);
}

function hapusHst($id) {
    global $conn;
    mysqli_query($conn, "DELETE FROM tb_history WHERE hst_id = '$id'");
    return mysqli_affected_rows($conn);
}

function registrasi($data){
    global $conn;

    // $name = stripslashes($data['name']);
    $usr_id = stripslashes($data['npk']);
    $username = stripslashes($data['username']);
    $unitkerja = stripslashes($data['unitkerja']);
    $telepon = $data['telepon'];
    $password = mysqli_real_escape_string($conn, $data['password']);
    $role = stripslashes($data['role']);
    // $password2 = mysqli_real_escape_string($conn, $data['password2']);

    //cek username
    $result = mysqli_query($conn, "SELECT usr_id FROM tb_user WHERE usr_id = '$usr_id'");

    if(mysqli_fetch_assoc($result)){
        echo "<script>
                alert('NPK sudah terdaftar');
                </script>";

        return false;
    }

    if (empty($usr_id) || empty($username) || empty($telepon) || empty($password)){
        return false;
    }

    //enkripsi password
    $password = password_hash($password, PASSWORD_DEFAULT);

    //add new user to db
    mysqli_query($conn, "INSERT INTO tb_user VALUES('$usr_id', '$username', '$telepon', '$unitkerja', '$role', '$password')");

    return mysqli_affected_rows($conn);
}

function perbaikan($data){
    global $conn;

    $msn_id = stripslashes($data['nomesin']);
    $baterai = $data['baterai'];
    $mesin = $data['mesin'];
    $last_maint = $data['lastmaint'];
    $next_maint = $data['nextmaint'];
    $keterangan = stripslashes($data['keterangan']);
    $usr_id = $_SESSION['ID'];

    if (empty($baterai) || empty($mesin) || empty($last_maint) 
        || empty($next_maint) || empty($keterangan)){

        return false;
    }

    //add new user to db
    mysqli_query($conn, "INSERT INTO tb_history (`hst_baterai`, `hst_mesin`, `hst_last_maint`, `hst_next_maint`,
                                                    `hst_keterangan`, `tb_user_usr_id`, `tb_mesin_msn_id`)    
                        VALUES('$baterai', '$mesin', '$last_maint', '$next_maint', 
                                                        '$keterangan', '$usr_id', '$msn_id')");

    return mysqli_affected_rows($conn);
}

function ubahPassword($data){
    global $conn;

    $password_lama = mysqli_real_escape_string($conn, $data['passwordlama']);
    $password_baru = mysqli_real_escape_string($conn, $data['passwordbaru']);
    $usr_id = $_SESSION['ID'];

    $query  = "SELECT * FROM tb_user WHERE usr_id = '$usr_id'";
    $result = $conn->query($query);
    //cek password lama
    if($result->num_rows > 0){
        $row = $result->fetch_assoc();
        if ( !password_verify( $password_lama, $row["usr_password"]) ){
            // echo "<script>
            //     alert('Password lama tidak sesuai');
            //     </script>";
            echo "<script>
                window.onload = function() {
                    Swal.fire('PASSWORD', 'Password lama tidak sesuai.', 'error');
            }
            </script>";
            return false;
        }

    }

    //enkripsi passwor baru
    $password_baru = password_hash($password_baru, PASSWORD_DEFAULT);

    $query = "UPDATE tb_user SET
                usr_password = '$password_baru'
            WHERE usr_id = '$usr_id'";
            
    // jalankan query        
    mysqli_query($conn, $query);

    return mysqli_query($conn, $query);    
}

function ubahHistory($data){
    global $conn;

    $hst_id = $data['idhst'];
    $baterai = $data['baterai'];
    $mesin = $data['mesin'];
    $last_maint = $data['lastmaint'];
    $next_maint = $data['nextmaint'];
    $keterangan = stripslashes($data['keterangan']);

    if (empty($baterai) && empty($mesin) && empty($lastmaint) && empty($nextmaint) && empty($keterangan)){
        return false;
    }

    $query = "UPDATE tb_history SET
                    hst_baterai = '$baterai',
                    hst_mesin = '$mesin',
                    hst_last_maint = '$last_maint',
                    hst_next_maint = '$next_maint',
                    hst_keterangan = '$keterangan'
                WHERE hst_id = '$hst_id'";

    // jalankan query
    mysqli_query($conn, $query);

    return mysqli_query($conn, $query);
}

function ubahUser($data){
    global $conn;

    $usr_id = stripslashes($data['npk']);
    $username = stripslashes($data['username']);
    $telepon = $data['telepon'];
    $role = stripslashes($data['role']);
    $unitkerja = stripslashes($data['unitkerja']);

    if (empty($usr_id) && empty($username) && empty($telepon)){
        return false;
    }

    $query = "UPDATE tb_user SET
                    usr_name = '$username',
                    usr_hp = '$telepon',
                    usr_role = '$role',
                    usr_departemen = '$unitkerja'
                WHERE usr_id = '$usr_id'";

    // jalankan query
    mysqli_query($conn, $query);

    return mysqli_query($conn, $query);
}

function mesinStatus($nomesin, $status){
    global $conn;
    
    $query = "UPDATE tb_mesin SET
                msn_status = '$status'
            WHERE msn_id = '$nomesin'";
            
    mysqli_query($conn, $query);

    return mysqli_query($conn, $query); 
}

function ubah($data){
    global $conn;

    $id = $data["id"];
    $name = htmlspecialchars($data["name"]);
    $address = htmlspecialchars($data["address"]);
    $email = htmlspecialchars($data["email"]);
    $telepon = htmlspecialchars($data["telepon"]);

    $query = "UPDATE users SET
                name = '$name',
                address = '$address',
                email = '$email',
                telepon = '$telepon',
            WHERE id = '$id'";
            
    mysqli_query($conn, $query);

    return mysqli_query($conn, $query);    
}


