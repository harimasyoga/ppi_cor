<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Master extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('status') != "login") {
			redirect(base_url("Login"));
		}
		$this->load->model('m_master');
		$data['setting'] = $this->m_master->get_data("m_setting")->row();
	}

	public function index()
	{

		$data = array(
			/*'produk' => $this->db->query("SELECT * FROM m_produk WHERE stok < 50 ORDER BY stok"),
                      'sales_produk' => $this->db->query("SELECT tanggal, SUM(total) total,SUM(total_perawatan) total_perawatan FROM (
                            SELECT tanggal,CASE WHEN LEFT(id_produk,1) = 'P' THEN total ELSE 0 END total,
                            CASE WHEN LEFT(id_produk,1) = 'R' THEN total ELSE 0 END total_perawatan 
                            FROM `tr_penjualan_detail` 
                            WHERE YEAR(tanggal) = YEAR(CURDATE()) AND MONTH(tanggal) = MONTH(CURDATE()) 
                            ) z GROUP BY tanggal")->result()*/);

		$this->load->view('header');
		$this->load->view('home');
		$this->load->view('footer');
	}
	function Produk()
	{

		$data = array(
			'judul' => "Produk",
			'pelanggan' => $this->m_master->get_data("m_pelanggan")->result()
		);

		$this->load->view('header');
		$this->load->view('Master/v_produk', $data);
		$this->load->view('footer');
	}

	function Pelanggan()
	{
		$data = array(
			'judul' => "Pelanggan"
		);

		$this->load->view('header');
		$this->load->view('Master/v_pelanggan', $data);
		$this->load->view('footer');
	}

	function Sales()
	{
		$this->load->view('header');
		$this->load->view('Master/v_sales');
		$this->load->view('footer');
	}

	function plhWilayah(){
		$v_prov = $_POST["prov"];
		$v_kab = $_POST["kab"];
		$v_kec = $_POST["kec"];

		if($v_prov == 0 && $v_kab == 0 && $v_kec == 0){
			$prov = $this->db->query("SELECT*FROM m_provinsi")->result();
			$kab = 0;
			$kec = 0;
			$kel = 0;
		}else if($v_prov != 0 && $v_kab == 0 && $v_kec == 0){
			$prov = $this->db->query("SELECT*FROM m_provinsi")->result();
			$kab = $this->db->query("SELECT*FROM m_kab WHERE prov_id='$v_prov'")->result();
			$kec = 0;
			$kel = 0;
		}else if($v_prov != 0 && $v_kab != 0 && $v_kec == 0){
			$prov = $this->db->query("SELECT*FROM m_provinsi")->result();
			$kab = $this->db->query("SELECT*FROM m_kab WHERE prov_id='$v_prov'")->result();
			$kec = $this->db->query("SELECT*FROM m_kec WHERE kab_id='$v_kab'")->result();
			$kel = 0;
		}else if($v_prov != 0 && $v_kab != 0 && $v_kec != 0){
			$prov = $this->db->query("SELECT*FROM m_provinsi")->result();
			$kab = $this->db->query("SELECT*FROM m_kab WHERE prov_id='$v_prov'")->result();
			$kec = $this->db->query("SELECT*FROM m_kec WHERE kab_id='$v_kab'")->result();
			$kel = $this->db->query("SELECT*FROM m_kel WHERE kec_id='$v_kec'")->result();
		}else{
			$prov = 0;
			$kab = 0;
			$kec = 0;
			$kel = 0;
		}

		echo json_encode(array(
			'prov' => $prov,
			'kab' => $kab,
			'kec' => $kec,
			'kel' => $kel,
		));
	}

	function User()
	{
		$data = array(
			'judul' => "User"
		);

		$this->load->view('header');
		$this->load->view('Master/v_user', $data);
		$this->load->view('footer');
	}

	function Sistem()
	{
		$data = array(
			'data' => $this->m_master->get_data("m_setting")->row(),
		);

		$this->load->view('header');
		$this->load->view('Master/v_setting', $data);
		$this->load->view('footer');
	}


	function Insert()
	{
		$jenis = $this->input->post('jenis');
		$status = $this->input->post('status');
		
		$result = $this->m_master->$jenis($jenis, $status);
		echo json_encode($result);
	}

	function load_data()
	{
		$jenis = $this->uri->segment(3);

		$data = array();

		if ($jenis == "pelanggan") {
			$query = $this->m_master->query("SELECT prov.prov_name,kab.kab_name,kec.kec_name,kel.kel_name,pel.* FROM m_pelanggan pel
			LEFT JOIN m_provinsi prov ON pel.prov=prov.prov_id
			LEFT JOIN m_kab kab ON pel.kab=kab.kab_id
			LEFT JOIN m_kec kec ON pel.kec=kec.kec_id
			LEFT JOIN m_kel kel ON pel.kel=kel.kel_id ORDER BY pel.nm_pelanggan")->result();
			$i = 1;
			foreach ($query as $r) {
				$row = array();
				$row[] = '<a href="javascript:void(0)" onclick="tampil_edit('."'".$r->id_pelanggan."'".','."'detail'".')">'.$i."<a>";
				$row[] = $r->nm_pelanggan;
				$row[] = $r->alamat_kirim;
				$row[] = ($r->prov_name == "" || $r->prov_name == null) ? '-' : $r->prov_name;
				$row[] = ($r->kab_name == "" || $r->kab_name == null) ? '-' : $r->kab_name;
				$row[] = ($r->kec_name == "" || $r->kec_name == null) ? '-' : $r->kec_name;
				$row[] = ($r->kel_name == "" || $r->kel_name == null) ? '-' : $r->kel_name;

				$idPelanggan = $r->id_pelanggan;
				$cekProduk = $this->db->query("SELECT * FROM m_produk WHERE no_customer='$idPelanggan'")->num_rows();
				$btnEdit = '<button type="button" onclick="tampil_edit('."'".$r->id_pelanggan."'".','."'edit'".')" class="btn btn-warning btn-xs">Edit</button>';
				$btnHapus = '<button type="button" onclick="deleteData('."'".$r->id_pelanggan."'".')" class="btn btn-danger btn-xs">Hapus</button>';
				$row[] = ($cekProduk == 0) ? $btnEdit.' '.$btnHapus : $btnEdit ;
				$data[] = $row;
				$i++;
			}
		} else if ($jenis == "produk") {
			$query = $this->m_master->query("SELECT * FROM m_produk ORDER BY nm_produk")->result();
			$i = 1;
			foreach ($query as $r) {
				$row = array();
				$row[] = '<a href="javascript:void(0)" onclick="tampil_edit('."'".$r->id_produk."'".','."'detail'".')">'.$i."<a>";
				$row[] = $r->nm_produk;
				$row[] = $r->ukuran;
				$row[] = $r->ukuran_sheet;
				$row[] = $r->kualitas;
				$row[] = $r->flute;
				$row[] = $r->berat_bersih;

				$kodeMc = $r->kode_mc;
				$cekPO = $this->db->query("SELECT * FROM trs_po_detail WHERE kode_mc='$kodeMc'")->num_rows();
				$btnEdit = '<button type="button" onclick="tampil_edit('."'".$r->id_produk."'".','."'edit'".')" class="btn btn-warning btn-xs">Edit</button>';
				$btnHapus = '<button type="button" onclick="deleteData('."'".$r->id_produk."'".')" class="btn btn-danger btn-xs">Hapus</button>';
				$row[] = ($cekPO == 0) ? $btnEdit.' '.$btnHapus : $btnEdit ;
				$data[] = $row;
				$i++;
			}
		} else if ($jenis == "sales") {
			$query = $this->m_master->query("SELECT * FROM m_sales ORDER BY nm_sales")->result();
			$i = 1;
			foreach ($query as $r) {
				$row = array();
				$row[] = '<a href="javascript:void(0)" onclick="tampil_edit('."'".$r->id_sales."'".','."'detail'".')">'.$i."<a>";
				$row[] = $r->nm_sales;
				$row[] = $r->no_sales;

				// $cekPO = $this->db->query("SELECT * FROM trs_po_detail WHERE kode_mc='$kodeMc'")->num_rows();
				$cekPO = 0;	
				$btnEdit = '<button type="button" onclick="tampil_edit('."'".$r->id_sales."'".','."'edit'".')" class="btn btn-warning btn-xs">Edit</button>';
				$btnHapus = '<button type="button" onclick="deleteData('."'".$r->id_sales."'".')" class="btn btn-danger btn-xs">Hapus</button>';
				$row[] = ($cekPO == 0) ? $btnEdit.' '.$btnHapus : $btnEdit ;
				$data[] = $row;
				$i++;
			}
		} else if ($jenis == "user") {
			$query = $this->m_master->query("SELECT * FROM tb_user order by id")->result();
			$i = 1;
			foreach ($query as $r) {
				$row = array();

				$row[] = '<a href="javascript:void(0)" onclick="tampil_edit(' . "'" . $r->username . "'" . ',' . "'detail'" . ')">' . $r->username . "<a>";
				$row[] = $r->nm_user;
				$row[] = base64_decode($r->password);
				$row[] = $r->level;

				if ($r->level == 'Admin') {
					$aksi = '<button type="button" onclick="tampil_edit(' . "'" . $r->username . "'" . ',' . "'edit'" . ')" class="btn btn-warning btn-xs">
						Edit
					</button>';
				} else {
					$aksi = '<button type="button" onclick="tampil_edit(' . "'" . $r->username . "'" . ',' . "'edit'" . ')" class="btn btn-warning btn-xs">
						Edit
					</button>
					<button type="button" onclick="deleteData(' . "'" . $r->username . "'" . ')" class="btn btn-danger btn-xs">
						Hapus
					</button>';
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

		$result = $this->m_master->query("DELETE FROM $jenis WHERE  $field = '$id'");

		echo json_encode($result);
	}


	function get_edit()
	{
		$id    = $this->input->post('id');
		$jenis    = $this->input->post('jenis');
		$field    = $this->input->post('field');

		$data =  $this->m_master->get_data_one($jenis, $field, $id)->row();
		echo json_encode($data);
	}

	function getPlhCustomer()
	{
		$data = $this->db->query("SELECT prov.prov_name,kab.kab_name,kec.kec_name,kel.kel_name,pel.* FROM m_pelanggan pel
		LEFT JOIN m_provinsi prov ON pel.prov=prov.prov_id
		LEFT JOIN m_kab kab ON pel.kab=kab.kab_id
		LEFT JOIN m_kec kec ON pel.kec=kec.kec_id
		LEFT JOIN m_kel kel ON pel.kel=kel.kel_id ORDER BY nm_pelanggan")->result();
		echo json_encode($data);
	}

	function getEditProduk()
	{
		$id = $_POST["id"];
		$data = $this->db->query("SELECT*FROM m_produk WHERE id_produk='$id'")->row();
		$pelanggan = $this->db->query("SELECT*FROM m_pelanggan pel
		LEFT JOIN m_provinsi prov ON pel.prov=prov.prov_id
		LEFT JOIN m_kab kab ON pel.kab=kab.kab_id
		LEFT JOIN m_kec kec ON pel.kec=kec.kec_id
		LEFT JOIN m_kel kel ON pel.kel=kel.kel_id
		ORDER BY id_pelanggan")->result();
		$id_pelanggan = $data->no_customer;
		$wilayah = $this->db->query("SELECT prov.prov_name,kab.kab_name,kec.kec_name,kel.kel_name,pel.* FROM m_pelanggan pel
		LEFT JOIN m_provinsi prov ON pel.prov=prov.prov_id
		LEFT JOIN m_kab kab ON pel.kab=kab.kab_id
		LEFT JOIN m_kec kec ON pel.kec=kec.kec_id
		LEFT JOIN m_kel kel ON pel.kel=kel.kel_id
		WHERE pel.id_pelanggan='$id_pelanggan'")->row();
		$po = $this->db->query("SELECT*FROM trs_po WHERE id_pelanggan='$id_pelanggan'")->row();
		echo json_encode(array(
			'produk' => $data,
			'pelanggan' => $pelanggan,
			'wilayah' => $wilayah,
			'po' => $po,
		));
	}

	function getEditPelanggan()
	{
		$id = $_POST["id"];
		$data =  $this->db->query("SELECT*FROM m_pelanggan WHERE id_pelanggan='$id'")->row();
		$prov = $this->db->query("SELECT*FROM m_provinsi")->result();
		$wilayah = $this->db->query("SELECT prov.prov_name,kab.kab_name,kec.kec_name,kel.kel_name,pel.* FROM m_pelanggan pel
		LEFT JOIN m_provinsi prov ON pel.prov=prov.prov_id
		LEFT JOIN m_kab kab ON pel.kab=kab.kab_id
		LEFT JOIN m_kec kec ON pel.kec=kec.kec_id
		LEFT JOIN m_kel kel ON pel.kel=kel.kel_id
		WHERE pel.id_pelanggan='$id'")->row();
		echo json_encode(array(
			'pelanggan' => $data,
			'prov' => $prov,
			'wilayah' => $wilayah,
		));
	}
}
