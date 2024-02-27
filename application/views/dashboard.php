

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

                  <?php if(in_array($level, ['Admin','konsul_keu','User','Owner','Hub'])){ ?>
                    <!-- REKAP HUB -->
                    <div class="col-md-12">
                      <div class="card card-info card-outline">
                        <div class="card-header">
                          <h3 class="card-title" style="font-weight:bold;font-style:italic">REKAP HUB</h3>
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
                            <div style="overflow:auto;white-space:nowrap" id="datatable_hub"></div>
                          </div>
                      </div>
                    </div>
                    <!-- END REKAP HUB -->
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
                    <div class="col-md-12">
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
    });

    function load_data_hub()
    {
      var th_hub = $('#th_hub').val();

      $.ajax({
        url   : '<?php echo base_url('Master/rekap_hub')?>',
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
          $("#datatable_hub").html(res)
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
  </script>

