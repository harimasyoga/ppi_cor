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
		<div class="container-fluid">

			<div class="row row-list-debit-note">
				<div class="col-md-12">
					<div class="card shadow mb-3">
						<div class="card-header" style="font-family:Cambria;">
							<h3 class="card-title" style="color:#4e73df;"><b>INVOICE JASA</b></h3>
							<div class="card-tools">
								<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
									<i class="fas fa-minus"></i>
								</button>
							</div>
						</div>
						<div class="card-body">
							<?php if(in_array($this->session->userdata('level'), ['Admin', 'Admin2'])){ ?>
								<div style="margin-bottom:12px">
									<button type="button" class="btn btn-sm btn-info" onclick="tambahData()"><i class="fa fa-plus"></i> <b>TAMBAH DATA</b></button>
								</div>
							<?php } ?>
							<div style="overflow:auto;white-space:nowrap">
								<table id="datatable" class="table table-bordered table-striped">
									<thead class="color-tabel">
										<tr>
											<th style="padding:12px;text-align:center">NO.</th>
											<th style="padding:12px 150px;text-align:center">DESKRIPSI</th>
											<th style="padding:12px;text-align:center">TGL INV</th>
											<th style="padding:12px;text-align:center">JATUH TEMPO</th>
											<th style="padding:12px;text-align:center">ADMIN</th>
											<th style="padding:12px;text-align:center">OWNER</th>
											<th style="padding:12px;text-align:center">TOTAL</th>
											<th style="padding:12px;text-align:center">CETAK</th>
											<th style="padding:12px;text-align:center">AKSI</th>
										</tr>
									</thead>
									<tbody></tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="row row-input-debit-note">
				<div class="col-md-6">
					<div class="card card-success card-outline">
						<div class="card-header" style="padding:12px">
							<h3 class="card-title" style="font-weight:bold;font-size:18px">INPUT DEBIT NOTE</h3>
						</div>
						<div style="margin:12px 6px;display:flex">
							<button type="button" class="btn btn-sm btn-info" onclick="kembali()"><i class="fa fa-arrow-left"></i> <b>KEMBALI</b></button><div id="btn-header" style="margin-left:6px"></div>
						</div>
						<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
							<div class="col-md-3">TANGGAL</div>
							<div class="col-md-9">
								<input type="hidden" id="h_id_header" value="">
								<input type="date" id="tgl_debit_note" class="form-control" value="<?= date('Y-m-d')?>">
							</div>
						</div>
						<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
							<div class="col-md-3">TRANSAKSI</div>
							<div class="col-md-9">
								<select id="transaksi" class="form-control select2">
									<option value="">PILIH</option>
									<option value="CORRUGATED">CORRUGATED</option>
									<option value="LAMINASI">LAMINASI</option>
								</select>
							</div>
						</div>
						<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
							<div class="col-md-3">NO. DEBIT NOTE</div>
							<div class="col-md-9">
								<input type="text" id="no_debit_note" class="form-control" style="font-weight:bold" value="AUTO" disabled>
							</div>
						</div>
						<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
							<div class="col-md-3">KETENTUAN</div>
							<div class="col-md-9">
								<input type="text" id="ketentuan" class="form-control" placeholder="-" oninput="this.value=this.value.toUpperCase()">
							</div>
						</div>
						<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
							<div class="col-md-3">JATUH TEMPO</div>
							<div class="col-md-9">
								<input type="date" id="tgl_jatuh_tempo" class="form-control">
							</div>
						</div>
						<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
							<div class="col-md-3">PO #</div>
							<div class="col-md-9">
								<input type="text" id="no_po" class="form-control" placeholder="-" oninput="this.value=this.value.toUpperCase()">
							</div>
						</div>
						<div class="card-body row" style="font-weight:bold;padding:0 12px 16px">
							<div class="col-md-3">TAGIH KE</div>
							<div class="col-md-9">
								<select id="tagih_ke" class="form-control select2">
									<?php
										$query = $this->db->query("SELECT*FROM m_hub WHERE id_hub!='7' ORDER BY nm_hub");
										$html ='';
										$html .='<option value="">PILIH</option>';
										foreach($query->result() as $r){
											$html .='<option value="'.$r->id_hub.'">CV. '.$r->nm_hub.'</option>';
										}
										echo $html
									?>
								</select>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="card card-info card-outline">
						<div class="card-header" style="padding:12px">
							<h3 class="card-title" style="font-weight:bold;font-size:18px">INPUT ITEM</h3>
						</div>
						<div class="card-body row" style="font-weight:bold;padding:16px 12px 6px">
							<div class="col-md-3">DESKRIPSI</div>
							<div class="col-md-9">
								<textarea id="i_deskripsi" rows="3" class="form-control" style="resize:none" placeholder="-" oninput="this.value=this.value.toUpperCase()"></textarea>
							</div>
						</div>
						<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
							<div class="col-md-3">QTY</div>
							<div class="col-md-9">
								<input type="number" id="i_qty" class="form-control" placeholder="0" onkeyup="onKeyUpDN()">
							</div>
						</div>
						<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
							<div class="col-md-3">HARGA</div>
							<div class="col-md-9">
								<input type="text" id="i_harga" class="form-control" placeholder="0" onkeyup="onKeyUpDN()">
							</div>
						</div>
						<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
							<div class="col-md-3">TOTAL</div>
							<div class="col-md-9">
								<input type="text" id="i_total" class="form-control" style="font-weight:bold;color:#000" placeholder="0" disabled>
							</div>
						</div>
						<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
							<div class="col-md-3"></div>
							<div class="col-md-9">
								<div id="button_aksi"></div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="row row-item-debit-note">
				<div class="col-md-12">
					<div class="card card-secondary card-outline">
						<div class="card-header" style="padding:12px">
							<h3 class="card-title" style="font-weight:bold;font-size:18px">LIST ITEM</h3>
						</div>
						<div class="card-body" style="padding:6px">
							<input type="hidden" id="hide_destroy_dn">
							<div style="overflow:auto;white-space:nowrap">
								<div class="list-item">LIST ITEM KOSONG!</div>
							</div>
						</div>
					</div>
				</div>
			</div>

		</div>
	</section>
</div>

<script type="text/javascript">
	let statusInput = 'insert';
	const urlAuth = '<?= $this->session->userdata('level')?>';
	const urlUser = '<?= $this->session->userdata('username')?>';

	$(document).ready(function ()
	{
		$("#hide_destroy_dn").load("<?php echo base_url('Logistik/destroyDebitNote') ?>")
		kosong()
		// load_data()
		$('.select2').select2();
	});

	// function reloadTable() {
	// 	table = $('#datatable').DataTable();
	// 	tabel.ajax.reload(null, false);
	// }

	// function load_data() {
	// 	let tahun = $("#tahun").val()
	// 	let jenis = $("#jenis").val()
	// 	let hub = $("#hub").val()
	// 	let table = $('#datatable').DataTable();
	// 	table.destroy();
	// 	tabel = $('#datatable').DataTable({
	// 		"processing": true,
	// 		"pageLength": true,
	// 		"paging": true,
	// 		"ajax": {
	// 			"url": '<?php echo base_url('Logistik/load_data/loadDataInvoiceJasa')?>',
	// 			"type": "POST",
	// 			"data": ({
	// 				tahun, jenis, hub
	// 			}),
	// 		},
	// 		"aLengthMenu": [
	// 			[5, 10, 50, 100, -1],
	// 			[5, 10, 50, 100, "Semua"]
	// 		],	
	// 		responsive: false,
	// 		"pageLength": 10,
	// 		"language": {
	// 			"emptyTable": "TIDAK ADA DATA.."
	// 		}
	// 	})
	// }

	function kosong()
	{
		let tanggal = '<?= date("Y-m-d")?>'
		$("#tgl_debit_note").val(tanggal).prop('disabled', false)
		$("#transaksi").val("").trigger("change").prop('disabled', false)
		$("#ketentuan").val("").prop('disabled', false)
		$("#tgl_jatuh_tempo").val("").prop('disabled', false)
		$("#no_po").val("").prop('disabled', false)
		$("#tagih_ke").val("").trigger("change").prop('disabled', false)
		$("#i_deskripsi").val("").prop('disabled', false)
		$("#i_qty").val("").prop('disabled', false)
		$("#i_harga").val("").prop('disabled', false)
		$("#i_total").val("").prop('disabled', true)

		$("#button_aksi").html('<button type="button" class="btn btn-sm btn-success" style="font-weight:bold" onclick="tambahDataDN()"><i class="fas fa-plus"></i> TAMBAH</button>	')
		statusInput = 'insert'
		swal.close()
	}

	function tambahData() {
		kosong()
	}

	function kembali() {
		kosong()
		// reloadTable()
	}

	function onKeyUpDN()
	{
		let qty = $("#i_qty").val();
		(qty < 0) ? qty = 0 : qty = qty
		$("#i_qty").val(qty)
		console.log("qty : ", qty)
		let harga = $("#i_harga").val().split('.').join('')
		$("#i_harga").val(format_angka(harga))
		console.log("harga : ", harga)
		let total = $("#i_total").val().split('.').join('')
		console.log("total : ", total)
		let hitung = parseInt(qty) * parseInt(harga);
		(isNaN(hitung) || hitung == "" || hitung == 0) ? hitung = 0 : hitung = hitung
		$("#i_total").val(format_angka(hitung))
		console.log("hitung : ", hitung)
	}

	function tambahDataDN()
	{
		let tgl_debit_note = $("#tgl_debit_note").val()
		let transaksi = $("#transaksi").val()
		let ketentuan = $("#ketentuan").val()
		let tgl_jatuh_tempo = $("#tgl_jatuh_tempo").val()
		let no_po = $("#no_po").val()
		let tagih_ke = $("#tagih_ke").val()
		let deskripsi = $("#i_deskripsi").val()
		let qty = $("#i_qty").val().split('.').join('')
		let harga = $("#i_harga").val().split('.').join('')
		let total = $("#i_total").val().split('.').join('')
		$.ajax({
			url: '<?php echo base_url('Logistik/tambahDataDN')?>',
			type: "POST",
			data: ({
				tgl_debit_note, transaksi, ketentuan, tgl_jatuh_tempo, no_po, tagih_ke, deskripsi, qty, harga, total
			}),
			success: function(res){
				data = JSON.parse(res)
				console.log(data)
				if(data.data){
					$("#tgl_debit_note").prop('disabled', true)
					$("#transaksi").prop('disabled', true)
					$("#ketentuan").prop('disabled', true)
					$("#tgl_jatuh_tempo").prop('disabled', true)
					$("#no_po").prop('disabled', true)
					$("#tagih_ke").prop('disabled', true)
					$("#i_deskripsi").val("")
					$("#i_qty").val("")
					$("#i_harga").val("")
					$("#i_total").val("").prop('disabled', true)
					listItemDebitNote()
				}
			}
		})
	}

	function listItemDebitNote() {
		$.ajax({
			url: '<?php echo base_url('Logistik/listItemDebitNote')?>',
			type: "POST",
			success: function(res){
				$(".list-item").html(res)
			}
		})
	}

	function hapusCartDN(rowid){
		$.ajax({
			url: '<?php echo base_url('Logistik/hapusCartDN')?>',
			type: "POST",
			data: ({ rowid }),
			success: function(res){
				listItemDebitNote()
			}
		})
	}
</script>
