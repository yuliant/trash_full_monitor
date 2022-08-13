<?php

function is_logged_in(){
  $ci = get_instance(); // instansiasi CI untuk helper agar this dapat digunakan
  if (!$ci->session->userdata('email')) {
    redirect('auth');
  }else {
    $role_id = $ci->session->userdata('id_hak_akses');
    $menu = $ci->uri->segment(1); //untuk menentukan menu yang diakses dari url

    $queryMenu = $ci->db->get_where('menu_pengguna', ['MENU_PENGGUNA' => $menu])->row_array();
    $menu_id = $queryMenu['ID_MENU_PENGGUNA']; //mengambil id dari user_menu

    $userAccess = $ci->db->get_where('menu_hak_akses', [
      'ID_HAK_AKSES' => $role_id,
      'ID_MENU_PENGGUNA' => $menu_id
    ]);

    if ($userAccess->num_rows() < 1) {
      redirect('auth/blocked');
    }
  }
}

function check_access($role_id, $menu_id){
  $ci = get_instance(); // instansiasi CI untuk helper agar semua library CI dapat digunakan

  $ci->db->where('ID_HAK_AKSES', $role_id);
  $ci->db->where('ID_MENU_PENGGUNA', $menu_id);
  $result = $ci->db->get('menu_hak_akses');

  if ($result->num_rows() > 0) {
    return "checked = 'checked' ";
  }
}
