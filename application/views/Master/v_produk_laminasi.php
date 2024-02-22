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
	
		<div class="row row-input" style="display:none">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header" style="font-family:Cambria;">
						<h3 class="card-title"><b>TAMBAH DATA PRODUK LAMINASI</b></h3>
					</div>
					<div class="card-body row" style="font-weight:bold;padding:18px 12px 12px">
						<div class="col-md-12">
							<button type="button" class="btn btn-sm btn-info" onclick="btnData('kembali')"><i class="fa fa-arrow-left"></i> <b>KEMBALI</b></button>
						</div>
					</div>
					<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
						<div class="col-md-1">NAMA</div>
						<div class="col-md-11">
							<input type="text" id="nama_lm" class="form-control" autocomplete="off" placeholder="NAMA" oninput="this.value=this.value.toUpperCase()">
						</div>
					</div>
					<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
						<div class="col-md-1">UKURAN</div>
						<div class="col-md-11">
							<input type="text" id="ukuran_lm" class="form-control" autocomplete="off" placeholder="UKURAN" oninput="this.value=this.value.toUpperCase()">
						</div>
					</div>
					<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
						<div class="col-md-1">ISI</div>
						<div class="col-md-11">
							<input type="number" id="isi_lm" class="form-control" autocomplete="off" placeholder="ISI">
						</div>
					</div>
					<div class="row-qty"></div>
					<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
						<div class="col-md-1"></div>
						<div class="col-md-2">
							<div class="input-group">
								<input type="number" id="qty_lm" class="form-control" autocomplete="" placeholder="0">
								<div class="input-group-append">
									<span class="input-group-text" style="font-weight:bold">PACK</span>
								</div>
							</div>
						</div>
						<div class="col-md-9"></div>
					</div>
					<div class="card-body row" style="font-weight:bold;padding:0 12px 18px">
						<div class="col-md-1"></div>
						<div class="col-md-11">
							<button type="button" class="btn btn-sm btn-primary" onclick="simpanDataLaminasi()"><i class="fa fa-save"></i> <b>SIMPAN</b></button>
						</div>
					</div>
					<input type="hidden" id="plh-qty" value="pack">
					<input type="hidden" id="h_id" value="">
				</div>
			</div>
		</div>

		<div class="row row-list">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header" style="font-family:Cambria;">
						<h3 class="card-title" style="color:#4e73df;"><b><?= $judul ?></b></h3>
						<div class="card-tools">
							<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fas fa-minus"></i></button>
						</div>
					</div>
					<div class="card-body">
						<?php if (in_array($this->session->userdata('level'), ['Admin','Laminasi'])) { ?>
							<button type="button" style="font-family:Cambria;" class="tambah_data btn btn-info pull-right" onclick="btnData('add')"><i class="fa fa-plus"></i>&nbsp;&nbsp;<b>Tambah Data</b></button>
							<br><br>
						<?php } ?>
						<div style="overflow:auto;white-space:nowrap">
							<table id="datatable" class="table table-bordered table-striped">
								<thead>
									<tr>
										<th style="text-align:center">#</th>
										<th style="text-align:center">NAMA</th>
										<th style="text-align:center">UKURAN</th>
										<th style="text-align:center">ISI</th>
										<th style="text-align:center">QTY</th>
										<th style="text-align:center">AKSI</th>
									</tr>
								</thead>
								<tbody></tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>

	</section>
</div>

<script type="text/javascript">
	let aksiInput = "insert"

	$(document).ready(function() {
		load_data();
		$('.select2').select2({
			dropdownAutoWidth: true
		});
	});

	function reloadTable() {
		table = $('#datatable').DataTable();
		tabel.ajax.reload(null, false);
	}

	function load_data() {
		var table = $('#datatable').DataTable();
		table.destroy();
		tabel = $('#datatable').DataTable({
			"processing": true,
			"pageLength": true,
			"paging": true,
			"ajax": {
				"url": '<?php echo base_url(); ?>Master/load_data/produk_laminasi',
				"type": "POST",
			},
			responsive: false,
			"pageLength": 10,
			"language": {
				"emptyTable": "Tidak ada data.."
			}
		});
	}

	function kosong()
	{
		aksiInput = "insert"
		$("#h_id").val("")
		$("#nama_lm").val("")
		$("#ukuran_lm").val("").prop('disabled', false)
		$("#isi_lm").val("").prop('disabled', false)
		$(".btn-pack").addClass('active')
		$(".btn-ikat").removeClass('focus active')
		$("#radio-pack").prop("checked")
		$("#radio-ikat").prop("checked", false)
		$("#radio-kg").prop("checked", false)
		$("#plh-qty").val("pack")
		$(".input-group-text").html("PACK")
		$("#qty_lm").val("").prop('disabled', false)
		$(".row-qty").html(`<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
			<div class="col-md-1">QTY</div>
			<div class="col-md-11">
				<div class="btn-group btn-group-toggle" data-toggle="buttons">
					<label class="btn btn-xs btn-secondary btn-pack active">
						<input type="radio" name="radio" id="radio-pack" autocomplete="off" checked onclick="plhQty('pack')"> PACK
					</label>
					<label class="btn btn-xs btn-secondary btn-ikat">
						<input type="radio" name="radio" id="radio-ikat" autocomplete="off" onclick="plhQty('ikat')"> IKAT
					</label>
					<label class="btn btn-xs btn-secondary btn-kg">
						<input type="radio" name="radio" id="radio-kg" autocomplete="off" onclick="plhQty('kg')"> KG
					</label>
				</div>
			</div>
		</div>`)
		reloadTable()
		swal.close()
	}

	function btnData(opsi)
	{
		kosong()
		if(opsi == 'add'){
			$(".row-input").attr('style', '')
			$(".row-list").attr('style', 'display:none')
		}else{
			$(".row-input").attr('style', 'display:none')
			$(".row-list").attr('style', '')
		}
	}

	function plhQty(aksi)
	{
		(aksi == 'kg') ? $("#ukuran_lm").val("").prop('disabled', true) : $("#ukuran_lm").prop('disabled', false);
		(aksi == 'kg') ? $("#isi_lm").val("").prop('disabled', true) : $("#isi_lm").prop('disabled', false);

		$("#plh-qty").val(aksi)
		$("#qty_lm").val("")
		$(".input-group-text").html(aksi.toUpperCase())
	}

	function simpanDataLaminasi()
	{
		let h_id = $("#h_id").val()
		let nama_lm = $("#nama_lm").val()
		let ukuran_lm = $("#ukuran_lm").val()
		let isi_lm = $("#isi_lm").val()
		let plh_qty = $("#plh-qty").val()
		let qty_lm = $("#qty_lm").val()
		$.ajax({
			url: '<?php echo base_url('Master/simpanDataLaminasi')?>',
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
			data: ({
				h_id, nama_lm, ukuran_lm, isi_lm, plh_qty, qty_lm, aksiInput
			}),
			success: function(res){
				data = JSON.parse(res)
				// console.log(data)
				if(data.insert){
					$(".row-input").attr('style', 'display:none')
					$(".row-list").attr('style', '')
					kosong()
				}else{
					toastr.error(`<b>${data.msg}</b>`)
					swal.close()
				}
			}
		})
	}

	function editDataLaminasi(id)
	{
		$(".row-input").attr('style', '')
		$(".row-list").attr('style', 'display:none')
		$.ajax({
			url: '<?php echo base_url('Master/editDataLaminasi')?>',
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
			data: ({
				id
			}),
			success: function(res){
				data = JSON.parse(res)
				// console.log(data)
				aksiInput = "update"
				$("#h_id").val(data.produk.id_produk_lm)
				$("#nama_lm").val(data.produk.nm_produk_lm)
				$("#ukuran_lm").val(data.produk.ukuran_lm).prop('disabled', (data.produk.jenis_qty_lm == 'kg') ? true : false)
				$("#isi_lm").val(data.produk.isi_lm).prop('disabled', (data.cek == 1 || data.produk.jenis_qty_lm == 'kg') ? true : false)
				$("#plh-qty").val(data.produk.jenis_qty_lm);
				let qty = 0
				if(data.produk.jenis_qty_lm == 'pack'){
					qty = data.produk.pack_lm
				}else if(data.produk.jenis_qty_lm == 'ikat'){
					qty = data.produk.ikat_lm
				}else{
					qty = data.produk.kg_lm
				}
				$("#qty_lm").val(qty).prop('disabled', (data.cek == 1) ? true : false);				
				if(data.cek == 1){
					$(".row-qty").html("").attr('style', 'padding:0')
				}else{
					$(".row-qty").html(`<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
						<div class="col-md-1">QTY</div>
						<div class="col-md-11">
							<div class="btn-group btn-group-toggle" data-toggle="buttons">
								<label class="btn btn-xs btn-secondary btn-pack active">
									<input type="radio" name="radio" id="radio-pack" autocomplete="off" checked onclick="plhQty('pack')"> PACK
								</label>
								<label class="btn btn-xs btn-secondary btn-ikat">
									<input type="radio" name="radio" id="radio-ikat" autocomplete="off" onclick="plhQty('ikat')"> IKAT
								</label>
								<label class="btn btn-xs btn-secondary btn-kg">
									<input type="radio" name="radio" id="radio-kg" autocomplete="off" onclick="plhQty('kg')"> KG
								</label>
							</div>
						</div>
					</div>`)
				}
				if(data.produk.jenis_qty_lm == 'pack'){
					$(".btn-pack").addClass('focus active')
					$(".btn-kg").removeClass('focus active')
					$(".btn-ikat").removeClass('focus active')
					$("#radio-ikat").prop("checked", false)
					$("#radio-kg").prop("checked", false)
					$("#radio-pack").prop("checked")
				}else if(data.produk.jenis_qty_lm == 'ikat'){
					$(".btn-pack").removeClass('focus active')
					$(".btn-kg").removeClass('focus active')
					$(".btn-ikat").addClass('focus active')
					$("#radio-pack").prop("checked", false)
					$("#radio-kg").prop("checked", false)
					$("#radio-ikat").prop("checked")
				}else{
					$(".btn-pack").removeClass('focus active')
					$(".btn-ikat").removeClass('focus active')
					$(".btn-kg").addClass('focus active')
					$("#radio-pack").prop("checked", false)
					$("#radio-ikat").prop("checked", false)
					$("#radio-kg").prop("checked")
				}
				$(".input-group-text").html(data.produk.jenis_qty_lm.toUpperCase())
				swal.close()
			}
		})
	}

	function hapusDataLaminasi(id)
	{
		swal({
			title : "PO Laminasi",
			html : "<p>Hapus List?</p>",
			type : "question",
			showCancelButton : true,
			confirmButtonText : '<b>Hapus</b>',
			cancelButtonText : '<b>Batal</b>',
			confirmButtonClass : 'btn btn-success',
			cancelButtonClass : 'btn btn-danger',
			cancelButtonColor : '#d33'
		}).then(() => {
			$.ajax({
				url: '<?= base_url(); ?>Master/hapus',
				data: ({
					id : id,
					jenis : 'm_produk_lm',
					field : 'id_produk_lm'
				}),
				type: "POST",
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
				success: function(data) {
					// console.log(data)
					// swal.close()
					kosong()
				},
			});
		});
	}

</script>
