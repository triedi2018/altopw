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
              <label>Kwitansi No <span class="symbol required"> </span></label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-file"></i></span>
                </div>
                <input type="text" autocomplete="off" name="kwitansi_no" value="<?= str_replace("PRO","KWI",$data['invoice_no']) ?>" required class="form-control" readonly placeholder="Kwitansi No">
              </div>
            </div>

            <div class="form-group">
              <label>Invoice No <span class="symbol required"> </span></label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-file"></i></span>
                </div>
                <input type="text" autocomplete="off" name="invoice_no" value="<?= $data['invoice_no'] ?>" required class="form-control" readonly placeholder="Invoice No">
              </div>
            </div>			
	
            <div class="form-group">
              <label>Nama Pelanggan <span class="symbol required"> </span></label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-file"></i></span>
                </div>
                <input type="text" autocomplete="off" name="nama_pelanggan" value="<?= $customer['nama_pelanggan'] ?>" required class="form-control" readonly placeholder="Nama Pelanggan">
              </div>
            </div>

			<div class="form-group">
			  <label>Status <span class="symbol required"> </span></label>
			  <select class="form-control" id="status" name="status">
				<option value="0" <?php if($data['status'] == '0' ) { echo "selected"; } ?> >BLM DIBAYAR</option>
				<option value="1" <?php if($data['status'] == '1' ) { echo "selected"; } ?>>LUNAS</option>
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
