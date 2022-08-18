<body>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <div class="navbar-bg"></div>
      <nav class="navbar navbar-expand-lg main-navbar">
        <form class="form-inline mr-auto">
          <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
          </ul>
        </form>
        <ul class="navbar-nav navbar-right">
          <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
              <img alt="image" src="<?= base_url() ?>assets/img/avatar/avatar-6.jpg" class="rounded-circle mr-1">
              <div class="d-sm-none d-lg-inline-block">Hi, <?php echo $this->session->userdata('nm'); ?></div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
              <div class="dropdown-title"><?php echo $this->session->userdata('us'); ?></div>
              <a href="<?php echo base_url() ?>profile" class="dropdown-item has-icon">
                <i class="far fa-user"></i> Profile
              </a>
              <div class="dropdown-divider"></div>
              <a href="<?php echo base_url() ?>auth/logout" class="dropdown-item has-icon text-danger">
                <i class="fas fa-sign-out-alt"></i> Logout
              </a>
            </div>
          </li>
        </ul>
      </nav>


      <div class="main-sidebar sidebar-style-2">
        <aside id="sidebar-wrapper">

          <div class="sidebar-brand">
            <a href="<?=
                      base_url()
                      ?>">Trash Full Monitor</a>
          </div>

          <div class="sidebar-brand sidebar-brand-sm">
            <a href="<?=
                      base_url()
                      ?>">TFM</a>
          </div>

          <ul class="sidebar-menu">
            <li <?php echo $this->uri->segment(1) == 'dashboard' ? 'class="active"' : '' ?>>
              <a class="nav-link" href="<?php echo base_url() ?>dashboard">
                <i class="fas fa-book"></i> <span>Dashboard</span>
              </a>
            </li>

            <li <?php echo $this->uri->segment(1) == 'list_tugas' ? 'class="active"' : '' ?>>
              <a class="nav-link" href="<?php echo base_url() ?>list_tugas">
                <i class="fas fa-user"></i> <span>List Tugas</span>
              </a>
            </li>

            <li <?php echo $this->uri->segment(1) == 'petugas' ? 'class="active"' : '' ?>>
              <a class="nav-link" href="<?php echo base_url() ?>petugas">
                <i class="fas fa-user"></i> <span>Petugas Sampah</span>
              </a>
            </li>

            <li <?php echo $this->uri->segment(1) == 'mobil_sampah' ? 'class="active"' : '' ?>>
              <a class="nav-link" href="<?php echo base_url() ?>mobil_sampah">
                <i class="fas fa-truck-moving"></i> <span>Mobil Sampah</span>
              </a>
            </li>

            <li <?php echo $this->uri->segment(1) == 'tempat_sampah' ? 'class="active"' : '' ?>>
              <a class="nav-link" href="<?php echo base_url() ?>tempat_sampah">
                <i class="fas fa-trash-alt"></i> <span>Tempat Sampah</span>
              </a>
            </li>

          </ul>
        </aside>
      </div>