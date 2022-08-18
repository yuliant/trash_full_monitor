<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1> <a href="<?= base_url('mobil_sampah') ?>">Kelola Mobil Sampah</a> > Edit</h1>
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
            <form method="POST" action="<?php echo base_url() ?>mobil_sampah/update">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Edit Kelola Mobil Sampah</h4>
                            </div>
                            <div class="card-body">

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Merek Mobil</label>
                                            <input type="text" class="form-control" name="merek" value="<?= $mobil_sampah->MEREK ?>" required>
                                            <input type="hidden" class="form-control" name="id" value="<?= $mobil_sampah->ID_MOBIL_SAMPAH ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Nomor Plat</label>
                                            <input type="text" class="form-control" name="no_plat" value="<?= $mobil_sampah->NO_PLAT ?>" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Lokasi</label>
                                            <textarea type="text" class="form-control" name="lokasi" required><?= $mobil_sampah->LOKASI ?></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Status</label>
                                            <select class="form-control" id="status" name="status" required>
                                                <option value="ready" <?= $mobil_sampah->STATUS == 'ready' ? 'selected' : '' ?>>Ready</option>
                                                <option value="dipakai" <?= $mobil_sampah->STATUS == 'dipakai' ? 'selected' : '' ?>>Dipakai</option>
                                                <option value="service" <?= $mobil_sampah->STATUS == 'service' ? 'selected' : '' ?>>Service</option>
                                            </select>
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
    </section>

</div>