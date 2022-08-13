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
            <!-- <form action="<?php echo base_url('sales/surat_jalan_tambah') ?>" method="POST" name="add_name"> -->
                <div class="form-group col-md-5">
                    <label for="no_surat_jalan">No Surat Jalan</label>
                    <input type="text" class="form-control" id="no_surat_jalan" name="no_surat_jalan" value="<?php echo $surat_jalan->NO_SURAT_JALAN; ?>" placeholder="Masukkan No Surat Jalan" readonly>
                    <?php echo form_error('no_surat_jalan', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
                <div class="form-group col-md-5">
                    <label for="tgl_surat_jalan">Tanggal</label>
                    <input type="text" class="form-control" id="tgl_surat_jalan" name="tgl_surat_jalan" value="<?php echo date_indo($surat_jalan->TGL_SURAT_JALAN); ?>" readonly>
                    <?php echo form_error('tgl_surat_jalan', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
                <div class="form-group">
                     <h7 style="color: black"><b>Detail Barang Surat Jalan</b></h7>
                        <div class="table-responsive">  
                            <table class="table " id="dynamic_field" style="border: 0px">  
                                <tr>
                                    <th>No.</th>
                                    <th>Nama Barang</th>
                                    <th>Jumlah Barang Dibawa</th>
                                    <th>Sisa Barang Dibawa</th>
                                </tr>
                                <?php 
                                $no=0;
                                foreach ($detail_surat_jalan as $dsj) {
                                $no++;
                                ?>
                                <tr>  
                                    <td>
                                        <?php echo $no;?>
                                    </td>
                                    <td>
                                        <input type="text" name="id_barang" placeholder="Masukkan Jumlah Bawa" class="form-control name_list" value="<?php echo $dsj->NAMA_BARANG;?>" readonly />
                                    </td>
                                    <td>
                                        <input type="number" name="jumlah_bawa" placeholder="Masukkan Jumlah Bawa" class="form-control name_list" value="<?php echo $dsj->JUMLAH_BAWA;?>" readonly />
                                    </td>
                                    <td>
                                        <input type="number" name="jumlah_bawa" placeholder="Masukkan Jumlah Bawa" class="form-control name_list" value="<?php echo $dsj->JUMLAH_SISA;?>" readonly />
                                    </td>  
                                    <td>
                                        <a href="<?php echo base_url(); ?>sales/penjualan_add/<?php echo encrypt_url($dsj->ID_DETAIL_SURAT_JALAN) ?>" class="btn btn-primary">Lakukan Penjualan</a>
                                    </td>  
                                </tr>
                                <?php } ?>  
                            </table>  
                        </div>
                </div> 
                <div class="text-right">
                    <a href="<?php echo base_url('sales/surat_jalan') ?>" class="btn btn-danger">Kembali</a>
                </div>

            <!-- </form> -->
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
<script type="text/javascript">
    $(document).ready(function(){      
      var i=1;  
   
      $('#add').click(function(){  
           i++;  
           $('#dynamic_field').append('<tr id="row'+i+'" class="dynamic-added"><td><select class="form-control" id="id_barang[]" name="id_barang[]"><option selected>Pilih Barang ...</option><?php foreach ($barang as $b) : ?><option value="<?php echo $b->ID_BARANG ?>"><?php echo $b->NAMA_BARANG ?> (Stok = <?php echo $b->STOK_BARANG ?>)</option><?php endforeach;?></select></td><td><input type="number" name="jumlah_bawa[]" placeholder="Masukkan Jumlah Bawa" class="form-control name_list" required="" /></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">Hapus Barang</button></td></tr>');  
      });
  
      $(document).on('click', '.btn_remove', function(){  
           var button_id = $(this).attr("id");   
           $('#row'+button_id+'').remove();  
      });  
  
    });  
</script>