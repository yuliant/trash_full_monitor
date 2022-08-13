<style type="text/css">
.field-icon {
  float: right;
  /*margin-left: -55px;*/
  padding-right: 40px;
  margin-top: -33px;
  /*position: relative;*/
  /*z-index: 2;*/
}

.container1{
  padding-top:50px;
  margin: auto;
}
</style>
  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-lg-7">

        <div class="card o-hidden border-0 shadow-lg my-5" style="background-color:gainsboro">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg">
                  <div class="text-center" style="padding-top: 40px">
                    <center><img class="" src="<?php echo base_url('assets/img/Logo Ilmea Biru.svg');?>" height="80px" style="padding-bottom:0px; margin:auto;"></center>
                     <!--<h1 class="h4 text-gray-900 mb-4">Form Login</h1> -->
                  </div>
                <div class="p-5">

                  <?php echo $this->session->flashdata('message'); ?>

                  <form class="user" method="post" action="<?php echo base_url('Auth'); ?>">
                    <div class="form-group">
                      <input type="text" class="form-control form-control-user" id="email" name="email" placeholder="Email Anda.." value="<?php echo set_value('email'); ?>">
                      <?php echo form_error('email', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control form-control-user" id="password" name="password" placeholder="Password Anda..">
                      <!-- <input type="checkbox" onclick="myFunction()">Tampilkan Password -->
                      <!-- <span toggle="#password" class="fa fa-fw fa-eye toggle-password"> -->
                       <!--  <input id="password-field" type="password" class="form-control" name="password" value="secret"> -->
                        <span toggle="#password" class="fa fa-fw fa-eye field-icon toggle-password" onclick="tes()"></span>
                      <?php echo form_error('password', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                    <button type="submit" class="btn btn-primary btn-user btn-block">
                      Masuk
                    </button>
                    <hr>
                  </form>
                  <div class="text-center small">
                    Copyright &copy 2021 ILMea | Created by <a href="https://www.mcteknologi.com" target="_BLANK">PT. Mutiara Cemerlang Teknologi.</a>
                  </div>
                 <!--  <div class="text-center">
                    <a class="small" href="<?php echo base_url('auth/registration'); ?>">Create an Account!</a>
                  </div> -->
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

  </div>
<script type="text/javascript">
// $(".toggle-password").click(function() {
function tes(){
  $(".toggle-password").toggleClass("fa-eye fa-eye-slash");
  var input = $($(".toggle-password").attr("toggle"));
  if (input.attr("type") == "password") {
    input.attr("type", "text");
  } else {
    input.attr("type", "password");
  }
};

</script>