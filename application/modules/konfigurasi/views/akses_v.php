
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

            <div class="card-body">
              
              <div class="table-responsive">
                <table id="example1" class="table table-bordered table-sm table-hover table-striped">
                  <thead>
                  <tr>
                    <th>Nama Level</th>
                    <th>Aksi</th>
                    <!-- <th>Aksi</th> -->

                  </tr>
                  </thead>
                  <tbody>
                  <?php
                    foreach ($list_level_user as $lu){
                      echo "<tr>
                      
                      <td>$lu[kode_level]</td>
                      <td><a href='#'><span class='badge badge-primary btn-action' data-id='$lu[kode_level]'>Edit</span></a></td>
                      </tr>";
                    }
                  ?>
                  
                  
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