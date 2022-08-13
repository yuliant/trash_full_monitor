<?php

defined('BASEPATH') or exit('No direct script access allowed');



class L_pesanulang_c extends CI_Controller

{

    public function __construct()

    {

        parent::__construct();

        is_logged_in();

        $this->load->model('sales/Surat_jalan_m', 'surat_jalan_m');

        $this->load->model('gudang/Barang_m', 'barang_m');

        $this->load->model('sales/Penjualan_m', 'penjualan_m');

        $this->load->model('sales/Pelanggan_m', 'pelanggan_m');

        $this->load->model('sales/Pesan_ulang_m', 'pesan_ulang_m');

    }



    public function index()

    {

       

    }

    public function cetak()

    {

        $this->load->library('Pdf');
        $tgl = date('Y-m-d');

        $user = $this->db->get_where('pengguna', ['EMAIL_PENGGUNA' => $this->session->userdata('email')])->row();
        $id = $user->ID_PENGGUNA;
        $eu = $this->session->userdata('email');
        $data['user'] = $this->db->query("
                        SELECT * FROM pengguna p JOIN _perusahaan ps ON ps.ID_PERUSAHAAN = p.ID_PERUSAHAAN
                        WHERE p.EMAIL_PENGGUNA = '$eu'")->row();
        $pesanulang1 = $this->db->query(
                "
               SELECT * FROM pesan_ulang pu
            JOIN detail_pesan_ulang dpu ON dpu.ID_PESAN_ULANG = pu.ID_PESAN_ULANG
            JOIN pelanggan p ON p.ID_PELANGGAN = pu.ID_PELANGGAN
            JOIN pengguna pg ON pg.ID_PENGGUNA = pu.ID_PENGGUNA
            JOIN barang b ON b.ID_BARANG = dpu.ID_BARANG
            WHERE pu.ID_PENGGUNA = '$id' AND pu.TGL_PESAN_ULANG BETWEEN '$tgaw' AND '$tgak'
                "
            )->num_rows();
        if($pesanulang1 > 0){
            $pesanulang = $this->db->query(
                "
               SELECT * FROM pesan_ulang pu
            JOIN detail_pesan_ulang dpu ON dpu.ID_PESAN_ULANG = pu.ID_PESAN_ULANG
            JOIN pelanggan p ON p.ID_PELANGGAN = pu.ID_PELANGGAN
            JOIN pengguna pg ON pg.ID_PENGGUNA = pu.ID_PENGGUNA
            JOIN barang b ON b.ID_BARANG = dpu.ID_BARANG
            WHERE pu.ID_PENGGUNA = '$id' AND pu.TGL_PESAN_ULANG BETWEEN '$tgaw' AND '$tgak'
                "
            )->result();
        }else{
            $pesanulang = $this->db->query(
                "
               SELECT * FROM pesan_ulang pu
            JOIN detail_pesan_ulang dpu ON dpu.ID_PESAN_ULANG = pu.ID_PESAN_ULANG
            JOIN pelanggan p ON p.ID_PELANGGAN = pu.ID_PELANGGAN
            JOIN pengguna pg ON pg.ID_PENGGUNA = pu.ID_PENGGUNA
            JOIN barang b ON b.ID_BARANG = dpu.ID_BARANG
            WHERE pu.TGL_PESAN_ULANG BETWEEN '$tgaw' AND '$tgak'
                "
            )->result();
        }

        error_reporting(0); // AGAR ERROR MASALAH VERSI PHP TIDAK MUNCUL



        $pdf = new FPDF('P', 'mm', 'A4');

        $pdf->AddPage();



         $pdf->SetFont('Times', 'B', 16);

        $pdf->Cell(0, 7, $data['user']->NAMA_PERUSAHAAN, 0, 1, 'C');
        $pdf->SetFont('Times', '', 10);
        // $pdf->Cell(0, 7, 'Alamat : Jl. Raya Wates No.3, Kec. Tanggulangin, Kabupaten Sidoarjo', 0, 1, 'C');
        $pdf->Cell(0, 7, 'Email : '.$data['user']->EMAIL_PEMILIK.', Telp/HP : '.$data['user']->NO_HP_PEMILIK, 0, 1, 'C');
        $pdf->Cell(0, 1, '___________________________________________________________________________________________________', 0, 1, 'C');

        $pdf->SetFont('Times', '', 7);

        $pdf->Cell(0, 1, '_____________________________________________________________________________________________________________________________________________', 0, 1, 'C');

        $pdf->Ln(8);

        

        $pdf->SetFont('Times', 'B', 14);

        $pdf->Cell(0, 7, 'LAPORAN PESAN ULANG', 0, 1, 'C');

        $pdf->Cell(20, 7, '', 0, 1);



        //$pdf->Ln(20);

        $pdf->SetFont('Times', 'B', 10);

        $pdf->Cell(15, 6, 'Periode', 0, 0, 'L');

        $pdf->Cell(5, 6, ':', 0, 0, 'L');

        $pdf->Cell(30, 6, date_indo($tgaw).' - '.date_indo($tgak), 0, 1, 'L');



        $pdf->Ln(3);



        $pdf->SetFont('Times', 'B', 10);

        $pdf->Cell(10, 6, 'No', 1, 0, 'C');

        $pdf->Cell(35, 6, 'Nama Sales', 1, 0, 'C');

        $pdf->Cell(35, 6, 'Nama Pelanggan', 1, 0, 'C');

        $pdf->Cell(35, 6, 'Nama Barang', 1, 0, 'C');

        $pdf->Cell(15, 6, 'Jumlah', 1, 0, 'C');

        $pdf->Cell(30, 6, 'Pembayaran', 1, 0, 'C');

        $pdf->Cell(30, 6, 'Sub Total', 1, 1, 'C');



        $pdf->SetFont('Times', '', 10);

        $no = 0;

        $ttl = 0;

        foreach ($pesanulang as $pnj2) {

            $no++;

            $sub = $pnj2->HARGA_JUAL_BARANG * $pnj2->JUMLAH_PESAN_ULANG;

            $pdf->Cell(10, 6, $no, 1, 0, 'C');

            $pdf->Cell(35, 6, $pnj2->NAMA_PENGGUNA, 1, 0);

            $pdf->Cell(35, 6, $pnj2->NAMA_PELANGGAN, 1, 0);

            $pdf->Cell(35, 6, $pnj2->NAMA_BARANG, 1, 0);

            $pdf->Cell(15, 6, $pnj2->JUMLAH_PESAN_ULANG, 1, 0,'C');

            $pdf->Cell(30, 6, $pnj2->STATUS_PEMBAYARAN_PESAN_ULANG, 1, 0,'C');

            $pdf->Cell(30, 6, 'Rp. '.number_format($sub), 1, 1,'L');

            $ttl = $ttl + $sub;

        }

        $pdf->SetFont('Times', 'B', 10);

        $pdf->Cell(160, 6, 'Total ', 1, 0,'C');

        $pdf->Cell(30, 6, 'Rp. '.number_format($ttl), 1, 1,'L');



        $pdf->SetY(-65);

        $pdf->SetFont('Times', '', 10);

        $pdf->line($pdf->GetX(), $pdf->GetY(), $pdf->GetX(), $pdf->GetY());

        $pdf->SetY(-65);

        $pdf->SetX(0);

        $pdf->Ln(1);



        $pdf->Cell(140, 6, '', 0, 0, 'C');

        $pdf->Cell(40, 6, '' . date_indo($tgl), 0, 1, 'C');



        $pdf->SetY(-55);

        $pdf->SetFont('Times', '', 10);

        $pdf->line($pdf->GetX(), $pdf->GetY(), $pdf->GetX(), $pdf->GetY());

        $pdf->SetY(-55);

        $pdf->SetX(0);

        $pdf->Ln(1);



        $pdf->Cell(140, 6, '', 0, 0, 'C');

        $pdf->Cell(40, 6, 'Yang bertanda tangan', 0, 1, 'C');



        $pdf->SetY(-30);

        $pdf->SetFont('Times', '', 8);

        $pdf->line($pdf->GetX(), $pdf->GetY(), $pdf->GetX(), $pdf->GetY());

        $pdf->SetY(-30);

        $pdf->SetX(0);

        $pdf->Ln(1);



       

        $pdf->Cell(140, 6, '', 0, 0, 'C');

        $pdf->SetFont('Times', '', 10);

        $pdf->Cell(40, 6, '('.$user->NAMA_PENGGUNA.')', 0, 1, 'C');



        $pdf->Output();

    }

}



/* End of file Supplier_c.php */

