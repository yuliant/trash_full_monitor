<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Kelola Tempat Sampah</h1>
      <div class="section-header-breadcrumb">

      </div>
    </div>
    <?php
    if ($this->session->flashdata('notif') == '1') { ?>
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
      <form method="POST" action="<?php echo base_url() ?>tempat_sampah/simpan">
        <div class="row">
          <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
              <div class="card-header">
                <h4>Form Kelola Tempat Sampah</h4>
              </div>
              <div class="card-body">

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Nama Tempat Sampah</label>
                      <input type="text" class="form-control" name="nama" required>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Lokasi</label>
                      <textarea type="text" class="form-control" name="lokasi" required></textarea>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Longitude</label>
                      <input type="text" class="form-control" name="longitude" required>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Latitude</label>
                      <input type="text" class="form-control" name="latitude" required>
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
    </div>
    <div class="section-body">
      <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
          <div class="card">
            <div class="card-header">
              <h4>Data Tempat Sampah</h4>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-striped" id="table-1" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>No.</th>
                      <th>Nama</th>
                      <th>Longitude</th>
                      <th>Latitude</th>
                      <th>Lokasi</th>
                      <th>Volume(%)</th>
                      <th>Keadaan</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $i = 1;
                    $tempat_sampah = $this->db->query('SELECT * from tempat_sampah ORDER BY ID_TEMPAT_SAMPAH DESC')->result();
                    foreach ($tempat_sampah as $ts) : ?>
                      <tr>
                        <td><?php echo $i ?></td>
                        <td><?php echo $ts->NAMA_TEMPAT_SAMPAH ?></td>
                        <td><?php echo $ts->LONGITUDE ?></td>
                        <td><?php echo $ts->LATITUDE ?></td>
                        <td><?php echo $ts->LOKASI ?></td>
                        <td><?php echo $ts->BERAT ?></td>
                        <td><?php echo $ts->STATUS_JEMPUT == 0 ? 'Aman' : 'Siap Dikosongkan'  ?></td>
                        <td>
                          <a class="badge badge-info" href="<?php echo base_url(); ?>tempat_sampah/gps/<?php echo $ts->ID_TEMPAT_SAMPAH ?>">GPS</a>
                          <a class="badge badge-warning" href="<?php echo base_url(); ?>tempat_sampah/edit/<?php echo $ts->ID_TEMPAT_SAMPAH ?>">Edit</a>
                          <a class="badge badge-danger" href="<?php echo base_url(); ?>tempat_sampah/hapus/<?php echo $ts->ID_TEMPAT_SAMPAH ?>" onclick="return confirm('Apakah anda yakin ingin menghapus data ini?');">Hapus</a>
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