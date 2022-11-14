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
	
		<div class="row">
		  <div class="col-md-6">
			<div class="form-group" style="display:none;" >
			  <label>View Transaksi</label>
			  <select class="form-control" id="view" name="view">
				<option value="all">All Data </option>
				<option value="DEBIT">Debit </option>
				<option value="KREDIT">Kredit </option>
			  </select>
			</div>								
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
	
      <div class="row">
        <div class="col-12">
          

          <div class="card">
            <!-- <div class="card-header">
              <h3 class="card-title">DataTable with default features</h3>
            </div> -->
            <!-- /.card-header -->
            
            <!-- /.modal -->

            
            <div class="tampil-modal"></div>

            <div class="card-body">
              <?php if ($cek_akses['tambah'] == 1): ?>
              <button type="button" class="btn btn-primary mb-3 btn-action">
                  <span class="fa fa-plus"></span> Tambah Data
              </button>
              <?php endif ?>
              <div class="table-responsive">
                <table id="example1" class="table table-bordered table-sm table-hover table-striped">
                  <thead>
                  <tr>
                    <th></th>
                    <th>Tanggal</th>
					<th>Keterangan</th>
					<th>Debit</th>
					<th>Kredit</th>
					<th>Saldo</th>
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
