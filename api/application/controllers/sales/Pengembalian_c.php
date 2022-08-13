<?php
defined('BASEPATH') or exit('No direct script access allowed');

class pengembalian_c extends CI_Controller
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

        public function index($id_penjualan)
        {
            $id_penjualan2 = decrypt_url($id_penjualan);
                if ($id_penjualan2 != null) {
                        $data['datapnj'] = $this->db->query("
                    SELECT * FROM detail_surat_jalan dsj 
                    JOIN surat_jalan sj ON sj.ID_SURAT_JALAN = dsj.ID_SURAT_JALAN
                    JOIN barang b ON b.ID_BARANG = dsj.ID_BARANG
                    JOIN penjualan p ON p.ID_DETAIL_SURAT_JALAN = dsj.ID_DETAIL_SURAT_JALAN
                    JOIN pelanggan pl ON pl.ID_PELANGGAN = p.ID_PELANGGAN
                    JOIN pengembalian pmb ON pmb.ID_PENJUALAN = p.ID_PENJUALAN
                    WHERE p.ID_PENJUALAN = '$id_penjualan2'")->result();
                }
                $data['title'] = "Daftar Pengembalian";

                $data['user'] = $this->db->get_where('pengguna', ['EMAIL_PENGGUNA' => $this->session->userdata('email')])->row_array();
                $user2 = $this->db->get_where('pengguna', ['EMAIL_PENGGUNA' => $this->session->userdata('email')])->row_array();
                $idpg = $user2['ID_PENGGUNA'];
                $data['pelanggan'] = $this->db->get_where('pelanggan', ['ID_PENGGUNA' => $idpg])->result();
                $data['penjualan'] = $this->db->get_where('penjualan', ['ID_PENGGUNA' => $idpg])->result();

                $this->load->view('templates/header', $data);
                $this->load->view('templates/sidebar', $data);
                $this->load->view('templates/topbar', $data);
                $this->load->view('sales/pengembalian/all', $data);
                $this->load->view('templates/footer');
        }

        public function add($id_penjualan)
        {
            $id_penjualan2 = decrypt_url($id_penjualan);
                if ($id_penjualan2 != null) {
                        $data['datapmb'] = $this->db->query("
                    SELECT * FROM detail_surat_jalan dsj 
                    JOIN surat_jalan sj ON sj.ID_SURAT_JALAN = dsj.ID_SURAT_JALAN
                    JOIN barang b ON b.ID_BARANG = dsj.ID_BARANG
                    JOIN penjualan p ON p.ID_DETAIL_SURAT_JALAN = dsj.ID_DETAIL_SURAT_JALAN
                    JOIN pelanggan pl ON pl.ID_PELANGGAN = p.ID_PELANGGAN
                    WHERE p.ID_PENJUALAN = '$id_penjualan2'")->result();
                }
                $data['title'] = "Lakukan Pengembalian";

                $data['user'] = $this->db->get_where('pengguna', ['EMAIL_PENGGUNA' => $this->session->userdata('email')])->row_array();

                $data['penjualan'] = $this->penjualan_m->TampilData()->result();
                $data['pelanggan'] = $this->pelanggan_m->TampilData()->result();

                $this->load->view('templates/header', $data);
                $this->load->view('templates/sidebar', $data);
                $this->load->view('templates/topbar', $data);
                $this->load->view('sales/pengembalian/add', $data);
                $this->load->view('templates/footer');
        }

        public function tambah()
        {
                $data['title'] = "Tambah Data Pengembalian";
                $data['user'] = $this->db->get_where('pengguna', ['EMAIL_PENGGUNA' => $this->session->userdata('email')])->row_array();
                $id_pengguna = $data['user']['ID_PENGGUNA'];

                $data = [
                        'ID_PENJUALAN' => $this->input->post('id_penjualan'),
                        'TGL_PENGEMBALIAN' => $this->input->post('tgl_pengembalian'),
                        'JUMLAH_PENGEMBALIAN' => $this->input->post('jumlah_kembali'),
                        'KETERANGAN_PENGEMBALIAN' => $this->input->post('ket_pengembalian')
                ];

                $this->db->insert('pengembalian', $data);

                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data pengembalian berhasil ditambahkan</div>');
                redirect('sales/surat_jalan');
        }
            public function cetak($id_pengembalian)
    {
        $this->load->library('Pdf');
        $id_pengembalian2 = decrypt_url($id_pengembalian);
        // $data['user'] = $this->db->get_where('pengguna', ['EMAIL_PENGGUNA' => $this->session->userdata('email')])->row();
        $eu = $this->session->userdata('email');
        $data['user'] = $this->db->query("
                        SELECT * FROM pengguna p JOIN _perusahaan ps ON ps.ID_PERUSAHAAN = p.ID_PERUSAHAAN
                        WHERE p.EMAIL_PENGGUNA = '$eu'")->row();
        $data['pengembalian'] = $this->db->query(
            "
                SELECT * FROM pengembalian pb 
                JOIN penjualan p ON pb.ID_PENJUALAN = p.ID_PENJUALAN
                JOIN detail_surat_jalan dsj ON p.ID_DETAIL_SURAT_JALAN = dsj.ID_DETAIL_SURAT_JALAN
                JOIN barang b ON b.ID_BARANG = dsj.ID_BARANG
                JOIN pelanggan pl ON pl.ID_PELANGGAN = p.ID_PELANGGAN
                WHERE pb.ID_PENGEMBALIAN = '$id_pengembalian2'
                "
        )->row();
         $data['pengembalian2'] = $this->db->query(
            "
                SELECT * FROM pengembalian pb 
                JOIN penjualan p ON pb.ID_PENJUALAN = p.ID_PENJUALAN
                JOIN detail_surat_jalan dsj ON p.ID_DETAIL_SURAT_JALAN = dsj.ID_DETAIL_SURAT_JALAN
                JOIN barang b ON b.ID_BARANG = dsj.ID_BARANG
                JOIN satuan s ON s.ID_SATUAN = b.ID_SATUAN
                WHERE pb.ID_PENGEMBALIAN = '$id_pengembalian2'
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
        $pdf->Cell(0, 7, 'Email : '.$data['user']->EMAIL_PEMILIK.', Telp/HP : '.$data['user']->NO_HP_PEMILIK, 0, 1, 'C');
        $pdf->Cell(0, 1, '________________________________________________________________________', 0, 1, 'C');
        $pdf->SetFont('Times', '', 7);
        $pdf->Cell(0, 1, '_______________________________________________________________________________________________________', 0, 1, 'C');
        $pdf->Ln(8);

        $pdf->SetFont('Times', 'B', 14);
        $pdf->Cell(130, 7, 'SURAT PENGEMBALIAN', 0, 1, 'C');
        $pdf->Cell(20, 7, '', 0, 1);

        //$pdf->Ln(20);
        $pdf->SetFont('Times', 'B', 10);
        $pdf->Cell(30, 6, 'Nama Sales', 0, 0, 'L');
        $pdf->Cell(5, 6, ':', 0, 0, 'L');
        $pdf->Cell(30, 6, $data['user']->NAMA_PENGGUNA, 0, 0, 'L');

        $pdf->Cell(30, 6, 'Tanggal', 0, 0, 'L');
        $pdf->Cell(5, 6, ':', 0, 0, 'L');
        $pdf->Cell(30, 6, date_indo($data['pengembalian']->TGL_PENGEMBALIAN), 0, 1, 'L');

        $pdf->Cell(30, 6, 'Nama Pelanggan', 0, 0, 'L');
        $pdf->Cell(5, 6, ':', 0, 0, 'L');
        $pdf->Cell(30, 6, $data['pengembalian']->NAMA_PELANGGAN, 0, 0, 'L');

        $pdf->Cell(30, 6, 'HP Pelanggan', 0, 0, 'L');
        $pdf->Cell(5, 6, ':', 0, 0, 'L');
        $pdf->Cell(30, 6, $data['pengembalian']->NO_HP_PELANGGAN, 0, 1, 'L');

        $pdf->Cell(30, 6, 'Pembayaran', 0, 0, 'L');
        $pdf->Cell(5, 6, ':', 0, 0, 'L');
        $pdf->Cell(30, 6, $data['pengembalian']->STATUS_PEMBAYARAN_PENJUALAN, 0, 0, 'L');

        $pdf->Cell(30, 6, 'Keterangan', 0, 0, 'L');
        $pdf->Cell(5, 6, ':', 0, 0, 'L');
        $pdf->Cell(30, 6, $data['pengembalian']->KETERANGAN_PENGEMBALIAN, 0, 1, 'L');

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
        foreach ($data['pengembalian2'] as $pnj2) {
            $no++;
            $sub = $pnj2->HARGA_JUAL_BARANG * $pnj2->JUMLAH_PENGEMBALIAN;
            $pdf->Cell(10, 6, $no, 1, 0, 'C');
            $pdf->Cell(40, 6, $pnj2->NAMA_BARANG, 1, 0);
            $pdf->Cell(30, 6, $pnj2->JUMLAH_PENGEMBALIAN, 1, 0,'C');
            $pdf->Cell(20, 6, $pnj2->NAMA_SATUAN, 1, 0,'C');
            $pdf->Cell(30, 6, 'Rp. '.number_format($sub), 1, 1,'C');
            $ttl = $ttl + $sub;
        }
        $pdf->SetFont('Times', 'B', 10);
        $pdf->Cell(100, 6, 'Total ', 1, 0,'C');
        $pdf->Cell(30, 6, 'Rp. '.number_format($ttl), 1, 1,'C');

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
        $pdf->Cell(40, 6, '('.$data['user']->NAMA_PENGGUNA.')', 0, 1, 'C');


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
        $pdf->Cell(0, 7, 'Email : '.$data['user']->EMAIL_PEMILIK.', Telp/HP : '.$data['user']->NO_HP_PEMILIK, 0, 1, 'C');
        $pdf->Cell(0, 1, '________________________________________________________________________', 0, 1, 'C');
        $pdf->SetFont('Times', '', 7);
        $pdf->Cell(0, 1, '_______________________________________________________________________________________________________', 0, 1, 'C');
        $pdf->Ln(8);

        $pdf->SetFont('Times', 'B', 14);
        $pdf->Cell(130, 7, 'SURAT PENGEMBALIAN', 0, 1, 'C');
        $pdf->Cell(20, 7, '', 0, 1);

        //$pdf->Ln(20);
        $pdf->SetFont('Times', 'B', 10);
        $pdf->Cell(30, 6, 'Nama Sales', 0, 0, 'L');
        $pdf->Cell(5, 6, ':', 0, 0, 'L');
        $pdf->Cell(30, 6, $data['user']->NAMA_PENGGUNA, 0, 0, 'L');

        $pdf->Cell(30, 6, 'Tanggal', 0, 0, 'L');
        $pdf->Cell(5, 6, ':', 0, 0, 'L');
        $pdf->Cell(30, 6, date_indo($data['pengembalian']->TGL_PENGEMBALIAN), 0, 1, 'L');

        $pdf->Cell(30, 6, 'Nama Pelanggan', 0, 0, 'L');
        $pdf->Cell(5, 6, ':', 0, 0, 'L');
        $pdf->Cell(30, 6, $data['pengembalian']->NAMA_PELANGGAN, 0, 0, 'L');

        $pdf->Cell(30, 6, 'HP Pelanggan', 0, 0, 'L');
        $pdf->Cell(5, 6, ':', 0, 0, 'L');
        $pdf->Cell(30, 6, $data['pengembalian']->NO_HP_PELANGGAN, 0, 1, 'L');

        $pdf->Cell(30, 6, 'Pembayaran', 0, 0, 'L');
        $pdf->Cell(5, 6, ':', 0, 0, 'L');
        $pdf->Cell(30, 6, $data['pengembalian']->STATUS_PEMBAYARAN_PENJUALAN, 0, 0, 'L');

        $pdf->Cell(30, 6, 'Keterangan', 0, 0, 'L');
        $pdf->Cell(5, 6, ':', 0, 0, 'L');
        $pdf->Cell(30, 6, $data['pengembalian']->KETERANGAN_PENGEMBALIAN, 0, 1, 'L');

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
        foreach ($data['pengembalian2'] as $pnj2) {
            $no++;
            $sub = $pnj2->HARGA_JUAL_BARANG * $pnj2->JUMLAH_PENGEMBALIAN;
            $pdf->Cell(10, 6, $no, 1, 0, 'C');
            $pdf->Cell(40, 6, $pnj2->NAMA_BARANG, 1, 0);
            $pdf->Cell(30, 6, $pnj2->JUMLAH_PENGEMBALIAN, 1, 0,'C');
            $pdf->Cell(20, 6, $pnj2->NAMA_SATUAN, 1, 0,'C');
            $pdf->Cell(30, 6, 'Rp. '.number_format($sub), 1, 1,'C');
            $ttl = $ttl + $sub;
        }
        $pdf->SetFont('Times', 'B', 10);
        $pdf->Cell(100, 6, 'Total ', 1, 0,'C');
        $pdf->Cell(30, 6, 'Rp. '.number_format($ttl), 1, 1,'C');

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
