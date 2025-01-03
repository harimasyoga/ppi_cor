<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Rekapan extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('status') != "login") {
			redirect(base_url("Login"));
		}
		$this->load->model('m_master');
		$this->load->model('m_fungsi');
		$this->load->model('m_transaksi');
	}

	function Penjualan()
	{
		$data = array(
			'judul' => "Rekap Penjualan Invoice",
			// 'pelanggan' => $this->m_master->get_data("m_pelanggan")->result()
		);

		$this->load->view('header', $data);
		$this->load->view('Rekap/v_jual_inv', $data);
		$this->load->view('footer');
	}
	

	function Beli_bb()
	{
		$data = array(
			'judul' => "Rekap Pembelian Bahan baku",
			// 'pelanggan' => $this->m_master->get_data("m_pelanggan")->result()
		);

		$this->load->view('header', $data);
		$this->load->view('Rekap/v_beli_bb_keu', $data);
		$this->load->view('footer');
	}
	

	function Penggunaan_bb()
	{
		$data = array(
			'judul' => "Rekap Penggunaan Bahan Baku",
			// 'pelanggan' => $this->m_master->get_data("m_pelanggan")->result()
		);

		$this->load->view('header', $data);
		$this->load->view('Rekap/v_guna_bb_keu', $data);
		$this->load->view('footer');
	}
	
	function Jurum()
	{
		$data = array(
			'judul' => "Rekap Rekap Jurnal Umum",
			// 'pelanggan' => $this->m_master->get_data("m_pelanggan")->result()
		);

		$this->load->view('header', $data);
		$this->load->view('Rekap/v_jurum_keu', $data);
		$this->load->view('footer');
	}
	
	function Bayar()
	{
		$data = array(
			'judul' => "Rekap Produk",
			// 'pelanggan' => $this->m_master->get_data("m_pelanggan")->result()
		);

		$this->load->view('header', $data);
		$this->load->view('Rekap/v_pembayaran_keu', $data);
		$this->load->view('footer');
	}

	function load_data()
	{
		$jenis        = $this->uri->segment(3);
		$data         = array();

		if ($jenis == "jual_invoice") {

			$bulan       = $_POST['bulan'];
			$jns_data    = $_POST['jns_data'];

			if($bulan)
			{
				$bln_thn = explode('-',$bulan);
				$tahun   = $bln_thn[0];
				$blnn    = $bln_thn[1];
			}else{
				$tahun   = date('Y');
				$blnn    = date('m');
			}
			
			if($jns_data=='box')
			{

				$query = $this->db->query("SELECT a.no_invoice,a.nm_perusahaan, c.id_hub,d.nm_hub,a.bank,a.tgl_invoice,b.nm_ker,b.no_po,b.type,b.qty,b.retur_qty,b.hasil,b.harga,a.pajak from invoice_header a 
				join invoice_detail b on a.no_invoice=b.no_invoice
				join trs_po c on b.no_po=c.kode_po
				join m_hub d on c.id_hub=d.id_hub
				where a.type in ('box','sheet') and YEAR(tgl_invoice) ='$tahun' and MONTH(tgl_invoice) ='$blnn' and c.id_hub not in ('7')
				order by c.id_hub,a.tgl_invoice,a.no_invoice")->result();

				$i               = 1;
				foreach ($query as $r) {

					$row        = array();

					$row[]   = $i;
					$row[]   = $r->no_invoice;
					$row[]   = $r->nm_perusahaan;
					$row[]   = $r->id_hub;
					$row[]   = $r->nm_hub;
					$row[]   = $r->bank;
					$row[]   = $r->tgl_invoice;
					$row[]   = $r->nm_ker;
					$row[]   = $r->no_po;
					$row[]   = $r->type;
					$row[]   = '<div class="text-center">'.number_format($r->qty, 0, ",", ".").'</div>';
					$row[]   = $r->retur_qty;
					$row[]   = '<div class="text-center">'.number_format($r->hasil, 0, ",", ".").'</div>';
					$row[]   = '<div class="text-center">Rp '.number_format($r->harga, 0, ",", ".").'</div>';
					$row[]   = $r->pajak;

					$data[]     = $row;

					$i++;
				}

			}else{

				$query = $this->db->query("SELECT no_invoice,nm_pelanggan_lm,id_hub,nm_hub,tgl_invoice,nm_produk_lm,no_po_lm,''type, qty_ok as qty,retur_qty as retur_qty,qty_ok-retur_qty as qty_fix,harga_pori_lm as harga,(qty_ok-retur_qty)*harga_pori_lm as total_jual,hitung as diskon,(qty_ok-retur_qty)*harga_pori_lm-hitung as total_inv FROM(

				SELECT a.no_invoice,a.tgl_invoice,g.nm_pelanggan_lm,h.id_hub,h.nm_hub,d.*,e.*,f.no_po_lm,c.hitung, d.qty_muat*(case when jenis_qty_lm='pack' then e.pack_lm else ikat_lm end) as qty_ok, b.retur_qty,f.harga_pori_lm
				FROM invoice_laminasi_header a 
				join invoice_laminasi_detail b ON a.no_surat=b.no_surat AND a.no_invoice=b.no_invoice
				left join ( select no_invoice,sum(hitung)hitung from invoice_laminasi_disc group by no_invoice ) c ON a.no_invoice=c.no_invoice
				JOIN m_rk_laminasi d ON b.id_rk_lm=d.id
				JOIN m_produk_lm e ON b.id_produk_lm=e.id_produk_lm
				JOIN trs_po_lm_detail f ON b.id_po_dtl=f.id
				JOIN m_pelanggan_lm g ON g.id_pelanggan_lm=a.id_pelanggan_lm
				JOIN m_hub h ON h.id_hub=a.bank
				WHERE MONTH(a.tgl_surat_jalan) in ($blnn) and YEAR(a.tgl_surat_jalan) in ($tahun) and a.jenis_lm='PPI'
				-- GROUP BY a.tgl_surat_jalan,a.no_surat,a.no_invoice 
				)p
				order by id_hub,p.tgl_invoice,no_invoice")->result();

				$i               = 1;
				foreach ($query as $r) {

					$row        = array();

					$row[]      = $i;
					$row[]      = $r->no_invoice;
					$row[]      = $r->nm_pelanggan_lm;
					$row[]      = $r->id_hub;
					$row[]      = $r->nm_hub;
					$row[]      = $r->tgl_invoice;
					$row[]      = $r->nm_produk_lm;
					$row[]      = $r->no_po_lm;
					$row[]      = $r->type;
					$row[]   = '<div class="text-center">'.number_format($r->qty, 0, ",", ".").'</div>';
					$row[]   = '<div class="text-center">'.number_format($r->retur_qty, 0, ",", ".").'</div>';
					$row[]   = '<div class="text-center">'.number_format($r->qty_fix, 0, ",", ".").'</div>';
					$row[]   = '<div class="text-center">'.number_format($r->harga, 0, ",", ".").'</div>';
					$row[]   = '<div class="text-center">'.number_format($r->total_jual, 0, ",", ".").'</div>';
					$row[]   = '<div class="text-center">'.number_format($r->diskon, 0, ",", ".").'</div>';
					$row[]   = '<div class="text-center">'.number_format($r->total_inv, 0, ",", ".").'</div>';

					$data[]     = $row;

					$i++;
				}
				
			}
			
			
		}else if ($jenis == "guna_bb") {

			$bulan       = $_POST['bulan'];
			$jns_data    = $_POST['jns_data'];

			if($bulan)
			{
				$bln_thn = explode('-',$bulan);
				$tahun   = $bln_thn[0];
				$blnn    = $bln_thn[1];
			}else{
				$tahun   = date('Y');
				$blnn    = date('m');
			}
			
			if($jns_data=='box')
			{

				$query = $this->db->query("SELECT *, f.berat_bersih ,
				r.hasil*f.berat_bersih as tonase,
				round(r.hasil*f.berat_bersih/0.7) as bahan 
				
				from(
SELECT a.no_invoice,a.nm_perusahaan, c.id_hub,d.nm_hub,a.bank,a.tgl_invoice,b.nm_ker,b.no_po,b.type,
				b.qty,b.retur_qty,b.hasil,b.harga,a.pajak, 
				(
				select hrg_bhn from (
				select * from (
				select b.kode_po,a.hrg_bhn from trs_po_bhnbk a
				join trs_po_bhnbk_detail b on a.no_po_bhn=b.no_po_bhn
				group by b.kode_po,a.hrg_bhn desc
				)bhn group by kode_po
				)bhn where bhn.kode_po = c.kode_po) as harga_bahan,
				(select e.id_produk from trs_po_detail e where b.no_po=e.kode_po and b.id_produk_simcorr=e.id_produk)id_produk
				from invoice_header a 
				join invoice_detail b on a.no_invoice=b.no_invoice
				join trs_po c on b.no_po=c.kode_po
				join m_hub d on c.id_hub=d.id_hub
				-- join trs_po_detail e on b.no_po=e.kode_po and e.id_produk=b.id_produk_simcorr
				-- join m_produk f on e.id_produk=f.id_produk
				where a.type in ('box','sheet') and YEAR(tgl_invoice) ='$tahun' and MONTH(tgl_invoice) ='$blnn' and c.id_hub not in ('7')
				)r
				join m_produk f on r.id_produk=f.id_produk
				order by r.id_hub,r.tgl_invoice,r.no_invoice  ")->result();

				$i               = 1;
				foreach ($query as $r) {

					$row        = array();

					$row[]   = $i;
					$row[]   = $r->no_invoice;
					$row[]   = $r->nm_perusahaan;
					$row[]   = $r->id_hub;
					$row[]   = $r->nm_hub;
					$row[]   = $r->bank;
					$row[]   = $r->tgl_invoice;
					$row[]   = $r->nm_ker;
					$row[]   = $r->no_po;
					$row[]   = $r->type;
					$row[]   = $r->qty;
					$row[]   = $r->retur_qty;
					$row[]   = $r->hasil;
					$row[]   = $r->harga;
					$row[]   = $r->pajak;
					$row[]   = $r->berat_bersih;
					$row[]   = '<div class="text-center">'.number_format($r->tonase, 0, ",", ".").'</div>';
					$row[]   = '<div class="text-center">'.number_format($r->bahan, 0, ",", ".").'</div>';
					$row[]   = '<div class="text-right">Rp '.number_format($r->harga_bahan, 0, ",", ".").'</div>';

					$data[]     = $row;

					$i++;
				}

			}else{

				$query = $this->db->query("SELECT no_invoice,nm_pelanggan_lm,id_hub,nm_hub,tgl_invoice,nm_produk_lm,no_po_lm, qty_ok as qty,retur_qty as retur_qty,
				qty_ok-retur_qty as qty_fix_pack,
				(qty_ok-retur_qty)/(case when jenis_qty_lm='pack' then pack_lm else ikat_lm end)qty_bal,
				(qty_ok-retur_qty)/(case when jenis_qty_lm='pack' then pack_lm else ikat_lm end)*50 as tonase,
				round( (qty_ok-retur_qty)/(case when jenis_qty_lm='pack' then pack_lm else ikat_lm end)*50/0.75 )as bahan_Kg,
				(
				select hrg_bhn from (
				select * from (
				select b.kode_po,a.hrg_bhn from trs_po_bhnbk a
				join trs_po_bhnbk_detail b on a.no_po_bhn=b.no_po_bhn
				group by b.kode_po,a.hrg_bhn desc
				)bhn group by kode_po
				)bhn where bhn.kode_po = p.no_po_lm) as harga_bahan
				FROM(

				SELECT a.no_invoice,a.tgl_invoice,g.nm_pelanggan_lm,h.id_hub,h.nm_hub,d.*,e.*,f.no_po_lm,c.hitung, d.qty_muat*(case when jenis_qty_lm='pack' then e.pack_lm else ikat_lm end) as qty_ok, b.retur_qty,f.harga_pori_lm
				FROM invoice_laminasi_header a 
				join invoice_laminasi_detail b ON a.no_surat=b.no_surat AND a.no_invoice=b.no_invoice
				left join ( select no_invoice,sum(hitung)hitung from invoice_laminasi_disc group by no_invoice ) c ON a.no_invoice=c.no_invoice
				JOIN m_rk_laminasi d ON b.id_rk_lm=d.id
				JOIN m_produk_lm e ON b.id_produk_lm=e.id_produk_lm
				JOIN trs_po_lm_detail f ON b.id_po_dtl=f.id
				JOIN m_pelanggan_lm g ON g.id_pelanggan_lm=a.id_pelanggan_lm
				JOIN m_hub h ON h.id_hub=a.bank
				WHERE (h.id_hub!='7' AND h.id_hub!='0') AND MONTH(a.tgl_surat_jalan) in ($blnn) AND YEAR(a.tgl_surat_jalan) in ($tahun) and a.jenis_lm='PPI'
				-- GROUP BY a.tgl_surat_jalan,a.no_surat,a.no_invoice 
				)p
				order by id_hub,p.tgl_invoice,no_invoice")->result();

				$i               = 1;
				foreach ($query as $r) {

					$row        = array();

					$row[]      = $i;
					$row[]      = $r->no_invoice;
					$row[]      = $r->nm_pelanggan_lm;
					$row[]      = $r->id_hub;
					$row[]      = $r->nm_hub;
					$row[]      = $r->tgl_invoice;
					$row[]      = $r->nm_produk_lm;
					$row[]      = $r->no_po_lm;
					$row[]      = $r->qty;
					$row[]      = $r->retur_qty;
					$row[]      = $r->qty_fix_pack;
					$row[]   = '<div class="text-center">'.number_format($r->qty_bal, 0, ",", ".").'</div>';
					$row[]   = '<div class="text-center">'.number_format($r->tonase, 0, ",", ".").'</div>';
					$row[]   = '<div class="text-center">'.number_format($r->bahan_Kg, 0, ",", ".").'</div>';
					$row[]   = '<div class="text-center">'.number_format($r->harga_bahan, 0, ",", ".").'</div>';

					$data[]     = $row;

					$i++;
				}
				
			}
			
			
		}else if ($jenis == "beli_bhn") {

			$bulan       = $_POST['bulan'];
			$jns_data    = $_POST['jns_data'];

			if($bulan)
			{
				$bln_thn = explode('-',$bulan);
				$tahun   = $bln_thn[0];
				$blnn    = $bln_thn[1];
			}else{
				$tahun   = date('Y');
				$blnn    = date('m');
			}
			
			if($jns_data=='box')
			{
				$jns_beli ='BOX';
			}else{
				$jns_beli ='LAMINASI';
			}

			$query = $this->db->query("SELECT a.no_stok,tgl_stok,tgl_j_tempo,no_timbangan,d.no_po_bhn,nm_hub,hrg_bhn,datang_bhn_bk,hrg_bhn*datang_bhn_bk as total from trs_h_stok_bb a 
			JOIN trs_d_stok_bb b on a.no_stok=b.no_stok
			JOIN m_hub c ON b.id_hub=c.id_hub
			JOIN trs_po_bhnbk d ON b.no_po_bhn = d.no_po_bhn
			where c.jns in ('$jns_beli') and MONTH(tgl_stok) in ($blnn) and YEAR(tgl_stok) ='$tahun'
			order by CAST(b.id_hub as int),tgl_j_tempo,a.no_stok")->result();

			$i               = 1;
			foreach ($query as $r) {

				$row        = array();

				$row[]   = $i;
				$row[]   = $r->no_stok;
				$row[]   = $r->tgl_stok;
				$row[]   = $r->tgl_j_tempo;
				$row[]   = $r->no_timbangan;
				$row[]   = $r->no_po_bhn;
				$row[]   = $r->nm_hub;
				$row[]   = '<div class="text-center">Rp '.number_format($r->hrg_bhn, 0, ",", ".").'</div>';
				$row[]   = '<div class="text-center">'.number_format($r->datang_bhn_bk, 0, ",", ".").'</div>';
				$row[]   = '<div class="text-center">'.number_format($r->total, 0, ",", ".").'</div>';

				$data[]     = $row;

				$i++;
			}

			
			
			
		}else if ($jenis == "jur_umum") {
			$query = $this->db->query("SELECT no_voucher, tgl_transaksi,sum(debet)debet,sum(kredit)kredit,a.id_hub,b.nm_hub,ket from jurnal_d a
			JOIN m_hub b ON a.id_hub=b.id_hub
			where no_voucher like'%JURUM%'
			group by no_voucher, tgl_transaksi,a.id_hub,ket
			order by tgl_transaksi desc")->result();

			$i               = 1;
			foreach ($query as $r) 
			{
				$no_voucher    = "'$r->no_voucher'";

				$row = array();
				$row[] = '<div class="text-center">'.$i.'</div>';
				$row[] = '<div class="text-center">'.$r->no_voucher.'</div>';
				$row[] = '<div class="text-center">'.$this->m_fungsi->tanggal_ind($r->tgl_transaksi).'</div>';
				$row[] = '<div class="text-center">'.$r->nm_hub.'</div>';
				$row[] = '<div class="text-center">Rp '.number_format($r->debet, 0, ",", ".").'</div>';
				$row[] = '<div class="text-center">Rp '.number_format($r->kredit, 0, ",", ".").'</div>';
				$row[] = '<div class="text-center">'.$r->ket .'</div>';

				$btncetak ='<a target="_blank" class="btn btn-sm btn-danger" href="' . base_url("Logistik/Cetak_inv_beli?no_voucher="."$r->no_voucher"."") . '" title="Cetak" ><i class="fas fa-print"></i> </a>';

				$btnEdit = '<a class="btn btn-sm btn-warning" onclick="edit_data(' . $no_voucher . ')" title="EDIT DATA" >
				<b><i class="fa fa-edit"></i> </b></a>';

				$btnHapus = '<button type="button" title="DELETE"  onclick="deleteData(' . $no_voucher.')" class="btn btn-danger btn-sm">
				<i class="fa fa-trash-alt"></i></button> ';

				if (in_array($this->session->userdata('level'), ['konsul_keu','User','Admin']))
				{
					$row[] = '<div class="text-center">'.$btnEdit.' '.$btncetak.' '.$btnHapus.'</div>';

				}else{
					$row[] = '<div class="text-center"></div>';
				}

				$data[] = $row;

				$i++;
			}
		}else{

		}

		$output = array(
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}

	function cetak_jual_inv()
	{
		$bulan    = $_GET['bulan'];
		$jns_data = $_GET['jns_data'];
		$cekpdf   = $_GET['ctk'];
		// $cekpdf   = 0;
		$position = 'L';

		if($bulan)
		{
			$bln_thn = explode('-',$bulan);
			$tahun   = $bln_thn[0];
			$blnn    = $bln_thn[1];
		}else{
			$tahun   = date('Y');
			$blnn    = date('m');
		}
		$bln_judul = $this->m_fungsi->getBulan($blnn) ;
		$judul    = 'REKAP INVOICE PENJUALAN('.$bln_judul.' - '.$tahun.' )';
			
		if($jns_data == 'box')
		{
			$judul1 = 'BOX';
			$query_detail = $this->db->query("SELECT a.no_invoice,a.nm_perusahaan, c.id_hub,d.nm_hub,a.bank,a.tgl_invoice,b.nm_ker,b.no_po,b.type,b.qty,b.retur_qty,b.hasil,b.harga,a.pajak from invoice_header a 
			join invoice_detail b on a.no_invoice=b.no_invoice
			join trs_po c on b.no_po=c.kode_po
			join m_hub d on c.id_hub=d.id_hub
			where a.type in ('box','sheet') and YEAR(tgl_invoice) ='$tahun' and MONTH(tgl_invoice) ='$blnn' and c.id_hub not in ('7')
			order by c.id_hub,a.tgl_invoice,a.no_invoice");
		}else{
			$judul1 = 'LAMINASI';
			$query_detail = $this->db->query("SELECT no_invoice,nm_pelanggan_lm,id_hub,nm_hub,tgl_invoice,nm_produk_lm,no_po_lm,''type, qty_ok as qty,retur_qty as retur_qty,qty_ok-retur_qty as qty_fix,harga_pori_lm as harga,(qty_ok-retur_qty)*harga_pori_lm as total_jual,hitung as diskon,(qty_ok-retur_qty)*harga_pori_lm-hitung as total_inv FROM(

				SELECT a.no_invoice,a.tgl_invoice,g.nm_pelanggan_lm,h.id_hub,h.nm_hub,d.*,e.*,f.no_po_lm,c.hitung, d.qty_muat*(case when jenis_qty_lm='pack' then e.pack_lm else ikat_lm end) as qty_ok, b.retur_qty,f.harga_pori_lm
				FROM invoice_laminasi_header a 
				join invoice_laminasi_detail b ON a.no_surat=b.no_surat AND a.no_invoice=b.no_invoice
				left join ( select no_invoice,sum(hitung)hitung from invoice_laminasi_disc group by no_invoice ) c ON a.no_invoice=c.no_invoice
				JOIN m_rk_laminasi d ON b.id_rk_lm=d.id
				JOIN m_produk_lm e ON b.id_produk_lm=e.id_produk_lm
				JOIN trs_po_lm_detail f ON b.id_po_dtl=f.id
				JOIN m_pelanggan_lm g ON g.id_pelanggan_lm=a.id_pelanggan_lm
				JOIN m_hub h ON h.id_hub=a.bank
				WHERE MONTH(a.tgl_surat_jalan) in ($blnn) and YEAR(a.tgl_surat_jalan) in ($tahun) and a.jenis_lm='PPI'
				-- GROUP BY a.tgl_surat_jalan,a.no_surat,a.no_invoice 
				)p
				order by id_hub,p.tgl_invoice,no_invoice");
		}

		$html = '';

		$html .= '
			 <table style="border-collapse:collapse;font-family: Tahoma; font-size:11px" width="100%" align="center" border="0" cellspacing="1" cellpadding="3">
				  <tr>
					   <td colspan="20" width="15%" style="text-align:center; font-size:20px;"><b>REKAP INVOICE PENJUALAN <br> '.$judul1 .' <br>('.$bln_judul.' - '.$tahun.' )</b></td>
				  </tr>
			 </table>';

		$html .= '<br>';

		if ($query_detail->num_rows() > 0) 
		{
			if($jns_data == 'box')
			{				
				$html .= '<table width="100%" border="1" cellspacing="1" cellpadding="3" style="border-collapse:collapse;font-size:12px;font-family: ;">
				<tr style="background-color: #cccccc">
					<Th Align="Center">No</Th>
					<Th Align="Center">No invoice</Th>
					<Th Align="Center">Nm perusahaan</Th>
					<Th Align="Center">Id hub</Th>
					<Th Align="Center">Nm hub</Th>
					<Th Align="Center">Bank</Th>
					<Th Align="Center">Tgl invoice</Th>
					<Th Align="Center">Nm ker</Th>
					<Th Align="Center">No po</Th>
					<Th Align="Center">Type</Th>
					<Th Align="Center">Qty</Th>
					<Th Align="Center">Retur qty</Th>
					<Th Align="Center">Hasil</Th>
					<Th Align="Center">Harga</Th>
					<Th Align="Center">Pajak</Th>
				</tr>';

				$no=1;
				foreach ($query_detail->result() as $r) 
				{
					$html .= '<tr>
							<td align="center">'.$no.'</td>
							<td align="">'.$r->no_invoice.'</td>
							<td align="">'.$r->nm_perusahaan.'</td>
							<td align="">'.$r->id_hub.'</td>
							<td align="">'.$r->nm_hub.'</td>
							<td align="">'.$r->bank.'</td>
							<td align="">'.$r->tgl_invoice.'</td>
							<td align="">'.$r->nm_ker.'</td>
							<td align="">'.$r->no_po.'</td>
							<td align="">'.$r->type.'</td>
							<td align="">'.$r->qty.'</td>
							<td align="">'.$r->retur_qty.'</td>
							<td align="">'.$r->hasil.'</td>
							<td align="">'.$r->harga.'</td>
							<td align="">'.$r->pajak.'</td>
						</tr>';

						$no++;
				}
				$html .= '</table>';
			}else{
				
				$html .= '<table width="100%" border="1" cellspacing="1" cellpadding="3" style="border-collapse:collapse;font-size:12px;font-family: ;">
				<tr style="background-color: #cccccc">
					<th style="text-align: center;">No</th>
					<th style="text-align: center;">No Invoice </th>
					<th style="text-align: center;">Nm Pelanggan Lm  </th>
					<th style="text-align: center;">Id Hub  </th>
					<th style="text-align: center;">Nm Hub  </th>
					<th style="text-align: center;">Tgl Invoice  </th>
					<th style="text-align: center;">Nm Produk Lm </th>
					<th style="text-align: center;">No Po Lm  </th>
					<th style="text-align: center;">Type  </th>
					<th style="text-align: center;">Qty  </th>
					<th style="text-align: center;">Retur Qty </th>
					<th style="text-align: center;">Qty Fix </th>
					<th style="text-align: center;">Harga  </th>
					<th style="text-align: center;">Total Jual </th>
					<th style="text-align: center;">Diskon </th>
					<th style="text-align: center;">Total Inv </th>
				</tr>';

				$no=1;
				foreach ($query_detail->result() as $r) 
				{
					$html .= '<tr>
							<td align="center">'.$no.'</td>
							<td align="">'.$r->no_invoice.'</td>
							<td align="">'.$r->nm_pelanggan_lm.'</td>
							<td align="">'.$r->id_hub.'</td>
							<td align="">'.$r->nm_hub.'</td>
							<td align="">'.$r->tgl_invoice.'</td>
							<td align="">'.$r->nm_produk_lm.'</td>
							<td align="">'.$r->no_po_lm.'</td>
							<td align="">'.$r->type.'</td>
							<td align="">'.$r->qty.'</td>
							<td align="">'.$r->retur_qty.'</td>
							<td align="">'.$r->qty_fix.'</td>
							<td align="">'.$r->harga.'</td>
							<td align="">'.$r->total_jual.'</td>
							<td align="">'.$r->diskon.'</td>
							<td align="">'.$r->total_inv.'</td>
						</tr>';

						$no++;
				}
				$html .= '</table>';
			}

		} else {
			$html .= '<h1> Data Kosong </h1>';
		}

		// $this->m_fungsi->_mpdf($html);
		// $this->m_fungsi->template_kop('REKAP INVOICE PENJUALAN <br>('.$bln_judul.' - '.$tahun.' )','-',$html,'L','1');
		
		$data['prev'] = $html;

		switch ($cekpdf) {
			case 0;
				echo ("<title>$judul</title>");
				echo ($html);
				break;

			case 1;

				// $this->m_fungsi->newMpdf($judul, '', $html, 10, 3, 3, 3, 'L', 'TT', $bln_judul.'.pdf');

				$this->m_fungsi->_mpdf_hari($position, 'A4', $judul, $html, $judul.'.pdf', 5, 5, 5, 10);
				break;

				
				
			case 2;
				header("Cache-Control: no-cache, no-store, must-revalidate");
				header("Content-Type: application/vnd-ms-excel");
				header("Content-Disposition: attachment; filename= $judul.xls");
				$this->load->view('Master/master_cetak', $data);
				break;
		}
	}
	
	function cetak_beli_bahan()
	{
		$bulan    = $_GET['bulan'];
		$jns_data = $_GET['jns_data'];
		$cekpdf   = $_GET['ctk'];
		// $cekpdf   = 0;
		$position = 'L';
	
		if($jns_data == 'box')
		{
			$judul1 = 'BOX';
		}else{
			$judul1 = 'LAMINASI';
		}


		if($bulan)
		{
			$bln_thn = explode('-',$bulan);
			$tahun   = $bln_thn[0];
			$blnn    = $bln_thn[1];
		}else{
			$tahun   = date('Y');
			$blnn    = date('m');
		}
		
		$bln_judul = $this->m_fungsi->getBulan($blnn) ;
		$judul    = 'REKAP INVOICE PENJUALAN '.$judul1.' ('.$bln_judul.' - '.$tahun.' )';

		$query_detail = $this->db->query("SELECT a.no_stok,tgl_stok,tgl_j_tempo,no_timbangan,d.no_po_bhn,nm_hub,hrg_bhn,datang_bhn_bk,hrg_bhn*datang_bhn_bk as total from trs_h_stok_bb a 
			JOIN trs_d_stok_bb b on a.no_stok=b.no_stok
			JOIN m_hub c ON b.id_hub=c.id_hub
			JOIN trs_po_bhnbk d ON b.no_po_bhn = d.no_po_bhn
			where c.jns in ('$judul1') and MONTH(tgl_stok) in ($blnn) and YEAR(tgl_stok) ='$tahun'
			order by CAST(b.id_hub as int),tgl_j_tempo,a.no_stok");

		$html = '';

		$html .= '
			 <table style="border-collapse:collapse;font-family: Tahoma; font-size:11px" width="100%" align="center" border="0" cellspacing="1" cellpadding="3">
				  <tr>
					   <td colspan="20" width="15%" style="text-align:center; font-size:20px;"><b>REKAP PEMBELIAN BAHAN BAKU <br> '.$judul1 .' <br>('.$bln_judul.' - '.$tahun.' )</b></td>
				  </tr>
			 </table>';

		$html .= '<br>';

		if ($query_detail->num_rows() > 0) 
		{				
			$html .= '<table width="100%" border="1" cellspacing="1" cellpadding="3" style="border-collapse:collapse;font-size:12px;font-family: ;">
			<tr style="background-color: #cccccc">
				<Th Align="Center">No</Th>
				<Th Align="Center">No Stok</Th>
				<Th Align="Center">Tgl Stok</Th>
				<Th Align="Center">Tgl J Tempo</Th>
				<Th Align="Center">No Timbangan</Th>
				<Th Align="Center">No Po Bhn</Th>
				<Th Align="Center">Nm Hub</Th>
				<Th Align="Center">Hrg Bhn</Th>
				<Th Align="Center">Datang Bhn Bk</Th>
				<Th Align="Center">Total</Th>
			</tr>';

			$no=1;
			foreach ($query_detail->result() as $r) 
			{
				$html .= '<tr>
						<td align="center">'.$no.'</td>
						<td align="">'.$r->no_stok.'</td>
						<td align="">'.$r->tgl_stok.'</td>
						<td align="">'.$r->tgl_j_tempo.'</td>
						<td align="">'.$r->no_timbangan.'</td>
						<td align="">'.$r->no_po_bhn.'</td>
						<td align="">'.$r->nm_hub.'</td>
						<td align="">'.$r->hrg_bhn.'</td>
						<td align="">'.$r->datang_bhn_bk.'</td>
						<td align="">'.$r->total.'</td>
					</tr>';

					$no++;
			}
			$html .= '</table>';
			

		} else {
			$html .= '<h1> Data Kosong </h1>';
		}

		// $this->m_fungsi->_mpdf($html);
		// $this->m_fungsi->template_kop('REKAP INVOICE PENJUALAN <br>('.$bln_judul.' - '.$tahun.' )','-',$html,'L','1');
		
		$data['prev'] = $html;

		switch ($cekpdf) {
			case 0;
				echo ("<title>$judul</title>");
				echo ($html);
				break;

			case 1;

				// $this->m_fungsi->newMpdf($judul, '', $html, 10, 3, 3, 3, 'L', 'TT', $bln_judul.'.pdf');

				$this->m_fungsi->_mpdf_hari($position, 'A4', $judul, $html, $judul.'.pdf', 5, 5, 5, 10);
				break;

				
				
			case 2;
				header("Cache-Control: no-cache, no-store, must-revalidate");
				header("Content-Type: application/vnd-ms-excel");
				header("Content-Disposition: attachment; filename= $judul.xls");
				$this->load->view('Master/master_cetak', $data);
				break;
		}
	}

	function cetak_penggunaan_bahan()
	{
		$bulan    = $_GET['bulan'];
		$jns_data = $_GET['jns_data'];
		$cekpdf   = $_GET['ctk'];
		// $cekpdf   = 0;
		$position = 'L';

		if($bulan)
		{
			$bln_thn = explode('-',$bulan);
			$tahun   = $bln_thn[0];
			$blnn    = $bln_thn[1];
		}else{
			$tahun   = date('Y');
			$blnn    = date('m');
		}
		
			
		if($jns_data == 'box')
		{
			$judul1 = 'BOX';
			$query_detail = $this->db->query("SELECT *, f.berat_bersih ,
				r.hasil*f.berat_bersih as tonase,
				round(r.hasil*f.berat_bersih/0.7) as bahan 
				
				from(
SELECT a.no_invoice,a.nm_perusahaan, c.id_hub,d.nm_hub,a.bank,a.tgl_invoice,b.nm_ker,b.no_po,b.type,
				b.qty,b.retur_qty,b.hasil,b.harga,a.pajak, 
				(
				select hrg_bhn from (
				select * from (
				select b.kode_po,a.hrg_bhn from trs_po_bhnbk a
				join trs_po_bhnbk_detail b on a.no_po_bhn=b.no_po_bhn
				group by b.kode_po,a.hrg_bhn desc
				)bhn group by kode_po
				)bhn where bhn.kode_po = c.kode_po) as harga_bahan,
				(select e.id_produk from trs_po_detail e where b.no_po=e.kode_po and b.id_produk_simcorr=e.id_produk)id_produk
				from invoice_header a 
				join invoice_detail b on a.no_invoice=b.no_invoice
				join trs_po c on b.no_po=c.kode_po
				join m_hub d on c.id_hub=d.id_hub
				-- join trs_po_detail e on b.no_po=e.kode_po and e.id_produk=b.id_produk_simcorr
				-- join m_produk f on e.id_produk=f.id_produk
				where a.type in ('box','sheet') and YEAR(tgl_invoice) ='$tahun' and MONTH(tgl_invoice) ='$blnn' and c.id_hub not in ('7')
				)r
				join m_produk f on r.id_produk=f.id_produk
				order by r.id_hub,r.tgl_invoice,r.no_invoice ");
		}else{
			$judul1 = 'LAMINASI';
			$query_detail = $this->db->query("SELECT no_invoice,nm_pelanggan_lm,id_hub,nm_hub,tgl_invoice,nm_produk_lm,no_po_lm, qty_ok as qty,retur_qty as retur_qty,
			qty_ok-retur_qty as qty_fix_pack,
			(qty_ok-retur_qty)/(case when jenis_qty_lm='pack' then pack_lm else ikat_lm end)qty_bal,
			(qty_ok-retur_qty)/(case when jenis_qty_lm='pack' then pack_lm else ikat_lm end)*50 as tonase,
			round( (qty_ok-retur_qty)/(case when jenis_qty_lm='pack' then pack_lm else ikat_lm end)*50/0.75 )as bahan_Kg,
			(
			select hrg_bhn from (
			select * from (
			select b.kode_po,a.hrg_bhn from trs_po_bhnbk a
			join trs_po_bhnbk_detail b on a.no_po_bhn=b.no_po_bhn
			group by b.kode_po,a.hrg_bhn desc
			)bhn group by kode_po
			)bhn where bhn.kode_po = p.no_po_lm) as harga_bahan
			FROM(

			SELECT a.no_invoice,a.tgl_invoice,g.nm_pelanggan_lm,h.id_hub,h.nm_hub,d.*,e.*,f.no_po_lm,c.hitung, d.qty_muat*(case when jenis_qty_lm='pack' then e.pack_lm else ikat_lm end) as qty_ok, b.retur_qty,f.harga_pori_lm
			FROM invoice_laminasi_header a 
			join invoice_laminasi_detail b ON a.no_surat=b.no_surat AND a.no_invoice=b.no_invoice
			left join ( select no_invoice,sum(hitung)hitung from invoice_laminasi_disc group by no_invoice ) c ON a.no_invoice=c.no_invoice
			JOIN m_rk_laminasi d ON b.id_rk_lm=d.id
			JOIN m_produk_lm e ON b.id_produk_lm=e.id_produk_lm
			JOIN trs_po_lm_detail f ON b.id_po_dtl=f.id
			JOIN m_pelanggan_lm g ON g.id_pelanggan_lm=a.id_pelanggan_lm
			JOIN m_hub h ON h.id_hub=a.bank
			WHERE (h.id_hub!='7' AND h.id_hub!='0') AND MONTH(a.tgl_surat_jalan) in ($blnn) AND YEAR(a.tgl_surat_jalan) in ($tahun) and a.jenis_lm='PPI'
			-- GROUP BY a.tgl_surat_jalan,a.no_surat,a.no_invoice 
			)p
			order by id_hub,p.tgl_invoice,no_invoice");
		}

		$bln_judul = $this->m_fungsi->getBulan($blnn) ;
		$judul    = 'REKAP PENGGUNAAN BAHAN BAKU '.$judul1.' ('.$bln_judul.' - '.$tahun.' )';
		
		$html = '';

		$html .= '
			 <table style="border-collapse:collapse;font-family: Tahoma; font-size:11px" width="100%" align="center" border="0" cellspacing="1" cellpadding="3">
				  <tr>
					   <td colspan="20" width="15%" style="text-align:center; font-size:20px;"><b>REKAP PENGGUNAAN BAHAN BAKU <br> '.$judul1 .' <br>('.$bln_judul.' - '.$tahun.' )</b></td>
				  </tr>
			 </table>';

		$html .= '<br>';

		if ($query_detail->num_rows() > 0) 
		{
			if($jns_data == 'box')
			{				
				$html .= '<table width="100%" border="1" cellspacing="1" cellpadding="3" style="border-collapse:collapse;font-size:12px;font-family: ;">
				<tr style="background-color: #cccccc">
					<th style="text-align: center;">No </th>
					<th style="text-align: center;">No Invoice </th>
					<th style="text-align: center;">Nm Perusahaan </th>
					<th style="text-align: center;">Id Hub </th>
					<th style="text-align: center;">Nm Hub </th>
					<th style="text-align: center;">Bank </th>
					<th style="text-align: center;">Tgl Invoice </th>
					<th style="text-align: center;">Nm Ker </th>
					<th style="text-align: center;">No Po </th>
					<th style="text-align: center;">Type </th>
					<th style="text-align: center;">Qty </th>
					<th style="text-align: center;">Retur Qty </th>
					<th style="text-align: center;">Hasil </th>
					<th style="text-align: center;">Harga </th>
					<th style="text-align: center;">Pajak </th>
					<th style="text-align: center;">Berat Bersih </th>
					<th style="text-align: center;">Tonase </th>
					<th style="text-align: center;">Bahan </th>
					<th style="text-align: center;">Harga Bahan </th>
				</tr>';

				$no=1;
				foreach ($query_detail->result() as $r) 
				{
					$html .= '<tr>
							<td align="center">'.$no.'</td>
							<td align="">'.$r->no_invoice.'</td> 
							<td align="">'.$r->nm_perusahaan.'</td> 
							<td align="">'.$r->id_hub.'</td> 
							<td align="">'.$r->nm_hub.'</td> 
							<td align="">'.$r->bank.'</td> 
							<td align="">'.$r->tgl_invoice.'</td> 
							<td align="">'.$r->nm_ker.'</td> 
							<td align="">'.$r->no_po.'</td> 
							<td align="">'.$r->type.'</td> 
							<td align="">'.$r->qty.'</td> 
							<td align="">'.$r->retur_qty.'</td> 
							<td align="">'.$r->hasil.'</td> 
							<td align="">'.$r->harga.'</td> 
							<td align="">'.$r->pajak.'</td> 
							<td align="">'.$r->berat_bersih.'</td> 
							<td align="">'.$r->tonase.'</td> 
							<td align="">'.$r->bahan.'</td> 
							<td align="">'.$r->harga_bahan.'</td> 
						</tr>';

						$no++;
				}
				$html .= '</table>';
			}else{
				
				$html .= '<table width="100%" border="1" cellspacing="1" cellpadding="3" style="border-collapse:collapse;font-size:12px;font-family: ;">
				<tr style="background-color: #cccccc">
					<th style="text-align: center;">No</th>
					<th style="text-align: center;">No Invoice  </th>
					<th style="text-align: center;">Nm Pelanggan Lm  </th>
					<th style="text-align: center;">Id Hub  </th>
					<th style="text-align: center;">Nm Hub  </th>
					<th style="text-align: center;">Tgl Invoice  </th>
					<th style="text-align: center;">Nm Produk Lm  </th>
					<th style="text-align: center;">No Po Lm  </th>
					<th style="text-align: center;">Qty  </th>
					<th style="text-align: center;">Retur Qty  </th>
					<th style="text-align: center;">Qty Fix Pack  </th>
					<th style="text-align: center;">Qty Bal  </th>
					<th style="text-align: center;">Tonase  </th>
					<th style="text-align: center;">Bahan Kg  </th>
					<th style="text-align: center;">Harga Bahan  </th>
				</tr>';

				$no=1;
				foreach ($query_detail->result() as $r) 
				{
					$html .= '<tr>
							<td align="center">'.$no.'</td>
							<td align="">'.$r->no_invoice.'</td>
							<td align="">'.$r->nm_pelanggan_lm.'</td>
							<td align="">'.$r->id_hub.'</td>
							<td align="">'.$r->nm_hub.'</td>
							<td align="">'.$r->tgl_invoice.'</td>
							<td align="">'.$r->nm_produk_lm.'</td>
							<td align="">'.$r->no_po_lm.'</td>
							<td align="">'.$r->qty.'</td>
							<td align="">'.$r->retur_qty.'</td>
							<td align="">'.$r->qty_fix_pack.'</td>
							<td align="">'.number_format($r->qty_bal, 0, ",", ".").'</td>
							<td align="">'.$r->tonase.'</td>
							<td align="">'.$r->bahan_Kg.'</td>
							<td align="">'.number_format($r->harga_bahan, 0, ",", ".").'</td>
						</tr>';

						$no++;
				}
				$html .= '</table>';
			}

		} else {
			$html .= '<h1> Data Kosong </h1>';
		}

		// $this->m_fungsi->_mpdf($html);
		// $this->m_fungsi->template_kop('REKAP INVOICE PENJUALAN <br>('.$bln_judul.' - '.$tahun.' )','-',$html,'L','1');
		
		$data['prev'] = $html;

		switch ($cekpdf) {
			case 0;
				echo ("<title>$judul</title>");
				echo ($html);
				break;

			case 1;

				// $this->m_fungsi->newMpdf($judul, '', $html, 10, 3, 3, 3, 'L', 'TT', $bln_judul.'.pdf');

				$this->m_fungsi->_mpdf_hari($position, 'A4', $judul, $html, $judul.'.pdf', 5, 5, 5, 10);
				break;

				
				
			case 2;
				header("Cache-Control: no-cache, no-store, must-revalidate");
				header("Content-Type: application/vnd-ms-excel");
				header("Content-Disposition: attachment; filename= $judul.xls");
				$this->load->view('Master/master_cetak', $data);
				break;
		}
	}
	

}
