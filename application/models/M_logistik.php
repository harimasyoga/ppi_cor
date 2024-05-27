<?php
class M_logistik extends CI_Model
{

	function __construct()
	{
		parent::__construct();

		date_default_timezone_set('Asia/Jakarta');
		$this->username = $this->session->userdata('username');
		$this->waktu    = date('Y-m-d H:i:s');
		$this->load->model('m_master');
	}

	function save_inv_bhn()
	{
		$status_input = $this->input->post('sts_input');
		if($status_input == 'add')
		{
			$tgl_inv       = $this->input->post('tgl_inv');
			$tanggal       = explode('-',$tgl_inv);
			$tahun         = $tanggal[0];
			$bulan         = $tanggal[1];
			
			$c_no_inv    = $this->m_fungsi->urut_transaksi('INV_BHN');
			$m_no_inv    = $c_no_inv.'/INV/BHN/'.$bulan.'/'.$tahun;

			$data_header = array(
				'no_inv_bhn'    => $m_no_inv,
				'tgl_inv_bhn'   => $this->input->post('tgl_inv'),
				'id_stok_d'   	=> $this->input->post('id_stok_d'),
				'no_stok'   	=> $this->input->post('no_stok'),
				'id_hub'        => $this->input->post('id_hub'),
				'ket'           => $this->input->post('ket'),
				'qty'           => str_replace('.','',$this->input->post('qty')), 
				'nominal'       => str_replace('.','',$this->input->post('nom')),
				'total_bayar'   => str_replace('.','',$this->input->post('total_bayar')),
				'acc_owner'     => 'N',
				
			);

			$result_header = $this->db->insert('invoice_bhn', $data_header);

			return $result_header;
			
		}else{
			
			$no_inv_bhn    = $this->input->post('no_inv_bhn');

			$data_header = array(
				'no_inv_bhn'    => $no_inv_bhn,
				'tgl_inv_bhn'   => $this->input->post('tgl_inv'),
				'id_stok_d'   	=> $this->input->post('id_stok_d'),
				'no_stok'   	=> $this->input->post('no_stok'),
				'id_hub'        => $this->input->post('id_hub'),
				'ket'           => $this->input->post('ket'),
				'qty'           => str_replace('.','',$this->input->post('qty')), 
				'nominal'       => str_replace('.','',$this->input->post('nom')),
				'total_bayar'   => str_replace('.','',$this->input->post('total_bayar')),
				'acc_owner'     => 'N',
			);

			$this->db->where('id_inv_bhn', $this->input->post('id_inv_bhn'));
			$result_header = $this->db->update('invoice_bhn', $data_header);
			return $result_header;
		}
		
	}

	function verif_inv_bhn()
	{
		$no_inv       = $this->input->post('no_inv');
		$acc          = $this->input->post('acc');
		$app          = "";
		
		$data_bhn   = $this->db->query("SELECT*from invoice_bhn a
		join m_hub b on a.id_hub=b.id_hub
		WHERE no_inv_bhn='$no_inv'
		order by tgl_inv_bhn desc, id_inv_bhn
		")->row();

		// KHUSUS ADMIN //
		if ( in_array($this->session->userdata('level'), ['Admin','Owner']) ) 
		{
			if($acc=='N')
			{
				$total_bayar = $data_bhn->qty*$data_bhn->nominal;

				add_jurnal($data_bhn->id_hub,$data_bhn->tgl_inv_bhn, $no_inv,'1.01.06','Persediaan Bahan Baku', $total_bayar, 0);

				add_jurnal($data_bhn->id_hub,$data_bhn->tgl_inv_bhn, $no_inv,'2.01.01','Hutang Usaha', 0,$total_bayar);
				
				$this->db->set("acc_owner", 'Y');
			}else{
				
				// delete jurnal pendapatan
				del_jurnal( $no_inv );

				$this->db->set("acc_owner", 'N');
			}
			
			$this->db->where("no_inv_bhn",$no_inv);
			$valid = $this->db->update("invoice_bhn");

		} else {
			
			$valid = false;

		}

		return $valid;
	}
	
	function save_inv_beli()
	{
		$status_input = $this->input->post('sts_input');
		if($status_input == 'add')
		{
			$id_hub        = $this->input->post('id_hub');
			$diskon        = $this->input->post('diskon');
			$pajak         = $this->input->post('pajak');
			
			$tgl_inv       = $this->input->post('tgl_inv');
			$tanggal       = explode('-',$tgl_inv);
			$tahun         = $tanggal[0];
			$bulan         = $tanggal[1];
			
			if($pajak=='PPN')
			{
				$c_no_inv_kd='INV/PA/';
			}else{
				$c_no_inv_kd='INV/PB/';
			}

			$c_no_inv    = $this->m_fungsi->urut_transaksi('INV_BELI_'.$pajak);
			$m_no_inv    = $c_no_inv_kd.''.$c_no_inv.'/'.$bulan.'/'.$tahun;

			$data_header = array(
				'no_inv_beli'       => $m_no_inv,
				'tgl_inv_beli'      => $this->input->post('tgl_inv'),
				'id_hub'            => $this->input->post('id_hub'),
				'id_supp'           => $this->input->post('id_supp'),
				'diskon'            => $this->input->post('diskon'),
				'pajak'             => $this->input->post('pajak'),
				'ket'               => $this->input->post('ket'),
				'acc_owner'         => 'N',
			);

			$result_header = $this->db->insert('invoice_header_beli', $data_header);
	
			// rinci

			$rowloop     = $this->input->post('bucket');
			for($loop = 0; $loop <= $rowloop; $loop++)
			{
				$data_detail = array(				
					'no_inv_beli'       => $m_no_inv,
					'transaksi'     	=> $this->input->post('transaksi['.$loop.']'),
					'jns_beban'     	=> $this->input->post('jns_beban['.$loop.']'),
					'nominal'     		=> str_replace('.','',$this->input->post('nominal['.$loop.']')),
				);

				$result_detail = $this->db->insert('invoice_detail_beli', $data_detail);

			}		

			return $result_detail;
			
		}else{
			
			$no_inv_beli    = $this->input->post('no_inv_beli');

			$data_header = array(
				'no_inv_beli'       => $no_inv_beli,
				'tgl_inv_beli'      => $this->input->post('tgl_inv'),
				'id_hub'            => $this->input->post('id_hub'),
				'id_supp'           => $this->input->post('id_supp'),
				'diskon'            => $this->input->post('diskon'),
				'pajak'             => $this->input->post('pajak'),
				'ket'               => $this->input->post('ket'),
				'acc_owner'         => 'N',
			);

			$this->db->where('id_header_beli', $this->input->post('id_header_beli'));
			$result_header = $this->db->update('invoice_header_beli', $data_header);
	
			// delete rinci
			$del_detail = $this->db->query("DELETE FROM invoice_detail_beli where no_inv_beli='$no_inv_beli' ");

			// rinci
			if($del_detail)
			{
				$rowloop     = $this->input->post('bucket');
				for($loop = 0; $loop <= $rowloop; $loop++)
				{
					$data_detail = array(				
						'no_inv_beli'       => $this->input->post('no_inv_beli'),
						'transaksi'     	=> $this->input->post('transaksi['.$loop.']'),
						'jns_beban'     	=> $this->input->post('jns_beban['.$loop.']'),
						'nominal'     		=> str_replace('.','',$this->input->post('nominal['.$loop.']')),
					);
	
					$result_detail = $this->db->insert('invoice_detail_beli', $data_detail);
				}		
				return $result_detail;
			}
			
		}
		
	}

	function batal_inv_beli()
	{
		$id       = $this->input->post('id');
		$app      = "";

		// KHUSUS ADMIN //
		if ($this->session->userdata('level') == "Admin") 
		{

			$this->db->set("acc_admin", 'N');
			$this->db->set("acc_owner", 'N');
			$this->db->where("no_invoice",$id);
			$valid = $this->db->update("invoice_header");

		} else if ($this->session->userdata('level') == "Keuangan1" && $this->session->userdata('username') == "karina") 
		{
			$this->db->set("acc_admin", 'N');
			$this->db->where("no_invoice",$id);
			$valid = $this->db->update("invoice_header");

		} else {
	
			$this->db->set("acc_owner", 'N');
			$this->db->where("no_invoice",$id);
			$valid = $this->db->update("invoice_header");

		}

		return $valid;
	}

	function verif_inv_beli()
	{
		$no_inv       = $this->input->post('no_inv');
		$acc          = $this->input->post('acc');
		$app          = "";
		
			$cek_detail   = $this->db->query("SELECT*FROM invoice_header_beli a
			join invoice_detail_beli b on a.no_inv_beli=b.no_inv_beli
			join m_hub c ON a.id_hub=c.id_hub
			join m_supp d ON a.id_supp=d.id_supp
			join 
			(SELECT*FROM(
						select kd_akun as kd,nm_akun as nm,jenis,dk from m_kode_akun
						union all
						select concat(kd_akun,'.',kd_kelompok) as kd,nm_kelompok as nm,jenis,dk from m_kode_kelompok
						union all
						select concat(kd_akun,'.',kd_kelompok,'.',kd_jenis) as kd,nm_jenis as nm,jenis,dk from m_kode_jenis
						union all
						select concat(kd_akun,'.',kd_kelompok,'.',kd_jenis,'.',kd_rinci) as kd,nm_rinci as nm,jenis,dk from m_kode_rinci
						)b )e
			ON b.jns_beban=e.kd
			where b.no_inv_beli='$no_inv'
			")->result();

		// KHUSUS ADMIN //
		if ($this->session->userdata('level') == "Admin") 
		{
			if($acc=='N')
			{				
				foreach ( $cek_detail as $row ) 
				{
					add_jurnal($row->id_hub,$row->tgl_inv_beli, $no_inv,$row->jns_beban,$row->nm, $row->nominal, 0);
					add_jurnal($row->id_hub,$row->tgl_inv_beli, $no_inv,'2.01.01','Hutang Usaha', 0,$row->nominal);
					
				}
				$this->db->set("acc_owner", 'Y');
			}else{
				
				foreach ( $cek_detail as $row ) 
				{
					// delete jurnal pendapatan
					del_jurnal( $no_inv );

				}
				$this->db->set("acc_owner", 'N');
			}
			
			$this->db->where("no_inv_beli",$no_inv);
			$valid = $this->db->update("invoice_header_beli");

		} else if ($this->session->userdata('level') == "Keuangan1" && $this->session->userdata('username') == "bumagda") 
		{
			if($acc=='N')
			{
				foreach ( $cek_detail as $row ) 
				{
					// jurnal
					add_jurnal($row->id_hub,$row->tgl_inv_beli, $no_inv,$row->jns_beban,$row->nm, $row->nominal, 0);
					add_jurnal($row->id_hub,$row->tgl_inv_beli, $no_inv,'2.01.01','Hutang Usaha', 0,$row->nominal);
				}

				$this->db->set("acc_owner", 'Y');
			}else{

				foreach ( $cek_detail as $row ) 
				{
					
					// delete jurnal
					del_jurnal( $no_inv );
						
				}
				
				$this->db->set("acc_owner", 'N');
			}
			
			$this->db->where("no_inv_beli",$no_inv);
			$valid = $this->db->update("invoice_header_beli");

		} else {
			
			$valid = false;

		}

		return $valid;
	}
	
	function save_invoice()
	{
		$cek_inv        = $this->input->post('cek_inv');
		$c_no_inv_tgl   = $this->input->post('no_inv_tgl');

		$type           = $this->input->post('type_po');
		$pajak          = $this->input->post('pajak');
		$tgl_inv        = $this->input->post('tgl_inv');
		$tanggal        = explode('-',$tgl_inv);
		$tahun          = $tanggal[0];

		($type=='roll')? $type_ok=$type : $type_ok='SHEET_BOX';
		
		($pajak=='nonppn')? $pajak_ok='non' : $pajak_ok='ppn';
		$c_no_inv_kd   = $this->input->post('no_inv_kd');

		if($cek_inv=='revisi')
		{
			$c_no_inv    = $this->input->post('no_inv');
			$m_no_inv    = $c_no_inv_kd.''.$c_no_inv.''.$c_no_inv_tgl;
		}else{
			$c_no_inv    = $this->m_fungsi->tampil_no_urut($type_ok.'_'.$pajak_ok.'_'.$tahun);
			$m_no_inv    = $c_no_inv_kd.''.$c_no_inv.''.$c_no_inv_tgl;
		}

		$data_header = array(
			'no_invoice'         => $m_no_inv,
			'type'               => $this->input->post('type_po'),
			'cek_inv'    		 => $cek_inv,
			'tgl_invoice'        => $this->input->post('tgl_inv'),
			'tgl_sj'             => $this->input->post('tgl_sj'),
			'pajak'              => $this->input->post('pajak'),
			'inc_exc'            => $this->input->post('inc_exc'),
			'tgl_jatuh_tempo'    => $this->input->post('tgl_tempo'),
			'id_perusahaan'      => $this->input->post('id_perusahaan'),
			'kepada'             => $this->input->post('kpd'),
			'nm_perusahaan'      => $this->input->post('nm_perusahaan'),
			'alamat_perusahaan'  => $this->input->post('alamat_perusahaan'),
			'bank'  			 => $this->input->post('bank'),
			'acc_admin'          => 'Y',
		);
	
		$result_header = $this->db->insert('invoice_header', $data_header);

		$db2              = $this->load->database('database_simroll', TRUE);
		$tgl_sj           = $this->input->post('tgl_sj');
		$id_perusahaan    = $this->input->post('id_perusahaan');

		if ($type == 'roll')
		{
			$query = $db2->query("SELECT c.nm_perusahaan,a.id_pl,b.id,a.nm_ker,a.g_label,a.width,COUNT(a.roll) AS qty,SUM(weight)-SUM(seset) AS weight,b.no_po,b.no_po_sj,b.no_surat
			FROM m_timbangan a 
			INNER JOIN pl b ON a.id_pl = b.id 
			LEFT JOIN m_perusahaan c ON b.id_perusahaan=c.id
			WHERE b.no_pl_inv = '0' AND b.tgl='$tgl_sj' AND b.id_perusahaan='$id_perusahaan'
			GROUP BY b.no_po,a.nm_ker,a.g_label,a.width 
			ORDER BY a.g_label,b.no_surat,b.no_po,a.nm_ker DESC,a.g_label,a.width ")->result();

			$no = 1;
			foreach ( $query as $row ) 
			{

				$cek = $this->input->post('aksi['.$no.']');
				if($cek == 1)
				{
					$harga_ok    = $this->input->post('hrg['.$no.']');
					$harga_inc   = $this->input->post('inc['.$no.']');
					$harga_inc1  = str_replace('.','',$harga_inc);

					$hasil_ok    = $this->input->post('hasil['.$no.']');
					$id_pl_roll  = $this->input->post('id_pl_roll['.$no.']');
					$data = [					
						'no_invoice'   => $m_no_inv,
						'type'         => $type,
						'no_surat'     => $this->input->post('no_surat['.$no.']'),
						'nm_ker'       => $this->input->post('nm_ker['.$no.']'),
						'g_label'      => $this->input->post('g_label['.$no.']'),
						'width'        => $this->input->post('width['.$no.']'),
						'qty'          => $this->input->post('qty['.$no.']'),
						'retur_qty'    => $this->input->post('retur_qty['.$no.']'),
						'id_pl'        => $id_pl_roll,
						'harga'        => str_replace('.','',$harga_ok),
						'include'      => str_replace(',','.',$harga_inc1),
						'weight'       => $this->input->post('weight['.$no.']'),
						'seset'        => $this->input->post('seset['.$no.']'),
						'hasil'        => str_replace('.','',$hasil_ok),
						'no_po'        => $this->input->post('no_po['.$no.']'),
					];

					$update_no_pl   = $db2->query("UPDATE pl set no_pl_inv = 1 where id ='$id_pl_roll'");

					$result_rinci   = $this->db->insert("invoice_detail", $data);

				}
				$no++;
			}
		}else{
			if ($type == 'box')
			{				
				$where_po    = 'and d.po ="box"';
			}else{
				$where_po    = 'and d.po is null';
			}
			
			$query = $db2->query("SELECT b.id as id_pl, a.qty, a.qty_ket, b.tgl, b.id_perusahaan, c.nm_perusahaan, b.no_surat, b.no_po, b.no_kendaraan, d.item, d.kualitas, d.ukuran2,d.ukuran, 
			d.flute, d.po
			FROM m_box a 
			JOIN pl_box b ON a.id_pl = b.id 
			LEFT JOIN m_perusahaan c ON b.id_perusahaan=c.id
			JOIN po_box_master d ON b.no_po=d.no_po and a.ukuran=d.ukuran
			WHERE b.no_pl_inv = '0' AND b.tgl = '$tgl_sj' AND b.id_perusahaan='$id_perusahaan' $where_po
			ORDER BY b.tgl desc ")->result();
			
			$no = 1;
			foreach ( $query as $row ) 
			{
				$cek = $this->input->post('aksi['.$no.']');
				if($cek == 1)
				{
					$harga_ok            = $this->input->post('hrg['.$no.']');
					$harga_inc           = $this->input->post('inc['.$no.']');
					$harga_inc1          = str_replace('.','',$harga_inc);

					$hasil_ok            = $this->input->post('hasil['.$no.']');
					$id_pl_roll          = $this->input->post('id_pl_roll['.$no.']');
					$no_po               = $this->input->post('no_po['.$no.']');
					$id_produk_simcorr   = $this->input->post('id_produk_simcorr['.$no.']');
					$data = [
						'no_invoice'          => $m_no_inv,
						'type'                => $type,
						'no_surat'            => $this->input->post('no_surat['.$no.']'),
						'nm_ker'              => $this->input->post('item['.$no.']'),
						'id_produk_simcorr'   => $id_produk_simcorr,
						'g_label'             => $this->input->post('ukuran['.$no.']'),
						'kualitas'            => $this->input->post('kualitas['.$no.']'),
						'qty'                 => $this->input->post('qty['.$no.']'),
						'retur_qty'           => $this->input->post('retur_qty['.$no.']'),
						'id_pl'               => $id_pl_roll,
						'harga'               => str_replace('.','',$harga_ok),
						'include'             => str_replace(',','.',$harga_inc1),
						'hasil'               => str_replace('.','',$hasil_ok),
						'no_po'               => $this->input->post('no_po['.$no.']'),
					];

					$update_no_pl   = $db2->query("UPDATE pl_box set no_pl_inv = 1 where id ='$id_pl_roll'");

					$result_rinci   = $this->db->insert("invoice_detail", $data);

				}
				$no++;
			}
		}

		if($result_rinci){
			$query = $this->db->query("SELECT*FROM invoice_header where no_invoice ='$m_no_inv' ")->row();
			return $query->id;
		}else{
			return 0;

		}
			
	}
	
	function save_byr_invoice()
	{
		$status_input = $this->input->post('sts_input');
		if($status_input == 'add')
		{

			$data_header = array(
				'id_invoice_h'   => $this->input->post('id_invoice_h'),
				'id_perusahaan'  => $this->input->post('id_perusahaan'),
				'tgl_sj'         => $this->input->post('tgl_inv'),
				'no_inv'         => $this->input->post('no_inv'),
				'tgl_inv'        => $this->input->post('tgl_inv'),
				'alasan_retur'   => $this->input->post('alasan'),
				'total_inv'      => str_replace('.','',$this->input->post('total_inv')),
				'tgl_jt'         => $this->input->post('tgl_jt'),
				'tgl_bayar'      => $this->input->post('tgl_byr'),
				'jumlah_bayar'   => str_replace('.','',$this->input->post('jml_byr')),
				'status_jt'      => $this->input->post('status_jt'),
				'status_lunas'   => $this->input->post('sts_lunas'),
				'sales'          => $this->input->post('sales'),
				'TOP'            => $this->input->post('top'),
			);
		
			$result_header = $this->db->insert('trs_bayar_inv', $data_header);
			
		}else{

			$data_header = array(
				'id_invoice_h'   => $this->input->post('id_invoice_h'),
				'id_perusahaan'  => $this->input->post('id_perusahaan'),
				'tgl_sj'         => $this->input->post('tgl_inv'),
				'no_inv'         => $this->input->post('no_inv'),
				'tgl_inv'        => $this->input->post('tgl_inv'),
				'alasan_retur'   => $this->input->post('alasan'),
				'total_inv'      => str_replace('.','',$this->input->post('total_inv')),
				'tgl_jt'         => $this->input->post('tgl_jt'),
				'tgl_bayar'      => $this->input->post('tgl_byr'),
				'jumlah_bayar'   => str_replace('.','',$this->input->post('jml_byr')),
				'status_jt'      => $this->input->post('status_jt'),
				'status_lunas'   => $this->input->post('sts_lunas'),
				'sales'          => $this->input->post('sales'),
				'TOP'            => $this->input->post('top'),
			);
		
			$this->db->where('id_bayar_inv', $this->input->post('id_byr_inv'));
			$result_header = $this->db->update('trs_bayar_inv', $data_header);
			
		}
		return $result_header;
		

			
	}

	function loadGudang()
	{
		$opsi = $_POST["opsi"];
		if($opsi == 'cor'){
			$where = "AND g.gd_id_plan_cor!='0' AND g.gd_id_plan_flexo IS NULL AND g.gd_id_plan_finishing IS NULL";
		}else if($opsi == 'flexo'){
			$where = "AND g.gd_id_plan_cor!='0' AND g.gd_id_plan_flexo!='0' AND g.gd_id_plan_finishing IS NULL";
		}else if($opsi == 'finishing'){
			$where = "AND g.gd_id_plan_cor!='0' AND g.gd_id_plan_flexo!='0' AND g.gd_id_plan_finishing!='0'";
		}else{
			$where = "";
		}
		$data = $this->db->query("SELECT COUNT(g.id_gudang) AS jml,p.nm_pelanggan,p.attn,i.nm_produk,g.* FROM m_gudang g
		INNER JOIN m_produk i ON g.gd_id_produk=i.id_produk
		INNER JOIN m_pelanggan p ON g.gd_id_pelanggan=p.id_pelanggan
		INNER JOIN trs_wo w ON g.gd_id_trs_wo=w.id
		INNER JOIN trs_po t ON w.kode_po=t.kode_po AND w.id_pelanggan=t.id_pelanggan
		WHERE g.gd_cek_spv='Open' AND t.status_kiriman='Open' $where
		GROUP BY p.nm_pelanggan,g.gd_id_produk");
		return [
			'data' => $data->result(),
			'opsi' => $opsi,
			'id_pelanggan' => $_POST["id_pelanggan"],
			'id_produk' => $_POST["id_produk"],
		];
	}

	function loadListProduksiPlan()
	{
		$opsi = $_POST["opsi"];
		$id_pelanggan = $_POST["id_pelanggan"];
		$id_produk = $_POST["id_produk"];
		if($opsi == 'cor'){
			$data = $this->db->query("SELECT w.kode_po,COUNT(g.id_gudang) AS jml_gd,g.* FROM m_gudang g
			INNER JOIN plan_cor c ON g.gd_id_plan_cor=c.id_plan
			INNER JOIN trs_wo w ON g.gd_id_trs_wo=w.id
			INNER JOIN trs_po t ON w.kode_po=t.kode_po AND w.id_pelanggan=t.id_pelanggan
			WHERE g.gd_id_pelanggan='$id_pelanggan' AND g.gd_id_produk='$id_produk' AND t.status_kiriman='Open'
			AND g.gd_id_plan_cor IS NOT NULL AND g.gd_id_plan_flexo IS NULL AND g.gd_id_plan_finishing IS NULL AND g.gd_cek_spv='Open' 
			GROUP BY g.gd_id_pelanggan,g.gd_id_produk,w.kode_po");
		}else if($opsi == 'flexo'){
			$data = $this->db->query("SELECT w.kode_po,COUNT(g.id_gudang) AS jml_gd,g.* FROM m_gudang g
			INNER JOIN plan_flexo fx ON g.gd_id_plan_cor=fx.id_plan_cor AND g.gd_id_plan_flexo=fx.id_flexo
			INNER JOIN trs_wo w ON g.gd_id_trs_wo=w.id
			INNER JOIN trs_po t ON w.kode_po=t.kode_po AND w.id_pelanggan=t.id_pelanggan
			WHERE g.gd_id_pelanggan='$id_pelanggan' AND g.gd_id_produk='$id_produk' AND t.status_kiriman='Open'
			AND g.gd_id_plan_cor IS NOT NULL AND g.gd_id_plan_flexo IS NOT NULL AND g.gd_id_plan_finishing IS NULL AND g.gd_cek_spv='Open' 
			GROUP BY g.gd_id_pelanggan,g.gd_id_produk,w.kode_po");
		}else{
			$data = $this->db->query("SELECT w.kode_po,COUNT(g.id_gudang) AS jml_gd,g.* FROM m_gudang g
			INNER JOIN plan_finishing fs ON g.gd_id_plan_cor=fs.id_plan_cor AND g.gd_id_plan_flexo=fs.id_plan_flexo AND g.gd_id_plan_finishing=fs.id_fs
			INNER JOIN trs_wo w ON g.gd_id_trs_wo=w.id
			INNER JOIN trs_po t ON w.kode_po=t.kode_po AND w.id_pelanggan=t.id_pelanggan
			WHERE g.gd_id_pelanggan='$id_pelanggan' AND g.gd_id_produk='$id_produk' AND t.status_kiriman='Open'
			AND g.gd_id_plan_cor IS NOT NULL AND g.gd_id_plan_flexo IS NOT NULL AND g.gd_id_plan_finishing IS NOT NULL AND g.gd_cek_spv='Open' 
			GROUP BY g.gd_id_pelanggan,g.gd_id_produk,w.kode_po");
		}
		return $data;
	}

	function clickHasilProduksiPlan()
	{
		$opsi = $_POST["opsi"];
		$id_pelanggan = $_POST["id_pelanggan"];
		$id_produk = $_POST["id_produk"];
		$no_po = $_POST["no_po"];

		if($opsi == 'cor'){
			$data = $this->db->query("SELECT g.*,c.* FROM m_gudang g
			INNER JOIN plan_cor c ON g.gd_id_plan_cor=c.id_plan
			INNER JOIN trs_wo w ON g.gd_id_trs_wo=w.id
			INNER JOIN trs_po t ON w.kode_po=t.kode_po
			WHERE g.gd_id_pelanggan='$id_pelanggan' AND g.gd_id_produk='$id_produk' AND w.kode_po='$no_po' AND t.status_kiriman='Open'
			AND g.gd_id_plan_cor IS NOT NULL AND g.gd_id_plan_flexo IS NULL AND g.gd_id_plan_finishing IS NULL
			ORDER BY c.tgl_plan");
		}else if($opsi == 'flexo'){
			$data = $this->db->query("SELECT g.*,fx.* FROM m_gudang g
			INNER JOIN plan_flexo fx ON g.gd_id_plan_cor=fx.id_plan_cor AND g.gd_id_plan_flexo=fx.id_flexo
			INNER JOIN trs_wo w ON g.gd_id_trs_wo=w.id
			INNER JOIN trs_po t ON w.kode_po=t.kode_po
			WHERE g.gd_id_pelanggan='$id_pelanggan' AND g.gd_id_produk='$id_produk' AND w.kode_po='$no_po' AND t.status_kiriman='Open'
			AND g.gd_id_plan_cor IS NOT NULL AND g.gd_id_plan_flexo IS NOT NULL AND g.gd_id_plan_finishing IS NULL
			ORDER BY fx.tgl_flexo");
		}else{
			$data = $this->db->query("SELECT g.*,fs.* FROM m_gudang g
			INNER JOIN plan_finishing fs ON g.gd_id_plan_cor=fs.id_plan_cor AND g.gd_id_plan_flexo=fs.id_plan_flexo AND g.gd_id_plan_finishing=fs.id_fs
			INNER JOIN trs_wo w ON g.gd_id_trs_wo=w.id
			INNER JOIN trs_po t ON w.kode_po=t.kode_po
			WHERE g.gd_id_pelanggan='$id_pelanggan' AND g.gd_id_produk='$id_produk' AND w.kode_po='$no_po' AND t.status_kiriman='Open'
			AND g.gd_id_plan_cor IS NOT NULL AND g.gd_id_plan_flexo IS NOT NULL AND g.gd_id_plan_finishing IS NOT NULL
			ORDER BY fs.tgl_fs");
		}

		return $data;
	}

	function simpanGudang()
	{
		$id_gudang = $_POST["id_gudang"];
		$good = $_POST["good"];
		$reject = $_POST["reject"];
		$opsi = $_POST["opsi"];
		$id_pelanggan = $_POST["id_pelanggan"];
		$id_produk = $_POST["id_produk"];
		$no_po = $_POST["no_po"];
		$i = $_POST["i"];

		// UPDATE GUDANG
		if($good < 0 || $good == 0 || $good == ""){
			$data = false;
			$msg = "HASIL TIDAK BOLEH KOSONG!";
		}else if($reject < 0 || $reject == ""){
			$data = false;
			$msg = "REJECT HARUS DIISI!";
		}else{
			$this->db->set("gd_good_qty", $good);
			$this->db->set("gd_reject_qty", $reject);
			$this->db->set("gd_cek_spv", 'Close');
			$this->db->where("id_gudang", $id_gudang);
			$data = $this->db->update("m_gudang");
			$msg = "OK!";
		}

		if($opsi == 'cor'){
			$where = "AND g.gd_id_plan_cor!='0' AND g.gd_id_plan_flexo IS NULL AND g.gd_id_plan_finishing IS NULL";
		}else if($opsi == 'flexo'){
			$where = "AND g.gd_id_plan_cor!='0' AND g.gd_id_plan_flexo!='0' AND g.gd_id_plan_finishing IS NULL";
		}else if($opsi == 'finishing'){
			$where = "AND g.gd_id_plan_cor!='0' AND g.gd_id_plan_flexo!='0' AND g.gd_id_plan_finishing!='0'";
		}else{
			$where = "";
		}
		// UPDATE HEADER SPAN
		$h_span = $this->db->query("SELECT COUNT(g.id_gudang) AS h_jml FROM m_gudang g
		INNER JOIN m_pelanggan p ON g.gd_id_pelanggan=p.id_pelanggan
		INNER JOIN trs_wo w ON g.gd_id_trs_wo=w.id
		INNER JOIN trs_po t ON w.kode_po=t.kode_po
		WHERE g.gd_cek_spv='Open' AND g.gd_id_pelanggan='$id_pelanggan' AND g.gd_id_produk='$id_produk' AND t.status_kiriman='Open' $where
		GROUP BY p.nm_pelanggan,g.gd_id_produk")->row();
		// UPDATE ISI SPAN
		$i_span = $this->db->query("SELECT COUNT(g.id_gudang) AS i_jml FROM m_gudang g
		INNER JOIN trs_wo w ON g.gd_id_trs_wo=w.id
		INNER JOIN trs_po t ON w.kode_po=t.kode_po
		WHERE g.gd_cek_spv='Open' AND g.gd_id_pelanggan='$id_pelanggan' AND g.gd_id_produk='$id_produk' AND w.kode_po='$no_po' AND t.status_kiriman='Open' $where 
		GROUP BY g.gd_id_pelanggan,g.gd_id_produk,w.kode_po")->row();

		return [
			'data' => $data,
			'msg' => $msg,
			'h_span' => $h_span,
			'i_span' => $i_span,
			'i' => $i,
		];
	}

	function closeGudang()
	{
		// GET DATA
		$kode_po = $_POST["kode_po"];
		$getPO = $this->db->query("SELECT*FROM m_gudang g
		INNER JOIN trs_wo w ON g.gd_id_trs_wo=w.id
		WHERE w.kode_po='$kode_po'");
		foreach($getPO->result() as $po){
			$this->db->set('gd_status', 'Close');
			$this->db->where('id_gudang', $po->id_gudang);
			$updateGudang = $this->db->update('m_gudang');
		}

		// GET DATA
		$id_gudang = $_POST["id_gudang"];
		$getData = $this->db->query("SELECT p.nm_pelanggan,i.nm_produk,g.* FROM m_gudang g
		INNER JOIN m_pelanggan p ON g.gd_id_pelanggan=p.id_pelanggan
		INNER JOIN m_produk i ON g.gd_id_produk=i.id_produk
		WHERE g.id_gudang='$id_gudang'")->row();

		return [
			'data' => $updateGudang,
			'gd_id_pelanggan' => $getData->gd_id_pelanggan,
			'gd_id_produk' => $getData->gd_id_produk,
			'nm_pelanggan' => $getData->nm_pelanggan,
			'nm_produk' => $getData->nm_produk,
		];
	}

	function openGudang()
	{
		// open
		$id_gudang = $_POST["id_gudang"];
		$this->db->set('gd_status', 'Open');
		$this->db->where('id_gudang', $id_gudang);
		$updateGudang = $this->db->update('m_gudang');

		// GET DATA
		$getData = $this->db->query("SELECT p.nm_pelanggan,i.nm_produk,g.* FROM m_gudang g
		INNER JOIN m_pelanggan p ON g.gd_id_pelanggan=p.id_pelanggan
		INNER JOIN m_produk i ON g.gd_id_produk=i.id_produk
		WHERE g.id_gudang='$id_gudang'")->row();

		return [
			'data' => $updateGudang,
			'gd_id_pelanggan' => $getData->gd_id_pelanggan,
			'gd_id_produk' => $getData->gd_id_produk,
			'nm_pelanggan' => $getData->nm_pelanggan,
			'nm_produk' => $getData->nm_produk,
		];
	}

	//

	function simpanCartRKSJ()
	{
		foreach($this->cart->contents() as $r){
			$data = array(
				'rk_tgl' => date('Y-m-d'),
				'id_pelanggan' => $r['options']['id_pelanggan'],
				'id_produk' => $r['options']['id_produk'],
				'kategori' => $r['options']['kategori'],
				'id_gudang' => $r['options']['id_gudang'],
				'qty_muat' => $r['options']['qty_muat'],
				'rk_tonase' => $r['options']['rk_tonase'],
				'rk_kode_po' => $r['options']['rk_kode_po'],
				'rk_bb' => $r['options']['rk_bb'],
			);
			$insertRencanaKirim = $this->db->insert('m_rencana_kirim', $data);
		}

		return [
			'insertRencanaKirim' => $insertRencanaKirim,
		];
	}

	function editListUrutRK()
	{
		$tgl = date('Y-m-d');
		$urut = $_POST["urut"];

		$cekKirim = $this->db->query("SELECT*FROM pl_box WHERE tgl='$tgl' AND no_pl_urut='$urut'");
		if($cekKirim->num_rows() == 0){
			$this->db->set('rk_urut', $_POST["urut"]);
			$this->db->where('id_rk', $_POST["id_rk"]);
			$data = $this->db->update('m_rencana_kirim');
			$msg = 'BERHASIL!';
		}else{
			$data = false;
			$msg = 'NO URUT SUDAH TERPAKAI!';
		}

		return [
			'data' => $data,
			'msg' => $msg,
		];
	}

	function editListRencanaKirim()
	{
		if($_POST["muat"] == 0){
			$data = false;
			$msg = 'MUAT TIDAK BOLEH KOSONG!';
		}else{
			$this->db->set('qty_muat', $_POST["muat"]);
			$this->db->set('rk_tonase', $_POST["tonase"]);
			$this->db->where('id_rk', $_POST["id_rk"]);
			$data = $this->db->update('m_rencana_kirim');
			$msg = 'BERHASIL';
		}

		return [
			'data' => $data,
			'msg' => $msg,
		];
	}

	function hapusListRencanaKirim()
	{
		$this->db->where('id_rk', $_POST["id_rk"]);
		$data = $this->db->delete('m_rencana_kirim');

		return [
			'data' => $data,
		];
	}

	function selesaiMuat()
	{
		$urut = $_POST["urut"];
		$cekMuat = $this->db->query("SELECT p.ppn,r.* FROM m_rencana_kirim r
		-- INNER JOIN m_produk i ON r.id_produk=i.id_produk
		INNER JOIN trs_po_detail p ON r.id_produk=p.id_produk AND r.id_pelanggan=p.id_pelanggan AND r.rk_kode_po=p.kode_po
		WHERE r.rk_urut='$urut' AND r.rk_status='Open'");

		$tgl = date('Y-m-d');
		// INSERT PL BOX
		foreach($cekMuat->result() as $r){
			($r->kategori == "BOX") ? $kategori = 'BOX' : $kategori = 'SHEET';
			$blnRomami = $this->m_fungsi->blnRomami(date('Y-m-d'));
			if($r->ppn == "PP"){
				$pajak = 'ppn';
				$sjSo = 'A';
				$pkb = '';
			}else{
				$pajak = 'non';
				$sjSo = 'B';
				$pkb = '.';
			}

			$id_hub = $this->db->query("SELECT h.aka,p.* FROM trs_po p INNER JOIN m_hub h ON p.id_hub=h.id_hub WHERE p.kode_po='$r->rk_kode_po'")->row();
			if($id_hub->id_hub != 7){
				$no_surat = '000/'.$id_hub->aka.'/'.$blnRomami.'/'.substr(date('Y'),2,2);
				$no_so = '000/'.$id_hub->aka.'/'.$blnRomami.'/'.substr(date('Y'),2,2);
				$no_pkb = '000/'.$id_hub->aka.'/'.$blnRomami.'/'.substr(date('Y'),2,2);
			}else{
				$no_surat = '000/'.$kategori.'/'.$blnRomami.'/'.substr(date('Y'),2,2).'/'.$sjSo;
				$no_so = '000/SO-'.$kategori.'/'.$blnRomami.'/'.substr(date('Y'),2,2).'/'.$sjSo;
				$no_pkb = '000/'.substr(date('Y'),2,2).'/'.$kategori.$pkb;
			}

			$data = [
				'id_perusahaan' => $r->id_pelanggan,
				'id_hub' => $id_hub->id_hub,
				'tgl' => $tgl,
				'no_surat' => $no_surat,
				'no_so' => $no_so,
				'no_pkb' => $no_pkb,
				'no_kendaraan' => '',
				'no_po' => $r->rk_kode_po,
				'pajak' => $pajak,
				'no_pl_urut' => $urut,
				'kategori' => $kategori,
			];

			// CEK JIKA CUSTOMER DENGAN PO DAN KETEGORI YANG SAMA ABAIKAN
			$cekPL = $this->db->query("SELECT*FROM pl_box WHERE tgl='$tgl' AND id_perusahaan='$r->id_pelanggan' AND no_po='$r->rk_kode_po' AND no_pl_urut='$urut' AND kategori='$kategori'");
			if($cekPL->num_rows() == 0){
				$insertPl = $this->db->insert('pl_box', $data);
			}else{
				$insertPl = true;
			}
		}

		// MASUKKAN LIST RENCANA KIRIM KE PACKING LIST, CUSTOMER DAN PO YANG SAMA
		$getPL = $this->db->query("SELECT*FROM pl_box WHERE tgl='$tgl' AND no_pl_urut='$urut'");
		foreach($getPL->result() as $l){
			$this->db->set('id_pl_box', $l->id);
			$this->db->set('rk_status', 'Close');
			$this->db->where('rk_tgl', $l->tgl);
			$this->db->where('rk_urut', $l->no_pl_urut);
			$this->db->where('rk_kode_po', $l->no_po);
			$this->db->where('kategori', $l->kategori);
			$updateIDplBox = $this->db->update('m_rencana_kirim');
		}

		return [
			'insertPl' => $insertPl,
			'updateIDplBox' => $updateIDplBox,
		];
	}

	function btnBatalPengiriman()
	{
		$tgl = $_POST["tgl"];
		$urut = $_POST["urut"];

		// HAPUS PACKING LIST
		$this->db->where('tgl', $tgl);
		$this->db->where('no_pl_urut', $urut);
		$deletePL = $this->db->delete('pl_box');

		// UPDATE RENCANA KIRIM
		$this->db->set('id_pl_box', null);
		$this->db->set('rk_status', 'Open');
		$this->db->where('rk_tgl', $tgl);
		$this->db->where('rk_urut', $urut);
		$updateRK = $this->db->update('m_rencana_kirim');

		// HAPUS TIMBANGAN
		$this->db->where('urut_t', $urut);
		$this->db->where('tgl_t', $tgl);
		$deleteTimb = $this->db->delete('m_jembatan_timbang');

		// HAPUS JASA
		$this->db->where('tgl', $tgl);
		$this->db->where('urut', $urut);
		$deleteJasa = $this->db->delete('m_jasa');

		return [
			'deletePL' => $deletePL,
			'updateRK' => $updateRK,
			'deleteTimb' => $deleteTimb,
			'deleteJasa' => $deleteJasa,
		];
	}

	function addPengirimanNoPlat()
	{
		$tgl = $_POST["tgl"];
		$urut = $_POST["urut"];
		$plat = $_POST["plat"];

		$this->db->set('no_kendaraan', $plat);
		$this->db->where('tgl', $tgl);
		$this->db->where('no_pl_urut', $urut);
		$addPlat = $this->db->update('pl_box');

		return [
			'addPlat' => $addPlat,
		];
	}

	function editPengirimanNoSJ()
	{ //
		$id_pl = $_POST["id_pl"];
		$no_surat = $_POST["no_surat"];

		$cekPrint = $this->db->query("SELECT*FROM pl_box WHERE id='$id_pl' AND cetak_sj='acc'");
		if($cekPrint->num_rows() == 0){
			$pl = $this->db->query("SELECT*FROM pl_box WHERE id='$id_pl'")->row();
			$sj = explode('/', $pl->no_surat);
			$so = explode('/', $pl->no_so);
			$pkb = explode('/', $pl->no_pkb);
	
			if($pl->id_hub != 7){
				$noSJ = $no_surat.'/'.$sj[1].'/'.$sj[2].'/'.$sj[3];
				$noSO = $no_surat.'/'.$so[1].'/'.$so[2].'/'.$so[3];
				$noPKB = $no_surat.'/'.$pkb[1].'/'.$pkb[2].'/'.$pkb[3];
			}else{
				$noSJ = $no_surat.'/'.$sj[1].'/'.$sj[2].'/'.$sj[3].'/'.$sj[4];
				$noSO = $no_surat.'/'.$so[1].'/'.$so[2].'/'.$so[3].'/'.$so[4];
				$noPKB = $no_surat.'/'.$pkb[1].'/'.$pkb[2];
			}

			$cekSJ = $this->db->query("SELECT*FROM pl_box WHERE no_surat='$noSJ'");
			if($cekSJ->num_rows() == 0){
				$this->db->set('no_surat', $noSJ);
				$this->db->set('no_so', $noSO);
				$this->db->set('no_pkb', $noPKB);
				$this->db->where('no_po', $pl->no_po);
				$this->db->where('no_surat', $pl->no_surat);
				$this->db->where('no_pl_urut', $pl->no_pl_urut);
				$updateNO = $this->db->update('pl_box');
				$msg = 'BERHASIL!';
			}else{
				$updateNO = false;
				$msg = 'NOMER SJ SUDAH TERPAKAI!';
			}
		}else{
			$updateNO = false;
			$msg = 'SUDAH CETAK SURAT JALAN!';
		}

		return [
			'data' => $updateNO,
			'msg' => $msg,
		];
	}

	function addTimbangan()
	{
		$tgl = $_POST["tgl"];
		$urut = $_POST["urut"];
		$plat = $_POST["plat"];
		$supir = $_POST["supir"];
		$tb_truk = $_POST["tb_truk"];
		$timbangan = $_POST["timbangan"];

		if($supir == "" || $timbangan < 0 || $timbangan == 0 || $tb_truk == "" || $timbangan == ""){
			$data = false; $result = false; $msg = 'HARAP LENGKAPI DATA!';
		}else if($tb_truk == $timbangan){
			$data = false; $result = false; $msg = 'BERAT TRUK TIDAK BOLEH SAMA DENGAN BERAT BERSIH!';
		}else if($tb_truk < $timbangan){
			$data = false; $result = false; $msg = 'BERAT TRUK HARUS LEBIH BESAR DARI BERAT BERSIH!';
		}else{
			// KELUAR
			$now = date("Y-m-d");
			if($now == $tgl){
				$date_keluar = date("Y-m-d H:i:s");
			}else{
				$k_detik = strtotime($tgl) + rand(1, 60); // 1 menit
				$k_jam = $k_detik + 7200; // 2 jam
				$k_rand = $k_jam + rand(28800, 57600); // 8 pagi - 4 sore
				$date_keluar = date("Y-m-d H:i:s", $k_rand);
			}
			// DATE MASUK
			$detik = strtotime($date_keluar) - rand(1, 60); // 1 menit
			$jam = $detik - 3600; // 1 jam
			$rand = $jam - rand(60, 1800); // 1 menit - 30 menit
			$date_masuk = date("Y-m-d H:i:s", $rand);
			// CATATAN
			$getCatatan = $this->db->query("SELECT p.*,c.nm_pelanggan FROM pl_box p
			INNER JOIN m_pelanggan c ON p.id_perusahaan=c.id_pelanggan
			WHERE p.tgl='$tgl' AND p.no_pl_urut='$urut' AND p.no_kendaraan='$plat'
			GROUP BY p.id_perusahaan ORDER BY c.nm_pelanggan");
			$catatan = '';
			if($getCatatan->num_rows() == 1){
				$catatan .= $getCatatan->row()->nm_pelanggan;
			}else{
				$i = 0;
				foreach($getCatatan->result() as $c){
					$i++;
					$catatan .= $c->nm_pelanggan;
					if($getCatatan->num_rows() != $i){
						$catatan .= ' ';
					}
				}
			}
			// CEK DATA TIMBANGAN
			$qTimb = $this->db->query("SELECT*FROM m_jembatan_timbang WHERE urut_t='$urut' AND tgl_t='$tgl' GROUP BY urut_t,tgl_t");
			if($qTimb->num_rows() == 0){
				$no_timbangan = $this->m_fungsi->urut_transaksi('TIMBANGAN').'/TIMB'.'/'.date('Y');
			}else{
				$no_timbangan = $qTimb->row()->no_timbangan;
			}
			$berat_kotor = $tb_truk - $timbangan;
			// DATA
			$data = array(
				'no_timbangan' => $no_timbangan,
				'id_pelanggan' => null,
				'input_t' => 'CORR',
				'suplier' => 'PT. PRIMA PAPER INDONESIA',
				'alamat' => 'Timang Kulon, Wonokerto, Wonogiri',
				'no_polisi' => $plat,
				'date_masuk' => $date_masuk,
				'date_keluar' => $date_keluar,
				'nm_barang' => 'KARTON BOX',
				'berat_kotor' => $berat_kotor,
				'berat_truk' => $tb_truk,
				'berat_bersih' => $timbangan,
				'potongan' => 0,
				'catatan' => $catatan,
				'nm_penimbang' => 'Feri S',
				'nm_sopir' => $supir,
				'keterangan' => 'KIRIM',
				'permintaan' => 'KIRIMAN',
				'urut_t' => $urut,
				'tgl_t' => $tgl,
				'pilih_po' => 'TIDAK',
			);
			// INSERT - UPDATE
			if($qTimb->num_rows() == 0){
				$result = $this->db->insert("m_jembatan_timbang", $data);
				$msg = 'insert';
			}else{
				$this->db->where("urut_t", $urut);
				$this->db->where("tgl_t", $tgl);
				$result = $this->db->update("m_jembatan_timbang", $data);
				$msg = 'update';
			}
		}
		// RETURN
		return [
			'data' => $data,
			'result' => $result,
			'msg' => $msg,
		];
	}

	function insertSuratJalanJasa()
	{
		$no_surat = $_POST["no_surat"];
		$opsi = $_POST["opsi"];
		
		// CEK
		$cek = $this->db->query("SELECT*FROM m_jasa WHERE no_surat='$no_surat'");
		// GET DATA PL
		if($opsi == 'cor'){
			$pl = $this->db->query("SELECT*FROM pl_box WHERE no_surat='$no_surat' GROUP BY no_surat")->row();
		}
		if($opsi == 'lam'){
			$pl = $this->db->query("SELECT*FROM pl_laminasi WHERE no_surat='$no_surat' GROUP BY no_surat")->row();
		}
		if($cek->num_rows() == 0){
			$no = explode('/',$no_surat);
			if($opsi == 'cor'){
				$tahun = $no[3];
				$db_jasa = $this->db->query("SELECT*FROM m_jasa WHERE no_jasa LIKE '%/$tahun'")->num_rows();
				$jasa = str_pad($db_jasa+1, 3, "0", STR_PAD_LEFT);
				$no_jasa = 'JASA/'.$jasa.'/PPI'.'/'.$no[2].'/'.$tahun;
			}
			if($opsi == 'lam'){
				$str_len = strlen($no_surat);
				($str_len == 12) ? $tahun = $no[1] : $tahun = $no[3];
				$db_jasa = $this->db->query("SELECT*FROM m_jasa WHERE no_jasa LIKE '%/$tahun/LAMINASI'")->num_rows();
				$jasa = str_pad($db_jasa+1, 3, "0", STR_PAD_LEFT);
				$no_jasa = 'JASA/'.$jasa.'/PPI'.'/'.$tahun.'/LAMINASI';
			}
			$data = array(
				'no_surat' => $no_surat,
				'tgl' => $pl->tgl,
				'no_po' => $pl->no_po,
				'no_jasa' => $no_jasa,
				'urut' => $pl->no_pl_urut,
				'id_pl_box' => $pl->id ,
			);
			$insert = $this->db->insert('m_jasa', $data);
		}else{
			$data = false;
			$insert = false;
			// GET DATA
			$no_jasa = $this->db->query("SELECT*FROM m_jasa WHERE no_surat='$no_surat' LIMIT 1")->row()->no_jasa;
		}

		return [
			'insert' => $insert,
			'data' => $data,
			'no_jasa' => $no_jasa,
		];
	}

	function cUkuranKualitas()
	{
		$id_rk = $_POST["id_rk"];
		$c_uk = $_POST["c_uk"];
		$c_kl = $_POST["c_kl"];
		$id_produk = $_POST["id_produk"];
		$opsi = $_POST["opsi"];
		
		// GET RENCANA KIRIM
		$rk = $this->db->query("SELECT*FROM m_rencana_kirim WHERE id_rk='$id_rk'")->row();

		if($opsi == "UK"){
			$set = "c_uk";
			$ket = $c_uk;
		}else{
			$set = "c_kl";
			$ket = $c_kl;
		}
		$this->db->set($set, ($ket == 1) ? 0 : 1);
		$this->db->where("rk_tgl", $rk->rk_tgl);
		$this->db->where("id_produk", $rk->id_produk);
		$this->db->where("rk_urut", $rk->rk_urut);
		$result = $this->db->update("m_rencana_kirim");

		return [
			'rk' => $rk,
			'data' => $result,
		];
	}

	//

	function simpanCartLaminasi()
	{
		foreach($this->cart->contents() as $r){
			$id_m_produk_lm = $r["options"]["id_m_produk_lm"];
			$id_pelanggan_lm = $r["options"]["id_pelanggan_lm"];
			$id_po_lm = $r["options"]["id_po"];
			$id_po_dtl = $r["options"]["id_dtl"];

			$cek = $this->db->query("SELECT SUM(qty_muat) AS jml_muat FROM m_rk_laminasi
			WHERE id_m_produk_lm='$id_m_produk_lm' AND id_pelanggan_lm='$id_pelanggan_lm' AND id_po_lm='$id_po_lm' AND id_po_dtl='$id_po_dtl'
			AND rk_status='Open' AND rk_urut='0'
			GROUP BY id_m_produk_lm, id_pelanggan_lm, id_po_lm, id_po_dtl, rk_status, rk_urut");

			if($cek->num_rows() == 0){
				$data = array(
					'id_m_produk_lm' => $r["options"]["id_m_produk_lm"],
					'id_pelanggan_lm' => $r["options"]["id_pelanggan_lm"],
					'id_po_lm' => $r["options"]["id_po"],
					'id_po_dtl' => $r["options"]["id_dtl"],
					'rk_no_po' => $r["options"]["no_po_lm"],
					'qty_muat' => $r["options"]["muat"],
					'rk_status' => 'Open',
					'rk_urut' => 0,
				);
				$insertRK = $this->db->insert('m_rk_laminasi', $data);
			}else{
				$this->db->set('qty_muat', $r["options"]["muat"] + $cek->row()->jml_muat);
				$this->db->where('id_m_produk_lm', $id_m_produk_lm);
				$this->db->where('id_pelanggan_lm', $id_pelanggan_lm);
				$this->db->where('id_po_lm', $id_po_lm);
				$this->db->where('id_po_dtl', $id_po_dtl);
				$this->db->where('rk_status', 'Open');
				$this->db->where('rk_urut', 0);
				$insertRK = $this->db->update('m_rk_laminasi');
			}
		}

		return [
			'insertRK' => $insertRK,
		];
	}

	function kirimSJLaminasi()
	{
		$id_pelanggan_lm = $_POST["id_pelanggan_lm"];
		$id_hub = $_POST["id_hub"];
		$tgl = $_POST["tgl"];
		$attn = $_POST["attn"];
		$alamat_kirim = $_POST["alamat_kirim"];
		$no_telp = $_POST["no_telp"];
		$no_kendaraan = $_POST["no_kendaraan"];
		if($attn == ''){
			$data = false; $insertPL = false; $updateIDPL = false;
			$msg = 'ATTN TIDAK BOLEH KOSONG!';
		}else if($alamat_kirim == ''){
			$data = false; $insertPL = false; $updateIDPL = false;
			$msg = 'ALAMAT KIRIM TIDAK BOLEH KOSONG!';
		}else if($no_telp == ''){
			$data = false; $insertPL = false; $updateIDPL = false;
			$msg = 'NO. TELP TIDAK BOLEH KOSONG!';
		}else if($no_kendaraan == ''){
			$data = false; $insertPL = false; $updateIDPL = false;
			$msg = 'NOMER KENDARAAN TIDAK BOLEH KOSONG!';
		}else{
			// CARI NOMER SURAT JALAN BEDASARKAN HUB
			$tahun = substr(date('Y'),2,2);
			if($id_hub == 0 || $id_hub == 7){
				$noSJ = $this->db->query("SELECT*FROM pl_laminasi WHERE no_surat LIKE '%/$tahun/LM' ORDER BY no_surat DESC LIMIT 1");
				($noSJ->num_rows() == 0) ? $no = 0 : $no = substr($noSJ->row()->no_surat,0,6);
				$no_surat = str_pad($no+1, 6, "0", STR_PAD_LEFT).'/'.$tahun.'/LM';
			}else{
				$hub = $this->db->query("SELECT aka FROM m_hub WHERE id_hub='$id_hub'")->row();
				$noSJ = $this->db->query("SELECT l.no_surat,p.id_hub,r.*,b.aka FROM m_rk_laminasi rk
				INNER JOIN pl_laminasi l ON rk.id_pl_lm=l.id AND rk.rk_urut=l.no_pl_urut AND rk.rk_no_po=l.no_po AND rk.rk_tgl=l.tgl AND rk.id_pelanggan_lm=l.id_perusahaan
				INNER JOIN trs_po_lm_detail dtl ON rk.id_po_dtl=dtl.id
				INNER JOIN trs_po_lm p ON p.id=rk.id_po_lm
				INNER JOIN m_no_rek_lam r ON r.id_hub=p.id_hub
				LEFT JOIN m_hub b ON r.id_hub=b.id_hub
				WHERE l.no_surat LIKE '%/$hub->aka/$tahun' AND p.id_hub='$id_hub' ORDER BY l.no_surat DESC LIMIT 1");
				if($noSJ->num_rows() == 0){
					$no = 0;
					$aka = $hub->aka;
				}else{
					$no = substr($noSJ->row()->no_surat,3,3);
					$aka = $noSJ->row()->aka;
				}
				$no_surat = 'LM/'.str_pad($no+1, 3, "0", STR_PAD_LEFT).'/'.$aka.'/'.$tahun;
			}
			// UPDATE RK URUT
			$cekUrut = $this->db->query("SELECT*FROM m_rk_laminasi WHERE rk_tgl='$tgl' GROUP BY rk_urut DESC LIMIT 1");
			($cekUrut->num_rows() == 0) ? $rk_urut = 1 : $rk_urut = $cekUrut->row()->rk_urut + 1;
			// INSERT KE PACKING LIST
			$no_po = $this->db->query("SELECT rk.* FROM m_rk_laminasi rk
			INNER JOIN trs_po_lm p ON p.id=rk.id_po_lm
			WHERE rk.id_pelanggan_lm='$id_pelanggan_lm' AND p.id_hub='$id_hub' AND rk.rk_urut='0' GROUP BY rk.rk_no_po");
			foreach($no_po->result() as $r){
				$pl = array(
					'id_perusahaan' => $r->id_pelanggan_lm,
					'tgl' => $tgl,
					'no_surat' => $no_surat,
					'attn_pl' => $attn,
					'alamat_pl' => $alamat_kirim,
					'no_telp_pl' => $no_telp,
					'no_kendaraan' => $no_kendaraan,
					'no_po' => $r->rk_no_po,
					'sj' => 'Open',
					'sj_blk' => NULL,
					'pajak' => NULL,
					'no_pl_inv' => 0,
					'no_pl_urut' => $rk_urut,
					'cetak_sj' => 'not',
				);
				$insertPL = $this->db->insert('pl_laminasi', $pl);
			}
			// UPDATE ID PL DI RENCANA KIRIM
			if($insertPL){
				$cekPL = $this->db->query("SELECT*FROM pl_laminasi WHERE id_perusahaan='$id_pelanggan_lm' AND tgl='$tgl' AND no_pl_urut='$rk_urut'");
				foreach($cekPL->result() as $c){
					$this->db->set('id_pl_lm', $c->id);
					$this->db->set('rk_tgl', $tgl);
					$this->db->set('rk_status', 'Close');
					$this->db->set('rk_urut', $rk_urut);
					$this->db->where('id_pelanggan_lm', $c->id_perusahaan);
					$this->db->where('rk_tgl', null);
					$this->db->where('rk_no_po', $c->no_po);
					$this->db->where('rk_urut', 0);
					$updateIDPL = $this->db->update('m_rk_laminasi');
				}
			}
			$data = true;
			$msg = 'OK';
		}
		return [
			'insertPL' => $insertPL,
			'updateIDPL' => $updateIDPL,
			'msg' => $msg,
			'data' => $data,
		];
	}

	//

	function simpanInvLam()
	{
		$id_header = $_POST["h_id_header"];
		$tgl_invoice = $_POST["tgl_invoice"];
		$tgl_sj = $_POST["tgl_sj"];
		$no_surat_jalan = $_POST["no_surat_jalan"];
		$tgl_jatuh_tempo = $_POST["tgl_jatuh_tempo"];
		$id_pelanggan_lm = $_POST["h_id_pelanggan_lm"];
		$kepada = $_POST["kepada"];
		$alamat = $_POST["alamat"];
		$pilihan_bank = $_POST["pilihan_bank"];
		$statusInput = $_POST["statusInput"];

		$tahun = substr($tgl_sj,2,2);
		$noSJ = $this->db->query("SELECT*FROM invoice_laminasi_header WHERE no_invoice LIKE '%$tahun%' ORDER BY no_invoice DESC LIMIT 1");
		($noSJ->num_rows() == 0) ? $no = 0 : $no = substr($noSJ->row()->no_invoice, 4, 6);
		$no_invoice = 'INV/'.str_pad($no+1, 6, "0", STR_PAD_LEFT).'/'.$tahun.'/LM';

		($statusInput == 'insert') ? $no_inv = $_POST["no_invoice"] : $no_inv = substr($_POST["no_invoice"], 4, 6);
		if($no_inv == 000000 || $no_inv == '000000' || $no_inv == '' || $no_inv < 0 || strlen("'.$no_inv.'") < 6){
			$data = false; $insert = false; $detail = false; $no_pl_inv = false;
			$msg = 'NOMER INVOICE TIDAK BOLEH KOSONG!';
		}else if($tgl_invoice == "" || $no_inv == "" || $tgl_jatuh_tempo == "" || $kepada == "" || $alamat == "" || $pilihan_bank == ""){
			$data = false; $insert = false; $detail = false; $no_pl_inv = false;
			$msg = 'HARAP LENGKAPI FORM!';
		}else{
			if($statusInput == 'insert'){
				$data = array(
					'tgl_invoice' => $tgl_invoice,
					'tgl_surat_jalan' => $tgl_sj,
					'tgl_jatuh_tempo' => $tgl_jatuh_tempo,
					'id_pelanggan_lm' => $id_pelanggan_lm,
					'no_surat' => $no_surat_jalan,
					'no_invoice' => $no_invoice,
					'attn_lam_inv' => $kepada,
					'alamat_lam_inv' => $alamat,
					'bank' => $pilihan_bank,
					'status_inv' => 'Open',
					'acc_admin' => 'Y',
					'time_admin' => date('Y-m-d H:i:s'),
					'acc_owner' => 'N',
				);
				$insert = $this->db->insert('invoice_laminasi_header', $data);
				
				if($insert){
					$isi = $this->db->query("SELECT rk.*,i.*,dtl.*,rk.id AS id_rk_lam FROM m_rk_laminasi rk
					INNER JOIN pl_laminasi l ON rk.id_pl_lm=l.id AND rk.rk_urut=l.no_pl_urut AND rk.rk_no_po=l.no_po AND rk.rk_tgl=l.tgl AND rk.id_pelanggan_lm=l.id_perusahaan
					INNER JOIN trs_po_lm_detail dtl ON rk.id_po_dtl=dtl.id
					INNER JOIN m_produk_lm i ON rk.id_m_produk_lm=i.id_produk_lm
					WHERE l.no_surat='$no_surat_jalan'
					ORDER BY rk.rk_no_po,i.nm_produk_lm,i.ukuran_lm,i.isi_lm,i.jenis_qty_lm");
					foreach($isi->result() as $r){
						if($r->jenis_qty_lm == 'pack'){
							$qty = $r->pack_lm;
						}else if($r->jenis_qty_lm == 'ikat'){
							$qty = $r->ikat_lm;
						}else{
							$qty = $r->kg_lm;
						}
						$total = ($qty * $r->qty_muat) * $r->harga_pori_lm;
						$this->db->set('id_rk_lm', $r->id_rk_lam);
						$this->db->set('id_produk_lm', $r->id_produk_lm);
						$this->db->set('id_po_dtl', $r->id_po_dtl);
						$this->db->set('no_surat', $no_surat_jalan);
						$this->db->set('no_invoice', $no_invoice);
						$this->db->set('total', $total);
						$detail = $this->db->insert('invoice_laminasi_detail');
					}
					// update no_pl_inv di pl laminasi
					if($detail){
						$this->db->set('no_pl_inv', 1);
						$this->db->where('no_surat', $no_surat_jalan);
						$no_pl_inv = $this->db->update('pl_laminasi');
					}
					$msg = 'insert!';
				}
			}else{
				$data = array(
					'tgl_invoice' => $tgl_invoice,
					'tgl_jatuh_tempo' => $tgl_jatuh_tempo,
					'attn_lam_inv' => $kepada,
					'alamat_lam_inv' => $alamat,
					// 'bank' => $pilihan_bank,
					'edit_admin' => date('Y-m-d H:i:s'),
				);
				$this->db->where('id', $id_header);
				$insert = $this->db->update('invoice_laminasi_header', $data);
				$detail = true;
				$no_pl_inv = true;
				$msg = 'update!';
			}
		}

		return [
			'data' => $data,
			'insert' => $insert,
			'detail' => $detail,
			'no_pl_inv' => $no_pl_inv,
			'msg' => $msg,
		];
	}

	function returInvLaminasi()
	{
		$id_dtl = $_POST["id_dtl"];
		$retur_qty = $_POST["retur_qty"];
		$qty_order = $_POST["qty_order"];

		if($retur_qty < 0){
			$data = false; $data2 = false; $msg = 'QTY RETUR TIDAK BOLEH KOSONG!';
		}if($retur_qty > $qty_order){
			$data = false; $data2 = false; $msg = 'QTY RETUR LEBIH DARI QTY ORDER!';
		}else{
			$r = $this->db->query("SELECT i.*,r.qty_muat,d.retur_qty,l.harga_pori_lm,d.total,d.no_invoice FROM invoice_laminasi_detail d
			INNER JOIN m_rk_laminasi r ON d.id_rk_lm=r.id
			INNER JOIN m_produk_lm i ON d.id_produk_lm=i.id_produk_lm
			INNER JOIN trs_po_lm_detail l ON d.id_po_dtl=l.id
			WHERE d.id='$id_dtl'")->row();
			if($r->jenis_qty_lm == 'pack'){
				$qty = $r->pack_lm;
			}else if($r->jenis_qty_lm == 'ikat'){
				$qty = $r->ikat_lm;
			}else{
				$qty = $r->kg_lm;
			}
			$total = (($qty * $r->qty_muat) - $retur_qty) * $r->harga_pori_lm;
			$this->db->set('retur_qty', ($retur_qty == "") ? 0 : $retur_qty);
			$this->db->set('total', $total);
			$this->db->where('id', $id_dtl);
			$data = $this->db->update('invoice_laminasi_detail');

			if($data){
				// CEK JIKA MINUS
				$d = $this->db->query("SELECT SUM(total) AS total FROM invoice_laminasi_detail WHERE no_invoice='$r->no_invoice' GROUP BY no_invoice")->row();
				$qDisc = $this->db->query("SELECT SUM(hitung) AS disc FROM invoice_laminasi_disc WHERE no_invoice='$r->no_invoice' GROUP BY no_invoice");
				($qDisc->num_rows() == 0) ? $disc = 0 : $disc = $qDisc->row()->disc;
				$total_dtl = $d->total - $disc;
				if($total_dtl < 0){
					$total2 = ($qty * $r->qty_muat) * $r->harga_pori_lm;
					$this->db->set('retur_qty', 0);
					$this->db->set('total', $total2);
					$this->db->where('id', $id_dtl);
					$data2 = $this->db->update('invoice_laminasi_detail');
					$msg = 'TOTAL TIDAK BOLEH MINUS!';
				}else{
					$data2 = false;
					$msg = 'BERHASIL TAMBAH QTY RETUR!';
				}
			}
		}

		return [
			'data' => $data,
			'data2' => $data2,
			'msg' => $msg,
		];
	}

	function btnVerifInvLaminasi()
	{
		if($_POST["ket_laminasi"] == '' && ($_POST["aksi"] == 'H' || $_POST["aksi"] == 'R')){
			$result = false;
		}else{
			if($_POST["aksi"] == 'H' || $_POST["aksi"] == 'N'){
				$status = 'Open';
			}else if($_POST["aksi"] == 'R'){
				$status = 'Reject';
			}else{
				$status = 'Approve';
			}

			if($_POST["aksi"] == 'N'){
				$ket = null;
			}else if($_POST["aksi"] == 'Y' && $_POST["ket_laminasi"] == ''){
				$ket = 'OK!';
			}else{
				$ket = $_POST["ket_laminasi"];
			}

			$this->db->set('status_inv', $status);
			$this->db->set('acc_owner', $_POST["aksi"]);
			$this->db->set('time_owner', ($_POST["aksi"] == 'N') ? null : date('Y-m-d H:i:s'));
			$this->db->set('ket_owner', $ket);
			$this->db->where('id', $_POST["h_id_header"]);
			$result = $this->db->update('invoice_laminasi_header');
		}

		return $result;
	}

	function addDisc()
	{
		$no_invoice = $_POST["no_invoice"];
		$dc_opsi = $_POST["dc_opsi"];
		$persen = $_POST["persen"];
		$hari = $_POST["hari"];
		$rupiah = $_POST["rupiah"];
		$ball = $_POST["ball"];
		$hitung = $_POST["hitung"];
		$total = $_POST["total"];

		$cek = $this->db->query("SELECT*FROM invoice_laminasi_disc WHERE no_invoice='$no_invoice' AND opsi='$dc_opsi'");

		if($total < 0 || $total == ''){
			$result = false; $msg = 'NGAWUR!';
		}else if($dc_opsi == 'DISCOUNT' && ($persen == 0 || $persen == '' || $hari == 0 || $hari == '')){
			$result = false; $msg = 'HARAP LENGKAPI DATA!';
		}else if($dc_opsi == 'BIAYA BONGKAR' && ($rupiah == 0 || $rupiah == '')){
			$result = false; $msg = 'HARAP LENGKAPI DATA!';
		}else if($dc_opsi == 'POTONG KARUNG' && ($rupiah == 0 || $rupiah == '' || $ball == 0 || $ball == '')){
			$result = false; $msg = 'HARAP LENGKAPI DATA!';
		}else if($cek->num_rows() > 0){
			$result = false; $msg = 'DATA SUDAH ADA!';
		}else{
			$data = array(
				'no_invoice' => $no_invoice,
				'opsi' => $dc_opsi,
				'persen' => $persen,
				'hari' => $hari,
				'rupiah' => $rupiah,
				'ball' => $ball,
				'hitung' => $hitung,
			);
			$result = $this->db->insert('invoice_laminasi_disc', $data);
			$msg = 'OK!';
		}

		return [
			'result' => $result,
			'msg' => $msg,
		];
	}

	function hapusDisc()
	{
		$id = $_POST["id"];
		$this->db->where('id', $id);
		$data = $this->db->delete('invoice_laminasi_disc');
		return [
			'data' => $data,
		];
	}

	function hapusInvoiceLaminasi()
	{
		$id = $_POST["id"];
		$data = $this->db->query("SELECT*FROM invoice_laminasi_header WHERE id='$id'")->row();

		$this->db->where('no_invoice', $data->no_invoice);
		$header = $this->db->delete('invoice_laminasi_header');
		if($header){
			$this->db->where('no_invoice', $data->no_invoice);
			$detail = $this->db->delete('invoice_laminasi_detail');
			if($detail){
				$this->db->where('no_invoice', $data->no_invoice);
				$disc = $this->db->delete('invoice_laminasi_disc');
				// UPDATE no_pl_inv jadi 0
				if($disc){
					$this->db->set('no_pl_inv', 0);
					$this->db->where('no_surat', $data->no_surat);
					$no_pl_inv = $this->db->update('pl_laminasi');
				}
			}
		}

		return [
			'data' => $data,
			'header' => $header,
			'detail' => $detail,
			'disc' => $disc,
			'no_pl_inv' => $no_pl_inv,
		];
	}

	//

	function simpanInvJasa()
	{
		$h_id_header = $_POST["h_id_header"];
		$tgl_invoice = $_POST["tgl_invoice"];
		$pilih_transaksi = $_POST["pilih_transaksi"];
		$tgl_sj = $_POST["tgl_sj"];
		$no_surat_jalan = $_POST["no_surat_jalan"];
		$no_invoice = $_POST["no_invoice"];
		$tgl_jatuh_tempo = $_POST["tgl_jatuh_tempo"];
		$h_id_hub = $_POST["h_id_hub"];
		$kepada = $_POST["kepada"];
		$alamat = $_POST["alamat"];
		$pilihan_bank = $_POST["pilihan_bank"];
		$opsi = $_POST["opsi"];
		$statusInput = $_POST["statusInput"];

		$tahun = substr($tgl_sj,2,2);
		$bulan = substr($tgl_sj,5,2);
		$noSJ = $this->db->query("SELECT*FROM invoice_jasa_header WHERE no_invoice LIKE '%/$tahun' AND transaksi='$opsi' ORDER BY no_invoice DESC LIMIT 1");
		if($opsi == "CORRUGATED"){
			($noSJ->num_rows() == 0) ? $no = 0 : $no = substr($noSJ->row()->no_invoice, 3, 6);
			$no_invoice = 'JP/'.str_pad($no+1, 6, "0", STR_PAD_LEFT).'/'.$bulan.'/'.$tahun;
		}
		if($opsi == "LAMINASI"){
			($noSJ->num_rows() == 0) ? $no = 0 : $no = substr($noSJ->row()->no_invoice, 6, 4);
			$no_invoice = 'JP/LM/'.str_pad($no+1, 4, "0", STR_PAD_LEFT).'/'.$bulan.'/'.$tahun;
		}

		($statusInput == 'insert') ? $no_inv = $_POST["no_invoice"] : $no_inv = substr($_POST["no_invoice"], 3, 6);
		if($no_inv == 000000 || $no_inv == '000000' || $no_inv == '' || $no_inv < 0 || strlen("'.$no_inv.'") < 6){
			$data = false; $insert = false; $detail = false; $no_pl_jasa = false;
			$msg = 'NOMER INVOICE TIDAK BOLEH KOSONG!';
		}else if($tgl_invoice == "" || $no_inv == "" || $tgl_jatuh_tempo == "" || $kepada == "" || $alamat == "" || $pilihan_bank == "" || $pilih_transaksi == ""){
			$data = false; $insert = false; $detail = false; $no_pl_jasa = false;
			$msg = 'HARAP LENGKAPI FORM!';
		}else{
			if($statusInput == 'insert'){
				$data = array(
					'tgl_invoice' => $tgl_invoice,
					'tgl_surat_jalan' => $tgl_sj,
					'tgl_jatuh_tempo' => $tgl_jatuh_tempo,
					'transaksi' => $pilih_transaksi,
					'id_hub' => $h_id_hub,
					'no_surat' => $no_surat_jalan,
					'no_invoice' => $no_invoice,
					'kepada_jasa_inv' => $kepada,
					'alamat_jasa_inv' => $alamat,
					'bank' => $pilihan_bank,
				);
				$insert = $this->db->insert('invoice_jasa_header', $data);
				
				if($insert){
					// CORRUGATED
					if($opsi == "CORRUGATED"){
						$isi = $this->db->query("SELECT r.*,p.*,i.*,d.qty AS fix_qty,d.retur_qty AS fix_retur,d.hasil AS fix_hasil,i.kategori AS kate FROM m_rencana_kirim r
						INNER JOIN pl_box p ON r.id_pl_box=p.id AND r.rk_urut=p.no_pl_urut
						INNER JOIN m_produk i ON r.id_produk=i.id_produk
						INNER JOIN m_jasa s ON p.tgl=s.tgl AND p.no_pl_urut=s.urut AND p.id=s.id_pl_box
						INNER JOIN invoice_detail d ON p.no_surat=d.no_surat AND s.no_surat=d.no_surat AND d.id_produk_simcorr=i.id_produk
						INNER JOIN invoice_header h ON d.no_invoice=h.no_invoice
						WHERE p.no_surat='$no_surat_jalan' GROUP BY r.id_pelanggan,r.id_produk,r.rk_kode_po ORDER BY p.no_po,i.nm_produk");
						foreach($isi->result() as $r){
							$this->db->set('id_produk', $r->id_produk);
							$this->db->set('no_surat', $no_surat_jalan);
							$this->db->set('no_invoice', $no_invoice);
							$this->db->set('no_po', $r->no_po);
							$this->db->set('qty_muat', $r->fix_hasil);
							$this->db->set('harga', 0);
							$this->db->set('total', 0);
							$detail = $this->db->insert('invoice_jasa_detail');
						}
						if($detail){
							$this->db->set('no_pl_jasa', 1);
							$this->db->where('no_surat', $no_surat_jalan);
							$no_pl_jasa = $this->db->update('pl_box');
						}
					}
					// LAMINASI
					if($opsi == "LAMINASI"){
						$isi = $this->db->query("SELECT r.*,i.*,t.*,d.* FROM m_rk_laminasi r
						INNER JOIN pl_laminasi p ON r.id_pl_lm=p.id AND r.rk_urut=p.no_pl_urut AND r.rk_no_po=p.no_po
						INNER JOIN m_jasa j ON j.urut=r.rk_urut AND j.id_pl_box=r.id_pl_lm AND j.tgl=r.rk_tgl
						INNER JOIN m_produk_lm i ON r.id_m_produk_lm=i.id_produk_lm
						INNER JOIN trs_po_lm_detail t ON r.rk_no_po=t.no_po_lm AND r.id_m_produk_lm=t.id_m_produk_lm
						INNER JOIN invoice_laminasi_header h ON p.tgl=h.tgl_surat_jalan AND p.no_surat=h.no_surat
						INNER JOIN invoice_laminasi_detail d ON d.no_surat=h.no_surat AND d.no_invoice=h.no_invoice AND d.id_produk_lm=r.id_m_produk_lm
						WHERE p.no_surat='$no_surat_jalan' AND p.no_pl_jasa='0' AND h.acc_owner='Y'
						GROUP BY r.rk_no_po,i.nm_produk_lm,i.ukuran_lm,i.isi_lm,i.jenis_qty_lm");
						foreach($isi->result() as $r){
							if($r->jenis_qty_lm == 'pack'){
								$qty = $r->pack_lm;
								$retur = round($r->retur_qty);
							}else if($r->jenis_qty_lm == 'ikat'){
								$qty = $r->ikat_lm;
								$retur = round($r->retur_qty);
							}else{
								$qty = $r->kg_lm;
								$retur = round($r->retur_qty,2);
							}
							$muat = ($qty * $r->qty_muat) - $retur;
							$this->db->set('id_produk', $r->id_produk_lm);
							$this->db->set('no_surat', $no_surat_jalan);
							$this->db->set('no_invoice', $no_invoice);
							$this->db->set('no_po', $r->no_po_lm);
							$this->db->set('qty_muat', $muat);
							$this->db->set('harga', 0);
							$this->db->set('total', 0);
							$detail = $this->db->insert('invoice_jasa_detail');
						}
						if($detail){
							$this->db->set('no_pl_jasa', 1);
							$this->db->where('no_surat', $no_surat_jalan);
							$no_pl_jasa = $this->db->update('pl_laminasi');
						}
					}
					$msg = 'insert!';
				}
			}else{
				$data = array(
					'tgl_invoice' => $tgl_invoice,
					'tgl_jatuh_tempo' => $tgl_jatuh_tempo,
					// 'attn_lam_inv' => $kepada,
					// 'alamat_lam_inv' => $alamat,
					'bank' => $pilihan_bank,
					'edit_admin' => date('Y-m-d H:i:s'),
				);
				$this->db->where('id', $h_id_header);
				$insert = $this->db->update('invoice_jasa_header', $data);
				$detail = true;
				$no_pl_jasa = true;
				$msg = 'update!';
			}
		}

		return [
			'data' => $data,
			'insert' => $insert,
			'detail' => $detail,
			'no_pl_jasa' => $no_pl_jasa,
			'msg' => $msg,
		];
	}

	function btnVerifInvJasa()
	{
		if($_POST["ket_jasa"] == '' && ($_POST["aksi"] == 'H' || $_POST["aksi"] == 'R')){
			$result = false; $header = false; $detail = false;
		}else{
			if($_POST["aksi"] == 'H' || $_POST["aksi"] == 'N'){
				$status = 'Open';
			}else if($_POST["aksi"] == 'R'){
				$status = 'Reject';
			}else{
				$status = 'Approve';
			}
			if($_POST["aksi"] == 'N'){
				$ket = null;
			}else if($_POST["aksi"] == 'Y' && $_POST["ket_jasa"] == ''){
				$ket = 'OK!';
			}else{
				$ket = $_POST["ket_jasa"];
			}
			$this->db->set('status_inv', $status);
			$this->db->set('acc_owner', $_POST["aksi"]);
			$this->db->set('time_owner', ($_POST["aksi"] == 'N') ? null : date('Y-m-d H:i:s'));
			$this->db->set('ket_owner', $ket);
			$this->db->where('id', $_POST["h_id_header"]);
			$result = $this->db->update('invoice_jasa_header');
			// INSERT INVOICE BELI
			$id = $_POST["h_id_header"];
			if($result && $_POST["aksi"] == 'Y'){
				// GET INVOICE JASA
				$jasa = $this->db->query("SELECT*FROM invoice_jasa_header WHERE id='$id'")->row();
				$tanggal = explode('-', $jasa->tgl_invoice);
				$tahun = $tanggal[0];
				$bulan = $tanggal[1];
				$c_no_inv = $this->m_fungsi->urut_transaksi('INV_BELI_NONPPN');
				$m_no_inv = 'INV/PB/'.$c_no_inv.'/'.$bulan.'/'.$tahun;
				$data_header = array(
					'no_inv_beli' => $m_no_inv,
					'no_inv_maklon' => $jasa->no_invoice,
					'tgl_inv_beli' => $jasa->tgl_invoice,
					'id_hub' => $jasa->id_hub,
					'id_supp' => 1,
					'diskon' => 0,
					'pajak' => 'NONPPN',
					'ket' => '-',
					'acc_owner' => 'N',
				);
				$header = $this->db->insert('invoice_header_beli', $data_header);
				if($header){
					if($jasa->transaksi == "CORRUGATED"){
						$dtl = $this->db->query("SELECT d.*,i.*,h.transaksi FROM invoice_jasa_detail d
						INNER JOIN invoice_jasa_header h ON d.no_surat=h.no_surat AND d.no_invoice=h.no_invoice
						INNER JOIN m_produk i ON d.id_produk=i.id_produk
						WHERE h.id='$id'
						ORDER BY d.no_po,i.nm_produk");
					}
					if($jasa->transaksi == "LAMINASI"){
						$dtl = $this->db->query("SELECT d.*,i.*,h.transaksi FROM invoice_jasa_detail d
						INNER JOIN invoice_jasa_header h ON d.no_surat=h.no_surat AND d.no_invoice=h.no_invoice
						INNER JOIN m_produk_lm i ON d.id_produk=i.id_produk_lm
						WHERE h.id='$id' AND i.jenis_qty_lm!='kg'
						ORDER BY d.no_po,i.nm_produk_lm,i.ukuran_lm,i.isi_lm,i.jenis_qty_lm");
					}
					foreach($dtl->result() as $d){
						$data_detail = array(				
							'no_inv_beli' => $m_no_inv,
							'transaksi' => $d->transaksi.' | '.$d->no_surat.' | '.$d->no_invoice.' | '.$d->id_produk,
							'jns_beban' => '5.04',
							'nominal' => $d->total,
						);
						$detail = $this->db->insert('invoice_detail_beli', $data_detail);
					}
				}else{
					$detail = false;
				}
			}else{
				$header = false; $detail = false;
			}
		}
		return [
			'result' => $result,
			'header' => $header,
			'detail' => $detail,
		];
	}

	function editHargaJasa()
	{
		$id_dtl = $_POST["id_dtl"];
		$harga = $_POST["harga"];
		$total = $_POST["total"];
		if($harga == 0 || $total == 0 || $harga == "" || $total == ""){
			$data = false;
		}else{
			$this->db->set('harga', $harga);
			$this->db->set('total', $total);
			$this->db->where('id', $id_dtl);
			$data = $this->db->update('invoice_jasa_detail');
		}
		return [
			'data' => $data,
		];
	}

	function hapusInvoiceJasa()
	{
		$id = $_POST["id"];
		$data = $this->db->query("SELECT*FROM invoice_jasa_header WHERE id='$id'")->row();
		$this->db->where('no_invoice', $data->no_invoice);
		$header = $this->db->delete('invoice_jasa_header');
		if($header){
			$this->db->where('no_invoice', $data->no_invoice);
			$detail = $this->db->delete('invoice_jasa_detail');
			if($detail){
				$this->db->set('no_pl_jasa', 0);
				$this->db->where('no_surat', $data->no_surat);
				($data->transaksi == "CORRUGATED") ? $pl = 'pl_box' : $pl = 'pl_laminasi';
				$no_pl_jasa = $this->db->update($pl);
			}
		}
		return [
			'data' => $data,
			'header' => $header,
			'detail' => $detail,
			'no_pl_jasa' => $no_pl_jasa,
		];
	}

	//

	function simpanTimbangan_2()
	{
		$thn = date('Y');
		$no_timbangan   = $this->m_fungsi->urut_transaksi('TIMBANGAN').'/TIMB'.'/'.$thn;
		// $rowloop        = $this->input->post('plh_input');
		// for($loop = 0; $loop <= $rowloop+1; $loop++)
		// {
		// 	$data_detail = array(
		// 		'no_timbangan'   => $no_timbangan,
		// 		'id_item'   => $this->input->post('item_po['.$loop.']'),
		// 		'berat_bahan'   => str_replace('.','',$this->input->post('qty['.$loop.']')),
		// 	);
		// 	$result_detail = $this->db->insert('m_jembatan_timbang_d', $data_detail);
		// }

		$status_input = $this->input->post('sts_input');
		if($status_input == 'add')
		{
			$data_header = array(
				'input_t'     	 => $this->input->post('plh_input'),
				'no_timbangan'   => $no_timbangan,
				'id_pelanggan'   => $this->input->post('cust'),
				'keterangan'     => $this->input->post('jns'),
				'nm_penimbang'   => $this->input->post('penimbang'),
				'permintaan'     => $this->input->post('permintaan'),
				'suplier'        => $this->input->post('supplier'),
				'date_masuk'     => $this->input->post('masuk'),
				'alamat'         => $this->input->post('alamat'),
				'date_keluar'    => $this->input->post('keluar'),
				'no_polisi'      => $this->input->post('nopol'),
				'berat_kotor'    => str_replace('.','',$this->input->post('b_kotor')),
				'nm_barang'      => $this->input->post('barang'),
				'berat_truk'     => str_replace('.','',$this->input->post('berat_truk')),
				'nm_sopir'       => $this->input->post('sopir'),
				'berat_bersih'   => str_replace('.','',$this->input->post('berat_bersih')),
				'catatan'        => $this->input->post('cttn'),
				'potongan'       => str_replace('.','',$this->input->post('pot')),
				'urut_t'         => $this->input->post('urut_t'),
				'tgl_t'          => $this->input->post('tgl_t'),
				'pilih_po'       => $this->input->post('pilih_po'),
			);
		
			$result_header = $this->db->insert('m_jembatan_timbang', $data_header);	
				
		}else{

			$data_header = array(
				'input_t'     	 => $this->input->post('plh_input'),
				'no_timbangan'   => $this->input->post('no_timbangan'),
				'id_pelanggan'   => $this->input->post('cust'),
				'keterangan'     => $this->input->post('jns'),
				'nm_penimbang'   => $this->input->post('penimbang'),
				'permintaan'     => $this->input->post('permintaan'),
				'suplier'        => $this->input->post('supplier'),
				'date_masuk'     => $this->input->post('masuk'),
				'alamat'         => $this->input->post('alamat'),
				'date_keluar'    => $this->input->post('keluar'),
				'no_polisi'      => $this->input->post('nopol'),
				'berat_kotor'    => str_replace('.','',$this->input->post('b_kotor')),
				'nm_barang'      => $this->input->post('barang'),
				'berat_truk'     => str_replace('.','',$this->input->post('berat_truk')),
				'nm_sopir'       => $this->input->post('sopir'),
				'berat_bersih'   => str_replace('.','',$this->input->post('berat_bersih')),
				'catatan'        => $this->input->post('cttn'),
				'potongan'       => str_replace('.','',$this->input->post('pot')),
				'urut_t'         => $this->input->post('urut_t'),
				'tgl_t'          => $this->input->post('tgl_t'),
				'pilih_po'       => $this->input->post('pilih_po'),
			);
		
			
			$this->db->where('id_timbangan', $this->input->post('id_timbangan'));
			$result_header = $this->db->update('m_jembatan_timbang', $data_header);		
			
		}
		return $result_header;
	}

	function simpanTimbangan()
	{
		if($_POST["plh_input"] == "" || $_POST["permintaan"] == "" || $_POST["supplier"] == "" || $_POST["alamat"] == "" || $_POST["nopol"] == "" || $_POST["tgl_masuk"] == "" || $_POST["tgl_keluar"] == "" || $_POST["nm_barang"] == "" || $_POST["bb_kotor"] == "" || $_POST["bb_truk"] == "" || $_POST["bb_bersih"] == "" || $_POST["potongan"] == "" || $_POST["catatan"] == "" || $_POST["nm_penimbang"] == "" || $_POST["nm_supir"] == "" || $_POST["keterangan"] == ""){
			$result = false;
			$msg = 'HARAP LENGKAPI FORM!';
		}else{
			$data = [
				'input_t' => $_POST["plh_input"],
				'permintaan' => $_POST["permintaan"],
				'suplier' => $_POST["supplier"],
				'alamat' => $_POST["alamat"],
				'no_polisi' => $_POST["nopol"],
				'date_masuk' => $_POST["tgl_masuk"],
				'date_keluar' => $_POST["tgl_keluar"],
				'nm_barang' => $_POST["nm_barang"],
				'berat_kotor' => $_POST["bb_kotor"],
				'berat_truk' => $_POST["bb_truk"],
				'berat_bersih' => $_POST["bb_bersih"],
				'potongan' => $_POST["potongan"],
				'catatan' => $_POST["catatan"],
				'nm_penimbang' => $_POST["nm_penimbang"],
				'nm_sopir' => $_POST["nm_supir"],
				'keterangan' => $_POST["keterangan"],
				'urut_t' => $_POST["urut"],
				'tgl_t' => $_POST["tgl"],
			];
			if($_POST["opsiInput"] == 'insert'){
				$result = $this->db->insert('m_jembatan_timbang', $data);
				$msg = 'BERHASIL TAMBAH DATA!';
			}else{
				$this->db->where('id_timbangan', $_POST["id_timbangan"]);
				$result = $this->db->update('m_jembatan_timbang', $data);
				$msg = 'BERHASIL EDIT DATA!';
			}
		}
		return [
			'data' => $result,
			'msg' => $msg,
		];
	}

	function deleteTimbangan()
	{
		$this->db->where('id_timbangan', $_POST["id_timbangan"]);
		$data = $this->db->delete('m_jembatan_timbang');
		return [
			'data' => $data,
		];
	}

	//

	function update_invoice()
	{
		$id_inv         = $this->input->post('id_inv');
		$cek_inv        = $this->input->post('cek_inv2');
		$c_no_inv_kd    = $this->input->post('no_inv_kd');
		$c_no_inv       = $this->input->post('no_inv');
		$c_no_inv_tgl   = $this->input->post('no_inv_tgl');

		$type           = $this->input->post('type_po2');
		$pajak          = $this->input->post('pajak2');
		$no_inv_old     = $this->input->post('no_inv_old');

		$m_no_inv       = $c_no_inv_kd.''.$c_no_inv.''.$c_no_inv_tgl;

		$data_header = array(
			'no_invoice'         => $m_no_inv,
			'type'               => $type,
			'cek_inv'    		 => $cek_inv,
			'tgl_invoice'        => $this->input->post('tgl_inv'),
			'tgl_sj'             => $this->input->post('tgl_sj'),
			'pajak'              => $this->input->post('pajak2'),
			'inc_exc'            => $this->input->post('inc_exc'),
			'tgl_jatuh_tempo'    => $this->input->post('tgl_tempo'),
			'id_perusahaan'      => $this->input->post('id_perusahaan'),
			'kepada'             => $this->input->post('kpd'),
			'nm_perusahaan'      => $this->input->post('nm_perusahaan'),
			'alamat_perusahaan'  => $this->input->post('alamat_perusahaan'),
			'bank'  			 => $this->input->post('bank'),
			'acc_owner' 		 => 'N',
			
			// 'status'             => 'Open',
		);

		$result_header = $this->db->update("invoice_header", $data_header,
			array(
				'id' => $id_inv
			)
		);

		$cek_detail   = $this->db->query("SELECT*FROM invoice_header a
		join invoice_detail b on a.no_invoice=b.no_invoice
		where b.no_invoice='$m_no_inv' ")->result();
		foreach ( $cek_detail as $row ) 
		{
			if($row->type=='box' || $row->type=='sheet' )
			{
				// delete stok berjalan HUB
				$cek_po = $this->db->query("SELECT * FROM trs_po a 
				join trs_po_detail b on a.kode_po=b.kode_po 
				join m_produk c on b.id_produk=c.id_produk
				where b.kode_po in ('$row->no_po') and b.id_produk='$row->id_produk_simcorr'")->row();
				
				// delete jurnal
				del_jurnal( $m_no_inv );

				$del_stok    = $this->db->query("DELETE FROM trs_stok_bahanbaku WHERE no_transaksi='$m_no_inv' and id_hub='$cek_po->id_hub' and id_produk='$row->id_produk_simcorr' ");
				
			}
		}

		$tgl_sj           = $this->input->post('tgl_sj');
		$id_perusahaan    = $this->input->post('id_perusahaan');

		$query = $this->db->query("SELECT *FROM invoice_detail where no_invoice='$no_inv_old' ")->result();

		if ($type == 'roll')
		{
			$no = 1;
			foreach ( $query as $row ) 
			{

					$harga_ok        = $this->input->post('hrg['.$no.']');
					$hasil_ok        = $this->input->post('hasil['.$no.']');
					$harga_inc       = $this->input->post('inc['.$no.']');
					$harga_inc1      = str_replace('.','',$harga_inc);

					$seset_ok        = $this->input->post('seset['.$no.']');
					$id_pl_roll      = $this->input->post('id_pl_roll['.$no.']');
					$id_inv_detail   = $this->input->post('id_inv_detail['.$no.']');
					$data = [					
						'no_invoice'   => $m_no_inv,
						'type'         => $type,
						'no_surat'     => $this->input->post('no_surat['.$no.']'),
						'nm_ker'       => $this->input->post('nm_ker['.$no.']'),
						'g_label'      => $this->input->post('g_label['.$no.']'),
						'width'        => $this->input->post('width['.$no.']'),
						'qty'          => $this->input->post('qty['.$no.']'),
						'retur_qty'    => $this->input->post('retur_qty['.$no.']'),
						'id_pl'        => $id_pl_roll,
						'harga'        => str_replace('.','',$harga_ok),
						'include'      => str_replace(',','.',$harga_inc1),
						'weight'       => $this->input->post('weight['.$no.']'),
						'seset'        => str_replace('.','',$seset_ok),
						'hasil'        => str_replace('.','',$hasil_ok),
						'no_po'        => $this->input->post('no_po['.$no.']'),
					];

					$result_rinci = $this->db->update("invoice_detail", $data,
						array(
							'id' => $id_inv_detail
						)
					);

				$no++;
			}
		}else{
			
			$no = 1;
			foreach ( $query as $row ) 
			{
				$harga_ok             = $this->input->post('hrg['.$no.']');
				$hasil_ok             = $this->input->post('hasil['.$no.']');
				
				$harga_inc            = $this->input->post('inc['.$no.']');
				$harga_inc1           = str_replace('.','',$harga_inc);

				$retur_qty_ok         = $this->input->post('retur_qty['.$no.']');
				$id_pl_roll           = $this->input->post('id_pl_roll['.$no.']');
				$id_inv_detail        = $this->input->post('id_inv_detail['.$no.']');
				$no_po                = $this->input->post('no_po['.$no.']');
				$id_produk_simcorr    = $this->input->post('id_produk_simcorr['.$no.']');

				$data = [					
					'no_invoice'           => $m_no_inv,
					'type'                 => $type,
					'no_surat'             => $this->input->post('no_surat['.$no.']'),
					'nm_ker'               => $this->input->post('item['.$no.']'),
					'id_produk_simcorr'    => $id_produk_simcorr,
					'g_label'              => $this->input->post('ukuran['.$no.']'),
					'kualitas'             => $this->input->post('kualitas['.$no.']'),
					'qty'                  => $this->input->post('qty['.$no.']'),
					'retur_qty'            => str_replace('.','',$retur_qty_ok),
					'id_pl'                => $id_pl_roll,
					'harga'                => str_replace('.','',$harga_ok),
					'include'              => str_replace(',','.',$harga_inc1),
					'hasil'                => str_replace('.','',$hasil_ok),
					'no_po'                => $no_po,
				];

				$result_rinci = $this->db->update("invoice_detail", $data,
					array(
						'id' => $id_inv_detail
					)
				);

				// HAPUS STOK
				$cek_po = $this->db->query("SELECT * FROM trs_po a 
				join trs_po_detail b on a.kode_po=b.kode_po 
				join m_produk c on b.id_produk=c.id_produk
				where b.kode_po in ('$no_po') and b.id_produk='$id_produk_simcorr'")->row();
				
				$del_stok    = $this->db->query("DELETE FROM trs_stok_bahanbaku WHERE no_transaksi='$m_no_inv' and id_hub='$cek_po->id_hub' and id_produk='$id_produk_simcorr' ");
				$no++;
			}
		}

		if($result_rinci){
			$query = $this->db->query("SELECT*FROM invoice_header where no_invoice ='$m_no_inv' ")->row();
			return $query->id;
		}else{
			return 0;

		}
	}

	function verif_inv()
	{
		$no_inv       = $this->input->post('no_inv');
		$acc          = $this->input->post('acc');
		$app          = "";
		
		$cek_detail   = $this->db->query("SELECT*,b.no_po as no_po FROM invoice_header a
		join invoice_detail b on a.no_invoice=b.no_invoice
		join trs_po c on b.no_po=c.kode_po
		join m_hub d on c.id_hub=d.id_hub
		where b.no_invoice='$no_inv' ")->result();

		// KHUSUS ADMIN //
		if ($this->session->userdata('level') == "Admin") 
		{
			if($acc=='N')
			{				
				foreach ( $cek_detail as $row ) 
				{
					if($row->type=='box' || $row->type=='sheet' )
					{
						// input stok berjalan HUB
						$cek_po = $this->db->query("SELECT * FROM trs_po a 
						join trs_po_detail b on a.kode_po=b.kode_po 
						join m_produk c on b.id_produk=c.id_produk
						where b.kode_po in ('$row->no_po') and b.id_produk='$row->id_produk_simcorr'")->row();

						// pendapatan tanpa di kurangi retur
						$pendapatan       = ($row->harga*$row->qty);
						$pajak_pendapatan = ($row->harga*$row->qty)*0.5/100;
						
						add_jurnal($row->id_hub,$row->tgl_invoice, $no_inv,'1.01.03','Pendapatan', $pendapatan, 0);
						add_jurnal($row->id_hub,$row->tgl_invoice, $no_inv,'4.01','Pendapatan', 0,$pendapatan);
						// pajak pendapatan
						add_jurnal($row->id_hub,$row->tgl_invoice, $no_inv,'6.37','Pajak Pendapatan', $pajak_pendapatan, 0);
						add_jurnal($row->id_hub,$row->tgl_invoice, $no_inv,'2.01.04','Pajak Pendapatan', 0,$pajak_pendapatan);
						
						
						// pembelian bahan baku		
						$harga_bahan        = 2300;
						$ton_tanpa_retur    = ($row->hasil * $cek_po->berat_bersih);
						$bhn_bk_tanpa_retur = ($ton_tanpa_retur / 0.7);
						$nominal_bahan      = $bhn_bk_tanpa_retur*$harga_bahan;

						// $cek_po = $this->db->query(" hrd : $row->harga,<br> bb : $cek_po->berat_bersih <br> bhn bk  : $bhn_bk_tanpa_retur <br> $nominal_bahan x x")->row();

						add_jurnal($row->id_hub,$row->tgl_invoice, $no_inv,'1.01.05','Penggunaan Bahan Baku',$nominal_bahan, 0);
						add_jurnal($row->id_hub,$row->tgl_invoice, $no_inv,'1.01.06','Penggunaan Bahan Baku',0, $nominal_bahan);

						add_jurnal($row->id_hub,$row->tgl_invoice, $no_inv,'5.01','Pembelian Bahan Baku', $nominal_bahan, 0);
						add_jurnal($row->id_hub,$row->tgl_invoice, $no_inv,'1.01.05','Pembelian Bahan Baku', 0,$nominal_bahan);
						
						
						
						if($row->retur_qty > 0)
						{
							// retur pendapatan
							$retur            = ($row->harga*$row->retur_qty);
							$pajak_retur      = ($row->harga*$row->retur_qty)*0.5/100;
							
							add_jurnal($row->id_hub,$row->tgl_invoice, $no_inv,'4.03','Retur Pendapatan', $retur, 0);
							add_jurnal($row->id_hub,$row->tgl_invoice, $no_inv,'1.01.03','Retur Pendapatan', 0,$retur);
							// pajak retur
							add_jurnal($row->id_hub,$row->tgl_invoice, $no_inv,'2.01.04','Pajak Retur Pendapatan', $pajak_retur, 0);
							add_jurnal($row->id_hub,$row->tgl_invoice, $no_inv,'6.37','Pajak Retur Pendapatan', 0,$pajak_retur);

							// retur
							$nominal_retur_bahan = ($row->retur_qty*$harga_bahan);

							// retur jadi bahan baku
							add_jurnal($row->id_hub,$row->tgl_invoice, $no_inv,'5.01','Retur Bahan Baku', $nominal_retur_bahan, 0);
							add_jurnal($row->id_hub,$row->tgl_invoice, $no_inv,'1.01.05','Retur Bahan Baku', 0,$nominal_retur_bahan);
						}
						
						// stok bahan setelah di kurangi retur
						$ton            = ($row->hasil * $cek_po->berat_bersih);
						$bhn_bk         = ($ton / 0.7);

						stok_bahanbaku($no_inv, $cek_po->id_hub, $row->tgl_invoice, 'HUB', 0, $bhn_bk, 'KELUAR DENGAN INVs', 'KELUAR', $row->id_produk_simcorr);
						
						
					}
				}
				$this->db->set("acc_admin", 'Y');
				$this->db->set("acc_owner", 'Y');
			}else{
				
				foreach ( $cek_detail as $row ) 
				{
					if($row->type=='box' || $row->type=='sheet' )
					{
						// input stok berjalan HUB
						$cek_po = $this->db->query("SELECT * FROM trs_po a 
						join trs_po_detail b on a.kode_po=b.kode_po 
						join m_produk c on b.id_produk=c.id_produk
						where b.kode_po in ('$row->no_po') and b.id_produk='$row->id_produk_simcorr'")->row();
						
						// delete jurnal pendapatan
						del_jurnal( $no_inv );

						$del_stok    = $this->db->query("DELETE FROM trs_stok_bahanbaku WHERE no_transaksi='$no_inv' and id_hub='$cek_po->id_hub' and id_produk='$row->id_produk_simcorr' ");
						
					}
				}
				$this->db->set("acc_admin", 'Y');
				$this->db->set("acc_owner", 'N');
			}
			
			$this->db->where("no_invoice",$no_inv);
			$valid = $this->db->update("invoice_header");

		} else if ($this->session->userdata('level') == "Keuangan1" && $this->session->userdata('username') == "karina") 
		{
			if($acc=='N')
			{
				$this->db->set("acc_admin", 'Y');
			}else{
				$this->db->set("acc_admin", 'N');
			}
			
			$this->db->where("no_invoice",$no_inv);
			$valid = $this->db->update("invoice_header");

		} else if ($this->session->userdata('level') == "Keuangan1" && $this->session->userdata('username') == "bumagda") 
		{
			if($acc=='N')
			{
				foreach ( $cek_detail as $row ) 
				{
					if($row->type=='box' || $row->type=='sheet' )
					{
						// input stok berjalan HUB
						$cek_po = $this->db->query("SELECT * FROM trs_po a 
						join trs_po_detail b on a.kode_po=b.kode_po 
						join m_produk c on b.id_produk=c.id_produk
						where b.kode_po in ('$row->no_po') and b.id_produk='$row->id_produk_simcorr'")->row();

						// pendapatan tanpa di kurangi retur
						$pendapatan       = ($row->harga*$row->qty);
						$pajak_pendapatan = ($row->harga*$row->qty)*0.5/100;
						
						add_jurnal($row->id_hub,$row->tgl_invoice, $no_inv,'1.01.03','Pendapatan', $pendapatan, 0);
						add_jurnal($row->id_hub,$row->tgl_invoice, $no_inv,'4.01','Pendapatan', 0,$pendapatan);
						// pajak pendapatan
						add_jurnal($row->id_hub,$row->tgl_invoice, $no_inv,'6.37','Pajak Pendapatan', $pajak_pendapatan, 0);
						add_jurnal($row->id_hub,$row->tgl_invoice, $no_inv,'2.01.04','Pajak Pendapatan', 0,$pajak_pendapatan);
						
						
						// pembelian bahan baku		
						$harga_bahan        = 2300;
						$ton_tanpa_retur    = ($row->hasil * $cek_po->berat_bersih);
						$bhn_bk_tanpa_retur = ($ton_tanpa_retur / 0.7);
						$nominal_bahan      = $bhn_bk_tanpa_retur*$harga_bahan;

						add_jurnal($row->id_hub,$row->tgl_invoice, $no_inv,'1.01.05','Penggunaan Bahan Baku',$nominal_bahan, 0);
						add_jurnal($row->id_hub,$row->tgl_invoice, $no_inv,'1.01.06','Penggunaan Bahan Baku',0, $nominal_bahan);

						add_jurnal($row->id_hub,$row->tgl_invoice, $no_inv,'5.01','Pembelian Bahan Baku', $nominal_bahan, 0);
						add_jurnal($row->id_hub,$row->tgl_invoice, $no_inv,'1.01.05','Pembelian Bahan Baku', 0,$nominal_bahan);

						if($row->retur_qty > 0)
						{
							// retur pendapatan
							$retur            = ($row->harga*$row->retur_qty);
							$pajak_retur      = ($row->harga*$row->retur_qty)*0.5/100;
							
							add_jurnal($row->id_hub,$row->tgl_invoice, $no_inv,'4.03','Retur Pendapatan', $retur, 0);
							add_jurnal($row->id_hub,$row->tgl_invoice, $no_inv,'1.01.03','Retur Pendapatan', 0,$retur);
							// pajak retur
							add_jurnal($row->id_hub,$row->tgl_invoice, $no_inv,'2.01.04','Pajak Retur Pendapatan', $pajak_retur, 0);
							add_jurnal($row->id_hub,$row->tgl_invoice, $no_inv,'6.37','Pajak Retur Pendapatan', 0,$pajak_retur);

							// retur
							$nominal_retur_bahan = ($row->retur_qty*$harga_bahan);

							// retur jadi bahan baku
							add_jurnal($row->id_hub,$row->tgl_invoice, $no_inv,'5.01','Retur Bahan Baku', $nominal_retur_bahan, 0);
							add_jurnal($row->id_hub,$row->tgl_invoice, $no_inv,'1.01.05','Retur Bahan Baku', 0,$nominal_retur_bahan);
						}
						
						// stok bahan setelah di kurangi retur
						$ton            = ($row->hasil * $cek_po->berat_bersih);
						$bhn_bk         = ($ton / 0.7);

						stok_bahanbaku($no_inv, $cek_po->id_hub, $row->tgl_invoice, 'HUB', 0, $bhn_bk, 'KELUAR DENGAN INV', 'KELUAR', $row->id_produk_simcorr);
						
					}
				}

				$this->db->set("acc_owner", 'Y');
			}else{

				foreach ( $cek_detail as $row ) 
				{
					if($row->type=='box' || $row->type=='sheet' )
					{
						// input stok berjalan HUB
						$cek_po = $this->db->query("SELECT * FROM trs_po a 
						join trs_po_detail b on a.kode_po=b.kode_po 
						join m_produk c on b.id_produk=c.id_produk
						where b.kode_po in ('$row->no_po') and b.id_produk='$row->id_produk_simcorr'")->row();
						
						// delete jurnal
						del_jurnal( $no_inv );

						$del_stok    = $this->db->query("DELETE FROM trs_stok_bahanbaku WHERE no_transaksi='$no_inv' and id_hub='$cek_po->id_hub' and id_produk='$row->id_produk_simcorr' ");
						
					}
				}
				
				$this->db->set("acc_owner", 'N');
			}
			
			$this->db->where("no_invoice",$no_inv);
			$valid = $this->db->update("invoice_header");

		} else {
			
			$valid = false;

		}

		return $valid;
	}
	

	function batal_inv()
	{
		$id       = $this->input->post('id');
		$app      = "";

		// KHUSUS ADMIN //
		if ($this->session->userdata('level') == "Admin") 
		{

			$this->db->set("acc_admin", 'N');
			$this->db->set("acc_owner", 'N');
			$this->db->where("no_invoice",$id);
			$valid = $this->db->update("invoice_header");

		} else if ($this->session->userdata('level') == "Keuangan1" && $this->session->userdata('username') == "karina") 
		{
			$this->db->set("acc_admin", 'N');
			$this->db->where("no_invoice",$id);
			$valid = $this->db->update("invoice_header");

		} else {
	
			$this->db->set("acc_owner", 'N');
			$this->db->where("no_invoice",$id);
			$valid = $this->db->update("invoice_header");

		}

		return $valid;
	}

	function save_stok_bb()
	{
		$sts_input    = $this->input->post('sts_input');
		$thn          = date('Y');

		if($sts_input=='edit')
		{
			$no_stokbb   = $this->input->post('no_stok');
			$rowloop     = $this->input->post('bucket');

			$del_detail  = $this->db->query("DELETE FROM trs_d_stok_bb WHERE no_stok='$no_stokbb' ");

			// delete jurnal & invoice
			$cek_inv = $this->db->query("SELECT*from invoice_bhn where no_stok='$no_stokbb' and no_inv_bhn in (select no_transaksi from jurnal_d)");
			if($cek_inv->num_rows() >0 )
			{
				foreach ($cek_inv->result() as $row_cek)
				{
					del_jurnal( $row_cek->no_inv_bhn );	

					$result = $this->m_master->query("DELETE FROM invoice_bhn WHERE no_stok = '$no_stokbb' and no_inv_bhn='$row_cek->no_inv_bhn' ");
				}
				
			}else{
				$result = $this->m_master->query("DELETE FROM invoice_bhn WHERE no_stok = '$no_stokbb' ");
			}

			if($del_detail)
			{
				for($loop = 0; $loop <= $rowloop; $loop++)
				{
					// pecah stok
					$data_detail = array(				
						'no_stok'       => $no_stokbb,
						'id_hub'        => $this->input->post('id_hub['.$loop.']'),
						'id_po_bhn'     => $this->input->post('id_po_bhn['.$loop.']'),
						'no_po_bhn'     => $this->input->post('no_po['.$loop.']'),
						'tonase_po'     => str_replace('.','',$this->input->post('ton['.$loop.']')),
						'datang_bhn_bk' => str_replace('.','',$this->input->post('datang['.$loop.']')),
					);
					$result_detail = $this->db->insert('trs_d_stok_bb', $data_detail);


					$id_hub_       = $this->input->post('id_hub['.$loop.']');
					$del_detail    = $this->db->query("DELETE FROM trs_stok_bahanbaku WHERE no_transaksi='$no_stokbb' and id_hub='$id_hub_' ");

					stok_bahanbaku($no_stokbb, $this->input->post('id_hub['.$loop.']'), $this->input->post('tgl_stok'), 'HUB', str_replace('.','',$this->input->post('datang['.$loop.']')), 0, 'MASUK DENGAN PO', 'MASUK');

				}

			}			

			$tonase_ppi = str_replace('.','',$this->input->post('tonase_ppi')) ;

			if($result_detail)
			{
				$data_header = array(
					'no_stok'         => $no_stokbb,
					'tgl_stok'        => $this->input->post('tgl_stok'),
					'id_timbangan'    => $this->input->post('id_timb'),
					'no_timbangan'    => $this->input->post('no_timb'),
					'total_timb'      => str_replace('.','',$this->input->post('jum_timb')),
					'muatan_ppi'      => str_replace('.','',$this->input->post('muat_ppi')),
					'tonase_ppi'      => $tonase_ppi,
					'total_item'      => str_replace('.','',$this->input->post('total_bb_item')),
					'sisa_stok'      => str_replace('.','',$this->input->post('sisa_timb')),

				);
			
				$this->db->where('id_stok', $this->input->post('id_stok_h'));
				$result_header = $this->db->update('trs_h_stok_bb', $data_header);

				
					// input stok berjalan PPI
				if($tonase_ppi>0)
				{
					$data_stok_berjalan = array(				
						'no_transaksi'    => $no_stokbb,
						'id_hub'          => null,
						'tgl_input'       => $this->input->post('tgl_stok'),
						'jam_input'       => date("H:i:s"),
						'jenis'           => 'PPI',
						'masuk'           => $tonase_ppi,
						'keluar'          => 0,
						'ket'             => 'MASUK DENGAN PO',
						'status'          => 'MASUK',
					);
					// $result_stok_berjalan = $this->db->insert('trs_stok_bahanbaku', $data_stok_berjalan);

					$this->db->where('no_transaksi', $no_stokbb);
					$this->db->where('jenis', 'PPI');
					$this->db->where('tgl_input', $this->input->post('tgl_stok'));
					$result_stok_berjalan = $this->db->update('trs_stok_bahanbaku', $data_stok_berjalan);
				
				}
				// input invoice bahan
				inv_bahan($no_stokbb,'edit'); 
			}
		}else{
			$no_stokbb   = $this->m_fungsi->urut_transaksi('STOK_BB').'/'.'STOK/'.$thn;
			$tonase_ppi  = str_replace('.','',$this->input->post('tonase_ppi')) ;

			$rowloop     = $this->input->post('bucket');
			for($loop = 0; $loop <= $rowloop; $loop++)
			{
				$data_detail = array(				
					'no_stok'       => $no_stokbb,
					'id_hub'        => $this->input->post('id_hub['.$loop.']'),
					'id_po_bhn'     => $this->input->post('id_po_bhn['.$loop.']'),
					'no_po_bhn'     => $this->input->post('no_po['.$loop.']'),
					'tonase_po'     => str_replace('.','',$this->input->post('ton['.$loop.']')),
					'datang_bhn_bk' => str_replace('.','',$this->input->post('datang['.$loop.']')),
				);
				$result_detail = $this->db->insert('trs_d_stok_bb', $data_detail);

				// input stok berjalan

				stok_bahanbaku($no_stokbb, $this->input->post('id_hub['.$loop.']'), $this->input->post('tgl_stok'), 'HUB', str_replace('.','',$this->input->post('datang['.$loop.']')), 0, 'MASUK DENGAN PO', 'MASUK');
			}

			if($result_detail)
			{
				$data_header = array(
					'no_stok'         => $no_stokbb,
					'tgl_stok'        => $this->input->post('tgl_stok'),
					'id_timbangan'    => $this->input->post('id_timb'),
					'no_timbangan'    => $this->input->post('no_timb'),
					'total_timb'      => str_replace('.','',$this->input->post('jum_timb')),
					'muatan_ppi'      => str_replace('.','',$this->input->post('muat_ppi')),
					'tonase_ppi'      => str_replace('.','',$this->input->post('tonase_ppi')),
					'total_item'      => str_replace('.','',$this->input->post('total_bb_item')),
					'sisa_stok'      => str_replace('.','',$this->input->post('sisa_timb')),

				);
			
				$result_header = $this->db->insert('trs_h_stok_bb', $data_header);
			}

			// input stok berjalan PPI
			if($tonase_ppi>0)
			{

				stok_bahanbaku($no_stokbb, NULL, $this->input->post('tgl_stok'), 'PPI', $tonase_ppi, 0, 'MASUK DENGAN PO', 'MASUK');
			
			}
			// input invoice bahan
			inv_bahan($no_stokbb,'add');
				
		}
		
		return $result_header;
			
	}

	function save_stok_ppi()
	{
		$sts_input    = $this->input->post('sts_input');
		$thn          = date('Y');

		if($sts_input=='edit')
		{
			$no_stok_ppi   = $this->input->post('no_stok_ppi');
			$id_stok_ppi   = $this->input->post('id_stok_ppi');
			$jam_stok      = $this->input->post('jam_stok');
			// delete stok sebelumnya
			$del_detail    = $this->db->query("DELETE FROM trs_stok_ppi WHERE no_stok_ppi='$no_stok_ppi' ");

		}else{
			$no_stok_ppi   = $this->m_fungsi->urut_transaksi('STOK_BB_PPI').'/'.'STOK_PPI/'.$thn;			
			$jam_stok      = date('H:i:s');

		}

		for($loop = 1; $loop <= 8; $loop++)
		{
			$data_detail = array(				
				'no_stok_ppi'   => $no_stok_ppi,
				'tgl_stok'      => $this->input->post('tgl_stok'),
				'ket_header'    => $this->input->post('ket_header'),
				'jam_stok'      => $jam_stok,
				'ket'           => $this->input->post('ket'.$loop),
				'tonase_masuk'  => str_replace('.','',$this->input->post('masuk'.$loop)),
				'tonase_keluar' => str_replace('.','',$this->input->post('keluar'.$loop)),
				'status' 		=> 'Open',
			);
			$result_detail = $this->db->insert('trs_stok_ppi', $data_detail);

			// input stok berjalan PPI

			// stok_bahanbaku($no_stokbb, NULL, $this->input->post('tgl_stok'), 'PPI', $tonase_ppi, 0, 'MASUK DENGAN PO', 'MASUK');
		}
		
		return $result_detail;
			
	}
	

}
