<script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?php echo $title; ?></h1>

    <!-- flashdata message -->
    <div class="row">
        <div class="col-lg-8">
            <?php echo $this->session->flashdata('message');
            foreach ($datapmb as $pmb) {

            ?>
        </div>
    </div>

    <!-- Card Profile -->
    <div class="card mb-3 col-lg-12">
        <div class="card-body">
            <form action="<?php echo base_url('sales/pengembalian_tambah') ?>" method="POST" name="add_name">
                <div class="form-group col-md-5">
                    <label for="id_penjualan">No Penjualan</label>
                    <input type="text" class="form-control" id="id_penjualan" name="id_penjualan" value="<?php echo $pmb->ID_PENJUALAN; ?>" readonly>
                    <?php echo form_error('id_penjualan', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
                <div class="form-group col-md-5">
                    <label for="tgl_pengembalian">Tanggal</label>
                    <input type="date" class="form-control" id="tgl_pengembalian" name="tgl_pengembalian" value="<?php echo set_value('tgl_pengembalian'); ?>" required>
                    <?php echo form_error('tgl_pengembalian', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
                <div class="form-group col-md-5">
                    <label for="pleanggan">Pelanggan</label>
                    <input type="text" class="form-control" id="id_pelanggan" name="id_pelanggan" value="<?php echo $pmb->NAMA_PELANGGAN; ?>" readonly>
                </div>
                <div class="form-group">
                    <h7 style="color: black"><b>Detail Barang Penjualan</b></h7>
                    <div class="table-responsive">
                        <table class="table " id="dynamic_field" style="border: 0px">
                            <tr>
                                <th>Nama Barang</th>
                                <th>Jumlah Barang Dijual</th>
                                <th>Jumlah Barang Dikembalikan</th>
                            </tr>
                            <tr>
                                <td>
                                    <input type="text" class="form-control" id="nama_barang" name="nama_barang" value="<?php echo $pmb->NAMA_BARANG; ?>" disabled>
                                </td>
                                <td>
                                    <input type="text" class="form-control" id="jumlah_jual" name="jumlah_jual" value="<?php echo $pmb->JUMLAH_PENJUALAN; ?>" readonly>
                                </td>
                                <td>
                                    <input type="number" class="form-control" id="jumlah_kembali" name="jumlah_kembali" max="<?php echo $pmb->JUMLAH_PENJUALAN; ?>" required>
                                </td>
                            </tr>
                            <tr>
                                <th colspan="3">Keterangan Pengembalian Barang</th>
                            </tr>
                            <tr>
                                <td colspan="3">
                                    <input type="text" class="form-control" id="ket_pengembalian" name="ket_pengembalian" required>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="text-right">
                    <button class="btn btn-primary mr-1" type="submit">Simpan</button>
                    <a href="#" onclick="goBack()" class="btn btn-danger">Batal</a>
                </div>
            <?php } ?>
            </form>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
<script type="text/javascript">
    $(document).ready(function() {
        var i = 1;

        $('#add').click(function() {
            i++;
            $('#dynamic_field').append('<tr id="row' + i + '" class="dynamic-added"><td><select class="form-control" id="id_barang[]" name="id_barang[]"><option selected>Pilih Barang ...</option><?php foreach ($barang as $b) : ?><option value="<?php echo $b->ID_BARANG ?>"><?php echo $b->NAMA_BARANG ?> (Stok = <?php echo $b->STOK_BARANG ?>)</option><?php endforeach;?></select></td><td><input type="number" name="jumlah_bawa[]" placeholder="Masukkan Jumlah Bawa" class="form-control name_list" required="" /></td><td><button type="button" name="remove" id="' + i + '" class="btn btn-danger btn_remove">Hapus Barang</button></td></tr>');
        });

        $(document).on('click', '.btn_remove', function() {
            var button_id = $(this).attr("id");
            $('#row' + button_id + '').remove();
        });

    });
</script>

<script>
    function goBack() {
        window.history.back();
    }
</script>