<!-- Begin Page Content -->
  <div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?php echo $title; ?></h1>

    <div class="row">
      <div class="col-lg-6">

        <!-- validation error -->
        <?php echo form_error('menu', '<div class="alert alert-danger" role="alert">', '</div>'); ?>

        <!-- flashdata message -->
        <?php echo $this->session->flashdata('message'); ?>

        <!-- tombol tambah menu terhubung dengan modal-->
        <a href="#" class="btn btn-primary mb-3" data-toggle="modal" data-target="#exampleModal">Tambah Menu Baru</a>

        <!-- Table -->
        <table class="table table-hover">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Menu</th>
              <th scope="col">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $i = 1;
            foreach ($menu as $m) : ?>
            <tr>
              <th scope="row"><?php echo $i; ?></th>
              <td><?php echo $m['MENU_PENGGUNA']; ?></td>
              <td>
                <a class="badge badge-success" href="#">Ubah</a>
                <a class="badge badge-danger" href="#">Hapus</a>
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
  <!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<!-- modal tambah data menu -->
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Menu Baru</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <!-- form tambah data menu -->
      <form class="" action="<?php echo base_url('menu'); ?>" method="post">
          <div class="modal-body">
            <div class="form-group">
              <input type="text" class="form-control" id="menu" name="menu" placeholder="Nama Menu">
            </div>
          </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>

    </div>
  </div>
</div>
