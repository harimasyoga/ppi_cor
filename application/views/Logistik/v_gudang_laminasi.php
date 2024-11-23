<div class="content-wrapper">
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
			<div class="col-sm-6">
				<!-- <h1><b>Data Plan</b></h1> -->
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
				<!-- <li class="breadcrumb-item active" ><a href="#">Corrugator</a></li> -->
				</ol>
			</div>
			</div>
		</div>
	</section>

	<style>
		/* Chrome, Safari, Edge, Opera */
		input::-webkit-outer-spin-button,
		input::-webkit-inner-spin-button {
			-webkit-appearance: none;
			margin: 0;
		}
	</style>

	<section class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="card card-primary card-outline" style="padding-bottom:12px">
					<div class="card-header" style="padding:12px">
						<h3 class="card-title" style="font-weight:bold;font-size:18px">LIST STOK LAMINASI</h3>
					</div>
					<div class="card-body" style="font-weight:bold;padding:6px">
						<div class="produk-lm"></div>
					</div>
				</div>
			</div>
		</div>

		<div class="card card-list-so">
			<div class="card-header">
				<h3 class="card-title">Gudang</h3>
				<div class="card-tools">
					<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
					<i class="fas fa-minus"></i></button>
				</div>
			</div>
			<div class="card-body">
				<?php if(in_array($this->session->userdata('level'), ['Admin', 'Laminasi'])) { ?>
					<button type="button" class="btn btn-info" onclick="tambah()"><i class="fa fa-plus"></i> <b>Tambah Data</b></button>
					<br><br>
				<?php } ?>
				<table id="datatable" class="table table-bordered table-striped" width="100%">
					<thead class="color-tabel">
						<tr>
							<th style="width:5%">#</th>
							<th style="width:35%">CUSTOMER</th>
							<th style="width:10%">TIPE</th>
							<th style="width:40%">ITEM</th>
							<th style="width:10%">JUMLAH</th>
							<!-- <th>AKSI</th> -->
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>
		</div>
	</section>
</div>

<script type="text/javascript">
	status ="insert";

	$(document).ready(function () {
		$(".select2").select2()
		// load_data()
	});

	// function reloadTable() {
	// 	table = $('#datatable').DataTable();
	// 	tabel.ajax.reload(null, false);
	// }

	// function load_data() {
	// 	let table = $('#datatable').DataTable();
	// 	table.destroy();
	// 	tabel = $('#datatable').DataTable({
	// 		"processing": true,
	// 		"pageLength": true,
	// 		"paging": true,
	// 		"ajax": {
	// 			"url": '<?php echo base_url('Logistik/LoaDataGudang')?>',
	// 			"type": "POST",
	// 		},
	// 		"aLengthMenu": [
	// 			[5, 10, 15, 20, -1],
	// 			[5, 10, 15, 20, "Semua"]
	// 		],	
	// 		responsive: true,
	// 		"pageLength": 10,
	// 		"language": {
	// 			"emptyTable": "Tidak ada data.."
	// 		}
	// 	})
	// }

	function tambah()
	{
		$(".produk-lm").html('')
		$.ajax({
			url: '<?php echo base_url('Logistik/ListGDProdukLM')?>',
			type: "POST",
			success: function(res){
				data = JSON.parse(res)
				console.log(data)
				$(".produk-lm").html(data.html)
			}
		})
	}

	function keyUpGD(i)
	{
		let rupiah = new Intl.NumberFormat('id-ID', {styles: 'currency', currency: 'IDR'});
		let stok_awal = $("#stok_awal_"+i).val().split('.').join('');
		(stok_awal < 0 || stok_awal == '' || stok_awal.length >= 7) ? stok_awal = 0 : stok_awal = stok_awal;
		$("#stok_awal_"+i).val(rupiah.format(stok_awal));
		let inin = $("#in_"+i).val().split('.').join('');
		(inin < 0 || inin == '' || inin.length >= 7) ? inin = 0 : inin = inin;
		$("#in_"+i).val(rupiah.format(inin));
		let out = $("#out_"+i).val().split('.').join('');
		(out < 0 || out == '' || out.length >= 7) ? out = 0 : out = out;
		$("#out_"+i).val(rupiah.format(out));
		let hitung = (parseInt(stok_awal) + parseInt(inin)) - parseInt(out);
		(isNaN(hitung) || hitung < 0) ? hitung = '' : hitung = hitung;
		$("#stok_akhir_"+i).val(rupiah.format(hitung));
		$("#hstok_akhir_"+i).val(rupiah.format(hitung));
	}

	function simpanGDLaminasi()
	{
		console.log($('#myForm').serialize())
		$.ajax({
			url: '<?php echo base_url('Logistik/simpanGDLaminasi')?>',
			type: "POST",
			data: $('#myForm').serialize(),
			success: function(res){
				data = JSON.parse(res)
				console.log(data)
			}
		})
	}

</script>
