<!-- Begin Page Content -->
<div class="container-fluid">

	<!-- Page Heading / fitur history halaman -->
	<h1 class="h3 mb-4 text-gray-800"><a href="<?php echo base_url('admin/kelolaUser'); ?>">Kelola Pengguna / </a><?php echo $title; ?></h1>
	<div class="row">
		<div class="col-lg-6">

			<form class="" action="<?php echo base_url('admin/tambah_user'); ?>" method="post">
				<div class="form-group">
					<label for="name">Nama</label>
					<input type="text" class="form-control" id="name" name="name">
					<?php echo form_error('name', '<small class="text-danger pl-3">', '</small>'); ?>
				</div>

				<div class="form-group">
					<label for="email">Email</label>
					<input type="email" class="form-control" id="email" name="email">
					<?php echo form_error('email', '<small class="text-danger pl-3">', '</small>'); ?>
				</div>

				<div class="form-group">
					<label for="email">Nama Perusahaan</label>
					<select class="form-control" id="perusahaan" name="perusahaan">
						<option value="">Pilih Perusahaan</option>
						<?php
						foreach ($perusahaan as $j) : ?>
							<option value="<?php echo $j['ID_PERUSAHAAN']; ?>"><?php echo $j['NAMA_PERUSAHAAN']; ?></option>
						<?php endforeach; ?>
					</select>
				</div>

				<div class="form-group">
					<label for="email">Hak Akses</label>
					<select class="form-control" id="hak_akses" name="hak_akses">
						<option value="">Pilih Hak Akses</option>
						<?php
						foreach ($jab as $j) : ?>
							<option value="<?php echo $j['ID_HAK_AKSES']; ?>"><?php echo $j['HAK_AKSES']; ?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<div class="form-group">
					<label for="new_pasword1">Password</label>
					<input type="password" class="form-control" id="new_pasword1" name="new_pasword1">
					<?php echo form_error('new_pasword1', '<small class="text-danger pl-3">', '</small>'); ?>
				</div>

				<div class="form-group">
					<label for="new_pasword2">Ulangi Password</label>
					<input type="password" class="form-control" id="new_pasword2" name="new_pasword2">
					<?php echo form_error('new_pasword2', '<small class="text-danger pl-3">', '</small>'); ?>
				</div>

				<div class="form-group">
					<button type="submit" class="btn btn-primary">Simpan</button>
				</div>

			</form>

		</div>
	</div>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
