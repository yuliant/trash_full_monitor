<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">
	<link rel="icon" href="<?php echo base_url('assets/'); ?>/img/ilmea-small.png" type="image/x-icon" sizes="16x16" />

	<title><?php echo $title; ?></title>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />

</head>

<body class="bg-mct" style="background-color: #264eca;">

	<style type="text/css">
		.field-icon {
			float: right;
			padding-right: 40px;
			margin-top: -33px;
		}

		.container1 {
			padding-top: 50px;
			margin: auto;
		}
	</style>
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-7">
				<div class="card o-hidden border-0 shadow-lg my-5" style="background-color:gainsboro">
					<div class="card-body p-0">
						<div class="row">
							<div class="col-lg">
								<div class="text-center" style="padding-top: 40px">
									<center>
										<h2>DETAIL KUNJUNGAN</h2>
									</center>
								</div>
								<div class="p-5">

									<?php echo $this->session->flashdata('message'); ?>

									<form method="POST" action="<?= base_url('order/kunjungan/save') ?>">

										<input type="hidden" name="kode" id="kode" value="<?= $user['KODE'] ?>">
										<input type="hidden" name="lat" id="lat" value="<?= $lat ?>">
										<input type="hidden" name="long" id="long" value="<?= $long ?>">

										<div class="form-group">
											<label><b>Nama Toko</b></label>
											<input class="form-control" value="<?= $user['NAMA_KUNJUNGAN'] ?>" readonly required>
										</div>

										<div class="form-group">
											<label for="exampleInputPassword1"><b>Alamat Toko</b></label>
											<textarea class="form-control" readonly required><?= $user['ALAMAT_KUNJUNGAN'] ?></textarea>
										</div>

										<div class="form-group">
											<label>
												<b>Telpon Toko</b></label>
											<input class="form-control" value="<?= $user['NO_TELP_KUNJUNGAN'] ?>" readonly required>
										</div>

										<center><label><b>Bukti Kunjungan</b></label></center>
                                        <div id="my_camera" style="width:200px; margin-left:-38px;"></div>
                                        <center>
                                            <div style="padding-top:10px">
                                                <input class="btn btn-warning btn-user" type=button value="Ambil Foto" onClick="take_snapshot()">

                                                <input type="hidden" name="image" class="image-tag">
                                            </div>
                                        </center>
                                        <div class="form-group">
                                            <div id="results"></div>
                                        </div>

										<div class="form-group">
											<label>
												<b>
													Keterangan
												</b>
											</label>
											<textarea name="keterangan" id="keterangan" type="text" class="form-control" rows="8" required></textarea>
											<?php echo form_error('keterangan', '<small class="text-danger pl-3">', '</small>'); ?>
										</div>

										<button type="submit" class="btn btn-primary btn-user btn-block">
											SIMPAN
										</button>
									</form>

								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Configure a few settings and attach camera -->
	<script language="JavaScript">
		Webcam.set({
		 width: 350,
            height: 400,
            image_format: 'jpeg',
            jpeg_quality: 100
		});

		Webcam.attach('#my_camera');

		function take_snapshot() {
			Webcam.snap(function(data_uri) {
				$(".image-tag").val(data_uri);
				document.getElementById('results').innerHTML = '<img style="padding-top:30px; width:270px; height:350px;" src="' + data_uri + '"/>';
			});
		}
	</script>

</body>

</html>
