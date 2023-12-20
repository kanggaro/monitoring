<?php  
// kontrol

require '../functions.php';

if(isset($_POST['token'])){
    $token = $_POST['token'];

    $sql = mysqli_query($conn, "SELECT * FROM tb_mesin_kondisi WHERE mk_token='$token'");
    $query = mysqli_num_rows($sql);//jumlah baris dalam tabel

    if($query > 0){
        $data = mysqli_fetch_assoc($sql);
    }
    else{
        $data = ['token' => 'Not Valid'];
    }

    $res = json_encode($data);
    echo $res;
}

?>