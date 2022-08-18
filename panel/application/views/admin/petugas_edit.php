<div class="main-content">
  <section class="section">

    <div class="section-header">
      <h1> <a href="<?= base_url('petugas') ?>">Kelola Petugas Sampah</a> > Edit</h1>
      <div class="section-header-breadcrumb">
      </div>
    </div>

    <?php if ($this->session->flashdata('notif') == '1') { ?>
      <div class="alert alert-success">
        <div class="alert-title">Sukses</div>
        Berhasil input data petugas sampah.
      </div>

    <?php } elseif ($this->session->flashdata('notif') == '2') { ?>
      <div class="alert alert-danger">
        <div class="alert-title">Gagal</div>
        Gagal input data petugas sampah.
      </div>
    <?php }
    ?>

    <div class="section-body">
      <form method="POST" action="<?php echo base_url() ?>petugas/update">
        <div class="row">
          <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
              <div class="card-header">
                <h4>Edit Data Petugas Sampah</h4>
              </div>

              <div class="card-body">

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Nama</label>
                      <input type="text" class="form-control" name="nama" value="<?= $pengguna->NAMA_PENGGUNA ?>" required>
                      <input type="hidden" class="form-control" name="id_petugas" value="<?= $pengguna->ID_PENGGUNA ?>" required>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label>No HP</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <div class="input-group-text">
                            <i class="fas fa-phone"></i>
                          </div>
                        </div>
                        <input type="text" class="form-control phone-number" name="nohp" value="<?= $pengguna->NOHP_PENGGUNA ?>" required>
                      </div>
                    </div>
                  </div>

                </div>

                <div class="row">

                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Email (tidak bisa diubah)</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <div class="input-group-text">
                            <i class="fas fa-envelope"></i>
                          </div>
                        </div>
                        <input type="text" class="form-control phone-number" value="<?= $pengguna->EMAIL_PENGGUNA ?>" readonly>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Password Strength (kosongkan jika tidak ingin mengubah)</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <div class="input-group-text">
                            <i class="fas fa-lock"></i>
                          </div>
                        </div>
                        <input type="password" class="form-control pwstrength" data-indicator="pwindicator" name="password">
                      </div>
                      <div id="pwindicator" class="pwindicator">
                        <div class="bar"></div>
                        <div class="label"></div>
                      </div>
                    </div>
                  </div>

                </div>

                <div class="row">
                  <div class="col-md-6">
                    <button type="submit" class="btn btn-md btn-warning">Update</button>
                  </div>
                </div>

              </div>
            </div>
          </div>
        </div>
      </form>

  </section>

</div>