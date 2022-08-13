<?php
defined('BASEPATH') or exit('No direct script access allowed');

class L_pengembalian_c extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('sales/Surat_jalan_m', 'surat_jalan_m');
        $this->load->model('gudang/Barang_m', 'barang_m');
        $this->load->model('sales/Penjualan_m', 'penjualan_m');
        $this->load->model('sales/Pengembalian_m', 'pengembalian_m');
        $this->load->model('sales/Pelanggan_m', 'pelanggan_m');
    }

    public function index()
    {
        $data['title'] = "Laporan Pengembalian";

        $data['user'] = $this->db->get_where('pengguna', ['EMAIL_PENGGUNA' => $this->session->userdata('email')])->row_array();

        $data['pengembalian'] = $this->penjualan_m->TampilData()->result();
        $data['pelanggan'] = $this->pelanggan_m->TampilData()->result();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('laporan/pengembalian', $data);
        $this->load->view('templates/footer');
    }

    public function view()
    {
        $tgaw = $this->input->post('tgaw');
        $tgak = $this->input->post('tgak');
        /*$datapnj = $this->db->query(
            "
            SELECT * FROM penjualan pj
            JOIN detail_surat_jalan dsj ON dsj.ID_DETAIL_SURAT_JALAN = pj.ID_DETAIL_SURAT_JALAN
            JOIN pelanggan p ON p.ID_PELANGGAN = pj.ID_PELANGGAN
            JOIN pengguna pg ON pg.ID_PENGGUNA = pj.ID_PENGGUNA
            JOIN barang b ON b.ID_BARANG = dsj.ID_BARANG
            JOIN pengembalian pb ON pb.ID_PENJUALAN = pj.ID_PENJUALAN
            WHERE pb.TGL_PENGEMBALIAN BETWEEN '$tgaw' AND '$tgak'
            "
        )->result();*/
        $user = $this->db->get_where('pengguna', ['EMAIL_PENGGUNA' => $this->session->userdata('email')])->row();
        $eu = $this->session->userdata('email');
        $data['user'] = $this->db->query("
                        SELECT * FROM pengguna p JOIN _perusahaan ps ON ps.ID_PERUSAHAAN = p.ID_PERUSAHAAN
                        WHERE p.EMAIL_PENGGUNA = '$eu'")->row();
        $id = $data['user']->ID_PENGGUNA;
        $datapnj1 = $this->db->query(
                "
               SELECT * FROM penjualan pj
            JOIN detail_surat_jalan dsj ON dsj.ID_DETAIL_SURAT_JALAN = pj.ID_DETAIL_SURAT_JALAN
            JOIN pelanggan p ON p.ID_PELANGGAN = pj.ID_PELANGGAN
            JOIN pengguna pg ON pg.ID_PENGGUNA = pj.ID_PENGGUNA
            JOIN barang b ON b.ID_BARANG = dsj.ID_BARANG
            JOIN pengembalian pb ON pb.ID_PENJUALAN = pj.ID_PENJUALAN
            WHERE pj.ID_PENGGUNA = '$id' AND pb.TGL_PENGEMBALIAN BETWEEN '$tgaw' AND '$tgak'
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
            JOIN pengembalian pb ON pb.ID_PENJUALAN = pj.ID_PENJUALAN
            WHERE pj.ID_PENGGUNA = '$id' AND pb.TGL_PENGEMBALIAN BETWEEN '$tgaw' AND '$tgak'
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
            JOIN pengembalian pb ON pb.ID_PENJUALAN = pj.ID_PENJUALAN
            WHERE pb.TGL_PENGEMBALIAN BETWEEN '$tgaw' AND '$tgak'
                "
            )->result();
        }
    ?>
    <div class="col-lg-12 col-sm-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Data Pengembalian</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama Pelanggan</th>
                                <th>Nama Sales</th>
                                <th>Tanggal Pengembalian</th>
                                <th>Nama Barang</th>
                                <th>Jumlah Kembali</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            foreach ($datapnj as $dpj) : ?>
                                <tr>
                                    <td><?php echo $i ?></td>
                                    <td><?php echo $dpj->NAMA_PELANGGAN ?></td>
                                    <td><?php echo $dpj->NAMA_PENGGUNA ?></td>
                                    <td><?php echo date_indo($dpj->TGL_PENGEMBALIAN) ?></td>
                                    <td><?php echo $dpj->NAMA_BARANG ?></td>
                                    <td><?php echo $dpj->JUMLAH_PENGEMBALIAN ?></td>
                                    <td><?php echo $dpj->KETERANGAN_PENGEMBALIAN ?></td>
                                </tr>
                            <?php
                                $i++;
                            endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <div class="text-right">
                    <button class="btn btn-success mr-1" type="submit">Cetak Data</button>
                </div>
            </div>
        </div>
    </div>

        
    <?php
    }

    public function cetak()
    {
        $this->load->library('Pdf');
        $tgaw = $this->input->post('tgaw');
        $tgak = $this->input->post('tgak');
        $tgl = date('Y-m-d');
        /*$data['pengembalian2'] = $this->db->query(
            "
            SELECT * FROM penjualan pj
            JOIN detail_surat_jalan dsj ON dsj.ID_DETAIL_SURAT_JALAN = pj.ID_DETAIL_SURAT_JALAN
            JOIN pelanggan p ON p.ID_PELANGGAN = pj.ID_PELANGGAN
            JOIN pengguna pg ON pg.ID_PENGGUNA = pj.ID_PENGGUNA
            JOIN barang b ON b.ID_BARANG = dsj.ID_BARANG
            JOIN satuan s ON s.ID_SATUAN = b.ID_SATUAN
            JOIN pengembalian pb ON pb.ID_PENJUALAN = pj.ID_PENJUALAN
            WHERE pb.TGL_PENGEMBALIAN BETWEEN '$tgaw' AND '$tgak'
            "
        )->result();
        $data['user'] = $this->db->get_where('pengguna', ['EMAIL_PENGGUNA' => $this->session->userdata('email')])->row();
        $data['pengembalian'] = $this->db->query(
            "
                SELECT * FROM penjualan p 
                JOIN detail_surat_jalan dsj ON p.ID_DETAIL_SURAT_JALAN = dsj.ID_DETAIL_SURAT_JALAN
                JOIN barang b ON b.ID_BARANG = dsj.ID_BARANG
                JOIN pelanggan pl ON pl.ID_PELANGGAN = p.ID_PELANGGAN
                "
        )->row();*/
        $user = $this->db->get_where('pengguna', ['EMAIL_PENGGUNA' => $this->session->userdata('email')])->row();
        $id = $user->ID_PENGGUNA;
        $eu = $this->session->userdata('email');
        $data['user'] = $this->db->query("
                        SELECT * FROM pengguna p JOIN _perusahaan ps ON ps.ID_PERUSAHAAN = p.ID_PERUSAHAAN
                        WHERE p.EMAIL_PENGGUNA = '$eu'")->row();
        $pengembalian1 = $this->db->query(
                "
               SELECT * FROM penjualan pj
            JOIN detail_surat_jalan dsj ON dsj.ID_DETAIL_SURAT_JALAN = pj.ID_DETAIL_SURAT_JALAN
            JOIN pelanggan p ON p.ID_PELANGGAN = pj.ID_PELANGGAN
            JOIN pengguna pg ON pg.ID_PENGGUNA = pj.ID_PENGGUNA
            JOIN barang b ON b.ID_BARANG = dsj.ID_BARANG
            JOIN pengembalian pb ON pb.ID_PENJUALAN = pj.ID_PENJUALAN
            WHERE pj.ID_PENGGUNA = '$id' AND pb.TGL_PENGEMBALIAN BETWEEN '$tgaw' AND '$tgak'
                "
            )->num_rows();
        if($pengembalian1 > 0){
            $pengembalian = $this->db->query(
                "
               SELECT * FROM penjualan pj
            JOIN detail_surat_jalan dsj ON dsj.ID_DETAIL_SURAT_JALAN = pj.ID_DETAIL_SURAT_JALAN
            JOIN pelanggan p ON p.ID_PELANGGAN = pj.ID_PELANGGAN
            JOIN pengguna pg ON pg.ID_PENGGUNA = pj.ID_PENGGUNA
            JOIN barang b ON b.ID_BARANG = dsj.ID_BARANG
            JOIN pengembalian pb ON pb.ID_PENJUALAN = pj.ID_PENJUALAN
            WHERE pj.ID_PENGGUNA = '$id' AND pb.TGL_PENGEMBALIAN BETWEEN '$tgaw' AND '$tgak'
                "
            )->result();
        }else{
            $pengembalian = $this->db->query(
                "
                SELECT * FROM penjualan pj
            JOIN detail_surat_jalan dsj ON dsj.ID_DETAIL_SURAT_JALAN = pj.ID_DETAIL_SURAT_JALAN
            JOIN pelanggan p ON p.ID_PELANGGAN = pj.ID_PELANGGAN
            JOIN pengguna pg ON pg.ID_PENGGUNA = pj.ID_PENGGUNA
            JOIN barang b ON b.ID_BARANG = dsj.ID_BARANG
            JOIN pengembalian pb ON pb.ID_PENJUALAN = pj.ID_PENJUALAN
            WHERE pb.TGL_PENGEMBALIAN BETWEEN '$tgaw' AND '$tgak'
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
        $pdf->Cell(0, 7, 'LAPORAN PENGEMBALIAN', 0, 1, 'C');
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
        $pdf->Cell(50, 6, 'Keterangan', 1, 0, 'C');
        $pdf->Cell(25, 6, 'Jumlah', 1, 1, 'C');

        $pdf->SetFont('Times', '', 10);
        $no = 0;
        $ttl = 0;
        foreach ($pengembalian as $pnj2) {
            $no++;

            $pdf->Cell(10, 6, $no, 1, 0, 'C');
            $pdf->Cell(35, 6, $pnj2->NAMA_PENGGUNA, 1, 0);
            $pdf->Cell(35, 6, $pnj2->NAMA_PELANGGAN, 1, 0);
            $pdf->Cell(35, 6, $pnj2->NAMA_BARANG, 1, 0);
            $pdf->Cell(50, 6, $pnj2->KETERANGAN_PENGEMBALIAN, 1, 0,'C');
            $pdf->Cell(25, 6, $pnj2->JUMLAH_PENGEMBALIAN, 1, 1,'C');
            $ttl = $ttl + $pnj2->JUMLAH_PENGEMBALIAN;
        }
        $pdf->SetFont('Times', 'B', 10);
        $pdf->Cell(165, 6, 'Jumlah Keseluruhan ', 1, 0,'C');
        $pdf->Cell(25, 6, $ttl, 1, 1,'C');

        $pdf->SetY(-65);
        $pdf->SetFont('Times', '', 10);
        $pdf->line($pdf->GetX(), $pdf->GetY(), $pdf->GetX(), $pdf->GetY());
        $pdf->SetY(-65);
        $pdf->SetX(0);
        $pdf->Ln(1);

        $pdf->Cell(140, 6, '', 0, 0, 'C');
        $pdf->Cell(40, 6, 'Sidoarjo, ' . date_indo($tgl), 0, 1, 'C');

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
