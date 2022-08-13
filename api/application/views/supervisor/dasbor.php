<script src="<?php echo base_url(); ?>assets/highcharts/code/highcharts.js"></script>

<script src="<?php echo base_url(); ?>assets/highcharts/code/modules/series-label.js"></script>

<script src="<?php echo base_url(); ?>assets/highcharts/code/modules/exporting.js"></script>

<script src="<?php echo base_url(); ?>assets/highcharts/code/modules/export-data.js"></script>

<script src="<?php echo base_url(); ?>assets/highcharts/code/modules/accessibility.js"></script>


<!-- Begin Page Content -->

<div class="container-fluid">



    <!-- flashdata message -->

    <div class="row">

        <div class="col-lg-8">

            <?php echo $this->session->flashdata('message'); ?>

        </div>

    </div>
    <div class="row">
        <!-- <input type="date" name="tgaw" class="form-control"> -->
        <!-- <div class="col-xl-6 col-md-6 mb-4"> -->
            <!-- <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Tanggal Mulai</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <input type="date" name="tglaw" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->
        <!-- </div> -->
        <div class="col-xl-12 col-md-12 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col-md-5">
                            <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Tanggal Mulai</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <input type="date" name="tgak" id="tgaw" class="form-control">
                            </div>
                        </div>
                        </div>
                        <div class="col-md-5">
                            <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Tanggal Selesai</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <input type="date" name="tgak" id="tgak" class="form-control">
                            </div>
                        </div>
                        </div>
                        <div class="col-md-2" style="padding-top: 20px;">
                            <div class="col mr-2">
                            <button class="btn btn-sm btn-primary" onclick="cek()"><i class="fa fa-search"></i> Lihat Informasi</button>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row" id="dash-item">
                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Total Kunjungan</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $kunjungan['tkj']?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-chart-line fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        <center><a href="<?= base_url()?>/supervisor/kunjungan">Lihat Data</a></center>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Kunjungan Selesai</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $kunjungan_selesai['tkj']?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-chart-area fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        <center><a href="<?= base_url()?>/supervisor/kunjungan">Lihat Data</a></center>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Jumlah Sales
                                            </div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $sales['sales']?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-portrait fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        <center><a href="<?= base_url()?>/supervisor/sales">Lihat Data</a></center>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pending Requests Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Jumlah MS</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $spv['spv']?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-portrait fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        <center><a href="<?= base_url()?>/supervisor/sales">Lihat Data</a></center>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

    <!-- Card all supplier-->

    <div class="col-lg-12">

        <div class="card shadow mb-4">

            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">

                <h6 class="m-0 font-weight-bold text-primary"><?php echo $title; ?></h6>

            </div>

            <div class="card-body">

            	<figure class="highcharts-figure">

				    <div id="container"></div>

				</figure>

            </div>

        </div>

    </div>



</div>

<!-- /.container-fluid -->



</div>

<!-- End of Main Content -->

<?php 

$bln = array('01','02','03','04','05','06','07','08','09','10','11','12');

$jml = sizeof($bln);

$year = date('Y');

?>

<script type="text/javascript">



Highcharts.chart('container', {

    chart: {

        type: 'line'

    },

    title: {

        text: 'Kunjungan Sales Tahun <?php echo $year;?>'

    },

    subtitle: {

        text: ''

    },

    xAxis: {

        categories: [

            'Jan',

            'Feb',

            'Mar',

            'Apr',

            'Mei',

            'Jun',

            'Jul',

            'Agu',

            'Sep',

            'Okt',

            'Nov',

            'Des'

        ],

        crosshair: true

    },

    yAxis: {

        min: 0,

        title: {

            text: 'Jumlah Kunjungan'

        }

    },

    tooltip: {

        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',

        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +

            '<td style="padding:0"><b>{point.y:.0f}</b></td></tr>',

        footerFormat: '</table>',

        shared: true,

        useHTML: true

    },

    plotOptions: {

        column: {

            pointPadding: 0.2,

            borderWidth: 0

        }

    },

    series: [

    <?php 

    $idp = $this->session->userdata('idp');

    $data = $this->db->query("

    	SELECT pg.ID_PENGGUNA, pg.NAMA_PENGGUNA, IFNULL(COUNT(k.ID_KUNJUNGAN),'0') as 'Total' 

        FROM kunjungan k

        JOIN pengguna pg ON pg.ID_PENGGUNA = k.ID_PENGGUNA

        WHERE ATASAN_PENGGUNA = '$idp'

        GROUP BY k.ID_PENGGUNA

        ORDER BY COUNT(k.ID_KUNJUNGAN) DESC")->result();



    foreach ($data as $dt) {

    	$idpg = $dt->ID_PENGGUNA;

    ?>

    {

        name: '<?php echo $dt->NAMA_PENGGUNA;?>',

        data: 

        [

        <?php 

        for ($i=0; $i < $jml; $i++) { 

        $tgl = $bln[$i].'-'.$year;

        	$data2 = $this->db->query("

	    	SELECT pg.ID_PENGGUNA, pg.NAMA_PENGGUNA, IFNULL(COUNT(k.ID_KUNJUNGAN),'0') as 'Total' 

            FROM kunjungan k

            JOIN pengguna pg ON pg.ID_PENGGUNA = k.ID_PENGGUNA

			WHERE pg.ID_PENGGUNA = '$idpg' AND DATE_FORMAT(k.TGL_KUNJUNGAN, '%m-%Y') = '$tgl'

            GROUP BY k.ID_PENGGUNA

            ORDER BY COUNT(k.ID_KUNJUNGAN) DESC")->num_rows();

			if($data2 > 0){

				$data2 = $this->db->query("

	    	SELECT pg.ID_PENGGUNA, pg.NAMA_PENGGUNA, IFNULL(COUNT(k.ID_KUNJUNGAN),'0') as 'Total' 

            FROM kunjungan k

            JOIN pengguna pg ON pg.ID_PENGGUNA = k.ID_PENGGUNA

            WHERE pg.ID_PENGGUNA = '$idpg' AND DATE_FORMAT(k.TGL_KUNJUNGAN, '%m-%Y') = '$tgl'

            GROUP BY k.ID_PENGGUNA

            ORDER BY COUNT(k.ID_KUNJUNGAN) DESC")->result();

			foreach ($data2 as $dt2) {

    		$ttljl = $dt2->Total;

    		}



			}else{

    		$ttljl = 0;

			}

        ?>

		<?php echo $ttljl;?>,

		<?php }?>

        ]



    },

	<?php }?>

    ]

});

		</script>
            <script type="text/javascript">
  function cek() {
    var tgaw = document.getElementById('tgaw').value;
    var tgak = document.getElementById('tgak').value;
      $.ajax({
          type: "POST",
          data: {tgaw: ""+tgaw, tgak: ""+tgak},
          url: "<?php echo base_url(); ?>supervisor/SP_dasbor_c/dash_custom",
          success: function(data) {
              $("#dash-item").html(data);
              
          }
      });
  }
</script>