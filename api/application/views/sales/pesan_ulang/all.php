<!--Begin Page Content -->
<div class="container-fluid">

    <!-- flashdata message -->
    <div class="row">
        <div class="col-lg-8">
            <?php echo $this->session->flashdata('message'); ?>
        </div>
    </div>

    <!-- Card all supplier-->
    <div class="col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary"><?php echo $title; ?></h6>
                <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <h6 class="text-dark">Menu</h6>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                        <a class="dropdown-item" href="<?php echo base_url('sales/pesan_ulang_tambah') ?>">Tambah Data</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Tanggal Pesan</th>
                                <th>Nama Pelanggan</th>
                                <th>Jenis Pembayaran</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            foreach ($pesan_ulang as $sj) : ?>
                                <tr>
                                    <td><?php echo $i ?></td>
                                    <td><?php echo date_indo($sj->TGL_PESAN_ULANG) ?></td>
                                    <td><?php echo $sj->NAMA_PELANGGAN ?></td>
                                    <td><?php echo $sj->STATUS_PEMBAYARAN_PESAN_ULANG ?></td>
                                    <td>
                                        <center>
                                            <?php
                                            if ($sj->STATUS_PESAN_ULANG == 0) { ?>
                                                <span class="disable-links">
                                                    <a class="badge badge-danger text-light">Belum verifikasi</a>
                                                </span>
                                            <?php } elseif($sj->STATUS_PESAN_ULANG == 1) { ?>
                                                <a class="badge badge-primary" target="_BLANK" href="<?php echo base_url(); ?>sales/pesan_ulang_cetak/<?php echo encrypt_url($sj->ID_PESAN_ULANG) ?>">Cetak Surat</a>
                                            <?php }else{ ?>
                                                <span class="disable-links">
                                                    <a class="badge badge-danger text-light">Verifikasi Ditolak</a>
                                                </span>
                                            <?php } ?>
                                            <a class="badge badge-warning text-dark" href="<?php echo base_url(); ?>sales/pesan_ulang_detail/<?php echo encrypt_url($sj->ID_PESAN_ULANG) ?>">Detail Pesan Ulang</a>

                                            <!-- <?php if ($sj->STATUS_PESAN_ULANG == 1) { ?>
                                                <a class="badge badge-success" href="<?php echo base_url(); ?>sales/penjualan/<?php echo encrypt_url($sj->ID_PESAN_ULANG) ?>">Lihat Penjualan</a>
                                            <?php } ?> -->

                                        </center>
                                    </td>
                                </tr>
                            <?php
                                $i++;
                            endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content