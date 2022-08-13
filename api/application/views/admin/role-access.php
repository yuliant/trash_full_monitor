<!-- Begin Page Content -->
  <div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?php echo $title; ?></h1>

    <div class="row">
      <div class="col-lg-6">

        <!-- flashdata message -->
        <?php echo $this->session->flashdata('message'); ?>

        <h5>Bidang : <?php echo $role['HAK_AKSES']; ?></h5>

        <!-- Table -->
        <table class="table table-hover">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Menu</th>
              <th scope="col">Akses</th>
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
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" <?php echo check_access($role['ID_HAK_AKSES'], $m['ID_MENU_PENGGUNA']); ?> data-role="<?php echo $role['ID_HAK_AKSES']; ?>" data-menu="<?php echo $m['ID_MENU_PENGGUNA']; ?>">
                </div>
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
