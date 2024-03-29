<script src="https://cdn.datatables.net/buttons/2.1.0/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.1.0/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.1.0/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.1.0/js/buttons.colVis.min.js"></script>

<script src="<?php echo base_url(); ?>bower_components/moment/min/moment.min.js"></script>
<script src="<?php echo base_url(); ?>bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>

<script type="text/javascript">

//set default swal sweet alert..
const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
});

$('#reservation').daterangepicker(
{
	startDate : moment().startOf('years'),
	locale: {
		format: 'DD/MM/YYYY'
	}        
})

$('#reservation').on('apply.daterangepicker', function(ev, picker) {
	
	table_data.ajax.reload();

})


$('.btn-print-action').on('click',function(e){
  //alert(e.target.dataset.id);
	var anchor = document.createElement('a');
	anchor.href = "<?= base_url().$this->uri->segment(1,0).$this->uri->slash_segment(2,'both')?>printdata/" + $('#reservation').data('daterangepicker').startDate.format('YYYY-MM-DD') + "/" + $('#reservation').data('daterangepicker').endDate.format('YYYY-MM-DD') ;
	anchor.target="_blank";
	anchor.click();		

})


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
			
			$('#add-items').on('click',function(){
				
				$("#description ol").append("<li style='margin-bottom:10px;'> No Surat Jalan: &nbsp;<select id='list_surat_jalan' class='description_no_surat_jalan' type='text' style='width:250px;' required  /> &nbsp; Tgl : &nbsp;<input type='text' style='width:150px;' required align='center' class='description_tanggal_surat_jalan'  /> &nbsp; <a href='javascript:void(0);' class='remove'>×</a></li>"); 
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
				  
				xhr = $.ajax({
				  method : "POST",
				  url : "<?= base_url().$this->uri->segment(1,0).$this->uri->slash_segment(2,'both')?>list-surat-jalan",
				  data:"customer_id=" + $('#list_customers').val(),
				  success: function(response){
					  
					$('.description_no_surat_jalan').last().html(response);
					
					  $('#form-action').on('change','.description_no_surat_jalan',function(e){
						if (e.target.value != "" ){
							
						  console.log(e.target);
						  
						  var tanggal_surat_jalan = $(this).find(':selected').data('tanggal_surat_jalan');
						  console.log(tanggal_surat_jalan);
						  
						  $(this).parent().find('.description_tanggal_surat_jalan').val(tanggal_surat_jalan);
						  
						  
						}
					  });	

						
						

						$(".description_quantity").keyup(function(e) {
							
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

				
			});		
			
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
      invoice_no:{required:true},
	  invoice_date:{required:true},
    },
    messages: {
      customer_id:"Harus diisi",
      invoice_no:"Harus diisi",
      invoice_date:"Harus diisi",
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
			  jsonObj.no_surat_jalan = current.find(".description_no_surat_jalan option:selected").val();	

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
    table_data = $('#example1').DataTable({

		/*
		dom: 'Bfrtip',
		
		buttons: [ 
		{
			extend: 'excelHtml5',
			filename: "File Name You want",
			title: "some title or heading for excel",
			text: 'Export'  //By default it is excel. if you want to change it set "text" value.
		},
		{
                extend: 'excel',
                //orientation: 'landscape',
                //pageSize: 'LEGAL',
                exportOptions: {
                    //columns: ':visible'
					columns: [ 0, 1, 2, 3, 4, 5, 6, 7 ],
					stripHtml: false,
                },
		action: newexportaction_all				
            },            {
                extend: 'pdfHtml5',
                //orientation: 'landscape',
                pageSize: 'LEGAL',
                exportOptions: {
                    //columns: ':visible'
					columns: [ 0, 1, 2, 3, 4, 5, 6, 7 ],
					stripHtml: false,
                },
		action: newexportaction_all				
            } ],
		*/	
			
       drawCallback: function (settings) {
            var api = this.api();
            var rows = api.rows( {page:'current'} ).nodes();
			var entirerows_count = rows.length;
			
			let b1 = null;
			let first_row = true;
			var total = 0;
 
            api.column(0, {page:'current'} ).data().each( function ( name, i ) {	// 0 =  first column
                let row = $(rows).eq( i );
				
				let v = api.cell(i,7).node().innerHTML.replace(/[^0-9]+/g, "");
				
				//$.each($(row),function(key,value){
					//console.log(key);
					//dataArr.push(value["name"]); //"name" being the value of your first column.
				//});				
                let temp = row.find('td:eq(0)').text();	
				
				
				var temp_total = api.cell(i,7).node().innerHTML.replace(/[^0-9]+/g, "");
				
				api.cell(i,7).node().innerHTML = "Rp " + numberWithDot(temp_total)
				//console.log(temp_total);
				
				if(b1 != temp) {
					console.log(temp_total);
					
                    //b2 = row.find('td:eq(3)').text(),
                    //b3 = row.find('td:eq(4)').text();
					if(first_row) {
                      row.before(
                          '<tr role="row" class="'+name+' name"><th colspan="8" >'+name+'</td></tr>');		
					  first_row = false;
					  total = parseInt(temp_total);
						
					}
					else
					{
						  row.before(
							  '<tr role="row" class="'+name+' total"><th>Total :</td><th colspan="7" >Rp '+numberWithDot(total)+'</td></tr>');							
						  row.before(
							  '<tr role="row" class="'+name+' total"><th colspan="8" >'+name+'</td></tr>');	

						total = parseInt(temp_total);
						
					}
					
	
						  
					b1 = temp;
				}
				else
				{
					total += parseInt(temp_total);
					//console.log("yyy "+total);
					//console.log("xxx "+temp_total);
					
				}
				
				
				let b1TRow = row.find('td:eq(0)');
				b1TRow.text('');
				
				if((entirerows_count-1)==i) {
						  row.after(
							  '<tr role="row" class="'+name+' total"><th>Total :</td><th colspan="20" >Rp '+numberWithDot(total)+'</td></tr>');						
					
				}
				
				//console.log(b1);
				
            }) ;
        },			

        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.

        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?= base_url().$this->uri->segment(1,0).$this->uri->slash_segment(2,'leading')."/tampildata"; ?>",
            "type": "POST",
            "data":{'<?= $this->security->get_csrf_token_name() ?>':'<?= $this->security->get_csrf_hash() ?>',
				  startdate: function() { return $('#reservation').data('daterangepicker').startDate.format('YYYY-MM-DD') },
				  enddate: function() { return $('#reservation').data('daterangepicker').endDate.format('YYYY-MM-DD') },			
			},
            
        },

        //Set column definition initialisation properties.
        // "columnDefs": [
        // { 
        //     "targets": [ 5 ], //last column
        //     "orderable": false, //set not orderable
        // }
        // ],
        

        "columns": [
			{ "data": "nama_pelanggan" },
            { "data": "no_surat_jalan" },
            { "data": "tanggal_surat_jalan" },						
			{ "data": "nama_produk" },
			{ "data": "description_quantity" },
			{ "data": "description_price" },
			{ "data": "ppn" },
			{ "data": "total" },
			//{ "data": "total" },
        ],
		
		"lengthMenu": [[-1], ["All"]]

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

function newexportaction_all(e, dt, button, config) {
    var self = this;
    var oldStart = dt.settings()[0]._iDisplayStart;
    dt.one('preXhr', function (e, s, data) {
        // Just this once, load all data from the server...
        data.start = 0;
        data.length = 2147483647;
        dt.one('preDraw', function (e, settings) {
            // Call the original action function
            if (button[0].className.indexOf('buttons-copy') >= 0) {
                $.fn.dataTable.ext.buttons.copyHtml5.action.call(self, e, dt, button, config);
            } else if (button[0].className.indexOf('buttons-excel') >= 0) {
                $.fn.dataTable.ext.buttons.excelHtml5.available(dt, config) ?
                    $.fn.dataTable.ext.buttons.excelHtml5.action.call(self, e, dt, button, config) :
                    $.fn.dataTable.ext.buttons.excelFlash.action.call(self, e, dt, button, config);
            } else if (button[0].className.indexOf('buttons-csv') >= 0) {
                $.fn.dataTable.ext.buttons.csvHtml5.available(dt, config) ?
                    $.fn.dataTable.ext.buttons.csvHtml5.action.call(self, e, dt, button, config) :
                    $.fn.dataTable.ext.buttons.csvFlash.action.call(self, e, dt, button, config);
            } else if (button[0].className.indexOf('buttons-pdf') >= 0) {
                $.fn.dataTable.ext.buttons.pdfHtml5.available(dt, config) ?
                    $.fn.dataTable.ext.buttons.pdfHtml5.action.call(self, e, dt, button, config) :
                    $.fn.dataTable.ext.buttons.pdfFlash.action.call(self, e, dt, button, config);
            } else if (button[0].className.indexOf('buttons-print') >= 0) {
                $.fn.dataTable.ext.buttons.print.action(e, dt, button, config);
            }
            dt.one('preXhr', function (e, s, data) {
                // DataTables thinks the first item displayed is index 0, but we're not drawing that.
                // Set the property to what it was before exporting.
                settings._iDisplayStart = oldStart;
                data.start = oldStart;
            });
            // Reload the grid with the original page. Otherwise, API functions like table.cell(this) don't work properly.
            setTimeout(dt.ajax.reload, 0);
            // Prevent rendering of the full data to the DOM
            return false;
        });
    });
    // Requery the server with the new one-time export settings
    dt.ajax.reload();
};


function numberWithDot(x) {
    return x.toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, ".");
}

</script>
