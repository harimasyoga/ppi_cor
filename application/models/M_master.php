<?php
class M_master extends CI_Model{
 	
 	function __construct(){
        parent::__construct();
        
        date_default_timezone_set('Asia/Jakarta');
        $this->username = $this->session->userdata('username');
        
    }

    public function upload($file,$nama){
        // $file = 'foto';
        // unlink('../assets/images/member/'.$nama);
        $config['upload_path'] = './assets/gambar/produk/';
        $config['allowed_types'] = 'jpg|png|jpeg';
        // $config['max_size'] = '20480';
        // $config['remove_space'] = TRUE;
        $config['file_name'] = $nama;
    
        $this->load->library('upload', $config); // Load konfigurasi uploadnya
        if($this->upload->do_upload($file)){ // Lakukan upload dan Cek jika proses upload berhasil
            // Jika berhasil :
            $return = array('result' => 'success', 'file' => $this->upload->data(), 'error' => '');
            return $return;
        }else{
            // Jika gagal :
            $return = array('result' => 'failed', 'file' => '', 'error' => $this->upload->display_errors());
            return $return;
        }
    }

    public function upload2($file,$nama){
        // $file = 'foto';
        // unlink('../assets/images/member/'.$nama);
        $config['upload_path'] = './assets/gambar/';
        $config['allowed_types'] = 'jpg|png|jpeg';
        // $config['max_size'] = '20480';
        // $config['remove_space'] = TRUE;
        $config['file_name'] = $nama;
    
        $this->load->library('upload', $config); // Load konfigurasi uploadnya
        if($this->upload->do_upload($file)){ // Lakukan upload dan Cek jika proses upload berhasil
            // Jika berhasil :
            $return = array('result' => 'success', 'file' => $this->upload->data(), 'error' => '');
            return $return;
        }else{
            // Jika gagal :
            $return = array('result' => 'failed', 'file' => '', 'error' => $this->upload->display_errors());
            return $return;
        }
    }
   
    function get_data($table){
        $query = "SELECT * FROM $table";
        return $this->db->query($query);
    }

    function get_count($table){
        $query = "SELECT count(*) as jumlah FROM $table";
        return $this->db->query($query);
    }



    function get_data_one($table,$kolom,$id){
        
        $query = "SELECT * FROM $table WHERE $kolom='$id'";
        return $this->db->query($query);
    }


    function query($query1){
        
        $query = $query1;
        return $this->db->query($query);
    }


    function get_data_max($table,$kolom){
        $query = "SELECT IFNULL(LPAD(MAX(RIGHT($kolom,4))+1,4,0),'0001')AS nomor FROM $table";
        return $this->db->query($query)->row("nomor");
    }

    function delete($tabel,$kolom,$id){
        
        $query = "DELETE FROM $tabel WHERE $kolom = '$id' ";
        $result =  $this->db->query($query);
        return $result;
    }
	
    
    function m_pelanggan($table,$status){
		$id = $this->input->post('no_pelanggan');

        $data = array(
                'id_pelanggan'  => $id,
                'nm_pelanggan'  => $this->input->post('nm_pelanggan'),
                'alamat'  => $this->input->post('alamat'),
                'no_telp'  => $this->input->post('no_telp'),
                'alamat_kirim'  => $this->input->post('alamat_kirim'),
                'lokasi'  => $this->input->post('lokasi'),
                'kota'  => $this->input->post('kota'),
                'fax'  => $this->input->post('fax'),
                'top'  => $this->input->post('top1')
            );

        if ($status == 'insert') {
            $this->db->set("add_user", $this->username);
            $result= $this->db->insert($table,$data);
        }else{
            $this->db->set("edit_user", $this->username);
            $this->db->set("edit_time", date('Y-m-d H:i:s'));
            $result= $this->db->update($table,$data,array('id_pelanggan' => $id));
        }
		
        return $result;
    }
    
    
    function tb_user($table,$status){
        
        
        $id = $this->input->post('username');

   
        $data = array(
                'username'  => $id,
                'nm_user'  => $this->input->post('nm_user'),
                'password'  => base64_encode($this->input->post('password')),
                'level'  => $this->input->post('level'),
            );

        if ($status == 'insert') {
             $cek = $this->db->query("
                    SELECT * FROM tb_user WHERE username = '$id'
                ")->num_rows();

            if ($cek > 0) {
                return false;
            }

            $result= $this->db->insert($table,$data);
        }else{
            $result= $this->db->update($table,$data,array('username' => $id));
        }
        

        return $result;
    }
    
    function m_produk($table,$status){
        $id = $this->input->post('id');
        $kode_mc = $this->input->post('kode_mc');
        $kode_mc_lama = $this->input->post('kode_mc_lama');
        
        $cek = $this->db->query("SELECT Kode_mc FROM m_produk WHERE Kode_mc = '".$kode_mc."' ")->num_rows();

        if ($status == 'insert') {
            if ($cek > 0 ) {
                return false;
            }
        }else{
            if (($kode_mc != $kode_mc_lama) and $cek > 0) {
                return false;
            }
        }

        $data = array(
                'kode_mc'  => $kode_mc,
                'nm_produk'  => $this->input->post('nm_produk'),
                'no_customer' => $this->input->post('no_customer'),
                'customer' => $this->input->post('customer'),
                'ukuran' => $this->input->post('ukuran'),
                'ukuran_sheet' => $this->input->post('ukuran_sheet'),
                'ukuran_sheet_p' => $this->input->post('ukuran_sheet_p'),
                'ukuran_sheet_l' => $this->input->post('ukuran_sheet_l'),
                'sambungan' => $this->input->post('sambungan'),
                'tipe' => $this->input->post('tipe'),
                'material' => $this->input->post('material'),
                'wall' => $this->input->post('wall'),
                'l_panjang' => $this->input->post('l_panjang'),
                'l_lebar' => $this->input->post('l_lebar'),
                'l_tinggi' => $this->input->post('l_tinggi'),
                'creasing' => $this->input->post('creasing'),
                'creasing2' => $this->input->post('creasing2'),
                'creasing3' => $this->input->post('creasing3'),
                'flute' => $this->input->post('flute'),
                'berat_bersih' => $this->input->post('berat_bersih'),
                'luas_bersih' => $this->input->post('luas_bersih'),
                'kualitas' => $this->input->post('kualitas'),
                'warna' => $this->input->post('warna'),
                'no_design' => $this->input->post('no_design'),
                'design' => $this->input->post('design'),
                'tipe_box' => $this->input->post('tipe_box'),
                'jenis_produk' => $this->input->post('jenis_produk'),
                'kategori' => $this->input->post('kategori'),
                'COA' => $this->input->post('COA'),
                'jml_ikat' => $this->input->post('jml_ikat'),
                'jml_palet' => $this->input->post('jml_palet'),
                'jml_paku' => $this->input->post('jml_paku'),
                'no_pisau' => $this->input->post('no_pisau'),
                'no_karet' => $this->input->post('no_karet'),
                'toleransi_kirim' => $this->input->post('toleransi_kirim'),
                'spesial_req' => $this->input->post('spesial_req')
            );

        if ($status == 'insert') {
            $this->db->set("add_user", $this->username);
            $result= $this->db->insert($table,$data);
        }else{
            $this->db->set("edit_user", $this->username);
            $this->db->set("edit_time", date('Y-m-d H:i:s'));
            $result= $this->db->update($table,$data,array('id' => $id));
        }

        return $result;
    }

    function m_setting($table,$status){
        
       

        $data = array(
            'nm_aplikasi'  => $this->input->post('nm_aplikasi'),
            'singkatan'  => $this->input->post('singkatan'),
            'nm_toko'  => $this->input->post('nm_toko'),
            'alamat'  => $this->input->post('alamat'),
            'no_telp'  => $this->input->post('no_telp'),
            'diskon_member'  => $this->input->post('diskon_member')
        );

   
        $upload = $this->m_master->upload2('logo','logo');

        if ($upload['result'] == 'success') {
            $this->db->set("logo", $upload['file']['file_name'] );
        }
        $result= $this->db->update($table,$data);
        
        return $result;
    }

    function update_status($status,$id,$table,$field){
        if ($status == '1') {
            $ubah = '0';
        }else{
            $ubah = '1';
        }
        $this->db->set("status", $ubah);
        $this->db->where($field, $id);

        return $this->db->update($table);

    }


    function  get_romawi($bln){
		switch  ($bln){
			case  1:
			return  "I";
			break;
			case  2:
			return  "II";
			break;
			case  3:
			return  "III";
			break;
			case  4:
			return  "IV";
			break;
			case  5:
			return  "V";
			break;
			case  6:
			return  "VI";
			break;
			case  7:
			return  "VII";
			break;
			case  8:
			return  "VIII";
			break;
			case  9:
			return  "IX";
			break;
			case  10:
			return  "X";
			break;
			case  11:
			return  "XI";
			break;
			case  12:
			return  "XII";
			break;
		}
    }

}

?>
