<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . '3rdparty/mpdf/mpdf.php';

class Transaksi extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('status') != "login") {
			redirect(base_url("Login"));
		}
		$this->load->model('m_master');
		$this->load->model('m_transaksi');
	}

	function dev_sys()
	{
		$data = [
			'judul' => "DELIVERY SYSTEM",
		];
		$this->load->view('header',$data);
		$this->load->view('Transaksi/v_dev_sys');
		$this->load->view('footer');
	}

	public function PO()
	{
		$tahun = date('Y');
		$data = array(
			'judul' => "Purchase Order",
			'produk' => $this->db->query("SELECT * FROM m_produk order by id_produk")->result(),
			'sales' => $this->db->query("SELECT * FROM m_sales order by id_sales")->result(),
			'hub' => $this->db->query("SELECT a.*,4800000000-IFNULL((select sum(c.qty*price_inc)jum from trs_po b JOIN trs_po_detail c ON b.no_po=c.no_po where b.id_hub=a.id_hub and YEAR(b.tgl_po) in ('$tahun')
			group by b.id_hub ,YEAR(b.tgl_po)),0) sisa_hub FROM m_hub a
			order by id_hub")->result(),
			'pelanggan' => $this->db->query("SELECT * FROM m_pelanggan a 
            left join m_kab b on a.kab=b.kab_id 
            Left Join m_sales c on a.id_sales=c.id_sales
            order by id_pelanggan")->result(),
			'level' => $this->session->userdata('level'). "aa",
		);

		$this->load->view('header', $data);
		$this->load->view('Transaksi/v_po', $data);
		$this->load->view('footer');
	}

	function etaPO()
	{
		$data = [
			'judul' => "ETA PO",
		];
		$this->load->view('header',$data);
		$this->load->view('Transaksi/v_eta_po');
		$this->load->view('footer');
	}

	function rekap_sales()
	{
		$data = [
			'judul' => "Rekap Sales",
		];
		$this->load->view('header',$data);
		$this->load->view('Transaksi/v_rekap_sales');
		$this->load->view('footer');
	}

	//

	function PO_Roll_Paper()
	{
		$data = [
			'judul' => "PO Roll Paper",
			'data' => '',
			'msg' => '',
		];
		$this->load->view('header', $data);
		$this->load->view('Transaksi/v_po_roll_paper');
		$this->load->view('footer');
	}

	function UploadFilePORoll()
	{
		$result = $this->m_transaksi->UploadFilePORoll();
		// echo json_encode($result);
		if($result['data'] == 1) {
			redirect(base_url("Transaksi/PO_Roll_Paper"));
		}else{
			$data = [
				'judul' => "PO Roll Paper",
				'data' => $result['data'],
				'msg' => $result['msg'],
			];
			$this->load->view('header', $data);
			$this->load->view('Transaksi/v_po_roll_paper');
			$this->load->view('footer');
		}
	}

	function editPORoll()
	{
		$id_hdr = $_POST['id_hdr'];
		$opsi = $_POST['opsi'];
		// HEADER
		$header = $this->db->query("SELECT*FROM trs_po_roll_header WHERE id_hdr='$id_hdr'")->row();

		// DETAIL
		$htmlDtl = '';
		$detail = $this->db->query("SELECT*FROM trs_po_roll_detail WHERE id_hdr='$header->id_hdr' AND no_po='$header->no_po'");
		$htmlDtl .= '<div style="display:flex">';
			$z = 0;
			foreach($detail->result() as $r){
				$z++;
				$e = explode('.', $r->nm_file);
				$ext = end($e);
				// HAPUS GAMBAR
				if($this->session->userdata('level') == 'Admin' && $opsi == 'edit' && $detail->num_rows() > 1){
					$htmlDtl .= '<div style="margin-right:4px">
						<button class="btn btn-xs btn-danger" onclick="hapusFilePO('."'".$r->id_dtl."'".')"><i class="fas fa-trash"></i></button>
					</div>';
				}
				// KET
				if($r->ket_po != null){
					if(preg_match('/BK/', $r->ket_po)){
						$s = ';background:#fff"';
					}else if($r->ket_po == 'MH110' || $r->ket_po == 'MN110'){
						$s = ';background:#ccf"';
					}else if($r->ket_po == 'MH120' || $r->ket_po == 'MH125' || $r->ket_po == 'MN120' || $r->ket_po == 'MN125'){
						$s = ';background:#ffc"';
					}else if($r->ket_po == 'MH150' || $r->ket_po == 'MH200' || $r->ket_po == 'MN150' || $r->ket_po == 'MN200'){
						$s = ';background:#fcc"';
					}else if($r->ket_po == 'WP65' || $r->ket_po == 'WP68' || $r->ket_po == 'WP70'){
						$s = ';background:#cfc"';
					}else{
						$s = ';background:#ccc"';
					}
					$htmlDtl .= '<div>
						<span style="margin:0;padding:3px 4px;font-size:12px;font-weight:bold'.$s.'">'.$r->ket_po.'</span>
					</div>';
				}
				$preview = 'p'.$z;
				$htmlDtl .= '<div style="margin-right:8px">
					<img id="'.$preview.'" src="'.base_url().'assets/gambar_po_roll/'.$r->nm_file.'" alt="Preview Foto 2" width="100" class="shadow-sm" onclick="imgClick('."'".$preview."'".')">
				</div>';
			}
		$htmlDtl .= '</div>';

		// ITEM
		$htmlE = '';
		// EDIT LIST DETAIL PO
		$list = $this->db->query("SELECT i.*,SUM(tonase) AS tonase, SUM(jml_roll) AS jml_roll FROM trs_po_roll_item i WHERE i.id_hdr='$header->id_hdr' AND i.no_po='$header->no_po' GROUP BY i.nm_ker,i.g_label,i.harga");
		if($this->session->userdata('level') == 'Admin' && $opsi == 'edit'){
			$htmlE .= '<div style="margin-bottom:5px;display:flex">';
				foreach($list->result() as $l2){
					$htmlE .= '<div>
						<table style="background:#e9ecef">
							<tr>
								<th style="background:#ccc;padding:6px;text-align:center;border-bottom:3px solid #666">#</th>
								<th style="background:#ccc;padding:6px;text-align:center;border-bottom:3px solid #666">'.$l2->nm_ker.'</th>
								<th style="background:#ccc;padding:6px;text-align:center;border-bottom:3px solid #666">'.$l2->g_label.'</th>
								<th style="background:#ccc;padding:6px;text-align:center;border-bottom:3px solid #666">WIDTH</th>
								<th style="background:#ccc;padding:6px;text-align:center;border-bottom:3px solid #666">BERAT</th>
								<th style="background:#ccc;padding:6px;text-align:center;border-bottom:3px solid #666">ROLL</th>
								<th style="background:#ccc;padding:6px;text-align:center;border-bottom:3px solid #666">HARGA</th>
								<th style="background:#ccc;padding:6px;text-align:center;border-bottom:3px solid #666">KET</th>
								<th style="background:#ccc;padding:6px;text-align:center;border-bottom:3px solid #666">-</th>
							</tr>';
							$listDtl = $this->db->query("SELECT*FROM trs_po_roll_item WHERE id_hdr='$header->id_hdr' AND no_po='$header->no_po' AND nm_ker='$l2->nm_ker' AND g_label='$l2->g_label' ORDER BY nm_ker,g_label,width");
							$q = 0;
							$sumTonase = 0;
							$sumRoll = 0;
							foreach($listDtl->result() as $e){
								$q++;
								$htmlE .= '<tr>
									<td style="padding:6px;text-align:center">'.$q.'</td>
									<td style="padding:6px">
										<input type="text" class="iproll" style="width:50px;text-align:center" id="e_nm_ker'.$e->id.'" value="'.$e->nm_ker.'" autocomplete="off" oninput="this.value=this.value.toUpperCase()">
									</td>
									<td style="padding:6px">
										<input type="number" class="iproll" style="width:50px;text-align:center" id="e_g_label'.$e->id.'" value="'.$e->g_label.'" autocomplete="off">
									</td>
									<td style="padding:6px">
										<input type="number" class="iproll" style="width:50px;text-align:right" id="e_width'.$e->id.'" value="'.round($e->width,2).'" autocomplete="off">
									</td>
									<td style="padding:6px">
										<input type="number" class="iproll" style="width:80px;text-align:right" id="e_tonase'.$e->id.'" value="'.$e->tonase.'" autocomplete="off">
									</td>
									<td style="padding:6px">
										<input type="number" class="iproll" style="width:50px;text-align:right" id="e_jml_roll'.$e->id.'" value="'.$e->jml_roll.'" autocomplete="off">
									</td>
									<td style="padding:6px">
										<input type="number" class="iproll" style="width:80px;text-align:right" id="e_harga'.$e->id.'" value="'.$e->harga.'" autocomplete="off">
									</td>
									<td style="padding:6px">
										<input type="text" class="iproll" style="width:100px" id="e_ket'.$e->id.'" value="'.$e->ket.'" autocomplete="off" placeholder="-" oninput="this.value=this.value.toUpperCase()">
									</td>
									<td style="padding:6px">
										<button class="btn btn-xs btn-warning" onclick="editListPORoll('."'".$e->id."'".')"><i class="fas fa-pen"></i></button>
										<button class="btn btn-xs" onclick="hapusListPORoll('."'".$e->id."'".')"><i class="fas fa-trash" style="color:#333"></i></button>
									</td>
								</tr>';
								$sumTonase += $e->tonase;
								$sumRoll += $e->jml_roll;
							}
							// TOTAL
							if($listDtl->num_rows() != 1){
								$htmlE .= '<tr>
									<td style="padding:6px;font-weight:bold;text-align:right" colspan="4">TOTAL</td>
									<td style="padding:6px;font-weight:bold;text-align:right">'.number_format($sumTonase).'</td>
									<td style="padding:6px;font-weight:bold;text-align:right">'.number_format($sumRoll).'</td>
								</tr>';
							}
						$htmlE .= '</table>
					</div>';
					// BATAS
					$htmlE .= '<div style="padding:3px"></div>';
				}
			$htmlE .= '</div>';
			// ADD NEW ITEM
			$htmlE .= '<div>
				<table style="background:#e9ecef">
					<tr>
						<th style="background:#fff;padding:6px" rowspan="2">NEW</th>
						<th style="background:#fff;padding:6px;text-align:center;border-bottom:3px solid #666">JENIS</th>
						<th style="background:#fff;padding:6px;text-align:center;border-bottom:3px solid #666">GSM</th>
						<th style="background:#fff;padding:6px;text-align:center;border-bottom:3px solid #666">WIDTH</th>
						<th style="background:#fff;padding:6px;text-align:center;border-bottom:3px solid #666">BERAT</th>
						<th style="background:#fff;padding:6px;text-align:center;border-bottom:3px solid #666">ROLL</th>
						<th style="background:#fff;padding:6px;text-align:center;border-bottom:3px solid #666">KET</th>
						<th style="background:#fff;padding:6px;text-align:center;border-bottom:3px solid #666"></th>
					</tr>';
					$htmlE .= '<tr>
						<td style="padding:6px">
							<input type="text" class="iproll" style="width:50px;text-align:center" id="n_nm_ker" autocomplete="off" placeholder="-" oninput="this.value=this.value.toUpperCase()">
						</td>
						<td style="padding:6px">
							<input type="number" class="iproll" style="width:50px;text-align:center" id="n_g_label" placeholder="0" autocomplete="off">
						</td>
						<td style="padding:6px">
							<input type="number" class="iproll" style="width:50px;text-align:right" id="n_width" placeholder="0" autocomplete="off">
						</td>
						<td style="padding:6px">
							<input type="number" class="iproll" style="width:80px;text-align:right" id="n_tonase" placeholder="0" autocomplete="off">
						</td>
						<td style="padding:6px">
							<input type="number" class="iproll" style="width:50px;text-align:right" id="n_jml_roll" placeholder="0" autocomplete="off">
						</td>
						<td style="padding:6px">
							<input type="text" class="iproll" style="width:100px" id="n_ket" autocomplete="off" placeholder="-" oninput="this.value=this.value.toUpperCase()">
						</td>
						<td style="padding:6px">
							<button class="btn btn-xs btn-success" onclick="addListPORoll()"><i class="fas fa-plus-circle"></i></button>
						</td>
					</tr>';
				$htmlE .= '</table>
			</div>';
		}
		// ITEM SIMPLE
		$htmlI = '';
		$htmlI .= '<div style="display:flex">';
			foreach($list->result() as $l){
				if(($l->nm_ker == 'MH' || $l->nm_ker == 'MN') && $l->g_label <= 110){
					$bT = 'style="background:#ccf"';
				}else if(($l->nm_ker == 'MH' || $l->nm_ker == 'MN') && ($l->g_label == 120 || $l->g_label == 125)){
					$bT = 'style="background:#ffc"';
				}else if(($l->nm_ker == 'MH' || $l->nm_ker == 'MN') && $l->g_label >= 150){
					$bT = 'style="background:#fcc"';
				}else if($l->nm_ker == 'WP' || $l->nm_ker == 'WS'){
					$bT = 'style="background:#cfc"';
				}else{
					$bT = 'style="background:#fff"';
				}
				$htmlI .= '<div>';
					$htmlI .= '<table>
						<tr '.$bT.'>
							<th style="padding:6px;border-style:solid;border-width:1px 1px 3px;border-color:#bbb #bbb #666">'.$l->nm_ker.' '.$l->g_label.'</th>
							<th style="padding:6px;border-style:solid;border-width:1px 1px 3px;border-color:#bbb #bbb #666">ROLL</th>
						</tr>';
					$item = $this->db->query("SELECT*FROM trs_po_roll_item WHERE id_hdr='$header->id_hdr' AND no_po='$header->no_po' AND nm_ker='$l->nm_ker' AND g_label='$l->g_label' ORDER BY nm_ker,g_label,width");
					$x = 0;
					$xJmlRoll = 0;
					foreach($item->result() as $i){
						$x++;
						($i->ket != '') ? $ket = ' <span style="font-size:11px;vertical-align:top;font-style:italic">( '.$i->ket.' )</span>' : $ket = '';
						$htmlI .= '<tr>
							<td style="padding:6px;background:#f2f2f2;border:1px solid #dee2e6;text-align:center">'.round($i->width,2).'</td>
							<td style="padding:6px;background:#f2f2f2;border:1px solid #dee2e6;text-align:right">'.$i->jml_roll.$ket.'</td>
						</tr>';
						if($item->num_rows() != $x){
							$htmlI .= '<tr>
								<th style="padding:1px;background:#fff;border:1px solid #dee2e6" colspan="2"></th>
							</tr>';
						}
						$xJmlRoll += $i->jml_roll;
					}
					if($item->num_rows() > 1){
						$htmlI .= '<tr>
							<td style="padding:6px;background:#fff;text-align:right;font-weight:bold	" colspan="2">'.number_format($xJmlRoll, 0, ',', '.').'</td>
						</tr>';
					}
					$htmlI .= '</table>';
				$htmlI .= '</div>';
				// BATAS
				$htmlI .= '<div style="padding:3px"></div>';
			}

			// HARGA
			$htmlI .= '<div>';
				if($list->num_rows() == 1){
					$htmlI .= 'HARGA : <b>Rp. '.number_format($list->row()->harga, 0, ',', '.').'</b>';
				}else{
					$htmlI .= 'HARGA<br>';
					$htmlI .= '<table>';
						foreach($list->result() as $h){
							$htmlI .= '<tr>
								<td>'.$h->nm_ker.' '.$h->g_label.'</td>
								<td style="padding:0 6px">:</td>
								<td style="padding:0 6px 0 0">Rp.</td>
								<td style="text-align:right"><b>'.number_format($h->harga, 0, ',', '.').'</b></td>
							</tr>';
						}
					$htmlI .= '</table>';
				}
			$htmlI .= '</div>';

			// TONASE
			$htmlI .= '<div style="padding:10px"></div>';
			$htmlI .= '<div>';
				if($list->num_rows() == 1){
					$htmlI .= 'TONASE : <b>'.number_format($list->row()->tonase, 0, ',', '.').'</b> Kg';
				}else{
					$htmlI .= 'TONASE<br>';
					$htmlI .= '<table>';
						$tTot = 0;
						foreach($list->result() as $t){
							$htmlI .= '<tr>
								<td>'.$t->nm_ker.' '.$t->g_label.'</td>
								<td style="padding:0 6px">:</td>
								<td style="text-align:right"><b>'.number_format($t->tonase, 0, ',', '.').'</b> Kg</td>
							</tr>';
							$tTot += $t->tonase;
						}
						$htmlI .= '<tr>
							<td colspan="2"></td>
							<td style="text-align:right"><b>'.number_format($tTot, 0, ',', '.').'</b> Kg</td>
						</tr>';
					$htmlI .= '</table>';
				}
			$htmlI .= '</div>';

			// JUMLAH ROLL
			$htmlI .= '<div style="padding:10px"></div>';
			if($list->num_rows() > 1){
				$htmlI .= '<div>';
					$tRoll = 0;
					foreach($list->result() as $jr){
						$tRoll += $jr->jml_roll;
					}
					$htmlI .= 'TOTAL : <b>'.number_format($tRoll, 0, ',', '.').'</b> ROLL';
				$htmlI .= '</div>';
			}
		$htmlI .= '</div>';

		echo json_encode([
			'header' => $header,
			'opsi' => $opsi,
			'ext' => $ext,
			'htmlDtl' => $htmlDtl,
			'htmlI' => $htmlI,
			'htmlE' => $htmlE,
			'oke_admin' => substr($this->m_fungsi->getHariIni(($header->edit_at == null) ? $header->creat_at : $header->edit_at),0,3).', '.$this->m_fungsi->tglIndSkt(substr(($header->edit_at == null) ? $header->creat_at : $header->edit_at, 0,10)).' ( '.substr(($header->edit_at == null) ? $header->creat_at : $header->edit_at, 10,6).' )',
			'mkt_time' => ($header->mkt_time == null) ? '' :substr($this->m_fungsi->getHariIni($header->mkt_time),0,3).', '.$this->m_fungsi->tglIndSkt(substr($header->mkt_time, 0,10)).' ( '.substr($header->mkt_time, 10,6).' )',
			'owner_time' => ($header->owner_time == null) ? '' :substr($this->m_fungsi->getHariIni($header->owner_time),0,3).', '.$this->m_fungsi->tglIndSkt(substr($header->owner_time, 0,10)).' ( '.substr($header->owner_time, 10,6).' )',
		]);
	}

	function InputPORoll()
	{
		$result = $this->m_transaksi->InputPORoll();
		echo json_encode($result);
	}

	function addNotePORoll()
	{
		$result = $this->m_transaksi->addNotePORoll();
		echo json_encode($result);
	}

	function btnVerifPORoll()
	{
		$result = $this->m_transaksi->btnVerifPORoll();
		echo json_encode($result);
	}

	function hapusPORoll()
	{
		$result = $this->m_transaksi->hapusPORoll();
		echo json_encode($result);
	}

	function hapusFilePO()
	{
		$result = $this->m_transaksi->hapusFilePO();
		echo json_encode($result);
	}

	function addListPORoll()
	{
		$result = $this->m_transaksi->addListPORoll();
		echo json_encode($result);
	}

	function editListPORoll()
	{
		$result = $this->m_transaksi->editListPORoll();
		echo json_encode($result);
	}

	function hapusListPORoll()
	{
		$result = $this->m_transaksi->hapusListPORoll();
		echo json_encode($result);
	}

	function destroyPORoll()
	{
		$this->cart->destroy();
	}

	function addListUK()
	{
		if($_POST["roll"] == "" || $_POST["jenis"] == "" || $_POST["gsm"] == "" || $_POST["ukuran"] == "" || $_POST["qty"] == "" || $_POST["harga"] == ""){
			echo json_encode(array('data' => false, 'isi' => 'HARAP LENGKAPI FORM!'));
		}else{
			$data = array(
				'id' => $_POST["id_cart"],
				'name' => 'name'.$_POST["id_cart"],
				'price' => 0,
				'qty' => 1,
				'options' => array(
					'stat' => $_POST["roll"],
					'jenis' => $_POST["jenis"],
					'gsm' => $_POST["gsm"],
					'ukuran' => $_POST["ukuran"],
					'berat' => $_POST["berat"],
					'qty' => $_POST["qty"],
					'harga' => $_POST["harga"],
					'ket' => ($_POST["ket"] == '') ? '' : $_POST["ket"],
					'id_cart' => $_POST["id_cart"],
				)
			);
			if($this->cart->total_items() != 0){
				foreach($this->cart->contents() as $r){
					if($r['options']['jenis'] == $_POST["jenis"] && $r['options']['gsm'] == $_POST["gsm"] && $r['options']['ukuran'] == $_POST["ukuran"]){
						echo json_encode(array('data' => false, 'isi' => 'ITEM SUDAH ADA!')); return;
					}
				}
				$this->cart->insert($data);
				echo json_encode(array('data' => true, 'isi' => 'BERHASIL ADD!'));
			}else{
				$this->cart->insert($data);
				echo json_encode(array('data' => true, 'isi' => 'BERHASIL ADD!'));
			}
		}

	}

	function cartListPORoll()
	{
		$html = '';
		if($this->cart->total_items() == 0){
			$html .= '';
		}
		if($this->cart->total_items() != 0){
			$html .='<div class="card-body" style="padding:6px">
				<table class="table table-bordered table-striped">
				<thead>
					<tr>
						<th style="padding:6px;text-align:center">NO.</th>
						<th style="padding:6px">JENIS</th>
						<th style="padding:6px;text-align:center">GSM</th>
						<th style="padding:6px;text-align:center">UKURAN</th>
						<th style="padding:6px;text-align:center">BERAT</th>
						<th style="padding:6px;text-align:center">QTY</th>
						<th style="padding:6px;text-align:center">HARGA</th>
						<th style="padding:6px;text-align:center">KETERANGAN</th>
						<th style="padding:6px;text-align:center">AKSI</th>
					</tr>
					<tr>
						<th style="padding:0;border:0" colspan="6"></th>
					</tr>
				</thead>
			';
		}
		$i = 0;
		$sumBerat = 0;
		$sumQty = 0;
		foreach($this->cart->contents() as $r){
			$i++;
			$html .='<tr>
				<td style="padding:6px;text-align:center">'.$i.'</td>
				<td style="padding:6px">'.$r['options']['jenis'].'</td>
				<td style="padding:6px;text-align:right">'.$r['options']['gsm'].'</td>
				<td style="padding:6px;text-align:right">'.$r['options']['ukuran'].'</td>
				<td style="padding:6px;text-align:right">'.number_format($r['options']['berat']).'</td>
				<td style="padding:6px;text-align:right">'.$r['options']['qty'].'</td>
				<td style="padding:6px;text-align:right">Rp. '.number_format($r['options']['harga']).'</td>
				<td style="padding:6px">'.$r['options']['ket'].'</td>
				<td style="padding:6px;text-align:center">
					<button class="btn btn-danger btn-xs" onclick="hapusCartPORoll('."'".$r['rowid']."'".')"><i class="fas fa-times"></i> BATAL</button>
				</td>
			</tr>';
			if($this->cart->total_items() != $i){
				$html .= '<tr>
					<th style="padding:2px" colspan="6"></th>
				</tr>';
			}
			$sumBerat += $r['options']['berat'];
			$sumQty += $r['options']['qty'];
		}
		if($this->cart->total_items() != 0){
			if($this->cart->total_items() > 1){
				$html .= '
				<tr style="font-weight:bold">
					<th style="padding:6px;border-top:3px solid #dee2e6;text-align:center" colspan="4">TOTAL</th>
					<th style="padding:6px;border-top:3px solid #dee2e6;text-align:right">'.number_format($sumBerat).'</th>
					<th style="padding:6px;border-top:3px solid #dee2e6;text-align:right">'.number_format($sumQty).'</th>
					<th style="padding:6px;border-top:3px solid #dee2e6" colspan="3"></th>
				</tr>';
			}
			$html .= '</table></div>';
		}
		echo $html;
	}

	function hapusCartPORoll()
	{
		$data = array(
			'rowid' => $_POST['rowid'],
			'qty' => 0,
		);
		$this->cart->update($data);
	}

	// LAPORAN PO

	function plhStatus()
	{
		$db = $this->load->database('database_simroll', TRUE);
		$id_pt = $_POST["id_pt"];
		$status = $_POST["lap_status"];
		($status == 'ALL') ? $stat = '' : $stat = "AND po.status='open'";

		$query = $db->query("SELECT pt.id,po.no_po FROM po_master po
		INNER JOIN m_perusahaan pt ON pt.id=po.id_perusahaan
		WHERE po.tgl BETWEEN '2024-12-01' AND '9999-01-01' AND pt.id='$id_pt' $stat
		GROUP BY po.no_po");
		$noPO = '';
		if($query->num_rows() == 0){
			$noPO .= '<option value="">PILIH</option>';
		}else{
			$noPO .= '<option value="">SEMUA</option>';
			foreach($query->result() as $r){
				$noPO .= '<option value="'.$r->no_po.'" optIdPt="'.$r->id.'">'.$r->no_po.'</option>';
			}
		}

		echo json_encode([
			'noPO' => $noPO,
		]);
	}

	function cariLaporanPORoll()
	{
		$db = $this->load->database('database_simroll', TRUE);
		$id_pt = $_POST["id_pt"];
		$stts = $_POST["status"];
		$no_po = $_POST["no_po"];
		$groupBy = $_POST["group"];
		$orderBy = $_POST["order"];
		$opsi = $_POST["opsi"];
		$jenis = $_POST["jenis"];
		$gsm = $_POST["gsm"];
		$ukuran = $_POST["ukuran"];
		$html = '';

		if($id_pt != ''){
			$data = true;
			if($groupBy == ''){
				$kHead = '<th style="padding:6px;background:#f2f2f2;border:1px solid #888;border-width:1px 1px 3px">TGL</th>
					<th style="padding:6px;background:#f2f2f2;border:1px solid #888;border-width:1px 1px 3px">NO PO</th>';
				$kHead2 = '';
			}else{
				$kHead = '';
				$kHead2 = '<th style="padding:6px;background:#f2f2f2;border:1px solid #888;border-width:1px 1px 3px">STOK</th>';
			}
			$html .= '<table style="color:#000">
				<tr>
					'.$kHead.'
					<th style="padding:6px;background:#f2f2f2;border:1px solid #888;border-width:1px 1px 3px">JENIS</th>
					<th style="padding:6px;background:#f2f2f2;border:1px solid #888;border-width:1px 1px 3px">GSM</th>
					<th style="padding:6px;background:#f2f2f2;border:1px solid #888;border-width:1px 1px 3px">WIDTH</th>
					<th style="padding:6px;background:#f2f2f2;border:1px solid #888;border-width:1px 1px 3px">ROLL PO</th>
					<th style="padding:6px;background:#f2f2f2;border:1px solid #888;border-width:1px 1px 3px">KIRIM ROLL</th>
					<th style="padding:6px;background:#f2f2f2;border:1px solid #888;border-width:1px 1px 3px">-/+ ROLL</th>
					<th style="padding:6px;background:#f2f2f2;border:1px solid #888;border-width:1px 1px 3px">TONASE PO</th>
					<th style="padding:6px;background:#f2f2f2;border:1px solid #888;border-width:1px 1px 3px">KIRIM TONASE</th>
					<th style="padding:6px;background:#f2f2f2;border:1px solid #888;border-width:1px 1px 3px">-/+ TON</th>
					'.$kHead2.'
				</tr>';

				// STATUS, NO. PO, ORDER BY
				($id_pt == 'ALL') ? $pt1 = "" : $pt1 = "AND pt.id='$id_pt'";
				($id_pt == 'ALL') ? $pt2 = "" : $pt2 = "AND p.id_perusahaan='$id_pt'";
				($stts == '') ? $stas = "AND po.status='open'" : $stas = "";
				($no_po == '') ? $noPO = "" : $noPO = "AND po.no_po='$no_po'";
				($jenis == '') ? $wJenis = "" : $wJenis = "AND po.nm_ker='$jenis'";
				($gsm == '') ? $wGsm = "" : $wGsm = "AND po.g_label LIKE '%$gsm%'";
				($ukuran == '') ? $wUkuran = "" : $wUkuran = "AND po.width='$ukuran'";
				if($groupBy == ''){
					$iGy = ", po.jml_roll AS jml_roll_po, po.tonase, (SELECT COUNT(t.roll) FROM m_timbangan t
					INNER JOIN pl p ON t.id_pl=p.id AND p.no_po=po.no_po AND t.nm_ker=po.nm_ker
					AND t.g_label=po.g_label AND t.width=po.width AND p.id_perusahaan=po.id_perusahaan) AS kiriman_roll,
					(SELECT SUM(t.weight - t.seset) FROM m_timbangan t
					INNER JOIN pl p ON t.id_pl=p.id AND p.no_po=po.no_po AND t.nm_ker=po.nm_ker AND t.g_label=po.g_label AND t.width=po.width AND p.id_perusahaan=po.id_perusahaan) AS kirim_tonase,";
					$oGy = "GROUP BY po.nm_ker,po.g_label,po.width,po.tgl,po.no_po";
					($orderBy == 'TNP') ? $oBy = "ORDER BY po.tgl,po.no_po,po.nm_ker,po.g_label,po.width" : $oBy = "";
					$cls = '8';
					$tdKos = '';
				}else{
					$iGy = ", SUM(po.jml_roll) AS jml_roll_po, SUM(po.tonase) AS tonase,";
					$oGy = "GROUP BY po.nm_ker,po.g_label,po.width";
					if($id_pt == 'ALL'){
						$oBy = "ORDER BY pt.nm_perusahaan,po.tgl,po.no_po,po.nm_ker,po.g_label,po.width";
					}else{
						$oBy = "";
					}
					$cls = '6';
					$tdKos = '<td style="padding:6px;background:#f2f2f2;border:1px solid #888"></td>';
				}

				$list = $db->query("SELECT po.tgl,po.no_po,po.nm_ker,po.g_label,po.width,po.id_perusahaan $iGy pt.nm_perusahaan,po.status
				FROM po_master po
				INNER JOIN m_perusahaan pt ON pt.id=po.id_perusahaan
				WHERE po.tgl BETWEEN '2024-12-01' AND '9999-01-01' $pt1 $stas $noPO $wJenis $wGsm $wUkuran
				$oGy $oBy");
				$sumTonase = 0; $sumKirimTon = 0; $poTonase = 0; $poKirimTon = 0; $i = 0;
				foreach($list->result() as $r){
					if($groupBy == ''){
						// KURANG ROLL
						$minRoll = $r->kiriman_roll - $r->jml_roll_po;
						($minRoll == 0 || $minRoll > 0 || $r->status == 'close') ? $bgR = ' style="background:#ccc"' : $bgR = '';
						// KURANG TONASE
						$minTonase = $r->kirim_tonase - $r->tonase;
						// OPEN CLOSE
						($r->status == 'close') ? $dO = ';color:#f00' : $dO = '';
						($id_pt == 'ALL') ? $nM = ' <span style="background:#ddd;vertical-align:top;font-weight:bold;padding:2px 4px;font-size:12px">'.$r->nm_perusahaan.'</span>' : $nM = "";

						if($opsi == '' || ($opsi != '' && $minRoll != 0)){
							$i++;
							$html .= '<tr'.$bgR.'>
								<td style="padding:6px;border:1px solid #888">'.$r->tgl.'</td>
								<td style="padding:6px;border:1px solid #888">'.$r->no_po.$nM.'</td>
								<td style="padding:6px;border:1px solid #888;text-align:center">'.$r->nm_ker.'</td>
								<td style="padding:6px;border:1px solid #888;text-align:center">'.$r->g_label.'</td>
								<td style="padding:6px;border:1px solid #888;text-align:center">
									<input type="hidden" id="h_id_perusahaan'.$i.'" value="'.$r->id_perusahaan.'">
									<input type="hidden" id="h_no_po'.$i.'" value="'.$r->no_po.'">
									<input type="hidden" id="h_nm_ker'.$i.'" value="'.$r->nm_ker.'">
									<input type="hidden" id="h_g_label'.$i.'" value="'.$r->g_label.'">
									<input type="hidden" id="h_width'.$i.'" value="'.$r->width.'">
									<input type="hidden" id="h_jml_roll_po'.$i.'" value="'.$r->jml_roll_po.'">
									<a href="javascript:void(0)" onclick="btnDtlPO('."'".$i."'".')">'.round($r->width,2).'</a>
								</td>
								<td style="padding:6px;border:1px solid #888;text-align:right">'.number_format($r->jml_roll_po, 0, ',', '.').'</td>
								<td style="padding:6px;border:1px solid #888;text-align:right">'.number_format($r->kiriman_roll, 0, ',', '.').'</td>
								<td style="padding:6px;border:1px solid #888;text-align:right;font-weight:bold'.$dO.'">'.number_format($minRoll, 0, ',', '.').'</td>
								<td style="padding:6px;border:1px solid #888;text-align:right">'.number_format($r->tonase, 0, ',', '.').'</td>
								<td style="padding:6px;border:1px solid #888;text-align:right">'.number_format($r->kirim_tonase, 0, ',', '.').'</td>
								<td style="padding:6px;border:1px solid #888;text-align:right">'.number_format($minTonase, 0, ',', '.').'</td>
							</tr>';

							// SUM TONASE
							$sumTonase += ($minRoll < 0) ? $r->tonase : 0;
							$sumKirimTon += ($minRoll < 0) ? $r->kirim_tonase : 0;
							$poTonase += $r->tonase;
							$poKirimTon += $r->kirim_tonase;
						}
					}else{
						$kir = $db->query("SELECT po.nm_ker, po.g_label, po.width, COUNT(t.roll) AS kiriman_roll, SUM(t.weight - t.seset) AS kirim_tonase FROM po_master po
						INNER JOIN m_timbangan t ON t.nm_ker=po.nm_ker AND t.g_label=po.g_label AND t.width=po.width
						INNER JOIN pl p ON t.id_pl=p.id AND p.no_po=po.no_po AND t.nm_ker=p.nm_ker AND t.g_label=p.g_label AND t.width=po.width AND p.id_perusahaan=po.id_perusahaan
						WHERE po.tgl BETWEEN '2024-12-01' AND '9999-01-01' AND po.nm_ker='$r->nm_ker' AND po.g_label='$r->g_label' AND po.width='$r->width' $pt2 $stas $noPO
						GROUP BY po.nm_ker,po.g_label,po.width");
						if($kir->num_rows() != 0){
							$kiriman_roll = $kir->row()->kiriman_roll;
							$kirim_tonase = $kir->row()->kirim_tonase;
						}else{
							$kiriman_roll = 0;
							$kirim_tonase = 0;
						}
						// KURANG ROLL
						$minRoll = $kiriman_roll - $r->jml_roll_po;
						// KURANG TONASE
						$minTonase = $kirim_tonase - $r->tonase;

						// STOK
						($r->g_label == 120 || $r->g_label == 125) ? $gsm = "AND (g_label='120' OR g_label='125')" : $gsm = "AND g_label='$r->g_label'";
						$stok = $db->query("SELECT COUNT(roll) AS roll FROM m_timbangan t
						WHERE tgl BETWEEN '2020-04-01' AND '9999-01-01' AND nm_ker='$r->nm_ker' $gsm AND width='$r->width' AND id_rk IS NULL AND t.status='0' AND id_pl='0'");
						($stok->num_rows() != 0) ? $ss = $stok->row()->roll : $ss = 0;
						(($minRoll == 0 || $minRoll > 0) || $ss == 0) ? $bgR = ' style="background:#ccc"' : $bgR = '';

						if($opsi == '' || ($opsi != '' && $minRoll != 0)){
							$html .= '<tr'.$bgR.'>
								<td style="padding:6px;border:1px solid #888;text-align:center">'.$r->nm_ker.'</td>
								<td style="padding:6px;border:1px solid #888;text-align:center">'.$r->g_label.'</td>
								<td style="padding:6px;border:1px solid #888;text-align:center">'.round($r->width,2).'</td>
								<td style="padding:6px;border:1px solid #888;text-align:right">'.number_format($r->jml_roll_po, 0, ',', '.').'</td>
								<td style="padding:6px;border:1px solid #888;text-align:right">'.number_format($kiriman_roll, 0, ',', '.').'</td>
								<td style="padding:6px;border:1px solid #888;text-align:right;font-weight:bold">'.number_format($minRoll, 0, ',', '.').'</td>
								<td style="padding:6px;border:1px solid #888;text-align:right">'.number_format($r->tonase, 0, ',', '.').'</td>
								<td style="padding:6px;border:1px solid #888;text-align:right">'.number_format($kirim_tonase, 0, ',', '.').'</td>
								<td style="padding:6px;border:1px solid #888;text-align:right">'.number_format($minTonase, 0, ',', '.').'</td>
								<td style="padding:6px;border:1px solid #888;text-align:right;font-weight:bold">'.number_format($ss, 0, ',', '.').'</td>
							</tr>';

							// SUM TONASE
							$sumTonase += ($minRoll < 0) ? $r->tonase : 0;
							$sumKirimTon += ($minRoll < 0) ? $kirim_tonase : 0;
							$poTonase += $r->tonase;
							$poKirimTon += $kirim_tonase;
						}
					}
				}

				// TONASE
				$totKurangTon = $sumKirimTon - $sumTonase;
				$totPOKurangTon = $poKirimTon - $poTonase;
				if($list->num_rows() != 1){
					$html .= '<tr>
						<td style="padding:6px;background:#f2f2f2;border:1px solid #888;font-weight:bold;text-align:right" colspan="'.$cls.'">OPEN</td>
						<td style="padding:6px;background:#f2f2f2;border:1px solid #888;font-weight:bold;text-align:right">'.number_format($sumTonase, 0, ',', '.').'</td>
						<td style="padding:6px;background:#f2f2f2;border:1px solid #888;font-weight:bold;text-align:right">'.number_format($sumKirimTon, 0, ',', '.').'</td>
						<td style="padding:6px;background:#f2f2f2;border:1px solid #888;font-weight:bold;text-align:right">'.number_format($totKurangTon, 0, ',', '.').'</td>
						'.$tdKos.'
					</tr>';
				}
				if($list->num_rows() != 1 && $stts == 'ALL'){
					$html .= '<tr>
						<td style="padding:6px;background:#f2f2f2;border:1px solid #888;font-weight:bold;text-align:right" colspan="'.$cls.'">ALL</td>
						<td style="padding:6px;background:#f2f2f2;border:1px solid #888;font-weight:bold;text-align:right">'.number_format($poTonase, 0, ',', '.').'</td>
						<td style="padding:6px;background:#f2f2f2;border:1px solid #888;font-weight:bold;text-align:right">'.number_format($poKirimTon, 0, ',', '.').'</td>
						<td style="padding:6px;background:#f2f2f2;border:1px solid #888;font-weight:bold;text-align:right">'.number_format($totPOKurangTon, 0, ',', '.').'</td>
						'.$tdKos.'
					</tr>';
				}

			$html .= '</table>';
		}else{
			$data = false;
			$html .= 'DATA KOSONG';
		}

		echo json_encode([
			'data' => $data,
			'html' => $html,
		]);
	}

	function cariLapDtlPORoll()
	{
		$id_perusahaan = $_POST["h_id_perusahaan"];
		$no_po = $_POST["h_no_po"];
		$nm_ker = $_POST["h_nm_ker"];
		$g_label = $_POST["h_g_label"];
		$width = $_POST["h_width"];
		$jml_roll_po = $_POST["h_jml_roll_po"];
		$html = '';

		$db = $this->load->database('database_simroll', TRUE);
		$data = $db->query("SELECT b.tgl,TRIM(b.no_surat) AS no_surat,a.nm_ker,a.g_label,a.width,COUNT(*) AS jumlah,SUM(a.weight - a.seset) AS berat,b.nama,b.nm_perusahaan,ex.plat,ex.pt,ex.supir
		FROM m_timbangan a
		INNER JOIN pl b ON a.id_pl=b.id
		INNER JOIN m_expedisi ex ON ex.id=b.id_expedisi
		AND b.id_perusahaan='$id_perusahaan' AND b.no_po='$no_po' AND a.nm_ker='$nm_ker' AND a.g_label='$g_label' AND a.width='$width'
		GROUP BY b.tgl,TRIM(b.no_surat),a.nm_ker,a.g_label,a.width");
		if($data->num_rows() == 0){
			$html .= '';
		}else{
			$html .= '<div class="card-body" style="padding:6px">
				<div style="color:#000;font-weight:bold">'.$no_po.'</div>
				<div style="color:#000;font-weight:bold">'.$nm_ker.$g_label.' - '.round($width,2).'</div>
				<div style="overflow:auto;white-space:nowrap">
					<table style="color:#000">
						<tr>
							<th style="padding:6px;background:#f2f2f2;border:1px solid #888;border-width:1px 1px 3px">TGL</th>
							<th style="padding:6px;background:#f2f2f2;border:1px solid #888;border-width:1px 1px 3px">NO. SURAT</th>
							<th style="padding:6px;background:#f2f2f2;border:1px solid #888;border-width:1px 1px 3px">JUMLAH</th>
							<th style="padding:6px;background:#f2f2f2;border:1px solid #888;border-width:1px 1px 3px">BERAT</th>
							<th style="padding:6px;background:#f2f2f2;border:1px solid #888;border-width:1px 1px 3px">EKSPEDISI</th>
						</tr>';
						$sumJumlah = 0;
						$sumBerat = 0;
						foreach($data->result() as $r){
							$html .= '<tr>
								<td style="padding:6px;border:1px solid #888">'.$r->tgl.'</td>
								<td style="padding:6px;border:1px solid #888">'.$r->no_surat.'</td>
								<td style="padding:6px;border:1px solid #888;text-align:right">'.number_format($r->jumlah, 0, ',', '.').'</td>
								<td style="padding:6px;border:1px solid #888;text-align:right">'.number_format($r->berat, 0, ',', '.').'</td>
								<td style="padding:6px;border:1px solid #888">'.$r->supir.' ( '.$r->plat.' ) '.$r->pt.'</td>
							</tr>';
							$sumJumlah += $r->jumlah;
							$sumBerat += $r->berat;
						}
						// total
						$kuR = $sumJumlah - $jml_roll_po;
						if($data->num_rows() != 1){
							$html .= '<tr>
								<td style="padding:6px;background:#f2f2f2;border:1px solid #888;font-weight:bold;text-align:right" colspan="2">TOTAL ('.$jml_roll_po.')</td>
								<td style="padding:6px;background:#f2f2f2;border:1px solid #888;font-weight:bold;text-align:right">'.number_format($sumJumlah, 0, ',', '.').' ('.$kuR.')</td>
								<td style="padding:6px;background:#f2f2f2;border:1px solid #888;font-weight:bold;text-align:right">'.number_format($sumBerat, 0, ',', '.').'</td>
								<td style="padding:6px;background:#f2f2f2;border:1px solid #888"></td>
							</tr>';
						}
					$html .= '</table>
				</div>
			</div>';
		}

		echo json_encode([
			'html' => $html,
		]);
	}

	//

	function FormSampleDesign()
	{
		$data = [
			'judul' => "Form Sample & Design",
		];
		$this->load->view('header',$data);
		$this->load->view('Transaksi/v_sample_design');
		$this->load->view('footer');
	}

	function loadCustDesign()
	{
		$h_id_pelanggan = $_POST["h_id_pelanggan"];
		$opt = $_POST["opt"];
		$qCust = $this->db->query("SELECT*FROM m_pelanggan c ORDER BY c.nm_pelanggan");
		$htmlCust = '';
		$htmlCust .= '<option value="">PILIH</option>';
		foreach($qCust->result() as $r){
			($r->attn == '-') ? $attn = '' : $attn = ' | '.$r->attn;
			($r->id_pelanggan == $h_id_pelanggan) ? $slt = 'selected' : $slt = '' ;
			$htmlCust .= '<option value="'.$r->id_pelanggan.'" '.$slt.'>'.$r->nm_pelanggan.$attn.'</option>';
		}

		echo json_encode([
			'htmlCust' => $htmlCust,
		]);
	}

	function loadNoPoDesign()
	{
		$h_id_pelanggan = $_POST["h_id_pelanggan"];
		$kode_po = $_POST["kode_po"];
		$id_pelanggan = $_POST["id_pelanggan"];
		($h_id_pelanggan != '' && $kode_po != '') ? $id_pt = $h_id_pelanggan : $id_pt = $id_pelanggan;
		$qNoPo = $this->db->query("SELECT*FROM trs_po WHERE id_pelanggan='$id_pt' AND tgl_po BETWEEN '2025-01-01' AND '9999-01-01' ORDER BY tgl_po DESC,kode_po");
		$htmlNoPo = '';
		if($qNoPo->num_rows() == 0){
			$htmlNoPo .= '<option value="">PILIH</option>';
		}else{
			$htmlNoPo .= '<option value="">PILIH</option>';
			foreach($qNoPo->result() as $r){
				($r->kode_po == $kode_po) ? $slt = 'selected' : $slt = '';
				$htmlNoPo .= '<option value="'.$r->kode_po.'" '.$slt.'>'.$r->kode_po.'</option>';
			}
		}

		echo json_encode([
			'htmlNoPo' => $htmlNoPo,
		]);
	}

	function loadProdukDesign()
	{
		$h_id_pelanggan = $_POST["h_id_pelanggan"];
		$h_kode_po = $_POST["h_kode_po"];
		$h_id_produk = $_POST["h_id_produk"];
		$id_pelanggan = $_POST["id_pelanggan"];
		$kode_po = $_POST["kode_po"];
		if($h_id_pelanggan != '' && $h_kode_po != '' && $h_id_produk != ''){
			$wIdPt = $h_id_pelanggan;
			$wKodePO = $h_kode_po;
		}else{
			$wIdPt = $id_pelanggan;
			$wKodePO = $kode_po;
		}

		$qProduk = $this->db->query("SELECT d.no_po,d.kode_po,d.id_pelanggan,d.id_produk,i.nm_produk FROM trs_po_detail d
		INNER JOIN m_produk i ON d.id_produk=i.id_produk
		WHERE d.kode_po='$wKodePO' AND d.id_pelanggan='$wIdPt' AND d.tgl_po BETWEEN '2025-01-01' AND '9999-01-01'
		GROUP BY d.no_po,d.kode_po,d.id_pelanggan,d.id_produk
		ORDER BY i.nm_produk");
		$htmlProduk = '';
		if($qProduk->num_rows() == 0){
			$htmlProduk .= '<option value="">PILIH</option>';
		}else{
			$htmlProduk .= '<option value="">PILIH</option>';
			foreach($qProduk->result() as $r){
				($r->id_produk == $h_id_produk) ? $slt = 'selected' : $slt = '';
				$htmlProduk .= '<option value="'.$r->id_produk.'" '.$slt.'>'.$r->nm_produk.'</option>';
			}
		}

		echo json_encode([
			'htmlProduk' => $htmlProduk,
		]);
	}

	function detailProdukDesign()
	{
		$h_id_produk = $_POST["h_id_produk"];
		$i_produk = $_POST["i_produk"];
		($h_id_produk != '') ? $id = $h_id_produk : $id = $i_produk;

		$p = $this->db->query("SELECT*FROM m_produk WHERE id_produk='$id'");

		if($p->num_rows() == 0){
			$htmlDtlProduk = '-';
		}else{
			if($p->row()->sambungan == 'G'){
				$join = 'GLUE';
			}else if($p->row()->sambungan == 'S'){
				$join = 'STITCHING';
			}else if($p->row()->sambungan == 'D'){
				$join = 'DIE CUT';
			}else if($p->row()->sambungan == 'DS'){
				$join = 'DOUBLE STITCHING';
			}else if($p->row()->sambungan == 'GS'){
				$join = 'GLUE STITCHING';
			}else {
				$join = '-';
			}
			$htmlDtlProduk = '<table>
				<tr>
					<td style="padding:5px 0">NAMA</td>
					<td style="padding:5px">:</td>
					<td style="padding:5px 0">'.$p->row()->nm_produk.'</td>
				</tr>
				<tr>
					<td style="padding:5px 0">UKURAN BOX</td>
					<td style="padding:5px">:</td>
					<td style="padding:5px 0">'.$p->row()->ukuran.'</td>
				</tr>
				<tr>
					<td style="padding:5px 0">UKURAN SHEET</td>
					<td style="padding:5px">:</td>
					<td style="padding:5px 0">'.$p->row()->ukuran_sheet.'</td>
				</tr>
				<tr>
					<td style="padding:5px 0">KUALITAS</td>
					<td style="padding:5px">:</td>
					<td style="padding:5px 0">'.$this->m_fungsi->kualitas($p->row()->kualitas, $p->row()->flute).'</td>
				</tr>
				<tr>
					<td style="padding:5px 0">FLUTE</td>
					<td style="padding:5px">:</td>
					<td style="padding:5px 0">'.$p->row()->flute.'</td>
				</tr>
				<tr>
					<td style="padding:5px 0">JOINT</td>
					<td style="padding:5px">:</td>
					<td style="padding:5px 0">'.$join.'</td>
				</tr>
			</table>';
		}

		echo json_encode([
			'p' => $h_id_produk,
			'htmlDtlProduk' => $htmlDtlProduk,
		]);
	}

	function uploadDesign()
	{
		$result = $this->m_transaksi->uploadDesign();
		echo json_encode($result);
	}

	function deleteDesign()
	{
		$result = $this->m_transaksi->deleteDesign();
		echo json_encode($result);
	}

	function saveDesign()
	{
		$result = $this->m_transaksi->saveDesign();
		echo json_encode($result);
	}

	function addLinkDesign()
	{
		$result = $this->m_transaksi->addLinkDesign();
		echo json_encode($result);
	}

	function btnAcuanWarna()
	{
		$result = $this->m_transaksi->btnAcuanWarna();
		echo json_encode($result);
	}

	function btnVerifDesign()
	{
		$result = $this->m_transaksi->btnVerifDesign();
		echo json_encode($result);
	}

	function hapusDesign()
	{
		$result = $this->m_transaksi->hapusDesign();
		echo json_encode($result);
	}

	function loadListDesign()
	{
		$lvl = $this->session->userdata('level');
		$id_dg = $_POST["id_dg"];
		$opt = $_POST["opt"];

		if($id_dg != ''){
			$header = $this->db->query("SELECT*FROM trs_design_header WHERE id_dg='$id_dg'")->row();
			$vA = $this->db->query("SELECT*FROM trs_design_header WHERE acc_a_stt='Y' AND id_dg='$id_dg'")->num_rows();
			$vP = $this->db->query("SELECT*FROM trs_design_header WHERE acc_p_stt='Y' AND id_dg='$id_dg'")->num_rows();
			$vD = $this->db->query("SELECT*FROM trs_design_header WHERE acc_d_stt='Y' AND id_dg='$id_dg'")->num_rows();
			$vS = $this->db->query("SELECT*FROM trs_design_header WHERE acc_s_stt='Y' AND id_dg='$id_dg'")->num_rows();
			$vX = $this->db->query("SELECT*FROM trs_design_header WHERE acc_x_stt='Y' AND id_dg='$id_dg'")->num_rows();
			$vZ = $this->db->query("SELECT*FROM trs_design_header WHERE acc_z_stt='Y' AND id_dg='$id_dg'")->num_rows();
		}else{
			$header = ''; $vA = 0; $vD = 0; $vP = 0; $vS = 0; $vX = 0; $vZ = 0; $vK = 0;
		}

		$htmlAcuan = ''; $htmlWarna = ''; $htmlDesign = ''; $linkDesign = ''; $htmlPenawaran = ''; $htmlSample = ''; $htmlPdfSample = ''; $htmlPdfDesign = ''; $htmlX = ''; $htmlXLink = ''; $htmlZ = '';

		// ACUAN
		$qAcuan = $this->db->query("SELECT*FROM trs_design_detail WHERE id_hdr='$id_dg' AND (jenis_dtl='FA' OR jenis_dtl='FW') ORDER BY jenis_dtl");
		if($qAcuan->num_rows() != ''){
			$i = 0;
			foreach($qAcuan->result() as $a){
				$i++;
				$prevAcuan = 'a'.$i;
				if(($opt == 'edit' && $vA == 0 && ($lvl == 'Admin' || $lvl == 'User'))){
					$htmlAcuan .= '<div style="margin-right:4px">
						<button class="btn btn-xs btn-danger" onclick="deleteDesign('."'".$a->id_dtl."'".')"><i class="fas fa-trash"></i></button>
					</div>';
				}
				$htmlAcuan .= '<div style="margin-right:8px">';
					if($a->jenis_dtl == 'FW'){
						$htmlAcuan .= '<div style="background:'.$a->nm_file.';width:55px;height:55px;border:1px solid #ddd"></div><div style="font-weight:bold">'.$a->nm_file.'</div>';
					}else{
						$htmlAcuan .= '<img id="'.$prevAcuan.'" src="'.base_url().'assets/gambar_design/'.$a->nm_file.'" alt="Preview Foto" width="100" class="shadow-sm" onclick="imgClick('."'".$prevAcuan."'".')">';
					}
				$htmlAcuan .= '</div>';
			}
		}else{
			$htmlAcuan .= '-';
		}
		// ACUAN WARNA
		if(($lvl == 'Admin' || $lvl == 'User') && $opt == 'edit'){
			$qAcWarna = $this->db->query("SELECT*FROM trs_design_detail WHERE id_hdr='$id_dg' AND jenis_dtl='FW'");
			($qAcWarna->num_rows() != 0) ? $lVal = $qAcWarna->row()->nm_file : $lVal = '';
			if($vA == 0){
				$htmlWarna .= '<div class="card-body" style="padding:6px">
					<div class="card-body row" style="padding:0">
						<div class="col-md-10" style="padding-bottom:6px">
							<input type="color" class="form-control" id="plh_warna">
						</div>
						<div class="col-md-2" style="padding-bottom:6px">
							<button type="button" class="btn-block btn-sm btn-success" style="padding:8px 12px;font-weight:bold;border:0" onclick="btnAcuanWarna()"><i class="fas fa-palette"></i></button>
						</div>
					</div>
				</div>';
			}else{
				$htmlWarna = '';
			}
		}else{
			$htmlWarna .='';
		}

		// FORM DESIGN
		$qDesign = $this->db->query("SELECT*FROM trs_design_detail WHERE id_hdr='$id_dg' AND (jenis_dtl='FD' OR jenis_dtl='FL' OR jenis_dtl='FG') ORDER BY jenis_dtl");
		if($qDesign->num_rows() != ''){
			$i = 0;
			foreach($qDesign->result() as $a){
				$i++;
				$prevDesign = 'd'.$i;
				if(($opt == 'edit' && $vD == 0 && ($lvl == 'Admin' || $lvl == 'User'))){
					$htmlDesign .= '<div style="margin-right:4px">
						<button class="btn btn-xs btn-danger" onclick="deleteDesign('."'".$a->id_dtl."'".')"><i class="fas fa-trash"></i></button>
					</div>';
				}
				// GAMBAR DAN LINK
				$htmlDesign .= '<div style="margin-right:8px">';
					if($a->jenis_dtl == 'FG'){
						$htmlDesign .= '<a target="_blank" class="btn btn-sm btn-danger" style="font-weight:bold" href="'.base_url("Transaksi/pdfSD?i=".$a->id_dtl."").'"><i class="fas fa-print"></i>&nbspPDF</a>';
					}else if($a->jenis_dtl == 'FD'){
						$htmlDesign .= '<img id="'.$prevDesign.'" src="'.base_url().'assets/gambar_design/'.$a->nm_file.'" alt="Preview Foto" width="100" class="shadow-sm" onclick="imgClick('."'".$prevDesign."'".')">';
					}else{
						$htmlDesign .= '<a target="_blank" class="btn btn-sm btn-primary" style="font-weight:bold" href="'.$a->nm_file.'" title="LINK FORM DESIGN"><i class="fas fa-link"></i> LINK</a>';
					}
				$htmlDesign .= '</div>';
			}
		}else{
			$htmlDesign .= '-';
		}
		// INPUT LINK DESIGN
		if(($lvl == 'Admin' || $lvl == 'User') && $opt == 'edit'){
			if($vD == 0){
				$linkiling = $this->db->query("SELECT*FROM trs_design_detail WHERE id_hdr='$id_dg' AND jenis_dtl='FL'");
				($linkiling->num_rows() != 0) ? $lVal = $linkiling->row()->nm_file : $lVal = '';
				$linkDesign .= '<div class="card-body" style="padding:6px">
					<input type="url" class="form-control" id="link_design" placeholder="LINK FORM DESIGN" autocomplete="off" value="'.$lVal.'" onchange="addLinkDesign('."'".$id_dg."'".')" required>
				</div>';
			}else{
				$linkDesign = '';
			}
		}else{
			$linkDesign .='';
		}
		// PDF FORM DESIGN
		if(($lvl == 'Admin' || $lvl == 'User') && $opt == 'edit'){
			if($vD == 0){
				$lPdf = $this->db->query("SELECT*FROM trs_design_detail WHERE id_hdr='$id_dg' AND jenis_dtl='FG'");
				if($lPdf->num_rows() == 0 && $header->jenis_dg == 'B'){
					$htmlPdfDesign .= '<div class="card-body" style="padding:6px">
						<div class="card-body row" style="padding:0">
							<div class="col-md-4" style="padding-bottom:6px">
								<input type="hidden" id="ff_cust_DESIGN" value="">
								<input type="hidden" id="ff_nm_produk_DESIGN" value="">
								<input type="hidden" id="ff_ukuran_DESIGN" value="">
								<input type="hidden" id="ff_substance_DESIGN" value="">
								<input type="hidden" id="ff_flute_DESIGN" value="">
								<input type="hidden" id="ff_join_DESIGN" value="">
								<input type="number" class="form-control" autocomplete="off" placeholder="QTY PCS" id="qty_pdf_DESIGN">
							</div>
							<div class="col-md-8" style="padding-bottom:6px">
								<button class="btn btn-sm btn-success" style="padding:7px 8px;font-weight:bold" onclick="formSample('."'DESIGN'".')"><i class="fas fa-plus"></i> &nbsp FILE PDF</button>
							</div>
						</div>
					</div>';
				}else if($lPdf->num_rows() == 0 && $header->jenis_dg == 'N'){
					$htmlPdfDesign .= '<div class="card-body" style="padding:6px;border-top:5px solid #6c757d">
						<div style="padding-bottom:5px"><input type="text" class="form-control" autocomplete="off" placeholder="NAMA CUSTOMER" id="ff_cust_DESIGN" oninput="this.value=this.value.toUpperCase()"></div>
						<div style="padding-bottom:5px"><input type="text" class="form-control" autocomplete="off" placeholder="NAMA PRODUK" id="ff_nm_produk_DESIGN" oninput="this.value=this.value.toUpperCase()"></div>
						<div style="padding-bottom:5px"><input type="text" class="form-control" autocomplete="off" placeholder="UKURAN" id="ff_ukuran_DESIGN" oninput="this.value=this.value.toUpperCase()"></div>
						<div style="padding-bottom:5px"><input type="text" class="form-control" autocomplete="off" placeholder="SUBSTANCE" id="ff_substance_DESIGN" oninput="this.value=this.value.toUpperCase()"></div>
						<div style="padding-bottom:5px"><input type="text" class="form-control" autocomplete="off" placeholder="FLUTE" id="ff_flute_DESIGN" oninput="this.value=this.value.toUpperCase()"></div>
						<div style="padding-bottom:5px"><input type="text" class="form-control" autocomplete="off" placeholder="JOIN" id="ff_join_DESIGN" oninput="this.value=this.value.toUpperCase()"></div>
						<div class="card-body row" style="padding:0">
							<div class="col-md-4" style="padding-bottom:6px">
								<input type="number" class="form-control" autocomplete="off" placeholder="QTY PCS" id="qty_pdf_DESIGN">
							</div>
							<div class="col-md-8" style="padding-bottom:6px">
								<button class="btn btn-sm btn-success" style="padding:7px 8px;font-weight:bold" onclick="formSample('."'DESIGN'".')"><i class="fas fa-plus"></i> &nbsp FILE PDF</button>
							</div>
						</div>
					</div>';
				}else{
					$htmlPdfDesign .= '';
				}
			}else{
				$htmlPdfDesign = '';
			}
		}else{
			$htmlPdfDesign .='';
		}

		// PENAWARAN
		if(in_array($this->session->userdata('level'), ['Admin', 'Marketing', 'Owner', 'User'])){
			$qPenawaran = $this->db->query("SELECT*FROM trs_design_detail WHERE id_hdr='$id_dg' AND jenis_dtl='FP'");
			if($qPenawaran->num_rows() != ''){
				$i = 0;
				foreach($qPenawaran->result() as $a){
					$i++;
					$prevPenawaran = 'p'.$i;
					if(($opt == 'edit' && $vP == 0 && ($lvl == 'Admin' || $lvl == 'User'))){
						$htmlPenawaran .= '<div style="margin-right:4px">
							<button class="btn btn-xs btn-danger" onclick="deleteDesign('."'".$a->id_dtl."'".')"><i class="fas fa-trash"></i></button>
						</div>';
					}
					$htmlPenawaran .= '<div style="margin-right:8px">
						<img id="'.$prevPenawaran.'" src="'.base_url().'assets/gambar_design/'.$a->nm_file.'" alt="Preview Foto" width="100" class="shadow-sm" onclick="imgClick('."'".$prevPenawaran."'".')">
					</div>';
				}
			}else{
				$htmlPenawaran .= '-';
			}
		}else{
			$htmlPenawaran .= '-';
		}

		// FORM SAMPLE
		$qSample = $this->db->query("SELECT*FROM trs_design_detail WHERE id_hdr='$id_dg' AND (jenis_dtl='FS' OR jenis_dtl='FF')");
		if($qSample->num_rows() != ''){
			$i = 0;
			foreach($qSample->result() as $a){
				$i++;
				$prevSample = 's'.$i;
				if(($opt == 'edit' && $vS == 0 && ($lvl == 'Admin' || $lvl == 'User'))){
					$htmlSample .= '<div style="margin-right:4px">
						<button class="btn btn-xs btn-danger" onclick="deleteDesign('."'".$a->id_dtl."'".')"><i class="fas fa-trash"></i></button>
					</div>';
				}
				if($a->jenis_dtl == 'FF'){
					$htmlSample .= '<a target="_blank" class="btn btn-sm btn-danger" style="font-weight:bold" href="'.base_url("Transaksi/pdfSD?i=".$a->id_dtl."").'"><i class="fas fa-print"></i>&nbspPDF</a>';
				}else{
					$htmlSample .= '<div style="margin-right:8px">
						<img id="'.$prevSample.'" src="'.base_url().'assets/gambar_design/'.$a->nm_file.'" alt="Preview Foto" width="100" class="shadow-sm" onclick="imgClick('."'".$prevSample."'".')">
					</div>';
				}
			}
		}else{
			$htmlSample .= '-';
		}
		// PDF FORM SAMPLE
		if(($lvl == 'Admin' || $lvl == 'User') && $opt == 'edit'){
			if($vS == 0){
				$lPdf = $this->db->query("SELECT*FROM trs_design_detail WHERE id_hdr='$id_dg' AND jenis_dtl='FF'");
				if($lPdf->num_rows() == 0 && $header->jenis_dg == 'B'){
					$htmlPdfSample .= '<div class="card-body" style="padding:6px">
						<div class="card-body row" style="padding:0">
							<div class="col-md-4" style="padding-bottom:6px">
								<input type="hidden" id="ff_cust_SAMPLE" value="">
								<input type="hidden" id="ff_nm_produk_SAMPLE" value="">
								<input type="hidden" id="ff_ukuran_SAMPLE" value="">
								<input type="hidden" id="ff_substance_SAMPLE" value="">
								<input type="hidden" id="ff_flute_SAMPLE" value="">
								<input type="hidden" id="ff_join_SAMPLE" value="">
								<input type="number" class="form-control" autocomplete="off" placeholder="QTY PCS" id="qty_pdf_SAMPLE">
							</div>
							<div class="col-md-8" style="padding-bottom:6px">
								<button class="btn btn-sm btn-success" style="padding:7px 8px;font-weight:bold" onclick="formSample('."'SAMPLE'".')"><i class="fas fa-plus"></i> &nbsp FILE PDF</button>
							</div>
						</div>
					</div>';
				}else if($lPdf->num_rows() == 0 && $header->jenis_dg == 'N'){
					$htmlPdfSample .= '<div class="card-body" style="padding:6px">
						<div style="padding-bottom:5px"><input type="text" class="form-control" autocomplete="off" placeholder="NAMA CUSTOMER" id="ff_cust_SAMPLE" oninput="this.value=this.value.toUpperCase()"></div>
						<div style="padding-bottom:5px"><input type="text" class="form-control" autocomplete="off" placeholder="NAMA PRODUK" id="ff_nm_produk_SAMPLE" oninput="this.value=this.value.toUpperCase()"></div>
						<div style="padding-bottom:5px"><input type="text" class="form-control" autocomplete="off" placeholder="UKURAN" id="ff_ukuran_SAMPLE" oninput="this.value=this.value.toUpperCase()"></div>
						<div style="padding-bottom:5px"><input type="text" class="form-control" autocomplete="off" placeholder="SUBSTANCE" id="ff_substance_SAMPLE" oninput="this.value=this.value.toUpperCase()"></div>
						<div style="padding-bottom:5px"><input type="text" class="form-control" autocomplete="off" placeholder="FLUTE" id="ff_flute_SAMPLE" oninput="this.value=this.value.toUpperCase()"></div>
						<div style="padding-bottom:5px"><input type="text" class="form-control" autocomplete="off" placeholder="JOIN" id="ff_join_SAMPLE" oninput="this.value=this.value.toUpperCase()"></div>
						<div class="card-body row" style="padding:0">
							<div class="col-md-4" style="padding-bottom:6px">
								<input type="number" class="form-control" autocomplete="off" placeholder="QTY PCS" id="qty_pdf_SAMPLE">
							</div>
							<div class="col-md-8" style="padding-bottom:6px">
								<button class="btn btn-sm btn-success" style="padding:7px 8px;font-weight:bold" onclick="formSample('."'SAMPLE'".')"><i class="fas fa-plus"></i> &nbsp FILE PDF</button>
							</div>
						</div>
					</div>';
				}else{
					$htmlPdfSample .= '';
				}
			}else{
				$htmlPdfSample = '';
			}
		}else{
			$htmlPdfSample .='';
		}

		// DESIGN PPIC
		$qX = $this->db->query("SELECT*FROM trs_design_detail WHERE id_hdr='$id_dg' AND (jenis_dtl='XD' OR jenis_dtl='XL') ORDER BY jenis_dtl");
		if($qX->num_rows() != ''){
			$i = 0;
			foreach($qX->result() as $a){
				$i++;
				$prevX = 'x'.$i;
				if(($opt == 'edit' && $vX == 0 && ($lvl == 'Admin' || $lvl == 'Design'))){
					$htmlX .= '<div style="margin-right:4px">
						<button class="btn btn-xs btn-danger" onclick="deleteDesign('."'".$a->id_dtl."'".')"><i class="fas fa-trash"></i></button>
					</div>';
				}
				// GAMBAR DAN LINK
				$htmlX .= '<div style="margin-right:8px">';
					if($a->jenis_dtl == 'XD'){
						$htmlX .= '<img id="'.$prevX.'" src="'.base_url().'assets/gambar_design/'.$a->nm_file.'" alt="Preview Foto" width="100" class="shadow-sm" onclick="imgClick('."'".$prevX."'".')">';
					}else{
						$htmlX .= '<a target="_blank" class="btn btn-sm btn-primary" style="font-weight:bold" href="'.$a->nm_file.'" title="LINK DESIGN PPI"><i class="fas fa-link"></i> LINK</a>';
					}
				$htmlX .= '</div>';
			}
		}else{
			$htmlX .= '-';
		}
		// INPUT LINK DESIGN
		if(($lvl == 'Admin' || $lvl == 'Design') && $opt == 'edit'){
			if($vX == 0){
				$linkX = $this->db->query("SELECT*FROM trs_design_detail WHERE id_hdr='$id_dg' AND jenis_dtl='XL'");
				($linkX->num_rows() != 0) ? $lX = $linkX->row()->nm_file : $lX = '';
				$htmlXLink .= '<div class="card-body" style="padding:6px">
					<input type="url" class="form-control" id="link_design" placeholder="LINK DESIGN PPI" autocomplete="off" value="'.$lX.'" onchange="addLinkDesign('."'".$id_dg."'".')" required>
				</div>';
			}else{
				$htmlXLink = '';
			}
		}else{
			$htmlXLink .='';
		}

		// SAMPLE PPIC
		$qZ = $this->db->query("SELECT*FROM trs_design_detail WHERE id_hdr='$id_dg' AND jenis_dtl='ZS' ORDER BY jenis_dtl");
		if($qZ->num_rows() != ''){
			$i = 0;
			foreach($qZ->result() as $a){
				$i++;
				$prevZ = 'x'.$i;
				if(($opt == 'edit' && $vZ == 0 && ($lvl == 'Admin' || $lvl == 'Design'))){
					$htmlZ .= '<div style="margin-right:4px">
						<button class="btn btn-xs btn-danger" onclick="deleteDesign('."'".$a->id_dtl."'".')"><i class="fas fa-trash"></i></button>
					</div>';
				}
				$htmlZ .= '<div style="margin-right:8px">
					<img id="'.$prevZ.'" src="'.base_url().'assets/gambar_design/'.$a->nm_file.'" alt="Preview Foto" width="100" class="shadow-sm" onclick="imgClick('."'".$prevZ."'".')">
				</div>';
			}
		}else{
			$htmlZ .= '-';
		}

		// OPTIONS
		($vA == 0) ? $zA = '<option value="FA">ACUAN WARNA</option>' : $zA = '';
		($vP == 0) ? $zP = '<option value="FP">PENAWARAN</option>' : $zP = '';
		($vD == 0) ? $zD = '<option value="FD">FORM DESIGN</option>' : $zD = '';
		($vS == 0) ? $zS = '<option value="FS">FORM SAMPLE</option>' : $zS = '';
		$options = '<option value="">PILIH</option>'.$zA.$zP.$zD.$zS;

		echo json_encode([
			'header' => $header,
			'htmlAcuan' => $htmlAcuan,
			'htmlWarna' => $htmlWarna,
			'htmlDesign' => $htmlDesign,
			'linkDesign' => $linkDesign,
			'htmlPenawaran' => $htmlPenawaran,
			'htmlSample' => $htmlSample,
			'htmlPdfSample' => $htmlPdfSample,
			'htmlPdfDesign' => $htmlPdfDesign,
			'htmlX' => $htmlX,
			'htmlXLink' => $htmlXLink,
			'htmlZ' => $htmlZ,
			'options' => $options,
		]);
	}

	function pdfSD() {
		$id_dtl = $_GET["i"];
		$d = $this->db->query("SELECT*FROM trs_design_detail WHERE id_dtl='$id_dtl'")->row();
		$header = $this->db->query("SELECT*FROM trs_design_header WHERE id_dg='$d->id_hdr'")->row();
        
		header('Content-Type: application/pdf');
		header('Content-Disposition: inline; filename="FORM SAMPLE - '.$header->kode_dg.'"');
		header('Cache-Control: private, max-age=0, must-revalidate');
		header('Pragma: public');
		echo $d->pdf_file;
		exit;
	}

	function editFormDesign()
	{
		$id_dg = $_POST["id_dg"];
		$opsi = $_POST["opsi"];

		$header = $this->db->query("SELECT*FROM trs_design_header WHERE id_dg='$id_dg'")->row();
		$imgA = $this->db->query("SELECT*FROM trs_design_detail WHERE id_hdr='$id_dg' AND (jenis_dtl='FA' OR jenis_dtl='FW')")->num_rows();
		$imgD = $this->db->query("SELECT*FROM trs_design_detail WHERE id_hdr='$id_dg' AND (jenis_dtl='FD' OR jenis_dtl='FL' OR jenis_dtl='FG')")->num_rows();
		$imgP = $this->db->query("SELECT*FROM trs_design_detail WHERE id_hdr='$id_dg' AND jenis_dtl='FP'")->num_rows();
		$imgS = $this->db->query("SELECT*FROM trs_design_detail WHERE id_hdr='$id_dg' AND (jenis_dtl='FS' OR jenis_dtl='FF')")->num_rows();
		$imgX = $this->db->query("SELECT*FROM trs_design_detail WHERE id_hdr='$id_dg' AND (jenis_dtl='XD' OR jenis_dtl='XL')")->num_rows();
		$imgZ = $this->db->query("SELECT*FROM trs_design_detail WHERE id_hdr='$id_dg' AND jenis_dtl='ZS'")->num_rows();

		echo json_encode([
			'header' => $header, 'imgA' => $imgA, 'imgD' => $imgD, 'imgP' => $imgP, 'imgS' => $imgS, 'imgX' => $imgX, 'imgZ' => $imgZ, 'opsi' => $opsi,
			'a_time' => ($header->acc_a_at == null) ? '' :substr($this->m_fungsi->getHariIni($header->acc_a_at),0,3).', '.$this->m_fungsi->tglIndSkt(substr($header->acc_a_at, 0,10)).' ( '.substr($header->acc_a_at, 10,6).' )',
			'd_time' => ($header->acc_d_at == null) ? '' :substr($this->m_fungsi->getHariIni($header->acc_d_at),0,3).', '.$this->m_fungsi->tglIndSkt(substr($header->acc_d_at, 0,10)).' ( '.substr($header->acc_d_at, 10,6).' )',
			'p_time' => ($header->acc_p_at == null) ? '' :substr($this->m_fungsi->getHariIni($header->acc_p_at),0,3).', '.$this->m_fungsi->tglIndSkt(substr($header->acc_p_at, 0,10)).' ( '.substr($header->acc_p_at, 10,6).' )',
			's_time' => ($header->acc_s_at == null) ? '' :substr($this->m_fungsi->getHariIni($header->acc_s_at),0,3).', '.$this->m_fungsi->tglIndSkt(substr($header->acc_s_at, 0,10)).' ( '.substr($header->acc_s_at, 10,6).' )',
			'x_time' => ($header->acc_x_at == null) ? '' :substr($this->m_fungsi->getHariIni($header->acc_x_at),0,3).', '.$this->m_fungsi->tglIndSkt(substr($header->acc_x_at, 0,10)).' ( '.substr($header->acc_x_at, 10,6).' )',
			'z_time' => ($header->acc_z_at == null) ? '' :substr($this->m_fungsi->getHariIni($header->acc_z_at),0,3).', '.$this->m_fungsi->tglIndSkt(substr($header->acc_z_at, 0,10)).' ( '.substr($header->acc_z_at, 10,6).' )',
			'k_time' => ($header->acc_k_at == null) ? '' :substr($this->m_fungsi->getHariIni($header->acc_k_at),0,3).', '.$this->m_fungsi->tglIndSkt(substr($header->acc_k_at, 0,10)).' ( '.substr($header->acc_k_at, 10,6).' )',
		]);
	}

	function formSample()
	{
		$opsi_pdf = $_POST["opsi_pdf"];
		$qty_pdf = $_POST["qty_pdf"];
		$id_dg = $_POST["id_dg"];
		$ff_cust = $_POST["ff_cust"];
		$ff_nm_produk = $_POST["ff_nm_produk"];
		$ff_ukuran = $_POST["ff_ukuran"];
		$ff_substance = $_POST["ff_substance"];
		$ff_flute = $_POST["ff_flute"];
		$ff_join = $_POST["ff_join"];

		$header = $this->db->query("SELECT*FROM trs_design_header WHERE id_dg='$id_dg'")->row();
		($opsi_pdf == 'SAMPLE') ? $opsi = 'SAMPLE' : $opsi = 'DESIGN';

		if(($qty_pdf == '' || $qty_pdf == 0 || $qty_pdf < 0) && $header->jenis_dg == 'B'){
			$data = false; $msg = 'ISI QTY!';
		}else if(($ff_cust == '' || $ff_nm_produk == '' || $ff_ukuran == '' || $ff_substance == '' || $ff_flute == '' || $ff_join == '' || $qty_pdf == '' || $qty_pdf == 0 || $qty_pdf < 0) && $header->jenis_dg == 'N'){
			$data = false; $msg = 'LENGKAPI FORM!';
		}else{
			$html = '';
			$html .= '<table style="margin:0;padding:0;font-size:12px;border-collapse:collapse;color:#000;width:100%">
				<thead>
					<tr>
						<th style="width:15%"></th>
						<th style="width:13%"></th>
						<th style="width:40%"></th>
						<th style="width:15%"></th>
						<th style="width:2%"></th>
						<th style="width:15%"></th>
					</tr>
					<tr>
						<th style="border:1px solid #000" rowspan="6">
							<img src="'.base_url('assets/gambar/ppi.png').'" alt="PPI" width="80" height="60">
						</th>
					</tr>
					<tr>
						<th style="border:1px solid #000;font-size:24px" rowspan="5" colspan="2">FORM PERMINTAAN '.$opsi.'</th>
					</tr>
					<tr>
						<th style="border:1px solid #000;border-width:1px 0 0 1px;font-weight:normal;padding:3px;text-align:left">No</th>
						<th style="border:1px solid #000;border-width:1px 0 0;font-weight:normal;padding:3px">:</th>
						<th style="border:1px solid #000;border-width:1px 1px 0 0;font-weight:normal;padding:3px;text-align:left">FR-MKT-05</th>
					</tr>
					<tr>
						<th style="border:1px solid #000;border-width:0 0 0 1px;font-weight:normal;padding:3px;text-align:left">Tgl Terbit</th>
						<th style="font-weight:normal;padding:3px">:</th>
						<th style="border:1px solid #000;border-width:0 1px 0 0;font-weight:normal;padding:3px;text-align:left">27-Sep-22</th>
					</tr>
					<tr>
						<th style="border:1px solid #000;border-width:0 0 0 1px;font-weight:normal;padding:3px;text-align:left">Rev</th>
						<th style="font-weight:normal;padding:3px">:</th>
						<th style="border:1px solid #000;border-width:0 1px 0 0;font-weight:normal;padding:3px;text-align:left">0</th>
					</tr>
					<tr>
						<th style="border:1px solid #000;border-width:0 0 1px 1px;font-weight:normal;padding:3px;text-align:left">Hal</th>
						<th style="border:1px solid #000;border-width:0 0 1px;font-weight:normal;padding:3px">:</th>
						<th style="border:1px solid #000;border-width:0 1px 1px 0;font-weight:normal;padding:3px;text-align:left">1</th>
					</tr>
					<tr>
						<th style="border:1px solid #000;border-width:1px 0 0 1px;font-weight:normal;padding:5px;text-align:right">No</th>
						<th style="border:1px solid #000;border-width:1px 0 0;font-weight:normal;padding:5px;text-align:left" colspan="2">: '.$header->kode_dg.'/'.$opsi.'</th>
						<th style="border:1px solid #000;border-width:1px 0 0;font-weight:normal;padding:5px;text-align:right">Kepada</th>
						<th style="border:1px solid #000;border-width:1px 0 0;font-weight:normal;padding:5px">:</th>
						<th style="border:1px solid #000;border-width:1px 1px 0 0;font-weight:normal;padding:5px;text-align:left">Bag '.$opsi.'</th>
					</tr>
					<tr>
						<th style="border:1px solid #000;border-width:0 0 1px 1px;font-weight:normal;padding:5px;text-align:right">Tgl</th>
						<th style="border:1px solid #000;border-width:0 0 1px;font-weight:normal;padding:5px;text-align:left" colspan="2">: '.$this->m_fungsi->tanggal_format_indonesia($header->tgl).'</th>
						<th style="border:1px solid #000;border-width:0 0 1px;font-weight:normal;padding:5px;text-align:right">Dari</th>
						<th style="border:1px solid #000;border-width:0 0 1px;font-weight:normal;padding:5px">:</th>
						<th style="border:1px solid #000;border-width:0 1px 1px 0;font-weight:normal;padding:5px;text-align:left">Marketing</th>
					</tr>
				</thead>';

				if($header->jenis_dg == 'B'){
					$item = $this->db->query("SELECT h.*,i.*,c.nm_pelanggan,c.attn FROM trs_design_header h
					INNER JOIN m_pelanggan c ON h.id_pelanggan=c.id_pelanggan
					INNER JOIN m_produk i ON h.id_produk=i.id_produk
					WHERE h.id_dg='$id_dg'
					GROUP BY h.id_pelanggan,h.kode_po,h.id_produk")->row();
					if($item->kategori == "K_BOX"){
						$ukuran = $item->ukuran;
						if($item->sambungan == 'G'){
							$s = 'GLUE';
						}else if($item->sambungan == 'S'){
							$s = 'STITCHING';
						}else if($item->sambungan == 'D'){
							$s = 'DIE CUT';
						}else if($item->sambungan == 'DS'){
							$s = 'DOUBLE STITCHING';
						}else if($item->sambungan == 'GS'){
							$s = 'GLUE STITCHING';
						}else{
							$s = '-';
						}
						$join = $item->tipe_box.' - '.$s;
					}else{
						$ukuran = $item->ukuran_sheet;
						$join = '-';
					}
					($item->attn == '-') ? $attn = '' : $attn = ' | '.$item->attn;
					$fnmCust = $item->nm_pelanggan.$attn;
					$fnmProduk = $item->nm_produk;
					$fUkuran = $ukuran;
					$fSubstance = $this->m_fungsi->kualitas($item->kualitas, $item->flute);
					$fFlute = $item->flute;
					$fJoin = $join;
				}else{
					$fnmCust = $ff_cust;
					$fnmProduk = $ff_nm_produk;
					$fUkuran = $ff_ukuran;
					$fSubstance = $ff_substance;
					$fFlute = $ff_flute;
					$fJoin = $ff_join;
				}

				$html .= '<tr>
					<td style="padding:16px 5px 8px" colspan="2">Nama Customer</td>
					<td>: '.$fnmCust.'</td>
				</tr>
				<tr>
					<td style="padding:8px 5px" colspan="2">Nama Box / Sheet</td>
					<td>: '.$fnmProduk.'</td>
				</tr>
				<tr>
					<td style="padding:8px 5px" colspan="2">Ukuran</td>
					<td>: '.$fUkuran.' MM</td>
				</tr>
				<tr>
					<td style="padding:8px 5px" colspan="2">Substance / Flute</td>
					<td>: '.$fSubstance.'</td>
					<td>/ '.$fFlute.'</td>
				</tr>
				<tr>
					<td style="padding:8px 5px" colspan="2">Join</td>
					<td>: '.$fJoin.'</td>
				</tr>
				<tr>
					<td style="padding:8px 5px" colspan="2">Nama Layer</td>
					<td>:</td>
				</tr>
				<tr>
					<td style="padding:8px 5px" colspan="2">Ukuran</td>
					<td>:</td>
				</tr>
				<tr>
					<td style="padding:8px 5px" colspan="2">Substance / Flute</td>
					<td>:</td>
				</tr>
				<tr>
					<td style="padding:10px 0" colspan="6"></td>
				</tr>
				<tr>
					<td style="padding:8px 5px" colspan="2">Jumlah</td>
					<td>: @ '.$qty_pdf.' PCS</td>
					<td>BH / SET</td>
				</tr>
				<tr>
					<td style="padding:8px 5px" colspan="2">Contoh/Gambar/Design</td>
					<td>:</td>
				</tr>
				<tr>
					<td style="padding:8px 5px" colspan="2">Keterangan Lain</td>
					<td>:</td>
				</tr>';

				// ttd
				$html .= '<tr>
					<td style="padding:50px 0" colspan="6"></td>
				</tr>
				<tr>
					<td style="padding:5px" colspan="2">( ........................... )</td>
					<td style="padding:5px;text-align:right" colspan="2">( ........................... )</td>
					<td style="padding:5px" colspan="2">( ........................... )</td>
				</tr>
				<tr>
					<td style="padding:5px 5px 5px 22px" colspan="2">MARKETING</td>
					<td style="padding:5px 45px 5px 5px;text-align:right" colspan="2">PPIC</td>
					<td style="padding:5px 5px 5px 35px" colspan="2">'.$opsi.'</td>
				</tr>';
			$html .= '</table>';

			$judul = 'FORM '.$opsi.' - '.$header->kode_dg;
			$this->load->library('mpdf');
			$this->mpdf->setTitle($judul);
			$this->mpdf->AddPageByArray(array(
				'orientation' => 'P',
				'margin-top' => 5,
				'margin-right' => 5,
				'margin-bottom' => 5,
				'margin-left' => 5,
				'sheet-size' => array(210, 297),
			));
			$this->mpdf->writeHTML($html);         
			$pdf = $this->mpdf->Output('', 'S');
			($opsi_pdf == 'SAMPLE') ? $ff = 'FF' : $ff = 'FG';
			$dtl = array(
				'id_hdr' => $id_dg,
				'jenis_dtl' => $ff,
				'nm_file' => 'FORM '.$opsi,
				'pdf_qty' => $qty_pdf,
				'pdf_file' => $pdf,
				'add_at' => date('Y-m-d H:i:s'),
				'add_by' => $this->session->userdata('username'),
			);
			$data = $this->db->insert('trs_design_detail', $dtl);
			$msg = 'BERHASIL BUAT FILE PDF!';
		}

		echo json_encode([
			'data' => $data,
			'msg' => $msg,
		]);
	}

	//

	function HPP()
	{
		$data = [
			'judul' => "HPP",
		];
		$this->load->view('header',$data);
		$this->load->view('Transaksi/v_hpp');
		$this->load->view('footer');
	}

	function simpanHPP()
	{
		$result = $this->m_transaksi->simpanHPP();
		echo json_encode($result);
	}

	function hapusHPP()
	{
		$result = $this->m_transaksi->hapusHPP();
		echo json_encode($result);
	}

	function hapusKetEditHPP()
	{
		$result = $this->m_transaksi->hapusKetEditHPP();
		echo json_encode($result);
	}

	function editHPP()
	{ //
		$id_hpp = $_POST["id_hpp"];
		$opsi = $_POST["opsi"];
		$hpp = $this->db->query("SELECT*FROM m_hpp WHERE id_hpp='$id_hpp'")->row();
		if($hpp->pilih_hpp == 'PM2'){
			$jenis = 'pm';
		}else if($hpp->pilih_hpp == 'SHEET'){
			$jenis = 'sheet';
		}else if($hpp->pilih_hpp == 'BOX'){
			$jenis = 'box';
		}
		
		$htmlUpah = '';
		$upah = $this->db->query("SELECT*FROM m_hpp_detail WHERE id_hpp='$id_hpp' AND opsi='upah' AND jenis='$jenis'");
		if($upah->num_rows() == 0){
			$htmlUpah .= '';
		}else{
			foreach($upah->result() as $u){
				if($opsi == 'edit'){
					$hapusUpah = '<button class="btn btn-xs btn-danger" style="padding:1px 4px" onclick="hapusKetEditHPP('."'".$u->id."'".','."'".$id_hpp."'".','."'".$jenis."'".','."'upah'".','."'edit'".')"><i class="fas fa-times"></i></button>';
				}else{
					$hapusUpah = '';
				}
				$htmlUpah .= '<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
					<div class="col-md-3">'.$hapusUpah.' '.$u->ket_txt.'</div>
					<div class="col-md-9">
						<input type="text" class="form-control" style="font-weight:bold;color:#000;text-align:right" value="'.number_format($u->ket_rp,0,',','.').'" disabled>
					</div>
				</div>';
			}
		}

		$htmlBB = '';
		$bb = $this->db->query("SELECT*FROM m_hpp_detail WHERE id_hpp='$id_hpp' AND opsi='bb' AND jenis='$jenis'");
		if($bb->num_rows() == 0){
			$htmlBB .= '';
		}else{
			foreach($bb->result() as $b){
				if($opsi == 'edit'){
					$hapusBB = '<button class="btn btn-xs btn-danger" style="padding:1px 4px" onclick="hapusKetEditHPP('."'".$b->id."'".','."'".$id_hpp."'".','."'".$jenis."'".','."'bb'".','."'edit'".')"><i class="fas fa-times"></i></button>';
				}else{
					$hapusBB = '';
				}
				if($b->ket_kg == 0){
					$htmlBB .= '<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
						<div class="col-md-3">'.$hapusBB.' '.$b->ket_txt.'</div>
						<div class="col-md-6"></div>
						<div class="col-md-3">
							<div class="input-group" style="margin-bottom:3px">
								<div class="input-group-prepend">
									<span class="input-group-text" style="padding:6px;font-weight:bold;color:#000">Rp</span>
								</div>
								<input type="text" class="form-control" style="font-weight:bold;color:#000;text-align:right" value="'.number_format($b->ket_rp,0,',','.').'" disabled>
							</div>
						</div>
					</div>';
				}
				if($b->ket_kg != 0){
					$htmlBB .= '<div class="card-body row" style="font-weight:bold;padding:0 12px 3px">
						<div class="col-md-3">'.$hapusBB.' '.$b->ket_txt.'</div>
						<div class="col-md-3">
							<div class="input-group" style="margin-bottom:3px">
								<input type="text" class="form-control" style="font-weight:bold;color:#000;text-align:right" value="'.number_format($b->ket_kg,0,',','.').'" disabled>
								<div class="input-group-prepend">
									<span class="input-group-text" style="padding:6px;font-weight:bold;color:#000">Kg</span>
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="input-group" style="margin-bottom:3px">
								<div class="input-group-prepend">
									<span class="input-group-text" style="padding:6px">Rp</span>
								</div>
								<input type="text" class="form-control" style="text-align:right" value="'.number_format($b->ket_rp,0,',','.').'" disabled>
							</div>
						</div>
						<div class="col-md-3">
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text" style="padding:6px;font-weight:bold;color:#000">Rp</span>
								</div>
								<input type="text" class="form-control" style="font-weight:bold;color:#000;text-align:right" value="'.number_format($b->ket_x,0,',','.').'" disabled>
							</div>
						</div>
					</div>';
				}
			}
		}

		$htmlLainLain = '';
		$dll = $this->db->query("SELECT*FROM m_hpp_detail WHERE id_hpp='$id_hpp' AND opsi='lainlain' AND jenis='$jenis'");
		if($dll->num_rows() == 0){
			$htmlLainLain .= '';
		}else{
			foreach($dll->result() as $l){
				if($opsi == 'edit'){
					$hapusLL = '<button class="btn btn-xs btn-danger" style="padding:1px 4px" onclick="hapusKetEditHPP('."'".$l->id."'".','."'".$id_hpp."'".','."'".$jenis."'".','."'lainlain'".','."'edit'".')"><i class="fas fa-times"></i></button>';
				}else{
					$hapusLL = '';
				}
				if($l->ket_kg == 0){
					$htmlLainLain .= '<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
						<div class="col-md-3">'.$hapusLL.' '.$l->ket_txt.'</div>
						<div class="col-md-6"></div>
						<div class="col-md-3">
							<div class="input-group" style="margin-bottom:3px">
								<div class="input-group-prepend">
									<span class="input-group-text" style="padding:6px;font-weight:bold;color:#000">Rp</span>
								</div>
								<input type="text" class="form-control" style="font-weight:bold;color:#000;text-align:right" value="'.number_format($l->ket_rp,0,',','.').'" disabled>
							</div>
						</div>
					</div>';
				}
				if($l->ket_kg != 0){
					$htmlLainLain .= '<div class="card-body row" style="font-weight:bold;padding:0 12px 3px">
						<div class="col-md-3">'.$hapusLL.' '.$l->ket_txt.'</div>
						<div class="col-md-3">
							<div class="input-group" style="margin-bottom:3px">
								<input type="text" class="form-control" style="font-weight:bold;color:#000;text-align:right" value="'.number_format($l->ket_kg,0,',','.').'" disabled>
								<div class="input-group-prepend">
									<span class="input-group-text" style="padding:6px;font-weight:bold;color:#000">Kg</span>
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="input-group" style="margin-bottom:3px">
								<div class="input-group-prepend">
									<span class="input-group-text" style="padding:6px">Rp</span>
								</div>
								<input type="text" class="form-control" style="text-align:right" value="'.number_format($l->ket_rp,0,',','.').'" disabled>
							</div>
						</div>
						<div class="col-md-3">
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text" style="padding:6px;font-weight:bold;color:#000">Rp</span>
								</div>
								<input type="text" class="form-control" style="font-weight:bold;color:#000;text-align:right" value="'.number_format($l->ket_x,0,',','.').'" disabled>
							</div>
						</div>
					</div>';
				}
			}
		}

		$data = [
			'id_hpp' => $hpp->id_hpp,
			'pilih_hpp' => $hpp->pilih_hpp,
			'rentang_hpp' => $hpp->rentang_hpp,
			'bulan_hpp' => $hpp->bulan_hpp,
			'tahun_hpp' => $hpp->tahun_hpp,
			'tgl_hpp' => $hpp->tgl_hpp,
			'jenis_hpp' => $hpp->jenis_hpp,
			'bahan_baku_kg' => number_format($hpp->bahan_baku_kg,0,',','.'),
			'bahan_baku_rp' => number_format($hpp->bahan_baku_rp,0,',','.'),
			'bahan_baku_x' => number_format($hpp->bahan_baku_x,0,',','.'),
			'tenaga_kerja' => number_format($hpp->tenaga_kerja,0,',','.'),
			'upah' => number_format($hpp->upah,0,',','.'),
			'thr' => number_format($hpp->thr,0,',','.'),
			'listrik' => number_format($hpp->listrik,0,',','.'),
			'batu_bara_kg' => number_format($hpp->batu_bara_kg,0,',','.'),
			'batu_bara_rp' => number_format($hpp->batu_bara_rp,0,',','.'),
			'batu_bara_x' => number_format($hpp->batu_bara_x,0,',','.'),
			'chemical_kg' => number_format($hpp->chemical_kg,0,',','.'),
			'chemical_rp' => number_format($hpp->chemical_rp,0,',','.'),
			'chemical_x' => number_format($hpp->chemical_x,0,',','.'),
			'bahan_pembantu' => number_format($hpp->bahan_pembantu,0,',','.'),
			'solar' => number_format($hpp->solar,0,',','.'),
			'maintenance' => number_format($hpp->maintenance,0,',','.'),
			'ekspedisi' => number_format($hpp->ekspedisi,0,',','.'),
			'depresiasi' => number_format($hpp->depresiasi,0,',','.'),
			'lain_lain_kg' => number_format($hpp->lain_lain_kg,0,',','.'),
			'lain_lain_rp' => number_format($hpp->lain_lain_rp,0,',','.'),
			'hasil_hpp' => number_format($hpp->hasil_hpp,0,',','.'),
			'tonase_order' => number_format($hpp->tonase_order,0,',','.'),
			'hasil_x_tonase' => number_format($hpp->hasil_x_tonase,0,',','.'),
			'presentase' => $hpp->presentase,
			'hasil_hpp_tanpa_bb' => number_format($hpp->hasil_hpp_tanpa_bb,0,',','.'),
			'hasil_x_tonase_tanpa_bb' => number_format($hpp->hasil_x_tonase_tanpa_bb,0,',','.'),
			'hxt_x_persen' => number_format($hpp->hxt_x_persen,0,',','.'),
			'hpp_pm' => number_format($hpp->hpp_pm,0,',','.'),
			'hpp_sheet' => number_format($hpp->hpp_sheet,0,',','.'),
			'hpp_plus_plus' => number_format($hpp->hpp_plus_plus,0,',','.'),
			'fix_hpp' => number_format($hpp->fix_hpp,0,',','.'),
			'fix_hpp_aktual' => number_format($hpp->fix_hpp_aktual,0,',','.'),
		];

		echo json_encode([
			'data' => $data,
			'htmlUpah' => $htmlUpah,
			'htmlBB' => $htmlBB,
			'htmlLainLain' => $htmlLainLain,
		]);
	}

	function loadDataHPP()
	{
		$data = [];
		$periode_hpp = $_POST["periode_hpp"];
		if($periode_hpp == ""){
			$rentang = "";
		}else{
			$rentang = "WHERE rentang_hpp='$periode_hpp'";
		}
		$query = $this->db->query("SELECT*FROM m_hpp $rentang ORDER BY id_hpp DESC")->result();
		$i = 0;
		foreach ($query as $r) {
			$i++;
			$row = [];
			$row[] = '<div class="text-center"><a href="javascript:void(0)" style="color:#212529" onclick="editHPP('."'".$r->id_hpp."'".','."'detail'".')">'.$i.'<a></div>';
			if($r->rentang_hpp == 'TAHUN'){
				$rentang = $r->tahun_hpp;
			}else if($r->rentang_hpp == 'BULAN'){
				$rentang = strtoupper($this->m_fungsi->getBulan($r->bulan_hpp)).' <span style="vertical-align:top;font-size:12px">( '.substr($r->tahun_hpp,2,2).' )</span>';
			}else{
				$rentang = strtoupper($this->m_fungsi->tanggal_format_indonesia($r->tgl_hpp));
			}
			$row[] = '<div><a href="javascript:void(0)" style="color:#212529" onclick="editHPP('."'".$r->id_hpp."'".','."'detail'".')">'.$r->rentang_hpp.'</a></div>';
			$row[] = '<div><a href="javascript:void(0)" style="color:#212529" onclick="editHPP('."'".$r->id_hpp."'".','."'detail'".')">'.$rentang.'</a></div>';
			$row[] = '<div class="text-center"><a href="javascript:void(0)" style="color:#212529" onclick="editHPP('."'".$r->id_hpp."'".','."'detail'".')">'.$r->pilih_hpp.'<a></div>';
			$row[] = '<div class="text-center"><a href="javascript:void(0)" style="color:#212529" onclick="editHPP('."'".$r->id_hpp."'".','."'detail'".')">'.$r->jenis_hpp.'<a></div>';
			$row[] = '<div class="text-right"><a href="javascript:void(0)" style="color:#212529" onclick="editHPP('."'".$r->id_hpp."'".','."'detail'".')">'.number_format($r->hasil_hpp,0,",",".").'</a></div>';
			$row[] = '<div class="text-right"><a href="javascript:void(0)" style="color:#212529" onclick="editHPP('."'".$r->id_hpp."'".','."'detail'".')">'.number_format($r->tonase_order,0,",",".").'</a></div>';
			$row[] = '<div class="text-right"><a href="javascript:void(0)" style="color:#212529" onclick="editHPP('."'".$r->id_hpp."'".','."'detail'".')">'.number_format($r->hasil_x_tonase,0,",",".").'</a></div>';
			$edit = '<button type="button" onclick="editHPP('."'".$r->id_hpp."'".','."'edit'".')" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></button>';
			$view = '<button type="button" onclick="editHPP('."'".$r->id_hpp."'".','."'detail'".')" class="btn btn-info btn-sm" style="color:#000"><i class="fas fa-eye"></i></button>';
			if($this->session->userdata('level') == 'Admin'){
				$hapus = '<button type="button" onclick="hapusHPP('."'".$r->id_hpp."'".')" class="btn btn-secondary btn-sm" ><i class="fas fa-trash-alt"></i></button>';
			}else{
				$hapus = '';
			}

			if($r->pilih_hpp == 'PM2' && $r->jenis_hpp != 'WP' && $r->cek_sheet != 'N'){
				$aksi = $edit.' '.$view;
			}else if($r->pilih_hpp == 'PM2' && $r->jenis_hpp == 'WP' && $r->cek_laminasi != 'N'){
				$aksi = $edit.' '.$view;
			}else if($r->pilih_hpp == 'SHEET' && $r->cek_box != 'N'){
				$aksi = $edit.' '.$view;
			}else{
				$aksi = $edit.' '.$hapus;
			}

			$row[] = '<div class="text-center">'.$aksi.'</div>';
			$data[] = $row;
		}
		$output = [
			"data" => $data,
		];
		echo json_encode($output);
	}

	function PO_bhn_bk()
	{
		$data = [
			'judul' => "PO BAHAN BAKU",
		];
		$this->load->view('header',$data);
		if($this->session->userdata('level'))
		{
			$this->load->view('Transaksi/v_po_bhn_bk');
		}else{
			$this->load->view('home');
		}
		$this->load->view('footer');
	}

	function insert_po_bb()
	{
		if($this->session->userdata('username'))
		{ 
			$result = $this->m_transaksi->save_po_bb();
			echo json_encode($result);
		}
		
	}

	function PO_Laminasi()
	{
		$data = [
			'judul' => "PO Laminasi",
		];
		$this->load->view('header',$data);
		if(in_array($this->session->userdata('level'), ['Admin', 'konsul_keu', 'Laminasi', 'Marketing Laminasi', 'Owner', 'Keuangan1'])){
			$this->load->view('Transaksi/v_po_laminasi');
		}else{
			$this->load->view('home');
		}
		$this->load->view('footer');
	}

	function plhProduk()
	{
		$jenis_lm = $_POST["jenis_lm"];
		$query = $this->db->query("SELECT*FROM m_produk_lm WHERE jenis_lm='$jenis_lm' ORDER BY nm_produk_lm");
		$html ='';
		$html .='<option value="">PILIH</option>';
		foreach($query->result() as $r){
			if($r->jenis_qty_lm == 'pack'){
				$qty = $r->pack_lm;
			}else if($r->jenis_qty_lm == 'ikat'){
				$qty = $r->ikat_lm.' ( IKAT )';
			}else{
				$qty = $r->kg_lm.' ( KG )';
			}
			$html .='<option
				value="'.$r->id_produk_lm.'"
				nm_produk_lm="'.$r->nm_produk_lm.'"
				ukuran_lm="'.$r->ukuran_lm.'"
				isi_lm="'.$r->isi_lm.'"
				jenis_qty_lm="'.$r->jenis_qty_lm.'"
				pack_x="'.$r->pack_x.'"
				ikat_x="'.$r->ikat_x.'"
				pack_lm="'.$r->pack_lm.'"
				ikat_lm="'.$r->ikat_lm.'"
				kg_lm="'.$r->kg_lm.'"
			>'.$r->nm_produk_lm.' | '.$r->ukuran_lm.' | '.$r->isi_lm.' | '.$qty.'</option>';
		}
		echo json_encode([
			'num_rows' => $query->num_rows(),
			'html' => $html,
		]);
	}

	function destroyLaminasi()
	{
		$this->cart->destroy();
		echo "LIST KOSONG!";
	}

	function addItemLaminasi()
	{
		if($_POST["tgl"] == "" || $_POST["customer"] == "" || $_POST["id_sales"] == "" || $_POST["attn"] == "" || $_POST["no_po"] == "" || $_POST["jenis_lm"] == "" || $_POST["item"] == "" || $_POST["qty_bal"] == "" || $_POST["harga_total"] == ""){
			echo json_encode(array('data' => false, 'isi' => 'HARAP LENGKAPI FORM!'));
		}else{
			// id_po_header, tgl, customer, id_sales, no_po, note_po_lm, attn, jenis_lm, item, nm_produk_lm, ukuran_lm, isi_lm, jenis_qty_lm, qty, order_sheet, order_pack, order_ikat, order_pori, qty_bal, harga_lembar, harga_pack, harga_ikat, harga_pori, harga_total, id_cart
			$data = array(
				'id' => $_POST["id_cart"],
				'name' => 'name'.$_POST["id_cart"],
				'price' => 0,
				'qty' => 1,
				'options' => array(
					'tgl' => $_POST["tgl"],
					'customer' => $_POST["customer"],
					'id_sales' => $_POST["id_sales"],
					'attn' => $_POST["attn"],
					'no_po' => $_POST["no_po"],
					'jenis_lm' => $_POST["jenis_lm"],
					'item' => $_POST["item"],
					'nm_produk_lm' => $_POST["nm_produk_lm"],
					'ukuran_lm' => $_POST["ukuran_lm"],
					'isi_lm' => $_POST["isi_lm"],
					'jenis_qty_lm' => $_POST["jenis_qty_lm"],
					'qty' => $_POST["qty"],
					'order_sheet' => $_POST["order_sheet"],
					'order_pack' => $_POST["order_pack"],
					'order_ikat' => $_POST["order_ikat"],
					'order_pori' => $_POST["order_pori"],
					'qty_bal' => $_POST["qty_bal"],
					'harga_lembar' => $_POST["harga_lembar"],
					'harga_pack' => $_POST["harga_pack"],
					'harga_ikat' => $_POST["harga_ikat"],
					'harga_pori' => $_POST["harga_pori"],
					'harga_total' => $_POST["harga_total"],
					'id_cart' => $_POST["id_cart"],
				)
			);
			$id = $_POST["id_po_header"];
			$po_lm = $this->db->query("SELECT*FROM trs_po_lm WHERE id='$id'");
			if($po_lm->num_rows() > 0){
				$no_po_lm = $po_lm->row()->no_po_lm;
				$po_dtl = $this->db->query("SELECT d.* FROM trs_po_lm_detail d INNER JOIN m_produk_lm p ON d.id_m_produk_lm=p.id_produk_lm WHERE d.no_po_lm='$no_po_lm'");
			}else{
				$po_dtl = '';
			}
			if($this->cart->total_items() != 0){
				foreach($this->cart->contents() as $r){
					if($r['options']['item'] == $_POST["item"]){
						echo json_encode(array('data' => false, 'isi' => 'ITEM SUDAH ADA!'));
						return;
					}
				}
				if($po_lm->num_rows() > 0){
					foreach($po_dtl->result() as $r){
						if($r->id_m_produk_lm == $_POST["item"]){
							echo json_encode(array('data' => false, 'isi' => 'ITEM SUDAH ADA!'));
							return;
						}
					}
				}
				$this->cart->insert($data);
				echo json_encode(array('data' => true, 'isi' => 'BERHASIL ADD!'));
			}else{
				if($_POST["id_po_header"] == ''){
					$this->cart->insert($data);
					echo json_encode(array('data' => true, 'isi' => 'BERHASIL ADD!'));
				}else{
					if($po_lm->num_rows() > 0 && $po_lm->row()->opsi_disc != ''){
						echo json_encode(array('data' => false, 'isi' => 'HAPUS HAPUS DISKON / FEE DAHULU!'));
						return;
					}
					foreach($po_dtl->result() as $r){
						if($r->id_m_produk_lm == $_POST["item"]){
							echo json_encode(array('data' => false, 'isi' => 'ITEM SUDAH ADA!'));
							return;
						}
					}
					$this->cart->insert($data);
					echo json_encode(array('data' => true, 'isi' => 'BERHASIL ADD!'));
				}
			}
		}
	}

	function cartPOLaminasi()
	{
		$html = '';

		if($this->cart->total_items() == 0){
			$html .= 'LIST KOSONG!';
		}

		if($this->cart->total_items() != 0){
			$html .='<table class="table table-bordered table-striped">';
			$html .='<thead>
				<tr>
					<th style="padding:6px;text-align:center">NO.</th>
					<th style="padding:6px">ITEM</th>
					<th style="padding:6px;text-align:center">SIZE</th>
					<th style="padding:6px;text-align:center">ISI</th>
					<th style="padding:6px;text-align:center">@BAL</th>
					<th style="padding:6px;text-align:center">ORDER SHEET</th>
					<th style="padding:6px;text-align:center">ORDER PACK</th>
					<th style="padding:6px;text-align:center">ORDER IKAT</th>
					<th style="padding:6px;text-align:center">QTY(BAL)</th>
					<th style="padding:6px;text-align:center">HARGA LEMBAR</th>
					<th style="padding:6px;text-align:center">HARGA PACK</th>
					<th style="padding:6px;text-align:center">HARGA IKAT</th>
					<th style="padding:6px;text-align:center">HARGA TOTAL</th>
					<th style="padding:6px;text-align:center">AKSI</th>
				</tr>
			</thead>';
		}

		$i = 0;
		foreach($this->cart->contents() as $r){
			$i++;
			($r['options']['jenis_qty_lm'] == 'kg') ? $qty = $r['options']['qty'] : $qty = number_format($r['options']['qty'],0,",",".");
			($r['options']['jenis_qty_lm'] == 'kg') ? $qty_bal = $r['options']['qty_bal'] : $qty_bal = number_format($r['options']['qty_bal'],0,",",".");
			if($r['options']['jenis_lm'] == 'PPI'){
				if($r['options']['jenis_qty_lm'] == 'pack'){
					$order_pack = number_format($r['options']['order_pori'],0,",",".");
					$order_ikat = '-';
					$harga_pack = number_format($r['options']['harga_pori'],0,",",".");
					$harga_ikat = '-';
				}else if($r['options']['jenis_qty_lm'] == 'ikat'){
					$order_pack = '-';
					$order_ikat = number_format($r['options']['order_pori'],0,",",".");
					$harga_pack = '-';
					$harga_ikat = number_format($r['options']['harga_pori'],0,",",".");
				}else{
					$order_pack = '-';
					$order_ikat = '-';
					$harga_pack = '-';
					$harga_ikat = '-';
				}
			}
			if($r['options']['jenis_lm'] == 'PEKALONGAN'){
				$order_pack = number_format($r['options']['order_pack'],0,",",".");
				$order_ikat = number_format($r['options']['order_ikat'],0,",",".");
				$harga_pack = number_format($r['options']['harga_pack'],0,",",".");
				$harga_ikat = number_format($r['options']['harga_ikat'],0,",",".");
			}
			$html .='<tr>
				<td style="padding:6px;text-align:center">'.$i.'</td>
				<td style="padding:6px">'.$r['options']['nm_produk_lm'].'</td>
				<td style="padding:6px;text-align:center">'.$r['options']['ukuran_lm'].'</td>
				<td style="padding:6px;text-align:center">'.number_format($r['options']['isi_lm'],0,",",".").'</td>
				<td style="padding:6px;text-align:right">'.$qty.'</td>
				<td style="padding:6px;text-align:right">'.number_format($r['options']['order_sheet'],0,",",".").'</td>
				<td style="padding:6px;text-align:right">'.$order_pack.'</td>
				<td style="padding:6px;text-align:right">'.$order_ikat.'</td>
				<td style="padding:6px;text-align:right">'.$qty_bal.'</td>
				<td style="padding:6px;text-align:right">'.round($r['options']['harga_lembar'],2).'</td>
				<td style="padding:6px;text-align:right">'.$harga_pack.'</td>
				<td style="padding:6px;text-align:right">'.$harga_ikat.'</td>
				<td style="padding:6px;text-align:right">'.number_format($r['options']['harga_total'],0,",",".").'</td>
				<td style="padding:6px;text-align:center">
					<button class="btn btn-danger btn-xs" onclick="hapusCartLaminasi('."'".$r['rowid']."'".')"><i class="fas fa-times"></i> BATAL</button>
				</td>
			</tr>';
		}

		if($this->cart->total_items() != 0){
			$html .= '</table>';
			$html .= '<div>
				<button class="btn btn-primary btn-sm" onclick="simpanCartLaminasi()"><i class="fas fa-save"></i> <b>SIMPAN</b></button>
			</div>';
		}

		echo $html;
	}

	function hapusCartLaminasi()
	{
		$data = array(
			'rowid' => $_POST['rowid'],
			'qty' => 0,
		);
		$this->cart->update($data);
	}

	function simpanCartLaminasi()
	{
		$result = $this->m_transaksi->simpanCartLaminasi();
		echo json_encode($result);
	}

	function editListLaminasi()
	{
		$result = $this->m_transaksi->editListLaminasi();
		echo json_encode($result);
	}

	function btnVerifLaminasi()
	{
		$result = $this->m_transaksi->btnVerifLaminasi();
		echo json_encode($result);
	}

	function bukaAccPOLam()
	{
		$result = $this->m_transaksi->bukaAccPOLam();
		echo json_encode($result);
	}

	function btnDiscPOLM()
	{
		$result = $this->m_transaksi->btnDiscPOLM();
		echo json_encode($result);
	}

	function hapusDiscPOLM()
	{
		$result = $this->m_transaksi->hapusDiscPOLM();
		echo json_encode($result);
	}

	function editPOLaminasi()
	{
		$id = $_POST["id"];
		$id_dtl = $_POST["id_dtl"];
		$opsi = $_POST["opsi"];

		$po_lm = $this->db->query("SELECT*FROM trs_po_lm WHERE id='$id'")->row();
		$po_dtl = $this->db->query("SELECT*FROM trs_po_lm_detail d INNER JOIN m_produk_lm p ON d.id_m_produk_lm=p.id_produk_lm WHERE d.no_po_lm='$po_lm->no_po_lm'");
		($id != 0 && $id_dtl != 0 ) ? $e_po_dtl = $this->db->query("SELECT*FROM trs_po_lm_detail d INNER JOIN m_produk_lm p ON d.id_m_produk_lm=p.id_produk_lm WHERE d.id='$id_dtl'")->row() : $e_po_dtl = '';

		if($po_lm->jenis_lm == "PEKALONGAN"){
			$ketKop = '<th style="padding:6px;text-align:center">H. PACK</th>
			<th style="padding:6px;text-align:center">H. IKAT</th>';
		}else{
			$ketKop = '<th style="padding:6px;text-align:center">HARGA</th>';
		}
		$html ='';
		$html .='<table class="table table-bordered table-striped" style="margin:0 0 12px">
			<thead>
				<tr>
					<th style="padding:6px;text-align:center">NO.</th>
					<th style="padding:6px" colspan="6">DESKRIPSI</th>
					<th style="padding:6px;text-align:center">QTY</th>
					<th style="padding:6px;text-align:center">H. LEMBAR</th>
					'.$ketKop.'
					<th style="padding:6px;text-align:center">JUMLAH</th>
					<th style="padding:6px;text-align:center">AKSI</th>
				</tr>
			</thead>';
			$i = 0;
			$subTotal = 0;
			foreach($po_dtl->result() as $r){
				$i++;
				$edit = '<button class="btn btn-warning btn-xs" onclick="editPOLaminasi('."'".$po_lm->id."'".','."'".$r->id."'".','."'edit'".')"><i class="fas fa-edit"></i> EDIT</button>';
				$hapus = '<button class="btn btn-danger btn-xs" onclick="hapusPOLaminasi('."'".$po_lm->id."'".','."'".$r->id."'".','."'trs_po_lm_detail'".')"><i class="fas fa-times"></i> HAPUS</button>';
				if($id_dtl == $r->id){
					$btnAksi = '-';
				}else if($po_dtl->num_rows() == 1){
					($opsi == 'edit') ? $btnAksi = $edit : $btnAksi = '-';
				}else{
					($opsi == 'edit') ? $btnAksi = $edit.' '.$hapus : $btnAksi = '-';
				}
				($id_dtl == $r->id) ? $bold = ';font-weight:bold;background:#ffd700' : $bold = '';
				if($r->jenis_qty_lm == 'pack'){
					$ket0 = '@BAL';
					$ket = '( PACK )';
					$qty = number_format($r->pack_lm,0,',','.');
				}else if($r->jenis_qty_lm == 'ikat'){
					$ket0 = '@IKAT';
					$ket = '( PACK )';
					$qty = number_format($r->ikat_lm,0,',','.');
				}else{
					$ket0 = '@KG';
					$ket = '( KG )';
					$qty = $r->kg_lm;
				}
				($r->jenis_qty_lm == 'kg') ? $order_pori_lm = $r->order_pori_lm : $order_pori_lm = number_format($r->order_pori_lm,0,",",".");
				($r->jenis_qty_lm == 'kg') ? $qty_bal = $r->qty_bal : $qty_bal = number_format($r->qty_bal,0,",",".");
				if($r->jenis_qty_lm == 'kg'){
					$ton = 0;
					$bb = 0;
				}else{
					($r->jenis_qty_lm == 'ikat') ? $ton = $r->qty_bal * 7 : $ton = $r->qty_bal * 50;
					$bb = round($ton / 0.75);
				}
				//
				if($po_lm->jenis_lm == "PEKALONGAN"){
					$ket1 = '<tr><td style="border:0;padding:6px;font-weight:bold">IKAT</td></tr>
					<tr><td style="border:0;padding:6px;font-weight:bold">PACK</td></tr>';
					$ket2 = '<tr><td style="border:0;padding:6px 3px;font-weight:bold">:</td></tr>
					<tr><td style="border:0;padding:6px 3px;font-weight:bold">:</td></tr>';
					$isi1 = '<tr><td style="border:0;padding:6px">'.$r->ikat_x.'</td></tr>
					<tr><td style="border:0;padding:6px">'.$r->pack_x.'</td></tr>
					<tr><td style="border:0;padding:6px">'.$qty.' ( PACK )</td></tr>';
					$ket3 = '<tr><td style="border:0;padding:6px;font-weight:bold">ORDER PACK</td></tr>
					<tr><td style="border:0;padding:6px;font-weight:bold">ORDER IKAT</td></tr>';
					$ket4 = '';
					$isi3 = '<tr><td style="border:0;padding:6px">'.number_format($r->order_pack_lm,0,",",".").'</td></tr>
					<tr><td style="border:0;padding:6px">'.number_format($r->order_ikat_lm,0,",",".").'</td></tr>';
					$harga1 = '<td style="padding:6px;text-align:right'.$bold.'">'.number_format($r->harga_pack_lm,0,",",".").'</td>
					<td style="padding:6px;text-align:right'.$bold.'">'.number_format($r->harga_ikat_lm,0,",",".").'</td>';
				}else{
					$ket1 = '';
					$ket2 = '';
					$ket4 = '<tr><td style="border:0;padding:6px 3px;font-weight:bold">:</td></tr>';
					$isi1 = '<tr><td style="border:0;padding:6px">'.$qty.' '.$ket.'</td></tr>';
					$ket3 = '<tr><td style="border:0;padding:6px;font-weight:bold">ORDER</td></tr>';
					$isi3 = '<tr><td style="border:0;padding:6px">'.$order_pori_lm.' '.$ket.'</td></tr>';
					$harga1 = '<td style="padding:6px;text-align:right'.$bold.'">'.number_format($r->harga_pori_lm,0,",",".").'  '.$ket.'</td>';
				}
				$html .='<tr>
					<td style="padding:6px;text-align:center'.$bold.'">'.$i.'</td>
					<td style="padding:0;border:0'.$bold.'">
						<table class="table" style="margin:0">
							<tr><td style="border:0;padding:6px;font-weight:bold">ITEM</td></tr>
							<tr><td style="border:0;padding:6px;font-weight:bold">SIZE</td></tr>
							<tr><td style="border:0;padding:6px;font-weight:bold">ISI</td></tr>
							'.$ket1.'
							<tr><td style="border:0;padding:6px;font-weight:bold">'.$ket0.'</td></tr>
						</table>
					</td>
					<td style="padding:0;border:0'.$bold.'">
						<table class="table" style="margin:0">
							<tr><td style="border:0;padding:6px 3px;font-weight:bold">:</td></tr>
							<tr><td style="border:0;padding:6px 3px;font-weight:bold">:</td></tr>
							<tr><td style="border:0;padding:6px 3px;font-weight:bold">:</td></tr>
							'.$ket2.'
							<tr><td style="border:0;padding:6px 3px;font-weight:bold">:</td></tr>
						</table>
					</td>
					<td style="padding:0;border:0'.$bold.'">
						<table class="table" style="margin:0">
							<tr><td style="border:0;padding:6px">'.$r->nm_produk_lm.'</td></tr>
							<tr><td style="border:0;padding:6px">'.$r->ukuran_lm.'</td></tr>
							<tr><td style="border:0;padding:6px">'.number_format($r->isi_lm,0,",",".").' ( LEMBAR )</td></tr>
							'.$isi1.'
						</table>
					</td>
					<td style="padding:0;border:0'.$bold.'">
						<table class="table" style="margin:0">
							<tr><td style="border:0;padding:6px;font-weight:bold">ORDER LEMBAR</td></tr>
							'.$ket3.'
							<tr><td style="border:0;padding:6px;font-weight:bold">TON</td></tr>
							<tr><td style="border:0;padding:6px;font-weight:bold">BAHAN BAKU</td></tr>
						</table>
					</td>
					<td style="padding:0;border:0'.$bold.'">
						<table class="table" style="margin:0">
							<tr><td style="border:0;padding:6px 3px;font-weight:bold">:</td></tr>
							'.$ket2.'
							<tr><td style="border:0;padding:6px 3px;font-weight:bold">:</td></tr>
							<tr><td style="border:0;padding:6px 3px;font-weight:bold">:</td></tr>
							'.$ket4.'
						</table>
					</td>
					<td style="padding:0;border:0'.$bold.'">
						<table class="table" style="margin:0">
							<tr><td style="border:0;padding:6px">'.number_format($r->order_sheet_lm,0,",",".").'</td></tr>
							'.$isi3.'
							<tr><td style="border:0;padding:6px">'.number_format($ton,0,",",".").'</td></tr>
							<tr><td style="border:0;padding:6px">'.number_format($bb,0,",",".").'</td></tr>
						</table>
					</td>
					<td style="padding:6px;text-align:center'.$bold.'">'.$qty_bal.'</td>
					<td style="padding:6px;text-align:right'.$bold.'">'.round($r->harga_lembar_lm,2).'</td>
					'.$harga1.'
					<td style="padding:6px;text-align:right'.$bold.'">'.number_format($r->harga_total_lm,0,",",".").'</td>
					<td style="padding:6px;text-align:center'.$bold.'">'.$btnAksi.'</td>
				</tr>';
				// KOSONG
				if($po_dtl->num_rows() != $i){
					$html .='<tr>
						<td colspan="12" style="padding:3px"></td>
					</tr>';
				}
				$subTotal += $r->harga_total_lm;
			}
			// total
			if($po_lm->opsi_disc != ''){
				$xTotal = 'SUB TOTAL';
			}else{
				$xTotal = 'HARGA TOTAL';
			}
			if($po_dtl->num_rows() > 1 || $po_lm->opsi_disc != ''){
				$html .='<tr>
					<td colspan="12" style="padding:3px"></td>
				</tr>
				<tr>
					<td style="padding:6px;font-weight:bold;text-align:right" colspan="10">'.$xTotal.'</td>
					<td style="padding:6px;font-weight:bold;text-align:right">'.number_format($subTotal,0,',','.').'</td>
					<td style="padding:6px"></td>
				</tr>';
			}
			// HAPUS
			if(in_array($this->session->userdata('level'), ['Admin', 'Laminasi']) && $opsi == 'edit' && $po_lm->jenis_lm == 'PPI' && $po_lm->status_lm2 != 'Y'){
				$hapus_disc = '<button class="btn btn-danger btn-xs" onclick="hapusDiscPOLM('."'".$po_lm->id."'".','."'".$po_lm->opsi_disc."'".')"><i class="fas fa-times"></i></button>';
			}else{
				$hapus_disc = '';
			}
			if($po_lm->opsi_disc == 'DISKON' || $po_lm->opsi_disc == 'FEE'){
				if($po_lm->opsi_disc == 'DISKON'){
					$df_lm = $po_lm->disc_lm;
				}
				if($po_lm->opsi_disc == 'FEE'){
					$df_lm = $po_lm->fee_lm;
				}
				// HITUNG
				$hitung_df = round(($subTotal * $df_lm) / 100);
				$fix_df = $subTotal - $hitung_df;
				$html .='<tr>
					<td colspan="12" style="padding:3px"></td>
				</tr>
				<tr>
					<td style="padding:6px;font-weight:bold;text-align:right" colspan="10">'.$po_lm->opsi_disc.' '.round($df_lm,2).' %</td>
					<td style="padding:6px;font-weight:bold;text-align:right">- '.number_format($hitung_df,0,',','.').'</td>
					<td style="padding:6px">'.$hapus_disc.'</td>
				</tr>
				<tr>
					<td colspan="12" style="padding:3px"></td>
				</tr>
				<tr>
					<td style="padding:6px;font-weight:bold;text-align:right" colspan="10">GRAND TOTAL</td>
					<td style="padding:6px;font-weight:bold;text-align:right">'.number_format($fix_df,0,',','.').'</td>
					<td style="padding:6px"></td>
				</tr>';
			}
			if($po_lm->opsi_disc == 'DISKONFEE'){
				// HITUNG
				$hitung_d = round(($subTotal * $po_lm->disc_lm) / 100);
				$fix_d = $subTotal - $hitung_d;
				$hitung_f = round((($subTotal - $hitung_d) * $po_lm->fee_lm) / 100);
				$fix_a = $subTotal - ($hitung_d + $hitung_f);
				$html .='<tr>
					<td colspan="12" style="padding:3px"></td>
				</tr>
				<tr>
					<td style="padding:6px;font-weight:bold;text-align:right" colspan="10">DISKON '.round($po_lm->disc_lm,2).' %</td>
					<td style="padding:6px;font-weight:bold;text-align:right">- '.number_format($hitung_d,0,',','.').'</td>
					<td style="padding:6px;font-weight:bold;text-align:center">'.number_format($fix_d,0,',','.').'</td>
				</tr>
				<tr>
					<td colspan="12" style="padding:3px"></td>
				</tr>
				<tr>
					<td style="padding:6px;font-weight:bold;text-align:right" colspan="10">FEE '.round($po_lm->fee_lm,2).' %</td>
					<td style="padding:6px;font-weight:bold;text-align:right">- '.number_format($hitung_f,0,',','.').'</td>
					<td style="padding:6px">'.$hapus_disc.'</td>
				</tr>
				<tr>
					<td colspan="12" style="padding:3px"></td>
				</tr>
				<tr>
					<td style="padding:6px;font-weight:bold;text-align:right" colspan="10">GRAND TOTAL</td>
					<td style="padding:6px;font-weight:bold;text-align:right">'.number_format($fix_a,0,',','.').'</td>
					<td style="padding:6px"></td>
				</tr>';
			}

		$html .= '</table>';

		if($po_lm->status_kirim == "Close" && $opsi == 'verif' && in_array($this->session->userdata('level'), ['Admin', 'Laminasi']) && $this->session->userdata('username') != 'usman'){
			$cekKiriman = $this->db->query("SELECT p.no_po_lm,d.id_m_produk_lm,(SELECT SUM(r.qty_muat) FROM m_rk_laminasi r WHERE r.id_m_produk_lm=d.id_m_produk_lm AND r.id_po_lm=p.id AND r.id_po_dtl=d.id) AS muat,d.qty_bal FROM trs_po_lm p
			INNER JOIN trs_po_lm_detail d ON p.no_po_lm=d.no_po_lm
			WHERE p.id='$id'
			AND (SELECT SUM(r.qty_muat) FROM m_rk_laminasi r WHERE r.id_m_produk_lm=d.id_m_produk_lm AND r.id_po_lm=p.id AND r.id_po_dtl=d.id) = d.qty_bal
			GROUP BY p.no_po_lm,d.id_m_produk_lm
			ORDER BY d.id");
			if($po_dtl->num_rows() != $cekKiriman->num_rows()){
				$aSS = '<button type="button" class="btn btn-warning" style="font-weight:bold" onclick="editSplitPO()">SPLIT PO</button>';
			}else{
				$aSS = '<button type="button" class="btn btn-secondary" style="font-weight:bold" disabled>SPLIT PO</button>';
			}
			$btnSpiltPO = '<div class="card-body row" style="padding:0 12px">
				<div class="col-md-3"></div>
				<div class="col-md-9">'.$aSS.'</div>
			</div>';
		}else{
			$btnSpiltPO = '';
		}
		echo json_encode([
			'po_lm' => $po_lm,
			'sub_total' => $subTotal,
			'add_time_po_lm' => substr($this->m_fungsi->getHariIni(($po_lm->edit_time == null) ? $po_lm->add_time : $po_lm->edit_time),0,3).', '.$this->m_fungsi->tglIndSkt(substr(($po_lm->edit_time == null) ? $po_lm->add_time : $po_lm->edit_time, 0,10)).' ( '.substr(($po_lm->edit_time == null) ? $po_lm->add_time : $po_lm->edit_time, 10,6).' )',
			'time_lm1' => ($po_lm->time_lm1 == null) ? '' :substr($this->m_fungsi->getHariIni($po_lm->time_lm1),0,3).', '.$this->m_fungsi->tglIndSkt(substr($po_lm->time_lm1, 0,10)).' ( '.substr($po_lm->time_lm1, 10,6).' )',
			'time_lm2' => ($po_lm->time_lm2 == null) ? '' :substr($this->m_fungsi->getHariIni($po_lm->time_lm2),0,3).', '.$this->m_fungsi->tglIndSkt(substr($po_lm->time_lm2, 0,10)).' ( '.substr($po_lm->time_lm2, 10,6).' )',
			'po_dtl' => $e_po_dtl,
			'html_dtl' => $html,
			'html_split_po' => $btnSpiltPO,
		]);
	}

	function editSplitPO()
	{
		$id_header = $_POST["id_po_header"];

		$po_lm = $this->db->query("SELECT*FROM trs_po_lm WHERE id='$id_header'")->row();
		$po_dtl = $this->db->query("SELECT*FROM trs_po_lm_detail d INNER JOIN m_produk_lm p ON d.id_m_produk_lm=p.id_produk_lm WHERE d.no_po_lm='$po_lm->no_po_lm'");
		$cekKiriman = $this->db->query("SELECT p.no_po_lm,d.id_m_produk_lm,(SELECT SUM(r.qty_muat) FROM m_rk_laminasi r WHERE r.id_m_produk_lm=d.id_m_produk_lm AND r.id_po_lm=p.id AND r.id_po_dtl=d.id) AS muat,d.qty_bal FROM trs_po_lm p INNER JOIN trs_po_lm_detail d ON p.no_po_lm=d.no_po_lm
		WHERE p.id='$id_header' AND (SELECT SUM(r.qty_muat) FROM m_rk_laminasi r WHERE r.id_m_produk_lm=d.id_m_produk_lm AND r.id_po_lm=p.id AND r.id_po_dtl=d.id) = d.qty_bal
		GROUP BY p.no_po_lm,d.id_m_produk_lm ORDER BY d.id");
		$ckNull = $this->db->query("SELECT d.* FROM trs_po_lm p INNER JOIN trs_po_lm_detail d ON p.no_po_lm=d.no_po_lm
		WHERE p.id='$id_header' AND (SELECT SUM(r.qty_muat) FROM m_rk_laminasi r WHERE r.id_m_produk_lm=d.id_m_produk_lm AND r.id_po_lm=p.id AND r.id_po_dtl=d.id) IS NULL
		GROUP BY p.no_po_lm,d.id_m_produk_lm ORDER BY d.id");
		$pelanggan_lm = $this->db->query("SELECT*FROM m_pelanggan_lm WHERE id_pelanggan_lm='$po_lm->id_pelanggan'")->row();

		// LIST PO
		$html = '';
		$html .= '<table class="table table-bordered" style="margin:0">
			<tr>
				<th style="background:#f2f2f2;border:1px solid #d1d1d1;padding:6px;text-align:center">#</th>
				<th style="background:#f2f2f2;border:1px solid #d1d1d1;padding:6px">ITEM</th>
				<th style="background:#f2f2f2;border:1px solid #d1d1d1;padding:6px;text-align:center">QTY PO</th>
				<th style="background:#f2f2f2;border:1px solid #d1d1d1;padding:6px;text-align:center">KIRIMAN</th>
				<th style="background:#f2f2f2;border:1px solid #d1d1d1;padding:6px;text-align:center">SISA PO</th>
			</tr>';
			$i0 = 0;
			foreach($po_dtl->result() as $r){
				$i0++;
				if($r->jenis_qty_lm == 'pack'){
					$ket = '';
				}else if($r->jenis_qty_lm == 'ikat'){
					$ket = '<span style="font-size:11px;vertical-align:top;font-style:italic">( IKAT )</span>';
				}else{
					$ket = '<span style="font-size:11px;vertical-align:top;font-style:italic">( KG )</span>';
				}
				($r->jenis_qty_lm == 'kg') ? $qty_bal = $r->qty_bal : $qty_bal = number_format($r->qty_bal,0,",",".");
				$kiriman = $this->db->query("SELECT SUM(qty_muat) AS qty_muat FROM m_rk_laminasi WHERE id_po_lm='$id_header' AND id_po_dtl='$r->id' AND rk_urut!='0' AND rk_status='Close'
				GROUP BY id_m_produk_lm,id_po_lm,id_po_dtl");
				($kiriman->num_rows() == 0) ? $muat = 0 : $muat = $kiriman->row()->qty_muat;
				($r->jenis_qty_lm == 'kg') ? $muat2 = round($muat,2) : $muat2 = number_format($muat,0,",",".");
				($r->jenis_qty_lm == 'kg') ? $sisa = $r->qty_bal - $muat : $sisa = number_format($r->qty_bal - $muat,0,",",".");
				// SISA
				if($sisa == 0 && $muat != 0){
					$bg = 'background:#dee2e6;color:#333;border:1px solid #babec2;';
				}else if($sisa != 0 && $muat == 0){
					$bg = '';
				}else{
					$bg = 'font-weight:bold;';
				}
				// JIKA BELUM ADA KIRIMAN
				if($muat == 0){
					$bgr = ';background:#ffbdbd;color:#333;border:1px solid #c99999;';
				}else{
					$bgr = '';
				}
				$html .= '<tr>
					<td style="'.$bg.'padding:6px;text-align:center'.$bgr.'">'.$i0.'.</td>
					<td style="'.$bg.'padding:6px'.$bgr.'">'.$r->nm_produk_lm.' '.$ket.'</td>
					<td style="'.$bg.'padding:6px;text-align:right'.$bgr.'">'.$qty_bal.'</td>
					<td style="'.$bg.'padding:6px;text-align:right'.$bgr.'">'.$muat2.'</td>
					<td style="'.$bg.'padding:6px;text-align:right'.$bgr.'">'.$sisa.'</td>
				</tr>';
			}
		$html .= '</table>';
		
		// REVISI LIST PO SPLIT
		$htmlL = '';
		if($ckNull->num_rows() == $po_dtl->num_rows()){
			$htmlL .= '<div style="padding:0 6px;font-weight:bold;font-style:italic">KIRIMAN KOSONG!</div>';
		}else{
			$htmlL .= '<table class="table table-bordered" style="margin:0">
				<tr>
					<th style="background:#f2f2f2;border:1px solid #d1d1d1;padding:6px;text-align:center">#</th>
					<th style="background:#f2f2f2;border:1px solid #d1d1d1;padding:6px">ITEM</th>
					<th style="background:#f2f2f2;border:1px solid #d1d1d1;padding:6px;text-align:center">@BAL</th>
					<th style="background:#f2f2f2;border:1px solid #d1d1d1;padding:6px;text-align:center">ORDER</th>
					<th style="background:#f2f2f2;border:1px solid #d1d1d1;padding:6px;text-align:center">QTY PO</th>
					<th style="background:#f2f2f2;border:1px solid #d1d1d1;padding:6px;text-align:center">HARGA</th>
					<th style="background:#f2f2f2;border:1px solid #d1d1d1;padding:6px;text-align:center">TOTAL</th>
				</tr>';
				$i1 = 0;
				foreach($po_dtl->result() as $rl){
					if($rl->jenis_qty_lm == 'pack'){
						$l_ket = '';
						$l_qty = number_format($rl->pack_lm,0,',','.'); $l_qty_2 = $rl->pack_lm;
					}else if($rl->jenis_qty_lm == 'ikat'){
						$l_ket = '<span style="font-size:11px;vertical-align:top;font-style:italic">( IKAT )</span>';
						$l_qty = number_format($rl->ikat_lm,0,',','.'); $l_qty_2 = $rl->ikat_lm;
					}else{
						$l_ket = '<span style="font-size:11px;vertical-align:top;font-style:italic">( KG )</span>';
						$l_qty = $rl->kg_lm; $l_qty_2 = $rl->kg_lm;
					}
					$l_kiriman = $this->db->query("SELECT SUM(qty_muat) AS qty_muat FROM m_rk_laminasi WHERE id_po_lm='$id_header' AND id_po_dtl='$rl->id' AND rk_urut!='0' AND rk_status='Close'
					GROUP BY id_m_produk_lm,id_po_lm,id_po_dtl");
					($l_kiriman->num_rows() == 0) ? $l_muat = 0 : $l_muat = $l_kiriman->row()->qty_muat;
					($rl->jenis_qty_lm == 'kg') ? $l_muat2 = round($l_muat,2) : $l_muat2 = number_format($l_muat,0,",",".");
					// QTY PO
					$l_sisa2 = $rl->qty_bal - $l_muat;
					// TAMPIL JIKA MASIH ADA SISA PO
					if(($l_sisa2 != 0 || $l_sisa2 == 0) && $l_muat != 0){
						$i1++;
						// ORDER
						($rl->jenis_qty_lm == 'kg') ? $l_order = round($l_muat * $l_qty_2,2) : $l_order = number_format($l_muat * $l_qty_2,0,',','.');
						$l_order2 = $l_muat * $l_qty_2;
						// HARGA TOTAL
						$l_harga = $l_order2 * $rl->harga_pori_lm;
						($l_sisa2 == 0) ? $bgl = 'background:#dee2e6;color:#333;border:1px solid #babec2;' : $bgl = '';
						$htmlL .= '<tr>
							<td style="'.$bgl.'padding:6px;text-align:center">'.$i1.'.</td>
							<td style="'.$bgl.'padding:6px">'.$rl->nm_produk_lm.' '.$l_ket.'</td>
							<td style="'.$bgl.'padding:6px;text-align:right">'.$l_qty.'</td>
							<td style="'.$bgl.'padding:6px;text-align:right">'.$l_order.'</td>
							<td style="'.$bgl.'padding:6px;text-align:right">'.$l_muat2.'</td>
							<td style="'.$bgl.'padding:6px;text-align:right">'.number_format($rl->harga_pori_lm,0,',','.').'</td>
							<td style="'.$bgl.'padding:6px;text-align:right">'.number_format($l_harga,0,',','.').'</td>
						</tr>';
					}
				}
			$htmlL .= '</table>';
		}

		// BARU LIST PO SPLIT
		$htmlS = '';
		if($ckNull->num_rows() == $po_dtl->num_rows()){
			$htmlS .= '<div style="padding:0 6px;font-weight:bold;font-style:italic">KIRIMAN KOSONG!</div>';
		}else{
			$htmlS .= '<table class="table table-bordered" style="margin:0">
				<tr>
					<th style="background:#f2f2f2;border:1px solid #d1d1d1;padding:6px;text-align:center">#</th>
					<th style="background:#f2f2f2;border:1px solid #d1d1d1;padding:6px">ITEM</th>
					<th style="background:#f2f2f2;border:1px solid #d1d1d1;padding:6px;text-align:center">@BAL</th>
					<th style="background:#f2f2f2;border:1px solid #d1d1d1;padding:6px;text-align:center">ORDER</th>
					<th style="background:#f2f2f2;border:1px solid #d1d1d1;padding:6px;text-align:center">QTY PO</th>
					<th style="background:#f2f2f2;border:1px solid #d1d1d1;padding:6px;text-align:center">HARGA</th>
					<th style="background:#f2f2f2;border:1px solid #d1d1d1;padding:6px;text-align:center">TOTAL</th>
				</tr>';
				$i2 = 0;
				foreach($po_dtl->result() as $rs){
					if($rs->jenis_qty_lm == 'pack'){
						$s_ket = '';
						$s_qty = number_format($rs->pack_lm,0,',','.'); $s_qty_2 = $rs->pack_lm;
					}else if($rs->jenis_qty_lm == 'ikat'){
						$s_ket = '<span style="font-size:11px;vertical-align:top;font-style:italic">( IKAT )</span>';
						$s_qty = number_format($rs->ikat_lm,0,',','.'); $s_qty_2 = $rs->ikat_lm;
					}else{
						$s_ket = '<span style="font-size:11px;vertical-align:top;font-style:italic">( KG )</span>';
						$s_qty = $rs->kg_lm; $s_qty_2 = $rs->kg_lm;
					}
					$s_kiriman = $this->db->query("SELECT SUM(qty_muat) AS qty_muat FROM m_rk_laminasi WHERE id_po_lm='$id_header' AND id_po_dtl='$rs->id' AND rk_urut!='0' AND rk_status='Close'
					GROUP BY id_m_produk_lm,id_po_lm,id_po_dtl");
					($s_kiriman->num_rows() == 0) ? $s_muat = 0 : $s_muat = $s_kiriman->row()->qty_muat;
					// QTY PO
					$s_sisa2 = $rs->qty_bal - $s_muat;
					// TAMPIL JIKA MASIH ADA SISA PO
					if($s_sisa2 != 0){
						$i2++;
						// ORDER
						($rs->jenis_qty_lm == 'kg') ? $s_order = round($s_sisa2 * $s_qty_2,2) : $s_order = number_format($s_sisa2 * $s_qty_2,0,',','.');
						$s_order2 = $s_sisa2 * $s_qty_2;
						// HARGA TOTAL
						$s_harga = $s_order2 * $rs->harga_pori_lm;
						$htmlS .= '<tr>
							<td style="padding:6px;text-align:center">'.$i2.'.</td>
							<td style="padding:6px">'.$rs->nm_produk_lm.' '.$s_ket.'</td>
							<td style="padding:6px;text-align:right">'.$s_qty.'</td>
							<td style="padding:6px;text-align:right">'.$s_order.'</td>
							<td style="padding:6px;text-align:right">'.$s_sisa2.'</td>
							<td style="padding:6px;text-align:right">'.number_format($rs->harga_pori_lm,0,',','.').'</td>
							<td style="padding:6px;text-align:right">'.number_format($s_harga,0,',','.').'</td>
						</tr>';
					}
				}
			$htmlS .= '</table>';
		}

		// BUTTON KONFIRMASI SPLIT PO
		if($po_dtl->num_rows() != $cekKiriman->num_rows()){
			$btnAccSplit = '<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
				<div class="col-md-3"></div>
				<div class="col-md-9">
					<button type="button" class="btn btn-warning" style="font-weight:bold" onclick="konfirmasiSplitPO()">KONFIRMASI SPLIT PO</button>
				</div>
			</div>';
		}else{
			$btnAccSplit = '';
		}

		echo json_encode([
			'id_header' => $id_header,
			'po_lm' => $po_lm,
			'pelanggan_lm' => $pelanggan_lm,
			'html_list' => $html,
			'html_rlist' => $htmlL,
			'html_slist' => $htmlS,
			'btnAccSplit' => $btnAccSplit,
			'nr_poDtl' => $po_dtl->num_rows(),
			'nr_cekKiriman' => $cekKiriman->num_rows(),
		]);
	}

	function konfirmasiSplitPO()
	{
		$result = $this->m_transaksi->konfirmasiSplitPO();
		echo json_encode($result);
	}

	function editListPOLaminasi()
	{
		$id = $_POST["id"];
		$data = $this->db->query("SELECT*FROM trs_po_lm_detail WHERE id='$id'")->row();
		echo json_encode($data);
	}

	function cek_tonase_kosong()
	{
		

		$html ='';

		$query = $this->db->query("SELECT a.no_po,a.kode_po,b.id_sales ,c.nm_sales, (a.price_exc*a.qty)exclude, a.ton
		from trs_po_detail a 
		join m_pelanggan b ON a.id_pelanggan=b.id_pelanggan
		join m_sales c ON b.id_sales=c.id_sales
		join trs_po d ON a.kode_po=d.kode_po
		WHERE a.status <> 'Reject' and d.status_app3 not in ('H') and (a.ton ='' or ISNULL(a.ton) or a.ton=0)")->result();

		
		$i = 0;
		$total =0;
		$total_rata =0;
		if($query)
		{
		$html .='<div class="card-body row" style="padding-bottom:20px;font-weight:bold">';
		$html .='<div class="col-md-12">
		<a type="button" onclick="open_ket()"><span style="color:red">[ Ada Tonase PO Kosong <i style="color:#4e73df;" class="fas fa-info-circle" title="Cek Tonase"></i> ]</span></a>

		<br>
		</div>
		';
		$html .='<table class="table table-bordered table-striped">
		<thead class="color-tabel">
			<tr>
				<th style="text-align:center">NO</th>
				<th style="text-align:center">KODE PO</th>
				<th style="text-align:center">EXCLUDE</th>
				<th style="text-align:center">TONASE</th>
			</tr>
		</thead>';
			foreach($query as $r){
				$i++;
				$html .= '</tr>
					<td style="text-align:center">'.$i.'</td>
					<td style="text-align:left;color:red">'.$r->kode_po.'</td>
					<td style="text-align:right;color:red">'.number_format($r->exclude, 0, ",", ".").'</td>
					<td style="text-align:right;color:red" >'.number_format($r->ton, 0, ",", ".").'</td>
				</tr>';
			}
		
			$html .='</table> </div>';
		}else{
			$html .='';
		}

		echo $html;
		
	}
	
	function hitung_rekap()
	{
		
		$bulan    = $this->input->post('bulan');
		$jns      = $this->input->post('jns');

		if($jns=='po')
		{
			if($bulan)
			{
				$ket= "and a.tgl_po like '%$bulan%'";
			}else{
				$ket='';
			}

			$html ='';

			$query = $this->db->query("SELECT id_sales,nm_sales,sum(ton)ton ,sum(exclude)exc, (sum(exclude)/sum(ton))avg from(
			
			select a.no_po,b.id_sales ,c.nm_sales, (a.price_exc*a.qty)exclude, a.ton
			from trs_po_detail a 
			join m_pelanggan b ON a.id_pelanggan=b.id_pelanggan
			join m_sales c ON b.id_sales=c.id_sales
			join trs_po d ON a.kode_po=d.kode_po
			-- WHERE a.status <> 'Reject' and d.status_app3 not in ('H')
			WHERE d.status_app3='Y'
			$ket 
			)p group by id_sales,nm_sales")->result();

			$html .='<div class="card-body row" style="padding-bottom:20px;font-weight:bold">';
			$html .='<table class="table table-bordered table-striped">
			<thead class="color-tabel">
				<tr>
					<th style="text-align:center">NO</th>
					<th style="text-align:center">Nama Sales</th>
					<th style="text-align:center">Total PO</th>
					<th style="text-align:center">Harga Rata2 / Kg</th>
				</tr>
			</thead>';
			$i = 0;
			$total =0;
			$total_rata =0;
			if($query)
			{
				foreach($query as $r)
				{
					$i++;
					$html .= '</tr>
						<td style="text-align:center">'.$i.'</td>
						<td style="text-align:left">'.$r->nm_sales.'</td>
						<td style="text-align:right">'.number_format($r->ton, 0, ",", ".").'</td>
						<td style="text-align:right">'.number_format($r->avg, 0, ",", ".").'</td>
					</tr>';
					$total += $r->ton; 
					$total_rata += $r->exc;
				}
				$total_all = $total_rata/$total;
				
				$html .='<tr>
						<th style="text-align:center" colspan="2" >Total</th>
						<th style="text-align:right">'.number_format($total, 0, ",", ".").'</th>
						<th style="text-align:right">'.number_format($total_all, 0, ",", ".").'</th>
					</tr>
					';
				
				$html .='</table>
				</div>';
			}else{
				$html .='<tr>
					<th style="text-align:center" colspan="4" >Data Kosong</th>
				</tr>
				';
			
				$html .='</table></div>';
			}

		}else{

			if($bulan)
			{
				$ket= "WHERE r.rk_tgl like '%$bulan%'";
			}else{
				$ket='';
			}

			$html ='';

			$query = $this->db->query("SELECT p.id_sales,p.nm_sales,SUM(p.berat_bersih) AS ton FROM (
			SELECT r.*,d.id_sales,d.nm_sales,j.berat_bersih FROM m_rencana_kirim r
			INNER JOIN pl_box p ON r.rk_kode_po=p.no_po AND r.rk_urut=p.no_pl_urut AND r.id_pl_box=p.id
			INNER JOIN m_jembatan_timbang j ON j.tgl_t=p.tgl AND j.urut_t=p.no_pl_urut AND j.no_polisi=p.no_kendaraan
			INNER JOIN m_pelanggan c ON p.id_perusahaan=c.id_pelanggan
			INNER JOIN m_sales d ON c.id_sales=d.id_sales
			$ket
			GROUP BY r.rk_tgl,r.rk_urut
			
			)p GROUP BY p.id_sales,p.nm_sales")->result();

			$html .='<div class="card-body row" style="padding-bottom:20px;font-weight:bold">';
			$html .='<table class="table table-bordered table-striped">
			<thead class="color-tabel">
				<tr>
					<th style="text-align:center">NO</th>
					<th style="text-align:center">Nama Sales</th>
					<th style="text-align:center">Tonase Kirim</th>
				</tr>
			</thead>';
			$i             = 0;
			$total_ton     = 0;
			if($query)
			{
				foreach($query as $r)
				{
					$i++;
					$html .= '</tr>
						<td style="text-align:center">'.$i.'</td>
						<td style="text-align:left">'.$r->nm_sales.'</td>
						<td style="text-align:right">'.number_format($r->ton, 0, ",", ".").'</td>
					</tr>';
					$total_ton += $r->ton; 
				}
				
				$html .='<tr>
						<th style="text-align:center" colspan="2" >Total</th>
						<th style="text-align:right">'.number_format($total_ton, 0, ",", ".").'</th>
					</tr>
					';
				
				$html .='</table>
				</div>';
			}else{
				$html .='<tr>
					<th style="text-align:center" colspan="4" >Data Kosong</th>
				</tr>
				';
			
				$html .='</table></div>';
			}

		}
		

		echo $html;
		
	}
    
    function load_so()
    {

        $query = $this->db->query("SELECT * FROM trs_so_detail a
		INNER JOIN m_produk b ON a.id_produk=b.id_produk
		INNER JOIN m_pelanggan c ON a.id_pelanggan=c.id_pelanggan
		WHERE a.status='Open' AND a.eta_so IS NOT NULL AND a.add_user!='ppic' ")->result();

		if (!$query) {
			$response = [
				'message'	=> 'not found',
				'data'		=> [],
				'status'	=> false,
			];
		}else{
			$response = [
				'message'	=> 'Success',
				'data'		=> $query,
				'status'	=> true,
			];
		}
		$json = json_encode($response);
		print_r($json);
    }
	
	function load_produk()
    {
        
		$pl = $this->input->post('idp');
		$kd = $this->input->post('kd');

        if($pl !='' && $kd ==''){
            $cek ="where no_customer = '$pl' ";
        }else if($pl =='' && $kd !=''){
            $cek ="where id_produk = '$kd' ";
        }else {
            $cek ="";
        }

        $query = $this->db->query("SELECT * FROM m_produk $cek order by id_produk ")->result();

            if (!$query) {
                $response = [
                    'message'	=> 'not found',
                    'data'		=> [],
                    'status'	=> false,
                ];
            }else{
                $response = [
                    'message'	=> 'Success',
                    'data'		=> $query,
                    'status'	=> true,
                ];
            }
            $json = json_encode($response);
            print_r($json);
    }
   
	function load_karet()
    {
        $query = $this->db->query("SELECT*FROM m_status_karet order by id_karet")->result();

            if (!$query) {
                $response = [
                    'message'	=> 'not found',
                    'data'		=> [],
                    'status'	=> false,
                ];
            }else{
                $response = [
                    'message'	=> 'Success',
                    'data'		=> $query,
                    'status'	=> true,
                ];
            }
            $json = json_encode($response);
            print_r($json);
    }

	function load_po_jual()
    {
		$blnn        = date("m");
		$blnn_min1   = $blnn - 7 ;

		$bln_ok1 = '';
		for($x=$blnn_min1;$x<$blnn;$x++) 
		{
			$bln_ok1 .= $x.',';
		}

		$bln_ok2 = $bln_ok1.$blnn;
		
        $query = $this->db->query("SELECT no_po_lm as kode from trs_po_lm
				-- where MONTH(tgl_lm) in ($bln_ok2)
				group by no_po_lm
				union ALL
				SELECT kode_po as kode FROM trs_po
				-- where MONTH(tgl_po) in ($bln_ok2)
				group by kode_po ")->result();

            if (!$query) {
                $response = [
                    'message'	=> 'not found',
                    'data'		=> [],
                    'status'	=> false,
                ];
            }else{
                $response = [
                    'message'	=> 'Success',
                    'data'		=> $query,
                    'status'	=> true,
                ];
            }
            $json = json_encode($response);
            print_r($json);
    }
	
    function load_produk_1()
    {
        
		$pl = $this->input->post('idp');
		$kd = $this->input->post('kd');

        if($pl !='' && $kd ==''){
            $cek ="where no_customer = '$pl' ";
        }else if($pl =='' && $kd !=''){
            $cek ="where id_produk = '$kd' ";
        }else {
            $cek ="";
        }

        $query = $this->db->query("SELECT * FROM m_produk $cek order by id_produk ")->row();

        echo json_encode($query);
    }

	function load_hub()
    {
		$tgl_po   = $this->input->post('tgl_po');
		$tanggal  = explode('-',$tgl_po);
		$tahun    = $tanggal[0];

        $query = $this->db->query("SELECT a.*,4800000000-IFNULL((select sum(c.qty*price_inc)jum from trs_po b JOIN trs_po_detail c ON b.no_po=c.no_po where b.id_hub=a.id_hub and YEAR(b.tgl_po) in ('$tahun')
		group by b.id_hub ,YEAR(b.tgl_po)),0) sisa_hub FROM m_hub a
		order by id_hub")->result();

            if (!$query) {
                $response = [
                    'message'	=> 'not found',
                    'data'		=> [],
                    'status'	=> false,
                ];
            }else{
                $response = [
                    'message'	=> 'Success',
                    'data'		=> $query,
                    'status'	=> true,
                ];
            }
            $json = json_encode($response);
            print_r($json);
    }
    
	function cek_plan_sementara()
    {
        
		$no_po        = $this->input->post('no_po');
		$id_produk    = $this->input->post('id_produk');

        $query = $this->db->query("SELECT * FROM plan_cor_sementara WHERE no_po = '$no_po 'and id_produk = '$id_produk' ")->num_rows();

        echo json_encode($query);
    }
	
	function plan_sementara()
    {
        
		$no_po        = $this->input->post('no_po');
		$id_produk    = $this->input->post('id_produk');

        $query = $this->db->query("SELECT * FROM plan_cor_sementara a 
		JOIN m_produk b ON a.id_produk=b.id_produk 
		WHERE a.no_po = '$no_po 'and a.id_produk = '$id_produk' ")->row();

        echo json_encode($query);
    }

    function set_ukuran()
    {
        
		$fl       = $this->input->post('fl');
        $query    = $this->db->query("SELECT * FROM m_scoring where jenis_flute    = '$fl' ")->row();

        echo json_encode($query);
    }

    function cek_kode()
    {
        $kode_po    = $this->input->post('kode_po');
        $query      = $this->db->query("SELECT count(*)jum FROM trs_po where kode_po    = '$kode_po' ")->row();

        echo json_encode($query);
    }


	public function SO()
	{
		$data = array(
			'judul' => "Sales Order",
			'getPO' => $this->db->query("SELECT * FROM trs_po WHERE Status = 'Approve' order by id")->result(),
			// 'getNoPO' => "PO-".date('Y')."-"."000000". $this->m_master->get_data_max("trs_po","no_po")
		);

		$this->load->view('header', $data);
		$this->load->view('Transaksi/v_so', $data);
		$this->load->view('footer');
	}

	public function WO()
	{
		$data = array(
			'judul' => "Work Order",
			'getSO' => $this->db->query("SELECT b.nm_produk,c.*,a.* 
            FROM trs_so_detail a
            JOIN m_produk b ON a.id_produk=b.id_produk
            JOIN m_pelanggan c ON a.id_pelanggan=c.id_pelanggan
            WHERE status='Open' ")->result(),
		);


		$this->load->view('header', $data);
		$this->load->view('Transaksi/v_wo', $data);
		$this->load->view('footer');
	}

	public function SuratJalan()
	{
		$data = array(
			'judul' => "Surat Jalan",
			'getPO' => $this->db->query("SELECT
                                                      a.no_po
                                                    FROM
                                                      trs_po_detail a
                                                      LEFT JOIN
                                                        (SELECT
                                                          no_po,
                                                          kode_mc,
                                                          SUM(qty) AS qty_sj
                                                        FROM
                                                          `trs_surat_jalan`
                                                        WHERE STATUS <> 'Batal'
                                                        GROUP BY no_po,
                                                          kode_mc) AS t_sj
                                                        ON a.`no_po` = t_sj.no_po
                                                        AND a.kode_mc = t_sj.kode_mc
                                                        WHERE  (a.qty - IFNULL(qty_sj,0)) <> 0
                                                        GROUP BY no_po")->result(),
			// 'getNoPO' => "PO-".date('Y')."-"."000000". $this->m_master->get_data_max("trs_po","no_po")
		);


		$this->load->view('header', $data);
		$this->load->view('Transaksi/v_surat_jalan', $data);
		$this->load->view('footer');
	}

	function getMax()
	{
		$table  = $this->input->post('table');
		$fieald = $this->input->post('fieald');

		$data = [
			'no'       => $this->m_master->get_data_max($table, $fieald),
			'bln'      => $this->m_master->get_romawi(date('m')),
			'tahun'    => date('Y')
		];
		echo json_encode($data);
	}

	function Insert()
	{

		$jenis    = $this->input->post('jenis');
		$status   = $this->input->post('status');

		$result   = $this->m_transaksi->$jenis($jenis, $status);
		echo json_encode($result);
	}

	function update_plan()
	{
		$jenis    = $this->input->post('jenis');
		$status   = $this->input->post('status');
		$result   = $this->m_transaksi->update_plan($jenis, $status);
		echo json_encode($result);
	}

	function updateAddTimePO()
	{
		$result = $this->m_transaksi->updateAddTimePO();
		echo json_encode($result);
	}

	function nonAktifPO()
	{
		$result = $this->m_transaksi->nonAktifPO();
		echo json_encode($result);
	}

	function load_data()
	{
		$jenis        = $this->uri->segment(3);
		$data         = array();

		if ($jenis == "po") {
			$level   = $this->session->userdata('level');
			$nm_user = $this->session->userdata('nm_user');
			if($level =='Hub') {
				$cek     = $this->db->query("SELECT*FROM m_hub where nm_hub='$nm_user' ")->row();
				$cek_data = "WHERE status_app3 in ('Y') and id_hub in ('$cek->id_hub')";
			}else{
				$id_sales = $this->session->userdata('id_sales');
				if($id_sales == "" || $id_sales == null){
					$cek_data = "";
				}else{
					$cek_data = "WHERE id_sales='$id_sales'";
				}
			}

			$query = $this->m_master->query("SELECT a.*,b.*,a.add_time as time_input FROM trs_po a join m_pelanggan b on a.id_pelanggan=b.id_pelanggan $cek_data order by a.tgl_po desc, id desc")->result();
			$i = 1;
			foreach ($query as $r) {
				$row        = array();
				$time       = substr($r->tgl_po, 0,10);
				$time_po    = substr($r->time_input, 10,6);
				// timer
				// $dateFormat           = "Y-m-d H:i:s";
				$expired              = strtotime($r->time_input) + (48*60*60) ;
				$actualDate           = time();
				$secondsDiff          = $expired - $actualDate;
				$days                 = floor($secondsDiff/60/60/24);
				$hours                = floor(($secondsDiff-($days*60*60*24))/60/60);
				$minutes              = floor(($secondsDiff-($days*60*60*24)-($hours*60*60))/60);
				$seconds              = floor(($secondsDiff-($days*60*60*24)-($hours*60*60))-($minutes*60));
				// $actualDateDisplay    = date($dateFormat, $actualDate);
				$expiredDisplay       = date("F d, Y H:i:s", $expired);

				($days == 0) ? $tDays = '' : $tDays = $days.' Day<br>';
				($hours == 0) ? $tHours = '' : $tHours = $hours.' Hrs<br>';
				($minutes == 0) ? $tMinutes = '' : $tMinutes = $minutes.' Mnt<br>';
				($seconds == 0) ? $tseconds = '' : $tseconds = $seconds.' Sec';
				($days == 0 && $hours == 0 && $minutes == 0) ? $waktu = $tseconds : $waktu = $tDays.$tHours.$tMinutes;
				// TIME MARKETING
				// onclick="countDownPO('."'".$r->id."'".')"
				$ketAlasan1 = '';
				$exp1 = '';
				if($r->status_app1=='N'){
					if($actualDate > $expired || $actualDate == $expired){
						$btn1       = 'btn-danger';
						$i1         = '<i class="fas fa-ban" style="color:#000"></i>';
						$alasan1    = '';
						$ketAlasan1 .= '<div style="color:#f00;font-weight:bold">EXPIRED</div>';
						$exp1 .= 'expired';
					}else{
						$btn1       = 'btn-warning';
						$i1         = '<i class="fas fa-lock"></i>';
						$alasan1    = '';
						$ketAlasan1 .= '<div style="color:#f00;font-weight:bold">'.$waktu.'</div>';
					}
				}else  if($r->status_app1=='H'){
					$btn1    = 'btn-danger';
					$i1      = '<i class="far fa-hand-paper"></i>';
					$alasan1 = $r->ket_acc1;
					($actualDate > $expired || $actualDate == $expired) ? $ketAlasan1 .= '<br><div style="color:#f00;font-weight:bold">EXPIRED</div>' : $ketAlasan1 .= '<br><div style="color:#f00;font-weight:bold">'.$waktu.'</div>';
				}else  if($r->status_app1=='R'){
					$btn1    = 'btn-danger';
					$i1      = '<i class="fas fa-times"></i>';
					$alasan1 = $r->ket_acc1;
					($actualDate > $expired || $actualDate == $expired) ? $ketAlasan1 .= '<br><div style="color:#f00;font-weight:bold">EXPIRED</div>' : $ketAlasan1 .= '<br><div style="color:#f00;font-weight:bold">'.$waktu.'</div>';
				}else{
					$btn1    = 'btn-success';
					$i1      = '<i class="fas fa-check-circle"></i>';
					$alasan1 = '';
				}
                // TIME PPIC
				$ketAlasan2 = '';
				$exp2 = '';
                if($r->status_app2=='N'){
					if($actualDate > $expired || $actualDate == $expired){
						$btn2       = 'btn-danger';
						$i2         = '<i class="fas fa-ban" style="color:#000"></i>';
						$alasan2    = '';
						$ketAlasan2 .= '<div style="color:#f00;font-weight:bold">EXPIRED</div>';
						$exp2 .= 'expired';
					}else{
						$btn2       = 'btn-warning';
						$i2         = '<i class="fas fa-lock"></i>';
						$alasan2    = '';
						$ketAlasan2 .= '<div style="color:#f00;font-weight:bold">'.$waktu.'</div>';
					}
                }else if($r->status_app2=='H'){
                    $btn2   = 'btn-danger';
                    $i2     = '<i class="far fa-hand-paper"></i>';
					$alasan2 = $r->ket_acc2;
					($actualDate > $expired || $actualDate == $expired) ? $ketAlasan2 .= '<br><div style="color:#f00;font-weight:bold">EXPIRED</div>' : $ketAlasan2 .= '<br><div style="color:#f00;font-weight:bold">'.$waktu.'</div>';
                }else if($r->status_app2=='R'){
                    $btn2   = 'btn-danger';
                    $i2     = '<i class="fas fa-times"></i>';
					$alasan2 = $r->ket_acc2;
					($actualDate > $expired || $actualDate == $expired) ? $ketAlasan2 .= '<br><div style="color:#f00;font-weight:bold">EXPIRED</div>' : $ketAlasan2 .= '<br><div style="color:#f00;font-weight:bold">'.$waktu.'</div>';
                }else{
                    $btn2   = 'btn-success';
                    $i2     = '<i class="fas fa-check-circle"></i>';
					$alasan2 = '';
                }
				// TIME HARGA
				$ketAlasan4 = '';
				$exp4 = '';
                if($r->status_app4=='N'){
					if($actualDate > $expired || $actualDate == $expired){
						$btn4       = 'btn-danger';
						$i4         = '<i class="fas fa-ban" style="color:#000"></i>';
						$alasan4    = '';
						$ketAlasan4 .= '<div style="color:#f00;font-weight:bold">EXPIRED</div>';
						$exp4 .= 'expired';
					}else{
						$btn4       = 'btn-warning';
						$i4         = '<i class="fas fa-lock"></i>';
						$alasan4    = '';
						$ketAlasan4 .= '<div style="color:#f00;font-weight:bold">'.$waktu.'</div>';
					}
                }else if($r->status_app4=='H'){
                    $btn4   = 'btn-danger';
                    $i4     = '<i class="far fa-hand-paper"></i>';
					$alasan4 = $r->ket_acc4;
					($actualDate > $expired || $actualDate == $expired) ? $ketAlasan4 .= '<br><div style="color:#f00;font-weight:bold">EXPIRED</div>' : $ketAlasan4 .= '<br><div style="color:#f00;font-weight:bold">'.$waktu.'</div>';
                }else if($r->status_app4=='R'){
                    $btn4   = 'btn-danger';
                    $i4     = '<i class="fas fa-times"></i>';
					$alasan4 = $r->ket_acc4;
					($actualDate > $expired || $actualDate == $expired) ? $ketAlasan4 .= '<br><div style="color:#f00;font-weight:bold">EXPIRED</div>' : $ketAlasan4 .= '<br><div style="color:#f00;font-weight:bold">'.$waktu.'</div>';
                }else{
                    $btn4   = 'btn-success';
                    $i4     = '<i class="fas fa-check-circle"></i>';
					$alasan4 = '';
                }
                
                if($r->status_app3=='N') {
                    $btn3   = 'btn-warning';
                    $i3     = '<i class="fas fa-lock"></i>';
					$alasan3 = '';
                }else if($r->status_app3=='H') {
                    $btn3   = 'btn-danger';
                    $i3     = '<i class="far fa-hand-paper"></i>';
					$alasan3 = $r->ket_acc3;
                }else if($r->status_app3=='R') {
                    $btn3   = 'btn-danger';
                    $i3     = '<i class="fas fa-times"></i>';
					$alasan3 = $r->ket_acc3;
                }else{
                    $btn3   = 'btn-success';
                    $i3     = '<i class="fas fa-check-circle"></i>';
					$alasan3 = '';
                }
                
                if($r->status == 'Open') {
                    $btn_s = 'btn-info';
					$cLink = '';
				}else if($r->status == 'Approve') {
					$btn_s = 'btn-success';
					$cLink = '';
                }else{
                    $btn_s = 'btn-danger';
					$cLink = 'style="color:#f00"';
                }

				$row[] = '<div class="text-center">'.$i.'</div>'; 
				if (in_array($this->session->userdata('level'), ['Admin', 'User'])) {
					$row[] = '<div class="text-center">
						<a href="javascript:void(0)" '.$cLink.' onclick="tampil_edit('."'".$r->id."'".', '."'detail'".')">'.$r->no_po.'<a>
						<div>'.$this->m_fungsi->tanggal_ind($time).' <br> ('.$time_po.' )</div>
					</div>';
				}else{
					$row[] = '<div class="text-center">
						<a href="javascript:void(0)" '.$cLink.' onclick="preview('."'".$r->id."'".', '."'detail'".')">'.$r->no_po.'<a>
						<div>'.$this->m_fungsi->tanggal_ind($time).' <br> ('.$time_po.' )</div>
					</div>';
				}
				// $row[] = '<div class="text-center">'.$this->m_fungsi->tanggal_ind($time).' <br> ('.$time_po.' )</div>';
				$result_po = $this->db->query("SELECT nm_produk from trs_po_detail a join m_produk b ON a.id_produk=b.id_produk where no_po='$r->no_po'
				GROUP BY a.id_produk ORDER BY a.id");
				if($result_po->num_rows() == '1'){
					(strlen($result_po->row()->nm_produk) >= 35) ? $sTy = 'style="width:260px;white-space:normal"' : $sTy = '';
					$nm_item = '<div '.$sTy.'>'.$result_po->row()->nm_produk.'</div>';
				}else{
					$nm_item_result = ''; $no = 0;
					foreach($result_po->result() as $row_po){
						(strlen($row_po->nm_produk) >= 35) ? $sTf = 'style="width:260px;white-space:normal"' : $sTf = '';
						$no++;
						$nm_item_result .= '<div '.$sTf.'><b>'.$no.'.</b> '.$row_po->nm_produk.'</div>';
					}
					$nm_item = $nm_item_result;
				}

				($r->attn == '-' || $r->attn == '') ? $attn = '' : $attn = '( '.$r->attn.' )';
				(strlen($r->nm_pelanggan) >= 40) ? $sTc = 'style="width:260px;white-space:normal"' : $sTc = '';
				$row[] = '<div '.$sTc.'>'.$r->nm_pelanggan.'</div>'.$attn;
				$row[] = $r->kode_po;
				$row[] = $nm_item;
				$row_karet = $this->db->query("SELECT *FROM m_status_karet where status='$r->status_karet' ")->row();
				$row[] = '<div class="text-center">
					<div style="margin-bottom:3px"><button type="button" class="btn btn-sm '.$btn_s.'">'.$r->status.'</button></div>
					<button type="button" class="btn btn-sm '.$row_karet->btn_class.'">'.$row_karet->ket.'</button>
				</div>';
				// ADMIN
				if(in_array($this->session->userdata('level'), ['Admin', 'User'])){
					$uAddTime = 'onclick="updateAddTimePO('."'".$r->id."'".')"';
				}else{
					$uAddTime = '';
				}
				$row[] = '<div class="text-center">
					<input type="hidden" id="time_actualDate-'.$r->id.'" value="'.$actualDate.'">
					<input type="hidden" id="time_expired-'.$r->id.'" value="'.$expired.'">
					<input type="hidden" id="statusMarketing-'.$r->id.'" value="'.$r->status_app1.'">
					<input type="hidden" id="statusPPIC-'.$r->id.'" value="'.$r->status_app2.'">
					<input type="hidden" id="tanggalExpired-'.$r->id.'" value="'.$expiredDisplay.'">
					<button type="button" title="OKE" style="text-align:center" class="btn btn-sm btn-success" '.$uAddTime.'><i class="fas fa-check-circle"></i></button><br><b>
					'.$this->m_fungsi->tanggal_ind($time).' <br> ('.$time_po.' )</b></div>
				';
				$time1 = (($r->time_app1 == null) ? 'BELUM ACC' : $this->m_fungsi->tanggal_format_indonesia(substr($r->time_app1,0,10))  . ' - ' .substr($r->time_app1,10,9));
                $time2 = (($r->time_app2 == null) ? 'BELUM ACC' : $this->m_fungsi->tanggal_format_indonesia(substr($r->time_app2,0,10))  . ' - ' .substr($r->time_app2,10,9));
                $time3 = (($r->time_app3 == null) ? 'BELUM ACC' : $this->m_fungsi->tanggal_format_indonesia(substr($r->time_app3,0,10))  . ' - ' .substr($r->time_app3,10,9));
                $time4 = (($r->time_app4 == null) ? 'BELUM ACC' : $this->m_fungsi->tanggal_format_indonesia(substr($r->time_app4,0,10))  . ' - ' .substr($r->time_app4,10,9));
				// HARGA
				(strlen($alasan4) >= 35) ? $spn4 = 'style="width:200px;white-space:normal"' : $spn4 = '';
				$row[] = '<div class="text-center" '.$spn4.'>
					<button onclick="data_sementara(`HARGA`, '."'".$r->status_app4."'".', '."'".$time4."'".', '."'".$alasan4."'".', '."'".$r->no_po."'".', '."'".$exp4."'".')" type="button" title="'.$time4.'"  style="text-align:center" class="btn btn-sm '.$btn4.'" id="btnBase2-'.$r->id.'">'.$i4.'</button><br>
					'.$alasan4.''.$ketAlasan4.'
				</div>';
				// MARKETING
				(strlen($alasan1) >= 35) ? $spn1 = 'style="width:200px;white-space:normal"' : $spn1 = '';
				$row[] = '<div class="text-center" '.$spn1.'>
					<button onclick="data_sementara(`Marketing`, '."'".$r->status_app1."'".', '."'".$time1."'".', '."'".$alasan1."'".', '."'".$r->no_po."'".', '."'".$exp1."'".')" type="button" title="'.$time1.'" style="text-align:center" class="btn btn-sm '.$btn1.'" id="btnBase1-'.$r->id.'">'.$i1.'</button><br>
					'.$alasan1.''.$ketAlasan1.'
				</div>';
				// PPIC
				(strlen($alasan2) >= 35) ? $spn2 = 'style="width:200px;white-space:normal"' : $spn2 = '';
                $row[] = '<div class="text-center" '.$spn2.'>
					<button onclick="data_sementara(`PPIC`, '."'".$r->status_app2."'".', '."'".$time2."'".', '."'".$alasan2."'".', '."'".$r->no_po."'".', '."'".$exp2."'".')" type="button" title="'.$time2.'"  style="text-align:center" class="btn btn-sm '.$btn2.'" id="btnBase2-'.$r->id.'">'.$i2.'</button><br>
					'.$alasan2.''.$ketAlasan2.'
				</div>';
				// OWNER
				(strlen($alasan3) >= 35) ? $spn3 = 'style="width:200px;white-space:normal"' : $spn3 = '';
                $row[] = '<div class="text-center" '.$spn3.'>
					<button onclick="data_sementara(`Owner`, '."'".$r->status_app3."'".', '."'".$time3."'".', '."'".$alasan3."'".', '."'".$r->no_po."'".', 0)"  type="button" title="'.$time3.'"  style="text-align:center" class="btn btn-sm '.$btn3.'">'.$i3.'</button><br>
					'.$alasan3.'
				</div>';

                $aksi = '';
				if (!in_array($this->session->userdata('level'), ['Admin', 'konsul_keu', 'Marketing', 'PPIC', 'Owner', 'AP'])) {
					if($this->session->userdata('level') == 'User' && $r->status == 'Open') {
						$aksi .= '
							<div style="margin-bottom:3px">
								<button type="button" onclick="preview('."'".$r->id."'".','."'edit'".')" title="EDIT" class="btn btn-info btn-sm">
									<i class="fa fa-edit"></i>
								</button>
								<button type="button" title="DELETE"  onclick="deleteData('."'".$r->id."'".','."'".$r->no_po."'".')" class="btn btn-secondary btn-sm">
									<i class="fa fa-trash-alt"></i>
								</button>
								<button type="button" title="NON AKTIF"  onclick="nonAktifPO('."'".$r->id."'".')" class="btn btn-sm btn-warning">
									<i class="fas fa-power-off"></i>
								</button>
							</div>
							<a target="_blank" class="btn btn-sm btn-danger" href="'.base_url("Transaksi/Cetak_PO?no_po=".$r->no_po."").'" title="Cetak" ><i class="fas fa-print"></i> </a>
							<a target="_blank" class="btn btn-sm btn-success" href="'.base_url("Transaksi/Cetak_wa_po?no_po=".$r->no_po."").'" title="Format WA" ><b><i class="fab fa-whatsapp"></i> </b></a> 
							<a target="_blank" class="btn btn-sm btn-primary" href="'.base_url("Transaksi/Cetak_img_po?no_po=".$r->no_po."").'" title="Cetak Img" ><i class="fas fa-image"></i></a> 
						';
					}else{
						if(($r->aktif == 0 || $r->aktif == '0') && $this->session->userdata('level') == 'User'){
							$aksi .=  '<button type="button" title="AKTIF KAN LAGI"  onclick="nonAktifPO('."'".$r->id."'".')" class="btn btn-sm btn-primary">
								<i class="fas fa-power-off"></i>
							</button>';
						}else if($this->session->userdata('level') == 'User'){
							$aksi .=  '<button type="button" title="NON AKTIF"  onclick="nonAktifPO('."'".$r->id."'".')" class="btn btn-sm btn-warning">
								<i class="fas fa-power-off"></i>
							</button>';
						}
						$aksi .= '
							<a target="_blank" class="btn btn-sm btn-danger" href="'.base_url("Transaksi/Cetak_PO?no_po=".$r->no_po."").'" title="Cetak" ><i class="fas fa-print"></i> </a>
							<a target="_blank" class="btn btn-sm btn-success" href="'.base_url("Transaksi/Cetak_wa_po?no_po=".$r->no_po."").'" title="Format WA" ><b><i class="fab fa-whatsapp"></i> </b></a> 
							<a target="_blank" class="btn btn-sm btn-primary" href="'.base_url("Transaksi/Cetak_img_po?no_po=".$r->no_po."").'" title="Cetak Img" ><i class="fas fa-image"></i></a> 
						';
					}
				}else{
                    if ($this->session->userdata('level') == 'Admin' ) {
						if($r->status_app1 == 'N' || $r->status_app2 == 'N' || $r->status_app3 == 'N' || $r->status_app4 == 'N' || $r->status_app1 == 'H' || $r->status_app2 == 'H' || $r->status_app3 == 'H' || $r->status_app4 == 'H' || $r->status_app1 == 'R' || $r->status_app2 == 'R' || $r->status_app3 == 'R' || $r->status_app4 == 'R'){
							$aksi .=  '
								<div style="margin-bottom:3px">
									<button type="button" onclick="tampil_edit('."'".$r->id."'".','."'edit'".')" title="EDIT" class="btn btn-warning btn-sm">
										<i class="fa fa-edit"></i>
									</button>
									<button type="button" title="DELETE"  onclick="deleteData('."'".$r->no_po."'".','."'".$r->no_po."'".')" class="btn btn-secondary btn-sm">
										<i class="fa fa-trash-alt"></i>
									</button>  
									<button title="VERIFIKASI DATA" type="button" onclick="tampil_edit('."'".$r->id."'".','."'detail'".')" class="btn btn-info btn-sm">
										<i class="fa fa-check"></i>
									</button>
								</div>
								<a target="_blank" class="btn btn-sm btn-danger" href="'.base_url("Transaksi/Cetak_PO?no_po=".$r->no_po."").'" title="Cetak" ><i class="fas fa-print"></i> </a>
								<a target="_blank" class="btn btn-sm btn-success" href="'.base_url("Transaksi/Cetak_wa_po?no_po=".$r->no_po."").'" title="Format WA" ><b><i class="fab fa-whatsapp"></i> </b></a> 
							';
						}else{
							$aksi .=  '
								<a target="_blank" class="btn btn-sm btn-danger" href="'.base_url("Transaksi/Cetak_PO?no_po=".$r->no_po."").'" title="Cetak" ><i class="fas fa-print"></i> </a>
								<a target="_blank" class="btn btn-sm btn-success" href="'.base_url("Transaksi/Cetak_wa_po?no_po=".$r->no_po."").'" title="Format WA" ><b><i class="fab fa-whatsapp"></i> </b></a> 
							';
						}
						if($r->aktif == 0 || $r->aktif == '0'){
							$aksi .=  '<button type="button" title="AKTIF KAN LAGI"  onclick="nonAktifPO('."'".$r->id."'".')" class="btn btn-sm btn-primary">
								<i class="fas fa-power-off"></i>
							</button>';
						}else{
							$aksi .=  '<button type="button" title="NON AKTIF"  onclick="nonAktifPO('."'".$r->id."'".')" class="btn btn-sm btn-warning">
								<i class="fas fa-power-off"></i>
							</button>';
						}
					}else{
						if($r->aktif == 1 || $r->aktif == '1'){
							$aksi .=  '<button title="VERIFIKASI DATA" type="button" onclick="preview(' . "'" . $r->id . "'" . ',' . "'detail'" . ')" class="btn btn-info btn-sm">
								<i class="fa fa-check"></i>
							</button>';
						}else{
							$aksi .=  '<button title="VERIFIKASI DATA" type="button" class="btn btn-secondary btn-sm">
								<i class="fa fa-check"></i>
							</button>';
						}
					}
				}

				$row[] = '<div class="text-center">'.$aksi.'</div>';
				$data[] = $row;
				$i++;
			}
		} else if ($jenis == "po_bahan") {

			$id_hub    = $this->input->post('id_hub');
			if($id_hub)
			{
				$where_hub = "where id_hub in ('$id_hub') ";
			}else{
				$where_hub = "";
			}

			$query = $this->db->query("SELECT b.*,a.*,(select datang_bhn_bk from(select sum(datang_bhn_bk)datang_bhn_bk,no_po_bhn from trs_d_stok_bb group by no_po_bhn)c where c.no_po_bhn=a.no_po_bhn)datang
			FROM trs_po_bhnbk a 
			JOIN m_hub b ON a.hub=b.id_hub 
			$where_hub
			ORDER BY tgl_bhn desc,a.id_po_bhn")->result();

			$i               = 1;
			foreach ($query as $r) 
			{
				$id           = "'$r->id_po_bhn'";
				$no_po_bhn    = "'$r->no_po_bhn'";
				$no_po_bhn2   = "$r->no_po_bhn";
				
				$row = array();
				$row[] = '<div class="text-center">'.$i.'</div>';
				$row[] = '<div class="">'.$r->no_po_bhn.'</div>';
				$row[] = '<div class="">'.$r->tgl_bhn.'</div>';
				$row[] = '<div class="">'.$r->nm_hub.'</div>';
				$row[] = '<div class="text-center" style="color:#e92944"><b>'.number_format($r->ton_bhn, 0, ",", ".").'</b> Kg</div>';
				$row[] = '<div class="text-center" style="color:#e92944"><b>'.number_format($r->datang, 0, ",", ".").'</b> Kg</div>';
				$row[] = '<div class="text-center" style="color:#e92944"><b>'.number_format($r->ton_bhn-$r->datang, 0, ",", ".").'</b> Kg</div>';
				$row[] = '<div class="text-center">'.number_format($r->hrg_bhn, 0, ",", ".").'</div>';
				$row[] = '<div class="text-center">'.number_format($r->total, 0, ",", ".").'</div>';

				$aksi = "";

				if (in_array($this->session->userdata('level'), ['Admin','User']))
				{
					$cek = $this->db->query("SELECT * FROM trs_d_stok_bb where no_po_bhn='$r->no_po_bhn' ")->num_rows();

					if($cek>0)
					{
						$aksi = '				
						<a class="btn btn-sm btn-primary" onclick=edit_data(' . $id . ',' . $no_po_bhn . ',"preview") title="EDIT DATA" >
							<b><i class="fa fa-eye"></i> </b>
						</a> 
								
						<a target="_blank" class="btn btn-sm btn-danger" href="' . base_url("Transaksi/Cetak_PO_BAHAN?no_po_bhn=".$no_po_bhn2."") . '" title="Cetak" ><i class="fas fa-print"></i> </a>

						';

					}else{

						$aksi = '
						<a class="btn btn-sm btn-warning" onclick=edit_data(' . $id . ',' . $no_po_bhn . ',"editt") title="EDIT DATA" >
							<b><i class="fa fa-edit"></i> </b>
						</a> 
						
						<a target="_blank" class="btn btn-sm btn-danger" href="' . base_url("Transaksi/Cetak_PO_BAHAN?no_po_bhn=".$no_po_bhn2."") . '" title="Cetak" ><i class="fas fa-print"></i> </a>

						<button type="button" title="DELETE"  onclick="deleteData(' . $id . ',' . $no_po_bhn . ')" class="btn btn-secondary btn-sm">
							<i class="fa fa-trash-alt"></i>
						</button> 
						';

					}
					
			
				} else {
					$aksi = '';
				}
				$row[] = '<div class="text-center">'.$aksi.'</div>';
				$data[] = $row;

				$i++;
			}
		} else if ($jenis == "trs_so_detail") {
			$tahunn = $_POST["tahun"];
			$status_kiriman = $_POST["status_kiriman"];
			// if ($this->session->userdata('level') == "PPIC") {
			// 	$query = $this->db->query("SELECT d.id AS id_po_detail,p.kode_mc,d.no_so_p,d.tgl_so,p.nm_produk,d.status_so,COUNT(s.rpt) AS c_rpt,l.nm_pelanggan,l.attn,d.qty AS qty_po,s.* FROM trs_po_detail d
			// 	INNER JOIN trs_so_detail s ON d.no_po=s.no_po AND d.kode_po=s.kode_po AND d.no_so_p=s.no_so AND d.id_produk=s.id_produk
			// 	INNER JOIN m_produk p ON d.id_produk=p.id_produk
			// 	INNER JOIN m_pelanggan l ON d.id_pelanggan=l.id_pelanggan
			// 	WHERE d.no_so_p IS NOT NULL AND d.tgl_so_p LIKE '%$tahunn%' AND s.add_user='ppic'
			// 	GROUP BY d.id DESC")->result();
			// }else{
				$query = $this->db->query("SELECT d.id AS id_po_detail,p.kategori,p.kode_mc,d.tgl_so,p.nm_produk,d.status_so,COUNT(s.rpt) AS c_rpt,l.nm_pelanggan,l.attn,d.qty AS qty_po,s.* FROM trs_po_detail d
				INNER JOIN trs_po po ON po.no_po=d.no_po AND po.kode_po=d.kode_po
				INNER JOIN trs_so_detail s ON d.no_po=s.no_po AND d.kode_po=s.kode_po AND d.no_so=s.no_so AND d.id_produk=s.id_produk
				INNER JOIN m_produk p ON d.id_produk=p.id_produk
				INNER JOIN m_pelanggan l ON d.id_pelanggan=l.id_pelanggan
				WHERE d.no_so IS NOT NULL AND d.tgl_so IS NOT NULL AND d.status_so IS NOT NULL AND d.tgl_so LIKE '%$tahunn%' AND po.status_kiriman='$status_kiriman'
				GROUP BY d.id
				ORDER BY d.tgl_so DESC, d.id")->result();
			// }
			$i = 0;
			foreach ($query as $r) {
				$row = array();
				// if ($this->session->userdata('level') == "PPIC") {
				// 	$tP = $this->db->query("SELECT*FROM trs_so_detail WHERE no_po='$r->no_po' AND kode_po='$r->kode_po' AND id_produk='$r->id_produk' AND add_user='ppic' GROUP BY status_2 DESC,eta_so,id");
				// 	$tt = '';
				// 	foreach($tP->result() as $z){
				// 		($z->status_2 == "Close") ? $s2 = '<span class="bg-primary" style="vertical-align:top;font-weight:bold;border-radius:3px;padding:2px 4px;font-size:11px">DONE</span> ' : $s2 = '';
				// 		$tt .= $s2.$z->eta_so.'<br>';
				// 	}
				// 	$row[] = '<div class="text-center">'.$tt.'</div>';
				// }else{
					$i++;
					$row[] = '<div class="text-center"><a href="javascript:void(0)" onclick="tampilEditSO('."'".$r->id_po_detail."'".','."'".$r->no_po."'".','."'".$r->kode_po."'".','."'detail'".')">'.$i."<a></div>";
					$row[] = $this->m_fungsi->tglIndSkt($r->tgl_so);
				// }
				// $urut_so = str_pad($r->urut_so, 2, "0", STR_PAD_LEFT);
				($r->c_rpt == 1) ? $cpt = '' : $cpt = ' <span class="bg-dark" style="vertical-align:top;font-weight:bold;border-radius:3px;padding:2px 4px;font-size:11px">'.$r->c_rpt.'</span>';
				$row[] = $r->kode_po.$cpt;
				($r->kategori == 'K_BOX') ? $k = '' : $k = '[SHEET] ';
				$row[] = $k.$r->nm_produk;
				($r->attn == '-') ? $attn = '' : $attn = ' | '.$r->attn;
				$row[] = $r->nm_pelanggan.$attn;
				$row[] = '<div class="text-right"><b>'.number_format($r->qty_po).'</b></div>';
				// if($this->session->userdata('level') == "PPIC") {
				// 	$tt = '';
				// 	foreach($tP->result() as $z){
				// 		$qG = $this->db->query("SELECT*FROM trs_so_hasil WHERE id_so_dtl='$z->id'");
				// 		($qG->num_rows() == 0) ? $gg = '' : $gg = ' <span class="bg-dark" style="vertical-align:top;font-weight:bold;border-radius:3px;padding:2px 4px;font-size:11px">'.number_format($qG->row()->hasil_qty).'</span>';
				// 		($z->status_2 == "Close") ? $s2 = ' <span class="bg-primary" style="vertical-align:top;font-weight:bold;border-radius:3px;padding:2px 4px;font-size:11px"><i class="fas fa-check"></i></span>' : $s2 = '';
				// 		$tt .= number_format($z->qty_so).$gg.$s2.'<br>';
				// 	}
				// 	$row[] = '<div class="text-right">'.$tt.'</div>';
				// }
				if ($r->status_so == 'Open' || $r->no_so_p != null) {
					$aksi = '<button type="button" onclick="tampilEditSO('."'".$r->id_po_detail."'".','."'".$r->no_po."'".','."'".$r->kode_po."'".','."'edit'".')" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></button>';
				}else{
					$aksi = '-';
				}
				// PENGIRIMAN
				$kirim = $this->m_fungsi->kiriman($r->kode_po, $r->id_produk, $r->qty_po);
				$sumKirim = $kirim["sumKirim"];
				$sumRetur = $kirim["sumRetur"];
				$sisa = $kirim["sisa"];
				($sisa <= 0) ? $bgtd = 'background:#74c69d' : $bgtd = 'background:#ff758f';
				($sisa <= 0) ? $txtSisa = number_format($sisa,0,',','.') : $txtSisa = '+'.number_format($sisa,0,',','.');
				($sisa == 0 || $sumKirim == 0) ? $span = '' : $span = ' <span style="'.$bgtd.'">'.$txtSisa.'</span>';
				($sumRetur != 0) ? $txtRtr = ' <span style="font-style:italic;font-weight:normal">('.number_format($sumRetur,0,',','.').')</span>' : $txtRtr = '';
				$row[] = '<div style="text-align:right;font-weight:bold">'.number_format($sumKirim,0,',','.').$txtRtr.$span.'</div>';
				$row[] = '<div class="text-center">'.$aksi.'</div>';
				$data[] = $row;
			}
		} else if ($jenis == "trs_wo") {
			$tahunx = $_POST["tahun"];
			$skz = $_POST["status_kiriman"];
			$query = $this->m_master->query("SELECT a.id AS id_wo,a.status AS statusWO,a.*,b.*,c.*,d.* FROM trs_wo a 
			INNER JOIN trs_po p ON a.no_po=p.no_po AND a.kode_po=p.kode_po
            INNER JOIN trs_wo_detail b ON a.no_wo=b.no_wo 
            INNER JOIN m_produk c ON a.id_produk=c.id_produk 
            INNER JOIN m_pelanggan d ON a.id_pelanggan=d.id_pelanggan 
			WHERE a.tgl_wo LIKE '%$tahunx%' AND p.status_kiriman='$skz'
            ORDER BY a.id DESC")->result();
			$i = 1;
			foreach ($query as $r) {

				if($r->kategori=='K_BOX'){
					$type ='BOX';
				}else{
					$type ='SHEET';
				}

				if($r->statusWO == 'Open') {
                    $btn_status   = 'btn-info';
                }else if($r->statusWO == 'Approve') {
                    $btn_status   = 'btn-success';
                }else{
                    $btn_status   = 'btn-danger';
                }

				$row = array();
				$row[] = '<div class="text-center">'.$i.'</div>';
				$row[] = '<a href="javascript:void(0)" onclick="tampil_edit(' . "'" . $r->id_wo . "'" . ',' . "'detail'" . ')">' . $r->no_wo . "<a>";
                
				$row[] = '<div class="text-center">'.$type.'</div';
				$row[] = $this->m_fungsi->tanggal_ind($r->tgl_wo);
				// $row[] = $r->no_so;
				$row[] = $this->m_fungsi->tanggal_ind($r->tgl_so);
				$row[] = '<div class="text-center btn btn-sm '.$btn_status.'">'.$r->statusWO.'</div';
				$row[] = $r->kode_mc;
				$row[] = '<div class="text-center">'.number_format($r->qty, 0, ",", ".").'</div';
				// $row[] = $r->id_pelanggan;
				$row[] = $r->nm_pelanggan;

				$btncetak ='<a target="_blank" class="btn btn-sm btn-danger" href="' . base_url("Transaksi/Cetak_WO?no_wo=" . $r->no_wo . "") . '" title="Cetak" ><i class="fas fa-print"></i> </a>';

				$btnEdit = '<button type="button" onclick="tampil_edit(' . "'" . $r->id_wo . "'" . ',' . "'edit'" . ')" class="btn btn-warning btn-sm">
								<i class="fa fa-edit"></i>
							</button>';

				$btnHapus = '<button type="button" onclick="deleteData(' . "'" . $r->id_wo . "'" . ',' . "'" . $r->no_wo . "'" . ')" class="btn btn-secondary btn-sm">
								<i class="fa fa-trash-alt"></i>
							</button> ';



				if ($r->statusWO == 'Open') {
					if(in_array($this->session->userdata('level'), ['Admin','User'])){
						$aksi = '<div class="text-center">'.$btnEdit.' '.$btncetak.' '.$btnHapus.'</div>';
					}else{
						$aksi = '<div class="text-center">'.$btncetak.'</div>';
					}
				} else {
					// $aksi = '-';
					$aksi = '<div class="text-center">'.$btncetak.' </div>';
				}

				$row[] = $aksi;

				$data[] = $row;

				$i++;
			}
		} else if ($jenis == "trs_surat_jalan") {
			$query = $this->m_master->query("SELECT *,sum(qty) as tot_qty FROM trs_surat_jalan group by no_surat_jalan,no_po order by id")->result();
			$i = 1;
			foreach ($query as $r) {
				$row = array();

				$row[] = $i;
				$row[] = '<a href="javascript:void(0)" onclick="tampil_edit(' . "'" . $r->id . "'" . ',' . "'detail'" . ')">' . $r->no_surat_jalan . "<a>";
				$row[] = $r->tgl_surat_jalan;
				$row[] = $r->status;
				$row[] = $r->no_po;
				$row[] = $r->id_produk;
				$row[] = $r->tot_qty;
				$row[] = $r->id_pelanggan;
				$row[] = $r->nm_pelanggan;

				if ($r->status == 'Open') {
					$aksi = ' 
                            <button type="button" onclick="deleteData(' . "'" . $r->id . "'" . ')" class="btn btn-danger btn-xs">
                               Batal
                            </button> ';
				} else {
					$aksi = '-';
				}

				$row[] = $aksi;

				$data[] = $row;

				$i++;
			}
		} else if ($jenis == "trs_po_laminasi") {
			$tahun = $_POST["tahun"];
			$plhJenis = $_POST["jenis"];
			$plhHub = $_POST["hub"];
			$bulan = $_POST["bulan"];
			$status_kiriman = $_POST["status_kiriman"];
			($plhHub == "") ? $wHub = '' : $wHub = "AND po.id_hub='$plhHub'";
			($bulan == "") ? $wBln = '' : $wBln = "AND MONTH(po.tgl_lm) IN ('$bulan')";
			($status_kiriman == "") ? $wSts = '' : $wSts = "AND po.status_kirim='$status_kiriman'";
			if($_POST["po"] == 'pengiriman' && $this->session->userdata('username') != 'usman'){
				$where1 = "po.status_lm='Approve' AND po.status_kirim='Open'";
			}else if($_POST["po"] == 'pengiriman' && $this->session->userdata('username') == 'usman'){
				$where1 = "po.status_lm='Approve' AND po.status_pkl='Open'";
			}else{
				$where1 = "po.tgl_lm LIKE '%$tahun%' AND po.jenis_lm LIKE '%$plhJenis%' $wHub $wBln $wSts";
			}
			if($this->session->userdata('level') == 'Admin'){
				$where2 = "";
			}else if($this->session->userdata('level') == 'Owner' || $this->session->userdata('level') == 'Keuangan1' || $this->session->userdata('level') == 'Marketing Laminasi'){
				$where2 = "AND po.jenis_lm!='PEKALONGAN'";
			}else if($this->session->userdata('level') == 'Laminasi' && $this->session->userdata('username') != 'usman'){
				if($_POST["po"] == 'pengiriman'){
					$where2 = "AND po.jenis_lm='PPI'";
				}else{
					$where2 = "";
				}
			}else{
				$where2 = "AND po.jenis_lm='PEKALONGAN'";
			}
			($_POST["po"] == 'pengiriman') ? $order = "ORDER BY po.tgl_lm DESC,pl.nm_pelanggan_lm,po.no_po_lm" : $order = "ORDER BY po.tgl_lm DESC,po.no_po_lm";
			$query = $this->db->query("SELECT po.*,pl.nm_pelanggan_lm FROM trs_po_lm po
			INNER JOIN m_pelanggan_lm pl ON po.id_pelanggan=pl.id_pelanggan_lm
			INNER JOIN m_sales s ON po.id_sales=s.id_sales
			WHERE $where1 $where2
			$order")->result();
			$i = 0;
			foreach ($query as $r) {
				$i++;
				$row = array();
				if($_POST["po"] == 'list'){
					$row[] = '<div class="text-center">'.$i.'</div>';
					$row[] = $r->no_po_lm;
					$row[] = '<div class="text-center">'.$this->m_fungsi->tanggal_format_indonesia($r->tgl_lm).'</div>';
					if($r->status_lm == 'Open'){
						$btn_s = 'btn-info';
					}else if($r->status_lm == 'Approve'){
						$btn_s = 'btn-success';
					}else{
						$btn_s = 'btn-danger';
					}
					$row[] = '<div class="text-center"><button type="button" class="btn btn-sm '.$btn_s.'" onclick="editPOLaminasi('."'".$r->id."'".',0,'."'detail'".')">'.$r->status_lm.'</button></div>';
					$row[] = $r->nm_pelanggan_lm;
					// MARKETING
					if($r->status_lm1 == 'N'){
						$bt1 = 'btn-warning';
						$fa1 = 'class="fas fa-lock"';
						$time1 = 'BELUM ACC!';
						$p1 = '';
					}else if($r->status_lm1 == 'H'){
						$bt1 = 'btn-warning';
						$fa1 = 'class="fas fa-hand-paper"';
						$time1 = 'HOLD!';
						$p1 = '';
					}else if($r->status_lm1 == 'R'){
						$bt1 = 'btn-danger';
						$fa1 = 'class="fas fa-times" style="color:#000"';
						$time1 = 'REJECT!';
						$p1 = 'style="padding:4px 10px"';
					}else{
						$bt1 = 'btn-success';
						$fa1 = 'class="fas fa-check-circle"';
						$time1 = $this->m_fungsi->tglIndSkt(substr($r->time_lm1,0,10)).' - '.substr($r->time_lm1,10,9);
						$p1 = '';
					}
					$row[] = '<div class="text-center">
						<div class="dropup">
							<button class="dropbtn btn btn-sm '.$bt1.'" '.$p1.' onclick="editPOLaminasi('."'".$r->id."'".',0,'."'detail'".')"><i '.$fa1.'></i></button>
							<div class="dropup-content">
								<div class="time-admin">'.$time1.'</div>
							</div>
						</div>
					</div>';
					// OWNER
					if($r->status_lm2 == 'N'){
						$bt2 = 'btn-warning';
						$fa2 = 'class="fas fa-lock"';
						$time2 = 'BELUM ACC!';
						$p2 = '';
					}else if($r->status_lm2 == 'H'){
						$bt2 = 'btn-warning';
						$fa2 = 'class="fas fa-hand-paper"';
						$time2 = 'HOLD!';
						$p2 = '';
					}else if($r->status_lm2 == 'R'){
						$bt2 = 'btn-danger';
						$fa2 = 'class="fas fa-times" style="color:#000"';
						$time2 = 'REJECT!';
						$p2 = 'style="padding:4px 10px"';
					}else{
						$bt2 = 'btn-success';
						$fa2 = 'class="fas fa-check-circle"';
						$time2 = $this->m_fungsi->tglIndSkt(substr($r->time_lm2,0,10)).' - '.substr($r->time_lm2,10,9);
						$p2 = '';
					}
					$row[] = '<div class="text-center">
						<div class="dropup">
							<button class="dropbtn btn btn-sm '.$bt2.'" '.$p2.' onclick="editPOLaminasi('."'".$r->id."'".',0,'."'detail'".')"><i '.$fa2.'></i></button>
							<div class="dropup-content">
								<div class="time-admin">'.$time2.'</div>
							</div>
						</div>
					</div>';
					$lapAcc = '<a target="_blank" class="btn btn-sm btn-primary" href="'.base_url("Transaksi/Lap_POLaminasi?id=".$r->id."&opsi=acc").'" title="Laporan Laminasi" ><i class="fas fa-print"></i></a>'; 
					$lapProd = '<a target="_blank" class="btn btn-sm btn-danger" href="'.base_url("Transaksi/Lap_POLaminasi?id=".$r->id."&opsi=prod").'" title="Laporan Laminasi" ><i class="fas fa-print"></i></a>'; 
					if(in_array($this->session->userdata('level'), ['Admin', 'Laminasi']) && $this->session->userdata('username') != 'usman'){
						$row[] = '<div class="text-center">'.$lapAcc.' '.$lapProd.'</div>';
					}else{
						$row[] = '<div class="text-center">'.$lapAcc.'</div>';
					}
					($r->status_lm1 == 'Y' && $r->status_lm2 == 'Y') ? $xEditVerif = 'verif' : $xEditVerif = 'edit';
					$btnEdit = '<button type="button" onclick="editPOLaminasi('."'".$r->id."'".',0,'."'".$xEditVerif."'".')" title="EDIT" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></button>'; 
					$btnHapus = ($r->status_lm1 == 'Y' && $r->status_lm2 == 'Y') ? '' : '<button type="button" onclick="hapusPOLaminasi(0,'."'".$r->id."'".','."'trs_po_lm'".')" title="HAPUS" class="btn btn-secondary btn-sm"><i class="fa fa-trash-alt"></i></button>';
					$btnVerif = '<button type="button" onclick="editPOLaminasi('."'".$r->id."'".',0,'."'verif'".')" title="VERIF" class="btn btn-info btn-sm"><i class="fa fa-check"></i></button>'; 
					
					if($this->session->userdata('level') == 'Admin'){
						$row[] = '<div class="text-center">'.$btnEdit.' '.$btnHapus.' '.$btnVerif.'</div>';
					}else if($this->session->userdata('level') == 'Laminasi'){
						if($this->session->userdata('username') == 'usman'){
							$row[] = '<div class="text-center">'.$btnVerif.'</div>';
						}else{
							$row[] = '<div class="text-center">'.$btnEdit.' '.$btnHapus.'</div>';
						}
					}else{
						$row[] = '<div class="text-center">'.$btnVerif.'</div>';
					}
				}else{
					$row[] = $r->nm_pelanggan_lm;
					$row[] = $r->no_po_lm;
					$cariPO = '<button type="button" title="CARI" class="btn btn-primary btn-sm" onclick="addListPOLaminasi('."'".$r->id."'".')"><i class="fas fa-search"></i></button>';
					$closePO = '<button type="button" title="CLOSE" class="btn btn-danger btn-sm" onclick="closePOLaminasi('."'".$r->id."'".','."'".$r->no_po_lm."'".')"><i class="fas fa-check"></i></button>';
					$row[] = '<div class="text-center">'.$cariPO.' '.$closePO.'</div>';
				}
				
				$data[] = $row;
			}
		} else if ($jenis == "trs_po_roll") {
			$tahun = $_POST["tahun"];
			$bulan = $_POST["bulan"];
			($bulan == "") ? $wBln = '' : $wBln = "AND MONTH(tgl_po) IN ('$bulan')";
			$query = $this->db->query("SELECT*FROM trs_po_roll_header WHERE tgl_po LIKE '%$tahun%' $wBln ORDER BY owner_status, tgl_po DESC, no_po")->result();
			$i = 0;
			foreach ($query as $r) {
				$i++;
				$row = array();
				$row[] = '<div class="text-center">'.$i.'</div>';
				// ORDER
				$qItems = $this->db->query("SELECT nm_ker,g_label FROM trs_po_roll_item WHERE id_hdr='$r->id_hdr' AND no_po='$r->no_po' GROUP BY nm_ker,g_label");
				$items = '';
				foreach($qItems->result() as $s){
					if(($s->nm_ker == 'MH' || $s->nm_ker == 'MN') && $s->g_label <= 110){
						$bT = 'background:#ccf;';
					}else if(($s->nm_ker == 'MH' || $s->nm_ker == 'MN') && ($s->g_label == 120 || $s->g_label == 125)){
						$bT = 'background:#ffc;';
					}else if(($s->nm_ker == 'MH' || $s->nm_ker == 'MN') && $s->g_label >= 150){
						$bT = 'background:#fcc;';
					}else if($s->nm_ker == 'WP' || $s->nm_ker == 'WS'){
						$bT = 'background:#cfc;';
					}else{
						$bT = 'background:#ddd;';
					}
					$items .= '<span style="'.$bT.'vertical-align:top;font-weight:bold;padding:2px 4px;font-size:12px">'.$s->nm_ker.$s->g_label.'</span>';
				}
				$row[] = $r->no_po.' '.$items;
				$row[] = '<div class="text-center">'.$this->m_fungsi->tanggal_format_indonesia($r->tgl_po).'</div>';
				if($r->status_po == 'Open'){
					$btn_s = 'btn-info';
				}else if($r->status_po == 'Approve'){
					$btn_s = 'btn-success';
				}else{
					$btn_s = 'btn-danger';
				}
				$row[] = '<div class="text-center"><button type="button" class="btn btn-sm '.$btn_s.'" onclick="editPORoll('."'".$r->id_hdr."'".', '."'detail'".')">'.$r->status_po.'</button></div>';
				// PAJAK
				($r->pajak == "non") ? $pajak = ' <span style="background:#ddd;vertical-align:top;font-weight:bold;padding:2px 4px;font-size:12px">non</span>' : $pajak = '';
				$row[] = $r->nm_pelanggan.$pajak;
				// MARKETING
				if($r->mkt_status == 'N'){
					$bt1 = 'btn-warning';
					$fa1 = 'class="fas fa-lock"';
					$time1 = 'BELUM ACC!';
					$p1 = '';
				}else if($r->mkt_status == 'H'){
					$bt1 = 'btn-warning';
					$fa1 = 'class="fas fa-hand-paper"';
					$time1 = 'HOLD!';
					$p1 = '';
				}else if($r->mkt_status == 'R'){
					$bt1 = 'btn-danger';
					$fa1 = 'class="fas fa-times" style="color:#000"';
					$time1 = 'REJECT!';
					$p1 = 'style="padding:4px 10px"';
				}else{
					$bt1 = 'btn-success';
					$fa1 = 'class="fas fa-check-circle"';
					$time1 = $this->m_fungsi->tglIndSkt(substr($r->mkt_time,0,10)).' - '.substr($r->mkt_time,10,9);
					$p1 = '';
				}
				$row[] = '<div class="text-center">
					<div class="dropup">
						<button class="dropbtn btn btn-sm '.$bt1.'" '.$p1.' onclick="editPORoll('."'".$r->id_hdr."'".', '."'detail'".')"><i '.$fa1.'></i></button>
						<div class="dropup-content">
							<div class="time-admin">'.$time1.'</div>
						</div>
					</div>
				</div>';
				// OWNER
				if($r->owner_status == 'N'){
					$bt1 = 'btn-warning';
					$fa1 = 'class="fas fa-lock"';
					$time1 = 'BELUM ACC!';
					$p1 = '';
				}else if($r->owner_status == 'H'){
					$bt1 = 'btn-warning';
					$fa1 = 'class="fas fa-hand-paper"';
					$time1 = 'HOLD!';
					$p1 = '';
				}else if($r->owner_status == 'R'){
					$bt1 = 'btn-danger';
					$fa1 = 'class="fas fa-times" style="color:#000"';
					$time1 = 'REJECT!';
					$p1 = 'style="padding:4px 10px"';
				}else{
					$bt1 = 'btn-success';
					$fa1 = 'class="fas fa-check-circle"';
					$time1 = $this->m_fungsi->tglIndSkt(substr($r->owner_time,0,10)).' - '.substr($r->owner_time,10,9);
					$p1 = '';
				}
				$row[] = '<div class="text-center">
					<div class="dropup">
						<button class="dropbtn btn btn-sm '.$bt1.'" '.$p1.' onclick="editPORoll('."'".$r->id_hdr."'".', '."'detail'".')"><i '.$fa1.'></i></button>
						<div class="dropup-content">
							<div class="time-admin">'.$time1.'</div>
						</div>
					</div>
				</div>';
				// AKSI
				$btnEdit = '<button type="button" title="EDIT" class="btn btn-warning btn-sm" onclick="editPORoll('."'".$r->id_hdr."'".', '."'edit'".')"><i class="fa fa-edit"></i></button>'; 
				$btnHapus = ($r->mkt_status == 'Y' && $r->owner_status == 'Y') ? '' : '<button type="button" title="HAPUS" class="btn btn-secondary btn-sm" onclick="hapusPORoll('."'".$r->id_hdr."'".')"><i class="fa fa-trash-alt"></i></button>';
				$btnVerif = '<button type="button" title="VERIF" class="btn btn-info btn-sm" onclick="editPORoll('."'".$r->id_hdr."'".', '."'verif'".')"><i class="fa fa-check"></i></button>';
				($r->input_po == 'N' && $r->owner_status == 'Y' && $this->session->userdata('level') == 'Admin') ? $btnUpload = '<button type="button" title="INPUT PO" class="btn btn-danger btn-sm" onclick=""><i class="fas fa-file-upload"></i></button>' : $btnUpload = '';
				if($this->session->userdata('level') == 'Admin'){
					$row[] = '<div class="text-center">'.$btnEdit.' '.$btnHapus.' '.$btnVerif.' '.$btnUpload.'</div>';
				}else{
					$row[] = '<div class="text-center">'.$btnVerif.'</div>';
				}
				$data[] = $row;
			}
		} else if ($jenis == "form_design") {
			$tahun = $_POST["tahun"];
			$bulan = $_POST["bulan"];
			($bulan == "") ? $wBln = "" : $wBln = "AND MONTH(h.tgl) IN ('$bulan')";
			
			$id_sales = $this->session->userdata('id_sales');
			($id_sales == null) ? $wSales = "" : $wSales = "AND p.id_sales='$id_sales'";
			
			$query = $this->db->query("SELECT p.id_sales,h.* FROM trs_design_header h
			LEFT JOIN m_pelanggan p ON h.id_pelanggan=p.id_pelanggan
			WHERE h.tgl LIKE '%$tahun%' $wBln $wSales
			GROUP BY h.id_dg DESC
			-- ORDER BY jenis_dg, acc_a_stt, acc_p_stt, acc_d_stt, acc_s_stt, acc_x_stt, acc_z_stt, acc_k_stt, tgl DESC, kode_dg
			")->result();
			$i = 0;
			foreach ($query as $r) {
				$i++;
				$row = array();
				$row[] = '<div class="text-center">'.$i.'</div>';
				// RINCIAN
				if($r->jenis_dg == 'B' || $r->id_pelanggan != null || $r->kode_po != null || $r->id_produk != null){
					$item = $this->db->query("SELECT h.id_pelanggan,h.kode_po,h.id_produk,c.nm_pelanggan,c.attn,i.nm_produk FROM trs_design_header h
					INNER JOIN m_pelanggan c ON h.id_pelanggan=c.id_pelanggan
					INNER JOIN m_produk i ON h.id_produk=i.id_produk
					WHERE h.id_pelanggan='$r->id_pelanggan' AND h.kode_po='$r->kode_po' AND h.id_produk='$r->id_produk'
					GROUP BY h.id_pelanggan,h.kode_po,h.id_produk")->row();
					($item->attn == '-') ? $attn = '' : $attn = ' | '.$item->attn;
					$tHtml = '<tr style="background-color:transparent !important">
						<td style="padding:2px;border:0;font-weight:bold">CUSTOMER</td>
						<td style="padding:2px;border:0">:</td>
						<td style="padding:2px;border:0">'.$item->nm_pelanggan.$attn.'</td>
					</tr>
					<tr style="background-color:transparent !important">
						<td style="padding:2px;border:0;font-weight:bold">NO. PO</td>
						<td style="padding:2px;border:0">:</td>
						<td style="padding:2px;border:0">'.$item->kode_po.'</td>
					</tr>
					<tr style="background-color:transparent !important">
						<td style="padding:2px;border:0;font-weight:bold">ITEM</td>
						<td style="padding:2px;border:0">:</td>
						<td style="padding:2px;border:0">'.$item->nm_produk.'</td>
					</tr>';
				}else{
					$tHtml = '';
				}
				$row[] = '<table>
					<tr style="background-color:transparent !important">
						<td style="padding:2px;border:0;font-weight:bold">NO. FORM</td>
						<td style="padding:2px;border:0">:</td>
						<td style="padding:2px;border:0">'.$r->kode_dg.'</td>
					</tr>
					'.$tHtml.'
				</table>';
				$row[] = '<div style="text-align:center;font-weight:bold;color:#f00">'.$r->tgl.'</div>';
				// STATUS
				if($r->form_stat == 'Open'){
					$btn_s = 'btn-info';
				}else if($r->form_stat == 'Approve'){
					$btn_s = 'btn-success';
				}else{
					$btn_s = 'btn-danger';
				}
				$row[] = '<div class="text-center"><button type="button" class="btn btn-sm '.$btn_s.'" onclick="editFormDesign('."'".$r->id_dg."'".', '."'verif'".')">'.$r->form_stat.'</button></div>';
				// ACUAN
				if($r->acc_a_stt == 'N'){
					$bt1 = 'btn-warning';
					$fa1 = 'class="fas fa-lock"';
					$time1 = 'FORM ACUAN BELUM ACC!';
					$p1 = '';
				}else if($r->acc_a_stt == 'H'){
					$bt1 = 'btn-warning';
					$fa1 = 'class="fas fa-hand-paper"';
					$time1 = 'FORM ACUAN HOLD!';
					$p1 = '';
				}else if($r->acc_a_stt == 'R'){
					$bt1 = 'btn-danger';
					$fa1 = 'class="fas fa-times" style="color:#000"';
					$time1 = 'FORM ACUAN REJECT!';
					$p1 = 'style="padding:4px 10px"';
				}else{
					$bt1 = 'btn-success';
					$fa1 = 'class="fas fa-check-circle"';
					$time1 = 'Form Acuan '.$this->m_fungsi->tglIndSkt(substr($r->acc_a_at,0,10)).' - '.substr($r->acc_a_at,10,9);
					$p1 = '';
				}
				$row[] = '<div class="text-center">
					<div class="dropup">
						<button class="dropbtn btn btn-sm '.$bt1.'" '.$p1.' onclick="editFormDesign('."'".$r->id_dg."'".', '."'verif'".')"><i '.$fa1.'></i></button>
						<div class="dropup-content">
							<div class="time-admin">'.$time1.'</div>
						</div>
					</div>
				</div>';
				// PENAWARAN
				if($r->acc_p_stt == 'N'){
					$bt1 = 'btn-warning';
					$fa1 = 'class="fas fa-lock"';
					$time1 = 'FORM PENAWARAN BELUM ACC!';
					$p1 = '';
				}else if($r->acc_p_stt == 'H'){
					$bt1 = 'btn-warning';
					$fa1 = 'class="fas fa-hand-paper"';
					$time1 = 'FORM PENAWARAN HOLD!';
					$p1 = '';
				}else if($r->acc_p_stt == 'R'){
					$bt1 = 'btn-danger';
					$fa1 = 'class="fas fa-times" style="color:#000"';
					$time1 = 'FORM PENAWARAN REJECT!';
					$p1 = 'style="padding:4px 10px"';
				}else{
					$bt1 = 'btn-success';
					$fa1 = 'class="fas fa-check-circle"';
					$time1 = 'Form Penawaran '.$this->m_fungsi->tglIndSkt(substr($r->acc_p_at,0,10)).' - '.substr($r->acc_p_at,10,9);
					$p1 = '';
				}
				$row[] = '<div class="text-center">
					<div class="dropup">
						<button class="dropbtn btn btn-sm '.$bt1.'" '.$p1.' onclick="editFormDesign('."'".$r->id_dg."'".', '."'verif'".')"><i '.$fa1.'></i></button>
						<div class="dropup-content">
							<div class="time-admin">'.$time1.'</div>
						</div>
					</div>
				</div>';
				// DESIGN
				if($r->acc_d_stt == 'N'){
					$bt1 = 'btn-warning';
					$fa1 = 'class="fas fa-lock"';
					$time1 = 'FORM DESIGN BELUM ACC!';
					$p1 = '';
				}else if($r->acc_d_stt == 'H'){
					$bt1 = 'btn-warning';
					$fa1 = 'class="fas fa-hand-paper"';
					$time1 = 'FORM DESIGN HOLD!';
					$p1 = '';
				}else if($r->acc_d_stt == 'R'){
					$bt1 = 'btn-danger';
					$fa1 = 'class="fas fa-times" style="color:#000"';
					$time1 = 'FORM DESIGN REJECT!';
					$p1 = 'style="padding:4px 10px"';
				}else{
					$bt1 = 'btn-success';
					$fa1 = 'class="fas fa-check-circle"';
					$time1 = 'Form Design '.$this->m_fungsi->tglIndSkt(substr($r->acc_d_at,0,10)).' - '.substr($r->acc_d_at,10,9);
					$p1 = '';
				}
				$row[] = '<div class="text-center">
					<div class="dropup">
						<button class="dropbtn btn btn-sm '.$bt1.'" '.$p1.' onclick="editFormDesign('."'".$r->id_dg."'".', '."'verif'".')"><i '.$fa1.'></i></button>
						<div class="dropup-content">
							<div class="time-admin">'.$time1.'</div>
						</div>
					</div>
				</div>';
				// SAMPLE
				if($r->acc_s_stt == 'N'){
					$bt1 = 'btn-warning';
					$fa1 = 'class="fas fa-lock"';
					$time1 = 'FORM SAMPLE BELUM ACC!';
					$p1 = '';
				}else if($r->acc_s_stt == 'H'){
					$bt1 = 'btn-warning';
					$fa1 = 'class="fas fa-hand-paper"';
					$time1 = 'FORM SAMPLE HOLD!';
					$p1 = '';
				}else if($r->acc_s_stt == 'R'){
					$bt1 = 'btn-danger';
					$fa1 = 'class="fas fa-times" style="color:#000"';
					$time1 = 'FORM SAMPLE REJECT!';
					$p1 = 'style="padding:4px 10px"';
				}else{
					$bt1 = 'btn-success';
					$fa1 = 'class="fas fa-check-circle"';
					$time1 = 'Form Sample '.$this->m_fungsi->tglIndSkt(substr($r->acc_s_at,0,10)).' - '.substr($r->acc_s_at,10,9);
					$p1 = '';
				}
				$row[] = '<div class="text-center">
					<div class="dropup">
						<button class="dropbtn btn btn-sm '.$bt1.'" '.$p1.' onclick="editFormDesign('."'".$r->id_dg."'".', '."'verif'".')"><i '.$fa1.'></i></button>
						<div class="dropup-content">
							<div class="time-admin">'.$time1.'</div>
						</div>
					</div>
				</div>';
				// DESIGN NUG
				if($r->acc_x_stt == 'N'){
					$bt1 = 'btn-warning';
					$fa1 = 'class="fas fa-lock"';
					$time1 = 'DESIGN BELUM ACC!';
					$p1 = '';
				}else if($r->acc_x_stt == 'H'){
					$bt1 = 'btn-warning';
					$fa1 = 'class="fas fa-hand-paper"';
					$time1 = 'DESIGN HOLD!';
					$p1 = '';
				}else if($r->acc_x_stt == 'R'){
					$bt1 = 'btn-danger';
					$fa1 = 'class="fas fa-times" style="color:#000"';
					$time1 = 'DESIGN REJECT!';
					$p1 = 'style="padding:4px 10px"';
				}else{
					$bt1 = 'btn-success';
					$fa1 = 'class="fas fa-check-circle"';
					$time1 = 'Design '.$this->m_fungsi->tglIndSkt(substr($r->acc_x_at,0,10)).' - '.substr($r->acc_x_at,10,9);
					$p1 = '';
				}
				$row[] = '<div class="text-center">
					<div class="dropup">
						<button class="dropbtn btn btn-sm '.$bt1.'" '.$p1.' onclick="editFormDesign('."'".$r->id_dg."'".', '."'verif'".')"><i '.$fa1.'></i></button>
						<div class="dropup-content">
							<div class="time-admin">'.$time1.'</div>
						</div>
					</div>
				</div>';
				// SAMPEL PPIC
				if($r->acc_z_stt == 'N'){
					$bt1 = 'btn-warning';
					$fa1 = 'class="fas fa-lock"';
					$time1 = 'SAMPLE BELUM ACC!';
					$p1 = '';
				}else if($r->acc_z_stt == 'H'){
					$bt1 = 'btn-warning';
					$fa1 = 'class="fas fa-hand-paper"';
					$time1 = 'SAMPLE HOLD!';
					$p1 = '';
				}else if($r->acc_z_stt == 'R'){
					$bt1 = 'btn-danger';
					$fa1 = 'class="fas fa-times" style="color:#000"';
					$time1 = 'SAMPLE REJECT!';
					$p1 = 'style="padding:4px 10px"';
				}else{
					$bt1 = 'btn-success';
					$fa1 = 'class="fas fa-check-circle"';
					$time1 = 'Sample '.$this->m_fungsi->tglIndSkt(substr($r->acc_x_at,0,10)).' - '.substr($r->acc_x_at,10,9);
					$p1 = '';
				}
				$row[] = '<div class="text-center">
					<div class="dropup">
						<button class="dropbtn btn btn-sm '.$bt1.'" '.$p1.' onclick="editFormDesign('."'".$r->id_dg."'".', '."'verif'".')"><i '.$fa1.'></i></button>
						<div class="dropup-content">
							<div class="time-admin">'.$time1.'</div>
						</div>
					</div>
				</div>';
				// KARET
				if($r->acc_k_stt == 'N'){
					$bt1 = 'btn-warning';
					$fa1 = 'class="fas fa-lock"';
					$time1 = 'KARET BELUM ACC!';
					$p1 = '';
				}else if($r->acc_k_stt == 'H'){
					$bt1 = 'btn-warning';
					$fa1 = 'class="fas fa-hand-paper"';
					$time1 = 'KARET HOLD!';
					$p1 = '';
				}else if($r->acc_k_stt == 'R'){
					$bt1 = 'btn-danger';
					$fa1 = 'class="fas fa-times" style="color:#000"';
					$time1 = 'KARET REJECT!';
					$p1 = 'style="padding:4px 10px"';
				}else{
					$bt1 = 'btn-success';
					$fa1 = 'class="fas fa-check-circle"';
					$time1 = 'Karet '.$this->m_fungsi->tglIndSkt(substr($r->acc_k_at,0,10)).' - '.substr($r->acc_k_at,10,9);
					$p1 = '';
				}
				$row[] = '<div class="text-center">
					<div class="dropup">
						<button class="dropbtn btn btn-sm '.$bt1.'" '.$p1.' onclick="editFormDesign('."'".$r->id_dg."'".', '."'verif'".')"><i '.$fa1.'></i></button>
						<div class="dropup-content">
							<div class="time-admin">'.$time1.'</div>
						</div>
					</div>
				</div>';
				// AKSI
				$lvl = $this->session->userdata('level');
				$btnEdit = '<button type="button" title="EDIT" class="btn btn-warning btn-sm" onclick="editFormDesign('."'".$r->id_dg."'".', '."'edit'".')"><i class="fa fa-edit"></i></button>'; 
				($lvl == 'Admin' || $lvl == 'User') ? $btnHapus = ' <button type="button" title="HAPUS" class="btn btn-secondary btn-sm" onclick="hapusDesign('."'".$r->id_dg."'".', '."'".$r->kode_dg."'".')"><i class="fa fa-trash-alt"></i></button>' : $btnHapus = '';
				$btnVerif = ' <button type="button" title="VERIF" class="btn btn-info btn-sm" onclick="editFormDesign('."'".$r->id_dg."'".', '."'verif'".')"><i class="fa fa-check"></i></button>';
				if($this->session->userdata('level') == 'Admin'){
					if($r->form_stat == 'Approve'){
						$row[] = '<div class="text-center">'.$btnVerif.'</div>';
					}else{
						$row[] = '<div class="text-center">'.$btnEdit.$btnHapus.$btnVerif.'</div>';
					}
				}else if(($lvl == 'User' || $lvl == 'Design' || $lvl == 'PPIC') && ($r->acc_a_stt == 'N' || $r->acc_d_stt == 'N' || $r->acc_p_stt == 'N' || $r->acc_s_stt == 'N' || $r->acc_x_stt == 'N' || $r->acc_z_stt == 'N' || $r->acc_k_stt == 'N')){
					$row[] = '<div class="text-center">'.$btnEdit.$btnHapus.'</div>';
				}else{
					$row[] = '<div class="text-center">'.$btnVerif.'</div>';
				}
				$data[] = $row;
			}
		}

		$output = array(
			"data" => $data,
		);
		echo json_encode($output);
	}

	function load_data_1()
	{
		$id       = $this->input->post('id');
		$tbl      = $this->input->post('tbl');
		$jenis    = $this->input->post('jenis');
		$field    = $this->input->post('field');

		if($jenis=='po_bahan_baku')
		{
			$queryh    = "SELECT * FROM $tbl a JOIN m_hub b ON a.hub=b.id_hub WHERE $field = '$id' ";
			
			$no_po     = $this->db->query($queryh)->row()->no_po_bhn;
			$queryd    = "SELECT*FROM trs_po_bhnbk_detail where no_po_bhn='$no_po'";
		}else{

			$queryh   = "SELECT*FROM invoice_header a where a.id='$id' and a.no_invoice='$no'";
			$queryd   = "SELECT*FROM invoice_detail where no_invoice='$no' ORDER BY TRIM(no_surat) ";
		}
		

		$header   = $this->db->query($queryh)->row();
		$detail    = $this->db->query($queryd)->result();

		$data = ["header" => $header, "detail" => $detail];

        echo json_encode($data);
	}	

	function Lap_POLaminasi()
	{
		$id = $_GET["id"];
		$opsi = $_GET["opsi"];
		if($opsi == 'acc'){
			$cls = 10;
		}else{
			$cls = 4;
		}

		$po_lm = $this->db->query("SELECT p.nm_pelanggan_lm,p.alamat,po.* FROM trs_po_lm po
		INNER JOIN m_pelanggan_lm p ON p.id_pelanggan_lm=po.id_pelanggan
		WHERE po.id='$id'")->row();
		$html = '';
		$html .= '<table style="margin:0;padding:0;font-size:12px;text-align:center;border-collapse:collapse;color:#000;width:100%">';
			$html .='<thead>
				<tr><th style="font-weight:normal;padding-bottom:33px;text-align:right" colspan="'.$cls.'">'.ucwords(strtolower($po_lm->alamat)).', '.$this->m_fungsi->tanggal_format_indonesia($po_lm->tgl_lm).'</th></tr>
				<tr><th style="font-weight:normal;padding-bottom:8px;text-decoration:underline" colspan="'.$cls.'">PURCHASE ORDER</th></tr>
				<tr><th style="font-weight:normal;padding-bottom:33px;text-decoration:underline" colspan="'.$cls.'">NO : '.$po_lm->no_po_lm.'</th></tr>
				<tr><th style="font-weight:normal;padding-bottom:8px;text-align:left" colspan="'.$cls.'">Kepada yth.</th></tr>
				<tr><th style="font-weight:normal;padding-bottom:8px;text-align:left" colspan="'.$cls.'">PT PRIMA PAPER INDONESIA</th></tr>
				<tr><th style="font-weight:normal;padding-bottom:33px;text-align:left" colspan="'.$cls.'">Di - Wonogiri</th></tr>
				<tr><th style="font-weight:normal;padding-bottom:8px;text-align:left" colspan="'.$cls.'">Dengan hormat,</th></tr>
				<tr><th style="font-weight:normal;padding-bottom:8px;text-align:left" colspan="'.$cls.'">Kami tempatkan order sbb ;</th></tr>
				<tr><th style="font-weight:normal;padding-bottom:8px;text-align:left" colspan="'.$cls.'">Kertas Laminasi</th></tr>
				<tr><th style="font-weight:normal;padding-bottom:8px;text-align:left" colspan="'.$cls.'">(Rincian terlampir)</th></tr>
				<tr>
					<th style="background:#8ea9db;padding:7px 5px;border:1px solid #000">ITEM</th>
					<th style="background:#8ea9db;padding:7px 5px;border:1px solid #000">SIZE</th>
					<th style="background:#8ea9db;padding:7px 5px;border:1px solid #000">SHEET</th>
					<th style="background:#8ea9db;padding:7px 5px;border:1px solid #000">QTY ( BAL )</th>';
					if($opsi == 'acc'){
						$html .='<th style="background:#8ea9db;padding:7px 0;border:1px solid #000" colspan="2">HARGA LEMBAR</th>
						<th style="background:#8ea9db;padding:7px 5px;border:1px solid #000" colspan="2">HARGA</th>
						<th style="background:#8ea9db;padding:7px 5px;border:1px solid #000" colspan="2">HARGA TOTAL</th>';
					}
				$html .='</tr>
			</thead>';
			$html .='<tbody>';
				$po_dtl = $this->db->query("SELECT * FROM trs_po_lm_detail d
				INNER JOIN m_produk_lm p ON d.id_m_produk_lm=p.id_produk_lm
				WHERE d.no_po_lm='$po_lm->no_po_lm'
				ORDER BY p.nm_produk_lm,p.isi_lm,p.ukuran_lm");
				foreach($po_dtl->result() as $r){
					if($r->jenis_qty_lm == 'kg'){
						$isi = '-';
						$kg = ' ( KG )';
					}else{
						$isi = number_format($r->isi_lm,0,',','.');
						if($po_lm->jenis_lm == "PEKALONGAN"){
							$kg = ' ( PACK )';
						}else{
							($r->jenis_qty_lm == 'pack') ? $kg = '' : $kg = ' ( IKAT )';
						}
					}
					if($opsi == 'acc'){
						$html .='<tr>
							<td style="width:22%;padding:7px 5px;border:1px solid #000">'.$r->nm_produk_lm.'</td>
							<td style="width:10%;padding:7px 5px;border:1px solid #000">'.$r->ukuran_lm.'</td>
							<td style="width:8%;padding:7px 5px;border:1px solid #000">'.$isi.'</td>
							<td style="width:13%;padding:7px 5px;border:1px solid #000">'.number_format($r->qty_bal,0,',','.').''.$kg.'</td>
							<td style="width:5%;padding:7px 5px;border:1px solid #000;border-right:0;text-align:left">Rp.</td>
							<td style="width:10%;padding:7px 5px;border:1px solid #000;border-left:0;text-align:right">'.round($r->harga_lembar_lm,2).'</td>
							<td style="width:5%;padding:7px 5px;border:1px solid #000;border-right:0;text-align:left">Rp.</td>
							<td style="width:10%;padding:7px 5px;border:1px solid #000;border-left:0;text-align:right">'.number_format($r->harga_pori_lm,0,',','.').'</td>
							<td style="width:5%;padding:7px 5px;border:1px solid #000;border-right:0;text-align:left">Rp.</td>
							<td style="width:12%;padding:7px 5px;border:1px solid #000;border-left:0;text-align:right">'.number_format($r->harga_total_lm,0,',','.').'</td>
						</tr>';
					}else{
						$html .='<tr>
							<td style="width:25%;padding:7px 5px;border:1px solid #000">'.$r->nm_produk_lm.'</td>
							<td style="width:25%;padding:7px 5px;border:1px solid #000">'.$r->ukuran_lm.'</td>
							<td style="width:25%;padding:7px 5px;border:1px solid #000">'.$isi.'</td>
							<td style="width:25%;padding:7px 5px;border:1px solid #000">'.number_format($r->qty_bal,0,',','.').''.$kg.'</td>
						</tr>';
					}
				}
				if($po_lm->note_po_lm != ''){
					$html .='<tr>
						<td style="text-align:left;padding-top:3px" colspan="10">NOTE : '.$po_lm->note_po_lm.'</td>
					</tr>';
				}
			$html .='</tbody>';
		$html .= '</table>';

		// TTD
		($po_lm->status_lm1 == 'Y') ? $lm1 = ';background:url('.base_url('assets/gambar/ttd_manager.png').') center no-repeat' : $lm1 = '';
		($po_lm->status_lm2 == 'Y') ? $lm2 = ';background:url('.base_url('assets/gambar/ttd_head_manager.png').') center no-repeat' : $lm2 = '';

		$html .= '<table style="margin:40px 0 0;padding:0;font-size:12px;text-align:center;border-collapse:collapse;color:#2f75b5;font-weight:bold;width:100%">';
			$html .='<tr>
				<td style="width:16%"></td>
				<td style="width:5%"></td>
				<td style="width:11%"></td>
				<td style="width:40%"></td>
				<td style="width:28%"></td>
			</tr>
			<tr>
				<td style="padding:3px 3px 35px;vertical-align:top;text-align:left;border:2px solid #2f75b5" colspan="2">RECEIVED :</td>
				<td style="padding-bottom:30px;border:2px solid #2f75b5;background:url('.base_url('assets/gambar/cc-po-lam.png').')center no-repeat"></td>
				<td></td>
				<td style="padding:3px;text-align:left;color:#000;font-weight:normal;vertical-align:top">Hormat Kami</td>
			</tr>
			<tr>
				<td style="border:2px solid #2f75b5">CHECKED BY</td>
				<td style="border:2px solid #2f75b5" colspan="2">APPROVED BY</td>
			</tr>
			<tr>
				<td style="border:2px solid #2f75b5;padding:30px'.$lm1.'"></td>
				<td style="border:2px solid #2f75b5;padding:30px'.$lm2.'" colspan="2"></td>
				<td></td>
				<td style="padding:15px 3px 3px;text-align:left;color:#000;font-weight:normal;vertical-align:top">'.$po_lm->nm_pelanggan_lm.'</td>
			</tr>
			<tr>
				<td style="border:2px solid #2f75b5">MANAGER</td>
				<td style="border:2px solid #2f75b5" colspan="2">HEAD MANAGER</td>
			</tr>';
		$html .= '</table>';
		
		$judul = 'PO: '.$po_lm->no_po_lm.' - '.$po_lm->nm_pelanggan_lm;
		$this->m_fungsi->newMpdf($judul, '', $html, 5, 5, 5, 5, 'P', 'A4', $judul.'.pdf');
	}

	function hapus()
	{
		$jenis    = $_POST['jenis'];
		$field    = $_POST['field'];
		$id       = $_POST['id'];

		if ($jenis == "trs_po") {

			$load_po    = $this->db->query("SELECT *from trs_po a 
			Join m_hub b ON a.id_hub=b.id_hub 
			Join akses_db_hub c ON b.nm_hub=c.nm_hub
			WHERE $field ='$id'")->row();
			
			$result = $this->m_master->query("DELETE FROM $jenis WHERE  $field = '$id'");
			$result = $this->m_master->query("DELETE FROM trs_po_detail WHERE  $field = '$id'");

			$koneksi_hub    = $this->db->query("SELECT*from m_hub a
			join akses_db_hub b ON b.nm_hub=a.nm_hub where a.id_hub='$load_po->id_hub' ")->row();

			$db_ppi_hub = '$'.$koneksi_hub->nm_db_hub;
			$db_ppi_hub = $this->load->database($koneksi_hub->nm_db_hub, TRUE);

			// hapus hub
			$result_hub = $db_ppi_hub->query("DELETE FROM $jenis WHERE  $field = '$id'");
			$result_hub = $db_ppi_hub->query("DELETE FROM trs_po_detail WHERE  $field = '$id'");

			if($load_po->img_po != 'foto.jpg')
			{
				// Hapus File Foto
				unlink("assets/gambar_po/".$load_po->img_po);
			}

		} else if ($jenis == "trs_po_lm") {
			$cek = $this->db->query("SELECT*FROM trs_po_lm WHERE id='$id' AND status_lm2='Y' AND status_lm='Approve'")->num_rows();
			$po = $this->db->query("SELECT*FROM trs_po_lm WHERE id='$id'")->row();
			if($cek == 0){
				$delDetail = $this->m_master->query("DELETE FROM trs_po_lm_detail WHERE no_po_lm = '$po->no_po_lm'");
				if($delDetail){
					$result = array(
						'result' => $this->m_master->query("DELETE FROM trs_po_lm WHERE id='$id'"),
						'msg' => 'HAPUS PO LM!',
					);
				}
			}else{
				$result = array(
					'result' => false,
					'msg' => 'PO SUDAH DI ACC!',
				);
			}
		} else if ($jenis == "trs_po_bhnbk") {			
			$no_po       = $_POST['no_po'];
			$delDetail   = $this->db->query("DELETE FROM trs_po_bhnbk_detail where no_po_bhn='$no_po' ");

			if($delDetail){
				$result = $this->m_master->query("DELETE FROM $jenis WHERE  $field = '$id'");
			}
		} else if ($jenis == "trs_po_lm_detail") {			
			$id_po_header = $_POST['id_po_header'];
			$po_lm = $this->db->query("SELECT*FROM trs_po_lm WHERE id='$id_po_header'")->row();
			if($po_lm->opsi_disc != ''){
				$result = array(
					'result' => false,
					'msg' => 'HAPUS DISKON / FEE DAHULU!',
				);
			}else{
				$result = array(
					'result' => $this->m_master->query("DELETE FROM $jenis WHERE  $field = '$id'"),
					'msg' => 'HAPUS PO LM DETAIL!',
				);
			}
		} else {

			$result = $this->m_master->query("DELETE FROM $jenis WHERE  $field = '$id'");
		}

		echo json_encode($result);
	}

	function batal()
	{
		$jenis   = $_POST['jenis'];
		$field   = $_POST['field'];
		$id = $_POST['id'];

		$result = $this->m_transaksi->batal($id, $jenis, $field);


		echo json_encode($result);
	}

	function prosesData()
	{
		$jenis   = $_POST['jenis'];

		$result = $this->m_transaksi->$jenis();


		echo json_encode($result);
	}

	function Verifikasi_all()
	{
		$id  = $_GET['no_po'];

		if ($this->session->userdata('level') == "Admin") {
			
		}


		echo json_encode($result);
	}


	function get_edit()
	{
		$id    = $this->input->post('id');
		$jenis    = $this->input->post('jenis');
		$field    = $this->input->post('field');

		if ($jenis == "trs_po") {
			$header =  $this->m_master->get_data_one($jenis, $field, $id)->row();
			if($header->img_po == null || $header->img_po == '') {
				$url_foto = base_url('assets/gambar_po/foto.jpg');
			}else{
				$url_foto = base_url('assets/gambar_po/') . $header->img_po;
			}
			$detail = $this->db->query("SELECT * FROM trs_po a 
			JOIN trs_po_detail b ON a.no_po = b.no_po
			JOIN m_pelanggan c ON a.id_pelanggan=c.id_pelanggan
			LEFT JOIN m_kab d ON c.kab=d.kab_id
			LEFT JOIN m_produk e ON b.id_produk=e.id_produk
			WHERE a.no_po = '$header->no_po' ORDER BY b.id")->result();
			
			// $design = $this->db->query("SELECT i.*,a.* FROM trs_design_header a
			// INNER JOIN trs_po b ON b.kode_po=a.kode_po
			// INNER JOIN trs_design_detail c ON a.id_dg=c.id_hdr
			// INNER JOIN m_produk i ON a.id_produk=i.id_produk
			// WHERE b.no_po='$header->no_po' AND c.jenis_dtl='FD'
			// GROUP BY a.kode_po, a.id_pelanggan, a.id_produk");
			// $img = $this->db->query("SELECT c.*,a.* FROM trs_design_header a
			// INNER JOIN trs_po b ON b.kode_po=a.kode_po
			// INNER JOIN trs_design_detail c ON a.id_dg=c.id_hdr
			// WHERE b.no_po='$header->no_po' AND a.id_produk='$r->id_produk' AND c.jenis_dtl='FD'
			// GROUP BY a.kode_po, a.id_pelanggan, a.id_produk, c.id_dtl");
			// $html .= '<div class="list-design" style="display:flex;padding:6px">';

			$html = '';
			$design = $this->db->query("SELECT i.nm_produk,m.img_mc,d.* FROM trs_po_detail d
			INNER JOIN m_produk i ON d.id_produk=i.id_produk
			INNER JOIN m_produk_mc m ON i.id_produk=m.id_produk
			WHERE d.no_po='$header->no_po'
			GROUP BY d.id_produk");
			if($design->num_rows() != 0){
				$html .= '<div class="card-body row" style="padding : 5px;font-weight:bold">
					<div class="col-md-2">Design</div>
					<div class="col-md-10">';
						$o = 0;
						foreach($design->result() as $r){
							$o++;
							$html .= '<div>'.$r->nm_produk.'</div>';
							// data
							$img = $this->db->query("SELECT i.nm_produk,m.img_mc,d.* FROM trs_po_detail d
							INNER JOIN m_produk i ON d.id_produk=i.id_produk
							INNER JOIN m_produk_mc m ON i.id_produk=m.id_produk
							WHERE d.no_po='$header->no_po' AND d.id_produk='$r->id_produk'
							GROUP BY d.id_produk, m.id_mc");
							$html .= '<div class="list-design" style="display:flex;padding:6px">';
								foreach($img->result() as $i){
									$o++;
									$preview = 'p'.$o;
									$html .= '<div style="margin-right:8px">
										<img id="'.$preview.'" src="'.base_url().'assets/mc/'.$i->img_mc.'" alt="preview design" width="100" class="shadow-sm img-thumbnail" onclick="imgClick('."'".$preview."'".')">
									</div>';
								}
							$html .= '</div>';
						}
					$html .= '</div>
				</div>';
			}
			$data = ["header" => $header, "detail" => $detail, "url_foto" => $url_foto, "html" => $html];
		} else if ($jenis == "trs_po2") {
			$header = $this->db->query("SELECT *,(select nm_hub from m_hub h where a.id_hub=h.id_hub)nm_hub FROM trs_po a WHERE $field = '$id'")->row();
			if($header->img_po==null || $header->img_po=='') {
				$url_foto = base_url('assets/gambar_po/foto.jpg');
			}else{
				$url_foto = base_url('assets/gambar_po/') . $header->img_po;
			}
			$detail = $this->db->query("SELECT *,(select nm_hub from m_hub h where a.id_hub=h.id_hub)nm_hub FROM trs_po a 
			JOIN trs_po_detail b ON a.no_po = b.no_po
			JOIN m_pelanggan c ON a.id_pelanggan=c.id_pelanggan
			LEFT JOIN m_kab d ON c.kab=d.kab_id
			LEFT JOIN m_produk e ON b.id_produk=e.id_produk
			WHERE a.no_po = '$header->no_po' ORDER BY b.id")->result();

			$html = '';
			$design = $this->db->query("SELECT i.nm_produk,m.img_mc,d.* FROM trs_po_detail d
			INNER JOIN m_produk i ON d.id_produk=i.id_produk
			INNER JOIN m_produk_mc m ON i.id_produk=m.id_produk
			WHERE d.no_po='$header->no_po'
			GROUP BY d.id_produk");
			if($design->num_rows() != 0){
				$html .= '<div class="card-body row" style="padding : 5px;font-weight:bold">
					<div class="col-md-2">Design</div>
					<div class="col-md-10">';
						$o = 0;
						foreach($design->result() as $r){
							$o++;
							$html .= '<div>'.$r->nm_produk.'</div>';
							// data
							$img = $this->db->query("SELECT i.nm_produk,m.img_mc,d.* FROM trs_po_detail d
							INNER JOIN m_produk i ON d.id_produk=i.id_produk
							INNER JOIN m_produk_mc m ON i.id_produk=m.id_produk
							WHERE d.no_po='$header->no_po' AND d.id_produk='$r->id_produk'
							GROUP BY d.id_produk, m.id_mc");
							$html .= '<div class="list-design" style="display:flex;padding:6px">';
								foreach($img->result() as $i){
									$o++;
									$preview = 'p'.$o;
									$html .= '<div style="margin-right:8px">
										<img id="'.$preview.'" src="'.base_url().'assets/mc/'.$i->img_mc.'" alt="preview design" width="100" class="shadow-sm img-thumbnail" onclick="imgClick('."'".$preview."'".')">
									</div>';
								}
							$html .= '</div>';
						}
					$html .= '</div>
				</div>';
			}
			$data = ["header" => $header, "detail" => $detail, "url_foto" => $url_foto, "html" => $html];
		} else if ($jenis == "trs_so_detail") {
			$data =  $this->m_master->query(
				"SELECT * 
                FROM trs_so_detail a
                JOIN m_produk b ON a.id_produk=b.id_produk
                JOIN m_pelanggan c ON a.id_pelanggan=c.id_pelanggan
                WHERE id = '$id' "
			)->row();
		} else if ($jenis == "trs_wo") {
			// $header =  $this->m_master->get_data_one($jenis, $field, $id)->row();
			$header =  $this->db->query("SELECT a.* ,CONCAT(b.no_so,'.',urut_so,'.',rpt) as no_so_1 from $jenis a LEFT JOIN trs_so_detail b ON a.no_so = b.id WHERE a.id='$id' ")->row();
			$detail = $this->m_master->get_data_one("trs_wo_detail", "no_wo", $header->no_wo)->row();

			// $data =  $this->m_master->query(
			// 	"SELECT a.id as id_wo,a.*,b.*,c.*,d.*,e.* FROM trs_wo a 
			// 	JOIN trs_wo_detail b ON a.no_wo=b.no_wo 
			// 	JOIN m_produk c ON a.id_produk=c.id_produk 
			// 	JOIN m_pelanggan d ON a.id_pelanggan=d.id_pelanggan 				
			// 	JOIN trs_so_detail e ON a.no_so=concat(e.no_so,'.',e.urut_so,'.',e.rpt)
			// 	WHERE a.id= '".$id."'
			// 	order by a.id
            //     "
			// )->row();

			$data = ["header" => $header, "detail" => $detail];
		} else if ($jenis == "SJ") {
			$header =  $this->m_master->query("SELECT a.*,IFNULL(qty_sj,0)qty_sj FROM trs_po_detail a 
                                    LEFT JOIN 
                                    (
                                    SELECT no_po,kode_mc,SUM(qty) AS qty_sj FROM `trs_surat_jalan` WHERE STATUS <> 'Batal' GROUP BY no_po,kode_mc
                                    )AS t_sj
                                    ON a.`no_po` = t_sj.no_po
                                    AND a.kode_mc = t_sj.kode_mc
                                    WHERE a.no_po ='$id' AND (a.qty - ifnull(qty_sj,0)) <> 0")->result();

			$data = ["header" => $header, "detail" => ""];
		} else if ($jenis == "SJView") {
			$header =  $this->m_master->query("SELECT a.*,IFNULL(qty_sj,0)qty_sj FROM trs_po_detail a 
                                    LEFT JOIN 
                                    (
                                    SELECT no_po,kode_mc,SUM(qty) AS qty_sj FROM `trs_surat_jalan` WHERE STATUS <> 'Batal' GROUP BY no_po,kode_mc
                                    )AS t_sj
                                    ON a.`no_po` = t_sj.no_po
                                    AND a.kode_mc = t_sj.kode_mc
                                    WHERE a.no_po ='$id' ")->result();

			$data = ["header" => $header, "detail" => ""];
		} else {
			$data =  $this->m_master->get_data_one($jenis, $field, $id)->row();
		}
		echo json_encode($data);
	}

	function status()
	{
		$jenis      = $this->input->post('jenis');
		$status      = $this->input->post('status');
		$id      = $this->input->post('id');
		$field      = $this->input->post('field');

		$result = $this->m_master->update_status($status, $id, $jenis, $field);

		echo json_encode($result);
	}

	public function print_invoice()
	{
		$id = $this->input->get('id');

		$data['id_penjualan'] = $id;

		$this->load->view('Transaksi/print_invoice', $data);
	}

	function checkout()
	{
		// $params =(object)$this->input->post();

		$valid = $this->m_transaksi->checkout();
		echo json_encode($valid);
	}

    function cek_bcf()
    {
        $kualitas = $this->input->post("kd");
        echo json_encode(array(
			"bcf" => cek_subs_bcf($kualitas)
		));
    }

    function cek_flute()
    {
        $kualitas   = $this->input->post("kd");
        $flute      = $this->input->post("flute");
        echo json_encode(array(
			"flute" => cek_subs_flute($kualitas,$flute)
		));
    }

	function Cetak_PO()
	{
		$id  = $_GET['no_po'];

		// $query = $this->m_master->get_data_one("trs_po_detail", "no_po", $id);
        $query_header = $this->db->query("SELECT * FROM trs_po a 
        JOIN m_pelanggan b ON a.id_pelanggan=b.id_pelanggan 
        WHERE a.no_po = '$id' ");
        
        $data = $query_header->row();
        
        $query = $this->db->query("SELECT * FROM trs_po a 
        JOIN trs_po_detail b ON a.no_po = b.no_po
        JOIN m_pelanggan c ON a.id_pelanggan=c.id_pelanggan
        LEFT JOIN m_kab d ON c.kab=d.kab_id
        LEFT JOIN m_produk e ON b.id_produk=e.id_produk
        WHERE a.no_po = '$id' ");

		$html = '';


		if ($query->num_rows() > 0) {

			$html .= '<table width="100%" border="0" cellspacing="0" style="font-size:14px;font-family: ;">
                        <tr style="font-weight: bold;">
                            <td colspan="15" align="center">
                            <b>( No. ' . $id . ' )</b>
                            </td>
                        </tr>
                 </table><br>';

            $html .= '<table width="100%" border="0" cellspacing="0" style="font-size:12px;font-family: ;">

            <tr>
                <td width="10 %"  align="left">Tgl PO</td>
                <td width="5%" > : </td>
                <td width="85 %" > '. $this->m_fungsi->tanggal_format_indonesia($data->tgl_po) .'</td>
            </tr>
            <tr>
                <td align="left">Customer</td>
                <td> : </td>
                <td> '. $data->nm_pelanggan .'</td>
            </tr>
            </table><br>';

			$html .= '<table width="100%" border="1" cellspacing="1" cellpadding="3" style="border-collapse:collapse;font-size:12px;font-family: ;">
                        <tr style="background-color: #cccccc">
                            <th width="2%" align="center">No</th>
                            <th width="10%" align="center">Item</th>
                            <th width="12%" align="center">Flute : RM : BB</th>
                            <th width="10%" align="center">Uk. Box</th>
                            <th width="8%" align="center">Uk. Sheet</th>
                            <th width="10%" align="center">Creasing </th>
                            <th width="10%" align="center">Kualitas</th>							
							<th width="10%" align="center">ETA</th>
                            <th width="8%" align="center">Qty</th>';
			if($this->session->userdata("level")!="PPIC"){

							$html .='
							<th width="10%" align="center">Harga <br> (Rp)</th>
							<th width="10%" align="center">Total <br> (Rp)</th>
							';
			}
					$html .='</tr>';
			$no = 1;
			$tot_qty = $tot_value = $tot_total = 0;
			foreach ($query->result() as $r) {

                $total = $r->price_inc*$r->qty;
				$html .= '

                            <tr >
                                <td align="center">' . $no . '</td>
                                <td align="center">' . $r->nm_produk . '</td>
                                <td align="center">' . $r->flute . ' : ' . $r->rm . ' : ' . $r->bb . '</td>
                                <td align="center">' . $r->l_panjang . ' x ' . $r->l_lebar . ' x ' . $r->l_tinggi . '</td>
                                <td align="center">' . $r->ukuran_sheet . '</td>
                                <td align="center">' . $r->creasing . ' : ' . $r->creasing2 . ' : ' . $r->creasing3 . '</td>
                                <td align="left">' . $r->kualitas . '</td>
                                <td align="center" style="color:red">' . $this->m_fungsi->tanggal_ind($r->eta) . '</td>
                                <td align="right">' . number_format($r->qty, 0, ",", ".") . '</td>								';
				if($this->session->userdata("level")!="PPIC"){
						$html .= '
								<td align="right">' . number_format($r->price_inc, 0, ",", ".") . '</td>
                                <td align="right">' . number_format($total, 0, ",", ".") . '</td>
								';
				}
						$html .= '</tr>';

				$no++;
				$tot_qty += $r->qty;
				$tot_price_inc += $r->price_inc;
				$tot_total += $total;
			}
			$html .='
                        <tr style="background-color: #cccccc">
                            <td align="center" colspan="8"><b>Total</b></td>
                            <td align="right" ><b>' . number_format($tot_qty, 0, ",", ".") . '</b></td>						
							';
			if($this->session->userdata("level")!="PPIC"){
					$html .= '
							<td align="right" ><b>' . number_format($tot_price_inc, 0, ",", ".") . '</b></td>
                            <td align="right" ><b>' . number_format($tot_total, 0, ",", ".") . '</b></td>';
			}
					$html .= '</tr>';
			$html .= '
                 </table>';
		} else {
			$html .= '<h1> Data Kosong </h1>';
		}

		// $this->m_fungsi->_mpdf($html);
		$this->m_fungsi->template_kop('PURCHASE ORDER',$id,$html,'L','1');
		// $this->m_fungsi->mPDFP($html);
	}
	
	function cetak_rfp()
	{
		$id  = $_GET['no_po'];

		// $query = $this->m_master->get_data_one("trs_po_detail", "no_po", $id);
        $query_header = $this->db->query("SELECT*from lampiran_rfp order by no");
        
        $data = $query_header->row();
        
        $query = $this->db->query("SELECT*from lampiran_rfp order by no ");

		$html = '';


		if ($query->num_rows() > 0) {

			$html .= '<table width="100%" border="1" cellspacing="1" cellpadding="3" style="border-collapse:collapse;font-size:12px;font-family: ;">
                        <tr style="background-color: #cccccc">
                            <th style="background-color: #cccccc" weight="10px" align="center">no</th>
                            <th style="background-color: #cccccc" weight="10px" align="center">item</th>
                            <th style="background-color: #cccccc" weight="10px" align="center">company</th>
                            <th style="background-color: #cccccc" weight="10px" align="center">delivery</th>
                            <th style="background-color: #cccccc" weight="10px" align="center">area</th>
                            <th style="background-color: #cccccc" weight="10px" align="center">p</th>
                            <th style="background-color: #cccccc" weight="10px" align="center">l</th>
                            <th style="background-color: #cccccc" weight="10px" align="center">t</th>
                            <th style="background-color: #cccccc" weight="10px" align="center">material</th>
                            <th style="background-color: #cccccc" weight="10px" align="center">Categori</th>
                            <th style="background-color: #cccccc" weight="10px" align="center">flute</th>
                            <th style="background-color: #cccccc" weight="10px" align="center">weight/pcs</th>
                            <th style="background-color: #cccccc" weight="10px" align="center">BB RUMUS</th>
                            <th style="background-color: #cccccc" weight="10px" align="center">QTY Pak Indra</th>
                            <th style="background-color: #cccccc" weight="10px" align="center">QTY Hanif</th>
                            <th style="background-color: #cccccc" weight="10px" align="center">RM</th>
                            <th style="background-color: #cccccc" weight="10px" align="center">TONASE</th>
							</tr>
							
							';
			$no        = 1;
			$p_sheet   = '';
			$l_sheet   = '';
			$bb        = 0;
			foreach ($query->result() as $r) {

				// ubah uk box ke sheet
				if($r->p == '' || $r->p == 0 || $r->l == '' || $r->l == 0 || $r->t == 0 || $r->t == ''){
					$p_sheet = 0 ;
					$l_sheet = 0 ;
				}else{
					if($r->flute == ""){
						$p_sheet = 0 ;
						$l_sheet = 0 ;
					} else if($r->flute == "BC"){
						$p_sheet = 2 * ($r->p + $r->l) + 61;
						$l_sheet = $r->l + $r->t + 23;
	
					} else if($r->flute == "C") {
						$p_sheet = 2 * ($r->p + $r->l) + 43;
						$l_sheet = $r->l + $r->t + 13;
	
					} else if($r->flute == "B") {
						$p_sheet = 2 * ($r->p + $r->l) + 39;
						$l_sheet = $r->l + $r->t + 9;
	
					} else {
						$p_sheet = 0;
						$l_sheet = 0;
					}
				}


			// bb
				if($r->flute == 'B'){
					$bb =  ($r->tl_al_i + ($r->bmf_i*1.36) + $r->bl_i) / 1000 * $p_sheet / 1000 * $l_sheet / 1000 ;
		
					$bb = $bb ;
		
				}else if($r->flute == 'C'){
					$bb = ($r->tl_al_i + ($r->cmf_i*1.46) + $r->cl_i) / 1000 * $p_sheet / 1000 * $l_sheet / 1000 ;
					
		
				}else if($r->flute == 'BC'){
		
					$bb = ($r->tl_al_i + ($r->bmf_i*1.36) + $r->bl_i + ($r->cmf_i*1.46) + $r->cl_i) / 1000 * $p_sheet / 1000 * $l_sheet / 1000 ;
		
					$bb = $bb ;
		
				}else{
					$bb = 0;
				}


				// rm

				$out = intval(1800/$l_sheet);
				if($out >= 5){
					$out = 5;
				}

				$rm       = ceil($p_sheet * $r->qty_pak_hanif / $out / 1000);
				$ton      = ceil($r->qty_pak_hanif * number_format($bb, 4));

				if ($r->qty_pak_indra==0 || $r->qty_pak_indra== null)
				{
					$qty_indra = 0;
				}else{
					$qty_indra = $r->qty_pak_indra;
				}
				
				if ($r->qty_pak_hanif==0 || $r->qty_pak_hanif== null)
				{
					$qty_hanif = 0;
				}else{
					$qty_hanif = $r->qty_pak_hanif;
				}
				$html .= '

                            <tr >
                                <td align="center">' . $r->no . '</td>
                                <td align="left">' . $r->item . '</td>
                                <td align="center">' . $r->company . '</td>
                                <td align="center">' . $r->delivery . '</td>
                                <td align="center">' . $r->area . '</td>
                                <td align="center">' . $r->p . '</td>
                                <td align="center">' . $r->l . '</td>
                                <td align="center">' . $r->t . '</td>
                                <td align="center">' . $r->material . '</td>
                                <td align="center">' . $r->kategori . '</td>
                                <td align="center">' . $r->flute . '</td>
                                <td align="center">' . $r->weight . '</td>
                                <td align="center">' . $bb .'</td>
                                <td align="center">' . $qty_indra . '</td>
                                <td align="center">' . $qty_hanif . '</td>
                                <td align="center">' . $rm . '</td>
                                <td align="center">' . $ton . '</td>
								';
						$html .= '</tr>';

			}
			$html .= '
                 </table>';
		} else {
			$html .= '<h1> Data Kosong </h1>';
		}

		echo ("<title>DATA ITEM FKS</title>");
		echo ($html);
		
		// $this->m_fungsi->_mpdf_hari('L', 'A4', '-', $html, 'DATA ITEM FKS.pdf', 5, 5, 5, 15);
	}
	
    function Cetak_wa_po()
	{
		$id  = $_GET['no_po'];

		// $query = $this->m_master->get_data_one("trs_po_detail", "no_po", $id);
        $query = $this->db->query("SELECT * FROM trs_po a 
        JOIN trs_po_detail b ON a.no_po = b.no_po
        JOIN m_pelanggan c ON a.id_pelanggan=c.id_pelanggan
        LEFT JOIN m_kab d ON c.kab=d.kab_id
        LEFT JOIN m_produk e ON b.id_produk=e.id_produk
        WHERE a.no_po = '$id' order by b.id");

		$html = '';


		if ($query->num_rows() > 0) {

            $data   = $query->row();

			$kode_po ='<br> ( ' . $data->kode_po . ' )';
	

			$html .= '<table width="100%" border="0" cellspacing="0" style="font-size:14px;">
                        <tr style="font-weight: bold;">
                            <td colspan="15" align="center">
                            </td>
                        </tr>
                 </table><br>';

				$html .= '<table width="100%" border="0" cellspacing="0" style="font-size:22px;">
				<tr align="left" style="background-color: #cccccc">
					<th>PO '.substr($data->kategori,2,10).' '. $data->nm_pelanggan .' '.$kode_po.'</th>
				</tr>
				<tr align="left">
					<th>ITEM :</th>';
				 
				$no = 1;
				foreach ($query->result() as $r) { 
					$html .= '
								<tr>
									<td>' . $no . '. ' . $r->nm_produk . '</td>
								</tr>';
					$no++;
				}
				
				$html .= '<table width="100%" border="0" cellspacing="0" style="font-size:22px;">
				
				<tr align="left">
					<th>QTY :</th>';
				 
				$no = 1;
				foreach ($query->result() as $r) { 
					$html .= '
								<tr>
									<td>' . $no . '. ' . number_format($r->qty, 0, ",", ".") . '</td>
								</tr>';
					$no++;
				}
	 
				$html .= '<table width="100%" border="0" cellspacing="0" style="font-size:22px;">
					<tr align="left">
						<th>RM :</th>';
                        
			$no = 1;
			foreach ($query->result() as $r) { 
				$html .= '
                            <tr>
                                <td>' . $no . '. ' . number_format($r->rm, 0, ",", ".") . '</td>
                            </tr>';
				$no++;
			}

            $html .= '
            <tr align="left">
                <th>Harga / kg:</th>
            </tr>';

            $no       = 1;
            $toton    = 0;
            foreach ($query->result() as $r) { 
				$harga_kg   = round($r->price_exc / $r->berat_bersih);
				$html .= '
                            <tr>
                                <td>' . $no . '. ' . number_format($harga_kg, 0, ",", ".") . '</td>
                            </tr>';
                $toton += $r->ton;
				$no++;
			}
			
			$html .= '
            <tr align="left">
                <th>Berat Bersih : Tonase</th>
            </tr>';
			
            $no       = 1;
            $toton    = 0;
            foreach ($query->result() as $r) { 
				$html .= '
                            <tr>
                                <td>' . $no . '. ' . str_replace(".",",",$r->bb) . ' : ' . number_format($r->ton, 0, ",", ".") . ' Kg</td>
                            </tr>';
                $toton += $r->ton;
				$no++;
			}

            $html .= '
            </th>
            <tr align="left">
                <th>Total Tonase PO : '. number_format($toton, 0, ",", ".") .' Kg</th>
            </tr>';
            
			if($data->kategori=='K_SHEET')
			{

				$html .= '<table width="100%" border="0" cellspacing="0" style="font-size:22px;">
				<tr align="left">
					<th>Harga P11</th>';

				$no       = 1;
				foreach ($query->result() as $r) { 
					$html .= '</th>
							<tr align="left">
								<td>'.$no.'. ( '. $data->p11 .' )</td>
							</tr>';
					$no++;
				}
				
			}
			

			$html .= '<table width="100%" border="0" cellspacing="0" style="font-size:22px;">
				<tr align="left">
					<th>ETA Item</th>';
				 
				$no = 1;
				foreach ($query->result() as $r) { 
					$html .= '
						<tr>
							<td>' . $no . '. ' . $this->m_fungsi->tanggal_format_indonesia($r->eta) . '</td>
						</tr>';
					$no++;
				}

			$html .= '
			</th>
			<tr align="left">
				<th>Roll Produksi Sudah Ada</th>
			</tr>';

            $html .= '<tr align="left">
                <th>Cust Bisa Menyesuaikan Kita</th>
            </tr>
            ';

                        
			$html .= '</table>';
		} else {
			$html .= '<h1> Data Kosong </h1>';
		}

		echo $html;
		// $this->m_fungsi->_mpdf($html);
		// $this->m_fungsi->template_kop('PURCHASE ORDER', $id ,$html,'L','0');
		// $this->m_fungsi->mPDFP($html);
	}
   
	function Cetak_img_po()
	{
		$id  = $_GET['no_po'];

		// $query = $this->m_master->get_data_one("trs_po_detail", "no_po", $id);
        $query = $this->db->query("SELECT * FROM trs_po a 
        JOIN trs_po_detail b ON a.no_po = b.no_po
        JOIN m_pelanggan c ON a.id_pelanggan=c.id_pelanggan
        LEFT JOIN m_kab d ON c.kab=d.kab_id
        LEFT JOIN m_produk e ON b.id_produk=e.id_produk
        WHERE a.no_po = '$id' ");

		$html = '';


		if ($query->num_rows() > 0) {

            $data   = $query->row();

			$html .= "<table width=\"100%\" border=\"0\" cellspacing=\"0\" style=\"font-size:14px;\">
                        <tr style=\"font-weight: bold;\">
							<td align=\"center\">
								<img src=\"" . base_url() . "assets/gambar_po/$data->img_po\"  />
							</td>
                        </tr>
                 </table><br>";


                        
			$html .= '</table>';
		} else {
			$html .= '<h1> Data Kosong </h1>';
		}

		// $this->m_fungsi->_mpdf($html);
		// $this->m_fungsi->template_kop($id, $id ,$html,'P','1');
		$this->m_fungsi->_mpdf_hari('P', 'A4', $data->kode_po, $html, $data->kode_po.'.pdf', 5, 5, 5, 10);
		// $this->m_fungsi->mPDFP($html);
	}

	function Cetak_rekap_penjualan()
	{
		$jns        = $_GET['jns'];
		$bulan      = $_GET['bulan'];
		$cekpdf     = $_GET['ctk'];
		$judul      = 'PO BAHAN BAKU ';
		$position   = 'P';


		$param      = $judul;
		$unit       = $this->session->userdata('unit');
		$chari      = '';

		if($jns=='BOX')
		{
			// BOX
			$query_header = $this->db->query("SELECT a.tgl_po,a.kode_po,e.nm_pelanggan,a.id_hub,d.nm_hub,b.qty,c.berat_bersih,CEILING(b.qty*c.berat_bersih) as tonase,CEILING(b.qty*c.berat_bersih/0.70) as bahan_bk FROM trs_po a 
			join trs_po_detail b on a.kode_po=b.kode_po
			join m_produk c on b.id_produk=c.id_produk
			join m_hub d on a.id_hub=d.id_hub
			join m_pelanggan e on a.id_pelanggan=e.id_pelanggan
			where a.id_hub <>'7' and a.tgl_po like '%$bulan%' and a.status_app3='Y'
			order by a.id_hub,a.tgl_po");			

		}else{

			// LAMINASI
			$query_header = $this->db->query("SELECT po.tgl_lm,hub.nm_hub,lm.nm_pelanggan_lm,po.no_po_lm,dtl.qty_bal,(dtl.qty_bal * (case when i.jenis_qty_lm='ikat' then 7 else 50 end)) AS ton,ROUND((dtl.qty_bal * (case when i.jenis_qty_lm='ikat' then 7 else 50 end))/0.75) AS bahan_baku,i.* FROM trs_po_lm po
			INNER JOIN trs_po_lm_detail dtl ON po.no_po_lm=dtl.no_po_lm
			LEFT JOIN m_hub hub ON hub.id_hub=po.id_hub
			INNER JOIN m_pelanggan_lm lm ON lm.id_pelanggan_lm=po.id_pelanggan
			INNER JOIN m_produk_lm i ON i.id_produk_lm=dtl.id_m_produk_lm
			WHERE (po.id_hub!='7' AND po.id_hub!='0') AND i.jenis_qty_lm!='kg' and po.tgl_lm like '%$bulan%' and po.jenis_lm='PPI'
			GROUP BY po.id_hub,po.tgl_lm,po.id_pelanggan,po.no_po_lm,dtl.id_m_produk_lm
			");

		}
       
        
		if ($query_header->num_rows() > 0) 
		{
			if($jns=='BOX')
			{
				$chari .= '<table width="100%" border="1" cellspacing="1" cellpadding="3" style="border-collapse:collapse;font-size:12px;font-family: ;">
                        <tr style="background-color: #fcf22c">
                            <th width="2%" align="center">No</th>
                            <th width="12%" align="center">tgl po</th>
                            <th width="15%" align="center">kode po</th>
                            <th width="10%" align="center">nm pelanggan</th>
                            <th width="5%" align="center">id hub</th>
                            <th width="18%" align="center">nm hub</th>
                            <th width="10%" align="center">qty</th>
                            <th width="10%" align="center">berat bersih</th>
                            <th width="10%" align="center">tonase</th>
                            <th width="10%" align="center">bahan bk</th>
							</tr>';
				$no = 1;
				$nmhub = '';
				foreach ($query_header->result() as $r) {
					 
					if($nmhub <> $r->nm_hub)
					{
						$chari .= '
								<tr >
									<td align="center">&nbsp;</td>
									<td align="left"></td>
									<td align="left"></td>
									<td align="left"></td>
									<td align="left"></td>
									<td align="left"></td>
									<td align="right"></td>
									<td align="right"></td>
									<td align="right"></td>
									<td align="right"></td>
									</tr>';
					}

					$chari .= '
								<tr >
									<td align="center">' . $no . '</td>
									<td align="left">' . $r->tgl_po . '</td>
									<td align="left">' . $r->kode_po . '</td>
									<td align="left">' . $r->nm_pelanggan . '</td>
									<td align="left">' . $r->id_hub . '</td>
									<td align="left">' . $r->nm_hub . '</td>
									<td align="right">' . $r->qty . '</td>
									<td align="right">' . $r->berat_bersih . '</td>
									<td align="right">' . $r->tonase . '</td>
									<td align="right">' . $r->bahan_bk . '</td>
									</tr>';

					$no++;
					$nmhub = $r->nm_hub;
				}
				
			}else{

				$chari .= '<table width="100%" border="1" cellspacing="1" cellpadding="3" style="border-collapse:collapse;font-size:12px;font-family: ;">
                        <tr style="background-color: #fcf22c">
                            <th width="2%" align="center">No</th>
                            <th width="10%" align="center">tgl lm</th>
                            <th width="20%" align="center">nm hub</th>
                            <th width="10%" align="center">nm pelanggan lm</th>
                            <th width="20%" align="center">no po lm</th>
                            <th width="10%" align="center">qty bal</th>
                            <th width="10%" align="center">ton</th>
                            <th width="10%" align="center">bahan baku</th>
							</tr>';
				$no       = 1;
				$nmhub2   = '';
				foreach ($query_header->result() as $r) {

					if($nmhub2 <> $r->nm_hub)
					{
						$chari .= '
								<tr >
									<td align="center">&nbsp;</td>
									<td align="left"></td>
									<td align="left"></td>
									<td align="left"></td>
									<td align="left"></td>
									<td align="left"></td>
									<td align="right"></td>
									<td align="right"></td>
									</tr>';
					}

					$chari .= '

								<tr >
									<td align="center">' . $no . '</td>
									<td align="left">' . $r->tgl_lm . '</td>
									<td align="left">' . $r->nm_hub . '</td>
									<td align="left">' . $r->nm_pelanggan_lm . '</td>
									<td align="left">' . $r->no_po_lm . '</td>
									<td align="right">' . $r->qty_bal . '</td>
									<td align="right">' . $r->ton . '</td>
									<td align="right">' . $r->bahan_baku . '</td>
									</tr>';

					$no++;
					
					$nmhub2 = $r->nm_hub;
				}


			}
			
			

            
		} else {
			$chari .= '<h1> Data Kosong </h1>';
		}

		// $this->m_fungsi->_mpdf($html);
		// $this->m_fungsi->template_kop('PURCHASE ORDER',$id,$html,'P','1');
		// $this->m_fungsi->mPDFP($html);

		// $data['prev']   = $chari;

		switch ($cekpdf) {
			case 0;
				echo ("<title>$judul</title>");
				echo ($chari);
				break;

			case 1;
				// $this->M_fungsi->_mpdf_hari($position, 'A4', $judul, $chari, $no_po_bhn.'.pdf', 5, 5, 5, 10);

				$this->m_fungsi->newMpdf($judul, '', $chari, 10, 3, 3, 3, 'P', 'TT', $no_po_bhn.'.pdf');
				break;

				
				
			case 2;
				header("Cache-Control: no-cache, no-store, must-revalidate");
				header("Content-Type: application/vnd-ms-excel");
				header("Content-Disposition: attachment; filename= $judul.xls");
				$this->load->view('app/master_cetak', $data);
				break;
		}

	}
	
	function Cetak_PO_BAHAN()
	{
		$no_po_bhn    = $_GET['no_po_bhn'];
		$judul        = 'PO BAHAN BAKU ';
		$position     = 'P';
		$cekpdf       = '1';


		$param        = $judul;
		$unit         = $this->session->userdata('unit');
		$chari        = '';

        $query_header = $this->db->query("SELECT * FROM trs_po_bhnbk a JOIN m_hub b ON a.hub   = b.id_hub WHERE a.no_po_bhn = '$no_po_bhn' ");
        
        $data = $query_header->row();

		$chari .= "
			 <table style=\"border-collapse:collapse;font-family: Century Gothic; font-size:12px; color:#000;\" width=\"100%\"  border=\"\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">
			 <thead>
				  <tr>
					   
					   <td colspan=\"20\">
							<b>
								 <tr>
									  <td align=\"center\" style=\"font-size:18;border-bottom: none;\"><b>$data->nm_hub</b></td>
								 </tr>
								 <tr>
									  <td align=\"center\" style=\"font-size:8px;text-transform: capitalize;\">$data->alamat</td>
								 </tr>
								 <tr>
									  <td align=\"center\" style=\"font-size:8px;\">Kode Pos $data->kode_pos </td>
								 </tr>
							</b>
					   </td>
				  </tr>
			 </table>";
		$chari .= "
			 <table style=\"border-collapse:collapse;font-family: tahoma; font-size:6px\" width=\"100%\" align=\"center\" border=\"0\">
				  <tr>
					   <td> &nbsp; </td>
				  </tr> 
			 </table>";
								 
		$chari .= "
			 <table style=\"border-collapse:collapse;font-family: tahoma; font-size:2px\" width=\"100%\" align=\"center\" border=\"1\">     
				  <tr>
					   <td colspan=\"20\" style=\"border-top: none;border-right: none;border-left: none;\"></td>
				  </tr> 
			 </table>";
		$chari .= "
			 <table style=\"border-collapse:collapse;font-family: tahoma; font-size:4px\" width=\"100%\" align=\"center\" border=\"1\">     
				  <tr>
					   <td colspan=\"20\" style=\"border-top: none;border-right: none;border-left: none;border-bottom: 2px solid black;font-size:5px\"></td>
				  </tr> 
			 </table>";
		$chari .= "
			 <table style=\"border-collapse:collapse;font-family: tahoma; font-size:8px\" width=\"100%\" align=\"center\" border=\"0\">     
				  <tr>
					   <td>&nbsp;</td>
				  </tr> 
			 </table>";
		$chari .= "
			 <table style=\"border-collapse:collapse;font-family: Tahoma; font-size:11px\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"1\" cellpadding=\"3\">
				  <tr>
					   <td colspan=\"20\" width=\"15%\" style=\"text-align:center; font-size:20px;\"><b>" . $param . "</b></td>
				  </tr>
			 </table>";

		if ($query_header->num_rows() > 0) 
		{
			$chari .= '<table width="100%" border="0" cellspacing="0" style="font-size:14px;font-family: ;">
                        <tr style="font-weight: bold;">
                            <td colspan="15" align="center">
                            <b>( No. '.$data->no_po_bhn.' )</b>
                            </td>
                        </tr>
                 </table>
				 <br>
				 <br>
				 ';

            $chari .= '<table width="100%" border="0" cellspacing="0" style="font-size:12px;font-family: ;">

				<tr>
					<td align="left" width="30%" >Tgl PO</td>
					<td align="center" width="5%" > : </td>
					<td align="right" width="30%" > '. $this->m_fungsi->tanggal_format_indonesia($data->tgl_bhn) .'</td>
					<td align="left" width="35%" ></td>
					</tr>
				<tr>
					<td align="left" >Qty Po</td>
					<td align="center" > : </td>
					<td align="right" > '. number_format($data->ton_bhn, 0, ",", ".") .' Kg</td>
					<td align="left" ></td>

				</tr>
				<tr>
					<td align="left" >Harga / Kg</td>
					<td align="center" > : </td>
					<td align="right" >Rp. '. number_format($data->hrg_bhn, 0, ",", ".") .'</td>
					<td align="left" ></td>

				</tr>
				<tr>
					<td align="left" >Total</td>
					<td align="center" > : </td>
					<td align="right" >Rp. '. number_format($data->total, 0, ",", ".") .'</td>
					<td align="left" ></td>

				</tr>
            </table>
			<br>
			<br>
			<br>
			
			<table style="width:100%;margin-bottom:5px;text-align:center;border-collapse:collapse;font-size:11px" border="0">
				<tr>
					<td style="border-bottom:0;padding-top:3px;width:32%"></td>
					<td style="border-bottom:0;padding-top:3px;width:32%">ADMIN</td>
					<td style="border:0;width:2%"></td>
					<td style="border-bottom:0;padding-top:3px;width:32%">DIREKTUR</td>
				</tr>
				<tr>
					<td style="border-top:0;border-bottom:0;padding:23px 0"></td>
					<td style="border-top:0;border-bottom:0;padding:23px 0"></td>
					<td style="border:0"></td>
					<td style="border-top:0;border-bottom:0;padding:23px 0"></td>
				</tr>
				<tr>
					<td style="border-top:0;padding-bottom:3px;"></td>
					<td style="border-top:0;padding-bottom:3px;">(. . . . . . . . . . . . . . . )</td>
					<td style="border:0"></td>
					<td style="border-top:0">(. . . . . . . . . . . . . . . )</td>
				</tr>
			</table>
			
			<br>
			<br>
			
			<table style="width:100%;border-top:2px solid #000">
				<tr>
					<td style="text-align:right;font-size:12px"></td>
				</tr>
			</table>
			';
		} else {
			$chari .= '<h1> Data Kosong </h1>';
		}

		// $this->m_fungsi->_mpdf($html);
		// $this->m_fungsi->template_kop('PURCHASE ORDER',$id,$html,'P','1');
		// $this->m_fungsi->mPDFP($html);

		// $data['prev']   = $chari;

		switch ($cekpdf) {
			case 0;
				echo ("<title>$judul</title>");
				echo ($chari);
				break;

			case 1;
				// $this->M_fungsi->_mpdf_hari($position, 'A4', $judul, $chari, $no_po_bhn.'.pdf', 5, 5, 5, 10);

				$this->m_fungsi->newMpdf($judul, '', $chari, 10, 3, 3, 3, 'P', 'TT', $no_po_bhn.'.pdf');
				break;

				
				
			case 2;
				header("Cache-Control: no-cache, no-store, must-revalidate");
				header("Content-Type: application/vnd-ms-excel");
				header("Content-Disposition: attachment; filename= $judul.xls");
				$this->load->view('app/master_cetak', $data);
				break;
		}

	}

	function Cetak_SO()
	{
		$id  = $_GET['no_so'];
		$query = $this->m_master->get_data_one("trs_so_detail", "no_so", $id);

		$html = '';

		if ($query->num_rows() > 0) {
			$data = $query->row();

			$style_top = "border-top:1px solid;";
			$style_top_bold = "border-top:3px solid;";

			$total = $data->harga * $data->qty;
			$ppn = round($total * 0.1);
			$sub_total = $total + $ppn;

			$html .= '<table width="100%" border="0" cellspacing="0" style="font-size:12px;font-family: ;">  
                        <tr>
                            <td width="15%" style="' . $style_top . '">Kode PO</td>
                            <td style="' . $style_top . '">' . $data->kode_po . '</td>
                            <td width="30%" style="' . $style_top . '"></td>
                            <td width="15%" style="' . $style_top . '">Input Date</td>
                            <td width="20%" style="' . $style_top . '">' . $data->tgl_so . '</td>
                        </tr>  
                        <tr>
                            <td style="">No PO</td>
                            <td style="">' . $data->no_po . '</td>
                            <td style=""></td>
                            <td style="">Created By</td>
                            <td style="">' . $data->add_user . '</td>
                        </tr> 
                        <tr>
                            <td style="">Sales</td>
                            <td style="">' . $data->salesman . '</td>
                            <td style=""></td>
                            <td style=""></td>
                            <td style=""></td>
                        </tr>
                        <tr>
                            <td style="' . $style_top . 'padding-top:10px">Customer</td>
                            <td style="' . $style_top . '"></td>
                            <td style="' . $style_top . '"></td>
                            <td style="' . $style_top . '">TOP</td>
                            <td style="' . $style_top . '">' . $data->top . '</td>
                        </tr> 
                        <tr>
                            <td  style="padding-left:20px" colspan="3">' . $data->nm_pelanggan . '</td>
                            <td  style="">PO Date</td>
                            <td style="">' . $data->tgl_po . '</td>
                        </tr>  
                        <tr>
                            <td  style="padding-left:20px" colspan="3">' . $data->alamat . '</td>
                            <td  style="">Phone NO.</td>
                            <td style="">' . $data->no_telp . '</td>
                        </tr>  
                        <tr>
                            <td  style="padding-left:20px" colspan="3"></td>
                            <td  style="">Fax NO.</td>
                            <td style="">' . $data->fax . '</td>
                        </tr> 
                        <tr>
                            <td style="' . $style_top . 'padding-top:10px" >Shipped To  </td>
                            <td style="' . $style_top . 'padding-top:10px" colspan="4">: ' . $data->alamat_kirim . '</td>
                        </tr>  
                        <tr>
                            <td style="" >Location </td>
                            <td style="" colspan="4">: ' . $data->lokasi . ' </td>
                        </tr> 
                        <tr>
                            <td style="' . $style_top . 'padding-top:10px">Description</td>
                            <td style="' . $style_top . '"></td>
                            <td style="' . $style_top . '"></td>
                            <td style="' . $style_top . '" colspan="2">
                                <table width="100%" border="0" cellspacing="0" style="font-size:12px;font-family: ;"> 
                                    <tr>
                                        <td width="30%">Order Qty</td>
                                        <td width="30%">Price / Unit</td>
                                        <td width="30%">Ammount</td>
                                    </tr>
                                </table>
                            </td>
                        </tr> 
                        <tr>
                            <td style="">Kode PO</td>
                            <td style="">' . $data->kode_po . '</td>
                            <td style=""></td>
                            <td style="" colspan="2">
                                <table width="100%" border="0" cellspacing="0" style="font-size:12px;font-family: ;"> 
                                    <tr>
                                        <td width="30%" align="right" style="padding-right:5px">' . number_format($data->qty) . '</td>
                                        <td width="30%" align="right" style="padding-right:5px">' . number_format($data->harga) . '</td>
                                        <td width="30%" align="right" style="padding-right:5px">' . number_format($total) . '</td>
                                    </tr>
                                </table>
                            </td>
                        </tr> 
                        <tr>
                            <td style="">Kode MC</td>
                            <td style="" colspan="4">' . $data->kode_mc . '</td>
                        </tr>  
                        <tr>
                            <td style="">Produk</td>
                            <td style="" colspan="4">' . $data->nm_produk . '</td>
                        </tr>  
                        <tr>
                            <td style="">Uk. Box</td>
                            <td style="" colspan="4">' . $data->ukuran . '</td>
                        </tr>   
                        <tr>
                            <td style="">Material</td>
                            <td style="" colspan="4">' . $data->material . '</td>
                        </tr>   
                        <tr>
                            <td style="">Flute</td>
                            <td style="" colspan="4">' . $data->flute . '</td>
                        </tr>   
                        <tr>
                            <td style="">Creasing</td>
                            <td style="" colspan="4">' . $data->creasing . '</td>
                        </tr> 
                        <tr>
                            <td style="' . $style_top . 'padding-top:10px;border-style: dotted;"></td>
                            <td style="' . $style_top . 'border-style: dotted;"></td>
                            <td style="' . $style_top . 'border-style: dotted;"></td>
                            <td style="' . $style_top . 'border-style: dotted;" colspan="2">
                                <table width="100%" border="0" cellspacing="0" style="font-size:12px;font-family: ;"> 
                                    <tr>
                                        <td width="30%" align="right" style="padding-right:5px">' . number_format($data->qty) . '</td>
                                        <td width="30%" align="right" style="padding-right:5px">&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                        <td width="30%" align="right" style="padding-right:5px">' . number_format($total) . '</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>  
                        <tr>
                            <td style="' . $style_top . 'padding-top:10px;" colspan="3" valign="top">
                                REMARK PO ORI-JANGAN GEMBOS
                            </td>
                            <td style="' . $style_top . '" colspan="2">
                                <table width="100%" border="0" cellspacing="0" style="font-size:12px;font-family: ;"> 
                                    <tr>
                                        <td width="30%"  align="left" style="padding-right:5px">Total Value</td>
                                        <td width="30%" colspan="2" align="right" style="padding-right:5px">' . number_format($total) . '</td>
                                    </tr>
                                    <tr>
                                        <td width="30%"  align="left" style="padding-right:5px">PPN 10%</td>
                                        <td width="30%" colspan="2" align="right" style="padding-right:5px">' . number_format($ppn) . '</td>
                                    </tr>
                                    <tr>
                                        <td width="30%"  align="left" style="padding-right:5px">Final Ammount</td>
                                        <td width="30%" colspan="2" align="right" style="padding-right:5px">' . number_format($sub_total) . '</td>
                                    </tr>
                                </table>
                            </td>
                        </tr> 

                        <tr>
                            <td colspan="5" style="' . $style_top_bold . 'padding-top:10px">
                                <table width="100%" border="0" cellspacing="0" style="font-size:12px;font-family: ;"> 
                                    <tr>
                                        <td width="25%" align="center">Sales / Marketing</td>
                                        <td width="25%" align="center">Costing</td>
                                        <td width="25%" align="center">Menyetujui</td>
                                        <td width="25%" align="center">Mengetahui</td>
                                    </tr> 
                                </table>
                            </td>
                        </tr> 

                      </table>';
		} else {
			$html .= '<h1> Data Kosong </h1>';
		}

		$this->m_fungsi->_mpdf($html);
		// $this->m_fungsi->mPDFP($html);
	}

	function Cetak_WO()
	{
		$id  = $_GET['no_wo'];
		// $query = $this->m_master->get_data_one("trs_wo", "no_wo", $id);
		$query = $this->db->query("SELECT a.id as id_wo,a.*,b.*,c.*,d.*,e.* FROM trs_wo a 
				JOIN trs_wo_detail b ON a.no_wo=b.no_wo 
				JOIN m_produk c ON a.id_produk=c.id_produk 
				JOIN m_pelanggan d ON a.id_pelanggan=d.id_pelanggan 				
				JOIN trs_so_detail e ON a.no_so=e.id
				WHERE a.no_wo='$id'
				order by a.id	");
		$data = $query->row();

		if ($data->sambungan == 'G'){
			$join = 'Glue';
		} else if ($data->sambungan == 'S'){
			$join = 'Stitching';
		} else if ($data->sambungan == 'D'){
			$join = 'Die Cut';
		} else if ($data->sambungan == 'DS'){
			$join = 'Double Stitching';
		} else if ($data->sambungan == 'GS'){
			$join = 'Glue Stitching';
		}else {
			$join = '-';
		}
		
		$tgl_wo        = ($data->tgl_wo == null || $data->tgl_wo == '0000-00-00' ? '0000-00-00' : $data->tgl_wo);
		$eta_so        = ($data->eta_so == null || $data->eta_so == '0000-00-00' ? '0000-00-00' : $data->eta_so);
		
		$data_detail = $this->m_master->get_data_one("trs_wo_detail", "no_wo", $id)->row();

		$html       = '';
		$box        = "border: 1px solid black";
		$angka_b    = 'style="text-align: center;color:red;font-weight:bold;"';
		$angka_s    = 'style="text-align: left;color:red;font-weight:bold"';
		$bottom     = "border-bottom: 1px solid black;";
		$top        = "border-top: 1px solid black;";

		if ($query->num_rows() > 0) {
			
			if($data->kategori=="K_BOX")
			{
				$ukuran_sheet_p    = $data->ukuran_sheet_p+5;
				$trim = '5 mm';
			}else{
				$ukuran_sheet_p    = $data->ukuran_sheet_p;
				$trim ='-';
			}

			$html .= '<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:14px;font-family: ;">
                            
                            <tr style="font-weight: bold;">
                                <td colspan="15" align="center">
                                <b> ( ' . $data->no_wo . ' )</b>
                                </td>
                            </tr>
                     </table><br>';

					 $html .= '<table width="100%" cellspacing="1" cellpadding="3" border="0" style="font-size:12px;font-family: ;">  
					 <tr>
						 <td width="15%" >CUSTOMER</td>
						 <td width="30%" >: <b>' . $data->nm_pelanggan . '</b></td>
						 <td width="10%" > </td>
						 <td width="15%" >Tgl Wo</td>
						 <td width="30%" >: <b>' . $this->m_fungsi->tanggal_format_indonesia($tgl_wo) . '</b></td>
					 </tr>
					 <tr>
						 <td>Item</td>
						 <td>: <b>' . $data->nm_produk . '</b></td>
						 <td></td>
						 <td width="15%" >No Po</td>
						 <td width="20%" >: <b>' . $data->no_po . '</b></td>
					 </tr>
					 <tr>
						 <td>Ukuran Box</td>
						 <td>: <b>' . $data->ukuran . '</b></td>
						 <td></td>
						 <td>Out</td>
						 <td>: <b>' . $data->line . '</b></td>
					 </tr>
					 <tr>
						 <td>Ukuran Sheet</td>
						 <td >: <b>' . $ukuran_sheet_p . ' x ' . $data->ukuran_sheet_l . '</b></td>
						 <td></td>
						 <td>Tgl Kirim</td>
						 <td style="color:red" >: <b>' . $this->m_fungsi->tanggal_format_indonesia($tgl_wo) . '</b></td>

					 </tr>
					 <tr>
						<td>Trim</td>
						<td>: <b>'. $trim .'</b></td>
						<td></td>
						<td>ETA</td>
						<td style="color:red" >: <b>' . $this->m_fungsi->tanggal_format_indonesia($eta_so) . '
						</b></td>

					 </tr>
					 <tr>
						<td>Kualitas</td>
						<td >: <b>' . $data->kualitas . '</b></td>	
						<td></td>
						<td>No Batch</td>
						<td>: <b>' . $data->batchno . '</b></td>
					 </tr>
					 <tr>
						<td>Type Box</td>
						<td>: <b>' . $data->tipe_box . '</b></td>					 
						<td></td>
						<td>Berat Box</td>
						<td>: <b>' . $data->berat_bersih . ' Kg</b></td>
					 </tr>
					 <tr>
						<td>Warna</td>
						<td>: <b>' . $data->warna . '</b></td>
						<td></td>
						<td>Flute</td>
						<td>: <b>' . $data->flute . '</b></td>
					 </tr>
					 <tr>
						<td style="">Jumlah Order</td>
						<td style="">: <b>' . number_format($data->qty, 0, ",", ".") . '</b> PCS</td>
						<td></td>
						<td>Joint</td>
						<td>: <b>' . $join . '</b></td>
					 </tr>
					 <tr>
						<td style="">Jumlah Ikat</td>
						<td style="">: <b>' . $data->jml_ikat . '</b></td>
						<td></td>
						<td>Jumlah Paku</td>
						<td>: <b>' . $data->jml_paku .  '</b></td>
					 </tr><br>
				 </table>';

			if ( $data->kategori == 'K_BOX')
			{
				$html .='<br><br>
				<table border="0" cellspacing="0" width="100%" id="tabel_box">
					<tr>
					
					<td width="15%" > </td>
					<td width="5%" style="border-right: 1px solid black;"> </td>
					<td width="15%" style=" '. $box .'" > </td>
					<td width="15%" style=" '. $box .'" > <br>&nbsp;</br> </td>
					<td width="15%" style=" '. $box .'" > </td>
					<td width="15%" style=" '. $box .'" > </td>
					<td width="20%" style="border-left: 1px solid black;border-left: 1px solid black;" ><b> &nbsp; ' . number_format($data->flap1, 0, ",", ".") . '
					</b></td>
					</tr>
					<tr>
					<td style="" > 
						<br>&nbsp;</br>
					</td>
					<td style="background-size: 30% 100%;" ><img src="'.base_url('assets/gambar/kupingan1.png').'" width="50" height="50"> </td>
					<td style="'. $box .'" > </td>
					<td style="'. $box .'" > </td>
					<td style="'. $box .'" > </td>
					<td style="'. $box .'" > </td>
					<td style="border-left: 1px solid black;" ><b> &nbsp; ' . number_format($data->creasing2, 0, ",", ".") . '
					</b></td>
					</tr>
					<tr>
					<td> <br>&nbsp;</br></td>
					<td style="border-right: 1px solid black;" align="right"><b>' . $data->kupingan . '</b></td>
					<td style =" '. $box .'" > </td>
					<td style =" '. $box .'" > </td>
					<td style =" '. $box .'" > </td>
					<td style =" '. $box .'" > </td>
					<td style=" border-left: 1px solid black;" ><b> &nbsp; ' . number_format($data->flap2, 0, ",", ".") . '
					</b></td>
					</tr>
					<tr>
					<td align="center" > <br>&nbsp;</br>
					</td>
					<td align="center"> 
					</td>
					<td align="center" ><b> ' . number_format($data->p1, 0, ",", ".") . '
					</b></td>
					<td align="center" ><b> ' . number_format($data->l1, 0, ",", ".")  . '
					</b></td>
					<td align="center" ><b> ' . number_format($data->p2, 0, ",", ".") . '
					</b></td>
					<td align="center" ><b> ' . number_format($data->l2, 0, ",", ".") . '
					</b></td>
					<td align="center" > </td>
					</tr>

				</table>';

			}else{
				
				$html .='<br><br>
				<table border="0" cellspacing="0" cellpadding="0" width="100%" id="tabel_sheet">
					<tr>
					<td width="15%"> <br>&nbsp;</td>
					<td width="5%"> </td>
					<td width="15%" style="'. $top .'border-left: 1px solid #000" > </td>
					<td width="15%" style="'. $top .'"></td>
					<td width="15%" style="'. $top .'"> </td>
					<td width="15%" style="'. $top .'border-right: 1px solid #000"></td>
					<td width="20%"><b> &nbsp; ' . number_format($data->flap1, 0, ",", ".") . '
					</b></td>
					</tr>
					<tr>
					<td> 
						<br>&nbsp;</br>
					</td>
					<td> </td>
					<td style="'. $top .'border-left: 1px solid #000" > </td>
					<td style="'. $top .'"> </td>
					<td style="'. $top .'"> </td>
					<td style="'. $top .'border-right: 1px solid #000" > </td>
					<td><b> &nbsp; ' . number_format($data->creasing2, 0, ",", ".") . '
					</b></td>
					</tr>
					<tr>
					<td> <br>&nbsp;</br></td>
					<td></td>
					<td style="'. $top .''.$bottom.' border-left: 1px solid #000" > </td>
					<td style="'. $top .''.$bottom.'" > </td>
					<td style="'. $top .''.$bottom.'" > </td>
					<td style="'. $top .''.$bottom.' border-right: 1px solid #000" > </td>
					<td><b> &nbsp; ' . number_format($data->flap2, 0, ",", ".") . '
					</b></td>
					</tr>
					<tr>
					<td align="center" > <br>&nbsp;</br>
					</td>
					<td align="center" > 
					</td>
					<td align="center" colspan="4"><b> '. number_format($data->p1_sheet, 0, ",", ".") .'
					</b></td>
					<td align="center"> </td>
					</tr>

				</table> ';

			}

			
			$query_detail = $this->db->query("SELECT*FROM plan_cor where no_wo ='$id' ");

			if( $query_detail->num_rows()>0 )
			{				
				foreach($query_detail->result() as $rinci)
				{
	
					$tgl_plan    = ($rinci->tgl_plan == null || $rinci->tgl_plan == '0000-00-00' ? '0000-00-00' : $rinci->tgl_plan);
	
					$tgl_ok      = $this->m_fungsi->tanggal_format_indonesia($rinci->tgl_plan);
	
					
					$html .= '<br>
						<table width="100%" border="1" cellspacing="0" cellpadding="3" style="font-size:12px;font-family: ;">  
							<tr>
								<td align="center" width="%" rowspan="2" style="background-color: #cccccc" ><b>No</b></td>
								<td align="center" width="%" rowspan="2" style="background-color: #cccccc" ><b>PROSES PRODUKSI</b></td>
								<td align="center" width="%" colspan="2" style="background-color: #cccccc" ><b>HASIL PRODUKSI</b></td>
								<td align="center" width="%" rowspan="2" style="background-color: #cccccc" ><b>RUSAK</b></td>
								<td align="center" width="%" rowspan="2" style="background-color: #cccccc" ><b>HASIL BAIK</b></td>
								<td align="center" width="%" rowspan="2" style="background-color: #cccccc" ><b>KETERANGAN</b></td>
							</tr>
							<tr>
								<td align="center" width="%" style="background-color: #cccccc"><b>TGL</b></td>
								<td align="center" width="%" style="background-color: #cccccc"><b>HASIL JADI</b></td>
							</tr>
	
							<tr>
								<td align="center" width="5%" >1</td>
								<td align="" width="20%" >CORUUGATOR</td>
								<td align="center" width="20%" >' . $tgl_ok . '</td>
								<td align="center" width="1%" >' . number_format($rinci->total_cor_p, 0, ",", ".")  . '</td>
								<td align="center" width="15%" >' . number_format($rinci->bad_cor_p, 0, ",", ".")  . '</td>
								<td align="center" width="15%" >' . number_format($rinci->good_cor_p, 0, ",", ".")  . '</td>
								<td align="" width="15%" >' . number_format($rinci->ket_plan, 0, ",", ".")  . '</td>
							</tr>
							<tr>
								<td align="center">2</td>
								<td align="" >FLEXO</td>
								<td align="center" >' . $tgl_ok . '</td>
								<td align="center" >' . $data_detail->hasil_flx . '</td>
								<td align="center" >' . $data_detail->rusak_flx . '</td>
								<td align="center" >' . $data_detail->baik_flx . '</td>
								<td align="" >' . $data_detail->ket_flx . '</td>
							</tr>
							<tr>
								<td align="center" rowspan="8" valign="middle">3</td>
								<td align="" >FINISHING</td>
								<td align="" style="border-bottom:hidden;border-right:hidden"></td>
								<td align="" style="border-bottom:hidden;border-right:hidden"></td>
								<td align="" style="border-bottom:hidden;border-right:hidden"></td>
								<td align="" style="border-bottom:hidden;border-right:hidden"></td>
								<td align="" style="border-bottom:hidden;"></td>
							</tr>
							<tr>
								<td align="right" >Glue</td>
								<td align="center" style="border-top:hidden;border-right:hidden">' . $tgl_ok . '</td>
	
								<td align="center" style="border-top:hidden;border-right:hidden;border-right:hidden">' . $data_detail->hasil_glu . '</td>
								<td align="center" style="border-top:hidden;border-right:hidden">' . $data_detail->rusak_glu . '</td>
								<td align="center" style="border-top:hidden;border-right:hidden">' . $data_detail->baik_glu . '</td>
								<td align="" style="border-top:hidden;">' . $data_detail->ket_glu . '</td>
							</tr>
							<tr>
								<td align="right" >Stitching</td>
								<td align="center" >' . $tgl_ok . '</td>
								<td align="center" >' . $data_detail->hasil_stc . '</td>
								<td align="center" >' . $data_detail->rusak_stc . '</td>
								<td align="center" >' . $data_detail->baik_stc . '</td>
								<td align="" >' . $data_detail->ket_stc . '</td>
							</tr>
							<tr>
								<td align="right" >Die Cut</td>
								<td align="center" >' . $tgl_ok . '</td>
								<td align="center" >' . $data_detail->hasil_dic . '</td>
								<td align="center" >' . $data_detail->rusak_dic . '</td>
								<td align="center" >' . $data_detail->baik_dic . '</td>
								<td align="" >' . $data_detail->ket_dic . '</td>
							</tr>
							<tr>
								<td align="right" >Glue Stitching</td>
								<td align="center" style="border-top:hidden;border-right:hidden">' . $tgl_ok . '</td>
	
								<td align="center" style="border-top:hidden;border-right:hidden;border-right:hidden">' . $data_detail->hasil_glu . '</td>
								<td align="center" style="border-top:hidden;border-right:hidden">' . $data_detail->rusak_glu . '</td>
								<td align="center" style="border-top:hidden;border-right:hidden">' . $data_detail->baik_glu . '</td>
								<td align="" style="border-top:hidden;">' . $data_detail->ket_glu . '</td>
							</tr>
							<tr>
								<td align="right" >Double Stitching</td>
								<td align="center" style="border-top:hidden;border-right:hidden">' . $tgl_ok . '</td>
	
								<td align="center" style="border-top:hidden;border-right:hidden;border-right:hidden">' . $data_detail->hasil_glu . '</td>
								<td align="center" style="border-top:hidden;border-right:hidden">' . $data_detail->rusak_glu . '</td>
								<td align="center" style="border-top:hidden;border-right:hidden">' . $data_detail->baik_glu . '</td>
								<td align="" style="border-top:hidden;">' . $data_detail->ket_glu . '</td>
							</tr>
							<tr>
								<td align="right" >Asembly Partisi</td>
								<td align="center" >' . $tgl_ok . '</td>
								<td align="center" >' . $data_detail->hasil_dic . '</td>
								<td align="center" >' . $data_detail->rusak_dic . '</td>
								<td align="center" >' . $data_detail->baik_dic . '</td>
								<td align="" >' . $data_detail->ket_dic . '</td>
							</tr>
							<tr>
								<td align="right" >Slitter Manual</td>
								<td align="center" >' . $tgl_ok . '</td>
	
								<td align="center" >' . $data_detail->hasil_dic . '</td>
								<td align="center" >' . $data_detail->rusak_dic . '</td>
								<td align="center" >' . $data_detail->baik_dic . '</td>
								<td align="" >' . $data_detail->ket_dic . '</td>
							</tr>
							<tr>
								<td align="center" >4</td>
								<td align="" >GUDANG</td>
								<td align="center" >' . $tgl_ok . '</td>
								<td align="center" >' . $data_detail->hasil_gdg . '</td>
								<td align="center" >' . $data_detail->rusak_gdg . '</td>
								<td align="center" >' . $data_detail->baik_gdg . '</td>
								<td align="" >' . $data_detail->ket_gdg . '</td>
							</tr>
							<tr>
								<td align="center" >5</td>
								<td align="" >EXPEDISI / PENGIRIMAN</td>
								<td align="center" >' . $tgl_ok . '</td>
								<td align="center" >' . $data_detail->hasil_exp . '</td>
								<td align="center" >' . $data_detail->rusak_exp . '</td>
								<td align="center" >' . $data_detail->baik_exp . '</td>
								<td align="" >' . $data_detail->ket_exp . '</td>
							</tr>
						</table>';
								
				}
			}else{
				$html .= '<br>
						<table width="100%" border="1" cellspacing="0" cellpadding="3" style="font-size:12px;font-family: ;">  
							<tr>
								<td align="center" width="%" rowspan="2" style="background-color: #cccccc" >No</td>
								<td align="center" width="%" rowspan="2" style="background-color: #cccccc" >PROSES PRODUKSI</td>
								<td align="center" width="%" colspan="2" style="background-color: #cccccc" >HASIL PRODUKSI</td>
								<td align="center" width="%" rowspan="2" style="background-color: #cccccc" >RUSAK</td>
								<td align="center" width="%" rowspan="2" style="background-color: #cccccc" >HASIL BAIK</td>
								<td align="center" width="%" rowspan="2" style="background-color: #cccccc" >KETERANGAN</td>
							</tr>
							<tr>
								<td align="center" width="%" style="background-color: #cccccc">TGL</td>
								<td align="center" width="%" style="background-color: #cccccc">HASIL JADI</td>
							</tr>
	
							<tr>
								<td align="center" width="5%" >1</td>
								<td align="" width="20%" >CORUUGATOR</td>
								<td align="center" width="20%" >0</td>
								<td align="center" width="1%" >0</td>
								<td align="center" width="15%" >0</td>
								<td align="center" width="15%" >0</td>
								<td align="" width="15%" >0</td>
							</tr>
							<tr>
								<td align="center">2</td>
								<td align="" >FLEXO</td>
								<td align="center" >0</td>
								<td align="center" >0</td>
								<td align="center" >0</td>
								<td align="center" >0</td>
								<td align="" >0</td>
							</tr>
							<tr>
								<td align="center" rowspan="8" valign="middle">3</td>
								<td align="" >FINISHING</td>
								<td align="" style="border-bottom:hidden;border-right:hidden"></td>
								<td align="" style="border-bottom:hidden;border-right:hidden"></td>
								<td align="" style="border-bottom:hidden;border-right:hidden"></td>
								<td align="" style="border-bottom:hidden;border-right:hidden"></td>
								<td align="" style="border-bottom:hidden;"></td>
							</tr>
							<tr>
								<td align="right" >Glue</td>
								<td align="center" style="border-top:0;border-right:0">0</td>
								<td align="center" style="border-top:0;border-right:0;">0</td>
								<td align="center" style="border-top:0;border-right:0;">0</td>
								<td align="center" style="border-top:0;border-right:0;">0</td>
								<td align="" style="border-top:0;">0</td>
							</tr>
							<tr>
								<td align="right" >Stitching</td>
								<td align="center" >0</td>
								<td align="center" >0</td>
								<td align="center" >0</td>
								<td align="center" >0</td>
								<td align="" >0</td>
							</tr>
							<tr>
								<td align="right" >Die Cut</td>
								<td align="center" >0</td>
								<td align="center" >0</td>
								<td align="center" >0</td>
								<td align="center" >0</td>
								<td align="" >0</td>
							</tr>
							<tr>
								<td align="right" >Glue Stitching</td>
								<td align="center" style="border-top:0;border-right:0">0</td>
								<td align="center" style="border-top:0;border-right:0;">0</td>
								<td align="center" style="border-top:0;border-right:0;">0</td>
								<td align="center" style="border-top:0;border-right:0;">0</td>
								<td align="" style="border-top:0;">0</td>
							</tr>
							<tr>
								<td align="right" >Double Stitching</td>
								<td align="center" style="border-top:0;border-right:0">0</td>
								<td align="center" style="border-top:0;border-right:0;">0</td>
								<td align="center" style="border-top:0;border-right:0;">0</td>
								<td align="center" style="border-top:0;border-right:0;">0</td>
								<td align="" style="border-top:0;">0</td>
							</tr>
							<tr>
								<td align="right" >Asembly Partisi</td>
								<td align="center" >0</td>
								<td align="center" >0</td>
								<td align="center" >0</td>
								<td align="center" >0</td>
								<td align="" >0</td>
							</tr>
							<tr>
								<td align="right" >Slitter Manual</td>
								<td align="center" >0</td>
	
								<td align="center" >0</td>
								<td align="center" >0</td>
								<td align="center" >0</td>
								<td align="" >0</td>
							</tr>
							<tr>
								<td align="center" >4</td>
								<td align="" >GUDANG</td>
								<td align="center" >0</td>
								<td align="center" >0</td>
								<td align="center" >0</td>
								<td align="center" >0</td>
								<td align="" >0</td>
							</tr>
							<tr>
								<td align="center" >5</td>
								<td align="" >EXPEDISI / PENGIRIMAN</td>
								<td align="center" >0</td>
								<td align="center" >0</td>
								<td align="center" >0</td>
								<td align="center" >0</td>
								<td align="" >0</td>
							</tr>
						</table>';				

			}

	
		} else {
			$html .= '<h1> Data Kosong </h1>';
		}

		// $this->m_fungsi->_mpdf($html);
		
		$this->m_fungsi->template_kop('WORK ORDER',$id ,$html,'P','1');
		// $this->m_fungsi->mPDFP($html);
	}

	function Cetak_WO_()
	{
		$id  = 'WO-2021-0000000002';
		$query = $this->m_master->get_data_one("trs_wo", "no_wo", $id);
		$data_detail = $this->m_master->get_data_one("trs_wo_detail", "no_wo", $id)->row();

		$html = '';

		if ($query->num_rows() > 0) {
			$data = $query->row();

			$html .= '<table width="100%" border="0" cellspacing="0" style="font-size:14px;font-family: ;">
                            <tr style="font-weight: bold;">
                                <td colspan="15" align="center">
                                  <u><h3> ORDER PRODUKSI </h3></u>
                                </td>
                            </tr>
                            <tr style="font-weight: bold;">
                                <td colspan="15" align="center">
                                  ' . $data->no_wo . '
                                </td>
                            </tr>
                     </table><br>';

			$html .= '<table width="100%" border="0" cellspacing="0" style="font-size:14px;font-family: ;">  
                            <tr>
                                <td width="20%" >No SO</td>
                                <td width="30%">: ' . $data->no_so . '</td>
                                <td width="30%" /td>
                                <td width="15%" >TGL WO</td>
                                <td width="20%" >' . $data->tgl_wo . '</td>
                            </tr>
                            <tr>
                                <td>TGL</td>
                                <td>: ' . $data->tgl_so . '</td>
                                <td></td>
                                <td>Line</td>
                                <td>' . $data->line . '</td>
                            </tr>
                            <tr>
                                <td>NAMA PELANGGAN</td>
                                <td>: ' . $data->nm_pelanggan . '</td>
                                <td></td>
                                <td>Tgl Kirim</td>
                                <td>' . $data->tgl_wo . '</td>
                            </tr>
                            <tr>
                                <td>JENIS PRODUK</td>
                                <td>: ' . $data->jenis_produk . '</td>
                                <td></td>
                                <td>No Batch</td>
                                <td>' . $data->batchno . '</td>
                            </tr>
                            <tr>
                                <td>NO. ARTIKEL</td>
                                <td colspan="4">: ' . $data->no_artikel . '</td>
                            </tr>
                            <tr>
                                <td>NAMA BARANG</td>
                                <td colspan="4">: ' . $data->nm_produk . '</td>
                            </tr>
                            <tr>
                                <td>UKURAN SHEET</td>
                                <td colspan="4">: ' . $data->ukuran . '</td>
                            </tr>
                            <tr>
                                <td>KUALITAS</td>
                                <td colspan="4">: ' . $data->kualitas . '</td>
                            </tr>
                            <tr>
                                <td>TYPE BOX</td>
                                <td colspan="4">: ' . $data->tipe_box . '</td>
                            </tr>
                            <tr>
                                <td>WARNA</td>
                                <td colspan="4">: ' . $data->warna . '</td>
                            </tr>
                            <tr>
                                <td style="border-bottom:1px solid;">JUMLAH ORDER</td>
                                <td style="border-bottom:1px solid;">: ' . number_format($data->qty) . '</td>
                                <td colspan="3"></td>
                            </tr>
                        </table>';

			$html .= '<br>
                        <table width="60%" border="0" cellspacing="0" cellpadding="0" style="font-size:10px;font-family: ;">  
                            <tr>
                                <td align="center" width="3%" style=""><br><br>&nbsp;</td>
                                <td align="center" width="8%" style="border-top:1px solid;border-left:1px solid" ><i>11</i></td>
                                <td align="center" width="20%" style="border-top:1px solid" valign="top">00</td>
                                <td align="center" width="20%" style="border-top:1px solid;border-left:1px solid" valign="top">00</td>
                                <td align="center" width="20%" style="border-top:1px solid;border-left:1px solid" valign="top">00</td>
                                <td align="center" width="20%" style="border-top:1px solid;border-left:1px solid" valign="top">00</td>
                                <td align="center" width="8%" style="border-top:1px solid;border-left:1px solid;border-right:1px solid"></td>
                            </tr> 
                            <tr>
                                <td align="center" width="3%" style="border-top:1px solid;border-bottom:1px solid;border-left:1px solid;" valign="midle"><i>11</i></td>
                                <td align="center" width="8%" style="" ><br><br>&nbsp;</td>
                                <td align="center" width="20%" style="" valign="top"></td>
                                <td align="center" width="20%" style="" valign="top"></td>
                                <td align="center" width="20%" style="" valign="top"></td>
                                <td align="center" width="20%" style="" valign="top"></td>
                                <td align="center" width="8%" style="border-right:1px solid"><i>11</i></td>
                            </tr>
                            <tr>
                                <td align="center" width="3%" style=""><br><br>&nbsp;</td>
                                <td align="center" width="8%" style="border-bottom:1px solid;border-left:1px solid" ><i>11</i></td>
                                <td align="center" width="20%" style="border-bottom:1px solid" valign="bottom">00</td>
                                <td align="center" width="20%" style="border-bottom:1px solid;border-left:1px solid" valign="bottom">00</td>
                                <td align="center" width="20%" style="border-bottom:1px solid;border-left:1px solid" valign="bottom">00</td>
                                <td align="center" width="20%" style="border-bottom:1px solid;border-left:1px solid" valign="bottom">00</td>
                                <td align="center" width="8%" style="border-bottom:1px solid;border-left:1px solid;border-right:1px solid"></td>
                            </tr> 
                        </table>
                        ';

			$html .= '<br>
                        <table width="100%" border="1" cellspacing="0" style="font-size:12px;font-family: ;">  
                            <tr>
                                <td align="center" width="%" rowspan="2">No</td>
                                <td align="center" width="%" rowspan="2">PROSES PRODUKSI</td>
                                <td align="center" width="%" colspan="2">HASIL PRODUKSI</td>
                                <td align="center" width="%" rowspan="2">RUSAK</td>
                                <td align="center" width="%" rowspan="2">HASIL BAIK</td>
                                <td align="center" width="%" rowspan="2">KETERANGAN</td>
                            </tr>
                            <tr>
                                <td align="center" width="%" >TGL</td>
                                <td align="center" width="%" >HASIL JADI</td>
                            </tr>

                            <tr>
                                <td align="center" width="3%" >1</td>
                                <td align="" width="20%" >CORUUGATOR</td>
                                <td align="" width="10%" >' . (($data_detail->tgl_crg) == '0000-00-00' ? '' : $data_detail->tgl_crg) . '</td>
                                <td align="" width="10%" >' . $data_detail->hasil_crg . '</td>
                                <td align="" width="15%" >' . $data_detail->rusak_crg . '</td>
                                <td align="" width="15%" >' . $data_detail->baik_crg . '</td>
                                <td align="" width="15%" >' . $data_detail->ket_crg . '</td>
                            </tr>
                            <tr>
                                <td align="center" width="%" >2</td>
                                <td align="" width="%" >FLEXO</td>
                                <td align="" width="%" >' . (($data_detail->tgl_flx) == '0000-00-00' ? '' : $data_detail->tgl_flx) . '</td>
                                <td align="" width="%" >' . $data_detail->hasil_flx . '</td>
                                <td align="" width="%" >' . $data_detail->rusak_flx . '</td>
                                <td align="" width="%" >' . $data_detail->baik_flx . '</td>
                                <td align="" width="%" >' . $data_detail->ket_flx . '</td>
                            </tr>
                            <tr>
                                <td align="center" width="%" rowspan="4" valign="middle">3</td>
                                <td align="" width="%" >CONVERTING</td>
                                <td align="" width="%" style="border-bottom:hidden;border-right:hidden"></td>
                                <td align="" width="%" style="border-bottom:hidden;border-right:hidden"></td>
                                <td align="" width="%" style="border-bottom:hidden;border-right:hidden"></td>
                                <td align="" width="%" style="border-bottom:hidden;border-right:hidden"></td>
                                <td align="" width="%" style="border-bottom:hidden;"></td>
                            </tr>
                            <tr>
                                <td align="right" width="%" >GLUE</td>
                                <td align="" width="%" style="border-top:hidden;border-right:hidden">' . (($data_detail->tgl_glu) == '0000-00-00' ? '' : $data_detail->tgl_glu) . '</td>
                                <td align="" width="%" style="border-top:hidden;border-right:hidden;border-right:hidden">' . $data_detail->hasil_glu . '</td>
                                <td align="" width="%" style="border-top:hidden;border-right:hidden">' . $data_detail->rusak_glu . '</td>
                                <td align="" width="%" style="border-top:hidden;border-right:hidden">' . $data_detail->baik_glu . '</td>
                                <td align="" width="%" style="border-top:hidden;">' . $data_detail->ket_glu . '</td>
                            </tr>
                            <tr>
                                <td align="right" width="%" >STITCHING</td>
                                <td align="" width="%" >' . (($data_detail->tgl_stc) == '0000-00-00' ? '' : $data_detail->tgl_stc) . '</td>
                                <td align="" width="%" >' . $data_detail->hasil_stc . '</td>
                                <td align="" width="%" >' . $data_detail->rusak_stc . '</td>
                                <td align="" width="%" >' . $data_detail->baik_stc . '</td>
                                <td align="" width="%" >' . $data_detail->ket_stc . '</td>
                            </tr>
                            <tr>
                                <td align="right" width="%" >DIE CUT</td>
                                <td align="" width="%" >' . (($data_detail->tgl_dic) == '0000-00-00' ? '' : $data_detail->tgl_dic) . '</td>
                                <td align="" width="%" >' . $data_detail->hasil_dic . '</td>
                                <td align="" width="%" >' . $data_detail->rusak_dic . '</td>
                                <td align="" width="%" >' . $data_detail->baik_dic . '</td>
                                <td align="" width="%" >' . $data_detail->ket_dic . '</td>
                            </tr>
                            <tr>
                                <td align="center" width="%" >4</td>
                                <td align="" width="%" >GUDANG</td>
                                <td align="" width="%" >' . (($data_detail->tgl_gdg) == '0000-00-00' ? '' : $data_detail->tgl_gdg) . '</td>
                                <td align="" width="%" >' . $data_detail->hasil_gdg . '</td>
                                <td align="" width="%" >' . $data_detail->rusak_gdg . '</td>
                                <td align="" width="%" >' . $data_detail->baik_gdg . '</td>
                                <td align="" width="%" >' . $data_detail->ket_gdg . '</td>
                            </tr>
                            <tr>
                                <td align="center" width="%" >5</td>
                                <td align="" width="%" >EXPEDISI / PENGIRIMAN</td>
                                <td align="" width="%" >' . (($data_detail->tgl_exp) == '0000-00-00' ? '' : $data_detail->tgl_exp) . '</td>
                                <td align="" width="%" >' . $data_detail->hasil_exp . '</td>
                                <td align="" width="%" >' . $data_detail->rusak_exp . '</td>
                                <td align="" width="%" >' . $data_detail->baik_exp . '</td>
                                <td align="" width="%" >' . $data_detail->ket_exp . '</td>
                            </tr>
                        </table>';
		} else {
			$html .= '<h1> Data Kosong </h1>';
		}

		$this->m_fungsi->_mpdf($html);
	}

	function Cetak_SuratJalan()
	{
		$id  = $_GET['no_surat_jalan'];
		$query = $this->m_master->get_data_one("trs_surat_jalan", "no_surat_jalan", $id);
		$data_pelanggan = $this->m_master->get_data_one("m_pelanggan", "id_pelanggan", $query->row('id_pelanggan'))->row();

		$html = '';

		if ($query->num_rows() > 0) {
			$data = $query->result();

			$html .= '<table width="100%" border="0" cellspacing="0" style="font-size:12px;font-family: ;">
                            <tr>
                                <td colspan="7" align="center"><h2><u>SURAT JALAN</u></h2><br>&nbsp;</td>
                            </tr>
                            <tr>
                                <td width="18%">TANGGAL</td>
                                <td width="2%">:</td>
                                <td width="20%">' . $data[0]->tgl_surat_jalan . '</td>
                                <td width="10%"></td>
                                <td width="18%">KEPADA</td>
                                <td width="2%">:</td>
                                <td width="40%">' . $data[0]->nm_pelanggan . '</td>
                            </tr>
                            <tr>
                                <td>NO. SURAT JALAN</td>
                                <td>:</td>
                                <td>' . $data[0]->no_surat_jalan . '</td>
                                <td></td>
                                <td>ALAMAT</td>
                                <td>:</td>
                                <td>' . $data_pelanggan->alamat . '</td>
                            </tr>
                            <tr>
                                <td>Kode PO</td>
                                <td>:</td>
                                <td>' . $data[0]->kode_po . '</td>
                                <td></td>
                                <td>ATTN</td>
                                <td>:</td>
                                <td>' . $data[0]->nm_pelanggan . '</td>
                            </tr>
                            <tr>
                                <td>NO. PKB</td>
                                <td>:</td>
                                <td>' . $data[0]->no_pkb . '</td>
                                <td></td>
                                <td>NO.TELP / HP</td>
                                <td>:</td>
                                <td>' . $data_pelanggan->no_telp . '</td>
                            </tr>
                            <tr>
                                <td>NO. KENDARAAN</td>
                                <td>:</td>
                                <td>' . $data[0]->no_kendaraan . '</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                     </table><br>';

			$html .= '<table width="100%" border="0" cellspacing="0" style="font-size:12px;font-family: ;">
                            <tr>
                                <td width="4%" align="center" style="border-top:1px solid;border-bottom:1px solid;border-left:1px solid"><b>NO</td>
                                <td width="20%" align="center" style="border-top:1px solid;border-bottom:1px solid;border-left:1px solid"><b>NO.PO</td>
                                <td width="25%" align="center" style="border-top:1px solid;border-bottom:1px solid;border-left:1px solid"><b>ITEM DESCRIPTION</td>
                                <td width="20%" align="center" style="border-top:1px solid;border-bottom:1px solid;border-left:1px solid"><b>FLUTE</td>
                                <td width="10%" align="center" style="border-top:1px solid;border-bottom:1px solid;border-left:1px solid"><b>QTY</td>
                                <td width="20%" align="center" style="border-top:1px solid;border-bottom:1px solid;border-left:1px solid;border-right:1px solid"><b>KETERANGAN</td>
                            </tr>';
			$no = $tot_qty = 0;

			foreach ($data as $r) {
				$no++;
				$html .= '
                        <tr>
                                <td style="border-bottom:1px solid;border-left:1px solid">
                                    ' . $no . '
                                    
                                </td>
                                <td style="border-bottom:1px solid;border-left:1px solid">
                                    ' . $r->kode_po . '
                                    
                                </td>
                                <td style="border-bottom:1px solid;border-left:1px solid">
                                    ' . $r->nm_produk . '
                                    
                                </td>
                                <td style="border-bottom:1px solid;border-left:1px solid">
                                    ' . $r->flute . '
                                    
                                </td>
                                <td style="border-bottom:1px solid;border-left:1px solid" align="right">
                                    ' . number_format($r->qty) . '
                                    
                                </td>
                                <td style="border-bottom:1px solid;border-left:1px solid;border-right:1px solid">
                                    
                                    
                                </td>
                            </tr>';
				$tot_qty += $r->qty;
			}
			$html .= ' 

                            <tr>
                                <td style="border-bottom:1px solid;border-left:1px solid" colspan="3" align="center"><b>TOTAL</td>
                                <td style="border-bottom:1px solid;border-left:1px solid"><b> </td>
                                <td style="border-bottom:1px solid;border-left:1px solid"><b> ' . number_format($tot_qty) . ' PCS</td>
                                <td style="border-bottom:1px solid;border-left:1px solid;border-right:1px solid"><b> </td>
                            </tr>    
                     </table><br>';

			$html .= '<br><table width="100%" border="0" cellspacing="0" style="font-size:12px;font-family: ;">
                            <tr>
                                <td width="16%" align="center" style="border-top:1px solid;border-bottom:1px solid;border-left:1px solid">DIBUAT</td>
                                <td width="17%" align="center" colspan="2" style="border-top:1px solid;border-bottom:1px solid;border-left:1px solid">DI KELUARKAN OLEH</td>
                                <td width="16%" align="center" style="border-top:1px solid;border-bottom:1px solid;border-left:1px solid">DIKETAHUI</td>
                                <td width="16%" align="center" style="border-top:1px solid;border-bottom:1px solid;border-left:1px solid">DISETUJUI</td>
                                <td width="16%" align="center" style="border-top:1px solid;border-bottom:1px solid;border-left:1px solid">SOPIR</td>
                                <td width="16%" align="center" style="border-top:1px solid;border-bottom:1px solid;border-left:1px solid;border-right:1px solid">DITERIMA OLEH</td>
                            </tr>
                            <tr>
                                <td align="center" style="border-bottom:1px solid;border-left:1px solid">
                                    <br><br><br><br><br>&nbsp;
                                </td>
                                <td align="center" style="border-bottom:1px solid;border-left:1px solid">
                                    <br><br><br><br><br>&nbsp;
                                </td>
                                <td align="center" style="border-bottom:1px solid;border-left:1px solid">
                                    <br><br><br><br><br>&nbsp;
                                </td>
                                <td align="center" style="border-bottom:1px solid;border-left:1px solid">
                                    <br><br><br><br><br>&nbsp;
                                </td>
                                <td align="center" style="border-bottom:1px solid;border-left:1px solid">
                                    <br><br><br><br><br>&nbsp;
                                </td>
                                <td align="center" style="border-bottom:1px solid;border-left:1px solid">
                                    
                                </td>
                                <td align="center" style="border-bottom:1px solid;border-left:1px solid;border-right:1px solid">
                                    
                                </td>
                            </tr>
                            <tr>
                                <td align="center" style="border-left:1px solid;border-bottom:1px solid">
                                    <br>.................. <br>
                                    ADMIN
                                </td>
                                <td align="center" style="border-left:1px solid;border-bottom:1px solid">
                                    <br>.................. <br>
                                    DIREKSI
                                </td>
                                <td width="10%" align="center" style="border-left:1px solid;border-bottom:1px solid">
                                    <br>.................. <br>
                                    SPV
                                </td>
                                <td align="center" style="border-left:1px solid;border-bottom:1px solid">
                                    <br>.................. <br>
                                    MGR GUDANG
                                </td>
                                <td align="center" style="border-left:1px solid;border-bottom:1px solid">
                                    <br>.................. <br>
                                    GM
                                </td>
                                <td align="center" style="border-left:1px solid;border-bottom:1px solid"></td>
                                <td align="center" style="border-left:1px solid;border-bottom:1px solid;border-right:1px solid"></td>
                            </tr>
                     </table><br>';

			$html .= '<br><br><br><table width="100%" border="0" cellspacing="0" style="font-size:10px;font-family: ;">
                            <tr>
                                <td colspan="4">NOTE :</td>
                            </tr>
                            <tr>
                                <td width="10%"></td>
                                <td width="10%">WHITE</td>
                                <td width="2%">:</td>
                                <td width="">PEMBELI / CUSTOMER</td>
                            </tr>
                            <tr>
                                <td width="10%"></td>
                                <td width="10%">PINK</td>
                                <td width="2%">:</td>
                                <td width="">FINANCE</td>
                            </tr>
                            <tr>
                                <td width="10%"></td>
                                <td width="10%">YELLOW</td>
                                <td width="2%">:</td>
                                <td width="">ACC</td>
                            </tr>
                            <tr>
                                <td width="10%"></td>
                                <td width="10%">GREEN</td>
                                <td width="2%">:</td>
                                <td width="">ADMIN</td>
                            </tr>
                            <tr>
                                <td width="10%"></td>
                                <td width="10%">BLUE</td>
                                <td width="2%">:</td>
                                <td width="">EXPEDISI</td>
                            </tr>
                     </table><br>';
		} else {
			$html .= '<h1> Data Kosong </h1>';
		}

		$this->m_fungsi->_mpdf($html);
	}

	function soPlhNoPO()
	{
		if($this->session->userdata('level') == 'PPIC'){
			$wId = "AND d.no_so_p IS NULL AND d.tgl_so_p IS NULL";
		}else{
			$wId = "AND d.no_so IS NULL AND d.tgl_so IS NULL AND d.status_so IS NULL";
		}
		// AND p.status_app3='Y' AND p.status='Approve'
		$po = $this->db->query("SELECT c.kode_unik,c.nm_pelanggan,c.attn,s.nm_sales,p.*,d.eta FROM trs_po p
		INNER JOIN trs_po_detail d ON p.no_po=d.no_po AND p.kode_po=d.kode_po
		INNER JOIN m_pelanggan c ON p.id_pelanggan=c.id_pelanggan
		INNER JOIN m_sales s ON c.id_sales=s.id_sales
		-- WHERE p.status_app1='Y' AND p.status_app2='Y' AND p.status_kiriman='Open'
		WHERE p.status_kiriman='Open'
		$wId
		GROUP BY p.no_po,p.kode_po ORDER BY c.nm_pelanggan,p.no_po")->result();
		echo json_encode(array(
			'po' => $po,
		));
	}

	function soPlhItems()
	{
		$no_po = $_POST["no_po"];
		// d.status='Approve'
		if($this->session->userdata('level') == 'PPIC'){
			$wId = "AND no_so_p IS NULL AND tgl_so_p IS NULL";
		}else{
			$wId = "AND no_so IS NULL AND tgl_so IS NULL";
		}
		$poDetail = $this->db->query("SELECT p.*,d.* FROM trs_po_detail d
		INNER JOIN trs_po o ON d.no_po=o.no_po AND d.kode_po=o.kode_po
		INNER JOIN m_produk p ON d.id_produk=p.id_produk
		WHERE d.no_po='$no_po' $wId");

		$options = '';
		$options .= '<option value="">PILIH</option>';
		foreach($poDetail->result() as $r){
			($r->kategori == "K_BOX") ? $ukuran = $r->ukuran : $ukuran = $r->ukuran_sheet;
			($r->kategori == "K_BOX") ? $ket_p = '[BOX] ' : $ket_p = '[SHEET] ';
			$options .= '<option value="'.$r->id_produk.'" data-idpodetail="'.$r->id.'" data-nm_produk="'.$r->nm_produk.'" data-ukuran="'.$r->ukuran.'" data-ukuran_sheet="'.$r->ukuran_sheet.'" data-flute="'.$r->flute.'" data-kualitas="'.$r->kualitas.'" data-kode_mc="'.$r->kode_mc.'" data-eta_item="'.$r->eta.'" data-qty="'.$r->qty.'" rm="'.$r->rm.'" ton="'.$r->ton.'">
				'.$ket_p.$r->nm_produk.' | '.$ukuran.' | '.$r->flute.' | '.$this->m_fungsi->kualitas($r->kualitas, $r->flute).' | '.number_format($r->qty,0,',','.').'
			</option>';
		}

		echo json_encode(array(
			'po_detail' => $poDetail->result(),
			'options' => $options,
		));
	}

	function soNoSo()
	{
		$item = $_POST["item"];
		$data = $this->db->query("SELECT d.kode_po FROM trs_po_detail d
		INNER JOIN m_produk p ON d.id_produk=p.id_produk
		WHERE d.id='$item'")->row();
		echo json_encode(array(
			'data' => $data,
		));
	}

	function destroySO()
	{
		$this->cart->destroy();
	}

	function addItems()
	{
		if($_POST["no_so"] == ""){
			echo json_encode(array('data' => false, 'isi' => 'NO. SO TIDAK BOLEH KOSONG!'));
			// return;
		}else{
			$data = array(
				'id' => $_POST['idpodetail'],
				'name' => $_POST['idpodetail'],
				'price' => 0,
				'qty' => 1,
				'options' => array(
					'nm_produk' => $_POST['nm_produk'],
					'no_po' => $_POST['no_po'],
					'kode_po' => $_POST['kode_po'],
					'id_produk' => $_POST['item'],
					'id_pelanggan' => $_POST['idpelanggan'],
					'no_so' => $_POST['no_so'],
					'jml_so' => $_POST['jml_so'],
					'rm' => $_POST['rm'],
					'ton' => $_POST['ton'],
					'eta_po' => $_POST['eta_po'],
				)
			);
			if($this->cart->total_items() != 0){
				foreach($this->cart->contents() as $r){
					if($r['id'] == $_POST["idpodetail"]){
						echo json_encode(array('data' => false, 'isi' => 'ITEM SUDAH ADA!'));
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
	}

	function showCartItem()
	{
		$html = '';
		if($this->cart->total_items() != 0){
			$html .='<table class="table table-bordered table-striped" style="width:100%">';
			$html .='<thead>
				<tr>
					<input type="hidden" id="table-nopo-value" value="isi">
					<th style="width:5%">NO.</th>
					<th style="width:40%">ITEM</th>
					<th style="width:35%">NO. PO</th>
					<th style="width:10%;text-align:center">QTY PO</th>
					<th style="width:10%">AKSI</th>
				</tr>
			</thead>';
		}

		$i = 0;
		foreach($this->cart->contents() as $r){
			$i++;
			$html .='<tr>
				<td>'.$i.'</td>
				<td>'.$r['options']['nm_produk'].'</td>
				<td>'.$r['options']['kode_po'].'</td>
				<td style="text-align:right">'.number_format($r['options']['jml_so']).'</td>
				<td>
					<button class="btn btn-danger btn-sm" onclick="hapusCartItem('."'".$r['rowid']."'".','."hapusCartItem".','."'showCartItem'".')"><i class="fas fa-times"></i> BATAL</button>
				</td>
			</tr>';
		}

		if($this->cart->total_items() != 0){
			$html .= '</table>';
		}

		echo $html;
	}

	function hapusCartItem()
	{
		$data = array(
			'rowid' => $_POST['rowid'],
			'qty' => 0,
		);
		$this->cart->update($data);
	}

	function simpanSO()
	{
		$result = $this->m_transaksi->simpanSO();
		echo json_encode($result);
	}

	function detailSO()
	{
		$id = $_POST["id"];
		$no_po = $_POST["no_po"];
		$kode_po = $_POST["kode_po"];
		$aksi = $_POST["aksi"];

		$html = '';
		// <th style="padding:12px 6px;width:20%">ETA PO</th>
		$html .='<table class="table table-bordered table-striped" style="width:100%">
			<thead>
				<tr>
					<th style="padding:12px 6px;width:3%;text-align:center">NO.</th>
					<th style="padding:12px 6px;width:40%">ITEM</th>
					<th style="padding:12px 6px;width:12%">UKURAN</th>
					<th style="padding:12px 6px;width:10%">KUALITAS</th>
					<th style="padding:12px 6px;width:5%;text-align:center">FLUTE</th>
					<th style="padding:12px 6px;width:10%;text-align:center">QTY PO</th>
					<th style="padding:12px 6px;width:10%;text-align:center">PENGIRIMAN</th>
					<th style="padding:12px 6px;width:10%;text-align:center">AKSI</th>
				</tr>
			</thead>';
		// if($this->session->userdata('level') == 'PPIC'){
			$wId = "AND d.id='$id'";
		// }else{
			// $wId = "";
		// }
		$getSO = $this->db->query("SELECT p.kode_mc,p.nm_produk,p.kategori,p.ukuran,p.ukuran_sheet,p.ukuran_sheet_l,p.ukuran_sheet_p,p.kualitas,p.flute,p.berat_bersih,po.status_kiriman,d.* FROM trs_po_detail d
		INNER JOIN trs_po po ON po.no_po=d.no_po AND po.kode_po=d.kode_po
		INNER JOIN m_produk p ON d.id_produk=p.id_produk
		WHERE d.no_po='$no_po' AND d.kode_po='$kode_po' $wId");

		$i = 0;
		foreach($getSO->result() as $r){
			$i++;
			$idPoSo = $r->id;
			($r->id == $id) ? $bHead = 'background:#ccc;border:1px solid #888;' : $bHead = '';
			($r->id == $id) ? $bold = 'font-weight:bold;"' : $bold = 'font-weight:normal;';
			($r->id == $id) ? $borLf = 'border-left:3px solid #0f0;' : $borLf = '';
			if($r->status_kiriman == 'Close'){
				$btnBagi = '<button class="btn btn-secondary btn-sm" disabled><i class="fas fa-minus"></i></button>';
			}else{
				if($aksi == 'detail'){
					$btnBagi = '<button class="btn btn-secondary btn-sm" disabled><i class="fas fa-minus"></i></button>';
				}else{
					if(in_array($this->session->userdata('level'), ['Admin', 'User', 'Admin2'])){
						($r->id == $id) ?
							$btnBagi = '<button type="button" class="btn btn-success btn-sm" id="addBagiSO" onclick="addBagiSO('."'".$r->id."'".')"><i class="fas fa-plus"></i></button>
								<button type="button" class="btn btn-danger btn-sm" id="hapusListSO" onclick="hapusListSO('."'".$r->id."'".')"><i class="fas fa-trash"></i></button>' :
							$btnBagi = '<button class="btn btn-secondary btn-sm" disabled><i class="fas fa-minus"></i></button>';
					}else{
						$btnBagi = '<button class="btn btn-secondary btn-sm" disabled><i class="fas fa-minus"></i></button>';
					}
				}
			}
			
			($r->kategori == "K_BOX") ? $ukuran = $r->ukuran : $ukuran = $r->ukuran_sheet;
			($r->kategori == "K_BOX") ? $ket_p = '[BOX]' : $ket_p = '[SHEET]';
			
			// PENGIRIMAN
			$kirim = $this->m_fungsi->kiriman($r->kode_po, $r->id_produk, $r->qty);
			$sumKirim = $kirim["sumKirim"];
			$sumRetur = $kirim["sumRetur"];
			$sisa = $kirim["sisa"];
			($sisa <= 0) ? $bgtd = 'background:#74c69d' : $bgtd = 'background:#ff758f';
			($sisa <= 0) ? $txtSisa = number_format($sisa,0,',','.') : $txtSisa = '+'.number_format($sisa,0,',','.');
			($sisa == 0 || $sumKirim == 0) ? $span = '' : $span = ' <span style="'.$bgtd.'">'.$txtSisa.'</span>';
			($sumRetur != 0) ? $txtRtr = ' <span style="font-style:italic;font-weight:normal">('.number_format($sumRetur,0,',','.').')</span>' : $txtRtr = '';

			// <td style="padding:6px;'.$bold.'">'.strtoupper($this->m_fungsi->tanggal_format_indonesia($r->eta)).'</td>
			$html .='<tr style="'.$borLf.'">
				<td style="padding:6px;text-align:center;'.$bold.'">'.$i.'</td>
				<td style="padding:6px;'.$bold.'">'.$ket_p.' '.$r->nm_produk.'</td>
				<td style="padding:6px;'.$bold.'">'.$ukuran.'</td>
				<td style="padding:6px;'.$bold.'">'.$this->m_fungsi->kualitas($r->kualitas, $r->flute).'</td>
				<td style="padding:6px;text-align:center;'.$bold.'">'.$r->flute.'</td>
				<td style="padding:6px;text-align:right;'.$bold.'">'.number_format($r->qty).'</td>
				<td style="padding:6px;text-align:right;'.$bold.'">'.number_format($sumKirim,0,',','.').$txtRtr.$span.'</td>
				<td style="padding:6px;text-align:center;'.$bold.'">'.$btnBagi.'</td>
			</tr>';

			// if($this->session->userdata('level') == 'PPIC'){
			// 	$whPPIC = "AND s.add_user='ppic'";
			// 	$nSP = $r->no_so_p;
			// }else{
				$whPPIC = "AND s.add_user!='ppic'";
				$nSP = $r->no_so;
			// }
			$dataSO = $this->db->query("SELECT p.nm_produk,p.ukuran_sheet_l,p.ukuran_sheet_p,p.berat_bersih,s.* FROM trs_so_detail s
			INNER JOIN m_produk p ON s.id_produk=p.id_produk
			WHERE s.id_produk='$r->id_produk' AND s.no_po='$r->no_po' AND s.kode_po='$r->kode_po' AND s.no_so='$nSP' $whPPIC");
			
			if($dataSO->num_rows() != 0){
				// if($this->session->userdata('level') == 'PPIC'){
				// 	$ketPPIC = '<th style="padding:6px 12px 6px 6px;text-align:center;'.$bHead.''.$bold.'">HASIL QTY</th>
				// 	<th style="padding:6px;text-align:center;'.$bHead.''.$bold.'">HASIL AKSI</th>
				// 	<th style="padding:6px;text-align:center;'.$bHead.''.$bold.'">DONE</th>';
				// }else{
					$ketPPIC = '';
				// }
				$html .='<tr style="'.$borLf.'">
					<td colspan="8">
						<table class="table table-bordered" style="margin:0;border:0;width:100%">
							<thead>
								<tr>
									<th style="padding:6px;'.$bHead.''.$bold.'" class="text-center">NO.</th>
									<th style="padding:6px;'.$bHead.''.$bold.'">ETA SO</th>
									<th style="padding:6px;'.$bHead.''.$bold.'">NO. SO</th>
									<th style="padding:6px 30px 6px 6px;text-align:center;'.$bHead.''.$bold.'">QTY SO</th>
									'.$ketPPIC.'
									<th style="padding:6px;'.$bHead.''.$bold.'">KETERANGAN</th>
									<th style="padding:6px;'.$bHead.''.$bold.'" class="text-center">-</th>
									<th style="padding:6px;'.$bHead.''.$bold.'" class="text-center">RM</th>
									<th style="padding:6px;'.$bHead.''.$bold.'" class="text-center">TON</th>
									<th style="padding:6px;'.$bHead.''.$bold.'" class="text-center">B. BAKU</th>
									<th style="padding:6px;'.$bHead.''.$bold.'" class="text-center">AKSI</th>
								</tr>
							</thead>';

				// if($this->session->userdata('level') == 'PPIC'){
				// 	$p = '_p';
				// 	$whP = "AND so.add_user='ppic'";
				// }else{
					$p = '';
					$whP = "AND so.add_user!='ppic'";
				// }
				$dataHapusSO = $this->db->query("SELECT COUNT(so.rpt) AS jml_rpt FROM trs_po_detail ps
				INNER JOIN trs_so_detail so ON ps.no_po=so.no_po AND ps.kode_po=so.kode_po AND ps.no_so$p=so.no_so AND ps.id_produk=so.id_produk
				WHERE ps.id='$idPoSo' $whP GROUP BY so.no_po,so.kode_po,so.no_so,so.id_produk");
				
				($r->id == $id) ? $bTd = 'border:1px solid #999;' : $bTd = '';
				$l = 0 ;
				$sumQty = 0 ;
				$sumRm = 0 ;
				$sumTon = 0 ;
				$sumBB = 0 ;
				foreach($dataSO->result() as $so){
					$l++;
					if($aksi == 'detail'){
						$btnHapus = '';
					}else{
						if($so->status == 'Close' || $so->status_2 == 'Close'){
							$btnHapus = '';
						}else{
							if(in_array($this->session->userdata('level'), ['Admin', 'User', 'Admin2'])){
								if($r->id == $id){
									if($so->rpt == 1){
										$btnHapus = '';
									}else{
										if($dataHapusSO->row()->jml_rpt == $so->rpt){
											$btnHapus = '<button type="button" class="btn btn-danger btn-sm" onclick="batalDataSO('."'".$so->id."'".')"><i class="fas fa-times"></i></button>';
										}else{
											$btnHapus = '';
										}
									}
								}else{
									$btnHapus = '';
								}
							}else{
								$btnHapus = '';
							}
						}
					}

					$link = base_url('Transaksi/laporanSO?id=').$so->id;
					$print = '<a href="'.$link.'" target="_blank"><button type="button" class="btn btn-dark btn-sm"><i class="fas fa-print"></i></button></a>';
					($so->cek_rm_so == 0) ? $check = '' : $check = 'checked';
					($so->cek_st_2 == 0) ? $check2 = '' : $check2 = 'checked';
					$bahan_baku = ceil($so->ton / 0.7);
					
					$urut_so = str_pad($so->urut_so, 2, "0", STR_PAD_LEFT);
					$rpt = str_pad($so->rpt, 2, "0", STR_PAD_LEFT);
					// if($this->session->userdata('level') == 'PPIC' && $so->add_user == 'ppic'){
					// 	$qHasil = $this->db->query("SELECT*FROM trs_so_hasil WHERE id_so_dtl='$so->id' ORDER BY hasil_tgl");
					// 	$dis3 = '';
					// 	if($aksi == 'detail'){
					// 		$dis2 = 'disabled';
					// 		$rTxt2 = '1';
					// 		$btnAksi2 = $print;
					// 		$btnDone = '<button type="button" class="btn btn-secondary btn-sm" disabled><i class="fas fa-check"></i></button>';
					// 	}else{
					// 		if($so->status_2 == 'Close'){
					// 			$btnAksi2 = $print;
					// 			$rTxt2 = 1;
					// 			$dis2 = 'disabled';
					// 			$btnDone = '<button type="button" class="btn btn-secondary btn-sm" disabled><i class="fas fa-check"></i></button>';
					// 		}else{
					// 			if($qHasil->num_rows() != 0){
					// 				$dis2 = '';
					// 				$dis3 = 'disabled';
					// 			}else{
					// 				($r->id == $id) ? $dis2 = '' : $dis2 = 'disabled';
					// 			}
					// 			($r->id == $id) ? $btnAksi2 = $print.' <button type="button" class="btn btn-warning btn-sm" id="editBagiSO'.$so->id.'" onclick="editBagiSO('."'".$so->id."'".')"><i class="fas fa-edit"></i></button>' : $btnAksi2 = $print;
					// 			($r->id == $id) ? $rTxt2 = 2 : $rTxt2 = 1;
					// 			$cH = $this->db->query("SELECT*FROM trs_so_hasil WHERE id_so_dtl='$so->id' GROUP BY id_so_dtl");
					// 			if($cH->num_rows() != ''){
					// 				$btnDone = '<button type="button" class="btn btn-secondary btn-sm" disabled><i class="fas fa-check"></i></button>';
					// 			}else{
					// 				$btnDone = '<button type="button" class="btn btn-primary btn-sm" onclick="btnSOHasil('."'".$so->id."'".')"><i class="fas fa-check"></i></button>';
					// 			}
					// 		}
					// 	}
					// 	$html .='<tr>
					// 		<td style="background:#f2f2f2;padding:6px;'.$bTd.''.$bold.'" class="text-center">'.$l.'</td>
					// 		<td style="background:#f2f2f2;padding:6px;'.$bTd.''.$bold.'">
					// 			<input type="date" id="edit-tgl-so'.$so->id.'" class="form-control" value="'.$so->eta_so.'" '.$dis2.$dis3.'>
					// 		</td>
					// 		<td style="background:#f2f2f2;padding:6px;'.$bTd.''.$bold.'">'.$so->no_so.'.'.$urut_so.'.'.$rpt.'</td>
					// 		<td style="background:#f2f2f2;padding:6px;'.$bTd.''.$bold.'">
					// 			<input type="number" id="edit-qty-so'.$so->id.'" class="form-control" style="text-align:right" onkeyup="keyUpQtySO('."'".$so->id."'".')" value="'.number_format($so->qty_so,0,',','.').'" '.$dis2.'>
					// 		</td>
					// 		<td style="background:#f2f2f2;padding:6px;'.$bTd.''.$bold.'">
					// 			<input type="number" id="hasil_pcs'.$so->id.'" class="form-control" style="text-align:right" onkeyup="" placeholder="0" '.$dis2.'>
					// 		</td>
					// 		<td style="background:#f2f2f2;padding:6px;text-align:center;'.$bTd.''.$bold.'">'.$btnDone.'</td>
					// 		<td style="background:#f2f2f2;padding:6px;'.$bTd.''.$bold.'">
					// 			<input type="checkbox" id="cbhs-'.$so->id.'" style="height:25px;width:100%" onclick="cbOSHasil('."'".$so->id."'".')" value="'.$so->cek_st_2.'" '.$check2.'>
					// 		</td>
					// 		<td style="background:#f2f2f2;padding:6px;'.$bTd.''.$bold.'">
					// 			<textarea class="form-control" id="edit-ket-so'.$so->id.'" rows="'.$rTxt2.'" style="resize:none">'.$so->ket_so.'</textarea>
					// 		</td>
					// 		<td style="background:#f2f2f2;padding:6px;'.$bTd.''.$bold.'">
					// 			<input type="checkbox" id="cbso-'.$so->id.'" style="height:25px;width:100%" onclick="keyUpQtySO('."'".$so->id."'".')" value="'.$so->cek_rm_so.'" '.$check.'>
					// 		</td>
					// 		<td style="background:#f2f2f2;padding:6px;'.$bTd.''.$bold.'" class="text-right">'.number_format($so->rm).'<br><span class="span-rm-h-'.$so->id.'"></span></td>
					// 		<td style="background:#f2f2f2;padding:6px;'.$bTd.''.$bold.'" class="text-right">'.number_format($so->ton).'<br><span class="span-ton-h-'.$so->id.'"></span></td>
					// 		<td style="background:#f2f2f2;padding:6px;'.$bTd.''.$bold.'" class="text-right">'.number_format($bahan_baku).'<br><span class="span-bb-h-'.$so->id.'"></span></td>
					// 		<td style="background:#f2f2f2;padding:6px;'.$bTd.''.$bold.'" class="text-center">
					// 			<input type="hidden" id="ht-ukl-'.$so->id.'" value="'.$so->ukuran_sheet_l.'">
					// 			<input type="hidden" id="ht-ukp-'.$so->id.'" value="'.$so->ukuran_sheet_p.'">
					// 			<input type="hidden" id="ht-bb-'.$so->id.'" value="'.$so->berat_bersih.'">
					// 			<input type="hidden" id="edit-qtypo-so'.$so->id.'" value="'.$r->qty.'">
					// 			'.$btnAksi2.' '.$btnHapus.'
					// 		</td>
					// 	</tr>';

					// 	// HTML HASIL
					// 	if($qHasil->num_rows() != 0){
					// 		foreach($qHasil->result() as $h){
					// 			if($qHasil->num_rows() == 1){
					// 				$kurHass = $h->hasil_qty - $so->qty_so;
					// 				$sHx = '<td style="background:#fff;padding:6px;text-align:right;font-weight:bold">'.$kurHass.'</td>
					// 				<td colspan="7" style="background:#fff"></td>';
					// 				$hfb = ';font-weight:bold';
					// 			}else{
					// 				$sHx = '<td colspan="8" style="background:#fff"></td>';
					// 				$hfb = '';
					// 			}
					// 			if($so->status_2 == 'Close'){
					// 				$bHsH = '';
					// 			}else{
					// 				// cek guna
					// 				$cG = $this->db->query("SELECT*FROM trs_so_detail s
					// 				INNER JOIN trs_so_roll r ON s.id=r.id_so_dtl
					// 				INNER JOIN trs_so_guna g ON r.id_roll=g.id_roll AND s.eta_so=g.tgl
					// 				WHERE r.id_so_dtl='$so->id'");
					// 				if($cG->num_rows() == 0){
					// 					$bHsH = '<button class="btn btn-xs btn-danger" onclick="hapusOSList('."'".$h->id."'".')"><i class="fas fa-trash"></i></button> ';
					// 				}else{
					// 					$bHsH = '';
					// 				}
					// 			}
					// 			$html .= '<tr>
					// 				<td colspan="4" style="background:#fff"></td>
					// 				<td style="background:#fff;padding:6px">'.$bHsH.substr($this->m_fungsi->getHariIni($h->hasil_tgl),0,3).', '.$this->m_fungsi->tglIndSkt(substr($h->hasil_tgl, 0,10)).'</td>
					// 				<td style="background:#fff;padding:6px;text-align:right'.$hfb.'">'.number_format($h->hasil_qty).'</td>
					// 				'.$sHx.'
					// 			</tr>';
					// 		}
					// 	}

					// 	$sumQty += $so->qty_so;
					// 	$sumRm += $so->rm;
					// 	$sumTon += $so->ton;
					// 	$sumBB += $bahan_baku;
					// }
					// if(in_array($this->session->userdata('level'), ['Admin','User']) && ($so->add_user == 'user' || $so->add_user == 'developer')){
					if($aksi == 'detail'){
						$diss = 'disabled';
						$rTxt = '1';
						$btnAksi = $print;
					}else{
						if($so->status == 'Close'){
							$btnAksi = $print;
							$rTxt = 1;
							$diss = 'disabled';
						}else{
							if(in_array($this->session->userdata('level'), ['Admin', 'User', 'Admin2'])){
								($r->id == $id) ? $diss = '' : $diss = 'disabled';
								($r->id == $id) ? $btnAksi = $print.' <button type="button" class="btn btn-warning btn-sm" id="editBagiSO'.$so->id.'" onclick="editBagiSO('."'".$so->id."'".')"><i class="fas fa-edit"></i></button>' : $btnAksi = $print;
							}else{
								$diss = 'disabled';
								$btnAksi = $print;
							}
							($r->id == $id) ? $rTxt = 2 : $rTxt = 1;
						}
					}
					$html .='<tr>
						<td style="padding:6px;'.$bTd.''.$bold.'" class="text-center">'.$l.'</td>
						<td style="padding:6px;'.$bTd.''.$bold.'">
							<input type="date" id="edit-tgl-so'.$so->id.'" class="form-control" value="'.$so->eta_so.'" '.$diss.'>
						</td>
						<td style="padding:6px;'.$bTd.''.$bold.'">'.$so->no_so.'.'.$urut_so.'.'.$rpt.'</td>
						<td style="padding:6px;'.$bTd.''.$bold.'">
							<input type="number" id="edit-qty-so'.$so->id.'" class="form-control" style="text-align:right;font-weight:bold" onkeyup="keyUpQtySO('."'".$so->id."'".')" value="'.number_format($so->qty_so,0,',','.').'" '.$diss.'>
						</td>
						<td style="padding:6px;'.$bTd.''.$bold.'">
							<textarea class="form-control" id="edit-ket-so'.$so->id.'" rows="'.$rTxt.'" style="resize:none" '.$diss.'>'.$so->ket_so.'</textarea>
						</td>
						<td style="padding:6px;'.$bTd.''.$bold.'">
							<input type="checkbox" id="cbso-'.$so->id.'" style="height:25px;width:100%" onclick="keyUpQtySO('."'".$so->id."'".')" value="'.$so->cek_rm_so.'" '.$check.' '.$diss.'>
						</td>
						<td style="padding:6px;'.$bTd.''.$bold.'" class="text-right">'.number_format($so->rm).'<br><span class="span-rm-h-'.$so->id.'"></span></td>
						<td style="padding:6px;'.$bTd.''.$bold.'" class="text-right">'.number_format($so->ton).'<br><span class="span-ton-h-'.$so->id.'"></span></td>
						<td style="padding:6px;'.$bTd.''.$bold.'" class="text-right">'.number_format($bahan_baku).'<br><span class="span-bb-h-'.$so->id.'"></span></td>
						<td style="padding:6px;'.$bTd.''.$bold.'" class="text-center">
							<input type="hidden" id="ht-ukl-'.$so->id.'" value="'.$so->ukuran_sheet_l.'">
							<input type="hidden" id="ht-ukp-'.$so->id.'" value="'.$so->ukuran_sheet_p.'">
							<input type="hidden" id="ht-bb-'.$so->id.'" value="'.$so->berat_bersih.'">
							<input type="hidden" id="edit-qtypo-so'.$so->id.'" value="'.$r->qty.'">
							'.$btnAksi.' '.$btnHapus.'
						</td>
					</tr>';
					$sumQty += $so->qty_so;
					$sumRm += $so->rm;
					$sumTon += $so->ton;
					$sumBB += $bahan_baku;

					// TAMPIL PLAN
					$trsWO = $this->db->query("SELECT*FROM trs_wo WHERE kode_po='$so->kode_po' AND id_produk='$so->id_produk' AND id_pelanggan='$so->id_pelanggan' AND no_so='$so->id'");
					if($trsWO->num_rows() != 0){
						$html .= '<tr>
							<td style="padding:6px;border:1px solid #999" colspan="2"></td>
							<td style="padding:6px;border:1px solid #999" colspan="8">'.$trsWO->row()->no_wo.'</td>
						</tr>';
					}
					$planCor = $this->db->query("SELECT c.*,w.* FROM plan_cor c
					INNER JOIN trs_wo w ON c.id_wo=w.id
					WHERE w.kode_po='$so->kode_po' AND w.id_produk='$so->id_produk' AND w.id_pelanggan='$so->id_pelanggan' AND w.no_so='$so->id'
					GROUP BY c.tgl_plan,w.kode_po, w.id_produk, w.id_pelanggan");
					if($planCor->num_rows() != 0){
						$html .= '<tr>
							<td style="padding:6px;border:1px solid #999" colspan="2"></td>
							<td style="padding:0;border:1px solid #999" colspan="8">
								<table>
									<tr>
										<td style="background:#eee;padding:6px;font-weight:bold">TGL PLAN</td>
										<td style="background:#eee;padding:6px;font-weight:bold">HASIL</td>
									</tr>';
									foreach($planCor->result() as $pc){
										($pc->good_cor_p == null || $pc->good_cor_p == 0) ? $good = '-' : $good = number_format($pc->good_cor_p);
										$html .= '<tr>
											<td style="background:#fff;padding:6px">'.$pc->tgl_plan.'</td>
											<td style="background:#fff;padding:6px;text-align:right">'.$good.'</td>
										</tr>';
									}
								$html .= '</table>
							</td>
						</tr>';
					}

					// }
				}

				if($dataSO->num_rows() > 1){
					// if($this->session->userdata('level') == 'PPIC'){
					// 	$sumPPIC = '<td style="background:#fff;padding:6px;font-weight:bold;text-align:center;border:0"></td>
					// 	<td style="background:#fff;padding:6px;font-weight:bold;text-align:center;border:0"></td>
					// 	<td style="background:#fff;padding:6px;font-weight:bold;text-align:center;border:0"></td>';
					// }else{
						$sumPPIC = '';
					// }
					$html .='<tr>
						<td style="background:#fff;padding:6px;font-weight:bold;text-align:center;border:0" colspan="3"></td>
						<td style="background:#fff;padding:6px;font-weight:bold;text-align:right;border:0">'.number_format($sumQty).'</td>
						<td style="background:#fff;padding:6px;font-weight:bold;text-align:center;border:0"></td>
						'.$sumPPIC.'
						<td style="background:#fff;padding:6px;font-weight:bold;text-align:center;border:0"></td>
						<td style="background:#fff;padding:6px;font-weight:bold;text-align:right;border:0">'.number_format($sumRm).'</td>
						<td style="background:#fff;padding:6px;font-weight:bold;text-align:right;border:0">'.number_format($sumTon).'</td>
						<td style="background:#fff;padding:6px;font-weight:bold;text-align:right;border:0">'.number_format($sumBB).'</td>
						<td style="background:#fff;padding:6px;font-weight:bold;text-align:center;border:0"></td>
					</tr>';
				}

				$html .= '</table>
						<div>
							<input type="hidden" id="hide-ukl-so'.$r->id.'" value="'.$r->ukuran_sheet_l.'">
							<input type="hidden" id="hide-ukp-so'.$r->id.'" value="'.$r->ukuran_sheet_p.'">
							<input type="hidden" id="hide-bb-so'.$r->id.'" value="'.$r->berat_bersih.'">
							<input type="hidden" id="hide-qtypo-so'.$r->id.'" value="'.$sumQty.'">
							<input type="hidden" id="hide-rmpo-so'.$r->id.'" value="'.$sumRm.'">
							<input type="hidden" id="hide-tonpo-so'.$r->id.'" value="'.$sumTon.'">
						</div>
						<div id="add-bagi-so-'.$r->id.'"></div>
						<div id="list-bagi-so-'.$r->id.'"></div>
					</td>
				</tr>';
			}
		}

		$html .= '</table>';
		echo $html;
	}

	function LaporanSOTrim()
	{
		$htmlO = '';
		$htmlOI = '';
		// ORDERS
		$htmlO .= 'orders.xlsx';
		$htmlO .= '<table style="margin-bottom:20px">
			<tr>
				<td style="padding:6px">order_id</td>
				<td style="padding:6px">customer_id</td>
				<td style="padding:6px">created_at</td>
			</tr>';
			$oQ = $this->db->query("SELECT s.no_po,c.kode_unik FROM trs_so_detail s
			INNER JOIN m_pelanggan c ON s.id_pelanggan=c.id_pelanggan
			WHERE s.add_user='ppic' AND s.status_2='Open'
			GROUP BY s.no_po,c.kode_unik,s.status_2");
			foreach($oQ->result() as $c){
				$th = date('Y');
				$bln = date('m');
				$date = date('d');
				$htmlO .= '<tr>
					<td style="padding:6px">'.str_replace('PO/', 'SO/', $c->no_po).'</td>
					<td style="padding:6px">'.$c->kode_unik.'</td>
					<td style="padding:6px">'.$th.'-'.$bln.'-'.$date.'T22:32:00</td>
				</tr>';
			}
		$htmlO .= '</table>';

		// ORDER ITEMS
		$htmlOI .= 'order-items.xlsx';
		$htmlOI .= '<table>
			<tr>
				<td style="padding:6px">id</td>
				<td style="padding:6px">order_id</td>
				<td style="padding:6px">item_id</td>
				<td style="padding:6px">sequence_id</td>
				<td style="padding:6px">quantity</td>
				<td style="padding:6px">eta</td>
				<td style="padding:6px">status</td>
			</tr>';

			$qOI = $this->db->query("SELECT s.no_po, s.id_produk
			FROM trs_so_detail s
			WHERE s.add_user='ppic' AND s.status_2='Open'
			GROUP BY s.no_po,s.id_produk,s.status_2");
			foreach($qOI->result() as $r){
				$sQ = $this->db->query("SELECT 
				s.no_po AS order_id,
				s.id_produk AS item_id,
				s.rpt AS sequence_id,
				s.qty_so,
				(SELECT SUM(h.hasil_qty) FROM trs_so_hasil h WHERE s.id=h.id_so_dtl) AS hasil,
				s.eta_so AS eta
				FROM trs_so_detail s
				WHERE s.add_user='ppic' AND s.status_2='Open' AND s.no_po='$r->no_po' AND s.id_produk='$r->id_produk'
				GROUP BY s.no_po,s.id_produk,s.urut_so,s.rpt,s.status_2");
				$ii = 0;
				foreach($sQ->result() as $s){
					$prod = ($s->hasil == null) ? 0 : $s->hasil;
					$hasil = $s->qty_so - $prod;
					if($hasil > 0){
						$ii++;
						$htmlOI .= '<tr>
							<td style="padding:6px"></td>
							<td style="padding:6px">'.str_replace('PO/', 'SO/', $s->order_id).'</td>
							<td style="padding:6px">ITEM'.$s->item_id.'</td>
							<td style="padding:6px;text-align:right">'.str_pad($ii, 3, "0", STR_PAD_LEFT).'</td>
							<td style="padding:6px;text-align:right">'.$hasil.'</td>
							<td style="padding:6px">'.$s->eta.'T00:00:00</td>
							<td style="padding:6px">pending</td>
						</tr>';
					}
				}
			}
		$htmlOI .= '</table>';

		// CUSTOMERS
		// SELECT kode_unik, nm_pelanggan, no_telp, '2025-06-05T17:03:00'created_at FROM m_pelanggan
		// WHERE id_pelanggan IN (SELECT no_customer FROM m_produk)
		// GROUP BY id_pelanggan
		// ORDER BY nm_pelanggan,kode_unik;

		// ITEMS
		// SELECT CONCAT('ITEM',a.id_produk)item_id,b.kode_unik customer_id,a.nm_produk description,ROUND((a.ukuran_sheet_l/10),2) sheet_width,ROUND((a.ukuran_sheet_p/10),2) sheet_length,LOWER(a.wall) wall_type,'0.04'toleransi,
		// CASE WHEN flute IN ('BF','CF') THEN CONCAT('[["liner", "' , SUBSTR(material,1,1),'", ' ,SUBSTR(kualitas_isi,1,3),'], ["fluting"," ', REPLACE(flute,'F',''),'", ' ,SUBSTR(kualitas_isi,5,3),'], ["liner", "',SUBSTR(material,5,1),'", ',SUBSTR(kualitas_isi,9,3),']]' )
		// ELSE CONCAT('[["liner", "' , SUBSTR(material,1,1),'", ' ,SUBSTR(kualitas_isi,1,3),'], ["fluting", "B", ' ,SUBSTR(kualitas_isi,5,3),'], ["liner", "',SUBSTR(material,5,1),'", ',SUBSTR(kualitas_isi,9,3),'], ["fluting", "C", ',SUBSTR(kualitas_isi,13,3),'], ["liner", "',SUBSTR(material,9,1),'", ',SUBSTR(kualitas_isi,17,3),']]' ) END
		// layer, a.flute ,a.material,a.kualitas_isi FROM m_produk a
		// INNER JOIN m_pelanggan b ON a.no_customer=b.id_pelanggan
		// GROUP BY a.id_produk, no_customer,kode_unik,nm_produk

		// rolls
		// roll_id	width	spec	grammage	running_meter	assigned(false)

		$htmlP = '';
		$htmlP .= '<table>
			<tr>
				<td>ETA</td>
				<td>NO. PO</td>
				<td>CUSTOMER</td>
				<td>ITEM</td>
			</tr>';
		$htmlP .= '</table>';

		echo json_encode([
			'htmlO' => $htmlO,
			'htmlOI' => $htmlOI,
		]);
	}

	function editBagiSO()
	{
		$result = $this->m_transaksi->editBagiSO();
		echo json_encode($result);
	}

	function btnAddBagiSO()
	{
		// $_POST["fBagiEtaSo"] == "";
		if($_POST["fBagiQtySo"] == "" || $_POST["fBagiQtySo"] == 0 || $_POST["fBagiQtySo"] < 0){
			echo json_encode(array('data' => false, 'msg' => 'QTY SO TIDAK BOLEH KOSONG!'));
		}else{
			$id = $_POST["i"];
			$produk = $this->db->query("SELECT p.* FROM m_produk p INNER JOIN trs_po_detail s ON p.id_produk=s.id_produk WHERE s.id='$id' GROUP BY p.id_produk");
			$RumusOut = 1800 / $produk->row()->ukuran_sheet_l;
			(floor($RumusOut) >= 5) ? $out = 5 : $out = (floor($RumusOut));
			$rm = ($produk->row()->ukuran_sheet_p * $_POST["fBagiQtySo"] / $out) / 1000;
			$ton = $_POST["fBagiQtySo"] * $produk->row()->berat_bersih;

			if($this->session->userdata('level') == 'PPIC'){
				$p = '_p';
				$aU = "AND so.add_user='ppic'";
			}else{
				$p = '';
				$aU = "AND so.add_user!='ppic'";
			}
			$getData = $this->db->query("SELECT COUNT(so.rpt) AS jml_rpt,so.* FROM trs_po_detail ps
			INNER JOIN trs_so_detail so ON ps.no_po=so.no_po AND ps.kode_po=so.kode_po AND ps.no_so$p=so.no_so AND ps.id_produk=so.id_produk $aU
			WHERE ps.id='$id'
			GROUP BY so.no_po,so.kode_po,so.no_so,so.id_produk");

			if($this->cart->total_items() != 0){
				foreach($this->cart->contents() as $r){
					if($r['id'] == $_POST["i"]){
						$rpt = $r['options']['rpt'] + 1;
					}
					if($r['options']['qty_po'] == $_POST["hQtyPo"]){
						$hQtyPo = 0;
					}
					if($r['options']['hRmPo'] == $_POST["hRmPo"]){
						$hRmPo = 0;
					}
					if($r['options']['hTonPo'] == $_POST["hTonPo"]){
						$hTonPo = 0;
					}
				}
				$i = $this->cart->total_items()+1;
			}else{
				$rpt = $getData->row()->jml_rpt + 1;
				$hQtyPo = $_POST["hQtyPo"];
				$hRmPo = $_POST["hRmPo"];
				$hTonPo = $_POST["hTonPo"];
				$i = 1;
			}

			$data = array(
				'id' => $_POST['i'],
				'name' => $_POST['i'],
				'price' => 0,
				'qty' => 1,
				'options' => array(
					'id_pelanggan' => $getData->row()->id_pelanggan,
					'id_produk' => $getData->row()->id_produk,
					'no_po' => $getData->row()->no_po,
					'kode_po' => $getData->row()->kode_po,
					'no_so' => $getData->row()->no_so,
					'urut_so' => $getData->row()->urut_so,
					'rpt' => $rpt,
					'eta_so' => ($_POST['fBagiEtaSo'] == "") ? null : $_POST["fBagiEtaSo"],
					'qty_so' => $_POST['fBagiQtySo'],
					'ket_so' => $_POST['fBagiKetSo'],
					'cek_rm_so' => $_POST['fBagiCrmSo'],
					'rm' => round($rm),
					'ton' => round($ton),
					'total_items' => $i,
					'qty_po' => $hQtyPo,
					'hRmPo' => $hRmPo,
					'hTonPo' => $hTonPo,
				)
			);

			if($_POST["fBagiCrmSo"] == 0){
				if($rm < 500){
					echo json_encode(array('data' => false, 'msg' => 'RM '.round($rm).' . RM KURANG!'));
				}else{
					$this->cart->insert($data);
					echo json_encode(array('data' => true, 'msg' => $data));
				}
			}else{
				if(round($rm) == 0 || round($ton) == 0 || round($rm) < 0 || round($ton) < 0 || $rm == "" || $ton == "" ){
					echo json_encode(array('data' => false, 'msg' => 'RM '.round($rm). ' . RM / TONASE TIDAK BOLEH KOSONG!'));
				}else{
					$this->cart->insert($data);
					echo json_encode(array('data' => true, 'msg' => $data));
				}
			}
		}
	}

	function ListAddBagiSO(){
		$html = '';
		if($this->cart->total_items() != 0){
			$html .='<table class="table table-bordered table-striped" style="margin:10px 0 0;border:0;width:100%">';
			$html .='<thead>
				<tr>
					<th style="width:5%;background:#ccc;border:1px solid #888" class="text-center">NO.</th>
					<th style="width:10%;background:#ccc;border:1px solid #888">ETA SO</th>
					<th style="width:21%;background:#ccc;border:1px solid #888">NO. SO</th>
					<th style="width:15%;background:#ccc;border:1px solid #888">QTY SO</th>
					<th style="width:20%;background:#ccc;border:1px solid #888">KETERANGAN</th>
					<th style="width:7%;background:#ccc;border:1px solid #888">RM</th>
					<th style="width:7%;background:#ccc;border:1px solid #888">TON</th>
					<th style="width:15%;background:#ccc;border:1px solid #888" class="text-center">AKSI</th>
				</tr>
			</thead>';
		}

		$i = 0;
		$sumQty = 0;
		$sumRm = 0;
		$sumTon = 0;
		foreach($this->cart->contents() as $r){
			$i++;
			$urut_so = str_pad($r['options']['urut_so'], 2, "0", STR_PAD_LEFT);
			$rpt = str_pad($r['options']['rpt'], 2, "0", STR_PAD_LEFT);
			($r['options']['eta_so'] == null || $r['options']['eta_so'] == "") ? $eeTa = '-' : $eeTa = $r['options']['eta_so'];
			($this->cart->total_items() == $r['options']['total_items']) ?
				$btnAksi = '<button class="btn btn-danger btn-sm" id="hapusCartItemSO" onclick="hapusCartItem('."'".$r['rowid']."'".','."'".$r['id']."'".','."'ListAddBagiSO'".')"><i class="fas fa-times"></i> <b>BATAL</b></button>' : $btnAksi = '-' ;
			$html .='<tr>
				<td style="border:1px solid #999" class="text-center">'.$i.'</td>
				<td style="border:1px solid #999">'.$eeTa.'</td>
				<td style="border:1px solid #999">'.$r['options']['no_so'].'.'.$urut_so.'.'.$rpt.'</td>
				<td style="border:1px solid #999;text-align:right">'.number_format($r['options']['qty_so']).'</td>
				<td style="border:1px solid #999">'.$r['options']['ket_so'].'</td>
				<td style="border:1px solid #999;text-align:right">'.number_format($r['options']['rm']).'</td>
				<td style="border:1px solid #999;text-align:right">'.number_format($r['options']['ton']).'</td>
				<td style="border:1px solid #999" class="text-center">'.$btnAksi.'</td>
			</tr>';

			$sumQty += $r['options']['qty_po'] + $r['options']['qty_so'];
			$sumRm += $r['options']['hRmPo'] + $r['options']['rm'];
			$sumTon += $r['options']['hTonPo'] + $r['options']['ton'];
		}

		if($this->cart->total_items() != 0){
			$html .= '<tr>
				<td style="background:#fff;padding:3px;font-weight:bold;border:0;text-align:center">'.$r['options']['rpt'].'</td>
				<td style="background:#fff;padding:3px;font-weight:bold;border:0;text-align:center" colspan="2"></td>
				<td style="background:#fff;padding:3px 12px;font-weight:bold;border:0;text-align:center;text-align:right">'.number_format($sumQty).'</td>
				<td style="background:#fff;padding:3px;font-weight:bold;border:0;text-align:center"></td>
				<td style="background:#fff;padding:3px 12px;font-weight:bold;border:0;text-align:center;text-align:right">'.number_format($sumRm).'</td>
				<td style="background:#fff;padding:3px 12px;font-weight:bold;border:0;text-align:center;text-align:right">'.number_format($sumTon).'</td>
				<td style="background:#fff;padding:3px;font-weight:bold;border:0;text-align:center"></td>
			</tr>
			<tr>
				<td style="font-weight:bold;background:#fff;padding:12px 0;border:0" colspan="6">
					<button class="btn btn-primary btn-sm" id="simpanCartItemSO" onclick="simpanCartItemSO()"><i class="fas fa-save"></i> <b>SIMPAN</b></button>
				</td>
			</tr>';
			$html .= '</table>';
		}

		echo $html;
	}

	function simpanCartItemSO()
	{
		$result = $this->m_transaksi->simpanCartItemSO();
		echo json_encode($result);
	}

	function batalDataSO()
	{
		$result = $this->m_transaksi->batalDataSO();
		echo json_encode($result);
	}

	function hapusListSO()
	{
		$result = $this->m_transaksi->hapusListSO();
		echo json_encode($result);
	}

	function btnSOHasil()
	{
		$result = $this->m_transaksi->btnSOHasil();
		echo json_encode($result);
	}

	function cbOSHasil()
	{
		$result = $this->m_transaksi->cbOSHasil();
		echo json_encode($result);
	}

	function hapusOSList()
	{
		$result = $this->m_transaksi->hapusOSList();
		echo json_encode($result);
	}

	function addRollCorr()
	{
		$result = $this->m_transaksi->addRollCorr();
		echo json_encode($result);
	}

	function editRollCorr()
	{
		$result = $this->m_transaksi->editRollCorr();
		echo json_encode($result);
	}

	function btnGunaSisa()
	{
		$result = $this->m_transaksi->btnGunaSisa();
		echo json_encode($result);
	}

	function delRollGuna()
	{
		$result = $this->m_transaksi->delRollGuna();
		echo json_encode($result);
	}

	function btnPatokanRoll()
	{
		$result = $this->m_transaksi->btnPatokanRoll();
		echo json_encode($result);
	}

	function laporanSO(){
		$id = $_GET["id"];
		$data = $this->db->query("SELECT c.nm_pelanggan,c.top,c.fax,c.no_telp,c.alamat,s.nm_sales,o.eta,p.tgl_po,o.tgl_so,p.time_app1,p.time_app2,p.time_app3,b.id_hub,b.nm_hub,b.alamat AS alamat_hub,i.*,d.* FROM trs_so_detail d
		INNER JOIN trs_po p ON p.no_po=d.no_po AND p.kode_po=d.kode_po
		INNER JOIN trs_po_detail o ON o.no_po=d.no_po AND o.kode_po=d.kode_po AND o.no_so=d.no_so AND o.id_produk=d.id_produk
		INNER JOIN m_produk i ON d.id_produk=i.id_produk
		INNER JOIN m_pelanggan c ON p.id_pelanggan=c.id_pelanggan
		INNER JOIN m_sales s ON c.id_sales=s.id_sales
		INNER JOIN m_hub b ON p.id_hub=b.id_hub
		WHERE d.id='$id'")->row();

		$html = '<table style="margin-bottom:5px;border-collapse:collapse;vertical-align:top;width:100%;font-weight:bold;font-family:Tahoma">
			<tr>
				<th style="width:25%"></th>
				<th style="width:75%"></th>
			</tr>
			<tr>
				<td style="border:0;text-align:center" rowspan="4">
					<img src="'.base_url('assets/gambar/ppi.png').'" width="160" height="140">
				</td>
				<td style="border:0;font-size:30px;padding:19px 0 0">PT. PRIMA PAPER INDONESIA</td>
			</tr>
			<tr>
				<td style="border:0;font-size:12px">DUSUN TIMANG KULON, DESA WONOKERTO, KEC.WONOGIRI, KAB.WONOGIRI</td>
			</tr>
			<tr>
				<td style="border:0;font-size:12px;padding:0 0 27px">WONOGIRI - JAWA TENGAH - INDONESIA. KODE POS 57615</td>
			</tr>
		</table>';

		$urutSo = str_pad($data->urut_so, 2, "0", STR_PAD_LEFT);
		$rpt = str_pad($data->rpt, 2, "0", STR_PAD_LEFT);
		($data->ket_so == "") ? $ketSO = '-' : $ketSO = $data->ket_so;
		//
		if($data->id_hub == 7){
			$nm_pelanggan = $data->nm_pelanggan;
			$alamat = $data->alamat;
		}else{
			$nm_pelanggan = 'CV. '.$data->nm_hub;
			$alamat = $data->alamat_hub;
		}
		($data->creasing == 0 && $data->creasing2 == 0 && $data->creasing3 == 0) ? $creasing = '-' : $creasing = $data->creasing.' - '.$data->creasing2.' - '.$data->creasing3;
		$bahan_baku = ceil($data->ton / 0.7);

		$html .='<table style="font-size:12px;border-collapse:collapse;vertical-align:top;width:100%;font-family:Tahoma">
			<tr>
				<td style="width:10%;border:0;padding:0"></td>
				<td style="width:1%;border:0;padding:0"></td>
				<td style="width:55%;border:0;padding:0"></td>
				<td style="width:11%;border:0;padding:0"></td>
				<td style="width:1%;border:0;padding:0"></td>
				<td style="width:22%;border:0;padding:0"></td>
			</tr>
			<tr>
				<td style="border-top:1px solid #000;padding:1px" colspan="6"></td>
			</tr>
			<tr>
				<td style="border-top:1px solid #000;font-size:20px;padding:15px 0 2xp;text-align:center;font-weight:bold" colspan="6">KONFIRMASI ORDER</td>
			</tr>
			<tr>
				<td style="font-size:14px;padding:2px 0 25px;font-style:italic;text-align:center" colspan="6">( NO : '.$data->no_so.'.'.$urutSo.'.'.$rpt.' )</td>
			</tr>
			<tr>
				<td style="padding:5px 0">Tanggal SO</td>
				<td>:</td>
				<td style="padding:5px">'.$this->m_fungsi->tanggal_format_indonesia($data->tgl_so).'</td>
				<td style="padding:5px 0">Created By</td>
				<td>:</td>
				<td style="padding:5px">'.$data->add_user.'</td>
			</tr>
			<tr>
				<td style="padding:5px 0">No. PO</td>
				<td>:</td>
				<td style="padding:5px">'.$data->no_po.'</td>
				<td style="padding:5px 0;font-weight:bold;color:#f00;font-size:16px;font-family:Tahoma">ETA</td>
			</tr>
			<tr>
				<td style="padding:5px 0 15px">Sales</td>
				<td style="padding:5px 0 15px">:</td>
				<td style="padding:5px 5px 15px">'.strtoupper($data->nm_sales).'</td>
				<td style="padding:5px 0 15px;font-weight:bold;color:#f00;font-size:16px;font-family:Tahoma" colspan="3">'.strtoupper($this->m_fungsi->tanggal_format_indonesia($data->eta_so)).'</td>
			</tr>
			<tr>
				<td style="border-top:1px solid #000" colspan="6"></td>
			</tr>
			<tr>
				<td style="padding:10px 0 5px">Customer</td>
				<td style="padding:10px 0 5px">:</td>
				<td style="padding:10px 5px 5px">'.$nm_pelanggan.'</td>
				<td style="padding:10px 0 5px">TOP</td>
				<td style="padding:10px 0 5px">:</td>
				<td style="padding:10px 5px 5px">'.$data->top.'</td>
			</tr>
			<tr>
				<td style="padding:5px 0" rowspan="3">Alamat</td>
				<td style="padding:5px 0" rowspan="3">:</td>
				<td style="padding:5px" rowspan="3">'.strtoupper($alamat).'</td>
				<td style="padding:5px 0">PO. Date</td>
				<td style="padding:5px 0">:</td>
				<td style="padding:5px">'.$this->m_fungsi->tanggal_format_indonesia($data->tgl_po).'</td>
			</tr>
			<tr>
				<td style="padding:5px 0">No. Hp</td>
				<td>:</td>
				<td style="padding:5px">'.$data->no_telp.'</td>
			</tr>
			<tr>
				<td style="padding:5px 0 15px">FAX</td>
				<td style="padding:5px 0 15px">:</td>
				<td style="padding:5px 5px 15px">'.$data->fax.'</td>
			</tr>
			<tr>
				<td style="border-top:1px solid #000" colspan="6"></td>
			</tr>
			<tr>
				<td style="padding:10px 0">Description</td>
			</tr>
			<tr>
				<td style="padding:5px 0">Kode. PO</td>
				<td>:</td>
				<td style="padding:5px">'.$data->kode_po.'</td>
			</tr>
			<tr>
				<td style="padding:5px 0">Kode. MC</td>
				<td>:</td>
				<td style="padding:5px">'.$data->kode_mc.'</td>
			</tr>
			<tr>
				<td style="padding:5px 0">Item</td>
				<td>:</td>
				<td style="padding:5px">'.$data->nm_produk.'</td>
			</tr>
			<tr>
				<td style="padding:5px 0">Uk. Box</td>
				<td>:</td>
				<td style="padding:5px">'.$data->ukuran.'</td>
			</tr>
			<tr>
				<td style="padding:5px 0">Uk. Sheet</td>
				<td>:</td>
				<td style="padding:5px">'.$data->ukuran_sheet.'</td>
			</tr>
			<tr>
				<td style="padding:5px 0">Creasing</td>
				<td>:</td>
				<td style="padding:5px">'.$creasing.'</td>
			</tr>
			<tr>
				<td style="padding:5px 0">Kualitas</td>
				<td>:</td>
				<td style="padding:5px">'.$this->m_fungsi->kualitas($data->kualitas, $data->flute).'</td>
			</tr>
			<tr>
				<td style="padding:5px 0">Flute</td>
				<td>:</td>
				<td style="padding:5px">'.$data->flute.'</td>
			</tr>
			<tr>
				<td style="padding:5px 0">Qty PO</td>
				<td>:</td>
				<td style="padding:5px">'.number_format($data->qty_so).'</td>
			</tr>
			<tr>
				<td style="padding:5px 0">Bahan Baku</td>
				<td>:</td>
				<td style="padding:5px">'.number_format($bahan_baku).'</td>
			</tr>
			<tr>
				<td style="padding:5px 0 25px">Keterangan</td>
				<td style="padding:5px 0 25px">:</td>
				<td style="padding:5px 5px 25px">'.$ketSO.'</td>
			</tr>
			<tr>
				<td style="border-top:1px solid #000" colspan="6"></td>
			</tr>
		</table>';

		$html .='<table style="font-size:12px;text-align:center;border-collapse:collapse;vertical-align:top;width:100%;font-family:Tahoma">
			<tr>
				<td style="width:30%;border:0;padding:5px"></td>
				<td style="width:5%;border:0;padding:5px"></td>
				<td style="width:30%;border:0;padding:5px"></td>
				<td style="width:5%;border:0;padding:5px"></td>
				<td style="width:30%;border:0;padding:5px"></td>
			</tr>
			<tr>
				<td style="padding:5px">Marketing</td>
				<td></td>
				<td style="padding:5px">PPIC</td>
				<td></td>
				<td style="padding:5px">Owner</td>
			</tr>
			<tr>
				<td style="padding:5px">'.strtoupper($data->nm_sales).'</td>
				<td></td>
				<td style="padding:5px">DION AGUS PRANOTO</td>
				<td></td>
				<td style="padding:5px">WILLIAM ALEXANDER HARTONO</td>
			</tr>
			<tr>
				<td style="padding:5px">'.$this->m_fungsi->tanggal_format_indonesia(substr($data->time_app1,0,10)).' '.substr($data->time_app1,11,10).'</td>
				<td></td>
				<td style="padding:5px">'.$this->m_fungsi->tanggal_format_indonesia(substr($data->time_app2,0,10)).' '.substr($data->time_app2,11,10).'</td>
				<td></td>
				<td style="padding:5px">'.$this->m_fungsi->tanggal_format_indonesia(substr($data->time_app3,0,10)).' '.substr($data->time_app3,11,10).'</td>
			</tr>
		</table>';

		$judul = 'SO - '.$data->no_so.'.'.$urutSo.'.'.$rpt;
		$this->m_fungsi->newMpdf($judul, 'footer', $html, 10, 10, 10, 10, 'P', 'A4', $judul.'.pdf');
	}

	function cariListRoll()
	{
		$pilih = $_POST["list_pilih"];
		$lNmKer = $_POST["list_nmker"];
		$html = '';
		
		$html .='<div style="overflow:auto;white-space:nowrap;">
			<table style="margin:12px 6px;padding:0;color:#000;text-align:center;vertical-align:middle;border-collapse:collapse" border="1">';

			// DATA INTI DARI SEGALA INTI
			if($lNmKer == ''){
				$wK = "AND nm_ker IN('BK', 'BL', 'MF', 'MH', 'MH COLOR', 'ML', 'MN', 'MS', 'TL')";
			}else if($lNmKer == 'BKBLTL'){
				$wK = "AND nm_ker IN('BK', 'BL', 'TL')";
			}else if($lNmKer == 'MHMFMC'){
				$wK = "AND nm_ker IN('MF', 'MH', 'MH COLOR')";
			}else if($lNmKer == 'MLMNMS'){
				$wK = "AND nm_ker IN('ML', 'MN', 'MS')";
			}else{
				$wK = "AND nm_ker='$lNmKer'";
			}
            $getLabel = $this->db->query("SELECT nm_ker FROM m_roll WHERE status_p='Open' AND t_cor='$pilih' $wK GROUP BY nm_ker");

			// GET SEMUA KOP JENIS
            $html .='<tr style="background:#e9e9e9">
				<td style="padding:5px;font-weight:bold" rowspan="3">NO.</td>
				<td style="padding:5px;font-weight:bold" rowspan="3">UKURAN</td>';
				foreach($getLabel->result() as $lbl){
					$getGsm = $this->db->query("SELECT nm_ker,g_label FROM m_roll WHERE status_p='Open' AND t_cor='$pilih' AND nm_ker='$lbl->nm_ker' GROUP BY nm_ker,g_label");
					($lbl->nm_ker == 'MH COLOR') ? $nmKer = 'MC' : $nmKer = $lbl->nm_ker;
					$nrs = $getGsm->num_rows() * 2;
					$html .='<td style="padding:5px;font-weight:bold" colspan="'.$nrs.'">'.$nmKer.'</td>';
				}
				$html .='<td style="padding:5px;font-weight:bold" rowspan="3">P</td>
			</tr>';

			// GET SEMUA KOP GRAMATURE
            $html .='<tr>';
            foreach($getLabel->result() as $lbl){
                $getGsm = $this->db->query("SELECT nm_ker,g_label FROM m_roll WHERE status_p='Open' AND t_cor='$pilih' AND nm_ker='$lbl->nm_ker' GROUP BY nm_ker,g_label");
                foreach($getGsm->result() as $gsm){
                    $html .='<td style="padding:5px;background:#e9e9e9;font-weight:bold" colspan="2">'.$gsm->g_label.'</td>';
                }
            }
            $html .='</tr>';

			$html .='<tr>';
            foreach($getLabel->result() as $lbl){
                $getGsm = $this->db->query("SELECT nm_ker,g_label FROM m_roll WHERE status_p='Open' AND t_cor='$pilih' AND nm_ker='$lbl->nm_ker' GROUP BY nm_ker,g_label");
                foreach($getGsm->result() as $gsm){
                    $html .='<td style="padding:5px 12px;background:#e9e9e9;font-weight:bold">U</td><td style="padding:5px 12px;background:#e9e9e9;font-weight:bold">S</td>';
                }
            }
            $html .='</tr>';

			// TAMPIL SEMUA DATA UKURAN
            $getWidth = $this->db->query("SELECT width FROM m_roll
            WHERE status_p='Open' AND t_cor='$pilih' $wK
            GROUP BY width");
            $i = 0;
            foreach($getWidth->result() as $width){
                $i++;
                $html .='<tr class="new-stok-gg" style="position:relative"><td style="font-weight:bold">'.$i.'</td><td style="font-weight:bold;background:#fff;border:1px solid #808080;position:sticky;left:0">'.round($width->width,2).'</td>';

                $getLabel = $this->db->query("SELECT nm_ker FROM m_roll WHERE status_p='Open' AND t_cor='$pilih' $wK GROUP BY nm_ker");
                foreach($getLabel->result() as $lbl){
                    $getGsm = $this->db->query("SELECT*FROM m_roll
                    WHERE status_p='Open' AND t_cor='$pilih' AND nm_ker='$lbl->nm_ker'
                    GROUP BY nm_ker,g_label");
                    foreach($getGsm->result() as $gsm){
						if($gsm->g_label == 125 || $gsm->g_label == '125'){
							$a120 = "(g_label='120' OR g_label='125')";
						}else{
							$a120 = "g_label='$gsm->g_label'";
						}

						// CEK PTK
						$qP = $this->db->query("SELECT*FROM m_roll_ptk WHERE t_cor='$pilih' AND width='$width->width'");
						if($qP->num_rows() == 0){
							$uPTK = "";
							$sPTK = "";
						}else{
							$ptk = $qP->row()->ptk;
							$uPTK = "AND (weight - seset) > '$ptk'";
							$sPTK = "AND (weight - seset) <= '$ptk'";
						}
                        $getWidth = $this->db->query("SELECT nm_ker,g_label,width,COUNT(width) as jml FROM m_roll
                        WHERE status_p='Open' AND t_cor='$pilih' AND nm_ker='$gsm->nm_ker' AND $a120 AND width='$width->width' $uPTK
                        GROUP BY nm_ker,width");
						// UTUH
                        if($gsm->nm_ker == 'MH' || $gsm->nm_ker == 'MF'){
                            $gbGsm = '#ffc';
                        }else if($gsm->nm_ker == 'MN' || $gsm->nm_ker == 'MS' || $gsm->nm_ker == 'ML'){
                            $gbGsm = '#fcc';
                        }else if($gsm->nm_ker == 'BK' || $gsm->nm_ker == 'BL' || $gsm->nm_ker == 'TL'){
                            $gbGsm = '#ccc';
                        }else if($gsm->nm_ker == 'MH COLOR'){
                            $gbGsm = '#ccf';
                        }else{
                            $gbGsm = '#fff';
                        }
                        if($getWidth->num_rows() == 0){
                            $html .='<td style="padding:5px;font-weight:bold;background:'.$gbGsm.'">-</td>';
                        }else{
                            $html .='<td style="padding:5px">
                                <button style="background:transparent;font-weight:bold;margin:0;padding:0;border:0" onclick="btnListRoll('."'".$gsm->t_cor."'".', '."'".$gsm->nm_ker."'".', '."'".$gsm->g_label."'".', '."'".round($width->width,2)."'".', '."'UTUH'".')">'.$getWidth->row()->jml.'</button>
                            </td>';
                        }

						// SISA
						$getWSisa = $this->db->query("SELECT nm_ker,g_label,width,COUNT(width) as jml FROM m_roll
                        WHERE status_p='Open' AND t_cor='$pilih' AND nm_ker='$gsm->nm_ker' AND $a120 AND width='$width->width' $sPTK
                        GROUP BY nm_ker,width");
						if($gsm->nm_ker == 'MH' || $gsm->nm_ker == 'MF'){
                            $gbGsmS = '#ff0';
                        }else if($gsm->nm_ker == 'MN' || $gsm->nm_ker == 'MS' || $gsm->nm_ker == 'ML'){
                            $gbGsmS = '#faa';
                        }else if($gsm->nm_ker == 'BK' || $gsm->nm_ker == 'BL' || $gsm->nm_ker == 'TL'){
                            $gbGsmS = '#aaa';
                        }else if($gsm->nm_ker == 'MH COLOR'){
                            $gbGsmS = '#aaf';
                        }else{
                            $gbGsmS = '#fff';
                        }
						if($getWSisa->num_rows() == 0 || $qP->num_rows() == 0){
                            $html .='<td style="padding:5px;font-weight:bold;background:'.$gbGsmS.'">-</td>';
                        }else{
							$html .='<td style="padding:5px">
								<button style="background:transparent;font-weight:bold;margin:0;padding:0;border:0" onclick="btnListRoll('."'".$gsm->t_cor."'".', '."'".$gsm->nm_ker."'".', '."'".$gsm->g_label."'".', '."'".round($width->width,2)."'".', '."'SISA'".')">'.$getWSisa->row()->jml.'</button>
							</td>';
                        }
                    }
                }
				// PATOKAN SISA
				$qC = $this->db->query("SELECT*FROM m_roll_ptk WHERE t_cor='$pilih' AND width='$width->width'");
				($qC->num_rows() == 0 || ($qC->num_rows() != 0 && $qC->row()->ptk == 0)) ? $cc = '' : $cc = $qC->row()->ptk;
				$html .= '<td style="padding:5px">
					<input type="number" style="border:0;width:60px;text-align:right" id="ptk_'.$gsm->t_cor.round($width->width,2).'" onchange="btnPatokanRoll('."'".$gsm->t_cor."'".', '."'".round($width->width,2)."'".')" value="'.$cc.'">
				</td>';
            }
            $html .='</tr>';
		$html .= '</table>';

		echo json_encode([
			'html' => $html,
		]);
	}

	function btnListRoll()
	{
		$t_cor = $_POST["t_cor"];
		$nm_ker = $_POST["nm_ker"];
		$g_label = $_POST["g_label"];
		$width = $_POST["width"];
		$opsi = $_POST["opsi"];
		$html = '';

		// CEK PTK
		$qP = $this->db->query("SELECT*FROM m_roll_ptk WHERE t_cor='$t_cor' AND width='$width'");
		if($qP->num_rows() == 0){
			$uPTK = "";
		}else{
			$ptk = $qP->row()->ptk;
			if($opsi == 'UTUH'){
				$uPTK = "AND (weight - seset) > '$ptk'";
			}else{
				$uPTK = "AND (weight - seset) <= '$ptk'";
			}
		}

		$qR = $this->db->query("SELECT*FROM m_roll WHERE status_p='Open' AND t_cor='$t_cor' AND nm_ker='$nm_ker' AND g_label='$g_label' AND width='$width' $uPTK ORDER BY nm_ker, g_label, width");

		if($qR->num_rows() == 0){
			$html .= '<div style="padding:6px;font-weight:bold">DATA KOSONG!</div>';
		}else{
			$html .= '<div style="overflow:auto;white-space:nowrap"><table style="margin:0 6px 6px">
				<tr>
					<td style="background:#f2f2f2;padding:6px;font-weight:bold;text-align:center;border:1px solid #dee2e6">#</td>
					<td style="background:#f2f2f2;padding:6px;font-weight:bold;text-align:center;border:1px solid #dee2e6">CORR</td>
					<td style="background:#f2f2f2;padding:6px;font-weight:bold;text-align:center;border:1px solid #dee2e6">ROLL</td>
					<td style="background:#f2f2f2;padding:6px;font-weight:bold;text-align:center;border:1px solid #dee2e6">JENIS</td>
					<td style="background:#f2f2f2;padding:6px;font-weight:bold;text-align:center;border:1px solid #dee2e6">GSM</td>
					<td style="background:#f2f2f2;padding:6px;font-weight:bold;text-align:center;border:1px solid #dee2e6">WIDTH</td>
					<td style="background:#f2f2f2;padding:6px;font-weight:bold;text-align:center;border:1px solid #dee2e6">BERAT</td>
					<td style="background:#f2f2f2;padding:6px;font-weight:bold;text-align:center;border:1px solid #dee2e6">JOINT</td>
					<td style="background:#f2f2f2;padding:6px;font-weight:bold;text-align:center;border:1px solid #dee2e6">KETERANGAN</td>
					<td style="background:#f2f2f2;padding:6px;font-weight:bold;text-align:center;border:1px solid #dee2e6">STATUS</td>
					<td style="background:#f2f2f2;padding:6px;font-weight:bold;text-align:center;border:1px solid #dee2e6">BW</td>
					<td style="background:#f2f2f2;padding:6px;font-weight:bold;text-align:center;border:1px solid #dee2e6">RCT</td>
					<td style="background:#f2f2f2;padding:6px;font-weight:bold;text-align:center;border:1px solid #dee2e6">BI</td>
					<td style="background:#f2f2f2;padding:6px;font-weight:bold;text-align:center;border:1px solid #dee2e6">AKSI</td>
				</tr>';
				$i = 0;
				foreach($qR->result() as $r){
					$i++;
					if($r->status_r == 0){
						$pStt = 'STOK';
					}else if($r->status_r == 2){
						$pStt = 'PPI';
					}else if($r->status_r == 22){
						$pStt = 'FG';
					}else if($r->status_r == 4){
						$pStt = 'PPI SIZING';
					}else if($r->status_r == 5){
						$pStt = 'PPI CALENDER';
					}else if($r->status_r == 6){
						$pStt = 'PPI WARNA';
					}else if($r->status_r == 7){
						$pStt = 'PPI BAROKAH / NUSANTARA';
					}else if($r->status_r == 3){
						$pStt = 'BUFFER';
					}else{
						$pStt = '-';
					}
					if($r->t_cor == 'CA'){
						$opt = '<option value="CA">ATAS</option><option value="CB">BAWAH</option>';
					}
					if($r->t_cor == 'CB'){
						$opt = '<option value="CB">BAWAH</option><option value="CA">ATAS</option>';
					}
					$cAB = '<select id="corcab'.$r->id.'" style="background:none;border:0;">'.$opt.'</select>';
					$aksi = '<button type="button" onclick="editRollCorr('."'".$r->id."'".', '."'LIST'".')" style="font-weight:bold" class="btn btn-warning btn-xs">EDIT</button>';
					$berat = $r->weight - $r->seset;
					$html .= '<tr>
						<td style="padding:6px;text-align:center;border:1px solid #dee2e6">'.$cAB.'</td>
						<td style="padding:6px;text-align:center;border:1px solid #dee2e6">'.$r->t_cor.'</td>
						<td style="padding:6px;border:1px solid #dee2e6">'.$r->roll.'</td>
						<td style="padding:6px;text-align:center;border:1px solid #dee2e6">'.$r->nm_ker.'</td>
						<td style="padding:6px;text-align:center;border:1px solid #dee2e6">'.$r->g_label.'</td>
						<td style="padding:6px;text-align:center;border:1px solid #dee2e6">'.round($r->width,2).'</td>
						<td style="padding:6px;text-align:center;border:1px solid #dee2e6">'.number_format($berat).'</td>
						<td style="padding:6px;text-align:center;border:1px solid #dee2e6">'.$r->joint.'</td>
						<td style="padding:6px;border:1px solid #dee2e6">'.$r->ket.'</td>
						<td style="padding:6px;text-align:center;border;border:1px solid #dee2e6">'.$pStt.'</td>
						<td style="padding:6px;text-align:center;border:1px solid #dee2e6">'.round($r->g_ac,2).'</td>
						<td style="padding:6px;text-align:center;border:1px solid #dee2e6">'.round($r->rct,2).'</td>
						<td style="padding:6px;text-align:center;border:1px solid #dee2e6">'.round($r->bi,2).'</td>
						<td style="padding:6px;text-align:center;border:1px solid #dee2e6">'.$aksi.'</td>
					</tr>';
				}
			$html .= '</table></div>';
		}

		echo json_encode([
			'html' => $html,
		]);
	}

	function addCari()
	{
		$opsi = $_POST["opsi"];
		$tgl_pm = $_POST["tgl_pm"];
		$tgl_gudang = $_POST["tgl_gudang"];
		$html = '';

		$db9 = $this->load->database('database_simroll', TRUE);
		if($opsi == 'pm'){
			$qR = $db9->query("SELECT*FROM m_timbangan WHERE tgl>='2025-06-17' AND tgl='$tgl_pm' AND nm_ker!='WP' AND (status='2' OR status='4' OR status='5' OR status='6' OR status='7') ORDER BY roll");
			$qRc = $db9->query("SELECT nm_ker,g_label,width,COUNT(roll) AS jml_roll FROM m_timbangan WHERE tgl>='2025-06-17' AND tgl='$tgl_pm' AND nm_ker!='WP' AND (status='2' OR status='4' OR status='5' OR status='6' OR status='7') GROUP BY nm_ker,g_label,width");
		}
		if($opsi == 'gudang'){
			$qR = $db9->query("SELECT t.*,p.tgl AS tgl_pl,p.no_surat,p.nama,p.nm_perusahaan FROM m_timbangan t
			INNER JOIN pl p ON t.id_pl=p.id
			WHERE p.tgl>='2025-06-17' AND p.tgl='$tgl_gudang' AND t.nm_ker NOT IN ('WP','WS') AND t.cor_at IS NOT NULL AND t.cor_by IS NOT NULL
			ORDER BY t.nm_ker,t.g_label,t.width,t.pm,t.roll");
			$qRc = $db9->query("SELECT t.nm_ker,t.g_label,t.width,COUNT(t.roll) AS jml_roll FROM m_timbangan t
			INNER JOIN pl p ON t.id_pl=p.id
			WHERE p.tgl>='2025-06-17' AND p.tgl='$tgl_gudang' AND t.nm_ker NOT IN ('WP','WS') AND t.cor_at IS NOT NULL AND t.cor_by IS NOT NULL
			GROUP BY t.nm_ker,t.g_label,t.width");
		}

		if($qR->num_rows() == 0){
			$html .= '<span style="padding:6px;font-weight:bold">DATA KOSONG!</span>';
		}else{
			$html .= '<div style="overflow:auto;white-space:nowrap"><table style="margin:6px 6px 12px;text-align:center">
				<tr>
					<td style="background:#f2f2f2;padding:6px;font-weight:bold;border:1px solid #dee2e6">JENIS</td>
					<td style="background:#f2f2f2;padding:6px;font-weight:bold;border:1px solid #dee2e6">GSM</td>
					<td style="background:#f2f2f2;padding:6px;font-weight:bold;border:1px solid #dee2e6">WIDTH</td>
					<td style="background:#f2f2f2;padding:6px;font-weight:bold;border:1px solid #dee2e6">JUMLAH</td>
				</tr>';
				$sumRoll = 0;
				foreach($qRc->result() as $z){
					$html .= '<tr>
						<td style="padding:6px;border:1px solid #dee2e6">'.$z->nm_ker.'</td>
						<td style="padding:6px;border:1px solid #dee2e6">'.$z->g_label.'</td>
						<td style="padding:6px;border:1px solid #dee2e6">'.round($z->width,2).'</td>
						<td style="padding:6px;border:1px solid #dee2e6">'.$z->jml_roll.'</td>
					</tr>';
					$sumRoll += $z->jml_roll;
				}
				// TOTAL
				if($qRc->num_rows() > 1){
					$html .= '<tr>
						<td style="background:#f2f2f2;padding:6px;font-weight:bold;border:1px solid #dee2e6" colspan="3">TOTAL</td>
						<td style="background:#f2f2f2;padding:6px;font-weight:bold;border:1px solid #dee2e6">'.$sumRoll.'</td>
					</tr>';
				}
			$html .= '</table></div>';

			$html .= '<div style="overflow:auto;white-space:nowrap"><table style="margin:6px">
				<tr>
					<td style="background:#f2f2f2;padding:6px;font-weight:bold;text-align:center;border:1px solid #dee2e6">CORR</td>
					<td style="background:#f2f2f2;padding:6px;font-weight:bold;text-align:center;border:1px solid #dee2e6">ROLL</td>
					<td style="background:#f2f2f2;padding:6px;font-weight:bold;text-align:center;border:1px solid #dee2e6">JENIS</td>
					<td style="background:#f2f2f2;padding:6px;font-weight:bold;text-align:center;border:1px solid #dee2e6">GSM</td>
					<td style="background:#f2f2f2;padding:6px;font-weight:bold;text-align:center;border:1px solid #dee2e6">WIDTH</td>
					<td style="background:#f2f2f2;padding:6px;font-weight:bold;text-align:center;border:1px solid #dee2e6">DIA(cm)</td>
					<td style="background:#f2f2f2;padding:6px;font-weight:bold;text-align:center;border:1px solid #dee2e6">BERAT</td>
					<td style="background:#f2f2f2;padding:6px;font-weight:bold;text-align:center;border:1px solid #dee2e6">JOINT</td>
					<td style="background:#f2f2f2;padding:6px;font-weight:bold;text-align:center;border:1px solid #dee2e6">KETERANGAN</td>
					<td style="background:#f2f2f2;padding:6px;font-weight:bold;text-align:center;border:1px solid #dee2e6">STATUS</td>
					<td style="background:#f2f2f2;padding:6px;font-weight:bold;text-align:center;border:1px solid #dee2e6">BW</td>
					<td style="background:#f2f2f2;padding:6px;font-weight:bold;text-align:center;border:1px solid #dee2e6">RCT</td>
					<td style="background:#f2f2f2;padding:6px;font-weight:bold;text-align:center;border:1px solid #dee2e6">BI</td>
					<td style="background:#f2f2f2;padding:6px;font-weight:bold;text-align:center;border:1px solid #dee2e6">AKSI</td>
				</tr>';
				foreach($qR->result() as $r){
					$cek = $this->db->query("SELECT*FROM m_roll WHERE roll='$r->roll' AND id_roll='$r->id'");
					if($r->status == 0){
						$pStt = 'STOK';
					}else if($r->status == 2){
						$pStt = 'PPI';
					}else if($r->status == 4){
						$pStt = 'PPI SIZING';
					}else if($r->status == 5){
						$pStt = 'PPI CALENDER';
					}else if($r->status == 6){
						$pStt = 'PPI WARNA';
					}else if($r->status == 7){
						$pStt = 'PPI BAROKAH / NUSANTARA';
					}else if($r->status == 3){
						$pStt = 'BUFFER';
					}else{
						$pStt = '-';
					}
					$berat = $r->weight - $r->seset;
					// aksi edit
					if($cek->num_rows() != 0){
						if($cek->row()->t_cor == 'CA'){
							$opt = '<option value="CA">ATAS</option><option value="CB">BAWAH</option>';
						}
						if($cek->row()->t_cor == 'CB'){
							$opt = '<option value="CB">BAWAH</option><option value="CA">ATAS</option>';
						}
						$cAB = '<select id="corcab'.$cek->row()->id.'" style="background:none;border:0;">'.$opt.'</select>';
						$aksi = '<button type="button" onclick="editRollCorr('."'".$cek->row()->id."'".')" style="font-weight:bold" class="btn btn-warning btn-xs">EDIT</button>';
					}else{
						$cAB = '<select style="background:none;border:0;">
							<option value="CA">ATAS</option>
							<option value="CB">BAWAH</option>
						</select>';
						$aksi = '-';
					}
					$html .= '<tr class="thdhdz">
						<td style="padding:6px;border:1px solid #dee2e6">'.$cAB.'</td>
						<td style="padding:6px;border:1px solid #dee2e6">'.$r->roll.'</td>
						<td style="padding:6px;text-align:center;border:1px solid #dee2e6">'.$r->nm_ker.'</td>
						<td style="padding:6px;text-align:center;border:1px solid #dee2e6">'.$r->g_label.'</td>
						<td style="padding:6px;text-align:center;border:1px solid #dee2e6">'.round($r->width,2).'</td>
						<td style="padding:6px;text-align:center;border:1px solid #dee2e6">'.$r->diameter.'</td>
						<td style="padding:6px;text-align:center;border:1px solid #dee2e6">'.number_format($berat).'</td>
						<td style="padding:6px;text-align:center;border:1px solid #dee2e6">'.$r->joint.'</td>
						<td style="padding:6px;border:1px solid #dee2e6">'.$r->ket.'</td>
						<td style="padding:6px;text-align:center;border:1px solid #dee2e6">'.$pStt.'</td>
						<td style="padding:6px;text-align:center;border:1px solid #dee2e6">'.round($r->g_ac,2).'</td>
						<td style="padding:6px;text-align:center;border:1px solid #dee2e6">'.round($r->rct,2).'</td>
						<td style="padding:6px;text-align:center;border:1px solid #dee2e6">'.round($r->bi,2).'</td>
						<td style="padding:6px;text-align:center;border:1px solid #dee2e6">'.$aksi.'</td>
					</tr>';
				}
			$html .= '</table></div>';

			$html .= '<div class="card-body row" style="padding:12px 6px;font-weight:bold">
				<div class="col-md-1">INPUT</div>
				<div class="col-md-11">
					<button type="button" class="btn btn-success" style="font-weight:bold" onclick="addRollCorr('."'".$opsi."'".')"><i class="fas fa-plus"></i> TAMBAH</button>
				</div>
			</div>';
		}

		echo json_encode([
			'html' => $html,
		]);
	}

	function cariGunaRoll(){
		$tgl_guna = $_POST["tgl_guna"];
		$html = '';

		$zV = $this->db->query("SELECT COUNT(r.roll) AS jml_roll,r.id_roll AS rollid,r.id_so_dtl,l.* FROM trs_so_roll r
		INNER JOIN trs_so_detail so ON so.id=r.id_so_dtl
		INNER JOIN m_roll l ON l.id=r.id_roll
		WHERE so.eta_so='$tgl_guna'
		GROUP BY r.id_roll
		ORDER BY l.t_cor,r.roll");

		if($zV->num_rows() == 0){
			$html .= '<div style="padding:6px;font-weight:bold">DATA KOSONG!</div>';
		}else{
			$html .= '<div style="overflow:auto;white-space:nowrap">
				<table style="margin:0 6px 6px">
					<tr>
						<td style="background:#f2f2f2;padding:6px;font-weight:bold;text-align:center;border:1px solid #dee2e6">#</td>
						<td style="background:#f2f2f2;padding:6px;font-weight:bold;text-align:center;border:1px solid #dee2e6">CORR</td>
						<td style="background:#f2f2f2;padding:6px;font-weight:bold;text-align:center;border:1px solid #dee2e6">ROLL</td>
						<td style="background:#f2f2f2;padding:6px;font-weight:bold;text-align:center;border:1px solid #dee2e6">GUNA</td>
						<td style="background:#f2f2f2;padding:6px;font-weight:bold;text-align:center;border:1px solid #dee2e6">AKSI</td>
					</tr>';
					$i = 0;
					$gNa = 0;
					foreach($zV->result() as $r){
						$i++;
						($r->jml_roll == 1) ? $k = '' : $k = ' <span class="bg-dark" style="vertical-align:top;font-weight:bold;border-radius:3px;padding:2px 4px;font-size:11px">'.$r->jml_roll.'</span>';
						// CEK HASIL
						$cH = $this->db->query("SELECT*FROM trs_so_hasil WHERE id_so_dtl='$r->id_so_dtl' GROUP BY id_so_dtl");
						if($cH->num_rows() != 0){
							$aH = '<button type="button" onclick="bGunaRoll('."'".$r->rollid."'".')" style="font-weight:bold" class="btn btn-warning btn-xs">EDIT</button>';
						}else{
							$aH = '-';
						}
						// CEK GUNA
						$cG = $this->db->query("SELECT g.* FROM trs_so_detail s
						INNER JOIN trs_so_roll r ON s.id=r.id_so_dtl
						INNER JOIN trs_so_guna g ON r.id_roll=g.id_roll AND s.eta_so=g.tgl
						WHERE s.eta_so='$tgl_guna' AND g.id_roll='$r->rollid'");
						($cG->num_rows() == 0) ? $gg = '' : $gg = ' <span style="vertical-align:top;font-weight:bold;border-radius:3px;padding:2px 4px;font-size:11px"><i class="fas fa-check" style="color:#007bff"></i></span>';
						($cG->num_rows() == 0) ? $ig = '-' : $ig = number_format($cG->row()->pemakaian);
						$html .= '<tr class="thdhdz">
							<td style="padding:6px;text-align:center;border:1px solid #dee2e6">'.$i.'</td>
							<td style="padding:6px;text-align:center;border:1px solid #dee2e6">'.$r->t_cor.'</td>
							<td style="padding:6px;border:1px solid #dee2e6">'.$r->roll.$k.'</td>
							<td style="padding:6px;text-align:right;border:1px solid #dee2e6">'.$ig.'</td>
							<td style="padding:6px;border:1px solid #dee2e6">
								'.$aH.$gg.'
							</td>
						</tr>';

						$gNa += ($cG->num_rows() == 0) ? $ig = 0 : $ig = $cG->row()->pemakaian;
					}
					// TOTAL
					if($zV->num_rows() > 1){
						$html .= '<tr>
							<td style="background:#f2f2f2;padding:5px;border:1px solid #dee2e6;font-weight:bold;text-align:center" colspan="3">TOTAL</td>
							<td style="background:#f2f2f2;padding:5px;border:1px solid #dee2e6;font-weight:bold;text-align:right">'.number_format($gNa).'</td>
							<td style="background:#f2f2f2;padding:5px;border:1px solid #dee2e6"></td>
						</tr>';
					}
				$html .= '</table>
			</div>';
		}

		echo json_encode([
			'html' => $html,
		]);
	}

	function bGunaRoll()
	{
		$tgl_guna = $_POST["tgl_guna"];
		$roll = $_POST["roll"];
		$html = '';

		$qS = $this->db->query("SELECT s.kode_po,c.nm_pelanggan,c.attn,s.eta_so,r.*,i.* FROM trs_so_roll r
		INNER JOIN m_roll l ON l.id=r.id_roll
		INNER JOIN trs_so_detail s ON s.id=r.id_so_dtl
		INNER JOIN m_pelanggan c ON s.id_pelanggan=c.id_pelanggan
		INNER JOIN m_produk i ON s.id_produk=i.id_produk
		WHERE r.id_roll='$roll'
		ORDER BY s.eta_so");

		if($qS->num_rows() == 0){
			$html .= '<div style="padding:6px;font-weight:bold">DATA KOSONG!</div>';
		}else{
			$html .= '<div style="overflow:auto;white-space:nowrap"><table style="margin:0 6px 6px">
				<tr>
					<td style="background:#f2f2f2;padding:6px;font-weight:bold;text-align:center;border:1px solid #dee2e6">HARI, TGL</td>
					<td style="background:#f2f2f2;padding:6px;font-weight:bold;text-align:center;border:1px solid #dee2e6">NO. PO</td>
					<td style="background:#f2f2f2;padding:6px;font-weight:bold;text-align:center;border:1px solid #dee2e6">CUSTOMER</td>
					<td style="background:#f2f2f2;padding:6px;font-weight:bold;text-align:center;border:1px solid #dee2e6">ITEM</td>
				</tr>';
				$i = 0;
				foreach($qS->result() as $r){
					$i++;
					($r->kategori == 'K_BOX') ? $k = '[BOX] ' : $k = '[SHEET] ';
					$html .= '<tr class="thdhdz">
						<td style="padding:6px;border:1px solid #dee2e6">'.strtoupper(substr($this->m_fungsi->getHariIni($r->eta_so),0,3)).', '.strtoupper($this->m_fungsi->tglIndSkt($r->eta_so)).'</td>
						<td style="padding:6px;border:1px solid #dee2e6">'.$r->kode_po.'</td>
						<td style="padding:6px;border:1px solid #dee2e6">'.$r->nm_pelanggan.'</td>
						<td style="padding:6px;border:1px solid #dee2e6">'.$k.$r->nm_produk.'</td>
					</tr>';
				}
			$html .= '</table></div>';
		}

		$qR = $this->db->query("SELECT*FROM m_roll WHERE id='$roll'")->row();
		$fixBerat = $qR->weight - $qR->seset;
		$html .= '<div style="overflow:auto;white-space:nowrap">
			<input type="hidden" id="add_roll" value="'.$roll.'">
			<input type="hidden" id="add_weight" value="'.$fixBerat.'">
			<table style="margin:0 6px 6px">
			<tr>
				<td style="background:#f2f2f2;padding:6px;font-weight:bold;text-align:center;border:1px solid #dee2e6">CORR</td>
				<td style="background:#f2f2f2;padding:6px;font-weight:bold;text-align:center;border:1px solid #dee2e6">ROLL</td>
				<td style="background:#f2f2f2;padding:6px;font-weight:bold;text-align:center;border:1px solid #dee2e6">JENIS</td>
				<td style="background:#f2f2f2;padding:6px;font-weight:bold;text-align:center;border:1px solid #dee2e6">GSM</td>
				<td style="background:#f2f2f2;padding:6px;font-weight:bold;text-align:center;border:1px solid #dee2e6">WIDTH</td>
				<td style="background:#f2f2f2;padding:6px;font-weight:bold;text-align:center;border:1px solid #dee2e6">BERAT</td>
				<td style="background:#f2f2f2;padding:6px;font-weight:bold;text-align:center;border:1px solid #dee2e6">JOINT</td>
				<td style="background:#f2f2f2;padding:6px;font-weight:bold;text-align:center;border:1px solid #dee2e6">KETERANGAN</td>
			</tr>';
			$html .= '<tr class="thdhdz">
				<td style="padding:6px;font-weight:bold;text-align:center;border:1px solid #dee2e6">'.$qR->t_cor.'</td>
				<td style="padding:6px;font-weight:bold;text-align:center;border:1px solid #dee2e6">'.$qR->roll.'</td>
				<td style="padding:6px;font-weight:bold;text-align:center;border:1px solid #dee2e6">'.$qR->nm_ker.'</td>
				<td style="padding:6px;font-weight:bold;text-align:center;border:1px solid #dee2e6">'.$qR->g_label.'</td>
				<td style="padding:6px;font-weight:bold;text-align:center;border:1px solid #dee2e6">'.round($qR->width).'</td>
				<td style="padding:6px;font-weight:bold;text-align:center;border:1px solid #dee2e6">'.number_format($qR->weight).'</td>
				<td style="padding:6px;font-weight:bold;text-align:center;border:1px solid #dee2e6">'.$qR->joint.'</td>
				<td style="padding:6px;font-weight:bold;text-align:center;border:1px solid #dee2e6">'.$qR->ket.'</td>
			</tr>';
			// all guna
			$qH = $this->db->query("SELECT*FROM trs_so_guna WHERE id_roll='$roll' ORDER BY tgl");
			if($qH->num_rows() != 0){
				foreach($qH->result() as $h){
					// cek so
					$qC = $this->db->query("SELECT*FROM trs_so_detail s
					INNER JOIN trs_so_roll r ON s.id=r.id_so_dtl
					INNER JOIN trs_so_guna g ON r.id_roll=g.id_roll AND s.eta_so=g.tgl
					WHERE g.id_roll='$h->id_roll' AND g.tgl='$h->tgl' AND s.status_2='Open'");
					if($qC->num_rows() != 0){
						$btnDel = '<button class="btn btn-xs btn-danger" onclick="delRollGuna('."'".$h->id."'".')"><i class="fas fa-trash"></i></button>';
					}else{
						$btnDel = '';
					}
					$html .= '<tr>
						<td style="padding:6px;text-align:right" colspan="5">'.$h->tgl.'</td>
						<td style="padding:6px;text-align:right">'.number_format($h->pemakaian).'</td>
						<td style="padding:6px;center;text-align:center">'.$btnDel.'</td>
						<td style="padding:6px;center">'.$h->ket.'</td>
					</tr>';
				}
				$html .= '<tr>
					<td style="padding:6px;text-align:right" colspan="5">SISA</td>
					<td style="padding:6px;text-align:right">'.number_format($fixBerat).'</td>
				</tr>';
			}
		$html .= '</table></div>';

		// cek guna
		$cG = $this->db->query("SELECT*FROM trs_so_guna WHERE tgl='$tgl_guna' AND id_roll='$roll'");
		if($cG->num_rows() == 0){
			$html .= '<div class="card-body row" style="padding:3px 6px;font-weight:bold">
				<div class="col-md-1">PENGGUNAAN</div>
				<div class="col-md-1">
					<input type="number" id="add_guna" class="form-control" autocomplete="off" placeholder="0" onkeyup="hitungGuna('."'guna'".')">
				</div>
				<div class="col-md-10"></div>
			</div>
			<div class="card-body row" style="padding:3px 6px;font-weight:bold">
				<div class="col-md-1">SISA</div>
				<div class="col-md-1">
					<input type="number" id="add_sisa" class="form-control" autocomplete="off" placeholder="0" onkeyup="hitungGuna('."'sisa'".')">
				</div>
				<div class="col-md-10"></div>
			</div>
			<div class="card-body row" style="padding:3px 6px;font-weight:bold">
				<div class="col-md-1">KETERANGAN</div>
				<div class="col-md-3">
					<input type="text" id="add_ket" class="form-control" autocomplete="off" placeholder="KET" oninput="this.value=this.value.toUpperCase()">
				</div>
				<div class="col-md-8"></div>
			</div>
			<div class="card-body row" style="padding:3px 6px 6px;font-weight:bold">
				<div class="col-md-1"></div>
				<div class="col-md-11">
					<button type="button" class="btn btn-primary btn-sm" style="font-weight:bold" onclick="btnGunaSisa()"><i class="fas fa-plus"></i> TAMBAH</button>
				</div>
			</div>';
		}

		echo json_encode([
			'html' => $html,
		]);
	}

	function pilihanEtaPO()
	{
		$html ='';

		$tgl1 = date('Y-m-d');
		$tgl3 = date('Y-m-d', strtotime('+12 month', strtotime($tgl1)));
		$getData = $this->db->query("SELECT eta,COUNT(eta) AS jml FROM trs_po_detail WHERE eta BETWEEN '$tgl1' AND '$tgl3' GROUP BY eta ASC");

		$html .='<div style="padding:6px;font-weight:bold">
			<table class="table table-bordered table-striped" style="margin:0">
				<thead>
					<tr>
						<th>HARI, TANGGAL</th>
						<th style="text-align:center">#</th>
					</tr>
				</thead>';
				$i = 0;
				foreach($getData->result() as $r){
					$i++;
					$html .= '</tr>
						<td><a href="javascript:void(0)" onclick="tampilDataEtaPO('."''".', '."'".$r->eta."'".')">'.strtoupper(substr($this->m_fungsi->getHariIni($r->eta),0,3)).', '.strtoupper($this->m_fungsi->tanggal_format_indonesia($r->eta)).'<a></td>
						<td style="text-align:center">'.$r->jml.'</td>
					</tr>';
				}
			$html .='</table>
		</div>';

		echo $html;
	}

	function tampilDataEtaPO()
	{
		$html = '';
		$id_pelanggan = $_POST["id_pelanggan"];
		($id_pelanggan != '') ? $id_pt = "AND p.id_pelanggan='$id_pelanggan'" : $id_pt = "";
		$tgl = $_POST["tgl"];

		$html .='<div class="card card-info card-outline">
			<div class="card-header">
				<h3 class="card-title" style="font-weight:bold">'.strtoupper(substr($this->m_fungsi->getHariIni($tgl),0,3)).', '.strtoupper($this->m_fungsi->tanggal_format_indonesia($tgl)).'</h3>
			</div>
			<div style="padding:6px">
				<div style="overflow:auto;white-space:nowrap">';
					$cust = $this->db->query("SELECT*FROM trs_po_detail p
					INNER JOIN m_pelanggan c ON p.id_pelanggan=c.id_pelanggan
					WHERE eta='$tgl' $id_pt GROUP BY p.id_pelanggan ORDER BY c.nm_pelanggan");
					if($cust->num_rows() == 0){
						$html .= 'DATA KOSONG!';
					}else{
						$html .='<table>
							<tr>
								<td style="padding:5px;font-weight:bold;border:1px solid #aaa;border-width:1px 1px 3px">ITEM DESCRIPTION</td>
								<td style="padding:5px;font-weight:bold;border:1px solid #aaa;border-width:1px 1px 3px;text-align:center">QTY</td>
								<td style="padding:5px;font-weight:bold;border:1px solid #aaa;border-width:1px 1px 3px;text-align:center">TONASE</td>
								<td style="padding:5px;font-weight:bold;border:1px solid #aaa;border-width:1px 1px 3px;text-align:center">ETA KETERANGAN</td>
							</tr>';
							// CUSTOMER
							foreach($cust->result() as $c){
								$html .= '<tr>
									<td style="background:#333;color:#fff;font-weight:bold;padding:5px;border:1px solid #aaa" colspan="4">'.$c->nm_pelanggan.'</td>
								</tr>';
								// NO. PO
								$po = $this->db->query("SELECT*FROM trs_po_detail WHERE eta='$tgl' AND id_pelanggan='$c->id_pelanggan' GROUP BY kode_po");
								foreach($po->result() as $p){
									$html .= '<tr>
										<td style="background:#ccc;padding:5px;font-weight:bold;border:1px solid #aaa" colspan="4">'.$p->kode_po.'</td>
									</tr>';
									// PRODUK
									$produk = $this->db->query("SELECT*FROM trs_po_detail p
									INNER JOIN m_produk i ON p.id_produk=i.id_produk
									WHERE p.eta='$tgl' AND p.id_pelanggan='$p->id_pelanggan' AND p.kode_po='$p->kode_po'
									ORDER BY i.id_produk");
									foreach($produk->result() as $i){
										($i->kategori == 'K_BOX') ? $kat = 'BOX' : $kat = 'SHEET';
										($i->kategori == 'K_BOX') ? $ukuran = '<br>'.$i->ukuran : $ukuran = '<br>'.$i->ukuran_sheet;
										$subs = '<br>'.$this->m_fungsi->kualitas($i->kualitas, $i->flute).' ( '.$i->flute.' ) ';
										$tonase = $i->bb * $i->qty;
										$html .= '<tr style="vertical-align:top">
											<td style="padding:5px;border:1px solid #aaa"><b>[ '.$kat.' ] '.$i->nm_produk.'</b> <span style="font-size:11px;vertical-align:top">( '.$i->bb.' )</span>'.$ukuran.$subs.'</td>
											<td style="padding:5px;border:1px solid #aaa;font-weight:bold;text-align:right">'.number_format($i->qty, 0, ',', '.').'</td>
											<td style="padding:5px;border:1px solid #aaa;font-weight:bold;text-align:right">'.number_format($tonase, 0, ',', '.').' KG</td>
											<td style="padding:5px;border:1px solid #aaa"><textarea style="resize:none;border:0;width:300px;height:70px;font-weight:bold">'.$i->eta_ket.'</textarea></td>
										</tr>';
									}
								}
							}
						$html .='</table>';
					}
				$html .='</div>
			</div>
		</div>';

		echo $html;
	}

	function cariAllEtaCust()
	{
		$html = '';
		$id_pelanggan = $_POST["id_pelanggan"];
		($id_pelanggan != '') ? $id_pt = "AND p.id_pelanggan='$id_pelanggan'" : $id_pt = "";
		$tgl = $_POST["tgl_po"];
		if($tgl != ''){
			$wTgl = "p.eta='$tgl'";
		}else{
			$tgl1 = date('Y-m-d');
			$tgl2 = date('Y-m-d', strtotime('+12 month', strtotime($tgl1)));
			$wTgl = "p.eta BETWEEN '$tgl1' AND '$tgl2'";
		}

		$cust = $this->db->query("SELECT*FROM trs_po_detail p
		INNER JOIN m_pelanggan c ON p.id_pelanggan=c.id_pelanggan
		WHERE $wTgl $id_pt
		GROUP BY p.id_pelanggan
		ORDER BY c.nm_pelanggan");

		$html .='<div style="padding:6px;font-weight:bold">
			<table class="table table-bordered table-striped">';
			// CUSTOMER
			foreach($cust->result() as $c){
				$html .= '<thead>
					<tr>
						<th style="background:#333;color:#fff">'.$c->nm_pelanggan.'</th>
						<th style="background:#333;color:#fff;text-align:center">#</th>
					</tr>
				</thead>';
				// TANGGAL ETA
				$eta = $this->db->query("SELECT p.eta,p.id_pelanggan,COUNT(p.eta) AS jml FROM trs_po_detail p WHERE $wTgl AND p.id_pelanggan='$c->id_pelanggan' GROUP BY p.eta ASC");
				foreach($eta->result() as $e){
					$html .= '<tr>
						<td><a href="javascript:void(0)" onclick="tampilDataEtaPO('."'".$e->id_pelanggan."'".', '."'".$e->eta."'".')">'.strtoupper(substr($this->m_fungsi->getHariIni($e->eta),0,3)).', '.strtoupper($this->m_fungsi->tanggal_format_indonesia($e->eta)).'<a></td>
						<td style="text-align:center">'.$e->jml.'</td>
					</tr>';
				}
			}
			$html .='</table>
		</div>';

		echo $html;
	}

	function tampilListHpp()
	{
		$jenis_hpp = $_POST["jenis_hpp"];
		$rentang = $_POST["rentang"];
		$opsi = $_POST["opsi"];
		if($opsi == 'sheet'){
			$pilih_hpp = 'PM2';
			$cek = "AND cek_sheet='N'";
		}else if($opsi == 'box'){
			$pilih_hpp = 'SHEET';
			$cek = "AND cek_box='N'";
		}else if($opsi == 'laminasi'){
			$pilih_hpp = 'PM2';
			$cek = "AND cek_laminasi='N'";
		}

		$data = $this->db->query("SELECT*FROM m_hpp WHERE pilih_hpp='$pilih_hpp' AND rentang_hpp='$rentang' AND jenis_hpp='$jenis_hpp' $cek");
		$html = '';
		if($data->num_rows() > 0){
			foreach($data->result() as $r){
				if($r->rentang_hpp == 'TAHUN'){
					$rentang = $r->tahun_hpp;
				}else if($r->rentang_hpp == 'BULAN'){
					$rentang = strtoupper($this->m_fungsi->getBulan($r->bulan_hpp));
				}else{
					$rentang = strtoupper($this->m_fungsi->tanggal_format_indonesia($r->tgl_hpp));
				}
				$html .='<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
					<div class="col-md-3">
						<button type="button" class="btn btn-block btn-sm bg-gradient-success" style="color:#000;font-weight:bold" onclick="pilihListHPP('."'".$r->id_hpp."'".','."'".$opsi."'".')">
							<i class="fas fa-list" style="margin-right:6px"></i>
							'.$rentang.', '.$r->jenis_hpp.'
						</button>
					</div>
					<div class="col-md-9"></div>
				</div>';
			}
		}else{
			$html .='<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
				<div class="col-md-12">DATA KOSONG!</div>
			</div>';
		}

		echo json_encode([
			'html' => $html,
		]);
	}

	function pilihListHPP()
	{
		$id_hpp = $_POST["id_hpp"];
		$get = $this->db->query("SELECT*FROM m_hpp WHERE id_hpp='$id_hpp'")->row();

		$pm = [
			"id_hpp" => $get->id_hpp,
			"jenis_hpp" => $get->jenis_hpp,
			"bahan_baku_rp" => number_format($get->bahan_baku_rp,0,',','.'),
			"hasil_x_tonase" => number_format($get->hasil_x_tonase,0,',','.'),
			"hasil_x_tonase_tanpa_bb" => number_format($get->hasil_x_tonase_tanpa_bb,0,',','.'),
			"hpp_plus_plus" => number_format($get->hpp_plus_plus,0,',','.'),
			"fix_hpp" => number_format($get->fix_hpp,0,',','.'),
		];

		echo json_encode([
			'pm' => $pm,
		]);
	}

	function destroyHPP()
	{
		$this->cart->destroy();
	}

	function keteranganHPP()
	{
		if(($_POST["ket_txt"] == "" || $_POST["ket_rp"] == "") && ($_POST["opsi"] == 'upah' || $_POST["opsi"] == 'bb' || $_POST["opsi"] == 'lainlain')){
			echo json_encode(array('valid' => false, 'data' => 'KETERANGAN TIDAK BOLEH KOSONG!'));
		}else{
			$id_hpp = $_POST["id_hpp"];
			$opsi = $_POST['opsi'];
			$jenis = $_POST['jenis'];
			$ket_txt = $_POST['ket_txt'];
			$cek = $this->db->query("SELECT*FROM m_hpp_detail WHERE id_hpp='$id_hpp' AND opsi='$opsi' AND jenis='$jenis' AND ket_txt='$ket_txt'");

			$data = array(
				'id' => $_POST['id_cart'],
				'name' => $_POST['id_cart'],
				'price' => 0,
				'qty' => 1,
				'options' => array(
					'id_hpp' => $_POST["id_hpp"],
					'opsi' => $_POST['opsi'],
					'jenis' => $_POST['jenis'],
					'ket_txt' => $_POST['ket_txt'],
					'ket_kg' => $_POST['ket_kg'],
					'ket_rp' => $_POST['ket_rp'],
					'ket_x' => $_POST['ket_x'],
				)
			);

			if($cek->num_rows() > 0){
				echo json_encode(array('valid' => false, 'data' => 'ITEM SUDAH ADA!')); return;
			}else{
				if($this->cart->total_items() != 0){
					foreach($this->cart->contents() as $r){
						if($_POST["opsi"] == 'upah' && $r['options']['ket_txt'] == $_POST["ket_txt"]){
							echo json_encode(array('valid' => false, 'data' => 'ITEM SUDAH ADA!')); return;
						}
						if($_POST["opsi"] == 'bb' && $r['options']['ket_txt'] == $_POST["ket_txt"]){
							echo json_encode(array('valid' => false, 'data' => 'ITEM SUDAH ADA!')); return;
						}
						if($_POST["opsi"] == 'lainlain' && $r['options']['ket_txt'] == $_POST["ket_txt"] && $r['options']['ket_kg'] == $_POST["ket_kg"] && $r['options']['ket_rp'] == $_POST["ket_rp"]){
							echo json_encode(array('valid' => false, 'data' => 'ITEM SUDAH ADA!')); return;
						}
					}
					$this->cart->insert($data);
					echo json_encode(array('valid' => true, 'data' => $data));
				}else{
					$this->cart->insert($data);
					echo json_encode(array('valid' => true, 'data' => $data));
				}
			}
		}
	}

	function listKeteranganHPP()
	{
		$opsi = $_POST['opsi'];
		$jenis = $_POST['jenis'];
		$id_hpp = $_POST['id_hpp'];
		$sum = $this->db->query("SELECT SUM(ket_kg) AS ket_kg,SUM(ket_rp) AS ket_rp,SUM(ket_x) AS ket_x FROM m_hpp_detail
		WHERE id_hpp='$id_hpp' AND opsi='$opsi' AND jenis='$jenis'
		GROUP BY id_hpp,opsi,jenis");

		$htmlUpah = '';
		$htmlBB = '';
		$htmlLainLain = '';
		if($sum->num_rows() > 0){
			$sumUpah = $sum->row()->ket_rp;
			$sumBBkg = $sum->row()->ket_kg;
			$sumBBrp = $sum->row()->ket_x;
			$sumLLkg = $sum->row()->ket_kg;
			$sumLLrp = $sum->row()->ket_x;
		}else{
			$sumUpah = 0;
			$sumBBkg = 0;
			$sumBBrp = 0;
			$sumLLkg = 0;
			$sumLLrp = 0;
		}

		if($this->cart->total_items() == 0){
			$htmlUpah .= '';
			$htmlBB .= '';
			$htmlLainLain .= '';
		}

		if($this->cart->total_items() != 0){
			foreach($this->cart->contents() as $r){
				if($r['options']['opsi'] == 'upah'){
					$htmlUpah .= '<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
						<div class="col-md-3">
							<button class="btn btn-xs btn-danger" style="padding:1px 4px" onclick="hapusKeteranganHPP('."'".$r['rowid']."'".','."'".$r['options']['opsi']."'".','."'".$r['options']['jenis']."'".','."'".$r['options']['id_hpp']."'".')"><i class="fas fa-times"></i></button> '.$r['options']['ket_txt'].'
						</div>
						<div class="col-md-9">
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text" style="padding:6px">Rp</span>
								</div>
								<input type="text" class="form-control" style="font-weight:bold;color:#000;text-align:right" value="'.number_format($r['options']['ket_rp'],0,',','.').'" disabled>
							</div>
						</div>
					</div>';
					$sumUpah += $r['options']['ket_rp'];
				}
			}

			foreach($this->cart->contents() as $r){
				if($r['options']['opsi'] == 'bb'){
					if($r['options']['ket_kg'] == 0){
						$htmlBB .= '<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
							<div class="col-md-3">
								<button class="btn btn-xs btn-danger" style="padding:1px 4px" onclick="hapusKeteranganHPP('."'".$r['rowid']."'".','."'".$r['options']['opsi']."'".','."'".$r['options']['jenis']."'".','."'".$r['options']['id_hpp']."'".')"><i class="fas fa-times"></i></button> '.$r['options']['ket_txt'].'
							</div>
							<div class="col-md-6"></div>
							<div class="col-md-3">
								<div class="input-group" style="margin-bottom:3px">
									<div class="input-group-prepend">
										<span class="input-group-text" style="padding:6px;font-weight:bold;color:#000">Rp</span>
									</div>
									<input type="text" class="form-control" style="font-weight:bold;color:#000;text-align:right" value="'.number_format($r['options']['ket_rp'],0,',','.').'" disabled>
								</div>
							</div>
						</div>';
					}
					if($r['options']['ket_kg'] != 0){
						$htmlBB .= '<div class="card-body row" style="font-weight:bold;padding:0 12px 3px">
							<div class="col-md-3">
								<button class="btn btn-xs btn-danger" style="padding:1px 4px" onclick="hapusKeteranganHPP('."'".$r['rowid']."'".','."'".$r['options']['opsi']."'".','."'".$r['options']['jenis']."'".','."'".$r['options']['id_hpp']."'".')"><i class="fas fa-times"></i></button> '.$r['options']['ket_txt'].'
							</div>
							<div class="col-md-3">
								<div class="input-group" style="margin-bottom:3px">
									<input type="text" class="form-control" style="font-weight:bold;color:#000;text-align:right" value="'.number_format($r['options']['ket_kg'],0,',','.').'" disabled>
									<div class="input-group-prepend">
										<span class="input-group-text" style="padding:6px;font-weight:bold;color:#000">Kg</span>
									</div>
								</div>
							</div>
							<div class="col-md-3">
								<div class="input-group" style="margin-bottom:3px">
									<div class="input-group-prepend">
										<span class="input-group-text" style="padding:6px">Rp</span>
									</div>
									<input type="text" class="form-control" style="text-align:right" value="'.number_format($r['options']['ket_rp'],0,',','.').'" disabled>
								</div>
							</div>
							<div class="col-md-3">
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text" style="padding:6px;font-weight:bold;color:#000">Rp</span>
									</div>
									<input type="text" class="form-control" style="font-weight:bold;color:#000;text-align:right" value="'.number_format($r['options']['ket_x'],0,',','.').'" disabled>
								</div>
							</div>
						</div>';
					}
					$sumBBkg += $r['options']['ket_kg'];
					$sumBBrp += $r['options']['ket_x'];
				}
			}

			foreach($this->cart->contents() as $r){
				if($r['options']['opsi'] == 'lainlain'){
					if($r['options']['ket_kg'] == 0){
						$htmlLainLain .= '<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
							<div class="col-md-3">
								<button class="btn btn-xs btn-danger" style="padding:1px 4px" onclick="hapusKeteranganHPP('."'".$r['rowid']."'".','."'".$r['options']['opsi']."'".','."'".$r['options']['jenis']."'".','."'".$r['options']['id_hpp']."'".')"><i class="fas fa-times"></i></button> '.$r['options']['ket_txt'].'
							</div>
							<div class="col-md-6"></div>
							<div class="col-md-3">
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text" style="padding:6px;font-weight:bold;color:#000">Rp</span>
									</div>
									<input type="text" class="form-control" style="font-weight:bold;color:#000;text-align:right" value="'.number_format($r['options']['ket_rp'],0,',','.').'" disabled>
								</div>
							</div>
						</div>';
					}
					if($r['options']['ket_kg'] != 0){
						$htmlLainLain .= '<div class="card-body row" style="font-weight:bold;padding:0 12px 3px">
							<div class="col-md-3">
								<button class="btn btn-xs btn-danger" style="padding:1px 4px" onclick="hapusKeteranganHPP('."'".$r['rowid']."'".','."'".$r['options']['opsi']."'".','."'".$r['options']['jenis']."'".','."'".$r['options']['id_hpp']."'".')"><i class="fas fa-times"></i></button> '.$r['options']['ket_txt'].'
							</div>
							<div class="col-md-3">
								<div class="input-group" style="margin-bottom:3px">
									<input type="text" class="form-control" style="font-weight:bold;color:#000;text-align:right" value="'.number_format($r['options']['ket_kg'],0,',','.').'" disabled>
									<div class="input-group-prepend">
										<span class="input-group-text" style="padding:6px;font-weight:bold;color:#000">Kg</span>
									</div>
								</div>
							</div>
							<div class="col-md-3">
								<div class="input-group" style="margin-bottom:3px">
									<div class="input-group-prepend">
										<span class="input-group-text" style="padding:6px">Rp</span>
									</div>
									<input type="text" class="form-control" style="text-align:right" value="'.number_format($r['options']['ket_rp'],0,',','.').'" disabled>
								</div>
							</div>
							<div class="col-md-3">
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text" style="padding:6px;font-weight:bold;color:#000">Rp</span>
									</div>
									<input type="text" class="form-control" style="font-weight:bold;color:#000;text-align:right" value="'.number_format($r['options']['ket_x'],0,',','.').'" disabled>
								</div>
							</div>
						</div>';
					}
					$sumLLkg += $r['options']['ket_kg'];
					$sumLLrp += $r['options']['ket_x'];
				}
			}
		}

		echo json_encode([
			'opsi' => $opsi,
			'htmlUpah' => $htmlUpah,
			'htmlBB' => $htmlBB,
			'htmlLainLain' => $htmlLainLain,
			'sumUpah' => number_format($sumUpah,0,',','.'),
			'sumBBkg' => number_format($sumBBkg,0,',','.'),
			'sumBBrp' => number_format($sumBBrp,0,',','.'),
			'sumLLkg' => number_format($sumLLkg,0,',','.'),
			'sumLLrp' => number_format($sumLLrp,0,',','.'),
			'sum' => $sum->row(),
		]);
	}

	function hapusKeteranganHPP()
	{
		$data = array(
			'rowid' => $_POST['rowid'],
			'qty' => 0,
		);
		$this->cart->update($data);
	}

	function list_dev()
	{
		$lvl = $this->session->userdata('level');
		$uName = $this->session->userdata('username');
		$html = '';

		$sales = $this->db->query("SELECT s.id_sales,s.nm_sales FROM trs_po p
		INNER JOIN m_pelanggan c ON p.id_pelanggan=c.id_pelanggan
		INNER JOIN m_sales s ON c.id_sales=s.id_sales
		WHERE p.status_kiriman='Open'
		GROUP BY s.id_sales ORDER BY s.nm_sales");

		if($sales->num_rows() != 0){
			$html .= '<div class="card card-info card-outline">
			<div class="card-header">
				<h3 class="card-title" style="font-weight:bold">SALES/CUSTOMER</h3>
				<div class="card-tools">
				</div>
			</div>
			<div style="padding:6px">
				<div style="overflow:auto;white-space:nowrap">
				
				<table style="color:#000;border-collapse: collapse" width="100%">';
				$html .= '<tr>
					<td style="background:#ccc;padding:5px;border:1px solid #aaa;font-weight:bold"></td>
				</tr>';
				foreach($sales->result() as $s){
					$html .= '<tr class="tr0">
						<td style="background:#eee;border:1px solid #aaa;font-weight:bold;padding:5px" colspan="2">
							<input type="hidden" id="ts1" value="">
							<button class="btn btn-xs ab1 b1-'.$s->id_sales.' btn-success" style="padding:1px 5px" onclick="btnPiuSales('."'".$s->id_sales."'".')">
								<i style="font-size:8px" class="fas af1 f1-'.$s->id_sales.' fa-plus"></i>
							</button>&nbsp
							'.$s->nm_sales.'
						</td>
					</tr>';

					// CUSTOMER
					$cust = $this->db->query("SELECT s.id_sales,p.id_pelanggan,c.nm_pelanggan,c.attn FROM trs_po p
					INNER JOIN m_pelanggan c ON p.id_pelanggan=c.id_pelanggan
					INNER JOIN m_sales s ON c.id_sales=s.id_sales
					WHERE p.status_kiriman='Open' AND s.id_sales='$s->id_sales'
					GROUP BY p.id_pelanggan ORDER BY c.nm_pelanggan");
					if($cust->num_rows() != 0){
						foreach($cust->result() as $r){

							$pt1 = $r->id_pelanggan;
							($r->attn == '-') ? $attn = '' : $attn = ' - '.$r->attn;
							//
							$html .= '<tr class="tr1 t'.$r->id_sales.'" style="display:none">
								<td style="background:#ddd;border:1px solid #aaa;font-weight:bold;padding:5px 5px 5px 15px" colspan="2">
									<input type="hidden" id="ts2" value="">
									<button class="btn btn-xs ab2 b2-'.$pt1.' btn-info" style="padding:1px 5px" onclick="btnPiuCustomer('."'".$pt1."'".')">
										<i style="font-size:8px" class="fas af2 f2-'.$pt1.' fa-plus"></i>
									</button>&nbsp
									'.$r->nm_pelanggan.$attn.'
								</td>
							</tr>';

							// LOKASI
							$lok = $this->db->query("SELECT*FROM m_pelanggan where id_pelanggan='$r->id_pelanggan'
							");
							if($lok->num_rows() != 0){
								foreach($lok->result() as $l){
									$html .= '<tr class="tr_l l'.$r->id_pelanggan.'" style="display:none">
										<td style="background:#ddd;border:1px solid #aaa;font-weight:bold;padding:5px 5px 5px 35px" colspan="2">
											<input type="hidden" id="ts3" value="">
											<button class="btn btn-xs ab3 b3-'.$r->id_pelanggan.' btn-danger" style="padding:1px 5px" onclick="btnPiuLok('."'".$l->id_pelanggan."'".')">
												<i style="font-size:8px" class="fas af3 f3-'.$r->id_pelanggan.' fa-plus"></i>
											</button>&nbsp
											'.$l->alamat.'
										</td>
									</tr>';
									// ITEM
									// $prod = $this->db->query("SELECT*FROM m_produk where no_customer='$l->id_pelanggan'");
									$prod = $this->db->query("SELECT i.* FROM trs_po p
									INNER JOIN trs_po_detail d ON p.no_po=d.no_po AND p.kode_po=d.kode_po
									INNER JOIN m_produk i ON d.id_produk=i.id_produk
									WHERE p.status_kiriman='Open' AND p.id_pelanggan='$l->id_pelanggan'
									GROUP BY d.id_produk ORDER BY i.nm_produk");
									if($prod->num_rows() != 0){
										foreach($prod->result() as $pr){
											($pr->kategori == "K_BOX") ? $ukuran = $pr->ukuran : $ukuran = $pr->ukuran_sheet;
											$html .= '<tr class="tr_p p'.$l->id_pelanggan.'" style="display:none">
												<td style="background:#ddd;border:1px solid #aaa;font-weight:bold;padding:5px 5px 5px 45px" colspan="2">
													<input type="hidden" id="ts5" value="">
													<button class="btn btn-xs ab5 b5-'.$pr->id_produk.' btn-danger" style="padding:1px 5px" onclick="Tampil_po('."'".$pr->id_produk."'".','."'".$l->id_pelanggan."'".','."'".$pr->nm_produk."'".')">
														<i style="font-size:8px" class="fas af5 f5-'.$pr->id_produk.' fa-plus"></i>
													</button>&nbsp
													'.$pr->nm_produk.' | '.$ukuran.' | '.$this->m_fungsi->kualitas($pr->kualitas, $pr->flute).' | '.$pr->flute.'
												</td>
											</tr>';
										}
									}
								}
							}
						}
					}
				}
				// TOTAL
				$html .= '<tr>
					<td style="background:#ccc;padding:5px;border:1px solid #aaa" colspan="2"></td>
				</tr>';
			$html .= '</table>
			</div>
			</div>
		</div>';
		}

		echo $html;
	}
	
	function hapusDelSys()
	{
		$result = $this->m_transaksi->hapusDelSys();
		echo json_encode($result);
	}

	function dsUrut()
	{
		$result = $this->m_transaksi->dsUrut();
		echo json_encode($result);
	}

	function plhEksDS()
	{
		$result = $this->m_transaksi->plhEksDS();
		echo json_encode($result);
	}

	function batalEksDS()
	{
		$result = $this->m_transaksi->batalEksDS();
		echo json_encode($result);
	}

	function TampilPO_dev()
	{
		$html = '';
		$id_produk    = $_POST["id_produk"];
		$id_pelanggan = $_POST["id_pelanggan"];
		$nm_produk    = $_POST["nm_produk"];
		$po_ = $this->db->query("SELECT*FROM trs_po p
		JOIN trs_po_detail d on p.kode_po=d.kode_po
		JOIN m_produk i ON d.id_produk=i.id_produk
		WHERE p.status_app3='Y' AND p.id_pelanggan='$id_pelanggan' AND d.id_produk='$id_produk' AND p.status_kiriman='Open'");
		$produk_ = $this->db->query("SELECT*from m_produk where id_produk='$id_produk'
		")->row();

		$html .= '<div class="card card-info card-outline">
			<div class="card-header">
				<h3 class="card-title" style="font-weight:bold;">
					LIST PO - <span style="color:red;"> '.$produk_->nm_produk.' </span> - <span style="color:red;"> '.$produk_->ukuran.' </span> - <span style="color:red;"> '.$this->m_fungsi->kualitas($produk_->kualitas, $produk_->flute).'</span> - <span style="color:red;">'.$produk_->flute.'</span>
				</h3>
				<div class="card-tools">
					<button type="button" onclick="kembali_po()" class="btn  btn-danger"><b>
						<i class="fa fa-arrow-left"></i> Kembali</b>
					</button>
				</div>
			</div>
			<div style="padding:6px">
				<div style="overflow:auto;white-space:nowrap">
					<table style="color:#000;border-collapse: collapse" width="100%">';
						$html .= '<tr>
							<td style="background:#ccc;padding:5px;border:1px solid #aaa;font-weight:bold"></td>
						</tr>';
						if($po_->num_rows() != 0){
							foreach($po_->result() as $po_ok) {
								$kirim = $this->db->query("SELECT SUM(r.qty_muat) AS tot_muat,r.*,p.* FROM m_rencana_kirim r
								INNER JOIN pl_box p ON r.rk_kode_po=p.no_po AND r.rk_urut=p.no_pl_urut AND r.id_pl_box=p.id
								WHERE p.no_po='$po_ok->kode_po' AND r.id_produk='$po_ok->id_produk'
								GROUP BY r.rk_tgl,r.id_pelanggan,r.id_produk,r.rk_kode_po,r.rk_urut");
								$sumKirim = 0;
								$sumRetur = 0;
								if($kirim->num_rows() > 0){
									foreach($kirim->result() as $k){
										$retur = $this->db->query("SELECT*FROM m_rencana_kirim_retur
										WHERE rtr_tgl='$k->tgl' AND rtr_id_pelanggan='$k->id_pelanggan' AND rtr_id_produk='$k->id_produk' AND rtr_kode_po='$k->rk_kode_po' AND rtr_urut='$k->rk_urut'");
										$sumKirim += $k->tot_muat;
										$sumRetur += ($retur->num_rows() == 0) ? 0 : $retur->row()->rtr_jumlah;
									}
								}
								$jumlah_plan = $this->db->query("SELECT IFNULL(sum(qty_plan),0)qty_plan FROM trs_dev_sys where id_po_header='$po_ok->id' and id_produk='$id_produk' and id_pelanggan='$id_pelanggan' GROUP BY id_po_header,id_produk,id_pelanggan 
								ORDER BY id_dev
								")->row();

								$sisa = $po_ok->qty - ($sumKirim - $sumRetur);
								$sisa_os_belum_terplanning = $sisa - $jumlah_plan->qty_plan;

								$html .= '<tr class="tr_po po'.$po_ok->id_produk.'" >
									<td style="background:#ddd;border:1px solid #aaa;font-weight:bold;padding:5px 5px 5px 5px" colspan="2">
										<input type="hidden" id="ts4" value="">
										<button class="btn btn-xs ab4 b4-'.$po_ok->id.' btn-danger" style="padding:1px 5px" onclick="btnPiuPO('."'".$po_ok->id."'".','."'".$id_produk."'".','."'".$id_pelanggan."'".','."'".$sisa."'".','."'".$sumKirim."'".')">
											<i style="font-size:8px" class="fas af4 f4-'.$po_ok->id.' fa-plus"></i>
										</button>&nbsp
										'.$po_ok->kode_po.'
									</td>
								</tr>';
								// OUTSTANDING PO
								$html .= '				
								<tr class="tr_i i'.$po_ok->id.'" style="display:none">
									<td style="padding:0;border:1px solid #aaa">
										<table width="100%" style="border-collapse:collapse">
											<tbody>
												<tr>
													<th style="padding:5px;text-align:center;border:1px solid #aaa;background:#00b0c0ff;" colspan="2">QTY PO</th>
													<th style="padding:5px;text-align:center;border:1px solid #aaa;background:#00b0c0ff;">DELIVERY</th>
													<th style="padding:5px;text-align:center;border:1px solid #aaa;background:#00b0c0ff;">OS</th>
													<th style="padding:5px 10px;text-align:center;border:1px solid #aaa;" rowspan="2" colspan="2">
														<button type="button" onclick="simpan('.$po_ok->id.','.$id_produk.','.$id_pelanggan.',`add`)" class="btn-tambah-produk btn btn-sm btn-warning" style="color: #ffffffff;">
															<b><i class="fas fa-shopping-basket"></i></b>
														</button>
													</th>
												</tr>
												<tr>
													<td style="padding:5px;border:1px solid #aaa;text-align:center" colspan="2">
														<input style="text-align:center;border:none;" id="qty_po'.$po_ok->id.'" autocomplete="off" value="'.number_format($po_ok->qty,0,',','.').'" readonly>
													</td>
													<td style="padding:5px;border:1px solid #aaa;text-align:center;">
														<input style="text-align:center;border:none;" id="delivery'.$po_ok->id.'" autocomplete="off" value="'.number_format($sumKirim,0,',','.').'" readonly>
													</td>
													<td style="padding:5px;border:1px solid #aaa;text-align:center;">
														<input style="text-align:center;border:none;" id="os'.$po_ok->id.'" autocomplete="off" value="'.number_format($sisa,0,',','.').'" readonly>
													</td>
													
												</tr>
												<tr>
													<th style="padding:5px;text-align:center;border:1px solid #aaa;background:#ff0000ff;">OS TERPLANNING</th>
													<th style="padding:5px;text-align:center;border:1px solid #aaa;background:#ff0000ff;">BB</th>
													<th style="padding:5px;text-align:center;border:1px solid #aaa;background:#ff0000ff;">OS BELUM TERPLANNING</th>
													<th style="padding:5px 10px;text-align:center;border:1px solid #aaa;background:#007bffff;">QTY PLAN DELIVERY</th>
													<th style="padding:5px 10px;text-align:center;border:1px solid #aaa;background:#007bffff;" colspan="2">ETA</th>
												</tr>
												<tr>
													<td style="padding:5px;text-align:center;border:1px solid #aaa">
														<input style="text-align:center;border:none;" id="os_terplanning'.$po_ok->id.'" autocomplete="off" readonly>
													</td>
													<td style="padding:5px;text-align:center;border:1px solid #aaa">
														<input style="text-align:center;border:none;" id="os_bb'.$po_ok->id.'" value="'.$produk_->berat_bersih.'" autocomplete="off" readonly>
													</td>
													<td style="padding:5px;text-align:center;border:1px solid #aaa;">
														<input style="text-align:center;border:none;" id="os_belum_terplanning'.$po_ok->id.'" autocomplete="off" value="'.number_format($sisa_os_belum_terplanning,0,',','.').'" readonly>
													</td>
													<td style="padding:5px;text-align:center;border:1px solid #aaa;">								
														<input class="form-control" style="text-align:center;" type="number" id="qty_plan'.$po_ok->id.'" autocomplete="off" onkeyup="hitung_os_plan(this.value,this.id,'.$sisa_os_belum_terplanning.','.$po_ok->id.')">
													</td>
													<td style="padding:5px;text-align:center;border:1px solid #aaa;text-align:center" colspan="2">
														<input class="form-control" type="date" id="eta'.$po_ok->id.'" autocomplete="off" >
													</td>
												</tr>
												<tr>
													<th style="padding:5px 10px;text-align:center;border:1px solid #aaa;background-color: #454545;color: #ffffff;" colspan="6">HISTORY PLAN</th>
												</tr>
												<tr>
													<th style="padding:5px;text-align:center;border:1px solid #aaa;background:#454545;color: #ffffff;">OS TERPLANNING</th>
													<th style="padding:5px;text-align:center;border:1px solid #aaa;background:#454545;color: #ffffff;">BERAT</th>
													<th style="padding:5px;text-align:center;border:1px solid #aaa;background:#454545;color: #ffffff;">OS BELUM TERPLANNING</th>
													<th style="padding:5px 10px;text-align:center;border:1px solid #aaa;background:#454545;color: #ffffff;">QTY PLAN DELIVERY</th>
													<th style="padding:5px 10px;text-align:center;border:1px solid #aaa;background:#454545;color: #ffffff;">ETA</th>
													<th style="padding:5px 10px;text-align:center;border:1px solid #aaa;background:#454545;color: #ffffff;">HAPUS</th>
												</tr>';

												// HISTORY PLAN
												$history_plan = $this->db->query("SELECT*FROM trs_dev_sys where id_po_header='$po_ok->id' and id_produk='$id_produk' and id_pelanggan='$id_pelanggan' ORDER BY id_dev");
												if($history_plan->num_rows() > 0){
													foreach($history_plan->result() as $his_plan){
														($his_plan->id_ex == null) ? $delH = 'onclick="del_history('.$his_plan->id_dev.',`add`)"' : $delH = 'disabled';
														$html .= '<tr>
															<td style="padding:5px;text-align:center;border:1px solid #aaa">
																<input style="text-align:center;border:none" id="his_os_terplanning'.$po_ok->id.'" value="'.number_format($his_plan->os_terplanning,0,',','.').'" readonly>
															</td>
															<td style="padding:5px;text-align:center;border:1px solid #aaa">
																<input style="text-align:center;border:none" id="his_os_berat'.$po_ok->id.'" value="'.number_format($his_plan->berat,0,',','.').'" readonly>
															</td>
															<td style="padding:5px;text-align:center;border:1px solid #aaa;">
																<input style="text-align:center;border:none" id="his_os_belum_terplanning'.$po_ok->id.'" value="'.number_format($his_plan->os_belum_terplanning,0,',','.').'" readonly>
															</td>
															<td style="padding:5px;text-align:center;border:1px solid #aaa;">								
																<input style="text-align:center;border:none" id="his_qty_plan'.$po_ok->id.'" value="'.number_format($his_plan->qty_plan,0,',','.').'" readonly>
															</td>
															<td style="padding:5px;text-align:center;border:1px solid #aaa;text-align:center">
																<input class="form-control" type="date" id="his_eta'.$po_ok->id.'" value="'.$his_plan->eta.'" readonly>
															</td>
															<td style="padding:5px;text-align:center;border:1px solid #aaa;text-align:center">
																<button type="button" class="btn" '.$delH.'><i class="fas fa-trash"></i></button>
															</td>
														</tr>';
													}
												}else{
													$html .= '<tr>
														<td style="padding:5px;text-align:center;border:1px solid #aaa" colspan="5">
															DATA KOSONG !!
														</td>
													</tr>';
												}
											$html .= '</tbody>
										</table>
									</td>
								</tr>';
							}
						}
						$html .= '<tr>
							<td style="background:#ccc;padding:5px;border:1px solid #aaa" colspan="2"></td>
						</tr>';
					$html .= '</table>
				</div>
			</div>
		</div>';

		echo $html;
	}
	
	function Insert_dev_sys()
	{
		if($this->session->userdata('username'))
		{ 
			
			$os_belum_terplanning    = (int) str_replace('.', '', $this->input->post('os_belum_terplanning'));
			$qty_plan                = (int) str_replace('.', '', $this->input->post('qty_plan'));

			$os_terplanning          = $os_belum_terplanning - $qty_plan;

			// ================= VALIDASI =================
			
			if ($qty_plan > $os_belum_terplanning) 
			{
				echo json_encode([
					'status' => 0,
					'msg'    => 'QTY Plan Melebihi OS'
				]);
				return;
			}

			// produk
			$id_p = $_POST["id_produk"];
			$produk = $this->db->query("SELECT*FROM m_produk WHERE id_produk='$id_p'")->row();
			$berat = $qty_plan * $produk->berat_bersih;

			// ambil data POST
			$data = [
				'id_po_header'         => (int) str_replace('.', '', $this->input->post('po_ok_id')),
				'id_produk'            => (int) str_replace('.', '', $this->input->post('id_produk')),
				'id_pelanggan'         => (int) str_replace('.', '', $this->input->post('id_pelanggan')),
				'qty_po'               => (int) str_replace('.', '', $this->input->post('qty_po')),
				'delivery'             => (int) str_replace('.', '', $this->input->post('delivery')),
				'os'                   => (int) str_replace('.', '', $this->input->post('os')),
				'os_belum_terplanning' => $os_belum_terplanning,
				'qty_plan'             => $qty_plan,
				'bb'                   => $produk->berat_bersih,
				'berat'                => $berat,
				'urut'                 => 0,
				// 'os_terplanning'       => (int) str_replace('.', '', $this->input->post('os_terplanning')),
				'os_terplanning'       => $os_belum_terplanning - $qty_plan,
				'eta'                  => $this->input->post('eta'),
				'created_at'           => date('Y-m-d H:i:s')
			];

			// VALIDASI SERVER (WAJIB)
			foreach ($data as $key => $val) {
				if ($val === '' || $val === null) {
					echo json_encode([
						'status' => 0,
						'msg'    => 'DATA KOSONG'
					]);
					return;
				}
			}

			// simpan
			$insert = $this->m_transaksi->save_dev_sys($data);

			if ($insert) {
				echo json_encode([
					'status' => 1,
					'produk' => $produk,
					'id'     => $insert
				]);
			} else {
				echo json_encode(['status' => 0]);
			}
		}
		
	}


	function load_det_dat()
	{
		$id           = $this->input->post('id');
		$id_produk    = $this->input->post('id_produk');
		$id_pelanggan = $this->input->post('id_pelanggan');

		$queryh = "SELECT*FROM trs_po p JOIN trs_po_detail d on p.kode_po=d.kode_po JOIN m_produk i ON d.id_produk=i.id_produk WHERE p.status_app3='Y' and p.id_pelanggan='$id_pelanggan' and d.id_produk='$id_produk' and d.id='$id'
		-- GROUP BY p.kode_po ORDER BY p.tgl_po
		";
		
		$queryd   = "SELECT*FROM trs_po p JOIN trs_po_detail d on p.kode_po=d.kode_po JOIN m_produk i ON d.id_produk=i.id_produk WHERE p.status_app3='Y' and p.id_pelanggan='$id_pelanggan' and d.id_produk='$id_produk' and d.id='$id'
		-- GROUP BY p.kode_po ORDER BY p.tgl_po
		";

		$header   = $this->db->query($queryh)->row();
		$detail   = $this->db->query($queryd)->result();
		$data     = ["header" => $header, "detail" => $detail];

        echo json_encode($data);
	}
	

	public function Hitung_harga()
	{
		$cek 	= $this->session->userdata('username');

		if(($this->session->userdata('level')))
		{
			$data = [
				'menu'  => '<span style="color:red">SIMULASI HARGA *</span>',
				'judul' => "Simulasi Harga",
			];
			
			$this->load->view('header', $data);

			if(($this->session->userdata('username'))=='bujenik')
			{				
				$this->load->view('hitung_harga/v_hitung_harga_jumbo', $data);
			}else{				
				$this->load->view('hitung_harga/v_hitung_harga', $data);
			}
			
			$this->load->view('footer');

		} else {
			header('location:'.base_url());
		}

		
	}

	function loadCalender()
	{
		$id_sales = $this->session->userdata('id_sales');
		$html = '';
		$tgl = $_POST["tgl"];
		$tahun = $_POST["tahun"];
		$bulan = $_POST["bulan"];
		$awal1 = $tahun.'-'.$bulan.'-01';

		// cek tahun kabisat
		$isKabisat = ($tahun % 400 == 0) || ($tahun % 4 == 0 && $tahun % 100 != 0);
		switch ($bulan) {
			case '01': case '03': case '05': case '07': case '08': case '10': case '12':
				$hari = 31;
			break;
			case '04': case '06': case '09': case '11':
				$hari = 30;
			break;
			case '02':
				$hari = $isKabisat ? 29 : 28;
			break;
		}
		$akhir = $tahun.'-'.$bulan.'-'.$hari;

		$html .= '<div>
			<div style="background:#333;color:#fff;padding:8px 6px;border-radius:6px 6px 0 0;font-weight:bold">'.strtoupper(date('F', strtotime($awal1))).' '.$tahun.'</div>
			<div class="day-of-week" style="background:#7c858d;padding:15px 6px;font-weight:bold;border-bottom:3px solid #333">
				<div style="text-align:center">Min</div>
				<div style="text-align:center">Sen</div>
				<div style="text-align:center">Sel</div>
				<div style="text-align:center">Rab</div>
				<div style="text-align:center">Kam</div>
				<div style="text-align:center">Jum</div>
				<div style="text-align:center">Sab</div>
			</div>';

			// menentukan awal hari
			$hariAwal = date('l', strtotime($awal1));
			if($hariAwal == "Monday"){
				$aw = 1;
			}else if($hariAwal == "Tuesday"){
				$aw = 2;
			}else if($hariAwal == "Wednesday"){
				$aw = 3;
			}else if($hariAwal == "Thursday"){
				$aw = 4;
			}else if($hariAwal == "Friday"){
				$aw = 5;
			}else if($hariAwal == "Saturday"){
				$aw = 6;
			}else{ // Sunday
				$aw = 0;
			}
			// menentukan akhir hari
			$hariAkhir = date('l', strtotime($akhir));
			if($hariAkhir == "Monday"){
				$ak = 5;
			}else if($hariAkhir == "Tuesday"){
				$ak = 4;
			}else if($hariAkhir == "Wednesday"){
				$ak = 3;
			}else if($hariAkhir == "Thursday"){
				$ak = 2;
			}else if($hariAkhir == "Friday"){
				$ak = 1;
			}else if($hariAkhir == "Saturday"){
				$ak = 0;
			}else{ // Sunday
				$ak = 6;
			}

			$html .= '<div class="date-grid" style="border:1px solid #d9dadc;border-top:0">';
				// tambah kotak kosong awal
				if($aw != 0) {
					for($i = 0; $i < $aw; $i++){
						$html .= '<div style="position:relative;padding:15px 0;text-align:center;border:1px solid #d9dadc">-</div>';
					}
				}
				// isi
				for ($i2 = 1; $i2 <= $hari; $i2++) {
					($i2 < 10) ? $a = '0'.$i2 : $a = $i2;
					$tglSys = $tahun.'-'.$bulan.'-'.$a;
					// minggu
					$hariMinggu = date('l', strtotime($tglSys));
					($hariMinggu == "Sunday") ? $kk = '<span style="color:#f00">'.$i2.'</span>' : $kk = $i2;

					if($id_sales == null || $id_sales == ''){
						$count = $this->db->query("SELECT*FROM trs_dev_sys WHERE eta='$tglSys'");
						$berat = $this->db->query("SELECT SUM(berat) AS berat FROM trs_dev_sys WHERE eta='$tglSys' GROUP BY eta")->row()->berat;
					}else{
						$count = $this->db->query("SELECT s.* FROM trs_dev_sys s
						INNER JOIN m_pelanggan p ON s.id_pelanggan=p.id_pelanggan
						WHERE s.eta='$tglSys' AND p.id_sales='$id_sales'
						GROUP BY s.id_dev");
						$berat = $this->db->query("SELECT SUM(s.berat) AS berat FROM trs_dev_sys s
						INNER JOIN m_pelanggan p ON s.id_pelanggan=p.id_pelanggan
						WHERE s.eta='$tglSys' AND p.id_sales='$id_sales'
						GROUP BY s.eta")->row()->berat;
					}

					($count->num_rows() == 0) ? $sCount = '' : $sCount = '<span style="position:absolute;top:3px;right:3px;font-size:12px;font-style:italic;color:#fff;background:#333;padding:0 4px;border-radius:4px">'.$count->num_rows().'</span>';
					($count->num_rows() == 0) ? $sBb = '' : $sBb = '<span style="position:absolute;bottom:3px;left:3px;font-size:12px;font-style:italic;color:#fff;background:#7c858d;padding:0 4px;border-radius:4px">'.number_format($berat, 0, ',', '.').'</span>';
					($count->num_rows() == 0) ? $link = '' : $link = '<a href="javascript:void(0)" class="ds-link" onclick="ccDevSys('."'".$a."'".')"></a>';
					($count->num_rows() == 0) ? $fb = '' : $fb = ';font-weight:bold';
					($tgl == $a) ? $bb = ';background:#d9dadc' : $bb = '';
					$html .= '<div style="position:relative;padding:15px 0;font-size:20px;text-align:center;border:1px solid #d9dadc'.$fb.$bb.'">
						'.$sCount.$sBb.'
						'.$kk.'
						'.$link.'
					</div>';
				}
				// tambah kotak kosong akhir
				if($ak != 0) {
					for($i3 = 0; $i3 < $ak; $i3++){
						$html .= '<div style="position:relative;padding:15px 0;text-align:center;border:1px solid #d9dadc">-</div>';
					}
				}
			$html .= '</div>';
		$html .= '</div>';

		echo json_encode([
			'html' => $html,
		]);
	}

	function ccDevSys()
	{
		$id_sales = $this->session->userdata('id_sales');
		$html = '';
		$tahun = $_POST["tahun"];
		$bulan = $_POST["bulan"];
		$angka = $_POST["tgl"];
		$tgl = $tahun.'-'.$bulan.'-'.$angka;

		$html .= '<table>
			<tr style="background:#dee2e6">
				<th style="padding:6px;border:1px solid #bbb;text-align:center">#</th>
				<th style="padding:6px;border:1px solid #bbb">CUSTOMER</th>
				<th style="padding:6px;border:1px solid #bbb">NO. PO</th>
				<th style="padding:6px;border:1px solid #bbb">ITEM</th>
				<th style="padding:6px 12px;text-align:center;border:1px solid #bbb">QTY</th>
				<th style="padding:6px;text-align:center;border:1px solid #bbb">BB</th>
				<th style="padding:6px;text-align:center;border:1px solid #bbb">TONASE</th>
			</tr>';

			if($id_sales == null || $id_sales == ''){
				$urut = $this->db->query("SELECT*FROM trs_dev_sys WHERE eta='$tgl' GROUP BY eta, urut, id_ex");
				$wSls = "";
			}else{
				$urut = $this->db->query("SELECT s.* FROM trs_dev_sys s
				INNER JOIN m_pelanggan p ON s.id_pelanggan=p.id_pelanggan
				WHERE s.eta='$tgl' AND p.id_sales='$id_sales'
				GROUP BY s.eta, s.urut, s.id_ex");
				$wSls = "AND c.id_sales='$id_sales'";
			}
			foreach($urut->result() as $u){
				if($u->urut == 0){
					$html .= '<tr>
						<td style="background:#333;color:#fff;padding:6px;font-weight:bold;text-align:center">'.$u->urut.'</td>
						<td style="background:#333;padding:6px" colspan="6"></td>
					</tr>';
				}else{
					$html .= '<tr>
						<td style="background:#333;color:#fff;padding:6px;font-weight:bold;text-align:center">'.$u->urut.'.</td>
						<td style="background:#333;padding:6px">';
							if($u->id_ex == null){
								$html .= '<select class="form-control select2" id="eks_ds'.$u->urut.'" onchange="plhEksDS('."'".$u->urut."'".')">
									<option value="">PILIH</option>';
									$ekspedisi = $this->db->query("SELECT*FROM m_ekspedisi ORDER BY plat, ekspedisi");
									foreach($ekspedisi->result() as $r){
										($r->panjang == null || $r->lebar == null || $r->tinggi == null || $r->panjang == '' || $r->lebar == '' || $r->tinggi == '') ?
											$pLt = '' : $pLt = ' | '.round($r->panjang, 2).' x '.round($r->lebar, 2).' x '.round($r->tinggi, 2);
										$html .= '<option value="'.$r->id_ex.'">'.$r->plat.' ( '.$r->ekspedisi.' )'.$pLt.'</option>';
									}
								$html .= '</select>';
							}else{
								$e = $this->db->query("SELECT*FROM m_ekspedisi WHERE id_ex='$u->id_ex'")->row();
								($e->panjang == null || $e->lebar == null || $e->tinggi == null || $e->panjang == '' || $e->lebar == '' || $e->tinggi == '') ?
									$pLt = '' : $pLt = ' | '.round($e->panjang, 2).' x '.round($e->lebar, 2).' x '.round($e->tinggi, 2);
								// btl
								$hapus = ' - <button class="btn btn-xs btn-danger" onclick="batalEksDS('."'".$u->urut."'".')"><i class="fas fa-times-circle"></i></button>';
								$html .= '<div style="font-weight:bold;color:#fff">'.$e->plat.' ( '.$e->ekspedisi.' )'.$pLt.$hapus.'</div>';
							}
						$html .= '</td>
						<td style="background:#333;padding:6px" colspan="5"></td>
					</tr>';
				}

				$sys = $this->db->query("SELECT c.nm_pelanggan,c.attn,p.kode_po,i.*,d.* FROM trs_dev_sys d
				INNER JOIN m_pelanggan c ON d.id_pelanggan=c.id_pelanggan
				INNER JOIN trs_po_detail p ON d.id_po_header=p.id
				INNER JOIN m_produk i ON d.id_produk=i.id_produk
				WHERE d.eta='$u->eta' AND d.urut='$u->urut' $wSls
				GROUP BY d.id_pelanggan,p.kode_po,d.id_produk
				ORDER BY c.nm_pelanggan,p.kode_po,i.nm_produk");
				$i = 0;
				$totBerat = 0;
				foreach($sys->result() as $r){
					$i++;
					($r->attn == '-') ? $attn = '' : $attn = ' - '.$r->attn;
					($r->kategori == "K_BOX") ? $kategori = '[BOX] ' : $kategori = '[SHEET] ';
					(in_array($this->session->userdata('level'), ['Admin', 'Admin2', 'User']) && $r->id_ex == null) ? $och = 'id="ds-urut'.$r->id_dev.'" onchange="dsUrut('."'".$r->id_dev."'".')"' : $och = 'disabled';
					$html .= '<tr>
						<td style="border:1px solid #dee2e6;padding:6px;text-align:center">
							<input type="number" class="form-control" style="height:100%;width:30px;text-align:center;padding:4px" value="'.$r->urut.'" '.$och.'>
						</td>
						<td style="border:1px solid #dee2e6;padding:6px">'.$r->nm_pelanggan.$attn.'</td>
						<td style="border:1px solid #dee2e6;padding:6px">'.$r->kode_po.'</td>
						<td style="border:1px solid #dee2e6;padding:6px">'.$kategori.$r->nm_produk.'</td>
						<td style="border:1px solid #dee2e6;padding:6px;text-align:right">'.number_format($r->qty_plan, 0, ',', '.').'</td>
						<td style="border:1px solid #dee2e6;padding:6px;text-align:center">'.$r->berat_bersih.'</td>
						<td style="border:1px solid #dee2e6;padding:6px;text-align:right">'.number_format($r->berat, 0, ',', '.').'</td>
					</tr>';
					$totBerat += $r->berat;
				}

				// TOTAL
				if($sys->num_rows() != 1){
					$html .= '<tr style="background:#dee2e6">
						<td style="padding:6px;border:1px solid #bbb;font-weight:bold;text-align:right" colspan="6">TOTAL</td>
						<td style="padding:6px;border:1px solid #bbb;font-weight:bold;text-align:right">'.number_format($totBerat, 0, ',', '.').'</td>
					</tr>';
				}
			}

		$html .= '</table>';

		echo json_encode([
			'html' => $html,
		]);
	}

}
