<?php
class M_logistik extends CI_Model
{

	function __construct()
	{
		parent::__construct();

		date_default_timezone_set('Asia/Jakarta');
		$this->username = $this->session->userdata('username');
		$this->waktu    = date('Y-m-d H:i:s');
		$this->load->model('m_master');
	}

	function save_invoice()
	{
		$cek_inv        = $this->input->post('cek_inv');
		$c_no_inv_tgl   = $this->input->post('no_inv_tgl');

		$type           = $this->input->post('type_po');
		$pajak          = $this->input->post('pajak');
		$tgl_inv        = $this->input->post('tgl_inv');
		$tanggal        = explode('-',$tgl_inv);
		$tahun          = $tanggal[0];

		($type=='roll')? $type_ok=$type : $type_ok='SHEET_BOX';
		
		($pajak=='nonppn')? $pajak_ok='non' : $pajak_ok='ppn';
		$c_no_inv_kd   = $this->input->post('no_inv_kd');

		if($cek_inv=='revisi')
		{
			$c_no_inv    = $this->input->post('no_inv');
			$m_no_inv    = $c_no_inv_kd.''.$c_no_inv.''.$c_no_inv_tgl;
		}else{
			$c_no_inv    = $this->m_fungsi->tampil_no_urut($type_ok.'_'.$pajak_ok.'_'.$tahun);
			$m_no_inv    = $c_no_inv_kd.''.$c_no_inv.''.$c_no_inv_tgl;
		}

		$data_header = array(
			'no_invoice'         => $m_no_inv,
			'type'               => $this->input->post('type_po'),
			'cek_inv'    		 => $cek_inv,
			'tgl_invoice'        => $this->input->post('tgl_inv'),
			'tgl_sj'             => $this->input->post('tgl_sj'),
			'pajak'              => $this->input->post('pajak'),
			'inc_exc'            => $this->input->post('inc_exc'),
			'tgl_jatuh_tempo'    => $this->input->post('tgl_tempo'),
			'id_perusahaan'      => $this->input->post('id_perusahaan'),
			'kepada'             => $this->input->post('kpd'),
			'nm_perusahaan'      => $this->input->post('nm_perusahaan'),
			'alamat_perusahaan'  => $this->input->post('alamat_perusahaan'),
			'bank'  			 => $this->input->post('bank'),
			'acc_admin'          => 'Y',
		);
	
		$result_header = $this->db->insert('invoice_header', $data_header);

		$db2              = $this->load->database('database_simroll', TRUE);
		$tgl_sj           = $this->input->post('tgl_sj');
		$id_perusahaan    = $this->input->post('id_perusahaan');

		if ($type == 'roll')
		{
			$query = $db2->query("SELECT c.nm_perusahaan,a.id_pl,b.id,a.nm_ker,a.g_label,a.width,COUNT(a.roll) AS qty,SUM(weight)-SUM(seset) AS weight,b.no_po,b.no_po_sj,b.no_surat
			FROM m_timbangan a 
			INNER JOIN pl b ON a.id_pl = b.id 
			LEFT JOIN m_perusahaan c ON b.id_perusahaan=c.id
			WHERE b.no_pl_inv = '0' AND b.tgl='$tgl_sj' AND b.id_perusahaan='$id_perusahaan'
			GROUP BY b.no_po,a.nm_ker,a.g_label,a.width 
			ORDER BY a.g_label,b.no_surat,b.no_po,a.nm_ker DESC,a.g_label,a.width ")->result();

			$no = 1;
			foreach ( $query as $row ) 
			{

				$cek = $this->input->post('aksi['.$no.']');
				if($cek == 1)
				{
					$harga_ok    = $this->input->post('hrg['.$no.']');
					$harga_inc   = $this->input->post('inc['.$no.']');
					$harga_inc1  = str_replace('.','',$harga_inc);

					$hasil_ok    = $this->input->post('hasil['.$no.']');
					$id_pl_roll  = $this->input->post('id_pl_roll['.$no.']');
					$data = [					
						'no_invoice'   => $m_no_inv,
						'type'         => $type,
						'no_surat'     => $this->input->post('no_surat['.$no.']'),
						'nm_ker'       => $this->input->post('nm_ker['.$no.']'),
						'g_label'      => $this->input->post('g_label['.$no.']'),
						'width'        => $this->input->post('width['.$no.']'),
						'qty'          => $this->input->post('qty['.$no.']'),
						'retur_qty'    => $this->input->post('retur_qty['.$no.']'),
						'id_pl'        => $id_pl_roll,
						'harga'        => str_replace('.','',$harga_ok),
						'include'      => str_replace(',','.',$harga_inc1),
						'weight'       => $this->input->post('weight['.$no.']'),
						'seset'        => $this->input->post('seset['.$no.']'),
						'hasil'        => str_replace('.','',$hasil_ok),
						'no_po'        => $this->input->post('no_po['.$no.']'),
					];

					$update_no_pl   = $db2->query("UPDATE pl set no_pl_inv = 1 where id ='$id_pl_roll'");

					$result_rinci   = $this->db->insert("invoice_detail", $data);

				}
				$no++;
			}
		}else{
			if ($type == 'box')
			{				
				$where_po    = 'and d.po ="box"';
			}else{
				$where_po    = 'and d.po is null';
			}
			
			$query = $db2->query("SELECT b.id as id_pl, a.qty, a.qty_ket, b.tgl, b.id_perusahaan, c.nm_perusahaan, b.no_surat, b.no_po, b.no_kendaraan, d.item, d.kualitas, d.ukuran2,d.ukuran, 
			d.flute, d.po
			FROM m_box a 
			JOIN pl_box b ON a.id_pl = b.id 
			LEFT JOIN m_perusahaan c ON b.id_perusahaan=c.id
			JOIN po_box_master d ON b.no_po=d.no_po and a.ukuran=d.ukuran
			WHERE b.no_pl_inv = '0' AND b.tgl = '$tgl_sj' AND b.id_perusahaan='$id_perusahaan' $where_po
			ORDER BY b.tgl desc ")->result();
			
			$no = 1;
			foreach ( $query as $row ) 
			{			

				$cek = $this->input->post('aksi['.$no.']');
				if($cek == 1)
				{
					$harga_ok    = $this->input->post('hrg['.$no.']');
					$harga_inc   = $this->input->post('inc['.$no.']');
					$harga_inc1  = str_replace('.','',$harga_inc);

					$hasil_ok    = $this->input->post('hasil['.$no.']');
					$id_pl_roll  = $this->input->post('id_pl_roll['.$no.']');
					$data = [					
						'no_invoice'   => $m_no_inv,
						'type'         => $type,
						'no_surat'     => $this->input->post('no_surat['.$no.']'),
						'nm_ker'       => $this->input->post('item['.$no.']'),
						'g_label'      => $this->input->post('ukuran['.$no.']'),
						'kualitas'      => $this->input->post('kualitas['.$no.']'),
						'qty'          => $this->input->post('qty['.$no.']'),
						'retur_qty'    => $this->input->post('retur_qty['.$no.']'),
						'id_pl'        => $id_pl_roll,
						'harga'        => str_replace('.','',$harga_ok),
						'include'      => str_replace(',','.',$harga_inc1),
						'hasil'        => str_replace('.','',$hasil_ok),
						'no_po'        => $this->input->post('no_po['.$no.']'),
					];

					$update_no_pl   = $db2->query("UPDATE pl_box set no_pl_inv = 1 where id ='$id_pl_roll'");

					// input stok berjalan HUB
					
					// $cek_po = $this->db->query("SELECT*FROM ");
					// stok_bahanbaku($this->input->post('no_po['.$no.']'), $cekPO->id_hub, $this->input->post('tgl_inv'), 'HUB', 0, str_replace('.','',$hasil_ok), 'KELUAR DENGAN INV', 'KELUAR');

					$result_rinci   = $this->db->insert("invoice_detail", $data);

				}
				$no++;
			}
		}

		if($result_rinci){
			$query = $this->db->query("SELECT*FROM invoice_header where no_invoice ='$m_no_inv' ")->row();
			return $query->id;
		}else{
			return 0;

		}
			
	}
	
	function save_byr_invoice()
	{
		$status_input = $this->input->post('sts_input');
		if($status_input == 'add')
		{

			$data_header = array(
				'id_invoice_h'   => $this->input->post('id_invoice_h'),
				'id_perusahaan'  => $this->input->post('id_perusahaan'),
				'tgl_sj'         => $this->input->post('tgl_inv'),
				'no_inv'         => $this->input->post('no_inv'),
				'tgl_inv'        => $this->input->post('tgl_inv'),
				'alasan_retur'   => $this->input->post('alasan'),
				'total_inv'      => str_replace('.','',$this->input->post('total_inv')),
				'tgl_jt'         => $this->input->post('tgl_jt'),
				'tgl_bayar'      => $this->input->post('tgl_byr'),
				'jumlah_bayar'   => str_replace('.','',$this->input->post('jml_byr')),
				'status_jt'      => $this->input->post('status_jt'),
				'status_lunas'   => $this->input->post('sts_lunas'),
				'sales'          => $this->input->post('sales'),
				'TOP'            => $this->input->post('top'),
			);
		
			$result_header = $this->db->insert('trs_bayar_inv', $data_header);
			
		}else{

			$data_header = array(
				'id_invoice_h'   => $this->input->post('id_invoice_h'),
				'id_perusahaan'  => $this->input->post('id_perusahaan'),
				'tgl_sj'         => $this->input->post('tgl_inv'),
				'no_inv'         => $this->input->post('no_inv'),
				'tgl_inv'        => $this->input->post('tgl_inv'),
				'alasan_retur'   => $this->input->post('alasan'),
				'total_inv'      => str_replace('.','',$this->input->post('total_inv')),
				'tgl_jt'         => $this->input->post('tgl_jt'),
				'tgl_bayar'      => $this->input->post('tgl_byr'),
				'jumlah_bayar'   => str_replace('.','',$this->input->post('jml_byr')),
				'status_jt'      => $this->input->post('status_jt'),
				'status_lunas'   => $this->input->post('sts_lunas'),
				'sales'          => $this->input->post('sales'),
				'TOP'            => $this->input->post('top'),
			);
		
			$this->db->where('id_bayar_inv', $this->input->post('id_byr_inv'));
			$result_header = $this->db->update('trs_bayar_inv', $data_header);
			
		}
		return $result_header;
		

			
	}

	function loadGudang()
	{
		$opsi = $_POST["opsi"];
		if($opsi == 'cor'){
			$where = "AND g.gd_id_plan_cor!='0' AND g.gd_id_plan_flexo IS NULL AND g.gd_id_plan_finishing IS NULL";
		}else if($opsi == 'flexo'){
			$where = "AND g.gd_id_plan_cor!='0' AND g.gd_id_plan_flexo!='0' AND g.gd_id_plan_finishing IS NULL";
		}else if($opsi == 'finishing'){
			$where = "AND g.gd_id_plan_cor!='0' AND g.gd_id_plan_flexo!='0' AND g.gd_id_plan_finishing!='0'";
		}else{
			$where = "";
		}

		$data = $this->db->query("SELECT COUNT(g.id_gudang) AS jml,p.nm_pelanggan,i.nm_produk,g.* FROM m_gudang g
		INNER JOIN m_produk i ON g.gd_id_produk=i.id_produk
		INNER JOIN m_pelanggan p ON g.gd_id_pelanggan=p.id_pelanggan
		INNER JOIN trs_wo w ON g.gd_id_trs_wo=w.id
		INNER JOIN trs_po t ON w.kode_po=t.kode_po
		WHERE g.gd_cek_spv='Open' AND t.status_kiriman='Open' $where
		GROUP BY p.nm_pelanggan,g.gd_id_produk");

		return [
			'data' => $data->result(),
			'opsi' => $opsi,
			'id_pelanggan' => $_POST["id_pelanggan"],
			'id_produk' => $_POST["id_produk"],
		];
	}

	function loadListProduksiPlan()
	{
		$opsi = $_POST["opsi"];
		$id_pelanggan = $_POST["id_pelanggan"];
		$id_produk = $_POST["id_produk"];

		if($opsi == 'cor'){
			$data = $this->db->query("SELECT w.kode_po,COUNT(g.id_gudang) AS jml_gd,g.* FROM m_gudang g
			INNER JOIN plan_cor c ON g.gd_id_plan_cor=c.id_plan
			INNER JOIN trs_wo w ON g.gd_id_trs_wo=w.id
			INNER JOIN trs_po t ON w.kode_po=t.kode_po
			WHERE g.gd_id_pelanggan='$id_pelanggan' AND g.gd_id_produk='$id_produk' AND t.status_kiriman='Open'
			AND g.gd_id_plan_cor IS NOT NULL AND g.gd_id_plan_flexo IS NULL AND g.gd_id_plan_finishing IS NULL AND g.gd_cek_spv='Open' 
			GROUP BY g.gd_id_pelanggan,g.gd_id_produk,w.kode_po");
		}else if($opsi == 'flexo'){
			$data = $this->db->query("SELECT w.kode_po,COUNT(g.id_gudang) AS jml_gd,g.* FROM m_gudang g
			INNER JOIN plan_flexo fx ON g.gd_id_plan_cor=fx.id_plan_cor AND g.gd_id_plan_flexo=fx.id_flexo
			INNER JOIN trs_wo w ON g.gd_id_trs_wo=w.id
			INNER JOIN trs_po t ON w.kode_po=t.kode_po
			WHERE g.gd_id_pelanggan='$id_pelanggan' AND g.gd_id_produk='$id_produk' AND t.status_kiriman='Open'
			AND g.gd_id_plan_cor IS NOT NULL AND g.gd_id_plan_flexo IS NOT NULL AND g.gd_id_plan_finishing IS NULL AND g.gd_cek_spv='Open' 
			GROUP BY g.gd_id_pelanggan,g.gd_id_produk,w.kode_po");
		}else{
			$data = $this->db->query("SELECT w.kode_po,COUNT(g.id_gudang) AS jml_gd,g.* FROM m_gudang g
			INNER JOIN plan_finishing fs ON g.gd_id_plan_cor=fs.id_plan_cor AND g.gd_id_plan_flexo=fs.id_plan_flexo AND g.gd_id_plan_finishing=fs.id_fs
			INNER JOIN trs_wo w ON g.gd_id_trs_wo=w.id
			INNER JOIN trs_po t ON w.kode_po=t.kode_po
			WHERE g.gd_id_pelanggan='$id_pelanggan' AND g.gd_id_produk='$id_produk' AND t.status_kiriman='Open'
			AND g.gd_id_plan_cor IS NOT NULL AND g.gd_id_plan_flexo IS NOT NULL AND g.gd_id_plan_finishing IS NOT NULL AND g.gd_cek_spv='Open' 
			GROUP BY g.gd_id_pelanggan,g.gd_id_produk,w.kode_po");
		}

		return $data;
	}

	function clickHasilProduksiPlan()
	{
		$opsi = $_POST["opsi"];
		$id_pelanggan = $_POST["id_pelanggan"];
		$id_produk = $_POST["id_produk"];
		$no_po = $_POST["no_po"];

		if($opsi == 'cor'){
			$data = $this->db->query("SELECT g.*,c.* FROM m_gudang g
			INNER JOIN plan_cor c ON g.gd_id_plan_cor=c.id_plan
			INNER JOIN trs_wo w ON g.gd_id_trs_wo=w.id
			INNER JOIN trs_po t ON w.kode_po=t.kode_po
			WHERE g.gd_id_pelanggan='$id_pelanggan' AND g.gd_id_produk='$id_produk' AND w.kode_po='$no_po' AND t.status_kiriman='Open'
			AND g.gd_id_plan_cor IS NOT NULL AND g.gd_id_plan_flexo IS NULL AND g.gd_id_plan_finishing IS NULL
			ORDER BY c.tgl_plan");
		}else if($opsi == 'flexo'){
			$data = $this->db->query("SELECT g.*,fx.* FROM m_gudang g
			INNER JOIN plan_flexo fx ON g.gd_id_plan_cor=fx.id_plan_cor AND g.gd_id_plan_flexo=fx.id_flexo
			INNER JOIN trs_wo w ON g.gd_id_trs_wo=w.id
			INNER JOIN trs_po t ON w.kode_po=t.kode_po
			WHERE g.gd_id_pelanggan='$id_pelanggan' AND g.gd_id_produk='$id_produk' AND w.kode_po='$no_po' AND t.status_kiriman='Open'
			AND g.gd_id_plan_cor IS NOT NULL AND g.gd_id_plan_flexo IS NOT NULL AND g.gd_id_plan_finishing IS NULL
			ORDER BY fx.tgl_flexo");
		}else{
			$data = $this->db->query("SELECT g.*,fs.* FROM m_gudang g
			INNER JOIN plan_finishing fs ON g.gd_id_plan_cor=fs.id_plan_cor AND g.gd_id_plan_flexo=fs.id_plan_flexo AND g.gd_id_plan_finishing=fs.id_fs
			INNER JOIN trs_wo w ON g.gd_id_trs_wo=w.id
			INNER JOIN trs_po t ON w.kode_po=t.kode_po
			WHERE g.gd_id_pelanggan='$id_pelanggan' AND g.gd_id_produk='$id_produk' AND w.kode_po='$no_po' AND t.status_kiriman='Open'
			AND g.gd_id_plan_cor IS NOT NULL AND g.gd_id_plan_flexo IS NOT NULL AND g.gd_id_plan_finishing IS NOT NULL
			ORDER BY fs.tgl_fs");
		}

		return $data;
	}

	function simpanGudang()
	{
		$id_gudang = $_POST["id_gudang"];
		$good = $_POST["good"];
		$reject = $_POST["reject"];
		$opsi = $_POST["opsi"];
		$id_pelanggan = $_POST["id_pelanggan"];
		$id_produk = $_POST["id_produk"];
		$no_po = $_POST["no_po"];
		$i = $_POST["i"];

		// UPDATE GUDANG
		if($good < 0 || $good == 0 || $good == ""){
			$data = false;
			$msg = "HASIL TIDAK BOLEH KOSONG!";
		}else if($reject < 0 || $reject == ""){
			$data = false;
			$msg = "REJECT HARUS DIISI!";
		}else{
			$this->db->set("gd_good_qty", $good);
			$this->db->set("gd_reject_qty", $reject);
			$this->db->set("gd_cek_spv", 'Close');
			$this->db->where("id_gudang", $id_gudang);
			$data = $this->db->update("m_gudang");
			$msg = "OK!";
		}

		if($opsi == 'cor'){
			$where = "AND g.gd_id_plan_cor!='0' AND g.gd_id_plan_flexo IS NULL AND g.gd_id_plan_finishing IS NULL";
		}else if($opsi == 'flexo'){
			$where = "AND g.gd_id_plan_cor!='0' AND g.gd_id_plan_flexo!='0' AND g.gd_id_plan_finishing IS NULL";
		}else if($opsi == 'finishing'){
			$where = "AND g.gd_id_plan_cor!='0' AND g.gd_id_plan_flexo!='0' AND g.gd_id_plan_finishing!='0'";
		}else{
			$where = "";
		}
		// UPDATE HEADER SPAN
		$h_span = $this->db->query("SELECT COUNT(g.id_gudang) AS h_jml FROM m_gudang g
		INNER JOIN m_pelanggan p ON g.gd_id_pelanggan=p.id_pelanggan
		INNER JOIN trs_wo w ON g.gd_id_trs_wo=w.id
		INNER JOIN trs_po t ON w.kode_po=t.kode_po
		WHERE g.gd_cek_spv='Open' AND g.gd_id_pelanggan='$id_pelanggan' AND g.gd_id_produk='$id_produk' AND t.status_kiriman='Open' $where
		GROUP BY p.nm_pelanggan,g.gd_id_produk")->row();
		// UPDATE ISI SPAN
		$i_span = $this->db->query("SELECT COUNT(g.id_gudang) AS i_jml FROM m_gudang g
		INNER JOIN trs_wo w ON g.gd_id_trs_wo=w.id
		INNER JOIN trs_po t ON w.kode_po=t.kode_po
		WHERE g.gd_cek_spv='Open' AND g.gd_id_pelanggan='$id_pelanggan' AND g.gd_id_produk='$id_produk' AND w.kode_po='$no_po' AND t.status_kiriman='Open' $where 
		GROUP BY g.gd_id_pelanggan,g.gd_id_produk,w.kode_po")->row();

		return [
			'data' => $data,
			'msg' => $msg,
			'h_span' => $h_span,
			'i_span' => $i_span,
			'i' => $i,
		];
	}

	function closeGudang()
	{
		// GET DATA
		$kode_po = $_POST["kode_po"];
		$getPO = $this->db->query("SELECT*FROM m_gudang g
		INNER JOIN trs_wo w ON g.gd_id_trs_wo=w.id
		WHERE w.kode_po='$kode_po'");
		foreach($getPO->result() as $po){
			$this->db->set('gd_status', 'Close');
			$this->db->where('id_gudang', $po->id_gudang);
			$updateGudang = $this->db->update('m_gudang');
		}

		// GET DATA
		$id_gudang = $_POST["id_gudang"];
		$getData = $this->db->query("SELECT p.nm_pelanggan,i.nm_produk,g.* FROM m_gudang g
		INNER JOIN m_pelanggan p ON g.gd_id_pelanggan=p.id_pelanggan
		INNER JOIN m_produk i ON g.gd_id_produk=i.id_produk
		WHERE g.id_gudang='$id_gudang'")->row();

		return [
			'data' => $updateGudang,
			'gd_id_pelanggan' => $getData->gd_id_pelanggan,
			'gd_id_produk' => $getData->gd_id_produk,
			'nm_pelanggan' => $getData->nm_pelanggan,
			'nm_produk' => $getData->nm_produk,
		];
	}

	//

	function simpanCartRKSJ()
	{
		foreach($this->cart->contents() as $r){
			$data = array(
				'rk_tgl' => date('Y-m-d'),
				'id_pelanggan' => $r['options']['id_pelanggan'],
				'id_produk' => $r['options']['id_produk'],
				'kategori' => $r['options']['kategori'],
				'id_gudang' => $r['options']['id_gudang'],
				'qty_muat' => $r['options']['qty_muat'],
				'rk_tonase' => $r['options']['rk_tonase'],
				'rk_kode_po' => $r['options']['rk_kode_po'],
				'rk_bb' => $r['options']['rk_bb'],
			);
			$insertRencanaKirim = $this->db->insert('m_rencana_kirim', $data);
		}

		return [
			'insertRencanaKirim' => $insertRencanaKirim,
		];
	}

	function editListUrutRK()
	{
		$tgl = date('Y-m-d');
		$urut = $_POST["urut"];

		$cekKirim = $this->db->query("SELECT*FROM pl_box WHERE tgl='$tgl' AND no_pl_urut='$urut'");
		if($cekKirim->num_rows() == 0){
			$this->db->set('rk_urut', $_POST["urut"]);
			$this->db->where('id_rk', $_POST["id_rk"]);
			$data = $this->db->update('m_rencana_kirim');
			$msg = 'BERHASIL!';
		}else{
			$data = false;
			$msg = 'NO URUT SUDAH TERPAKAI!';
		}

		return [
			'data' => $data,
			'msg' => $msg,
		];
	}

	function editListRencanaKirim()
	{
		if($_POST["muat"] == 0){
			$data = false;
			$msg = 'MUAT TIDAK BOLEH KOSONG!';
		}else{
			$this->db->set('qty_muat', $_POST["muat"]);
			$this->db->set('rk_tonase', $_POST["tonase"]);
			$this->db->where('id_rk', $_POST["id_rk"]);
			$data = $this->db->update('m_rencana_kirim');
			$msg = 'BERHASIL';
		}

		return [
			'data' => $data,
			'msg' => $msg,
		];
	}

	function hapusListRencanaKirim()
	{
		$this->db->where('id_rk', $_POST["id_rk"]);
		$data = $this->db->delete('m_rencana_kirim');

		return [
			'data' => $data,
		];
	}

	function selesaiMuat()
	{
		$urut = $_POST["urut"];
		$cekMuat = $this->db->query("SELECT p.ppn,r.* FROM m_rencana_kirim r
		-- INNER JOIN m_produk i ON r.id_produk=i.id_produk
		INNER JOIN trs_po_detail p ON r.id_produk=p.id_produk AND r.id_pelanggan=p.id_pelanggan AND r.rk_kode_po=p.kode_po
		WHERE r.rk_urut='$urut' AND r.rk_status='Open'");

		$tgl = date('Y-m-d');
		// INSERT PL BOX
		foreach($cekMuat->result() as $r){
			($r->kategori == "BOX") ? $kategori = 'BOX' : $kategori = 'SHEET';
			$blnRomami = $this->m_fungsi->blnRomami(date('Y-m-d'));
			if($r->ppn == "PP"){
				$pajak = 'ppn';
				$sjSo = 'A';
				$pkb = '';
			}else{
				$pajak = 'non';
				$sjSo = 'B';
				$pkb = '.';
			}

			$id_hub = $this->db->query("SELECT h.aka,p.* FROM trs_po p INNER JOIN m_hub h ON p.id_hub=h.id_hub WHERE p.kode_po='$r->rk_kode_po'")->row();
			if($id_hub->id_hub != 7){
				$no_surat = '000/'.$id_hub->aka.'/'.$blnRomami.'/'.substr(date('Y'),2,2);
				$no_so = '000/'.$id_hub->aka.'/'.$blnRomami.'/'.substr(date('Y'),2,2);
				$no_pkb = '000/'.$id_hub->aka.'/'.$blnRomami.'/'.substr(date('Y'),2,2);
			}else{
				$no_surat = '000/'.$kategori.'/'.$blnRomami.'/'.substr(date('Y'),2,2).'/'.$sjSo;
				$no_so = '000/SO-'.$kategori.'/'.$blnRomami.'/'.substr(date('Y'),2,2).'/'.$sjSo;
				$no_pkb = '000/'.substr(date('Y'),2,2).'/'.$kategori.$pkb;
			}

			$data = [
				'id_perusahaan' => $r->id_pelanggan,
				'id_hub' => $id_hub->id_hub,
				'tgl' => $tgl,
				'no_surat' => $no_surat,
				'no_so' => $no_so,
				'no_pkb' => $no_pkb,
				'no_kendaraan' => '',
				'no_po' => $r->rk_kode_po,
				'pajak' => $pajak,
				'no_pl_urut' => $urut,
				'kategori' => $kategori,
			];

			// CEK JIKA CUSTOMER DENGAN PO DAN KETEGORI YANG SAMA ABAIKAN
			$cekPL = $this->db->query("SELECT*FROM pl_box WHERE tgl='$tgl' AND id_perusahaan='$r->id_pelanggan' AND no_po='$r->rk_kode_po' AND no_pl_urut='$urut' AND kategori='$kategori'");
			if($cekPL->num_rows() == 0){
				$insertPl = $this->db->insert('pl_box', $data);
			}else{
				$insertPl = true;
			}
		}

		// MASUKKAN LIST RENCANA KIRIM KE PACKING LIST, CUSTOMER DAN PO YANG SAMA
		$getPL = $this->db->query("SELECT*FROM pl_box WHERE tgl='$tgl' AND no_pl_urut='$urut'");
		foreach($getPL->result() as $l){
			$this->db->set('id_pl_box', $l->id);
			$this->db->set('rk_status', 'Close');
			$this->db->where('rk_tgl', $l->tgl);
			$this->db->where('rk_urut', $l->no_pl_urut);
			$this->db->where('rk_kode_po', $l->no_po);
			$this->db->where('kategori', $l->kategori);
			$updateIDplBox = $this->db->update('m_rencana_kirim');
		}

		return [
			'insertPl' => $insertPl,
			'updateIDplBox' => $updateIDplBox,
		];
	}

	function btnBatalPengiriman()
	{
		$tgl = $_POST["tgl"];
		$urut = $_POST["urut"];

		// HAPUS PACKING LIST
		$this->db->where('tgl', $tgl);
		$this->db->where('no_pl_urut', $urut);
		$deletePL = $this->db->delete('pl_box');

		// UPDATE RENCANA KIRIM
		$this->db->set('id_pl_box', null);
		$this->db->set('rk_status', 'Open');
		$this->db->where('rk_tgl', $tgl);
		$this->db->where('rk_urut', $urut);
		$updateRK = $this->db->update('m_rencana_kirim');

		return [
			'deletePL' => $deletePL,
			'updateRK' => $updateRK,
		];
	}

	function addPengirimanNoPlat()
	{
		$tgl = $_POST["tgl"];
		$urut = $_POST["urut"];
		$plat = $_POST["plat"];

		$this->db->set('no_kendaraan', $plat);
		$this->db->where('tgl', $tgl);
		$this->db->where('no_pl_urut', $urut);
		$addPlat = $this->db->update('pl_box');

		return [
			'addPlat' => $addPlat,
		];
	}

	function editPengirimanNoSJ()
	{ //
		$id_pl = $_POST["id_pl"];
		$no_surat = $_POST["no_surat"];

		$cekPrint = $this->db->query("SELECT*FROM pl_box WHERE id='$id_pl' AND cetak_sj='acc'");
		if($cekPrint->num_rows() == 0){
			$pl = $this->db->query("SELECT*FROM pl_box WHERE id='$id_pl'")->row();
			$sj = explode('/', $pl->no_surat);
			$so = explode('/', $pl->no_so);
			$pkb = explode('/', $pl->no_pkb);
	
			if($pl->id_hub != 7){
				$noSJ = $no_surat.'/'.$sj[1].'/'.$sj[2].'/'.$sj[3];
				$noSO = $no_surat.'/'.$so[1].'/'.$so[2].'/'.$so[3];
				$noPKB = $no_surat.'/'.$pkb[1].'/'.$pkb[2].'/'.$pkb[3];
			}else{
				$noSJ = $no_surat.'/'.$sj[1].'/'.$sj[2].'/'.$sj[3].'/'.$sj[4];
				$noSO = $no_surat.'/'.$so[1].'/'.$so[2].'/'.$so[3].'/'.$so[4];
				$noPKB = $no_surat.'/'.$pkb[1].'/'.$pkb[2];
			}

			$cekSJ = $this->db->query("SELECT*FROM pl_box WHERE no_surat='$noSJ'");
			if($cekSJ->num_rows() == 0){
				$this->db->set('no_surat', $noSJ);
				$this->db->set('no_so', $noSO);
				$this->db->set('no_pkb', $noPKB);
				$this->db->where('no_po', $pl->no_po);
				$this->db->where('no_surat', $pl->no_surat);
				$this->db->where('no_pl_urut', $pl->no_pl_urut);
				$updateNO = $this->db->update('pl_box');
				$msg = 'BERHASIL!';
			}else{
				$updateNO = false;
				$msg = 'NOMER SJ SUDAH TERPAKAI!';
			}
		}else{
			$updateNO = false;
			$msg = 'SUDAH CETAK SURAT JALAN!';
		}

		return [
			'data' => $updateNO,
			'msg' => $msg,
		];
	}

	//

	function simpanCartLaminasi()
	{
		foreach($this->cart->contents() as $r){
			$id_m_produk_lm = $r["options"]["id_m_produk_lm"];
			$id_pelanggan_lm = $r["options"]["id_pelanggan_lm"];
			$id_po_lm = $r["options"]["id_po"];
			$id_po_dtl = $r["options"]["id_dtl"];

			$cek = $this->db->query("SELECT SUM(qty_muat) AS jml_muat FROM m_rk_laminasi
			WHERE id_m_produk_lm='$id_m_produk_lm' AND id_pelanggan_lm='$id_pelanggan_lm' AND id_po_lm='$id_po_lm' AND id_po_dtl='$id_po_dtl'
			AND rk_status='Open' AND rk_urut='0'
			GROUP BY id_m_produk_lm, id_pelanggan_lm, id_po_lm, id_po_dtl, rk_status, rk_urut");

			if($cek->num_rows() == 0){
				$data = array(
					'id_m_produk_lm' => $r["options"]["id_m_produk_lm"],
					'id_pelanggan_lm' => $r["options"]["id_pelanggan_lm"],
					'id_po_lm' => $r["options"]["id_po"],
					'id_po_dtl' => $r["options"]["id_dtl"],
					'rk_no_po' => $r["options"]["no_po_lm"],
					'qty_muat' => $r["options"]["muat"],
					'rk_status' => 'Open',
					'rk_urut' => 0,
				);
				$insertRK = $this->db->insert('m_rk_laminasi', $data);
			}else{
				$this->db->set('qty_muat', $r["options"]["muat"] + $cek->row()->jml_muat);
				$this->db->where('id_m_produk_lm', $id_m_produk_lm);
				$this->db->where('id_pelanggan_lm', $id_pelanggan_lm);
				$this->db->where('id_po_lm', $id_po_lm);
				$this->db->where('id_po_dtl', $id_po_dtl);
				$this->db->where('rk_status', 'Open');
				$this->db->where('rk_urut', 0);
				$insertRK = $this->db->update('m_rk_laminasi');
			}
		}

		return [
			'insertRK' => $insertRK,
		];
	}

	function kirimSJLaminasi()
	{
		$id_pelanggan_lm = $_POST["id_pelanggan_lm"];
		$tgl = $_POST["tgl"];
		$no_sj = $_POST["no_sj"];
		$attn = $_POST["attn"];
		$no_kendaraan = $_POST["no_kendaraan"];

		$tahun = substr(date('Y'),2,2);
		$no_surat = $no_sj.'/'.$tahun.'/LM';

		$cekNoSJ = $this->db->query("SELECT*FROM pl_laminasi WHERE no_surat='$no_surat'");

		if($no_sj == 000000 || $no_sj == '000000' || $no_sj == '' || $no_sj < 0 || strlen("'.$no_sj.'") < 6){
			$data = false; $insertPL = false; $updateIDPL = false;
			$msg = 'NOMER SURAT JALAN TIDAK BOLEH KOSONG!';
		}else if($attn == ''){
			$data = false; $insertPL = false; $updateIDPL = false;
			$msg = 'ATTN TIDAK BOLEH KOSONG!';
		}else if($no_kendaraan == ''){
			$data = false; $insertPL = false; $updateIDPL = false;
			$msg = 'NOMER KENDARAAN TIDAK BOLEH KOSONG!';
		}else if($cekNoSJ->num_rows() > 0){
			$data = false; $insertPL = false; $updateIDPL = false;
			$msg = 'NOMER SURAT JALAN SUDAH TERPAKAI!';
		}else{
			// UPDATE RK URUT
			$cekUrut = $this->db->query("SELECT*FROM m_rk_laminasi WHERE rk_tgl='$tgl' GROUP BY rk_urut DESC LIMIT 1");
			($cekUrut->num_rows() == 0) ? $rk_urut = 1 : $rk_urut = $cekUrut->row()->rk_urut + 1;

			$no_po = $this->db->query("SELECT*FROM m_rk_laminasi WHERE id_pelanggan_lm='$id_pelanggan_lm' AND rk_urut='0' GROUP BY rk_no_po");
			foreach($no_po->result() as $r){
				$pl = array(
					'id_perusahaan' => $r->id_pelanggan_lm,
					'tgl' => $tgl,
					'no_surat' => $no_surat,
					'attn_pl' => $attn,
					'no_kendaraan' => $no_kendaraan,
					'no_po' => $r->rk_no_po,
					'sj' => 'Open',
					'sj_blk' => NULL,
					'pajak' => NULL,
					'no_pl_inv' => 0,
					'no_pl_urut' => $rk_urut,
					'cetak_sj' => 'not',
				);
				$insertPL = $this->db->insert('pl_laminasi', $pl);
			}

			// UPDATE ID PL DI RENCANA KIRIM
			if($insertPL){
				$cekPL = $this->db->query("SELECT*FROM pl_laminasi WHERE id_perusahaan='$id_pelanggan_lm' AND tgl='$tgl' AND no_pl_urut='$rk_urut'");
				foreach($cekPL->result() as $c){
					$this->db->set('id_pl_lm', $c->id);
					$this->db->set('rk_tgl', $tgl);
					$this->db->set('rk_status', 'Close');
					$this->db->set('rk_urut', $rk_urut);
					$this->db->where('id_pelanggan_lm', $c->id_perusahaan);
					$this->db->where('rk_tgl', null);
					$this->db->where('rk_no_po', $c->no_po);
					$this->db->where('rk_urut', 0);
					$updateIDPL = $this->db->update('m_rk_laminasi');
				}
			}

			$data = true;
			$msg = 'OK';
		}

		return [
			'3insertPL' => $insertPL,
			'5updateIDPL' => $updateIDPL,
			'msg' => $msg,
			'data' => $data,
		];
	}

	//

	function simpanTimbangan_2()
	{
		$thn = date('Y');
		$no_timbangan   = $this->m_fungsi->urut_transaksi('TIMBANGAN').'/TIMB'.'/'.$thn;
		// $rowloop        = $this->input->post('plh_input');
		// for($loop = 0; $loop <= $rowloop+1; $loop++)
		// {
		// 	$data_detail = array(
		// 		'no_timbangan'   => $no_timbangan,
		// 		'id_item'   => $this->input->post('item_po['.$loop.']'),
		// 		'berat_bahan'   => str_replace('.','',$this->input->post('qty['.$loop.']')),
		// 	);
		// 	$result_detail = $this->db->insert('m_jembatan_timbang_d', $data_detail);
		// }

		$status_input = $this->input->post('sts_input');
		if($status_input == 'add')
		{
			$data_header = array(
				'input_t'     	 => $this->input->post('plh_input'),
				'no_timbangan'   => $no_timbangan,
				'id_pelanggan'   => $this->input->post('cust'),
				'keterangan'     => $this->input->post('jns'),
				'nm_penimbang'   => $this->input->post('penimbang'),
				'permintaan'     => $this->input->post('permintaan'),
				'suplier'        => $this->input->post('supplier'),
				'date_masuk'     => $this->input->post('masuk'),
				'alamat'         => $this->input->post('alamat'),
				'date_keluar'    => $this->input->post('keluar'),
				'no_polisi'      => $this->input->post('nopol'),
				'berat_kotor'    => str_replace('.','',$this->input->post('b_kotor')),
				'nm_barang'      => $this->input->post('barang'),
				'berat_truk'     => str_replace('.','',$this->input->post('berat_truk')),
				'nm_sopir'       => $this->input->post('sopir'),
				'berat_bersih'   => str_replace('.','',$this->input->post('berat_bersih')),
				'catatan'        => $this->input->post('cttn'),
				'potongan'       => str_replace('.','',$this->input->post('pot')),
				'urut_t'         => $this->input->post('urut_t'),
				'tgl_t'          => $this->input->post('tgl_t'),
				'pilih_po'       => $this->input->post('pilih_po'),
			);
		
			$result_header = $this->db->insert('m_jembatan_timbang', $data_header);	
				
		}else{

			$data_header = array(
				'input_t'     	 => $this->input->post('plh_input'),
				'no_timbangan'   => $this->input->post('no_timbangan'),
				'id_pelanggan'   => $this->input->post('cust'),
				'keterangan'     => $this->input->post('jns'),
				'nm_penimbang'   => $this->input->post('penimbang'),
				'permintaan'     => $this->input->post('permintaan'),
				'suplier'        => $this->input->post('supplier'),
				'date_masuk'     => $this->input->post('masuk'),
				'alamat'         => $this->input->post('alamat'),
				'date_keluar'    => $this->input->post('keluar'),
				'no_polisi'      => $this->input->post('nopol'),
				'berat_kotor'    => str_replace('.','',$this->input->post('b_kotor')),
				'nm_barang'      => $this->input->post('barang'),
				'berat_truk'     => str_replace('.','',$this->input->post('berat_truk')),
				'nm_sopir'       => $this->input->post('sopir'),
				'berat_bersih'   => str_replace('.','',$this->input->post('berat_bersih')),
				'catatan'        => $this->input->post('cttn'),
				'potongan'       => str_replace('.','',$this->input->post('pot')),
				'urut_t'         => $this->input->post('urut_t'),
				'tgl_t'          => $this->input->post('tgl_t'),
				'pilih_po'       => $this->input->post('pilih_po'),
			);
		
			
			$this->db->where('id_timbangan', $this->input->post('id_timbangan'));
			$result_header = $this->db->update('m_jembatan_timbang', $data_header);		
			
		}
		return $result_header;
	}

	function simpanTimbangan()
	{
		if($_POST["plh_input"] == "" || $_POST["permintaan"] == "" || $_POST["supplier"] == "" || $_POST["alamat"] == "" || $_POST["nopol"] == "" || $_POST["tgl_masuk"] == "" || $_POST["tgl_keluar"] == "" || $_POST["nm_barang"] == "" || $_POST["bb_kotor"] == "" || $_POST["bb_truk"] == "" || $_POST["bb_bersih"] == "" || $_POST["potongan"] == "" || $_POST["catatan"] == "" || $_POST["nm_penimbang"] == "" || $_POST["nm_supir"] == "" || $_POST["keterangan"] == ""){
			$result = false;
			$msg = 'HARAP LENGKAPI FORM!';
		}else{
			$data = [
				'input_t' => $_POST["plh_input"],
				'permintaan' => $_POST["permintaan"],
				'suplier' => $_POST["supplier"],
				'alamat' => $_POST["alamat"],
				'no_polisi' => $_POST["nopol"],
				'date_masuk' => $_POST["tgl_masuk"],
				'date_keluar' => $_POST["tgl_keluar"],
				'nm_barang' => $_POST["nm_barang"],
				'berat_kotor' => $_POST["bb_kotor"],
				'berat_truk' => $_POST["bb_truk"],
				'berat_bersih' => $_POST["bb_bersih"],
				'potongan' => $_POST["potongan"],
				'catatan' => $_POST["catatan"],
				'nm_penimbang' => $_POST["nm_penimbang"],
				'nm_sopir' => $_POST["nm_supir"],
				'keterangan' => $_POST["keterangan"],
				'urut_t' => $_POST["urut"],
				'tgl_t' => $_POST["tgl"],
			];
			if($_POST["opsiInput"] == 'insert'){
				$result = $this->db->insert('m_jembatan_timbang', $data);
				$msg = 'BERHASIL TAMBAH DATA!';
			}else{
				$this->db->where('id_timbangan', $_POST["id_timbangan"]);
				$result = $this->db->update('m_jembatan_timbang', $data);
				$msg = 'BERHASIL EDIT DATA!';
			}
		}
		return [
			'data' => $result,
			'msg' => $msg,
		];
	}

	function deleteTimbangan()
	{
		$this->db->where('id_timbangan', $_POST["id_timbangan"]);
		$data = $this->db->delete('m_jembatan_timbang');
		return [
			'data' => $data,
		];
	}

	//

	function update_invoice()
	{
		$id_inv         = $this->input->post('id_inv');
		$cek_inv        = $this->input->post('cek_inv2');
		$c_no_inv_kd    = $this->input->post('no_inv_kd');
		$c_no_inv       = $this->input->post('no_inv');
		$c_no_inv_tgl   = $this->input->post('no_inv_tgl');

		$type           = $this->input->post('type_po2');
		$pajak          = $this->input->post('pajak2');
		$no_inv_old     = $this->input->post('no_inv_old');

		$m_no_inv       = $c_no_inv_kd.''.$c_no_inv.''.$c_no_inv_tgl;

		$data_header = array(
			'no_invoice'         => $m_no_inv,
			'type'               => $type,
			'cek_inv'    		 => $cek_inv,
			'tgl_invoice'        => $this->input->post('tgl_inv'),
			'tgl_sj'             => $this->input->post('tgl_sj'),
			'pajak'              => $this->input->post('pajak2'),
			'inc_exc'            => $this->input->post('inc_exc'),
			'tgl_jatuh_tempo'    => $this->input->post('tgl_tempo'),
			'id_perusahaan'      => $this->input->post('id_perusahaan'),
			'kepada'             => $this->input->post('kpd'),
			'nm_perusahaan'      => $this->input->post('nm_perusahaan'),
			'alamat_perusahaan'  => $this->input->post('alamat_perusahaan'),
			'bank'  			 => $this->input->post('bank'),
			// 'status'             => 'Open',
		);

		$result_header = $this->db->update("invoice_header", $data_header,
			array(
				'id' => $id_inv
			)
		);

		$tgl_sj           = $this->input->post('tgl_sj');
		$id_perusahaan    = $this->input->post('id_perusahaan');

		$query = $this->db->query("SELECT *FROM invoice_detail where no_invoice='$no_inv_old' ")->result();

		if ($type == 'roll')
		{
			$no = 1;
			foreach ( $query as $row ) 
			{

					$harga_ok        = $this->input->post('hrg['.$no.']');
					$hasil_ok        = $this->input->post('hasil['.$no.']');
					$harga_inc       = $this->input->post('inc['.$no.']');
					$harga_inc1      = str_replace('.','',$harga_inc);

					$seset_ok        = $this->input->post('seset['.$no.']');
					$id_pl_roll      = $this->input->post('id_pl_roll['.$no.']');
					$id_inv_detail   = $this->input->post('id_inv_detail['.$no.']');
					$data = [					
						'no_invoice'   => $m_no_inv,
						'type'         => $type,
						'no_surat'     => $this->input->post('no_surat['.$no.']'),
						'nm_ker'       => $this->input->post('nm_ker['.$no.']'),
						'g_label'      => $this->input->post('g_label['.$no.']'),
						'width'        => $this->input->post('width['.$no.']'),
						'qty'          => $this->input->post('qty['.$no.']'),
						'retur_qty'    => $this->input->post('retur_qty['.$no.']'),
						'id_pl'        => $id_pl_roll,
						'harga'        => str_replace('.','',$harga_ok),
						'include'      => str_replace(',','.',$harga_inc1),
						'weight'       => $this->input->post('weight['.$no.']'),
						'seset'        => str_replace('.','',$seset_ok),
						'hasil'        => str_replace('.','',$hasil_ok),
						'no_po'        => $this->input->post('no_po['.$no.']'),
					];

					$result_rinci = $this->db->update("invoice_detail", $data,
						array(
							'id' => $id_inv_detail
						)
					);

				$no++;
			}
		}else{
			
			$no = 1;
			foreach ( $query as $row ) 
			{			

					$harga_ok        = $this->input->post('hrg['.$no.']');
					$hasil_ok        = $this->input->post('hasil['.$no.']');
					
					$harga_inc       = $this->input->post('inc['.$no.']');
					$harga_inc1      = str_replace('.','',$harga_inc);

					$retur_qty_ok    = $this->input->post('retur_qty['.$no.']');
					$id_pl_roll      = $this->input->post('id_pl_roll['.$no.']');
					$id_inv_detail   = $this->input->post('id_inv_detail['.$no.']');

					$data = [					
						'no_invoice'   => $m_no_inv,
						'type'         => $type,
						'no_surat'     => $this->input->post('no_surat['.$no.']'),
						'nm_ker'       => $this->input->post('item['.$no.']'),
						'g_label'      => $this->input->post('ukuran['.$no.']'),
						'kualitas'      => $this->input->post('kualitas['.$no.']'),
						'qty'          => $this->input->post('qty['.$no.']'),
						'retur_qty'    => str_replace('.','',$retur_qty_ok),
						'id_pl'        => $id_pl_roll,
						'harga'        => str_replace('.','',$harga_ok),
						'include'      => str_replace(',','.',$harga_inc1),
						'hasil'        => str_replace('.','',$hasil_ok),
						'no_po'        => $this->input->post('no_po['.$no.']'),
					];

					$result_rinci = $this->db->update("invoice_detail", $data,
						array(
							'id' => $id_inv_detail
						)
					);

				$no++;
			}
		}

		if($result_rinci){
			$query = $this->db->query("SELECT*FROM invoice_header where no_invoice ='$m_no_inv' ")->row();
			return $query->id;
		}else{
			return 0;

		}
	}

	function verif_inv()
	{
		$no_inv   = $this->input->post('no_inv');
		$user     = $this->input->post('user');
		$acc      = $this->input->post('acc');
		$app      = "";

		// KHUSUS ADMIN //
		if ($this->session->userdata('level') == "Admin") 
		{

			if($acc=='N')
			{
				$this->db->set("acc_admin", 'Y');
				$this->db->set("acc_owner", 'Y');
				// stok_bahanbaku($cekPO->kode_po, $cekPO->id_hub, $cekPO->tgl_po, 'HUB', 0, $cekPO_detail->bahan, 'KELUAR DENGAN INV', 'KELUAR');
			}else{
				$this->db->set("acc_admin", 'N');
				$this->db->set("acc_owner", 'N');
			}
			
			$this->db->where("no_invoice",$no_inv);
			$valid = $this->db->update("invoice_header");

		} else if ($this->session->userdata('level') == "Keuangan1" && $this->session->userdata('username') == "karina") 
		{
			if($acc=='N')
			{
				$this->db->set("acc_admin", 'Y');
			}else{
				$this->db->set("acc_admin", 'N');
			}
			
			$this->db->where("no_invoice",$no_inv);
			$valid = $this->db->update("invoice_header");

		} else if ($this->session->userdata('level') == "Keuangan1" && $this->session->userdata('username') == "bumagda") 
		{
			if($acc=='N')
			{
				$this->db->set("acc_owner", 'Y');
				// $cek_detail = $this->db->query("SELECT*FROM invoice_header a
				// join invoice_detail b on a.no_invoice=b.no_invoice
				//  where b.no_invoice='$no_inv' ")->result();
				// $no = 1;
				// foreach ( $cek_detail as $row ) 
				// {
				// 	if($row->type=='box' || $row->type=='sheet' )
				// 	{
				// 		stok_bahanbaku($no_inv, $cekPO->id_hub, $row->tgl_invoice, 'HUB', 0, $cekPO_detail->bahan, 'KELUAR DENGAN INV', 'KELUAR');
				// 	}
				// }
			}else{
				$this->db->set("acc_owner", 'N');
			}
			
			$this->db->where("no_invoice",$no_inv);
			$valid = $this->db->update("invoice_header");

		} else {
			
			$valid = false;

		}

		return $valid;
	}

	function batal_inv()
	{
		$id       = $this->input->post('id');
		$app      = "";

		// KHUSUS ADMIN //
		if ($this->session->userdata('level') == "Admin") 
		{

			$this->db->set("acc_admin", 'N');
			$this->db->set("acc_owner", 'N');
			$this->db->where("no_invoice",$id);
			$valid = $this->db->update("invoice_header");

		} else if ($this->session->userdata('level') == "Keuangan1" && $this->session->userdata('username') == "karina") 
		{
			$this->db->set("acc_admin", 'N');
			$this->db->where("no_invoice",$id);
			$valid = $this->db->update("invoice_header");

		} else {
	
			$this->db->set("acc_owner", 'N');
			$this->db->where("no_invoice",$id);
			$valid = $this->db->update("invoice_header");

		}

		return $valid;
	}

	function save_stok_bb()
	{
		$sts_input    = $this->input->post('sts_input');
		$thn          = date('Y');

		if($sts_input=='edit')
		{
			$no_stokbb   = $this->input->post('no_stok');
			$rowloop     = $this->input->post('bucket');

			$del_detail  = $this->db->query("DELETE FROM trs_d_stok_bb WHERE no_stok='$no_stokbb' ");

			if($del_detail)
			{
				for($loop = 0; $loop <= $rowloop; $loop++)
				{
					// pecah stok
					$data_detail = array(				
						'no_stok'       => $no_stokbb,
						'id_hub'        => $this->input->post('id_hub['.$loop.']'),
						'id_po_bhn'     => $this->input->post('id_po_bhn['.$loop.']'),
						'no_po_bhn'     => $this->input->post('no_po['.$loop.']'),
						'tonase_po'     => str_replace('.','',$this->input->post('ton['.$loop.']')),
						'datang_bhn_bk' => str_replace('.','',$this->input->post('datang['.$loop.']')),
					);
					$result_detail = $this->db->insert('trs_d_stok_bb', $data_detail);


					$id_hub_       = $this->input->post('id_hub['.$loop.']');
					$del_detail    = $this->db->query("DELETE FROM trs_stok_bahanbaku WHERE no_transaksi='$no_stokbb' and id_hub='$id_hub_' ");

					stok_bahanbaku($no_stokbb, $this->input->post('id_hub['.$loop.']'), $this->input->post('tgl_stok'), 'HUB', str_replace('.','',$this->input->post('datang['.$loop.']')), 0, 'MASUK DENGAN PO', 'MASUK');
				}

			}			

			$tonase_ppi = str_replace('.','',$this->input->post('tonase_ppi')) ;

			if($result_detail)
			{
				$data_header = array(
					'no_stok'         => $no_stokbb,
					'tgl_stok'        => $this->input->post('tgl_stok'),
					'id_timbangan'    => $this->input->post('id_timb'),
					'no_timbangan'    => $this->input->post('no_timb'),
					'total_timb'      => str_replace('.','',$this->input->post('jum_timb')),
					'muatan_ppi'      => str_replace('.','',$this->input->post('muat_ppi')),
					'tonase_ppi'      => $tonase_ppi,
					'total_item'      => str_replace('.','',$this->input->post('total_bb_item')),
					'sisa_stok'      => str_replace('.','',$this->input->post('sisa_timb')),

				);
			
				$this->db->where('id_stok', $this->input->post('id_stok_h'));
				$result_header = $this->db->update('trs_h_stok_bb', $data_header);

				
					// input stok berjalan PPI
				if($tonase_ppi>0)
				{
					$data_stok_berjalan = array(				
						'no_transaksi'    => $no_stokbb,
						'id_hub'          => null,
						'tgl_input'       => $this->input->post('tgl_stok'),
						'jam_input'       => date("H:i:s"),
						'jenis'           => 'PPI',
						'masuk'           => $tonase_ppi,
						'keluar'          => 0,
						'ket'             => 'MASUK DENGAN PO',
						'status'          => 'MASUK',
					);
					// $result_stok_berjalan = $this->db->insert('trs_stok_bahanbaku', $data_stok_berjalan);

					$this->db->where('no_transaksi', $no_stokbb);
					$this->db->where('jenis', 'PPI');
					$this->db->where('tgl_input', $this->input->post('tgl_stok'));
					$result_stok_berjalan = $this->db->update('trs_stok_bahanbaku', $data_stok_berjalan);
				
				}
			}
		}else{
			$no_stokbb   = $this->m_fungsi->urut_transaksi('STOK_BB').'/'.'STOK/'.$thn;
			$tonase_ppi  = str_replace('.','',$this->input->post('tonase_ppi')) ;

			$rowloop     = $this->input->post('bucket');
			for($loop = 0; $loop <= $rowloop; $loop++)
			{
				$data_detail = array(				
					'no_stok'       => $no_stokbb,
					'id_hub'        => $this->input->post('id_hub['.$loop.']'),
					'id_po_bhn'     => $this->input->post('id_po_bhn['.$loop.']'),
					'no_po_bhn'     => $this->input->post('no_po['.$loop.']'),
					'tonase_po'     => str_replace('.','',$this->input->post('ton['.$loop.']')),
					'datang_bhn_bk' => str_replace('.','',$this->input->post('datang['.$loop.']')),
				);
				$result_detail = $this->db->insert('trs_d_stok_bb', $data_detail);

				// input stok berjalan

				stok_bahanbaku($no_stokbb, $this->input->post('id_hub['.$loop.']'), $this->input->post('tgl_stok'), 'HUB', str_replace('.','',$this->input->post('datang['.$loop.']')), 0, 'MASUK DENGAN PO', 'MASUK');
			}

			if($result_detail)
			{
				$data_header = array(
					'no_stok'         => $no_stokbb,
					'tgl_stok'        => $this->input->post('tgl_stok'),
					'id_timbangan'    => $this->input->post('id_timb'),
					'no_timbangan'    => $this->input->post('no_timb'),
					'total_timb'      => str_replace('.','',$this->input->post('jum_timb')),
					'muatan_ppi'      => str_replace('.','',$this->input->post('muat_ppi')),
					'tonase_ppi'      => str_replace('.','',$this->input->post('tonase_ppi')),
					'total_item'      => str_replace('.','',$this->input->post('total_bb_item')),
					'sisa_stok'      => str_replace('.','',$this->input->post('sisa_timb')),

				);
			
				$result_header = $this->db->insert('trs_h_stok_bb', $data_header);
			}

			// input stok berjalan PPI
			if($tonase_ppi>0)
			{

				stok_bahanbaku($no_stokbb, NULL, $this->input->post('tgl_stok'), 'PPI', $tonase_ppi, 0, 'MASUK DENGAN PO', 'MASUK');
			
			}
		}
		
		return $result_header;
			
	}

	function save_stok_ppi()
	{
		$sts_input    = $this->input->post('sts_input');
		$thn          = date('Y');

		if($sts_input=='edit')
		{
			$no_stok_ppi   = $this->input->post('no_stok_ppi');
			$id_stok_ppi   = $this->input->post('id_stok_ppi');
			$jam_stok      = $this->input->post('jam_stok');
			// delete stok sebelumnya
			$del_detail    = $this->db->query("DELETE FROM trs_stok_ppi WHERE no_stok_ppi='$no_stok_ppi' ");

		}else{
			$no_stok_ppi   = $this->m_fungsi->urut_transaksi('STOK_BB_PPI').'/'.'STOK_PPI/'.$thn;			
			$jam_stok      = date('H:i:s');

		}

		for($loop = 1; $loop <= 8; $loop++)
		{
			$data_detail = array(				
				'no_stok_ppi'   => $no_stok_ppi,
				'tgl_stok'      => $this->input->post('tgl_stok'),
				'ket_header'    => $this->input->post('ket_header'),
				'jam_stok'      => $jam_stok,
				'ket'           => $this->input->post('ket'.$loop),
				'tonase_masuk'  => str_replace('.','',$this->input->post('masuk'.$loop)),
				'tonase_keluar' => str_replace('.','',$this->input->post('keluar'.$loop)),
				'status' 		=> 'Open',
			);
			$result_detail = $this->db->insert('trs_stok_ppi', $data_detail);

			// input stok berjalan PPI

			// stok_bahanbaku($no_stokbb, NULL, $this->input->post('tgl_stok'), 'PPI', $tonase_ppi, 0, 'MASUK DENGAN PO', 'MASUK');
		}
		
		return $result_detail;
			
	}
	

}
