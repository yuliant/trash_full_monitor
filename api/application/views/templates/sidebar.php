<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

  <!-- Sidebar - Brand -->
  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
    <div class="sidebar-brand-icon rotate-n-0">
       <!--<i class="fas fa-map-marker"> </i>&nbsp-->
      
    </div>
    <img class="sidebar-brand-text" src="<?php echo base_url('assets/img/Logo Ilmea Putih.svg');?>" height="45px">
    <!--<div class="sidebar-brand-text mx-2" style="font-size: 24px">COS</div>-->
  </a>

  <!-- Divider -->
  <hr class="sidebar-divider">

  <!-- Query menu -->
  <?php
  $role_id = $this->session->userdata('id_hak_akses');
  $queryMenu = "SELECT menu_pengguna.ID_MENU_PENGGUNA, MENU_PENGGUNA
                      FROM menu_pengguna JOIN menu_hak_akses
                      ON menu_pengguna.ID_MENU_PENGGUNA = menu_hak_akses.ID_MENU_PENGGUNA
                      WHERE menu_hak_akses.ID_HAK_AKSES = $role_id
                      ORDER BY menu_hak_akses.ID_HAK_AKSES ASC ";
  $menu = $this->db->query($queryMenu)->result_array();
  ?>

  <!-- Looping Menu -->
  <?php foreach ($menu as $m) : ?>
    <div class="sidebar-heading">
      <?php 
      if($m['MENU_PENGGUNA'] == 'User'){
        echo 'Pengguna';
        }else{
        echo $m['MENU_PENGGUNA'];
        }?>
    </div>

    <!-- Siapkan sublink sesuai menu -->
    <?php
    $menuId = $m['ID_MENU_PENGGUNA'];
    /*$querySubMenu = "SELECT *
                    FROM user_sub_menu JOIN user_menu
                    ON user_sub_menu.menu_id = user_menu.id
                    WHERE user_sub_menu.menu_id = $menuId
                    AND user_sub_menu.is_active = 1 ";*/

    // bisa pakai ini atau yang diatasnya

    $querySubMenu = "SELECT *
                                  FROM sub_menu_pengguna
                                  WHERE ID_MENU_PENGGUNA = $menuId
                                  AND STATUS_AKTIF_SUB_MENU_PENGGUNA = 1 ";
    $subMenu = $this->db->query($querySubMenu)->result_array();
    ?>

    <?php foreach ($subMenu as $sm) : ?>
      <!-- Nav Item - Dashboard -->
      <?php if ($title == $sm['JUDUL_SUB_MENU_PENGGUNA']) : ?>
        <li class="nav-item active">
        <?php else : ?>
        <li class="nav-item">
        <?php endif; ?>
        <a class="nav-link pb-0" href="<?php echo base_url($sm['URL_SUB_MENU_PENGGUNA']); ?>">
          <i class="<?php echo $sm['GAMBAR_SUB_MENU_PENGGUNA']; ?>"></i>
          <span><?php echo $sm['JUDUL_SUB_MENU_PENGGUNA']; ?></span></a>
        </li>
      <?php endforeach; ?>

      <!-- Divider -->
      <hr class="sidebar-divider mt-3">
    <?php endforeach; ?>

    <!-- Nav Item - Logout -->
    <li class="nav-item">
      <a class="nav-link" href="<?php echo base_url('auth/logout'); ?>">
        <i class="fas fa-fw fa-sign-out-alt"></i>
        <span>Keluar</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
      <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->