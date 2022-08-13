<!--Begin Page Content -->

<style>
* {
  box-sizing: border-box;
}

body {
  background-color: #24b47e;
  /*font-family: open-sans;*/
}

/* The actual timeline (the vertical ruler) */
.timeline {
  position: relative;
  max-width: 1200px;
  margin: 0 auto;
}

/* The actual timeline (the vertical ruler) */
.timeline::after {
  content: '';
  position: absolute;
  width: 6px;
  background-color: #4e73df;
  top: 0;
  bottom: 0;
  left: 0%;
  margin-left: -6px;
}

/* Container around content */
.container2 {
  padding: 10px 40px;
  position: relative;
  background-color: inherit;
  width: 100%;
}

/* The circles on the timeline */
.container2::after {
  content: '';
  position: absolute;
  width: 25px;
  height: 25px;
  right: -17px;
  background-color: #4e73df;
  border: 4px solid #224abe;
  top: 15px;
  border-radius: 50%;
  z-index: 1;
}

/* Place the container to the right */
.right {
  left: 0%;
}

/* Add arrows to the right container (pointing left) */
.right::before {
  content: " ";
  height: 0;
  position: absolute;
  top: 22px;
  width: 0;
  z-index: 1;
  left: 30px;
  border: medium solid #24b47e;
  border-width: 10px 10px 10px 0;
  border-color: transparent #24b47e transparent transparent;
}

/* Fix the circle for containers on the right side */
.right::after {
  left: -16px;
}

/* The actual content */
.content2 {
  padding-left:20px;
  padding-right:20px;
  padding-top:10px;
  padding-bottom:10px;
  background-color: #AFF1b6;
  position: relative;
  border-radius: 6px;
  width:350px;
  height:120px;
}

}
</style>

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
         <form action="<?php echo base_url('laporan/linimasa_cetak') ?>" method="POST" name="add_name" target="_BLANK">
    <?php }?>
    <div class="row">
    <div class="col-lg-6 col-sm-6" >

        <div class="card shadow mb-4" >

            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">

                <h6 class="m-0 font-weight-bold text-primary"><?php echo $title; ?></h6>

            </div>

            <div class="card-body" style="height:450px;">

                <div class="row">

                <div class="col-md-12">

                    <div class="col-md-6">

                        <div class="form-group" >

                        <label for="tgaw">Tanggal Mulai</label>

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
              
              <div class="row">
                  <div class="col-md-12">
                <div class="col-md-6">
                	<div class="form-group" >

                        <label for="tgak">Pilih Sales</label>

                        <select class="form-control" id="idsales">
                            
                            <?php 
                            $idp = $this->session->userdata('idp');
                                $sls = $this->db->query("SELECT * FROM pengguna WHERE ID_HAK_AKSES = '4' AND ATASAN_PENGGUNA = '$idp'")->result();
                                foreach($sls as $sl){
                            ?>
                                <option value="<?php echo $sl->ID_PENGGUNA;?>"><?php echo $sl->NAMA_PENGGUNA;?></option>
                            <?php }?>
                        </select>

                    </div>
                </div>
                </div>
               <!--<div class="text-left" padding-bottom:100px >-->
                    <div class="form-group" style="padding-left:25px;padding-top:50px;">
                    <button class="btn btn-lg btn-primary mr-1" type="button" onclick="Lap()" style="padding-bottom:-10px">Cari Data</button>
                    </div>
                <!--</div>-->
              </div>

               

            </div>

        </div>

    </div>
     
    <div id="dtlap"  class="col-lg-6 col-sm-6"></div>
    </div>
    



</div>

</form>

<!-- /.container-fluid -->



</div>

    <script type="text/javascript">

  function Lap() {

    var tgaw = document.getElementById('tgaw').value;

    var tgak = document.getElementById('tgak').value;

    var idsales = document.getElementById('idsales').value;

      $.ajax({

          type: "POST",

          data: {tgaw: ""+tgaw, tgak: ""+tgak, idsales: ""+idsales},

          url: "<?php echo base_url(); ?>laporan/linimasa_view",

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