<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Grafik extends CI_Controller 
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('api/Api_m', 'api_m');
    }

    public function index()
    {
        $api_key = htmlspecialchars($this->input->post('api'), true);
        $id = htmlspecialchars($this->input->post('idpengguna'), true);
        $cek_api_key = $this->api_m->CekApiKey($api_key);
        if ($cek_api_key->num_rows() > 0) {
        $bln = array('01','02','03','04','05','06','07','08','09','10','11','12');
        $jml = sizeof($bln);
        $year = date('Y');
        $datapenjualan = array();
        
        $blnpenjualan = array('Jan','Feb', 'Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des');

            for ($i=0; $i < $jml; $i++) {

                $tgl = $bln[$i].'-'.$year;
                $data2 = $this->db->query("
                    SELECT pg.ID_PENGGUNA, pg.NAMA_PENGGUNA, IFNULL(SUM(p.JUMLAH_PENJUALAN),'0') as 'Total' 
                    FROM penjualan p
                    JOIN detail_surat_jalan dsj ON dsj.ID_DETAIL_SURAT_JALAN = p.ID_DETAIL_SURAT_JALAN
                    JOIN barang b ON b.ID_BARANG = dsj.ID_BARANG
                    JOIN pengguna pg ON pg.ID_PENGGUNA = p.ID_PENGGUNA
                    WHERE pg.ID_PENGGUNA = '$id' AND DATE_FORMAT(p.TGL_PENJUALAN, '%m-%Y') = '$tgl'
                    GROUP BY p.ID_PENGGUNA
                    ORDER BY SUM(p.JUMLAH_PENJUALAN) DESC
                    ")->num_rows();

                if($data2 > 0){

                    $data2 = $this->db->query("
                    SELECT pg.ID_PENGGUNA, pg.NAMA_PENGGUNA, IFNULL(SUM(p.JUMLAH_PENJUALAN),'0') as 'Total' 
                    FROM penjualan p
                    JOIN detail_surat_jalan dsj ON dsj.ID_DETAIL_SURAT_JALAN = p.ID_DETAIL_SURAT_JALAN
                    JOIN barang b ON b.ID_BARANG = dsj.ID_BARANG
                    JOIN pengguna pg ON pg.ID_PENGGUNA = p.ID_PENGGUNA
                    WHERE pg.ID_PENGGUNA = '$id' AND DATE_FORMAT(p.TGL_PENJUALAN, '%m-%Y') = '$tgl'
                    GROUP BY p.ID_PENGGUNA
                    ORDER BY SUM(p.JUMLAH_PENJUALAN) DESC")->result();

                    foreach ($data2 as $dt2) {
                        $ttljl = $dt2->Total;
                    }
                
                }else{
                    $ttljl = 0;
                }   
                    //$datapenjualan = 'JML';
                    $datapenjualan[] = Array("JUMLAH" => ((int) $ttljl));
            }

            $respon = [
                'status' => true,
                'message' => "Data berhasil didapatkan",
                'grafik_penjualan' => $datapenjualan
            ];

        }else {
            $respon = [
                'status' => false,
                'message' => "Error API Key"
            ];
        }
        $json = json_encode($respon);
        echo $json;
    }
}

/* End of file Barang.php */
