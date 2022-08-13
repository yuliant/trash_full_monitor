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
    <div class="card mb-3 col-lg-12">
        <div class="card-body">
            <div class="row">
            <div class="col-lg-8">
            <div class="form-group">
                <label>Nama Toko</label>
                <input class="form-control" value="<?php echo $kunjungan->NAMA_KUNJUNGAN; ?>" readonly>
            </div>

            <div class="form-group">
                <label>Nama Sales</label>
                <input class="form-control" value="<?php echo $kunjungan->NAMA_PENGGUNA; ?>" readonly>
            </div>

            <div class="form-group">
                <label>No Telp Toko</label>
                <input class="form-control" value="<?php echo $kunjungan->NO_TELP_KUNJUNGAN; ?>" readonly>
            </div>

            <div class="form-group">
                <label>Alamat</label>
                <input class="form-control" value="<?php echo $kunjungan->ALAMAT_KUNJUNGAN; ?>" readonly>
            </div>

            <div class="form-group">
                <label>Keterangan Kunjungan</label>
                <textarea class="form-control" readonly><?php echo $kunjungan->KETERANGAN_KUNJUNGAN; ?></textarea>
               </div>
            </div>
            <div class="col-lg-4">
                <br>
                <div class="form-group">
                    <center>
                    <img class="rounded" height="410px" width="auto" src="<?php echo base_url()?>assets/img/kunjungan/<?php echo $kunjungan->BUKTI_KUNJUNGAN;?>">
                    </center>
                </div>
            </div>
            </div>
            <div class="text-right">
                <a href="<?php echo base_url('supervisor/kunjungan') ?>" class="btn btn-danger">Kembali</a>
            </div>

        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->