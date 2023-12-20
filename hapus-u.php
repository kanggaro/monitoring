<?php
    require "functions.php";
    
    $id = $_GET["id"];
    // var_dump($id);die;
    
    if(hapus($id) > 0){
        header("location: user.php?m=1");
        // echo "
        //     <script>
        //     window.onload = function() {
        //         Swal.fire({
        //             title: 'Deleted!',
        //             text: 'Your file has been deleted.',
        //             icon: 'success'
        //         });
        //     }
        //     </script>
        // ";
    }else{
        echo "
            <script>
                alert('data gagal dihapus');
                document.location.href = 'user.php';
            </script>
        ";
    }
?>