
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
              <?php if ($cek_akses['tambah'] == 1): ?>
              <button type="button" class="btn btn-primary mb-3 btn-action">
                  <span class="fa fa-plus"></span> Tambah Pesanan
              </button>
              <?php endif ?>
              <div class="table-responsive">
                <table id="example1" class="table table-bordered table-sm table-hover table-striped">
                  <thead>
                  <tr>
                    <th></th>
                    <th>No PO</th>
                    <th>Tgl PO</th>					
                    <th>No Surat Jalan</th>
                    <th>Tgl Surat Jalan</th>
					<th>Kode Pelanggan</th>
                    <th>Pelanggan</th>
					<th>Driver</th>
					<th>Keterangan</th>
					<th>Total</th>
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
