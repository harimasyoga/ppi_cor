<?php
class M_laporan extends CI_Model
{

	function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		$this->username = $this->session->userdata('username');
	}

	function get_periode()
	{
		$query = $this->db->query("SELECT DATE_FORMAT(tgl,'%Y-%m') periode FROM tr_absensi GROUP BY DATE_FORMAT(tgl,'%Y-%m') ORDER BY periode DESC");
		return $query;
	}

	function get_produk($searchTerm = "", $jenis)
	{
		if ($jenis == "Produk") {
			$table = "m_produk";
			$id = "id_produk";
			$text = "nm_produk";
		} else {
			$table = "m_perawatan";
			$id = "id_perawatan";
			$text = "nm_perawatan";
		}
		$users = $this->db->query("SELECT * FROM $table where $text like '%$searchTerm%' ")->result_array();
		$data = array();
		array_push(
			$data,
			['id' => "-", 'text' => "Semua"]
		);
		foreach ($users as $user) {
			$data[] = array(
				"id" => $user[$id],
				"text" => $user[$text]
			);
		}
		return $data;
	}

	function addReturKiriman()
	{
		$h_tot_muat = $_POST["h_tot_muat"];
		$h_tgl = $_POST["h_tgl"];
		$h_id_pelanggan = $_POST["h_id_pelanggan"];
		$h_id_produk = $_POST["h_id_produk"];
		$h_kode_po = $_POST["h_kode_po"];
		$h_urut = $_POST["h_urut"];
		$h_no_surat = $_POST["h_no_surat"];
		$h_plat = $_POST["h_plat"];
		$rtr_tgl = $_POST["rtr_tgl"];
		$rtr_ket = $_POST["rtr_ket"];
		$rtr_jumlah = $_POST["rtr_jumlah"];

		if($rtr_tgl == ""){
			$data = false;
			$msg = "TANGGAL TIDAK BOLEH KOSONG!";
		}else if($rtr_ket == ""){
			$data = false;
			$msg = "KETERANGAN TIDAK BOLEH KOSONG!";
		}else if($rtr_jumlah == "" || $rtr_jumlah < 0 || $rtr_jumlah == 0){
			$data = false;
			$msg = "JUMLAH TIDAK BOLEH KOSONG!";
		}else if($rtr_jumlah > $h_tot_muat){
			$data = false;
			$msg = "RETUR MELEBIHI JUMLAH MUAT!";
		}else{
			$retur = array(
				'rtr_tgl' => $h_tgl,
				'rtr_id_pelanggan' => $h_id_pelanggan,
				'rtr_id_produk' => $h_id_produk,
				'rtr_kode_po' => $h_kode_po,
				'rtr_urut' => $h_urut,
				'rtr_no_surat' => $h_no_surat,
				'rtr_plat' => $h_plat,
				'rtr_jumlah' => $rtr_jumlah,
				'rtr_ket' => $rtr_ket,
				'time' => date('Y-m-d H:i:s'),
			);
			$data = $this->db->insert('m_rencana_kirim_retur', $retur);
			$msg = "DATA RETUR DITAMBAHKAN!";
		}

		return [
			'data' => $data,
			'msg' => $msg,
		];
	}

	function deleteReturkiriman()
	{
		$this->db->where('id', $_POST["id"]);
		$data = $this->db->delete('m_rencana_kirim_retur');
		return [
			'data' => $data,
		];
	}

	function addGudangLap()
	{
		$id = $_POST["id"];
		$opsi = $_POST["opsi"];
		$poDtl = $this->db->query("SELECT*FROM trs_po_detail WHERE id='$id'")->row();

		if($opsi == 'OPEN'){
			$hasil = $poDtl->qty + ($poDtl->qty * 0.1);
			$edd = [
				'gd_id_pelanggan' => $poDtl->id_pelanggan,
				'gd_id_produk' => $poDtl->id_produk,
				'gd_id_trs_wo' => null,
				'gd_id_plan_cor' => null,
				'gd_id_plan_flexo' => null,
				'gd_id_plan_finishing' => null,
				'gd_kode_po' => $poDtl->kode_po,
				'gd_berat_box' => $poDtl->bb,
				'gd_hasil_plan' => $hasil,
				'gd_good_qty' => $hasil,
				'gd_reject_qty' => 0,
				'gd_cek_spv' => 'Close',
				'gd_status' => 'Open',
				'add_time' => date('Y-m-d H:i:s'),
				'add_user' => $this->username,
			];
			$data = $this->db->insert('m_gudang', $edd);
		}
		if($opsi == 'CLOSE'){
			$gd = $this->db->query("SELECT*FROM m_gudang WHERE gd_id_pelanggan='$poDtl->id_pelanggan' AND gd_id_produk='$poDtl->id_produk' AND gd_kode_po='$poDtl->kode_po'");
			$edd = 'CLOSE';
			foreach($gd->result() as $r){
				$this->db->set('gd_status', 'Close');
				$this->db->where('id_gudang', $r->id_gudang);
				$data = $this->db->update('m_gudang');
			}
		}

		return [
			'edd' => $edd,
			'data' => $data,
		];
	}
}
