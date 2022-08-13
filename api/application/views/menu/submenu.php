<!-- Begin Page Content -->
  <div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?php echo $title; ?></h1>

    <div class="row">
      <div class="col-lg">

        <!-- validation error -->
        <?php if (validation_errors()): ?>
          <div class="alert alert-danger" role="alert">
            <?php echo validation_errors(); ?>
          </div>
        <?php endif; ?>

        <!-- flashdata message -->
        <?php echo $this->session->flashdata('message'); ?>

        <!-- tombol tambah menu terhubung dengan modal-->
        <a href="#" class="btn btn-primary mb-3" data-toggle="modal" data-target="#exampleModal">Tambahkan Sub Menu Baru</a>

        <!-- Table -->
        <table class="table table-hover">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Judul</th>
              <th scope="col">Menu</th>
              <th scope="col">Url</th>
              <th scope="col">Ikon</th>
              <th scope="col">Aktif</th>
              <th scope="col">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $i = 1;
            foreach ($subMenu as $sm) : ?>
            <tr>
              <!-- tidak urut sesuai table mysql, tidak apa2 -->
              <th scope="row"><?php echo $i; ?></th>
              <td><?php echo $sm['JUDUL_SUB_MENU_PENGGUNA']; ?></td>
              <td><?php echo $sm['MENU_PENGGUNA']; ?></td>
              <td><?php echo $sm['URL_SUB_MENU_PENGGUNA']; ?></td>
              <td><?php echo $sm['GAMBAR_SUB_MENU_PENGGUNA']; ?></td>
              <td><?php if ($sm['STATUS_AKTIF_SUB_MENU_PENGGUNA'] == 1) {
                echo "Aktif";
              }else {
                echo "Tidak Aktif";
              }; ?></td>
              <td>
                <a class="badge badge-danger" href="<?php echo base_url('menu/deleteSubmenu/') . $sm['ID_SUB_MENU_PENGGUNA']; ?>" onclick="return confirm('yakin?');">Hapus</a>
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
        <h5 class="modal-title" id="exampleModalLabel">Tambah Sub Menu Baru</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <!-- form tambah data menu -->
      <form class="" action="<?php echo base_url('menu/submenu'); ?>" method="post">
          <div class="modal-body">
            <div class="form-group">
              <input type="text" class="form-control" id="title" name="title" placeholder="Judul Sub Menu">
            </div>
            <div class="form-group">
              <select class="form-control" id="menu_id" name="menu_id">
                <option value="">Pilih Menu</option>
                <?php foreach ($menu as $m) : ?>
                  <option value="<?php echo $m['ID_MENU_PENGGUNA']; ?>"><?php echo $m['MENU_PENGGUNA']; ?></option>
                <?php endforeach?>
              </select>
            </div>
            <div class="form-group">
              <input type="text" class="form-control" id="url" name="url" placeholder="Submenu url">
            </div>
            <div class="form-group">
              <input type="text" class="form-control" id="icon" name="icon" placeholder="Submenu icon">
            </div>
            <div class="form-group">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="1" name="is_active" id="is_active" checked>
                <label class="form-check-label" for="is_active">
                  Aktif?
                </label>
              </div>
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
