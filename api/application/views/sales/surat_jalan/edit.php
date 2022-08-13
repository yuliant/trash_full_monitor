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
        <div class="card-body">
            <form action="<?php echo base_url('sales/pelanggan_ubah/') . $pelanggan->ID_PELANGGAN ?>" method="POST">
                <div class="form-group">
                    <label for="nama_pelanggan">Nama Pelanggan</label>
                    <input type="text" class="form-control" id="nama_pelanggan" name="nama_pelanggan" value="<?php echo $pelanggan->NAMA_PELANGGAN ?>" required>
                    <?php echo form_error('nama_pelanggan', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>

                <div class="form-group">
                    <label for="email_pelanggan">Email Pelanggan</label>
                    <input type="email" class="form-control" id="email_pelanggan" name="email_pelanggan" value="<?php echo $pelanggan->EMAIL_PELANGGAN ?>" required>
                    <?php echo form_error('email_pelanggan', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>

                <div class="form-group">
                    <label for="no_hp_pelanggan">No HP Pelanggan</label>
                    <input type="number" class="form-control" id="no_hp_pelanggan" name="no_hp_pelanggan" value="<?php echo $pelanggan->NO_HP_PELANGGAN ?>" required>
                    <?php echo form_error('no_hp_pelanggan', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>

                <div class="form-group">
                    <label for="alamat_pelanggan">Alamat Pelanggan</label>
                    <textarea class="form-control" id="alamat_pelanggan" name="alamat_pelanggan" rows="3"><?php echo $pelanggan->ALAMAT_PELANGGAN ?></textarea>
                    <?php echo form_error('alamat_pelanggan', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>

                <div class="text-right">
                    <button class="btn btn-primary mr-1" type="submit">Simpan</button>
                    <a href="<?php echo base_url('sales/pelanggan') ?>" class="btn btn-danger">Batal</a>
                </div>

            </form>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->