<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Logistik extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('status') != "login") {
			redirect(base_url("Login"));
		}
		$this->load->model('m_master');
		$this->load->model('m_logistik');
	}

	public function Invoice()
	{
		$data = array(
			'judul' => "Invoice",
		);
		$this->load->view('header', $data);
		$this->load->view('Logistik/v_invoice');
		$this->load->view('footer');
	}
	
	public function Invoice_add()
	{
		$data = array(
			'judul' => "Invoice Baru",
		);
		$this->load->view('header', $data);
		$this->load->view('Logistik/v_invoice_add');
		$this->load->view('footer');
	}
	
	public function Invoice_edit()
	{
		$id       = $_GET['id'];
		$no_inv   = $_GET['no_inv'];

		$data = array(
			'judul' 	 => "Edit Invoice",
			'id'    	 => $id,
			'no_inv'     => $no_inv,
		);
		$this->load->view('header', $data);
		$this->load->view('Logistik/v_invoice_edit');
		$this->load->view('footer');
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

	function load_no_inv()
    {
        
		$type   = $this->input->post('type');
		$pajak  = $this->input->post('pajak');

		($type=='roll')? $type_ok=$type : $type_ok='SHEET_BOX';
		
		($pajak=='nonppn')? $pajak_ok='non' : $pajak_ok='ppn';
		
		$type   = $this->m_fungsi->tampil_no_urut($type_ok.'_'.$pajak_ok);
        echo json_encode($type);
    }

	function load_data_1()
	{
		$id       = $this->input->post('id');
		$no_inv   = $this->input->post('no_inv');

		$queryh   = "SELECT*FROM invoice_header where id='$id' and no_invoice='$no_inv'";
		$queryd   = "SELECT*FROM invoice_detail where no_invoice='$no_inv' ";

		$header   = $this->db->query($queryh)->row();
		$detail    = $this->db->query($queryd)->result();

		$data = ["header" => $header, "detail" => $detail];

        echo json_encode($data);
	}

	function load_data()
	{
		// $db2 = $this->load->database('database_simroll', TRUE);
		$jenis        = $this->uri->segment(3);
		$data         = array();

		if ($jenis == "Invoice") {
			$query = $this->db->query("SELECT * FROM invoice_header ORDER BY tgl_invoice,no_invoice")->result();
			$i = 1;
			foreach ($query as $r) {
				$id = "'$r->id'";
				$no_inv = "'$r->no_invoice'";
				$print = base_url("laporan/print_invoice_v2?no_invoice=") . $r->no_invoice;

				$row = array();
				$row[] = '<div class="text-center">'.$i.'</div>';
				$row[] = '<div class="text-center">'.$this->m_fungsi->tanggal_ind($r->tgl_invoice).'</div>';
				$row[] = $r->no_invoice;
				$row[] = $r->kepada;
				$row[] = $r->nm_perusahaan;
				$aksi = "";

				if (in_array($this->session->userdata('level'), ['Admin','Keuangan1']))
				{
					if ($r->status == "Open") {
						$aksi = '
							<a class="btn btn-sm btn-warning" href="' . base_url("Logistik/Invoice_edit?id=" .$r->id ."&no_inv=" .$r->no_invoice ."") . '" title="EDIT DATA" >
								<b><i class="fa fa-edit"></i> </b>
							</a> 

							<button type="button" title="DELETE"  onclick="deleteData(' . $id . ',' . $no_inv . ')" class="btn btn-danger btn-sm">
								<i class="fa fa-trash-alt"></i>
							</button> 

							<button title="VERIFIKASI DATA" type="button" onclick="tampil_edit(' . $id . ',' . $no_inv . ')" class="btn btn-info btn-sm">
								<i class="fa fa-check"></i>
							</button>

							<a target="_blank" class="btn btn-sm btn-danger" href="' . base_url("Logistik/Cetak_Invoice?no_invoice=" . $r->no_invoice . "") . '" title="CETAK" ><b><i class="fa fa-print"></i> </b></a>
							
							';
					} else if ($r->status == "Verified") {
						$aksi = '
							<a type="button" href="' . $print . '" target="blank" class="btn btn-default btn-circle waves-effect waves-circle waves-float" title="Print Invoice">
								<i class="material-icons">print</i>
							</a>';
					}
				} else {
					$aksi = '';
				}
				$row[] = '<div class="text-center">'.$aksi.'</div>';
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

	function load_sj($searchTerm="")
	{
		// ASLI
		$db2 = $this->load->database('database_simroll', TRUE);
		$tgl = $this->input->post('tgl_sj');

		$query = $db2->query("SELECT DATE_FORMAT(a.tgl, '%d-%m-%Y')tgll,a.* FROM pl a
			INNER JOIN m_timbangan b ON a.id = b.id_pl
			WHERE a.status = 'Open' AND a.no_pl_inv = '0' and a.tgl = '$tgl' and id_perusahaan not in ('210','217') 
			GROUP BY a.tgl,a.nm_perusahaan
			ORDER BY a.tgl,a.nm_perusahaan,a.no_pl_inv")->result();

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

	function list_item()
	{
		// ASLI
		$tgl_sj           = $this->input->post('tgl_sj');
		$id_perusahaan    = $this->input->post('id_perusahaan');
		
		$db2 = $this->load->database('database_simroll', TRUE);

		$query = $db2->query("SELECT b.nm_perusahaan,a.id_pl,b.id,a.nm_ker,a.g_label,a.width,COUNT(a.roll) AS qty,SUM(weight)-SUM(seset) AS weight,b.no_po,b.no_po_sj,b.no_surat
		FROM m_timbangan a 
		INNER JOIN pl b ON a.id_pl = b.id 
		WHERE b.no_pl_inv = '0' AND b.tgl='$tgl_sj' AND b.id_perusahaan='$id_perusahaan'
		GROUP BY b.no_po,a.nm_ker,a.g_label,a.width 
		ORDER BY a.g_label,b.no_surat,b.no_po,a.nm_ker DESC,a.g_label,a.width ")->result();

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

	function Insert_inv()
	{

		if($this->session->userdata('username'))
		{

			$c_no_inv_kd   = $this->input->post('no_inv_kd');
			$c_no_inv      = $this->input->post('no_inv');
			$c_no_inv_tgl  = $this->input->post('no_inv_tgl');

			$no_inv_ok     = $c_no_inv_kd.''.$c_no_inv.''.$c_no_inv_tgl;
			$query_cek_no  = $this->db->query("SELECT*FROM invoice_header where no_invoice='$no_inv_ok' ")->num_rows();

			if($query_cek_no>0)
			{
				echo json_encode(array("status" => "3","id" => $asc));
			}else{
				
				$c_type_po   = $this->input->post('type_po');
				$c_pajak     = $this->input->post('pajak');
				$asc         = $this->m_logistik->save_invoice();
		
				if($asc){
		
					($c_type_po=='roll')? $type_ok=$c_type_po : $type_ok='SHEET_BOX';
			
					($c_pajak=='nonppn')? $pajak_ok='non' : $pajak_ok='ppn';
			
					$no_urut    = $this->m_fungsi->tampil_no_urut($type_ok.'_'.$pajak_ok);
					$kode_ok    = $type_ok.'_'.$pajak_ok;

					$this->db->query("UPDATE m_urut set no_urut=$no_urut+1 where kode='$kode_ok' ");
		
					echo json_encode(array("status" =>"1","id" => $asc));
		
				}else{
					echo json_encode(array("status" => "2","id" => $asc));
		
				}

			}

		}

		
		
	}
	
	function get_edit()
	{
		$id    = $this->input->post('id');
		$jenis    = $this->input->post('jenis');
		$field    = $this->input->post('field');

		if ($jenis == "trs_po") {
			$header =  $this->m_master->get_data_one($jenis, $field, $id)->row();
			// $data = $this->m_master->get_data_one("trs_po_detail", "no_po", $header->no_po)->result();
			$data = $this->db->query("SELECT * FROM trs_po a 
                    JOIN trs_po_detail b ON a.no_po = b.no_po
                    JOIN m_pelanggan c ON a.id_pelanggan=c.id_pelanggan
                    LEFT JOIN m_kab d ON c.kab=d.kab_id
                    LEFT JOIN m_produk e ON b.id_produk=e.id_produk
					WHERE a.no_po = '".$header->no_po."'
				")->result();

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
	
	function hapus()
	{
		$jenis    = $_POST['jenis'];
		$field    = $_POST['field'];
		$id       = $_POST['id'];

		if ($jenis == "invoice") {
			$no_inv          = $_POST['no_inv'];
			
			// ubah no pl
			$query_cek = $this->db->query("SELECT*FROM invoice_detail where no_invoice ='$no_inv'")->result();

			foreach( $query_cek as $row)
			{
				$db2            = $this->load->database('database_simroll', TRUE);
				$update_no_pl   = $db2->query("UPDATE pl set no_pl_inv = 0 where id ='$row->id_pl'");
			}

			if($update_no_pl)
			{

				$result          = $this->m_master->query("DELETE FROM invoice_header WHERE  $field = '$id'");

				$result          = $this->m_master->query("DELETE FROM invoice_detail WHERE  no_invoice = '$no_inv'");
			}
			
			
			
		} else {

			$result = $this->m_master->query("DELETE FROM $jenis WHERE  $field = '$id'");
		}

		echo json_encode($result);
	}

	function Cetak_Invoice()
	{
        $no_invoice = $_GET['no_invoice'];
        $ctk = 0;
        $html = '';

		//////////////////////////////////////// K O P ////////////////////////////////////////

        $data_detail = $this->db->query("SELECT * FROM invoice_header WHERE no_invoice='$no_invoice'")->row();
		$ppnpph = $data_detail->pajak;

		$html .= '<table cellspacing="0" style="font-size:11px;color:#000;border-collapse:collapse;vertical-align:top;width:100%;text-align:center;font-weight:bold;font-family:"Trebuchet MS", Helvetica, sans-serif">';

        if($ppnpph == 'nonppn'){
            $html .= '<tr>
                <th style="border:0;height:92px"></th>
            </tr>
            <tr>
                <td style="background:#ddd;border:1px solid #000;padding:6px;font-size:14px !important">INVOICE</td>
            </tr>';
            $html .= '</table>';
        }else{
            $html .= '<tr>
                <th style="border:0;width:15%;height:0"></th>
                <th style="border:0;width:55%;height:0"></th>
                <th style="border:0;width:25%;height:0"></th>
            </tr>

            <tr>
				<td rowspan="3" align="center">
					<img src="' . base_url() . 'assets/gambar/ppi.png"  width="80" height="70" />
				</td>
		   
                <td style="font-size:20px;" align="left">PT. PRIMA PAPER INDONESIA</td>

            </tr>
            <tr>
                <td style="font-size:11px" align="left">Dusun Timang Kulon, Desa Wonokerto, Kec.Wonogiri, Kab.Wonogiri</td>
                <td></td>
            </tr>
            <tr>
                <td style="font-size:11px;" align="left">WONOGIRI - JAWA TENGAH - INDONESIA Kode Pos 57615</td>
                <td style=""></td>
            </tr>
			<tr><td>&nbsp;<br></td></tr>';
            $html .= '</table>';

            $html .= '<table cellspacing="0" style="font-size:11px;color:#000;border-collapse:collapse;vertical-align:top;width:100%;text-align:center;font-weight:bold;font-family:"Trebuchet MS", Helvetica, sans-serif">
            <tr>
                <th style="height:0"></th>
            </tr>
            <tr>
                <td style="background:#ddd;border:1px solid #000;padding:6px;font-size:14px !important">INVOICE</td>
            </tr>';
            $html .= '</table>';
        }       

		//////////////////////////////////////// D E T A I L //////////////////////////////////////

        $html .= '<table cellspacing="0" style="font-size:11px;color:#000;border-collapse:collapse;vertical-align:top;width:100%;font-family:"Trebuchet MS", Helvetica, sans-serif">
        <tr>
            <th style="border:0;padding:2px 0;height:0;width:14%"></th>
            <th style="border:0;padding:2px 0;height:0;width:1%"></th>
            <th style="border:0;padding:2px 0;height:0;width:40%"></th>
            <th style="border:0;padding:2px 0;height:0;width:12%"></th>
            <th style="border:0;padding:2px 0;height:0;width:1%"></th>
            <th style="border:0;padding:2px 0;height:0;width:32%"></th>
        </tr>';

        $html .= '
        <tr>
            <td colspan="3"></td>
            <td style="padding:3px 0 20px;font-weight:bold">NOMOR</td>
            <td style="padding:3px 0 20px;font-weight:bold">:</td>
            <td style="padding:3px 0 20px;font-weight:bold">'.$data_detail->no_invoice.'</td>
        </tr>
        <tr>
            <td style="padding:3px 0">Nama Perusahaan</td>
            <td style="padding:3px 0">:</td>
            <td style="padding:0 3px 0 0;line-height:1.8">'.$data_detail->nm_perusahaan.'</td>
            <td style="padding:3px 0;font-weight:bold">Jatuh Tempo</td>
            <td style="padding:3px 0">:</td>
            <td style="padding:3px 0;font-weight:bold;color:#f00">'.$this->m_fungsi->tanggal_format_indonesia($data_detail->tgl_jatuh_tempo).'</td>
        </tr>';

		$html .= '<tr>
			<td style="padding:3px 0">Alamat</td>
			<td style="padding:3px 0">:</td>
			<td style="padding:0 3px 0 0;line-height:1.8">'.$data_detail->alamat_perusahaan.'</td>
			<td style="padding:3px 0">No. PO</td>
			<td style="padding:3px 0">:</td>
			<td style="padding:0;line-height:1.8">';

			// KONDISI JIKA LEBIH DARI 1 PO
			$result_po = $this->db->query("SELECT * FROM invoice_detail WHERE no_invoice='$no_invoice' GROUP BY no_po ORDER BY no_po");
			if($result_po->num_rows() == '1'){
				$html .= $result_po->row()->no_po;;
			}else{
				foreach($result_po->result() as $r){
					$html .= $r->no_po.'<br/>';
				}
			}
		$html .= '</td>
		</tr>';

        $html .= '<tr>
            <td style="padding:3px 0">Kepada</td>
            <td style="padding:3px 0">:</td>
            <td style="padding:0 3px 0 0;line-height:1.8">'.$data_detail->kepada.'</td>
            <td style="padding:3px 0">No. Surat Jalan</td>
            <td style="padding:3px 0">:</td>
            <td style="padding:0;line-height:1.8">';

			// KONDISI JIKA LEBIH DARI 1 SURAT JALAN
			$result_sj = $this->db->query("SELECT * FROM invoice_detail WHERE no_invoice='$no_invoice' GROUP BY no_surat ORDER BY no_surat");
			if($result_sj->num_rows() == '1'){
				$html .= $result_sj->row()->no_surat;;
			}else{
				foreach($result_sj->result() as $r){
					$html .= $r->no_surat.'<br/>';
				}
			}
		$html .= '</td>
		</tr>';

        $html .= '</table>';

		/////////////////////////////////////////////// I S I ///////////////////////////////////////////////

        $html .= '<table cellspacing="0" style="font-size:11px;color:#000;border-collapse:collapse;vertical-align:top;width:100%;font-family:"Trebuchet MS", Helvetica, sans-serif">
        <tr>
            <th style="border:0;height:15px;width:30%"></th>
            <th style="border:0;height:15px;width:10%"></th>
            <th style="border:0;height:15px;width:15%"></th>
            <th style="border:0;height:15px;width:5%"></th>
            <th style="border:0;height:15px;width:10%"></th>
            <th style="border:0;height:15px;width:5%"></th>
            <th style="border:0;height:15px;width:25%"></th>
        </tr>';

        $html .= '<tr>
            <td style="border:1px solid #000;border-width:2px 0;padding:5px 0;text-align:center;font-weight:bold">NAMA BARANG</td>
            <td style="border:1px solid #000;border-width:2px 0;padding:5px 0;text-align:center;font-weight:bold">SATUAN</td>
            <td style="border:1px solid #000;border-width:2px 0;padding:5px 0;text-align:center;font-weight:bold">JUMLAH</td>
            <td style="border:1px solid #000;border-width:2px 0;padding:5px 0;text-align:center;font-weight:bold" colspan="2">HARGA</td>
            <td style="border:1px solid #000;border-width:2px 0;padding:5px 0;text-align:center;font-weight:bold" colspan="2">TOTAL</td>
        </tr>';
		$html .= '<tr>
			<td style="border:0;padding:20px 0 0" colspan="7"></td>
		</tr>';

        $sqlLabel = $this->db->query("SELECT*FROM invoice_detail WHERE no_invoice='$no_invoice' GROUP BY nm_ker DESC,g_label ASC,no_po");
		
		// TAMPILKAN DULU LABEL
		$totalHarga = 0;
		foreach($sqlLabel->result() as $label){

			if($label->nm_ker == 'MH'){
                $jnsKertas = 'KERTAS MEDIUM';
            }else if($label->nm_ker == 'WP'){
                $jnsKertas = 'KERTAS COKLAT';
            }else if($label->nm_ker == 'BK'){
                $jnsKertas = 'KERTAS B-KRAFT';
            }else if($label->nm_ker == 'MEDIUM LINER'){
                $jnsKertas = 'KERTAS MEDIUM LINER';
            }else if($label->nm_ker == 'MH COLOR'){
                $jnsKertas = 'KERTAS MEDIUM COLOR';
            }else if($label->nm_ker == 'MN'){
                $jnsKertas = 'KERTAS MEDIUM NON SPEK';
            }else{
                $jnsKertas = '';
            }
			$html .= '<tr>
				<td style="border:0;padding:5px 0" colspan="7">'.$jnsKertas.' ROLL '.$label->g_label.' GSM</td>
			</tr>';

			// TAMPILKAN ITEMNYA
			$weightNmLbPo = 0;
			$sqlWidth = $this->db->query("SELECT*FROM invoice_detail
			WHERE no_invoice='$label->no_invoice' AND nm_ker='$label->nm_ker' AND g_label='$label->g_label' AND no_po='$label->no_po'
			ORDER BY width ASC");
			foreach($sqlWidth->result() as $items){
                // BERAT SESETAN
				$qty        = $items->qty - $items->retur_qty;
				$fixBerat   = $items->weight - $items->seset;
				$html .= '<tr>
					<td style="border:0;padding:5px 0">LB '.round($items->width,2).' = '.$qty.' ROLL</td>
					<td style="border:0;padding:5px 0;text-align:center">KG</td>
					<td style="border:0;padding:5px 0;text-align:right">'.number_format($fixBerat).'</td>
					<td style="border:0;padding:5px 0" colspan="4"></td>
				</tr>';

				// TOTAL BERAT PER GSM - LABEL - PO
				$weightNmLbPo += $fixBerat;
			}

			// CARI HARGANYA
			$sqlHargaPo = $this->db->query("SELECT*FROM invoice_detail
			WHERE no_invoice='$label->no_invoice' AND nm_ker='$label->nm_ker' AND g_label='$label->g_label' AND no_po='$label->no_po'")->row();
			// PERKALIAN ANTARA TOTAL BERAT DAN HARGA PO
			$weightXPo = round($weightNmLbPo * $sqlHargaPo->harga);
			$html .= '<tr>
				<td style="border:0;padding:5px 0" colspan="2"></td>
				<td style="border-top:1px solid #000;padding:5px 0;text-align:right">'.number_format($weightNmLbPo).'</td>
				<td style="border-top:1px solid #000;padding:5px 0 0 15px">Rp</td>
				<td style="border-top:1px solid #000;padding:5px 0;text-align:right">'.number_format($sqlHargaPo->harga).'</td>
				<td style="border:0;padding:5px 0 0 15px">Rp</td>
				<td style="border:0;padding:5px 0;text-align:right">'.number_format($weightXPo).'</td>
			</tr>';

			$totalHarga += $weightXPo;
		}
        
		
		//////////////////////////////////////////////// T O T A L ////////////////////////////////////////////////
		$html .= '<tr>
			<td style="border:0;padding:20px 0 0" colspan="7"></td>
		</tr>';

        // RUMUS
		if($ppnpph == 'ppn'){ // PPN 10 %
			$terbilang = round($totalHarga + (0.1 * $totalHarga));
			$rowspan = 3;
		}else if($ppnpph == 'ppn_pph'){ // PPH22
			$terbilang = round($totalHarga + (0.1 * $totalHarga) + (0.01 * $totalHarga));
			$rowspan = 4;
		}else{ // NON
			$terbilang = $totalHarga;
			$rowspan = 2;
		}

		$html .= '<tr>
			<td style="border-width:2px 0;border:1px solid;font-weight:bold;padding:5px 0;line-height:1.8;text-transform:uppercase" colspan="3" rowspan="'.$rowspan.'">Terbilang :<br/><b><i>'.$this->m_fungsi->terbilang($terbilang).'</i></b></td>

			<td style="border-top:2px solid #000;font-weight:bold;padding:5px 0 0 15px" colspan="2">Sub Total</td>

			<td style="border-top:2px solid #000;font-weight:bold;padding:5px 0 0 15px">Rp</td>

			<td style="border-top:2px solid #000;font-weight:bold;padding:5px 0;text-align:right">'.number_format($totalHarga).'</td>
		</tr>';

		// PPN - PPH22
		$ppn10 = 0.1 * $totalHarga;
        $pph22 = 0.01 * $totalHarga;
		$txtppn10 = '<tr>
				<td style="border:0;font-weight:bold;padding:5px 0 0 15px" colspan="2">Ppn 11%</td>
				<td style="border:0;font-weight:bold;padding:5px 0 0 15px">Rp</td>
				<td style="border:0;font-weight:bold;padding:5px 0;text-align:right">'.number_format($ppn10).'</td>
			</tr>';

		if($ppnpph == 'ppn'){ // PPN 10 %
			$html .= $txtppn10;
		}else if($ppnpph == 'ppn_pph'){ // PPH22
			// pph22
			$html .= $txtppn10.'<tr>
				<td style="border:0;font-weight:bold;padding:5px 0 0 15px" colspan="2">Pph 22</td>
				<td style="border:0;font-weight:bold;padding:5px 0 0 15px">Rp</td>
				<td style="border:0;font-weight:bold;padding:5px 0;text-align:right">'.number_format($pph22).'</td>
			</tr>';
		}else{
			$html .= '';
		}

		$html .= '<tr>
			<td style="border-bottom:2px solid #000;font-weight:bold;padding:5px 0 0 15px" colspan="2">Total</td>
			<td style="border-bottom:2px solid #000;font-weight:bold;padding:5px 0 0 15px">Rp</td>
			<td style="border-bottom:2px solid #000;font-weight:bold;padding:5px 0;text-align:right">'.number_format($terbilang).'</td>
		</tr>';

		//////////////////////////////////////////////// T T D ////////////////////////////////////////////////
		
		$html .= '<tr>
			<td style="border:0;padding:20px 0 0" colspan="7"></td>
		</tr>';

		$html .= '<tr>
			<td style="border:0;padding:5px" colspan="3"></td>
			<td style="border:0;padding:5px;text-align:center" colspan="4">Wonogiri, '.$this->m_fungsi->tanggal_format_indonesia(date('Y-m-d')).'</td>
		</tr>
		<tr>
			<td style="border:0;padding:0 0 15px;line-height:1.8" colspan="3">Pembayaran Full Amount ditransfer ke :<br/>BNI 5758699690 (CABANG SOLO)<br/>A.n PT. PRIMA PAPER INDONESIA</td>
			<td style="border:0;padding:0" colspan="4"></td>
		</tr>
		<tr>
			<td style="border:0;padding:0;line-height:1.8" colspan="3">* Harap bukti transfer di email ke</td>
			<td style="border-bottom:1px solid #000;padding:0" colspan="4"></td>
		</tr>
		<tr>
			<td style="border:0;padding:0;line-height:1.8" colspan="3">primapaperin@gmail.com / bethppi@yahoo.co.id</td>
			<td style="border:0;padding:0;line-height:1.8;text-align:center" colspan="4">Finance</td>
		</tr>
		';

        $html .= '</table>';

        // $this->m_fungsi->newPDF($html,'P',77,0);
		$this->m_fungsi->_mpdf_hari('P', 'A4', 'INVOICE', $html, 'INVOICE.pdf', 5, 5, 5, 10);
		// echo $html;

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