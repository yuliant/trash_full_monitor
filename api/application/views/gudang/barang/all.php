<!-- Begin Page Content -->
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
                        <a class="dropdown-item" href="<?php echo base_url('gudang/barang_tambah') ?>">Tambah Data</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama Barang</th>
                                <th>Stok barang</th>
                                <th>Supplier</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            foreach ($barang as $b) : ?>
                                <tr>
                                    <td><?php echo $i ?></td>
                                    <td><?php echo $b->NAMA_BARANG ?></td>
                                    <td><?php echo $b->STOK_BARANG . " " . $b->NAMA_SATUAN ?></td>
                                    <td><?php echo $b->NAMA_SUPPLIER ?></td>
                                    <td>
                                        <a class="badge badge-warning text-dark" href="<?php echo base_url(); ?>gudang/barang_detail/<?php echo $b->ID_BARANG ?>">Detail</a>
                                        <a class="badge badge-success" href="<?php echo base_url(); ?>gudang/barang_ubah/<?php echo $b->ID_BARANG ?>">Ubah</a>
                                        <a class="badge badge-danger" href="<?php echo base_url(); ?>gudang/barang_hapus/<?php echo $b->ID_BARANG ?>" onclick="return confirm('Apakah anda yakin ingin menghapus data barang ini?');">Hapus</a>
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