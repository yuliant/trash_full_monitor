<script src="<?php echo base_url(); ?>assets/highcharts/code/highcharts.js"></script>
<script src="<?php echo base_url(); ?>assets/highcharts/code/modules/series-label.js"></script>
<script src="<?php echo base_url(); ?>assets/highcharts/code/modules/exporting.js"></script>
<script src="<?php echo base_url(); ?>assets/highcharts/code/modules/export-data.js"></script>
<script src="<?php echo base_url(); ?>assets/highcharts/code/modules/accessibility.js"></script>
<!-- 		<style type="text/css">
.highcharts-figure, .highcharts-data-table table {
    min-width: 360px; 
    max-width: 800px;
    margin: 1em auto;
}

.highcharts-data-table table {
	font-family: Verdana, sans-serif;
	border-collapse: collapse;
	border: 1px solid #EBEBEB;
	margin: 10px auto;
	text-align: center;
	width: 100%;
	max-width: 500px;
}
.highcharts-data-table caption {
    padding: 1em 0;
    font-size: 1.2em;
    color: #555;
}
.highcharts-data-table th {
	font-weight: 600;
    padding: 0.5em;
}
.highcharts-data-table td, .highcharts-data-table th, .highcharts-data-table caption {
    padding: 0.5em;
}
.highcharts-data-table thead tr, .highcharts-data-table tr:nth-child(even) {
    background: #f8f8f8;
}
.highcharts-data-table tr:hover {
    background: #f1f7ff;
}

		</style> -->
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
        type: 'column'
    },
    title: {
        text: 'Perbandingan Barang Terbaik Tahun <?php echo $year;?>'
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
            text: 'Tingkat Penjualan'
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
    $data = $this->db->query("
    	SELECT b.ID_BARANG, b.NAMA_BARANG, IFNULL(SUM(p.JUMLAH_PENJUALAN),'0') as 'Total' 
		FROM penjualan p
		JOIN detail_surat_jalan dsj ON dsj.ID_DETAIL_SURAT_JALAN = p.ID_DETAIL_SURAT_JALAN
		JOIN barang b ON b.ID_BARANG = dsj.ID_BARANG
		GROUP BY b.ID_BARANG
		ORDER BY SUM(p.JUMLAH_PENJUALAN) DESC
		LIMIT 3")->result();

    foreach ($data as $dt) {
    	$idbrg = $dt->ID_BARANG;
    ?>
    {
        name: '<?php echo $dt->NAMA_BARANG;?>',
        data: 
        [
        <?php 
        for ($i=0; $i < $jml; $i++) { 
        $tgl = $bln[$i].'-'.$year;
        	$data2 = $this->db->query("
	    	SELECT b.ID_BARANG, b.NAMA_BARANG, IFNULL(SUM(p.JUMLAH_PENJUALAN),'0') as 'Total' 
			FROM penjualan p
			JOIN detail_surat_jalan dsj ON dsj.ID_DETAIL_SURAT_JALAN = p.ID_DETAIL_SURAT_JALAN
			JOIN barang b ON b.ID_BARANG = dsj.ID_BARANG
			WHERE b.ID_BARANG = '$idbrg' AND DATE_FORMAT(p.TGL_PENJUALAN, '%m-%Y') = '$tgl'
			GROUP BY b.ID_BARANG
			ORDER BY SUM(p.JUMLAH_PENJUALAN) DESC
			LIMIT 3")->num_rows();
			if($data2 > 0){
				$data2 = $this->db->query("
	    	SELECT b.ID_BARANG, b.NAMA_BARANG, IFNULL(SUM(p.JUMLAH_PENJUALAN),'0') as 'Total' 
			FROM penjualan p
			JOIN detail_surat_jalan dsj ON dsj.ID_DETAIL_SURAT_JALAN = p.ID_DETAIL_SURAT_JALAN
			JOIN barang b ON b.ID_BARANG = dsj.ID_BARANG
			WHERE b.ID_BARANG = '$idbrg' AND DATE_FORMAT(p.TGL_PENJUALAN, '%m-%Y') = '$tgl'
			GROUP BY b.ID_BARANG
			ORDER BY SUM(p.JUMLAH_PENJUALAN) DESC
			LIMIT 3")->result();
			foreach ($data2 as $dt2) {
    		$ttlbrg = $dt2->Total;
    		}

			}else{
    		$ttlbrg = 0;
			}
        ?>
		<?php echo $ttlbrg;?>,
		<?php }?>
        ]

    },
	<?php }?>
    ]
});
		</script>