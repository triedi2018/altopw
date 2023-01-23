<script src="https://js.pusher.com/5.1/pusher.min.js"></script>
  <script>

    // Enable pusher logging - don't include this in production
    // Pusher.logToConsole = true;
/*
    var pusher = new Pusher('ae907be302551e0bb4e9', {
      cluster: 'ap1',
      forceTLS: true
    });

    var channel = pusher.subscribe('my-channel');
    channel.bind('my-event', function(data) {
    //   alert(JSON.stringify(data));
        xhr = $.ajax({
            method : "POST",
            url : "<?= base_url('notifikasi/list-notifikasi') ?>",
            success : function(response){
                $('.list-notifikasi').html(response);
            }
        })
    });
*/
  </script>
  
  <script>
    let log_off = new Date();
    log_off.setMinutes(log_off.getMinutes() + 55)
    log_off = new Date(log_off)

    let int_logoff = setInterval(function(){
        let now = new Date();
        if (now > log_off){
            window.location.assign("<?= base_url() ?>login/logoff");
            clearInterval(int_logoff);
        }
    }, 5000);

    $('body').on('click',function(){
        // console.log('asdfsaf')
        log_off = new Date()
        log_off.setMinutes(log_off.getMinutes() + 55)
        log_off = new Date(log_off)
        console.log(log_off)
    })

    // loading dulu ach ---
    show_loading();
    $( window ).on("load", function() {
        // Handler for .load() called.
        $(".preload-wrapper6").fadeOut('slow');
    });
    function show_loading(){
        $(".preload-wrapper6").show();	
    }
    function hide_loading(){
        $(".preload-wrapper6").fadeOut('fast');
    }
    function call_datepicker(){
        $('.datepicker').datepicker({
            autoclose: true,
            todayHighlight: true
        });
    }

    $('.list-notifikasi').on('click','.notifikasi',function(e){
        let id = e.currentTarget.dataset.id;
        let jenis_notif = e.currentTarget.dataset.jenis;
        show_loading();
        xhr = $.ajax({
            method : "POST",
            url : "<?= base_url('notifikasi/approval') ?>",
            data : 'id='+id+'&jenis_notif='+jenis_notif,
            success : function(response){
                $('.div-modal-approval').html(response);
                $('.modal-approval').modal('show');
                hide_loading();
            }
        })
    })

    /// CEK UNTUK 2 MODAL SUPAYA BISA SCROLL
    $('body').on('hidden.bs.modal', function () {
        if($('.modal.in').length > 0)
        {
            $('body').addClass('modal-open');
        }
    });


    /////// disable close modal escape
    // $.fn.modal.prototype.constructor.Constructor.DEFAULTS.backdrop = 'static';
    // $.fn.modal.prototype.constructor.Constructor.DEFAULTS.keyboard =  false;


    function format_angka(nilai) 
    {
        bk = nilai.replace(/[^\d]/g,"");
        ck = "";
        panjangk = bk.length;
        j = 0;
        for (i = panjangk; i > 0; i--) 
        {
            j = j + 1;
            if (((j % 3) == 1) && (j != 1)) 
            {
                ck = bk.substr(i-1,1) + "." + ck;
                xk = bk;
            }else 
            {
                ck = bk.substr(i-1,1) + ck;
                xk = bk;
            }
        }
        return ck;
        
    }

    function hanya_angka(nilai) {
        bk = nilai.replace(/[^\d]/g,"");
        ck = "";
        panjangk = bk.length;
        j = 0;
        for (i = panjangk; i > 0; i--) 
        {
            
                ck = bk.substr(i-1,1) + ck;
                xk = bk;
            
        }
        return ck;
    }
    function formatNumber (num) {
        return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.")
    }
    function error_timeout_ajax($param1){				
        swal({
            title: "Perhatian!",
            text: ($param1 ? $param1 : "Gagal Memuat Halaman, silahkan coba lagi atau periksa koneksi internet anda.."),
            type: "warning",
            confirmButtonColor: "#007AFF" 
        });
    }

    
    
</script>
</body>
</html>