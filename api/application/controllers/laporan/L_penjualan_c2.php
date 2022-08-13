<?php
defined('BASEPATH') or exit('No direct script access allowed');

class L_penjualan_c2 extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('sales/Surat_jalan_m', 'surat_jalan_m');
        $this->load->model('gudang/Barang_m', 'barang_m');
        $this->load->model('sales/Penjualan_m', 'penjualan_m');
        $this->load->model('sales/Pelanggan_m', 'pelanggan_m');
    }

    public function index()
    {
        
    }


    public function cetak()
    {
        $this->load->library('Pdf');
        //$tgaw = $this->input->get('tgaw');
        //$tgak = $this->input->get('tgak');
        $tgaw = '2020-01-01';
        $tgak = '2021-01-01';
        $tgl = date('Y-m-d');
        $user = $this->db->get_where('pengguna', ['EMAIL_PENGGUNA' => $this->session->userdata('email')])->row();
        $id = $user->ID_PENGGUNA;
        $eu = $this->session->userdata('email');
        $data['user'] = $this->db->query("
                        SELECT * FROM pengguna p JOIN _perusahaan ps ON ps.ID_PERUSAHAAN = p.ID_PERUSAHAAN
                        WHERE p.EMAIL_PENGGUNA = '$eu'")->row();
        $datapnj1 = $this->db->query(
                "
                SELECT * FROM penjualan pj
                JOIN detail_surat_jalan dsj ON dsj.ID_DETAIL_SURAT_JALAN = pj.ID_DETAIL_SURAT_JALAN
                JOIN pelanggan p ON p.ID_PELANGGAN = pj.ID_PELANGGAN
                JOIN pengguna pg ON pg.ID_PENGGUNA = pj.ID_PENGGUNA
                JOIN barang b ON b.ID_BARANG = dsj.ID_BARANG
                WHERE pj.ID_PENGGUNA = '$id' AND pj.TGL_PENJUALAN BETWEEN '$tgaw' AND '$tgak'
                "
            )->num_rows();
        if($datapnj1 > 0){
            $datapnj = $this->db->query(
                "
                SELECT * FROM penjualan pj
                JOIN detail_surat_jalan dsj ON dsj.ID_DETAIL_SURAT_JALAN = pj.ID_DETAIL_SURAT_JALAN
                JOIN pelanggan p ON p.ID_PELANGGAN = pj.ID_PELANGGAN
                JOIN pengguna pg ON pg.ID_PENGGUNA = pj.ID_PENGGUNA
                JOIN barang b ON b.ID_BARANG = dsj.ID_BARANG
                WHERE pj.ID_PENGGUNA = '$id' AND pj.TGL_PENJUALAN BETWEEN '$tgaw' AND '$tgak'
                "
            )->result();
        }else{
            $datapnj = $this->db->query(
                "
                SELECT * FROM penjualan pj
                JOIN detail_surat_jalan dsj ON dsj.ID_DETAIL_SURAT_JALAN = pj.ID_DETAIL_SURAT_JALAN
                JOIN pelanggan p ON p.ID_PELANGGAN = pj.ID_PELANGGAN
                JOIN pengguna pg ON pg.ID_PENGGUNA = pj.ID_PENGGUNA
                JOIN barang b ON b.ID_BARANG = dsj.ID_BARANG
                WHERE pj.TGL_PENJUALAN BETWEEN '$tgaw' AND '$tgak'
                "
            )->result();
        }
        
        //$tgls = date("Y-m-d");
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
        $pdf->Cell(0, 7, 'LAPORAN PENJUALAN', 0, 1, 'C');
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
        foreach ($datapnj as $pnj2) {
            $no++;
            $sub = $pnj2->HARGA_JUAL_BARANG * $pnj2->JUMLAH_PENJUALAN;
            $pdf->Cell(10, 6, $no, 1, 0, 'C');
            $pdf->Cell(35, 6, $pnj2->NAMA_PENGGUNA, 1, 0);
            $pdf->Cell(35, 6, $pnj2->NAMA_PELANGGAN, 1, 0);
            $pdf->Cell(35, 6, $pnj2->NAMA_BARANG, 1, 0);
            $pdf->Cell(15, 6, $pnj2->JUMLAH_PENJUALAN, 1, 0,'C');
            $pdf->Cell(30, 6, $pnj2->STATUS_PEMBAYARAN_PENJUALAN, 1, 0,'C');
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

    // public function cetakg($dt = null)
    // {
    //     $this->load->library('Pdf');
    //     $tgaw_no_conv = substr($dt,0,10);
    //     $tgak_no_conv = substr($dt,10,10);
    //     $tgaw = date("Y-m-d", strtotime($tgaw_no_conv));
    //     $tgak = date("Y-m-d", strtotime($tgak_no_conv));
    //     $id = substr($dt,20);
    //     $tgl = date('Y-m-d');
    //     $datapnj = $this->db->query(
    //             "
    //             SELECT * FROM penjualan pj
    //             JOIN detail_surat_jalan dsj ON dsj.ID_DETAIL_SURAT_JALAN = pj.ID_DETAIL_SURAT_JALAN
    //             JOIN pelanggan p ON p.ID_PELANGGAN = pj.ID_PELANGGAN
    //             JOIN pengguna pg ON pg.ID_PENGGUNA = pj.ID_PENGGUNA
    //             JOIN barang b ON b.ID_BARANG = dsj.ID_BARANG
    //             WHERE pj.ID_PENGGUNA = '$id' AND pj.TGL_PENJUALAN BETWEEN '$tgaw' AND '$tgak'
    //             "
    //         )->result();
    //     error_reporting(0); // AGAR ERROR MASALAH VERSI PHP TIDAK MUNCUL

    //     $pdf = new FPDF('L', 'mm', 'A4');
    //     $pdf->AddPage();

    //      $pdf->SetFont('Times', 'B', 16);
    //     $pdf->Cell(0, 7, 'MUTIARA CEMERLANG TEKNOLOGI', 0, 1, 'C');
    //     $pdf->SetFont('Times', '', 10);
    //     $pdf->Cell(0, 7, 'Alamat : Jl. Raya Wates No.3, Kec. Tanggulangin, Kabupaten Sidoarjo', 0, 1, 'C');
    //     $pdf->Cell(0, 7, 'Email : info@mutiaract.com, Telp/HP : 082328382002', 0, 1, 'C');
    //     $pdf->Cell(0, 1, '___________________________________________________________________________________________________', 0, 1, 'C');
    //     $pdf->SetFont('Times', '', 7);
    //     $pdf->Cell(0, 1, '_____________________________________________________________________________________________________________________________________________', 0, 1, 'C');
    //     $pdf->Ln(8);
        
    //     $pdf->SetFont('Times', 'B', 14);
    //     $pdf->Cell(0, 7, 'LAPORAN PENJUALAN', 0, 1, 'C');
    //     $pdf->Cell(20, 7, '', 0, 1);

    //     //$pdf->Ln(20);
    //     $pdf->SetFont('Times', 'B', 10);
    //     $pdf->Cell(15, 6, 'Periode', 0, 0, 'L');
    //     $pdf->Cell(5, 6, ':', 0, 0, 'L');
    //     $pdf->Cell(30, 6, date_indo($tgaw).' - '.date_indo($tgak), 0, 1, 'L');

    //     $pdf->Ln(3);

    //     $pdf->SetFont('Times', 'B', 10);
    //     $pdf->Cell(10, 6, 'No', 1, 0, 'C');
    //     $pdf->Cell(35, 6, 'Nama Sales', 1, 0, 'C');
    //     $pdf->Cell(35, 6, 'Nama Pelanggan', 1, 0, 'C');
    //     $pdf->Cell(35, 6, 'Nama Barang', 1, 0, 'C');
    //     $pdf->Cell(15, 6, 'Jumlah', 1, 0, 'C');
    //     $pdf->Cell(25, 6, 'Pembayaran', 1, 0, 'C');
    //     $pdf->Cell(30, 6, 'Harga Pokok', 1, 0, 'C');
    //     $pdf->Cell(30, 6, 'Harga Jual', 1, 0, 'C');
    //     $pdf->Cell(30, 6, 'Sub Total', 1, 0, 'C');
    //     $pdf->Cell(30, 6, 'Keuntungan', 1, 1, 'C');

    //     $pdf->SetFont('Times', '', 10);
    //     $no = 0;
    //     $ttl = 0;
    //     $ttl2 = 0;
    //     $ttl3 = 0;
    //     $ttl4 = 0;
    //     foreach ($datapnj as $pnj2) {
    //         $no++;
    //         $sub = $pnj2->HARGA_JUAL_BARANG * $pnj2->JUMLAH_PENJUALAN;
    //         $sub2 = $pnj2->HARGA_BELI_BARANG * $pnj2->JUMLAH_PENJUALAN;
    //         $sub3 = $sub-$sub2;
    //         $pdf->Cell(10, 6, $no, 1, 0, 'C');
    //         $pdf->Cell(35, 6, $pnj2->NAMA_PENGGUNA, 1, 0);
    //         $pdf->Cell(35, 6, $pnj2->NAMA_PELANGGAN, 1, 0);
    //         $pdf->Cell(35, 6, $pnj2->NAMA_BARANG, 1, 0);
    //         $pdf->Cell(15, 6, $pnj2->JUMLAH_PENJUALAN, 1, 0,'C');
    //         $pdf->Cell(25, 6, $pnj2->STATUS_PEMBAYARAN_PENJUALAN, 1, 0,'C');
    //         $pdf->Cell(30, 6, 'Rp. '.number_format($pnj2->HARGA_BELI_BARANG), 1, 0,'L');
    //         $pdf->Cell(30, 6, 'Rp. '.number_format($pnj2->HARGA_JUAL_BARANG), 1, 0,'L');
    //         $pdf->Cell(30, 6, 'Rp. '.number_format($sub), 1, 0,'L');
    //         $pdf->Cell(30, 6, 'Rp. '.number_format($sub3), 1, 1,'L');
    //         $ttl = $ttl + $pnj2->HARGA_BELI_BARANG;
    //         $ttl2 = $ttl2 + $pnj2->HARGA_JUAL_BARANG;
    //         $ttl3 = $ttl3 + $sub;
    //         $ttl4 = $ttl4 + $sub3;
    //     }
    //     $pdf->SetFont('Times', 'B', 10);
    //     $pdf->Cell(215, 6, 'Total ', 1, 0,'C');
    //     /*$pdf->Cell(30, 6, 'Rp. '.number_format($ttl), 1, 0,'L');
    //     $pdf->Cell(30, 6, 'Rp. '.number_format($ttl2), 1, 0,'L');*/
    //     $pdf->Cell(30, 6, 'Rp. '.number_format($ttl3), 1, 0,'L');
    //     $pdf->Cell(30, 6, 'Rp. '.number_format($ttl4), 1, 1,'L');

    //     /*$pdf->SetY(-35);
    //     $pdf->SetFont('Times', '', 10);
    //     $pdf->line($pdf->GetX(), $pdf->GetY(), $pdf->GetX(), $pdf->GetY());
    //     $pdf->SetY(-35);
    //     $pdf->SetX(0);
    //     $pdf->Ln(1);

    //     $pdf->Cell(230, 6, '', 0, 0, 'C');
    //     $pdf->Cell(40, 6, 'Sidoarjo, ' . date_indo($tgl), 0, 1, 'C');

    //     $pdf->SetY(-25);
    //     $pdf->SetFont('Times', '', 10);
    //     $pdf->line($pdf->GetX(), $pdf->GetY(), $pdf->GetX(), $pdf->GetY());
    //     $pdf->SetY(-25);
    //     $pdf->SetX(0);
    //     $pdf->Ln(1);

    //     $pdf->Cell(140, 6, '', 0, 0, 'C');
    //     $pdf->Cell(40, 6, 'Yang bertanda tangan', 0, 1, 'C');

    //     $pdf->SetY(-30);
    //     $pdf->SetFont('Times', '', 8);
    //     $pdf->line($pdf->GetX(), $pdf->GetY(), $pdf->GetX(), $pdf->GetY());
    //     $pdf->SetY(-30);
    //     $pdf->SetX(0);
    //     $pdf->Ln(1);

       
    //     $pdf->Cell(140, 6, '', 0, 0, 'C');
    //     $pdf->SetFont('Times', '', 10);
    //     $pdf->Cell(40, 6, '('.$user->NAMA_PENGGUNA.')', 0, 1, 'C');*/

    //     $pdf->Output();
    // }
}

/* End of file Supplier_c.php */
