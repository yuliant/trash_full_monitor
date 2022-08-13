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
            <form action="<?php echo base_url('gudang/supplier_ubah/') . $supplier->ID_SUPPLIER ?>" method="POST">
                <div class="form-group">
                    <label for="nama_supplier">Nama Supplier</label>
                    <input type="text" class="form-control" id="nama_supplier" name="nama_supplier" value="<?php echo $supplier->NAMA_SUPPLIER ?>" required>
                    <?php echo form_error('nama_supplier', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>

                <div class="form-group">
                    <label for="email_supplier">Email Supplier</label>
                    <input type="email" class="form-control" id="email_supplier" name="email_supplier" value="<?php echo $supplier->EMAIL_SUPPLIER ?>" required>
                    <?php echo form_error('email_supplier', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>

                <div class="form-group">
                    <label for="no_hp_supplier">No HP Supplier</label>
                    <input type="number" class="form-control" id="no_hp_supplier" name="no_hp_supplier" value="<?php echo $supplier->NO_HP_SUPPLIER ?>" required>
                    <?php echo form_error('no_hp_supplier', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>

                <div class="form-group">
                    <label for="alamat_supplier">Alamat Supplier</label>
                    <textarea class="form-control" id="alamat_supplier" name="alamat_supplier" rows="3"><?php echo $supplier->ALAMAT_SUPPLIER ?></textarea>
                    <?php echo form_error('alamat_supplier', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>

                <div class="text-right">
                    <button class="btn btn-primary mr-1" type="submit">Simpan</button>
                    <a href="<?php echo base_url('gudang/supplier') ?>" class="btn btn-danger">Batal</a>
                </div>

            </form>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->