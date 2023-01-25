<div class="modal fade modal-action" id="modal-lg">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><?= ucwords($this->uri->segment(3,0))?> Data</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="post" action="" role="form" id="form-action">
      <div class="modal-body">
        <!-- form start -->
		<input type="hidden" name="id" value="<?= md5($data['id']) ?>" />
	
 		<div class="row">
			<div class="col-lg-12 col-12">
			
					<div class="form-group">
					  <label>No PO <span class="symbol required"> </span></label>
					  <div class="input-group mb-3">
						<div class="input-group-prepend">
						  <span class="input-group-text"><i class="fas fa-file"></i></span>
						</div>
						<input type="text" autocomplete="off" name="no_po" required class="form-control" value="<?= $data['no_po'] ?>" placeholder="No PO ">
					  </div>
					</div>		

					<div class="form-group">
					  <label class="control-label">
						Tanggal PO <span class="symbol required"> </span>
					  </label>
					  <div class="input-group input-append datepicker date" data-date-format='dd-mm-yyyy' style="padding: 0px;" > 
						<input class="form-control" type="text" readonly autocomplete="off" name="tanggal_po" value="<?= date("d-m-Y", strtotime($data['tanggal_po'])) ?>" required />
						<div class="input-group-append">
						  <button class="btn btn-outline-secondary" type="button" ><i class="far fa-calendar-alt"></i></button>
						</div>
					  </div>
					</div>			
			
					<div class="form-group">
					  <label>No Surat Jalan <span class="symbol required"> </span></label>
					  <div class="input-group mb-3">
						<div class="input-group-prepend">
						  <span class="input-group-text"><i class="fas fa-file"></i></span>
						</div>
						<input type="text" autocomplete="off" name="no_surat_jalan" required class="form-control" value="<?= $data['no_surat_jalan'] ?>" placeholder="No Surat Jalan">
					  </div>
					</div>		

					<div class="form-group">
					  <label class="control-label">
						Tanggal Kirim <span class="symbol required"> </span>
					  </label>
					  <div class="input-group input-append datepicker date" data-date-format='dd-mm-yyyy' style="padding: 0px;" > 
						<input class="form-control" type="text" readonly autocomplete="off" name="tanggal_surat_jalan" value="<?= date("d-m-Y", strtotime($data['tanggal_surat_jalan'])) ?>" required />
						<div class="input-group-append">
						  <button class="btn btn-outline-secondary" type="button" ><i class="far fa-calendar-alt"></i></button>
						</div>
					  </div>
					</div>

					<div class="form-group">
					  <label>Nama Pelanggan <span class="symbol required"> </span></label>
					  <select class="form-control" id="list_customers" name="customer_id">
						<?php
						
							$data0 = $this->Data_model->list_customers();
							if ($data0){
								echo "<option value=''>Pilih Pelanggan</option>";
								foreach($data0 as $customer){
									if($customer['id'] == $data['customer_id']) {
										//echo "<option data-address='$customer[address]' data-phone='$customer[phone]' data-attn='$customer[attn]' value='$customer[id]' selected >$customer[name]</option>";
										echo "<option data-address='$customer[alamat]' data-phone='$customer[phone]' data-attn='$customer[contact_person]' value='$customer[id]' selected  >$customer[nama_pelanggan]</option>";
										
									}
									else
									{
										//echo "<option data-address='$customer[address]' data-phone='$customer[phone]' data-attn='$customer[attn]' value='$customer[id]'>$customer[name]</option>";
										echo "<option data-address='$customer[alamat]' data-phone='$customer[phone]' data-attn='$customer[contact_person]' value='$customer[id]'>$customer[nama_pelanggan]</option>";
									}
								}
							}
							echo "<script>
							  $('#form-action').on('change','#list_customers',function(e){
								  									
								  console.log(e.target);
								  
								  var address = $(this).find(':selected').data('address');
								  var phone = $(this).find(':selected').data('phone');
								  var attn = $(this).find(':selected').data('attn');
								  
								  console.log(address);
								  console.log(phone);
								  console.log(attn);
								  
								  $('textarea[name=\"address\"]').val(address);
								  $('input[name=\"phone\"]').val(phone);
								  $('input[name=\"attn\"]').val(attn);
								
							  });							
							
							$(\"#list_customers\").change();</script>";
						
						?>				
						
					  </select>
					</div>

					<div class="form-group">
					  <label>Nama Driver <span class="symbol required"> </span></label>
					  <select class="form-control" id="list_drivers" name="driver_id">
						<?php						
							$data0 = $this->Data_model->list_drivers();
							if ($data0){
								echo "<option value=''>Pilih Driver</option>";
								foreach($data0 as $driver){
									if($driver['id'] == $data['driver_id']) {
										echo "<option data-address='$driver[alamat]' data-phone='$driver[phone]' data-attn='$driver[kode]' value='$driver[id]' selected >$driver[nama_driver]</option>";
										
									}
									else
									{
										echo "<option data-address='$driver[alamat]' data-phone='$driver[phone]' data-attn='$driver[kode]' value='$driver[id]'>$driver[nama_driver]</option>";
									}
								}
							}
						
						?>				
						
					  </select>
					</div>					

					<div class="form-group">
					  <label>Alamat </label>
					  <div class="input-group mb-3">
						<div class="input-group-prepend">
						  <span class="input-group-text"><i class="fas fa-file"></i></span>
						</div>
						<textarea rows="3" name="address" disabled class="form-control" placeholder="Alamat"></textarea>
					  </div>
					</div>
					
					<div class="form-group">
					  <label>No Telp/HP </label>
					  <div class="input-group mb-3">
						<div class="input-group-prepend">
						  <span class="input-group-text"><i class="fas fa-file"></i></span>
						</div>
						<input type="text" autocomplete="off" name="phone" disabled class="form-control" placeholder="No Telp/HP">
					  </div>
					</div>	

					<div class="form-group">
					  <label>Contact Person </label>
					  <div class="input-group mb-3">
						<div class="input-group-prepend">
						  <span class="input-group-text"><i class="fas fa-file"></i></span>
						</div>
						<input type="text" autocomplete="off" name="attn" disabled class="form-control" placeholder="Attn">
					  </div>
					</div>	
			
			</div>
			
			
		</div>		
		
		<div class="row" style="display:block;">
					  <button id="add-items" type="button" class="btn btn-primary mb-3 btn-action-items">
						  <span class="fa fa-plus"></span> Tambah Produk
					  </button>
					  
			<div id="description">
				<ol>
					<?= $data['items'] ?>
				</ol>
			</div>
				<input type="hidden" name="items" />	  
		</div>
		
		<div class="row" style="display:none;">
			<div class="col-lg-12 col-12">
			
					<div class="form-group">
					  <label>Diskon (%)<span class="symbol required"> </span></label>
					  <div class="input-group mb-3">
						<div class="input-group-prepend">
						  <span class="input-group-text"><i class="fas fa-file"></i></span>
						</div>
						<input type="text" autocomplete="off" id="diskon" name="diskon" value="<?= $data['diskon'] ?>" required class="form-control allow_only_numbers" placeholder="Diskon (%)" value="0" >
					  </div>
					</div>	
			
			</div>
		</div>

		<div class="row">
			<div class="col-lg-12 col-12">
			
					<div class="form-group">
					  <label>Total <span class="symbol required"> </span></label>
					  <div class="input-group mb-3">
						<div class="input-group-prepend">
						  <span class="input-group-text"><i class="fas fa-file"></i></span>
						</div>
						<input type="text" autocomplete="off" name="total" value="<?= $data['total'] ?>" required class="form-control allow_only_numbers" placeholder="Total ">
					  </div>
					</div>	
			
			</div>
		</div>		

		<div class="row">
			<div class="col-lg-12 col-12">
				<ol>
				</ol>			  
			</div>
		</div>				

            <span class="symbol required"> Harus diisi 
            <!-- <div class="form-group mb-0">
              <div class="custom-control custom-checkbox">
                <input type="checkbox" name="terms" class="custom-control-input" id="exampleCheck1">
                <label class="custom-control-label" for="exampleCheck1">I agree to the <a href="#">terms of service</a>. <span class="symbol required"> </label>
              </div>
            </div> -->
          <!-- /.card-body -->
          
        
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
        <button type="submit" id="simpan" class="btn btn-primary">Simpan</button>
      </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
