

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Data Transaksi </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active" ><a href="#"><?= $judul ?></a></li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title"><?= $judul ?></h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fas fa-minus"></i></button>
          </div>
        </div>
        <div class="card-body">

          <button type="button" class="tambah_data btn  btn-outline-primary pull-right" >Tambah Data</button>
          <br><br>

         

          <table id="datatable" class="table table-bordered table-striped" width="100%">
            <thead>
            <tr>
              <th style="width:5%">No</th>
              <th style="width:%">No WO</th>
              <th style="width:%">Tgl WO</th>
              <th style="width:%">No SO</th>
              <th style="width:%">Tgl SO</th>
              <th style="width:%">Status</th>
              <th style="width:%">Kode MC</th>
              <th style="width:%">Total Qty</th>
              <th style="width:%">ID Pelanggan</th>
              <th style="width:%">Nama Pelanggan</th>

              <th style="width:10%">Aksi</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<div class="modal fade" id="modalForm">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="judul"></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form role="form" method="post" id="myForm">
        
        <div class="form-group row">
          <table width="100%" border="0">
            <tr>
              <td width="15%">No WO</td>
              <td>

                <input type="hidden" class="form-control" value="trs_wo" name="jenis" id="jenis" >
                <input type="hidden" class="form-control" value="" name="status" id="status" >
                <input type="text" class="form-control" name="no_wo" id="no_wo" readonly>
              </td>
              <td width="15%"></td>
              <td width="15%">Pelanggan</td>
              <td width="30%">
                <input type="text" class="form-control" name="pelanggan"  id="pelanggan" readonly=""  >
              </td>
            </tr>
            <tr>
              <td width="15%">Tgl WO</td>
              <td><input type="date" class="form-control" name="tgl_wo"  id="tgl_wo" value="<?= date('Y-m-d') ?>" readonly></td>
              <td width="15%"></td>
              <td width="15%">Out</td>
              <td><input type="text" class="form-control" name="line" id="line" ></td>
            </tr>
            <tr>
              <td width="15%">NO SO</td>
              <td>
                <select class="form-control select2" name="no_so" id="no_so" style="width: 100%;" onchange="setDetailSO()">
                  <option value="">Pilih</option>
                  <?php foreach ($getSO as $r): ?>
                    <option value="<?= $r->no_so ?>" detail="<?= $r->no_so ?>"><?= $r->no_so ?></option>
                  <?php endforeach ?>
                </select>
                
              </td>
              <td width="15%"></td>
              <td width="15%">Lebar Kertas</td>
              <td><input type="text" class="form-control" name="no_artikel" id="no_artikel" ></td>
            <tr>
              <td width="15%"></td>
              <td></td>
              <td width="15%"></td>
              <td width="15%">Batch No</td>
              <td><input type="text" class="form-control" name="batchno" id="batchno" ></td>
              
            </tr>

            
          </table>
        </div>

        <div class="form-group row">
          <table class="table" id="table-produk" style="width: 80%;display: ;" align="center" >
            <thead>
                <tr>
                    <th>Nama Produk</th>
                    <th width="10%">Qty</th>
                    <th width="50%">Detail Produk</th>
                </tr>
            </thead>
            <tbody>
              <tr id="itemRow0">
                  <td>
                    <input type="text" id="kode_mc0" class="form-control" readonly>

                  </td>
                  <td>
                      <input type="text" name="qty" id="qty0" class="form-control" readonly>
                  </td>
                  <td id="txt_detail_produk0">
                      
                  </td>

                  
              </tr>
            </tbody>
          </table>   

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
                <td align="" width="10%" ><input type="date" id="tgl_crg" name="tgl_crg" class="form-control" ></td>
                <td align="" width="10%" ><input type="text" id="hasil_crg" name="hasil_crg" class="form-control" ></td>
                <td align="" width="15%" ><input type="text" id="rusak_crg" name="rusak_crg" class="form-control" ></td>
                <td align="" width="15%" ><input type="text" id="baik_crg" name="baik_crg" class="form-control" ></td>
                <td align="" width="15%" ><input type="text" id="ket_crg" name="ket_crg" class="form-control" ></td>
            </tr>
            <tr>
                <td align="center" width="%" >2</td>
                <td align="" width="%" >FLEXO</td>
                <td align="" width="%" ><input type="date" id="tgl_flx" name="tgl_flx" class="form-control" ></td>
                <td align="" width="%" ><input type="text" id="hasil_flx" name="hasil_flx" class="form-control" ></td>
                <td align="" width="%" ><input type="text" id="rusak_flx" name="rusak_flx" class="form-control" ></td>
                <td align="" width="%" ><input type="text" id="baik_flx" name="baik_flx" class="form-control" ></td>
                <td align="" width="%" ><input type="text" id="ket_flx" name="ket_flx" class="form-control" ></td>
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
                <td align="" width="%" style="border-top:hidden;border-right:hidden"><input type="date" id="tgl_glu" name="tgl_glu" class="form-control" ></td>
                <td align="" width="%" style="border-top:hidden;border-right:hidden"><input type="text" id="hasil_glu" name="hasil_glu" class="form-control" ></td>
                <td align="" width="%" style="border-top:hidden;border-right:hidden"><input type="text" id="rusak_glu" name="rusak_glu" class="form-control" ></td>
                <td align="" width="%" style="border-top:hidden;border-right:hidden"><input type="text" id="baik_glu" name="baik_glu" class="form-control" ></td>
                <td align="" width="%" style="border-top:hidden;"><input type="text" id="ket_glu" name="ket_glu" class="form-control" ></td>
            </tr>
            <tr>
                <td align="right" width="%" >STITCHING</td>
                <td align="" width="%" ><input type="date" id="tgl_stc" name="tgl_stc" class="form-control" ></td>
                <td align="" width="%" ><input type="text" id="hasil_stc" name="hasil_stc" class="form-control" ></td>
                <td align="" width="%" ><input type="text" id="rusak_stc" name="rusak_stc" class="form-control" ></td>
                <td align="" width="%" ><input type="text" id="baik_stc" name="baik_stc" class="form-control" ></td>
                <td align="" width="%" ><input type="text" id="ket_stc" name="ket_stc" class="form-control" ></td>
            </tr>
            <tr>
                <td align="right" width="%" >DIE CUT</td>
                <td align="" width="%" ><input type="date" id="tgl_dic" name="tgl_dic" class="form-control" ></td>
                <td align="" width="%" ><input type="text" id="hasil_dic" name="hasil_dic" class="form-control" ></td>
                <td align="" width="%" ><input type="text" id="rusak_dic" name="rusak_dic" class="form-control" ></td>
                <td align="" width="%" ><input type="text" id="baik_dic" name="baik_dic" class="form-control" ></td>
                <td align="" width="%" ><input type="text" id="ket_dic" name="ket_dic" class="form-control" ></td>
            </tr>
            <tr>
                <td align="center" width="%" >4</td>
                <td align="" width="%" >GUDANG</td>
                <td align="" width="%" ><input type="date" id="tgl_gdg" name="tgl_gdg" class="form-control" ></td>
                <td align="" width="%" ><input type="text" id="hasil_gdg" name="hasil_gdg" class="form-control" ></td>
                <td align="" width="%" ><input type="text" id="rusak_gdg" name="rusak_gdg" class="form-control" ></td>
                <td align="" width="%" ><input type="text" id="baik_gdg" name="baik_gdg" class="form-control" ></td>
                <td align="" width="%" ><input type="text" id="ket_gdg" name="ket_gdg" class="form-control" ></td>
            </tr>
            <tr>
                <td align="center" width="%" >5</td>
                <td align="" width="%" >EXPEDISI / PENGIRIMAN</td>
                <td align="" width="%" ><input type="date" id="tgl_exp" name="tgl_exp" class="form-control" ></td>
                <td align="" width="%" ><input type="text" id="hasil_exp" name="hasil_exp" class="form-control" ></td>
                <td align="" width="%" ><input type="text" id="rusak_exp" name="rusak_exp" class="form-control" ></td>
                <td align="" width="%" ><input type="text" id="baik_exp" name="baik_exp" class="form-control" ></td>
                <td align="" width="%" ><input type="text" id="ket_exp" name="ket_exp" class="form-control" ></td>
            </tr>
        </table>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 col-form-label"></label>
          <div class="col-sm-4">
          <input type="hidden" name="bucket" id="bucket" value="0">  
          </div>
        </div>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="btn-simpan" onclick="simpan()"><i class="fas fa-save"></i> Simpan</button>
        <button type="button" class="btn btn-outline-secondary" id="btn-print" onclick="Cetak()" style="display:none"><i class="fas fa-print"></i> Print</button>
      </div>
      </form>
        <input type="hidden" name="bucket" id="bucket" value="0">
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<script type="text/javascript">
  rowNum = 0;
  $(document).ready(function () {
     load_data();
     getMax();
     $('.select2').select2();
  });

  status ="insert";
  $(".tambah_data").click(function(event) {
    kosong();
    $("#modalForm").modal("show");
    

    $("#judul").html('<h3> Form Tambah Data</h3>');
    status = "insert";
    $("#status").val("insert");
  });


  function load_data() {
    

    var table = $('#datatable').DataTable();

    table.destroy();

    tabel = $('#datatable').DataTable({

      "processing": true,
      "pageLength": true,
      "paging": true,
      "ajax": {
        "url": '<?php echo base_url(); ?>Transaksi/load_data/trs_wo',
        "type": "POST",
        // data  : ({tanggal:tanggal,tanggal_akhir:tanggal_akhir,id_kategori:id_kategori1,id_sub_kategori:id_sub_kategori1}), 
      },
      responsive: true,
      "pageLength": 25,
      "language": {
        "emptyTable": "Tidak ada data.."
      }
    });

  }

  function reloadTable() {
    table = $('#datatable').DataTable();
    tabel.ajax.reload(null, false);
  }

  function simpan(){
    no_so = $('#no_so').val();
    line  = $("#line").val();
    no_artikel  = $("#no_artikel").val();
    batchno = $("#batchno").val();

    if (no_so == '' || no_so == null || line == '' || no_artikel == '' || batchno == '' ) {
      toastr.info('Harap Lengkapi Form');
      return;
    }


      $.ajax({
          url : '<?php echo base_url(); ?>Transaksi/insert',
          type: "POST",
          data: $('#myForm').serialize(),
          dataType: "JSON",
          success: function(data)
          {           
              if (data) {
                toastr.success('Berhasil Disimpan'); 
                kosong();
                $("#modalForm").modal("hide");

                setTimeout(function(){ location.reload(); }, 1000);
              }else{
                toastr.error('Gagal Simpan'); 
              }
              // reloadTable();
          },
          error: function (jqXHR, textStatus, errorThrown)
          {
             toastr.error('Terjadi Kesalahan '); 
          }
      });
     
  }

  function kosong(c =''){
     $("#tgl_wo").val("<?= date('Y-m-d') ?>");
     $('#no_so').prop('disabled',false);

     if (c != 's') {
       getMax();
      
     }

     $('#no_so').val('').trigger('change');

     $("#btn-print").hide();

     status = 'insert';
     $("#status").val(status);
     $("#salesman").val("");

     $("#btn-simpan").show();

     $("#pelanggan").val('');
      $("#kode_mc0").val('');
      $("#qty0").val('');
      $("#txt_detail_produk0").html('');

      $("#line").val('');
      $("#no_artikel").val('');
      $("#batchno").val('');
     
     $(".btn-tambah-produk").show();

     $("#tgl_crg").val('');
      $("#hasil_crg").val('');
      $("#rusak_crg").val('');
      $("#baik_crg").val('');
      $("#ket_crg").val('');
      $("#tgl_flx").val('');
      $("#hasil_flx").val('');
      $("#rusak_flx").val('');
      $("#baik_flx").val('');
      $("#ket_flx").val('');
      $("#tgl_glu").val('');
      $("#hasil_glu").val('');
      $("#rusak_glu").val('');
      $("#baik_glu").val('');
      $("#ket_glu").val('');
      $("#tgl_stc").val('');
      $("#hasil_stc").val('');
      $("#rusak_stc").val('');
      $("#baik_stc").val('');
      $("#ket_stc").val('');
      $("#tgl_dic").val('');
      $("#hasil_dic").val('');
      $("#rusak_dic").val('');
      $("#baik_dic").val('');
      $("#ket_dic").val('');
      $("#tgl_gdg").val('');
      $("#hasil_gdg").val('');
      $("#rusak_gdg").val('');
      $("#baik_gdg").val('');
      $("#ket_gdg").val('');
      $("#tgl_exp").val('');
      $("#hasil_exp").val('');
      $("#rusak_exp").val('');
      $("#baik_exp").val('');
      $("#ket_exp").val('');
  }


  function tampil_edit(id,act){
    kosong('s');
    $(".btn-tambah-produk").hide();
    
    $("#btn-print").show();

    $("#status").val("update");
    status = 'update';
    $("#modalForm").modal("show");
    if (act =='detail') {
      $("#judul").html('<h3> Detail Data</h3>');
      $("#btn-simpan").hide();
    }else{
      $("#judul").html('<h3> Form Edit Data</h3>');
      $("#btn-simpan").show();
    }

    status = "update";

         $.ajax({
              url: '<?php echo base_url('Transaksi/get_edit'); ?>',
              type: 'POST',
              data: {id: id,jenis : "trs_wo",field:'id'},
              dataType: "JSON",
          })
          .done(function(data) {
            $("#no_wo").val(data.header.no_wo);
            $("#pelanggan").val(data.header.id_pelanggan+' || '+data.header.nm_pelanggan);
            $("#tgl_wo").val(data.header.tgl_wo);
            $("#line").val(data.header.line);
            $("#no_so").val(data.header.no_so);
            $("#no_artikel").val(data.header.no_artikel);
            $("#batchno").val(data.header.batchno);
            $("#kode_mc0").val(data.header.kode_mc);
            $("#qty0").val(data.header.qty);

            $('#no_so').prop('disabled',true);
            $('#no_so').append('<option value="'+data.header.no_so+'" detail="'+data.header.no_so+'">'+data.header.no_so+'</option>');

            $('#no_so').val(data.header.no_so).trigger('change');

            $("#txt_detail_produk0").html('<table width="100%" style="font-size:12px">'+
                                        '<tr>'+
                                          '<td>'+
                                              '<ul>'+
                                                '<li>Nama Produk : '+data.header.nm_produk+'</li>'+
                                                '<li>Ukuran : '+data.header.ukuran+'</li>'+
                                                '<li>Jenis Produk : '+data.header.jenis_produk+'</li>'+
                                              '</ul>'+
                                          '</td>'+
                                          '<td>'+
                                              '<ul>'+
                                                '<li>Tipe Box : '+data.header.tipe_box+'</li>'+
                                                '<li>Kualitas : '+data.header.kualitas+'</li>'+
                                                '<li>Warna : '+data.header.warna+'</li>'+
                                              '</ul>'+
                                          '</td>'+
                                        '<tr>'+
                                      '</table>');

            $("#tgl_crg").val(data.detail.tgl_crg);
            $("#hasil_crg").val(data.detail.hasil_crg);
            $("#rusak_crg").val(data.detail.rusak_crg);
            $("#baik_crg").val(data.detail.baik_crg);
            $("#ket_crg").val(data.detail.ket_crg);
            $("#tgl_flx").val(data.detail.tgl_flx);
            $("#hasil_flx").val(data.detail.hasil_flx);
            $("#rusak_flx").val(data.detail.rusak_flx);
            $("#baik_flx").val(data.detail.baik_flx);
            $("#ket_flx").val(data.detail.ket_flx);
            $("#tgl_glu").val(data.detail.tgl_glu);
            $("#hasil_glu").val(data.detail.hasil_glu);
            $("#rusak_glu").val(data.detail.rusak_glu);
            $("#baik_glu").val(data.detail.baik_glu);
            $("#ket_glu").val(data.detail.ket_glu);
            $("#tgl_stc").val(data.detail.tgl_stc);
            $("#hasil_stc").val(data.detail.hasil_stc);
            $("#rusak_stc").val(data.detail.rusak_stc);
            $("#baik_stc").val(data.detail.baik_stc);
            $("#ket_stc").val(data.detail.ket_stc);
            $("#tgl_dic").val(data.detail.tgl_dic);
            $("#hasil_dic").val(data.detail.hasil_dic);
            $("#rusak_dic").val(data.detail.rusak_dic);
            $("#baik_dic").val(data.detail.baik_dic);
            $("#ket_dic").val(data.detail.ket_dic);
            $("#tgl_gdg").val(data.detail.tgl_gdg);
            $("#hasil_gdg").val(data.detail.hasil_gdg);
            $("#rusak_gdg").val(data.detail.rusak_gdg);
            $("#baik_gdg").val(data.detail.baik_gdg);
            $("#ket_gdg").val(data.detail.ket_gdg);
            $("#tgl_exp").val(data.detail.tgl_exp);
            $("#hasil_exp").val(data.detail.hasil_exp);
            $("#rusak_exp").val(data.detail.rusak_exp);
            $("#baik_exp").val(data.detail.baik_exp);
            $("#ket_exp").val(data.detail.ket_exp);
              
          }) 

  }

  function getMax(){
    $.ajax({
          url: '<?php echo base_url('Transaksi/getMax'); ?>',
          type: 'POST',
          data: {table : "trs_wo",fieald:'no_wo'},
          dataType: "JSON",
          success : function(data){
            $("#no_wo").val("WO-"+data.tahun+"-"+"000000"+data.no);
          },
          error: function (jqXHR, textStatus, errorThrown)
          {
             toastr.error('Terjadi Kesalahan'); 
          }
      });
      
  }


  function deleteData(id){
    let cek = confirm("Apakah Anda Yakin?");

    if (cek) {
      $.ajax({
        url   : '<?php echo base_url(); ?>Transaksi/batal',
        data  : ({id:id,jenis:'trs_wo',field:'id'}),
        type  : "POST",
        success : function(data){
          toastr.success('Data Berhasil Di Batalkan'); 
          reloadTable();
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
           toastr.error('Terjadi Kesalahan'); 
        }
      });
    }
    
   
  }

  function setDetailSO() {
    id = $("#no_so").val();

    if (id == "") {
      return;
    }

    $.ajax({
        url: '<?php echo base_url('Transaksi/get_edit'); ?>',
        type: 'POST',
        data: {id: id,jenis : "trs_so_detail",field:'no_so'},
        dataType: "JSON",
    })
    .done(function(data) {
       $("#pelanggan").val(data.id_pelanggan+' || '+data.nm_pelanggan);
       $("#kode_mc0").val(data.kode_mc+' || '+data.nm_produk);
       $("#qty0").val(data.qty);

       $("#txt_detail_produk0").html('<table width="100%" style="font-size:12px">'+
                                        '<tr>'+
                                          '<td>'+
                                              '<ul>'+
                                                '<li>Nama Produk : '+data.nm_produk+'</li>'+
                                                '<li>Ukuran : '+data.ukuran+'</li>'+
                                                '<li>Jenis Produk : '+data.jenis_produk+'</li>'+
                                              '</ul>'+
                                          '</td>'+
                                          '<td>'+
                                              '<ul>'+
                                                '<li>Tipe Box : '+data.tipe_box+'</li>'+
                                                '<li>Kualitas : '+data.kualitas+'</li>'+
                                                '<li>Warna : '+data.warna+'</li>'+
                                              '</ul>'+
                                          '</td>'+
                                        '<tr>'+
                                      '</table>');

          
    }) 
  }


  function Cetak(){
    no_wo = $("#no_wo").val();
    var url    = "<?php echo base_url('Transaksi/Cetak_WO'); ?>";
    window.open(url+'?no_wo='+no_wo, '_blank');
  }

</script>