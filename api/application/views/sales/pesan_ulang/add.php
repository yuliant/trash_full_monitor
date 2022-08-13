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
            <form action="<?php echo base_url('sales/pesan_ulang_tambah') ?>" method="POST" name="add_name">
                <div class="form-group col-md-5">
                    <label for="tgl_pesan_ulang">Tanggal</label>
                    <input type="date" class="form-control" id="tgl_pesan_ulang" name="tgl_pesan_ulang" value="<?php echo set_value('tgl_pesan_ulang'); ?>" required>
                    <?php echo form_error('tgl_pesan_ulang', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
                <div class="form-group col-md-5">
                    <label for="tgl_penjualan">Pelanggan</label>
                    <select class="form-control" id="id_pelanggan" name="id_pelanggan">
                        <option selected>Pilih Pelanggan ...</option>
                        <?php
                        foreach ($pelanggan as $plg) : ?>
                            <option value="<?php echo $plg->ID_PELANGGAN ?>"><?php echo $plg->NAMA_PELANGGAN ?></option>
                        <?php
                        endforeach; ?>
                    </select>
                </div>
                <div class="form-group col-md-5">
                    <label for="tgl_penjualan">Pembayaran</label>
                    <select class="form-control" id="jenis_pembayaran" name="jenis_pembayaran">
                        <option selected>Pilih Jenis Pembayaran ...</option>
                        <option value="Transfer">Transfer</option>
                        <option value="Tunai">Tunai</option>
                    </select>
                </div>
                <div class="form-group">
                    <h7 style="color: black"><b>Detail Barang Surat Jalan</b></h7>
                    <div class="table-responsive">
                        <table class="table " id="dynamic_field" style="border: 0px">
                            <tr>
                                <td>
                                    <select class="form-control" id="id_barang[]" name="id_barang[]">
                                        <option selected>Pilih Barang ...</option>
                                        <?php
                                        foreach ($barang as $b) : ?>
                                            <option value="<?php echo $b->ID_BARANG ?>"><?php echo $b->NAMA_BARANG ?> (Stok = <?php echo $b->STOK_BARANG ?>)</option>
                                        <?php
                                        endforeach; ?>
                                    </select>
                                </td>
                                <td><input type="number" name="jumlah_pesan[]" placeholder="Masukkan Jumlah Pesan" class="form-control name_list" required /></td>
                                <td><input type="number" class="form-control" name="harga_pesan_ulang[]"><span>Kosongkan jika tidak menggunakan harga khusus</span></td>
                                <td><button type="button" name="add" id="add" class="btn btn-success">Tambah Barang</button></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="text-right">
                    <button class="btn btn-primary mr-1" type="submit">Simpan</button>
                    <a href="#" onclick="goBack()" class="btn btn-danger">Batal</a>
                </div>

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
            $('#dynamic_field').append('<tr id="row' + i + '" class="dynamic-added"><td><select class="form-control" id="id_barang[]" name="id_barang[]"><option selected>Pilih Barang ...</option><?php foreach ($barang as $b) : ?><option value="<?php echo $b->ID_BARANG ?>"><?php echo $b->NAMA_BARANG ?> (Stok = <?php echo $b->STOK_BARANG ?>)</option><?php endforeach; ?></select></td><td><input type="number" name="jumlah_pesan[]" placeholder="Masukkan Jumlah Pesan" class="form-control name_list" required="" /></td><td><input type="number" class="form-control" name="harga_pesan_ulang[]"><span>Kosongkan jika tidak menggunakan harga khusus</span></td><td><button type="button" name="remove" id="' + i + '" class="btn btn-danger btn_remove">Hapus Barang</button></td></tr>');
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