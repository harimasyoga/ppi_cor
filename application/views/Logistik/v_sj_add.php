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

	<section class="content" style="padding-bottom:30px">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<div class="card card-secondary card-outline">
						<div class="card-header" style="padding:12px">
							<h3 class="card-title" style="font-weight:bold;font-size:18px">GUDANG</h3>
						</div>
						<div class="card-body card-body-gudang" style="padding:6px">
							<div style="padding:10px;text-align:center">
								<i class="fas fa-2x fa-sync-alt fa-spin"></i>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="card card-info">
						<div class="card-header" style="padding:12px;font-weight:bold">RENCANA KIRIM</div>
						<div class="card-body card-body-rk" style="padding:0">
							<table class="table table-bordered">
								<tr>
									<th style="padding:6px">CUSTOMER</th>
									<th style="padding:6px">NO. PO</th>
									<th style="padding:6px">PLAN</th>
									<th style="padding:6px">MUAT</th>
									<th style="padding:6px">BB</th>
									<th style="padding:6px">TONASE</th>
									<th style="padding:6px">AKSI</th>
								</tr>
								<tr>
									<td style="padding:6px;font-weight:bold" colspan="7">BELUM ADA RENCANA KIRIM!</td>
								</tr>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>

<div class="modal fade" id="modalForm">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="judul"></h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" style="overflow:auto;white-space:nowrap"></div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		loadSJGudang()
		$('.select2').select2({
			dropdownAutoWidth: true
		})
	})

	function loadSJGudang() {
		$.ajax({
			url: '<?php echo base_url('Logistik/loadSJGudang') ?>',
			type: "POST",
			success: function(res) {
				$(".card-body-gudang").html(res)
			}
		})
	}

	function loadSJItems(gd_id_pelanggan) {
		$(".iitemss").html('')
		$.ajax({
			url: '<?php echo base_url('Logistik/loadSJItems') ?>',
			type: "POST",
			data: ({ gd_id_pelanggan }),
			success: function(res) {
				$("#tampilItems-"+gd_id_pelanggan).html(res)
			}
		})
	}

	function loadSJPO(gd_id_pelanggan, gd_id_produk) {
		$.ajax({
			url: '<?php echo base_url('Logistik/loadSJPO') ?>',
			type: "POST",
			data: ({ gd_id_pelanggan, gd_id_produk }),
			success: function(res) {
				$("#tampilPO-"+gd_id_pelanggan+"-"+gd_id_produk).html(res)
			}
		})
	}

	function loadSJIsiGudang(i, gd_id_pelanggan, gd_id_produk, kode_po) {
		$.ajax({
			url: '<?php echo base_url('Logistik/loadSJIsiGudang') ?>',
			type: "POST",
			data: ({ gd_id_pelanggan, gd_id_produk, kode_po }),
			success: function(res) {
				$("#tampilGudang-"+i+"-"+gd_id_pelanggan+"-"+gd_id_produk).html(res)
			}
		})
	}

	function hitungSJTonase(id_gudang, gd_berat_box) {
		let rp = new Intl.NumberFormat('id-ID', {styles: 'currency', currency: 'IDR'})
		let muat = $("#inp-muat-"+id_gudang).val().split('.').join('');
		(muat < 0 || muat == 0 || muat == '' || muat == undefined || muat.length >= 7) ? muat = 0 : muat = muat;
		$("#inp-muat-"+id_gudang).val(rp.format(muat));

		let hitung = parseInt(muat) * parseFloat(gd_berat_box);
		(hitung < 0 || hitung == 0 || hitung == '') ? hitung = 0 : hitung = hitung;
		$(".hitung-tonase-"+id_gudang).html(rp.format(Math.round(hitung)))
		$("#hidden-hitung-tonase-"+id_gudang).val(rp.format(Math.round(hitung)))
	}

	function addCartRKSJ(id_gudang) {
		let muat = $("#inp-muat-"+id_gudang).val().split('.').join('')
		let tonase = $("#hidden-hitung-tonase-"+id_gudang).val().split('.').join('')
		let idPelanggan = $("#hidden-id-pelanggan-"+id_gudang).val()
		let idProduk = $("#hidden-id-produk-"+id_gudang).val()
		let nmPelanggan = $("#hidden-nm-pelanggan-"+id_gudang).val()
		let kodePo = $("#hidden-kode-po-"+id_gudang).val()
		let bb = $("#hidden-bb-"+id_gudang).val()
		let qty = $("#hidden-qty-"+id_gudang).val()

		console.log("id_gudang : ", id_gudang)
		console.log("muat : ", muat)
		console.log("tonase : ", tonase)
		console.log("idPelanggan : ", idPelanggan)
		console.log("idProduk : ", idProduk)
		console.log("nmPelanggan : ", nmPelanggan)
		console.log("kodePo : ", kodePo)
		console.log("bb : ", bb)
		console.log("qty : ", qty)
	}
</script>
