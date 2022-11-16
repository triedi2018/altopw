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
		
			<div class="form-group">
			  <label>Nama Pelanggan <span class="symbol required"> </span></label>
			  <select class="form-control" id="list_customers" name="customer_id">
				<?php
				
					$data0 = $this->Data_model->list_customers();
					if ($data0){
						echo "<option value=''>Pilih Pelanggan</option>";
						foreach($data0 as $customer){
							if($customer['id'] == $data['customer_id']) {
								echo "<option data-address='$customer[alamat]' data-phone='$customer[phone]' data-attn='$customer[contact_person]' value='$customer[id]' selected >$customer[nama_pelanggan]</option>";
							}
							else
							{
								echo "<option data-address='$customer[alamat]' data-phone='$customer[phone]' data-attn='$customer[contact_person]' value='$customer[id]'>$customer[nama_pelanggan]</option>";
							}
						}
					}				
				
				?>				
				
			  </select>
			</div>		

            <div class="form-group">
              <label>Nama Produk <span class="symbol required"> </span></label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-file"></i></span>
                </div>
                <input type="text" autocomplete="off" name="nama_produk" value="<?= $data['nama_produk'] ?>" required class="form-control" placeholder="Nama Produk">
              </div>
            </div>	
			
            <div class="form-group">
              <label>Harga <span class="symbol required"> </span></label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-file"></i></span>
                </div>
                <input type="text" autocomplete="off" name="harga" value="<?= $data['harga'] ?>" required class="form-control" placeholder="Harga">
              </div>
            </div>				

			<div class="form-group">
			  <label>Satuan <span class="symbol required"> </span></label>
			  <select class="form-control" id="satuan" name="satuan">
				<option value="Unit" <?php if($data['satuan'] == 'Unit' ) { echo "selected"; } ?> >Unit</option>
				<option value="Galon" <?php if($data['satuan'] == 'Galon' ) { echo "selected"; } ?> >Galon</option>
				<option value="Dus" <?php if($data['satuan'] == 'Dus' ) { echo "selected"; } ?> >Dus</option>
			  </select>
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
