<?php
class M_plan extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		$this->load->model('m_master');
		$this->load->model('m_transaksi');
		$this->load->model('m_plan');
	}


}
