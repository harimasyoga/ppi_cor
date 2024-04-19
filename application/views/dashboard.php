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
                          <h3 class="card-title" style="font-weight:bold;font-style:italic">REKAP JATUH TEMPO</h3>
                        </div>
                        <div class="card-body">
                          <div class="row">
                            <div class="col-md-10">
                            </div>
                          </div>
                          
                          
                        </div>
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
    });

    function reloadTable() 
    {
      load_data_hub()
      load_data_jt()
      load_list_bhn()
      load_cek_produk()
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

    function load_data_jt() 
    {
      var table = $('#load_data_jt').DataTable();
      table.destroy();
      tabel = $('#load_data_jt').DataTable({
        "processing": true,
        "pageLength": true,
        "paging": true,
        "ajax": {
          "url": '<?php echo base_url(); ?>Master/rekap_jt',
          "type": "POST",
        },
        responsive: true,
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

