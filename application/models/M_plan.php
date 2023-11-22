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
			$query = $this->db->query("SELECT *,w.qty AS qtyPoWo,w.status AS statusWo,i.kategori AS kategoriItems,w.creasing2 AS creasing2wo,w.tgl_wo FROM plan_cor pl
			INNER JOIN m_produk i ON pl.id_produk=i.id_produk
			INNER JOIN m_pelanggan l ON pl.id_pelanggan=l.id_pelanggan
			INNER JOIN m_sales m ON l.id_sales=m.id_sales
			INNER JOIN trs_wo w ON pl.id_wo=w.id
			INNER JOIN trs_so_detail s ON pl.id_so_detail=s.id
			WHERE pl.id_plan='$opsi'");
		}else{
			$query = $this->db->query("SELECT w.*,i.*,s.*,o.tgl_po,o.total_qty,p.nm_pelanggan,p.alamat,p.prov,p.kab,m.nm_sales,s.id AS idSoDetail,w.id AS idWo,w.creasing2 AS creasing2wo,i.kategori AS kategoriItems FROM trs_wo w
			INNER JOIN m_pelanggan p ON w.id_pelanggan=p.id_pelanggan
			INNER JOIN m_sales m ON p.id_sales=m.id_sales
			INNER JOIN m_produk i ON w.id_produk=i.id_produk
			INNER JOIN trs_po o ON w.no_po=o.no_po AND w.kode_po=o.kode_po
			INNER JOIN trs_so_detail s ON w.no_po=s.no_po AND w.kode_po=s.kode_po AND w.id_pelanggan=s.id_pelanggan AND w.id_produk=s.id_produk
			WHERE w.status='Open'
			AND w.no_so=s.id
			GROUP BY w.id,w.id_pelanggan,w.id_produk,p.id_pelanggan,i.id_produk,s.id
			ORDER BY p.nm_pelanggan");
		}
		return $query;
	}

	function addDtProd()
	{
		$opsi = $_POST["opsi"];
		if($opsi != ''){
			$getNoPlan = $this->db->query("SELECT*FROM plan_cor WHERE id_plan='$opsi'")->row();
			return $this->db->query("SELECT*FROM plan_cor
			WHERE no_plan='$getNoPlan->no_plan' AND total_cor_p='0' AND no_urut_plan!='0'
			ORDER BY no_urut_plan ASC LIMIT 1")->row();
		}else{
			return false;
		}
	}

	function loadDataPlan()
	{
		$tgl_plan = $_POST["tgl_plan"];
		$shift = $_POST["shift"];
		$mesin = $_POST["mesin"];
		
		return $this->db->query("SELECT wo.status AS statusWo,pl.* FROM plan_cor pl
		INNER JOIN trs_wo wo ON pl.id_wo=wo.id
		WHERE pl.tgl_plan='$tgl_plan' AND pl.shift_plan='$shift' AND pl.machine_plan='$mesin'")->result();
	}

	function simpanCartItem()
	{
		if($_POST['no_plan'] == ''){
			$plan_no = $this->m_fungsi->urut_transaksi('PLAN');
			$bln = $this->m_master->get_romawi(date('m'));
			$tahun = date('Y');
		}

		foreach($this->cart->contents() as $r){
			// UPDATE SCORE WO
			$this->db->set("flap1", $r["options"]["creasing_wo1"]);
			$this->db->set("creasing2", $r["options"]["creasing_wo2"]);
			$this->db->set("flap2", $r["options"]["creasing_wo3"]);
			$this->db->set("edit_time", date("Y:m:d H:i:s"));
			$this->db->set("edit_user", $this->session->userdata('username'));
			$this->db->where("id", $r["options"]["id_wo"]);
			$updateScoreWO = $this->db->update("trs_wo");

			// INSERT PLAN COR
			if($_POST['no_plan'] == ''){
				$noplan = 'PLAN/'.$tahun.'/'.$bln.'/'.$plan_no;
			}else{
				$noplan = $_POST['no_plan'];
			}
			$data = array(
				'no_plan' => $noplan,
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
			$insertPlanCor = $this->db->insert('plan_cor', $data);
		}

		return array(
			'updateScoreWO' => $updateScoreWO,
			'insertPlanCor' => $insertPlanCor,
		);
	}

	function addRencanaPlan()
	{
		if($_POST["opsi"] != 'add'){
			// UPDATE SCORE WO
			$this->db->set("flap1", $_POST["creasing_wo1"]);
			$this->db->set("creasing2", $_POST["creasing_wo2"]);
			$this->db->set("flap2", $_POST["creasing_wo3"]);
			$this->db->set("edit_time", date("Y:m:d H:i:s"));
			$this->db->set("edit_user", $this->session->userdata('username'));
			$this->db->where("id", $_POST["id_wo"]);
			$updateScoreWO = $this->db->update("trs_wo");

			$data = array(
				'tgl_plan' => $_POST["tgl_plan"],
				'tgl_kirim_plan' => $_POST["tgl_kirim_plan"],
				'shift_plan' => $_POST["shift_plan"],
				'machine_plan' => $_POST["machine_plan"],
				'no_wo' => $_POST["no_wo"],
				'no_so' => $_POST["no_so"],
				'panjang_plan' => $_POST["panjang_plan"],
				'lebar_plan' => $_POST["lebar_plan"],
				'out_plan' => $_POST["out_plan"],
				'lebar_roll_p' => $_POST["lebar_roll_p"],
				'material_plan' => $_POST["material_plan"],
				'kualitas_plan' => $_POST["kualitas_plan"],
				'kualitas_isi_plan' => $_POST["kualitas_isi_plan"],
				'trim_plan' => $_POST["trim_plan"],
				'c_off_p' => $_POST["c_off_p"],
				'rm_plan' => $_POST["rm_plan"],
				'tonase_plan' => $_POST["tonase_plan"],
				'next_plan' => $_POST["next_plan"],
				'edit_time' => date('Y-m-d H:i:s'),
				'edit_user' => $this->session->userdata('username'),
			);

			$this->db->where('id_plan', $_POST['opsi']);
			$this->db->where('id_so_detail', $_POST['id_so_detail']);
			$this->db->where('id_wo', $_POST['id_wo']);
			$this->db->where('id_produk', $_POST['id_produk']);
			$this->db->where('id_pelanggan', $_POST['id_pelanggan']);
			$updatePlanCor = $this->db->update('plan_cor', $data);
		}

		return array(
			'updateScoreWO' => $updateScoreWO,
			'updatePlanCor' => $updatePlanCor,
		);
	}

	function produksiRencanaPlan()
	{
		$this->db->set('good_cor_p', $_POST["good_cor_p"]);
		$this->db->set('bad_cor_p', $_POST["bad_cor_p"]);
		$this->db->set('total_cor_p', $_POST["total_cor_p"]);
		$this->db->set('ket_plan', strtoupper($_POST["ket_plan"]));
		$this->db->set('start_time_p', $_POST["start_cor"]);
		$this->db->set('end_time_p', $_POST["end_cor"]);
		$this->db->where('id_plan', $_POST["id_plan"]);

		if($_POST["total_cor_p"] != 0){
			$id_plan = $_POST["id_plan"];
			$cekPlan = $this->db->query("SELECT*FROM plan_cor WHERE id_plan='$id_plan'")->row();
			if($cekPlan->status_plan == 'Close'){
				$result = array(
					'data' => false,
					'msg' => 'PLAN SUDAH SELESAI!',
				);
			}else{
				$result = $this->db->update('plan_cor');
			}
		}else{
			$result = $this->db->update('plan_cor');
		}

		return $result;
	}

	function hapusPlan()
	{
		$this->db->where('id_plan', $_POST["id_plan"]);
		return $this->db->delete('plan_cor');
	}

	function selesaiPlan()
	{
		$this->db->set('status_plan', 'Close');
		$this->db->where('id_plan', $_POST["id_plan"]);
		return $this->db->update('plan_cor');
	}

	function selesaiPlanWO()
	{
		$this->db->set('status', 'Close');
		$this->db->where('id', $_POST["id_wo"]);
		return $this->db->update('trs_wo');
	}

	function riwayatPlan()
	{
		$id_wo = $_POST["id_wo"];
		$id_so = $_POST["id_so"];
		$id_pelanggan = $_POST["id_pelanggan"];
		$id_produk = $_POST["id_produk"];

		// return $this->db->query("SELECT p.*,so.qty_so FROM plan_cor p
		// INNER JOIN trs_so_detail so ON p.id_so_detail=so.id
		// WHERE p.status_plan='Close'
		// AND p.id_so_detail='$id_so' AND p.id_wo='$id_wo' AND p.id_produk='$id_produk' AND p.id_pelanggan='$id_pelanggan'");
		return $this->db->query("SELECT COUNT(dt.id_plan_cor) AS jmlDt,SUM(dt.durasi_mnt_dt) AS jmlDtDurasi,p.*,so.qty_so FROM plan_cor p
		INNER JOIN trs_so_detail so ON p.id_so_detail=so.id
		LEFT JOIN plan_cor_dt dt ON p.id_plan=dt.id_plan_cor
		WHERE p.status_plan='Close'
		AND p.id_so_detail='$id_so' AND p.id_wo='$id_wo' AND p.id_produk='$id_produk' AND p.id_pelanggan='$id_pelanggan'
		GROUP BY p.tgl_plan,p.id_plan");
	}

	function onChangeNourutPlan()
	{
		$no_urut = $_POST["no_urut"];
		$id_plan = $_POST["i"];

		$noPoPlan = $this->db->query("SELECT no_plan FROM plan_cor WHERE id_plan='$id_plan'")->row();

		$cekNoUrutPlan = $this->db->query("SELECT*FROM plan_cor WHERE no_urut_plan='$no_urut' AND no_plan='$noPoPlan->no_plan'");
		if($cekNoUrutPlan->num_rows() == 0){
			$this->db->set('no_urut_plan', $no_urut);
			$this->db->where('id_plan', $id_plan);
			$data = $this->db->update("plan_cor");
			$msg = 'BERHASIL EDIT NO URUT!';
		}else{
			$data = false;
			$msg = 'NO URUT SUDAH ADA!';
		}

		return array(
			'data' => $data,
			'msg' => $msg,
			'no_plan' => $noPoPlan,
			'urut_plan' => $cekNoUrutPlan->row(),
		);
	}

	function editListPlan()
	{
		if($_POST["opsi"] == 'edit'){
			$this->db->set("material_plan", $_POST["material"]);
			$this->db->set("kualitas_plan", $_POST["kualitas"]);
			$this->db->set("kualitas_isi_plan", $_POST["kualitas_isi"]);
			$this->db->set("panjang_plan", $_POST["panjang_plan"]);
			$this->db->set("lebar_plan", $_POST["lebar_plan"]);
			$this->db->set("lebar_roll_p", $_POST["lebar_roll_p"]);
			$this->db->set("out_plan", $_POST["out_plan"]);
			$this->db->set("trim_plan", $_POST["trim_plan"]);
			$this->db->set("c_off_p", $_POST["c_off_p"]);
			$this->db->set("rm_plan", $_POST["rm_plan"]);
			$this->db->set("tonase_plan", $_POST["tonase_plan"]);
			$this->db->set("tgl_kirim_plan", $_POST["tglkirim"]);
			$this->db->set("next_plan", $_POST["next"]);
			$this->db->where("id_plan", $_POST["id_plan"]);
			$plan = $this->db->update("plan_cor");

			$this->db->set("flap1", $_POST["creasing_wo1"]);
			$this->db->set("creasing2", $_POST["creasing_wo2"]);
			$this->db->set("flap2", $_POST["creasing_wo3"]);
			$this->db->where("id", $_POST["id_wo"]);
			$wo = $this->db->update("trs_wo");
		}else{
			$this->db->set("tgl_kirim_plan", $_POST["tglkirim"]);
			$this->db->set("next_plan", $_POST["next"]);
			$this->db->where("id_plan", $_POST["id_plan"]);
			$plan = $this->db->update("plan_cor");
			$wo = true;
		}

		return array(
			'plan' => $plan,
			'wo' => $wo,
		);
	}

	function simpanDowntime()
	{
		$id_plan = $_POST["id_plan"];
		$id_dt = $_POST["id_dt"];
		$durasi = $_POST["durasi"];
		$ket = $_POST["ket"];

		if($id_plan == "" || $id_dt == "" || $durasi == "" || $durasi == 0 || $durasi < 0){
			$result = false;
			$msg = 'HARAP LENGKAPI DATA DOWNTIME!';
		}else{
			$cek = $this->db->query("SELECT*FROM plan_cor_dt WHERE id_plan_cor='$id_plan' AND id_m_downtime='$id_dt'");
			if($cek->num_rows() > 0){
				$result = false;
				$msg = 'DATA DOWNTIME SUDAH ADA!';
			}else{
				$this->db->set('id_plan_cor', $id_plan);
				$this->db->set('id_m_downtime', $id_dt);
				$this->db->set('durasi_mnt_dt', $durasi);
				$this->db->set('ket_plan_dt', strtoupper($ket));
				$this->db->set('add_time', date("Y:m:d H:i:s"));
				$this->db->set('add_user', $this->session->userdata('username'));
				$result = $this->db->insert('plan_cor_dt');
				$msg = 'BERHASIL!';
			}
		}
		return array(
			'result' => $result,
			'msg' => $msg,
		);
	}

	function hapusDowntimePlan()
	{
		$this->db->where('id_plan_dt', $_POST["id_dt"]);
		return $this->db->delete('plan_cor_dt');
	}

	function changeEditDt()
	{
		$durasi = $_POST["durasi"];
		if($durasi == 0 || $durasi == ""){
			$result = false;
			$msg = 'DURASI TIDAK BOLEH KOSONG!';
		}else{
			$this->db->set('durasi_mnt_dt', $durasi);
			$this->db->set('ket_plan_dt', strtoupper($_POST["ket"]));
			$this->db->set('edit_time', date("Y-m-d H:i:s"));
			$this->db->set('edit_user', $this->session->userdata('username'));
			$this->db->where('id_plan_dt', $_POST["id_plan"]);
			$result = $this->db->update('plan_cor_dt');
			$msg = "BERHASIL EDIT!";
		}

		return array(
			'data' => $result,
			'msg' => $msg,
		);
	}

	function btnGantiTglPlan()
	{
		$tgl = $_POST["tgl"];
		$shift = $_POST["shift"];
		$mesin = $_POST["mesin"];
		$id_plan = $_POST["id_plan"];

		if($tgl == "" || $shift == "" || $mesin == ""){
			$result = false;
			$msg = 'CEK KEMBALI!';
		}else{
			$cekIDPlan = $this->db->query("SELECT id_so_detail,id_wo,id_produk,id_pelanggan FROM plan_cor WHERE id_plan='$id_plan'")->row();
			$cekIDProduk = $this->db->query("SELECT*FROM plan_cor
			WHERE id_so_detail='$cekIDPlan->id_so_detail' AND id_wo='$cekIDPlan->id_wo' AND id_produk='$cekIDPlan->id_produk' AND id_pelanggan='$cekIDPlan->id_pelanggan' 
			AND tgl_plan='$tgl' AND shift_plan='$shift' AND machine_plan='$mesin'");
			if($cekIDProduk->num_rows() > 0){
				$result = false;
				$msg = 'WO SUDAH ADA DI TANGGAL TERSEBUT!';
			}else{
				$cekIDPlanProduksi = $this->db->query("SELECT * FROM plan_cor WHERE id_plan='$id_plan' AND total_cor_p!='0'");
				if($cekIDPlanProduksi->num_rows() > 0){
					$result = false;
					$msg = 'PLAN SUDAH TERPRODUKSI!';
				}else{
					$cekPlan = $this->db->query("SELECT*FROM plan_cor
					WHERE tgl_plan='$tgl' AND shift_plan='$shift' AND machine_plan='$mesin' LIMIT 1");
					if($cekPlan->num_rows() > 0){
						$noplan = $cekPlan->row()->no_plan;
					}else{
						$plan_no = $this->m_fungsi->urut_transaksi('PLAN');
						$bln = $this->m_master->get_romawi(date('m'));
						$tahun = date('Y');
						$noplan = 'PLAN/'.$tahun.'/'.$bln.'/'.$plan_no;
					}
					$this->db->set('tgl_plan', $tgl);
					$this->db->set('shift_plan', $shift);
					$this->db->set('machine_plan', $mesin);
					$this->db->set('no_urut_plan', 0);
					$this->db->set('no_plan', $noplan);
					$this->db->set('edit_time', date("Y-m-d H:i:s"));
					$this->db->set('edit_user', $this->session->userdata('username'));
					$this->db->where('id_plan', $id_plan);
					$result = $this->db->update('plan_cor');
					$msg = 'BERHASIL EDIT!';
				}
			}
		}
		return array(
			'data' => $result,
			'msg' => $msg,
		);
	}

	//

	function loadPlanCor()
	{
		$mesin = $_POST["mesin"];
		$query = $this->db->query("SELECT i.nm_produk,c.nm_pelanggan,p.* FROM plan_cor p
		INNER JOIN m_produk i ON p.id_produk=i.id_produk
		INNER JOIN m_pelanggan c ON p.id_pelanggan=c.id_pelanggan
		WHERE p.status_plan='Close' AND next_plan='$mesin'")->result();
		return $query;
	}
}
