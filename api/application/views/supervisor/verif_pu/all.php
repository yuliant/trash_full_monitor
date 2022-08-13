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
                    <!-- <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <h6 class="text-dark">Menu</h6>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                        <a class="dropdown-item" href="#">Tambah Data</a>
                    </div> -->
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>ID Pesan</th>
                                <th>Tanggal Pesan</th>
                                <th>Nama Sales</th>
                                <th>Nama Pelanggan</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            foreach ($pesan_ulang as $sj) : ?>
                                <tr>
                                    <td><?php echo $i ?></td>
                                    <td><?php echo $sj->ID_PESAN_ULANG ?></td>
                                    <td><?php echo date_indo($sj->TGL_PESAN_ULANG) ?></td>
                                    <td><?php echo $sj->NAMA_PENGGUNA ?></td>
                                    <td><?php echo $sj->NAMA_PELANGGAN ?></td>
                                    <td>
                                        <center>
                                            <a class="badge badge-success text-dark" href="<?php echo base_url(); ?>supervisor/verifikasi_pesan_ulang/<?php echo encrypt_url($sj->ID_PESAN_ULANG) ?>">Terima</a>
                                            <a class="badge badge-danger text-dark" href="<?php echo base_url(); ?>supervisor/tolak_pesan_ulang/<?php echo encrypt_url($sj->ID_PESAN_ULANG) ?>">Tolak</a>
                                            <a class="badge badge-warning text-dark" href="<?php echo base_url(); ?>supervisor/pesan_ulang_detail/<?php echo encrypt_url($sj->ID_PESAN_ULANG) ?>">Detail Pesan Ulang</a>
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