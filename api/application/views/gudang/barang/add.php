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
            <form action="<?php echo base_url('gudang/barang_tambah') ?>" method="POST">
                <div class="form-group">
                    <label for="nama_barang">Nama Barang</label>
                    <input type="text" class="form-control" id="nama_barang" name="nama_barang" value="<?php echo set_value('nama_barang'); ?>" required>
                    <?php echo form_error('nama_barang', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>

                <div class="form-group">
                    <label for="nama_supplier">Nama Supplier</label>
                    <select class="custom-select" id="nama_supplier" name="nama_supplier">
                        <option selected>Pilih supplier ...</option>
                        <?php
                        foreach ($supplier as $s) : ?>
                            <option value="<?php echo $s->ID_SUPPLIER ?>"><?php echo $s->NAMA_SUPPLIER ?></option>
                        <?php
                        endforeach; ?>
                    </select>
                    <?php echo form_error('nama_supplier', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>

                <div class="form-group">
                    <label for="stok_barang">Stok Barang</label>
                    <input type="number" class="form-control" id="stok_barang" name="stok_barang" value="<?php echo set_value('stok_barang'); ?>" required>
                    <?php echo form_error('stok_barang', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>

                <div class="form-group">
                    <label for="nama_satuan">Satuan</label>
                    <select class="custom-select" id="nama_satuan" name="nama_satuan">
                        <option selected>Pilih satuan ...</option>
                        <?php
                        foreach ($satuan as $s) : ?>
                            <option value="<?php echo $s->ID_SATUAN ?>"><?php echo $s->NAMA_SATUAN ?></option>
                        <?php
                        endforeach; ?>
                    </select>
                    <?php echo form_error('nama_satuan', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>

                <div class="form-group">
                    <label for="harga_beli_barang">Harga Beli Barang</label>
                    <input type="number" class="form-control" id="harga_beli_barang" name="harga_beli_barang" value="<?php echo set_value('harga_beli_barang'); ?>" required>
                    <?php echo form_error('harga_beli_barang', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>

                <div class="form-group">
                    <label for="harga_jual_barang">Harga Jual Barang</label>
                    <input type="number" class="form-control" id="harga_jual_barang" name="harga_jual_barang" value="<?php echo set_value('harga_jual_barang'); ?>" required>
                    <?php echo form_error('harga_jual_barang', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>

                <div class="text-right">
                    <button class="btn btn-primary mr-1" type="submit">Save</button>
                    <a href="<?php echo base_url('gudang/barang') ?>" class="btn btn-danger">Cancel</a>
                </div>

            </form>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->