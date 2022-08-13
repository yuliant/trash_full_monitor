<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="col-lg-12">

        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary"><?php echo $title; ?></h6>
                <div class="dropdown no-arrow">
                    <!-- <a href="<?php echo base_url() ?>supervisor/datagps/getmap2/" class="btn btn-md btn-primary"><i class="fas fa-map"></i> Lacak Semua Sales</a> -->
                </div>
            </div>

            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Aksi</th>
                            </tr>

                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            foreach ($sales as $s) { ?>
                                <tr>
                                    <td><?php echo $i ?></td>
                                    <td><?php echo $s->NAMA_PENGGUNA ?></td>
                                    <td><?php echo $s->EMAIL_PENGGUNA ?></td>
                                    <td align="center"><a href="<?php echo base_url() ?>supervisor/datagps/getmap/<?php echo $s->ID_PENGGUNA; ?>" class="btn btn-md btn-primary"><i class="fas fa-map"></i> Lacak</a></td>
                                </tr>
                            <?php
                                $i++;
                            } ?>

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