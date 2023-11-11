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
			if(in_array($this->session->userdata('level'), ['Admin','PPIC'])){
				$this->load->view('Plan/Cor/v_corr_add');
			}
		}else if($jenis == 'List'){
			if(in_array($this->session->userdata('level'), ['Admin','PPIC','Corrugator'])){
				$data = array(
					"tgl_plan" => $this->uri->segment(4),
					"shift" => $this->uri->segment(5),
					"mesin" => $this->uri->segment(6),
				);
				$this->load->view('Plan/Cor/v_corr_plan', $data);
			}
		}else{
			$this->load->view('Plan/Cor/v_corr');
		}


		$this->load->view('footer');
	}

	function LoaDataCor()
	{
		$data = array();
		$query = $this->db->query("SELECT COUNT(p.id_plan) AS jml,p.* FROM plan_cor p GROUP BY tgl_plan,shift_plan,machine_plan")->result();
		$i = 0;
		foreach ($query as $r) {
			$i++;
			$row = array();
			$row[] = '<div style="text-align:center">'.$i.'</div>';
			$row[] = strtoupper($this->m_fungsi->tanggal_format_indonesia($r->tgl_plan));
			$row[] = '<div style="text-align:center">'.$r->shift_plan.'</div>';
			$row[] = '<div style="text-align:center">'.$r->machine_plan.'</div>';
			$row[] = $r->no_plan;
			$row[] = '<div style="text-align:center">'.$r->jml.'</div>';

			$link = base_url('Plan/Corrugator/List/'.$r->tgl_plan.'/'.$r->shift_plan.'/'.$r->machine_plan);
			
			$row[] = '<a href="'.$link.'"><button type="button" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></button></a>

			<a target="_blank" class="btn btn-sm btn-success" href="' . base_url("Plan/Cetak_plan2?no_plan=" . $r->no_plan . "") . '" title="Cetak" ><i class="fas fa-print"></i> </a>

			<a target="_blank" class="btn btn-sm btn-primary" href="'.base_url("Plan/laporanPlan?no_plan=".$r->no_plan."").'" title="Cetak" ><i class="fas fa-print"></i> </a>
			
			';
			// $row[] = '<button type="button" onclick="editListPlan('."'".$r->tgl_plan."'".','."'".$r->shift_plan."'".','."'".$r->machine_plan."'".')" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></button>';

			$data[] = $row;
		}

		$output = array(
			"data" => $data,
		);
		echo json_encode($output);
	}

	function loadPlanWo()
	{
		$getWo = $this->m_plan->loadPlanWo();
		if($_POST['opsi'] != ''){
			$result = $getWo->row();
			$data = true;
		}else{
			$result = $getWo->result();
			$data = false;
		}
		echo json_encode(array(
			'data' => $data,
			'opsi' => $_POST['opsi'],
			'wo' => $result
		));
	}

	function destroyPlan()
	{
		$this->cart->destroy();
	}

	function hapusCartItem()
	{
		$data = array(
			'rowid' => $_POST['rowid'],
			'qty' => 0,
		);
		$this->cart->update($data);
	}

	function addRencanaPlan()
	{
		$opsi = $_POST["opsi"];
		if($opsi == 'add'){
			$data = array(
				'id' => $_POST['id_wo'],
				'name' => $_POST['id_wo'],
				'price' => 0,
				'qty' => 1,
				'options' => array(
					'id_so_detail' => $_POST["id_so_detail"],
					'id_wo' => $_POST["id_wo"],
					'id_produk' => $_POST["id_produk"],
					'id_pelanggan' => $_POST["id_pelanggan"],
					'no_wo' => $_POST["no_wo"],
					'no_so' => $_POST["no_so"],
					'pcs_plan' => $_POST["pcs_plan"],
					'tgl_plan' => $_POST["tgl_plan"],
					'machine_plan' => $_POST["machine_plan"],
					'shift_plan' => $_POST["shift_plan"],
					'tgl_kirim_plan' => $_POST["tgl_kirim_plan"],
					'next_plan' => $_POST["next_plan"],
					'lebar_roll_p' => $_POST["lebar_roll_p"],
					'panjang_plan' => $_POST["panjang_plan"],
					'lebar_plan' => $_POST["lebar_plan"],
					'out_plan' => $_POST["out_plan"],
					'trim_plan' => $_POST["trim_plan"],
					'c_off_p' => $_POST["c_off_p"],
					'rm_plan' => $_POST["rm_plan"],
					'tonase_plan' => $_POST["tonase_plan"],
					'material_plan' => $_POST["material_plan"],
					'kualitas_plan' => $_POST["kualitas_plan"],
					'kualitas_isi_plan' => $_POST["kualitas_isi_plan"],
					'creasing_wo1' => $_POST["creasing_wo1"],
					'creasing_wo2' => $_POST["creasing_wo2"],
					'creasing_wo3' => $_POST["creasing_wo3"],
				)
			);

			$tgl_plan = $_POST["tgl_plan"];
			$id_so_detail = $_POST["id_so_detail"];
			$id_wo = $_POST["id_wo"];
			$id_produk = $_POST["id_produk"];
			$id_pelanggan = $_POST["id_pelanggan"];
			$machine_plan = $_POST["machine_plan"];
			$shift_plan = $_POST["shift_plan"];
			$cekHariPlan = $this->db->query("SELECT*FROM plan_cor
			WHERE id_so_detail='$id_so_detail' AND id_wo='$id_wo' AND id_produk='$id_produk' AND id_pelanggan='$id_pelanggan' AND tgl_plan='$tgl_plan' AND shift_plan='$shift_plan' AND machine_plan='$machine_plan'")->num_rows();
			if($cekHariPlan > 0){
				echo json_encode(array('data' => false, 'isi' => 'PLAN SUDAH ADA DI TGL / SHIFT / MESIN YANG SAMA!'));
				return;
			}else{
				if($this->cart->total_items() != 0){
					foreach($this->cart->contents() as $r){
						if($r['id'] == $_POST["id_wo"]){
							echo json_encode(array('data' => false, 'isi' => 'WO SUDAH MASUK LIST PLAN!'));
							return;
						}
					}
					$this->cart->insert($data);
					echo json_encode(array('data' => true, 'opsi' => $opsi, 'isi' => $data));
				}else{
					$this->cart->insert($data);
					echo json_encode(array('data' => true, 'opsi' => $opsi, 'isi' => $data));
				}
			}
		}else{
			$edit = $this->m_plan->addRencanaPlan();
			echo json_encode(array('data' => true, 'opsi' => $opsi, 'isi' => $edit));
		}
	}

	function listRencanaPlan()
	{
		$html = '';
		if($this->cart->total_items() != 0){
			$html .='<div class="card card-success card-outline">
			<div class="card-header">
				<h3 class="card-title" style="font-weight:bold;font-style:italic">LIST PLAN</h3>
			</div>
			<div class="card-body row" style="padding:0 0 20px">
				<div class="col-md-12">
					<input type="hidden" id="list-rencana-plan-isi" value="isi">
					<table class="table table-striped">
						<thead>
							<tr>
								<th style="width=5%">#</th>
								<th style="width=90%">NO. WO</th>
								<th style="width=5%">AKSI</th>
							</tr>
						</thead>
						<tbody>';
		}

		$i = 0;
		foreach($this->cart->contents() as $r){
			$i++;
			$html .='<tr>
				<td>'.$i.'</td>
				<td><a href="javascript:void(0)" onclick="showCartitem('."'".$r['rowid']."'".')">'.$r['options']['no_wo'].'<a></td>
				<td>
					<button class="btn btn-sm btn-danger" onclick="hapusCartItem('."'".$r['rowid']."'".')"><i class="fas fa-times"></i> BATAL</button>
				</td>
			</tr>';
		}

		if($this->cart->total_items() != 0){
			$html .= '</tbody>
					</table>
					<button class="btn btn-sm btn-primary" style="margin-left:20px" onclick="simpanCartItem('."'".$r['rowid']."'".')"><i class="fas fa-save"></i> SIMPAN</button>
				</div>
			</div>';
		}

		echo $html;	
	}

	function simpanCartItem()
	{
		$result = $this->m_plan->simpanCartItem();
		echo json_encode($result);
	}

	function showCartitem()
	{
		$html = '';
		foreach($this->cart->contents() as $r){
			if($r['rowid'] == $_POST["rowid"]){
				$html .= '<div class="row">
					<div class="col-md-6">
						<div class="card card-secondary card-outline" style="padding-bottom:20px">
							<div class="card-header" style="margin-bottom:15px">
								<h3 class="card-title" style="font-weight:bold;font-style:italic">RINCIAN</h3>
							</div>
							<div class="card-body row" style="padding:2px 20px;font-weight:bold">
								<div class="col-md-2">TANGGAL</div>
								<div class="col-md-10">
									<input type="text" class="form-control" value="'.$this->m_fungsi->tanggal_format_indonesia($r['options']['tgl_plan']).'" disabled>
								</div>
							</div>
							<div class="card-body row" style="padding:2px 20px;font-weight:bold">
								<div class="col-md-2">SHIFT</div>
								<div class="col-md-10">
									<input type="text" class="form-control" value="'.$r['options']['shift_plan'].'" disabled>
								</div>
							</div>
							<div class="card-body row" style="padding:2px 20px;font-weight:bold">
								<div class="col-md-2">MESIN</div>
								<div class="col-md-10">
									<input type="text" class="form-control" value="'.$r['options']['machine_plan'].'" disabled>
								</div>
							</div>
							<div class="card-body row" style="padding:2px 20px;font-weight:bold">
								<div class="col-md-2">NO. WO</div>
								<div class="col-md-10">
									<input type="text" class="form-control" value="'.$r['options']['no_wo'].'" disabled>
								</div>
							</div>
						</div>
					</div>

					<div class="col-md-6">
						<div class="card card-info card-outline" style="padding-bottom:20px">
							<div class="card-header" style="margin-bottom:15px">
								<h3 class="card-title" style="font-weight:bold;font-style:italic">PLAN</h3>
							</div>
							<div class="card-body row" style="padding:2px 20px;font-weight:bold">
								<div class="col-md-2" style="padding:0">PANJANG</div>
								<div class="col-md-10">
									<input type="text" class="form-control" value="'.number_format($r['options']['panjang_plan']).'" disabled>
								</div>
							</div>
							<div class="card-body row" style="padding:2px 20px;font-weight:bold">
								<div class="col-md-2">LEBAR</div>
								<div class="col-md-10">
									<input type="text" class="form-control" value="'.number_format($r['options']['lebar_plan']).'" disabled>
								</div>
							</div>
							<div class="card-body row" style="padding:2px 20px;font-weight:bold">
								<div class="col-md-2" style="padding-right:0">L. ROLL</div>
								<div class="col-md-10">
									<input type="text" class="form-control" value="'.number_format($r['options']['lebar_roll_p']).'" disabled>
								</div>
							</div>
							<div class="card-body row" style="padding:2px 20px;font-weight:bold">
								<div class="col-md-2">OUT</div>
								<div class="col-md-10">
									<input type="text" class="form-control" value="'.number_format($r['options']['out_plan']).'" disabled>
								</div>
							</div>
							<br/>
							<div class="card-body row" style="padding:2px 20px;font-weight:bold">
								<div class="col-md-2">QTY</div>
								<div class="col-md-10">
									<input type="text" class="form-control" value="'.number_format($r['options']['pcs_plan']).'" disabled>
								</div>
							</div>
							<div class="card-body row" style="padding:2px 20px;font-weight:bold">
								<div class="col-md-2">TRIM</div>
								<div class="col-md-10">
									<input type="text" class="form-control" value="'.number_format($r['options']['trim_plan']).'" disabled>
								</div>
							</div>
							<div class="card-body row" style="padding:2px 20px;font-weight:bold">
								<div class="col-md-2" style="padding-right:0">C.OFF</div>
								<div class="col-md-10">
									<input type="text" class="form-control" value="'.number_format($r['options']['c_off_p']).'" disabled>
								</div>
							</div>
							<div class="card-body row" style="padding:2px 20px;font-weight:bold">
								<div class="col-md-2">RM</div>
								<div class="col-md-10">
									<input type="text" class="form-control" value="'.number_format($r['options']['rm_plan']).'" disabled>
								</div>
							</div>
							<div class="card-body row" style="padding:2px 20px;font-weight:bold">
								<div class="col-md-2">TON</div>
								<div class="col-md-10">
									<input type="text" class="form-control" value="'.number_format($r['options']['tonase_plan']).'" disabled>
								</div>
							</div>
							<br/>
							<div class="card-body row" style="padding:2px 20px;font-weight:bold">
								<div class="col-md-2" style="padding-right:0">KIRIM</div>
								<div class="col-md-10">
									<input type="text" class="form-control" value="'.$this->m_fungsi->tanggal_format_indonesia($r['options']['tgl_kirim_plan']).'" disabled>
								</div>
							</div>
							<div class="card-body row" style="padding:2px 20px;font-weight:bold">
								<div class="col-md-2">NEXT</div>
								<div class="col-md-10">
									<input type="text" class="form-control" value="'.$r['options']['next_plan'].'" disabled>
								</div>
							</div>
						</div>
					</div>
				</div>';
			}
		}

		echo $html;
	}

	function loadDataPlan()
	{
		$getData = $this->m_plan->loadDataPlan();
		echo json_encode(array(
			'data' => true,
			'planCor' => $getData,
		));
	}

	function produksiRencanaPlan()
	{
		$result = $this->m_plan->produksiRencanaPlan();
		echo json_encode($result);
	}

	function hapusPlan()
	{
		$result = $this->m_plan->hapusPlan();
		echo json_encode($result);
	}

	function selesaiPlan()
	{
		$result = $this->m_plan->selesaiPlan();
		echo json_encode($result);
	}

	function selesaiPlanWO()
	{
		$result = $this->m_plan->selesaiPlanWO();
		echo json_encode($result);
	}

	function laporanPlan()
	{
		$html = '';
		$no_plan = $_GET['no_plan'];

		$html .= '<table style="margin:0;padding:0;font-size:10px;text-align:center;border-collapse:collapse;color:#000;width:100%">
			<thead>
				<tr>
					<th style="width:5%;border:1px solid #000;border-width:1px 0 0 1px" rowspan="2">
						<img src="'.base_url('assets/gambar/ppi.png').'" alt="PPI" width="70" height="60">
					</th>
					<th style="width:45%;border:1px solid #000;border-width:1px 0 0;font-weight:bold;text-align:left;font-size:16px;padding-left:10px">PT. PRIMA PAPER INDONESIA</th>
					<th style="width:35%;border:1px solid #000;border-width:1px 1px 0 0;font-weight:bold;text-align:right;font-size:14px;padding-right:10px">CORRUGATORs PLAN</th>
					<th style="width:15%;border:1px solid #000;border-width:1px 1px 0;text-align:left;font-weight:bold" rowspan="2">
						<table style="margin:0;padding:0;font-size:10px;font-weight:normal;text-align:left;border-collapse:collapse">
							<tr>
								<td>No</td>
								<td style="padding:0 5px">:</td>
								<td>FR-PPIC-01</td>
							</tr>
							<tr>
								<td>Tgl Terbit</td>
								<td style="padding:0 5px">:</td>
								<td>27 Sep 2022</td>
							</tr>
							<tr>
								<td>Rev</td>
								<td style="padding:0 5px">:</td>
								<td>00</td>
							</tr>
							<tr>
								<td>Hal</td>
								<td style="padding:0 5px">:</td>
								<td>1</td>
							</tr>
						</table>
					</th>
				</tr>
				<tr>
					<th style="vertical-align:top;font-style:italic;font-weight:normal;text-align:left;padding-left:10px">Dusun Timang Kulon, Desa Wonokerto, Wonogiri</th>
					<th></th>
				</tr>
			</thead>
		</table>';

		$query = $this->db->query("SELECT l.*,m.*,p.*,m.kategori AS kategoriItem,w.kode_po AS no_po,w.flap1,w.creasing2 AS creasing2wo,w.flap2 FROM plan_cor l
		INNER JOIN m_produk m ON l.id_produk=m.id_produk
		INNER JOIN m_pelanggan p ON l.id_pelanggan=p.id_pelanggan
		INNER JOIN trs_wo w ON l.id_wo=w.id
		WHERE no_plan='$no_plan'");

		$html .= '<table style="margin:0;padding:0;font-size:10px;text-align:center;border-collapse:collapse;color:#000;width:100%">';
		$html .= '<thead>
			<tr>
				<th style="width:2%;border:0;padding:0"></th>
				<th style="width:18%;border:0;padding:0"></th>
				<th style="width:4%;border:0;padding:0"></th>
				<th style="width:9%;border:0;padding:0"></th>
				<th style="width:2%;border:0;padding:0"></th>
				<th style="width:4%;border:0;padding:0"></th>
				<th style="width:8%;border:0;padding:0"></th>
				<th style="width:4%;border:0;padding:0"></th>
				<th style="width:4%;border:0;padding:0"></th>
				<th style="width:2%;border:0;padding:0"></th>
				<th style="width:2%;border:0;padding:0"></th>
				<th style="width:4%;border:0;padding:0"></th>
				<th style="width:4%;border:0;padding:0"></th>
				<th style="width:4%;border:0;padding:0"></th>
				<th style="width:4%;border:0;padding:0"></th>
				<th style="width:4%;border:0;padding:0"></th>
				<th style="width:4%;border:0;padding:0"></th>
				<th style="width:3%;border:0;padding:0"></th>
				<th style="width:14%;border:0;padding:0"></th>
			</tr>
			<tr text-rotate="-90">
				<th text-rotate="0" style="font-weight:bold;border:1px solid #000" rowspan="4">ID</th>
				<th text-rotate="0" style="font-weight:bold;border:1px solid #000;border-width:1px 1px 0;text-align:left">NO. SO/WO</th>
				<th text-rotate="0" style="font-weight:bold;border:1px solid #000" rowspan="4">TGL KIRIM</th>
				<th text-rotate="0" style="font-weight:bold;border:1px solid #000" rowspan="4">KUALITAS SHEET</th>
				<th style="font-weight:bold;border:1px solid #000" rowspan="4">FLUTE</th>
				<th text-rotate="0" style="font-weight:bold;border:1px solid #000" rowspan="4">LEBAR ROLL</th>
				<th text-rotate="0" style="font-weight:bold;border:1px solid #000" rowspan="4">SCORING LINE</th>
				<th text-rotate="0" style="font-weight:bold;border:1px solid #000" rowspan="2" colspan="2">SHEET SIZE</th>
				<th style="font-weight:bold;border:1px solid #000" rowspan="4">OUT</th>
				<th style="font-weight:bold;border:1px solid #000" rowspan="4">TRIM</th>
				<th text-rotate="0" style="font-weight:bold;border:1px solid #000" rowspan="2" colspan="5">RENCANA PRODUKSI</th>
				<th text-rotate="0" style="font-weight:bold;border:1px solid #000" rowspan="2">WAKTU</th>
				<th style="font-weight:bold;border:1px solid #000" rowspan="4">NEXT</th>
				<th text-rotate="0" style="font-weight:bold;border:1px solid #000" rowspan="4">KET</th>
			</tr>
			<tr>
				<th style="font-weight:bold;border:1px solid #000;border-width:0 1px;text-align:left">CUSTOMER</th>
			</tr>
			<tr>
				<th style="font-weight:bold;border:1px solid #000;border-width:0 1px;text-align:left">NO. PO</th>
				<th style="font-weight:bold;border:1px solid #000;border-width:0 1px">P</th>
				<th style="font-weight:bold;border:1px solid #000;border-width:0 1px">L</th>
				<th style="font-weight:bold;border:1px solid #000" rowspan="2">COUNT PCS</th>
				<th style="font-weight:bold;border:1px solid #000" rowspan="2">NUM OF CUT</th>
				<th style="font-weight:bold;border:1px solid #000" rowspan="2">RM</th>
				<th style="font-weight:bold;border:1px solid #000" rowspan="2">TON</th>
				<th style="font-weight:bold;border:1px solid #000" rowspan="2">BAD SHEET</th>
				<th style="font-weight:bold;border:1px solid #000;border-width:0 1px">START</th>
			</tr>
			<tr>
				<th style="font-weight:bold;border:1px solid #000;border-width:0 1px 1px;text-align:left">ITEM</th>
				<th style="font-weight:bold;border:1px solid #000;border-width:0 1px 1px">mm</th>
				<th style="font-weight:bold;border:1px solid #000;border-width:0 1px 1px">mm</th>
				<th style="font-weight:bold;border:1px solid #000;border-width:0 1px 1px">END</th>
			</tr>
			<tr>
				<th style="padding:2px 0;font-weight:bold;text-align:left" colspan="2">PERIODE : '.strtoupper($this->m_fungsi->tanggal_format_indonesia($query->row()->tgl_plan)).'</th>
				<th style="padding:2px 0;font-weight:bold;text-align:left" colspan="2">MACHINE : '.$query->row()->machine_plan.'</th>
				<th style="padding:2px 0;font-weight:bold;text-align:left" colspan="3">SHIFT : '.$query->row()->shift_plan.'</th>
			</tr>
		</thead>';

		$i = 0;
		foreach($query->result() as $r){
			$i++;

			$expKualitas = explode("/", $r->kualitas);
			if($r->flute == 'BCF'){
				if($expKualitas[1] == 'M125' && $expKualitas[2] == 'M125' && $expKualitas[3] == 'M125'){
					$kualitas = $expKualitas[0].'/'.$expKualitas[1].'x3/'.$expKualitas[4];
				}else if($expKualitas[1] == 'K125' && $expKualitas[2] == 'K125' && $expKualitas[3] == 'K125'){
					$kualitas = $expKualitas[0].'/'.$expKualitas[1].'x3/'.$expKualitas[4];
				}else if($expKualitas[1] == 'M150' && $expKualitas[2] == 'M150' && $expKualitas[3] == 'M150'){
					$kualitas = $expKualitas[0].'/'.$expKualitas[1].'x3/'.$expKualitas[4];
				}else if($expKualitas[1] == 'K150' && $expKualitas[2] == 'K150' && $expKualitas[3] == 'K150'){
					$kualitas = $expKualitas[0].'/'.$expKualitas[1].'x3/'.$expKualitas[4];
				}else{
					$kualitas = $r->kualitas;
				}
			}else{
				$kualitas = $r->kualitas;
			}

			if($r->kategoriItem == 'K_BOX'){
				$score = $r->flap1.' - '.$r->creasing2wo.' - '.$r->flap2;
			}else if($r->kategoriItem == 'K_SHEET'){
				if($r->flap1 != 0 && $r->creasing2wo != 0 && $r->flap2 != 0){
					$score = $r->flap1.' - '.$r->creasing2wo.' - '.$r->flap2;
				}else{
					$score = '-';
				}
			}else{
				$score = '-';
			}

			if($r->next_plan == 'GUDANG'){
				$nextPlan = 'G. B. <br>JADI';
			}else{
				$nextPlan = $r->next_plan;
			}
			
			$html .= '<tbody>
				<tr>
					<td style="border:1px solid #000" rowspan="4">'.$i.'</td>
					<td style="border:1px solid #000;text-align:left">'.$r->no_so.'</td>
					<td style="border:1px solid #000" rowspan="4">'.$this->m_fungsi->tglPlan($r->tgl_kirim_plan).'</td>
					<td style="border:1px solid #000" rowspan="4">'.$kualitas.'</td>
					<td style="border:1px solid #000" rowspan="4">'.$r->flute.'</td>
					<td style="border:1px solid #000;font-weight:bold" rowspan="4">'.$r->lebar_roll_p.'</td>
					<td style="border:1px solid #000" rowspan="4">'.$score.'</td>
					<td style="border:1px solid #000;font-weight:bold;color:#f00" rowspan="4">'.$r->panjang_plan.'</td>
					<td style="border:1px solid #000;font-weight:bold;color:#f00" rowspan="4">'.$r->lebar_plan.'</td>
					<td style="border:1px solid #000" rowspan="4">'.number_format($r->out_plan).'</td>
					<td style="border:1px solid #000" rowspan="4">'.number_format($r->trim_plan).'</td>
					<td style="border:1px solid #000;border-bottom:1px dotted #000" rowspan="2">'.number_format($r->pcs_plan).'</td>
					<td style="border:1px solid #000;border-bottom:1px dotted #000" rowspan="2">'.number_format($r->c_off_p).'</td>
					<td style="border:1px solid #000;border-bottom:1px dotted #000" rowspan="2">'.number_format($r->rm_plan).'</td>
					<td style="border:1px solid #000;border-bottom:1px dotted #000" rowspan="2">'.number_format($r->tonase_plan).'</td>
					<td style="border:1px solid #000;border-bottom:1px dotted #000" rowspan="2"></td>
					<td style="border:1px solid #000;border-bottom:1px dotted #000" rowspan="2"></td>
					<td style="border:1px solid #000" rowspan="4">'.$nextPlan.'</td>
					<td style="border:1px solid #000" rowspan="4">'.$r->ket_plan.'</td>
				</tr>
				<tr>
					<td style="border:1px solid #000;border-width:0 1px;text-align:left">'.$r->nm_pelanggan.'</td>
				</tr>
				<tr>
					<td style="border:1px solid #000;border-width:0 1px;text-align:left">'.$r->no_po.'</td>
					<td style="border:1px solid #000;border-width:0 1px 1px" rowspan="2"></td>
					<td style="border:1px solid #000;border-width:0 1px 1px" rowspan="2"></td>
					<td style="border:1px solid #000;border-width:0 1px 1px" rowspan="2"></td>
					<td style="border:1px solid #000;border-width:0 1px 1px" rowspan="2"></td>
					<td style="border:1px solid #000;border-width:0 1px 1px" rowspan="2"></td>
					<td style="border:1px solid #000;border-width:0 1px 1px" rowspan="2"></td>
				</tr>
				<tr>
					<td style="border:1px solid #000;border-width:0 1px 1px;text-align:left">'.$r->nm_produk.'</td>
				</tr>
			</tbody>';
		}
		
		$html .= '</table>';
		
		$judul = $query->row()->tgl_plan.'-'.$no_plan;
		$this->m_fungsi->newMpdf($judul, '', $html, 1, 3, 1, 3, 'L', 'A4');
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

	function Cetak_plan2()
	{
		$no_plan             = $_GET['no_plan'];
		
		$header    = $this->db->query("SELECT * from plan_cor where no_plan= '$no_plan' order by id_plan LIMIT 1");

		if ($header->num_rows() > 0) {

			$head = $header->row();
			
			$html = '<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:14px;font-family: ;">
                            
					<tr style="font-weight: bold;">
						<td colspan="15" align="center">
						<b> ( ' . $head->no_plan . ' )</b>
						</td>
					</tr>
			</table><br>';

			$html .= '<table width="100%" border="1" cellspacing="1" cellpadding="3" style="border-collapse:collapse;font-size:12px;font-family: ;">
				<thead>
				<tr style="background-color: #cccccc">
					<th width="2%" align="center">No</th>
					<th width="5%" align="center">Item</th>
					<th width="5%" align="center">No PO</th>
					<th width="5%" align="center">Customer</th>
					<th width="8%" align="center" colspan="2" >TL/AL</th>
					<th width="7%" align="center" colspan="2" >B MF	</th>
					<th width="7%" align="center" colspan="2" >B.L </th>
					<th width="7%" align="center" colspan="2" >C.MF	</th>
					<th width="7%" align="center" colspan="2" >C.L </th>
					<th width="5%" align="center">pjg</th>
					<th width="3%" align="center">lbr</th>
					<th width="5%" align="center" colspan="3" >Score</th>
					<th width="3%" align="center">Out</th>
					<th width="3%" align="center">Fl </th>
					<th width="5%" align="center">Lbr Roll</th>
					<th width="3%" align="center">Trim</th>
					<th width="5%" align="center">Qty</th>
					<th width="5%" align="center">C.off</th>
					<th width="5%" align="center">RM</th>
					<th width="5%" align="center">KG</th>
					<th width="5%" align="center">TGL KIRIM</th>
				</tr>
				</thead>
				';
			$no = 1;
			$data    = $this->db->query("SELECT*FROM plan_cor a 
			JOIN m_produk b ON a.id_produk=b.id_produk
			JOIN m_pelanggan c ON a.id_pelanggan=c.id_pelanggan
			JOIN trs_so_detail d ON a.id_so_detail=d.id
			JOIN trs_wo e ON a.id_wo=e.id
			where no_plan = '$no_plan' ")->result();
 
			foreach ($data as $r) {

				$substance = explode("/", $r->material_plan);
				$gramature = explode("/", $r->kualitas_isi_plan);

				if( $r->flute =='BCF'){

					$s1 = $substance[0];
					$s2 = $substance[1];
					$s3 = $substance[2];
					$s4 = $substance[3];
					$s5 = $substance[4];

					$grm1 = $gramature[0];
					$grm2 = $gramature[1];
					$grm3 = $gramature[2];
					$grm4 = $gramature[3];
					$grm5 = $gramature[4];

				}else if( $r->flute =='BF'){
					
					$s1 = $substance[0];
					$s2 = $substance[1];
					$s3 = $substance[2];
					$s4 = 0;
					$s5 = 0;
					
					$grm1 = $gramature[0];
					$grm2 = $gramature[1];
					$grm3 = $gramature[2];
					$grm4 = 0;
					$grm5 = 0;

				}else if( $r->flute =='CF'){
					
					$s1 = $substance[0];
					$s2 = 0;
					$s3 = 0;
					$s4 = $substance[1];
					$s5 = $substance[2];
					
					$grm1 = $gramature[0];
					$grm2 = 0;
					$grm3 = 0;
					$grm4 = $gramature[1];
					$grm5 = $gramature[2];

				}
				$bold= 'font-weight:bold';
				$html .= '
					<tbody>
                        <tr>
                            <td align="center">'.$no.'</td>
                            <td align="center">'. $r->nm_produk .'</td>
                            <td align="center">'. $r->no_po .'</td>
                            <td align="center">'. $r->nm_pelanggan .'</td>
                            <td width="3%" align="center" style="color:red"><b>'. $s1.'</b></td>
                            <td width="3%" align="center">'. $grm1.'</td>
                            <td width="3%" align="center" style="color:red"><b>'. $s2.'</b></td>
                            <td width="3%" align="center">'. $grm2.'</td>
                            <td width="3%" align="center" style="color:red"><b>'. $s3.'</b></td>
                            <td width="3%" align="center">'. $grm3.'</td>
                            <td width="3%" align="center" style="color:red"><b>'. $s4.'</b></td>
                            <td width="3%" align="center">'. $grm4.'</td>
                            <td width="3%" align="center" style="color:red"><b>'. $s5.'</b></td>
                            <td width="3%" align="center">'. $grm5.'</td>
                            <td align="center" style="color:red;'.$bold.'">'. $r->panjang_plan .'</td>
                            <td align="center" style="color:red;'.$bold.'">'. $r->lebar_plan .'</td>

                            <td width="3%" align="center">'. $r->flap1 .'</td>
                            <td width="3%" align="center">'. $r->flap1 .'</td>
                            <td width="3%" align="center">'. $r->flap1 .'</td>

                            <td align="center">'. $r->out_plan .'</td>
                            <td align="center">'. $r->flute .' </td>
                            <td align="center">'. $r->lebar_roll_p .'</td>
                            <td align="center">'. $r->trim_plan .'</td>
                            <td align="center" style="color:red;'.$bold.'">'. $r->pcs_plan .'</td>
                            <td align="center">'. $r->c_off_p .'</td>
                            <td align="center">'. $r->rm_plan .'</td>
                            <td align="center">'. $r->tonase_plan .'</td>
                            <td align="center" style="color:red;'.$bold.'">'. $this->m_fungsi->tanggal_ind($r->tgl_kirim_plan) .'</td>
                        </tr>
					</tbody>
					';

						$no++;
			}
			$html .='</table>';

		} else {
			$html .= '<h1> Data Kosong </h1>';
		}

		// $this->m_fungsi->_mpdf($html);
		
		$this->m_fungsi->template_kop('PLAN CORR',$html,'L','1');
		// $this->m_fungsi->mPDFP($html);
	}

}
