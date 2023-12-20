<?php
    require "functions.php";
    
    $nomesin = $_GET["nomesin"];
    $idH = $_GET["id"];
    
    if(hapusHst($idH) > 0){

        header("location: mesin_history.php?id=$nomesin&m=1");

    }else{
        // header("location: mesin_history.php?id=$nomesin&m=1");
        echo "
            <script>
                alert('History gagal dihapus');
                document.location.href = 'mesin_history.php?id=$nomesin';
            </script>
        ";
    }
?>