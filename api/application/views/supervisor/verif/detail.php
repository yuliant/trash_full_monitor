<script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- flashdata message -->
    <div class="row">
        <div class="col-lg-8">
            <?php echo $this->session->flashdata('message'); ?>
        </div>
    </div>

    <!-- Card Profile -->
    <div class="card mb-3 col-lg-12">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary"><?php echo $title; ?></h6>
            <div class="dropdown no-arrow">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <h6 class="text-dark">Menu</h6>
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                    <a class="dropdown-item" href="<?php echo base_url(); ?>supervisor/verifikasi_surat_jalan/<?php echo encrypt_url($surat_jalan->ID_SURAT_JALAN) ?>">Verifikasi</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="<?php echo base_url(); ?>supervisor/tolak_surat_jalan/<?php echo encrypt_url($surat_jalan->ID_SURAT_JALAN) ?>">Tolak</a>
                </div>
            </div>
        </div>
        <div class="card-body">

            <?php if ($surat_jalan->STATUS_SURAT_JALAN == 0) { ?>
                <div class="alert alert-warning" role="alert">Status surat Jalan belum diverifikasi</div>
            <?php } else { ?>
                <div class="alert alert-success" role="alert">Status surat Jalan sudah diverifikasi</div>
            <?php } ?>

            <div class="form-group col-md-5">
                <label for="no_surat_jalan">No Surat Jalan</label>
                <input type="text" class="form-control" id="no_surat_jalan" name="no_surat_jalan" value="<?php echo $surat_jalan->NO_SURAT_JALAN; ?>" placeholder="Masukkan No Surat Jalan" readonly>
                <?php echo form_error('no_surat_jalan', '<small class="text-danger pl-3">', '</small>'); ?>
            </div>
            <div class="form-group col-md-5">
                <label for="tgl_surat_jalan">Tanggal</label>
                <input type="text" class="form-control" id="tgl_surat_jalan" name="tgl_surat_jalan" value="<?php echo date_indo($surat_jalan->TGL_SURAT_JALAN); ?>" readonly>
                <?php echo form_error('tgl_surat_jalan', '<small class="text-danger pl-3">', '</small>'); ?>
            </div>
            <div class="form-group">
                <h7 style="color: black"><b>Detail Barang Surat Jalan</b></h7>
                <div class="table-responsive">
                    <table class="table " id="dynamic_field" style="border: 0px">
                        <tr>
                            <th>No.</th>
                            <th>Nama Barang</th>
                            <th>Jumlah Barang Dibawa</th>
                        </tr>
                        <?php
                        $no = 0;
                        foreach ($detail_surat_jalan as $dsj) {
                            $no++;
                        ?>
                            <tr>
                                <td>
                                    <?php echo $no; ?>
                                </td>
                                <td>
                                    <input type="text" name="id_barang" placeholder="Masukkan Jumlah Bawa" class="form-control name_list" value="<?php echo $dsj->NAMA_BARANG; ?>" readonly />
                                </td>
                                <td>
                                    <input type="number" name="jumlah_bawa" placeholder="Masukkan Jumlah Bawa" class="form-control name_list" value="<?php echo $dsj->JUMLAH_BAWA; ?>" readonly />
                                </td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
            </div>
            <div class="text-right">
                <a href="<?php echo base_url('supervisor/verif_surat_jalan') ?>" class="btn btn-danger">Back</a>
            </div>

        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->