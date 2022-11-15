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
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-file"></i></span>
                </div>
                <input type="text" autocomplete="off" name="nama_pelanggan" value="<?= $data['nama_pelanggan'] ?>" required class="form-control" placeholder="Nama Pelanggan">
              </div>
            </div>	

			<div class="form-group">
			  <label>Status <span class="symbol required"> </span></label>
			  <select class="form-control" id="status_pelanggan" name="status_pelanggan">
				<option value="Distributor" <?php if($data['status_pelanggan'] == 'Distributor' ) { echo "selected"; } ?> >Distributor</option>
				<option value="Agen" <?php if($data['status_pelanggan'] == 'Agen' ) { echo "selected"; } ?>>Agen</option>
				<option value="Perusahaan" <?php if($data['status_pelanggan'] == 'Perusahaan' ) { echo "selected"; } ?>>Perusahaan</option>
				<option value="Downline Agen" <?php if($data['status_pelanggan'] == 'Downline Agen' ) { echo "selected"; } ?>>Downline Agen</option>
				<option value="Perorangan" <?php if($data['status_pelanggan'] == 'Perorangan' ) { echo "selected"; } ?>>Perorangan</option>
			  </select>
			</div>
			
			<?php if($data['status_pelanggan'] == 'Downline Agen' ) {  ?>
			
			<div class="form-group" id="list_agen_container" style="display:block;">
			  <label>Agen </label>
			  <select class="form-control" id="list_agen" name="agen_id">
				<?php 
					//$CI = & get_instance();
					$this->CI->list_agen_selected($data['agen_id']);
					/*
					if ($data){
						echo "<option value=''>Pilih Agen</option>";
						foreach($data as $customer){
							echo "<option data-address='$customer[alamat]' data-phone='$customer[phone]' data-attn='$customer[contact_person]' value='$customer[id]'>$customer[nama_pelanggan]</option>";
						}
					}				
					*/
				?>
			  </select>
			</div>	

			<?php } else {  ?>
			
			<div class="form-group" id="list_agen_container" style="display:none;">
			  <label>Agen </label>
			  <select class="form-control" id="list_agen" name="agen_id">
				<option value="">Pilih Agen </option>
				
			  </select>
			</div>			
			
			<?php }  ?>

            <div class="form-group">
              <label>Referensi <span class="symbol required"> </span></label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-file"></i></span>
                </div>
                <input type="text" autocomplete="off" name="referensi" value="<?= $data['referensi'] ?>" required class="form-control" placeholder="Referensi">
              </div>
            </div>

			<div class="form-group">
			  <label>Status Referensi<span class="symbol required"> </span></label>
			  <select class="form-control" id="status_ref" name="status_ref">
				<option value="Distributor" <?php if($data['status_ref'] == 'Distributor' ) { echo "selected"; } ?> >Distributor</option>
				<option value="Agen" <?php if($data['status_ref'] == 'Agen' ) { echo "selected"; } ?> >Agen</option>
				<option value="Mediator" <?php if($data['status_ref'] == 'Mediator' ) { echo "selected"; } ?> >Mediator</option>
				<option value="Lain-Lain" <?php if($data['status_ref'] == 'Lain-Lain' ) { echo "selected"; } ?> >Lain-Lain</option>
			  </select>
			</div>

            <div class="form-group">
              <label>No NPWP <span class="symbol required"> </span></label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-file"></i></span>
                </div>
                <input type="text" autocomplete="off" name="no_npwp" value="<?= $data['no_npwp'] ?>" required class="form-control" placeholder="No NPWP">
              </div>
            </div>

			<div class="form-group">
			  <label>Faktur Pajak<span class="symbol required"> </span></label>
			  <select class="form-control" id="faktur_pajak" name="faktur_pajak">
				<option value="Copy NPWP" <?php if($data['faktur_pajak'] == 'Copy NPWP' ) { echo "selected"; } ?> >Copy NPWP</option>
				<option value="Tagih Gabungan" <?php if($data['faktur_pajak'] == 'Tagih Gabungan' ) { echo "selected"; } ?> >Tagih Gabungan</option>
			  </select>
			</div>			

            <div class="form-group">
              <label>Alamat Rumah/Kantor<span class="symbol required"> </span></label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-file"></i></span>
                </div>
                <textarea rows="3" name="alamat" required class="form-control" placeholder="Alamat"><?= $data['alamat'] ?></textarea>
              </div>
            </div>
		
            <div class="form-group">
              <label>Contact Person <span class="symbol required"> </span></label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-file"></i></span>
                </div>
                <input type="text" autocomplete="off" name="contact_person" value="<?= $data['contact_person'] ?>" required class="form-control" placeholder="Contact Person">
              </div>
            </div>	

            <div class="form-group">
              <label>No Telp/HP <span class="symbol required"> </span></label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-file"></i></span>
                </div>
                <input type="text" autocomplete="off" name="phone" value="<?= $data['phone'] ?>" required class="form-control" placeholder="No Telp/HP">
              </div>
            </div>	

            <div class="form-group">
              <label>Email <span class="symbol required"> </span></label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-file"></i></span>
                </div>
                <input type="text" autocomplete="off" name="email" value="<?= $data['email'] ?>" required class="form-control" placeholder="Email">
              </div>
            </div>
			
            <div class="form-group">
              <label>Alamat Pengiriman <span class="symbol required"> </span></label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-file"></i></span>
                </div>
                <textarea rows="3" name="alamat_pengiriman" required class="form-control" placeholder="Alamat Pengiriman "><?= $data['alamat_pengiriman'] ?></textarea>
              </div>
            </div>			

            <div class="form-group">
              <label>Kode Pos <span class="symbol required"> </span></label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-file"></i></span>
                </div>
                <input type="text" autocomplete="off" name="kode_pos" value="<?= $data['kode_pos'] ?>" required class="form-control" placeholder="Kode Pos">
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
