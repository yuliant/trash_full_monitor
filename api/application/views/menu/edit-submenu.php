
        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800"><?php echo $title ." (". $submenu['title'] . ")";?></h1>

          <!-- form tambah data menu -->
          <div class="row">
            <div class="col-lg-8">

              <form class="" action="<?php echo base_url('menu/editSubmenu'); ?>" method="post">
                    <div class="form-group">
                      <input type="text" class="form-control" id="title" name="title" value="<?php echo $submenu['title']; ?>">
                    </div>

                    <div class="form-group">
                      <select class="form-control" id="menu_id" name="menu_id">
                        <option value="<?php echo $submenu['id']; ?>"><?php echo $submenu['menu']; ?></option>
                        <?php foreach ($menu as $m) : ?>
                          <option value="<?php echo $m['id']; ?>"><?php echo $m['menu']; ?></option>
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
                  <button type="submit" class="btn btn-primary">Save</button>
                </div>
              </form>

            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->
