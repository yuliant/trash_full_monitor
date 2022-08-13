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
            <form action="<?php echo base_url('supervisor/kunjungan_tambah') ?>" method="POST">
                <div class="form-group">
                    <label for="nama_kunjungan">Nama Toko</label>
                    <input type="text" class="form-control" id="nama_kunjungan" name="nama_kunjungan" value="<?php echo set_value('nama_kunjungan'); ?>" required>
                    <?php echo form_error('nama_kunjungan', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>

                <div class="form-group">
                    <label for="tgl_kunjungan">Tanggal Kunjungan</label>
                    <input type="date" class="form-control" id="tgl_kunjungan" name="tgl_kunjungan" value="<?php echo set_value('stok_barang'); ?>" required>
                    <?php echo form_error('tgl_kunjungan', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>

                <div class="form-group">
                    <label for="nama_sales">Nama Sales</label>
                    <select class="custom-select" id="nama_sales" name="nama_sales">
                        <option selected>Pilih Sales ...</option>
                        <?php
                        $idp = $this->session->userdata('idp');
                        $sales = $this->db->query("SELECT * FROM pengguna WHERE ATASAN_PENGGUNA = '$idp' AND ID_HAK_AKSES = '4'")->result();
                        foreach ($sales as $s) : ?>
                            <option value="<?php echo $s->ID_PENGGUNA ?>"><?php echo $s->NAMA_PENGGUNA ?></option>
                        <?php
                        endforeach; ?>
                    </select>
                    <?php echo form_error('nama_sales', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>

                <div class="form-group">
                    <label for="no_telp_kunjungan">No Telp Toko</label>
                    <input type="number" class="form-control" id="no_telp_kunjungan" name="no_telp_kunjungan" value="<?php echo set_value('stok_barang'); ?>" required>
                    <?php echo form_error('no_telp_kunjungan', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>

                <div class="form-group">
                    <label for="alamat_toko">Alamat Toko</label>
                    <textarea class="form-control" name="alamat_kunjungan"></textarea>
                    <?php echo form_error('alamat_kunjungan', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>

                <div class="text-right">
                    <button class="btn btn-primary mr-1" type="submit">Save</button>
                    <a href="<?php echo base_url('supervisor/kunjungan') ?>" class="btn btn-danger">Cancel</a>
                </div>

            </form>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->