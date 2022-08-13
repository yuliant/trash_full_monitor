<div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>Profile</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
              <div class="breadcrumb-item">Profile</div>
            </div>
          </div>
          <div class="section-body">
            <h2 class="section-title">Hi,<?php echo $this->session->userdata('nm')?></h2>
            <p class="section-lead">
              Form ubah password
            </p>
            
            <?php 
            if($this->session->flashdata('notif') == '1'){?>
            <div class="alert alert-success">
              <div class="alert-title">Sukses</div>
              Berhasil ubah password.
            </div>
            <?php }elseif($this->session->flashdata('notif') == '2'){?>
            <div class="alert alert-danger">
              <div class="alert-title">Gagal</div>
              Password saat ini salah.
            </div>
            <?php }elseif($this->session->flashdata('notif') == '3'){?>
            <div class="alert alert-danger">
              <div class="alert-title">Gagal</div>
              Password tidak sama.
            </div>
            <?php }
            ?>
            
            

            <div class="row mt-sm-4">
              <div class="col-12 col-md-12 col-lg-7">
                <div class="card">
                  <form method="post" class="needs-validation" action="<?php echo base_url()?>profile/password">
                    <div class="card-header">
                      <h4>Edit Password</h4>
                    </div>
                    <div class="card-body">
                      <div class="row">                               
                          <div class="form-group col-md-6 col-12">
                            <label>Password saat ini</label>
                            <input type="password" class="form-control" name="pass1" required>
                          </div>
                          <div class="form-group col-md-6 col-12">
                          </div>
                        </div>
                        <div class="row">                               
                          <div class="form-group col-md-6 col-12">
                            <label>Password baru</label>
                            <input type="password" class="form-control" name="pass2" required>
                          </div>
                          <div class="form-group col-md-6 col-12">
                            <label>Ulangi password baru</label>
                            <input type="password" class="form-control" name="pass3" required>
                          </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                      <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>