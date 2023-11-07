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

	function loadPlanWo()
	{
		$opsi = $_POST["opsi"];
		if($opsi != ''){
			$query = $this->db->query("SELECT * FROM plan_cor pl
			INNER JOIN m_produk i ON pl.id_produk=i.id_produk
			INNER JOIN m_pelanggan l ON pl.id_pelanggan=l.id_pelanggan
			INNER JOIN m_sales m ON l.id_sales=m.id_sales
			INNER JOIN trs_wo w ON pl.id_wo=w.id
			INNER JOIN trs_so_detail s ON pl.id_so_detail=s.id
			WHERE pl.id_wo='$opsi'");
		}else{
			$query = $this->db->query("SELECT w.*,i.*,s.*,o.tgl_po,o.total_qty,p.nm_pelanggan,m.nm_sales,s.id AS idSoDetail,w.id AS idWo,w.creasing2 AS creasing2wo FROM trs_wo w
			INNER JOIN m_pelanggan p ON w.id_pelanggan=p.id_pelanggan
			INNER JOIN m_sales m ON p.id_sales=m.id_sales
			INNER JOIN m_produk i ON w.id_produk=i.id_produk
			INNER JOIN trs_po o ON w.no_po=o.no_po AND w.kode_po=o.kode_po
			INNER JOIN trs_so_detail s ON w.no_po=s.no_po AND w.kode_po=s.kode_po AND w.id_pelanggan=s.id_pelanggan AND w.id_produk=s.id_produk
			WHERE w.status='Open'
			AND w.no_so=CONCAT(s.no_so,'.',s.urut_so,'.',s.rpt)
			GROUP BY w.id,w.id_pelanggan,w.id_produk,p.id_pelanggan,i.id_produk,s.id
			ORDER BY p.nm_pelanggan");
		}

		return $query;
	}

	function simpanCartItem()
	{
		foreach($this->cart->contents() as $r){
			$data = array(
				'id_so_detail' => $r["options"]["id_so_detail"],
				'id_wo' => $r["options"]["id_wo"],
				'id_produk' => $r["options"]["id_produk"],
				'id_pelanggan' => $r["options"]["id_pelanggan"],
				'no_wo' => $r["options"]["no_wo"],
				'no_so' => $r["options"]["no_so"],
				'pcs_plan' => $r["options"]["pcs_plan"],
				'tgl_plan' => $r["options"]["tgl_plan"],
				'machine_plan' => $r["options"]["machine_plan"],
				'shift_plan' => $r["options"]["shift_plan"],
				'tgl_kirim_plan' => $r["options"]["tgl_kirim_plan"],
				'next_plan' => $r["options"]["next_plan"],
				'lebar_roll_p' => $r["options"]["lebar_roll_p"],
				'panjang_plan' => $r["options"]["panjang_plan"],
				'lebar_plan' => $r["options"]["lebar_plan"],
				'out_plan' => $r["options"]["out_plan"],
				'trim_plan' => $r["options"]["trim_plan"],
				'c_off_p' => $r["options"]["c_off_p"],
				'rm_plan' => $r["options"]["rm_plan"],
				'tonase_plan' => $r["options"]["tonase_plan"],
				'material_plan' => $r["options"]["material_plan"],
				'kualitas_plan' => $r["options"]["kualitas_plan"],
				'kualitas_isi_plan' => $r["options"]["kualitas_isi_plan"],
				'status_plan' => 'Open',
				'good_cor_p' => 0,
				'bad_cor_p' => 0,
				'total_cor_p' => 0,
				'ket_plan' => '',
				'add_user' => $this->session->userdata('username'),
			);
			$result = $this->db->insert('plan_cor', $data);
		}

		return $result;
	}
}
