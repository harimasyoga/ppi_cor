<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Plan extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('status') != "login") {
			redirect(base_url("Login"));
		}
		$this->load->model('m_plan');
	}

	function Corrugator()
	{
		$this->load->view('header');
		$jenis = $this->uri->segment(3);
		if($jenis == 'Add'){
			$this->load->view('Plan/Cor/v_corr_add');
		}else{
			$this->load->view('Plan/Cor/v_corr');
		}
		$this->load->view('footer');
	}

	function loadPlanWo()
	{
		$getWo = $this->db->query("SELECT w.*,i.*,s.*,p.nm_pelanggan,s.id AS idSoDetail,w.id AS idWo,w.creasing2 AS creasing2wo FROM trs_wo w
		INNER JOIN m_pelanggan p ON w.id_pelanggan=p.id_pelanggan
		INNER JOIN m_produk i ON w.id_produk=i.id_produk
		INNER JOIN trs_so_detail s ON w.no_po=s.no_po AND w.kode_po=s.kode_po AND w.id_pelanggan=s.id_pelanggan AND w.id_produk=s.id_produk
		WHERE w.status='Open'
		AND w.no_so=CONCAT(s.no_so,'.',s.urut_so,'.',s.rpt)
		GROUP BY w.id,w.id_pelanggan,w.id_produk,p.id_pelanggan,i.id_produk,s.id
		ORDER BY p.nm_pelanggan")->result();
		echo json_encode(array(
			'wo' => $getWo
		));
	}

	//

	function Flexo()
	{
		$this->load->view('header');
		$this->load->view('Plan/Flexo/v_flexo');
		$this->load->view('footer');
	}

	//

	function Finishing()
	{
		$this->load->view('header');
		$this->load->view('Plan/Finishing/v_finishing');
		$this->load->view('footer');
	}

}
