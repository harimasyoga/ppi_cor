<?php
defined('BASEPATH') or exit('No direct script access allowed');

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
				$hapus = '<button type="button" onclick="hapusHPP('."'".$r->id_hpp."'".')" class="btn btn-danger btn-sm" style="color:#000"><i class="fas fa-trash-alt"></i></button>';
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
		if(in_array($this->session->userdata('level'), ['Admin','konsul_keu', 'Laminasi', 'Marketing Laminasi', 'Owner'])){
			$this->load->view('Transaksi/v_po_laminasi');
		}else{
			$this->load->view('home');
		}
		$this->load->view('footer');
	}

	function destroyLaminasi()
	{
		$this->cart->destroy();
		echo "LIST KOSONG!";
	}

	function addItemLaminasi()
	{
		if(
			$_POST["tgl"] == "" ||
			$_POST["customer"] == "" ||
			$_POST["id_sales"] == "" ||
			$_POST["attn"] == "" ||
			$_POST["no_po"] == "" ||
			$_POST["item"] == "" ||
			$_POST["ukuran_lm"] == "" ||
			$_POST["isi_lm"] == "" ||
			$_POST["jenis_qty_lm"] == "" ||
			$_POST["qty"] == "" ||
			$_POST["order_sheet"] == "" ||
			$_POST["order_pori"] == "" ||
			$_POST["qty_bal"] == "" ||
			$_POST["harga_lembar"] == "" ||
			$_POST["harga_pori"] == "" ||
			$_POST["harga_total"] == "" 
		){
			echo json_encode(array('data' => false, 'isi' => 'HARAP LENGKAPI FORM!'));
		}else{
			$no_po = str_replace(' ', '',$_POST["no_po"]);
			$cek = $this->db->query("SELECT*FROM trs_po_lm WHERE no_po_lm='$no_po'");
			if($cek->num_rows() == 0){
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
						'item' => $_POST["item"],
						'nm_produk_lm' => $_POST["nm_produk_lm"],
						'ukuran_lm' => $_POST["ukuran_lm"],
						'isi_lm' => $_POST["isi_lm"],
						'jenis_qty_lm' => $_POST["jenis_qty_lm"],
						'qty' => $_POST["qty"],
						'order_sheet' => $_POST["order_sheet"],
						'order_pori' => $_POST["order_pori"],
						'qty_bal' => $_POST["qty_bal"],
						'harga_lembar' => $_POST["harga_lembar"],
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
					echo json_encode(array('data' => true, 'isi' => $data));
				}else{
					if($_POST["id_po_header"] == ''){
						$this->cart->insert($data);
						echo json_encode(array('data' => true, 'isi' => $data));
					}else{
						foreach($po_dtl->result() as $r){
							if($r->id_m_produk_lm == $_POST["item"]){
								echo json_encode(array('data' => false, 'isi' => 'ITEM SUDAH ADA!'));
								return;
							}
						}
						$this->cart->insert($data);
						echo json_encode(array('data' => true, 'isi' => $data));
					}
				}
			}else{
				echo json_encode(array('data' => false, 'isi' => 'NO. PO SUDAH TERPAKAI!'));
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
					<th style="padding:6px">SIZE</th>
					<th style="padding:6px;text-align:center">@PACK</th>
					<th style="padding:6px;text-align:center">@BAL</th>
					<th style="padding:6px;text-align:center">ORDER SHEET</th>
					<th style="padding:6px;text-align:center">ORDER</th>
					<th style="padding:6px;text-align:center">QTY(BAL)</th>
					<th style="padding:6px;text-align:center">HARGA LEMBAR</th>
					<th style="padding:6px;text-align:center">HARGA</th>
					<th style="padding:6px;text-align:center">HARGA TOTAL</th>
					<th style="padding:6px;text-align:center">AKSI</th>
				</tr>
			</thead>';
		}

		$i = 0;
		foreach($this->cart->contents() as $r){
			$i++;
			if($r['options']['jenis_qty_lm'] == 'pack'){
				$ket = '( PACK )';
				$qty = number_format($r['options']['qty'],0,",",".");
			}else if($r['options']['jenis_qty_lm'] == 'ikat'){
				$ket = '( IKAT )';
				$qty = number_format($r['options']['qty'],0,",",".");
			}else{
				$ket = '( KG )';
				$qty = $r['options']['qty'];
			}
			($r['options']['jenis_qty_lm'] == 'kg') ? $order_pori = $r['options']['order_pori'] : $order_pori = number_format($r['options']['order_pori'],0,",",".");
			($r['options']['jenis_qty_lm'] == 'kg') ? $qty_bal = $r['options']['qty_bal'] : $qty_bal = number_format($r['options']['qty_bal'],0,",",".");
			$html .='<tr>
				<td style="padding:6px;text-align:center">'.$i.'</td>
				<td style="padding:6px">'.$r['options']['nm_produk_lm'].'</td>
				<td style="padding:6px">'.$r['options']['ukuran_lm'].'</td>
				<td style="padding:6px;text-align:right">'.number_format($r['options']['isi_lm'],0,",",".").' ( SHEET )</td>
				<td style="padding:6px;text-align:right">'.$qty.' '.$ket.'</td>
				<td style="padding:6px;text-align:right">'.number_format($r['options']['order_sheet'],0,",",".").'</td>
				<td style="padding:6px;text-align:right">'.$order_pori.' '.$ket.'</td>
				<td style="padding:6px;text-align:right">'.$qty_bal.'</td>
				<td style="padding:6px;text-align:right">'.round($r['options']['harga_lembar'],2).'</td>
				<td style="padding:6px;text-align:right">'.number_format($r['options']['harga_pori'],0,",",".").' '.$ket.'</td>
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

	function editPOLaminasi()
	{ //
		$id = $_POST["id"];
		$id_dtl = $_POST["id_dtl"];
		$opsi = $_POST["opsi"];

		$po_lm = $this->db->query("SELECT*FROM trs_po_lm WHERE id='$id'")->row();
		$po_dtl = $this->db->query("SELECT*FROM trs_po_lm_detail d INNER JOIN m_produk_lm p ON d.id_m_produk_lm=p.id_produk_lm WHERE d.no_po_lm='$po_lm->no_po_lm'");
		($id != 0 && $id_dtl != 0 ) ? $e_po_dtl = $this->db->query("SELECT*FROM trs_po_lm_detail d INNER JOIN m_produk_lm p ON d.id_m_produk_lm=p.id_produk_lm WHERE d.id='$id_dtl'")->row() : $e_po_dtl = '';

		$html ='';
		$html .='<table class="table table-bordered table-striped" style="margin:0">
			<thead>
				<tr>
					<th style="padding:6px;text-align:center">NO.</th>
					<th style="padding:6px" colspan="6">DESKRIPSI</th>
					<th style="padding:6px;text-align:center">QTY(BAL)</th>
					<th style="padding:6px;text-align:center">H. LEMBAR</th>
					<th style="padding:6px;text-align:center">HARGA</th>
					<th style="padding:6px;text-align:center">HARGA TOTAL</th>
					<th style="padding:6px;text-align:center">AKSI</th>
				</tr>
			</thead>';
			$i = 0;
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
					$ket = '( PACK )';
					$qty = number_format($r->pack_lm,0,',','.');
				}else if($r->jenis_qty_lm == 'ikat'){
					$ket = '( IKAT )';
					$qty = number_format($r->ikat_lm,0,',','.');
				}else{
					$ket = '( KG )';
					$qty = $r->kg_lm;
				}
				($r->jenis_qty_lm == 'kg') ? $order_pori_lm = $r->order_pori_lm : $order_pori_lm = number_format($r->order_pori_lm,0,",",".");
				($r->jenis_qty_lm == 'kg') ? $qty_bal = $r->qty_bal : $qty_bal = number_format($r->qty_bal,0,",",".");

				$ton = $r->qty_bal * 50;
				$bb = round($ton / 0.75);
				$html .='<tr>
					<td style="padding:6px;text-align:center'.$bold.'">'.$i.'</td>
					<td style="padding:0;border:0'.$bold.'">
						<table class="table" style="margin:0">
							<tr>
								<td style="border:0;padding:6px;font-weight:bold">ITEM</td>
							</tr>
							<tr>
								<td style="border:0;padding:6px;font-weight:bold">SIZE</td>
							</tr>
							<tr>
								<td style="border:0;padding:6px;font-weight:bold">@PACK</td>
							</tr>
							<tr>
								<td style="border:0;padding:6px;font-weight:bold">@BAL</td>
							</tr>
						</table>
					</td>
					<td style="padding:0;border:0'.$bold.'">
						<table class="table" style="margin:0">
							<tr>
								<td style="border:0;padding:6px 3px;font-weight:bold">:</td>
							</tr>
							<tr>
								<td style="border:0;padding:6px 3px;font-weight:bold">:</td>
							</tr>
							<tr>
								<td style="border:0;padding:6px 3px;font-weight:bold">:</td>
							</tr>
							<tr>
								<td style="border:0;padding:6px 3px;font-weight:bold">:</td>
							</tr>
						</table>
					</td>
					<td style="padding:0;border:0'.$bold.'">
						<table class="table" style="margin:0">
							<tr>
								<td style="border:0;padding:6px">'.$r->nm_produk_lm.'</td>
							</tr>
							<tr>
								<td style="border:0;padding:6px">'.$r->ukuran_lm.'</td>
							</tr>
							<tr>
								<td style="border:0;padding:6px">'.number_format($r->isi_lm,0,",",".").' ( SHEET )</td>
							</tr>
							<tr>
								<td style="border:0;padding:6px">'.$qty.' '.$ket.'</td>
							</tr>
						</table>
					</td>
					<td style="padding:0;border:0'.$bold.'">
						<table class="table" style="margin:0">
							<tr>
								<td style="border:0;padding:6px;font-weight:bold">ORDER SHEET</td>
							</tr>
							<tr>
								<td style="border:0;padding:6px;font-weight:bold">ORDER</td>
							</tr>
							<tr>
								<td style="border:0;padding:6px;font-weight:bold">TON</td>
							</tr>
							<tr>
								<td style="border:0;padding:6px;font-weight:bold">BAHAN BAKU</td>
							</tr>
						</table>
					</td>
					<td style="padding:0;border:0'.$bold.'">
						<table class="table" style="margin:0">
							<tr>
								<td style="border:0;padding:6px 3px;font-weight:bold">:</td>
							</tr>
							<tr>
								<td style="border:0;padding:6px 3px;font-weight:bold">:</td>
							</tr>
							<tr>
								<td style="border:0;padding:6px 3px;font-weight:bold">:</td>
							</tr>
							<tr>
								<td style="border:0;padding:6px 3px;font-weight:bold">:</td>
							</tr>
						</table>
					</td>
					<td style="padding:0;border:0'.$bold.'">
						<table class="table" style="margin:0">
							<tr>
								<td style="border:0;padding:6px">'.number_format($r->order_sheet_lm,0,",",".").'</td>
							</tr>
							<tr>
								<td style="border:0;padding:6px">'.$order_pori_lm.' '.$ket.'</td>
							</tr>
							<tr>
								<td style="border:0;padding:6px">'.number_format($ton,0,",",".").'</td>
							</tr>
							<tr>
								<td style="border:0;padding:6px">'.number_format($bb,0,",",".").'</td>
							</tr>
						</table>
					</td>
					<td style="padding:6px;text-align:center'.$bold.'">'.$qty_bal.'</td>
					<td style="padding:6px;text-align:center'.$bold.'">'.round($r->harga_lembar_lm,2).'</td>
					<td style="padding:6px;text-align:right'.$bold.'">'.number_format($r->harga_pori_lm,0,",",".").'  '.$ket.'</td>
					<td style="padding:6px;text-align:right'.$bold.'">'.number_format($r->harga_total_lm,0,",",".").'</td>
					<td style="padding:6px;text-align:center'.$bold.'">'.$btnAksi.'</td>
				</tr>';
				// KOSONG
				if($po_dtl->num_rows() != $i){
					$html .='<tr>
						<td colspan="12" style="padding:3px"></td>
					</tr>';
				}
			}
		$html .= '</table>';

		echo json_encode([
			'po_lm' => $po_lm,
			'add_time_po_lm' => substr($this->m_fungsi->getHariIni(($po_lm->edit_time == null) ? $po_lm->add_time : $po_lm->edit_time),0,3).', '.$this->m_fungsi->tglIndSkt(substr(($po_lm->edit_time == null) ? $po_lm->add_time : $po_lm->edit_time, 0,10)).' ( '.substr(($po_lm->edit_time == null) ? $po_lm->add_time : $po_lm->edit_time, 10,6).' )',
			'time_lm1' => ($po_lm->time_lm1 == null) ? '' :substr($this->m_fungsi->getHariIni($po_lm->time_lm1),0,3).', '.$this->m_fungsi->tglIndSkt(substr($po_lm->time_lm1, 0,10)).' ( '.substr($po_lm->time_lm1, 10,6).' )',
			'time_lm2' => ($po_lm->time_lm2 == null) ? '' :substr($this->m_fungsi->getHariIni($po_lm->time_lm2),0,3).', '.$this->m_fungsi->tglIndSkt(substr($po_lm->time_lm2, 0,10)).' ( '.substr($po_lm->time_lm2, 10,6).' )',
			'po_dtl' => $e_po_dtl,
			'html_dtl' => $html,
		]);
	}

	function editListPOLaminasi()
	{
		$id = $_POST["id"];
		$data = $this->db->query("SELECT*FROM trs_po_lm_detail WHERE id='$id'")->row();
		echo json_encode($data);
	}

	function hitung_rekap()
	{
		
		$bulan = $this->input->post('bulan');

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
		WHERE a.status <> 'Reject' and d.status_app3 not in ('H')
		$ket 
		)p group by id_sales,nm_sales")->result();

		$html .='<div class="card-body row" style="padding-bottom:20px;font-weight:bold">';
		$html .='<table class="table table-bordered table-striped">
		<thead>
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
		foreach($query as $r){
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
		
		$html .='</table>
		</div>';
		}

		echo $html;
		
	}
    
    function load_so()
    {

        $query = $this->db->query("SELECT * 
		FROM trs_so_detail a
		JOIN m_produk b ON a.id_produk=b.id_produk
		JOIN m_pelanggan c ON a.id_pelanggan=c.id_pelanggan
		WHERE status='Open' ")->result();

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

	function load_data()
	{
		$jenis        = $this->uri->segment(3);
		$data         = array();

		if ($jenis == "po") {

			$level   = $this->session->userdata('level');
			$nm_user = $this->session->userdata('nm_user');

			if($level =='Hub')
			{
				$cek     = $this->db->query("SELECT*FROM m_hub where nm_hub='$nm_user' ")->row();
				$cek_data = "WHERE status_app3 in ('Y') and id_hub in ('$cek->id_hub')";
			}else{

				if($this->session->userdata('username')=='ppismg'){
					$cek_data = 'WHERE id_sales in ("2","3")';
				}else{
					$cek_data = '';
				}
			}			

			$query = $this->m_master->query("SELECT a.*,b.*,a.add_time as time_input FROM trs_po a join m_pelanggan b on a.id_pelanggan=b.id_pelanggan $cek_data order by a.tgl_po desc, id desc")->result();
			$i = 1;
			foreach ($query as $r) {
				$row        = array();
				$time       = substr($r->tgl_po, 0,10);
				$time_po    = substr($r->time_input, 10,6);

				$result_po  = $this->db->query("SELECT nm_produk from trs_po_detail a join m_produk b ON a.id_produk=b.id_produk where no_po='$r->no_po'
				GROUP BY a.id_produk ORDER BY a.id_produk");

				if($result_po->num_rows() == '1'){
					$nm_item = $result_po->row()->nm_produk;
				}else{
					$no                = 1;
					$nm_item_result    = '';
					foreach($result_po->result() as $row_po){
						$nm_item_result .= '<b>'.$no.'.</b> '.$row_po->nm_produk.'<br>';
						$no ++;
					}
					$nm_item = $nm_item_result;

				}

				if($r->status_karet=='REPEAT')
				{
					$status_karet    = '<b>REPEAT</b>';
					$btn_sk          = 'btn-warning';
					
				}else if($r->status_karet=='REVISI'){
					$status_karet    = '<b>REVISI DESAIN</b>';
					$btn_sk          = 'btn-success';

				}else{
					$status_karet    = '<b>NEW ORDER</b>';
					$btn_sk          = 'btn-info';

				}

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
						$i1         = '<i id="iBtn1-'.$r->id.'" class="fas fa-lock"></i>';
						$alasan1    = '';
						$ketAlasan1 .= '<div id="countdown1-'.$r->id.'" style="color:#f00;font-weight:bold" onclick="countDownPO('."'".$r->id."'".')">'.$waktu.'</div>';
					}
				}else  if($r->status_app1=='H'){
					$btn1    = 'btn-danger';
					$i1      = '<i class="far fa-hand-paper"></i>';
					$alasan1 = $r->ket_acc1;
					($actualDate > $expired || $actualDate == $expired) ? $ketAlasan1 .= '<br><div style="color:#f00;font-weight:bold">EXPIRED</div>' : $ketAlasan1 .= '<br><div id="countdown1-'.$r->id.'" style="color:#f00;font-weight:bold" onclick="countDownPO('."'".$r->id."'".')">'.$waktu.'</div>';
				}else  if($r->status_app1=='R'){
					$btn1    = 'btn-danger';
					$i1      = '<i class="fas fa-times"></i>';
					$alasan1 = $r->ket_acc1;
					($actualDate > $expired || $actualDate == $expired) ? $ketAlasan1 .= '<br><div style="color:#f00;font-weight:bold">EXPIRED</div>' : $ketAlasan1 .= '<br><div id="countdown1-'.$r->id.'" style="color:#f00;font-weight:bold" onclick="countDownPO('."'".$r->id."'".')">'.$waktu.'</div>';
				}else{
					$btn1    = 'btn-success';
					$i1      = '<i class="fas fa-check-circle"></i>';
					$alasan1 = '';
				}
                
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
						$i2         = '<i id="iBtn2-'.$r->id.'" class="fas fa-lock"></i>';
						$alasan2    = '';
						$ketAlasan2 .= '<div id="countdown2-'.$r->id.'" style="color:#f00;font-weight:bold" onclick="countDownPO('."'".$r->id."'".')">'.$waktu.'</div>';
					}
                }else if($r->status_app2=='H'){
                    $btn2   = 'btn-danger';
                    $i2     = '<i class="far fa-hand-paper"></i>';
					$alasan2 = $r->ket_acc2;
					($actualDate > $expired || $actualDate == $expired) ? $ketAlasan2 .= '<br><div style="color:#f00;font-weight:bold">EXPIRED</div>' : $ketAlasan2 .= '<br><div id="countdown2-'.$r->id.'" style="color:#f00;font-weight:bold" onclick="countDownPO('."'".$r->id."'".')">'.$waktu.'</div>';
                }else if($r->status_app2=='R'){
                    $btn2   = 'btn-danger';
                    $i2     = '<i class="fas fa-times"></i>';
					$alasan2 = $r->ket_acc2;
					($actualDate > $expired || $actualDate == $expired) ? $ketAlasan2 .= '<br><div style="color:#f00;font-weight:bold">EXPIRED</div>' : $ketAlasan2 .= '<br><div id="countdown2-'.$r->id.'" style="color:#f00;font-weight:bold" onclick="countDownPO('."'".$r->id."'".')">'.$waktu.'</div>';
                }else{
                    $btn2   = 'btn-success';
                    $i2     = '<i class="fas fa-check-circle"></i>';
					$alasan2 = '';
                }
                
                if($r->status_app3=='N')
                {
                    $btn3   = 'btn-warning';
                    $i3     = '<i class="fas fa-lock"></i>';
					$alasan3 = '';
                }else  if($r->status_app3=='H')
                {
                    $btn3   = 'btn-danger';
                    $i3     = '<i class="far fa-hand-paper"></i>';
					$alasan3 = $r->ket_acc3;
                }else  if($r->status_app3=='R')
                {
                    $btn3   = 'btn-danger';
                    $i3     = '<i class="fas fa-times"></i>';
					$alasan3 = $r->ket_acc3;
                }else{
                    $btn3   = 'btn-success';
                    $i3     = '<i class="fas fa-check-circle"></i>';
					$alasan3 = '';
                }
                
                if($r->status == 'Open')
                {
                    $btn_s   = 'btn-info';
                }else if($r->status == 'Approve')
                {
                    $btn_s   = 'btn-success';
                }else{
                    $btn_s   = 'btn-danger';
                }

				$row[] = '<div class="text-center">'.$i.'</div>';
				$row[] = '<div class="text-center"><a href="javascript:void(0)" onclick="tampil_edit(' . "'" . $r->id . "'" . ',' . "'detail'" . ')">' . $r->no_po . "<a></div>";

				$row[] = '<div class="text-center">'.$this->m_fungsi->tanggal_ind($time).' <br> ('.$time_po.' )</div>';
				
				$row[] = '<div class="text-center">'.$nm_item.'</div>';

                $time1 = ( ($r->time_app1 == null) ? 'BELUM ACC' : $this->m_fungsi->tanggal_format_indonesia(substr($r->time_app1,0,10))  . ' - ' .substr($r->time_app1,10,9)) ;

                $time2 = ( ($r->time_app2 == null) ? 'BELUM ACC' : $this->m_fungsi->tanggal_format_indonesia(substr($r->time_app2,0,10))  . ' - ' .substr($r->time_app2,10,9));

                $time3 = ( ($r->time_app3 == null) ? 'BELUM ACC' : $this->m_fungsi->tanggal_format_indonesia(substr($r->time_app3,0,10))  . ' - ' .substr($r->time_app3,10,9));

				$row[] = '<div class="text-center"><button type="button" class="btn btn-sm '.$btn_s.' ">'.$r->status.'</button></div>';
				$row[] = '<div class="text-center"><button type="button" class="btn btn-sm '.$btn_sk.' ">'.$status_karet.'</button></div>';

				$row[] = '<div class="text-center">'.$r->kode_po.'</div>';
				// $row[] = $r->total_qty;
				$row[] = '<div class="text-center">'.$r->nm_pelanggan.'</div>';
                
				$row[] = '<div class="text-center">
					<input type="hidden" id="statusMarketing-'.$r->id.'" value="'.$r->status_app1.'">
					<input type="hidden" id="statusPPIC-'.$r->id.'" value="'.$r->status_app2.'">
					<input type="hidden" id="tanggalExpired-'.$r->id.'" value="'.$expiredDisplay.'">
					<button type="button" title="OKE" style="text-align: center;" class="btn btn-sm btn-success "><i class="fas fa-check-circle"></i></button><br><b>
					'.$this->m_fungsi->tanggal_ind($time).' <br> ('.$time_po.' )</b></div>
				';
				$row[] = '<div class="text-center">
					<button onclick="data_sementara(`Marketing`,' . "'" . $r->status_app1 . "'" . ',' . "'" . $time1 . "'" . ',' . "'" . $alasan1 . "'" . ',' . "'" . $r->no_po . "'" . ','."'".$exp1."'".')" type="button" title="'.$time1.'" style="text-align: center;" class="btn btn-sm '.$btn1.'" id="btnBase1-'.$r->id.'">'.$i1.'</button><br>
					'.$alasan1.''.$ketAlasan1.'</div>
				';
				
                $row[] = '<div class="text-center">
					<button onclick="data_sementara(`PPIC`,' . "'" . $r->status_app2 . "'" . ',' . "'" . $time2 . "'" . ',' . "'" . $alasan2 . "'" . ',' . "'" . $r->no_po . "'" . ','."'".$exp2."'".')" type="button" title="'.$time2.'"  style="text-align: center;" class="btn btn-sm '.$btn2.'" id="btnBase2-'.$r->id.'">'.$i2.'</button><br>
					'.$alasan2.''.$ketAlasan2.'</div>
				';
                $row[] = '<div class="text-center">
					<button onclick="data_sementara(`Owner`,' . "'" . $r->status_app3 . "'" . ',' . "'" . $time3 . "'" . ',' . "'" . $alasan3 . "'" . ',' . "'" . $r->no_po . "'" . ',0)"  type="button" title="'.$time3.'"  style="text-align: center;" class="btn btn-sm '.$btn3.' ">'.$i3.'</button><br>
					'.$alasan3.'</div>
				';

				// $aksi = '-';
                $aksi = '';

				if (!in_array($this->session->userdata('level'), ['Admin','konsul_keu','Marketing','PPIC','Owner','AP']))
                {

					if ($r->status == 'Open' && $r->status_app1 == 'N') {
						if (in_array($this->session->userdata('level'), ['Keuangan1'])) { 

							$aksi .= ' 
							<a target="_blank" class="btn btn-sm btn-danger" href="' . base_url("Transaksi/Cetak_PO?no_po=" . $r->no_po . "") . '" title="Cetak" ><i class="fas fa-print"></i> </a>

							<a target="_blank" class="btn btn-sm btn-success" href="' . base_url("Transaksi/Cetak_wa_po?no_po=" . $r->no_po . "") . '" title="Format WA" ><b><i class="fab fa-whatsapp"></i> </b></a>

							<a target="_blank" class="btn btn-sm btn-primary" href="' . base_url("Transaksi/Cetak_img_po?no_po=" . $r->no_po . "") . '" title="CETAK PO" ><b><i class="fas fa-images"></i> </b></a>

							';
						} else {

							$aksi .= ' 
								<button type="button" onclick="tampil_edit(' . "'" . $r->id . "'" . ',' . "'edit'" . ')" title="EDIT" class="btn btn-info btn-sm">
									<i class="fa fa-edit"></i>
								</button>
								
								<button type="button" title="DELETE"  onclick="deleteData(' . "'" . $r->id . "'" . ',' . "'" . $r->no_po . "'" . ')" class="btn btn-danger btn-sm">
									<i class="fa fa-trash-alt"></i>
								</button>  

								<a target="_blank" class="btn btn-sm btn-danger" href="' . base_url("Transaksi/Cetak_PO?no_po=" . $r->no_po . "") . '" title="Cetak" ><i class="fas fa-print"></i> </a>

								<a target="_blank" class="btn btn-sm btn-success" href="' . base_url("Transaksi/Cetak_wa_po?no_po=" . $r->no_po . "") . '" title="Format WA" ><b><i class="fab fa-whatsapp"></i> </b></a> 
								
								<a target="_blank" class="btn btn-sm btn-primary" href="' . base_url("Transaksi/Cetak_img_po?no_po=" . $r->no_po . "") . '" title="CETAK PO" ><b><i class="fas fa-images"></i> </b></a>
							';
						}
						
					}else if (in_array($this->session->userdata('level'), ['Hub','AP'])) {
						$aksi .= '';
					}else {

						$aksi .= ' 
							<a target="_blank" class="btn btn-sm btn-danger" href="' . base_url("Transaksi/Cetak_PO?no_po=" . $r->no_po . "") . '" title="Cetak" ><i class="fas fa-print"></i> </a>

							<a target="_blank" class="btn btn-sm btn-success" href="' . base_url("Transaksi/Cetak_wa_po?no_po=" . $r->no_po . "") . '" title="Format WA" ><b><i class="fab fa-whatsapp"></i> </b></a> 
							
							<a target="_blank" class="btn btn-sm btn-primary" href="' . base_url("Transaksi/Cetak_img_po?no_po=" . $r->no_po . "") . '" title="CETAK PO" ><b><i class="fas fa-images"></i> </b></a>';

					}
					
				}else{
					if ($this->session->userdata('level') == 'Marketing' ) {

						if($r->status_app1 == 'N' || $r->status_app1 == 'H' || $r->status_app1 == 'R')
						{
							$aksi .=  ' 
									<button title="VERIFIKASI DATA" type="button" onclick="tampil_edit(' . "'" . $r->id . "'" . ',' . "'detail'" . ')" class="btn btn-info btn-sm">
										<i class="fa fa-check"></i>
									</button>  ';
						}
					}

					if ($this->session->userdata('level') == 'PPIC' && $r->status_app1 == 'Y' ) {

						if($r->status_app2 == 'N' || $r->status_app2 == 'H' || $r->status_app2 == 'R'){

							$aksi .=  ' 
									<button title="VERIFIKASI DATA" type="button" onclick="tampil_edit(' . "'" . $r->id . "'" . ',' . "'detail'" . ')" class="btn btn-info btn-sm">
										<i class="fa fa-check"></i>
									</button> ';
						}
					}

					if ($this->session->userdata('level') == 'Owner' && $r->status_app1 == 'Y' && $r->status_app2 == 'Y' ) {
						if($r->status_app3 == 'N' || $r->status_app3 == 'H' || $r->status_app3 == 'R'){

							$aksi .=  ' 
									<button title="VERIFIKASI DATA" type="button" onclick="tampil_edit(' . "'" . $r->id . "'" . ',' . "'detail'" . ')" class="btn btn-info btn-sm">
										<i class="fa fa-check"></i>
									</button>  ';
						}
					}

                    if ($this->session->userdata('level') == 'Admin' ) 
					{

						if($r->status_app1 == 'N' || $r->status_app2 == 'N' || $r->status_app3 == 'N' || $r->status_app1 == 'H' || $r->status_app2 == 'H' || $r->status_app3 == 'H' || $r->status_app1 == 'R' || $r->status_app2 == 'R' || $r->status_app3 == 'R'){
							$aksi .=  '
								<button type="button" onclick="tampil_edit(' . "'" . $r->id . "'" . ',' . "'edit'" . ')" title="EDIT" class="btn btn-info btn-sm">
									<i class="fa fa-edit"></i>
								</button>

								<button type="button" title="DELETE"  onclick="deleteData(' . "'" . $r->no_po . "'" . ',' . "'" . $r->no_po . "'" . ')" class="btn btn-danger btn-sm">
									<i class="fa fa-trash-alt"></i>
								</button>  
	                            <button title="VERIFIKASI DATA" type="button" onclick="tampil_edit(' . "'" . $r->id . "'" . ',' . "'detail'" . ')" class="btn btn-info btn-sm">
                                    <i class="fa fa-check"></i>
	                            </button>
								<a target="_blank" class="btn btn-sm btn-danger" href="' . base_url("Transaksi/Cetak_PO?no_po=" . $r->no_po . "") . '" title="Cetak" ><i class="fas fa-print"></i> </a>

								<a target="_blank" class="btn btn-sm btn-success" href="' . base_url("Transaksi/Cetak_wa_po?no_po=" . $r->no_po . "") . '" title="Format WA" ><b><i class="fab fa-whatsapp"></i> </b></a> 
								
								<a target="_blank" class="btn btn-sm btn-primary" href="' . base_url("Transaksi/Cetak_img_po?no_po=" . $r->no_po . "") . '" title="CETAK PO" ><b><i class="fas fa-images"></i> </b></a>
								';
						}else{
							$aksi .=  '
								<a target="_blank" class="btn btn-sm btn-danger" href="' . base_url("Transaksi/Cetak_PO?no_po=" . $r->no_po . "") . '" title="Cetak" ><i class="fas fa-print"></i> </a>

								<a target="_blank" class="btn btn-sm btn-success" href="' . base_url("Transaksi/Cetak_wa_po?no_po=" . $r->no_po . "") . '" title="Format WA" ><b><i class="fab fa-whatsapp"></i> </b></a> 
								
								<a target="_blank" class="btn btn-sm btn-primary" href="' . base_url("Transaksi/Cetak_img_po?no_po=" . $r->no_po . "") . '" title="CETAK PO" ><b><i class="fas fa-images"></i> </b></a>
								';

						}

						if($time<date('2023-11-13'))
						{
							
							// 1 itu aktif 0 itu non aktif / po lama
							if($r->aktif=='1')
							{
								$aksi .=  '
								<button type="button" title="NON AKTIF"  onclick="nonaktif(0,' . "'" . $r->id . "'" . ',' . "'" . $r->no_po . "'" . ',' . "'" . $this->m_fungsi->tanggal_ind($time) . "'" . ')" class="btn btn-sm btn-warning">
									<i class="fas fa-power-off"></i>
								</button> 
								';
							}else{
								$aksi .=  '
								<button type="button" title="AKTIF"  onclick="nonaktif(1,'. "'" . $r->id . "'" . ',' . "'" . $r->no_po . "'" . ',' . "'" . $this->m_fungsi->tanggal_ind($time) . "'" . ')" class="btn btn-sm btn-primary">
									<i class="fas fa-power-off"></i>
								</button> 
								';
							}

						}
					}

					
				}

				$row[] = '<div class="text-center">'.$aksi.'</div>';

				$data[] = $row;

				$i++;
			}
		} else if ($jenis == "po_bahan") {

			$query = $this->db->query("SELECT b.*,a.*,(select datang_bhn_bk from(select sum(datang_bhn_bk)datang_bhn_bk,no_po_bhn from trs_d_stok_bb group by no_po_bhn)c where c.no_po_bhn=a.no_po_bhn)datang
			FROM trs_po_bhnbk a 
			JOIN m_hub b ON a.hub=b.id_hub 
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
						<a target="_blank" class="btn btn-sm btn-danger" href="' . base_url("Transaksi/Cetak_PO_BAHAN?no_po_bhn=".$no_po_bhn2."") . '" title="Cetak" ><i class="fas fa-print"></i> </a>

						';

					}else{

						$aksi = '
						<a class="btn btn-sm btn-warning" onclick="edit_data(' . $id . ',' . $no_po_bhn . ')" title="EDIT DATA" >
							<b><i class="fa fa-edit"></i> </b>
						</a> 
						
						<a target="_blank" class="btn btn-sm btn-danger" href="' . base_url("Transaksi/Cetak_PO_BAHAN?no_po_bhn=".$no_po_bhn2."") . '" title="Cetak" ><i class="fas fa-print"></i> </a>

						<button type="button" title="DELETE"  onclick="deleteData(' . $id . ',' . $no_po_bhn . ')" class="btn btn-danger btn-sm">
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
			$query = $this->db->query("SELECT d.id AS id_po_detail,p.kode_mc,d.tgl_so,p.nm_produk,d.status_so,COUNT(s.rpt) AS c_rpt,l.nm_pelanggan,s.* FROM trs_po_detail d
			INNER JOIN trs_so_detail s ON d.no_po=s.no_po AND d.kode_po=s.kode_po AND d.no_so=s.no_so AND d.id_produk=s.id_produk
			INNER JOIN m_produk p ON d.id_produk=p.id_produk
			INNER JOIN m_pelanggan l ON d.id_pelanggan=l.id_pelanggan
			WHERE d.no_so IS NOT NULL AND d.tgl_so IS NOT NULL AND d.status_so IS NOT NULL
			GROUP BY d.id DESC")->result();
			$i = 1;
			foreach ($query as $r) {
				$row = array();
				$row[] = '<div class="text-center"><a href="javascript:void(0)" onclick="tampilEditSO('."'".$r->id_po_detail."'".','."'".$r->no_po."'".','."'".$r->kode_po."'".','."'detail'".')">'.$i."<a></div>";
				$row[] = $this->m_fungsi->tglIndSkt($r->tgl_so);
				$row[] = $r->kode_mc;
				$row[] = $r->nm_produk;
				$row[] = $r->nm_pelanggan;

				$urut_so = str_pad($r->urut_so, 2, "0", STR_PAD_LEFT);
				$row[] = $r->no_so.'.'.$urut_so.'('.$r->c_rpt.')';
				// $row[] = $r->no_so;
				if ($r->status_so == 'Open') {
					$aksi = '<button type="button" onclick="tampilEditSO('."'".$r->id_po_detail."'".','."'".$r->no_po."'".','."'".$r->kode_po."'".','."'edit'".')" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></button>';
				}else{
					$aksi = '-';
				}
				$row[] = '<div class="text-center">'.$aksi.'</div>';
				$data[] = $row;
				$i++;
			}
		} else if ($jenis == "trs_wo") {
			$query = $this->m_master->query("SELECT a.id as id_wo,a.status AS statusWO,a.*,b.*,c.*,d.* FROM trs_wo a 
            JOIN trs_wo_detail b ON a.no_wo=b.no_wo 
            JOIN m_produk c ON a.id_produk=c.id_produk 
            JOIN m_pelanggan d ON a.id_pelanggan=d.id_pelanggan 
            order by a.id desc")->result();
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

				if ($r->statusWO == 'Open') {

                    $aksi = ' 
							<button type="button" onclick="tampil_edit(' . "'" . $r->id_wo . "'" . ',' . "'edit'" . ')" class="btn btn-info btn-sm">
                                <i class="fa fa-edit"></i>
                            </button>

							<a target="_blank" class="btn btn-sm btn-warning" href="' . base_url("Transaksi/Cetak_WO?no_wo=" . $r->no_wo . "") . '" title="Cetak" ><i class="fas fa-print"></i> </a>

                            <button type="button" onclick="deleteData(' . "'" . $r->id_wo . "'" . ',' . "'" . $r->no_wo . "'" . ')" class="btn btn-danger btn-sm">
                                <i class="fa fa-trash-alt"></i>
                            </button>  
                            ';

				} else {
					$aksi = '-';
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
			($this->session->userdata('username') == 'usman') ? $where = "WHERE s.id_sales='9' OR s.nm_sales='Usman'" : $where = '';
			($_POST["po"] == 'pengiriman') ? $stats = "AND po.status_lm='Approve' AND po.status_kirim='Open' ORDER BY po.tgl_lm DESC,pl.nm_pelanggan_lm,po.no_po_lm" : $stats = "ORDER BY po.tgl_lm DESC,po.no_po_lm" ;
			$query = $this->db->query("SELECT po.*,pl.nm_pelanggan_lm FROM trs_po_lm po
			INNER JOIN m_pelanggan_lm pl ON po.id_pelanggan=pl.id_pelanggan_lm
			INNER JOIN m_sales s ON po.id_sales=s.id_sales
			$where $stats")->result();
			$i = 0;
			foreach ($query as $r) {
				$i++;
				$row = array();
				if($_POST["po"] == 'list'){
					$row[] = '<div class="text-center">'.$i.'</div>';
					$row[] = $r->no_po_lm;
					$row[] = $r->tgl_lm;
					if($r->status_lm == 'Open'){
						$btn_s = 'btn-info';
					}else if($r->status_lm == 'Approve'){
						$btn_s = 'btn-success';
					}else{
						$btn_s = 'btn-danger';
					}
					$row[] = '<div class="text-center"><button type="button" class="btn btn-sm '.$btn_s.'" onclick="editPOLaminasi('."'".$r->id."'".',0,'."'detail'".')">'.$r->status_lm.'</button></div>';
					$row[] = $r->nm_pelanggan_lm;
					$row[] = '<div class="text-center">
						<div class="dropup">
							<button class="dropbtn btn btn-sm btn-success"><i class="fas fa-check-circle" onclick="editPOLaminasi('."'".$r->id."'".',0,'."'detail'".')"></i></button>
							<div class="dropup-content">
								<div class="time-admin">'.$this->m_fungsi->tglIndSkt(substr($r->add_time,0,10)).' - '.substr($r->add_time,10,9).'</div>
							</div>
						</div>
					</div>';

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
					$lapProd = '<a target="_blank" class="btn btn-sm btn-warning" href="'.base_url("Transaksi/Lap_POLaminasi?id=".$r->id."&opsi=prod").'" title="Laporan Laminasi" ><i class="fas fa-print"></i></a>'; 
					$row[] = '<div class="text-center">'.$lapAcc.' '.$lapProd.'</div>';

					($r->status_lm1 == 'Y' && $r->status_lm2 == 'Y') ? $xEditVerif = 'verif' : $xEditVerif = 'edit';
					$btnEdit = '<button type="button" onclick="editPOLaminasi('."'".$r->id."'".',0,'."'".$xEditVerif."'".')" title="EDIT" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></button>'; 
					$btnHapus = ($r->status_lm1 == 'Y' && $r->status_lm2 == 'Y') ? '' : '<button type="button" onclick="hapusPOLaminasi(0,'."'".$r->id."'".','."'trs_po_lm'".')" title="HAPUS" class="btn btn-danger btn-sm"><i class="fa fa-trash-alt"></i></button>';
					$btnVerif = '<button type="button" onclick="editPOLaminasi('."'".$r->id."'".',0,'."'verif'".')" title="VERIF" class="btn btn-info btn-sm"><i class="fa fa-check"></i></button>'; 
					
					if($this->session->userdata('level') == 'Admin'){
						$row[] = '<div class="text-center">'.$btnEdit.' '.$btnHapus.' '.$btnVerif.'</div>';
					}else if($this->session->userdata('level') == 'Laminasi'){
						$row[] = '<div class="text-center">'.$btnEdit.' '.$btnHapus.'</div>';
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
			$queryh   = "SELECT * FROM $tbl a JOIN m_hub b ON a.hub=b.id_hub WHERE $field = '$id' ";
			
			$queryd   = "SELECT*FROM $tbl where $field = '$id' ";
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
						($r->jenis_qty_lm == 'pack') ? $kg = '' : $kg = ' ( IKAT )';
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
		$this->m_fungsi->newMpdf($judul, 'cetak', $html, 5, 5, 5, 5, 'P', 'A4', $judul.'.pdf');
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
					$result = $this->m_master->query("DELETE FROM trs_po_lm WHERE id='$id'");
				}
			}else{
				$result = false;
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
			// $data = $this->m_master->get_data_one("trs_po_detail", "no_po", $header->no_po)->result();

			if($header->img_po==null || $header->img_po=='') {
				$url_foto = base_url('assets/gambar_po/foto.jpg');
			}else{
				$url_foto = base_url('assets/gambar_po/') . $header->img_po;
			}

			$detail = $this->db->query("SELECT * FROM trs_po a 
                    JOIN trs_po_detail b ON a.no_po = b.no_po
                    JOIN m_pelanggan c ON a.id_pelanggan=c.id_pelanggan
                    LEFT JOIN m_kab d ON c.kab=d.kab_id
                    LEFT JOIN m_produk e ON b.id_produk=e.id_produk
					WHERE a.no_po = '$header->no_po' ORDER BY b.id
				")->result();

			$data = ["header" => $header, "detail" => $detail, "url_foto" => $url_foto];

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
	
    function Cetak_wa_po()
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

			if($this->session->userdata('level')=='Admin')
			{
				$kode_po ='<br> ( ' . $data->kode_po . ' )';
			}else{
				$kode_po ='';
	
			}
	

			$html .= '<table width="100%" border="0" cellspacing="0" style="font-size:14px;">
                        <tr style="font-weight: bold;">
                            <td colspan="15" align="center">
                            ( No. ' . $id . ' )
                            </td>
                        </tr>
                 </table><br>';

				$html .= '<table width="100%" border="0" cellspacing="0" style="font-size:22px;">
				<tr align="left" style="background-color: #cccccc">
					<th>PO '.substr($data->kategori,2,10).' '. $data->nm_pelanggan .' '.$kode_po.'</th>
				</tr>
				<tr align="left">
					<th>ITEM </th>';
				 
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
						<th>RM </th>';
                        
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
                <th>Harga / kg</th>
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

		// $this->m_fungsi->_mpdf($html);
		$this->m_fungsi->template_kop('PURCHASE ORDER', $id ,$html,'L','0');
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

	function Cetak_PO_BAHAN()
	{
		$no_po_bhn    = $_GET['no_po_bhn'];
		$judul        = 'PO BAHAN BAKU ';
		$position     = 'P';
		$cekpdf       = '1';


		$param        = $judul;
		$unit         = $this->session->userdata('unit');
		$npwp         = '-';
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
		// AND p.status_app3='Y' AND p.status='Approve'
		$po = $this->db->query("SELECT c.kode_unik,c.nm_pelanggan,s.nm_sales,p.*,d.eta FROM trs_po p
		INNER JOIN trs_po_detail d ON p.no_po=d.no_po AND p.kode_po=d.kode_po
		INNER JOIN m_pelanggan c ON p.id_pelanggan=c.id_pelanggan
		INNER JOIN m_sales s ON c.id_sales=s.id_sales
		-- WHERE p.status_app1='Y' AND p.status_app2='Y' AND p.status_kiriman='Open'
		WHERE p.status_kiriman='Open'
		AND d.no_so IS NULL AND d.tgl_so IS NULL AND d.status_so IS NULL
		GROUP BY p.no_po,p.kode_po ORDER BY c.nm_pelanggan,p.no_po")->result();
		echo json_encode(array(
			'po' => $po,
		));
	}

	function soPlhItems()
	{
		$no_po = $_POST["no_po"];
		$poDetail = $this->db->query("SELECT p.nm_produk,p.kode_mc,p.ukuran,p.ukuran_sheet,p.flute,p.kualitas,d.eta,d.* FROM trs_po_detail d
		INNER JOIN trs_po o ON d.no_po=o.no_po AND d.kode_po=o.kode_po
		INNER JOIN m_produk p ON d.id_produk=p.id_produk
		WHERE d.status='Approve' AND d.no_po='$no_po' AND no_so IS NULL AND tgl_so IS NULL")->result();
		echo json_encode(array(
			'po_detail' => $poDetail,
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
					<th style="width:25%">ITEM</th>
					<th style="width:25%">NO. PO</th>
					<th style="width:25%">NO. SO</th>
					<th style="width:10%">QTY SO</th>
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
				<td>'.$r['options']['no_po'].'</td>
				<td>'.$r['options']['no_so'].'</td>
				<td>'.number_format($r['options']['jml_so']).'</td>
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
		$html .='<table class="table table-bordered table-striped" style="width:100%">
			<thead>
				<tr>
					<th style="padding:12px 6px;width:3%;text-align:center">NO.</th>
					<th style="padding:12px 6px;width:20%">KODE MC</th>
					<th style="padding:12px 6px;width:32%">ITEM</th>
					<th style="padding:12px 6px;width:10%">UKURAN</th>
					<th style="padding:12px 6px;width:10%">KUALITAS</th>
					<th style="padding:12px 6px;width:5%;text-align:center">FLUTE</th>
					<th style="padding:12px 6px;width:10%;text-align:center">QTY PO</th>
					<th style="padding:12px 6px;width:10%;text-align:center">AKSI</th>
				</tr>
			</thead>';

		$getSO = $this->db->query("SELECT p.kode_mc,p.nm_produk,p.kategori,p.ukuran,p.ukuran_sheet,p.ukuran_sheet_l,p.ukuran_sheet_p,p.kualitas,p.flute,p.berat_bersih,d.* FROM trs_po_detail d
		INNER JOIN m_produk p ON d.id_produk=p.id_produk
		WHERE no_po='$no_po' AND kode_po='$kode_po'");

		$i = 0;
		foreach($getSO->result() as $r){
			$i++;
			$idPoSo = $r->id;
			($r->id == $id) ? $bHead = 'background:#ccc;border:1px solid #888;' : $bHead = '';
			($r->id == $id) ? $bold = 'font-weight:bold;"' : $bold = 'font-weight:normal;';
			($r->id == $id) ? $borLf = 'border-left:3px solid #0f0;' : $borLf = '';
			if($aksi == 'detail'){
				$btnBagi = '<button class="btn btn-secondary btn-sm" disabled><i class="fas fa-minus"></i></button>';
			}else{
				($r->id == $id) ?
					$btnBagi = '<button type="button" class="btn btn-success btn-sm" id="addBagiSO" onclick="addBagiSO('."'".$r->id."'".')"><i class="fas fa-plus"></i></button>
						<button type="button" class="btn btn-danger btn-sm" id="hapusListSO" onclick="hapusListSO('."'".$r->id."'".')"><i class="fas fa-trash"></i></button>' :
					$btnBagi = '<button class="btn btn-secondary btn-sm" disabled><i class="fas fa-minus"></i></button>';
			}
			($r->kategori == "K_BOX") ? $ukuran = $r->ukuran : $ukuran = $r->ukuran_sheet;
			($r->kategori == "K_BOX") ? $ket_p = '[BOX]' : $ket_p = '[SHEET]';
			
			$html .='<tr style="'.$borLf.'">
				<td style="padding:6px;text-align:center;'.$bold.'">'.$i.'</td>
				<td style="padding:6px;'.$bold.'">'.$r->kode_mc.'</td>
				<td style="padding:6px;'.$bold.'">'.$ket_p.' '.$r->nm_produk.'</td>
				<td style="padding:6px;'.$bold.'">'.$ukuran.'</td>
				<td style="padding:6px;'.$bold.'">'.$this->m_fungsi->kualitas($r->kualitas, $r->flute).'</td>
				<td style="padding:6px;text-align:center;'.$bold.'">'.$r->flute.'</td>
				<td style="padding:6px;text-align:right;'.$bold.'">'.number_format($r->qty).'</td>
				<td style="padding:6px;text-align:center;'.$bold.'">'.$btnBagi.'</td>
			</tr>';

			$dataSO = $this->db->query("SELECT p.nm_produk,p.ukuran_sheet_l,p.ukuran_sheet_p,p.berat_bersih,s.* FROM trs_so_detail s
			INNER JOIN m_produk p ON s.id_produk=p.id_produk
			WHERE s.id_produk='$r->id_produk' AND s.no_po='$r->no_po' AND s.kode_po='$r->kode_po' AND s.no_so='$r->no_so'");
			
			if($dataSO->num_rows() != 0){
				$html .='<tr style="'.$borLf.'">
					<td colspan="8">
						<table class="table table-bordered" style="margin:0;border:0;width:100%">
							<thead>
								<tr>
									<th style="padding:6px;width:3%;'.$bHead.''.$bold.'" class="text-center">NO.</th>
									<th style="padding:6px;width:10%;'.$bHead.''.$bold.'">ETA SO</th>
									<th style="padding:6px;width:20%;'.$bHead.''.$bold.'">NO. SO</th>
									<th style="padding:6px;width:12%;'.$bHead.''.$bold.'">QTY SO</th>
									<th style="padding:6px;width:20%;'.$bHead.''.$bold.'">KETERANGAN</th>
									<th style="padding:6px;width:5%;'.$bHead.''.$bold.'" class="text-center">-</th>
									<th style="padding:6px;width:7%;'.$bHead.''.$bold.'" class="text-center">RM</th>
									<th style="padding:6px;width:7%;'.$bHead.''.$bold.'" class="text-center">TON</th>
									<th style="padding:6px;width:7%;'.$bHead.''.$bold.'" class="text-center">B. BAKU</th>
									<th style="padding:6px;width:10%;'.$bHead.''.$bold.'" class="text-center">AKSI</th>
								</tr>
							</thead>';

				$dataHapusSO = $this->db->query("SELECT COUNT(so.rpt) AS jml_rpt FROM trs_po_detail ps
				INNER JOIN trs_so_detail so ON ps.no_po=so.no_po AND ps.kode_po=so.kode_po AND ps.no_so=so.no_so AND ps.id_produk=so.id_produk
				WHERE ps.id='$idPoSo' GROUP BY so.no_po,so.kode_po,so.no_so,so.id_produk");
				
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
						if($so->status == 'Close'){
							$btnHapus = '';
						}else{
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
						}
					}

					$link = base_url('Transaksi/laporanSO?id=').$so->id;
					$print = '<a href="'.$link.'" target="_blank"><button type="button" class="btn btn-dark btn-sm"><i class="fas fa-print"></i></button></a>';
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
							($r->id == $id) ? $diss = '' : $diss = 'disabled';
							($r->id == $id) ? $btnAksi = $print.' <button type="button" class="btn btn-warning btn-sm" id="editBagiSO'.$so->id.'" onclick="editBagiSO('."'".$so->id."'".')"><i class="fas fa-edit"></i></button>' : $btnAksi = $print;
							($r->id == $id) ? $rTxt = 2 : $rTxt = 1;
						}
					}

					($so->cek_rm_so == 0) ? $check = '' : $check = 'checked';
					$bahan_baku = ceil($so->ton / 0.7);
					
					$urut_so = str_pad($so->urut_so, 2, "0", STR_PAD_LEFT);
					$rpt = str_pad($so->rpt, 2, "0", STR_PAD_LEFT);
					$html .='<tr>
						<td style="padding:6px;'.$bTd.''.$bold.'" class="text-center">'.$l.'</td>
						<td style="padding:6px;'.$bTd.''.$bold.'"><input type="date" id="edit-tgl-so'.$so->id.'" class="form-control" value="'.$so->eta_so.'" '.$diss.'></td>
						<td style="padding:6px;'.$bTd.''.$bold.'">'.$so->no_so.'.'.$urut_so.'.'.$rpt.'</td>
						<td style="padding:6px;'.$bTd.''.$bold.'"><input type="number" id="edit-qty-so'.$so->id.'" class="form-control" onkeyup="keyUpQtySO('."'".$so->id."'".')" value="'.$so->qty_so.'" '.$diss.'></td>
						<td style="padding:6px;'.$bTd.''.$bold.'"><textarea class="form-control" id="edit-ket-so'.$so->id.'" rows="'.$rTxt.'" style="resize:none" '.$diss.'>'.$so->ket_so.'</textarea></td>
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
				}

				if($dataSO->num_rows() > 1){
					$html .='<tr>
						<td style="background:#fff;padding:6px;font-weight:bold;text-align:center;border:0" colspan="3"></td>
						<td style="background:#fff;padding:6px;font-weight:bold;border:0">'.number_format($sumQty).'</td>
						<td style="background:#fff;padding:6px;font-weight:bold;text-align:center;border:0"></td>
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

	function editBagiSO()
	{
		$result = $this->m_transaksi->editBagiSO();
		echo json_encode($result);
	}

	function btnAddBagiSO()
	{
		if($_POST["fBagiEtaSo"] == "" || $_POST["fBagiQtySo"] == "" || $_POST["fBagiQtySo"] == 0 || $_POST["fBagiQtySo"] < 0){
			echo json_encode(array('data' => false, 'msg' => 'ETA, QTY SO TIDAK BOLEH KOSONG!'));
		}else{
			$id = $_POST["i"];
			$produk = $this->db->query("SELECT p.* FROM m_produk p INNER JOIN trs_po_detail s ON p.id_produk=s.id_produk WHERE s.id='$id' GROUP BY p.id_produk");
			$RumusOut = 1800 / $produk->row()->ukuran_sheet_l;
			(floor($RumusOut) >= 5) ? $out = 5 : $out = (floor($RumusOut));
			$rm = ($produk->row()->ukuran_sheet_p * $_POST["fBagiQtySo"] / $out) / 1000;
			$ton = $_POST["fBagiQtySo"] * $produk->row()->berat_bersih;

			$getData = $this->db->query("SELECT COUNT(so.rpt) AS jml_rpt,so.* FROM trs_po_detail ps
			INNER JOIN trs_so_detail so ON ps.no_po=so.no_po AND ps.kode_po=so.kode_po AND ps.no_so=so.no_so AND ps.id_produk=so.id_produk
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
					'eta_so' => $_POST['fBagiEtaSo'],
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
			($this->cart->total_items() == $r['options']['total_items']) ?
				$btnAksi = '<button class="btn btn-danger btn-sm" id="hapusCartItemSO" onclick="hapusCartItem('."'".$r['rowid']."'".','."'".$r['id']."'".','."'ListAddBagiSO'".')"><i class="fas fa-times"></i> <b>BATAL</b></button>' : $btnAksi = '-' ;
			$html .='<tr>
				<td style="border:1px solid #999" class="text-center">'.$i.'</td>
				<td style="border:1px solid #999">'.$r['options']['eta_so'].'</td>
				<td style="border:1px solid #999">'.$r['options']['no_so'].'.'.$urut_so.'.'.$rpt.'</td>
				<td style="border:1px solid #999">'.number_format($r['options']['qty_so']).'</td>
				<td style="border:1px solid #999">'.$r['options']['ket_so'].'</td>
				<td style="border:1px solid #999">'.number_format($r['options']['rm']).'</td>
				<td style="border:1px solid #999">'.number_format($r['options']['ton']).'</td>
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
				<td style="background:#fff;padding:3px;font-weight:bold;border:0;text-align:center">'.number_format($sumQty).'</td>
				<td style="background:#fff;padding:3px;font-weight:bold;border:0;text-align:center"></td>
				<td style="background:#fff;padding:3px;font-weight:bold;border:0;text-align:center">'.number_format($sumRm).'</td>
				<td style="background:#fff;padding:3px;font-weight:bold;border:0;text-align:center">'.number_format($sumTon).'</td>
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

	function pilihanEtaPO()
	{
		$html ='';

		$getData = $this->db->query("SELECT eta_so,COUNT(eta_so) AS jml FROM trs_so_detail
		GROUP BY eta_so");

		$html .='<div class="card-body row" style="padding-bottom:20px;font-weight:bold">';
		$html .='<table class="table table-bordered table-striped">
		<thead>
			<tr>
				<th style="text-align:center">NO.</th>
				<th>TANGGAL</th>
				<th style="text-align:center">JUMLAH</th>
			</tr>
		</thead>';
		$i = 0;
		foreach($getData->result() as $r){
			$i++;
			$html .= '</tr>
				<td style="text-align:center">'.$i.'</td>
				<td><a href="javascript:void(0)" onclick="tampilDataEtaPO('."'".$r->eta_so."'".',)">'.strtoupper($this->m_fungsi->tanggal_format_indonesia($r->eta_so)).'<a></td>
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
		$tgl = $_POST["tgl"];

		$html .='<div class="card card-info card-outline">
		<div class="card-body row" style="padding-bottom:20px;font-weight:bold">';
		
		$getData = $this->db->query("SELECT * FROM trs_so_detail so
		INNER JOIN m_pelanggan p ON so.id_pelanggan=p.id_pelanggan
		WHERE so.eta_so='$tgl'");
		if($getData->num_rows() == 0){
			$html .= 'DATA KOSONG!';
		}else{
			$html .='<div class="col-md-12" style="margin-bottom:10px">
				DATA ETA TANGGAL : '.strtoupper($this->m_fungsi->tanggal_format_indonesia($tgl)).'
			</div>';
			$html .='<table class="table table-bordered table-striped">
			<thead>
				<tr>
					<th style="text-align:center">NO.</th>
					<th style="text-align:center">CUSTOMER</th>
					<th style="text-align:center">NO. PO</th>
				</tr>
			</thead>';
			$i = 0;
			foreach($getData->result() as $r){
				$i++;
				$html .='<tr>
					<td style="text-align:center">'.$i.'</td>
					<td>'.$r->nm_pelanggan.'</td>
					<td>'.$r->kode_po.'</td>
				</tr>';
			}

		}

		$html .='</div></div>';

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

	public function coba_api()
	{
		$curl = curl_init();

		curl_setopt_array($curl, array(
		CURLOPT_URL => "https://api.rajaongkir.com/starter/province?id=12",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "GET",
		CURLOPT_HTTPHEADER => array(
			"key: c479d0aa6880c0337184539462eeec6f"
		),
		));

		$response   = curl_exec($curl);
		$err        = curl_error($curl);

		curl_close($curl);

		if ($err) {
			echo "cURL Error #:" . $err;
		} else {
			// echo $response;
			echo json_encode($response);
		}
	}

}
