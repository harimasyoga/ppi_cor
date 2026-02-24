<div class="content-wrapper">
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6"></div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right"></ol>
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
		<div class="row card-add-gudang">
			<div class="col-md-12">
				<div class="card card-primary card-outline" style="padding-bottom:12px">
					<div class="card-header" style="padding:12px">
						<h3 class="card-title" style="font-weight:bold;font-size:18px">INPUT DATA STOK GUDANG CORR</h3>
					</div>
					<div class="card-body" style="font-weight:bold;padding:6px">
						<div style="margin-bottom:6px">
							<button type="button" class="btn btn-info" onclick="kembali()"><i class="fas fa-arrow-left"></i> <b>Kembali</b></button>
						</div>
						<div class="card-body row" style="font-weight:bold;padding:0 6px 30px">
							<div class="col-md-2">CUSTOMER</div>
							<div class="col-md-10">
								<select class="form-control select2" id="pelanggan" onchange="plhGCPelanggan()">
									<?php
										$query = $this->db->query("SELECT*FROM m_pelanggan ORDER BY nm_pelanggan");
										$html ='';
										$html .='<option value="">PILIH</option>';
										foreach($query->result() as $r){
											($r->attn == "-" || $r->attn == "") ? $attn = '' : $attn = ' | '.$r->attn;
											$html .='<option value="'.$r->id_pelanggan.'">'.$r->nm_pelanggan.''.$attn.'</option>';
										}
										echo $html
									?>
								</select>
							</div>
						</div>
						<div class="produk"></div>
						<div class="gudang"></div>
					</div>
				</div>
			</div>
		</div>

		<div class="card card-list-gudang">
			<div class="card-header">
				<h3 class="card-title">Gudang</h3>
				<div class="card-tools">
					<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
					<i class="fas fa-minus"></i></button>
				</div>
			</div>
			<div class="card-body" style="padding:12px 6px">
				<?php if(in_array($this->session->userdata('level'), ['Admin', 'Admin2', 'User'])) { ?>
					<div style="margin-bottom:16px">
						<button type="button" class="btn btn-info" onclick="tambah()"><i class="fa fa-plus"></i> <b>Tambah Data</b></button>
					</div>
				<?php } ?>
				<div>
					<table>
						<tr>
							<td style="font-weight:bold;padding:0 0 16px">
								<input type="date" id="plh_tgl" name="plh_tgl" value="<?php echo date('Y-m-d')?>" class="form-control" onchange="load_data()">
							</td>
							<td style="font-weight:bold;padding:0 0 16px 12px">
								<div class="btn-pdf"></div>
							</td>
						</tr>
					</table>
				</div>
				<table id="datatable" class="table table-bordered table-striped" width="100%">
					<thead class="color-tabel">
						<tr>
							<th style="width:5%">#</th>
							<th style="width:25%">MEREK</th>
							<th style="width:10%">UKURAN</th>
							<th style="width:10%">STOK AWAL</th>
							<th style="width:10%">IN</th>
							<th style="width:10%">OUT</th>
							<th style="width:10%">STOK AKHIR</th>
							<th style="width:20%">KETERANGAN</th>
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

	function reloadTable() {
		table = $('#datatable').DataTable();
		tabel.ajax.reload(null, false);
	}

	// function load_data() {
	// 	let plh_tgl = $("#plh_tgl").val()
	// 	let table = $('#datatable').DataTable();
	// 	table.destroy();
	// 	tabel = $('#datatable').DataTable({
	// 		"processing": true,
	// 		"pageLength": true,
	// 		"paging": true,
	// 		"ajax": {
	// 			"url": '<?php echo base_url('Logistik/loadDataGDLaminasi')?>',
	// 			"type": "POST",
	// 			"data": ({ plh_tgl }),
	// 		},
	// 		"aLengthMenu": [
	// 			[5, 10, 15, 20, -1],
	// 			[5, 10, 15, 20, "Semua"]
	// 		],	
	// 		responsive: true,
	// 		"pageLength": -1,
	// 		"language": {
	// 			"emptyTable": "Tidak ada data.."
	// 		}
	// 	})
	// }

	function tambah() {
		loadGC()
	}

	function kembali() {
		$(".produk").html('')
		$(".gudang").html('')
	}

	function plhGCPelanggan() {
		$(".produk").html('')
		let id_pelanggan = $("#pelanggan").val()
		$.ajax({
			url: '<?php echo base_url('Logistik/plhGCPelanggan')?>',
			type: "POST",
			data: ({
				id_pelanggan, tgl_awal_cust: ''
			}),
			success: function(res){
				data = JSON.parse(res)
				console.log(data)
				$(".produk").html(data.html)
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
		let stokAwalIn = parseInt(stok_awal) + parseInt(inin);
		(out < 0 || out == '' || out.length >= 7 || out > stokAwalIn) ? out = 0 : out = out;
		$("#out_"+i).val(rupiah.format(out));

		let hitung = (parseInt(stok_awal) + parseInt(inin)) - parseInt(out);
		(isNaN(hitung) || hitung < 0) ? hitung = '' : hitung = hitung;
		$("#stok_akhir_"+i).val(rupiah.format(hitung));
		$("#hstok_akhir_"+i).val(hitung);
	}

	function keyUpGD2(i)
	{
		let rupiah = new Intl.NumberFormat('id-ID', {styles: 'currency', currency: 'IDR'});

		let stok_awal = $("#stok_awal2_"+i).val().split('.').join('');
		(stok_awal < 0 || stok_awal == '' || stok_awal.length >= 7) ? stok_awal = 0 : stok_awal = stok_awal;
		$("#stok_awal2_"+i).val(rupiah.format(stok_awal));

		let inin = $("#in2_"+i).val().split('.').join('');
		(inin < 0 || inin == '' || inin.length >= 7) ? inin = 0 : inin = inin;
		$("#in2_"+i).val(rupiah.format(inin));

		let out = $("#out2_"+i).val().split('.').join('');
		let stokAwalIn = parseInt(stok_awal) + parseInt(inin);
		(out < 0 || out == '' || out.length >= 7 || out > stokAwalIn) ? out = 0 : out = out;
		$("#out2_"+i).val(rupiah.format(out));

		let hitung = (parseInt(stok_awal) + parseInt(inin)) - parseInt(out);
		(isNaN(hitung) || hitung < 0) ? hitung = '' : hitung = hitung;
		$("#stok_akhir2_"+i).val(rupiah.format(hitung));
		$("#hstok_akhir2_"+i).val(hitung);
	}

	function simpanGCcorrugated()
	{
		$.ajax({
			url: '<?php echo base_url('Logistik/simpanGCcorrugated')?>',
			type: "POST",
			data: $('#myForm').serialize(),
			success: function(res){
				data = JSON.parse(res)
				console.log(data)
			}
		})
	}

	function plhStokAwalCust()
	{
		let tgl_awal_cust = $("#tgl_awal_cust").val()
		console.log(tgl_awal_cust)
		// $(".produk").html('')
		let id_pelanggan = $("#pelanggan").val()
		$.ajax({
			url: '<?php echo base_url('Logistik/plhGCPelanggan')?>',
			type: "POST",
			data: ({
				id_pelanggan, tgl_awal_cust
			}),
			success: function(res){
				data = JSON.parse(res)
				console.log(data)
				$(".produk").html(data.html)
			}
		})
	}

	function loadGC()
	{
		$(".gudang").html('')
		$.ajax({
			url: '<?php echo base_url('Logistik/loadGC')?>',
			type: "POST",
			success: function(res){
				data = JSON.parse(res)
				console.log(data)
				$(".gudang").html(data.html)
			}
		})
	}

	function gdStokAwalCust()
	{
		let tgl_awal2 = $("#tgl_awal2").val()
		console.log(tgl_awal2)
		// $.ajax({
		// 	url: '<?php echo base_url('Logistik/gdStokAwalCust')?>',
		// 	type: "POST",
		// 	success: function(res){
		// 		data = JSON.parse(res)
		// 		console.log(data)
		// 		$(".gudang").html(data.html)
		// 	}
		// })
	}

</script>
