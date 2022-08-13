<?php
defined('BASEPATH') or exit('No direct script access allowed');

class pesan_ulang_c extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('sales/Surat_jalan_m', 'surat_jalan_m');
        $this->load->model('gudang/Barang_m', 'barang_m');
        $this->load->model('sales/Pesan_ulang_m', 'pesan_ulang_m');
        $this->load->model('sales/Pelanggan_m', 'pelanggan_m');
    }

    public function index($id_pesan_ulang = null)
    {
        $data['title'] = "Daftar Pesan Ulang";
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
            if ($data['pesan_ulang']->STATUS_PESAN_ULANG == 0) {
                $this->load->view('sales/pesan_ulang/detail_no_verif', $data);
            } elseif ($data['pesan_ulang']->STATUS_PESAN_ULANG == 2) {
                $this->load->view('sales/pesan_ulang/detail_no_verif', $data);
            } else {
                $this->load->view('sales/pesan_ulang/detail', $data);
            }
            $this->load->view('templates/footer');
        } else {
            $data['user'] = $this->db->get_where('pengguna', ['EMAIL_PENGGUNA' => $this->session->userdata('email')])->row_array();

            /*$data['pesan_ulang'] = $this->pesan_ulang_m->TampilData()->result();*/
            $user2 = $this->db->get_where('pengguna', ['EMAIL_PENGGUNA' => $this->session->userdata('email')])->row_array();
            $idpg = $user2['ID_PENGGUNA'];
            $data['pelanggan'] = $this->db->get_where('pelanggan', ['ID_PENGGUNA' => $idpg])->result();
            $data['pesan_ulang'] = $this->db->query(
                "
                SELECT * FROM pesan_ulang pu 
                JOIN pelanggan p ON p.ID_PELANGGAN = pu.ID_PELANGGAN
                WHERE pu.ID_PENGGUNA = '$idpg'
                "
            )->result();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('sales/pesan_ulang/all', $data);
            $this->load->view('templates/footer');
        }
    }

    public function tambah()
    {
        $data['title'] = "Tambah Data Pesan Ulang";
        $data['user'] = $this->db->get_where('pengguna', ['EMAIL_PENGGUNA' => $this->session->userdata('email')])->row_array();
        $idps = $data['user']['ID_PERUSAHAAN'];
        $data['barang'] = $this->db->query("
                SELECT * FROM barang b
                JOIN satuan st ON st.ID_SATUAN = b.ID_SATUAN
                JOIN supplier sp ON sp.ID_SUPPLIER = b.ID_SUPPLIER 
                JOIN pengguna p ON p.ID_PENGGUNA = b.ID_PENGGUNA  WHERE p.ID_PERUSAHAAN = '$idps'")->result();
        $user2 = $this->db->get_where('pengguna', ['EMAIL_PENGGUNA' => $this->session->userdata('email')])->row_array();
        $idpg = $user2['ID_PENGGUNA'];
        $data['pelanggan'] = $this->db->get_where('pelanggan', ['ID_PENGGUNA' => $idpg])->result();
        $data['penjualan'] = $this->db->get_where('penjualan', ['ID_PENGGUNA' => $idpg])->result();

        $this->form_validation->set_rules('tgl_pesan_ulang', 'Tanggal Pesan Ulang', 'required|min_length[1]|max_length[50]');

        //message
        $this->form_validation->set_message('required', '%s masih kosong, silahkan diisi');
        $this->form_validation->set_message('min_length', '%s anda terlalu pendek');
        $this->form_validation->set_message('max_length', '%s anda terlalu panjang');

        if ($this->form_validation->run() == false) {

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('sales/pesan_ulang/add', $data);
            $this->load->view('templates/footer');
        } else {

            $id_pengguna = $data['user']['ID_PENGGUNA'];

            $data = [
                'ID_PENGGUNA' => $id_pengguna,
                'ID_PELANGGAN' => $this->input->post('id_pelanggan'),
                'TGL_PESAN_ULANG' => $this->input->post('tgl_pesan_ulang'),
                'STATUS_PESAN_ULANG' => 0,
                'STATUS_PEMBAYARAN_PESAN_ULANG' => $this->input->post('jenis_pembayaran')
            ];

            $this->db->insert('pesan_ulang', $data);

            $data_pesan_ulang = $this->db->query("SELECT MAX(ID_PESAN_ULANG) as id FROM pesan_ulang")->result();

            foreach ($data_pesan_ulang as $psu) {
                $id_pesan_ulang = $psu->id;
            }

            $id_barang = $this->input->post('id_barang');
            $jumlah_pesan = $this->input->post('jumlah_pesan');
            $jml = sizeof($id_barang);

            for ($i = 0; $i < $jml; $i++) {
                if ($this->input->post("harga_pesan_ulang") != '') {
                    $hrg = $this->input->post('harga_pesan_ulang');
                } else {
                    $hrg = '0';
                }
                $data2 = [
                    'ID_PESAN_ULANG' => $id_pesan_ulang,
                    'ID_BARANG' => $id_barang[$i],
                    'JUMLAH_PESAN_ULANG' => $jumlah_pesan[$i],
                    'HARGA_PESAN_ULANG' => $hrg[$i]
                ];

                $this->db->insert('detail_pesan_ulang', $data2);
            }

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data pesan ulang berhasil ditambahkan</div>');
            redirect('sales/pesan_ulang');
        }
    }

    public function ubah($id_pelanggan)
    {
        $id_pelanggan2 = decrypt_url($id_pelanggan);
        $data['title'] = "Ubah Data Pelanggan";
        $data['user'] = $this->db->get_where('pengguna', ['EMAIL_PENGGUNA' => $this->session->userdata('email')])->row_array();

        $data['pelanggan'] = $this->pelanggan_m->TampilData($id_pelanggan2)->row();

        $this->form_validation->set_rules('nama_pelanggan', 'Nama Pelanggan', 'required|trim|max_length[50]');
        $this->form_validation->set_rules('email_pelanggan', 'Email Pelanggan', 'required|trim|valid_email|max_length[50]');
        $this->form_validation->set_rules('no_hp_pelanggan', 'No Hp Pelanggan', 'required|trim|numeric|min_length[8]|max_length[13]');
        $this->form_validation->set_rules('alamat_pelanggan', 'Alamat Pelanggan', 'required|trim|max_length[200]');

        //message
        $this->form_validation->set_message('required', '%s masih kosong, silahkan diisi');
        $this->form_validation->set_message('numeric', '%s harus diisi dengan nominasi angka');
        $this->form_validation->set_message('valid_email', '%s harus diisi dengan email yang valid');
        $this->form_validation->set_message('min_length', '%s anda terlalu pendek');
        $this->form_validation->set_message('max_length', '%s anda terlalu panjang');
        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('sales/pelanggan/edit', $data);
            $this->load->view('templates/footer');
        } else {
            $post = $this->input->post(null, TRUE);
            $id_pengguna = $data['user']['ID_PENGGUNA'];
            $this->pelanggan_m->ubahData($id_pengguna, $id_pelanggan, $post);

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data pelanggan berhasil diubah</div>');
            redirect('sales/pelanggan');
        }
    }

    public function hapus($id_pelanggan)
    {
        $id_pelanggan2 = decrypt_url($id_pelanggan);
        $this->pelanggan_m->hapusData($id_pelanggan);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data pelanggan berhasil dihapus</div>');
        redirect('sales/pelanggan');
    }

    public function cetak($id_pesan_ulang)
    {
        $this->load->library('Pdf');
        $id_pesan_ulang2 = decrypt_url($id_pesan_ulang);
        $eu = $this->session->userdata('email');
        $data['user'] = $this->db->query("
                        SELECT * FROM pengguna p JOIN _perusahaan ps ON ps.ID_PERUSAHAAN = p.ID_PERUSAHAAN
                        WHERE p.EMAIL_PENGGUNA = '$eu'")->row();
        $data['pesan_ulang'] = $this->db->query(
            "
                SELECT * FROM pesan_ulang pu 
                JOIN pengguna p ON p.ID_PENGGUNA = pu.ID_PENGGUNA
                JOIN pelanggan pl ON pl.ID_PELANGGAN = pu.ID_PELANGGAN
                WHERE pu.ID_PESAN_ULANG = '$id_pesan_ulang2'
                "
        )->row();
        $data['detail_pesan_ulang'] = $this->db->query(
            "
                SELECT * FROM detail_pesan_ulang dpu 
                JOIN barang b ON b.ID_BARANG = dpu.ID_BARANG
                JOIN satuan s ON s.ID_SATUAN = b.ID_SATUAN
                WHERE dpu.ID_PESAN_ULANG = '$id_pesan_ulang2'
                "
        )->result();
        $tgls = date("Y-m-d");
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

        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(0, 7, 'SURAT JALAN', 0, 1, 'C');
        $pdf->Cell(20, 7, '', 0, 1);

        //$pdf->Ln(20);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(30, 6, 'Nama Sales', 0, 0, 'L');
        $pdf->Cell(5, 6, ':', 0, 0, 'L');
        $pdf->Cell(30, 6, $data['pesan_ulang']->NAMA_PENGGUNA, 0, 0, 'L');

        $pdf->Cell(30, 6, 'Tanggal', 0, 0, 'L');
        $pdf->Cell(5, 6, ':', 0, 0, 'L');
        $pdf->Cell(30, 6, date_indo($data['pesan_ulang']->TGL_PESAN_ULANG), 0, 1, 'L');

        $pdf->Cell(30, 6, 'Nama Pelanggan', 0, 0, 'L');
        $pdf->Cell(5, 6, ':', 0, 0, 'L');
        $pdf->Cell(30, 6, $data['pesan_ulang']->NAMA_PELANGGAN, 0, 0, 'L');

        $pdf->Cell(30, 6, 'HP Pelanggan', 0, 0, 'L');
        $pdf->Cell(5, 6, ':', 0, 0, 'L');
        $pdf->Cell(30, 6, $data['pesan_ulang']->NO_HP_PELANGGAN, 0, 1, 'L');

        $pdf->Cell(30, 6, 'Pembayaran', 0, 0, 'L');
        $pdf->Cell(5, 6, ':', 0, 0, 'L');
        $pdf->Cell(30, 6, $data['pesan_ulang']->STATUS_PEMBAYARAN_PESAN_ULANG, 0, 1, 'L');

        $pdf->Ln(10);

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(10, 6, 'No', 1, 0, 'C');
        $pdf->Cell(40, 6, 'Nama Barang', 1, 0, 'C');
        $pdf->Cell(30, 6, 'Jumlah Barang', 1, 0, 'C');
        $pdf->Cell(20, 6, 'Satuan', 1, 0, 'C');
        $pdf->Cell(30, 6, 'Sub Total', 1, 1, 'C');

        $pdf->SetFont('Arial', '', 10);
        $no = 0;
        $ttl = 0;
        foreach ($data['detail_pesan_ulang'] as $dpu) {
            $no++;
            $hrg = $dpu->HARGA_PESAN_ULANG;
            if ($hrg > 0) {
                $sub = $hrg;
            } else {
                $sub = $dpu->HARGA_JUAL_BARANG * $dpu->JUMLAH_PESAN_ULANG;
            }
            $pdf->Cell(10, 6, $no, 1, 0, 'C');
            $pdf->Cell(40, 6, $dpu->NAMA_BARANG, 1, 0);
            $pdf->Cell(30, 6, $dpu->JUMLAH_PESAN_ULANG, 1, 0, 'C');
            $pdf->Cell(20, 6, $dpu->NAMA_SATUAN, 1, 0, 'C');
            $pdf->Cell(30, 6, 'Rp. ' . number_format($sub), 1, 1, 'C');
            $ttl = $ttl + $sub;
        }
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(100, 6, 'Total ', 1, 0, 'C');
        $pdf->Cell(30, 6, 'Rp. ' . number_format($ttl), 1, 1, 'C');

        $pdf->SetY(-65);
        $pdf->SetFont('Arial', '', 10);
        $pdf->line($pdf->GetX(), $pdf->GetY(), $pdf->GetX(), $pdf->GetY());
        $pdf->SetY(-65);
        $pdf->SetX(0);
        $pdf->Ln(1);

        // $pdf->Cell(90, 6, '', 0, 0, 'C');
        // $pdf->Cell(40, 6, 'Sidoarjo, ' . date_indo($data['pesan_ulang']->TGL_PESAN_ULANG), 0, 1, 'C');

        $pdf->SetY(-55);
        $pdf->SetFont('Arial', '', 10);
        $pdf->line($pdf->GetX(), $pdf->GetY(), $pdf->GetX(), $pdf->GetY());
        $pdf->SetY(-55);
        $pdf->SetX(0);
        $pdf->Ln(1);

        $pdf->Cell(90, 6, '', 0, 0, 'C');
        $pdf->Cell(40, 6, 'Sales', 0, 1, 'C');

        $pdf->SetY(-30);
        $pdf->SetFont('Arial', '', 8);
        $pdf->line($pdf->GetX(), $pdf->GetY(), $pdf->GetX(), $pdf->GetY());
        $pdf->SetY(-30);
        $pdf->SetX(0);
        $pdf->Ln(1);

        $pdf->Cell(50, 6, 'LEMBAR UNTUK PELANGGAN', 1, 0, 'C');
        $pdf->Cell(40, 6, '', 0, 0, 'C');
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(40, 6, '(' . $data['pesan_ulang']->NAMA_PENGGUNA . ')', 0, 1, 'C');


        /*$hal = 'Page : '.$pdf->PageNo().'/{nb}' ;
        $pdf->Cell($pdf->GetStringWidth($hal ),10,$hal );   
        $datestring = date("d F Y");
        $tanggal  = 'Printed : '.date('d-m-Y  h:i-a').' ';
        $pdf->Cell($lebar-$pdf->GetStringWidth($hal )-$pdf->GetStringWidth($tanggal)-20);   
        $pdf->Cell($pdf->GetStringWidth($tanggal),10,$tanggal );*/
        $pdf->AddPage();

        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 7, 'SURAT JALAN', 0, 1, 'C');
        $pdf->Cell(20, 7, '', 0, 1);

        //$pdf->Ln(20);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(30, 6, 'Nama Sales', 0, 0, 'L');
        $pdf->Cell(5, 6, ':', 0, 0, 'L');
        $pdf->Cell(30, 6, $data['pesan_ulang']->NAMA_PENGGUNA, 0, 0, 'L');

        $pdf->Cell(30, 6, 'Tanggal', 0, 0, 'L');
        $pdf->Cell(5, 6, ':', 0, 0, 'L');
        $pdf->Cell(30, 6, date_indo($data['pesan_ulang']->TGL_PESAN_ULANG), 0, 1, 'L');

        $pdf->Cell(30, 6, 'Nama Pelanggan', 0, 0, 'L');
        $pdf->Cell(5, 6, ':', 0, 0, 'L');
        $pdf->Cell(30, 6, $data['pesan_ulang']->NAMA_PELANGGAN, 0, 0, 'L');

        $pdf->Cell(30, 6, 'HP Pelanggan', 0, 0, 'L');
        $pdf->Cell(5, 6, ':', 0, 0, 'L');
        $pdf->Cell(30, 6, $data['pesan_ulang']->NO_HP_PELANGGAN, 0, 1, 'L');

        $pdf->Cell(30, 6, 'Pembayaran', 0, 0, 'L');
        $pdf->Cell(5, 6, ':', 0, 0, 'L');
        $pdf->Cell(30, 6, $data['pesan_ulang']->STATUS_PEMBAYARAN_PESAN_ULANG, 0, 1, 'L');

        $pdf->Ln(10);

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(10, 6, 'No', 1, 0, 'C');
        $pdf->Cell(40, 6, 'Nama Barang', 1, 0, 'C');
        $pdf->Cell(30, 6, 'Jumlah Barang', 1, 0, 'C');
        $pdf->Cell(20, 6, 'Satuan', 1, 0, 'C');
        $pdf->Cell(30, 6, 'Sub Total', 1, 1, 'C');

        $pdf->SetFont('Arial', '', 10);
        $no = 0;
        $ttl = 0;
        foreach ($data['detail_pesan_ulang'] as $dpu) {
            $no++;
            $hrg = $dpu->HARGA_PESAN_ULANG;
            if ($hrg > 0) {
                $sub = $hrg;
            } else {
                $sub = $dpu->HARGA_JUAL_BARANG * $dpu->JUMLAH_PESAN_ULANG;
            }
            $pdf->Cell(10, 6, $no, 1, 0, 'C');
            $pdf->Cell(40, 6, $dpu->NAMA_BARANG, 1, 0);
            $pdf->Cell(30, 6, $dpu->JUMLAH_PESAN_ULANG, 1, 0, 'C');
            $pdf->Cell(20, 6, $dpu->NAMA_SATUAN, 1, 0, 'C');
            $pdf->Cell(30, 6, 'Rp. ' . number_format($sub), 1, 1, 'C');
            $ttl = $ttl + $sub;
        }
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(100, 6, 'Total ', 1, 0, 'C');
        $pdf->Cell(30, 6, 'Rp. ' . number_format($ttl), 1, 1, 'C');

        $pdf->SetY(-65);
        $pdf->SetFont('Arial', '', 10);
        $pdf->line($pdf->GetX(), $pdf->GetY(), $pdf->GetX(), $pdf->GetY());
        $pdf->SetY(-65);
        $pdf->SetX(0);
        $pdf->Ln(1);

        // $pdf->Cell(90, 6, '', 0, 0, 'C');
        // $pdf->Cell(40, 6, 'Sidoarjo, ' . date_indo($data['pesan_ulang']->TGL_PESAN_ULANG), 0, 1, 'C');

        $pdf->SetY(-55);
        $pdf->SetFont('Arial', '', 10);
        $pdf->line($pdf->GetX(), $pdf->GetY(), $pdf->GetX(), $pdf->GetY());
        $pdf->SetY(-55);
        $pdf->SetX(0);
        $pdf->Ln(1);

        $pdf->Cell(90, 6, '', 0, 0, 'C');
        $pdf->Cell(40, 6, 'Supervisor', 0, 1, 'C');

        $pdf->SetY(-30);
        $pdf->SetFont('Arial', '', 8);
        $pdf->line($pdf->GetX(), $pdf->GetY(), $pdf->GetX(), $pdf->GetY());
        $pdf->SetY(-30);
        $pdf->SetX(0);
        $pdf->Ln(1);

        $pdf->Cell(50, 6, 'LEMBAR UNTUK ARSIP', 1, 0, 'C');
        $pdf->Cell(40, 6, '', 0, 0, 'C');
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(40, 6, '(......................................)', 0, 1, 'C');

        $pdf->Output();
    }
}

/* End of file Supplier_c.php */
