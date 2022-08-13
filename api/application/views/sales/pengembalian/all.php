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
                <h6 class="m-0 font-weight-bold text-primary">Daftar Surat Jalan> Daftar Penjualan> <?php echo $title; ?></h6>
                <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <h6 class="text-dark">Menu</h6>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                        <a class="dropdown-item" href="<?php echo base_url('sales/surat_jalan_tambah') ?>">Tambah Data</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#" onclick="goBack()">Kembali ke daftar penjualan</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama Pelanggan</th>
                                <th>Tanggal Pengembalian</th>
                                <th>Nama Barang</th>
                                <th>Jumlah Kembali</th>
                                <th>Keterangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            foreach ($datapnj as $dpj) : ?>
                                <tr>
                                    <td><?php echo $i ?></td>
                                    <td><?php echo $dpj->NAMA_PELANGGAN ?></td>
                                    <td><?php echo date_indo($dpj->TGL_PENGEMBALIAN) ?></td>
                                    <td><?php echo $dpj->NAMA_BARANG ?></td>
                                    <td><?php echo $dpj->JUMLAH_PENGEMBALIAN ?></td>
                                    <td><?php echo $dpj->KETERANGAN_PENGEMBALIAN ?></td>
                                    <td>
                                     <a class="badge badge-primary " target="_BLANK" href="<?php echo base_url(); ?>sales/pengembalian_cetak/<?php echo encrypt_url($dpj->ID_PENGEMBALIAN) ?>">Cetak Pengembalian</a>
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
<!-- End of Main Content -->

<script>
    function goBack() {
        window.history.back();
    }
</script>