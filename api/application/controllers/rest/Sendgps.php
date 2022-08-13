<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Sendgps extends CI_Controller 
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('api/Api_m', 'api_m');
    }

    public function getgps(){
        $idp = htmlspecialchars($this->input->post('idpengguna'), true);
        $api = htmlspecialchars($this->input->post('api'), true);
        $lat = htmlspecialchars($this->input->post('myLatitude'), true);
        $long = htmlspecialchars($this->input->post('myLongtitude'), true);
        
         $cek_api_key = $this->api_m->CekApiKey($api);

        if ($cek_api_key->num_rows() > 0) {
            if(!empty($lat)){

                $data = [
                    'latitude' => $lat,
                    'longtitude' => $long
                ];
                $data2 = array(
                    'ID_PENGGUNA'=>$idp,
                    'LATITUDE'=>$lat,
                    'LONGTITUDE'=>$long
                );
        
                $this->db->insert('gps',$data2);
                $respon = [
                    'status' => true,
                     'message' => "Lat :".$lat." -> Long :".$long
                    ];
            }else {
                $respon = [
                    'status' => true,
                    'message' => "Data Tidak Masuk"
                    ];
            }
        }else{
           
         $respon = [
            'status' => true,
            'message' => "Api Tidak Cocok"
            ];
        }
    
        $json = json_encode($respon);
        echo $json;
    }
    
    public function getlokasi()
	{
	    date_default_timezone_set("Asia/Bangkok");
	    $tgl = date('Y-m-d:H-i-s');
		$idp = htmlspecialchars($this->input->post('idpengguna'), true);
		$api = htmlspecialchars($this->input->post('api'), true);
		$lat = htmlspecialchars($this->input->post('myLatitude'), true);
		$long = htmlspecialchars($this->input->post('myLongtitude'), true);
		$lokasi = htmlspecialchars($this->input->post('lokasi'), true);

		$cek_api_key = $this->api_m->CekApiKey($api);

		if ($cek_api_key->num_rows() > 0) {
			if (!empty($lokasi)) {
				$data2 = array(
					'ID_PENGGUNA' => $idp,
					'LATITUDE' => $lat,
					'LONGTITUDE' => $long,
					'NAMA_LOKASI' => $lokasi,
					'TANGGAL' => $tgl
				);
				$this->db->insert('gps_lokasi', $data2);
				$respon = [
					'status' => true,
					'message' => "Input lokasi sukses"
				];
			} else {
				$respon = [
					'status' => true,
					'message' => "Data Tidak Masuk"
				];
			}
		} else {
			$respon = [
				'status' => true,
				'message' => "Api Tidak Cocok"
			];
		}
		$json = json_encode($respon);
		echo $json;
		die;
	}
}

/* End of file Login   .php */
