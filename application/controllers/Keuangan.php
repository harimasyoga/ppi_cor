<?php
defined('BASEPATH') or exit('No direct script access allowed');
 
class Keuangan extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('status') != "login") {
			redirect(base_url("Login"));
		}
		$this->load->model('m_master');
		$this->load->model('m_laporan');
		$this->load->model('m_fungsi');
	}

	public function jurnal()
	{
		$data = array(
			'judul' => "Laporan Jurnal",
		);
		$this->load->view('header', $data);
		$this->load->view('Keuangan/v_jurnal');
		$this->load->view('footer');
	}

	public function bukbes()
	{
		$data = array(
			'judul' => "Laporan Buku Besar",
		);
		$this->load->view('header', $data);
		$this->load->view('Keuangan/v_bukbes');
		$this->load->view('footer');
	}
	
	public function lr()
	{
		$data = array(
			'judul' => "Laporan Laba Rugi",
		);
		$this->load->view('header', $data);
		$this->load->view('Keuangan/v_lr');
		$this->load->view('footer');
	}
	
	public function neraca()
	{
		$data = array(
			'judul' => "Laporan Neraca",
		);
		$this->load->view('header', $data);
		$this->load->view('Keuangan/v_neraca');
		$this->load->view('footer');
	}

	function load_data()
	{
		$jenis        = $this->uri->segment(3);
		$data         = array();

		if ($jenis == "Jurnal") {
			$query = $this->db->query("SELECT * FROM jurnal_d order by id_jurnal")->result();

			$i               = 1;
			foreach ($query as $r) {

				$row = array();
				$row[] = '<div class="text-center">'.$i.'</div>';
				$row[] = '<div class="text-center">'.$r->no_voucher.'</div>';
				$row[] = '<div class="text-center">'.$this->m_fungsi->tanggal_ind(substr($r->tgl_input,0,10)).'</div>';
				$row[] = '<div class="text-center">'.$r->jam_input.'</div>';
				$row[] = '<div class="text-center">'.$r->no_transaksi.'</div>';
				$row[] = '<div class="text-center">'.$this->m_fungsi->tanggal_ind(substr($r->tgl_transaksi,0,10)).'</div>';
				$row[] = '<div class="text-center">'.$r->kode_rek.'</div>';
				$row[] = '<div class="text-center">'.cari_rek($r->kode_rek).'</div>';
				$row[] = '<div class="text-center">'.number_format($r->debet, 0, ",", ".").'</div>';
				$row[] = '<div class="text-center">'.number_format($r->kredit, 0, ",", ".").'</div>';
				$row[] = '<div class="text-center">'.$r->ket .'</div>';
				$data[] = $row;

				$i++;
			}
		}else if ($jenis == "bukbes") {
			$query = $this->db->query("SELECT * FROM jurnal_d where kode_rek in ('1.01.02.01' ',1.01.03' ',1.01.05' ',1.01.06' ',2.01.01' ',2.01.03.01' ',2.01.03.02' ',3.01' ',4.01' ',4.03' ',5.01' ',5.04' ',6.05' ',6.37') order by kode_rek,id_jurnal")->result();

			$i               = 1;
			foreach ($query as $r) {

				$row = array();
				$row[] = '<div class="text-center">'.$i.'</div>';
				$row[] = '<div class="text-center">'.$this->m_fungsi->tanggal_ind(substr($r->tgl_input,0,10)).'</div>';
				$row[] = '<div class="text-center">'.$r->no_voucher.'</div>';$row[] = '<div class="text-center">'.$r->kode_rek.'</div>';
				$row[] = '<div class="text-center">'.cari_rek($r->kode_rek).'</div>';
				$row[] = '<div class="text-center">'.number_format($r->debet, 0, ",", ".").'</div>';
				$row[] = '<div class="text-center">'.number_format($r->kredit, 0, ",", ".").'</div>';
				$row[] = '<div class="text-center">'.$r->ket .'</div>';
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

	function load_bubes()
	{ //

		$nrc_header = $this->db->query("SELECT kode_rek from jurnal_d group by kode_rek order by kode_rek ");

		$html ='';
		$i         = 0;
		$cek_rek   = '';
		foreach($nrc_header->result() as $header){
			$html .='<table class="table table-bordered table-striped table-scrollable" width="100%">
			<thead class="color-tabel">
				<tr>
					<th style="text-align: center;">No</th>
					<th style="text-align: center;">Tanggal</th>
					<th style="text-align: center;">No Voucher</th>
					<th style="text-align: center;">Kode Rek</th>
					<th style="text-align: center;">Nama Rek</th>
					<th style="text-align: center;">Debit</th>
					<th style="text-align: center;">Kredit</th>
					<th style="text-align: center;">saldo</th>
				</tr>
			</thead>
			<tbody>';

				$nrc = $this->db->query("SELECT* from jurnal_d where kode_rek='$header->kode_rek' order by kode_rek");

				$i        = 0;
				$hitung   = 0;
				foreach($nrc->result() as $r){
					$i++;				
					$hitung   += $r->debet - $r->kredit;
					$html .='
					<tr>
						<td style="font-weight: bold;">'.$i.'</td>
						<td style="font-weight: bold;">'.$r->tgl_transaksi.'</td>
						<td style="font-weight: bold;">'.$r->no_voucher.'</td>
						<td style="font-weight: bold;text-align:center" >'.$r->kode_rek.'</td>
						<td style="font-weight: bold;">'.cari_rek($r->kode_rek).'</td>
						<td style="font-weight: bold;text-align:right">Rp ' . number_format($r->debet, 0, ",", ".") . '</td>
						<td style="font-weight: bold;text-align:right">Rp ' . number_format($r->kredit, 0, ",", ".") . '</td>
						<td style="font-weight: bold;text-align:right">Rp ' . number_format($hitung, 0, ",", ".") . '</td>
					</tr>';
					
				}
		}
		$html .= '</tbody></table>';

		echo json_encode([
			'html_dtl' => $html,
		]);
	}

	function load_lr()
	{ //

		$lr_dtl = $this->db->query("SELECT LENGTH(p.kd)length,p.* FROM(
			select kd_akun as kd,nm_akun as nm,jenis,dk,(select sum(debet) from jurnal_d where left(kode_rek,1)=kd_akun)nominal from m_kode_akun
			union all
			select concat(kd_akun,'.',kd_kelompok) as kd,nm_kelompok as nm,jenis,dk,(select sum(debet) from jurnal_d where left(kode_rek,4)=concat(kd_akun,'.',kd_kelompok))nominal from m_kode_kelompok 
			 )p
			 where jenis='lr'
			 order by kd");

		$html ='';
		$html .='<table class="table table-bordered table-striped table-scrollable" width="100%">
		<thead class="color-tabel">
			<tr>
				<th style="text-align: center;">Kode Rek</th>
				<th style="text-align: center;">Nama Akun</th>
				<th style="text-align: center;"> MARET 2024</th>
			</tr>
		</thead>';
			$i = 0;
			foreach($lr_dtl->result() as $r){
				$i++;
				$html .='<tbody>';

				if($r->length=='1')
				{
					$html .='
					<tr>
						<td style="font-weight: bold;">'.$r->kd.'</td>
						<td style="font-weight: bold;">'.cari_rek($r->kd).'</td>					
						<td style="font-weight: bold;text-align:right">Rp ' . number_format($r->nominal, 0, ",", ".") . '</td>
					</tr>';
				}else{
					$html .='
					<tr>
						<td style="">&nbsp;&nbsp;&nbsp;&nbsp;'.$r->kd.'</td>
						<td style="">&nbsp;&nbsp;&nbsp;&nbsp;'.cari_rek($r->kd).'</td>					
						<td style="text-align:right">Rp ' . number_format($r->nominal, 0, ",", ".") . '</td>
					</tr>';

				}

				
				$html .='</tbody>';
				
			}
		$html .= '</table>';

		echo json_encode([
			'html_dtl' => $html,
		]);
	}
	
	function load_neraca()
	{ //

		$nrc = $this->db->query("SELECT LENGTH(p.kd)length,p.* FROM(
			select kd_akun as kd,nm_akun as nm,jenis,dk,(select sum(debet) from jurnal_d where left(kode_rek,1)=kd_akun)nominal from m_kode_akun
			union all
			select concat(kd_akun,'.',kd_kelompok) as kd,nm_kelompok as nm,jenis,dk,(select sum(debet) from jurnal_d where left(kode_rek,4)=concat(kd_akun,'.',kd_kelompok))nominal from m_kode_kelompok 
       union all
       select concat(kd_akun,'.',kd_kelompok,'.',kd_jenis) as kd,nm_jenis as nm,jenis,dk,(select sum(debet) from jurnal_d where left(kode_rek,7)=concat(kd_akun,'.',kd_kelompok,'.',kd_jenis))nominal from m_kode_jenis
			union all
			select concat(kd_akun,'.',kd_kelompok,'.',kd_jenis,'.',kd_rinci) as kd,nm_rinci as nm,jenis,dk,(select sum(debet) from jurnal_d where left(kode_rek,10)=concat(kd_akun,'.',kd_kelompok,'.',kd_jenis,'.',kd_rinci))nominal from m_kode_rinci
			 )p
			 where jenis='Neraca'
			 order by kd");

		$html ='';
		$html .='<table class="table table-bordered table-striped table-scrollable" width="100%">
		<thead class="color-tabel">
			<tr>
				<th style="text-align: center;">Kode Rek</th>
				<th style="text-align: center;">Nama Akun</th>
				<th style="text-align: center;"> MARET 2024</th>
			</tr>
		</thead>';
			$i = 0;
			foreach($nrc->result() as $r){
				$i++;
				$html .='<tbody>';

				if($r->length=='1')
				{
					$html .='
					<tr>
						<td style="font-weight: bold;">'.$r->kd.'</td>
						<td style="font-weight: bold;">'.cari_rek($r->kd).'</td>					
						<td style="font-weight: bold;text-align:right">Rp ' . number_format($r->nominal, 0, ",", ".") . '</td>
					</tr>';
				}else{
					$html .='
					<tr>
						<td style="">&nbsp;&nbsp;&nbsp;&nbsp;'.$r->kd.'</td>
						<td style="">&nbsp;&nbsp;&nbsp;&nbsp;'.cari_rek($r->kd).'</td>					
						<td style="text-align:right">Rp ' . number_format($r->nominal, 0, ",", ".") . '</td>
					</tr>';

				}

				
				$html .='</tbody>';
				
			}
		$html .= '</table>';

		echo json_encode([
			'html_dtl' => $html,
		]);
	}

	function cetak_jurnal()
	{
		$no_stok  = $_GET['no_stok'];

        $query_header = $this->db->query("SELECT * FROM jurnal_d order by id_jurnal ");
        
        $data = $query_header->row();
        
        $query_detail = $this->db->query("SELECT * FROM jurnal_d order by id_jurnal ");

		$html = '';
		$html .= '<br>';

		if ($query_header->num_rows() > 0) 
		{

			$html .= '<table width="100%" border="1" cellspacing="1" cellpadding="3" style="border-collapse:collapse;font-size:12px;font-family: ;">
                        <tr style="background-color: #cccccc">
							<Th Align="Center">No</Th>
							<Th Align="Center">No Voucher</Th>
							<Th Align="Center">Tgl Input</Th>
							<Th Align="Center">Jam Input</Th>
							<Th Align="Center">No Transaksi</Th>
							<Th Align="Center">Tgl Transaksi</Th>
							<Th Align="Center">Kode Rek</Th>
							<Th Align="Center">Nama Rek</Th>
							<Th Align="Center">Debet</Th>
							<Th Align="Center">Kredit</Th>
							<Th Align="Center">Ket</Th>
						</tr>';
			
			$no=1;
			foreach ($query_detail->result() as $r) 
			{
				$html .= '<tr>
						<td align="center">'.$no.'</td>
						<td align="center">' . $r->no_voucher . '</td>
						<td align="center">'.$this->m_fungsi->tanggal_ind(substr($r->tgl_input,0,10)).'</td>
						<td align="center">' . $r->jam_input . '</td>
						<td align="center">' . $r->no_transaksi . '</td>
						<td align="center">'.$this->m_fungsi->tanggal_ind(substr($r->tgl_transaksi,0,10)).'</td>
						<td align="left">' . $r->kode_rek . '</td>
						<td align="left" style="text-transform:capitalize;">' . cari_rek($r->kode_rek) . '</td> 
						<td align="right">Rp ' . number_format($r->debet, 0, ",", ".") . '</td>
						<td align="right">Rp ' . number_format($r->kredit, 0, ",", ".") . '</td>
						<td align="left">' . $r->ket . '</td>
					</tr>';

					$no++;
			}
			$html .= '
                 </table>';
		} else {
			$html .= '<h1> Data Kosong </h1>';
		}

		// $this->m_fungsi->_mpdf($html);
		$this->m_fungsi->template_kop('JURNAL UMUM','-',$html,'L','1');
		// $this->m_fungsi->mPDFP($html);
	}
	
	function cetak_lr()
	{
		// $no_stok  = $_GET['no_stok'];

        $query_header = $this->db->query("SELECT LENGTH(p.kd)length,p.* FROM(
			select kd_akun as kd,nm_akun as nm,jenis,dk,(select sum(debet) from jurnal_d where left(kode_rek,1)=kd_akun)nominal from m_kode_akun
			union all
			select concat(kd_akun,'.',kd_kelompok) as kd,nm_kelompok as nm,jenis,dk,(select sum(debet) from jurnal_d where left(kode_rek,4)=concat(kd_akun,'.',kd_kelompok))nominal from m_kode_kelompok 
			 )p
			 where jenis='lr'
			 order by kd");
        
        $data = $query_header->row();
        
        $query_detail = $this->db->query("SELECT LENGTH(p.kd)length,p.* FROM(
			select kd_akun as kd,nm_akun as nm,jenis,dk,(select sum(debet) from jurnal_d where left(kode_rek,1)=kd_akun)nominal from m_kode_akun
			union all
			select concat(kd_akun,'.',kd_kelompok) as kd,nm_kelompok as nm,jenis,dk,(select sum(debet) from jurnal_d where left(kode_rek,4)=concat(kd_akun,'.',kd_kelompok))nominal from m_kode_kelompok 
			 )p
			 where jenis='lr'
			 order by kd");

		$html = '';
		$html .= '<br>';

		if ($query_header->num_rows() > 0) 
		{

			$html .= '<table border="1" cellspacing="1" cellpadding="3" style="border-collapse:collapse;font-size:14px;font-family: ;" width="100%">
			<thead class="color-tabel">
				<tr style="background-color: #cccccc">
					<th style="text-align: center;">Kode Rek</th>
					<th style="text-align: center;">Nama Akun</th>
					<th style="text-align: center;"> MARET 2024</th>
				</tr>
			</thead>
			<tbody>';
			
			$no=0;
			foreach ($query_detail->result() as $r) 
			{
				$no++;
				if($r->length=='1')
				{
					$html .='
					<tr>
						<td style="font-weight: bold;">'.$r->kd.'</td>
						<td style="font-weight: bold;">'.cari_rek($r->kd).'</td>					
						<td style="font-weight: bold;text-align:right">Rp ' . number_format($r->nominal, 0, ",", ".") . '</td>
					</tr>';
				}else{
					$html .='
					<tr>
						<td style="">&nbsp;&nbsp;&nbsp;&nbsp;'.$r->kd.'</td>
						<td style="" style="text-transform:capitalize;">&nbsp;&nbsp;&nbsp;&nbsp;'.cari_rek($r->kd).'</td>					
						<td style="text-align:right">Rp ' . number_format($r->nominal, 0, ",", ".") . '</td>
					</tr>';

				}
				
				$no++;
			}
			$html .= '</tbody>
                 </table>';
		} else {
			$html .= '<h1> Data Kosong </h1>';
		}

		// echo($html);
		$this->m_fungsi->template_kop('LAPORAN LABA RUGI','-',$html,'P','1');
	}
	
	function cetak_nrc()
	{
		// $no_stok  = $_GET['no_stok'];

        $query_header = $this->db->query("SELECT LENGTH(p.kd)length,p.* FROM(
			select kd_akun as kd,nm_akun as nm,jenis,dk,(select sum(debet) from jurnal_d where left(kode_rek,1)=kd_akun)nominal from m_kode_akun
			union all
			select concat(kd_akun,'.',kd_kelompok) as kd,nm_kelompok as nm,jenis,dk,(select sum(debet) from jurnal_d where left(kode_rek,4)=concat(kd_akun,'.',kd_kelompok))nominal from m_kode_kelompok 
       union all
       select concat(kd_akun,'.',kd_kelompok,'.',kd_jenis) as kd,nm_jenis as nm,jenis,dk,(select sum(debet) from jurnal_d where left(kode_rek,7)=concat(kd_akun,'.',kd_kelompok,'.',kd_jenis))nominal from m_kode_jenis
			union all
			select concat(kd_akun,'.',kd_kelompok,'.',kd_jenis,'.',kd_rinci) as kd,nm_rinci as nm,jenis,dk,(select sum(debet) from jurnal_d where left(kode_rek,10)=concat(kd_akun,'.',kd_kelompok,'.',kd_jenis,'.',kd_rinci))nominal from m_kode_rinci
			 )p
			 where jenis='Neraca'
			 order by kd");
        
        $data = $query_header->row();
        
        $query_detail = $this->db->query("SELECT LENGTH(p.kd)length,p.* FROM(
			select kd_akun as kd,nm_akun as nm,jenis,dk,(select sum(debet) from jurnal_d where left(kode_rek,1)=kd_akun)nominal from m_kode_akun
			union all
			select concat(kd_akun,'.',kd_kelompok) as kd,nm_kelompok as nm,jenis,dk,(select sum(debet) from jurnal_d where left(kode_rek,4)=concat(kd_akun,'.',kd_kelompok))nominal from m_kode_kelompok 
       union all
       select concat(kd_akun,'.',kd_kelompok,'.',kd_jenis) as kd,nm_jenis as nm,jenis,dk,(select sum(debet) from jurnal_d where left(kode_rek,7)=concat(kd_akun,'.',kd_kelompok,'.',kd_jenis))nominal from m_kode_jenis
			union all
			select concat(kd_akun,'.',kd_kelompok,'.',kd_jenis,'.',kd_rinci) as kd,nm_rinci as nm,jenis,dk,(select sum(debet) from jurnal_d where left(kode_rek,10)=concat(kd_akun,'.',kd_kelompok,'.',kd_jenis,'.',kd_rinci))nominal from m_kode_rinci
			 )p
			 where jenis='Neraca'
			 order by kd");

		$html = '';
		$html .= '<br>';

		if ($query_header->num_rows() > 0) 
		{

			$html .= '<table border="1" cellspacing="1" cellpadding="3" style="border-collapse:collapse;font-size:14px;font-family: ;" width="100%">
			<thead class="color-tabel">
				<tr style="background-color: #cccccc">
					<th style="text-align: center;">Kode Rek</th>
					<th style="text-align: center;">Nama Akun</th>
					<th style="text-align: center;"> MARET 2024</th>
				</tr>
			</thead>
			<tbody>';
			
			$no=0;
			foreach ($query_detail->result() as $r) 
			{
				$no++;
				if($r->length=='1')
				{
					$html .='
					<tr>
						<td style="font-weight: bold;">'.$r->kd.'</td>
						<td style="font-weight: bold;">'.cari_rek($r->kd).'</td>					
						<td style="font-weight: bold;text-align:right">Rp ' . number_format($r->nominal, 0, ",", ".") . '</td>
					</tr>';
				}else if($r->length=='4')
				{
					$html .='
					<tr>
						<td style="font-weight: bold;">&nbsp;&nbsp;&nbsp;&nbsp;'.$r->kd.'</td>
						<td style="font-weight: bold;text-transform:capitalize;">&nbsp;&nbsp;&nbsp;&nbsp;'.cari_rek($r->kd).'</td>					
						<td style="font-weight: bold;text-align:right">Rp ' . number_format($r->nominal, 0, ",", ".") . '</td>
					</tr>';
				}else{
					$html .='
					<tr>
						<td style="">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$r->kd.'</td>
						<td style="" style="text-transform:capitalize;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.cari_rek($r->kd).'</td>					
						<td style="text-align:right">Rp ' . number_format($r->nominal, 0, ",", ".") . '</td>
					</tr>';

				}
				
				$no++;
			}
			$html .= '</tbody>
                 </table>';
		} else {
			$html .= '<h1> Data Kosong </h1>';
		}

		// echo($html);
		$this->m_fungsi->template_kop('LAPORAN NERACA','-',$html,'P','1');
	}
	
	function cetak_bukbes()
	{
		// $no_stok  = $_GET['no_stok'];
		
		$html = '';
		$html .= '<br>';

        $query_header = $this->db->query("SELECT kode_rek from jurnal_d group by kode_rek order by tgl_input asc,kode_rek");
        
        $data = $query_header->row();

		if ($query_header->num_rows() > 0) 
		{
			foreach ($query_header->result() as $header) 
			{        
				$query_detail = $this->db->query("SELECT kode_rek from jurnal_d where kode_rek='$header->kode_rek' order by tgl_input asc,kode_rek");

					$html .= '<table border="1" cellspacing="1" cellpadding="3" style="border-collapse:collapse;font-size:14px;font-family: ;" width="100%">
					<thead class="color-tabel">
						<tr style="background-color: #cccccc">
							<th style="text-align: center;">No</th>
							<th style="text-align: center;">Tanggal</th>
							<th style="text-align: center;">No Voucher</th>
							<th style="text-align: center;">Kode Rek</th>
							<th style="text-align: center;">Nama Rek</th>
							<th style="text-align: center;">Debit</th>
							<th style="text-align: center;">Kredit</th>
							<th style="text-align: center;">saldo</th>
						</tr>
					</thead>
					<tbody>';
					
					$nrc = $this->db->query("SELECT* from jurnal_d where kode_rek='$header->kode_rek' order by kode_rek");

					$i        = 0;
					$hitung   = 0;
					foreach($nrc->result() as $r){
						$i++;				
						$hitung   += $r->debet - $r->kredit;
						$html .='
						<tr>
							<td style="font-weight: bold;">'.$i.'</td>
							<td style="font-weight: bold;">'.$r->tgl_transaksi.'</td>
							<td style="font-weight: bold;">'.$r->no_voucher.'</td>
							<td style="font-weight: bold;text-align:center" >'.$r->kode_rek.'</td>
							<td style="font-weight: bold;">'.cari_rek($r->kode_rek).'</td>
							<td style="font-weight: bold;text-align:right">Rp ' . number_format($r->debet, 0, ",", ".") . '</td>
							<td style="font-weight: bold;text-align:right">Rp ' . number_format($r->kredit, 0, ",", ".") . '</td>
							<td style="font-weight: bold;text-align:right">Rp ' . number_format($hitung, 0, ",", ".") . '</td>
						</tr>';
					}
					$html .= '</tbody>
						</table>
						<br>';
				
			}

		} else {
			$html .= '<h1> Data Kosong </h1>';
		}

		// echo($html);
		$this->m_fungsi->template_kop('LAPORAN BUKU BESAR','-',$html,'L','1');
	}


}