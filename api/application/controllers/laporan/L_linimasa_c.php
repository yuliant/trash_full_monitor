<?php
defined('BASEPATH') or exit('No direct script access allowed');

class L_linimasa_c extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('sales/Surat_jalan_m', 'surat_jalan_m');
        $this->load->model('gudang/Barang_m', 'barang_m');
        $this->load->model('sales/Penjualan_m', 'penjualan_m');
        $this->load->model('sales/Pelanggan_m', 'pelanggan_m');
    }

    public function index()
    {
        $data['title'] = "Laporan Linimasa";

        //$data['user'] = $this->db->get_where('pengguna', ['EMAIL_PENGGUNA' => $this->session->userdata('email')])->row_array();
        $email = $this->session->userdata('email');
        $data['user'] = $this->db->query("SELECT * FROM pengguna pg JOIN hak_akses ha ON ha.ID_HAK_AKSES = pg.ID_HAK_AKSES WHERE pg.EMAIL_PENGGUNA = '$email'")->row_array();
        $data['penjualan'] = $this->penjualan_m->TampilData()->result();
        $data['pelanggan'] = $this->pelanggan_m->TampilData()->result();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('laporan/linimasa', $data);
        $this->load->view('templates/footer');
    }

    public function view()
    {
        $tgaw = $this->input->post('tgaw');
        $tgak = $this->input->post('tgak');
        $idsales = $this->input->post('idsales');
	
      $data = $this->db->query("SELECT * FROM gps_lokasi WHERE ID_PENGGUNA = '$idsales' AND TANGGAL BETWEEN '$tgaw' AND '$tgak' ORDER BY TANGGAL ASC")->result();
    
	?>
    <div>
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Linimasa Sales</h6>
            </div>
            <div class="card-body" style="overflow-y: scroll; height:450px">
                <div class="timeline" style="margin-left:50px;">
                 <?php 
                 foreach ($data as $dt) {
                   // code...
                 ?>
                  <div class="container2 right">
                    <div class="content2">
                      <!--<p style="font-size:20px; font-family:sans-serif; color:#5a5c69;">Kevin Frozen Food Sidoarjo</p>-->
                      <p style="font-size:14px; font-family:sans-serif; color:#5a5c69;"><a href="<?php echo base_url(); ?>laporan/linimasa_map/<?php echo $dt->ID_PENGGUNA; ?>" target="_blank"><?php echo $dt->NAMA_LOKASI;?></a></p>
                      <p style="font-size:12px; font-family:sans-serif; margin-top:-10px; color:#5a5c69; text-align:right;"><?php echo date('d F Y', strtotime($dt->TANGGAL))?> / <?php echo date('H:i', strtotime($dt->TANGGAL))?> WIB</p>
                    </div>
                  </div>
                 <?php } ?>
                </div>
            </div>
        </div>
    </div>

<?php
}
    public function map($idsales)
    {
        // $data['title'] = "Laporan Linimasa";

        //$data['user'] = $this->db->get_where('pengguna', ['EMAIL_PENGGUNA' => $this->session->userdata('email')])->row_array();
        // $email = $this->session->userdata('email');
        $data['longlat'] = $this->db->query("SELECT * FROM gps_lokasi WHERE ID_PENGGUNA = '$idsales'")->row_array();
        
        // $this->load->view('templates/header', $data);
        // $this->load->view('templates/sidebar', $data);
        // $this->load->view('templates/topbar', $data);
        $this->load->view('laporan/lap_map', $data);
        // $this->load->view('templates/footer');
    }
}
/* End of file Supplier_c.php */
