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
		$this->load->model('m_keuangan');
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

	public function jurnal_u()
	{
		$data = array(
			'judul' => "Jurnal Umum",
		);
		$this->load->view('header', $data);
		$this->load->view('Keuangan/v_ju');
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

	function insert_ju()
	{
		if($this->session->userdata('username'))
		{ 
			$result = $this->m_keuangan->save_ju();
			echo json_encode($result);
		}
		
	}

	function load_rek()
    {
        $query = load_rek()->result();

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

	function load_data()
	{
		$jenis        = $this->uri->segment(3);
		$data         = array();

		if ($jenis == "Jurnal") {

			$priode    = $_POST['priode'];
			$attn      = $_POST['id_hub'];
			$tgl_awal  = $_POST['tgl_awal'];
			$tgl_akhir = $_POST['tgl_akhir'];
			$tahun     = date('Y');
			$blnn      = date('m');

			if($attn=='' || $attn== null || $attn== 'null')
			{
				if($priode=='all')
				{
					$value="";
				}else if($priode=='now')
				{
					$value="and YEAR(a.tgl_transaksi) = '$tahun' and MONTH(a.tgl_transaksi) ='$blnn'";
				}else{
					$value="and a.tgl_transaksi BETWEEN  '$tgl_awal' and  '$tgl_akhir'";
				}

			}else{
				if($priode=='all')
				{
					$value="and b.id_hub='$attn' ";
				}else if($priode=='now')
				{
					$value="and b.id_hub='$attn' and YEAR(a.tgl_transaksi) = '$tahun' and MONTH(a.tgl_transaksi) ='$blnn'";
				}else{
					$value="and b.id_hub='$attn' and a.tgl_transaksi BETWEEN  '$tgl_awal' and  '$tgl_akhir'";
				}

			}
			
			$query = $this->db->query("SELECT * FROM jurnal_d a
			join m_hub b on a.id_hub=b.id_hub
			where b.id_hub <>'7' $value
			order by b.id_hub,id_jurnal")->result();

			$i               = 1;
			foreach ($query as $r) {

				$nm_rekk    = strtolower(cari_rek($r->kode_rek));
				$row        = array();
				$row[]      = '<div class="text-center">'.$i.'</div>';
				$row[]      = '<div class="text-center">'.$r->no_voucher.'</div>';
				$row[]      = '<div class="text-center">'.$r->nm_hub.'</div>';
				$row[]      = '<div class="text-center">'.$this->m_fungsi->tanggal_ind(substr($r->tgl_input,0,10)).'</div>';
				$row[]      = '<div class="text-center">'.$r->jam_input.'</div>';
				$row[]      = '<div class="text-center">'.$r->no_transaksi.'</div>';
				$row[]      = '<div class="text-center">'.$this->m_fungsi->tanggal_ind(substr($r->tgl_transaksi,0,10)).'</div>';
				$row[]      = '<div class="text-center">'.$r->kode_rek.'</div>';
				$row[]      = '<div class="text-left" style="text-transform:capitalize;">'.$nm_rekk.'</div>';
				$row[]      = '<div class="text-center">'.number_format($r->debet, 0, ",", ".").'</div>';
				$row[]      = '<div class="text-center">'.number_format($r->kredit, 0, ",", ".").'</div>';
				$row[]      = '<div class="text-center">'.$r->ket .'</div>';
				$data[]     = $row;

				$i++;
			}
		}else if ($jenis == "jur_umum") {
			
			$thn   = $_POST['thn'];
			$attn  = $_POST['id_hub'];

			if($attn=='')
			{
				$hub ="";
			}else{
				$hub ="and b.id_hub='$attn'";
			}

			
			$query = $this->db->query("SELECT no_voucher, tgl_transaksi,sum(debet)debet,sum(kredit)kredit,a.id_hub,b.nm_hub,ket from jurnal_d a
			JOIN m_hub b ON a.id_hub=b.id_hub
			where no_voucher like'%JURUM%' and YEAR(tgl_transaksi) = '$thn' $hub
			group by no_voucher, tgl_transaksi,a.id_hub,ket
			order by b.id_hub,tgl_transaksi desc")->result();

			$i               = 1;
			foreach ($query as $r) 
			{
				$no_voucher    = "'$r->no_voucher'";

				$row = array();
				$row[] = '<div class="text-center">'.$i.'</div>';
				$row[] = '<div class="text-center">'.$r->no_voucher.'</div>';
				$row[] = '<div class="text-center">'.$r->tgl_transaksi.'</div>';
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
		}else if ($jenis == "bukbes") {
			$query = $this->db->query("SELECT * FROM jurnal_d where kode_rek in ('1.01.02.01', '1.01.03', '1.01.05', '1.01.06', '2.01.01', '2.01.03.01', '2.01.04', '3.01', '4.01', '4.03', '5.01', '5.04', '6.05', '6.37') order by kode_rek,id_jurnal")->result();

			$i               = 1;
			foreach ($query as $r) {
				$nm_rekk    = strtolower(cari_rek($r->kode_rek));
				
				$row    = array();
				$row[]  = '<div class="text-center">'.$i.'</div>';
				$row[]  = '<div class="text-center">'.$this->m_fungsi->tanggal_ind(substr($r->tgl_input,0,10)).'</div>';
				$row[]  = '<div class="text-center">'.$r->no_voucher.'</div>';$row[] = '<div class="text-center">'.$r->kode_rek.'</div>';
				$row[]  = '<div class="text-left" style="text-transform:capitalize;">'.$nm_rekk.'</div>';
				$row[]  = '<div class="text-center">'.number_format($r->debet, 0, ",", ".").'</div>';
				$row[]  = '<div class="text-center">'.number_format($r->kredit, 0, ",", ".").'</div>';
				$row[]  = '<div class="text-center">'.$r->ket .'</div>';
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

		$priode       = $_POST['priode'];
		$attn         = $_POST['id_hub'];
		$tgl_awal     = $_POST['tgl_awal'];
		$tgl_akhir    = $_POST['tgl_akhir'];		
		$tahun        = date('Y');
		$blnn         = date('m');

		if($attn=='' || $attn== null || $attn== 'null')
		{
			if($priode=='all')
			{
				$value="";
			}else if($priode=='now')
			{
				$value="and YEAR(a.tgl_transaksi) = '$tahun' and MONTH(a.tgl_transaksi) ='$blnn'";
			}else{
				$value="and a.tgl_transaksi BETWEEN  '$tgl_awal' and  '$tgl_akhir'";
			}

		}else{
			if($priode=='all')
			{
				$value="and b.id_hub='$attn' ";
			}else if($priode=='now')
			{
				$value="and b.id_hub='$attn' ";
			}else{
				$value="and b.id_hub='$attn' and a.tgl_transaksi BETWEEN  '$tgl_awal' and  '$tgl_akhir'";
			}

		}
		
		$nrc_header = $this->db->query("SELECT kode_rek from jurnal_d a join m_hub b on a.id_hub=b.id_hub where b.id_hub <>'7' $value group by kode_rek order by kode_rek ");

		$html       = '';
		$i          = 0;
		$cek_rek    = '';
		foreach($nrc_header->result() as $header){
			$html .='<table class="table table-bordered table-striped table-scrollable" width="100%">
			<thead class="color-tabel">
				<tr>
					<th style="text-align: center;">No</th>
					<th style="text-align: center;">Tanggal</th>
					<th style="text-align: center;">No Voucher</th>
					<th style="text-align: center;">Hub</th>
					<th style="text-align: center;">Kode Rek</th>
					<th style="text-align: center;">Nama Rek</th>
					<th style="text-align: center;">Debit</th>
					<th style="text-align: center;">Kredit</th>
					<th style="text-align: center;">saldo</th>
				</tr>
			</thead>
			<tbody>';
			
				if($attn=='' || $attn== null || $attn== 'null')
				{
					if($priode=='all')
					{
						$union ="";
						$value2="and kode_rek='$header->kode_rek'";
					}else if($priode=='now')
					{
						$union ="";
						$value2="and kode_rek='$header->kode_rek' and YEAR(a.tgl_transaksi) = '$tahun' and MONTH(a.tgl_transaksi) ='$blnn'";
					}else{
						$union ="(SELECT 0 id_jurnal,b.id_hub,b.nm_hub,'$tgl_awal' tgl_transaksi,tgl_input,jam_input,'SALDO AWAL'no_voucher,''no_transaksi,kode_rek,sum(debet)debet,sum(kredit)kredit
						from jurnal_d a join m_hub b on a.id_hub=b.id_hub 
						where kode_rek='$header->kode_rek' and a.tgl_transaksi < '$tgl_awal' 
						GROUP BY b.id_hub,b.nm_hub,kode_rek)
						UNION ALL"; 
						$value2="and kode_rek='$header->kode_rek' and a.tgl_transaksi BETWEEN  '$tgl_awal' and  '$tgl_akhir'";
					}
		
				}else{
					if($priode=='all')
					{
						$union ="";
						$value2="and kode_rek='$header->kode_rek' and b.id_hub='$attn' ";
					}else if($priode=='now')
					{
						$union ="";
						$value2="and kode_rek='$header->kode_rek' and b.id_hub='$attn' and YEAR(a.tgl_transaksi) = '$tahun' and MONTH(a.tgl_transaksi) ='$blnn'";
					}else{
						$union ="(SELECT 0 id_jurnal,b.id_hub,b.nm_hub,'$tgl_awal' tgl_transaksi,tgl_input,jam_input,'SALDO AWAL'no_voucher,''no_transaksi,kode_rek,sum(debet)debet,sum(kredit)kredit
						from jurnal_d a join m_hub b on a.id_hub=b.id_hub 
						where kode_rek='$header->kode_rek' and b.id_hub='$attn' and a.tgl_transaksi < '$tgl_awal' 
						GROUP BY b.id_hub,b.nm_hub,kode_rek)
						UNION ALL";
						
						$value2="and kode_rek='$header->kode_rek' and b.id_hub='$attn' and a.tgl_transaksi BETWEEN  '$tgl_awal' and  '$tgl_akhir'";
					}
		
				}

				$nrc = $this->db->query("$union SELECT id_jurnal,b.id_hub,b.nm_hub,tgl_transaksi,tgl_input,jam_input,no_voucher,no_transaksi,kode_rek,debet,kredit from jurnal_d  a join m_hub b on a.id_hub=b.id_hub where b.id_hub<>'7' $value2 order by kode_rek,tgl_transaksi,id_jurnal");

				$i        = 0;
				$hitung   = 0;
				foreach($nrc->result() as $r){
					$i++;				
					$nm_rekk   = strtolower(cari_rek($r->kode_rek));
					$hitung    += $r->debet - $r->kredit;
					$html .='
					<tr>
						<td style="font-weight: bold;text-align:center" >'.$i.'</td>
						<td style="font-weight: bold;">'.$r->tgl_transaksi.'</td>
						<td style="font-weight: bold;">'.$r->no_voucher.'</td>
						<td style="font-weight: bold;">'.$r->nm_hub.'</td>
						<td style="font-weight: bold;text-align:center" >'.$r->kode_rek.'</td>
						<td style="font-weight: bold; text-transform:capitalize;" class="text-left">'.$nm_rekk.'</td>
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

		$attn         = $_POST['id_hub'];
		$blnn         = $_POST['blnn'];
		$thun         = $_POST['thun'];

		if($attn=='' || $attn== null || $attn== 'null')
		{
			if($blnn=='all')
			{
				$value            = "";
				$cek_bulan        = '';
				$where_bln_awal   = "and YEAR(tgl_transaksi)<'$thun' ";
				$where_bln        = "and YEAR(tgl_transaksi)='$thun' ";
			}else{
				// $value="where a.tgl_transaksi BETWEEN  '$tgl_awal' and  '$tgl_akhir'";
				$cek_bulan ="where id ='$blnn'";
				$where_bln_awal   = "and YEAR(tgl_transaksi)='$thun' and MONTH(tgl_transaksi) < ('$blnn') ";
				$where_bln        = "and YEAR(tgl_transaksi)='$thun' and MONTH(tgl_transaksi) in ('$blnn') ";
			}

		}else{
			if($blnn=='all')
			{
				$value            = "where b.id_hub='$attn' ";
				$cek_bulan        = '';
				$where_bln_awal   = "and id_hub='$attn' and YEAR(tgl_transaksi)<'$thun' ";
				$where_bln        = "and id_hub='$attn' and YEAR(tgl_transaksi)='$thun' ";
			}else{
				// $value="where b.id_hub='$attn' and a.tgl_transaksi BETWEEN  '$tgl_awal' and  '$tgl_akhir'";
				$cek_bulan        = "where id ='$blnn'";
				$where_bln_awal   = "and id_hub='$attn' and YEAR(tgl_transaksi)='$thun' and MONTH(tgl_transaksi) < ('$blnn') ";
				$where_bln        = "and id_hub='$attn' and YEAR(tgl_transaksi)='$thun' and MONTH(tgl_transaksi) in ('$blnn') ";
			}

		}
		
		$lr_dtl = load_lr2('LR');
		// $lr_dtl = load_lr('LR');

		$html ='';
		$html .='<table class="table table-bordered table-striped table-scrollable" width="100%">
		<thead class="color-tabel">
			<tr>
				<th style="text-align: center;">Kode Rek</th>
				<th style="text-align: center;">Nama Akun</th>
				<th style="text-align: center;">Saldo Awal</th>';

		$query_bln = $this->db->query("SELECT*FROM m_bulan $cek_bulan order by id");
		foreach($query_bln->result() as $bln){
			$html .=' <th style="text-align: center;"> '.$bln->bulan.' '.$thun.'</th>';
				
		}
		$html .='</tr>
			</thead>';

			$i         = 0;
			$nominal   = 0;
			$nom_awal  = 0;
			foreach($lr_dtl->result() as $r){
				$i++;
				$html .='<tbody>';
				$kode = str_replace("'",'',$r->kode_1);

				if($r->kode_1=='' || $r->kode_1 == null)
				{
					if($r->id=='5')
					{
						// total_jual_awal
						$total_jual_awal = total_penjualan('awal',$blnn,$bln->id,$thun,$attn);

						if($total_jual_awal->num_rows() > 0)
						{
							$nom_total_jual_awal = $total_jual_awal->row()->nominal;
							$nom_awal = 'Rp '.number_format($nom_total_jual_awal, 0, ",", ".");

						}else{
							$nom_awal = 'Rp '.number_format(0, 0, ",", ".");
						}
					}else if($r->id=='11')
					{
						// hp_penjualan_awal
						$hp_penjualan_awal = hp_penjualan('awal',$blnn,$bln->id,$thun,$attn);

						if($hp_penjualan_awal->num_rows() > 0)
						{
							$nom_hp_penjualan_awal = $hp_penjualan_awal->row()->nominal;
							$nom_awal = 'Rp '.number_format($nom_hp_penjualan_awal, 0, ",", ".");
						}else{
							$nom_awal = 'Rp '.number_format(0, 0, ",", ".");
						}
					}else if($r->id=='21')
					{
						// lr_kotor_awal
						$lr_kotor_awal = lr_kotor('awal',$blnn,$bln->id,$thun,$attn);

						if($lr_kotor_awal->num_rows() > 0)
						{
							$nom_lr_kotor_awal = $lr_kotor_awal->row()->nominal;
							$nom_awal = 'Rp '.number_format($nom_lr_kotor_awal, 0, ",", ".");
						}else{
							$nom_awal = 'Rp '.number_format(0, 0, ",", ".");
						}
					}else if($r->id=='62')
					{
						// jum_beban_awal
						$jum_beban_awal = jum_beban('awal',$blnn,$bln->id,$thun,$attn);

						if($jum_beban_awal->num_rows() > 0)
						{
							$nom_jum_beban_awal = $jum_beban_awal->row()->nominal;
							$nom_awal = 'Rp '.number_format($nom_jum_beban_awal, 0, ",", ".");
						}else{
							$nom_awal = 'Rp '.number_format(0, 0, ",", ".");
						}
					}else if($r->id=='63')
					{

						// lr_kotor_awal
						$lr_kotor_awal              = lr_kotor('awal',$blnn,$bln->id,$thun,$attn);
						if($lr_kotor_awal->num_rows() > 0)
						{
							$nom_lr_kotor_awal = $lr_kotor_awal->row()->nominal;
						}else{
							$nom_lr_kotor_awal = 0;
						}

						// jum_beban_awal
						$jum_beban_awal = jum_beban('awal',$blnn,$bln->id,$thun,$attn);
						if($jum_beban_awal->num_rows() > 0)
						{
							$nom_jum_beban_awal = $jum_beban_awal->row()->nominal;
						}else{
							$nom_jum_beban_awal = 0;
						}


						$nom_awal = 'Rp '.number_format($nom_lr_kotor_awal - $nom_jum_beban_awal, 0, ",", ".");


					}else if($r->id=='77')
					{
						// pll_awal
						$pll_awal = pll('awal',$blnn,$bln->id,$thun,$attn);

						if($pll_awal->num_rows() > 0)
						{
							$nom_pll_awal = $pll_awal->row()->nominal;
							$nom_awal = 'Rp '.number_format($nom_pll_awal, 0, ",", ".");
						}else{
							$nom_awal = 'Rp '.number_format(0, 0, ",", ".");
						}

					}else if($r->id=='78')
					{
						// lr_kotor_awal
						$lr_kotor_awal = lr_kotor('awal',$blnn,$bln->id,$thun,$attn);
						if($lr_kotor_awal->num_rows() > 0)
						{
							$nom_lr_kotor_awal = $lr_kotor_awal->row()->nominal;
						}else{
							$nom_lr_kotor_awal = 0;
						}

						// jum_beban_awal
						$jum_beban_awal              = jum_beban('awal',$blnn,$bln->id,$thun,$attn);
						if($jum_beban_awal->num_rows() > 0)
						{
							$nom_jum_beban_awal = $jum_beban_awal->row()->nominal;
						}else{
							$nom_jum_beban_awal = 0;
						}
						
						// pll_awal
						$pll_awal= pll('awal',$blnn,$bln->id,$thun,$attn);

						if($pll_awal->num_rows() > 0)
						{
							$nom_pll_awal = $pll_awal->row()->nominal;
						}else{
							$nom_pll_awal = 0;
						}

						$nom_awal = 'Rp '.number_format($nom_lr_kotor_awal - $nom_jum_beban_awal - $nom_pll_awal, 0, ",", ".");

					}else{
						
						$nom_awal   = '';
					}

				}else{

					if($r->pengurang == null || $r->pengurang == '')
					{

						$nom_awall = $this->db->query("SELECT IFNULL(sum($r->dk),0)nom_awal from jurnal_d where left(kode_rek,$r->length) in ($r->kode_1) $where_bln_awal GROUP BY left(kode_rek,$r->length)");
					}else{
						$nom_awall = $this->db->query("SELECT IFNULL(sum($r->dk)-sum($r->pengurang),0)nom_awal from jurnal_d where left(kode_rek,$r->length) in ($r->kode_1) $where_bln_awal GROUP BY left(kode_rek,$r->length)");
					}

					if($nom_awall->num_rows() > 0)
					{
						($nom_awall->row()->nom_awal == '' || $nom_awall->row()->nom_awal == null) ? $nomi_awall = 0 : $nomi_awall = $nom_awall->row()->nom_awal;

						$nom_awal = 'Rp '.number_format($nomi_awall, 0, ",", ".");
					}else{
						$nom_awal = 'Rp '.number_format(0, 0, ",", ".");
					}

				}

				$html .='
				<tr>
					<td style="'.$r->bold.'">'.$r->spasi.''.$kode.'</td>
					<td style="'.$r->bold.'text-transform:capitalize;" class="text-left">'.$r->spasi.''.$r->uraian.'</td>
					<td style="'.$r->bold.'text-align:right">' . $nom_awal . '</td>';
					
					$query_bln = $this->db->query("SELECT*FROM m_bulan $cek_bulan order by id");
					
					foreach($query_bln->result() as $bln){

						$where_bln2        = "and MONTH(tgl_transaksi)='$bln->id' ";

						if($r->kode_1=='' || $r->kode_1 == null)
						{
							if($r->id=='5')
							{
								// total_penjualan
								$total_penjualan = total_penjualan('now',$blnn,$bln->id,$thun,$attn);

								if($total_penjualan->num_rows() > 0)
								{
									$nom_total_jual = $total_penjualan->row()->nominal;
									$nominal = 'Rp '.number_format($nom_total_jual, 0, ",", ".");

								}else{
									$nominal = 'Rp '.number_format(0, 0, ",", ".");
								}
							}else if($r->id=='11')
							{
								// hp_penjualan
								$hp_penjualan = hp_penjualan('now',$blnn,$bln->id,$thun,$attn);

								if($hp_penjualan->num_rows() > 0)
								{
									$nom_hp_penjualan = $hp_penjualan->row()->nominal;
									$nominal = 'Rp '.number_format($nom_hp_penjualan, 0, ",", ".");
								}else{
									$nominal = 'Rp '.number_format(0, 0, ",", ".");
								}
							}else if($r->id=='21')
							{
								// lr_kotor
								$lr_kotor              = lr_kotor('now',$blnn,$bln->id,$thun,$attn);

								if($lr_kotor->num_rows() > 0)
								{
									$nom_lr_kotor = $lr_kotor->row()->nominal;
									$nominal = 'Rp '.number_format($nom_lr_kotor, 0, ",", ".");
								}else{
									$nominal = 'Rp '.number_format(0, 0, ",", ".");
								}
							}else if($r->id=='62')
							{
								// jum_beban
								$jum_beban              = jum_beban('now',$blnn,$bln->id,$thun,$attn);

								if($jum_beban->num_rows() > 0)
								{
									$nom_jum_beban = $jum_beban->row()->nominal;
									$nominal = 'Rp '.number_format($nom_jum_beban, 0, ",", ".");
								}else{
									$nominal = 'Rp '.number_format(0, 0, ",", ".");
								}
							}else if($r->id=='63')
							{

								// lr_kotor
								$lr_kotor              = lr_kotor('now',$blnn,$bln->id,$thun,$attn);
								if($lr_kotor->num_rows() > 0)
								{
									$nom_lr_kotor = $lr_kotor->row()->nominal;
								}else{
									$nom_lr_kotor = 0;
								}

								// jum_beban
								$jum_beban              = jum_beban('now',$blnn,$bln->id,$thun,$attn);
								if($jum_beban->num_rows() > 0)
								{
									$nom_jum_beban = $jum_beban->row()->nominal;
								}else{
									$nom_jum_beban = 0;
								}


								$nominal = 'Rp '.number_format($nom_lr_kotor - $nom_jum_beban, 0, ",", ".");


							}else if($r->id=='77')
							{

								// pll
								$pll              = pll('now',$blnn,$bln->id,$thun,$attn);

								if($pll->num_rows() > 0)
								{
									$nom_pll = $pll->row()->nominal;
									$nominal = 'Rp '.number_format($nom_pll, 0, ",", ".");
								}else{
									$nominal = 'Rp '.number_format(0, 0, ",", ".");
								}

							}else if($r->id=='78')
							{

								// lr_kotor
								$lr_kotor              = lr_kotor('now',$blnn,$bln->id,$thun,$attn);
								if($lr_kotor->num_rows() > 0)
								{
									$nom_lr_kotor = $lr_kotor->row()->nominal;
								}else{
									$nom_lr_kotor = 0;
								}

								// jum_beban
								$jum_beban              = jum_beban('now',$blnn,$bln->id,$thun,$attn);
								if($jum_beban->num_rows() > 0)
								{
									$nom_jum_beban = $jum_beban->row()->nominal;
								}else{
									$nom_jum_beban = 0;
								}
								
								// pll
								$pll              = pll('now',$blnn,$bln->id,$thun,$attn);

								if($pll->num_rows() > 0)
								{
									$nom_pll = $pll->row()->nominal;
								}else{
									$nom_pll = 0;
								}

								$nominal = 'Rp '.number_format($nom_lr_kotor - $nom_jum_beban - $nom_pll, 0, ",", ".");

							}else{
								
								$nominal   = '';
							}

						}else{
							if($r->pengurang == null || $r->pengurang == '')
							{

								$nom = $this->db->query("SELECT IFNULL(sum($r->dk),0)nominal from jurnal_d where left(kode_rek,$r->length) in ($r->kode_1) $where_bln $where_bln2 GROUP BY left(kode_rek,$r->length)");
							}else{
								$nom = $this->db->query("SELECT IFNULL(sum($r->dk)-sum($r->pengurang),0)nominal from jurnal_d where left(kode_rek,$r->length) in ($r->kode_1) $where_bln $where_bln2 GROUP BY left(kode_rek,$r->length)");
							}

							if($nom->num_rows() > 0)
							{
								($nom->row()->nominal == '' || $nom->row()->nominal == null) ? $nomi = 0 : $nomi = $nom->row()->nominal;

								$nominal = 'Rp '.number_format($nomi, 0, ",", ".");
							}else{
								$nominal = 'Rp '.number_format(0, 0, ",", ".");
							}

						}
								
						$html .='<td style="'.$r->bold.'text-align:right">' . $nominal . '</td>';
					}

				
				$html .='</tr></tbody>';
				
			}

		
			// foreach($lr_dtl->result() as $r){
			// 	$i++;
			// 	$html .='<tbody>';
			// 	$nm_rekk = strtolower(cari_rek($r->kd));
			// 	if($r->dk=='K')
			// 	{
			// 		$nominal = $r->kredit;
			// 	}else{

			// 		$nominal = $r->debet;
			// 	}


			// 	if($nominal != 0)
			// 	{				
			// 		if($r->length=='1')
			// 		{
			// 			$html .='
			// 			<tr>
			// 				<td style="font-weight: bold;">'.$r->kd.'</td>
			// 				<td style="font-weight: bold;text-transform:capitalize;" class="text-left">'.$nm_rekk.'</td>					
			// 				<td style="font-weight: bold;text-align:right">Rp ' . number_format($nominal, 0, ",", ".") . '</td>
			// 			</tr>';
			// 		}else{
			// 			$html .='
			// 			<tr>
			// 				<td style="">&nbsp;&nbsp;&nbsp;&nbsp;'.$r->kd.'</td>
			// 				<td class="text-left" style="text-transform:capitalize;">&nbsp;&nbsp;&nbsp;&nbsp;'.$nm_rekk.'</td>					
			// 				<td style="text-align:right">Rp ' . number_format($nominal, 0, ",", ".") . '</td>
			// 			</tr>';

			// 		}
			// 	}else{
			// 		$html .='';
			// 	}

				
			// 	$html .='</tbody>';
				
			// }
		$html .= '</table>';

		echo json_encode([
			'html_dtl' => $html,
		]);
	}
	
	function load_neraca()
	{ //

		$attn         = $_POST['id_hub'];
		$blnn         = $_POST['blnn'];
		$thun         = $_POST['thun'];

		if($attn=='' || $attn== null || $attn== 'null')
		{
			if($blnn=='all')
			{
				$value            = "";
				$cek_bulan        = '';
				$where_bln_awal   = "and YEAR(tgl_transaksi)<'$thun' ";
				$where_bln        = "and YEAR(tgl_transaksi)='$thun' ";
			}else{
				// $value="where a.tgl_transaksi BETWEEN  '$tgl_awal' and  '$tgl_akhir'";
				$cek_bulan ="where id ='$blnn'";
				$where_bln_awal   = "and YEAR(tgl_transaksi)='$thun' and MONTH(tgl_transaksi) < ('$blnn') ";
				$where_bln        = "and YEAR(tgl_transaksi)='$thun' and MONTH(tgl_transaksi) <= ('$blnn') ";
			}

		}else{
			if($blnn=='all')
			{
				$value            = "where b.id_hub='$attn' ";
				$cek_bulan        = '';
				$where_bln_awal   = "and id_hub='$attn' and YEAR(tgl_transaksi)<'$thun' ";
				$where_bln        = "and id_hub='$attn' and YEAR(tgl_transaksi)='$thun' ";
			}else{
				// $value="where b.id_hub='$attn' and a.tgl_transaksi BETWEEN  '$tgl_awal' and  '$tgl_akhir'";
				$cek_bulan        = "where id ='$blnn'";
				$where_bln_awal   = "and id_hub='$attn' and YEAR(tgl_transaksi)='$thun' and MONTH(tgl_transaksi) < ('$blnn') ";
				$where_bln        = "and id_hub='$attn' and YEAR(tgl_transaksi)='$thun' and MONTH(tgl_transaksi) <= ('$blnn') ";
			}

		}

	// 	$nrc = $this->db->query("SELECT LENGTH(p.kd)length,p.* FROM(
	// 		select kd_akun as kd,nm_akun as nm,jenis,dk,(select sum(debet) from jurnal_d where left(kode_rek,1)=kd_akun)nominal from m_kode_akun
	// 		union all
	// 		select concat(kd_akun,'.',kd_kelompok) as kd,nm_kelompok as nm,jenis,dk,(select sum(debet) from jurnal_d where left(kode_rek,4)=concat(kd_akun,'.',kd_kelompok))nominal from m_kode_kelompok 
    //    union all
    //    select concat(kd_akun,'.',kd_kelompok,'.',kd_jenis) as kd,nm_jenis as nm,jenis,dk,(select sum(debet) from jurnal_d where left(kode_rek,7)=concat(kd_akun,'.',kd_kelompok,'.',kd_jenis))nominal from m_kode_jenis
	// 		union all
	// 		select concat(kd_akun,'.',kd_kelompok,'.',kd_jenis,'.',kd_rinci) as kd,nm_rinci as nm,jenis,dk,(select sum(debet) from jurnal_d where left(kode_rek,10)=concat(kd_akun,'.',kd_kelompok,'.',kd_jenis,'.',kd_rinci))nominal from m_kode_rinci
	// 		 )p
	// 		 where jenis='Neraca'
	// 		 order by kd");

			$nrc = load_map_nrc();

			$html ='';
			$html .='<table class="table table-bordered table-striped table-scrollable" width="100%">
			<thead class="color-tabel">
				<tr>
					<th style="text-align: center;">Kode Rek</th>
					<th style="text-align: center;">Nama Akun</th>
					<th style="text-align: center;">Saldo Awal</th>';

			$query_bln = $this->db->query("SELECT*FROM m_bulan $cek_bulan order by id");
			foreach($query_bln->result() as $bln){
				$html .=' <th style="text-align: center;"> '.$bln->bulan.' '.$thun.'</th>';
					
			}
			$html .='</tr>
			</thead>';

			$i         = 0;
			$nominal   = 0;
			$nom_awal  = 0;
			foreach($nrc->result() as $r)
			{
				$i++;
				$html .='<tbody>';
				$kode = str_replace("'",'',$r->kode_1);

				if($r->kode_1=='' || $r->kode_1 == null)
				{
					if($r->id=='14')
					{
						// total_aset_lancar
						$total_aset_lancar = total_aset_lancar('awal',$blnn,$bln->id,$thun,$attn);

						if($total_aset_lancar->num_rows() > 0)
						{
							$nom_total_jual = $total_aset_lancar->row()->nominal;
							$nom_awal = 'Rp '.number_format($nom_total_jual, 0, ",", ".");

						}else{
							$nom_awal = 'Rp '.number_format(0, 0, ",", ".");
						}
					}else if($r->id=='20')
					{
						// aset_tetap
						$aset_tetap = aset_tetap('awal',$blnn,$bln->id,$thun,$attn);

						if($aset_tetap->num_rows() > 0)
						{
							$nom_aset_tetap = $aset_tetap->row()->nominal;
							$nom_awal = 'Rp '.number_format($nom_aset_tetap, 0, ",", ".");
						}else{
							$nom_awal = 'Rp '.number_format(0, 0, ",", ".");
						}
					}else if($r->id=='26')
					{
						// akumulasi_penyusutan
						$akumulasi_penyusutan = akumulasi_penyusutan('awal',$blnn,$bln->id,$thun,$attn);

						if($akumulasi_penyusutan->num_rows() > 0)
						{
							$nom_akumulasi_penyusutan = $akumulasi_penyusutan->row()->nominal;
							$nom_awal = 'Rp '.number_format($nom_akumulasi_penyusutan, 0, ",", ".");
						}else{
							$nom_awal = 'Rp '.number_format(0, 0, ",", ".");
						}
					}else if($r->id=='27')
					{
						// total_aset
						$total_aset = total_aset('awal',$blnn,$bln->id,$thun,$attn);

						if($total_aset->num_rows() > 0)
						{
							$nom_total_aset = $total_aset->row()->nominal;
							$nom_awal = 'Rp '.number_format($nom_total_aset, 0, ",", ".");
						}else{
							$nom_awal = 'Rp '.number_format(0, 0, ",", ".");
						}
					}else if($r->id=='37')
					{
						// total_kewajiban_lancar
						$total_kewajiban_lancar = total_kewajiban_lancar('awal',$blnn,$bln->id,$thun,$attn);

						if($total_kewajiban_lancar->num_rows() > 0)
						{
							$nom_total_kewajiban_lancar = $total_kewajiban_lancar->row()->nominal;
							$nom_awal = 'Rp '.number_format($nom_total_kewajiban_lancar, 0, ",", ".");
						}else{
							$nom_awal = 'Rp '.number_format(0, 0, ",", ".");
						}
					}else if($r->id=='42')
					{
						// total_kewajiban_jp
						$total_kewajiban_jp = total_kewajiban_jp('awal',$blnn,$bln->id,$thun,$attn);

						if($total_kewajiban_jp->num_rows() > 0)
						{
							$nom_total_kewajiban_jp = $total_kewajiban_jp->row()->nominal;
							$nom_awal = 'Rp '.number_format($nom_total_kewajiban_jp, 0, ",", ".");
						}else{
							$nom_awal = 'Rp '.number_format(0, 0, ",", ".");
						}
					}else if($r->id=='43')
					{
						// total_kewajiban
						$total_kewajiban = total_kewajiban('awal',$blnn,$bln->id,$thun,$attn);

						if($total_kewajiban->num_rows() > 0)
						{
							$nom_total_kewajiban = $total_kewajiban->row()->nominal;
							$nom_awal = 'Rp '.number_format($nom_total_kewajiban, 0, ",", ".");
						}else{
							$nom_awal = 'Rp '.number_format(0, 0, ",", ".");
						}
					}else if($r->id=='50')
					{
						// total_ekuitas
						$total_ekuitas = total_ekuitas('awal',$blnn,$bln->id,$thun,$attn);

						if($total_ekuitas->num_rows() > 0)
						{
							$nom_total_ekuitas = $total_ekuitas->row()->nominal;
						}else{
							$nom_total_ekuitas = 0;
						}

						// lr_kotor_nrc
						$lr_kotor_nrc              = lr_kotor_nrc('awal',$blnn,$bln->id,$thun,$attn);
						if($lr_kotor_nrc->num_rows() > 0)
						{
							$nom_lr_kotor_nrc = $lr_kotor_nrc->row()->nominal;
						}else{
							$nom_lr_kotor_nrc = 0;
						}

						// jum_beban_nrc
						$jum_beban_nrc              = jum_beban_nrc('awal',$blnn,$bln->id,$thun,$attn);
						if($jum_beban_nrc->num_rows() > 0)
						{
							$nom_jum_beban_nrc = $jum_beban_nrc->row()->nominal;
						}else{
							$nom_jum_beban_nrc = 0;
						}
						
						// pll
						$pll_nrc              = pll_nrc('awal',$blnn,$bln->id,$thun,$attn);

						if($pll_nrc->num_rows() > 0)
						{
							$nom_pll_nrc = $pll_nrc->row()->nominal;
						}else{
							$nom_pll_nrc = 0;
						}

						$nom_awal = 'Rp '.number_format($nom_total_ekuitas+ ($nom_lr_kotor_nrc - $nom_jum_beban_nrc - $nom_pll_nrc), 0, ",", ".");

					}else if($r->id=='51')
					{
						// total_kewajiban
						$total_kewajiban = total_kewajiban('awal',$blnn,$bln->id,$thun,$attn);

						if($total_kewajiban->num_rows() > 0)
						{
							$nom_total_kewajiban = $total_kewajiban->row()->nominal;
						}else{
							$nom_total_kewajiban = 0;
						}

						// total_ekuitas
						$total_ekuitas = total_ekuitas('awal',$blnn,$bln->id,$thun,$attn);

						if($total_ekuitas->num_rows() > 0)
						{
							$nom_total_ekuitas = $total_ekuitas->row()->nominal;
						}else{
							$nom_total_ekuitas = 0;
						}

						
						// lr_kotor_nrc
						$lr_kotor_nrc              = lr_kotor_nrc('awal',$blnn,$bln->id,$thun,$attn);
						if($lr_kotor_nrc->num_rows() > 0)
						{
							$nom_lr_kotor_nrc = $lr_kotor_nrc->row()->nominal;
						}else{
							$nom_lr_kotor_nrc = 0;
						}

						// jum_beban_nrc
						$jum_beban_nrc              = jum_beban_nrc('awal',$blnn,$bln->id,$thun,$attn);
						if($jum_beban_nrc->num_rows() > 0)
						{
							$nom_jum_beban_nrc = $jum_beban_nrc->row()->nominal;
						}else{
							$nom_jum_beban_nrc = 0;
						}
						
						// pll
						$pll_nrc              = pll_nrc('awal',$blnn,$bln->id,$thun,$attn);

						if($pll_nrc->num_rows() > 0)
						{
							$nom_pll_nrc = $pll_nrc->row()->nominal;
						}else{
							$nom_pll_nrc = 0;
						}

						$nom_awal = 'Rp '.number_format($nom_total_kewajiban+ + $nom_total_ekuitas + ($nom_lr_kotor_nrc - $nom_jum_beban_nrc - $nom_pll_nrc), 0, ",", ".");
					}else{
						
						$nom_awal   = '';
					}

				}else{

					if($r->id=='48')
					{
						$nom_awal = 'Rp '.number_format(0, 0, ",", ".");
					}else if($r->id=='49')
					{
						// lr_kotor_nrc
						$lr_kotor_nrc              = lr_kotor_nrc('awal',$blnn,$bln->id,$thun,$attn);
						if($lr_kotor_nrc->num_rows() > 0)
						{
							$nom_lr_kotor_nrc = $lr_kotor_nrc->row()->nominal;
						}else{
							$nom_lr_kotor_nrc = 0;
						}

						// jum_beban_nrc
						$jum_beban_nrc              = jum_beban_nrc('awal',$blnn,$bln->id,$thun,$attn);
						if($jum_beban_nrc->num_rows() > 0)
						{
							$nom_jum_beban_nrc = $jum_beban_nrc->row()->nominal;
						}else{
							$nom_jum_beban_nrc = 0;
						}
						
						// pll
						$pll_nrc              = pll_nrc('awal',$blnn,$bln->id,$thun,$attn);

						if($pll_nrc->num_rows() > 0)
						{
							$nom_pll_nrc = $pll_nrc->row()->nominal;
						}else{
							$nom_pll_nrc = 0;
						}

						$lr_dtahan = $nom_lr_kotor_nrc - $nom_jum_beban_nrc - $nom_pll_nrc;
						if($lr_dtahan<0)
						{
							$lr_dtahan_ok =$lr_dtahan*-1;
						}else{
							$lr_dtahan_ok =$lr_dtahan;

						}

						$nom_awal = 'Rp '.number_format($lr_dtahan_ok, 0, ",", ".");
					}else{

						if($r->dk=='debet')
						{
							$nom_awall = $this->db->query("SELECT IFNULL(sum(debet)-sum(kredit),0)nom_awal from jurnal_d where left(kode_rek,$r->length) in ('$r->kode_1') $where_bln_awal GROUP BY left(kode_rek,$r->length)");
						}else{
							$nom_awall = $this->db->query("SELECT IFNULL(sum(kredit)-sum(debet),0)nom_awal from jurnal_d where left(kode_rek,$r->length) in ('$r->kode_1') $where_bln_awal GROUP BY left(kode_rek,$r->length)");
						}
						
						

						// if($r->dk=='debet')
						// {
						// 	$nom_awall = $this->db->query("SELECT IFNULL(sum(debet)-sum(kredit),0)nom_awal from jurnal_d where left(kode_rek,$r->length) in ('$r->kode_1') $where_bln_awal GROUP BY left(kode_rek,$r->length)");
						// }else{
						// 	$nom = $this->db->query("SELECT IFNULL(sum(debet)-sum(kredit)*-1,0)nom_awal from jurnal_d where left(kode_rek,$r->length) in ('$r->kode_1') $where_bln_awal GROUP BY left(kode_rek,$r->length)");
						// }
						
						if($nom_awall->num_rows() > 0)
						{
							($nom_awall->row()->nom_awal == '' || $nom_awall->row()->nom_awal == null) ? $nomi_awall = 0 : $nomi_awall = $nom_awall->row()->nom_awal;

							$nom_awal = 'Rp '.number_format($nomi_awall, 0, ",", ".");
						}else{
							$nom_awal = 'Rp '.number_format(0, 0, ",", ".");
						}
					}

				}

				$html .='
				<tr>
					<td style="'.$r->bold.'">'.$r->spasi.''.$kode.'</td>
					<td style="'.$r->bold.'text-transform:capitalize;" class="text-left">'.$r->spasi.''.$r->uraian.'</td>
					<td style="'.$r->bold.'text-align:right">' . $nom_awal . '</td>';
					
					$query_bln = $this->db->query("SELECT*FROM m_bulan $cek_bulan order by id");
					
					foreach($query_bln->result() as $bln)
					{
						// $where_bln2        = "and MONTH(tgl_transaksi)='$bln->id' ";

						if($r->kode_1=='' || $r->kode_1 == null)
						{
							if($r->id=='14')
							{
								// total_aset_lancar
								$total_aset_lancar = total_aset_lancar('now',$blnn,$bln->id,$thun,$attn);

								if($total_aset_lancar->num_rows() > 0)
								{
									$nom_total_jual = $total_aset_lancar->row()->nominal;
									$nominal = 'Rp '.number_format($nom_total_jual, 0, ",", ".");

								}else{
									$nominal = 'Rp '.number_format(0, 0, ",", ".");
								}
							}else if($r->id=='20')
							{
								// aset_tetap
								$aset_tetap = aset_tetap('now',$blnn,$bln->id,$thun,$attn);

								if($aset_tetap->num_rows() > 0)
								{
									$nom_aset_tetap = $aset_tetap->row()->nominal;
									$nominal = 'Rp '.number_format($nom_aset_tetap, 0, ",", ".");
								}else{
									$nominal = 'Rp '.number_format(0, 0, ",", ".");
								}
							}else if($r->id=='26')
							{
								// akumulasi_penyusutan
								$akumulasi_penyusutan = akumulasi_penyusutan('now',$blnn,$bln->id,$thun,$attn);

								if($akumulasi_penyusutan->num_rows() > 0)
								{
									$nom_akumulasi_penyusutan = $akumulasi_penyusutan->row()->nominal;
									$nominal = 'Rp '.number_format($nom_akumulasi_penyusutan, 0, ",", ".");
								}else{
									$nominal = 'Rp '.number_format(0, 0, ",", ".");
								}
							}else if($r->id=='27')
							{
								// total_aset
								$total_aset = total_aset('now',$blnn,$bln->id,$thun,$attn);

								if($total_aset->num_rows() > 0)
								{
									$nom_total_aset = $total_aset->row()->nominal;
									$nominal = 'Rp '.number_format($nom_total_aset, 0, ",", ".");
								}else{
									$nominal = 'Rp '.number_format(0, 0, ",", ".");
								}
							}else if($r->id=='37')
							{
								// total_kewajiban_lancar
								$total_kewajiban_lancar = total_kewajiban_lancar('now',$blnn,$bln->id,$thun,$attn);

								if($total_kewajiban_lancar->num_rows() > 0)
								{
									$nom_total_kewajiban_lancar = $total_kewajiban_lancar->row()->nominal;
									$nominal = 'Rp '.number_format($nom_total_kewajiban_lancar, 0, ",", ".");
								}else{
									$nominal = 'Rp '.number_format(0, 0, ",", ".");
								}
							}else if($r->id=='42')
							{
								// total_kewajiban_jp
								$total_kewajiban_jp = total_kewajiban_jp('now',$blnn,$bln->id,$thun,$attn);

								if($total_kewajiban_jp->num_rows() > 0)
								{
									$nom_total_kewajiban_jp = $total_kewajiban_jp->row()->nominal;
									$nominal = 'Rp '.number_format($nom_total_kewajiban_jp, 0, ",", ".");
								}else{
									$nominal = 'Rp '.number_format(0, 0, ",", ".");
								}
							}else if($r->id=='43')
							{
								// total_kewajiban
								$total_kewajiban = total_kewajiban('now',$blnn,$bln->id,$thun,$attn);

								if($total_kewajiban->num_rows() > 0)
								{
									$nom_total_kewajiban = $total_kewajiban->row()->nominal;
									$nominal = 'Rp '.number_format($nom_total_kewajiban, 0, ",", ".");
								}else{
									$nominal = 'Rp '.number_format(0, 0, ",", ".");
								}
							}else if($r->id=='50')
							{
								// total_ekuitas
								$total_ekuitas = total_ekuitas('now',$blnn,$bln->id,$thun,$attn);

								if($total_ekuitas->num_rows() > 0)
								{
									$nom_total_ekuitas = $total_ekuitas->row()->nominal;
								}else{
									$nom_total_ekuitas = 0;
								}

								// lr_kotor_nrc
								$lr_kotor_nrc              = lr_kotor_nrc('now',$blnn,$bln->id,$thun,$attn);
								if($lr_kotor_nrc->num_rows() > 0)
								{
									$nom_lr_kotor_nrc = $lr_kotor_nrc->row()->nominal;
								}else{
									$nom_lr_kotor_nrc = 0;
								}

								// jum_beban_nrc
								$jum_beban_nrc              = jum_beban_nrc('now',$blnn,$bln->id,$thun,$attn);
								if($jum_beban_nrc->num_rows() > 0)
								{
									$nom_jum_beban_nrc = $jum_beban_nrc->row()->nominal;
								}else{
									$nom_jum_beban_nrc = 0;
								}
								
								// pll
								$pll_nrc              = pll_nrc('now',$blnn,$bln->id,$thun,$attn);

								if($pll_nrc->num_rows() > 0)
								{
									$nom_pll_nrc = $pll_nrc->row()->nominal;
								}else{
									$nom_pll_nrc = 0;
								}

								$nominal = 'Rp '.number_format($nom_total_ekuitas+ ($nom_lr_kotor_nrc - $nom_jum_beban_nrc - $nom_pll_nrc), 0, ",", ".");

							}else if($r->id=='51')
							{
								// total_kewajiban
								$total_kewajiban = total_kewajiban('now',$blnn,$bln->id,$thun,$attn);

								if($total_kewajiban->num_rows() > 0)
								{
									$nom_total_kewajiban = $total_kewajiban->row()->nominal;
								}else{
									$nom_total_kewajiban = 0;
								}

								// total_ekuitas
								$total_ekuitas = total_ekuitas('now',$blnn,$bln->id,$thun,$attn);

								if($total_ekuitas->num_rows() > 0)
								{
									$nom_total_ekuitas = $total_ekuitas->row()->nominal;
								}else{
									$nom_total_ekuitas = 0;
								}

								
								// lr_kotor_nrc
								$lr_kotor_nrc              = lr_kotor_nrc('now',$blnn,$bln->id,$thun,$attn);
								if($lr_kotor_nrc->num_rows() > 0)
								{
									$nom_lr_kotor_nrc = $lr_kotor_nrc->row()->nominal;
								}else{
									$nom_lr_kotor_nrc = 0;
								}

								// jum_beban_nrc
								$jum_beban_nrc              = jum_beban_nrc('now',$blnn,$bln->id,$thun,$attn);
								if($jum_beban_nrc->num_rows() > 0)
								{
									$nom_jum_beban_nrc = $jum_beban_nrc->row()->nominal;
								}else{
									$nom_jum_beban_nrc = 0;
								}
								
								// pll
								$pll_nrc              = pll_nrc('now',$blnn,$bln->id,$thun,$attn);

								if($pll_nrc->num_rows() > 0)
								{
									$nom_pll_nrc = $pll_nrc->row()->nominal;
								}else{
									$nom_pll_nrc = 0;
								}

								$nominal = 'Rp '.number_format($nom_total_kewajiban+ + $nom_total_ekuitas + ($nom_lr_kotor_nrc - $nom_jum_beban_nrc - $nom_pll_nrc), 0, ",", ".");
							}else{
								$nominal   = '';
							}

						}else{
							if($r->id=='48')
							{
								$nominal = 'Rp '.number_format(0, 0, ",", ".");
							}else if($r->id=='49')
							{
								// lr_kotor_nrc
								$lr_kotor_nrc              = lr_kotor_nrc('now',$blnn,$bln->id,$thun,$attn);
								if($lr_kotor_nrc->num_rows() > 0)
								{
									$nom_lr_kotor_nrc = $lr_kotor_nrc->row()->nominal;
								}else{
									$nom_lr_kotor_nrc = 0;
								}

								// jum_beban_nrc
								$jum_beban_nrc              = jum_beban_nrc('now',$blnn,$bln->id,$thun,$attn);
								if($jum_beban_nrc->num_rows() > 0)
								{
									$nom_jum_beban_nrc = $jum_beban_nrc->row()->nominal;
								}else{
									$nom_jum_beban_nrc = 0;
								}
								
								// pll
								$pll_nrc              = pll_nrc('now',$blnn,$bln->id,$thun,$attn);

								if($pll_nrc->num_rows() > 0)
								{
									$nom_pll_nrc = $pll_nrc->row()->nominal;
								}else{
									$nom_pll_nrc = 0;
								}

								$nominal = 'Rp '.number_format($nom_lr_kotor_nrc - $nom_jum_beban_nrc - $nom_pll_nrc, 0, ",", ".");
							}else{
								if($r->dk=='debet')
								{
									$nom = $this->db->query("SELECT IFNULL(sum(debet)-sum(kredit),0)nominal from jurnal_d where left(kode_rek,$r->length) in ('$r->kode_1') $where_bln GROUP BY left(kode_rek,$r->length)");
								}else{
									$nom = $this->db->query("SELECT IFNULL(sum(kredit)-sum(debet),0)nominal from jurnal_d where left(kode_rek,$r->length) in ('$r->kode_1') $where_bln GROUP BY left(kode_rek,$r->length)");
								}
							
								if($nom->num_rows() > 0)
								{
									($nom->row()->nominal == '' || $nom->row()->nominal == null) ? $nomi = 0 : $nomi = $nom->row()->nominal;

									$nominal = 'Rp '.number_format($nomi, 0, ",", ".");
								}else{
									$nominal = 'Rp '.number_format(0, 0, ",", ".");
								}
							}
							

						}
								
						$html .='<td style="'.$r->bold.'text-align:right">' . $nominal . '</td>';
					}
				
				$html .='</tr></tbody>';
				
			}
		$html .= '</table>';

		echo json_encode([
			'html_dtl' => $html,
		]);
	}

	function cetak_jurnal()
	{
		// $no_stok    = $_GET['no_stok'];

		$ctk        = $_GET['ctk'];
		$priode     = $_GET['priode'];
		$attn       = $_GET['id_hub'];
		$tgl_awal   = $_GET['tgl_awal'];
		$tgl_akhir  = $_GET['tgl_akhir'];
		$tahun      = date('Y');
		$blnn       = date('m');
 
		if($attn=='' || $attn== null || $attn== 'null')
		{
			if($priode=='all')
			{
				$value="";
			}else if($priode=='now')
			{
				$value="and YEAR(a.tgl_transaksi) = '$tahun' and MONTH(a.tgl_transaksi) ='$blnn'";
			}else{
				$value="and a.tgl_transaksi BETWEEN  '$tgl_awal' and  '$tgl_akhir'";
			}

		}else{
			if($priode=='all')
			{
				$value="and b.id_hub='$attn' ";
			}else if($priode=='now')
			{
				$value="and b.id_hub='$attn' and YEAR(a.tgl_transaksi) = '$tahun' and MONTH(a.tgl_transaksi) ='$blnn'";
			}else{
				$value="and b.id_hub='$attn' and a.tgl_transaksi BETWEEN  '$tgl_awal' and  '$tgl_akhir'";
			}

		}
			
        $query_header = $this->db->query("SELECT * FROM jurnal_d a
			join m_hub b on a.id_hub=b.id_hub
			where b.id_hub <>'7' $value
			order by b.id_hub,id_jurnal");
        
        $data = $query_header->row();
        
        $query_detail = $this->db->query("SELECT * FROM jurnal_d a
			join m_hub b on a.id_hub=b.id_hub
			where b.id_hub <>'7' $value
			order by b.id_hub,id_jurnal");

		$html = '';
		$html .= '<br>';

		if ($query_header->num_rows() > 0) 
		{

			$html .= '<table width="100%" border="1" cellspacing="1" cellpadding="3" style="border-collapse:collapse;font-size:12px;font-family: ;">
                        <tr style="background-color: #cccccc">
							<Th Align="Center">No</Th>
							<Th Align="Center">No Voucher</Th>
							<Th Align="Center">Hub</Th>
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
						<td align="center">' . $r->nm_hub . '</td>
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
		$this->m_fungsi->template_kop('JURNAL UMUM','-',$html,'L',$ctk);
		// $this->m_fungsi->mPDFP($html);
		
	}
	
	function cetak_jurnal_umum()
	{
		// $no_stok    = $_GET['no_stok'];

		$thn        = $_GET['thn'];
		$ctk        = $_GET['ctk'];
		$attn       = $_GET['id_hub'];
		$tahun      = date('Y');
		$blnn       = date('m');
 
		if($attn=='' || $attn== null || $attn== 'null')
		{
			$hub="";
		}else{
			$hub="and b.id_hub='$attn' ";

		}
			
        $query_header = $this->db->query("SELECT no_voucher, tgl_transaksi,sum(debet)debet,sum(kredit)kredit,a.id_hub,b.nm_hub,ket from jurnal_d a
			JOIN m_hub b ON a.id_hub=b.id_hub
			where no_voucher like'%JURUM%' and YEAR(tgl_transaksi) = '$thn' $hub
			group by no_voucher, tgl_transaksi,a.id_hub,ket
			order by b.id_hub,tgl_transaksi desc");
        
        $data = $query_header->row();
        
        $query_detail = $this->db->query("SELECT no_voucher, tgl_transaksi,sum(debet)debet,sum(kredit)kredit,a.id_hub,b.nm_hub,ket from jurnal_d a
			JOIN m_hub b ON a.id_hub=b.id_hub
			where no_voucher like'%JURUM%' and YEAR(tgl_transaksi) = '$thn' $hub
			group by no_voucher, tgl_transaksi,a.id_hub,ket
			order by b.id_hub,tgl_transaksi desc");

		$html = '';
		$html .= '<br>';

		if ($query_header->num_rows() > 0) 
		{

			$html .= '<table width="100%" border="1" cellspacing="1" cellpadding="3" style="border-collapse:collapse;font-size:12px;font-family: ;">
				<tr style="background-color: #cccccc">
					<th class="text-center">NO</th>
					<th class="text-center">NO VOUCHER</th>
					<th class="text-center">TANGGAL</th>
					<th class="text-center">HUB</th>
					<th class="text-center">DEBIT</th>
					<th class="text-center">KREDIT</th>
					<th class="text-center">KET</th>
				</tr>';
			
			$no=1;

			foreach ($query_detail->result() as $r) 
			{
				$html .= '<tr>
						<td align="center">'.$no.'</td>
						<td align="center">' . $r->no_voucher . '</td>
						<td align="center">' . $r->tgl_transaksi . '</td>
						<td align="">' . $r->nm_hub . '</td>
						<td align="right">'.$r->debet.'</td>
						<td align="right">' . $r->kredit . '</td>
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
		$this->m_fungsi->template_kop('JURNAL UMUM','-',$html,'L',$ctk);
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
				$nm_rekk    = strtolower(cari_rek($r->kd));

				$no++;
				if($r->length=='1')
				{
					$html .='
					<tr>
						<td style="font-weight: bold;">'.$r->kd.'</td>
						<td style="font-weight: bold;" class="text-left" style="text-transform:capitalize;">'.$nm_rekk.'</td>					
						<td style="font-weight: bold;text-align:right">Rp ' . number_format($r->nominal, 0, ",", ".") . '</td>
					</tr>';
				}else{
					$html .='
					<tr>
						<td style="">&nbsp;&nbsp;&nbsp;&nbsp;'.$r->kd.'</td>
						<td style="" class="text-left" style="text-transform:capitalize;">&nbsp;&nbsp;&nbsp;&nbsp;'.$nm_rekk.'</td>					
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
						<td style="font-weight: bold; text-transform:capitalize;" class="text-left">'.cari_rek($r->kd).'</td>					
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
		 
		$ctk        = $_GET['ctk'];
		$priode     = $_GET['priode'];
		$attn       = $_GET['id_hub'];
		$tgl_awal   = $_GET['tgl_awal'];
		$tgl_akhir  = $_GET['tgl_akhir'];
		$tahun      = date('Y');
		$blnn       = date('m');

		$hubb         = $this->db->query("SELECT * from m_hub where id_hub='$attn' ")->row();

		if($attn=='' || $attn== null || $attn== 'null')
		{
			if($priode=='all')
			{
				$attn_head    = "";
				$value        = "";
				$periode      = "";
			}else if($priode=='now')
			{
				$attn_head    = "";
				$value        = "and YEAR(a.tgl_transaksi) = '$tahun' and MONTH(a.tgl_transaksi) ='$blnn'";
				$periode      = "";
			}else{
				$attn_head    = "";
				$value        = "and a.tgl_transaksi BETWEEN  '$tgl_awal' and  '$tgl_akhir'";
				$periode      = '<tr>
				<td width="10%" style="text-align:left; font-size:15px;"><b>PERIODE</b></td>
				<td width="5%" style="text-align:left; font-size:15px;"><b>:</b></td>
				<td width="85%" style="text-align:left; font-size:15px;"><b>'.$this->m_fungsi->tanggal_ind($tgl_awal).' s/d '.$this->m_fungsi->tanggal_ind($tgl_akhir).'</b></td> </tr>';
			}

		}else{
			if($priode=='all')
			{
				$attn_head    = '<tr>
				<td width="10%" style="text-align:left; font-size:15px;"><b>ATTN</b></td>
				<td width="5%" style="text-align:left; font-size:15px;"><b>:</b></td>
				<td width="85%" style="text-align:left; font-size:15px;"><b>'.$hubb->nm_hub.'</b></td> </tr>';
				$value        = "and b.id_hub='$attn' ";
				$periode      = "";
			}else if($priode=='now')
			{
				$attn_head    = '<tr>
				<td width="10%" style="text-align:left; font-size:15px;"><b>ATTN</b></td>
				<td width="5%" style="text-align:left; font-size:15px;"><b>:</b></td>
				<td width="85%" style="text-align:left; font-size:15px;"><b>'.$hubb->nm_hub.'</b></td> </tr>';
				$value        = "and b.id_hub='$attn' and YEAR(a.tgl_transaksi) = '$tahun' and MONTH(a.tgl_transaksi) ='$blnn'";
				$periode      = "";
			}else{
				$attn_head    = '<tr>
				<td width="10%" style="text-align:left; font-size:15px;"><b>ATTN</b></td>
				<td width="5%" style="text-align:left; font-size:15px;"><b>:</b></td>
				<td width="85%" style="text-align:left; font-size:15px;"><b>'.$hubb->nm_hub.'</b></td> </tr>';
				$value        = "and b.id_hub='$attn' and a.tgl_transaksi BETWEEN  '$tgl_awal' and  '$tgl_akhir'";
				$periode      = '<tr>
				<td width="10%" style="text-align:left; font-size:15px;"><b>PERIODE</b></td>
				<td width="5%" style="text-align:left; font-size:15px;"><b>:</b></td>
				<td width="85%" style="text-align:left; font-size:15px;"><b>'.$this->m_fungsi->tanggal_ind($tgl_awal).' s/d '.$this->m_fungsi->tanggal_ind($tgl_akhir).'</b></td> </tr>';
			}

		}

		$html = '';
		$html .= '<br>';

		$html .= '<table style="border-collapse:collapse;font-family: Tahoma; font-size:11px" width="100%" align="center" border="0" cellspacing="1" cellpadding="3">
		'.$attn_head.'
		'.$periode.'
		</table>';
					
		$html .= '<br>';

        $query_header = $this->db->query("SELECT kode_rek from jurnal_d a join m_hub b on a.id_hub=b.id_hub where b.id_hub <>'7' $value group by kode_rek order by tgl_input asc,kode_rek");
        
        $data = $query_header->row();

		if ($query_header->num_rows() > 0) 
		{
			foreach ($query_header->result() as $header) 
			{        
				
				$query_detail = $this->db->query("SELECT kode_rek from jurnal_d a join m_hub b on a.id_hub=b.id_hub where b.id_hub <>'7' and kode_rek='$header->kode_rek' order by tgl_input asc,kode_rek");

					$html .= '<table border="1" cellspacing="1" cellpadding="3" style="border-collapse:collapse;font-size:14px;font-family: ;" width="100%">
					<thead class="color-tabel">
						<tr style="background-color: #cccccc">
							<th style="text-align: center;">No</th>
							<th style="text-align: center;">Tanggal</th>
							<th style="text-align: center;">No Voucher</th>
							<th style="text-align: center;">ATTN</th>
							<th style="text-align: center;">Kode Rek</th>
							<th style="text-align: center;">Nama Rek</th>
							<th style="text-align: center;">Debit</th>
							<th style="text-align: center;">Kredit</th>
							<th style="text-align: center;">saldo</th>
						</tr>
					</thead>
					<tbody>';
					
					if($attn=='' || $attn== null || $attn== 'null')
					{
						if($priode=='all')
						{
							$union ="";
							$value2="and kode_rek='$header->kode_rek'";
						}else if($priode=='now')
						{
							$union ="";
							$value2="and kode_rek='$header->kode_rek' and YEAR(a.tgl_transaksi) = '$tahun' and MONTH(a.tgl_transaksi) ='$blnn'";
						}else{
							$union ="(SELECT 0 id_jurnal,b.id_hub,b.nm_hub,'$tgl_awal' tgl_transaksi,tgl_input,jam_input,'SALDO AWAL'no_voucher,''no_transaksi,kode_rek,sum(debet)debet,sum(kredit)kredit
							from jurnal_d a join m_hub b on a.id_hub=b.id_hub 
							where kode_rek='$header->kode_rek' and a.tgl_transaksi < '$tgl_awal' 
							GROUP BY b.id_hub,b.nm_hub,kode_rek)
							UNION ALL"; 

							$value2="and kode_rek='$header->kode_rek' and a.tgl_transaksi BETWEEN  '$tgl_awal' and  '$tgl_akhir'";
						}

					}else{
						if($priode=='all')
						{
							$union ="";
							$value2="and kode_rek='$header->kode_rek' and b.id_hub='$attn' ";
						}else if($priode=='now')
						{
							$union ="";
							$value2="and kode_rek='$header->kode_rek' and b.id_hub='$attn' and YEAR(a.tgl_transaksi) = '$tahun' and MONTH(a.tgl_transaksi) ='$blnn' ";
						}else{
							$union ="(SELECT 0 id_jurnal,b.id_hub,b.nm_hub,'$tgl_awal' tgl_transaksi,tgl_input,jam_input,'SALDO AWAL'no_voucher,''no_transaksi,kode_rek,sum(debet)debet,sum(kredit)kredit
							from jurnal_d a join m_hub b on a.id_hub=b.id_hub 
							where kode_rek='$header->kode_rek' and b.id_hub='$attn' and a.tgl_transaksi < '$tgl_awal' 
							GROUP BY b.id_hub,b.nm_hub,kode_rek)
							UNION ALL";
							
							$value2="and kode_rek='$header->kode_rek' and b.id_hub='$attn' and a.tgl_transaksi BETWEEN  '$tgl_awal' and  '$tgl_akhir'";
						}

					}
					
					$nrc = $this->db->query("$union SELECT id_jurnal,b.id_hub,b.nm_hub,tgl_transaksi,tgl_input,jam_input,no_voucher,no_transaksi,kode_rek,debet,kredit from jurnal_d  a join m_hub b on a.id_hub=b.id_hub where b.id_hub <>'7' $value2 order by kode_rek,tgl_transaksi,id_jurnal");

					$i        = 0;
					$hitung   = 0;
					foreach($nrc->result() as $r){
						$i++;				
						$hitung   += $r->debet - $r->kredit;
						$html .='
						<tr>
							<td style="font-weight: bold;text-align:center">'.$i.'</td>
							<td style="font-weight: bold;">'.$r->tgl_transaksi.'</td>
							<td style="font-weight: bold;">'.$r->no_voucher.'</td>
							<td style="font-weight: bold;">'.$r->nm_hub.'</td>
							<td style="font-weight: bold;text-align:center" >'.$r->kode_rek.'</td>
							<td style="font-weight: bold;text-transform:capitalize;" class="text-left" >'.cari_rek($r->kode_rek).'</td>
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
		$this->m_fungsi->template_kop('LAPORAN BUKU BESAR','-',$html,'L',$ctk);
	}

	function load_data_1()
	{
		$id       = $this->input->post('id');
		$no       = $this->input->post('no');
		$jenis    = $this->input->post('jenis');

		if($jenis=='edit_ju')
		{ 
			$queryh   = "SELECT no_voucher, tgl_transaksi,sum(debet)debet,sum(kredit)kredit,a.id_hub,b.nm_hub,ket from jurnal_d a
			JOIN m_hub b ON a.id_hub=b.id_hub
			where no_voucher ='$no'
			group by no_voucher, tgl_transaksi,a.id_hub,ket
			order by tgl_transaksi desc";
			
			$data_h   = $this->db->query($queryh)->row();

			$queryd   = "SELECT * from jurnal_d a
			JOIN m_hub b ON a.id_hub=b.id_hub
			JOIN 
			(SELECT*FROM(
						select kd_akun as kd,nm_akun as nm,jenis,dk from m_kode_akun
						union all
						select concat(kd_akun,'.',kd_kelompok) as kd,nm_kelompok as nm,jenis,dk from m_kode_kelompok
						union all
						select concat(kd_akun,'.',kd_kelompok,'.',kd_jenis) as kd,nm_jenis as nm,jenis,dk from m_kode_jenis
						union all
						select concat(kd_akun,'.',kd_kelompok,'.',kd_jenis,'.',kd_rinci) as kd,nm_rinci as nm,jenis,dk from m_kode_rinci
						)b )c
			ON a.kode_rek=c.kd
			where no_voucher ='$no'
			order by id_jurnal";

		}else{

			$queryh   = "SELECT*FROM invoice_header a where a.id='$id' and a.no_invoice='$no'";
			$queryd   = "SELECT*FROM invoice_detail where no_invoice='$no' ORDER BY TRIM(no_surat) ";
		}
		

		$header   = $this->db->query($queryh)->row();
		$detail   = $this->db->query($queryd)->result();
		$data     = ["header" => $header, "detail" => $detail];

        echo json_encode($data);
	}

	function hapus()
	{
		$jenis    = $_POST['jenis'];
		$field    = $_POST['field'];
		$id       = $_POST['id'];

		if ($jenis == "contoh") {
			
			$no_inv          = $_POST['no_inv'];
			// ubah no pl
			$query_cek = $this->db->query("SELECT*FROM invoice_detail where no_invoice ='$no_inv'")->result();

			foreach( $query_cek as $row)
			{
				$db2 = $this->load->database('database_simroll', TRUE);

				if($row->type=='roll'){
					$update_no_pl   = $db2->query("UPDATE pl set no_pl_inv = 0 where id ='$row->id_pl'");					
				}else{
					$update_no_pl   = $db2->query("UPDATE pl_box set no_pl_inv = 0 where id ='$row->id_pl'");					
				}
			}

			if($update_no_pl)
			{

				$result          = $this->m_master->query("DELETE FROM invoice_header WHERE  $field = '$id'");

				$result          = $this->m_master->query("DELETE FROM invoice_detail WHERE  no_invoice = '$no_inv'");

				// delete stok
				$result          = $this->m_master->query("DELETE FROM trs_stok_bahanbaku WHERE  no_transaksi = '$no_inv'");
			}
			
			
		} else {

			$result = $this->m_master->query("DELETE FROM $jenis WHERE  $field = '$id'");
		}

		echo json_encode($result);
	}
}