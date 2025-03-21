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
		<div class="row card-add-gudang" style="display:none">
			<div class="col-md-12">
				<div class="card card-primary card-outline" style="padding-bottom:12px">
					<div class="card-header" style="padding:12px">
						<h3 class="card-title" style="font-weight:bold;font-size:18px">LIST STOK LAMINASI</h3>
					</div>
					<div class="card-body" style="font-weight:bold;padding:6px">
						<div style="margin-bottom:6px">
							<button type="button" class="btn btn-info" onclick="kembali()"><i class="fas fa-arrow-left"></i> <b>Kembali</b></button>
						</div>
						<div class="produk-lm"></div>
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
				<?php if(in_array($this->session->userdata('level'), ['Admin', 'Laminasi', 'User'])) { ?>
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
		load_data()
	});

	function reloadTable() {
		table = $('#datatable').DataTable();
		tabel.ajax.reload(null, false);
	}

	function load_data() {
		let plh_tgl = $("#plh_tgl").val()
		let table = $('#datatable').DataTable();
		table.destroy();
		tabel = $('#datatable').DataTable({
			"processing": true,
			"pageLength": true,
			"paging": true,
			"ajax": {
				"url": '<?php echo base_url('Logistik/loadDataGDLaminasi')?>',
				"type": "POST",
				"data": ({ plh_tgl }),
			},
			"aLengthMenu": [
				[5, 10, 15, 20, -1],
				[5, 10, 15, 20, "Semua"]
			],	
			responsive: true,
			"pageLength": -1,
			"language": {
				"emptyTable": "Tidak ada data.."
			}
		})
		pdfGDLaminasi()
	}

	function pdfGDLaminasi()
	{
		$(".btn-pdf").html('')
		let plh_tgl = $("#plh_tgl").val()
		$.ajax({
			url: '<?php echo base_url('Logistik/ListGDProdukLM')?>',
			type: "POST",
			data: ({ tgl_awal: '', plh_tgl, opsi: 'html' }),
			success: function(res){
				data = JSON.parse(res)
				$(".btn-pdf").html(data.pdf)
			}
		})
	}

	function tambah()
	{
		$(".card-add-gudang").show()
		$(".card-list-gudang").hide()
		$(".produk-lm").html('')
		$.ajax({
			url: '<?php echo base_url('Logistik/ListGDProdukLM')?>',
			type: "POST",
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
			data: ({ tgl_awal: '', plh_tgl: '', opsi: 'html' }),
			success: function(res){
				data = JSON.parse(res)
				$(".produk-lm").html(data.html)
				swal.close()
			}
		})
	}

	function kembali()
	{
		$(".card-add-gudang").hide()
		$(".card-list-gudang").show()
		$(".produk-lm").html('')
		reloadTable()
	}

	function plhStokAwal()
	{
		let tgl_awal = $("#tgl_awal").val()
		$.ajax({
			url: '<?php echo base_url('Logistik/ListGDProdukLM')?>',
			type: "POST",
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
			data: ({ tgl_awal, plh_tgl: '', opsi: 'html' }),
			success: function(res){
				data = JSON.parse(res)
				$(".produk-lm").html(data.html)
				swal.close()
			}
		})
	}

	function keyUpGD(i)
	{
		let rupiah = new Intl.NumberFormat('id-ID', {styles: 'currency', currency: 'IDR'});

		let stok_awal = $("#stok_awal_"+i).val().split('.').join('');
		(stok_awal < 0 || stok_awal == '' || stok_awal.length >= 7) ? stok_awal = 0 : stok_awal = stok_awal;
		$("#stok_awal_"+i).val(rupiah.format(stok_awal));
		$("#hstok_awal_"+i).val(stok_awal);

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

	function simpanGDLaminasi()
	{
		$.ajax({
			url: '<?php echo base_url('Logistik/simpanGDLaminasi')?>',
			type: "POST",
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
			data: $('#myForm').serialize(),
			success: function(res){
				data = JSON.parse(res)
				if(data.data){
					toastr.success(`<b>BERHASIL SIMPAN!</b>`)
					kembali()
				}else{
					toastr.error(`<b>${data.msg}</b>`)
				}
				swal.close()
			}
		})
	}

</script>
