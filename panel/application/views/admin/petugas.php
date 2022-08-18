<div class="main-content">
  <section class="section">

    <div class="section-header">
      <h1>Kelola Petugas Sampah</h1>
      <div class="section-header-breadcrumb">
      </div>
    </div>

    <?php if ($this->session->flashdata('notif') == '1') { ?>
      <div class="alert alert-success">
        <div class="alert-title">Sukses</div>
      </div>

    <?php } elseif ($this->session->flashdata('notif') == '2') { ?>
      <div class="alert alert-danger">
        <div class="alert-title">Gagal</div>
      </div>
    <?php }
    ?>

    <div class="section-body">
      <form method="POST" action="<?php echo base_url() ?>petugas/simpan">
        <div class="row">
          <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
              <div class="card-header">
                <h4>Form Kelola Petugas Sampah</h4>
              </div>

              <div class="card-body">

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Nama</label>
                      <input type="text" class="form-control" name="nama" required>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Email</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <div class="input-group-text">
                            <i class="fas fa-envelope"></i>
                          </div>
                        </div>
                        <input type="text" class="form-control phone-number" name="email" required>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Password Strength</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <div class="input-group-text">
                            <i class="fas fa-lock"></i>
                          </div>
                        </div>
                        <input type="password" class="form-control pwstrength" data-indicator="pwindicator" name="password" required>
                      </div>
                      <div id="pwindicator" class="pwindicator">
                        <div class="bar"></div>
                        <div class="label"></div>
                      </div>
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
                        <input type="text" class="form-control phone-number" name="nohp" required>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <button type="submit" class="btn btn-md btn-success">Simpan</button>
                  </div>
                </div>

              </div>
            </div>
          </div>
        </div>
      </form>

      <div class="section-body">
        <div class="row">
          <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
              <div class="card-header">
                <h4>Data Petugas Sampah</h4>
              </div>
              <div class="card-body">
                <div class="table-responsive">

                  <table class="table table-striped" id="table-1" width="100%" cellspacing="0">
                    <thead>
                      <tr>
                        <th>No.</th>
                        <th>Nama Pengguna</th>
                        <th>Email Pengguna</th>
                        <th>No HP Pengguna</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $i = 1;
                      $petugas = $this->db->query('SELECT * from pengguna WHERE JABATAN_PENGGUNA = "Petugas" ORDER BY ID_PENGGUNA DESC')->result();
                      foreach ($petugas as $p) : ?>
                        <tr>
                          <td><?php echo $i ?></td>
                          <td><?php echo $p->NAMA_PENGGUNA ?></td>
                          <td><?php echo $p->EMAIL_PENGGUNA ?></td>
                          <td><?php echo $p->NOHP_PENGGUNA ?></td>
                          <td>
                            <a class="badge badge-warning" href="<?php echo base_url(); ?>petugas/edit/<?php echo $p->ID_PENGGUNA ?>">Edit</a>
                            <a class="badge badge-danger" href="<?php echo base_url(); ?>petugas/hapus/<?php echo $p->ID_PENGGUNA ?>" onclick="return confirm('Apakah anda yakin ingin menghapus data ini?');">Hapus</a>
                          </td>
                        </tr>
                      <?php
                        $i++;
                      endforeach; ?>
                    </tbody>
                  </table>

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
  </section>

</div>