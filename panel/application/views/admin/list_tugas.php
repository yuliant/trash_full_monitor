<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Kelola List Tugas</h1>
            <div class="section-header-breadcrumb">
            </div>
        </div>

        <?php
        if ($this->session->flashdata('notif') == '1') { ?>
            <div class="alert alert-success">
                <div class="alert-title">Sukses</div>
            </div>
        <?php } elseif ($this->session->flashdata('notif') == '2') { ?>
            <div class="alert alert-danger">
                <div class="alert-title">Gagal</div>
            </div>
        <?php }
        ?>

        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Data List Tugas</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="table-1" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Nama Tempat Sampah</th>
                                            <th>Petugas</th>
                                            <th>Mobil</th>
                                            <th>Status</th>
                                            <th>Tanggal</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        $tempat_sampah = $this->db->query(
                                            'SELECT * 
                                            from list_tugas 
                                            INNER JOIN tempat_sampah ON list_tugas.ID_TEMPAT_SAMPAH=tempat_sampah.ID_TEMPAT_SAMPAH
                                            INNER JOIN mobil_sampah ON list_tugas.ID_MOBIL_SAMPAH=mobil_sampah.ID_MOBIL_SAMPAH
                                            INNER JOIN pengguna ON list_tugas.ID_PENGGUNA=pengguna.ID_PENGGUNA
                                            ORDER BY ID_LIST_TUGAS DESC'
                                        )->result();

                                        foreach ($tempat_sampah as $ts) : ?>
                                            <tr>
                                                <td><?php echo $i ?></td>
                                                <td><?php echo $ts->NAMA_TEMPAT_SAMPAH ?></td>
                                                <td><?php echo $ts->NAMA_PENGGUNA ?></td>
                                                <td><?php echo $ts->MEREK . " - " .  $ts->NO_PLAT ?></td>
                                                <td><?php echo $ts->STATUS_LIST ?></td>
                                                <td><?php echo $ts->TANGGAL ?></td>
                                                <td>
                                                    <a class="badge badge-danger" href="<?php echo base_url(); ?>list_tugas/hapus/<?php echo $ts->ID_LIST_TUGAS ?>" onclick="return confirm('Apakah anda yakin ingin menghapus data ini?');">Hapus</a>
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
        </div>
    </section>

</div>