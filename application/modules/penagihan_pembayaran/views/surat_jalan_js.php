
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
		  url : "<?= base_url().$this->uri->segment(1,0).$this->uri->slash_segment(2,'both')?>list-customers",
		  success: function(response){
			$('#list_customers').html(response);
			
			$('#list_customers').select2({
			  //placeholder: 'Select an option'
			  width: '100%'
			});			
			
			  $('#form-action').on('change','#list_customers',function(e){
				  
			$("#description ol").html("");				  
				  show_loading();
				  
				if (e.target.value != "" ){
					
				  console.log(e.target);
				  
				  var address = $(this).find(':selected').data('address');
				  var phone = $(this).find(':selected').data('phone');
				  var attn = $(this).find(':selected').data('attn');
				  
				  console.log(address);
				  console.log(phone);
				  console.log(attn);
				  
				  $('textarea[name="address"]').val(address);
				  $('input[name="phone"]').val(phone);
				  $('input[name="attn"]').val(attn);				  
				  
				}
				
				hide_loading();
				
			  });			
			
			
			$('#add-items').on('click',function(){
				
				$("#description ol").append("<li style='margin-bottom:10px;'> Produk: &nbsp;<select id='list_produk' class='description_name' type='text' style='width:250px;' required  /> &nbsp; Quantity: &nbsp;<input type='text' style='width:50px;' required align='center' class='allow_only_numbers description_quantity'  /> &nbsp; Harga: &nbsp;<input type='text' style='width:150px;' required class='allow_only_numbers description_price'  />&nbsp; <a href='javascript:void(0);' class='remove'>×</a></li>"); 
				$(document).on("click", "a.remove" , function() {
					$(this).parent().remove();
				});

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
				  
				  var customer_id = $("#list-customers").val();;
				  console.log("xxxxx"+$('#list_customers').val());
				  
					xhr = $.ajax({
					  method : "POST",
					  url : "<?= base_url().$this->uri->segment(1,0).$this->uri->slash_segment(2,'both')?>list-produk",
					  data : { customer_id : $('#list_customers').val() },
					  success: function(response){
						  
						  console.log(response);
						  
						$('.description_name').last().html(response);
						
						  $('#form-action').on('change','.description_name',function(e){
							if (e.target.value != "" ){
								
							  console.log(e.target);
							  
							  var nama_produk = $(this).find(':selected').data('nama_produk');
							  var id_produk = $(this).find(':selected').data('id');
							  var harga = $(this).find(':selected').data('harga');
							  
							  console.log(nama_produk);
							  console.log(id_produk);
							  console.log(harga);
							  
							  $(this).parent().find('.description_price').val(harga);
							  
							  
							}
						  });	

							$(".description_quantity , .description_price , #diskon ").keyup(function(e) {
								
								var total = 0;
								
								var diskon = 0;
								
								var el = document.getElementById("diskon");
								if (el !== null && el.value !== "")
								{
								  //The element was found and the value is empty.
								  diskon = $('input[name=diskon]').val();
								}								
								
								$('input[name=total]').val(total);
								
								$('.description_name').each(function() { 
									//ek.push($(this).val()); 
									console.log($(this).val());
									var price = $(this).parent().find('.description_price').val();
									var quantity = $(this).parent().find('.description_quantity').val();
									console.log(quantity);
									console.log((diskon/100));
									total += ((price * quantity) - ((price * quantity) * (diskon/100)));
								});
								
								$('input[name=total]').val(total);
							})
							
						hide_loading();
					  },
					  error : function(){

					  }
					})				  
				
			/*
				xhr = $.ajax({
				  method : "POST",
				  url : "<?= base_url().$this->uri->segment(1,0).$this->uri->slash_segment(2,'both')?>list-produk",
				  "data":{ "customer_id" : $('#customer_id').val() },
				  success: function(response){
					  
					$('.description_name').last().html(response);
					
					  $('#form-action').on('change','.description_name',function(e){
						if (e.target.value != "" ){
							
						  console.log(e.target);
						  
						  var nama_produk = $(this).find(':selected').data('nama_produk');
						  var id_produk = $(this).find(':selected').data('id');
						  var harga = $(this).find(':selected').data('harga');
						  
						  console.log(nama_produk);
						  console.log(id_produk);
						  console.log(harga);
						  
						  $(this).parent().find('.description_price').val(harga);
						  
						  
						}
					  });	

						
						

						$(".description_quantity , .description_price").keyup(function(e) {
							
							var total = 0;
							
							$('input[name=total]').val(total);
							
							$('.description_name').each(function() { 
								//ek.push($(this).val()); 
								console.log($(this).val());
								var price = $(this).parent().find('.description_price').val();
								var quantity = $(this).parent().find('.description_quantity').val();
								console.log(quantity);
								total += (price * quantity);
							});
							
							$('input[name=total]').val(total);
						})
						
					hide_loading();
				  },
				  error : function(){

				  }
				})	
			*/

				
			});		
			
			hide_loading();
		  },
		  error : function(){

		  }
		})
		
		xhr = $.ajax({
		  method : "POST",
		  url : "<?= base_url().$this->uri->segment(1,0).$this->uri->slash_segment(2,'both')?>list-drivers",
		  success: function(response){
			$('#list_drivers').html(response);	
			
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
	
  $('#form-action').on('change','#list_customers',function(e){
	  
	  show_loading();
	  
    if (e.target.value != "" ){
		
      console.log(e.target);
	  
	  var address = $(this).find(':selected').data('address');
	  var phone = $(this).find(':selected').data('phone');
	  var attn = $(this).find(':selected').data('attn');
	  
	  console.log(address);
	  console.log(phone);
	  console.log(attn);
	  
	  $('textarea[name="address"]').val(address);
	  $('input[name="phone"]').val(phone);
	  $('input[name="attn"]').val(attn);
	  
	  console.log("");	  
	  
    }
	
	hide_loading();
	
  });
  
}

function validate_form(action){
  

  $.validator.setDefaults({
    
  });
  
  $('#form-action').validate({
    rules: {
      customer_id:{required:true},
      no_surat_jalan:{required:true},
	  tanggal_surat_jalan:{required:true},
	  total:{required:true},
	  diskon:{required:true},
    },
    messages: {
      customer_id:"Harus diisi",
      no_surat_jalan:"Harus diisi",
      tanggal_surat_jalan:"Harus diisi",
	  total:"Harus diisi",
	  diskon:"Harus diisi",
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
	  
		var json_description = [];
	  
		  $('#description').find('li').each(function(){
			  
			  var current = $(this);
			  var jsonObj = {};
			  //console.log(current);
			  jsonObj.description_name = current.find(".description_name option:selected").val();	
				current.find('input[type=text]').each(function(){
					if($(this).hasClass('description_name')) {
						//alert($(this).val());
						jsonObj.description_name = $(this).val();
					}
					if($(this).hasClass('description_quantity')) {
						jsonObj.description_quantity = $(this).val();
					}
					if($(this).hasClass('description_price')) {
						jsonObj.description_price = $(this).val();
					}
				  
				});	

			json_description.push(jsonObj);
			  
		  })
		  
		  jsonStr = JSON.stringify(json_description);
		  $("input[name=items]").val(jsonStr);	  

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
	
	$('#judul-halaman').html("Pesanan dan Surat Jalan");
	
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
            {
                "class":          "details-control",
                "orderable":      false,
                "data":           null,
                "defaultContent": ""
            },
			{ "data": "no_po" },
			{ "data": "tanggal_po" },
            { "data": "no_surat_jalan" },
            { "data": "tanggal_surat_jalan" },
			{ "data": "nama_pelanggan" },	
			{ "data": "nama_driver" },				
			{ "data": "items" },
			{ "data": "total" },
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
			  
			$('#add-items').on('click',function(){
				
				$("#description ol").append("<li style='margin-bottom:10px;'> Produk: &nbsp;<select id='list_produk' class='description_name' type='text' style='width:250px;' required  /> &nbsp; Quantity: &nbsp;<input type='text' style='width:50px;' required align='center' class='allow_only_numbers description_quantity'  /> &nbsp; Harga: &nbsp;<input type='text' style='width:150px;' required class='allow_only_numbers description_price'  />&nbsp; <a href='javascript:void(0);' class='remove'>×</a></li>"); 
				$(document).on("click", "a.remove" , function() {
					$(this).parent().remove();
				});

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
				  
				  var customer_id = $("#list-customers").val();;
				  console.log("xxxxx"+$('#list_customers').val());
				  
					xhr = $.ajax({
					  method : "POST",
					  url : "<?= base_url().$this->uri->segment(1,0).$this->uri->slash_segment(2,'both')?>list-produk",
					  data : { customer_id : $('#list_customers').val() },
					  success: function(response){
						  
						  console.log(response);
						  
						$('.description_name').last().html(response);
						
						  $('#form-action').on('change','.description_name',function(e){
							if (e.target.value != "" ){
								
							  console.log(e.target);
							  
							  var nama_produk = $(this).find(':selected').data('nama_produk');
							  var id_produk = $(this).find(':selected').data('id');
							  var harga = $(this).find(':selected').data('harga');
							  
							  console.log(nama_produk);
							  console.log(id_produk);
							  console.log(harga);
							  
							  $(this).parent().find('.description_price').val(harga);
							  
							  
							}
						  });	

							$(".description_quantity , .description_price , #diskon ").keyup(function(e) {
								
								var total = 0;
								
								var diskon = 0;
								
								var el = document.getElementById("diskon");
								if (el !== null && el.value !== "")
								{
								  //The element was found and the value is empty.
								  diskon = $('input[name=diskon]').val();
								}								
								
								$('input[name=total]').val(total);
								
								$('.description_name').each(function() { 
									//ek.push($(this).val()); 
									console.log($(this).val());
									var price = $(this).parent().find('.description_price').val();
									var quantity = $(this).parent().find('.description_quantity').val();
									console.log(quantity);
									console.log((diskon/100));
									total += ((price * quantity) - ((price * quantity) * (diskon/100)));
								});
								
								$('input[name=total]').val(total);
							})
							
						hide_loading();
					  },
					  error : function(){

					  }
					})				  

				
			});
			  

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


    $('#example1 tbody').on('click','.btn-print',function(e){
      //alert(e.target.dataset.id);
		var anchor = document.createElement('a');
		anchor.href = "<?= base_url().$this->uri->segment(1,0).$this->uri->slash_segment(2,'both')?>printdata/" + e.target.dataset.id;
		anchor.target="_blank";
		anchor.click();		

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
