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
                
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama</th>
                                <th>Email</th>
                                
                                <th>Wilayah</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            foreach ($sales as $k) : ?>
                                <tr>
                                    <td><?php echo $i ?></td>
                                    <td><?php echo $k->NAMA_PENGGUNA ?></td>
                                    <td><?php echo $k->EMAIL_PENGGUNA ?></td>
                                    
                                    <td><?php echo $k->NAMA_WILAYAH ?></td>    
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