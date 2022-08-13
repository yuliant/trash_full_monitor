<?php
defined('BASEPATH') or exit('No direct script access allowed');

class SP_dasbor_c extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index($id_barang = null)
    {

        $data['title'] = 'Dasbor';
        $idp = $this->session->userdata('idp');
        $data['user'] = $this->db->get_where('pengguna', ['EMAIL_PENGGUNA' => $this->session->userdata('email')])->row_array();
        $data['kunjungan'] = $this->db->query("SELECT COUNT(k.ID_KUNJUNGAN) AS tkj FROM kunjungan k join pengguna p ON p.ID_PENGGUNA = k.ID_PENGGUNA WHERE p.ATASAN_PENGGUNA = '$idp'")->row_array();
        $data['kunjungan_selesai'] = $this->db->query("SELECT COUNT(k.ID_KUNJUNGAN) AS tkj FROM kunjungan k join pengguna p ON p.ID_PENGGUNA = k.ID_PENGGUNA WHERE p.ATASAN_PENGGUNA = '$idp' AND k.STATUS_KUNJUNGAN ='1'")->row_array();
        $data['sales'] = $this->db->query("SELECT COUNT(ID_PENGGUNA) AS sales FROM pengguna where ID_HAK_AKSES ='4' AND ATASAN_PENGGUNA = '$idp' AND NAMA_PENGGUNA NOT IN (SELECT NAMA_PENGGUNA FROM pengguna where NAMA_PENGGUNA LIKE '%(MS)%')")->row_array();
        $data['spv'] = $this->db->query("SELECT COUNT(ID_PENGGUNA) AS spv FROM pengguna where ATASAN_PENGGUNA = '$idp' AND NAMA_PENGGUNA LIKE '%(MS)%'")->row_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('supervisor/dasbor', $data);
            $this->load->view('templates/footer');
    }

    public function dash_custom()
    {
        $idp = $this->session->userdata('idp');
        $tgaw = $this->input->post('tgaw');
        $tgak = $this->input->post('tgak');

        $kunjungan = $this->db->query("SELECT COUNT(k.ID_KUNJUNGAN) AS tkj FROM kunjungan k join pengguna p ON p.ID_PENGGUNA = k.ID_PENGGUNA WHERE p.ATASAN_PENGGUNA = '$idp' AND k.TGL_KUNJUNGAN BETWEEN '$tgaw' AND '$tgak'")->row_array();
        $kunjungan_selesai = $this->db->query("SELECT COUNT(k.ID_KUNJUNGAN) AS tkj FROM kunjungan k join pengguna p ON p.ID_PENGGUNA = k.ID_PENGGUNA WHERE p.ATASAN_PENGGUNA = '$idp' AND STATUS_KUNJUNGAN ='1' AND TGL_KUNJUNGAN BETWEEN '$tgaw' AND '$tgak'")->row_array();
        $sales = $this->db->query("SELECT COUNT(ID_PENGGUNA) AS sales FROM pengguna where ID_HAK_AKSES ='4'  AND ATASAN_PENGGUNA = '$idp' AND NAMA_PENGGUNA NOT IN (SELECT NAMA_PENGGUNA FROM pengguna where NAMA_PENGGUNA LIKE '%(MS)%')")->row_array();
        $spv = $this->db->query("SELECT COUNT(ID_PENGGUNA) AS spv FROM pengguna where ATASAN_PENGGUNA = '$idp' AND NAMA_PENGGUNA LIKE '%(MS)%'")->row_array();
    ?>

    <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Total Kunjungan</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $kunjungan['tkj']?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-chart-line fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        <center><a href="<?= base_url()?>/supervisor/kunjungan">Lihat Data</a></center>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Kunjungan Selesai</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $kunjungan_selesai['tkj']?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-chart-area fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        <center><a href="<?= base_url()?>/supervisor/kunjungan">Lihat Data</a></center>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Jumlah Sales
                                            </div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $sales['sales']?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-portrait fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        <center><a href="<?= base_url()?>/supervisor/sales">Lihat Data</a></center>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pending Requests Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Jumlah MS</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $spv['spv']?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-portrait fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        <center><a href="<?= base_url()?>/supervisor/sales">Lihat Data</a></center>
                                    </div>
                                </div>
                            </div>
                        </div>
    
    <?php
    }

}

/* End of file Barang_c.php */