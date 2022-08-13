<!-- Begin Page Content -->
<div class="container-fluid">

	<!-- Page Heading -->
	<h1 class="h3 mb-4 text-gray-800"><?php echo $title; ?></h1>
	<div class="row">
		<div class="col-lg-12">

			<!-- tombol tambah menu terhubung dengan modal-->
			<a class="btn btn-primary mb-3" href="<?php echo base_url(); ?>admin/tambah_user">Tambah Data Pengguna</a>

			<?php if (empty($kelolaUser)) : ?>
				<div class="alert alert-danger" role="alert">
					Data tidak ditemukan
				</div>
			<?php endif ?>

			<!-- flashdata message -->
			<?php echo $this->session->flashdata('message'); ?>

			<!-- Table -->
			<div class="table-responsive">
				<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th scope="col">No</th>
							<th scope="col">Nama</th>
							<th scope="col">Email</th>
							<th scope="col">Perusahaan</th>
							<th scope="col">Posisi</th>
							<th scope="col">Status</th>
							<th scope="col">Tanggal dibuat</th>
							<th scope="col">Aksi</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$i = 1;
						foreach ($kelolaUser as $ku) : ?>
							<tr>
								<!-- tidak urut sesuai table mysql, tidak apa2 -->
								<th scope="row"><?php echo $i; ?></th>
								<td><?php echo $ku['NAMA_PENGGUNA']; ?></td>
								<td><?php echo $ku['EMAIL_PENGGUNA']; ?></td>
								<td><?php echo $ku['NAMA_PERUSAHAAN']; ?></td>
								<td><?php echo $ku['HAK_AKSES']; ?></td>
								<td><?php if ($ku['STATUS_AKTIF_PENGGUNA'] == 1) {
										echo "<p style='color:green'>Aktif</p>";
									} else {
										echo "<p style='color:red'>Tidak Aktif</p>";
									} ?></td>
								<td><?php echo date_indo($user['TGL_DAFTAR_PENGGUNA']); ?></td>
								<td>
									<a class="badge badge-warning" href="<?php echo base_url(); ?>admin/change_status_user/<?php echo $ku['ID_PENGGUNA'] . '/' . $ku['STATUS_AKTIF_PENGGUNA']; ?>" onclick="return confirm('Status user akan diganti, yakin?');">Ubah Status</a>
									<a class="badge badge-danger" href="<?php echo base_url(); ?>admin/delete_user/<?php echo $ku['ID_PENGGUNA'] ?>" onclick="return confirm('User akan dihapus, yakin?');">Hapus</a>
								</td>
							</tr>
						<?php
							$i++;
						endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
