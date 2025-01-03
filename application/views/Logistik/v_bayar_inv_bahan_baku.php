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

	<div class="container-fluid row-input" style="display: none;">
		<form role="form" method="post" id="myForm">
			<div class="row">
				<div class="col-md-12">
					<div class="card card-info card-outline">
						<div class="card-header" style="padding:12px">
							<h3 class="card-title" style="font-weight:bold;font-size:18px">Input Pembayaran</h3>
						</div>
						
						<div class="card-body row" style="padding-bottom:1px;font-weight:bold">						
							<div class="col-md-2">No Pembayaran</div>
							<div class="col-md-3">
								<input type="hidden" name="id_header_bayar" id="id_header_bayar">

								<input type="text" class="angka form-control" name="no_bayar_bhn" id="no_bayar_bhn" value="AUTO" readonly>
							</div>
							<div class="col-md-1"></div>
							<div class="col-md-2">Total Bayar</div>
							<div class="col-md-3">
								<div class="input-group mb-1">
									<div class="input-group-append">
										<span class="input-group-text"><b>Rp</b>
										</span>
									</div>	
									<input type="text" class="angka form-control" name="total_byr" id="total_byr" readonly>
										
								</div>
							</div>

						</div>
						
						<div class="card-body row" style="padding-bottom:1px;font-weight:bold">			
							<div class="col-md-2">Tanggal Bayar</div>
							<div class="col-md-3">
								<input type="date" name="tgl_byr" id="tgl_byr" class="form-control" value="<?= date('Y-m-d') ?>" >
							</div>
							<div class="col-md-1"></div>

							<div class="col-md-2">History bayar</div>
							<div class="col-md-3">
								<div class="input-group mb-3">
									<div class="input-group-append">
										<span class="input-group-text"><b>Rp</b></span>
									</div>
									<input style="text-align: right;font-weight: bold;"  type="text" name="history_byr" id="history_byr" class="form-control" readonly> 
								</div>
							</div>
						</div>
						
						<div class="card-body row" style="padding-bottom:1px;font-weight:bold">			
						<div class="col-md-2">ATTN</div>
							<div class="col-md-3">
								<select class="form-control select2" name="id_hub" id="id_hub" style="width: 100%;" >
								</select>
							</div>
							<div class="col-md-1"></div>

							<div class="col-md-2">Kurang bayar</div>
							<div class="col-md-3">
								
								<div class="input-group mb-3">
									<div class="input-group-append">
										<span class="input-group-text"><b>Rp</b></span>
									</div>
									<input style="text-align: right;font-weight: bold;"  type="text" name="krg_byr" id="krg_byr" class="form-control" readonly> 
								</div>
							</div>
						</div>
						
						<div class="card-body row" style="padding-bottom:1px;font-weight:bold">			
							<div class="col-md-2">Jenis Produk</div>
							<div class="col-md-3">
								<input type="text" name="jns_prod" id="jns_prod" class="form-control" value="AUTO" readonly>
							</div>
							
							<div class="col-md-1"></div>
							<div class="col-md-2">Jumlah bayar</div>
							<div class="col-md-3">
								<div class="input-group mb-3">
									<div class="input-group-append">
										<span class="input-group-text"><b>Rp</b></span>
									</div>
									<input style="text-align: right;font-weight: bold; color:#ff5733;"   type="text" name="jml_byr" id="jml_byr" class="form-control" value="" onkeyup="ubah_angka(this.value,this.id)" > 
								</div>
							</div>
							
						</div>
						
						<div class="card-body row" style="padding-bottom:1px;font-weight:bold">			
							<div class="col-md-2">Jenis Bayar</div>
							<div class="col-md-3">
								<select name="jns_byr" id="jns_byr" class="form-control select2">
									<option value="">-- PILIH --</option>
									<option value="tf">TRANSFER</option>
									<option value="tunai">CEK / TUNAI</option>
								</select>
							</div>
							
							<div class="col-md-6"></div>
						</div>
									
						<br>
						
						
						<div class="card-body row"style="font-weight:bold">
							<div class="col-md-4">
								<button type="button" onclick="kembaliList()" class="btn-tambah-produk btn  btn-danger"><b>
									<i class="fa fa-undo" ></i> Kembali</b>
								</button>
								<span id="btn-simpan"></span>
							</div>
							<div class="col-md-6"></div>
							
						</div>

						<br>
					</div>
				</div>
			</div>
		</form>	
	</div>

	<section class="content">
		<div class="card shadow mb-3">
			<div class="row-list">
				<div class="card-header" style="font-family:Cambria;">		
						<h3 class="card-title" style="color:#4e73df;"><b><?= $judul ?>&nbsp;
						</b>  </h3>
						<i style="color:#4e73df;" class="fas fa-info-circle" title="PEMBAYARAN SELAIN DEBIT NOTE"></i>

						<div class="card-tools">
							<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
								<i class="fas fa-minus"></i></button>
						</div>
				</div>
				<div class="card-body" >
					<?php if(in_array($this->session->userdata('level'), ['Admin','Laminasi','Keuangan1','Pembayaran'])){ ?>
						<div style="margin-bottom:12px">
							<button type="button" class="btn btn-sm btn-info" onclick="add_data()"><i class="fa fa-plus"></i> <b>TAMBAH DATA</b></button>
						</div>
					<?php } ?>
					<div style="overflow:auto;white-space:nowrap;" >
						<table id="datatable" class="table table-bordered table-striped table-scrollable" width="100%"> 
							<thead class="color-tabel">
								<tr>
									<th class="text-center title-white">NO</th>
									<th class="text-center title-white">Invoice</th>
									<th class="text-center title-white">TGL BAYAR</th>
									<th class="text-center title-white">TOTAL INV</th>
									<th class="text-center title-white">TOTAL BAYAR</th>
									<th class="text-center title-white">ACC OWNER</th>
									<th class="text-center title-white">AKSI</th>
								</tr>
							</thead>
							<tbody></tbody>
						</table>
					</div>
				</div>
			</div>			
		</div>
	</section>
</div>

<script type="text/javascript">
	let statusInput = 'insert';
	const urlAuth = '<?= $this->session->userdata('level')?>';

	$(document).ready(function ()
	{
		kosong()
		load_data()
		load_hub_bhn()
		load_supp()
		$('.select2').select2();
	});

	function reloadTable() 
	{
		table = $('#datatable').DataTable();
		tabel.ajax.reload(null, false);
	}

	function load_data() 
	{
		let table = $('#datatable').DataTable();
		table.destroy();
		tabel = $('#datatable').DataTable({
			"processing": true,
			"pageLength": true,
			"paging": true,
			"ajax": {
				"url": '<?php echo base_url('Logistik/load_data/byr_inv_beli')?>',
				"type": "POST",
			},
			"aLengthMenu": [
				[5, 10, 50, 100, -1],
				[5, 10, 50, 100, "Semua"]
			],	
			responsive: false,
			"pageLength": 10,
			"language": {
				"emptyTable": "TIDAK ADA DATA.."
			}
		})
	}

	function load_hub_bhn() 
	{
		option = "";
		$.ajax({
			type       : 'POST',
			url        : "<?= base_url(); ?>Logistik/load_hub_bhn",
			// data       : { idp: pelanggan, kd: '' },
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
					option = `<option value="">-- Pilih --</option>`;	

					$.each(data.data, function(index, val) {
					option += "<option value='"+val.id_hub+"'>"+val.nm_hub+"</option>";
					});

					$('#id_hub').html(option);
					swal.close();
				}else{	
					option += "<option value=''></option>";
					$('#id_hub').html(option);					
					swal.close();
				}
			}
		});
		
	}

	function hitung_total()
	{
		// var diskon        = $("#diskon").val()
		// diskon_ok         = (diskon=='' || isNaN(diskon) || diskon == null) ? '0' : diskon;
		// var disk_total    = parseInt(diskon_ok.split('.').join(''))
		// var pajak         = $("#pajak").val()
		
		// var total_nominal = 0
		// for(loop = 0; loop <= rowNum; loop++)
		// {
		// 	var nom = $("#nominal"+loop).val()
		// 	if(nom=='')
		// 	{
		// 		nom1 = 0;
		// 	}else{
		// 		nom1 = nom;
		// 	}
		// 	var nominal   = parseInt(nom1.split('.').join(''))
		// 	total_nominal += nominal
		// }		
		// total_nominal_ok = (total_nominal=='' || isNaN(total_nominal) || total_nominal == null) ? 0 : total_nominal
		
		// if(pajak=='PPN')
		// {
		// 	var ppn_total    = (total_nominal_ok *0.11).toFixed(0);
		// 	var pph_total    = 0
		// }else if(pajak=='PPN_PPH')
		// {
		// 	var ppn_total   = (total_nominal_ok *0.11).toFixed(0);
		// 	var pph_total   = (total_nominal_ok *0.02).toFixed(0);
		// }else{
		// 	var ppn_total   = 0
		// 	var pph_total   = 0
		// }
		
		// var total_all     = parseInt(total_nominal_ok)-parseInt(disk_total)+parseInt(ppn_total)-parseInt(pph_total)

		// $("#total_nom").val(format_angka(total_nominal_ok))		
		// $("#disk_total").val(format_angka(disk_total))
		// $("#pajak_total").val(format_angka(ppn_total))
		// $("#pph_total").val(format_angka(pph_total))
		// $("#total_all").val(format_angka(total_all))
		
	}
	
	function load_supp() 
	{
		option = "";
		$.ajax({
			type       : 'POST',
			url        : "<?= base_url(); ?>Logistik/load_supp",
			// data       : { idp: pelanggan, kd: '' },
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
					option = `<option value="">-- Pilih --</option>`;	

					$.each(data.data, function(index, val) {
					option += "<option value='"+val.id_supp+"'>"+val.nm_supp+"</option>";
					});

					$('#id_supp').html(option);
					swal.close();
				}else{	
					option += "<option value=''></option>";
					$('#id_supp').html(option);					
					swal.close();
				}
			}
		});
		
	}
	
	function load_invoice()
	{
		var blnn    = $('#rentang_bulan').val();
		var table   = $('#tbl_inv').DataTable();
		table.destroy();
		tabel = $('#tbl_inv').DataTable({
			"processing": true,
			"pageLength": true,
			"paging": true,
			"ajax": {
				"url"   : '<?php echo base_url('Logistik/load_invoice/byr_inv_beli')?>',
				"type"  : "POST",
				"data"  : ({blnn:blnn}),
			},
			"aLengthMenu": [
				[5, 10, 50, 100, -1],
				[5, 10, 50, 100, "Semua"]
			],	
			responsive: false,
			"pageLength": 10,
			"language": {
				"emptyTable": "TIDAK ADA DATA.."
			}
		})
	}
	
	function edit_data(id,no_inv)
	{
		$(".row-input").attr('style', '');
		$(".row-list").attr('style', 'display:none');
		$("#sts_input").val('edit');

		$("#btn-simpan").html(`<button type="button" onclick="simpan()" class="btn-tambah-produk btn  btn-primary"><b><i class="fa fa-save" ></i> Update</b> </button>`)

		$.ajax({
			url        : '<?= base_url(); ?>Logistik/load_data_1',
			type       : "POST",
			data       : { id, no:no_inv, jenis:'byr_invoice_beli' },
			dataType   : "JSON",
			beforeSend: function() {
				swal({
				title: 'loading data...',
				allowEscapeKey    : false,
				allowOutsideClick : false,
				onOpen: () => {
					swal.showLoading();
				}
				})
			},
			success: function(data) {
				// console.log(data)
				if(data){
					
					$('.list_inv').modal('hide');

					// header
					$("#id_byr_inv").val(data.header.id_byr_inv);
					$("#id_header_beli").val(data.header.id_header_beli);
					$("#no_inv_beli").val(data.header.no_inv_beli);
					$("#tgl_inv").val(data.header.tgl_inv_beli);
					$("#tgl_byr").val(data.header.tgl_bayar);
					$("#jml_byr").val(format_angka(data.header.jumlah_bayar));
					$("#diskon").val(data.header.diskon);
					$("#ket").val(data.header.ket);
					$("#id_supp").val(data.header.id_supp).trigger('change');
					$("#id_hub").val(data.header.id_hub).trigger('change');
					$("#pajak").val(data.header.pajak).trigger('change');

					// detail
				
					var list = `
					<table id="datatable_input" class="table">
						<thead class="color-tabel">
							<th style="text-align: center" >No</th>
							<th style="text-align: center" >Transaksi</th>
							<th style="text-align: center; padding-right: 35px" >Jenis Beban</th>
							<th style="text-align: center; padding-right: 35px">Nominal</th>
							
						</thead>`;
					var no            = 1;
					var total_nominal = 0
					$.each(data.detail, function(index, val) {
						

						// total invoice
						var total_invo = val.harga*val.hasil; 

						list += `
						<tbody>
							<td id="no_urut${no}" name="no_urut[${no}]" style="text-align: center" >${no}
							
							</td>

							<td style="text-align: LEFT" >${val.transaksi}
							</td>
							
							<td style="text-align: LEFT" >${val.nm}
							</td>

							<td style="text-align: RIGHT" >${format_angka(val.nominal)}
							</td>

						</tbody>`;
						total_nominal   += parseInt(val.nominal)

						no ++;
					})


					var diskon        = data.header.diskon
					diskon_ok         = (diskon=='' || isNaN(diskon) || diskon == null) ? '0' : diskon;
					var pajak         = data.header.pajak					
					
					total_nominal_ok = (total_nominal=='' || isNaN(total_nominal) || total_nominal == null) ? 0 : total_nominal
					
					if(pajak=='PPN')
					{
						var ppn_total    = (total_nominal_ok *0.11).toFixed(0);
						var pph_total    = 0
					}else if(pajak=='PPN_PPH')
					{
						var ppn_total   = (total_nominal_ok *0.11).toFixed(0);
						var pph_total   = (total_nominal_ok *0.02).toFixed(0);
					}else{
						var ppn_total   = 0
						var pph_total   = 0
					}
					
					var total_all     = parseInt(total_nominal_ok)-parseInt(diskon_ok)+parseInt(ppn_total)-parseInt(pph_total)
					
					

					list += `
					<tr>
					<td style="text-align: RIGHT;color:#d90002;background: #e9ecef;" colspan="3">SUB TOTAL
							</td>
							<td id="qty" style="text-align: right;color:#d90002;background: #e9ecef;" >${format_angka(total_nominal_ok)}
							</td>
					</tr>`;
					
					list += `
					<tr>
					<td style="text-align: RIGHT;color:#d90002;background: #e9ecef;" colspan="3">DISKON
							</td>
							<td id="qty" style="text-align: right;color:#d90002;background: #e9ecef;" >${format_angka(diskon_ok)}
							</td>
					</tr>`;

					list +=`
					<tr>
					<td style="text-align: RIGHT;color:#d90002;background: #e9ecef;" colspan="3">PPN
					</td>
					<td id="qty" style="text-align: right;color:#d90002;background: #e9ecef;" >${format_angka(ppn_total)}
					</td>
					</tr>`;
					
					list +=`						
					<tr>
					<td style="text-align: RIGHT;color:#d90002;background: #e9ecef;" colspan="3">PPH
					</td>
					<td id="qty" style="text-align: right;color:#d90002;background: #e9ecef;" >${format_angka(pph_total)}
					</td>
					</tr>`;
					
					list += `
					<tr><td style="text-align: RIGHT;color:#d90002;background: #e9ecef;" colspan="3">TOTAL
					</td>
					<td id="qty" style="text-align: right;color:#d90002;background: #e9ecef;" >${format_angka(total_all)}
					</td>
					</tr>`;
					list += `</table>`;
					swal.close();
					
					$("#total_inv").val(format_angka(total_all));
					$("#history_byr").val(format_angka(data.header.jum_bayar-data.header.jumlah_bayar));
					hitung_kurang()
					$("#data_list").html(list);
					swal.close();

				} else {

					swal.close();
					swal({
						title               : "Cek Kembali",
						html                : "Gagal Simpan",
						type                : "error",
						confirmButtonText   : "OK"
					});
					return;
				}
			},
			error: function(jqXHR, textStatus, errorThrown) {
				// toastr.error('Terjadi Kesalahan');
				
				swal.close();
				swal({
					title               : "Cek Kembali",
					html                : "Terjadi Kesalahan",
					type                : "error",
					confirmButtonText   : "OK"
				});
				
				return;
			}
		});
	}

	function spilldata(id,no_inv)
	{
		
		$.ajax({
			url        : '<?= base_url(); ?>Logistik/load_data_1',
			type       : "POST",
			data       : { id, no:no_inv, jenis:'spill_inv_beli' },
			dataType   : "JSON",
			beforeSend: function() {
				swal({
				title: 'loading data...',
				allowEscapeKey    : false,
				allowOutsideClick : false,
				onOpen: () => {
					swal.showLoading();
				}
				})
			},
			success: function(data) {
				// console.log(data)
				if(data){
					$('.list_inv').modal('hide');
					// header
					
					$("#id_header_beli").val(data.header.id_header_beli);
					$("#no_inv_beli").val(data.header.no_inv_beli);
					$("#tgl_inv").val(data.header.tgl_inv_beli);
					$("#diskon").val(data.header.diskon);
					$("#ket").val(data.header.ket);
					$("#id_supp").val(data.header.id_supp).trigger('change');
					$("#id_hub").val(data.header.id_hub).trigger('change');
					$("#pajak").val(data.header.pajak).trigger('change');

					// detail
				
					var list = `
					<table id="datatable_input" class="table">
						<thead class="color-tabel">
							<th style="text-align: center" >No</th>
							<th style="text-align: center" >Transaksi</th>
							<th style="text-align: center; padding-right: 35px" >Jenis Beban</th>
							<th style="text-align: center; padding-right: 35px">Nominal</th>
							
						</thead>`;
					var no            = 1;
					var total_nominal = 0
					$.each(data.detail, function(index, val) {
						

						// total invoice
						var total_invo = val.harga*val.hasil; 

						list += `
						<tbody>
							<td id="no_urut${no}" name="no_urut[${no}]" style="text-align: center" >${no}
							
							</td>

							<td style="text-align: LEFT" >${val.transaksi}
							</td>
							
							<td style="text-align: LEFT" >${val.nm}
							</td>

							<td style="text-align: RIGHT" >${format_angka(val.nominal)}
							</td>

						</tbody>`;
						total_nominal   += parseInt(val.nominal)

						no ++;
					})


					var diskon        = data.header.diskon
					diskon_ok         = (diskon=='' || isNaN(diskon) || diskon == null) ? '0' : diskon;
					var pajak         = data.header.pajak					
					
					total_nominal_ok = (total_nominal=='' || isNaN(total_nominal) || total_nominal == null) ? 0 : total_nominal
					
					if(pajak=='PPN')
					{
						var ppn_total    = (total_nominal_ok *0.11).toFixed(0);
						var pph_total    = 0
					}else if(pajak=='PPN_PPH')
					{
						var ppn_total   = (total_nominal_ok *0.11).toFixed(0);
						var pph_total   = (total_nominal_ok *0.02).toFixed(0);
					}else{
						var ppn_total   = 0
						var pph_total   = 0
					}
					
					var total_all     = parseInt(total_nominal_ok)-parseInt(diskon_ok)+parseInt(ppn_total)-parseInt(pph_total)
					
					

					list += `
					<tr>
					<td style="text-align: RIGHT;color:#d90002;background: #e9ecef;" colspan="3">SUB TOTAL
							</td>
							<td id="qty" style="text-align: right;color:#d90002;background: #e9ecef;" >${format_angka(total_nominal_ok)}
							</td>
					</tr>`;
					
					list += `
					<tr>
					<td style="text-align: RIGHT;color:#d90002;background: #e9ecef;" colspan="3">DISKON
							</td>
							<td id="qty" style="text-align: right;color:#d90002;background: #e9ecef;" >${format_angka(diskon_ok)}
							</td>
					</tr>`;

					list +=`
					<tr>
					<td style="text-align: RIGHT;color:#d90002;background: #e9ecef;" colspan="3">PPN
					</td>
					<td id="qty" style="text-align: right;color:#d90002;background: #e9ecef;" >${format_angka(ppn_total)}
					</td>
					</tr>`;
					
					list +=`						
					<tr>
					<td style="text-align: RIGHT;color:#d90002;background: #e9ecef;" colspan="3">PPH
					</td>
					<td id="qty" style="text-align: right;color:#d90002;background: #e9ecef;" >${format_angka(pph_total)}
					</td>
					</tr>`;
					
					list += `
					<tr><td style="text-align: RIGHT;color:#d90002;background: #e9ecef;" colspan="3">TOTAL
					</td>
					<td id="qty" style="text-align: right;color:#d90002;background: #e9ecef;" >${format_angka(total_all)}
					</td>
					</tr>`;
					list += `</table>`;
					swal.close();
					
					$("#total_inv").val(format_angka(total_all));					
					$("#history_byr").val(format_angka(data.header.jum_bayar));
					$("#data_list").html(list);
					hitung_kurang()
					swal.close();

				} else {

					swal.close();
					swal({
						title               : "Cek Kembali",
						html                : "Gagal Simpan",
						type                : "error",
						confirmButtonText   : "OK"
					});
					return;
				}
			},
			error: function(jqXHR, textStatus, errorThrown) {
				// toastr.error('Terjadi Kesalahan');
				
				swal.close();
				swal({
					title               : "Cek Kembali",
					html                : "Terjadi Kesalahan",
					type                : "error",
					confirmButtonText   : "OK"
				});
				
				return;
			}
		});
	}

	function kosong()
	{
		statusInput = 'insert'
		$("#id_header_bayar").val("")
		$("#no_bayar_bhn").val("AUTO")
		$("#total_byr").val("")
		$("#tgl_byr").val("")
		$("#history_byr").val("")
		$("#id_hub").val("")
		$("#krg_byr").val("")
		$("#jns_prod").val("AUTO")
		$("#jml_byr").val("")
		$("#jns_byr").val("")

		$("#id_hub").val("").trigger('change')

		swal.close()
	}

	function hitung_kurang()
	{
		var total_inv       = $("#total_inv").val().split('.').join('')
		var history_byr     = $("#history_byr").val().split('.').join('')
		var jml_byr         = $("#jml_byr").val().split('.').join('')
		var kurang_bayar    = total_inv - history_byr - jml_byr
		if(kurang_bayar==0)
		{
			krg_byr = 0
		}else{
			krg_byr = kurang_bayar
		}		
		$("#krg_byr").val(format_angka(krg_byr))
		
	}

	function simpan() 
	{
		var tgl_byr         = $("#tgl_byr").val();
		var jml_byr         = $("#jml_byr").val();
		if (tgl_byr == '' || jml_byr=='' ||jml_byr==0 ) 
		{			
			swal.close();
			swal({
				title               : "Cek Kembali",
				html                : "Harap Lengkapi Form Dahulu",
				type                : "info",
				confirmButtonText   : "OK"
			});
			return;
		}

		$.ajax({
			url        : '<?= base_url(); ?>Logistik/Insert_byr_inv_beli',
			type       : "POST",
			data       : $('#myForm').serialize(),
			dataType   : "JSON",
			success: function(data) {
				if(data.status=='1'){
					// toastr.success('Berhasil Disimpan');
					// swal.close();
					swal({
						title               : "Data",
						html                : "Berhasil Disimpan",
						type                : "success",
						confirmButtonText   : "OK"
					});
					// location.href = "<?= base_url()?>Logistik/Invoice_edit?id="+data.id+"&no_inv="+no_inv_ok+"";					
					kosong();
					location.href = "<?= base_url()?>Logistik/bayar_inv_beli";
					// kembaliList();
					
				} else {
					// toastr.error('Gagal Simpan');
					swal.close();
					swal({
						title               : "Cek Kembali",
						html                : "Gagal Simpan",
						type                : "error",
						confirmButtonText   : "OK"
					});
					return;
				}
				reloadTable();
			},
			error: function(jqXHR, textStatus, errorThrown) {
				// toastr.error('Terjadi Kesalahan');
				
				swal.close();
				swal({
					title               : "Cek Kembali",
					html                : "Terjadi Kesalahan",
					type                : "error",
					confirmButtonText   : "OK"
				});
				
				return;
			}
		});

	}

	function add_data()
	{
		kosong()
		$(".row-input").attr('style', '')
		$(".row-list").attr('style', 'display:none')
		$("#sts_input").val('add');
		
		$("#btn-simpan").html(`<button type="button" onclick="simpan()" class="btn-tambah-produk btn  btn-primary"><b><i class="fa fa-save" ></i> Simpan</b> </button>`)
	}

	function kembaliList()
	{
		kosong()
		reloadTable()
		$(".row-input").attr('style', 'display:none')
		$(".row-list").attr('style', '')
	}

	function deleteData(id,no) 
	{
		// let cek = confirm("Apakah Anda Yakin?");
		swal({
			title: "HAPUS PEMBAYARAN",
			html: "<p> Apakah Anda yakin ingin menghapus file ini ?</p><br>"
			+"<strong>" +no+ " </strong> ",
			type               : "question",
			showCancelButton   : true,
			confirmButtonText  : '<b>Hapus</b>',
			cancelButtonText   : '<b>Batal</b>',
			confirmButtonClass : 'btn btn-success',
			cancelButtonClass  : 'btn btn-danger',
			cancelButtonColor  : '#d33'
		}).then(() => {

		// if (cek) {
			$.ajax({
				url: '<?= base_url(); ?>Logistik/hapus',
				data: ({
					id: id,
					jenis: 'byr_inv_beli',
					field: 'id_bayar_inv'
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
					toastr.success('Data Berhasil Di Hapus');
					swal.close();

					// swal({
					// 	title               : "Data",
					// 	html                : "Data Berhasil Di Hapus",
					// 	type                : "success",
					// 	confirmButtonText   : "OK"
					// });
					reloadTable();
					
					location.href = "<?= base_url()?>Logistik/bayar_inv_beli";
				},
				error: function(jqXHR, textStatus, errorThrown) {
					// toastr.error('Terjadi Kesalahan');
					swal({
						title               : "Cek Kembali",
						html                : "Terjadi Kesalahan",
						type                : "error",
						confirmButtonText   : "OK"
					});
					return;
				}
			});
		// }

		});


	}

	function acc_inv(id,status_owner) 
	{	
		var user        = "<?= $this->session->userdata('username')?>"
		var acc_owner   = status_owner
		// var acc_admin   = $('#modal_status_inv_admin').val()
		var id          = id
		
		if(user=='bumagda' || user=='developer')
		{
			acc = acc_owner
		}else{
			acc = acc_owner
		}

		// console.log(user)
		// console.log(acc)
		if (acc=='N')
		{
			var html = 'VERIFIKASI'
			var icon = '<i class="fas fa-check"></i>'
		}else{
			var html = 'BATAL VERIFIKASI'
			var icon = '<i class="fas fa-lock"></i>'
		}
		
		swal({
			title              : html,
			html               : "<p> Apakah Anda yakin ?</p><br>",
			type               : "question",
			showCancelButton   : true,
			confirmButtonText  : '<b>'+icon+' '+html+'</b>',
			cancelButtonText   : '<b><i class="fas fa-undo"></i> Batal</b>',
			confirmButtonClass : 'btn btn-success',
			cancelButtonClass  : 'btn btn-danger',
			confirmButtonColor : '#28a745',
			cancelButtonColor  : '#d33'
		}).then(() => {

				$.ajax({
					url: '<?= base_url(); ?>Logistik/prosesData',
					data: ({
						id    : id,
						acc   : acc,
						jenis : 'verif_byr_inv_beli'
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
						toastr.success('Data Berhasil Diproses');
						// swal({
						// 	title               : "Data",
						// 	html                : "Data Berhasil Diproses",
						// 	type                : "success",
						// 	confirmButtonText   : "OK"
						// });
						
						// setTimeout(function(){ location.reload(); }, 1000);
						// location.href = "<?= base_url()?>Logistik/Invoice";
						// location.href = "<?= base_url()?>Logistik/Invoice_edit?id="+id+"&statuss=Y&no_inv="+no_inv+"&acc=1";
						reloadTable()
						close_modal()
						swal.close();
					},
					error: function(jqXHR, textStatus, errorThrown) {
						// toastr.error('Terjadi Kesalahan');
						swal({
							title               : "Cek Kembali",
							html                : "Terjadi Kesalahan",
							type                : "error",
							confirmButtonText   : "OK"
						});
						return;
					}
				});
		
		});


	}

	function close_modal()
	{
		$('#modalForm').modal('hide');
		reloadTable()
	}
</script>
