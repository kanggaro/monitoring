<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="config/jquery-3.7.1.min.js"></script>
    <script>
        $('.btn-del').on('click', function(e){
            e.preventDefault();
            const href = $(this).attr('href');

            // window.onload = function() {
            Swal.fire({
                title : 'Kamu yakin?',
                text : 'Data akan dihapus?',
                type : 'warning',
                showCancelButton : true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Hapus Data'
                }).then((result) => {
                    if(result.value){
                        document.location.href = href;
                    }
            });
            // }
        })

        $('.hst-del').on('click', function(e){
            e.preventDefault();
            const href = $(this).attr('href');

            // window.onload = function() {
            Swal.fire({
                title : 'Kamu yakin?',
                text : 'History akan dihapus',
                type : 'warning',
                icon : 'warning',
                showCancelButton : true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Hapus Data'
                }).then((result) => {
                    if(result.value){
                        document.location.href = href;
                    }
            });
            // }
        })

        // on off
        $('.onmesin').on('click', function(e){
            e.preventDefault();
            const href = $(this).attr('href');

            // window.onload = function() {
            Swal.fire({
                title : 'Kamu yakin?',
                text : 'mesin las diesel akan dinyalakan',
                type : 'warning',
                icon : 'warning',
                showCancelButton : true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Nyalakan!'
                }).then((result) => {
                    if(result.value){
                        document.location.href = href;
                    }
            });
            // }
        })
        $('.offmesin').on('click', function(e){
            e.preventDefault();
            const href = $(this).attr('href');

            // window.onload = function() {
            Swal.fire({
                title : 'Kamu yakin?',
                text : 'mesin las diesel akan dimatikan',
                type : 'warning',
                icon : 'warning',
                showCancelButton : true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Matikan!'
                }).then((result) => {
                    if(result.value){
                        document.location.href = href;
                    }
            });
            // }
        })
        // end on off

        const flashdatauser = $('.user').data('flashdatauser');
        if(flashdatauser){
            Swal.fire({
                title: 'Deleted!',
                text: 'User has been deleted.',
                icon: 'success',
                showConfirmButton: false,
                timer: 1750
            });
        }

        const flashdatahistory = $('.hst-del').data('flashdatahistory');
        if(flashdatahistory){
            Swal.fire({
                title: 'Deleted!',
                text: 'History been deleted.',
                icon: 'success',
                showConfirmButton: false,
                timer: 1750
            });
        }

        // const flashdataonoff = $('.onoff').data('flashdataonoff');
        // if(flashdataonoff){
        //     Swal.fire({
        //         title: 'Success!',
        //         icon: 'success',
        //         showConfirmButton: false,
        //         timer: 1750
        //     });
        // }

    </script>