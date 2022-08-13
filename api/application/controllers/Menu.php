<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends CI_Controller {

  public function __construct() //method untuk menerapkan seluruh fungsi didalamnya ke dalam seluruh method di controller
	{
		parent::__construct(); // syarat method
		is_logged_in();
	}

  public function index(){
    $data['title'] = 'Manajemen Menu';
    $data['user'] = $this->db->get_where('pengguna', ['EMAIL_PENGGUNA'=> $this->session->userdata('email')])->row_array();

    //query get table user_menu
    $data['menu'] = $this->db->get('menu_pengguna')->result_array();

    //validation menu
    $this->form_validation->set_rules('menu', 'Menu', 'required|trim');
    if ($this->form_validation->run() == false) {
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('menu/index',$data);
      $this->load->view('templates/footer');
    }else {
      $this->db->insert('menu_pengguna', ['MENU_PENGGUNA' => $this->input->post('menu')]);
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Menu Berhasil Ditambahkan</div>');
			redirect('menu');
    }
  }

  public function submenu(){
    $data['title'] = 'Menajemen Sub Menu';
    $data['user'] = $this->db->get_where('pengguna', ['EMAIL_PENGGUNA'=> $this->session->userdata('email')])->row_array();

    //menggunkan model untuk melakukan join 2 tabel
    $this->load->model('Menu_model', 'menu');
    $data['subMenu'] = $this->menu->getSubMenu();

    //mengirim tabel menu untuk combo box di modal
    $data['menu'] = $this->db->get('menu_pengguna')->result_array();

    //validation menu
    $this->form_validation->set_rules('title', 'Title', 'required|trim');
    $this->form_validation->set_rules('menu_id', 'Menu', 'required|trim');
    $this->form_validation->set_rules('url', 'URL', 'required|trim');
    $this->form_validation->set_rules('icon', 'icon', 'required|trim');

    if ($this->form_validation->run() == false) {
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('menu/submenu',$data);
      $this->load->view('templates/footer');
    }else {
      $data = [
        'JUDUL_SUB_MENU_PENGGUNA' => $this->input->post('title'),
        'ID_MENU_PENGGUNA' => $this->input->post('menu_id'),
        'URL_SUB_MENU_PENGGUNA' => $this->input->post('url'),
        'GAMBAR_SUB_MENU_PENGGUNA' => $this->input->post('icon'),
        'STATUS_AKTIF_SUB_MENU_PENGGUNA' => $this->input->post('is_active')
      ];
      $this->db->insert('sub_menu_pengguna', $data);
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Sub Menu Berhasil Ditambahkan.</div>');
			redirect('menu/submenu');
    }
  }

  public function deleteSubmenu($id){
    $data['user'] = $this->db->get_where('pengguna', ['EMAIL_PENGGUNA'=> $this->session->userdata('email')])->row_array();

    $this->load->model('Menu_model', 'menu');
    $this->menu->deleteSubmenu($id);

    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Submenu has been delete</div>');
    redirect('menu/submenu');
  }


  // public function editSubmenu($id){
  //
  // }

}
