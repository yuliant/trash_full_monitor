<!--Begin Page Content -->

<div class="container-fluid">



    <!-- flashdata message -->

    <div class="row">

        <div class="col-lg-8">

            <?php echo $this->session->flashdata('message'); ?>

        </div>

    </div>



    <!-- Card all supplier-->
    <?php 
    if ($user['HAK_AKSES'] == 'Gudang') {?>
    <form action="<?php echo base_url('laporan/penjualan_cetakg') ?>" method="POST" name="add_name" target="_BLANK">
    <?php }else{?>
         <form action="<?php echo base_url('laporan/penjualan_cetak') ?>" method="POST" name="add_name" target="_BLANK">
    <?php }?>
    <div class="col-lg-12 col-sm-12">

        <div class="card shadow mb-4">

            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">

                <h6 class="m-0 font-weight-bold text-primary"><?php echo $title; ?></h6>

            </div>

            <div class="card-body">

                <div class="row">

                <div class="col-md-12">

                    <div class="col-md-6">

                        <div class="form-group" >

                        <label for="tgaw">Tanggal Mulai <?php echo $user['HAK_AKSES'];?></label>

                        <input type="date" class="form-control" id="tgaw" name="tgaw" value="<?php echo set_value('tgaw'); ?>" required>

                        <?php echo form_error('tgaw', '<small class="text-danger pl-3">', '</small>'); ?>

                        </div>

                    </div>

                    <div class="col-md-6">

                        <div class="form-group" >

                        <label for="tgak">Tanggal Akhir</label>

                        <input type="date" class="form-control" id="tgak" name="tgak" value="<?php echo set_value('tgak'); ?>" required>

                        <?php echo form_error('tgak', '<small class="text-danger pl-3">', '</small>'); ?>

                        </div>

                    </div>

                </div>

                </div>

                <div class="text-right">
                    <?php 
                    if ($user['HAK_AKSES'] == 'Gudang') {?>
                    <button class="btn btn-primary mr-1" type="button" onclick="LapG()">Cari Data</button>
                    <?php }else{
                    ?>
                    <button class="btn btn-primary mr-1" type="button" onclick="Lap()">Cari Data</button>
                    <?php }?>
                </div>

            </div>

        </div>

    </div>

    <div id="dtlap"></div>



</div>

</form>

<!-- /.container-fluid -->



</div>

    <script type="text/javascript">

  function Lap() {

    var tgaw = document.getElementById('tgaw').value;

    var tgak = document.getElementById('tgak').value;

      $.ajax({

          type: "POST",

          data: {tgaw: ""+tgaw, tgak: ""+tgak},

          url: "<?php echo base_url(); ?>laporan/penjualan_view",

          success: function(data) {

              $("#dtlap").html(data);

              

          }

      });

  }

  function LapG() {

    var tgaw = document.getElementById('tgaw').value;

    var tgak = document.getElementById('tgak').value;

      $.ajax({

          type: "POST",

          data: {tgaw: ""+tgaw, tgak: ""+tgak},

          url: "<?php echo base_url(); ?>laporan/penjualan_viewg",

          success: function(data) {

              $("#dtlap").html(data);

              

          }

      });

  }

</script>

<!-- End of Main Content