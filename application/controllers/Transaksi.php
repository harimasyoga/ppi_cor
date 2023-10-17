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
		$data = array(
			'judul' => "Purchase Order",
			'produk' => $this->db->query("SELECT * FROM m_produk order by id_produk")->result(),
			'sales' => $this->db->query("SELECT * FROM m_sales order by id_sales")->result(),
			'pelanggan' => $this->db->query("SELECT * FROM m_pelanggan a left join m_kab b on a.kab=b.kab_id order by id_pelanggan")->result(),
			'level' => $this->session->userdata('level'). "aa"
		);

		$this->load->view('header');
		$this->load->view('Transaksi/v_po', $data);
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

	public function SO()
	{
		$data = array(
			'judul' => "Sales Order",
			'getPO' => $this->db->query("SELECT * FROM trs_po WHERE Status = 'Approve' order by id")->result(),
			// 'getNoPO' => "PO-".date('Y')."-"."000000". $this->m_master->get_data_max("trs_po","no_po")
		);

		$this->load->view('header');
		$this->load->view('Transaksi/v_so', $data);
		$this->load->view('footer');
	}

	public function WO()
	{
		$data = array(
			'judul' => "Order Produksi",
			'getSO' => $this->db->query("SELECT * FROM trs_so_detail WHERE Status = 'Open' order by id")->result(),
		);


		$this->load->view('header');
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


		$this->load->view('header');
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

	function load_data()
	{
		$jenis        = $this->uri->segment(3);
		$data         = array();

		if ($jenis == "po") {
			$query = $this->m_master->query("SELECT * FROM trs_po a join m_pelanggan b on a.id_pelanggan=b.id_pelanggan order by id")->result();
			$i = 1;
			foreach ($query as $r) {
				$row    = array();
                $time   = substr($r->add_time, 0,10);

                if($r->status_app1=='N')
                {
                    $btn1   = 'btn-warning';
                    $i1     = '<i class="fas fa-lock"></i>';
                }else{
                    $btn1   = 'btn-success';
                    $i1     = '<i class="fas fa-check-circle"></i>';
                }
                
                if($r->status_app2=='N')
                {
                    $btn2   = 'btn-warning';
                    $i2     = '<i class="fas fa-lock"></i>';
                }else{
                    $btn2   = 'btn-success';
                    $i2     = '<i class="fas fa-check-circle"></i>';
                }
                
                if($r->status_app3=='N')
                {
                    $btn3   = 'btn-warning';
                    $i3     = '<i class="fas fa-lock"></i>';
                }else{
                    $btn3   = 'btn-success';
                    $i3     = '<i class="fas fa-check-circle"></i>';
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

				$row[] = $i;
				$row[] = '<div class="text-center"><a href="javascript:void(0)" onclick="tampil_edit(' . "'" . $r->id . "'" . ',' . "'detail'" . ')">' . $r->no_po . "<a></div>";

				$row[] = '<div class="text-center">'.$this->m_fungsi->tanggal_ind($time).'</div>';

                $time1 = ($r->time_app1 == null) ? 'BELUM ACC' : $this->m_fungsi->tanggal_format_indonesia(substr($r->time_app1,0,10));
                $time2 = ($r->time_app2 == null) ? 'BELUM ACC' : $this->m_fungsi->tanggal_format_indonesia(substr($r->time_app2,0,10));
                $time3 = ($r->time_app3 == null) ? 'BELUM ACC' : $this->m_fungsi->tanggal_format_indonesia(substr($r->time_app3,0,10));

				$row[] = '<div class="text-center"><button type="button" class="btn btn-sm '.$btn_s.' ">'.$r->status.'</button></div>';
				$row[] = '<div class="text-center">'.$r->kode_po.'</div>';
				// $row[] = $r->total_qty;
				$row[] = '<div class="text-center">'.$r->nm_pelanggan.'</div>';
                
				$row[] = '<div class="text-center">
					<button type="button" title="'.$time1.'" style="text-align: center;" class="btn btn-sm '.$btn1.' ">'.$i1.'</button></div>
				';
				
                $row[] = '<div class="text-center">
					<button type="button" title="'.$time2.'"  style="text-align: center;" class="btn btn-sm '.$btn2.' ">'.$i2.'</button></div>
				';
                $row[] = '<div class="text-center">
					<button type="button" title="'.$time3.'"  style="text-align: center;" class="btn btn-sm '.$btn3.' ">'.$i3.'</button></div>
				';

				// $aksi = '-';
                $aksi = '<div class="text-center">
					<a target="_blank" class="btn btn-sm btn-danger" href="' . base_url("Transaksi/Cetak_PO?no_po=" . $r->no_po . "") . '" title="Cetak" ><i class="fas fa-print"></i> </a></div>';

				if (!in_array($this->session->userdata('level'), ['Admin','Marketing','PPIC','Owner'])){

					if ($r->status == 'Open' && $r->status_app1 == 'N') {
						$aksi =  '
	                            <button type="button" onclick="tampil_edit(' . "'" . $r->id . "'" . ',' . "'edit'" . ')" class="btn btn-warning btn-xs">
	                               Edit
	                            </button>
	                            <button type="button" onclick="deleteData(' . "'" . $r->no_po . "'" . ')" class="btn btn-danger btn-xs">
	                               Hapus
	                            </button> ';
					}
				}else{
					if ($this->session->userdata('level') == 'Marketing' && $r->status_app1 == 'N' ) {
						$aksi =  '
	                            <button type="button" onclick="tampil_edit(' . "'" . $r->id . "'" . ',' . "'detail'" . ')" class="btn btn-info btn-xs">
	                               Proses Data
	                            </button> ';
					}

					if ($this->session->userdata('level') == 'PPIC' && $r->status_app1 == 'Y' && $r->status_app2 == 'N' ) {
						$aksi =  '
	                            <button type="button" onclick="tampil_edit(' . "'" . $r->id . "'" . ',' . "'detail'" . ')" class="btn btn-info btn-xs">
	                               Proses Data
	                            </button> ';
					}

					if ($this->session->userdata('level') == 'Owner' && $r->status_app1 == 'Y' && $r->status_app2 == 'Y'  && $r->status_app3 == 'N' ) {
						$aksi =  '
	                            <button type="button" onclick="tampil_edit(' . "'" . $r->id . "'" . ',' . "'detail'" . ')" class="btn btn-info btn-xs">
	                               Proses Data
	                            </button> ';
					}

					
				}

				$row[] = '<div>'.$aksi.'</div>';

				$data[] = $row;

				$i++;
			}
		} else if ($jenis == "trs_so_detail") {
			$query = $this->m_master->query("SELECT * FROM trs_so_detail order by id")->result();
			$i = 1;
			foreach ($query as $r) {
				$row = array();

				$row[] = $i;
				$row[] = '<a href="javascript:void(0)" onclick="tampil_edit(' . "'" . $r->id . "'" . ',' . "'detail'" . ')">' . $r->no_so . "<a>";
				$row[] = $r->tgl_so;
				$row[] = $r->status;
				$row[] = $r->no_po;
				$row[] = $r->id_produk;
				$row[] = $r->qty;
				$row[] = $r->id_pelanggan;
				$row[] = $r->nm_pelanggan;
				$row[] = $r->salesman;

				if ($r->status == 'Open') {
					$aksi = '<button type="button" onclick="deleteData(' . "'" . $r->id . "'" . ')" class="btn btn-danger btn-xs">
                               Batal
                            </button> ';
				} else {
					$aksi = '-';
				}

				$row[] = $aksi;

				$data[] = $row;

				$i++;
			}
		} else if ($jenis == "trs_wo") {
			$query = $this->m_master->query("SELECT * FROM trs_wo order by id")->result();
			$i = 1;
			foreach ($query as $r) {
				$row = array();

				$row[] = $i;
				$row[] = '<a href="javascript:void(0)" onclick="tampil_edit(' . "'" . $r->id . "'" . ',' . "'detail'" . ')">' . $r->no_wo . "<a>";
				$row[] = $r->tgl_wo;
				$row[] = $r->no_so;
				$row[] = $r->tgl_so;
				$row[] = $r->status;
				$row[] = $r->id_produk;
				$row[] = $r->qty;
				$row[] = $r->id_pelanggan;
				$row[] = $r->nm_pelanggan;

				if ($r->status == 'Open') {
					$aksi = ' <button type="button" onclick="tampil_edit(' . "'" . $r->id . "'" . ',' . "'edit'" . ')" class="btn btn-warning btn-xs">
                               Edit
                            </button>
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
		}



		$output = array(
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
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

		} else if ($jenis == "trs_po_detail") {
			$data =  $this->m_master->query(
				"SELECT a.*,IFNULL(b.qty_so,0)qty_so FROM `trs_po_detail` a 
                        LEFT JOIN (
                            SELECT SUM(qty) AS qty_so,no_po,id_produk FROM `trs_so_detail` WHERE STATUS <> 'Batal'

                            GROUP BY no_po,id_produk
                        )b
                        ON a.`no_po` = b.no_po
                        AND a.`id_produk` = b.id_produk

                        WHERE a.no_po ='" . $id . "'
                        AND STATUS NOT IN ('Batal','Closed')
                        "
			)->result();
		} else if ($jenis == "trs_wo") {
			$header =  $this->m_master->get_data_one($jenis, $field, $id)->row();
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
                            ( No. ' . $id . ' )
                            </td>
                        </tr>
                 </table><br>';

			$html .= '<table width="100%" border="1" cellspacing="0" style="font-size:12px;font-family: ;">
                        <tr style="background-color: #cccccc">
                            <th align="center">No</th>
                            <th align="center">Sheet Ukuran <br> (mm)</th>
                            <th align="center">Creasing <br> (mm)</th>
                            <th align="center">Kualitas</th>
                            <th align="center">Jumlah <br> (Lbr)</th>
                            <th align="center">Harga <br> (Rp)</th>
                            <th align="center">Total Harga <br> (Rp)</th>
                        </tr>';
			$no = 1;
			$tot_qty = $tot_value = $tot_total = 0;
			foreach ($query->result() as $r) {

				$total = $r->qty * $r->harga;
				$html .= '
                            <tr >
                                <td align="center">' . $no . '</td>
                                <td align="center">' . $r->ukuran . '</td>
                                <td align="center">' . $r->creasing . '</td>
                                <td align="left">' . $r->kualitas . '</td>
                                <td align="center">' . number_format($r->qty) . '</td>
                                <td align="center">' . number_format($r->harga, 0, ",", ".") . '</td>
                                <td align="right">' . number_format($total, 0, ",", ".") . '</td>
                            </tr>';

				$no++;
				$tot_qty += $r->qty;
				$tot_total += $total;
			}
			$html .= '
                            <tr style="background-color: #cccccc">
                                <td align="center" colspan="6">Total</td>
                                <td align="right" >' . number_format($tot_total, 0, ",", ".") . '</td>
                            </tr>';
			$html .= '
                 </table>';
		} else {
			$html .= '<h1> Data Kosong </h1>';
		}

		// $this->m_fungsi->_mpdf($html);
		$this->m_fungsi->template_kop('PURCHASE ORDER',$html,'L','1');
		// $this->m_fungsi->mPDFP($html);
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
                                <td>Out</td>
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
                                <td>LEBAR KERTAS</td>
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
		$po = $this->db->query("SELECT c.nm_pelanggan,s.nm_sales,p.* FROM trs_po p
		INNER JOIN m_pelanggan c ON p.id_pelanggan=c.id_pelanggan
		INNER JOIN m_sales s ON p.id_sales=s.id_sales WHERE status_app1='Y' AND status_app2='Y' AND status_app3='Y'")->result();
		echo json_encode(array(
			'po' => $po,
		));
	}

	function soPlhItems()
	{
		$no_po = $_POST["no_po"];
		$poDetail = $this->db->query("SELECT p.nm_produk,p.ukuran,p.ukuran_sheet,p.flute,p.kualitas,d.* FROM trs_po_detail d
		INNER JOIN m_produk p ON d.id_produk=p.id_produk
		WHERE d.status='Approve' AND d.no_po='$no_po' AND no_so IS NULL AND tgl_so IS NULL")->result();
		echo json_encode(array(
			'po_detail' => $poDetail,
		));
	}

	function soNoSo()
	{
		$item = $_POST["item"];
		$cekSo = $this->db->query("SELECT COUNT(d.id_produk) AS jmlNoSo,d.no_so FROM trs_po_detail d
		WHERE d.id_produk='$item' AND d.no_so IS NOT NULL
		GROUP BY d.id_produk,d.no_so")->result();
		echo json_encode(array(
			'siu' => $cekSo,
		));
	}
}
