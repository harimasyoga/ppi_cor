<?php
    
    function load_rek($field='', $kd='')
    {
        $CI       = & get_instance();
        $result_jurnal = $CI->db->query("SELECT*FROM(
            select kd_akun as kd,nm_akun as nm,jenis,dk from m_kode_akun
            union all
            select concat(kd_akun,'.',kd_kelompok) as kd,nm_kelompok as nm,jenis,dk from m_kode_kelompok
            union all
            select concat(kd_akun,'.',kd_kelompok,'.',kd_jenis) as kd,nm_jenis as nm,jenis,dk from m_kode_jenis
            union all
            select concat(kd_akun,'.',kd_kelompok,'.',kd_jenis,'.',kd_rinci) as kd,nm_rinci as nm,jenis,dk from m_kode_rinci
            )p
            order by kd");
        return $result_jurnal;
    } 
   
    function cari_data_rek($field='', $kd='')
    {
        $CI       = & get_instance();
        $result_jurnal = $CI->db->query("SELECT*FROM(
            select kd_akun as kd,nm_akun as nm,jenis,dk from m_kode_akun
            union all
            select concat(kd_akun,'.',kd_kelompok) as kd,nm_kelompok as nm,jenis,dk from m_kode_kelompok
            union all
            select concat(kd_akun,'.',kd_kelompok,'.',kd_jenis) as kd,nm_jenis as nm,jenis,dk from m_kode_jenis
            union all
            select concat(kd_akun,'.',kd_kelompok,'.',kd_jenis,'.',kd_rinci) as kd,nm_rinci as nm,jenis,dk from m_kode_rinci
            )p
            where p.$field like '%$kd%'
            order by kd");
        return $result_jurnal;
    } 
    
    function cari_rek($kd='')
    {
        $CI       = & get_instance();
        $result_jurnal = $CI->db->query("SELECT*FROM(
            select kd_akun as kd,nm_akun as nm,jenis,dk from m_kode_akun
            union all
            select concat(kd_akun,'.',kd_kelompok) as kd,nm_kelompok as nm,jenis,dk from m_kode_kelompok
            union all
            select concat(kd_akun,'.',kd_kelompok,'.',kd_jenis) as kd,nm_jenis as nm,jenis,dk from m_kode_jenis
            union all
            select concat(kd_akun,'.',kd_kelompok,'.',kd_jenis,'.',kd_rinci) as kd,nm_rinci as nm,jenis,dk from m_kode_rinci
            )p
            where p.kd='$kd'
            order by kd");
        return $result_jurnal->row()->nm;
    } 
   
    function add_jurnal($id_hub,$tgl_transaksi='', $no_transaksi='',$kode_rek='',$ket='' ,$debit=0, $kredit=0)
    {
        $CI       = & get_instance();
        $thn      = date('Y');
        $month    = date('m');

        $data_jurnal    = array(
            'tgl_transaksi'   => $tgl_transaksi,
            'tgl_input'       => date("Y:m:d"),
            'jam_input'       => date("H:i:s"),
            'no_voucher'      => $CI->m_fungsi->urut_transaksi('VOUCHER').'/JURNAL'.'/'.$month.'/'.$thn,
            'no_transaksi'    => $no_transaksi,
            'kode_rek'        => $kode_rek,
            'ket'             => $ket,
            'debet'           => $debit,
            'kredit'          => $kredit,
            'id_hub'          => $id_hub,
        );
        $result_jurnal = $CI->db->insert('jurnal_d', $data_jurnal);
    } 
    
    function del_jurnal( $no_transaksi='',$kode_rek='')
    {
        $CI       = & get_instance();
        if($kode_rek=='')
        {
            $rek = "";
        }else{
            $rek = "and kode_rek='$kode_rek'";
        }
        
        $CI->db->query("DELETE FROM jurnal_d where no_transaksi='$no_transaksi' $rek ");
    } 
    
    function add_jurnal_all($tgl_transaksi='', $no_transaksi='', $nominal='')
    {
        $CI       = & get_instance();
        $thn      = date('Y');
        $month    = date('m');

        // Persediaan Bahan Baku
        $data_jurnal    = array(
            'tgl_transaksi'   => $tgl_transaksi,
            'tgl_input'       => date("Y:m:d"),
            'jam_input'       => date("H:i:s"),
            'no_voucher'      => $CI->m_fungsi->urut_transaksi('VOUCHER').'/JURNAL'.'/'.$month.'/'.$thn,
            'no_transaksi'    => $no_transaksi,
            'kode_rek'        => '1.01.06',
            'jns_transaksi'   => '1',
            'ket'             => 'Persediaan Bahan Baku',
            'debet'           => $nominal,
            'kredit'          => 0,
        );
        $result_jurnal = $CI->db->insert('jurnal_d', $data_jurnal);
       
        // Hutang Usaha
        $data_jurnal    = array(
            'tgl_transaksi'   => $tgl_transaksi,
            'tgl_input'       => date("Y:m:d"),
            'jam_input'       => date("H:i:s"),
            'no_voucher'      => $CI->m_fungsi->urut_transaksi('VOUCHER').'/JURNAL'.'/'.$month.'/'.$thn,
            'no_transaksi'    => $no_transaksi,
            'kode_rek'        => '2.01.01',
            'jns_transaksi'   => '2',
            'ket'             => 'Hutang Usaha',
            'debet'           => 0,
            'kredit'          => $nominal,
        );
        $result_jurnal = $CI->db->insert('jurnal_d', $data_jurnal);

        // Beban Transport
        $data_jurnal    = array(
            'tgl_transaksi'   => $tgl_transaksi,
            'tgl_input'       => date("Y:m:d"),
            'jam_input'       => date("H:i:s"),
            'no_voucher'      => $CI->m_fungsi->urut_transaksi('VOUCHER').'/JURNAL'.'/'.$month.'/'.$thn,
            'no_transaksi'    => $no_transaksi,
            'kode_rek'        => '6.05',
            'jns_transaksi'   => '6',
            'ket'             => 'Beban Transport',
            'debet'           => $nominal,
            'kredit'          => 0,
        );
        $result_jurnal = $CI->db->insert('jurnal_d', $data_jurnal);

        
        // Hutang Usaha
        $data_jurnal    = array(
            'tgl_transaksi'   => $tgl_transaksi,
            'tgl_input'       => date("Y:m:d"),
            'jam_input'       => date("H:i:s"),
            'no_voucher'      => $CI->m_fungsi->urut_transaksi('VOUCHER').'/JURNAL'.'/'.$month.'/'.$thn,
            'no_transaksi'    => $no_transaksi,
            'kode_rek'        => '2.01.01',
            'jns_transaksi'   => '2',
            'ket'             => 'Hutang Usaha',
            'debet'           => 0,
            'kredit'          => $nominal,
        );
        $result_jurnal = $CI->db->insert('jurnal_d', $data_jurnal);

        // BCA 1
        $data_jurnal    = array(
            'tgl_transaksi'   => $tgl_transaksi,
            'tgl_input'       => date("Y:m:d"),
            'jam_input'       => date("H:i:s"),
            'no_voucher'      => $CI->m_fungsi->urut_transaksi('VOUCHER').'/JURNAL'.'/'.$month.'/'.$thn,
            'no_transaksi'    => $no_transaksi,
            'kode_rek'        => '1.01.02.01',
            'jns_transaksi'   => '1',
            'ket'             => 'BCA 1',
            'debet'           => $nominal,
            'kredit'          => 0,
        );
        $result_jurnal = $CI->db->insert('jurnal_d', $data_jurnal);

        // Modal
        $data_jurnal    = array(
            'tgl_transaksi'   => $tgl_transaksi,
            'tgl_input'       => date("Y:m:d"),
            'jam_input'       => date("H:i:s"),
            'no_voucher'      => $CI->m_fungsi->urut_transaksi('VOUCHER').'/JURNAL'.'/'.$month.'/'.$thn,
            'no_transaksi'    => $no_transaksi,
            'kode_rek'        => '3.01',
            'jns_transaksi'   => '3',
            'ket'             => 'Modal',
            'debet'           => 0,
            'kredit'          => $nominal,
        );
        $result_jurnal = $CI->db->insert('jurnal_d', $data_jurnal);

        // Hutang Usaha
        $data_jurnal    = array(
            'tgl_transaksi'   => $tgl_transaksi,
            'tgl_input'       => date("Y:m:d"),
            'jam_input'       => date("H:i:s"),
            'no_voucher'      => $CI->m_fungsi->urut_transaksi('VOUCHER').'/JURNAL'.'/'.$month.'/'.$thn,
            'no_transaksi'    => $no_transaksi,
            'kode_rek'        => '2.01.01',
            'jns_transaksi'   => '2',
            'ket'             => 'Hutang Usaha',
            'debet'           => $nominal,
            'kredit'          => 0,
        );
        $result_jurnal = $CI->db->insert('jurnal_d', $data_jurnal);

        // BCA 1
        $data_jurnal    = array(
            'tgl_transaksi'   => $tgl_transaksi,
            'tgl_input'       => date("Y:m:d"),
            'jam_input'       => date("H:i:s"),
            'no_voucher'      => $CI->m_fungsi->urut_transaksi('VOUCHER').'/JURNAL'.'/'.$month.'/'.$thn,
            'no_transaksi'    => $no_transaksi,
            'kode_rek'        => '1.01.02.01',
            'jns_transaksi'   => '1',
            'ket'             => 'BCA 1',
            'debet'           => 0,
            'kredit'          => $nominal,
        );
        $result_jurnal = $CI->db->insert('jurnal_d', $data_jurnal);

        // Beban Maklon
        $data_jurnal    = array(
            'tgl_transaksi'   => $tgl_transaksi,
            'tgl_input'       => date("Y:m:d"),
            'jam_input'       => date("H:i:s"),
            'no_voucher'      => $CI->m_fungsi->urut_transaksi('VOUCHER').'/JURNAL'.'/'.$month.'/'.$thn,
            'no_transaksi'    => $no_transaksi,
            'kode_rek'        => '5.04',
            'jns_transaksi'   => '5',
            'ket'             => 'Beban Maklon',
            'debet'           => $nominal,
            'kredit'          => 0,
        );
        $result_jurnal = $CI->db->insert('jurnal_d', $data_jurnal);

        // Hutang Usaha
        $data_jurnal    = array(
            'tgl_transaksi'   => $tgl_transaksi,
            'tgl_input'       => date("Y:m:d"),
            'jam_input'       => date("H:i:s"),
            'no_voucher'      => $CI->m_fungsi->urut_transaksi('VOUCHER').'/JURNAL'.'/'.$month.'/'.$thn,
            'no_transaksi'    => $no_transaksi,
            'kode_rek'        => '2.01.01',
            'jns_transaksi'   => '2',
            'ket'             => 'Hutang Usaha',
            'debet'           => 0,
            'kredit'          => $nominal,
        );
        $result_jurnal = $CI->db->insert('jurnal_d', $data_jurnal);

        // Persediaan Dagang
        $data_jurnal    = array(
            'tgl_transaksi'   => $tgl_transaksi,
            'tgl_input'       => date("Y:m:d"),
            'jam_input'       => date("H:i:s"),
            'no_voucher'      => $CI->m_fungsi->urut_transaksi('VOUCHER').'/JURNAL'.'/'.$month.'/'.$thn,
            'no_transaksi'    => $no_transaksi,
            'kode_rek'        => '1.01.05',
            'jns_transaksi'   => '1',
            'ket'             => 'Persediaan Dagang',
            'debet'           => $nominal,
            'kredit'          => 0,
        );
        $result_jurnal = $CI->db->insert('jurnal_d', $data_jurnal);

        // Persediaan Bahan Baku
        $data_jurnal    = array(
            'tgl_transaksi'   => $tgl_transaksi,
            'tgl_input'       => date("Y:m:d"),
            'jam_input'       => date("H:i:s"),
            'no_voucher'      => $CI->m_fungsi->urut_transaksi('VOUCHER').'/JURNAL'.'/'.$month.'/'.$thn,
            'no_transaksi'    => $no_transaksi,
            'kode_rek'        => '1.01.06',
            'jns_transaksi'   => '1',
            'ket'             => 'Persediaan Bahan Baku',
            'debet'           => 0,
            'kredit'          => $nominal,
        );
        $result_jurnal = $CI->db->insert('jurnal_d', $data_jurnal);

        // Hutang Usaha
        $data_jurnal    = array(
            'tgl_transaksi'   => $tgl_transaksi,
            'tgl_input'       => date("Y:m:d"),
            'jam_input'       => date("H:i:s"),
            'no_voucher'      => $CI->m_fungsi->urut_transaksi('VOUCHER').'/JURNAL'.'/'.$month.'/'.$thn,
            'no_transaksi'    => $no_transaksi,
            'kode_rek'        => '2.01.01',
            'jns_transaksi'   => '2',
            'ket'             => 'Hutang Usaha',
            'debet'           => $nominal,
            'kredit'          => 0,
        );
        $result_jurnal = $CI->db->insert('jurnal_d', $data_jurnal);

        // BCA 1
        $data_jurnal    = array(
            'tgl_transaksi'   => $tgl_transaksi,
            'tgl_input'       => date("Y:m:d"),
            'jam_input'       => date("H:i:s"),
            'no_voucher'      => $CI->m_fungsi->urut_transaksi('VOUCHER').'/JURNAL'.'/'.$month.'/'.$thn,
            'no_transaksi'    => $no_transaksi,
            'kode_rek'        => '1.01.02.01',
            'jns_transaksi'   => '1',
            'ket'             => 'BCA 1',
            'debet'           => 0,
            'kredit'          => $nominal,
        );
        $result_jurnal = $CI->db->insert('jurnal_d', $data_jurnal);

        // Hutang Usaha
        $data_jurnal    = array(
            'tgl_transaksi'   => $tgl_transaksi,
            'tgl_input'       => date("Y:m:d"),
            'jam_input'       => date("H:i:s"),
            'no_voucher'      => $CI->m_fungsi->urut_transaksi('VOUCHER').'/JURNAL'.'/'.$month.'/'.$thn,
            'no_transaksi'    => $no_transaksi,
            'kode_rek'        => '2.01.01',
            'jns_transaksi'   => '2',
            'ket'             => 'Hutang Usaha',
            'debet'           => $nominal,
            'kredit'          => 0,
        );
        $result_jurnal = $CI->db->insert('jurnal_d', $data_jurnal);

        // Hutang PPh 23
        $data_jurnal    = array(
            'tgl_transaksi'   => $tgl_transaksi,
            'tgl_input'       => date("Y:m:d"),
            'jam_input'       => date("H:i:s"),
            'no_voucher'      => $CI->m_fungsi->urut_transaksi('VOUCHER').'/JURNAL'.'/'.$month.'/'.$thn,
            'no_transaksi'    => $no_transaksi,
            'kode_rek'        => '2.01.03.01',
            'jns_transaksi'   => '2',
            'ket'             => 'Hutang PPh 23',
            'debet'           => 0,
            'kredit'          => $nominal,
        );
        $result_jurnal = $CI->db->insert('jurnal_d', $data_jurnal);



        return $result_jurnal;
    } 
?>