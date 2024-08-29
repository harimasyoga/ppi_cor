  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <!-- <h1>Blank Page</h1> -->
          </div>
          
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <?php if(in_array($level, ['Admin','konsul_keu','User','Owner','Keuangan1'])){ ?>
    <!-- REKAP JATUH TEMPO BAHAN -->
    <!-- content2 -->

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- /.col (LEFT) -->
          <div class="col-md-12">
            <div class="row">

                  <?php if(in_array($level, ['Admin','konsul_keu','User','Owner','Hub'])){ ?>
                    
                    <div class="col-md-12 row-jatuh_tempo">
                      <div class="card card-info card-outline">
                        <div class="card-header">
                          <h3 class="card-title" style="font-weight:bold;font-style:italic">REKAP JATUH TEMPO BAHAN</h3>
                        </div>
                        
                        <!--  AA -->
                        <div class="col-md-12">								
                          <br>						
                          <div class="card-body row" style="padding-bottom:1px;font-weight:bold">						
                            <div class="col-md-2">PERIODE</div>
                            <div class="col-md-3">
                              <select class="form-control select2" name="priode" id="priode" style="width: 100%;" onchange="cek_periode(),load_data_jt_bhn()">
                                <option value="bln_ini">BULAN INI</option>
                                <option value="custom">Custom</option>
                                <option value="all">ALL</option>
                              </select>
                            </div>
                            <div class="col-md-1"></div>
                            <div class="col-md-2">ATTN</div>
                            <div class="col-md-3">
                              <select class="form-control select2" name="id_hub2" id="id_hub2" style="width: 100%;" onchange="load_data_jt_bhn()">
                              </select>
                            </div>
                          </div>
                          
                          <div class="card-body row" style="padding-bottom:1px;font-weight:bold;display:none" id="tgl_awal_list" >						
                            <div class="col-md-2">Tgl Awal</div>
                            <div class="col-md-3">
                              <input type="date" class="form-control" name="tgl_awal" id="tgl_awal" onchange="load_data_jt_bhn()" value ="<?= date('Y-m-d') ?>">
                            </div>
                            <div class="col-md-6"></div>
                          </div>

                          <div class="card-body row" style="padding-bottom:1px;font-weight:bold;display:none" id="tgl_akhir_list" >						
                            <div class="col-md-2">Tgl Akhir</div>
                            <div class="col-md-3">
                              <input type="date" class="form-control" name="tgl_akhir" id="tgl_akhir" onchange="load_data_jt_bhn()" value ="<?= date('Y-m-d') ?>">
                            </div>
                            <div class="col-md-6"></div>
                          </div>
                          
                          <br>
                          <hr>
                        </div>
                        <!-- AA -->

                          <div style="padding:0 10px 20px;">
                            <div style="overflow:auto;white-space:nowrap" >
                              <table id="load_data_jt_bhn" class="table table-bordered table-striped" width="100%">
                                <thead class="color-tabel">
                                  <tr>
                                    <th style="width:5%">NO.</th>
                                    <th style="width:45%">NO STOK</th>
                                    <th style="width:45%">TGL</th>
                                    <th style="width:45%">TGL JT</th>
                                    <th style="width:40%">HUB</th>
                                    <th style="width:40%">HARGA</th>
                                    <th style="width:40%">TONASE</th>
                                    <th style="width:40%">TOTAL BAYAR</th>
                                    <!-- <th style="width:10%">AKSI</th> -->
                                  </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                  <tr>
                                    <td colspan="7" class="text-right">
                                      <label for="total">TOTAL</label>
                                    </td>	
                                    <td>
                                      <div class="input-group mb-1 text-right" style="font-weight:bold;color:red">
                                        <!-- <input type="text" size="5" name="total_nom" id="total_nom" style="font-weight:bold;color:red" class="angka form-control text-right" value='0' readonly> -->
                                        <span id="total_all_inv_bhn"></span>
                                      </div>
                                      
                                    </td>	
                                  </tr>
                                </tfoot>
                              </table>
                            </div>
                          </div>
                      </div>
                    </div>
                  <?php } ?>

                <br>
                <hr>
                
            </div>
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>

    <!-- /.content2 -->
    <!-- END JATUH TEMPO BAHAN-->

    <?php } ?>
    

    <section class="content">
      <!-- RINCIAN STOK -->
      <div class="col-md-12 row-stok_rinci" style="display: none;">
        <div class="card card-info card-outline">
          <div class="card-header">
            <h3 class="card-title" style="font-weight:bold;font-style:italic">RINCIAN STOK BAHAN BAKU</h3>

            <div class="card-tools">

              <button type="button" onclick="kembaliList()" class="btn-tambah-produk btn  btn-danger"><b>
                <i class="fa fa-undo" ></i> Kembali</b>
              </button>
            </div>

          </div>
          
            <div style="padding:0 10px 20px;">
              <div style="overflow:auto;white-space:nowrap" >
                <br>
                
                <table id="load_data_bhn_rinci" class="table table-bordered table-striped" width="100%">
                  <thead class="color-tabel">
                    <tr>
                      <th style="width:5%">NO</th>
                      <th style="width:25%">NO TRANSAKSI</th>
                      <th style="width:25%">TANGGAL</th>
                      <th style="width:20%">JAM</th>
                      <th style="width:20%">QTY</th>
                      <th style="width:20%">KET</th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div>
            </div>
        </div>
      </div>
      <!-- END RINCIAN STOK -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- /.col (LEFT) -->
          <div class="col-md-12">
            <div class="row">
              <!-- <div class="card-body">
                  <div align="center" style="font-family:Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;" class="">
                      <h1><strong>SISTEM INFORMASI PRODUKSI </strong> <br><br>
                  <img src="<?= base_url()?>assets/gambar/ppi.png" style="width: 40%;" /> 
                  </div>
              </div> -->

                <!-- <?php if(in_array($level, ['Admin','User'])){ ?>
                    
                      CEK PRODUK
                      
                      <div class="col-md-12 row-stok_bhn">
                        <div class="card card-info card-outline">
                          <div class="card-header">
                            <h3 class="card-title" style="font-weight:bold;font-style:italic">CEK PRODUK</h3>
                          </div>
                          <div class="card-body">
                          <div class="row">
                              <div class="col-md-10">
                              </div>

                            
                          </div>
                            <div style="padding:0 10px 20px;">
                              <div style="overflow:auto;white-space:nowrap" >
                                <table id="load_cek_produk" class="table table-bordered table-striped" width="100%">
                                  <thead class="color-tabel">
                                    <tr>
                                      <th style="width:5%">NO</th>
                                      <th style="width:25%">ID PELANGGAN</th>
                                      <th style="width:20%">NM PELANGGAN</th>
                                      <th style="width:20%">KODE PO</th>
                                      <th style="width:20%">ID PRODUK</th>
                                      <th style="width:20%">NM PRODUK</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                        </div>
                      </div>
                      END CEK PRODUK

                  <?php } ?> -->

                  <?php if(in_array($level, ['Admin','konsul_keu','User','Owner','Hub','Keuangan1'])){ ?>
                    
                    <!-- REKAP STOK BAHAN BAKU -->
                    
                    <div class="col-md-12 row-stok_bhn">
                      <div class="card card-info card-outline">
                        <div class="card-header">
                          <h3 class="card-title" style="font-weight:bold;font-style:italic">REKAP STOK BAHAN BAKU</h3>
                        </div>
                        <div class="card-body">
                          <div class="row">
                            <div class="col-md-10">
                            </div>

                            <div class="col-md-2">
                              <select class="form-control select2" id="pil_keluar" name="pil_keluar" onchange="load_list_bhn()" style="font-weight:bold;" >
                                  <option value="po"><b>PO</b></option>
                                  <option value="inv"><b>INVOICE</b></option>
                              </select>
                            </div>
                          </div>
                          
                          
                        </div>
                          <div style="padding:0 10px 20px;">
                            <div style="overflow:auto;white-space:nowrap" >
                              <table id="load_data_bhn" class="table table-bordered table-striped" width="100%">
                                <thead class="color-tabel">
                                  <tr>
                                    <th style="width:5%">NO</th>
                                    <th style="width:25%">NAMA</th>
                                    <th style="width:20%">MASUK</th>
                                    <th style="width:20%">KELUAR</th>
                                    <th style="width:20%">STOK AKHIR</th>
                                  </tr>
                                </thead>
                                <tbody>
                                </tbody>
                              </table>
                            </div>
                          </div>
                      </div>
                    </div>
                    <!-- END REKAP STOK BAHAN BAKU -->


                    <!-- REKAP OMSET HUB -->
                    <div class="col-md-12 row-omset_hub">
                      <div class="card card-info card-outline">
                        <div class="card-header">
                          <h3 class="card-title" style="font-weight:bold;font-style:italic">REKAP OMSET HUB</h3>
                        </div>
                        <div class="card-body">
                          <div class="row">
                            <div class="col-md-10">
                            </div>

                            <div class="col-md-2">
                              <select class="form-control select2" id="th_hub" name="th_hub" onchange="load_data_hub()">
                                <?php 
                                $thang        = date("Y");
                                $thang_maks   = $thang + 3 ;
                                $thang_min    = $thang - 3 ;
                                for ($th=$thang_min ; $th<=$thang_maks ; $th++)
                                { ?>

                                  <?php if ($th==$thang) { ?>

                                    <option selected value="<?= $th ?>"> <?= $thang ?> </option>
                                    
                                  <?php }else{ ?>
                                      
                                    <option value="<?= $th ?>"> <?= $th ?> </option>
                                  <?php } ?>
                                <?php } ?>
                              </select>
                            </div>
                          </div>
                          
                          
                        </div>
                          <div style="padding:0 10px 20px;">
                            <div style="overflow:auto;white-space:nowrap" id="datatable_omset_hub"></div>
                          </div>
                      </div>
                    </div>
                    <!-- END REKAP OMSET HUB -->
                    

                  <?php } ?>

                <br>
                <hr>
                
            </div>
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

    
    <?php if(in_array($level, ['Admin','konsul_keu','User','Owner','Keuangan1'])){ ?>
    <!-- REKAP JATUH TEMPO -->
    <!-- content2 -->

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- /.col (LEFT) -->
          <div class="col-md-12">
            <div class="row">

                  <?php if(in_array($level, ['Admin','konsul_keu','User','Owner','Hub'])){ ?>
                    
                    <div class="col-md-12 row-jatuh_tempo">
                      <div class="card card-info card-outline">
                        <div class="card-header">
                          <h3 class="card-title" style="font-weight:bold;font-style:italic">REKAP JATUH TEMPO PENJUALAN</h3>
                        </div>
                        
                          <!--  AA -->
                          <div class="col-md-12">								
                            <br>						
                            <div class="card-body row" style="padding-bottom:1px;font-weight:bold">						
                              <div class="col-md-2">PERIODE</div>
                              <div class="col-md-3">
                                <select class="form-control select2" name="priode_jual" id="priode_jual" style="width: 100%;" onchange="cek_periode_jual(),load_data_jt()">
                                  <option value="bln_ini">BULAN INI</option>
                                  <option value="custom">Custom</option>
                                  <option value="all">ALL</option>
                                </select>
                              </div>
                              <div class="col-md-6"></div>
                            </div>
                            
                            <div class="card-body row" style="padding-bottom:1px;font-weight:bold;display:none" id="tgl_awal_list_jual" >
                              <div class="col-md-2">Tgl Awal</div>
                              <div class="col-md-3">
                                <input type="date" class="form-control" name="tgl_awal_jual" id="tgl_awal_jual" onchange="load_data_jt()" value ="<?= date('Y-m-d') ?>">
                              </div>
                              <div class="col-md-6"></div>
                            </div>

                            <div class="card-body row" style="padding-bottom:1px;font-weight:bold;display:none" id="tgl_akhir_list_jual" >						
                              <div class="col-md-2">Tgl Akhir</div>
                              <div class="col-md-3">
                                <input type="date" class="form-control" name="tgl_akhir_jual" id="tgl_akhir_jual" onchange="load_data_jt()" value ="<?= date('Y-m-d') ?>">
                              </div>
                              <div class="col-md-6"></div>
                            </div>
                            
                            <br>
                            <hr>
                          </div>
                          <!-- AA -->
                          
                          <div style="padding:0 10px 20px;">
                            <div style="overflow:auto;white-space:nowrap" >
                              <table id="load_data_jt" class="table table-bordered table-striped" width="100%">
                                <thead class="color-tabel">
                                  <tr>
                                    <th style="width:5%">NO.</th>
                                    <th style="width:45%">NAMA</th>
                                    <th style="width:45%">No Invoice</th>
                                    <th style="width:45%">SJ</th>
                                    <th style="width:40%">PO</th>
                                    <th style="width:40%">Tgl J.Tempo</th>
                                    <th style="width:10%">AKSI</th>
                                  </tr>
                                </thead>
                                <tbody>
                                </tbody>
                              </table>
                            </div>
                          </div>
                      </div>
                    </div>
                  <?php } ?>

                <br>
                <hr>
                
            </div>
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>

    <!-- /.content2 -->
    <!-- END JATUH TEMPO -->

    <?php } ?>
  </div>
  <!-- /.content-wrapper -->
  <script type="text/javascript">
    $(document).ready(function() {
      $(".select2").select2()
      load_data_hub()
      load_data_jt()
      load_list_bhn()
      load_cek_produk()
      <?php if(in_array($level, ['Admin','konsul_keu','User','Owner','Hub'])){ ?>        
        load_data_jt_bhn()
      <?php } ?>
      load_hub_bhn() 
    });

    function reloadTable() 
    {
      load_data_hub()
      load_data_jt()
      <?php if(in_array($level, ['Admin','konsul_keu','User','Owner','Hub'])){ ?>
        load_data_jt_bhn()      
      <?php } ?>
      load_list_bhn()
      load_cek_produk()
      load_hub_bhn() 
    }

    function cek_periode()
    {
      $cek = $('#priode').val();

      if($cek=='custom' )
        {
          $('#tgl_awal_list').show("1000");
          $('#tgl_akhir_list').show("1000");
        }else{
          $('#tgl_awal_list').hide("1000");
          $('#tgl_akhir_list').hide("1000");
        }
    }

    function cek_periode_jual()
    {
      $cek = $('#priode_jual').val();

      if($cek=='custom' )
        {
          $('#tgl_awal_list_jual').show("1000");
          $('#tgl_akhir_list_jual').show("1000");
        }else{
          $('#tgl_awal_list_jual').hide("1000");
          $('#tgl_akhir_list_jual').hide("1000");
        }
    }

    function load_data_hub()
    {
      var th_hub = $('#th_hub').val();

      $.ajax({
        url   : '<?php echo base_url('Master/rekap_omset_hub')?>',
        type  : "POST",
        data  : {th_hub},
        beforeSend: function() {
          swal({
            title: 'Loading',
            allowEscapeKey: false,
            allowOutsideClick: false,
            onOpen: () => {
              swal.showLoading();
            }
          });
        },
        success: function(res){
          $("#datatable_omset_hub").html(res)
          swal.close()
        }
      })
    }

    function load_data_jt_bhn() 
    {
      var id_hub    = $('#id_hub2').val()
      var priode    = $('#priode').val()
      var tgl_awal  = $('#tgl_awal').val()
      var tgl_akhir = $('#tgl_akhir').val()
      var table     = $('#load_data_jt_bhn').DataTable();

      table.destroy();
      tabel = $('#load_data_jt_bhn').DataTable({
        "processing": true,
        "pageLength": true,
        "paging": true,
        "ajax": {
          "url": '<?php echo base_url(); ?>Master/rekap_jt_bhn',
          "type": "POST",
          "data" : ({
            priode    : priode,
            id_hub    : id_hub,
            tgl_awal  : tgl_awal,
            tgl_akhir : tgl_akhir
          }),
        },
        responsive: false,
        "pageLength": 10,
        "language": {
          "emptyTable": "Tidak ada data.."
        }
      });
      total_jt_bhn()
    }

    function total_jt_bhn()
    {

      var id_hub    = $('#id_hub2').val()
      var priode    = $('#priode').val()
      var tgl_awal  = $('#tgl_awal').val()
      var tgl_akhir = $('#tgl_akhir').val()
      var table     = $('#load_data_jt_bhn').DataTable();

      $.ajax({
        url   : '<?= base_url(); ?>Master/rekap_all_jt_bahan',
        type  : "POST",
        data  : {priode    : priode,id_hub    : id_hub,tgl_awal  : tgl_awal,tgl_akhir : tgl_akhir
          },
        dataType   : "JSON",
        
        success: function(data) {
          if(data){
            // header
            $("#total_all_inv_bhn").html(`<div> <span style='font-weight:bold;' class='text-right'>Rp.${format_angka(data.rekap_jumlah.jumlah)}</span></div>`);
            swal.close();

          } else {
            swal.close();
            swal({
              title               : "Cek Kembali",
              html                : "Gagal Load Data",
              type                : "error",
              confirmButtonText   : "OK"
            });
            return;
            $("#total_all_inv_bhn").val(0);
          }
        },
        error: function(jqXHR, textStatus, errorThrown) {
          // toastr.error('Terjadi Kesalahan');
          
          swal.close();
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
    
    function load_hub_bhn() 
    {
      option = "";
      $.ajax({
        type       : 'POST',
        url        : "<?= base_url(); ?>Logistik/load_hub",
        // data       : { idp: pelanggan, kd: '' },
        dataType   : 'json',
        beforeSend: function() {
          swal({
          title: 'loading ...',
          allowEscapeKey    : false,
          allowOutsideClick : false,
          onOpen: () => {
            swal.showLoading();
          }
          })
        },
        success:function(data){			
          if(data.message == "Success"){					
            option = `<option value="">-- Pilih --</option>`;	

            $.each(data.data, function(index, val) {
            option += "<option value='"+val.id_hub+"'>"+val.nm_hub+"</option>";
            });

            $('#id_hub2').html(option);
            $('#id_hub_jual').html(option);
            swal.close();
          }else{	
            option += "<option value=''></option>";
            $('#id_hub2').html(option);					
            $('#id_hub_jual').html(option);					
            swal.close();
          }
        }
      });
      
    }
    
    function load_data_jt() 
    {
      var id_hub    = $('#id_hub_jual').val()
      var priode    = $('#priode_jual').val()
      var tgl_awal  = $('#tgl_awal_jual').val()
      var tgl_akhir = $('#tgl_akhir_jual').val()
      var table     = $('#load_data_jt').DataTable();

      table.destroy();
      tabel = $('#load_data_jt').DataTable({
        "processing": true,
        "pageLength": true,
        "paging": true,
        "ajax": {
          "url": '<?php echo base_url(); ?>Master/rekap_jt',
          "type": "POST",          
          "data" : ({
            priode    : priode,
            id_hub    : id_hub,
            tgl_awal  : tgl_awal,
            tgl_akhir : tgl_akhir
          }),
        },
        responsive: false,
        "pageLength": 10,
        "language": {
          "emptyTable": "Tidak ada data.."
        }
      });
    }
    
    function load_list_bhn() 
    {
      var vall    = $('#pil_keluar').val()
      var table   = $('#load_data_bhn').DataTable()

      table.destroy();
      tabel = $('#load_data_bhn').DataTable({
        "processing": true,
        "pageLength": true,
        "paging": true,
        "ajax": {
          "url": '<?php echo base_url(); ?>Master/rekap_bhn/'+vall,
          "type": "POST",
        },
        responsive: true,
        "pageLength": 10,
        "language": {
          "emptyTable": "Tidak ada data.."
        }
      });
    }
    
    function load_data_bhn_rinci(id_hub,status) 
    {
      var ket   = $('#pil_keluar').val()
      var table = $('#load_data_bhn_rinci').DataTable();
      table.destroy();
      tabel = $('#load_data_bhn_rinci').DataTable({
        "processing": true,
        "pageLength": true,
        "paging": true,
        "ajax": {
          "url"       : '<?php echo base_url(); ?>Master/rekap_bhn_rinci',
          "type"      : 'POST',
          data        : { id_hub,status,ket },
          dataType    : 'JSON',
        },
        
        responsive: true,
        "pageLength": 10,
        "language": {
          "emptyTable": "Tidak ada data.."
        }
      });
    }

    function tampil_data(id_hub,ket)
    {
      $(".row-stok_rinci").attr('style', '')

      $(".row-stok_bhn").attr('style', 'display:none')
      $(".row-omset_hub").attr('style', 'display:none')
      $(".row-jatuh_tempo").attr('style', 'display:none')
      load_data_bhn_rinci(id_hub,ket) 
    }

    function kembaliList()
    {
      reloadTable()
      $(".row-stok_rinci").attr('style', 'display:none')
      
      $(".row-stok_bhn").attr('style', '')
      $(".row-omset_hub").attr('style', '')
      $(".row-jatuh_tempo").attr('style', '')
    }

    
    function load_cek_produk() 
    {
      var table = $('#load_cek_produk').DataTable();
      table.destroy();
      tabel = $('#load_cek_produk').DataTable({
        "processing": true,
        "pageLength": true,
        "paging": true,
        "ajax": {
          "url": '<?php echo base_url(); ?>Master/cek_produk',
          "type": "POST",
        },
        responsive: true,
        "pageLength": 10,
        "language": {
          "emptyTable": "Tidak ada data.."
        }
      });
    }
  </script>

