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
			}else{
				$this->load->view('Plan/Cor/v_corr');
			}
		}else if($jenis == 'List'){
			if(in_array($this->session->userdata('level'), ['Admin','PPIC','Corrugator'])){
				$data = array(
					"tgl_plan" => $this->uri->segment(4),
					"shift" => $this->uri->segment(5),
					"mesin" => $this->uri->segment(6),
				);
				$this->load->view('Plan/Cor/v_corr_plan', $data);
			}else{
				$this->load->view('Plan/Cor/v_corr');
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
			if(in_array($this->session->userdata('level'), ['Admin','PPIC'])){
				$btnPrint = '
				<a target="_blank" class="btn btn-sm btn-success" href="' . base_url("Plan/Cetak_plan2?no_plan=" . $r->no_plan . "") . '" title="Cetak" ><i class="fas fa-print"></i></a>
				<a target="_blank" class="btn btn-sm btn-primary" href="'.base_url("Plan/laporanPlan?no_plan=".$r->no_plan."").'" title="Cetak SO" ><i class="fas fa-print"></i></a>';
			}else{
				$btnPrint = '';
			}
			$row[] = '<a href="'.$link.'" title="Edit"><button type="button" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></button></a>'.$btnPrint;

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
			
			$opsi = $_POST['opsi'];
			$getNoPlan = $this->db->query("SELECT*FROM plan_cor WHERE id_plan='$opsi'")->row();
			$urutDtProd = $this->db->query("SELECT*FROM plan_cor
			WHERE no_plan='$getNoPlan->no_plan' AND total_cor_p='0' AND no_urut_plan!='0'
			ORDER BY no_urut_plan ASC LIMIT 1")->row();
		}else{
			$result = $getWo->result();
			$data = false;
			$getNoPlan = false;
			$urutDtProd = false;
		}
		echo json_encode(array(
			'data' => $data,
			'opsi' => $_POST['opsi'],
			'wo' => $result,
			'getNoPlan' => $getNoPlan,
			'urutDtProd' => $urutDtProd,
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
					'nm_produk' => $_POST["nm_produk"],
					'id_pelanggan' => $_POST["id_pelanggan"],
					'customer' => $_POST["customer"],
					'no_wo' => $_POST["no_wo"],
					'no_so' => $_POST["no_so"],
					'kode_po' => $_POST["kode_po"],
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
					'kategori' => $_POST["kategori"],
					'kupingan' => $_POST["kupingan"],
					'p1' => $_POST["p1"],
					'l1' => $_POST["l1"],
					'p2' => $_POST["p2"],
					'l2' => $_POST["l2"],
					'panjangWO' => $_POST["panjangWO"],
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
				<h3 class="card-title" style="font-weight:bold;font-style:italic">LIST PLAN BARU</h3>
			</div>
			<div style="overflow:auto;white-space:nowrap;padding-bottom:10px">
				<table class="table table-bordered table-striped">
					<thead>
						<tr>
							<th>#</th>
							<th style="padding:12px 6px">ITEM</th>
							<th style="padding:12px 6px">NO. PO</th>
							<th style="padding:12px 6px">CUSTOMER</th>
							<th style="padding:12px 6px">SUBSTANCE</th>
							<th style="padding:12px 6px">PJG</th>
							<th style="padding:12px 6px">LBR</th>
							<th style="padding:12px 6px">SCORE</th>
							<th style="padding:12px 6px">OUT</th>
							<th style="padding:12px 6px">L.ROLL</th>
							<th style="padding:12px 6px">TRIM</th>
							<th style="padding:12px 6px">ORDER</th>
							<th style="padding:12px 6px">C.OFF</th>
							<th style="padding:12px 6px">RM</th>
							<th style="padding:12px 6px">KG</th>
							<th style="padding:12px 6px">TGL KIRIM</th>
							<th style="padding:12px 6px">NEXT</th>
							<th>AKSI</th>
						</tr>
					</thead>
					<tbody>';
		}

		$i = 0;
		foreach($this->cart->contents() as $r){
			$i++;

			if($r['options']['creasing_wo1'] == 0 || $r['options']['creasing_wo2'] == 0 || $r['options']['creasing_wo3'] == 0){
				$score = '-';
			}else{
				$score = $r['options']['creasing_wo1'].' - '.$r['options']['creasing_wo2'].' - '.$r['options']['creasing_wo3'];
			}
			$html .='<tr>
				<td style="padding:6px;text-align:center">'.$i.'</td>
				<td style="padding:6px"><a href="javascript:void(0)" onclick="showCartitem('."'".$r['id']."'".','."'input'".')">'.$r['options']['nm_produk'].'<a></td>
				<td style="padding:6px">'.$r['options']['kode_po'].'</td>
				<td style="padding:6px">'.$r['options']['customer'].'</td>
				<td style="padding:6px">'.$r['options']['kualitas_plan'].'</td>
				<td style="padding:6px;text-align:center">'.number_format($r['options']['panjang_plan']).'</td>
				<td style="padding:6px;text-align:center">'.number_format($r['options']['lebar_plan']).'</td>
				<td style="padding:6px">'.$score.'</td>
				<td style="padding:6px;text-align:center">'.number_format($r['options']['out_plan']).'</td>
				<td style="padding:6px;text-align:center">'.number_format($r['options']['lebar_roll_p']).'</td>
				<td style="padding:6px;text-align:center">'.number_format($r['options']['trim_plan']).'</td>
				<td style="padding:6px;text-align:center">'.number_format($r['options']['pcs_plan']).'</td>
				<td style="padding:6px;text-align:center">'.number_format($r['options']['c_off_p']).'</td>
				<td style="padding:6px;text-align:center">'.number_format($r['options']['rm_plan']).'</td>
				<td style="padding:6px;text-align:center">'.number_format($r['options']['tonase_plan']).'</td>
				<td style="padding:6px;text-align:center">'.strtoupper($this->m_fungsi->tanggal_format_indonesia($r['options']['tgl_kirim_plan'])).'</td>
				<td style="padding:6px">'.$r['options']['next_plan'].'</td>
				<td style="padding:0">
					<button class="btn btn-sm btn-danger" onclick="hapusCartItem('."'".$r['rowid']."'".')"><i class="fas fa-times"></i> BATAL</button>
				</td>
			</tr>';
		}

		if($this->cart->total_items() != 0){
			$html .= '</tbody>
					</table>
				<button class="btn btn-sm btn-primary" style="margin-left:20px" onclick="simpanCartItem()"><i class="fas fa-save"></i> SIMPAN</button>
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
		$id_plan = $_POST["rowid"];
		$opsi = $_POST["opsi"];
		if($opsi == 'input'){
			if($this->cart->total_items() != 0){
				foreach($this->cart->contents() as $r){
					if($r['id'] == $_POST["rowid"]){
						$tgl_plan = $this->m_fungsi->tanggal_format_indonesia($r['options']['tgl_plan']); $shift_plan = $r['options']['shift_plan']; $machine_plan = $r['options']['machine_plan']; $no_wo = $r['options']['no_wo']; $panjang_plan = number_format($r['options']['panjang_plan']); $lebar_plan = number_format($r['options']['lebar_plan']); $lebar_roll_p = number_format($r['options']['lebar_roll_p']); $out_plan = number_format($r['options']['out_plan']); $pcs_plan = number_format($r['options']['pcs_plan']); $trim_plan = number_format($r['options']['trim_plan']); $c_off_p = number_format($r['options']['c_off_p']); $rm_plan = number_format($r['options']['rm_plan']); $tonase_plan = number_format($r['options']['tonase_plan']); $tgl_kirim_plan = $this->m_fungsi->tanggal_format_indonesia($r['options']['tgl_kirim_plan']); $next_plan = $r['options']['next_plan'];
						$good_cor_p = ''; $bad_cor_p = ''; $total_cor_p = ''; $ket_plan = ''; $start_time_p = ''; $end_time_p = ''; $downtime = 0;
					}
				}
			}
		}else{
			$plan = $this->db->query("SELECT*FROM plan_cor WHERE id_plan='$id_plan'")->row();
			$downtime = $this->db->query("SELECT*FROM plan_cor_dt dt
			INNER JOIN m_downtime md ON dt.id_m_downtime=md.id_downtime
			WHERE dt.id_plan_cor='$id_plan'");
			$tgl_plan = $this->m_fungsi->tanggal_format_indonesia($plan->tgl_plan); $shift_plan = $plan->shift_plan; $machine_plan = $plan->machine_plan; $no_wo = $plan->no_wo; $panjang_plan = number_format($plan->panjang_plan); $lebar_plan = number_format($plan->lebar_plan); $lebar_roll_p = number_format($plan->lebar_roll_p); $out_plan = number_format($plan->out_plan); $pcs_plan = number_format($plan->pcs_plan); $trim_plan = number_format($plan->trim_plan); $c_off_p = number_format($plan->c_off_p); $rm_plan = number_format($plan->rm_plan); $tonase_plan = number_format($plan->tonase_plan); $tgl_kirim_plan = $this->m_fungsi->tanggal_format_indonesia($plan->tgl_kirim_plan); $next_plan = $plan->next_plan;
			$good_cor_p = number_format($plan->good_cor_p); $bad_cor_p = number_format($plan->bad_cor_p); $total_cor_p = number_format($plan->total_cor_p); $ket_plan = $plan->ket_plan; $start_time_p = date("h:i", strtotime($plan->start_time_p)); $end_time_p = date("h:i", strtotime($plan->end_time_p));
		}

		$html .= '<div class="row">
			<div class="col-md-6">

				<div class="card card-secondary card-outline" style="padding-bottom:20px">
					<div class="card-header" style="margin-bottom:15px">
						<h3 class="card-title" style="font-weight:bold;font-style:italic">RINCIAN</h3>
					</div>
					<div class="card-body row" style="padding:2px 20px;font-weight:bold">
						<div class="col-md-2">TANGGAL</div>
						<div class="col-md-10"><input type="text" class="form-control" value="'.$tgl_plan.'" disabled></div>
					</div>
					<div class="card-body row" style="padding:2px 20px;font-weight:bold">
						<div class="col-md-2">SHIFT</div>
						<div class="col-md-10"><input type="text" class="form-control" value="'.$shift_plan.'" disabled></div>
					</div>
					<div class="card-body row" style="padding:2px 20px;font-weight:bold">
						<div class="col-md-2">MESIN</div>
						<div class="col-md-10"><input type="text" class="form-control" value="'.$machine_plan.'" disabled></div>
					</div>
					<div class="card-body row" style="padding:2px 20px;font-weight:bold">
						<div class="col-md-2">NO. WO</div>
						<div class="col-md-10"><input type="text" class="form-control" value="'.$no_wo.'" disabled></div>
					</div>
				</div>';

				$hasilProd ='<div class="card card-success card-outline" style="padding-bottom:20px">
					<div class="card-header">
						<h3 class="card-title" style="font-weight:bold;font-style:italic">HASIL PRODUKSI</h3>
					</div>
					<div class="card-body row" style="padding-bottom:5px;font-weight:bold">
						<div class="col-md-2">GOOD</div>
						<div class="col-md-10"><input type="text" class="form-control" value="'.$good_cor_p.'" disabled></div>
					</div>
					<div class="card-body row" style="padding:0 20px 5px;font-weight:bold">
						<div class="col-md-2">REJECT</div>
						<div class="col-md-10"><input type="text" class="form-control" value="'.$bad_cor_p.'" disabled></div>
					</div>
					<div class="card-body row" style="padding:0 20px 5px;font-weight:bold">
						<div class="col-md-2">TOTAL</div>
						<div class="col-md-10"><input type="text" class="form-control" value="'.$total_cor_p.'" disabled></div>
					</div>
					<div class="card-body row" style="padding:0 20px 5px;font-weight:bold">
						<div class="col-md-2">KET</div>
						<div class="col-md-10"><textarea class="form-control" style="resize:none" rows="2" disabled>'.$ket_plan.'</textarea></div>
					</div>
					<div class="card-body row" style="padding:20px 20px 5px;font-weight:bold">
						<div class="col-md-2">START</div>
						<div class="col-md-10"><input type="text" class="form-control" value="'.$start_time_p.'" disabled></div>
					</div>
					<div class="card-body row" style="padding:0 20px 5px;font-weight:bold">
						<div class="col-md-2">END</div>
						<div class="col-md-10"><input type="text" class="form-control" value="'.$end_time_p.'" disabled></div>
					</div>
				</div>';

				if($opsi == 'input'){
					if($this->cart->total_items() != 0){
						foreach($this->cart->contents() as $r){
							if($r['id'] == $_POST["rowid"]){
								$html .='';
							}
						}
					}
				}else{
					if($downtime->num_rows() == 0){
						$html .='';
					}else{
						$html .= '<div class="card card-danger card-outline" style="padding-bottom:20px">
							<div class="card-header">
								<h3 class="card-title" style="font-weight:bold;font-style:italic">DOWNTIME</h3>
							</div>
							<div style="overflow:auto;white-space:nowrap">
								<table class="table table-bordered" style="margin:0;border:0">
									<thead>
										<tr>
											<th style="text-align:center">#</th>
											<th>KODE</th>
											<th>-</th>
											<th style="padding:12px 54px 12px 12px">KETERANGAN</th>
											<th style="text-align:center">(M)</th>
										</tr>
									</thead>';
									$data = $this->db->query("SELECT*FROM plan_cor_dt p
									INNER JOIN m_downtime d ON p.id_m_downtime=d.id_downtime
									WHERE p.id_plan_cor='$id_plan'");

									if($data->num_rows() == 0){
										$html .= '<tr>
											<td style="padding:6px;text-align:center" colspan="5">DOWNTIME KOSONG</td>
										</tr>';
									}else{
										$i = 0;
										$sumMntDt = 0;
										foreach($data->result() as $r){
											$i++;
											$html .= '<tr class="h-tmpl-list-plan">
												<td style="padding:6px;text-align:center">'.$i.'</td>
												<td style="padding:6px;text-align:center">'.$r->kode_d.'</td>
												<td style="padding:6px">'.$r->keterangan.'</td>
												<td style="padding:6px">'.$r->ket_plan_dt.'</td>
												<td style="padding:6px;text-align:center">'.$r->durasi_mnt_dt.'</td>
											</tr>';
											$sumMntDt += $r->durasi_mnt_dt;
										}
										if($data->num_rows() != 1){
											$html .='<tr>
												<td style="border:0;padding:6px;background:#fff;font-weight:bold;text-align:right" colspan="4">TOTAL DOWNTIME(M)</td>
												<td style="border:0;padding:6px;background:#fff;font-weight:bold;text-align:center">'.number_format($sumMntDt).'</td>
											</tr>';
										}
									}
								$html .= '</table>
							</div>
						</div>';
					}
					$html .= $hasilProd;
				}

			$html .='</div>
			<div class="col-md-6">
				<div class="card card-info card-outline" style="padding-bottom:20px">
					<div class="card-header" style="margin-bottom:15px">
						<h3 class="card-title" style="font-weight:bold;font-style:italic">PLAN</h3>
					</div>
					<div class="card-body row" style="padding:2px 20px;font-weight:bold">
						<div class="col-md-2" style="padding:0">PANJANG</div>
						<div class="col-md-10"><input type="text" class="form-control" value="'.$panjang_plan.'" disabled></div>
					</div>
					<div class="card-body row" style="padding:2px 20px;font-weight:bold">
						<div class="col-md-2">LEBAR</div>
						<div class="col-md-10"><input type="text" class="form-control" value="'.$lebar_plan.'" disabled></div>
					</div>
					<div class="card-body row" style="padding:2px 20px;font-weight:bold">
						<div class="col-md-2" style="padding-right:0">L. ROLL</div>
						<div class="col-md-10"><input type="text" class="form-control" value="'.$lebar_roll_p.'" disabled></div>
					</div>
					<div class="card-body row" style="padding:2px 20px;font-weight:bold">
						<div class="col-md-2">OUT</div>
						<div class="col-md-10"><input type="text" class="form-control" value="'.$out_plan.'" disabled></div>
					</div>
					<br/>
					<div class="card-body row" style="padding:2px 20px;font-weight:bold">
						<div class="col-md-2">QTY</div>
						<div class="col-md-10"><input type="text" class="form-control" value="'.$pcs_plan.'" disabled></div>
					</div>
					<div class="card-body row" style="padding:2px 20px;font-weight:bold">
						<div class="col-md-2">TRIM</div>
						<div class="col-md-10"><input type="text" class="form-control" value="'.$trim_plan.'" disabled></div>
					</div>
					<div class="card-body row" style="padding:2px 20px;font-weight:bold">
						<div class="col-md-2" style="padding-right:0">C.OFF</div>
						<div class="col-md-10"><input type="text" class="form-control" value="'.$c_off_p.'" disabled></div>
					</div>
					<div class="card-body row" style="padding:2px 20px;font-weight:bold">
						<div class="col-md-2">RM</div>
						<div class="col-md-10"><input type="text" class="form-control" value="'.$rm_plan.'" disabled></div>
					</div>
					<div class="card-body row" style="padding:2px 20px;font-weight:bold">
						<div class="col-md-2">TON</div>
						<div class="col-md-10"><input type="text" class="form-control" value="'.$tonase_plan.'" disabled></div>
					</div>
					<br/>
					<div class="card-body row" style="padding:2px 20px;font-weight:bold">
						<div class="col-md-2" style="padding-right:0">KIRIM</div>
						<div class="col-md-10"><input type="text" class="form-control" value="'.$tgl_kirim_plan.'" disabled></div>
					</div>
					<div class="card-body row" style="padding:2px 20px;font-weight:bold">
						<div class="col-md-2">NEXT</div>
						<div class="col-md-10"><input type="text" class="form-control" value="'.$next_plan.'" disabled></div>
					</div>
				</div>
			</div>
		</div>';

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
		WHERE no_plan='$no_plan'
		ORDER BY l.no_urut_plan");

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

			$id_plan = $r->id_plan;
			$cekDowntime = $this->db->query("SELECT*FROM plan_cor_dt dt
			INNER JOIN m_downtime md ON dt.id_m_downtime=md.id_downtime
			WHERE dt.id_plan_cor='$id_plan'");
			$txtKet = '';
			if($cekDowntime->num_rows() == 0){
				$txtKet .= '';
			}else{
				foreach($cekDowntime->result() as $dt){
					$txtKet .= $dt->kode_d.' - '.$dt->durasi_mnt_dt.'"'.'<br>';
				}
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
					<td style="border:1px solid #000;border-bottom:1px dotted #000" rowspan="2">'.number_format($r->bad_cor_p).'</td>
					<td style="border:1px solid #000;border-bottom:1px dotted #000" rowspan="2">'.date("h:i", strtotime($r->start_time_p)).'</td>
					<td style="border:1px solid #000" rowspan="4">'.$nextPlan.'</td>
					<td style="border:1px solid #000;text-align:left;vertical-align:top" rowspan="4">'.$txtKet.'</td>
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
					<td style="border:1px solid #000;border-width:0 1px 1px" rowspan="2">'.date("h:i", strtotime($r->end_time_p)).'</td>
				</tr>
				<tr>
					<td style="border:1px solid #000;border-width:0 1px 1px;text-align:left">'.$r->nm_produk.'</td>
				</tr>
			</tbody>';
		}
		
		$html .= '</table>';
		
		$judul = $query->row()->tgl_plan.'-'.$no_plan;
		$this->m_fungsi->newMpdf($judul, '', $html, 1, 3, 1, 3, 'L', 'A4', $judul.'.pdf');
		// echo $html;
	}

	function riwayatPlan()
	{
		$html = '';
		$result = $this->m_plan->riwayatPlan();
		
		if($result->num_rows() == 0){
			$html .='';
		}else{
			$html .='<div class="card card-warning card-outline">
				<div class="card-header">
					<h3 class="card-title" style="font-weight:bold;font-style:italic">RIWAYAT PLAN</h3>
				</div>
				<div style="overflow:auto;white-space:nowrap">
					<table class="table table-bordered table-striped" style="border:0;text-align:center">
						<thead>
							<tr>
								<th>#</th>
								<th style="text-align:left">TGL PLAN</th>
								<th>SHIFT</th>
								<th>MESIN</th>
								<th>GOOD</th>
								<th>BAD</th>
								<th>TOTAL</th>
								<th>DOWNTIME(m)</th>
								<th>START</th>
								<th>END</th>
							</tr>
						</thead>';
						$i = 0;
						$good_cor_p = 0;
						$bad_cor_p = 0;
						$total_cor_p = 0;
						foreach($result->result() as $r){
							$i++;

							if($r->jmlDt == 0){
								$txtDowtime = '-';
							}else{
								$txtDowtime = $r->jmlDt.' ( '.number_format($r->jmlDtDurasi).' )';
							}
							$html .= '<tr>
								<td>'.$i.'</td>
								<td style="text-align:left">
									<a href="javascript:void(0)" onclick="showCartitem('."'".$r->id_plan."'".','."'riwayat'".')">
										'.strtoupper($this->m_fungsi->tanggal_format_indonesia($r->tgl_plan)).'	
									<a>
								</td>
								<td>'.$r->shift_plan.'</td>
								<td>'.$r->machine_plan.'</td>
								<td style="text-align:right">'.number_format($r->good_cor_p).'</td>
								<td style="text-align:right">'.number_format($r->bad_cor_p).'</td>
								<td style="text-align:right">'.number_format($r->total_cor_p).'</td>
								<td style="text-align:right">'.$txtDowtime.'</td>
								<td>'.date("h:i", strtotime($r->start_time_p)).'</td>
								<td>'.date("h:i", strtotime($r->end_time_p)).'</td>
							</tr>';
							$good_cor_p += $r->good_cor_p;
							$bad_cor_p += $r->bad_cor_p;
							$total_cor_p += $r->total_cor_p;
						}
						if($result->num_rows() > 1){
							$html .='<tr>
								<td style="border:0;background:#fff;font-weight:bold;text-align:right" colspan="4">TOTAL PRODUKSI</td>
								<td style="border:0;background:#fff;font-weight:bold;text-align:right">'.number_format($good_cor_p).'</td>
								<td style="border:0;background:#fff;font-weight:bold;text-align:right">'.number_format($bad_cor_p).'</td>
								<td style="border:0;background:#fff;font-weight:bold;text-align:right">'.number_format($total_cor_p).'</td>
							</tr>';
						}
						$jmlGood = $good_cor_p - $result->row()->qty_so;
						$jmlTot = $total_cor_p - $result->row()->qty_so;
						$html .='<tr>
							<td style="border:0;background:#fff;font-weight:bold;text-align:right" colspan="4">QTY SO - ( '.number_format($result->row()->qty_so).' )</td>
							<td style="border:0;background:#fff;font-weight:bold;text-align:right">'.number_format($jmlGood).'</td>
							<td style="border:0;background:#fff;font-weight:bold;text-align:right">-</td>
							<td style="border:0;background:#fff;font-weight:bold;text-align:right">'.number_format($jmlTot).'</td>
						</tr>';
					$html .='</table>
				</div>
			</div>';
		}

		echo $html;
	}

	function loadInputList()
	{
		$urlTgl_plan = $_POST["tgl_plan"];
		$urlShift = $_POST["shift"];
		$urlMesin = $_POST["machine"];
		$id_plan = $_POST["hidplan"];
		$urlNoPlan = $_POST["urlNoPlan"];
		$opsi = $_POST["opsi"];
		$html = '';

		if($opsi != 'pilihan'){
			$tglPlan = $this->db->query("SELECT tgl_plan,p.shift_plan,p.machine_plan,
			(SELECT COUNT(lp.tgl_plan) FROM plan_cor lp
			WHERE p.tgl_plan=lp.tgl_plan AND p.shift_plan=lp.shift_plan AND p.machine_plan=lp.machine_plan GROUP BY lp.tgl_plan) AS jml_plan,
			(SELECT COUNT(lp.tgl_plan) FROM plan_cor lp
			WHERE p.tgl_plan=lp.tgl_plan AND p.shift_plan=lp.shift_plan AND p.machine_plan=lp.machine_plan AND lp.total_cor_p!='0' AND lp.status_plan='Open' GROUP BY lp.tgl_plan) AS prod_plan,
			(SELECT COUNT(lp.tgl_plan) FROM plan_cor lp
			WHERE p.tgl_plan=lp.tgl_plan AND p.shift_plan=lp.shift_plan AND p.machine_plan=lp.machine_plan AND lp.total_cor_p!='0' AND lp.status_plan='Close' GROUP BY lp.tgl_plan) AS selesai_plan,
			(SELECT COUNT(lp.tgl_plan) FROM plan_cor lp
			INNER JOIN trs_wo w ON lp.id_wo=w.id
			WHERE p.tgl_plan=lp.tgl_plan AND p.shift_plan=lp.shift_plan AND p.machine_plan=lp.machine_plan AND lp.total_cor_p!='0' AND lp.status_plan='Close' AND w.status='Close' GROUP BY lp.tgl_plan) AS wo_plan
			FROM plan_cor p
			INNER JOIN trs_wo ww ON p.id_wo=ww.id
			WHERE ww.status='Open' AND p.no_plan='$urlNoPlan'
			GROUP BY p.tgl_plan,p.shift_plan,p.machine_plan")->row();
			($tglPlan->machine_plan == 'CORR1') ? $mch = '1' : $mch = '2';
			($tglPlan->prod_plan == null) ? $prodPlan = '' : $prodPlan = '<span class="bg-success" style="vertical-align:top;font-weight:bold;padding:2px 4px;font-size:12px">'.$tglPlan->prod_plan.'</span>';
			($tglPlan->selesai_plan == null) ? $selesaiPlan = '' : $selesaiPlan = '<span class="bg-primary" style="vertical-align:top;font-weight:bold;padding:2px 4px;font-size:12px">'.$tglPlan->selesai_plan.'</span>';
			($tglPlan->wo_plan == null) ? $woPlan = '' : $woPlan = '<span class="bg-dark" style="vertical-align:top;font-weight:bold;padding:2px 4px;font-size:12px">'.$tglPlan->wo_plan.'</span>';
			$html .= '<div class="card card-primary card-outline">
			<div class="card-header">
				<h3 class="card-title" style="font-weight:bold;font-style:italic">LIST -</h3>&nbsp;
				<i>['.$urlShift.'.'.$mch.']-'.$this->m_fungsi->tglPlan($urlTgl_plan).'<span class="bg-light" style="vertical-align:top;font-weight:bold;padding:2px 4px;font-size:12px">'.$tglPlan->jml_plan.'</span>'.$prodPlan.''.$selesaiPlan.''.$woPlan.'</i>
			</div>';
		}
		$html .= '<div style="overflow:auto;white-space:nowrap">
			<table class="table table-bordered" style="border:0;text-align:center">
				<thead>
					<tr>
						<th style="position:sticky;left:0;background:#fff">#</th>
						<th>STATUS</th>
						<th style="position:sticky;left:33px;background:#fff">ITEM</th>
						<th>NO.PO</th>
						<th>CUSTOMER</th>
						<th colspan="2">TL/AL</th>
						<th colspan="2">B MF</th>
						<th colspan="2">BC</th>
						<th colspan="2">C.MF</th>
						<th colspan="2">B/C.L</th>
						<th style="padding:12px 22px">PJG</th>
						<th style="padding:12px 22px">LBR</th>
						<th colspan="3">SCORE</th>
						<th>OUT</th>
						<th>FT</th>
						<th>L. ROLL</th>
						<th>TRIM</th>
						<th>ORDER</th>
						<th>C.OFF</th>
						<th style="padding:12px 22px">RM</th>
						<th style="padding:12px 22px">KG</th>
						<th>TGL KIRIM</th>
						<th style="padding:12px 24px">NEXT</th>
						<th>AKSI</th>
					</tr>
				</thead>';

		$data = $this->db->query("SELECT p.*,i.nm_produk,w.kode_po,l.nm_pelanggan,i.kategori,i.flute,w.flap1,w.creasing2,w.flap2,w.status AS statusWo FROM plan_cor p
		INNER JOIN m_produk i ON p.id_produk=i.id_produk
		INNER JOIN trs_wo w ON p.id_wo=w.id
		INNER JOIN trs_so_detail s ON p.id_so_detail=s.id
		INNER JOIN m_pelanggan l ON p.id_pelanggan=l.id_pelanggan
		WHERE p.tgl_plan='$urlTgl_plan' AND p.shift_plan='$urlShift' AND p.machine_plan='$urlMesin'
		ORDER BY p.no_urut_plan,p.id_plan");

		foreach($data->result() as $r){
			$id = $r->id_plan;
			$exMatPlan = explode("/", $r->material_plan);
			$exKistPlan = explode("/", $r->kualitas_isi_plan);
			if($r->flute == "BF"){
				$dis2 = ''; $dis3 = 'disabled'; $dis4 = 'disabled';
				$vMatPlan1 = $exMatPlan[0];
				$vkisPlan1 = $exKistPlan[0];
				$vMatPlan2 = $exMatPlan[1];
				$vkisPlan2 = $exKistPlan[1];
				$vMatPlan3 = '';
				$vkisPlan3 = '';
				$vMatPlan4 = '';
				$vkisPlan4 = '';
				$vMatPlan5 = $exMatPlan[2];
				$vkisPlan5 = $exKistPlan[2];
			}else if($r->flute == "CF"){
				$dis2 = 'disabled'; $dis3 = 'disabled'; $dis4 = '';
				$vMatPlan1 = $exMatPlan[0];
				$vkisPlan1 = $exKistPlan[0];
				$vMatPlan2 = '';
				$vkisPlan2 = '';
				$vMatPlan3 = '';
				$vkisPlan3 = '';
				$vMatPlan4 = $exMatPlan[1];
				$vkisPlan4 = $exKistPlan[1];
				$vMatPlan5 = $exMatPlan[2];
				$vkisPlan5 = $exKistPlan[2];
			}else{
				$dis2 = ''; $dis3 = ''; $dis4 = '';
				$vMatPlan1 = $exMatPlan[0];
				$vkisPlan1 = $exKistPlan[0];
				$vMatPlan2 = $exMatPlan[1];
				$vkisPlan2 = $exKistPlan[1];
				$vMatPlan3 = $exMatPlan[2];
				$vkisPlan3 = $exKistPlan[2];
				$vMatPlan4 = $exMatPlan[3];
				$vkisPlan4 = $exKistPlan[3];
				$vMatPlan5 = $exMatPlan[4];
				$vkisPlan5 = $exKistPlan[4];
			}

			if($opsi == 'pilihan'){
				$onKeyUpEdiPlan = 'disabled';
				$ePlhS = 'disabled';
			}else{
				$onKeyUpEdiPlan = 'onkeyup="onChangeEditPlan('."'".$id."'".')"';
				$ePlhS = '';
			}

			if($id_plan == $r->id_plan){
				$bgTd = 'class="h-tlp-td"';
			}else{
				$bgTd = 'class="h-tlpf-td"';
			}

			$htmlSub ='<td '.$bgTd.' style="padding:6px">
				<select class="form-control inp-kosong" id="lp-sm1-'.$id.'" '.$ePlhS.'>
					<option value="'.$vMatPlan1.'">'.$vMatPlan1.'</option><option value="">-</option><option value="M">M</option><option value="K">K</option><option value="MC">MC</option><option value="MN">MN</option>
				</select></td>
			<td '.$bgTd.' style="padding:6px"><input type="number" id="lp-si1-'.$id.'" class="form-control inp-kosong" value="'.$vkisPlan1.'" '.$onKeyUpEdiPlan.'></td>
			<td '.$bgTd.' style="padding:6px">
				<select class="form-control inp-kosong" id="lp-sm2-'.$id.'" '.$dis2.' '.$ePlhS.'>
					<option value="'.$vMatPlan2.'">'.$vMatPlan2.'</option><option value="">-</option><option value="M">M</option><option value="K">K</option><option value="MC">MC</option><option value="MN">MN</option>
				</select></td>
			<td '.$bgTd.' style="padding:6px"><input type="number" id="lp-si2-'.$id.'" class="form-control inp-kosong" value="'.$vkisPlan2.'" '.$dis2.' '.$onKeyUpEdiPlan.'></td>
			<td '.$bgTd.' style="padding:6px">
				<select class="form-control inp-kosong" id="lp-sm3-'.$id.'" '.$dis3.' '.$ePlhS.'>
					<option value="'.$vMatPlan3.'">'.$vMatPlan3.'</option><option value="">-</option><option value="M">M</option><option value="K">K</option><option value="MC">MC</option><option value="MN">MN</option>
				</select></td>
			<td '.$bgTd.' style="padding:6px"><input type="number" id="lp-si3-'.$id.'" class="form-control inp-kosong" value="'.$vkisPlan3.'" '.$dis3.' '.$onKeyUpEdiPlan.'></td>
			<td '.$bgTd.' style="padding:6px">
				<select class="form-control inp-kosong" id="lp-sm4-'.$id.'" '.$dis4.' '.$ePlhS.'>
					<option value="'.$vMatPlan4.'">'.$vMatPlan4.'</option><option value="">-</option><option value="M">M</option><option value="K">K</option><option value="MC">MC</option><option value="MN">MN</option>
				</select></td>
			<td '.$bgTd.' style="padding:6px"><input type="number" id="lp-si4-'.$id.'" class="form-control inp-kosong" value="'.$vkisPlan4.'" '.$dis4.' '.$onKeyUpEdiPlan.'></td>
			<td '.$bgTd.' style="padding:6px">
				<select class="form-control inp-kosong" id="lp-sm5-'.$id.'" '.$ePlhS.'>
					<option value="'.$vMatPlan5.'">'.$vMatPlan5.'</option><option value="">-</option><option value="M">M</option><option value="K">K</option><option value="MC">MC</option><option value="MN">MN</option>
				</select></td>
			<td '.$bgTd.' style="padding:6px"><input type="number" id="lp-si5-'.$id.'" class="form-control inp-kosong" value="'.$vkisPlan5.'" '.$onKeyUpEdiPlan.'></td>';

			if(in_array($this->session->userdata('level'), ['Admin','PPIC','Corrugator'])){
				if($r->status_plan == 'Open' && $r->total_cor_p == 0){
					if($opsi == 'pilihan' || $this->session->userdata('level') == 'Corrugator'){
						$btnAksiHapus = '<button class="btn btn-danger btn-block" style="padding:2px 4px;border-radius:4px;cursor:default" disabled>HAPUS</button>';
						$btnAksiEdit = '-';
						$aksiNoUrut = 'disabled';
						$dis = 'disabled';
					}else{
						$btnAksiHapus = '<a href="javascript:void(0)" onclick="hapusPlan('."".$r->id_plan."".')" href="" class="bg-danger" style="padding:2px 4px;border-radius:4px;display:block">HAPUS</a>';
						$btnAksiEdit = '<a href="javascript:void(0)" style="font-weight:bold" onclick="editListPlan('."'".$r->id_plan."'".', '."'".$r->id_wo."'".','."'edit'".')">EDIT<a>';
						$aksiNoUrut = 'onchange="onChangeNourutPlan('."'".$id."'".')"';
						$dis = '';
					}
				}else if($r->status_plan == 'Open' && $r->total_cor_p != 0){
					$btnAksiHapus = '<span class="bg-success" style="padding:2px 4px;border-radius:4px;display:block">PRODUKSI</span>';
					(in_array($this->session->userdata('level'), ['Admin','PPIC'])) ? $btnAksiEdit = '<a href="javascript:void(0)" style="font-weight:bold" onclick="editListPlan('."'".$r->id_plan."'".', '."'".$r->id_wo."'".','."'kirimnext'".')">EDIT<a>' : $btnAksiEdit = '';
					$aksiNoUrut = 'disabled';
					$dis = 'disabled';
				}else if($r->status_plan == 'Close' && $r->statusWo == 'Open'){
					$btnAksiHapus = '<span class="bg-primary" style="padding:2px;border-radius:4px;display:block">PLAN</span>';
					(in_array($this->session->userdata('level'), ['Admin','PPIC'])) ? $btnAksiEdit = '<a href="javascript:void(0)" style="font-weight:bold" onclick="editListPlan('."'".$r->id_plan."'".', '."'".$r->id_wo."'".','."'kirimnext'".')">EDIT<a>' : $btnAksiEdit = '';
					$aksiNoUrut = 'disabled';
					$dis = 'disabled';
				}else if($r->status_plan == 'Close' && $r->statusWo == 'Close'){
					$btnAksiHapus = '<span class="bg-dark" style="padding:2px 4px;border-radius:4px;display:block">WO</span>';
					(in_array($this->session->userdata('level'), ['Admin','PPIC'])) ? $btnAksiEdit = '<a href="javascript:void(0)" style="font-weight:bold" onclick="editListPlan('."'".$r->id_plan."'".', '."'".$r->id_wo."'".','."'kirimnext'".')">EDIT<a>' : $btnAksiEdit = '';
					$aksiNoUrut = 'disabled';
					$dis = 'disabled';
				}else{
					$btnAksiHapus = `-`;
					$btnAksiEdit = '-';
					$aksiNoUrut = 'disabled';
					$dis = 'disabled';
				}
			}else{
				$btnAksiHapus = '-';
				$btnAksiEdit = '-';
				$aksiNoUrut = 'disabled';
				$dis = 'disabled';
			}

			if($opsi == 'pilihan'){
				$btnLink = $r->nm_produk;
			}else{
				$btnLink = '<a href="javascript:void(0)" onclick="plhNoWo('."".$r->id_plan."".')" title="'."".$r->no_wo."".'">'.$r->nm_produk.'</a>';
			}

			if($r->kategori == 'K_BOX'){
				$next = '<select class="form-control inp-kosong2" id="lp-next-'.$id.'">
					<option value="'.$r->next_plan.'">'.$r->next_plan.'</option>
					<option value="">-</option>
					<option value="FLEXO1">FLEXO1</option>
					<option value="FLEXO2">FLEXO2</option>
					<option value="FLEXO3">FLEXO3</option>
					<option value="FLEXO4">FLEXO4</option>
				</select>';
			}else{
				$next = $r->next_plan.'<input type="hidden" id="lp-next-'.$id.'" value="'.$r->next_plan.'">';
			}

			$html .= '<tr class="h-tmpl-list-plan">
				<td '.$bgTd.' style="position:sticky;left:0;padding:6px 3px">
					<input type="number" class="form-control inp-kosong2" id="lp-nourut-'.$id.'" value="'.$r->no_urut_plan.'" '.$aksiNoUrut.' tabindex="1">
				</td>
				<td '.$bgTd.' style="padding:4px 3px 3px;font-weight:normal">'.$btnAksiHapus.'</td>
				<td '.$bgTd.' style="position:sticky;left:33px;padding:6px;text-align:left">'.$btnLink.'</td>
				<td '.$bgTd.' style="padding:6px;text-align:left">'.$r->kode_po.'</td>
				<td '.$bgTd.' style="padding:6px;text-align:left">'.$r->nm_pelanggan.'</td>
				'.$htmlSub.'
				<td '.$bgTd.' style="padding:6px">
					<input type="number" class="form-control inp-kosong2" id="lp-pjgs-'.$id.'" style="font-weight:bold;color:#ff0066" value="'.$r->panjang_plan.'" '.$onKeyUpEdiPlan.' disabled>
				</td>
				<td '.$bgTd.' style="padding:6px">
					<input type="number" class="form-control inp-kosong2" id="lp-lbrs-'.$id.'" style="font-weight:bold;color:#ff0066" value="'.$r->lebar_plan.'" '.$onKeyUpEdiPlan.' disabled>
				</td>
				<td '.$bgTd.' style="padding:6px" id="lptd-scr1-'.$id.'">
					<input type="number" class="form-control inp-kosong" id="lp-scr1-'.$id.'" value="'.$r->flap1.'" '.$onKeyUpEdiPlan.' disabled>
				</td>
				<td '.$bgTd.' style="padding:6px" id="lptd-scr2-'.$id.'">
					<input type="number" class="form-control inp-kosong" id="lp-scr2-'.$id.'" value="'.$r->creasing2.'" '.$onKeyUpEdiPlan.' disabled>
				</td>
				<td '.$bgTd.' style="padding:6px" id="lptd-scr3-'.$id.'">
					<input type="number" class="form-control inp-kosong" id="lp-scr3-'.$id.'" value="'.$r->flap2.'" '.$onKeyUpEdiPlan.' disabled>
				</td>
				<td '.$bgTd.' style="padding:6px">
					<input type="number" class="form-control inp-kosong2" id="lp-out-'.$id.'" value="'.$r->out_plan.'" '.$onKeyUpEdiPlan.' '.$dis.'>
				</td>
				<td '.$bgTd.' style="padding:6px">'.$r->flute.'</td>
				<td '.$bgTd.' style="padding:6px">
					<input type="number" class="form-control inp-kosong2" id="lp-lbri-'.$id.'" style="font-weight:bold;color:#000" value="'.$r->lebar_roll_p.'" '.$onKeyUpEdiPlan.' '.$dis.'>
				</td>
				<td '.$bgTd.' style="padding:6px;text-align:right">
					<input type="number" class="form-control inp-kosong2" id="lp-trimp-'.$id.'" value="'.$r->trim_plan.'" disabled>
				</td>
				<td '.$bgTd.' style="padding:6px;text-align:right">
					<input type="hidden" class="form-control inp-kosong2" id="lp-pcs-plan-'.$id.'" value="'.$r->pcs_plan.'">
					'.number_format($r->pcs_plan).'
				</td>
				<td '.$bgTd.' style="padding:6px;text-align:right">
					<input type="number" class="form-control inp-kosong2" id="lp-coffp-'.$id.'" value="'.$r->c_off_p.'" disabled>
				</td>
				<td '.$bgTd.' style="padding:6px;text-align:right">
					<input type="number" class="form-control inp-kosong2" id="lp-rmp-'.$id.'" value="'.$r->rm_plan.'" disabled>
				</td>
				<td '.$bgTd.' style="padding:6px;text-align:right">
					<input type="number" class="form-control inp-kosong2" id="lp-tonp-'.$id.'" value="'.$r->tonase_plan.'" disabled>
				</td>
				<td '.$bgTd.' style="padding:6px">
					<input type="date" class="form-control inp-kosong2" id="lp-tglkirim-'.$id.'" value="'.$r->tgl_kirim_plan.'">
				</td>
				<td '.$bgTd.' style="padding:6px">'.$next.'</td>
				<td '.$bgTd.' style="padding:6px">
					<input type="hidden" id="hlp-flute-'.$id.'" value="'.$r->flute.'">
					<input type="hidden" id="hlp-kategori-'.$id.'" value="'.$r->kategori.'">
					<input type="hidden" id="hlp-kua-isi-p-'.$id.'" value="'.$r->kualitas_isi_plan.'">
					'.$btnAksiEdit.'
				</td>
			</tr>';
		}

		$html .= '</table>
			</div>
		</div>';
		echo $html;
	}
	
	function btnGantiTglPlan()
	{
		$result = $this->m_plan->btnGantiTglPlan();
		echo json_encode($result);
	}

	function onChangeNourutPlan()
	{
		$result = $this->m_plan->onChangeNourutPlan();
		echo json_encode($result);
	}

	function editListPlan()
	{
		$result = $this->m_plan->editListPlan();
		echo json_encode($result);
	}

	function plhDowntime()
	{
		$id_plan = $_POST["id_plan"];
		$cek = $this->db->query("SELECT*FROM plan_cor WHERE id_plan='$id_plan' AND status_plan='Close'");

		echo json_encode(array(
			'data' => $cek->num_rows()
		));
	}

	function downtime()
	{
		$html = '';
		$downtime = $_POST["downtime"];
		$id_plan = $_POST["id_plan"];
		if($downtime == 'OP'){
			$where = "WHERE kode_h='C.01' AND kode_d LIKE 'OP%' ORDER BY kode_d";
		}else if($downtime == 'MT'){
			$where = "WHERE kode_h='C.02' AND kode_d LIKE 'MT%'";
		}else if($downtime == 'M'){
			$where = "WHERE kode_h='C.03' AND kode_d LIKE 'M%'";
		}else if($downtime == 'N'){
			$where = "WHERE kode_h='C.04' AND kode_d LIKE 'N%'";
		}

		if($downtime == ""){
			$html .= '';
		}else{
			$cekPlan = $this->db->query("SELECT*FROM plan_cor WHERE id_plan='$id_plan' AND status_plan='Close'");
			if($cekPlan->num_rows() == 1){
				$html .='<div class="card-body row" style="padding:0 20px 5px;font-weight:bold">
					<div class="col-md-2"></div>
					<div class="col-md-10" style="color:#f00;font-style:italic">PLAN SUDAH DICLOSE!</div>
				</div>';
			}else{
				$html .='<div class="card-body row" style="padding:0 20px 5px;font-weight:bold">
					<div class="col-md-2"></div>
					<div class="col-md-10" style="color:#f00;font-style:italic;font-size:12px">* KODE | KETERANGAN</div>
				</div>
				<div class="card-body row" style="padding:0 20px 5px;font-weight:bold">
					<div class="col-md-2"></div>
					<div class="col-md-10">
						<select class="form-control select2" id="dt-plh-downtime">
							<option value="">PILIH</option>';
							$data = $this->db->query("SELECT*FROM m_downtime $where");
							foreach($data->result() as $r){
								$html .='<option value="'.$r->id_downtime.'">'.$r->kode_d.' | '.$r->keterangan.'</option>';
							}
						$html .= '</select>
					</div>
				</div>
				<div class="card-body row" style="padding:0 20px 5px;font-weight:bold ">
					<div class="col-md-2 p-0">DURASI</div>
					<div class="col-md-2">
						<input type="number" id="dt-durasi" class="form-control" onkeyup="onKeyDTDurasi()">
					</div>
					<div class="col-md-8" style="font-style:italic;font-size:12px">MENIT</div>
				</div>
				<div class="card-body row" style="padding:0 20px 5px;font-weight:bold ">
					<div class="col-md-2 p-0">KETERANGAN</div>
					<div class="col-md-10">
						<textarea class="form-control" id="dt-keterangan" style="resize:none" rows="2"></textarea>
					</div>
				</div>
				<div class="card-body row" style="padding:0 20px 5px;font-weight:bold ">
					<div class="col-md-2"></div>
					<div class="col-md-10">
						<button class="btn btn-sm btn-success" style="font-weight:bold" onclick="simpanDowntime()"><i class="fas fa-plus"></i> ADD</button>
					</div>
				</div>';
			}
		}

		echo $html;
	}

	function simpanDowntime()
	{
		$result = $this->m_plan->simpanDowntime();
		echo json_encode($result);
	}

	function loadDataDowntime()
	{
		$id_plan = $_POST["id_plan"];
		$html = '';

		$html .= '<div class="card-body row" style="padding:0 20px 5px;font-weight:bold">
			<div class="col-md-12" style="padding:0">
				<table class="table table-bordered" style="margin:20px 0 0;border:0">
					<thead>
						<tr>
							<th style="text-align:center">#</th>
							<th>KODE</th>
							<th>-</th>
							<th style="padding:12px 54px 12px 12px">KETERANGAN</th>
							<th style="text-align:center">(M)</th>
						</tr>
					</thead>';
					$data = $this->db->query("SELECT*FROM plan_cor_dt p
					INNER JOIN m_downtime d ON p.id_m_downtime=d.id_downtime
					WHERE p.id_plan_cor='$id_plan'");

					if($data->num_rows() == 0){
						$html .= '<tr>
							<td style="padding:6px;text-align:center" colspan="5">DOWNTIME KOSONG</td>
						</tr>';
					}else{
						$i = 0;
						$sumMntDt = 0;
						foreach($data->result() as $r){
							$i++;
							$id = $r->id_plan_dt;

							$cekPlan = $this->db->query("SELECT*FROM plan_cor WHERE id_plan='$id_plan' AND status_plan='Close'");
							if($cekPlan->num_rows() == 1){
								$onClickDt = 'style="color:#666;cursor:default" disabled';
								$onChangeDt = 'disabled';
							}else{
								$onClickDt = 'style="color:#f00" onclick="hapusDowntimePlan('."'".$id."'".')"';
								$onChangeDt = 'onchange="changeEditDt('."'".$id."'".')"';
							}
							$html .= '<tr class="h-tmpl-list-plan">
								<td style="padding:6px;text-align:center;vertical-align:middle">'.$i.'</td>
								<td style="padding:6px;text-align:center;vertical-align:middle">'.$r->kode_d.'</td>
								<td style="padding:6px;vertical-align:middle">'.$r->keterangan.'&nbsp
									<a href="javascript:void(0)" '.$onClickDt.'><i class="fas fa-times-circle"></i><a>
								</td>
								<td style="padding:3px">
									<textarea type="text" id="dt-ket-plan-'.$id.'" class="form-control inp-kosong2" style="text-align:left;resize:none;font-size:13px" '.$onChangeDt.'>'.$r->ket_plan_dt.'</textarea>
								</td>
								<td style="padding:6px;text-align:center;vertical-align:middle">
									<input type="number" id="dt-durasi-plan-'.$id.'" class="form-control inp-kosong" value="'.$r->durasi_mnt_dt.'" '.$onChangeDt.'>
								</td>
							</tr>';
							$sumMntDt += $r->durasi_mnt_dt;
						}

						if($data->num_rows() != 1){
							$html .='<tr>
								<td style="border:0;padding:6px;background:#fff;font-weight:bold;text-align:right" colspan="4">TOTAL DOWNTIME(M)</td>
								<td style="border:0;padding:6px;background:#fff;font-weight:bold;text-align:center">'.number_format($sumMntDt).'</td>
							</tr>';
						}
					}
				$html .= '</table>
			</div>
		</div>';

		echo $html;
	}

	function hapusDowntimePlan()
	{
		$result = $this->m_plan->hapusDowntimePlan();
		echo json_encode($result);
	}

	function changeEditDt()
	{
		$result = $this->m_plan->changeEditDt();
		echo json_encode($result);
	}

	function loadPilihTanggal()
	{
		$urlTglPlan = $_POST["urlTgl_plan"];
		$urlShift = $_POST["urlShift"];
		$urlMesin = $_POST["urlMesin"];
		
		$tglPlan = $this->db->query("SELECT tgl_plan,p.shift_plan,p.machine_plan,
		(SELECT COUNT(lp.tgl_plan) FROM plan_cor lp
		WHERE p.tgl_plan=lp.tgl_plan AND p.shift_plan=lp.shift_plan AND p.machine_plan=lp.machine_plan GROUP BY lp.tgl_plan) AS jml_plan,
		(SELECT COUNT(lp.tgl_plan) FROM plan_cor lp
		WHERE p.tgl_plan=lp.tgl_plan AND p.shift_plan=lp.shift_plan AND p.machine_plan=lp.machine_plan AND lp.total_cor_p!='0' AND lp.status_plan='Open' GROUP BY lp.tgl_plan) AS prod_plan,
		(SELECT COUNT(lp.tgl_plan) FROM plan_cor lp
		WHERE p.tgl_plan=lp.tgl_plan AND p.shift_plan=lp.shift_plan AND p.machine_plan=lp.machine_plan AND lp.total_cor_p!='0' AND lp.status_plan='Close' GROUP BY lp.tgl_plan) AS selesai_plan,
		(SELECT COUNT(lp.tgl_plan) FROM plan_cor lp
		INNER JOIN trs_wo w ON lp.id_wo=w.id
		WHERE p.tgl_plan=lp.tgl_plan AND p.shift_plan=lp.shift_plan AND p.machine_plan=lp.machine_plan AND lp.total_cor_p!='0' AND lp.status_plan='Close' AND w.status='Close' GROUP BY lp.tgl_plan) AS wo_plan
		FROM plan_cor p
		INNER JOIN trs_wo ww ON p.id_wo=ww.id
		WHERE ww.status='Open'
		GROUP BY p.tgl_plan,p.shift_plan,p.machine_plan");

		$html ='';
		if($tglPlan->num_rows() == 1){
			echo true;
		}else{
			$html .='<div class="card-body row" style="padding:5px">
				<div class="col-md-12">
					[SHIFT.MESIN]-TANGGAL<span class="bg-light" style="vertical-align:top;font-weight:bold;padding:2px 4px;font-size:12px">JUMLAH</span><span class="bg-success" style="vertical-align:top;font-weight:bold;padding:2px 4px;font-size:12px">PRODUKSI</span><span class="bg-primary" style="vertical-align:top;font-weight:bold;padding:2px 4px;font-size:12px">SELESAI PLAN</span><span class="bg-dark" style="vertical-align:top;font-weight:bold;padding:2px 4px;font-size:12px">CLOSE WO</span>
				</div>
			</div>';
			$html .='<div class="card-header p-0 pt-1 pl-1 bg-gradient-secondary">
				<ul class="nav nav-tabs" style="border-bottom:0" role="tablist">';
					$i = 0;
					foreach($tglPlan->result() as $r){
						$i++;
						if($r->jml_plan == $r->wo_plan){
							$html .='';
						}else if($urlTglPlan == $r->tgl_plan && $urlShift == $r->shift_plan && $urlMesin == $r->machine_plan){
							$html .='';
						}else{
							$strTgl = str_replace('-', '', $r->tgl_plan);
							($r->machine_plan == 'CORR1') ? $mch = '1' : $mch = '2';
							($r->prod_plan == null) ? $prodPlan = '' : $prodPlan = '<span class="bg-success" style="vertical-align:top;font-weight:bold;padding:2px 4px;font-size:12px">'.$r->prod_plan.'</span>';
							($r->selesai_plan == null) ? $selesaiPlan = '' : $selesaiPlan = '<span class="bg-primary" style="vertical-align:top;font-weight:bold;padding:2px 4px;font-size:12px">'.$r->selesai_plan.'</span>';
							($r->wo_plan == null) ? $woPlan = '' : $woPlan = '<span class="bg-dark" style="vertical-align:top;font-weight:bold;padding:2px 4px;font-size:12px">'.$r->wo_plan.'</span>';

							$html .='<li class="nav-item">
								<a class="nav-link" style="padding:8px" id="plh-tgl-plan-'.$strTgl.'" data-toggle="pill" onclick="loadInputList('."'".$r->tgl_plan."'".','."'".$r->shift_plan."'".','."'".$r->machine_plan."'".','."'".$i."'".')" role="tab" aria-controls="aria-cc-'.$strTgl.'" aria-selected="false">
									<span class="all-hal ke-halaman-'.$i.'"></span>['.$r->shift_plan.'.'.$mch.']-'.$this->m_fungsi->tglPlan($r->tgl_plan).'
									<span class="bg-light" style="vertical-align:top;font-weight:bold;padding:2px 4px;font-size:12px">'.$r->jml_plan.'</span>'.$prodPlan.''.$selesaiPlan.''.$woPlan.'
								</a>
							</li>';
						}
					}
				$html .='</ul>
			</div>';
			echo $html;
		}
	}

	function clickPlhTgl()
	{
		$tgl_plan = $_POST["tgl_plan"];
		$html = '';
		$html .= '<div class="card-body">
			'.$tgl_plan.'
		</div>';
		echo $html;
	}

	//

	function Flexo()
	{
		$this->load->view('header');

		$jenis = $this->uri->segment(3);
		if($jenis == 'Add'){
			if(in_array($this->session->userdata('level'), ['Admin','PPIC'])){
				$this->load->view('Plan/Flexo/v_flexo_add');
			}else{
				$this->load->view('Plan/Flexo/v_flexo');
			}
		}else if($jenis == 'List'){
			if(in_array($this->session->userdata('level'), ['Admin','PPIC','Flexo'])){
				$data = array(
					"tgl_plan" => $this->uri->segment(4),
					"shift" => $this->uri->segment(5),
					"mesin" => $this->uri->segment(6),
				);
				$this->load->view('Plan/Flexo/v_flexo_plan', $data);
			}else{
				$this->load->view('Plan/Flexo/v_flexo');
			}
		}else{
			$this->load->view('Plan/Flexo/v_flexo');
		}

		$this->load->view('footer');
	}

	function loadPlanCor()
	{
		$result = $this->m_plan->loadPlanCor();
		echo json_encode(array(
			'plan_cor' => $result
		));
	}

	//

	function Finishing()
	{
		$this->load->view('header');
		$this->load->view('Plan/Finishing/v_finishing');
		$this->load->view('footer');
	}

	//

	function Cetak_plan2()
	{
		$no_plan             = $_GET['no_plan'];
		
		$header    = $this->db->query("SELECT * from plan_cor where no_plan= '$no_plan' order by id_plan LIMIT 1");

		if ($header->num_rows() > 0) {

			$head = $header->row();
			
			$html = '<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:14px;font-family: ;">
                            
					<tr style="font-weight: bold;">
						<td colspan="15" align="center">
						<b> ( ' . $this->m_fungsi->tanggal_format_indonesia($head->tgl_plan) . ' - ' . $head->no_plan . ' )</b>
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
                            <td align="center" style="color:red;'.$bold.'">'. number_format($r->panjang_plan, 0, ",", ".") .'</td>
                            <td align="center" style="color:red;'.$bold.'">'. number_format($r->lebar_plan, 0, ",", ".") .'</td>

                            <td width="3%" align="center">'. number_format($r->flap1, 0, ",", ".") .'</td>
                            <td width="3%" align="center">'. number_format($r->flap1, 0, ",", ".") .'</td>
                            <td width="3%" align="center">'. number_format($r->flap1, 0, ",", ".") .'</td>

                            <td align="center">'. $r->out_plan .'</td>
                            <td align="center">'. $r->flute .' </td>
                            <td align="center">'. number_format($r->lebar_roll_p, 0, ",", ".") .'</td>
                            <td align="center">'. number_format($r->trim_plan, 0, ",", ".") .'</td>
                            <td align="center" style="color:red;'.$bold.'">'. number_format($r->pcs_plan, 0, ",", ".") .'</td>
                            <td align="center">'. number_format($r->c_off_p, 0, ",", ".") .'</td>
                            <td align="center">'. number_format($r->rm_plan, 0, ",", ".") .'</td>
                            <td align="center">'. number_format($r->tonase_plan, 0, ",", ".") .'</td>
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
		
		$this->m_fungsi->template_kop('CORRUGATOR PLAN','P-'.$this->m_fungsi->tanggal_ind($r->tgl_plan).'-'.$no_plan,$html,'L','1');
		// $this->m_fungsi->mPDFP($html);
	}

}
