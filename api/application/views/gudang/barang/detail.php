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
            <div class="form-group">
                <label>Nama Barang</label>
                <input class="form-control" value="<?php echo $barang->NAMA_BARANG; ?>" readonly>
            </div>

            <div class="form-group">
                <label>Nama Supplier</label>
                <input class="form-control" value="<?php echo $barang->NAMA_SUPPLIER; ?>" readonly>
            </div>

            <div class="form-group">
                <label>Stok Barang</label>
                <input class="form-control" value="<?php echo $barang->STOK_BARANG; ?>" readonly>
            </div>

            <div class="form-group">
                <label>Satuan</label>
                <input class="form-control" value="<?php echo $barang->NAMA_SATUAN; ?>" readonly>
            </div>

            <div class="form-group">
                <label>Harga Beli Barang</label>
                <input class="form-control" value="<?php echo $barang->HARGA_BELI_BARANG; ?>" readonly>
            </div>

            <div class="form-group">
                <label>Harga Jual Barang</label>
                <input class="form-control" value="<?php echo $barang->HARGA_JUAL_BARANG; ?>" readonly>
            </div>

            <div class="text-right">
                <a href="<?php echo base_url('gudang/barang') ?>" class="btn btn-danger">Kembali</a>
            </div>

        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->