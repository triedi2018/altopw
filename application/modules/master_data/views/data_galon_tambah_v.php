<div class="modal fade modal-action" id="modal-lg">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><?= ucwords($this->uri->segment(3,0))?> / Update Data</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="post" action="" role="form" id="form-action">
      <div class="modal-body">
        <!-- form start -->		
			<div class="form-group">
			  <label>Nama Pelanggan <span class="symbol required"> </span></label>
			  <select class="form-control" id="list_customers" name="customer_id">
				<option value="">Pilih Pelanggan </option>
				
			  </select>
			</div>		
			
            <div class="form-group">
              <label>Jumlah Galon <span class="symbol required"> </span></label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-file"></i></span>
                </div>
                <input type="text" autocomplete="off" name="jumlah" required class="form-control allow_only_numbers" placeholder="Jumlah Galon ">
              </div>
            </div>				

            <span class="symbol required"> Harus diisi 
          
        
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
