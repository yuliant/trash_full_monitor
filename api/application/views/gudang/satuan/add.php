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
    <div class="card mb-3 col-lg-6">
        <div class="card-body">
            <form action="<?php echo base_url('gudang/satuan_tambah') ?>" method="POST">
                <div class="form-group">
                    <label for="nama_satuan">Nama Satuan</label>
                    <input type="text" class="form-control" id="nama_satuan" name="nama_satuan" value="<?php echo set_value('nama_satuan'); ?>" required>
                    <?php echo form_error('nama_satuan', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>

                <div class="text-right">
                    <button class="btn btn-primary mr-1" type="submit">Simpan</button>
                    <a href="<?php echo base_url('gudang/satuan') ?>" class="btn btn-danger">Batal</a>
                </div>

            </form>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->