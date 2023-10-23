<?php
class M_transaksi extends CI_Model
{

	function __construct()
	{
		parent::__construct();

		date_default_timezone_set('Asia/Jakarta');
		$this->username = $this->session->userdata('username');
		$this->waktu    = date('Y-m-d H:i:s');
		$this->load->model('m_master');
	}

	function get_data_max($table, $kolom)
	{
		$query = "SELECT IFNULL(LPAD(MAX(RIGHT($kolom,4))+1,4,0),'0001')AS nomor FROM $table";
		return $this->db->query($query)->row("nomor");
	}

	function trs_po($table, $status)
	{
		$params       = (object)$this->input->post();
		$pono         = $this->m_master->get_data_max($table, 'no_po');
		$bln          = $this->m_master->get_romawi(date('m'));
		$tahun        = date('Y');
		$nopo         = 'PO/'.$tahun.'/'.$bln.'/'.$pono;

		$pelanggan    = $this->m_master->get_data_one("m_pelanggan", "id_pelanggan", $params->id_pelanggan)->row();

		$total_qty    = 0;
		foreach ($params->id_produk as $key => $value) {
			// $produk = $this->m_master->get_data_one("m_produk", "kode_mc", $params->id_produk[$key])->row();

			$data = array(
				'no_po'           => $nopo,
				'tgl_po'          => $params->tgl_po,
				'kode_po'         => $params->kode_po,
				'eta'             => $params->eta,
				'qty'             => $params->qty[$key],
				'p11'             => $params->p11[$key],
				
				'rm'              => $params->rm[$key],
				'bb'              => $params->bb[$key],
				'ton'             => $params->ton[$key],
				'harga_kg'        => $params->hrg_kg[$key],
				
				'id_produk'       => $params->id_produk[$key],
					
				'id_pelanggan'    => $pelanggan->id_pelanggan,
				'ppn'             => $params->ppn[$key],
				'price_inc'       => $params->price_inc[$key],
				'price_exc'       => $params->price_exc[$key]
			);

			if ($status == 'insert') {
				$this->db->set("add_user", $this->username);
				$result = $this->db->insert("trs_po_detail", $data);
			} else {

				$this->db->set("edit_user", $this->username);
				$this->db->set("edit_time", date('Y-m-d H:i:s'));
				$result = $this->db->update(
					"trs_po_detail",
					$data,
					array(
						'no_po' => $params->no_po,
						// 'kode_mc' => $produk->kode_mc
						'id_produk' => $params->id_produk[$key]
					)
				);
			}

			$total_qty += $params->qty[$key];
		}

		$data = array(
			'no_po'          => $nopo,
			'tgl_po'         => $params->tgl_po,
			'kode_po'        => $params->kode_po,
			'eta'            => $params->eta,
			'id_sales'       => $params->txt_marketing,
			'id_pelanggan'   => $pelanggan->id_pelanggan,
			// 'nm_pelanggan'   => $pelanggan->nm_pelanggan,
			// 'alamat'         => $pelanggan->alamat,
			// 'alamat_kirim'   => $pelanggan->alamat_kirim,
			// 'lokasi'         => $pelanggan->lokasi,
			// 'kota'           => $pelanggan->kota,
			// 'no_telp'        => $pelanggan->no_telp,
			// 'fax'            => $pelanggan->fax,
			// 'top'            => $pelanggan->top,
			'total_qty'      => $total_qty
		);

		if ($status == 'insert') {
			$this->db->set("add_user", $this->username);
			$result = $this->db->insert($table, $data);
		} else {

			$this->db->set("edit_user", $this->username);
			$this->db->set("edit_time", date('Y-m-d H:i:s'));
			$result = $this->db->update($table, $data, array('no_po' => $params->no_po));
		}

		return $result;
	}

	function trs_so_detail($table, $status)
	{
		$params = (object)$this->input->post();


		$detail_po = $this->m_master->get_data_one("trs_po", "no_po", $params->no_po)->row();

		$total_qty = 0;
		foreach ($params->id_produk as $key => $value) {
			$produk = $this->m_master->get_data_one("m_produk", "id_produk", $params->id_produk[$key])->row();

			$data = array(
				'no_so'           => $params->no_so,
				'no_po'           => $params->no_po,
				'tgl_so'          => $params->tgl_so,
				'salesman'        => $params->salesman,
				'kode_po'         => $detail_po->kode_po,
				'tgl_po'          => $params->tgl_po,
				'qty'             => $params->qty[$key],

				'kode_mc'         => $produk->kode_mc,
				'nm_produk'       => $produk->nm_produk,
				'ukuran'          => $produk->ukuran,

				'material'        => $produk->material,
				'flute'           => $produk->flute,
				'creasing'        => $produk->creasing,
				'warna'           => $produk->warna,
				'kualitas'        => $produk->kualitas,
				'jenis_produk'    => $produk->jenis_produk,
				'tipe_box'        => $produk->tipe_box,

				'id_pelanggan'    => $detail_po->id_pelanggan,
				'nm_pelanggan'    => $detail_po->nm_pelanggan,
				'alamat'          => $detail_po->alamat,
				'kota'            => $detail_po->kota,
				'no_telp'         => $detail_po->no_telp,
				'fax'             => $detail_po->fax,
				'alamat_kirim'    => $detail_po->alamat_kirim,
				'lokasi'          => $detail_po->lokasi,
				'top'             => $detail_po->top,
			);



			if ($status == 'insert') {
				$this->db->set("add_user", $this->username);
				$result = $this->db->insert("trs_so_detail", $data);
			} else {

				$this->db->set("edit_user", $this->username);
				$this->db->set("edit_time", date('Y-m-d H:i:s'));
				$result = $this->db->update(
					"trs_so_detail",
					$data,
					array(
						'no_so' => $params->no_so
					)
				);
			}

			// $total_qty += $params->qty[$key];
		}

		// sum detail po from so
		$sum_detail = $this->db->query("SELECT a.`no_po`,a.kode_mc,a.nm_produk,a.qty,IFNULL(b.qty_detail,0)qty_detail FROM `trs_po_detail` a
                        LEFT JOIN 
                        (
                        SELECT no_po,kode_mc,SUM(qty) AS qty_detail FROM `trs_so_detail` WHERE STATUS <> 'Batal'
                        AND no_po = '" . $params->no_po . "'
                        GROUP BY no_po,kode_mc
                        )b
                        ON a.`no_po` = b.no_po
                        AND a.`kode_mc` = b.kode_mc
                        WHERE a.no_po = '" . $params->no_po . "'")->result();

		$status_header = 0;

		foreach ($sum_detail as $r) {
			if ($r->qty_detail >= $r->qty) {
				$this->db->query("UPDATE trs_po_detail SET status ='Closed' 
                                WHERE no_po = '" . $r->no_po . "' AND kode_mc = '" . $r->kode_mc . "' ");
			}

			if ($r->qty_detail < $r->qty) {
				$status_header++;
			}
		}


		if ($status_header == 0) {
			$this->db->query("UPDATE trs_po SET status ='Closed' 
                                WHERE no_po = '" . $r->no_po . "'");
		}


		return $result;
	}

	function trs_wo($table, $status)
	{
		$params = (object)$this->input->post();

		if (!empty($params->no_so)) {
			// code...
			$detail_so = $this->m_master->get_data_one("trs_so_detail", "no_so", $params->no_so)->row();


			$data = array(
				'no_wo'       => $params->no_wo,
				'line'       => $params->line,
				'no_artikel'       => $params->no_artikel,
				'batchno'       => $params->batchno,
				'tgl_wo'       => $params->tgl_wo,
				'no_so'       => $detail_so->no_so,
				'tgl_so'       => $detail_so->tgl_so,
				'no_po'       => $detail_so->no_po,
				'kode_po'       => $detail_so->kode_po,
				'tgl_po'       => $detail_so->tgl_po,
				'qty'       => $detail_so->qty,
				'kode_mc'       => $detail_so->kode_mc,
				'nm_produk'     => $detail_so->nm_produk,
				'ukuran'        => $detail_so->ukuran,
				'harga'         => $detail_so->harga,
				'warna'         => $detail_so->warna,
				'kualitas'         => $detail_so->kualitas,
				'flute'         => $detail_so->flute,
				'jenis_produk'      => $detail_so->jenis_produk,
				'tipe_box'         => $detail_so->tipe_box,
				'id_pelanggan'  => $detail_so->id_pelanggan,
				'nm_pelanggan'  => $detail_so->nm_pelanggan
			);
		}

		$data_detail = array(
			'no_wo'       => $params->no_wo,
			'tgl_wo'       => $params->tgl_wo,
			'tgl_crg'     => $params->tgl_crg,
			'hasil_crg'   => $params->hasil_crg,
			'rusak_crg'   => $params->rusak_crg,
			'baik_crg'    => $params->baik_crg,
			'ket_crg'     => $params->ket_crg,
			'tgl_flx'     => $params->tgl_flx,
			'hasil_flx'   => $params->hasil_flx,
			'rusak_flx'   => $params->rusak_flx,
			'baik_flx'    => $params->baik_flx,
			'ket_flx'     => $params->ket_flx,
			'tgl_glu'     => $params->tgl_glu,
			'hasil_glu'   => $params->hasil_glu,
			'rusak_glu'   => $params->rusak_glu,
			'baik_glu'    => $params->baik_glu,
			'ket_glu'     => $params->ket_glu,
			'tgl_stc'     => $params->tgl_stc,
			'hasil_stc'   => $params->hasil_stc,
			'rusak_stc'   => $params->rusak_stc,
			'baik_stc'    => $params->baik_stc,
			'ket_stc'     => $params->ket_stc,
			'tgl_dic'     => $params->tgl_dic,
			'hasil_dic'   => $params->hasil_dic,
			'rusak_dic'   => $params->rusak_dic,
			'baik_dic'    => $params->baik_dic,
			'ket_dic'     => $params->ket_dic,
			'tgl_gdg'     => $params->tgl_gdg,
			'hasil_gdg'   => $params->hasil_gdg,
			'rusak_gdg'   => $params->rusak_gdg,
			'baik_gdg'    => $params->baik_gdg,
			'ket_gdg'     => $params->ket_gdg,
			'tgl_exp'     => $params->tgl_exp,
			'hasil_exp'   => $params->hasil_exp,
			'rusak_exp'   => $params->rusak_exp,
			'baik_exp'    => $params->baik_exp,
			'ket_exp'     => $params->ket_exp,
		);



		if ($status == 'insert') {
			$this->db->set("add_user", $this->username);
			$result = $this->db->insert("trs_wo", $data);

			$this->db->set("add_user", $this->username);
			$result = $this->db->insert("trs_wo_detail", $data_detail);

			$this->db->query("UPDATE trs_so_detail SET status ='Closed' WHERE no_so = '" . $params->no_so . "' ");
		} else {


			$data_update = array(
				'no_wo'       => $params->no_wo,
				'line'       => $params->line,
				'no_artikel'       => $params->no_artikel,
				'batchno'       => $params->batchno
			);

			$this->db->set("edit_user", $this->username);
			$this->db->set("edit_time", date('Y-m-d H:i:s'));
			$result = $this->db->update(
				"trs_wo",
				$data_update,
				array(
					'no_wo' => $params->no_wo
				)
			);


			$this->db->set("edit_user", $this->username);
			$this->db->set("edit_time", date('Y-m-d H:i:s'));
			$result = $this->db->update(
				"trs_wo_detail",
				$data_detail,
				array(
					'no_wo' => $params->no_wo
				)
			);
		}



		return $result;
	}

	function trs_surat_jalan($table, $status)
	{
		$params = (object)$this->input->post();


		foreach ($params->id_produk as $key => $value) {

			$detail_po = $this->db->query("SELECT * FROM trs_po_detail WHERE no_po = '" . $params->no_po . "' and kode_mc = '" . $params->id_produk[$key] . "'")->row();

			$data = array(
				'no_surat_jalan'       => $params->no_surat_jalan,
				'tgl_surat_jalan'       => $params->tgl_surat_jalan,
				'no_pkb'       => $params->no_pkb,
				'no_kendaraan'       => $params->no_kendaraan,

				/*'no_so'       => $detail_po->no_so,
                    'tgl_so'       => $detail_po->tgl_so,*/
				'no_po'       => $detail_po->no_po,
				'kode_po'       => $detail_po->kode_po,
				'tgl_po'       => $detail_po->tgl_po,
				'qty'       => $params->qty[$key],
				'kode_mc'       => $detail_po->kode_mc,
				'nm_produk'     => $detail_po->nm_produk,
				'flute'         => $detail_po->flute,
				'id_pelanggan'  => $detail_po->id_pelanggan,                    'nm_pelanggan'  => $detail_po->nm_pelanggan
			);



			if ($status == 'insert') {
				$this->db->set("add_user", $this->username);
				$result = $this->db->insert($table, $data);

				/*$this->db->query("UPDATE trs_wo a 
                                        LEFT JOIN 
                                        (
                                        SELECT no_po,kode_mc,SUM(qty) AS qty_sj FROM `trs_surat_jalan` WHERE STATUS <> 'Batal' GROUP BY no_po,kode_mc
                                        )AS t_sj
                                        ON a.`no_po` = t_sj.no_po
                                        and a.`kode_mc` = t_sj.kode_mc

                                        SET a.`status` = IF(qty = IFNULL(qty_sj,0) ,'Closed','Open')
                                        WHERE 
                                            a.no_po ='".$params->no_po."'
                                            AND a.kode_mc ='".$detail_po->kode_mc."'
                                        ");*/
			} else {


				/*$this->db->set("edit_user", $this->username);
                    $this->db->set("edit_time", date('Y-m-d H:i:s'));
                    $result= $this->db->update($table,$data,array(
                                                                        'no_surat_jalan' => $params->no_surat_jalan
                                                                    )
                                              );*/
			}
		}



		return $result;
	}

	function batal($id, $jenis, $field)
	{

		$this->db->set("Status", 'Batal');
		$this->db->set("edit_user", $this->username);
		$this->db->set("edit_time", date('Y-m-d H:i:s'));
		$this->db->where($field, $id);
		$query = $this->db->update($jenis);

		if ($jenis == "trs_so_detail") {
			$data = $this->db->query("SELECT * FROM trs_so_detail WHERE id ='" . $id . "' ")->row();

			$this->db->set("Status", 'Open');
			$this->db->where("no_po", $data->no_po);
			$this->db->where("kode_mc", $data->kode_mc);
			$query = $this->db->update("trs_po_detail");

			$this->db->set("Status", 'Open');
			$this->db->where("no_po", $data->no_po);
			$query = $this->db->update("trs_po");
		} else if ($jenis == "trs_wo") {
			$data = $this->db->query("SELECT * FROM trs_wo WHERE id ='" . $id . "' ")->row();

			$this->db->set("Status", 'Open');
			$this->db->where("no_so", $data->no_so);
			$query = $this->db->update("trs_so_detail");

			$this->db->set("Status", 'Batal');
			$this->db->where("no_wo", $data->no_wo);
			$query = $this->db->update("trs_wo_detail");
		} else if ($jenis == "trs_surat_jalan") {
			$data = $this->db->query("SELECT * FROM trs_surat_jalan WHERE id ='" . $id . "' ")->row();

			$this->db->set("Status", 'Open');
			$this->db->where("no_wo", $data->no_wo);
			$query = $this->db->update("trs_wo");

			$this->db->set("Status", 'Open');
			$this->db->where("no_wo", $data->no_wo);
			$query = $this->db->update("trs_wo_detail");
		}

		return $query;
	}

	function verifPO(){
		$id	= $this->input->post('id');
		$status	= $this->input->post('status');

		$app = "";

		if ($this->session->userdata('level') == "Marketing") {
			$app = "1";
		}else if ($this->session->userdata('level') == "PPIC") {
			$app = "2";
		}else if ($this->session->userdata('level') == "Owner") {
			$app = "3";
			if ($status == 'Y') {
				$this->db->set("status", 'Approve');
			}
		}

		if ($status == 'R') {
			$this->db->set("status", 'Reject');
		}


		$this->db->set("status_app".$app, $status);
		$this->db->set("user_app".$app, $this->username);
		$this->db->set("time_app".$app, $this->waktu);

		$this->db->where("no_po",$id);
		$valid = $this->db->update("trs_po");

		if ($this->session->userdata('level') == "Owner") {
			$app = "3";
			if ($status == 'Y') {
				$this->db->set("status", 'Approve');
				$this->db->where("no_po",$id);
				$valid = $this->db->update("trs_po_detail");
			}
		}

		if ($status == 'R') {
			$this->db->set("status", 'Reject');
			$this->db->where("no_po",$id);
			$valid = $this->db->update("trs_po_detail");
		}

		// KHUSUS ADMIN //

		if ($this->session->userdata('level') == "Admin") {
			$app = "3";
			if ($status == 'Y') {
				// header
				
				$this->db->set("status", 'Approve');
				$this->db->set("status_app1", $status);
				$this->db->set("user_app1", $this->username);
				$this->db->set("time_app1", $this->waktu);
				
				$this->db->set("status_app2", $status);
				$this->db->set("user_app2", $this->username);
				$this->db->set("time_app2", $this->waktu);
				
				$this->db->set("status_app3", $status);
				$this->db->set("user_app3", $this->username);
				$this->db->set("time_app3", $this->waktu);

				$this->db->where("no_po",$id);
				$valid = $this->db->update("trs_po");

				// detail
				$this->db->set("status", 'Approve');
				$this->db->where("no_po",$id);
				$valid = $this->db->update("trs_po_detail");
			}else{

				$this->db->set("status", 'Reject');
				$this->db->set("status_app1", $status);
				$this->db->set("user_app1", $this->username);
				$this->db->set("time_app1", $this->waktu);
				
				$this->db->set("status_app2", $status);
				$this->db->set("user_app2", $this->username);
				$this->db->set("time_app2", $this->waktu);
				
				$this->db->set("status_app3", $status);
				$this->db->set("user_app3", $this->username);
				$this->db->set("time_app3", $this->waktu);

				$this->db->where("no_po",$id);
				$valid = $this->db->update("trs_po");

				// detail
				$this->db->set("status", 'Reject');
				$this->db->where("no_po",$id);
				$valid = $this->db->update("trs_po_detail");
			}
		}

		return $valid;
	}

	function simpanSO()
	{
		foreach($this->cart->contents() as $r){
			$id = $r['id'];
			$no_po = $r['options']['no_po'];
			$kode_po = $r['options']['kode_po'];
			$id_produk = $r['options']['id_produk'];
			$no_so = $r['options']['no_so'];

			$this->db->set("no_so", $no_so);
			$this->db->set("tgl_so", $_POST["tgl_so"]);
			$this->db->set("status_so", 'Open');
			$this->db->set("add_time_so", date('Y-m-d H:i:s'));
			$this->db->set("add_user_so", $this->username);
			$this->db->where("id", $id);
			$this->db->where("no_po", $no_po);
			$this->db->where("kode_po", $kode_po);
			$this->db->where("id_produk", $id_produk);
			$result = $this->db->update('trs_po_detail');
		}

		return $result;
	}
}
