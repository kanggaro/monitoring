<?php
    require "../functions.php";
    
    $nomesin = $_GET["nomesin"];
    $status = $_GET["status"];
    // var_dump($nomesin);
    // var_dump($status);die;
    
    if(mesinStatus($nomesin, $status) > 0){

        header("location: ../mesin.php");

    }else{
        echo "
            <script>
                alert('status gagal diupdate');
                document.location.href = '../mesin.php';
            </script>
        ";
    }
?>