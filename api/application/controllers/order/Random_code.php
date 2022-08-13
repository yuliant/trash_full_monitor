<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Random_code extends CI_Controller
{
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

	public function index()
	{
		echo $this->_random(20);
	}
}

/* End of file Random_code.php */
