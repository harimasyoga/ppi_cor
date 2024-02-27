<?php
    function cek_subs_bcf($kualitas)
    {	
        $CI =& get_instance();	  
        $substance = $CI->db->query("SELECT * FROM m_p11 where '$kualitas'=concat(substance1,'/',substance2,'/',substance3,'/',substance4,'/',substance5) ")->row();
        return $substance->BCF;
    } 

    function cek_subs_flute($kualitas,$flute)
    {	
        $CI =& get_instance();	  
        $substance = $CI->db->query("SELECT * FROM m_p11 where '$kualitas'=concat(substance1,'/',substance2,'/',substance5) ")->row();
        return $substance->$flute;
    } 
    
    function history_tr($menu, $sub_menu, $tindakan, $no_transaksi, $ket)
    {	
        // CONTOH PENGGUNAAN 
        // history_tr('PO', 'TAMBAH_DATA', 'ADD', 'PO/2024/I/0703')
        $CI =& get_instance();	  

        $data = array(
            'menu'            => $menu,
            'tgl_transaksi'   => date('Y-m-d H:i:s'),
            'sub_menu'        => $sub_menu,
            'tindakan'        => $tindakan,
            'no_transaksi'    => $no_transaksi,
            'user'            => $CI->session->userdata('nm_user'),
            'ket'             => $ket,
        );
        
        $result= $CI->db->insert('m_history_transaksi',$data);
        return $result;
    } 
?>