<?php

defined('BASEPATH') or exit('No direct script access allowed');



class Verif_pesan_ulang_c extends CI_Controller

{

    public function __construct()

    {

        parent::__construct();

        is_logged_in();

        $this->load->model('sales/Surat_jalan_m', 'surat_jalan_m');

        $this->load->model('sales/Pesan_ulang_m', 'pesan_ulang_m');

        $this->load->model('gudang/Barang_m', 'barang_m');

        $this->load->model('supervisor/Verif_surat_jalan_m', 'verif_surat_jalan_m');

        $this->load->model('supervisor/Verif_pesan_ulang_m', 'verif_pesan_ulang_m');

    }



    public function index($id_pesan_ulang = null)

    {

        $data['title'] = "Verifikasi Pesan Ulang";

        $id_pesan_ulang2 = decrypt_url($id_pesan_ulang);

        if ($id_pesan_ulang2 != null) {

            $data['user'] = $this->db->get_where('pengguna', ['EMAIL_PENGGUNA' => $this->session->userdata('email')])->row_array();

            $data['pesan_ulang'] = $this->db->query(

                "

                SELECT * FROM pesan_ulang pu 

                JOIN pelanggan p ON p.ID_PELANGGAN = pu.ID_PELANGGAN

                WHERE pu.ID_PESAN_ULANG = '$id_pesan_ulang2'

                "

            )->row();

            $data['detail_pesan_ulang'] = $this->db->query(

                "

                SELECT * FROM detail_pesan_ulang dpu 

                JOIN barang b ON b.ID_BARANG = dpu.ID_BARANG

                WHERE dpu.ID_PESAN_ULANG = '$id_pesan_ulang2'

                "

            )->result();

            $this->load->view('templates/header', $data);

            $this->load->view('templates/sidebar', $data);

            $this->load->view('templates/topbar', $data);

            $this->load->view('supervisor/verif_pu/detail', $data);

            $this->load->view('templates/footer');

        } else {

            $data['user'] = $this->db->get_where('pengguna', ['EMAIL_PENGGUNA' => $this->session->userdata('email')])->row_array();
            $idps = $data['user']['ID_PERUSAHAAN'];

             $data['pesan_ulang'] = $this->db->query(

                "

                SELECT * FROM pesan_ulang pu 

                JOIN pelanggan p ON p.ID_PELANGGAN = pu.ID_PELANGGAN

                JOIN pengguna pg ON pg.ID_PENGGUNA = pu.ID_PENGGUNA

                WHERE pu.STATUS_PESAN_ULANG = 0 AND pg.ID_PERUSAHAAN = '$idps'

                "

            )->result();



            $this->load->view('templates/header', $data);

            $this->load->view('templates/sidebar', $data);

            $this->load->view('templates/topbar', $data);

            $this->load->view('supervisor/verif_pu/all', $data);

            $this->load->view('templates/footer');

        }

    }



    public function verifikasi_pesan_ulang($id_pesan_ulang)

    {

        $id_pesan_ulang2 = decrypt_url($id_pesan_ulang);

        $this->verif_pesan_ulang_m->VerifPesanUlang($id_pesan_ulang2);

        $data = $this->db->query("SELECT * FROM detail_pesan_ulang WHERE ID_PESAN_ULANG = '$id_pesan_ulang2'")->result();
        foreach ($data as $dt) {
            $idbrg = $dt->ID_BARANG;
            $jml = $dt->JUMLAH_PESAN_ULANG;
            $data2 = $this->db->query("SELECT * FROM barang WHERE ID_BARANG = '$idbrg'")->result();
            foreach ($data2 as $dt2) {
                $jmlst = $dt2->STOK_BARANG;
            }
            
            if ($jml > $jmlst) {

                    $this->session->set_flashdata('message', '<div class="alert alert-warning" role="alert">Stok barang tidak memenuhi.</div>');
                    redirect('supervisor/verif_surat_jalan');
                } else {

                    $jmlskr = $jmlst-$jml;

                    $this->db->where('ID_BARANG', $idbrg);
                    $this->db->update('barang', ['STOK_BARANG' => $jmlskr]);
                }
        }


        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Pesan Ulang telah diverifikasi</div>');

        redirect('supervisor/verif_pesan_ulang');

    }



    public function tolak_pesan_ulang($id_pesan_ulang)

    {

        $id_pesan_ulang2 = decrypt_url($id_pesan_ulang);



        $this->verif_pesan_ulang_m->TolakPesanUlang($id_pesan_ulang2);





        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Pesan Ulang telah ditolak</div>');

        redirect('supervisor/verif_pesan_ulang');

    }

}



/* End of file Verif_surat_jalan_c.php */

