

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
  <div class="modal-dialog modal-full">
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
            <td width="15%">NO SO</td>
              <td>
                <select class="form-control select2" name="no_so" id="no_so" style="width: 100%;" onchange="setDetailSO();">
                  <option value="">Pilih</option>
                  <?php foreach ($getSO as $r): ?>
                    <option value="<?= $r->no_so ?>.<?= $r->urut_so ?>.<?= $r->rpt ?>" detail="<?= $r->no_so ?>">[ <?= $r->no_so ?>.<?= $r->urut_so ?>.<?= $r->rpt ?> ] - [ <?= $r->nm_produk ?> ]</option>
                  <?php endforeach ?>
                </select>
                
              </td>
              <td width="15%"></td>
              <td width="15%">Pelanggan</td>
              <td width="30%">
                <input type="text" class="form-control" name="pelanggan"  id="pelanggan" readonly=""  >
              </td>
            </tr>
            <tr>
              <td >No WO</td>
              <td>
                <input type="hidden" class="form-control" value="trs_wo" name="jenis" id="jenis" >
                <input type="hidden" class="form-control" value="" name="status" id="status" >
                <input type="text" class="form-control" name="no_wo" id="no_wo" readonly>
              </td>
              <td></td>
              <td>Out</td>
              <td><input type="text" class="form-control" name="line" id="line" ></td>
            </tr>
            <tr>
              <td>Tgl WO</td>
              <td><input type="date" class="form-control" name="tgl_wo"  id="tgl_wo" value="<?= date('Y-m-d') ?>" readonly></td>
              <td></td>
              <td>Lebar Kertas</td>
              <td><input type="text" class="form-control" name="no_artikel" id="no_artikel" ></td>
            </tr>
            <tr>
              <td>NO PO</td>
              <td><input type="text" name="nopo" id="nopo" class="form-control" readonly></td>
              <td></td>
              <td>Batch No</td>
              <td><input type="text" class="form-control" name="batchno" id="batchno" ></td>
              
            </tr>

            
          </table>
        </div>

        <div class="form-group row">
          <table class="table" id="table-produk" style="width: 100%;display: ;" align="center" >
            <thead>
                <tr class="color-tabel">
                    <th>Nama Item</th>
                    <th width="10%">Qty</th>
                    <th width="50%">Detail Item</th>
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
            
          <table width="100%">
            <tr> <td>&nbsp;</td> </tr>
          </table>
          <?php 
            $box        = "border: 1px solid black";
            $bottom     = "border-bottom : 1px solid black;";
            $angka_b    = 'style="text-align: center;color:red;font-weight:bold;"';
            $angka_s    = 'style="text-align: left;color:red;font-weight:bold"';
          ?>
          <table border="0" width="100%" id="tabel_box">
            <tr>
              
              <td width="15%" > </td>
              <td width="5%" style="border-right: 1px solid black;"> </td>
              <td width="15%" style="<?= $box ?>" > </td>
              <td width="15%" style="<?= $box ?>" > <br>&nbsp;</br> </td>
              <td width="15%" style="<?= $box ?>" > </td>
              <td width="15%" style="<?= $box ?>" > </td>
              <td width="20%" style="border-left: 1px solid black;border-left: 1px solid black;" > &nbsp; 
                <input <?= $angka_s ?> type="text" class="angka input-border-none" name="flap1" id="flap1" value="0">
              </td>
            </tr>
            <tr>
              <td style="" > 
                <br>&nbsp;</br>
              </td>
              <td class="trapesium" > </td>
              <td style="<?= $box ?>" > </td>
              <td style="<?= $box ?>" > </td>
              <td style="<?= $box ?>" > </td>
              <td style="<?= $box ?>" > </td>
              <td style="border-left: 1px solid black;" > &nbsp;
                <input <?= $angka_s ?> type="text" class="angka input-border-none" name="creasing2" id="creasing2" value="0">
              </td>
            </tr>
            <tr>
              <td> <br>&nbsp;</br></td>
              <td style="border-right: 1px solid black;" align="right">
                <input style="text-align: right;color:red;font-weight:bold;" type="text" class="angka input-border-none" name="kupingan" id="kupingan" value="30"></td>
              <td style =" <?= $box ?>" > </td>
              <td style =" <?= $box ?>" > </td>
              <td style =" <?= $box ?>" > </td>
              <td style =" <?= $box ?>" > </td>
              <td style=" border-left: 1px solid black;" > &nbsp; 
                <input <?= $angka_s ?> type="text" class="angka input-border-none" name="flap2" id="flap2" value="0">
              </td>
            </tr>
            <tr>
              <td align="center" > <br>&nbsp;</br>
              </td>
              <td align="center"> 
              </td>
              <td align="center" > 
                <input <?= $angka_b ?> class="angka input-border-none" type="text" name="p1" id="p1" value="0">
              </td>
              <td align="center" > 
                <input <?= $angka_b ?> class="angka input-border-none" type="text" name="l1" id="l1" value="0">
              </td>
              <td align="center" > 
                <input <?= $angka_b ?> class="angka input-border-none" type="text" name="p2" id="p2" value="0"> 
              </td>
              <td align="center" > 
                <input <?= $angka_b ?> class="angka input-border-none" type="text" name="l2" id="l2" value="0">
              </td>
              <td align="center" > </td>
            </tr>

          </table>
          
          <table border="0" width="100%" id="tabel_sheet">
            <tr>
              <td width="15%"> </td>
              <td width="5%"> </td>
              <td width="15%" style="border-top: 1px solid #000;<?= $bottom ?>border-left: 1px solid #000" > </td>
              <td width="15%" style="border-top: 1px solid #000;<?= $bottom ?>"> <br>&nbsp;</br> </td>
              <td width="15%" style="border-top: 1px solid #000;<?= $bottom ?>"> </td>
              <td width="15%" style="border-top: 1px solid #000;<?= $bottom ?>border-right: 1px solid #000"> </td>
              <td width="20%">
                <input <?= $angka_s ?> type="text" class="angka input-border-none" name="flap1_sheet" id="flap1_sheet" value="127">
              </td>
            </tr>
            <tr>
              <td> 
                <br>&nbsp;</br>
              </td>
              <td> </td>
              <td style="<?= $bottom ?>border-left: 1px solid #000" > </td>
              <td style="<?= $bottom ?>"> </td>
              <td style="<?= $bottom ?>"> </td>
              <td style="<?= $bottom ?>border-right: 1px solid #000" > </td>
              <td>
                <input <?= $angka_s ?> type="text" class="angka input-border-none" name="creasing2_sheet" id="creasing2_sheet" value="275">
              </td>
            </tr>
            <tr>
              <td> <br>&nbsp;</br></td>
              <td></td>
              <td style="<?= $bottom ?> border-left: 1px solid #000" > </td>
              <td style="<?= $bottom ?>" > </td>
              <td style="<?= $bottom ?>" > </td>
              <td style="<?= $bottom ?> border-right: 1px solid #000" > </td>
              <td>
                <input <?= $angka_s ?> type="text" class="angka input-border-none" name="flap2_sheet" id="flap2_sheet" value="127">
              </td>
            </tr>
            <tr>
              <td align="center" > <br>&nbsp;</br>
              </td>
              <td align="center" > 
              </td>
              <td align="center" colspan="4"> 
                <input <?= $angka_b ?> class="angka input-border-none" type="text" name="p1_sheet" id="p1_sheet" value="222">
              </td>
              <td align="center"> </td>
            </tr>

          </table>


          <table border="0" width="100%">
            <tr>
              <td>
                <br>&nbsp;</br>
                <br>&nbsp;</br>
              </td>
            </tr>
          </table>

          <table class="table" id="table-produk" width="100%" border="1" cellspacing="0" style="font-size:12px;">  
            <tr>
              <td align="center" width="10%" rowspan="2" class="posisi-tengah color-tabel"><b>No</b></td>
              <td align="center" width="20%" rowspan="2" class="posisi-tengah color-tabel"><b>PROSES PRODUKSI</b></td>
              <td align="center" width="30%" colspan="2" class="posisi-tengah color-tabel"><b>HASIL PRODUKSI</b></td>
              <td align="center" width="10%" rowspan="2" class="posisi-tengah color-tabel"><b>RUSAK</b></td>
              <td align="center" width="10%" rowspan="2" class="posisi-tengah color-tabel"><b>HASIL BAIK</b></td>
              <td align="center" width="20%" rowspan="2" class="posisi-tengah color-tabel"><b>KETERANGAN</b></td>
            </tr>
            <tr>
                <td align="center" width="15%" class="color-tabel"><b> TGL </b></td>
                <td align="center" width="15%" class="color-tabel"><b> HASIL JADI </b></td>
            </tr>

            <tr>
                <td class="posisi-tengah" align="center"  ><b>1</b></td>
                <td class="posisi-tengah"  ><b>CORRUGATOR</b></td>
                <td>
                  <input type="date" id="tgl_crg" name="tgl_crg" class="form-control" ></td>
                <td>
                  <input type="text" id="hasil_crg" name="hasil_crg" class="form-control" ></td>
                <td>
                  <input type="text" id="rusak_crg" name="rusak_crg" class="form-control" ></td>
                <td>
                  <input type="text" id="baik_crg" name="baik_crg" class="form-control" ></td>
                <td>
                  <input type="text" id="ket_crg" name="ket_crg" class="form-control" ></td>
            </tr>
            <tr>
                <td class="posisi-tengah" align="center"><b>2</b></td>
                <td class="posisi-tengah"><b>FLEXO</b></td>
                <td>
                  <input type="date" id="tgl_flx" name="tgl_flx" class="form-control" ></td>
                <td>
                  <input type="text" id="hasil_flx" name="hasil_flx" class="form-control" ></td>
                <td>
                  <input type="text" id="rusak_flx" name="rusak_flx" class="form-control" ></td>
                <td>
                  <input type="text" id="baik_flx" name="baik_flx" class="form-control" ></td>
                <td>
                  <input type="text" id="ket_flx" name="ket_flx" class="form-control" ></td>
            </tr>
            <tr>
                <td rowspan="6" align="center"><b>3</b></td>
                <td class="posisi-tengah"><b>FINISHING</b></td>
                <td style="border-bottom:hidden;border-right:hidden"></td>
                <td style="border-bottom:hidden;border-right:hidden"></td>
                <td style="border-bottom:hidden;border-right:hidden"></td>
                <td style="border-bottom:hidden;border-right:hidden"></td>
                <td style="border-bottom:hidden;"></td>
            </tr>
            <tr>
                <td class="posisi-tengah"  align="right" ><b>Glue</b></td>
                <td style="border-top:hidden;border-right:hidden">
                  <input type="date" id="tgl_glu" name="tgl_glu" class="form-control" ></td>
                <td style="border-top:hidden;border-right:hidden">
                  <input type="text" id="hasil_glu" name="hasil_glu" class="form-control" ></td>
                <td style="border-top:hidden;border-right:hidden">
                  <input type="text" id="rusak_glu" name="rusak_glu" class="form-control" ></td>
                <td style="border-top:hidden;border-right:hidden">
                  <input type="text" id="baik_glu" name="baik_glu" class="form-control" ></td>
                <td style="border-top:hidden;">
                  <input type="text" id="ket_glu" name="ket_glu" class="form-control" ></td>
            </tr>
            <tr>
                <td class="posisi-tengah"  align="right" ><b>Stitching</b></td>
                <td>
                  <input type="date" id="tgl_stc" name="tgl_stc" class="form-control" ></td>
                <td>
                  <input type="text" id="hasil_stc" name="hasil_stc" class="form-control" ></td>
                <td>
                  <input type="text" id="rusak_stc" name="rusak_stc" class="form-control" ></td>
                <td>
                  <input type="text" id="baik_stc" name="baik_stc" class="form-control" ></td>
                <td>
                  <input type="text" id="ket_stc" name="ket_stc" class="form-control" ></td>
            </tr>
            <tr>
                <td class="posisi-tengah" align="right" ><b>Die Cut</b></td>
                <td>
                  <input type="date" id="tgl_dic" name="tgl_dic" class="form-control" ></td>
                <td>
                  <input type="text" id="hasil_dic" name="hasil_dic" class="form-control" ></td>
                <td>
                  <input type="text" id="rusak_dic" name="rusak_dic" class="form-control" ></td>
                <td>
                  <input type="text" id="baik_dic" name="baik_dic" class="form-control" ></td>
                <td>
                  <input type="text" id="ket_dic" name="ket_dic" class="form-control" ></td>
            </tr>
            <tr>
                <td class="posisi-tengah" align="right" ><b>Asembly Partisi</b></td>
                <td>
                  <input type="date" id="tgl_asembly" name="tgl_asem" class="form-control" ></td>
                <td>
                  <input type="text" id="hasil_asembly" name="hasil_asembly" class="form-control" ></td>
                <td>
                  <input type="text" id="rusak_asembly" name="rusak_asembly" class="form-control" ></td>
                <td>
                  <input type="text" id="baik_asembly" name="baik_asembly" class="form-control" ></td>
                <td>
                  <input type="text" id="ket_asembly" name="ket_asembly" class="form-control" ></td>
            </tr>
            <tr>
                <td class="posisi-tengah" align="right" ><b>Slitter Manual</b></td>
                <td>
                  <input type="date" id="tgl_sliter" name="tgl_sliter" class="form-control" ></td>
                <td>
                  <input type="text" id="hasil_sliter" name="hasil_sliter" class="form-control" ></td>
                <td>
                  <input type="text" id="rusak_sliter" name="rusak_sliter" class="form-control" ></td>
                <td>
                  <input type="text" id="baik_sliter" name="baik_sliter" class="form-control" ></td>
                <td>
                  <input type="text" id="ket_sliter" name="ket_sliter" class="form-control" ></td>
            </tr>
            <tr>
                <td class="posisi-tengah" align="center" ><b>4</b></td>
                <td><b>GUDANG<b></td>
                <td>
                  <input type="date" id="tgl_gdg" name="tgl_gdg" class="form-control" ></td>
                <td>
                  <input type="text" id="hasil_gdg" name="hasil_gdg" class="form-control" ></td>
                <td>
                  <input type="text" id="rusak_gdg" name="rusak_gdg" class="form-control" ></td>
                <td>
                  <input type="text" id="baik_gdg" name="baik_gdg" class="form-control" ></td>
                <td>
                  <input type="text" id="ket_gdg" name="ket_gdg" class="form-control" ></td>
            </tr>
            <tr>
                <td class="posisi-tengah" align="center" ><b>5</b></td>
                <td><b>EXPEDISI / PENGIRIMAN</b></td>
                <td>
                  <input type="date" id="tgl_exp" name="tgl_exp" class="form-control" ></td>
                <td>
                  <input type="text" id="hasil_exp" name="hasil_exp" class="form-control" ></td>
                <td>
                  <input type="text" id="rusak_exp" name="rusak_exp" class="form-control" ></td>
                <td>
                  <input type="text" id="baik_exp" name="baik_exp" class="form-control" ></td>
                <td>
                  <input type="text" id="ket_exp" name="ket_exp" class="form-control" ></td>
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
        <button type="button" class="btn btn-outline-primary" id="btn-simpan" onclick="simpan()"><i class="fas fa-save"></i> Simpan</button>

        <button type="button" class="btn btn-outline-danger" data-dismiss="modalForm" onclick="close_modal();" ><i class="fa fa-times-circle"></i> <b> Batal</b></button>
        
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
    //  getMax();
    $('#tabel_box').hide();
    $('#tabel_sheet').hide();
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
    no_so         = $('#no_so').val();
    line          = $("#line").val();
    no_artikel    = $("#no_artikel").val();
    batchno       = $("#batchno").val();

    if (no_so == '' || no_so == null || line == '' || no_artikel == '' || batchno == '' ) {
      // toastr.info('Harap Lengkapi Form');
      // return;
      swal({
          title               : "Cek Kembali",
          html                : "Harap Lengkapi Form",
          type                : "info",
          confirmButtonText   : "OK"
        });
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
              // toastr.success('Berhasil Disimpan'); 
              swal({
                title               : "Data",
                html                : "Berhasil Disimpan",
                type                : "success",
                confirmButtonText   : "OK"
              });
              kosong();
              $("#modalForm").modal("hide");

              setTimeout(function(){ location.reload(); }, 1000);
            }else{
              // toastr.error('Gagal Simpan'); 
              swal({
                title               : "Cek Kembali",
                html                : "Gagal Simpan",
                type                : "error",
                confirmButtonText   : "OK"
              });
              return;
            }
            // reloadTable();
          },
          error: function (jqXHR, textStatus, errorThrown)
          {
            //  toastr.error('Terjadi Kesalahan '); 
            swal({
              title               : "Cek Kembali",
              html                : "Terjadi Kesalahan",
              type                : "error",
              confirmButtonText   : "OK"
            });
            return;
          }
      });
     
  }

  function kosong(c =''){

    $("#tgl_wo").val("<?= date('Y-m-d') ?>");
    $('#no_so').prop('disabled',false);

    if (c != 's') {
    //  getMax();
    
    }

    $('#no_so').val('').trigger('change');

    $("#btn-print").hide();

    status    = 'insert';
    $("#status").val(status);
    $("#salesman").val("");

    $("#btn-simpan").show();

    $("#pelanggan").val('');
    $("#no_wo").val('');
    $("#nopo").val('');
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

    $("#tgl_asembly").val('');
    $("#hasil_asembly").val('');
    $("#rusak_asembly").val('');
    $("#baik_asembly").val('');
    $("#ket_asembly").val('');
    
    $("#tgl_sliter").val('');
    $("#hasil_sliter").val('');
    $("#rusak_sliter").val('');
    $("#baik_sliter").val('');
    $("#ket_sliter").val('');
    
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

            $("#txt_detail_produk0").html(`
            <table class="table" width="100%" style="font-size:12px">
            <tr>
              <tr style=list-style:none;>
                  <td><b>Nama Item </b>: ${data.nm_produk}</td>
                  <td><b>Ukuran Box </b>: ${data.ukuran}</td>
                  <td><b>Kualitas </b>: ${data.kualitas}</td>
              </tr>
              <tr style=list-style:none;>
                <td><b>Kode MC </b>: ${data.kode_mc}</td>
                <td><b>Ukuran Sheet </b>: ${data.ukuran_sheet}</td>
                <td><b>flute </b>: ${data.flute}</td>
              </tr>
              <tr style=list-style:none;>
                  <td><b>RM </b>: ${data.rm}</td>
                  <td><b>BB </b>: ${data.bb}</td>
                  <td><b>TON </b>: ${data.ton}</td>
              </tr>
              <tr style=list-style:none;>
                  <td><b>Jenis Item </b>: ${data.jenis_produk}</td>
                  <td><b>Creasing </b>: ${ data.creasing }-${ data.creasing2 }-${ data.creasing3 }</td>
                  <td><b>Warna </b>: ${data.warna}</td>
              </tr>
              <tr style=list-style:none;>
                <td><b>Tipe Box </b>: ${data.tipe_box}</td>
                <td><b>Joint </b>: ${$join}</td>
                <td><b>Toleransi </b>: ${data.toleransi_kirim} %</td>
              </tr>
            <tr>
            </table>`);

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
              // toastr.error('Terjadi Kesalahan'); 
              swal({
                title               : "Cek Kembali",
                html                : "Terjadi Kesalahan",
                type                : "error",
                confirmButtonText   : "OK"
              });
              return;
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
          // toastr.success('Data Berhasil Di Batalkan'); 
          swal({
						title               : "Data",
						html                : "Data Berhasil Di Batalkan",
						type                : "success",
						confirmButtonText   : "OK"
					});
          reloadTable();
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
          //  toastr.error('Terjadi Kesalahan'); 
            swal({
              title               : "Cek Kembali",
              html                : "Terjadi Kesalahan",
              type                : "error",
              confirmButtonText   : "OK"
            });
            return;
        }
      });
    }
    
   
  }

  function setDetailSO() 
  {
    
    id = $("#no_so").val();

    if (id == "") {
      // swal({
      //     title               : "Cek Kembali",
      //     html                : "NO SO Tidak Terdeteksi",
      //     type                : "info",
      //     confirmButtonText   : "OK"
      //   });
      $("#loading").hide();
      return;
    }
    
    // $("#loading").show();
    show_loading();
    $.ajax({
        url: '<?php echo base_url('Transaksi/get_edit'); ?>',
        type: 'POST',
        data: {id: id,jenis : "trs_so_detail",field:'no_so'},
        dataType: "JSON",
        success: function(data)
        {  
          $("#pelanggan").val(data.id_pelanggan+' || '+data.nm_pelanggan);
          $("#kode_mc0").val(data.kode_mc+' || '+data.nm_produk);
          $("#qty0").val(data.qty_so);
          $("#nopo").val(data.no_po);
          $("#no_wo").val('WO-'+data.no_so+'.'+data.urut_so+'.'+data.rpt);

          if (data.sambungan == 'G'){
            $join = 'Glue';
          } else if (data.sambungan == 'S'){
            $join = 'Stitching';
          }else {
            $join = 'Die Cut';
          }

          $("#txt_detail_produk0").html(`<table id="datatable" class="table table-bordered table-striped table-scrollable" border="0" width="100%" style="font-size:12px">
            <tr>
                <tr style=list-style:none;>
                  <td><b>Nama Item </b>: ${data.nm_produk}</td>
                  <td><b>Ukuran Box </b>: ${data.ukuran}</td>
                  <td><b>Kualitas </b>: ${data.kualitas}</td>
                </tr>
                <tr style=list-style:none;>
                  <td><b>Kode MC </b>: ${data.kode_mc}</td>
                  <td><b>Ukuran Sheet </b>: ${data.ukuran_sheet}</td>
                  <td><b>flute </b>: ${data.flute}</td>
                      
                </tr>
                <tr style=list-style:none;>
                  <td><b>RM </b>: ${data.rm}</td>
                  <td><b>BB </b>: ${data.bb}</td>
                  <td><b>TON </b>: ${data.ton}</td>
                </tr>
                <tr style=list-style:none;>
                      <td><b>Jenis Item </b>: ${data.jenis_produk}</td>
                      <td><b>Creasing </b>: ${ data.creasing }-${ data.creasing2 }-${ data.creasing3 }</td>
                      <td><b>Warna </b>: ${data.warna}</td>
                </tr>
                <tr style=list-style:none;>
                  <td><b>Tipe Box </b>: ${data.tipe_box}</td>
                  <td><b>Joint </b>: ${$join}</td>
                  <td><b>Toleransi </b>: ${data.toleransi_kirim} %</td>
                </tr>
              <tr>
              </table>`);

          set_ukuran(data);

        }
    })
    // .done(function(data) {
    // }) 
  }

  function set_ukuran(data)
  {
    var fl = data.flute;

    $.ajax({
        url         : '<?php echo base_url(); ?>Transaksi/set_ukuran',
        type        : "POST",
        data        : {fl},
        dataType    : "JSON",
        success: function(val)
        {      
          if(data.kategori=='K_BOX')
          {
            $('#tabel_sheet').hide();
            $('#tabel_box').show();
            $('#p1').val(parseFloat(val.p1)+parseFloat(data.l_panjang));
            $('#l1').val(parseFloat(val.l1)+parseFloat(data.l_lebar));
            $('#p2').val(parseFloat(val.p2)+parseFloat(data.l_panjang));
            $('#l2').val(parseFloat(val.l2)+parseFloat(data.l_lebar));
            $('#flap1').val(parseFloat(val.f1)+(parseFloat(data.l_lebar/2)));
            $('#creasing2').val(parseFloat(val.t)+parseFloat(data.l_tinggi));
            $('#flap2').val(parseFloat(val.f2)+(parseFloat(data.l_lebar/2)));
            $('#kupingan').val(parseFloat(val.kupingan));
          }else{

            $('#tabel_sheet').show();
            $('#tabel_box').hide();
            $('#p1_sheet').val(data.ukuran_sheet_p);
            $('#flap1_sheet').val((data.l_lebar/2));
            $('#creasing2_sheet').val(data.l_tinggi);
            $('#flap2_sheet').val((data.l_lebar/2));
          }
          close_loading();
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            // toastr.error('Terjadi Kesalahan '); 
            swal({
              title               : "Cek Kembali",
              html                : "Terjadi Kesalahan",
              type                : "error",
              confirmButtonText   : "OK"
            });
            close_loading();
            return;
        }
        
    });
    
  }

  function close_modal()
  {
		$('#modalForm').modal('hide');
	}
  
  function Cetak(){
    no_wo = $("#no_wo").val();
    var url    = "<?php echo base_url('Transaksi/Cetak_WO'); ?>";
    window.open(url+'?no_wo='+no_wo, '_blank');
  }

</script>