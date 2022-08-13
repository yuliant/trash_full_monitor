<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_m extends CI_Model 
{
    public function CekApiKey($api_key)
    {
        $this->db->from('keys');
        $this->db->where('key ', $api_key);
        $query = $this->db->get();
        return $query;
    }
}

/* End of file Api_m.php */
