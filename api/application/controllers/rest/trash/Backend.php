<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Backend extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('api/Api_m', 'api_m');
    }

    public function menuju_lokasi()
    {
        $api_key = htmlspecialchars($this->input->post('API-KEY'), true);
        $data = [
            'id_tempat_sampah' => htmlspecialchars($this->input->post('id_tempat_sampah'), true),
            'id_mobil_sampah' => htmlspecialchars($this->input->post('id_mobil_sampah'), true),
            'id_pengguna' => htmlspecialchars($this->input->post('id_pengguna'), true),
        ];

        if (!$api_key || !$data) {
            $respon = ['status' => false, 'message' => "Parameter not fount"];
            $json = json_encode($respon);
            echo $json;
            die;
        }

        $cek_api_key = $this->api_m->CekApiKey($api_key);
        if ($cek_api_key->num_rows() == 0) {
            $respon = ['status' => false, 'message' => "Error API Key"];
            $json = json_encode($respon);
            echo $json;
            die;
        }

        $id_tempat_sampah = $data['id_tempat_sampah'];
        $ditolak = $this->db->query("SELECT * FROM list_tugas WHERE ID_TEMPAT_SAMPAH  = '$id_tempat_sampah' AND STATUS_LIST = 'menuju lokasi'")->row();
        if ($ditolak) {
            $respon = [
                'status' => false,
                'message' => "Tugas sudah dilakukan oleh unit lain"
            ];
            $json = json_encode($respon);
            echo $json;
            die;
        }


        $id_mobil = $data['id_mobil_sampah'];
        $mobil_bisa = $this->db->query("SELECT * FROM mobil_sampah WHERE ID_MOBIL_SAMPAH  = '$id_mobil' AND STATUS = 'ready'")->row();
        if (!$mobil_bisa) {
            $respon = [
                'status' => false,
                'message' => "Mobil sampah tidak ready"
            ];
            $json = json_encode($respon);
            echo $json;
            die;
        }

        $data = array(
            'ID_TEMPAT_SAMPAH' => $data['id_tempat_sampah'],
            'ID_MOBIL_SAMPAH' => $data['id_mobil_sampah'],
            'ID_PENGGUNA' => $data['id_pengguna'],
            'STATUS_LIST' => 'menuju lokasi'
        );
        $this->db->insert('list_tugas', $data);

        $this->db->where("ID_MOBIL_SAMPAH", $id_mobil);
        $this->db->update("mobil_sampah", ['STATUS' => 'dipakai']);

        $this->db->where("ID_TEMPAT_SAMPAH ", $id_tempat_sampah);
        $this->db->update("tempat_sampah", ['STATUS_JEMPUT' => '1']);

        $respon = [
            'status' => true,
            'message' => "Data tugas berhasil diinputkan"
        ];
        $json = json_encode($respon);
        echo $json;
        die;
    }

    public function angkut()
    {
        $api_key = htmlspecialchars($this->input->post('API-KEY'), true);
        $data = [
            'id_list_tugas' => htmlspecialchars($this->input->post('id_list_tugas'), true),
        ];

        if (!$api_key || !$data) {
            $respon = ['status' => false, 'message' => "Parameter not fount"];
            $json = json_encode($respon);
            echo $json;
            die;
        }

        $cek_api_key = $this->api_m->CekApiKey($api_key);
        if ($cek_api_key->num_rows() == 0) {
            $respon = ['status' => false, 'message' => "Error API Key"];
            $json = json_encode($respon);
            echo $json;
            die;
        }

        $id_tugas = $data['id_list_tugas'];
        $tugas = $this->db->query("SELECT * FROM list_tugas WHERE ID_LIST_TUGAS = '$id_tugas' AND STATUS_LIST = 'menuju lokasi'")->row();
        if ($tugas) {
            $this->db->where("ID_LIST_TUGAS", $id_tugas);
            $this->db->update("list_tugas", ['STATUS_LIST' => 'angkut']);

            $this->db->where("ID_MOBIL_SAMPAH", $tugas->ID_MOBIL_SAMPAH);
            $this->db->update("mobil_sampah", ['STATUS' => 'ready']);

            $this->db->where("ID_TEMPAT_SAMPAH ", $tugas->ID_TEMPAT_SAMPAH);
            $this->db->update("tempat_sampah", [
                'STATUS_JEMPUT' => '0',
                'BERAT' => '0',
            ]);

            $respon = [
                'status' => true,
                'message' => "Tugas berhasil diselesaikan"
            ];
            $json = json_encode($respon);
            echo $json;
            die;
        } else {
            $respon = [
                'status' => false,
                'message' => "Rekap tugasmu tidak ditemukan"
            ];
            $json = json_encode($respon);
            echo $json;
            die;
        }
    }

    public function update_volume()
    {
        $api_key = htmlspecialchars($this->input->get('API-KEY'), true);
        $data = [
            'id_tempat_sampah' => htmlspecialchars($this->input->get('id_tempat_sampah'), true),
            'berat' => htmlspecialchars($this->input->get('berat'), true),
        ];

        if (!$api_key || !$data) {
            $respon = ['status' => false, 'message' => "Parameter not fount"];
            $json = json_encode($respon);
            echo $json;
            die;
        }

        $cek_api_key = $this->api_m->CekApiKey($api_key);
        if ($cek_api_key->num_rows() == 0) {
            $respon = ['status' => false, 'message' => "Error API Key"];
            $json = json_encode($respon);
            echo $json;
            die;
        }

        $id_tempat_sampah = $data['id_tempat_sampah'];
        $berat = $data['berat'];
        $tempat_sampah = $this->db->query("SELECT * FROM tempat_sampah WHERE ID_TEMPAT_SAMPAH = '$id_tempat_sampah'")->row();
        if (!$tempat_sampah) {
            $respon = ['status' => false, 'message' => "Data tidak ditemukan"];
        } else {
            $this->db->where("ID_TEMPAT_SAMPAH", $id_tempat_sampah);
            $this->db->update("tempat_sampah", ['BERAT' => $berat]);

            $respon = ['status' => true, 'message' => "Data berhasil diupdate"];
        }

        $json = json_encode($respon);
        echo $json;
        die;
    }
}

/* End of file Backend.php */
