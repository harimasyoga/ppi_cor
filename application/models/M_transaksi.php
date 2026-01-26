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
		$params   = (object)$this->input->post();
		$id_hub   = $this->input->post('id_hub');

		$koneksi_hub    = $this->db->query("SELECT*from m_hub a
		join akses_db_hub b ON b.nm_hub=a.nm_hub where a.id_hub='$id_hub' ")->row();

		$db_ppi_hub = '$'.$koneksi_hub->nm_db_hub;
		$db_ppi_hub = $this->load->database($koneksi_hub->nm_db_hub, TRUE);

		/* LOGO */
		//$nmfile = "file_".time(); //nama file saya beri nama langsung dan diikuti fungsi time
		$config['upload_path']   = './assets/gambar_po/'; //path folder
		$config['allowed_types'] = 'gif|jpg|png|jpeg|bmp'; //type yang dapat diakses bisa anda sesuaikan
		$config['max_size']      = '1024'; //maksimum besar file 2M
		$config['max_width']     = 'none'; //lebar maksimum 1288 px
		$config['max_height']    = 'none'; //tinggi maksimu 768 px
		//$config['file_name'] = $nmfile; //nama yang terupload nantinya

		$this->load->library('upload',$config);
		$this->upload->initialize($config);

		if ($status == 'insert') 
		{
			if($_FILES['filefoto']['name'])
			{
				if ($this->upload->do_upload('filefoto'))
				{
					$gbrBukti = $this->upload->data();
					$filefoto = $gbrBukti['file_name'];
					// $filefoto    = $_FILES['filefoto']['name'];
					
				}else{
					$filefoto = 'foto.jpg';
				}
			} else {

				if($params->tgl_po<'2023-11-01')
				{
					$filefoto = 'foto.jpg';
				}else{
					$error = array('error' => $this->upload->display_errors());
					var_dump($error);
					exit;
				}
			}

		}else{
			if($_FILES['filefoto']['name'])
			{
				if ($this->upload->do_upload('filefoto'))
				{
					$gbrBukti = $this->upload->data();
					$filefoto = $gbrBukti['file_name'];
					// $filefoto    = $_FILES['filefoto']['name'];
					
				}else{
					$filefoto = 'foto.jpg';
				}
			} else {

				if($params->tgl_po<'2023-11-01')
				{
					$filefoto = 'foto.jpg';
				}else{
					// $error = array('error' => $this->upload->display_errors());
					// var_dump($error);
					// exit;

					$load_data = $this->db->query("SELECT*FROM $table where kode_po = '$params->kode_po' and no_po='$params->no_po' ")->row();

					$filefoto = $load_data->img_po;
				}
			}
			
		}
		
		/*END LOGO */
		
		$pono         = $this->m_master->get_data_max($table, 'no_po');
		$bln          = $this->m_master->get_romawi(date('m'));
		$tahun        = date('Y');
		$nopo         = 'PO/'.$tahun.'/'.$bln.'/'.$pono;

		$pelanggan    = $this->m_master->get_data_one("m_pelanggan", "id_pelanggan", $params->id_pelanggan)->row();

		$total_qty    = 0;
		foreach ($params->id_produk as $key => $value) {
			$id_produk_ = $params->id_produk[$key];
			// $produk = $this->m_master->get_data_one("m_produk", "kode_mc", $params->id_produk[$key])->row();
			// if($params->cek_rm[$key]== null)
			// {
			// 	$cek_rm = 0;
			// }else{
			// 	$cek_rm = $params->cek_rm[$key];
			// }

			$data = array(
				'tgl_po'          => $params->tgl_po,
				'kode_po'         => $params->kode_po,
				'eta'             => $params->eta_item[$key],
				'eta_ket'         => $params->eta_ket[$key],
				'cek_rm'          => 0,
				'qty'             => str_replace('.', '', $params->qty[$key]),
				'p11'             => $params->p11[$key],
				
				'rm'              => str_replace('.', '', $params->rm[$key]),
				'bb'              => $params->bb[$key],
				'ton'             => str_replace('.', '', $params->ton[$key]),
				'bhn_bk'          => str_replace('.', '', $params->bhn_bk[$key]),
				'harga_kg'        => str_replace('.', '', $params->hrg_kg[$key]),
				
				'id_produk'       => $params->id_produk[$key],
					
				'id_pelanggan'    => $pelanggan->id_pelanggan,
				'ppn'             => $params->ppn[$key],
				'price_inc'       => str_replace('.', '', $params->price_inc[$key]),
				'price_exc'       => str_replace('.', '', $params->price_exc[$key])
			);

			if ($status == 'insert') {
				// insert PPI
				$this->db->set("no_po", $nopo);
				$this->db->set("add_user", $this->username);
				$this->db->set("add_time", date("Y:m:d H:i:s"));
				$result = $this->db->insert("trs_po_detail", $data);

				// insert HUB
				if($result)
				{					
					$cek_data_ppi = $this->db->query("SELECT*FROM trs_po_detail where kode_po = '$params->kode_po' and id_produk='$id_produk_'")->row();

					$db_ppi_hub->set("id", $cek_data_ppi->id);
					$db_ppi_hub->set("no_po", $nopo);
					$db_ppi_hub->set("add_user", $this->username);
					$db_ppi_hub->set("add_time", date("Y:m:d H:i:s"));
					$result_hub_trspo = $db_ppi_hub->insert("trs_po_detail",$data);
				}else{
					$result_hub_trspo = false;
				}

				
			} else {
				// update PPI
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

				// UPDATE HUB
				if($result)
				{					
					$db_ppi_hub->set("edit_user", $this->username);
					$db_ppi_hub->set("edit_time", date('Y-m-d H:i:s'));
					$result_hub_trspo = $db_ppi_hub->update(
						"trs_po_detail",
						$data,
						array(
							'no_po' => $params->no_po,
							// 'kode_mc' => $produk->kode_mc
							'id_produk' => $params->id_produk[$key]
						));
				}else{
					$result_hub_trspo = false;
				}
			}

			$total_qty +=  str_replace('.', '', $params->qty[$key]);
		}

		$data = array(
			'tgl_po'         => $params->tgl_po,
			'kode_po'        => $params->kode_po,
			'status_karet'   => $params->status_karet,
			// 'eta'            => $params->eta,
			// 'id_sales'       => $params->txt_marketing,
			'id_pelanggan'   => $pelanggan->id_pelanggan,			
			'id_hub'         => $params->id_hub,
			// 'nm_pelanggan'   => $pelanggan->nm_pelanggan,
			// 'alamat'         => $pelanggan->alamat,
			// 'alamat_kirim'   => $pelanggan->alamat_kirim,
			// 'lokasi'         => $pelanggan->lokasi,
			// 'kota'           => $pelanggan->kota,
			// 'no_telp'        => $pelanggan->no_telp,
			// 'fax'            => $pelanggan->fax,
			// 'top'            => $pelanggan->top,
			'total_qty'      => $total_qty,
			'img_po'         => $filefoto
		);

		if ($status == 'insert') {
			
			// insert PPI
			$this->db->set("no_po", $nopo);
			$this->db->set("add_user", $this->username);
			$this->db->set("add_time", date("Y:m:d H:i:s"));
			$result = $this->db->insert($table, $data);

			// insert HUB
			if($result)
			{					
				$cek_data_ppi = $this->db->query("SELECT*FROM $table where kode_po = '$params->kode_po' and no_po='$nopo' ")->row();

				$db_ppi_hub->set("id", $cek_data_ppi->id);
				$db_ppi_hub->set("no_po", $nopo);
				$db_ppi_hub->set("add_user", $this->username);
				$db_ppi_hub->set("add_time", date("Y:m:d H:i:s"));
				$result_hub_trspo = $db_ppi_hub->insert($table, $data);
			}else{
				$result_hub_trspo = false;
			}


			// history
			history_tr('PO', 'TAMBAH_DATA', 'ADD', $nopo, '-');
		} else {

			$this->db->set("edit_user", $this->username);
			$this->db->set("edit_time", date("Y:m:d H:i:s"));
			$result = $this->db->update($table, $data, array('no_po' => $params->no_po));

			// update HUB
			if($result)
			{					
				// update ke hub					
				$db_ppi_hub->set("edit_user", $this->username);
				$db_ppi_hub->set("edit_time", date("Y:m:d H:i:s"));
				$result_hub_trspo = $db_ppi_hub->update($table, $data, array('no_po' => $params->no_po));
			}else{
				$result_hub_trspo = false;
			}
			
			// history
			history_tr('PO', 'EDIT_DATA', 'EDIT', $params->no_po, '-');
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

	function update_plan($table, $status)
	{
		$params       = $this->input->post('jenis');

		foreach ($params->id_produk as $key => $value) 
		{
			
			$tl_al   = $params->tl_al[$key];
			$bmf     = $params->bmf[$key];
			$bl      = $params->bl[$key];
			$cmf     = $params->cmf[$key];
			$cl      = $params->cl[$key];

			
			$tl_al_i = str_replace('.', '', $params->tl_al_i[$key]);
			$bmf_i   = str_replace('.', '', $params->bmf_i[$key]);
			$bl_i    = str_replace('.', '', $params->bl_i[$key]);
			$cmf_i   = str_replace('.', '', $params->cmf_i[$key]);
			$cl_i    = str_replace('.', '', $params->cl_i[$key]);

			if($params->flute[$key] == "BCF"){
				$material_plan        = $tl_al+'/'+$bmf+'/'+$bl+'/'+$cmf+'/'+$cl;
				$kualitas_isi_plan    = $tl_al_i+'/'+$bmf_i+'/'+$bl_i+'/'+$cmf_i+'/'+$cl_i;
				$kualitas_plan        = $tl_al+$tl_al_i+'/'+$bmf+$bmf_i+'/'+$bl+$bl_i+'/'+$cmf+$cmf_i+'/'+$cl+$cl_i;

			} else if($params->flute[$key] == "CF") {
				$material_plan        = $tl_al+'/'+$cmf+'/'+$cl;
				$kualitas_isi_plan    = $tl_al_i+'/'+$cmf_i+'/'+$cl_i;
				$kualitas_plan        = $tl_al+$tl_al_i+'/'+$cmf+$cmf_i+'/'+$cl+$cl_i;

			} else if($params->flute[$key] == "BF") {
				$material_plan        = $tl_al+'/'+$bmf+'/'+$bl;
				$kualitas_isi_plan    = $tl_al_i+'/'+$bmf_i+'/'+$bl_i;
				$kualitas_plan        = $tl_al+$tl_al_i+'/'+$bmf+$bmf_i+'/'+$bl+$bl_i;

			} else {
				$material_plan        = 0;
				$kualitas_isi_plan    = 0;
				$kualitas_plan        = 0;
			}

			$data = array(
				'lebar_plan'          => str_replace('.', '', $params->ii_lebar[$key]),
				'qty_plan'            => str_replace('.', '', $params->qty_plan[$key]),
				'lebar_roll_p'        => str_replace('.', '', $params->i_lebar_roll[$key]),
				'out_plan'            => str_replace('.', '', $params->out_plan[$key]),
				'trim_plan'           => str_replace('.', '', $params->trim[$key]),
				'c_off_p'             => $params->c_off[$key],
				'rm_plan'             => $params->rm_plan[$key],
				'tonase_plan'         => $params->ton_plan[$key],
				'material_plan'       => $material_plan,
				'kualitas_isi_plan'   => $kualitas_isi_plan,
				'kualitas_plan'       => $kualitas_plan,
				'status_plan'         => 'Open'


			);

			$cek = $this->db->query("SELECT*FROM plan_cor_sementara WHERE no_po='$params->no_po' and id_produk='$params->id_produk[$key]'")->num_rows();

			if ($cek>0) {
				$this->db->set("edit_user", $this->username);
				$this->db->set("edit_time", date('Y-m-d H:i:s'));
				$result = $this->db->update(
					"plan_cor_sementara",
					$data,
					array(
						'no_po' => $params->no_po,
						'id_produk' => $params->id_produk[$key]
					)
				);

			} else {
				$this->db->set("no_po", $params->no_po);
				$this->db->set("id_produk", $params->id_produk[$key]);
				$this->db->set("add_user", $this->username);
				$this->db->set("add_time", date('Y-m-d H:i:s'));
				$result = $this->db->insert("plan_cor_sementara", $data);
			}

		}

		return $result;
	}

	function trs_wo($table, $status)
	{
		$params = (object)$this->input->post();

		if (!empty($params->no_so)) {
			// code...
			// $detail_so = $this->m_master->get_data_one("trs_so_detail", "no_so", $params->no_so)->row();

			$detail_so = $this->db->query("SELECT * 
            FROM trs_so_detail a
            JOIN m_produk b ON a.id_produk=b.id_produk
            JOIN m_pelanggan c ON a.id_pelanggan=c.id_pelanggan
			JOIN trs_po_detail d ON d.no_po=a.no_po and d.kode_po=a.kode_po and d.no_so=a.no_so and d.id_produk=a.id_produk
            WHERE a.status='Open' and a.id = '$params->no_so' ")->row();

			if($detail_so->kategori=='K_BOX')
			{
				$p1_sheet   = '-';
				$p1         = $params->p1;
				$l1         = $params->l1;
				$p2         = $params->p2;
				$l2         = $params->l2;
				$flap1      = $params->flap1;
				$creasing2  = $params->creasing2;
				$flap2      = $params->flap2;
				$kupingan   = $params->kupingan;
			}else{
				$p1_sheet   = $params->p1_sheet;
				$p1         = '-';
				$l1         = '-';
				$p2         = '-';
				$l2         = '-';
				$flap1      = $params->flap1_sheet;
				$creasing2  = $params->creasing2_sheet;
				$flap2      = $params->flap2_sheet;
				$kupingan   = '-';

			}

			$data = array(
				'no_wo'         => $params->no_wo,
				// 'line'          => $params->line,
				// 'no_artikel'    => $params->no_artikel,
				// 'batchno'       => $params->batchno,
				'tgl_wo'        => $params->tgl_wo,

				'p1_sheet'		=> $params->p1_sheet,
				'p1'  			=> $p1,
				'l1'  			=> $l1,
				'p2'  			=> $p2,
				'l2'  			=> $l2,
				'flap1'  		=> $flap1,
				'creasing2'  	=> $creasing2,
				'flap2'  		=> $flap2,
				'kupingan '  	=> $kupingan,
				'no_so'         => $params->no_so,
				'tgl_so'        => $detail_so->tgl_so,
				'no_po'         => $detail_so->no_po,
				'kode_po'       => $detail_so->kode_po,
				'tgl_po'        => $detail_so->tgl_po,
				'qty'           => $detail_so->qty_so,
				'id_produk'     => $detail_so->id_produk,
				'id_pelanggan'  => $detail_so->id_pelanggan,
				'kategori'      => $detail_so->kategori,
				
			);
		}

		$data_detail = array(
			'no_wo'            => $params->no_wo,
			'tgl_wo'           => $params->tgl_wo,

			// 'tgl_crg'          => $params->tgl_crg,
			// 'hasil_crg'        => $params->hasil_crg,
			// 'rusak_crg'        => $params->rusak_crg,
			// 'baik_crg'         => $params->baik_crg,
			// 'ket_crg'          => $params->ket_crg,

			// 'tgl_flx'          => $params->tgl_flx,
			// 'hasil_flx'        => $params->hasil_flx,
			// 'rusak_flx'        => $params->rusak_flx,
			// 'baik_flx'         => $params->baik_flx,
			// 'ket_flx'          => $params->ket_flx,

			// 'tgl_glu'          => $params->tgl_glu,
			// 'hasil_glu'        => $params->hasil_glu,
			// 'rusak_glu'        => $params->rusak_glu,
			// 'baik_glu'         => $params->baik_glu,
			// 'ket_glu'          => $params->ket_glu,

			// 'tgl_stc'          => $params->tgl_stc,
			// 'hasil_stc'        => $params->hasil_stc,
			// 'rusak_stc'        => $params->rusak_stc,
			// 'baik_stc'         => $params->baik_stc,
			// 'ket_stc'          => $params->ket_stc,

			// 'tgl_dic'          => $params->tgl_dic,
			// 'hasil_dic'        => $params->hasil_dic,
			// 'rusak_dic'        => $params->rusak_dic,
			// 'baik_dic'         => $params->baik_dic,
			// 'ket_dic'          => $params->ket_dic,

			// 'tgl_asembly'      => $params->tgl_asembly,
			// 'hasil_asembly'    => $params->hasil_asembly,
			// 'rusak_asembly'    => $params->rusak_asembly,
			// 'baik_asembly'     => $params->baik_asembly,
			// 'ket_asembly'      => $params->ket_asembly,
			
			// 'tgl_sliter'       => $params->tgl_sliter,
			// 'hasil_sliter'     => $params->hasil_sliter,
			// 'rusak_sliter'     => $params->rusak_sliter,
			// 'baik_sliter'      => $params->baik_sliter,
			// 'ket_sliter'       => $params->ket_sliter,

			// 'tgl_gdg'          => $params->tgl_gdg,
			// 'hasil_gdg'        => $params->hasil_gdg,
			// 'rusak_gdg'        => $params->rusak_gdg,
			// 'baik_gdg'         => $params->baik_gdg,
			// 'ket_gdg'          => $params->ket_gdg,

			// 'tgl_exp'          => $params->tgl_exp,
			// 'hasil_exp'        => $params->hasil_exp,
			// 'rusak_exp'        => $params->rusak_exp,
			// 'baik_exp'         => $params->baik_exp,
			// 'ket_exp'          => $params->ket_exp,
		);



		if ($status == 'insert') {
			$this->db->set("add_user", $this->username);
			$result = $this->db->insert("trs_wo", $data);

			$this->db->set("add_user", $this->username);
			$result = $this->db->insert("trs_wo_detail", $data_detail);

			$this->db->query("UPDATE trs_so_detail SET status ='Close' WHERE id = '" . $params->no_so . "'"); 
		} else {

			
			$p1_sheet   = $params->p1_sheet;
			$p1         = $params->p1;
			$l1         = $params->l1;
			$p2         = $params->p2;
			$l2         = $params->l2;
			$flap1      = $params->flap1;
			$creasing2  = $params->creasing2;
			$flap2      = $params->flap2;

			$data_update = array(
				'no_wo'       	=> $params->no_wo,
				// 'line'       	=> $params->line,
				// 'no_artikel'    => $params->no_artikel,
				// 'batchno'       => $params->batchno,

				'p1_sheet'		=> $p1_sheet,
				'p1'  			=> $p1,
				'l1'  			=> $l1,
				'p2'  			=> $p2,
				'l2'  			=> $l2,
				'flap1'  		=> $flap1,
				'creasing2'  	=> $creasing2,
				'flap2'  		=> $flap2,
				'kupingan'  	=> $params->kupingan,
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

		// $this->db->set("Status", 'Batal');
		// $this->db->set("edit_user", $this->username);
		// $this->db->set("edit_time", date('Y-m-d H:i:s'));
		// $this->db->where($field, $id);
		// $query = $this->db->update($jenis);

		// if ($jenis == "trs_so_detail") {
		// 	$data = $this->db->query("SELECT * FROM trs_so_detail WHERE id ='" . $id . "' ")->row();

		// 	$this->db->set("Status", 'Open');
		// 	$this->db->where("no_po", $data->no_po);
		// 	$this->db->where("kode_mc", $data->kode_mc);
		// 	$query = $this->db->update("trs_po_detail");

		// 	$this->db->set("Status", 'Open');
		// 	$this->db->where("no_po", $data->no_po);
		// 	$query = $this->db->update("trs_po");
		// } else if ($jenis == "trs_wo") {
			$cekPlan = $this->db->query("SELECT*FROM plan_cor WHERE id_wo='$id'");
			if($cekPlan->num_rows() == 0){
				$data = $this->db->query("SELECT * FROM trs_wo WHERE id ='" . $id . "' ")->row();

				$this->db->set("Status", 'Open');
				$this->db->where("id", $data->no_so);
				$query = $this->db->update("trs_so_detail");
	
				$this->db->where("no_wo", $data->no_wo);
				$query = $this->db->delete("trs_wo_detail");
	
				$this->db->where("no_wo", $data->no_wo);
				$query = $this->db->delete("trs_wo");
			}else{
				$query = false;
			}
		// }
		// else if ($jenis == "trs_surat_jalan") {
		// 	$data = $this->db->query("SELECT * FROM trs_surat_jalan WHERE id ='" . $id . "' ")->row();

		// 	$this->db->set("Status", 'Open');
		// 	$this->db->where("no_wo", $data->no_wo);
		// 	$query = $this->db->update("trs_wo");

		// 	$this->db->set("Status", 'Open');
		// 	$this->db->where("no_wo", $data->no_wo);
		// 	$query = $this->db->update("trs_wo_detail");
		// }

		return $query;
	}

	function verifPO()
	{
		$id             = $this->input->post('id');
		$status         = $this->input->post('status');
		$alasan         = $this->input->post('alasan');

		// $koneksi_hub    = $this->db->query("SELECT *from trs_po a 
		// Join m_hub b ON a.id_hub=b.id_hub 
		// Join akses_db_hub c ON b.nm_hub=c.nm_hub
		// WHERE no_po='$id'")->row();

		// $db_ppi_hub = '$'.$koneksi_hub->nm_db_hub;
		// $db_ppi_hub = $this->load->database($koneksi_hub->nm_db_hub, TRUE);

		if($status == 'Y')
		{
			$stts    = 'VERIFIKASI';
			if (in_array($this->session->userdata('level'), ['Owner','Admin']) )
			{
				$sts     = 'Approve';
			}else{
				$sts     = 'Open';
			}
		}else if($status == 'H'){
			$stts    = 'HOLD';
			$sts     = 'Open';
		}else{
			$stts    = 'REJECT';
			$sts     = 'Reject';
		}		

		$app      = "";

		// KHUSUS ADMIN
		if ($this->session->userdata('level') == "Admin") 
		{

			// TRS PO
			$data = array(
				'status'        => $sts,
				'status_app1'   => $status,
				'user_app1'     => $this->username,
				'time_app1'     => $this->waktu,
				'ket_acc1'      => $alasan,
				'status_app2'   => $status,
				'user_app2'     => $this->username,
				'time_app2'     => $this->waktu,
				'ket_acc2'      => $alasan,
				'status_app3'   => $status,
				'user_app3'     => $this->username,
				'time_app3'     => $this->waktu,
				'ket_acc3'      => $alasan,
			);

			$this->db->where("no_po",$id);
			$update_trs_po = $this->db->update("trs_po", $data);
			// UPDATE HUB
			// if($update_trs_po)
			// {
			// 	$db_ppi_hub->where("no_po",$id);
			// 	$verif_data = $db_ppi_hub->update("trs_po", $data);
			// }else{
			// 	$verif_data = false;
			// }

			// TRS PO DETAIL
			$this->db->set("status", $sts);
			$this->db->where("no_po", $id);
			$update_trs_po_detail = $this->db->update("trs_po_detail");

			// UPDATE HUB
			// if($update_trs_po_detail)
			// {
			// 	$db_ppi_hub->set("status", $sts);
			// 	$db_ppi_hub->where("no_po",$id);
			// 	$verif_data_detail = $db_ppi_hub->update("trs_po_detail");
			// }else{
			// 	$verif_data_detail = false;
			// }

			// history
			history_tr('PO', 'VERIFIKASI_PO_ADMIN', $stts, $id, '-');
			
			$msg = 'Data Berhasil Diproses';

		}else {
			$cekPO         = $this->db->query("SELECT*FROM trs_po WHERE no_po='$id'");
			$cekPO_detail  = $this->db->query("SELECT * FROM trs_po a join trs_po_detail b on a.kode_po=b.kode_po join m_produk c on b.id_produk=c.id_produk where b.no_po in ('$id') ");
			
			$expired       = strtotime($cekPO->row()->add_time) + (48*60*60);
			$actualDate    = time();

			if($this->session->userdata('level') != "Owner" && $actualDate > $expired || $actualDate == $expired)
			{
				$update_trs_po          = false;
				$update_trs_po_detail   = false;
				$msg                    = 'TIDAK BISA '.$stts.' SUDAH EXPIRED';
			}else{
				// UPDATE TRS PO

				if ($this->session->userdata('level') == "Marketing") {
					$app = "1";		
				}else if ($this->session->userdata('level') == "PPIC") {
					$app = "2";
				}else if ($this->session->userdata('level') == "Owner") {
					$app = "3";
					if($status == 'Y')
					{
						foreach ($cekPO_detail->result() as $row)
						{
							stok_bahanbaku($row->kode_po, $row->id_hub, $row->tgl_po, 'HUB', 0, $row->bhn_bk, 'KELUAR DENGAN PO', 'KELUAR',$row->id_produk);
						}
					}
				}

				$data_verif_po = array(
					'status'             => $sts,
					'status_app'.$app    => $status,
					'user_app'.$app      => $this->username,
					'time_app'.$app      => $this->waktu,
					'ket_acc'.$app       => $alasan,
				);

				$this->db->where("no_po",$id);
				$update_trs_po = $this->db->update("trs_po",$data_verif_po);

				// UPDATE HUB
				// if($update_trs_po)
				// {					
				// 	$db_ppi_hub->where("no_po",$id);
				// 	$verif_data_po = $db_ppi_hub->update("trs_po",$data_verif_po);
				// }else{
				// 	$verif_data_po = false;
				// }

				// history
				history_tr('PO', 'VERIFIKASI_PO', $stts, $id, $alasan);

				// UPDATE TRS PO DETAIL
				$this->db->set("status", $sts);
				$this->db->where("no_po",$id);
				$update_trs_po_detail = $this->db->update("trs_po_detail");
				// UPDATE HUB
				// if($update_trs_po_detail)
				// {							
				// 	$db_ppi_hub->set("status", $sts);
				// 	$db_ppi_hub->where("no_po",$id);
				// 	$verif_data_detail = $db_ppi_hub->update("trs_po_detail");
				// }else{
				// 	$verif_data_detail = false;
				// }

				$msg = 'Data Berhasil Diproses';
			}
		}

		return [
			'update_trs_po' => $update_trs_po,
			'update_trs_po_detail' => $update_trs_po_detail,
			'msg' => $msg,
		];
	}

	function save_dev_sys($data)
	{
		$status_input = $this->input->post('sts_input');
		if($status_input == 'add')
		{

			$this->db->insert('trs_dev_sys', $data);
			return $this->db->insert_id(); // kembalikan ID
			
		}else{
			
			// $no_inv_bhn    = $this->input->post('no_inv_bhn');

			// $data_header = array(
			// 	'no_inv_bhn'    => $no_inv_bhn,
			// 	'tgl_inv_bhn'   => $this->input->post('tgl_inv'),
			// 	'id_stok_d'   	=> $this->input->post('id_stok_d'),
			// 	'no_stok'   	=> $this->input->post('no_stok'),
			// 	'id_hub'        => $this->input->post('id_hub'),
			// 	'ket'           => $this->input->post('ket'),
			// 	'qty'           => str_replace('.','',$this->input->post('qty')), 
			// 	'nominal'       => str_replace('.','',$this->input->post('nom')),
			// 	'total_bayar'   => str_replace('.','',$this->input->post('total_bayar')),
			// 	'acc_owner'     => 'N',
			// );

			// $this->db->where('id_inv_bhn', $this->input->post('id_inv_bhn'));
			// $result_header = $this->db->update('invoice_bhn', $data_header);
			// return $result_header;
		}
		
	}
	
	function simpanSO()
	{
		foreach($this->cart->contents() as $r){
			$id = $r['id'];
			$no_po = $r['options']['no_po'];
			$kode_po = $r['options']['kode_po'];
			$id_produk = $r['options']['id_produk'];
			$no_so = $r['options']['no_so'];
			$id_pelanggan = $r['options']['id_pelanggan'];
			$jml_so = $r['options']['jml_so'];

			if($this->session->userdata('level') == 'PPIC'){
				$wH = "AND add_user='ppic'";
				$no = 1;
				$tglSO = $_POST["tgl_so"];
				$addUser = strtolower($this->session->userdata('level'));
			}else{
				$wH = "AND add_user!='ppic'";
				$no = 50;
				$tglSO = $r['options']['eta_po'];
				$addUser = $this->username;
			}
			$tmbhUrutSo = $this->db->query("SELECT urut_so FROM trs_so_detail
			WHERE id_pelanggan='$id_pelanggan' AND no_po='$no_po' AND kode_po='$kode_po' $wH
			ORDER BY urut_so DESC LIMIT 1");
			($tmbhUrutSo->num_rows() == 0) ? $urut = $no : $urut = $tmbhUrutSo->row()->urut_so + 1;
			$data = array(
				'id_pelanggan' => $id_pelanggan,
				'id_produk' => $id_produk,
				'eta_so' => $tglSO,
				'no_po' => $no_po,
				'kode_po' => $kode_po,
				'no_so' => $no_so,
				'urut_so' => $urut,
				'rpt' => 1,
				'qty_so' => $jml_so,
				'status' => 'Open',
				'status_2' => 'Open',
				'ket_so' => '',
				'rm' => $r['options']['rm'],
				'ton' => $r['options']['ton'],
				'add_time' => date('Y-m-d H:i:s'),
				'add_user' => $addUser,
			);
			$result = $this->db->insert('trs_so_detail', $data);

			if($this->session->userdata('level') == 'PPIC'){
				$this->db->set("tgl_so_p", $_POST["tgl_so"]);
				$this->db->set("no_so_p", $no_so);
			}else{
				$this->db->set("no_so", $no_so);
				$this->db->set("tgl_so", $_POST["tgl_so"]);
				$this->db->set("status_so", 'Open');
				$this->db->set("add_time_so", date('Y-m-d H:i:s'));
				$this->db->set("add_user_so", $this->username);
			}
			$this->db->where("id", $id);
			$this->db->where("no_po", $no_po);
			$this->db->where("kode_po", $kode_po);
			$this->db->where("id_produk", $id_produk);
			$result = $this->db->update('trs_po_detail');
		}

		return $result;
	}

	function editBagiSO()
	{
		$id = $_POST["i"];

		if($_POST["editTglSo"] == ""){
			$result = array(
				'data' => false,
				'msg' => 'ETA SO TIDAK BOLEH KOSONG!',
			);
		}else if($_POST["editQtySo"] == 0 || $_POST["editQtySo"] == ""){
			$result = array(
				'data' => false,
				'msg' => 'QTY SO TIDAK BOLEH KOSONG!',
			);
		}else if($_POST["editQtySo"] > $_POST["editQtypoSo"]){
			$result = array(
				'data' => false,
				'msg' => 'QTY SO LEBIH DARI QTY PO!',
			);
		}else{
			$produk = $this->db->query("SELECT p.* FROM m_produk p INNER JOIN trs_so_detail s ON p.id_produk=s.id_produk WHERE s.id='$id' GROUP BY p.id_produk");
			$RumusOut = 1800 / $produk->row()->ukuran_sheet_l;
			(floor($RumusOut) >= 5) ? $out = 5 : $out = (floor($RumusOut));
			$rm = ($produk->row()->ukuran_sheet_p * $_POST["editQtySo"] / $out) / 1000;
			$ton = $_POST["editQtySo"] * $produk->row()->berat_bersih;

			$data = array(
				"eta_so" => $_POST["editTglSo"],
				"qty_so" => $_POST["editQtySo"],
				"ket_so" => $_POST["editKetSo"],
				"cek_rm_so" => ($rm < 500) ? $_POST["editCekRM"] : 0,
				"rm" => round($rm),
				"ton" => round($ton),
				"edit_time" => date('Y-m-d H:i:s'),
				"edit_user" => $this->username,
			);

			if($_POST["editCekRM"] == 0){
				if($rm < 500){
					$insert = false;
					$msg = 'RM '.round($rm).' . RM KURANG!';
				}else{
					$this->db->where("id", $id);
					$insert = $this->db->update('trs_so_detail', $data);
					$msg = 'BERHASIL EDIT DATA!';
				}
			}else{
				if(round($rm) == 0 || round($ton) == 0 || round($rm) < 0 || round($ton) < 0 || $rm == "" || $ton == "" ){
					$insert = false;
					$msg = 'RM '.round($rm).' . RM / TONASE TIDAK BOLEH KOSONG!';
				}else{
					$this->db->where("id", $id);
					$insert = $this->db->update('trs_so_detail', $data);
					$msg = 'BERHASIL EDIT DATA!';
				}
			}

			$result = array(
				'data' => $insert,
				'msg' => $msg,
				'p' => $produk->row()->ukuran_sheet_p, 'l' => $produk->row()->ukuran_sheet_l, 'bb' => $produk->row()->berat_bersih, 'RumusOut' => $RumusOut, 'out' => $out, 'rm' => $rm, 'ton' => $ton,
			);
		}

		return $result;
	}

	function simpanCartItemSO()
	{
		foreach($this->cart->contents() as $r){
			$data = array(
				'id_pelanggan' => $r['options']['id_pelanggan'],
				'id_produk' => $r['options']['id_produk'],
				'eta_so' => $r['options']['eta_so'],
				'no_po' => $r['options']['no_po'],
				'kode_po' => $r['options']['kode_po'],
				'no_so' => $r['options']['no_so'],
				'urut_so' => $r['options']['urut_so'],
				'rpt' => $r['options']['rpt'],
				'qty_so' => $r['options']['qty_so'],
				'status' => 'Open',
				'status_2' => 'Open',
				'ket_so' => $r['options']['ket_so'],
				'cek_rm_so' => ($r['options']['rm'] < 500) ? $r['options']['cek_rm_so'] : 0,
				'rm' => $r['options']['rm'],
				'ton' => $r['options']['ton'],
				'add_time' => date('Y-m-d H:i:s'),
				'add_user' => $this->username,
			);
			$result = $this->db->insert('trs_so_detail', $data);
		}
		return $result;
	}

	function batalDataSO()
	{
		$this->db->where('id', $_POST["i"]);
		$result = $this->db->delete('trs_so_detail');
		return array(
			'data' => $result,
			'msg' => 'BERHASIL BATAL DATA SO!'
		);
	}

	function hapusListSO()
	{
		$id = $_POST["id"];
		$getSoDetail = $this->db->query("SELECT*FROM trs_po_detail WHERE id='$id'")->row();
		$cekWo = $this->db->query("SELECT*FROM trs_wo
		WHERE no_po='$getSoDetail->no_po' AND kode_po='$getSoDetail->kode_po'
		GROUP BY no_po,kode_po;");

		// $cH = $this->db->

		if($cekWo->num_rows() != 0 && $this->session->userdata('level') != 'PPIC'){
			return array(
				'data' => false,
				'msg' => 'SO SUDAH MASUK WO!'
			);
		}else{
			$this->db->where('no_po', $getSoDetail->no_po);
			$this->db->where('kode_po', $getSoDetail->kode_po);
			$this->db->where('id_produk', $getSoDetail->id_produk);
			$this->db->where('add_user', ($this->session->userdata('level') == 'PPIC') ? 'ppic' : $this->username);
			$hapusDetailSO = $this->db->delete('trs_so_detail');

			if($this->session->userdata('level') == 'PPIC'){
				$this->db->set('tgl_so_p', null);
				$this->db->set('no_so_p', null);
			}else{
				$this->db->set('no_so', null);
				$this->db->set('tgl_so', null);
				$this->db->set('status_so', null);
				$this->db->set('add_time_so', '0000-00-00 00:00:00');
				$this->db->set('add_user_so', null);
			}
			$this->db->where('no_po', $getSoDetail->no_po);
			$this->db->where('kode_po', $getSoDetail->kode_po);
			$this->db->where('id_produk', $getSoDetail->id_produk);
			$updateDetailPO = $this->db->update('trs_po_detail');

			return array(
				'hapusDetailSO' => $hapusDetailSO,
				'updateDetailPO' => $updateDetailPO,
				'data' => true,
				'msg' => 'BERHASIL HAPUS DATA SO!',
			);
		}
	}

	function btnSOHasil()
	{
		$id = $_POST["id"];
		$hasil_pcs = $_POST["hasil_pcs"];

		if($hasil_pcs == '' || $hasil_pcs == 0 || $hasil_pcs < 0){
			$data = false;
			$msg = 'HASIL PCS KOSONG / SALAH!';
		}else{
			$sO = $this->db->query("SELECT*FROM trs_so_detail WHERE id='$id'")->row();
			$soHasil = array(
				'id_so_dtl' => $id,
				'hasil_tgl' => $sO->eta_so,
				'hasil_qty' => $hasil_pcs,
			);
			$data = $this->db->insert('trs_so_hasil', $soHasil);
			$msg = 'BERHASIL!';
		}

		return [
			'id' => $id,
			'hasil_pcs' => $hasil_pcs,
			'data' => $data,
			'msg' => $msg,
		];
	}

	function cbOSHasil()
	{
		$id = $_POST["id"];
		$cbhs = $_POST["cbhs"];

		$cek = $this->db->query("SELECT*FROM trs_so_detail WHERE id='$id'")->row();
		if($cek->cek_st_2 == 0){
			$this->db->set('cek_st_2', 1);
			$this->db->set('status_2', 'Close');
		}else{
			$this->db->set('cek_st_2', 0);
			$this->db->set('status_2', 'Open');
		}
		$this->db->where('id', $id);
		$data = $this->db->update('trs_so_detail');

		return [
			'id' => $id,
			'cbhs' => $cbhs,
			'data' => $data,
		];
	}

	function hapusOSList()
	{
		$id = $_POST["id"];

		$this->db->where('id', $id);
		$data = $this->db->delete('trs_so_hasil');

		return [
			'data' => $data,
		];
	}

	function addRollCorr()
	{
		$opsi = $_POST["opsi"];
		$tgl_pm = $_POST["tgl_pm"];
		$tgl_gudang = $_POST["tgl_gudang"];

		$db9 = $this->load->database('database_simroll', TRUE);
		if($opsi == 'pm'){
			$qR = $db9->query("SELECT*FROM m_timbangan WHERE tgl='$tgl_pm' AND nm_ker!='WP' AND (status='2' OR status='4' OR status='5' OR status='6' OR status='7') ORDER BY roll");
		}
		if($opsi == 'gudang'){
			$qR = $db9->query("SELECT t.* FROM m_timbangan t
			INNER JOIN pl p ON t.id_pl=p.id
			WHERE p.tgl='$tgl_gudang' AND t.nm_ker NOT IN ('WP','WS') AND t.cor_at IS NOT NULL AND t.cor_by IS NOT NULL
			ORDER BY t.nm_ker,t.g_label,t.width,t.pm,t.roll");
		}

		foreach($qR->result() as $r){
			$cek = $this->db->query("SELECT*FROM m_roll WHERE roll='$r->roll' AND id_roll='$r->id'");
			if($cek->num_rows() == 0){
				($opsi == 'pm') ? $o = 'PM' : $o = 'FG';
				$berat = $r->weight - $r->seset;
				$rL = array(
					't_cor' => 'CA',
					'roll' => $r->roll,
					'i_tgl' => $tgl_gudang,
					'nm_ker' => $r->nm_ker,
					'g_label' => $r->g_label,
					'width' => $r->width,
					'diameter' => $r->diameter,
					'weight' => $berat,
					'joint' => $r->joint,
					'ket' => $r->ket,
					'status_r' => $r->status,
					'g_ac' => $r->g_ac,
					'rct' => $r->rct,
					'bi' => $r->bi,
					'cobb' => $r->cobb,
					'moisture' => $r->moisture,
					'rm' => $r->rm,
					'dari' => $o,
					'created_at' => date('Y-m-d H:i:s'),
					'created_by' => $this->username,
					'id_roll' => $r->id,
				);
				$data = $this->db->insert("m_roll", $rL);
			}else{
				$data = true;
			}
		}
		$msg = 'BERHASIL!';

		return [
			'data' => $data,
			'msg' => $msg,
		];
	}

	function editRollCorr()
	{
		$id = $_POST["id"];
		$cab = $_POST["corcab"];

		$this->db->set('t_cor', $cab);
		$this->db->where('id', $id);
		$data = $this->db->update('m_roll');

		return [
			'data' => $data,
		];
	}

	function btnGunaSisa()
	{
		$tgl_guna = $_POST["tgl_guna"];
		$roll = $_POST["roll"];
		$guna = $_POST["guna"];
		$sisa = $_POST["sisa"];
		$ket = $_POST["ket"];

		$qR = $this->db->query("SELECT*FROM m_roll WHERE id='$roll'")->row();
		$ay = array(
			'tgl' => $tgl_guna,
			'id_roll' => $roll,
			'roll' => $qR->roll,
			'pemakaian' => $guna,
			'sisa' => $sisa,
			'ket' => $ket,
		);
		$data = $this->db->insert("trs_so_guna", $ay);
		if($data){
			// seset
			($qR->seset == 0) ? $seset = $guna : $seset = $qR->seset + $guna;
			$this->db->set('seset', $seset);
			$this->db->where('id', $roll);
			$uRoll = $this->db->update('m_roll');
			if($uRoll){
				// JIKA BERAT == SESET : DICLOSE
				$cR = $this->db->query("SELECT*FROM m_roll WHERE id='$roll'")->row();
				if($cR->weight == $cR->seset){
					$this->db->set('status_p', 'Close');
					$this->db->where('id', $roll);
					$cRoll = $this->db->update('m_roll');
				}else{
					$cRoll = false;
				}
			}
		}
		return [
			'data' => $data,
			'uRoll' => $uRoll,
			'cRoll' => $cRoll,
		];
	}

	function delRollGuna()
	{
		$id_guna = $_POST["id"];
		$id_roll = $_POST["roll"];

		$qG = $this->db->query("SELECT*FROM trs_so_guna WHERE id='$id_guna'")->row();
		$qR = $this->db->query("SELECT*FROM m_roll WHERE id='$id_roll'")->row();

		// update seset
		$seset = $qR->seset - $qG->pemakaian;
		if($qR->weight == $qR->seset){
			$this->db->set('status_p', 'Open');
		}
		$this->db->set('seset', $seset);
		$this->db->where('id', $id_roll);
		$uRoll = $this->db->update('m_roll');
		if($uRoll){
			// delete guna
			$this->db->where('id', $id_guna);
			$data = $this->db->delete('trs_so_guna');
		}

		return [
			'uRoll' => $uRoll,
			'data' => $data,
		];
	}

	function btnPatokanRoll()
	{
		$t_cor = $_POST["t_cor"];
		$width = $_POST["width"];
		$ptk = $_POST["ptk"];

		$cek = $this->db->query("SELECT*FROM m_roll_ptk WHERE t_cor='$t_cor' AND width='$width'");

		if($ptk < 0){
			$data = false;
			$msg = "SALAH";
		}else{
			$aR = array(
				't_cor' => $t_cor,
				'width' => $width,
				'ptk' => $ptk,
			);
			if($cek->num_rows() == 0){
				$data = $this->db->insert('m_roll_ptk', $aR);
				$msg = "BERHASIL!";
			}else{
				$this->db->set('ptk', $ptk);
				$this->db->where('t_cor', $t_cor);
				$this->db->where('width', $width);
				$data = $this->db->update('m_roll_ptk', $aR);
				$msg = "BERHASIL UPDATE!";
			}
		}

		return [
			'data' => $data,
			'msg' => $msg,
		];
	}

	function simpanHPP()
	{
		$statusInput = $_POST["statusInput"];
		$rentang_tahun = $_POST["rentang_tahun"];
		$rentang_bulan = $_POST["rentang_bulan"];
		$rentang_bulan_tahun = $_POST["rentang_bulan_tahun"];
		if($rentang_bulan != "" && $rentang_bulan_tahun != ""){
			$tahunHPP = $rentang_bulan_tahun;
		}else{
			($rentang_tahun == "") ? $tahunHPP = null : $tahunHPP = $rentang_tahun;
		}

		$data = [
			'pilih_hpp' => $_POST["pilih_hpp"],
			'rentang_hpp' => $_POST["rentang"],
			'tahun_hpp' => $tahunHPP,
			'bulan_hpp' => ($_POST["rentang_bulan"] == "") ? null : $_POST["rentang_bulan"],
			'tgl_hpp' => ($_POST["rentang_tanggal"] == "") ? null : $_POST["rentang_tanggal"],
			'jenis_hpp' => $_POST["jenis_hpp"],
			'bahan_baku_kg' => ($_POST["bahan_baku_kg"] == "") ? 0 : $_POST["bahan_baku_kg"],
			'bahan_baku_rp' => ($_POST["bahan_baku_rp"] == "") ? 0 : $_POST["bahan_baku_rp"],
			'bahan_baku_x' => $_POST["bahan_baku_x"],
			'tenaga_kerja' => $_POST["tenaga_kerja"],
			'upah' => ($_POST["upah"] == "") ? 0 : $_POST["upah"],
			'thr' => $_POST["thr"],
			'listrik' => $_POST["listrik"],
			'batu_bara_kg' => $_POST["batu_bara_kg"],
			'batu_bara_rp' => $_POST["batu_bara_rp"],
			'batu_bara_x' => $_POST["batu_bara_x"],
			'chemical_kg' => $_POST["chemical_kg"],
			'chemical_rp' => $_POST["chemical_rp"],
			'chemical_x' => $_POST["chemical_x"],
			'bahan_pembantu' => $_POST["bahan_pembantu"],
			'solar' => $_POST["solar"],
			'maintenance' => $_POST["biaya_pemeliharaan"],
			'ekspedisi' => $_POST["ekspedisi"],
			'depresiasi' => $_POST["depresiasi"],
			'lain_lain_kg' => ($_POST["lain_lain_kg"] == "") ? 0 : $_POST["lain_lain_kg"],
			'lain_lain_rp' => ($_POST["lain_lain_rp"] == "") ? 0 : $_POST["lain_lain_rp"],
			'hasil_hpp' => $_POST["hasil_hpp"],
			'hasil_hpp_tanpa_bb' => $_POST["hasil_hpp_tanpa_bb"],
			'tonase_order' => $_POST["tonase_order"],
			'hasil_x_tonase' => $_POST["hasil_x_tonase"],
			'hasil_x_tonase_tanpa_bb' => $_POST["hasil_x_tonase_tanpa_bb"],
			'hxt_x_persen' => $_POST["hxt_x_persen"],
			'hpp_pm' => $_POST["hpp_pm"],
			'hpp_sheet' => $_POST["hpp_sheet"],
			'hpp_plus_plus' => $_POST["hpp_plus_plus"],
			'presentase' => $_POST["presentase"],
			'fix_hpp' => $_POST["fix_hpp"],
			'fix_hpp_aktual' => $_POST["fix_hpp_aktual"],
		];

		if(($_POST["pilih_hpp"] == 'PM2' || $_POST["pilih_hpp"] == 'SHEET' || $_POST["pilih_hpp"] == 'BOX' || $_POST["pilih_hpp"] == 'LAMINASI') && ($_POST["hasil_hpp"] == '' || $_POST["tonase_order"] == '' || $_POST["hasil_x_tonase"] == '' || $_POST["hasil_hpp"] == 0 || $_POST["tonase_order"] == 0 || $_POST["hasil_x_tonase"] == 0)){
			$insertHPP = false; $msg = 'DATA HPP KOSONG!'; $cek = ''; $cart = '';
		}else if(($_POST["pilih_hpp"] == 'SHEET' || $_POST["pilih_hpp"] == 'BOX' || $_POST["pilih_hpp"] == 'LAMINASI') && ($_POST["bahan_baku_x"] == '' || $_POST["bahan_baku_x"] == 0)){
			$insertHPP = false; $msg = 'DATA BAHAN BAKU KOSONG!'; $cek = ''; $cart = '';
		}else if(($_POST["pilih_hpp"] == 'SHEET' || $_POST["pilih_hpp"] == 'BOX' || $_POST["pilih_hpp"] == 'LAMINASI') && $_POST["pilih_id_hpp"] == '' && $statusInput == 'insert'){
			$insertHPP = false; $msg = 'PILIH HPP DAHULU!'; $cek = ''; $cart = '';
		}else{
			$pilih_hpp = $_POST["pilih_hpp"];
			$pilih_id_hpp = $_POST["pilih_id_hpp"];
			$rentang = $_POST["rentang"];
			$jenis_hpp = $_POST["jenis_hpp"];
			$rentang_tanggal = $_POST["rentang_tanggal"];
			if($rentang == 'TAHUN'){
				$periode = "AND tahun_hpp='$rentang_tahun'";
			}else if($rentang == 'BULAN'){
				$periode = "AND bulan_hpp='$rentang_bulan' AND tahun_hpp='$rentang_bulan_tahun'";
			}else{
				$periode = "AND tgl_hpp='$rentang_tanggal'";
			}
			$cek = $this->db->query("SELECT*FROM m_hpp WHERE pilih_hpp='$pilih_hpp' AND jenis_hpp='$jenis_hpp' AND rentang_hpp='$rentang' $periode")->num_rows();

			if($statusInput == 'insert'){
				if($cek == 0){
					$this->db->set('add_time', date('Y-m-d H:i:s'));
					$this->db->set('add_user', $this->username);
					$insertHPP = $this->db->insert('m_hpp', $data);
					// CART
					if($insertHPP){
						// UPDATE CEK
						$get = $this->db->query("SELECT*FROM m_hpp WHERE pilih_hpp='$pilih_hpp' AND jenis_hpp='$jenis_hpp' AND rentang_hpp='$rentang' $periode")->row();
						if($pilih_hpp != 'PM2'){
							$this->db->set('edit_time', date('Y-m-d H:i:s'));
							$this->db->set('edit_user', $this->username);
							if($pilih_hpp == 'SHEET'){
								$this->db->set('cek_sheet', $get->id_hpp);
							}else if($pilih_hpp == 'BOX'){
								$this->db->set('cek_box', $get->id_hpp);
							}else if($pilih_hpp == 'LAMINASI'){
								$this->db->set('cek_laminasi', $get->id_hpp);
							}
							$this->db->where('id_hpp', $pilih_id_hpp);
							$this->db->update('m_hpp');
						}

						if($this->cart->total_items() != 0){
							foreach($this->cart->contents() as $r){
								$this->db->set('id_hpp', $get->id_hpp);
								$this->db->set('opsi', $r['options']['opsi']);
								$this->db->set('jenis', $r['options']['jenis']);
								$this->db->set('ket_txt', $r['options']['ket_txt']);
								$this->db->set('ket_kg', $r['options']['ket_kg']);
								$this->db->set('ket_rp', $r['options']['ket_rp']);
								$this->db->set('ket_x', $r['options']['ket_x']);
								$cart = $this->db->insert('m_hpp_detail');
							}
						}else{
							$cart = '';
						}
					}
					$msg = 'OK!';
				}else{
					$insertHPP = false;
					$msg = 'DATA SUDAH ADA!';
					$cart = '';
				}
			}

			if($statusInput == 'update'){
				$this->db->set('edit_time', date('Y-m-d H:i:s'));
				$this->db->set('edit_user', $this->username);
				$this->db->where('id_hpp', $_POST["id_hpp"]);
				$insertHPP = $this->db->update('m_hpp', $data);
				// CART
				if($insertHPP){
					if($this->cart->total_items() != 0){
						foreach($this->cart->contents() as $r){
							$this->db->set('id_hpp', $_POST["id_hpp"]);
							$this->db->set('opsi', $r['options']['opsi']);
							$this->db->set('jenis', $r['options']['jenis']);
							$this->db->set('ket_txt', $r['options']['ket_txt']);
							$this->db->set('ket_kg', $r['options']['ket_kg']);
							$this->db->set('ket_rp', $r['options']['ket_rp']);
							$this->db->set('ket_x', $r['options']['ket_x']);
							$cart = $this->db->insert('m_hpp_detail');
						}
					}else{
						$cart = '';
					}
				}
				$msg = 'OK!';
			}
		}

		return [
			'data' => $data,
			'cek' => $cek,
			'valid' => $insertHPP,
			'msg' => $msg,
			'cart' => $cart,
		];
	}

	function hapusKetEditHPP()
	{
		$id_dtl = $_POST["id_dtl"];
		$id_hpp = $_POST["id_hpp"];
		$jenis = $_POST["jenis"];
		$ooo = $_POST["ooo"];
		$opsi = $_POST["opsi"];

		$detail = $this->db->query("SELECT*FROM m_hpp_detail WHERE id='$id_dtl'")->row();
		($ooo == 'upah') ? $pengurangan = $detail->ket_rp : $pengurangan = $detail->ket_x;

		$this->db->where('id', $id_dtl);
		$delete_dtl = $this->db->delete('m_hpp_detail');

		if($delete_dtl){
			$data = $this->db->query("SELECT SUM(ket_kg) AS ket_kg,SUM(ket_rp) AS ket_rp,SUM(ket_x) AS ket_x FROM m_hpp_detail
			WHERE id_hpp='$id_hpp' AND opsi='$ooo' AND jenis='$jenis' GROUP BY id_hpp,opsi,jenis");
			if($data->num_rows() > 0){
				$ket_kg = $data->row()->ket_kg;
				$ket_rp = $data->row()->ket_rp;
				$ket_x = $data->row()->ket_x;
			}else{
				$ket_kg = 0; $ket_rp = 0; $ket_x = 0;
			}
			
			$hpp = $this->db->query("SELECT*FROM m_hpp WHERE id_hpp='$id_hpp'")->row();
			$hasil_hpp = $hpp->hasil_hpp - $pengurangan;
			$hasil_x_tonase = round(($hpp->hasil_hpp - $pengurangan) / $hpp->tonase_order);
			
			if($ooo == 'bb'){
				$hxt_tanpa_bb = $hpp->hasil_hpp_tanpa_bb;
				$hasil_x_tonase_tanpa_bb = $hpp->hasil_x_tonase_tanpa_bb;
			}else{
				$hxt_tanpa_bb = $hpp->hasil_hpp_tanpa_bb - $pengurangan;
				$hasil_x_tonase_tanpa_bb = round(($hpp->hasil_hpp_tanpa_bb - $pengurangan) / $hpp->tonase_order);
			}
			$hxt_x_persen = round(($hxt_tanpa_bb * ($hpp->presentase / 100)));
			$fix_hpp = $hxt_tanpa_bb + round(($hxt_tanpa_bb * ($hpp->presentase / 100)));

			$this->db->set('edit_time', date('Y-m-d H:i:s'));
			$this->db->set('edit_user', $this->username);
			$this->db->set('hasil_hpp', $hasil_hpp);
			$this->db->set('hasil_x_tonase', $hasil_x_tonase);
			$this->db->set('hasil_hpp_tanpa_bb', $hxt_tanpa_bb);
			$this->db->set('hasil_x_tonase_tanpa_bb', $hasil_x_tonase_tanpa_bb);
			$this->db->set('hxt_x_persen', $hxt_x_persen);
			$this->db->set('fix_hpp', $fix_hpp);
			if($ooo == 'upah'){
				$this->db->set('upah', $ket_rp);
				$this->db->where('id_hpp', $id_hpp);
				$u_upah = $this->db->update('m_hpp'); $u_bb = ''; $u_dll = '';
			}else if($ooo == 'bb'){
				if($jenis = 'pm'){
					$this->db->set('bahan_baku_kg', $ket_kg);
					$this->db->set('bahan_baku_rp', $ket_x);
					$this->db->where('id_hpp', $id_hpp);
					$u_bb = $this->db->update('m_hpp'); $u_upah = ''; $u_dll = '';
				}else{
					$u_bb = 'bb sheet'; $u_upah = ''; $u_dll = '';
				}
			}else{ // lainlain
				$this->db->set('lain_lain_kg', $ket_kg);
				$this->db->set('lain_lain_rp', $ket_x);
				$this->db->where('id_hpp', $id_hpp);
				$u_dll = $this->db->update('m_hpp'); $u_upah = ''; $u_bb = '';
			}
		}

		return [
			'01_delete_dtl' => $delete_dtl,
			'02_u_upah' => $u_upah,
			'03_u_bb' => $u_bb,
			'04_u_dll' => $u_dll,
			'05_pengurangan' => $pengurangan,
			'06_hasil_hpp' => $hpp->hasil_hpp - $pengurangan,
			'07_tonase_order' => $hpp->tonase_order,
			'08_hasil_x_tonase' => round(($hpp->hasil_hpp - $pengurangan) / $hpp->tonase_order),
			'09_hasil_hpp' => $hpp->hasil_hpp,
			'10_hxt_tanpa_bb' => $hxt_tanpa_bb,
			'11_hasil_x_tonase_tanpa_bb' => $hasil_x_tonase_tanpa_bb,
			'12_hxt_x_persen' => $hxt_x_persen,
			'13_fix_hpp' => $fix_hpp,
		];
	}

	function hapusHPP()
	{
		$id_hpp = $_POST["id_hpp"];
		$getPMcekLam = $this->db->query("SELECT*FROM m_hpp WHERE pilih_hpp='PM2' AND cek_laminasi='$id_hpp'");
		$getPMcekSheet = $this->db->query("SELECT*FROM m_hpp WHERE pilih_hpp='PM2' AND cek_sheet='$id_hpp'");
		$getSHEETcekBox = $this->db->query("SELECT*FROM m_hpp WHERE pilih_hpp='SHEET' AND cek_box='$id_hpp'");

		// DELETE HPP
		$this->db->where('id_hpp', $_POST["id_hpp"]);
		$delete = $this->db->delete('m_hpp');
		if($delete){
			// DELETE HPP DETAIL
			$this->db->where('id_hpp', $_POST["id_hpp"]);
			$detail = $this->db->delete('m_hpp_detail');
			if($detail){
				// UPDATE CEK SHEET BOX LAMINASI
				if($getPMcekLam->num_rows() == 1 && $getPMcekSheet->num_rows() == 0 && $getSHEETcekBox->num_rows() == 0){
					$this->db->set('cek_laminasi', 'N');
					$this->db->where('id_hpp', $getPMcekLam->row()->id_hpp);
				}else if($getPMcekLam->num_rows() == 0 && $getPMcekSheet->num_rows() == 0 && $getSHEETcekBox->num_rows() == 1){
					$this->db->set('cek_box', 'N');
					$this->db->where('id_hpp', $getSHEETcekBox->row()->id_hpp);
				}else if($getPMcekLam->num_rows() == 0 && $getPMcekSheet->num_rows() == 1 && $getSHEETcekBox->num_rows() == 0){
					$this->db->set('cek_sheet', 'N');
					$this->db->where('id_hpp', $getPMcekSheet->row()->id_hpp);
				}
				if($getPMcekLam->num_rows() == 0 && $getPMcekSheet->num_rows() == 0 && $getSHEETcekBox->num_rows() == 0){
					$updateHPP = false;
				}else{
					$updateHPP = $this->db->update('m_hpp');
				}
			}
		}

		return [
			'delete' => $delete,
			'detail' => $detail,
			'updateHPP' => $updateHPP,
		];
	}

	function save_po_bb()
	{
		$thn          = date('Y');
		$sts_input    = $this->input->post('sts_input');
		$aka          = $this->input->post('aka');

		if($sts_input=='edit')
		{
			$no_po_bhn    = $this->input->post('no_po_old');
			
			// delete detail
			$del_detail = $this->db->query("DELETE FROM trs_po_bhnbk_detail where no_po_bhn='$no_po_bhn' ");

			$rowloop     = $this->input->post('bucket');
			for($loop = 0; $loop <= $rowloop; $loop++)
			{
				$data_detail = array(				
					'no_po_bhn'     => $no_po_bhn,
					'kode_po'     	=> $this->input->post('po_jual['.$loop.']'),
				);

				$result_detail = $this->db->insert('trs_po_bhnbk_detail', $data_detail);

			}		

			// header
			$data_header = array(			
				'no_po_bhn'  => $no_po_bhn,
				'tgl_bhn'    => $this->input->post('tgl_po'),
				'hub'        => $this->input->post('hub'),
				'hrg_bhn'    => str_replace('.','',$this->input->post('harga')),
				'ton_bhn'    => str_replace('.','',$this->input->post('ton')),
				'total'      => str_replace('.','',$this->input->post('total_po')),
	
			);
	
			$this->db->where('id_po_bhn', $this->input->post('id_po_bhn'));
			$result_header = $this->db->update('trs_po_bhnbk', $data_header);

		}else{
			$no_po_bhn    = $this->m_fungsi->urut_transaksi('PO_BAHAN').'/'.$aka.'/'.$thn;

			// detail
			$rowloop     = $this->input->post('bucket');
			for($loop = 0; $loop <= $rowloop; $loop++)
			{
				$data_detail = array(				
					'no_po_bhn'     => $no_po_bhn,
					'kode_po'     	=> $this->input->post('po_jual['.$loop.']'),
				);

				$result_detail = $this->db->insert('trs_po_bhnbk_detail', $data_detail);

			}		

			// header
			$data_header = array(			
				'no_po_bhn'  => $no_po_bhn,
				'tgl_bhn'    => $this->input->post('tgl_po'),
				'hub'        => $this->input->post('hub'),
				'hrg_bhn'    => str_replace('.','',$this->input->post('harga')),
				'ton_bhn'    => str_replace('.','',$this->input->post('ton')),
				'total'      => str_replace('.','',$this->input->post('total_po')),
	
			);
			$result_header = $this->db->insert('trs_po_bhnbk', $data_header);

		}

		return $result_header;
			
	}

	function simpanCartLaminasi()
	{
		if($_POST["statusInput"] == 'insert'){
			$no_po = str_replace(' ', '',$_POST["no_po"]);
			$cek = $this->db->query("SELECT*FROM trs_po_lm WHERE no_po_lm='$no_po'");
			if($cek->num_rows() == 0){
				$data_po = [
					'tgl_lm' => $_POST["tgl"],
					'jenis_lm' => $_POST["jenis_lm"],
					'id_pelanggan' => $_POST["customer"],
					'id_sales' => $_POST["id_sales"],
					'id_hub' => $_POST["attn"],
					'no_po_lm' => $_POST["no_po"],
					'note_po_lm' => $_POST["note_po_lm"],
					'status_lm1' => 'Y',
					'user_lm1' => $this->username,
					'time_lm1' => date('Y-m-d H:i:s'),
					'ket_lm1' => 'OK',
					'add_time' => date('Y-m-d H:i:s'),
					'add_user' => $this->username,
				];
				$insertPO = $this->db->insert("trs_po_lm", $data_po);
			}else{
				$insertPO = false;
			}
		}else{
			$insertPO = true;
		}

		if($insertPO){
			foreach($this->cart->contents() as $r){
				$data = array(
					'id_m_produk_lm' => $r['options']['item'],
					'no_po_lm' => $r['options']['no_po'],
					'order_sheet_lm' => $r['options']['order_sheet'],
					'order_pack_lm' => $r['options']['order_pack'],
					'order_ikat_lm' => $r['options']['order_ikat'],
					'jenis_order_lm' => $r['options']['jenis_qty_lm'],
					'order_pori_lm' => $r['options']['order_pori'],
					'qty_bal' => $r['options']['qty_bal'],
					'harga_lembar_lm' => $r['options']['harga_lembar'],
					'harga_pack_lm' => $r['options']['harga_pack'],
					'harga_ikat_lm' => $r['options']['harga_ikat'],
					'harga_pori_lm' => $r['options']['harga_pori'],
					'harga_total_lm' => $r['options']['harga_total'],
					'add_time' => date('Y-m-d H:i:s'),
					'add_user' => $this->username,
				);
				$insertPOdtl = $this->db->insert('trs_po_lm_detail', $data);
			}
		}else{
			$insertPOdtl = false;
		}
		
		return [
			'insertPO' => $insertPO,
			'insertPOdtl' => $insertPOdtl,
		];
	}

	function btnVerifLaminasi()
	{
		if($_POST["ket_laminasi"] == '' && ($_POST["aksi"] == 'H' || $_POST["aksi"] == 'R')){
			$result = false;
		}else{
			if($_POST["aksi"] == 'H'){
				$status = 'Open';
			}else if($_POST["aksi"] == 'R'){
				$status = 'Reject';
			}else if($_POST["aksi"] == 'Y' && $_POST["status_verif"] == 'marketing'){
				$status = 'Open';
			}else{
				$status = 'Approve';
			}
			($_POST["status_verif"] == 'marketing') ? $i = 1 : $i = 2 ;
			$this->db->set('status_lm', $status);
			$this->db->set('status_lm'.$i, $_POST["aksi"]);
			$this->db->set('user_lm'.$i, $this->username);
			$this->db->set('time_lm'.$i, date('Y-m-d H:i:s'));
			$this->db->set('ket_lm'.$i, ($_POST["aksi"] == 'Y' && $_POST["ket_laminasi"] == '') ? 'OK' : $_POST["ket_laminasi"]);
			$this->db->where('id', $_POST["id_po_lm"]);
			$result = $this->db->update('trs_po_lm');

			// if($_POST["aksi"] == 'Y' && $result == true){
			// 	$id = $_POST["id_po_lm"];
			// 	$po_lm = $this->db->query("SELECT*FROM trs_po_lm WHERE id='$id'")->row();
			// 	$po_dtl = $this->db->query("SELECT*FROM trs_po_lm_detail d WHERE d.no_po_lm='$po_lm->no_po_lm'");
			// 	foreach($po_dtl->result() as $r){
			// 		$data = [
			// 			'tgl' => date('Y-m-d'),
			// 			'no_po_lm' => $po_lm->no_po_lm,
			// 			'id_trs_po_lm' => $id,
			// 			'id_trs_po_dtl' => $r->id,
			// 			'id_produk_lm' => $r->id_m_produk_lm,
			// 			'qty_isi' => $r->order_sheet_lm,
			// 			'qty_pack' => $r->order_pack_lm,
			// 			'qty_ikat' => $r->order_ikat_lm,
			// 			'qty_ball' => $r->qty_bal,
			// 			'add_time' => date('Y-m-d H:i:s'),
			// 		];
			// 		$gudang_pkl = $this->db->insert("m_gudang_pkl", $data);
			// 	}
			// }else{
			// 	$gudang_pkl = false;
			// }
		}

		return [
			'result' => $result,
			// 'gudang_pkl' => $gudang_pkl,
		];
	}

	function bukaAccPOLam()
	{
		$opsi = $_POST["opsi"];
		$id = $_POST["id_po_lm"];

		if($opsi == 'acc'){
			$this->db->set('status_lm2', 'Y');
		}else if($opsi == 'edit'){
			$this->db->set('status_lm2', 'N');
		}else{
			$this->db->set('status_lm', 'Open');
			$this->db->set('status_lm2', 'N');
			$this->db->set('user_lm2', null);
			$this->db->set('time_lm2', null);
			$this->db->set('ket_lm2', null);
		}
		$this->db->where('id', $id);
		$data = $this->db->update('trs_po_lm');

		return [
			'data' => $data,
		];
	}

	function btnDiscPOLM()
	{
		$id = $_POST["id_po_header"];
		$ps_opsi = $_POST["ps_opsi"];
		$ps_disc = $_POST["ps_disc"];
		$ps_fee = $_POST["ps_fee"];
		// !preg_match("/^[0-9]*$/", $_POST["muat"]
		if($ps_opsi == ''){
			$data = false;
			$msg = 'HARAP LENGKAPI FORM!';
		}else if($ps_opsi == 'DISKON' && ($ps_disc == '' || $ps_disc == 0 || $ps_disc < 0 || $ps_disc > 100)){
			$data = false;
			$msg = 'HARAP LENGKAPI FORM DISKON!';
		}else if($ps_opsi == 'FEE' && ($ps_fee == '' || $ps_fee == 0 || $ps_fee < 0 || $ps_fee > 100)){
			$data = false;
			$msg = 'HARAP LENGKAPI FORM FEE!';
		}else if($ps_opsi == 'DISKONFEE' && ($ps_disc == '' || $ps_disc == 0 || $ps_disc < 0 || $ps_disc > 100 || $ps_fee == '' || $ps_fee == 0 || $ps_fee < 0 || $ps_fee > 100)){
			$data = false;
			$msg = 'HARAP LENGKAPI FORM DISKON+FEE!';
		}else{
			if($ps_opsi == 'DISKON'){
				$this->db->set('disc_lm', $ps_disc);
				$this->db->set('fee_lm', null);
			}
			if($ps_opsi == 'FEE'){
				$this->db->set('disc_lm', null);
				$this->db->set('fee_lm', $ps_fee);
			}
			if($ps_opsi == 'DISKONFEE'){
				$this->db->set('disc_lm', $ps_disc);
				$this->db->set('fee_lm', $ps_fee);
			}
			$this->db->set('opsi_disc', $ps_opsi);
			$this->db->where('id', $id);
			$data = $this->db->update('trs_po_lm');
			$msg = 'BERHASIL TAMBAH '.$ps_opsi.'!';
		}
		return [
			'data' => $data,
			'msg' => $msg,
		];
	}

	function hapusDiscPOLM()
	{
		$id = $_POST["id_po_header"];
		$this->db->set('disc_lm', null);
		$this->db->set('fee_lm', null);
		$this->db->set('opsi_disc', null);
		$this->db->where('id', $id);
		$data = $this->db->update('trs_po_lm');
		return [
			'data' => $data,
		];
	}

	function konfirmasiSplitPO()
	{
		$id = $_POST["id_po_header"];
		$s_attn = $_POST["s_attn"];
		$po_lm = $this->db->query("SELECT*FROM trs_po_lm WHERE id='$id'")->row();
		$po_dtl = $this->db->query("SELECT*FROM trs_po_lm_detail d INNER JOIN m_produk_lm p ON d.id_m_produk_lm=p.id_produk_lm WHERE d.no_po_lm='$po_lm->no_po_lm'");
		$kiriman = $this->db->query("SELECT SUM(qty_muat) AS qty_muat FROM m_rk_laminasi WHERE id_po_lm='$id' AND rk_urut!='0' AND rk_status='Close' GROUP BY id_m_produk_lm,id_po_lm,id_po_dtl");
		if($id == "" || $s_attn == ""){
			$header = false; $data = false; $msg = "PILIH ATTN!"; $i_header = false; $i_detail = false; $u_detail = false;
		}else if($s_attn == $po_lm->id_hub){
			$header = false; $data = false; $msg = "ATTN SAMA DENGAN SEBELUMNYA!"; $i_header = false; $i_detail = false; $u_detail = false;
		}else{
			if($kiriman->num_rows() == 0){
				// CUMA GANTI ATTN
				$i_header = false;
				$i_detail = false;
				$ghub = $this->db->query("SELECT*FROM m_hub WHERE id_hub='$po_lm->id_hub'");
				($ghub->num_rows() == 0) ? $nm_hub = '' : $nm_hub = $ghub->row()->aka;
				$header = array(
					'note_po_lm' => 'GANTI ATTN!. '.$nm_hub,
					'id_hub' => $s_attn,
					'status_kirim' => 'Open',
					'edit_time' => date('Y-m-d H:i:s'),
					'edit_user' => $this->username,
				);
				$this->db->set('id_hub', $id);
				$this->db->where('id', $id);
				$u_detail = $this->db->update('trs_po_lm', $header);
				$data = true;
				$msg = "update!";
			}else{
				// PO DI SPLIT
				$cekPOSplit = $this->db->query("SELECT*FROM trs_po_lm WHERE id='$id' AND split IS NULL");
				if($cekPOSplit->num_rows() == 1){
					$nn = '-S.1';
					$ss = 1;
					$noSplit = $po_lm->no_po_lm.$nn;
				}else{
					$ns = explode('-S.', $po_lm->no_po_lm);
					$ss = $po_lm->split+1;
					$nn = '-S.'.$ss;
					$noSplit = $ns[0].$nn;
				}
				$header = array(
					'tgl_lm' => $po_lm->tgl_lm,
					'jenis_lm' => $po_lm->jenis_lm,
					'id_pelanggan' => $po_lm->id_pelanggan,
					'id_sales' => $po_lm->id_sales,
					'id_hub' => $s_attn,
					'no_po_lm' => $noSplit,
					'status_lm' => 'Approve',
					'note_po_lm' => 'SPLIT PO!',
					'status_lm1' => 'Y',
					'user_lm1' => $this->username,
					'time_lm1' => $po_lm->time_lm1,
					'ket_lm1' => 'OK!',
					'status_lm2' => 'Y',
					'status_kirim' => 'Open',
					'status_pkl' => 'Open',
					'user_lm2' => $this->username,
					'time_lm2' => $po_lm->time_lm2,
					'ket_lm2' => 'OK!',
					'add_time' => date('Y-m-d H:i:s'),
					'add_user' => $this->username,
					'split' => $ss,
				);
				// INSERT PO SPLIT
				$i_header = $this->db->insert('trs_po_lm', $header);
				if($i_header){
					foreach($po_dtl->result() as $rs){
						if($rs->jenis_qty_lm == 'pack'){
							$s_qty_2 = $rs->pack_lm;
						}else if($rs->jenis_qty_lm == 'ikat'){
							$s_qty_2 = $rs->ikat_lm;
						}else{
							$s_qty_2 = $rs->kg_lm;
						}
						// CEK KIRIMAN
						$s_kiriman = $this->db->query("SELECT SUM(qty_muat) AS qty_muat FROM m_rk_laminasi WHERE id_po_lm='$id' AND id_po_dtl='$rs->id' AND rk_urut!='0' AND rk_status='Close'
						GROUP BY id_m_produk_lm,id_po_lm,id_po_dtl");
						($s_kiriman->num_rows() == 0) ? $s_muat = 0 : $s_muat = $s_kiriman->row()->qty_muat;
						// QTY PO
						$s_sisa2 = $rs->qty_bal - $s_muat;
						// TAMPIL JIKA MASIH ADA SISA PO
						if($s_sisa2 != 0){
							// ORDER LEMBAR DAN ORDER PACK
							$s_order2 = $s_sisa2 * $s_qty_2;
							$s_lembar = $s_order2 * $rs->isi_lm;
							// HARGA TOTAL
							$s_harga = $s_order2 * $rs->harga_pori_lm;
							$detail = array(
								'id_m_produk_lm' => $rs->id_m_produk_lm,
								'no_po_lm' => $noSplit,
								'jenis_order_lm' => $rs->jenis_order_lm,
								'order_sheet_lm' => $s_lembar,
								'order_pack_lm' => $rs->order_pack_lm,
								'order_ikat_lm' => $rs->order_ikat_lm,
								'order_pori_lm' => $s_order2,
								'qty_bal' => $s_sisa2,
								'harga_lembar_lm' => $rs->harga_lembar_lm,
								'harga_pack_lm' => $rs->harga_pack_lm,
								'harga_ikat_lm' => $rs->harga_ikat_lm,
								'harga_pori_lm' => $rs->harga_pori_lm,
								'harga_total_lm' => $s_harga,
								'add_time' => date('Y-m-d H:i:s'),
								'add_user' => $this->username,
							);
							// UPDATE PO SPLIT DETAIL
							$i_detail = $this->db->insert('trs_po_lm_detail', $detail);
							if($i_detail){
								foreach($po_dtl->result() as $rl){
									if($rl->jenis_qty_lm == 'pack'){
										$l_qty_2 = $rl->pack_lm;
									}else if($rl->jenis_qty_lm == 'ikat'){
										$l_qty_2 = $rl->ikat_lm;
									}else{
										$l_qty_2 = $rl->kg_lm;
									}
									// CEK KIRIMAN
									$l_kiriman = $this->db->query("SELECT SUM(qty_muat) AS qty_muat FROM m_rk_laminasi WHERE id_po_lm='$id' AND id_po_dtl='$rl->id' AND rk_urut!='0' AND rk_status='Close'
									GROUP BY id_m_produk_lm,id_po_lm,id_po_dtl");
									($l_kiriman->num_rows() == 0) ? $l_muat = 0 : $l_muat = $l_kiriman->row()->qty_muat;
									// QTY PO
									$l_sisa2 = $rl->qty_bal - $l_muat;
									// TAMPIL JIKA MASIH ADA SISA PO
									if(($l_sisa2 != 0 || $l_sisa2 == 0) && $l_muat != 0){
										// ORDER LEMBAR DAN ORDER PACK
										$l_order2 = $l_muat * $l_qty_2;
										$l_lembar = $l_order2 * $rl->isi_lm;
										// HARGA TOTAL
										$l_harga = $l_order2 * $rl->harga_pori_lm;
										$detail_lama = array(
											'order_sheet_lm' => $l_lembar,
											'order_pori_lm' => $l_order2,
											'qty_bal' => $l_muat,
											'harga_total_lm' => $l_harga,
											'edit_time' => date('Y-m-d H:i:s'),
											'edit_user' => $this->username,
										);
										$this->db->where('id', $rl->id);
										$u_detail = $this->db->update('trs_po_lm_detail', $detail_lama);
									}else{
										// HAPUS JIKA BELUM ADA YANG TERKIRIM
										$this->db->where('id', $rl->id);
										$u_detail = $this->db->delete('trs_po_lm_detail');
									}
								}
							}
						}
					}
				}
				$data = true;
				$msg = "insert!";
			}
		}
		return [
			'header' => $header,
			'i_header' => $i_header,
			'i_detail' => $i_detail,
			'u_detail' => $u_detail,
			'data' => $data,
			'msg' => $msg,
		];
	}

	function editListLaminasi()
	{
		$id = $_POST["id_po_header"];
		$po_lm = $this->db->query("SELECT*FROM trs_po_lm WHERE id='$id'")->row();
		if($_POST["harga_pori"] == 0 || $_POST["harga_total"] == 0 || $_POST["harga_pori"] == '' || $_POST["harga_total"] == ''){
			$updatePOdtl = false;
			$msg = 'HARGA TIDAK BOLEH KOSONG!';
		}else if($po_lm->opsi_disc != ''){
			$updatePOdtl = false;
			$msg = 'HAPUS DISKON / FEE DAHULU!';
		}else{
			$this->db->set('edit_time', date('Y-m-d H:i:s'));
			$this->db->set('edit_user', $this->username);
			$this->db->where('id', $_POST["id_po_header"]);
			$updatePO = $this->db->update('trs_po_lm');
			
			if($updatePO){
				$editData = array(
					// 'id_m_produk_lm' => $_POST[""],
					'order_sheet_lm' => $_POST["order_sheet"],
					'order_pori_lm' => $_POST["order_pori"],
					'qty_bal' => $_POST["qty_bal"],
					'harga_lembar_lm' => $_POST["harga_lembar"],
					'harga_pori_lm' => $_POST["harga_pori"],
					'harga_total_lm' => $_POST["harga_total"],
					'edit_time' => date('Y-m-d H:i:s'),
					'edit_user' => $this->username,
				);
				$this->db->where('id', $_POST["id_po_detail"]);
				$updatePOdtl = $this->db->update('trs_po_lm_detail', $editData);
			}
			$msg = 'BERHASIL EDIT!';
		}
		return [
			'updatePOdtl' => $updatePOdtl,
			'msg' => $msg,
		];
	}

	function generateFileName()
	{
		$stringSpace = '0123456789_abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$stringLength = strlen($stringSpace);
		$string = str_repeat($stringSpace, ceil(11 / $stringLength));
		$shuffledString = str_shuffle($string);
		$code = substr($shuffledString, 1, 11);
		return $code;
	}

	function UploadFilePORoll()
	{
		$hidhdr = $this->input->post('hidhdr');
		$tgl = $this->input->post('tgl');
		$no_po = $this->input->post('no_po');
		$pajak = $this->input->post('pajak');
		$nm_pelanggan = $this->input->post('nm_pelanggan');
		$id_pt = $this->input->post('id_pt');
		$id_sales = $this->input->post('id_sales');
		$jenis_file = $this->input->post('jenis_file');
		// CEK NO PO
		$cek = $this->db->query("SELECT*FROM trs_po_roll_header	WHERE no_po='$no_po' AND nm_pelanggan='$nm_pelanggan'");
		// FILE
		($hidhdr == '') ? $nmFile = $_FILES['filefoto']['name'] : $nmFile = 'update';
		$config['upload_path'] = './assets/gambar_po_roll/';
		$config['allowed_types'] = 'jpg|jpeg|png';
		$config['overwrite'] = true;
		$thn = substr(date('Y'), 2, 2); $bln = date('m'); $date = date('d');
		$config['file_name'] = $thn.$bln.$date.'-'.$this->generateFileName();
		$this->load->library('upload',$config);
		$this->upload->initialize($config);

		if($tgl == '' && $hidhdr == ''){
			$data = false; $msg = 'HARAP PILIH TANGGAL!';
		}else if($nm_pelanggan == '' && $hidhdr == ''){
			$data = false; $msg = 'HARAP PILIH NAMA CUSTOMER!';
		}else if($no_po == '' && $hidhdr == ''){
			$data = false; $msg = 'HARAP ISI NO. PO!';
		}else if($pajak == '' && $hidhdr == ''){
			$data = false; $msg = 'HARAP PILIH PAJAK!';
		}else if($id_sales == '' && $hidhdr == ''){
			$data = false; $msg = 'HARAP PILIH MARKETING!';
		}else if($nmFile == '' && $hidhdr == ''){
			$data = false; $msg = 'HARAP PILIH FILE!';
		}else if($cek->num_rows() > 0 && $hidhdr == ''){
			$data = false; $msg = 'NO. PO SUDAH ADA!';
		}else if(!$this->upload->do_upload('filefoto') && $hidhdr == '') {
			$data = false; $msg = 'UKURAN / FORMAT FILE TIDAK DIDUKUNG!';
		}else{
			if($hidhdr != ''){
				$getHdrU = $this->db->query("SELECT*FROM trs_po_roll_header WHERE id_hdr='$hidhdr'")->row();
				if($this->upload->do_upload('updatefilefoto')){
					$gbrBukti_u = $this->upload->data();
					$filefoto_u = $gbrBukti_u['file_name'];
					$this->db->set('id_hdr', $hidhdr);
					$this->db->set('no_po', $getHdrU->no_po);
					$this->db->set('ket_po', $jenis_file);
					$this->db->set('nm_file', $filefoto_u);
					$data = $this->db->insert('trs_po_roll_detail');
					$msg = 'Tambah file!';
				}
			}else{
				$dh = [
					'tgl_po' => $tgl,
					'no_po' => $no_po,
					'pajak' => $pajak,
					'id_pt' => $id_pt,
					'nm_pelanggan' => $nm_pelanggan,
					'id_sales' => $id_sales,
					'creat_at' => date('Y-m-d H:i:s'),
					'creat_by' => $this->username,
				];
				$header = $this->db->insert('trs_po_roll_header', $dh);
				if($header){
					if($this->upload->do_upload('filefoto')){
						$getHdr = $this->db->query("SELECT*FROM trs_po_roll_header WHERE tgl_po='$tgl' AND no_po='$no_po' AND nm_pelanggan='$nm_pelanggan'")->row();
						$gbrBukti = $this->upload->data();
						$filefoto = $gbrBukti['file_name'];
						$dtl = [
							'id_hdr' => $getHdr->id_hdr,
							'no_po' => $no_po,
							'ket_po' => $jenis_file,
							'nm_file' => $filefoto,
						];
						$detail = $this->db->insert('trs_po_roll_detail', $dtl);
						if($detail){
							foreach($this->cart->contents() as $r){
								$data = array(
									'id_hdr' => $getHdr->id_hdr,
									'no_po' => $no_po,
									'nm_ker' => $r['options']['jenis'],
									'g_label' => $r['options']['gsm'],
									'width' => $r['options']['ukuran'],
									'tonase' => $r['options']['berat'],
									'jml_roll' => $r['options']['qty'],
									'harga' => $r['options']['harga'],
									'ket' => $r['options']['ket'],
									'stat' => $r['options']['stat'],
								);
								$item = $this->db->insert('trs_po_roll_item', $data);
								if($item){
									$data = true; $msg = 'OK!';
								}else{
									$data = false; $msg = 'GAGAL INSERT ITEM!';
								}
							}
						}else{
							$data = false; $msg = 'GAGAL INSERT ITEM!';
						}
					}else{
						$data = false; $msg = 'GAGAL INSERT DETAIL!';
					}
				}else{
					$data = false; $msg = 'GAGAL UPLOAD FILE!';
				}
			}
		}
		return [
			'data' => $data,
			'msg' => $msg,
		];
	}

	function btnVerifPORoll()
	{
		if($_POST["ket_roll"] == '' && ($_POST["aksi"] == 'H' || $_POST["aksi"] == 'R')){
			$result = false;
		}else{
			if($_POST["aksi"] == 'H'){
				$status = 'Open';
			}else if($_POST["aksi"] == 'R'){
				$status = 'Reject';
			}else if($_POST["aksi"] == 'Y' && $_POST["status_verif"] == 'marketing'){
				$status = 'Open';
			}else{
				$status = 'Approve';
			}
			if($_POST["status_verif"] == 'marketing'){
				$vstatus = 'mkt_status';
				$vuser = 'mkt_user';
				$vtime = 'mkt_time';
				$vket = 'mkt_ket';
			}else{
				$vstatus = 'owner_status';
				$vuser = 'owner_user';
				$vtime = 'owner_time';
				$vket = 'owner_ket';
			}
			$this->db->set('status_po', $status);
			$this->db->set($vstatus, $_POST["aksi"]);
			$this->db->set($vuser, $this->username);
			$this->db->set($vtime, date('Y-m-d H:i:s'));
			$this->db->set($vket, ($_POST["aksi"] == 'Y' && $_POST["ket_roll"] == '') ? 'OK' : $_POST["ket_roll"]);
			$this->db->where('id_hdr', $_POST["id_hdr"]);
			$result = $this->db->update('trs_po_roll_header');
		}

		return [
			'result' => $result,
		];
	}

	function hapusPORoll()
	{
		$id_hdr = $_POST["id_hdr"];
		$detail = $this->db->query("SELECT*FROM trs_po_roll_detail WHERE id_hdr='$id_hdr'");
		// HAPUS FILE
		foreach($detail->result() as $r){
			unlink("assets/gambar_po_roll/".$r->nm_file);
		}
		// HAPUS ITEM
		$this->db->where("id_hdr", $id_hdr);
		$itm = $this->db->delete("trs_po_roll_item");
		if($itm){
			// HAPUS DETAIL
			$this->db->where("id_hdr", $id_hdr);
			$hdtl = $this->db->delete("trs_po_roll_detail");
			if($hdtl){
				// HAPUS HEADER
				$this->db->where("id_hdr", $id_hdr);
				$hhdr = $this->db->delete("trs_po_roll_header");
			}
		}
		return [
			'itm' => $itm,
			'hdtl' => $hdtl,
			'hhdr' => $hhdr,
		];
	}

	function gF2()
	{
		$stringSpace = '0123456789_abcdefghijklmnopqrstuvwxyz';
		$stringLength = strlen($stringSpace);
		$string = str_repeat($stringSpace, ceil(11 / $stringLength));
		$shuffledString = str_shuffle($string);
		$code = substr($shuffledString, 1, 11);
		return $code;
	}

	function InputPORoll()
	{
		$id_hdr = $_POST["id_hdr"];
		$db_ppi = $this->load->database('database_simroll', TRUE);

		$header = $this->db->query("SELECT*FROM trs_po_roll_header WHERE id_hdr='$id_hdr'")->row();
		$detail = $this->db->query("SELECT*FROM trs_po_roll_item WHERE id_hdr='$id_hdr' AND no_po='$header->no_po' ORDER BY nm_ker,g_label,width");

		$thn = substr(date('Y'), 2, 2);
		$bln = date('m');
		$date = date('d');
		$idPO = 'x'.$header->id_pt.'.'.$thn.$bln.$date.'.'.$this->generateFileName();
		foreach($detail->result() as $r){
			$items = array(
				'id_po' => $idPO,
				'id_perusahaan' => $header->id_pt,
				'tgl' => $header->tgl_po,
				'nm_ker' => $r->nm_ker,
				'g_label' => $r->g_label,
				'width' => $r->width,
				'jml_roll' => $r->jml_roll,
				'no_po' => $r->no_po,
				'pajak' => $header->pajak,
				'tonase' => ($r->tonase == null) ? 0 : $r->tonase,
				'harga' => ($r->harga == null) ? 0 : $r->harga,
				'status' => 'open',
				'status_roll' => $r->stat,
				'ket' => $r->ket,
				'created_at' => date('Y-m-d H:i:s'),
				'created_by' => $this->username,
			);
			$data = $db_ppi->insert('po_master', $items);
		}
		if($data){
			$this->db->set('input_po', 'Y');
			$this->db->where('id_hdr', $id_hdr);
			$this->db->update('trs_po_roll_header');
		}
		return [
			'data' => $data,
			'id_hdr' => $id_hdr,
		];
	}

	function hapusFilePO()
	{
		$id_dtl = $_POST["id_dtl"];
		$detail = $this->db->query("SELECT*FROM trs_po_roll_detail WHERE id_dtl='$id_dtl'")->row();
		// HAPUS FILE
		$unlink = unlink("assets/gambar_po_roll/".$detail->nm_file);
		// HAPUS DETAIL
		$this->db->where("id_dtl", $id_dtl);
		$hdtl = $this->db->delete("trs_po_roll_detail");
		return [
			'id_dtl' => $id_dtl,
			'unlink' => $unlink,
			'hdtl' => $hdtl,
		];
	}

	function editListPORoll()
	{
		$id_hdr = $_POST["id_hdr"];
		$id = $_POST["id_item"];
		$nm_ker = $_POST["e_nm_ker"];
		$g_label = $_POST["e_g_label"];
		$width = $_POST["e_width"];
		$tonase = $_POST["e_tonase"];
		$jml_roll = $_POST["e_jml_roll"];
		$harga = $_POST["e_harga"];
		$ket = $_POST["e_ket"];
		$item = $this->db->query("SELECT*FROM trs_po_roll_item WHERE id='$id'");
		$cek = $this->db->query("SELECT*FROM trs_po_roll_item WHERE id_hdr='$id_hdr' AND nm_ker='$nm_ker' AND g_label='$g_label' AND width='$width'");
		if($cek->num_rows() != 0 && $item->row()->id != $cek->row()->id){
			$data = false;
			$msg = 'ITEM SUDAH ADA!';
		}else if($nm_ker == '' || $g_label == '' || $width == '' || $tonase == '' || $tonase == 0 || $jml_roll == '' || $jml_roll == 0 || $harga == '' || $harga == 0){
			$data = false;
			$msg = 'HARAP LENGKAPI INPUTAN!';
		}else{
			$this->db->set('nm_ker', $nm_ker);
			$this->db->set('g_label', $g_label);
			$this->db->set('width', $width);
			$this->db->set('tonase', $tonase);
			$this->db->set('jml_roll', $jml_roll);
			$this->db->set('harga', $harga);
			$this->db->set('ket', $ket);
			$this->db->where('id', $id);
			$data = $this->db->update('trs_po_roll_item');
			$msg = 'BERHASIL!';
		}
		return [
			'item' => $item->row(),
			'cek' => $cek->row(),
			'data' => $data,
			'msg' => $msg,
		];
	}

	function addListPORoll()
	{
		$id_hdr = $_POST["id_hdr"];
		$nm_ker = $_POST["n_nm_ker"];
		$g_label = $_POST["n_g_label"];
		$width = $_POST["n_width"];
		$tonase = $_POST["n_tonase"];
		$jml_roll = $_POST["n_jml_roll"];
		$ket = $_POST["n_ket"];
		$cek = $this->db->query("SELECT*FROM trs_po_roll_item WHERE id_hdr='$id_hdr' AND nm_ker='$nm_ker' AND g_label='$g_label' AND width='$width'");
		if($cek->num_rows() != 0){
			$data = false;
			$msg = 'ITEM SUDAH ADA!';
		}else if($nm_ker == '' || $g_label == '' || $width == '' || $tonase == '' || $tonase == 0 || $jml_roll == '' || $jml_roll == 0){
			$data = false;
			$msg = 'HARAP LENGKAPI INPUTAN!';
		}else{
			$header = $this->db->query("SELECT*FROM trs_po_roll_header WHERE id_hdr='$id_hdr'")->row();
			$item = array(
				'id_hdr' => $id_hdr,
				'no_po' => $header->no_po,
				'nm_ker' => $nm_ker,
				'g_label' => $g_label,
				'width' => $width,
				'tonase' => $tonase,
				'jml_roll' => $jml_roll,
				'ket' => $ket,
			);
			$data = $this->db->insert('trs_po_roll_item', $item);
			$msg = 'BERHASIL!';
		}
		return [
			'data' => $data,
			'msg' => $msg,
		];
	}

	function hapusListPORoll()
	{
		$this->db->where('id', $_POST["id_item"]);
		$del = $this->db->delete("trs_po_roll_item");
		return [
			'del' => $del,
		];
	}

	function addNotePORoll()
	{
		$id_hdr = $_POST["id_hdr"];
		$note_po_roll = $_POST["note_po_roll"];
		if($note_po_roll == ''){
			$data = false; $msg = 'NOTE TIDAK BOLEH KOSONG!';
		}else{
			$this->db->set('note_po', $note_po_roll);
			$this->db->where('id_hdr', $id_hdr);
			$data = $this->db->update('trs_po_roll_header');
			$msg = 'BERHASIL!';
		}
		return [
			'data' => $data,
			'msg' => $msg,
		];
	}

	function uploadDesign()
	{
		$id_dg = $_POST["id_dg"];
		$opt = $_POST["opt"];
		$dsg_pilih = $_POST["dsg_pilih"];
		$config['upload_path'] = './assets/gambar_design/';
		$config['allowed_types'] = 'jpg|jpeg|png|gif|webp';
		$config['max_size'] = 2048; // 2MB
		$config['overwrite'] = true;
		$thn = substr(date('Y'), 2, 2); $bln = date('m'); $date = date('d');
		$config['file_name'] = $dsg_pilih.'-'.$thn.$bln.$date.'-'.$this->generateFileName();
		$this->load->library('upload',$config);
		$this->upload->initialize($config);

		if(!$this->upload->do_upload('dsg_foto')){
			$data = false; $msg = 'UKURAN / FORMAT FILE TIDAK DIDUKUNG!';
		}else{
			if($this->upload->do_upload('dsg_foto')){
				$gbrBukti = $this->upload->data();
				$filefoto = $gbrBukti['file_name'];
				($id_dg != '' && $opt != '') ? $id_hdr = $id_dg : $id_hdr = 0;
				$dtl = array(
					'id_hdr' => $id_hdr,
					'jenis_dtl' => $dsg_pilih,
					'nm_file' => $filefoto,
					'add_at' => date('Y-m-d H:i:s'),
					'add_by' => $this->username,
				);
				$data = $this->db->insert('trs_design_detail', $dtl);
				$msg = 'BERHASIL';
			}
		}

		return [
			'data' => $data,
			'msg' => $msg,
		];
	}

	function deleteDesign()
	{
		$lvl = $this->session->userdata('level');
		$id_dtl = $_POST["id_dtl"];
		$detail = $this->db->query("SELECT*FROM trs_design_detail WHERE id_dtl='$id_dtl'");
		// HAPUS FILE
		foreach($detail->result() as $r){
			if($r->jenis_dtl == 'FA' || $r->jenis_dtl == 'FD' || $r->jenis_dtl == 'FP' || $r->jenis_dtl == 'FS' || $r->jenis_dtl == 'XD' || $r->jenis_dtl == 'ZS'){
				unlink("assets/gambar_design/".$r->nm_file);
			}
		}
		// HAPUS ITEM
		$this->db->where("id_dtl", $id_dtl);
		$data = $this->db->delete("trs_design_detail");
		return [
			'data' => $data,
		];
	}

	function saveDesign()
	{
		$id_dg = $_POST["id_dg"];
		$opsi = $_POST["opsi"];
		$tgl = $_POST["tgl_s"];
		$pilih = $_POST["pilih_s"];
		$id_pelanggan = $_POST["i_customer"];
		$kode_po = $_POST["i_po"];
		$id_produk = $_POST["i_produk"];
		$statusInput = $_POST["statusInput"];

		// N - MULTINASIONAL / B - LOKAL CUSTOMER
		if($pilih == 'B' || ($pilih == 'N' && $opsi == 'edit' && $statusInput == 'update')){
			$id_pelanggan = $_POST["i_customer"];
			$kode_po = $_POST["i_po"];
			$id_produk = $_POST["i_produk"];
		}else{
			$id_pelanggan = null;
			$kode_po = null;
			$id_produk = null;
		}

		$cek = $this->db->query("SELECT*FROM trs_design_header WHERE id_pelanggan='$id_pelanggan' AND kode_po='$kode_po' AND id_produk='$id_produk'");

		if($cek->num_rows() != 0){
			$data = false;
			$msg = 'DATA FORM SUDAH ADA!';
		}else if($pilih == 'B' && ($id_pelanggan == '' || $kode_po == '' || $id_produk == '')){
			$data = false;
			$msg = 'LENGKAPI FORM!';
		}else if($pilih == 'N' && $statusInput == 'update' && ($id_pelanggan == '' || $kode_po == '' || $id_produk == '')){
			$data = false;
			$msg = 'LENGKAPI FORM!';
		}else{
			if($statusInput == 'insert'){
				$qUrut = $this->db->query("SELECT*FROM trs_design_header WHERE tgl='$tgl' AND jenis_dg='$pilih' ORDER BY id_dg DESC LIMIT 1");
				($qUrut->num_rows() == 0) ? $no = 1 : $no = $qUrut->row()->urut_dg + 1;
				$urut = str_pad($no, 3, "0", STR_PAD_LEFT);
				$kode = 'F'.$pilih.'/'.$this->m_fungsi->dateMonthYear($tgl).'/'.$urut;

				$header = [
					'tgl' => $tgl,
					'jenis_dg' => $pilih,
					'urut_dg' => $no,
					'kode_dg' => $kode,
					'id_pelanggan' => $id_pelanggan,
					'kode_po' => $kode_po,
					'id_produk' => $id_produk,
					'add_at' => date('Y-m-d H:i:s'),
					'add_by' => $this->username,
				];
			}
			
			// EDIT
			if($statusInput == 'update'){
				$this->db->set('id_pelanggan', $id_pelanggan);
				$this->db->set('kode_po', $kode_po);
				$this->db->set('id_produk', $id_produk);
				$this->db->set('edit_at', date('Y-m-d H:i:s'));
				$this->db->set('edit_by', $this->username);
				$this->db->where('id_dg', $id_dg);
				$data = $this->db->update('trs_design_header');
				$msg = 'BERHASIL UPDATE DATA!';
			}else{
				$data = $this->db->insert('trs_design_header', $header);
				$msg = 'BERHASIL TAMBAH DATA!';
			}
		}

		return [
			'data' => $data,
			'msg' => $msg,
		];
	}

	function addLinkDesign()
	{
		$urlAuth = $this->session->userdata('level');
		$id_dg = $_POST["id_dgx"];
		$link_design = preg_replace('/\s/', '', $_POST["link_design"]);
		
		if($urlAuth == 'Admin'){
			$cek = $this->db->query("SELECT*FROM trs_design_header WHERE id_dg='$id_dg' AND acc_d_stt='Y'");
			if($cek->num_rows() == 0){
				$j = 'FL';
			}else{
				$j = 'XL';
			}
		}
		if($urlAuth == 'User'){
			$j = 'FL';
		}
		if($urlAuth == 'Design'){
			$j = 'XL';
		}

		$dtl = array(
			'id_hdr' => ($id_dg == '') ? 0 : $id_dg,
			'jenis_dtl' => $j,
			'nm_file' => $link_design,
			'add_at' => date('Y-m-d H:i:s'),
			'add_by' => $this->username,
		);

		($id_dg != '') ? $id = $id_dg : $id = 0;
		$cek = $this->db->query("SELECT*FROM trs_design_detail WHERE id_hdr='$id' AND jenis_dtl='$j'");

		if(!filter_var($link_design, FILTER_VALIDATE_URL)) {
			$data = false;
			$msg = 'LINK URL TIDAK VALID!';
		}else{
			if($cek->num_rows() != 0){
				$this->db->where("jenis_dtl", $j);
				$this->db->where("id_hdr", $id_dg);
				$data = $this->db->update('trs_design_detail', $dtl);
				$msg = 'BERHASIL EDIT LINK DESIGN!';
			}else{
				$data = $this->db->insert('trs_design_detail', $dtl);
				$msg = 'BERHASIL TAMBAH LINK DESIGN!';
			}
		}

		return [
			'data' => $data,
			'msg' => $msg,
		];
	}

	function btnAcuanWarna()
	{
		$id_dg = $_POST["id_dg"];
		$plh_warna = $_POST["plh_warna"];
		$cek = $this->db->query("SELECT*FROM trs_design_detail WHERE id_hdr='$id_dg' AND jenis_dtl='FW' AND nm_file='$plh_warna'");

		if($cek->num_rows() != 0){
			$data = false;
			$msg = 'ACUAN WARNA SUDAH ADA!';
		}else{
			$dtl = array(
				'id_hdr' => $id_dg,
				'jenis_dtl' => 'FW',
				'nm_file' => $plh_warna,
				'add_at' => date('Y-m-d H:i:s'),
				'add_by' => $this->username,
			);
			$data = $this->db->insert('trs_design_detail', $dtl);
			$msg = 'BERHASIL TAMBAH ACUAN WARNA!';
		}

		return [
			'data' => $data,
			'msg' => $msg,
		];
	}

	function btnVerifDesign()
	{
		$id_dg = $_POST["id_dg"];
		$aksi = $_POST["aksi"];
		$status_verif = $_POST["status_verif"];
		$ket2 = $_POST["ket"];

		if($aksi == 'H') { $ket = 'HOLD'; }
		if($aksi == 'R') { $ket = 'REJECT'; }
		if($aksi == 'Y') { $ket = 'VERIF'; }
		if($aksi == 'N') { $ket = 'LOCK'; }

		if($ket2 == '' && ($aksi == 'H' || $aksi == 'R')){
			$data = false; $stat = false;
			$msg = "KETERANGAN TIDAK BOLEH KOSONG!";
		}else{
			$v = substr($status_verif, 0, 1);
			if($aksi == 'N'){
				$nKet = null; $nAt = null; $nBy = null;
			}else{
				$nKet = ($aksi == 'Y' && $ket2 == '') ? 'OK!' : $ket2;
				$nAt = date('Y-m-d H:i:s');
				$nBy = $this->username;
			}
			$this->db->set('acc_'.$v.'_stt', $aksi);
			$this->db->set('acc_'.$v.'_ket', $nKet);
			$this->db->set('acc_'.$v.'_at', $nAt);
			$this->db->set('acc_'.$v.'_by', $nBy);
			$this->db->where('id_dg', $id_dg);
			$data = $this->db->update('trs_design_header');
			$msg = "BERHASIL ".$ket.'!';
			if($data){
				$cek = $this->db->query("SELECT*FROM trs_design_header WHERE id_dg='$id_dg' AND acc_a_stt='Y' AND acc_d_stt='Y' AND acc_p_stt='Y' AND acc_s_stt='Y' AND acc_x_stt='Y' AND acc_z_stt='Y' AND acc_k_stt='Y'")->num_rows();
				$this->db->set('form_stat', ($cek != 0) ? 'Approve' : 'Open');
				$this->db->where('id_dg', $id_dg);
				$stat = $this->db->update('trs_design_header');
			}
		}

		return [
			'data' => $data,
			'stat' => $stat,
			'msg' => $msg,
		];
	}

	function hapusDesign()
	{
		$lvl = $this->session->userdata('level');
		$id_dg = $_POST["id_dg"];
		$detail = $this->db->query("SELECT*FROM trs_design_detail WHERE id_hdr='$id_dg'");
		// HAPUS FILE
		foreach($detail->result() as $r){
			if($r->jenis_dtl == 'FA' || $r->jenis_dtl == 'FD' || $r->jenis_dtl == 'FP' || $r->jenis_dtl == 'FS' || $r->jenis_dtl == 'XD' || $r->jenis_dtl == 'ZS'){
				unlink("assets/gambar_design/".$r->nm_file);
			}
		}
		// HAPUS DETAIL
		$this->db->where("id_hdr", $id_dg);
		$hdtl = $this->db->delete("trs_design_detail");
		if($hdtl){
			// HAPUS HEADER
			$this->db->where("id_dg", $id_dg);
			$hhdr = $this->db->delete("trs_design_header");
		}
		return [
			'hdtl' => $hdtl,
			'hhdr' => $hhdr,
		];
	}

	function hapusDelSys()
	{
		$id = $this->session->userdata('level');
		$id = $_POST["id"];
		$dev = $this->db->query("SELECT*FROM trs_dev_sys WHERE id_dev='$id'")->row();
		$nm_produk = $this->db->query("SELECT*FROM m_produk WHERE id_produk='$dev->id_produk'")->row()->nm_produk;

		// HAPUS data
		$this->db->where("id_dev", $id);
		$data = $this->db->delete("trs_dev_sys");

		return [
			'data' => $data,
			'dev' => $dev,
			'nm_produk' => $nm_produk,
		];
	}
}
