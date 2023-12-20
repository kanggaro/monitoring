<?php
    require "functions.php";
    
    $id = $_GET["id"];
    $nomesin = $_GET["nomesin"];
    
    if(hapus($id) > 0){
        echo "
            <script>
                alert('data berhasil dihapus');
                document.location.href = 'user.php';
            </script>
        ";
    }else if(hapus($id) < 0){
        echo "
            <script>
                alert('data gagal dihapus');
                document.location.href = 'user.php';
            </script>
        ";
    }
    else if(hapusHst($id) > 0){

        echo "
            <script>
                alert('History berhasil dihapus');
                document.location.href = 'mesin_history.php?id=$nomesin';
            </script>
        ";
    }else if(hapusHst($id) < 0){
        echo "
            <script>
                alert('History gagal dihapus');
                document.location.href = 'mesin_history.php?id=$nomesin';
            </script>
        ";
    }
?>