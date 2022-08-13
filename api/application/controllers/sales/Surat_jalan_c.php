<?php

defined('BASEPATH') or exit('No direct script access allowed');



class surat_jalan_c extends CI_Controller

{

    public function __construct()

    {

        parent::__construct();

        is_logged_in();

        $this->load->model('sales/Surat_jalan_m', 'surat_jalan_m');

        $this->load->model('gudang/Barang_m', 'barang_m');

    }



    public function index($id_surat_jalan = null)

    {

        $data['title'] = "Daftar Surat Jalan";

        $id_surat_jalan2 = decrypt_url($id_surat_jalan);

        if ($id_surat_jalan2 != null) {

            $data['user'] = $this->db->get_where('pengguna', ['EMAIL_PENGGUNA' => $this->session->userdata('email')])->row_array();

            $data['surat_jalan'] = $this->db->get_where('surat_jalan', ['ID_SURAT_JALAN' => $id_surat_jalan2])->row();

            // $data['detail_surat_jalan'] = $this->db->get_where('detail_surat_jalan', ['ID_SURAT_JALAN' => $id_surat_jalan])->row_array();

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

            if ($data['surat_jalan']->STATUS_SURAT_JALAN == 0) {

                $this->load->view('sales/surat_jalan/detail_no_verif', $data);

            }elseif ($data['surat_jalan']->STATUS_SURAT_JALAN == 2) {

                $this->load->view('sales/surat_jalan/detail_no_verif', $data);

            } else {

                $this->load->view('sales/surat_jalan/detail', $data);

            }

            $this->load->view('templates/footer');

        } else {

            $data['user'] = $this->db->get_where('pengguna', ['EMAIL_PENGGUNA' => $this->session->userdata('email')])->row_array();



            $user2 = $this->db->get_where('pengguna', ['EMAIL_PENGGUNA' => $this->session->userdata('email')])->row_array();

                $idpg = $user2['ID_PENGGUNA'];

                $data['pelanggan'] = $this->db->get_where('pelanggan', ['ID_PENGGUNA' => $idpg])->result();

                $data['surat_jalan'] = $this->db->get_where('surat_jalan', ['ID_PENGGUNA' => $idpg])->result();



            $this->load->view('templates/header', $data);

            $this->load->view('templates/sidebar', $data);

            $this->load->view('templates/topbar', $data);

            $this->load->view('sales/surat_jalan/all', $data);

            $this->load->view('templates/footer');

        }

    }



    public function tambah()

    {

        $dariDB = $this->surat_jalan_m->noSJ();

        // contoh JRD0004, angka 3 adalah awal pengambilan angka, dan 4 jumlah angka yang diambil

        $nourut = substr($dariDB, 4, 6);

        $noSJ1 = $nourut + 1;

        $noSJ2 = "SRJ-".sprintf("%06s",$noSJ1);

        $data['noSJ'] = $noSJ2;



        $data['title'] = "Tambah Data Surat Jalan";

        $data['user'] = $this->db->get_where('pengguna', ['EMAIL_PENGGUNA' => $this->session->userdata('email')])->row_array();
        $idps = $data['user']['ID_PERUSAHAAN'];
        $data['barang'] = $this->db->query("
                SELECT * FROM barang b
                JOIN satuan st ON st.ID_SATUAN = b.ID_SATUAN
                JOIN supplier sp ON sp.ID_SUPPLIER = b.ID_SUPPLIER 
                JOIN pengguna p ON p.ID_PENGGUNA = b.ID_PENGGUNA  WHERE p.ID_PERUSAHAAN = '$idps'")->result();



        $this->form_validation->set_rules('tgl_surat_jalan', 'Tanggal Surat Jalan', 'required|min_length[1]|max_length[50]');

        $this->form_validation->set_rules('no_surat_jalan', 'No Surat Jalan', 'required|min_length[1]|max_length[50]');



        //message

        $this->form_validation->set_message('required', '%s masih kosong, silahkan diisi');

        $this->form_validation->set_message('min_length', '%s anda terlalu pendek');

        $this->form_validation->set_message('max_length', '%s anda terlalu panjang');



        if ($this->form_validation->run() == false) {



            $this->load->view('templates/header', $data);

            $this->load->view('templates/sidebar', $data);

            $this->load->view('templates/topbar', $data);

            $this->load->view('sales/surat_jalan/add', $data);

            $this->load->view('templates/footer');

        } else {



            $id_pengguna = $data['user']['ID_PENGGUNA'];



            $data = [

                'ID_PENGGUNA' => $id_pengguna,

                'NO_SURAT_JALAN' => $this->input->post('no_surat_jalan'),

                'TGL_SURAT_JALAN' => $this->input->post('tgl_surat_jalan')

            ];



            $this->db->insert('surat_jalan', $data);



            $data_surat_jalan = $this->db->query("SELECT MAX(ID_SURAT_JALAN) as id FROM surat_jalan")->result();



            foreach ($data_surat_jalan as $dsj) {

                $id_surat_jalan = $dsj->id;

            }



            $id_barang = $this->input->post('id_barang');

            $jumlah_bawa = $this->input->post('jumlah_bawa');

            $jml = sizeof($id_barang);



            for ($i = 0; $i < $jml; $i++) {



                $datastok = $this->db->get_where('barang', ['ID_BARANG' => $id_barang[$i]])->result();



                foreach ($datastok as $dstok) {



                    $stoktsd = $dstok->STOK_BARANG;

                    $nmbrg = $dstok->NAMA_BARANG;

                }



                if ($jumlah_bawa[$i] > $stoktsd) {



                    $this->surat_jalan_m->hapusData($id_surat_jalan);

                    $this->session->set_flashdata('message', '<div class="alert alert-warning" role="alert">Stok barang ' . $nmbrg . ' tidak memenuhi.</div>');

                    redirect('sales/surat_jalan');

                } else {



                    $stokskr = $stoktsd - $jumlah_bawa[$i];



                    $this->db->where('ID_BARANG', $id_barang[$i]);

                    $this->db->update('barang', ['STOK_BARANG' => $stokskr]);

                    $data2 = [

                        'ID_SURAT_JALAN' => $id_surat_jalan,

                        'ID_BARANG' => $id_barang[$i],

                        'JUMLAH_BAWA' => $jumlah_bawa[$i],

                        'JUMLAH_SISA' => $jumlah_bawa[$i]

                    ];

                    $this->db->insert('detail_surat_jalan', $data2);

                }

            }



            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data surat jalan berhasil ditambahkan</div>');

            redirect('sales/surat_jalan');

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



    public function cetak($id_surat_jalan)

    {

        $this->load->library('Pdf');

        $id_surat_jalan2 = decrypt_url($id_surat_jalan);

        // $data['user'] = $this->db->get_where('pengguna', ['EMAIL_PENGGUNA' => $this->session->userdata('email')])->row_array();
        $eu = $this->session->userdata('email');
        $data['user'] = $this->db->query("
                        SELECT * FROM pengguna p JOIN _perusahaan ps ON ps.ID_PERUSAHAAN = p.ID_PERUSAHAAN
                        WHERE p.EMAIL_PENGGUNA = '$eu'")->row();
        $data['surat_jalan'] = $this->db->query(

            "

                SELECT * FROM surat_jalan sj 

                JOIN pengguna p ON p.ID_PENGGUNA = sj.ID_PENGGUNA

                WHERE sj.ID_SURAT_JALAN = '$id_surat_jalan2'

                "

        )->row();

        $data['detail_surat_jalan'] = $this->db->query(

            "

                SELECT * FROM detail_surat_jalan dsj 

                JOIN barang b ON b.ID_BARANG = dsj.ID_BARANG

                JOIN satuan s ON s.ID_SATUAN = b.ID_SATUAN

                WHERE dsj.ID_SURAT_JALAN = '$id_surat_jalan2'

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

        $pdf->Cell(0, 7, 'Email : '.$data['user']->EMAIL_PEMILIK.', Telp/HP : '.$data['user']->NO_HP_PEMILIK, 0, 1, 'C');

        $pdf->Cell(0, 1, '________________________________________________________________________', 0, 1, 'C');

        $pdf->SetFont('Times', '', 7);

        $pdf->Cell(0, 1, '_______________________________________________________________________________________________________', 0, 1, 'C');

        $pdf->Ln(8);



        $pdf->SetFont('Arial', 'B', 14);

        $pdf->Cell(0, 7, 'SURAT JALAN', 0, 1, 'C');

        $pdf->Cell(15, 7, '', 0, 1);



        //$pdf->Ln(20);

        $pdf->SetFont('Arial', 'B', 10);

        $pdf->Cell(30, 6, 'No Surat Jalan', 0, 0, 'L');

        $pdf->Cell(5, 6, ':', 0, 0, 'L');

        $pdf->Cell(40, 6, $data['surat_jalan']->NO_SURAT_JALAN, 0, 0, 'L');



        $pdf->Cell(20, 6, 'Tanggal', 0, 0, 'L');

        $pdf->Cell(5, 6, ':', 0, 0, 'L');

        $pdf->Cell(30, 6, date_indo($data['surat_jalan']->TGL_SURAT_JALAN), 0, 1, 'L');



        $pdf->Cell(30, 6, 'Nama Sales', 0, 0, 'L');

        $pdf->Cell(5, 6, ':', 0, 0, 'L');

        $pdf->Cell(30, 6, $data['surat_jalan']->NAMA_PENGGUNA, 0, 0, 'L');



        $pdf->Ln(15);



        $pdf->SetFont('Arial', 'B', 10);

        $pdf->Cell(10, 6, 'No', 1, 0, 'C');

        $pdf->Cell(40, 6, 'Nama Barang', 1, 0, 'C');

        $pdf->Cell(30, 6, 'Jumlah Barang', 1, 0, 'C');

        $pdf->Cell(20, 6, 'Satuan', 1, 0, 'C');

        $pdf->Cell(30, 6, 'Harga', 1, 1, 'C');



        $pdf->SetFont('Arial', '', 10);

        $no = 0;

        $ttl = 0;
        $ttl2 = 0;

        foreach ($data['detail_surat_jalan'] as $detail) {

            $no++;
            $ttl2 = $detail->JUMLAH_BAWA*$detail->HARGA_JUAL_BARANG;
            $pdf->Cell(10, 6, $no, 1, 0, 'C');

            $pdf->Cell(40, 6, $detail->NAMA_BARANG, 1, 0);

            $pdf->Cell(30, 6, $detail->JUMLAH_BAWA, 1, 0,'C');

            $pdf->Cell(20, 6, $detail->NAMA_SATUAN, 1, 0,'C');

            $pdf->Cell(30, 6, 'Rp. '.number_format($ttl2), 1, 1,'C');

            $ttl = $ttl + $ttl2;

        }

        $pdf->SetFont('Arial', 'B', 10);

        $pdf->Cell(100, 6, 'Sub Total ', 1, 0,'C');

        $pdf->Cell(30, 6, 'Rp. '.number_format($ttl), 1, 1,'C');



        // $pdf->SetY(-65);

        // $pdf->SetFont('Arial', '', 10);

        // $pdf->line($pdf->GetX(), $pdf->GetY(), $pdf->GetX(), $pdf->GetY());

        // $pdf->SetY(-65);

        // $pdf->SetX(0);

        // $pdf->Ln(1);



        // $pdf->Cell(90, 6, '', 0, 0, 'C');

        // $pdf->Cell(40, 6, '' . date_indo($tgls), 0, 1, 'C');



        // $pdf->SetY(-59);

        // $pdf->SetFont('Arial', '', 10);

        // $pdf->line($pdf->GetX(), $pdf->GetY(), $pdf->GetX(), $pdf->GetY());

        // $pdf->SetY(-59);

        // $pdf->SetX(0);

        // $pdf->Ln(1);



        // $pdf->Cell(90, 6, '', 0, 0, 'C');

        // $pdf->Cell(40, 6, 'Supervisor', 0, 1, 'C');



        // $pdf->SetY(-29);

        // $pdf->SetFont('Arial', '', 10);

        // $pdf->line($pdf->GetX(), $pdf->GetY(), $pdf->GetX(), $pdf->GetY());

        // $pdf->SetY(-29);

        // $pdf->SetX(0);

        // $pdf->Ln(1);



        // $pdf->Cell(90, 6, '', 0, 0, 'C');

        // $pdf->Cell(40, 6, '(................................)', 0, 1, 'C');



        /*$hal = 'Page : '.$pdf->PageNo().'/{nb}' ;

        $pdf->Cell($pdf->GetStringWidth($hal ),10,$hal );   

        $datestring = date("d F Y");

        $tanggal  = 'Printed : '.date('d-m-Y  h:i-a').' ';

        $pdf->Cell($lebar-$pdf->GetStringWidth($hal )-$pdf->GetStringWidth($tanggal)-20);   

        $pdf->Cell($pdf->GetStringWidth($tanggal),10,$tanggal );*/





        $pdf->Output();

    }

}



/* End of file Supplier_c.php */

