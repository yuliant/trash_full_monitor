<?php
defined('BASEPATH') or exit('No direct script access allowed');

class penjualan_c extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('sales/Surat_jalan_m', 'surat_jalan_m');
        $this->load->model('gudang/Barang_m', 'barang_m');
        $this->load->model('sales/Penjualan_m', 'penjualan_m');
        $this->load->model('sales/Pelanggan_m', 'pelanggan_m');
    }

    public function index($id_surat_jalan)
    {
        $id_surat_jalan2 = decrypt_url($id_surat_jalan);
        if ($id_surat_jalan2 != null) {
            $data['datapnj'] = $this->db->query("
                    SELECT * FROM detail_surat_jalan dsj 
                    JOIN surat_jalan sj ON sj.ID_SURAT_JALAN = dsj.ID_SURAT_JALAN
                    JOIN barang b ON b.ID_BARANG = dsj.ID_BARANG
                    JOIN penjualan p ON p.ID_DETAIL_SURAT_JALAN = dsj.ID_DETAIL_SURAT_JALAN
                    JOIN pelanggan pl ON pl.ID_PELANGGAN = p.ID_PELANGGAN
                    WHERE dsj.ID_SURAT_JALAN = '$id_surat_jalan2'")->result();
        }
        $data['title'] = "Daftar Penjualan";

        $data['user'] = $this->db->get_where('pengguna', ['EMAIL_PENGGUNA' => $this->session->userdata('email')])->row_array();
        $user2 = $this->db->get_where('pengguna', ['EMAIL_PENGGUNA' => $this->session->userdata('email')])->row_array();
        $idpg = $user2['ID_PENGGUNA'];
        $data['pelanggan'] = $this->db->get_where('pelanggan', ['ID_PENGGUNA' => $idpg])->result();
        $data['penjualan'] = $this->db->get_where('penjualan', ['ID_PENGGUNA' => $idpg])->result();
        /*$data['penjualan'] = $this->penjualan_m->TampilData()->result();
        $data['pelanggan'] = $this->pelanggan_m->TampilData()->result();*/

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('sales/penjualan/all', $data);
        $this->load->view('templates/footer');
    }

    public function add($id_detail_surat_jalan)
    {
        $id_detail_surat_jalan2 = decrypt_url($id_detail_surat_jalan);
        if ($id_detail_surat_jalan != null) {
            $data['datasj'] = $this->db->query("
                    SELECT * FROM detail_surat_jalan dsj 
                    JOIN surat_jalan sj ON sj.ID_SURAT_JALAN = dsj.ID_SURAT_JALAN
                    JOIN barang b ON b.ID_BARANG = dsj.ID_BARANG
                    WHERE dsj.ID_DETAIL_SURAT_JALAN = '$id_detail_surat_jalan2'")->result();
        }
        $data['title'] = "Lakukan Penjualan";

        $data['user'] = $this->db->get_where('pengguna', ['EMAIL_PENGGUNA' => $this->session->userdata('email')])->row_array();

        $user2 = $this->db->get_where('pengguna', ['EMAIL_PENGGUNA' => $this->session->userdata('email')])->row_array();
        $idpg = $user2['ID_PENGGUNA'];
        $data['pelanggan'] = $this->db->get_where('pelanggan', ['ID_PENGGUNA' => $idpg])->result();
        $data['penjualan'] = $this->db->get_where('penjualan', ['ID_PENGGUNA' => $idpg])->result();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('sales/penjualan/add', $data);
        $this->load->view('templates/footer');
    }

    public function tambah()
    {

        $data['title'] = "Tambah Data Surat Jalan";
        $data['user'] = $this->db->get_where('pengguna', ['EMAIL_PENGGUNA' => $this->session->userdata('email')])->row_array();
        $id_pengguna = $data['user']['ID_PENGGUNA'];

        if ($this->input->post("harga_jual") != '') {
            $data = [
                'ID_DETAIL_SURAT_JALAN' => $this->input->post('id_detail_surat_jalan'),
                'ID_PENGGUNA' => $id_pengguna,
                'ID_PELANGGAN' => $this->input->post('id_pelanggan'),
                'TGL_PENJUALAN' => $this->input->post('tgl_penjualan'),
                'JUMLAH_PENJUALAN' => $this->input->post('jumlah_jual'),
                'HARGA_PENJUALAN' => $this->input->post('harga_jual'),
                'STATUS_PEMBAYARAN_PENJUALAN' => $this->input->post('jenis_pembayaran')
            ];
        } else {
            $data = [
                'ID_DETAIL_SURAT_JALAN' => $this->input->post('id_detail_surat_jalan'),
                'ID_PENGGUNA' => $id_pengguna,
                'ID_PELANGGAN' => $this->input->post('id_pelanggan'),
                'TGL_PENJUALAN' => $this->input->post('tgl_penjualan'),
                'JUMLAH_PENJUALAN' => $this->input->post('jumlah_jual'),
                'HARGA_PENJUALAN' => '',
                'STATUS_PEMBAYARAN_PENJUALAN' => $this->input->post('jenis_pembayaran')
            ];
        }



        $this->db->insert('penjualan', $data);
        $jmlbawa = $this->input->post('jumlah_bawa');
        $jmljual = $this->input->post('jumlah_jual');
        $jmlsisa = $jmlbawa - $jmljual;
        $this->db->where('ID_DETAIL_SURAT_JALAN', $this->input->post('id_detail_surat_jalan'));
        $this->db->update('detail_surat_jalan', ['JUMLAH_SISA' => $jmlsisa]);

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data penjualan berhasil ditambahkan</div>');
        redirect('sales/surat_jalan');
    }
    public function cetak($id_penjualan)
    {
        $this->load->library('Pdf');
        $id_penjualan2 = decrypt_url($id_penjualan);
        // $data['user'] = $this->db->get_where('pengguna', ['EMAIL_PENGGUNA' => $this->session->userdata('email')])->row();
        $eu = $this->session->userdata('email');
        $data['user'] = $this->db->query("
                        SELECT * FROM pengguna p JOIN _perusahaan ps ON ps.ID_PERUSAHAAN = p.ID_PERUSAHAAN
                        WHERE p.EMAIL_PENGGUNA = '$eu'")->row();
        $data['penjualan'] = $this->db->query(
            "
                SELECT * FROM penjualan p 
                JOIN detail_surat_jalan dsj ON p.ID_DETAIL_SURAT_JALAN = dsj.ID_DETAIL_SURAT_JALAN
                JOIN barang b ON b.ID_BARANG = dsj.ID_BARANG
                JOIN pelanggan pl ON pl.ID_PELANGGAN = p.ID_PELANGGAN
                WHERE p.ID_PENJUALAN = '$id_penjualan2'
                "
        )->row();
        $data['penjualan2'] = $this->db->query(
            "
                SELECT * FROM penjualan p 
                JOIN detail_surat_jalan dsj ON p.ID_DETAIL_SURAT_JALAN = dsj.ID_DETAIL_SURAT_JALAN
                JOIN barang b ON b.ID_BARANG = dsj.ID_BARANG
                JOIN satuan s ON s.ID_SATUAN = b.ID_SATUAN
                WHERE p.ID_PENJUALAN = '$id_penjualan2'
                "
        )->result();

        //$tgls = date("Y-m-d");
        error_reporting(0); // AGAR ERROR MASALAH VERSI PHP TIDAK MUNCUL

        $pdf = new FPDF('P', 'mm', 'A5');
        $pdf->AddPage();

        $pdf->SetFont('Times', 'B', 16);
        $pdf->Cell(0, 7, $data['user']->NAMA_PERUSAHAAN, 0, 1, 'C');
        $pdf->SetFont('Times', '', 10);
        // $pdf->Cell(0, 7, 'Alamat : Jl. Raya Wates No.3, Kec. Tanggulangin, Kabupaten Sidoarjo', 0, 1, 'C');
        $pdf->Cell(0, 7, 'Email : ' . $data['user']->EMAIL_PEMILIK . ', Telp/HP : ' . $data['user']->NO_HP_PEMILIK, 0, 1, 'C');
        $pdf->Cell(0, 1, '________________________________________________________________________', 0, 1, 'C');
        $pdf->SetFont('Times', '', 7);
        $pdf->Cell(0, 1, '_______________________________________________________________________________________________________', 0, 1, 'C');
        $pdf->Ln(8);

        $pdf->SetFont('Times', 'B', 14);
        $pdf->Cell(0, 7, 'NOTA PENJUALAN', 0, 1, 'C');
        $pdf->Cell(20, 7, '', 0, 1);

        //$pdf->Ln(20);
        $pdf->SetFont('Times', 'B', 10);
        $pdf->Cell(30, 6, 'Nama Sales', 0, 0, 'L');
        $pdf->Cell(5, 6, ':', 0, 0, 'L');
        $pdf->Cell(30, 6, $data['user']->NAMA_PENGGUNA, 0, 0, 'L');

        $pdf->Cell(30, 6, 'Tanggal', 0, 0, 'L');
        $pdf->Cell(5, 6, ':', 0, 0, 'L');
        $pdf->Cell(30, 6, date_indo($data['penjualan']->TGL_PENJUALAN), 0, 1, 'L');

        $pdf->Cell(30, 6, 'Nama Pelanggan', 0, 0, 'L');
        $pdf->Cell(5, 6, ':', 0, 0, 'L');
        $pdf->Cell(30, 6, $data['penjualan']->NAMA_PELANGGAN, 0, 0, 'L');

        $pdf->Cell(30, 6, 'HP Pelanggan', 0, 0, 'L');
        $pdf->Cell(5, 6, ':', 0, 0, 'L');
        $pdf->Cell(30, 6, $data['penjualan']->NO_HP_PELANGGAN, 0, 1, 'L');

        $pdf->Cell(30, 6, 'Pembayaran', 0, 0, 'L');
        $pdf->Cell(5, 6, ':', 0, 0, 'L');
        $pdf->Cell(30, 6, $data['penjualan']->STATUS_PEMBAYARAN_PENJUALAN, 0, 1, 'L');

        $pdf->Ln(10);

        $pdf->SetFont('Times', 'B', 10);
        $pdf->Cell(10, 6, 'No', 1, 0, 'C');
        $pdf->Cell(40, 6, 'Nama Barang', 1, 0, 'C');
        $pdf->Cell(30, 6, 'Jumlah Barang', 1, 0, 'C');
        $pdf->Cell(20, 6, 'Satuan', 1, 0, 'C');
        $pdf->Cell(30, 6, 'Sub Total', 1, 1, 'C');

        $pdf->SetFont('Times', '', 10);
        $no = 0;
        $ttl = 0;
        foreach ($data['penjualan2'] as $pnj2) {
            $no++;
            $hrg = $pnj2->HARGA_PENJUALAN;
            if ($hrg > 0) {
                $sub = $hrg;
            } else {
                $sub = $pnj2->HARGA_JUAL_BARANG * $pnj2->JUMLAH_BAWA;
            }
            $pdf->Cell(10, 6, $no, 1, 0, 'C');
            $pdf->Cell(40, 6, $pnj2->NAMA_BARANG, 1, 0);
            $pdf->Cell(30, 6, $pnj2->JUMLAH_BAWA, 1, 0, 'C');
            $pdf->Cell(20, 6, $pnj2->NAMA_SATUAN, 1, 0, 'C');
            $pdf->Cell(30, 6, 'Rp. ' . number_format($sub), 1, 1, 'C');
            $ttl = $ttl + $sub;
        }
        $pdf->SetFont('Times', 'B', 10);
        $pdf->Cell(100, 6, 'Total ', 1, 0, 'C');
        $pdf->Cell(30, 6, 'Rp. ' . number_format($ttl), 1, 1, 'C');

        $pdf->SetY(-65);
        $pdf->SetFont('Times', '', 10);
        $pdf->line($pdf->GetX(), $pdf->GetY(), $pdf->GetX(), $pdf->GetY());
        $pdf->SetY(-65);
        $pdf->SetX(0);
        $pdf->Ln(1);

        // $pdf->Cell(90, 6, '', 0, 0, 'C');
        // $pdf->Cell(40, 6, 'Sidoarjo, ' . date_indo($data['penjualan']->TGL_PENJUALAN), 0, 1, 'C');

        $pdf->SetY(-55);
        $pdf->SetFont('Times', '', 10);
        $pdf->line($pdf->GetX(), $pdf->GetY(), $pdf->GetX(), $pdf->GetY());
        $pdf->SetY(-55);
        $pdf->SetX(0);
        $pdf->Ln(1);

        $pdf->Cell(90, 6, '', 0, 0, 'C');
        $pdf->Cell(40, 6, 'Sales', 0, 1, 'C');

        $pdf->SetY(-30);
        $pdf->SetFont('Times', '', 8);
        $pdf->line($pdf->GetX(), $pdf->GetY(), $pdf->GetX(), $pdf->GetY());
        $pdf->SetY(-30);
        $pdf->SetX(0);
        $pdf->Ln(1);

        $pdf->Cell(50, 6, 'LEMBAR UNTUK PELANGGAN', 1, 0, 'C');
        $pdf->Cell(40, 6, '', 0, 0, 'C');
        $pdf->SetFont('Times', '', 10);
        $pdf->Cell(40, 6, '(' . $data['user']->NAMA_PENGGUNA . ')', 0, 1, 'C');


        /*$hal = 'Page : '.$pdf->PageNo().'/{nb}' ;
        $pdf->Cell($pdf->GetStringWidth($hal ),10,$hal );   
        $datestring = date("d F Y");
        $tanggal  = 'Printed : '.date('d-m-Y  h:i-a').' ';
        $pdf->Cell($lebar-$pdf->GetStringWidth($hal )-$pdf->GetStringWidth($tanggal)-20);   
        $pdf->Cell($pdf->GetStringWidth($tanggal),10,$tanggal );*/
        $pdf->AddPage();

        $pdf->SetFont('Times', 'B', 16);
        $pdf->Cell(0, 7, $data['user']->NAMA_PERUSAHAAN, 0, 1, 'C');
        $pdf->SetFont('Times', '', 10);
        // $pdf->Cell(0, 7, 'Alamat : Jl. Raya Wates No.3, Kec. Tanggulangin, Kabupaten Sidoarjo', 0, 1, 'C');
        $pdf->Cell(0, 7, 'Email : ' . $data['user']->EMAIL_PEMILIK . ', Telp/HP : ' . $data['user']->NO_HP_PEMILIK, 0, 1, 'C');
        $pdf->Cell(0, 1, '________________________________________________________________________', 0, 1, 'C');
        $pdf->SetFont('Times', '', 7);
        $pdf->Cell(0, 1, '_______________________________________________________________________________________________________', 0, 1, 'C');
        $pdf->Ln(8);

        $pdf->SetFont('Times', 'B', 14);
        $pdf->Cell(0, 7, 'NOTA PENJUALAN', 0, 1, 'C');
        $pdf->Cell(20, 7, '', 0, 1);

        //$pdf->Ln(20);
        $pdf->SetFont('Times', 'B', 10);
        $pdf->Cell(30, 6, 'Nama Sales', 0, 0, 'L');
        $pdf->Cell(5, 6, ':', 0, 0, 'L');
        $pdf->Cell(30, 6, $data['user']->NAMA_PENGGUNA, 0, 0, 'L');

        $pdf->Cell(30, 6, 'Tanggal', 0, 0, 'L');
        $pdf->Cell(5, 6, ':', 0, 0, 'L');
        $pdf->Cell(30, 6, date_indo($data['penjualan']->TGL_PENJUALAN), 0, 1, 'L');

        $pdf->Cell(30, 6, 'Nama Pelanggan', 0, 0, 'L');
        $pdf->Cell(5, 6, ':', 0, 0, 'L');
        $pdf->Cell(30, 6, $data['penjualan']->NAMA_PELANGGAN, 0, 0, 'L');

        $pdf->Cell(30, 6, 'HP Pelanggan', 0, 0, 'L');
        $pdf->Cell(5, 6, ':', 0, 0, 'L');
        $pdf->Cell(30, 6, date_indo($data['penjualan']->NO_HP_PELANGGAN), 0, 1, 'L');

        $pdf->Cell(30, 6, 'Pembayaran', 0, 0, 'L');
        $pdf->Cell(5, 6, ':', 0, 0, 'L');
        $pdf->Cell(30, 6, $data['penjualan']->STATUS_PEMBAYARAN_PENJUALAN, 0, 1, 'L');

        $pdf->Ln(10);

        $pdf->SetFont('Times', 'B', 10);
        $pdf->Cell(10, 6, 'No', 1, 0, 'C');
        $pdf->Cell(40, 6, 'Nama Barang', 1, 0, 'C');
        $pdf->Cell(30, 6, 'Jumlah Barang', 1, 0, 'C');
        $pdf->Cell(20, 6, 'Satuan', 1, 0, 'C');
        $pdf->Cell(30, 6, 'Sub Total', 1, 1, 'C');

        $pdf->SetFont('Times', '', 10);
        $no = 0;
        $ttl = 0;
        foreach ($data['penjualan2'] as $pnj2) {
            $no++;
            $hrg = $pnj2->HARGA_PENJUALAN;
            if ($hrg > 0) {
                $sub = $hrg;
            } else {
                $sub = $pnj2->HARGA_JUAL_BARANG * $pnj2->JUMLAH_BAWA;
            }

            $pdf->Cell(10, 6, $no, 1, 0, 'C');
            $pdf->Cell(40, 6, $pnj2->NAMA_BARANG, 1, 0);
            $pdf->Cell(30, 6, $pnj2->JUMLAH_BAWA, 1, 0, 'C');
            $pdf->Cell(20, 6, $pnj2->NAMA_SATUAN, 1, 0, 'C');
            $pdf->Cell(30, 6, 'Rp. ' . number_format($sub), 1, 1, 'C');
            $ttl = $ttl + $sub;
        }
        $pdf->SetFont('Times', 'B', 10);
        $pdf->Cell(100, 6, 'Total ', 1, 0, 'C');
        $pdf->Cell(30, 6, 'Rp. ' . number_format($ttl), 1, 1, 'C');

        $pdf->SetY(-65);
        $pdf->SetFont('Times', '', 10);
        $pdf->line($pdf->GetX(), $pdf->GetY(), $pdf->GetX(), $pdf->GetY());
        $pdf->SetY(-65);
        $pdf->SetX(0);
        $pdf->Ln(1);

        // $pdf->Cell(90, 6, '', 0, 0, 'C');
        // $pdf->Cell(40, 6, 'Sidoarjo, ' . date_indo($data['penjualan']->TGL_PENJUALAN), 0, 1, 'C');

        $pdf->SetY(-55);
        $pdf->SetFont('Times', '', 10);
        $pdf->line($pdf->GetX(), $pdf->GetY(), $pdf->GetX(), $pdf->GetY());
        $pdf->SetY(-55);
        $pdf->SetX(0);
        $pdf->Ln(1);

        $pdf->Cell(90, 6, '', 0, 0, 'C');
        $pdf->Cell(40, 6, 'Supervisor', 0, 1, 'C');

        $pdf->SetY(-30);
        $pdf->SetFont('Times', '', 8);
        $pdf->line($pdf->GetX(), $pdf->GetY(), $pdf->GetX(), $pdf->GetY());
        $pdf->SetY(-30);
        $pdf->SetX(0);
        $pdf->Ln(1);

        $pdf->Cell(50, 6, 'LEMBAR UNTUK ARSIP', 1, 0, 'C');
        $pdf->Cell(40, 6, '', 0, 0, 'C');
        $pdf->SetFont('Times', '', 10);
        $pdf->Cell(40, 6, '(......................................)', 0, 1, 'C');

        $pdf->Output();
    }
}

/* End of file Supplier_c.php */
