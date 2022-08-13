<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kunjungan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('api/home/Home_m', 'home');
        $this->load->model('api/kunjungan/Kunjungan_m', 'kunjungan');
        $this->load->model('api/Api_m', 'api_m');
    }

    private function tgl_indo($tanggal)
    {
        $bulan = array(
            1 =>   'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        );
        $pecahkan = explode('-', $tanggal);
        return $pecahkan[2] . ' ' . $bulan[(int)$pecahkan[1]] . ' ' . $pecahkan[0];
    }

    public function belum_dikunjungi()
    {
        $api_key = htmlspecialchars($this->input->post('API-KEY'), true);
        $id_pengguna = htmlspecialchars($this->input->post('id_pengguna'), true);
        if (!$api_key || !$id_pengguna) {
            $respon = [
                'status' => false,
                'message' => "Parameter not found"
            ];
            $json = json_encode($respon);
            echo $json;
            die;
        }

        $cek_api_key = $this->api_m->CekApiKey($api_key);
        if ($cek_api_key->num_rows() == 0) {
            $respon = [
                'status' => false,
                'message' => "Error API Key"
            ];
        } else {
            $respon = [
                'status' => true,
                'message' => "Data berhasil ditampilkan",
                "tanggal" =>  $this->tgl_indo(date('Y-m-d')),
                "kunjungan_data" =>  $this->home->belumDikunjungi(date('Y-m-d'), $id_pengguna)->result()
            ];
        }
        $json = json_encode($respon);
        echo $json;
        die;
    }

    private function _random($n)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $n; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }
        return $randomString;
    }

    public function add_belum_dikunjungi()
    {
        $api_key = htmlspecialchars($this->input->post('API-KEY'), true);
        $id_kunjungan = htmlspecialchars($this->input->post('id_kunjungan'), true);
        $keterangan_kunjungan = htmlspecialchars($this->input->post('keterangan_kunjungan'), true);
        $lat = htmlspecialchars($this->input->post('lat'), true);
        $long = htmlspecialchars($this->input->post('long'), true);
        $picture = $this->input->post('picture');

        if (!$api_key || !$id_kunjungan || !$keterangan_kunjungan || !$lat || !$long || !$picture) {
            $respon = [
                'status' => false,
                'message' => "Parameter not found"
            ];
            $json = json_encode($respon);
            echo $json;
            die;
        }

        $cek_api_key = $this->api_m->CekApiKey($api_key);
        if ($cek_api_key->num_rows() == 0) {
            $respon = [
                'status' => false,
                'message' => "Error API Key"
            ];
        } else {
            if (!empty($picture)) {
                $image = base64_decode($picture);
                $image_name = $this->_random(10);
                $filename = '.' . 'jpg';
                $path = "assets/img/kunjungan/" . $image_name;

                $this->load->helper("file");
                if (file_put_contents($path . $filename, $image)) {

                    $this->kunjungan->addKunjungan($id_kunjungan, $keterangan_kunjungan, $lat, $long, $image_name . '' . $filename);

                    $respon = [
                        'status' => true,
                        'message' => "Data berhasil diinputkan"
                    ];
                }
            }
        }
        $json = json_encode($respon);
        echo $json;
        die;
    }

    public function new_add_belum_dikunjungi()
    {
        $api_key = str_replace('"', ' ', htmlspecialchars($this->input->post('API-KEY'), true));
        $id_kunjungan = str_replace('"', ' ', htmlspecialchars($this->input->post('id_kunjungan'), true));
        $keterangan_kunjungan = str_replace('"', ' ', htmlspecialchars($this->input->post('keterangan_kunjungan'), true));
        $lat = str_replace('"', ' ', htmlspecialchars($this->input->post('lat'), true));
        $long = str_replace('"', ' ', htmlspecialchars($this->input->post('long'), true));

        if (!$api_key || !$id_kunjungan || !$keterangan_kunjungan) {
            $respon = [
                'status' => false,
                'message' => "Parameter not found"
            ];
            $json = json_encode($respon);
            echo $json;
            die;
        }

        $cek_api_key = $this->api_m->CekApiKey($api_key);
        if ($cek_api_key->num_rows() == 0) {
            $respon = [
                'status' => false,
                'message' => "Error API Key"
            ];
        } else {

            $data = json_decode(file_get_contents("php://input"), true);
            $fileName  =  $_FILES['sendimage']['name'];
            $tempPath  =  $_FILES['sendimage']['tmp_name'];
            $fileSize  =  $_FILES['sendimage']['size'];

            if (empty($fileName)) {
                $respon = [
                    'status' => false,
                    'message' => "Image in server not found"
                ];
            } else {
                $upload_path = 'assets/img/kunjungan/';
                $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

                $valid_extensions = array('jpeg', 'jpg', 'png', 'gif');

                if (in_array($fileExt, $valid_extensions)) {
                    if (!file_exists($upload_path . $fileName)) {
                        move_uploaded_file($tempPath, $upload_path . $fileName);

                        $this->kunjungan->addKunjungan(
                            $id_kunjungan,
                            $keterangan_kunjungan,
                            $lat,
                            $long,
                            $fileName
                        );

                        $respon = [
                            'status' => true,
                            'message' => "Data berhasil di inputkan"
                        ];
                    } else {

                        $respon = [
                            'status' => false,
                            'message' => "Invalid destination"
                        ];
                    }
                } else {

                    $respon = [
                        'status' => false,
                        'message' => "Invalid image"
                    ];
                }
            }

            $json = json_encode($respon);
            echo $json;
            die;
        }
    }

    public function akses_cepat()
    {
        date_default_timezone_set("Asia/Jakarta");
        $api_key = htmlspecialchars($this->input->post('API-KEY'), true);
        $id_pengguna = $this->input->post('id_pengguna');
        $nama_kunjungan = $this->input->post('nama_kunjungan');
        $alamat_kunjungan = $this->input->post('alamat_kunjungan');
        $no_telp_kunjungan = $this->input->post('no_telp_kunjungan');
        $picture = $this->input->post('picture');
        $keterangan_kunjungan = htmlspecialchars($this->input->post('keterangan_kunjungan'), true);
        $tgl = date('Y-m-d:H-i-s');
        $lat = htmlspecialchars($this->input->post('lat'), true);
        $long = htmlspecialchars($this->input->post('long'), true);

        if (
            !$api_key || !$id_pengguna || !$nama_kunjungan || !$alamat_kunjungan || !$no_telp_kunjungan ||
            !$keterangan_kunjungan || !$lat || !$long || !$picture
        ) {
            $respon = [
                'status' => false,
                'message' => "Parameter not found"
            ];
            $json = json_encode($respon);
            echo $json;
            die;
        }

        $cek_api_key = $this->api_m->CekApiKey($api_key);
        if ($cek_api_key->num_rows() == 0) {
            $respon = [
                'status' => false,
                'message' => "Error API Key"
            ];
        } else {
            if (!empty($picture)) {
                $image = base64_decode($picture);
                $image_name = $this->_random(10);
                $filename = '.' . 'jpg';
                $path = "assets/img/kunjungan/" . $image_name;

                $this->load->helper("file");
                if (file_put_contents($path . $filename, $image)) {

                    $this->kunjungan->addAksesCepat(
                        $id_pengguna,
                        $nama_kunjungan,
                        $alamat_kunjungan,
                        $no_telp_kunjungan,
                        $keterangan_kunjungan,
                        $tgl,
                        $lat,
                        $long,
                        $image_name . '' . $filename
                    );

                    $respon = [
                        'status' => true,
                        'message' => "Data berhasil diinputkan"
                    ];
                }
            }
        }
        $json = json_encode($respon);
        echo $json;
        die;
    }

    public function new_akses_cepat()
    {
        date_default_timezone_set("Asia/Jakarta");
        $api_key = str_replace('"', ' ', htmlspecialchars($this->input->post('API-KEY'), true));
        $id_pengguna = str_replace('"', ' ', $this->input->post('id_pengguna'));
        $nama_kunjungan = str_replace('"', ' ', $this->input->post('nama_kunjungan'));
        $alamat_kunjungan = str_replace('"', ' ', $this->input->post('alamat_kunjungan'));
        $no_telp_kunjungan = str_replace('"', ' ', $this->input->post('no_telp_kunjungan'));
        $keterangan_kunjungan = str_replace('"', ' ', htmlspecialchars($this->input->post('keterangan_kunjungan'), true));
        $tgl =date('Y-m-d:H-i-s');
        $lat = str_replace('"', ' ', $this->input->post('lat'));
        $long = str_replace('"', ' ', $this->input->post('long'));

        if (
            !$api_key || !$id_pengguna || !$nama_kunjungan || !$alamat_kunjungan || !$no_telp_kunjungan ||
            !$keterangan_kunjungan
        ) {
            $respon = [
                'status' => false,
                'message' => "Parameter not found"
            ];
            $json = json_encode($respon);
            echo $json;
            die;
        }

        $cek_api_key = $this->api_m->CekApiKey($api_key);
        if ($cek_api_key == 0) {
            $respon = [
                'status' => false,
                'message' => "Error API Key"
            ];
        } else {

            $data = json_decode(file_get_contents("php://input"), true);
            $fileName  =  $_FILES['sendimage']['name'];
            $tempPath  =  $_FILES['sendimage']['tmp_name'];
            $fileSize  =  $_FILES['sendimage']['size'];

            if (empty($fileName)) {
                $respon = [
                    'status' => false,
                    'message' => "Image in server not found"
                ];
            } else {
                $upload_path = 'assets/img/kunjungan/';
                $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

                $valid_extensions = array('jpeg', 'jpg', 'png', 'gif');

                if (in_array($fileExt, $valid_extensions)) {
                    if (!file_exists($upload_path . $fileName)) {
                        move_uploaded_file($tempPath, $upload_path . $fileName);

                        $this->kunjungan->addAksesCepat(
                            $id_pengguna,
                            $nama_kunjungan,
                            $alamat_kunjungan,
                            $no_telp_kunjungan,
                            $keterangan_kunjungan,
                            $tgl,
                            $lat,
                            $long,
                            $fileName
                        );

                        $respon = [
                            'status' => true,
                            'message' => "Data berhasil di inputkan"
                        ];
                    } else {

                        $respon = [
                            'status' => false,
                            'message' => "Invalid destination"
                        ];
                    }
                } else {

                    $respon = [
                        'status' => false,
                        'message' => "Invalid image"
                    ];
                }
            }
        }

        $json = json_encode($respon);
        echo $json;
        die;
    }

    public function telah_dikunjungi()
    {
        date_default_timezone_set("Asia/Jakarta");
        $api_key = htmlspecialchars($this->input->post('API-KEY'), true);
        $id_pengguna = htmlspecialchars($this->input->post('id_pengguna'), true);
        if (!$api_key || !$id_pengguna) {
            $respon = [
                'status' => false,
                'message' => "Parameter not found"
            ];
            $json = json_encode($respon);
            echo $json;
            die;
        }

        $cek_api_key = $this->api_m->CekApiKey($api_key);
        if ($cek_api_key->num_rows() == 0) {
            $respon = [
                'status' => false,
                'message' => "Error API Key"
            ];
        } else {
            $respon = [
                'status' => true,
                'message' => "Data berhasil ditampilkan",
                "tanggal" =>  $this->tgl_indo(date('Y-m-d')),
                "kunjungan_data" =>  $this->home->telahDikunjungi(date('Y-m-d'), $id_pengguna)->result()
            ];
        }
        $json = json_encode($respon);
        echo $json;
        die;
    }

    public function history_kunjungan()
    {
        date_default_timezone_set("Asia/Jakarta");
        $api_key = htmlspecialchars($this->input->post('API-KEY'), true);
        $id_pengguna = htmlspecialchars($this->input->post('id_pengguna'), true);
        $tgaw_no_convert = $this->input->post('tgaw');
        $tgak_no_convert = $this->input->post('tgak');

        $tgaw = date("Y-m-d", strtotime($tgaw_no_convert));
        $tgak = date("Y-m-d", strtotime($tgak_no_convert));

        if (!$api_key || !$id_pengguna || !$tgaw || !$tgak) {
            $respon = [
                'status' => false,
                'message' => "Parameter not found"
            ];
            $json = json_encode($respon);
            echo $json;
            die;
        }

        $cek_api_key = $this->api_m->CekApiKey($api_key);
        if ($cek_api_key->num_rows() == 0) {
            $respon = [
                'status' => false,
                'message' => "Error API Key"
            ];
        } else {
            $respon = [
                'status' => true,
                'message' => "Data berhasil ditampilkan",
                "tanggal" =>  $this->tgl_indo(date('Y-m-d')),
                "kunjungan_data" =>  $this->kunjungan->showKunjungan($id_pengguna, $tgaw, $tgak)->result()
            ];
        }
        $json = json_encode($respon);
        echo $json;
        die;
    }
}
/* End of file Kunjungan.php */
