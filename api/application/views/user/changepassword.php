
        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800"><?php echo $title; ?></h1>

          <!-- edit Password user -->
          <div class="row">
             <div class="col-lg-6">

               <!-- flashdata message -->
              <?php echo $this->session->flashdata('message'); ?>
              
               <form class="" action="<?php echo base_url('user/changepassword'); ?>" method="post">
                 <div class="form-group">
                   <label for="current_pasword">Password Saat Ini</label>
                   <input type="password" class="form-control" id="current_pasword" name="current_pasword">
                   <?php echo form_error('current_pasword', '<small class="text-danger pl-3">', '</small>'); ?>
                 </div>

                 <div class="form-group">
                   <label for="new_pasword1">Password Baru</label>
                   <input type="password" class="form-control" id="new_pasword1" name="new_pasword1">
                   <?php echo form_error('new_pasword1', '<small class="text-danger pl-3">', '</small>'); ?>
                 </div>

                 <div class="form-group">
                   <label for="new_pasword2">Ulangi Password</label>
                   <input type="password" class="form-control" id="new_pasword2" name="new_pasword2">
                   <?php echo form_error('new_pasword2', '<small class="text-danger pl-3">', '</small>'); ?>
                 </div>

                 <div class="form-group">
                   <button type="submit" class="btn btn-primary">Ubah Password</button>
                 </div>

               </form>

             </div>
          </div>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->
