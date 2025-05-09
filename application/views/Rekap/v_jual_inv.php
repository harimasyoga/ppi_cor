<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6" style="font-family:Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;" >
					<!-- <h1><b>Data Logistik</b> </h1> -->
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<!-- <li class="breadcrumb-item active"><a href="#"><?= $judul ?></a></li> -->
					</ol>
				</div>
			</div>
		</div><!-- /.container-fluid -->
	</section>

	<section class="content">

		<!-- Default box -->
		<div class="card shadow mb-3">
			
			<div class="row-list">
				<div class="card-header" style="font-family:Cambria;" >
					<h3 class="card-title" style="color:#4e73df;"><b><?= $judul ?></b></h3>

					<div class="card-tools">
						<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
							<i class="fas fa-minus"></i></button>
					</div>
				</div>
				<div class="card-body">
					 <!--  AA -->
					 <div class="col-md-12">								
						<br>			
						
						<div class="card-body row" style="padding-bottom:1px;font-weight:bold">
							<div class="col-md-2">JENIS</div>
							<div class="col-md-3">
								<select name="jns_data" id="jns_data" class="form-control" style="font-weight:bold" onchange="cek_header(),load_hub_bhn()">
									<option value="box">BOX</option>
									<option value="lm">LAMINASI</option>
								</select>
							</div>
							<div class="col-md-6"></div>
						</div>
						<div class="card-body row" style="padding-bottom:1px;font-weight:bold">
							<div class="col-md-2">BULAN</div>
							<div class="col-md-3">
								<input type="month" class="form-control " name="bulan" id="bulan" onchange="cek_header()">
							</div>
							<div class="col-md-6"></div>
						</div>
						
						<div class="card-body row" style="padding-bottom:1px;font-weight:bold">
							<div class="col-md-2">ATTN</div>
							<div class="col-md-3">
								<select class="form-control select2" name="id_hub2" id="id_hub2" style="width: 100%;"> </select>
							</div>
							<div class="col-md-6"></div>
						</div>
						
						<div class="card-body row" style="padding-bottom:1px;font-weight:bold">
							<div class="col-md-6">
								
								<button onclick="cetak_jual_inv(0)"  class="btn btn-primary">
								<i class="fa fa-print"></i> LAYAR</button>
								
								<button onclick="cetak_jual_inv(1)"  class="btn btn-danger">
								<i class="fa fa-print"></i> PDF</button>

								<button onclick="cetak_jual_inv(2)"  class="btn btn-success">
								<i class="fa fa-download"></i> EXCEL</button>
									<br>
									<br>
									
							</div>
							<div class="col-md-5"></div>
						</div>
						
						
						<br>
					</div>
					<!-- AA -->

					
					<!-- <div style="overflow:auto;white-space:nowrap;" >

						<div class="row-box">
							<table id="datatable_box" class="table table-bordered table-striped table-scrollable" width="100%">
								<thead class="color-tabel">
									<tr>
										<th style="text-align: center;">No </th>
										<th style="text-align: center;">No invoice </th>
										<th style="text-align: center;">Nm perusahaan </th>
										<th style="text-align: center;">Id hub </th>
										<th style="text-align: center;">Nm hub </th>
										<th style="text-align: center;">Bank </th>
										<th style="text-align: center;">Tgl invoice </th>
										<th style="text-align: center;">Nm ker </th>
										<th style="text-align: center;">No po </th>
										<th style="text-align: center;">Type </th>
										<th style="text-align: center;">Qty </th>
										<th style="text-align: center;">Retur qty </th>
										<th style="text-align: center;">Hasil </th>
										<th style="text-align: center;">Harga </th>
										<th style="text-align: center;">Pajak </th>
									</tr>
								</thead>
								<tbody>
								</tbody>
							</table>
						</div>
						<div class="row-lm">
							<table id="datatable_lm" class="table table-bordered table-striped table-scrollable" width="100%">
								<thead class="color-tabel">
									<tr>
										<th style="text-align: center;">No</th>
										<th style="text-align: center;">No Invoice </th>
										<th style="text-align: center;">Nm Pelanggan Lm  </th>
										<th style="text-align: center;">Id Hub  </th>
										<th style="text-align: center;">Nm Hub  </th>
										<th style="text-align: center;">Tgl Invoice  </th>
										<th style="text-align: center;">Nm Produk Lm </th>
										<th style="text-align: center;">No Po Lm  </th>
										<th style="text-align: center;">Type  </th>
										<th style="text-align: center;">Qty  </th>
										<th style="text-align: center;">Retur Qty </th>
										<th style="text-align: center;">Qty Fix </th>
										<th style="text-align: center;">Harga  </th>
										<th style="text-align: center;">Total Jual </th>
										<th style="text-align: center;">Diskon </th>
										<th style="text-align: center;">Total Inv </th>
									</tr>
								</thead>
								<tbody>
								</tbody>
							</table>
						</div>
					</div> -->
				</div>
			</div>
		</div>
		<!-- /.card -->
	</section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->


<script type="text/javascript">
	rowNum = 0;
	$(document).ready(function() {
		// load_data();
		// getMax();
		load_hub_bhn()
		cek_header()
		$('.select2').select2({
			containerCssClass: "wrap",
			// placeholder: '--- Pilih ---',
			dropdownAutoWidth: true
		});
	});

	status = "insert";

	function cetak_jual_inv(ctk)
	{		
		var bulan       = $('#bulan').val()
		var jns_data    = $('#jns_data').val()
		var id_hub2     = $('#id_hub2').val()

		var url    = "<?php echo base_url('Rekapan/cetak_jual_inv'); ?>";
		window.open(url+'?bulan='+bulan+'&ctk='+ctk+'&jns_data='+jns_data+'&id_hub2='+id_hub2, '_blank');   
		 
	}
	
	function load_data() 
	{
		var bulan       = $('#bulan').val()
		var jns_data    = $('#jns_data').val()
		var table       = $('#datatable_'+jns_data).DataTable();

		table.destroy();

		tabel = $('#datatable_'+jns_data).DataTable({

			"processing": true,
			"pageLength": true,
			"paging": true,
			"ajax": {
				"url": '<?= base_url(); ?>Rekapan/load_data/jual_invoice',
				"type": "POST",
				"data" : ({
					bulan    : bulan,jns_data
				}),
				// data  : ({tanggal:tanggal,tanggal_akhir:tanggal_akhir,id_kategori:id_kategori1,id_sub_kategori:id_sub_kategori1}), 
			},
			"aLengthMenu": [
				[10, 15, 20, 25, -1],
				[10, 15, 20, 25, "Semua"] // change per page values here
			],		

			responsive: false,
			"pageLength": 100,
			"language": {
				"emptyTable": "Tidak ada data.."
			}
		});

	}

	
	function load_hub_bhn() 
    {
		var jns_data = $('#jns_data').val()
		option = "";
		$.ajax({
		type       : 'POST',
		url        : "<?= base_url(); ?>Rekapan/load_hub",
		data       : { jns_data },
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
				option = `<option value="">-- Semua --</option>`;	

				$.each(data.data, function(index, val) {
				option += "<option value='"+val.id_hub+"'>"+val.nm_hub+"</option>";
				});

				$('#id_hub2').html(option);
				swal.close();
			}else{	
				option += "<option value=''></option>";
				$('#id_hub2').html(option);						
				swal.close();
			}
		}
		});
      
    }

	function reloadTable() 
	{
		var jns_data    = $('#jns_data').val()
		table           = $('#datatable_'+jns_data).DataTable();
		tabel.ajax.reload(null, false);
	}
	
	var no_po = ''

	function add_data()
	{
		kosong()
		$(".row-input").attr('style', '')
		$(".row-list").attr('style', 'display:none')
		$("#sts_input").val('add');
		
		$("#btn-simpan").html(`<button type="button" onclick="simpan()" class="btn-tambah-produk btn btn-sm btn-primary"><b><i class="fa fa-save" ></i> Simpan</b> </button>`)
	}

	function kembaliList()
	{
		kosong()
		reloadTable()
		$(".row-input").attr('style', 'display:none')
		$(".row-list").attr('style', '')
	}

	function cek_header() 
	{	
		var jns_data    = $('#jns_data').val()

		if(jns_data=='lm')
		{
			$(".row-box").attr('style','display:none');
			$(".row-lm").attr('style','');
		}else{
			$(".row-box").attr('style','');
			$(".row-lm").attr('style','display:none');		

		}

		// load_data()

	}


</script>
