<link rel="stylesheet" href="<?php echo base_url(); ?>bower_components/bootstrap-daterangepicker/daterangepicker.css" />

<style>
td.details-control {
    background: url('<?= base_url() ?>assets/images/details_open.png') no-repeat center center;
    cursor: pointer;
}
tr.details td.details-control {
    background: url('<?= base_url() ?>assets/images/details_close.png') no-repeat center center;
}

  </style>
<div class="content-wrapper">
    <?php $this->load->view('templates/header-page') ?>

    <!-- Main content -->
    <section class="content">
	
<form class="form-horizontal" method="post" enctype="multipart/form-data" id="ajax_form" action="">		
	
		<div class="row">
		  <div class="col-md-6">
							
		  </div>
		  <div class="col-md-6">
			<div class="form-group">
			  <label>Range Date : </label>
			  <div class="input-group mb-3">
				<div class="input-group-prepend">
				  <span class="input-group-text"><i class="fa fa-calendar"></i></span>
				</div>
				<input type="text" class="form-control pull-right" id="reservation">
			  </div>
			</div>							
		  </div>		  
		</div>	
		
</form>	
	
      <div class="row">
        <div class="col-12">
          

          <div class="card">
            <!-- <div class="card-header">
              <h3 class="card-title">DataTable with default features</h3>
            </div> -->
            <!-- /.card-header -->
            
            <!-- /.modal -->

            
            <div class="tampil-modal"></div>
			<div class="tampil-modal2"></div>

            <div class="card-body">
              <?php if (true): ?>
              <button type="button" class="btn btn-primary mb-3 btn-print-action">
                  <span class="fa fa-print"></span> Print PDF
              </button>
              <?php endif ?>
              <div class="table-responsive">
                <table id="example1" class="table table-bordered table-sm table-hover table-striped">
                  <thead>
                  <tr>
					<th>Nama Pelanggan</th>	
                    <th>No Surat Jalan</th>
                    <th>Tgl Surat Jalan</th>                    				
					<th>Nama Barang</th>
					<th>Qty</th>
					<th>DPP</th>
					<th>PPN</th>
					<th>Total Harga</th>
                  </tr>
                  </thead>
                  <tbody>
                  
                  
                  </tbody>
                  
                </table>
              </div>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
