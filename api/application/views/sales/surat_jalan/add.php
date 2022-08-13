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
            <form action="<?php echo base_url('sales/surat_jalan_tambah') ?>" method="POST" name="add_name">
                <div class="form-group col-md-5">
                    <label for="no_surat_jalan">No Surat Jalan</label>
                    <input type="text" class="form-control" id="no_surat_jalan" name="no_surat_jalan" value="<?php echo $noSJ; ?>" readonly>
                    <?php echo form_error('no_surat_jalan', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
                <div class="form-group col-md-5">
                    <label for="tgl_surat_jalan">Tanggal</label>
                    <input type="date" class="form-control" id="tgl_surat_jalan" name="tgl_surat_jalan" value="<?php echo set_value('tgl_surat_jalan'); ?>" required>
                    <?php echo form_error('tgl_surat_jalan', '<small class="text-danger pl-3">', '</small>'); ?>
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
                                <td><input type="number" name="jumlah_bawa[]" placeholder="Masukkan Jumlah Bawa" class="form-control name_list" required /></td>
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