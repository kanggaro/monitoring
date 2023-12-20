<?php
    require 'functions.php';

    $usr_id = $_SESSION["ID"];


    if(isset($_GET['channel']) && isset($_GET['state'])){
        // include 'connection.php';

        $nomesin = $_GET['channel'];
        $state = $_GET['state'];

        mysqli_query($conn, "UPDATE tb_mesin_kondisi SET mk_condition='$state', tb_user_usr_id = '$usr_id'
                                WHERE tb_mesin_msn_id = '$nomesin'");

        // if($channel == 1){
        // }
        // else if($channel == 2){
        //     mysqli_query($conn, "UPDATE tb_mesin_kondidi SET mk_condition='$state'");
        // }
        header("location: mesin_monitor.php?id=$nomesin&m=1");
        exit;
    }

?>