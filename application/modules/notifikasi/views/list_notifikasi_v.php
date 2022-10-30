<a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-danger navbar-badge"><?= sizeof(list_notifikasi()) ?></span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        
          <?php 
          if (sizeof(list_notifikasi()) == 0){
          ?>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <div class="media-body">
                
                <h3 class="dropdown-item-title">
                Tidak ada Notifikasi
                </h3>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <?php
          }
          foreach (list_notifikasi() as $ln) : ?>
          <a href="#" class="dropdown-item notifikasi" data-id="<?= $ln['id'] ?>" data-jenis="<?= $ln['jenis'] ?>">
            <!-- Message Start -->
            <div class="media">
              <img src="<?= base_url() ?>assets/images/profil-user/<?= $ln['foto'] ?>" alt="User Avatar" class="img-size-50 mr-3 img-circle">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  <?= $ln['jenis'] ?>
                  <!-- <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span> -->
                </h3>
                <h3 class="dropdown-item-title">
                <span class="text-sm"><i class="fas fa-user"></i></span>  <?= $ln['nama_lengkap'] ?>
                </h3>
                <p class="text-sm"><?= $ln['keterangan'] ?></p>
                <p class="float-right text-sm text-muted"><i class="far fa-clock mr-1"></i> <?= convert_date_to_id($ln['tanggal']) ?></p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <?php endforeach ?>
          
          <!-- <a href="#" class="dropdown-item dropdown-footer">See All Messages</a> -->
        </div>