
        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800"><?php echo $title; ?></h1>

          <!-- flashdata message -->
          <div class="row">
            <div class="col-lg-8">
              <?php echo $this->session->flashdata('message'); ?>
            </div>
          </div>

          <!-- Card Profile -->
          <div class="card mb-3 col-lg-8">
            <div class="row no-gutters">
              <div class="col-md-4">
                <img src="<?php echo base_url('assets/img/profile/') . $user['FOTO_PENGGUNA']; ?>" class="card-img" alt="...">
              </div>
              <div class="col-md-8">
                <div class="card-body">
                  <h5 class="card-title"><?php echo $user['NAMA_PENGGUNA']; ?></h5>
                  <p class="card-text"><?php echo $user['EMAIL_PENGGUNA']; ?></p>
                  <p class="card-text"><small class="text-muted">Terdaftar Sejak <?php echo date_indo($user['TGL_DAFTAR_PENGGUNA']); ?></small></p>
                </div>
              </div>
            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->
