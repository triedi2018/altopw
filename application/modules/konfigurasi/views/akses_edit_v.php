<div class="modal fade modal-action" id="modal-lg">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?= ucwords($this->uri->segment(3,0))?> Data</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="<?= base_url($this->uri->segment(1,0).$this->uri->slash_segment(2,'both')) ?>simpan" role="form" id="form-action">
                <div class="modal-body">
                    <div class="table-responsive">
                        <table id="example1" class="table table-bordered table-sm table-hover table-striped">
                            <thead>
                                <tr>
                                    <!-- <th>Kode Menu</th> -->
                                    <th>Nama Menu</th>
                                    <th>Akses</th>
                                    <th>Tambah</th>
                                    <th>Edit</th>
                                    <th>Hapus</th>
                                    <!-- <th>Aksi</th> -->

                                </tr>
                            </thead>
                            <tbody>
                            <input type="hidden" name="level_user" value="<?= $this->input->post('level_user') ?>" />
                            <input type="hidden" name="id_level_user" value="<?= hash_id($this->input->post('level_user')) ?>" />
                                <?php
                                echo csrf();
                              // var_dump($list_menu);
                              function input($no,$aktif,$jenis){
                                return '<td><div class="custom-control custom-switch">
                                <input name="'.$jenis.$no.'" '.($aktif == '1' ? 'checked' : '').' type="checkbox" class="custom-control-input" 
                                id="customSwitch'.$jenis.$no.'">
                                <label class="custom-control-label" for="customSwitch'.$jenis.$no.'"></label>
                              </div></td>';
                              }
                              $no = 0;
                              foreach ($list_menu as $lm){
                                echo '<tr>';
                                // echo '<td>'.$lm['kode_menu'].'</td>';
                                echo '<td><div '.($lm['level'] == 'sub_menu' ? "style='margin-left:15px;'" : "").'>'.$lm['nama_menu'].'</div></td>';
                                echo input($no,$lm['akses'],'akses');
                                if ($lm['level'] == 'sub_menu') {
                                  echo input($no,$lm['tambah'],'tambah');
                                  echo input($no,$lm['edit'],'edit');
                                  echo input($no,$lm['hapus'],'hapus');
                                }else{
                                  echo '<td colspan="3"></td>';
                              
                                }
                                

                                echo '</tr>';
                                $no++;
                              }
                            ?>

                            </tbody>

                        </table>
                    </div>


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