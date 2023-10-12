

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
              <th style="width:%">No SO</th>
              <th style="width:%">Tgl SO</th>
              <th style="width:%">Status</th>
              <th style="width:%">No PO</th>
              <th style="width:%">Kode MC</th>
              <th style="width:%">Total Qty</th>
              <th style="width:%">ID Pelanggan</th>
              <th style="width:%">Nama Pelanggan</th>
              <th style="width:%">Salesman</th>

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
              <td width="15%">No SO</td>
              <td>

                <input type="hidden" class="form-control" value="trs_so_detail" name="jenis" id="jenis" >
                <input type="hidden" class="form-control" value="" name="tgl_po" id="tgl_po" >
                <input type="hidden" class="form-control" value="" name="status" id="status" >
                <input type="text" class="form-control" name="no_so" id="no_so" readonly>
              </td>
              <td width="15%"></td>
              <td width="15%">Salesman</td>
              <td width="30%">
                <input type="text" class="form-control" name="salesman"  id="salesman"  >
              </td>
            </tr>
            <tr>
              <td width="15%">Tgl SO</td>
              <td><input type="date" class="form-control" name="tgl_so"  id="tgl_so" value="<?= date('Y-m-d') ?>" readonly></td>
              <td width="15%"></td>
              <td width="15%" rowspan="2" style="padding-left: 20px;" valign="top">
                ID Pelanggan <br>
                Pelanggan <br>
                Kota <br>
                No Telepon <br>
                FAX <br>
                TOP 
              </td>
              <td rowspan="2" valign="top">
                <font id="txt_id_pelanggan"> </font> <br>
                <font id="txt_nm_pelanggan"> </font> <br>
                <font id="txt_kota"> </font> <br>
                <font id="txt_no_telp"> </font> <br>
                <font id="txt_fax"> </font> <br>
                <font id="txt_top"> </font> <br>
              </td>
            </tr>
            <tr>
              <td width="15%">NO PO</td>
              <td>
                <select class="form-control select2" name="no_po" id="no_po" style="width: 100%;" onchange="setDetailPO()">
                  <option value="">Pilih</option>
                  <?php foreach ($getPO as $r): ?>
                    <option value="<?= $r->no_po ?>" detail="<?= $r->no_po ?>"><?= $r->no_po ?></option>
                  <?php endforeach ?>
                </select>
                
              </td>
              <td width="15%"></td>
              
            </tr>

            
          </table>
        </div>

        <div class="form-group row">
          <table class="table" id="table-produk" style="width: 80%;display: none;" align="center" >
            <thead>
                <tr>
                    <th>Nama Produk</th>
                    <th width="10%">Qty PO</th>
                    <th width="10%">Qty SO</th>
                    <th width="10%">Qty</th>
                    <th width="50%">Detail Produk</th>
                </tr>
            </thead>
            <tbody>
              <tr id="itemRow0">
                  <td>
                    <select class="form-control select2" name="id_produk[0]" id="id_produk0" style="width: 100%;" onchange="setDetailProduk(0)">
                      
                    </select>

                  </td>
                  <td>
                      <input type="text" id="qty_po0" class="angka form-control" readonly>
                  </td>
                  <td>
                      <input type="text" id="qty_so0" class="angka form-control" readonly>
                  </td>
                  <td>
                      <input type="text" name="qty[0]" id="qty0" class="angka form-control" value='0'  onkeyup="hitung(0)" onchange="hitung(0)">
                  </td>
                  <td id="txt_detail_produk0">
                      
                  </td>

                  
              </tr>
            </tbody>
          </table>   
          <table class="table" id="table-produk-detail" style="width: 80%;display: none;" align="center" >
            <thead>
                <tr>
                    <th width="40%">Nama Produk</th>
                    <th width="10%">Qty</th>
                    <th width="50%">Detail Produk</th>
                </tr>
            </thead>
            <tbody>
              
            </tbody>
          </table>   
        </div>
        <div class="form-group row">
          <label class="col-sm-2 col-form-label"></label>
          <div class="col-sm-4">
            <!-- <button type="button" onclick="addRow()" class="btn-tambah-produk btn  btn-outline-primary">Tambah Produk</button> -->
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
    $("#table-produk").show();
    $("#table-produk-detail").hide();
    

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
        "url": '<?php echo base_url(); ?>Transaksi/load_data/trs_so_detail',
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
    no_po = $("#no_po").val();
    salesman = $("#salesman").val();

    if (no_po == '' || no_po == null || salesman == '' ) {
      toastr.info('Harap Lengkapi Form');
      return;
    }

      arr_produk = [];
      for (var i = 0; i <= rowNum; i++) {

        produk = $("#id_produk"+i).val();
        qty = $("#qty"+i).val();

        if (produk == '' || qty == '' || qty == '0') {
          toastr.info('Harap Lengkapi Form');
          return;
        }

        arr_produk.push(produk);
      }

      let findDuplicates = arr => arr.filter((item, index) => arr.indexOf(item) != index)

      if (findDuplicates(arr_produk).length > 0) {
        toastr.info('Tidak boleh ada produk yang sama'); 
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
     $("#tgl_so").val("<?= date('Y-m-d') ?>");

     if (c != 's') {
       getMax();
      
     }

     $('#no_po').val('').trigger('change');

     $("#btn-print").hide();

     $("#txt_id_pelanggan").html(": -");
     $("#txt_nm_pelanggan").html(": -");
     $("#txt_kota").html(": -");
     $("#txt_no_telp").html(": -");
     $("#txt_fax").html(": -");
     $("#txt_top").html(": -");
    
     clearRow();
     status = 'insert';
     $("#status").val(status);
     $("#salesman").val("");

     $('#no_po').prop('disabled',false);

     $("#btn-simpan").show();
     
     $(".btn-tambah-produk").show();
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
              data: {id: id,jenis : "trs_so_detail",field:'id'},
              dataType: "JSON",
          })
          .done(function(data) {
            $("#no_so").val(data.no_so);
            $("#tgl_so").val(data.tgl_so);

            
            $('#no_po').prop('disabled',true);
            $('#no_po').append('<option value="'+data.no_po+'" detail="'+data.no_po+'">'+data.no_po+'</option>');

            $('#no_po').val(data.no_po).trigger('change');
             
             $("#kode_po").val(data.kode_po);
             $("#salesman").val(data.salesman);


             $("#txt_kota").html(": "+data.kota);
             $("#txt_no_telp").html(": "+data.no_telp);
             $("#txt_fax").html(": "+data.fax);
             $("#txt_top").html(": "+data.top);
             
             $("#table-produk").hide();
             $("#table-produk-detail").show();

             if (act =='detail') {
              
              $("#table-produk-detail tbody").empty();
              
              $("#table-produk-detail tbody").append(
                                                 '<tr>'+
                                                    '<td>'+data.nm_produk+'</td>'+
                                                    '<td>'+data.qty+'</td>'+
                                                    '<td>'+
                                                        '<table width="100%" style="font-size:12px">'+
                                                          '<tr>'+
                                                            '<td>'+
                                                                '<ul>'+
                                                                  '<li>Nama Produk : '+data.nm_produk+'</li>'+
                                                                  '<li>Ukuran : '+data.ukuran+'</li>'+
                                                                  '<li>Material : '+data.material+'</li>'+
                                                                '</ul>'+
                                                            '</td>'+
                                                            '<td>'+
                                                                '<ul>'+
                                                                  '<li>Flute : '+data.flute+'</li>'+
                                                                  '<li>Creasing : '+data.creasing+'</li>'+
                                                                  '<li>Warna : '+data.warna+'</li>'+
                                                                '</ul>'+
                                                            '</td>'+
                                                          '<tr>'+
                                                        '</table>'+
                                                    '</td>'+
                                                 '</tr>'
                                              );

             
              }
              
          }) 

  }

  function getMax(){
    $.ajax({
          url: '<?php echo base_url('Transaksi/getMax'); ?>',
          type: 'POST',
          data: {table : "trs_so_detail",fieald:'no_so'},
          dataType: "JSON",
          success : function(data){
            $("#no_so").val("SO-"+data.tahun+"-"+"000000"+data.no);
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
        data  : ({id:id,jenis:'trs_so_detail',field:'id'}),
        type  : "POST",
        success : function(data){
          toastr.success('Data Berhasil Di Hapus'); 
          reloadTable();
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
           toastr.error('Terjadi Kesalahan'); 
        }
      });
    }
    
   
  }

  $("#id_pelanggan").change(function(){
    if ($("#id_pelanggan").val() == "") {
      return;
    }

    arr_detail = $('#id_pelanggan option:selected').attr('detail');

    if (typeof arr_detail === 'undefined'){
        return;
    }

    arr_detail = arr_detail.split("|");
    // console.log(arr_detail);

    $("#txt_kota").html(": "+arr_detail[0]);
    $("#txt_no_telp").html(": "+arr_detail[1]);
    $("#txt_fax").html(": "+arr_detail[2]);
    $("#txt_top").html(": "+arr_detail[3]);

  });

  function setDetailPO() {
    id = $("#no_po").val();

    if (id == "") {
      return;
    }

    $("#id_produk0").empty();
    $("#id_produk0").append('<option value="">Pilih</option>');

    $.ajax({
        url: '<?php echo base_url('Transaksi/get_edit'); ?>',
        type: 'POST',
        data: {id: id,jenis : "trs_po_detail",field:'no_po'},
        dataType: "JSON",
    })
    .done(function(data) {
       $("#txt_id_pelanggan").html(": "+data[0].id_pelanggan);
       $("#txt_nm_pelanggan").html(": "+data[0].nm_pelanggan);
       $("#txt_kota").html(": "+data[0].kota);
       $("#txt_no_telp").html(": "+data[0].no_telp);
       $("#txt_fax").html(": "+data[0].fax);
       $("#txt_top").html(": "+data[0].top);
       $("#tgl_po").val(data[0].tgl_po);

          $.each(data,function(index, value){
            /*<option value="<?= $r->kode_mc ?>" detail="<?= $r->kode_mc."|".$r->nm_produk."|".$r->ukuran."|".$r->material."|".$r->flute."|".$r->creasing."|".$r->warna ?>"><?= $r->kode_mc ?></option>  */

             $("#id_produk0").append('<option value="'+value.kode_mc+'" '+
                                        'detail="'+value.kode_mc+'|'+value.nm_produk+'|'+value.ukuran+'|'+value.material+'|'+value.flute+'|'+value.creasing+'|'+value.warna+'|'+value.qty_so+'|'+value.qty+' "'+
                                      '>'+value.kode_mc+'</option>');
          });

          $('#id_produk0').select2();
    }) 
  }

  function clearRow() 
    {
        var bucket = $('#bucket').val();
        for (var e = bucket; e > 0; e--) {            
            jQuery('#itemRow'+e).remove();            
            rowNum--;
        }

        $('#removeRow').hide();
        $('#bucket').val(rowNum);
        $('#id_produk0').val('').trigger('change');
        $('#qty0').val('0');
        $('#qty_so0').val('0');
        $('#qty_po0').val('0');
        $('#txt_detail_produk0').html('');
        $("#btn-hapus-0").show();

        $("#qty0").prop("disabled",false);
        $("#id_produk0").prop("disabled",false);
    }

  function setDetailProduk(e){
    if ($("#id_produk"+e).val() == "") {
      return;
    }
    
    arr_detail = $('#id_produk'+e+' option:selected').attr('detail');

    if (typeof arr_detail === 'undefined'){
        return;
    }

    arr_detail = arr_detail.split("|");
    // console.log(arr_detail);

    $("#txt_detail_produk"+e).html(
      '<table width="100%" style="font-size:12px">'+
        '<tr>'+
          '<td>'+
              '<ul>'+
                '<li>Nama Produk : '+arr_detail[1]+'</li>'+
                '<li>Ukuran : '+arr_detail[2]+'</li>'+
                '<li>Material : '+arr_detail[3]+'</li>'+
              '</ul>'+
          '</td>'+
          '<td>'+
              '<ul>'+
                '<li>Flute : '+arr_detail[4]+'</li>'+
                '<li>Creasing : '+arr_detail[5]+'</li>'+
                '<li>Warna : '+arr_detail[6]+'</li>'+
              '</ul>'+
          '</td>'+
        '<tr>'+
      '</table>'
      
    );

    $("#qty_so0").val(arr_detail[7]);
    $("#qty_po0").val(arr_detail[8]);

    qty_sisa = parseFloat(arr_detail[8]) - parseFloat(arr_detail[7]);
    $("#qty0").val(qty_sisa);
  }

  function hitung(){
    toastr.clear();

    qty_po = parseFloat($("#qty_po0").val());
    qty_so = parseFloat($("#qty_so0").val());

    qty_sisa = qty_po - qty_so;
    qty = parseFloat($("#qty0").val());

    if(isNaN(qty)){
        qty = 0;
    }

    if (qty > qty_sisa) {
      toastr.info('qty maksimal : '+qty_sisa);
      qty = qty_sisa;

    }

    $("#qty0").val(qty);


  }

    function Cetak(){
      no_so = $("#no_so").val();
      var url    = "<?php echo base_url('Transaksi/Cetak_SO'); ?>";
      window.open(url+'?no_so='+no_so, '_blank');
    }

</script>