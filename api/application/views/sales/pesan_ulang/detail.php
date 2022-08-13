<script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
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
    <div class="card mb-3 col-lg-12">
        <div class="card-body">
            <div class="form-group col-md-5">
                <label for="tgl_pesan_ulang">Tanggal</label>
                <input type="text" class="form-control" id="tgl_pesan_ulang" name="tgl_pesan_ulang" value="<?php echo date_indo($pesan_ulang->TGL_PESAN_ULANG); ?>" readonly>
                <?php echo form_error('tgl_pesan_ulang', '<small class="text-danger pl-3">', '</small>'); ?>
            </div>
            <div class="form-group">
                <h7 style="color: black"><b>Detail Barang Pesan Ulang</b></h7>
                <div class="table-responsive">
                    <table class="table " id="dynamic_field" style="border: 0px">
                        <tr>
                            <th>No.</th>
                            <th>Nama Barang</th>
                            <th>Jumlah Pesan Ulang</th>
                        </tr>
                        <?php
                        $no = 0;
                        foreach ($detail_pesan_ulang as $dpu) {
                            $no++;
                        ?>
                            <tr>
                                <td>
                                    <?php echo $no; ?>
                                </td>
                                <td>
                                    <input type="text" name="id_barang" placeholder="Masukkan Jumlah Bawa" class="form-control name_list" value="<?php echo $dpu->NAMA_BARANG; ?>" readonly />
                                </td>
                                <td>
                                    <input type="number" name="jumlah_bawa" placeholder="Masukkan Jumlah Bawa" class="form-control name_list" value="<?php echo $dpu->JUMLAH_PESAN_ULANG; ?>" readonly />
                                </td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
            </div>
            <div class="text-right">
                <!-- <a href="<?php echo base_url('sales/pesan_ulang') ?>" class="btn btn-success">Kirim Pesanan</a> -->
                <a href="<?php echo base_url('sales/pesan_ulang') ?>" class="btn btn-danger">Kembali</a>
            </div>

            <!-- </form> -->
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->