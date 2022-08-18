<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1> <a href="<?= base_url('tempat_sampah') ?>">Kelola Tempat Sampah</a> > Edit</h1>
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
    <?php } ?>

    <div class="section-body">
      <form method="POST" action="<?php echo base_url() ?>tempat_sampah/update">
        <div class="row">
          <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
              <div class="card-header">
                <h4>Edit Kelola Tempat Sampah</h4>
              </div>
              <div class="card-body">

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Nama Tempat Sampah</label>
                      <input type="text" class="form-control" name="nama" value="<?= $tempat_sampah->NAMA_TEMPAT_SAMPAH ?>" required>
                      <input type="hidden" class="form-control" name="id" value="<?= $tempat_sampah->ID_TEMPAT_SAMPAH ?>" required>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Lokasi</label>
                      <textarea type="text" class="form-control" name="lokasi" required><?= $tempat_sampah->LOKASI ?></textarea>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Longitude</label>
                      <input type="text" class="form-control" name="longitude" value="<?= $tempat_sampah->LONGITUDE ?>" required>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Latitude</label>
                      <input type="text" class="form-control" name="latitude" value="<?= $tempat_sampah->LATITUDE ?>" required>
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
    </div>
  </section>

</div>