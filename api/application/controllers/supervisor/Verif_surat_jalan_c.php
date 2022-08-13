<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Verif_surat_jalan_c extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('sales/Surat_jalan_m', 'surat_jalan_m');
        $this->load->model('gudang/Barang_m', 'barang_m');
        $this->load->model('supervisor/Verif_surat_jalan_m', 'verif_surat_jalan_m');
    }

    public function index($id_surat_jalan = null)
    {
        $data['title'] = "Verifikasi Surat Jalan";
        $id_surat_jalan2 = decrypt_url($id_surat_jalan);
        if ($id_surat_jalan2 != null) {
            $data['user'] = $this->db->get_where('pengguna', ['EMAIL_PENGGUNA' => $this->session->userdata('email')])->row_array();
            $data['surat_jalan'] = $this->db->get_where('surat_jalan', ['ID_SURAT_JALAN' => $id_surat_jalan2])->row();
       
            $data['detail_surat_jalan'] = $this->db->query(
                "
                SELECT * FROM detail_surat_jalan dsj 
                JOIN barang b ON b.ID_BARANG = dsj.ID_BARANG
                WHERE dsj.ID_SURAT_JALAN = '$id_surat_jalan2'
                "
            )->result();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('supervisor/verif/detail', $data);
            $this->load->view('templates/footer');
        } else {
            $data['user'] = $this->db->get_where('pengguna', ['EMAIL_PENGGUNA' => $this->session->userdata('email')])->row_array();
            $idps = $data['user']['ID_PERUSAHAAN'];

            $data['surat_jalan'] = $this->db->query(
                "
                SELECT * FROM surat_jalan sj 
                JOIN pengguna pg ON pg.ID_PENGGUNA = sj.ID_PENGGUNA
                WHERE sj.STATUS_SURAT_JALAN = 0 AND pg.ID_PERUSAHAAN = '$idps'
                "
            )->result();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('supervisor/verif/all', $data);
            $this->load->view('templates/footer');
        }
    }

    public function verifikasi_surat_jalan($id_surat_jalan)
    {
        $id_surat_jalan2 = decrypt_url($id_surat_jalan);
        $this->verif_surat_jalan_m->VerifSuratJalan($id_surat_jalan2);

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Surat Jalan telah diverifikasi</div>');
        redirect('supervisor/verif_surat_jalan');
    }

    public function tolak_surat_jalan($id_surat_jalan)
    {
        $id_surat_jalan2 = decrypt_url($id_surat_jalan);

        $datasj = $this->db->query("
                                    SELECT * FROM surat_jalan sj 
                                    JOIN detail_surat_jalan dsj ON dsj.ID_SURAT_JALAN = sj.ID_SURAT_JALAN 
                                    WHERE dsj.ID_SURAT_JALAN = '$id_surat_jalan2'")->result();

            foreach ($datasj as $dsj) {

                $jmlbawa = $dsj->JUMLAH_BAWA;
                $idbrg = $dsj->ID_BARANG;

                $datastok = $this->db->get_where('barang', ['ID_BARANG' => $idbrg])->result();

                foreach ($datastok as $dstok) {

                    $nmbrg = $dstok->NAMA_BARANG;
                    $stoktsd = $dstok->STOK_BARANG;

                    $stokskr = $stoktsd + $jmlbawa;
                    $this->db->where('ID_BARANG', $idbrg);
                    $this->db->update('barang', ['STOK_BARANG' => $stokskr]);

                }
                $this->db->where('ID_SURAT_JALAN', $id_surat_jalan2);
                $this->db->update('detail_surat_jalan', ['JUMLAH_SISA' => 0]);
            }

        $this->verif_surat_jalan_m->TolakSuratJalan($id_surat_jalan2);


        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Surat Jalan telah ditolak</div>');
        redirect('supervisor/verif_surat_jalan');
    }
}

/* End of file Verif_surat_jalan_c.php */
