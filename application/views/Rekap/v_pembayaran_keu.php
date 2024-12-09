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
					<h3 class="card-title" style="color:#4e73df;"><b>MENU MASIH WAITING LIST...</b></h3>

					<div class="card-tools">
						<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
							<i class="fas fa-minus"></i></button>
					</div>
				</div>
				
			</div>
		</div>
		<!-- /.card -->
	</section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- 
<script type="text/javascript">
	rowNum = 0;
	$(document).ready(function() {
		// load_data();
		// getMax();
		cek_header()
		$('.select2').select2({
			containerCssClass: "wrap",
			placeholder: '--- Pilih ---',
			dropdownAutoWidth: true
		});
	});

	status = "insert";

	function cetak_penggunaan_bahan(ctk)
	{		
		var bulan       = $('#bulan').val()
		var jns_data    = $('#jns_data').val()

		var url    = "<?php echo base_url('Rekapan/cetak_penggunaan_bahan'); ?>";
		window.open(url+'?bulan='+bulan+'&ctk='+ctk+'&jns_data='+jns_data, '_blank');   
		 
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
				"url": '<?= base_url(); ?>Rekapan/load_data/guna_bb',
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

		load_data()

	}


</script> -->
