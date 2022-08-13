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
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />

</head>

<body class="bg-mct" style="background-color: #35283c;">
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
								<div class="p-5">
									<form>
										<div class="form-group">
											<textarea type="text" class="form-control" rows="4" readonly>Data berhasil diinput silhkan kembali ke aplikasi dengan menekan tombol di bawah ini.</textarea>
										</div>

										<a href="<?= base_url('order/kunjungan/sukses') ?>" class="btn btn-primary btn-user btn-block">
											Kembali ke Aplikasi
										</a>
									</form>

								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

</body>

</html>
