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
                    <!--<a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">-->
                    <!--    <h6 class="text-dark">Menu</h6>-->
                    <!--</a>-->
                    <!--<button class="btn btn-sm btn-primary">Tambah Data</button>-->
                    <a class="btn btn-sm btn-primary" href="<?php echo base_url('supervisor/kunjungan_tambah') ?>">Tambah Data</a>
                    <!--<div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">-->
                    <!--    <a class="dropdown-item" href="<?php echo base_url('supervisor/kunjungan_tambah') ?>">Tambah Data</a>-->
                    <!--</div>-->
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama Toko</th>
                                <th>Tgl Kunjungan</th>
                                <th>No Telp</th>
                                <th>Alamat</th>
                                <th>Nama Sales</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            foreach ($kunjungan as $k) : ?>
                                <tr>
                                    <td><?php echo $i ?></td>
                                    <td><?php echo $k->NAMA_KUNJUNGAN ?></td>
                                    <td><?php echo date("d F Y", strtotime($k->TGL_KUNJUNGAN)) ?></td>
                                    <td><?php echo $k->NO_TELP_KUNJUNGAN ?></td>
                                    <td><?php echo $k->ALAMAT_KUNJUNGAN ?></td>
                                    <td><?php echo $k->NAMA_PENGGUNA ?></td>
                                    <?php 
                                        if($k->STATUS_KUNJUNGAN == 0){
                                    ?>
                                    <td>
                                        <!--<a class="badge badge-warning text-dark" href="<?php echo base_url(); ?>supervisor/kunjungan_detail/<?php echo $k->ID_KUNJUNGAN ?>">Detail</a>-->
                                        <!--<a class="badge badge-success" href="<?php echo base_url(); ?>supervisor/kunjungan_ubah/<?php echo $k->ID_KUNJUNGAN ?>">Ubah</a>-->
                                        <a class="badge badge-danger" href="<?php echo base_url(); ?>supervisor/kunjungan_hapus/<?php echo $k->ID_KUNJUNGAN ?>" onclick="return confirm('Apakah anda yakin ingin menghapus kunjungan ini?');">Hapus</a>
                                    </td>
                                    <?php        
                                        }else{
                                    ?>
                                    <td>
                                        <a class="badge badge-primary text-white" href="<?php echo base_url(); ?>supervisor/kunjungan_detail/<?php echo $k->ID_KUNJUNGAN ?>">Detail</a>
                                        <a class="badge badge-danger" href="<?php echo base_url(); ?>supervisor/kunjungan_hapus/<?php echo $k->ID_KUNJUNGAN ?>" onclick="return confirm('Apakah anda yakin ingin menghapus kunjungan ini?');">Hapus</a>
                                    </td>
                                    <?php }?>
                                    
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