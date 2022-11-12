
<script type="text/javascript">

//set default swal sweet alert..
const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
});




$('.btn-action').on('click',function(){
  show_loading();

  xhr = $.ajax({
    method : "POST",
    url : "<?= base_url().$this->uri->segment(1,0).$this->uri->slash_segment(2,'both')?>tambah",
    data:"jenis=tambah",
    success: function(response){
      $('.tampil-modal').html(response);
      $('.modal-action').modal({
        backdrop: 'static',
        keyboard: false},'show');

        validate_form('tambah');
        cek_divisi_jabatan();
        call_datepicker();
		
		  $(".allow_only_numbers").keydown(function(e) {

			// Allow: backspace, delete, tab, escape, enter and .
			if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 173 , 190]) !== -1 ||
			  // Allow: Ctrl+A,Ctrl+C,Ctrl+V, Command+A
			  ((e.keyCode == 65 || e.keyCode == 86 || e.keyCode == 67) && (e.metaKey === true)) ||
			  // Allow: home, end, left, right, down, up
			  (e.keyCode >= 35 && e.keyCode <= 40)) {
			  // let it happen, don't do anything
			  return;
			}
			// Ensure that it is a number and stop the keypress
			if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {			
			  e.preventDefault();
			}
		  });

	xhr = $.ajax({
	  method : "POST",
	  url : "<?= base_url().$this->uri->segment(1,0).$this->uri->slash_segment(2,'both')?>list-produk",
	  success: function(response){
		$('#list_produk').html(response);
				
		hide_loading();
	  },
	  error : function(){

	  }
	})
		  

      hide_loading();
    },
    error : function(){

    }
  })
})
function cek_divisi_jabatan(){
  $('#form-action').on('change','#divisi',function(e){
    // console.log(e.target.value);
    show_loading();
    xhr = $.ajax({
      method : "POST",
      url : "<?= base_url().$this->uri->segment(1,0).$this->uri->slash_segment(2,'both')?>list-jabatan",
      data : "divisi="+e.target.value,
      success: function(response){
        $('#jabatan').html(response);
        hide_loading();
      },
      error : function(){

      }
    })
    
  });
  $('#form-action').on('change','#jabatan',function(e){
    if (e.target.value != "" ){
      // console.log(e.target.value);
      show_loading();
      xhr = $.ajax({
        method : "POST",
        url : "<?= base_url().$this->uri->segment(1,0).$this->uri->slash_segment(2,'both')?>list-atasan",
        data : "nik="+$('#nik').val()+"&divisi="+$('#divisi').val(),
        success: function(response){
          $('#atasan1').html(response);
          $('#atasan2').html(response);
          hide_loading();
        },
        error : function(){

        }
      })
    }
  });
}
function validate_form(action){
  

  $.validator.setDefaults({
    
  });
  
  $('#form-action').validate({
    rules: {
      id_produk:{required:true},
      jumlah: { required: true },
      tanggal_masuk:{required:true},
    },
    messages: {
      id_produk:"Harus diisi",
      jumlah:"Harus diisi",
      tanggal_masuk:"Harus diisi",
    },
    errorElement: 'span',
    errorPlacement: function (error, element) {
      error.addClass('invalid-feedback');

        error.appendTo($(element).closest('.form-group').find('.symbol'));
    },
    highlight: function (element, errorClass, validClass) {
    //   $(element).addClass('is-invalid');
      $(element).closest('.form-group').removeClass('has-success').addClass('has-error').find('.symbol').removeClass('ok').addClass('required');

    },
    unhighlight: function (element, errorClass, validClass) {
        $(element).closest('.form-group').removeClass('has-error');

    },
    success: function (label, element) {
        label.addClass('help-block valid');
        // mark the current input as valid and display OK icon
        $(element).closest('.form-group').removeClass('has-error').addClass('has-success').find('.symbol').removeClass('required').addClass('ok');
    },
    submitHandler: function () {
      $('#simpan').text('Menyimpan data...');
      $('#simpan').attr('disabled','disabled');

      show_loading();
      let formdata = $('#form-action').serialize();
      xhr = $.ajax({
        method : "POST",
        url : "<?= base_url().$this->uri->segment(1,0).$this->uri->slash_segment(2,'both') ?>simpan-"+action,
        data : formdata,
        success: function(response){
          let result = JSON.parse(response);

          if (result.status == 'error'){
            hide_loading();
            $('#simpan').text('Simpan');
            $('#simpan').removeAttr('disabled');
          }else{
            reload_table();
            $('.modal-action').modal('hide');
            hide_loading();
          }
          Toast.fire({
            type: result.status,
            title: result.pesan
          })
          

        },
        

      })



    }
  });
}


function detail_table ( d ) {
    return d.action;
}
$(document).ready(function () {
    table_data = $('#example1').DataTable({

        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.

        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?= base_url().$this->uri->segment(1,0).$this->uri->slash_segment(2,'leading')."/tampildata"; ?>",
            "type": "POST",
            "data":{'<?= $this->security->get_csrf_token_name() ?>':'<?= $this->security->get_csrf_hash() ?>'},
            
        },

        //Set column definition initialisation properties.
        // "columnDefs": [
        // { 
        //     "targets": [ 5 ], //last column
        //     "orderable": false, //set not orderable
        // }
        // ],
        

        "columns": [
            { "data": "nama_produk" },
            { "data": "jumlah_in" },
			{ "data": "jumlah_out" },
			{ "data": "jumlah_all" },
        ],
		
		"lengthMenu": [[50, -1], [50, "All"]]

    });
    var detailRows = [];
    $('#example1 tbody').on( 'click', 'tr td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = table_data.row( tr );
        var idx = $.inArray( tr.attr('id'), detailRows );
 
        if ( row.child.isShown() ) {
            tr.removeClass( 'details' );
            row.child.hide();
 
            // Remove from the 'open' array
            detailRows.splice( idx, 1 );
        }
        else {
            tr.addClass( 'details' );
            row.child( detail_table( row.data() ) ).show();
 
            // Add to the 'open' array
            if ( idx === -1 ) {
                detailRows.push( tr.attr('id') );
            }
        }
    } );

    // action edit dan delete
    $('#example1 tbody').on('click','.btn-edit',function(e){
      // alert(e.data);
      // console.log('nik',e.target.dataset.nik);
      // console.log('csrf',e.target.dataset.<?=$this->security->get_csrf_token_name() ?>);
      // console.log('id',e.target.dataset.id);
      // console.log('jenis action',e.target.dataset.jenis_action);

      xhr = $.ajax({
        method : "POST",
        url : "<?= base_url().$this->uri->segment(1,0).$this->uri->slash_segment(2,'both')?>edit",
        data: {"jenis":"edit","nik":e.target.dataset.nik,'id': e.target.dataset.id,'<?= $this->security->get_csrf_token_name() ?>':e.target.dataset.<?=$this->security->get_csrf_token_name() ?> },
        success: function(response){
          if (response == 'error'){
            window.location.href = "<?= base_url('unauthorized') ?>";
          }else{
            $('.tampil-modal').html(response);
            $('.modal-action').modal({
              backdrop: 'static',
              keyboard: false},'show');

              validate_form('edit');
              cek_divisi_jabatan();
              call_datepicker();

          }

          hide_loading();
        },
        error : function(){

        }
      })

    })
	
    $('#example1 tbody').on('click','.btn-hapus',function(e){
      console.log(e);

		Swal.fire({
			title: "Hapus data ini?",
			text: "Data yang terhapus tidak bisa dikembalikan!",
			  icon: 'warning',
			  showCancelButton: true,
			  timerProgressBar: true,
			  confirmButtonColor: '#3085d6',
			  cancelButtonColor: '#d33',
			  confirmButtonText: "Iya, Hapus",
		}).then((result) => {

		if (result.isConfirmed) {

		      xhr = $.ajax({
			method : "POST",
			url : "<?= base_url().$this->uri->segment(1,0).$this->uri->slash_segment(2,'both')?>hapus",
			data: {"jenis":"delete","id":e.target.dataset.id,'<?= $this->security->get_csrf_token_name() ?>':e.target.dataset.<?=$this->security->get_csrf_token_name() ?> },
			success: function(response){
			  if (response == 'error'){
			    window.location.href = "<?= base_url('unauthorized') ?>";
			  }else{
			
				reload_table();
				
			  }

			  hide_loading();
			},
			error : function(){

			}
		      })

		}			
			
		})

    })	

 
    // On each draw, loop over the `detailRows` array and show any child rows
    // table_data.on( 'draw', function () {
    //     $.each( detailRows, function ( i, id ) {
    //         $('#'+id+' td.details-control').trigger( 'click' );
    //     } );
    // } );

  
});
function reload_table()
{
  table_data.ajax.reload(null,false); //reload datatable ajax 
}
</script>
