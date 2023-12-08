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

	function save_invoice()
	{
		$cek_inv        = $this->input->post('cek_inv');
		$c_no_inv_tgl   = $this->input->post('no_inv_tgl');

		$type           = $this->input->post('type_po');
		$pajak          = $this->input->post('pajak');

		($type=='roll')? $type_ok=$type : $type_ok='SHEET_BOX';
		
		($pajak=='nonppn')? $pajak_ok='non' : $pajak_ok='ppn';
		$c_no_inv_kd   = $this->input->post('no_inv_kd');

		if($cek_inv=='revisi')
		{
			$c_no_inv    = $this->input->post('no_inv');
			$m_no_inv    = $c_no_inv_kd.''.$c_no_inv.''.$c_no_inv_tgl;
		}else{
			$c_no_inv    = $this->m_fungsi->tampil_no_urut($type_ok.'_'.$pajak_ok);
			$m_no_inv    = $c_no_inv_kd.''.$c_no_inv.''.$c_no_inv_tgl;
		}

		$data_header = array(
			'no_invoice'         => $m_no_inv,
			'type'               => $this->input->post('type_po'),
			'tgl_invoice'        => $this->input->post('tgl_inv'),
			'tgl_sj'             => $this->input->post('tgl_sj'),
			'pajak'              => $this->input->post('pajak'),
			'tgl_jatuh_tempo'    => $this->input->post('tgl_tempo'),
			'id_perusahaan'      => $this->input->post('id_perusahaan'),
			'kepada'             => $this->input->post('kpd'),
			'nm_perusahaan'      => $this->input->post('nm_perusahaan'),
			'alamat_perusahaan'  => $this->input->post('alamat_perusahaan'),
			'status'             => 'Open',
		);
	
		$result_header = $this->db->insert('invoice_header', $data_header);

		$db2              = $this->load->database('database_simroll', TRUE);
		$tgl_sj           = $this->input->post('tgl_sj');
		$id_perusahaan    = $this->input->post('id_perusahaan');

		$query = $db2->query("SELECT b.nm_perusahaan,a.id_pl,b.id,a.nm_ker,a.g_label,a.width,COUNT(a.roll) AS qty,SUM(weight) AS weight,b.no_po,b.no_surat,b.no_pkb 
		FROM m_timbangan a 
		INNER JOIN pl b ON a.id_pl = b.id 
		WHERE b.tgl='$tgl_sj' AND b.id_perusahaan='$id_perusahaan'
		GROUP BY b.no_po,a.nm_ker,a.g_label,a.width 
		ORDER BY a.g_label,b.no_surat,b.no_po,a.nm_ker DESC,a.g_label,a.width")->result();

		$no = 1;
		foreach ( $query as $row ) {

			$cek = $this->input->post('aksi['.$no.']');
			if($cek == 1)
			{
				$harga_ok   = $this->input->post('hrg['.$no.']');
				$hasil_ok   = $this->input->post('hasil['.$no.']');
				$id_pl_roll = $this->input->post('id_pl_roll['.$no.']');
				$data = [					
					'no_invoice'   => $m_no_inv,
					'no_surat'     => $this->input->post('no_surat['.$no.']'),
					'nm_ker'       => $this->input->post('nm_ker['.$no.']'),
					'g_label'      => $this->input->post('g_label['.$no.']'),
					'width'        => $this->input->post('width['.$no.']'),
					'qty'          => $this->input->post('qty['.$no.']'),
					'retur_qty'    => $this->input->post('retur_qty['.$no.']'),
					'id_pl'        => $id_pl_roll,
					'harga'        => str_replace('.','',$harga_ok),
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

		if($result_rinci){
			$query = $this->db->query("SELECT*FROM invoice_header where no_invoice ='$m_no_inv' ")->row();
			return $query->id;
		}else{
			return 0;

		}
			
	}

}
