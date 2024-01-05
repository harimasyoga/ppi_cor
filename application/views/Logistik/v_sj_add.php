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
					<div class="card card-info card-outline">
						<input type="hidden" id="hidden-card-body-rk">
						<div class="card-header" style="padding:12px">
							<h3 class="card-title" style="font-weight:bold;font-size:18px">RENCANA KIRIM</h3>
						</div>
						<div class="card-body" style="padding:0">
							<div class="card-body-rk" style="overflow:auto;white-space:nowrap"></div>
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="card card-success card-outline">
						<div class="card-header" style="padding:12px">
							<h3 class="card-title" style="font-weight:bold;font-size:18px">PENGIRIMAN</h3>
						</div>
						<div class="card-body card-body-pengiriman" style="padding:6px"></div>
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
		$("#hidden-card-body-rk").load("<?php echo base_url('Logistik/destroyGudang') ?>")
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
				listRencanaKirim()
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
		let nmProduk = $("#hidden-nm-produk-"+id_gudang).val()
		let kodePo = $("#hidden-kode-po-"+id_gudang).val()
		let bb = $("#hidden-bb-"+id_gudang).val()
		let qty = $("#hidden-qty-"+id_gudang).val()

		$.ajax({
			url: '<?php echo base_url('Logistik/addCartRKSJ')?>',
			type: "POST",
			data: ({
				id_gudang, muat, tonase, idPelanggan, idProduk, nmPelanggan, nmProduk, kodePo, bb, qty
			}),
			success: function(res){
				data = JSON.parse(res)
				if(data.data){
					toastr.success('<b>BERHASIL!</b>');
					listRencanaKirim()
				}else{
					swal(data.isi, "", "error")
					$("#inp-muat-"+id_gudang).val(0)
					$(".hitung-tonase-"+id_gudang).html('0')
					$("#hidden-hitung-tonase-"+id_gudang).val(0)
					return
				}
			}
		})
	}

	function listRencanaKirim() {
		$.ajax({
			url: '<?php echo base_url('Logistik/listRencanaKirim')?>',
			type: "POST",
			success: function(res){
				$(".card-body-rk").html(res)
			}
		})
	}

	function hapusCartRKSJ(rowid){
		$.ajax({
			url: '<?php echo base_url('Logistik/hapusCartRKSJ')?>',
			type: "POST",
			data: ({
				rowid
			}),
			success: function(res){
				listRencanaKirim()
			}
		})
	}

	function simpanCartRKSJ() {
		$("#simpan_rk").prop('disabled', true)
		$.ajax({
			url: '<?php echo base_url('Logistik/simpanCartRKSJ')?>',
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
			success: function(res){
				data = JSON.parse(res)
				console.log(data)
				$(".card-body-rk").html('')
				$("#hidden-card-body-rk").load("<?php echo base_url('Logistik/destroyGudang') ?>")
				loadSJGudang()
				listRencanaKirim()
				swal.close()
			}
		})
	}
</script>
