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
			  <label>Nama Produk <span class="symbol required"> </span></label>
			  <select class="form-control" id="list_produk" name="id_produk" readonly >
				<?php
				
					$data0 = $this->Data_model->list_produk();
					if ($data0){
						echo "<option value=''>Pilih Produk</option>";
						foreach($data0 as $produk){
							if($produk['id'] == $data['id_produk']) {
								echo "<option data-nama_produk='$produk[nama_produk]' data-harga='$produk[harga]' data-satuan='$produk[satuan]' value='$produk[id]' selected >$produk[nama_produk]</option>";
							}
							else
							{
								echo "<option data-nama_produk='$produk[nama_produk]' data-harga='$produk[harga]' data-satuan='$produk[satuan]' value='$produk[id]'>$produk[nama_produk]</option>";
							}
						}
					}				
				
				?>	
				
			  </select>
			</div>		
			
            <div class="form-group">
              <label>Jumlah <span class="symbol required"> </span></label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-file"></i></span>
                </div>
                <input type="text" autocomplete="off" name="jumlah" value="<?= $data['jumlah'] ?>" required class="form-control allow_only_numbers" placeholder="Jumlah">
              </div>
            </div>				

			<div class="form-group">
			  <label class="control-label">
				Tanggal Masuk <span class="symbol required"> </span>
			  </label>
			  <div class="input-group input-append datepicker date" data-date-format='dd-mm-yyyy' style="padding: 0px;" > 
				<input class="form-control" type="text" readonly autocomplete="off" name="tanggal_masuk" value="<?= date("d-m-Y", strtotime($data['tanggal_masuk'])) ?>" required />
				<div class="input-group-append">
				  <button class="btn btn-outline-secondary" type="button" ><i class="far fa-calendar-alt"></i></button>
				</div>
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
