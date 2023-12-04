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
			'judul' => "Invoice",
		);
		$this->load->view('header', $data);
		$this->load->view('Logistik/v_invoice_add');
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

	function load_data()
	{
		$db2 = $this->load->database('database_simroll', TRUE);
		$jenis        = $this->uri->segment(3);
		$data         = array();

		if ($jenis == "Invoice") {
			$query = $db2->query("SELECT * FROM invoice_header ORDER BY tgl,no_invoice")->result();
			$i = 1;
			foreach ($query as $r) {
				$id = "'$r->id'";
				$nm = "'$r->no_invoice'";
				$opsi = "'opsi'";
				$print = base_url("laporan/print_invoice_v2?no_invoice=") . $r->no_invoice;

				$row = array();
				$row[] = $i;
				$row[] = $r->tgl;
				$row[] = $r->no_invoice;
				$row[] = $r->kepada;
				$row[] = $r->nm_perusahaan;
				$aksi = "";

				if ($this->session->userdata('level') == "Admin") {
					if ($r->status == "Closed") {
						$aksi = '<a type="button" onclick="editDataInv(' . $id . ',' . $nm . ')" class="btn bg-orange btn-circle waves-effect waves-circle waves-float">
								<i class="material-icons">edit</i>
							</a>
							<button type="button" onclick="deleteData(' . $id . ',' . $nm . ',' . $opsi . ')" class="btn btn-danger btn-circle waves-effect waves-circle waves-float" title="Reject">
								<i class="material-icons">delete</i>
							</button>
							<a type="button" onclick="confirmData(' . $id . ',' . $nm . ')" class="btn bg-green btn-circle waves-effect waves-circle waves-float">
								<i class="material-icons">check</i>
							</a>';
					} else if ($r->status == "Verified") {
						$aksi = '<a type="button" onclick="editDataInv(' . $id . ',' . $nm . ')" class="btn bg-orange btn-circle waves-effect waves-circle waves-float">
								<i class="material-icons">edit</i>
							</a>
							<a type="button" href="' . $print . '" target="blank" class="btn btn-default btn-circle waves-effect waves-circle waves-float" title="Print Invoice">
								<i class="material-icons">print</i>
							</a>';
					}
				} else {
					$aksi = '';
				}
				$row[] = $aksi;
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

		$query = $db2->query("SELECT b.nm_perusahaan,a.id_pl,b.id,a.nm_ker,a.g_label,a.width,COUNT(a.roll) AS qty,SUM(weight) AS weight,b.no_po,b.no_surat,b.no_pkb 
		FROM m_timbangan a 
		INNER JOIN pl b ON a.id_pl = b.id 
		WHERE b.tgl='$tgl_sj' AND b.id_perusahaan='$id_perusahaan'
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

	function Insert()
	{

		$jenis    = $this->input->post('jenis');
		$status   = $this->input->post('status');

		$result   = $this->m_logistik->$jenis($jenis, $status);
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
		$jenis   = $_POST['jenis'];
		$field   = $_POST['field'];
		$id = $_POST['id'];

		if ($jenis == "trs_po") {
			$result = $this->m_master->query("DELETE FROM $jenis WHERE  $field = '$id'");
			$result = $this->m_master->query("DELETE FROM trs_po_detail WHERE  $field = '$id'");
		} else {

			$result = $this->m_master->query("DELETE FROM $jenis WHERE  $field = '$id'");
		}

		echo json_encode($result);
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
                <td width="85 %" > '. $this->m_fungsi->tanggal_format_indonesia($data->tgl_po) .'<td>
            </tr>
            <tr>
                <td align="left">Customer</td>
                <td> : </td>
                <td> '. $data->nm_pelanggan .'<td>
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
