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
		<div class="row">
			<div class="col-lg-6 col-6">

					<div class="form-group">
					  <label>Nama Pelanggan <span class="symbol required"> </span></label>
					  <select class="form-control" id="list_customers" name="customer_id">
						<option value="">Pilih Pelanggan </option>
						
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
			
			<div class="col-lg-6 col-6">
			

					<div class="form-group">
					  <label>Invoice No <span class="symbol required"> </span></label>
					  <div class="input-group mb-3">
						<div class="input-group-prepend">
						  <span class="input-group-text"><i class="fas fa-file"></i></span>
						</div>
						<input type="text" autocomplete="off" name="invoice_no" required class="form-control" placeholder="Invoice No">
					  </div>
					</div>		

					<div class="form-group">
					  <label class="control-label">
						Tanggal Invoice <span class="symbol required"> </span>
					  </label>
					  <div class="input-group input-append datepicker date" data-date-format='dd-mm-yyyy' style="padding: 0px;" > 
						<input class="form-control" type="text" readonly autocomplete="off" name="invoice_date" required />
						<div class="input-group-append">
						  <button class="btn btn-outline-secondary" type="button" ><i class="far fa-calendar-alt"></i></button>
						</div>
					  </div>
					</div>
					
					<div class="form-group">
					  <label>Pelanggan Order No <span class="symbol required"> </span></label>
					  <div class="input-group mb-3">
						<div class="input-group-prepend">
						  <span class="input-group-text"><i class="fas fa-file"></i></span>
						</div>
						<input type="text" autocomplete="off" name="cust_order_no" required class="form-control" placeholder="Pelanggan Order No">
					  </div>
					</div>		

					<div class="form-group">
					  <label class="control-label">
						Pelanggan Order Date <span class="symbol required"> </span>
					  </label>
					  <div class="input-group input-append datepicker date" data-date-format='dd-mm-yyyy' style="padding: 0px;" > 
						<input class="form-control" type="text" readonly autocomplete="off" name="cust_order_date" required />
						<div class="input-group-append">
						  <button class="btn btn-outline-secondary" type="button" ><i class="far fa-calendar-alt"></i></button>
						</div>
					  </div>
					</div>	

					<div class="form-group">
					  <label>Payment Term <span class="symbol required"> </span></label>
					  <div class="input-group mb-3">
						<div class="input-group-prepend">
						  <span class="input-group-text"><i class="fas fa-file"></i></span>
						</div>
						<input type="text" autocomplete="off" name="payment_term" required class="form-control" placeholder="Payment Term ">
					  </div>
					</div>	

					<div class="form-group">
					  <label class="control-label">
						Due Date <span class="symbol required"> </span>
					  </label>
					  <div class="input-group input-append datepicker date" data-date-format='dd-mm-yyyy' style="padding: 0px;" > 
						<input class="form-control" type="text" readonly autocomplete="off" name="due_date" required />
						<div class="input-group-append">
						  <button class="btn btn-outline-secondary" type="button" ><i class="far fa-calendar-alt"></i></button>
						</div>
					  </div>
					</div>			
					
			
			</div>	
			
		</div>

		<div class="row">
			<div class="col-lg-12 col-12">
			
					<div class="form-group">
					  <label>Subject <span class="symbol required"> </span></label>
					  <div class="input-group mb-3">
						<div class="input-group-prepend">
						  <span class="input-group-text"><i class="fas fa-file"></i></span>
						</div>
						<textarea rows="3" name="subject" required class="form-control" placeholder="Subject"></textarea>
					  </div>
					</div>	
			
			</div>
		</div>
		
		<div class="row">
			<div class="col-lg-12 col-12">
			
					<div class="form-group">
					  <label>Faktur Number <span class="symbol required"> </span></label>
					  <div class="input-group mb-3">
						<div class="input-group-prepend">
						  <span class="input-group-text"><i class="fas fa-file"></i></span>
						</div>
						<input type="text" autocomplete="off" name="faktur_number" required class="form-control" placeholder="Faktur Number ">
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
				</ol>
			</div>
				<input type="hidden" name="items" />	  
		</div>

		<div class="row">
			<div class="col-lg-12 col-12">
			
					<div class="form-group">
					  <label>Total <span class="symbol required"> </span></label>
					  <div class="input-group mb-3">
						<div class="input-group-prepend">
						  <span class="input-group-text"><i class="fas fa-file"></i></span>
						</div>
						<input type="text" autocomplete="off" name="total" required class="form-control" placeholder="Total ">
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
