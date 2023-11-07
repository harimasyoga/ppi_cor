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
		$query = $this->db->query("SELECT*FROM plan_cor GROUP BY tgl_plan")->result();
		$i = 0;
		foreach ($query as $r) {
			$i++;
			$row = array();
			$row[] = $i;
			$row[] = $r->tgl_plan;
			$row[] = $r->shift_plan;
			$row[] = $r->machine_plan;

			$link = base_url('Plan/Corrugator/List/'.$r->tgl_plan.'/'.$r->shift_plan.'/'.$r->machine_plan);
			
			$row[] = '<a href="'.$link.'"><button type="button" class="btn btn-dark btn-sm"><i class="fas fa-print"></i></button></a>

			<a href="'.$link.'"><button type="button" class="btn btn-warning btn-sm"><i class="fas fa-print"></i></button></a>
			
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
					echo json_encode(array('data' => true, 'isi' => $data));
				}else{
					$this->cart->insert($data);
					echo json_encode(array('data' => true, 'isi' => $data));
				}
			}
		}else{
			echo json_encode(array('data' => true, 'isi' => 'edit'));
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
					<button class="btn btn-sm btn-primary" style="margin-left:20px" onclick="simpanCartItem()"><i class="fas fa-save"></i> SIMPAN</button>
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
					<div class="col-md-12">
						<div class="card card-info card-outline">
							<div class="card-header">
								<h3 class="card-title" style="font-weight:bold;font-style:italic">WO</h3>
							</div>
							<div class="card-body row" style="padding-bottom:5px;font-weight:bold">
								<div class="col-md-1">NO. WO</div>
								<div class="col-md-11">'.$r['options']['no_wo'].'</div>
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
		$tgl_plan = $_POST["tgl_plan"];
		$shift = $_POST["shift"];
		$mesin = $_POST["mesin"];
		// $getData = $this->db->query("SELECT pl.*,i.*,l.*,s.eta_so,s.qty_so,s.rm AS rmSO,s.ton AS tonSO,s.ket_so AS ketSO,m.nm_sales,w.tgl_wo,w.flap1,w.creasing2,w.flap2 FROM plan_cor pl
		// INNER JOIN m_produk i ON pl.id_produk=i.id_produk
		// INNER JOIN m_pelanggan l ON pl.id_pelanggan=l.id_pelanggan
		// INNER JOIN m_sales m ON l.id_sales=m.id_sales
		// INNER JOIN trs_wo w ON pl.id_wo=w.id
		// INNER JOIN trs_so_detail s ON pl.id_so_detail=s.id
		// WHERE pl.tgl_plan='$tgl_plan' AND pl.shift_plan='$shift' AND pl.machine_plan='$mesin'");
		$getData = $this->db->query("SELECT * FROM plan_cor pl
		WHERE pl.tgl_plan='$tgl_plan' AND pl.shift_plan='$shift' AND pl.machine_plan='$mesin'");
		echo json_encode(array(
			'data' => true,
			'planCor' => $getData->result(),
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
