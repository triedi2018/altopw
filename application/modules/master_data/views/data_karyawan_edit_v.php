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
      <input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash();?>" />
      <div class="modal-body">
        <!-- form start -->
        <input type="hidden" name="id" value="<?= hash_id($data_user['nik']) ?>" />
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Nik <span class="symbol required"> </span></label>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-user"></i></span>
                    </div>
                    <input type="text" readonly value="<?= $data_user['nik'] ?>" autocomplete="off" name="nik" id="nik" required class="form-control" placeholder="Nik">
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Email <span class="symbol required"> </span></label>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                    </div>
                    <input type="email" value="<?= $data_user['email'] ?>" autocomplete="off" name="email" required class="form-control" placeholder="Email">
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label>Nama Lengkap <span class="symbol required"> </span></label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-user"></i></span>
                </div>
                <input type="text" autocomplete="off" value="<?= $data_user['nama_lengkap'] ?>" name="nama_lengkap" required class="form-control" placeholder="Nama Lengkap">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label">
                Tanggal Lahir <span class="symbol required"> </span>
              </label>
              <div class="input-group input-append datepicker date" data-date-format='dd-mm-yyyy' style="padding: 0px;" > 
                <input class="form-control" value="<?= $data_user['tgl_lahir'] ?>" type="text" readonly autocomplete="off" id="tgl_lahir" name="tgl_lahir" required />
                <div class="input-group-append">
                  <button class="btn btn-outline-secondary" type="button" ><i class="far fa-calendar-alt"></i></button>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label">
                Tanggal Masuk <span class="symbol required"> </span>
              </label>
              <div class="input-group input-append datepicker date" data-date-format='dd-mm-yyyy' style="padding: 0px;" > 
                <input class="form-control" value="<?= $data_user['tgl_masuk'] ?>" type="text" readonly autocomplete="off" name="tgl_masuk" required />
                <div class="input-group-append">
                  <button class="btn btn-outline-secondary" type="button" ><i class="far fa-calendar-alt"></i></button>
                </div>
              </div>
            </div>
            <!-- <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Password <span class="symbol required"> </span></label>
                  <input type="password"  name="password" class="form-control" id="password" placeholder="Password">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Konfirmasi Password <span class="symbol required"> </span></label>
                  <input type="password"  name="konfirmasi_password" class="form-control" id="konfirmasi_password" placeholder="Konfirmasi Password">
                </div>
              </div>
            </div> -->
            <div class="form-group">
              <label>Level User <span class="symbol required"> </span></label>
              <?php $level_user = ['admin' => 'Admin','karyawan' => 'Karyawan','hrd' => 'HRD']; ?>
              <select class="form-control" name="level_user">
                <option value="">Pilih Level User</option>
                <?php 
                foreach ($level_user as $key => $value){
                  echo "<option value='$key' ".($key == $data_user['level_user'] ? "selected" : "").">$value</option>";
                }
                ?>
              </select>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Divisi <span class="symbol required"> </span></label>
                  <select class="form-control" id="divisi" name="divisi">
                    <option value="">Pilih Divisi</option>
                    <?php
                    foreach ($list_divisi as $ls){
                      echo "<option value='$ls[nama]' ".($ls['nama'] == $data_user['divisi'] ? "selected" : "").">$ls[nama]</option>";
                    }
                    ?>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Jabatan <span class="symbol required"> </span></label>
                  <select class="form-control" id="jabatan" name="jabatan">
                    <option value="">Pilih Divisi Dulu</option>
                    <?php
                    foreach($list_jabatan as $key => $value){
                      echo "<option value='$key' ".($key == $data_user['jabatan'] ? "selected" : "").">$value</option>";
                    }
                    ?>
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Atasan 1 <span class="symbol required"> </span></label>
                  <select class="form-control" id="atasan1" name="atasan1">
                    <option value="">Pilih Atasan 1</option>
                    <?php
                    foreach ($list_atasan as $la){
                      echo "<option value='$la[nik]' ".($la['nik'] == $data_user['atasan1'] ? "selected" : "").">$la[nama_lengkap]</option>";
                    }
                    ?>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Atasan 2 <span class="symbol required"> </span></label>
                  <select class="form-control" id="atasan2" name="atasan2">
                  <option value="">Pilih Atasan 2 </option>
                  <?php
                    foreach ($list_atasan as $la){
                      echo "<option value='$la[nik]' ".($la['nik'] == $data_user['atasan2'] ? "selected" : "").">$la[nama_lengkap]</option>";
                    }
                  ?>
                    
                  </select>
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