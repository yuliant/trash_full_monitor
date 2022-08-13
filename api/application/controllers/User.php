<?php

defined('BASEPATH') or exit('No direct script access allowed');



class User extends CI_Controller

{



  public function __construct() //method untuk menerapkan seluruh fungsi didalamnya ke dalam seluruh method di controller

  {

    parent::__construct(); // syarat method

    is_logged_in();
  }



  public function index()

  {

    $data['title'] = 'Profil Saya';

    $data['user'] = $this->db->get_where('pengguna', ['EMAIL_PENGGUNA' => $this->session->userdata('email')])->row_array();



    $this->load->view('templates/header', $data);

    $this->load->view('templates/sidebar', $data);

    $this->load->view('templates/topbar', $data);

    $this->load->view('user/index', $data);

    $this->load->view('templates/footer');
  }



  public function edit()

  {

    $data['title'] = 'Ubah Profil Saya';

    /*$id = $this->session->userdata('id_hak_akses');

    $data = $this->db->query("SELECT * FROM hak_akses WHERE id_hak_akses = '$id'")->result_array();

    foreach ($data as $dt) {

      echo $name = $data['HAK_AKSES'];

    }*/

    $data['user'] = $this->db->get_where('pengguna', ['EMAIL_PENGGUNA' => $this->session->userdata('email')])->row_array();



    //validation

    $this->form_validation->set_rules('name', 'Full Name', 'required|trim');

    if ($this->form_validation->run() == false) {

      $this->load->view('templates/header', $data);

      $this->load->view('templates/sidebar', $data);

      $this->load->view('templates/topbar', $data);

      $this->load->view('user/edit', $data);

      $this->load->view('templates/footer');
    } else {

      $name = $this->input->post('name');

      $email = $this->input->post('email');



      // cek jika ada gambar

      $upload_image = $_FILES['image']['name'];

      if ($upload_image) {

        $config['allowed_types'] = 'jpg|png|jpeg';

        $config['max_size']      = '555048';

        $config['upload_path'] = './assets/img/profile/';



        $this->load->library('upload', $config);



        if ($this->upload->do_upload('image')) {

          //$old_image = $data['user']['image'];

          $old_image = $data['user']['FOTO_PENGGUNA'];

          if ($old_image != 'default.jpg') {

            unlink(FCPATH . 'assets/img/profile/' . $old_image);
          }



          $new_image = $this->upload->data('file_name');

          $this->db->set('FOTO_PENGGUNA', $new_image);
        } else {

          $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">' . $this->upload->display_errors() . '</div>');

          redirect('user');
        }
      }



      $this->db->set('NAMA_PENGGUNA', $name);

      $this->db->where('EMAIL_PENGGUNA', $email);

      $this->db->update('pengguna');



      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Profil anda berhasil diubah</div>');

      redirect('user');
    }
  }



  public function changePassword()

  {

    $data['title'] = 'Ubah Password';

    $data['user'] = $this->db->get_where('pengguna', ['EMAIL_PENGGUNA' => $this->session->userdata('email')])->row_array();



    //validation

    $this->form_validation->set_rules('current_pasword', 'Current Password', 'required|trim'); //untuk inputan dengan name="current_pasword"

    $this->form_validation->set_rules('new_pasword1', 'New Password', 'required|trim|min_length[3]|matches[new_pasword2]'); //untuk inputan dengan name="new_pasword1"

    $this->form_validation->set_rules('new_pasword2', 'Confirm New Password', 'required|trim|min_length[3]|matches[new_pasword1]'); //untuk inputan dengan name="new_pasword2"



    if ($this->form_validation->run() == false) {

      $this->load->view('templates/header', $data);

      $this->load->view('templates/sidebar', $data);

      $this->load->view('templates/topbar', $data);

      $this->load->view('user/changepassword', $data);

      $this->load->view('templates/footer');
    } else {

      $current_password = $this->input->post('current_pasword');

      $new_password = $this->input->post('new_pasword1');

      if (!password_verify($current_password, $data['user']['PASSWORD_PENGGUNA'])) {

        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Password saat ini salah.</div>');

        redirect('user/changepassword');
      } else {

        if ($current_password == $new_password) {

          $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Password baru tidak boleh sama dengan password lama</div>');

          redirect('user/changepassword');
        } else {

          //password yang benar

          $password_hash = password_hash($new_password, PASSWORD_DEFAULT);



          //update password

          $this->db->set('PASSWORD_PENGGUNA', $password_hash);

          $this->db->where('EMAIL_PENGGUNA', $this->session->userdata('email'));

          $this->db->update('pengguna');



          $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Password berhasil diganti.</div>');

          redirect('user/changepassword');
        }
      }
    }
  }
}
