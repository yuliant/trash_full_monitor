<!-- Begin Page Content -->
  <div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?php echo $title; ?></h1>

    <div class="row">
      <div class="col-lg-6">

        <!-- validation error -->
        <?php echo form_error('menu', '<div class="alert alert-danger" role="alert">', '</div>'); ?>

        <!-- validation error -->
        <?php if (validation_errors()): ?>
          <div class="alert alert-danger" role="alert">
            <?php echo validation_errors(); ?>
          </div>
        <?php endif; ?>

        <!-- flashdata message -->
        <?php echo $this->session->flashdata('message'); ?>

        <!-- tombol tambah menu terhubung dengan modal-->
        <a href="#" class="btn btn-primary mb-3" data-toggle="modal" data-target="#exampleModal">Tambahkan Bidang Baru</a>

        <!-- Table -->
        <table class="table table-hover">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Bidang</th>
              <th scope="col">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $i = 1;
            foreach ($role as $r) : ?>
            <tr>
              <th scope="row"><?php echo $i; ?></th>
              <td><?php echo $r['HAK_AKSES']; ?></td>
              <td>
                <a class="badge badge-warning" href="<?php echo base_url('admin/roleAccess/') . $r['ID_HAK_AKSES']; ?>">Akses</a>
                <a class="badge badge-danger" href="<?php echo base_url('admin/deleteRole/') . $r['ID_HAK_AKSES']; ?>" onclick="return confirm('yakin?');">Hapus</a>
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
        <h5 class="modal-title" id="exampleModalLabel">Add new role</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <!-- form tambah data menu -->
      <form class="" action="<?php echo base_url('admin/addRole'); ?>" method="post">
          <div class="modal-body">
            <div class="form-group">
              <input type="text" class="form-control" id="role" name="role" placeholder="Role name">
            </div>
          </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Add</button>
        </div>
      </form>

    </div>
  </div>
</div>
