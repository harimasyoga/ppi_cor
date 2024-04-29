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
		<div class="card shadow mb-3">
			<div class="row-list">
				<div class="card-header" style="font-family:Cambria;">		
						<h3 class="card-title" style="color:#4e73df;"><b><?= $judul ?></b></h3>

						<div class="card-tools">
							<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
								<i class="fas fa-minus"></i></button>
						</div>
				</div>
				<div class="card-body" >
					<?php if(in_array($this->session->userdata('level'), ['Admin','konsul_keu','Laminasi'])){ ?>
						<div style="margin-bottom:12px">
							<button type="button" class="btn btn-sm btn-info" onclick="add_data()"><i class="fa fa-plus"></i> <b>TAMBAH DATA</b></button>
						</div>
					<?php } ?>
					<div style="overflow:auto;">
						<table id="datatable" class="table table-bordered table-striped table-scrollable" width="100%">
							<thead class="color-tabel">
								<tr>
									<th class="text-center">NO</th>
									<th class="text-center">NO VOUCHER</th>
									<th class="text-center">TANGGAL</th>
									<th class="text-center">HUB</th>
									<th class="text-center">SUPPLIER</th>
									<th class="text-center">PAJAK</th>
									<th class="text-center">ACC OWNER</th>
									<th class="text-center">AKSI</th>
								</tr>
							</thead>
							<tbody></tbody>
						</table>
					</div>
				</div>
			</div>			
		</div>
	</section>

	<section class="content">

		<!-- Default box -->
		<div class="card shadow row-input" style="display: none;">
			<div class="card-header" style="font-family:Cambria;" >
				<h3 class="card-title" style="color:#4e73df;"><b>Input <?=$judul?></b></h3>

				<div class="card-tools">
					<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
						<i class="fas fa-minus"></i></button>
				</div>
			</div>
			<form role="form" method="post" id="myForm">
				<div class="col-md-12">								
					<br>						
					<div class="card-body row" style="padding-bottom:1px;font-weight:bold">						
						<div class="col-md-2">No Voucher</div>
						<div class="col-md-3">
							<input type="hidden" name="sts_input" id="sts_input">
							<input type="hidden" name="id_jurnal" id="id_jurnal">

							<input type="text" class="angka form-control" name="no_voucher" id="no_voucher" value="AUTO" readonly>
						</div>
						<div class="col-md-6"></div>
							
						

					</div>
					
					<div class="card-body row" style="padding-bottom:1px;font-weight:bold">			
					<div class="col-md-2">Tanggal Voucher</div>
						<div class="col-md-3">
							<input type="date" class="form-control" name="tgl_inv" id="tgl_inv" value ="<?= date('Y-m-d') ?>" >
						</div>
						<div class="col-md-1"></div>
						<div class="col-md-2">Keterangan</div>
						<div class="col-md-3">
							<textarea type="text" class="form-control" name="ket" id="ket" ></textarea>
						</div>
					</div>
					
					<br>
					
					<!-- detail PO-->
					<hr>
					<div class="card-body row" style="padding:0 20px 20px;font-weight:bold">
						<div class="col-md-4" style="padding-right:0">List Item Pembelian</div>
						<div class="col-md-8">&nbsp;
						</div>
					</div>


					<div style="overflow:auto;white-space:nowrap;" >
						<table class="table table-hover table-striped table-bordered table-scrollable table-condensed" id="table_list_item" width="100%">
							<thead class="color-tabel">
								<tr>
									<th id="header_del">Delete</th>
									<th style="padding : 12px 70px" >Kode</th>
									<th style="padding : 12px 70px" >Nama</th>
									<th style="padding : 12px 50px" >Debit</th>
									<th style="padding : 12px 50px" >Kredit</th>
								</tr>
							</thead>
							<tbody>
								<tr id="itemRow0">
									<td id="detail-hapus-0">
										<div class="text-center">
											<a class="btn btn-danger" id="btn-hapus-0" onclick="removeRow(0)">
												<i class="far fa-trash-alt" style="color:#fff"></i> 
											</a>
										</div>
									</td>
									<td style="padding : 12px 20px">
										<div class="input-group mb-1">
											<input type="text" class="form-control" name="kd_rek[0]" id="kd_rek0" readonly>
										</div>
									</td>		
									<td style="padding : 12px 20px">
										<div class="input-group mb-1">
											<select name="nm_rek[0]"  id="nm_rek0" class="form-control select2" style="width: 100%">
											</select>	
										</div>
									</td>		
									<td style="padding : 12px 20px">
										<div class="input-group mb-1">
											<div class="input-group-append">
												<span class="input-group-text"><b>Rp</b>
												</span>
											</div>	
											<input type="text" size="5" name="debit[0]" id="debit0" class="angka form-control" onkeyup="ubah_angka(this.value,this.id),hitung_total()" value='0'>
										</div>										
									</td>		
									<td style="padding : 12px 20px">
										<div class="input-group mb-1">
											<div class="input-group-append">
												<span class="input-group-text"><b>Rp</b>
												</span>
											</div>	
											<input type="text" size="5" name="kredit[0]" id="kredit0" class="angka form-control" onkeyup="ubah_angka(this.value,this.id),hitung_total()" value='0'>
										</div>										
									</td>		
								</tr>
							</tbody>
							<tfoot>
								<tr>
									<td colspan="3" class="text-right">
									</td>	
									<td>
										<label for="total">DEBIT</label>
										<br>
										<div class="input-group mb-1">
											<div class="input-group-append">
												<span class="input-group-text"><b>Rp</b>
												</span>
											</div>		
											<input type="text" size="5" name="debit_all" id="debit_all" class="angka form-control" value='0' readonly>
										</div>
										
									</td>	
									<td>
										<label for="total">KREDIT</label>
										<br>
										<div class="input-group mb-1">
											<div class="input-group-append">
												<span class="input-group-text"><b>Rp</b>
												</span>
											</div>		
											<input type="text" size="5" name="kredit_all" id="kredit_all" class="angka form-control" value='0' readonly>
										</div>
										
									</td>	
								</tr>								
							</tfoot>
						</table>
						<div id="add_button" >
							<button type="button" onclick="addRow()" class="btn-tambah-produk btn  btn-success"><b><i class="fa fa-plus" ></i></b></button>
							<input type="hidden" name="bucket" id="bucket" value="0">
						</div>
						<br>
					</div>

					<!-- end detail PO-->

				
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
			</form>	
		</div>
		<!-- /.card -->
	</section>
</div>

	<!-- MODAL box -->
	<div class="modal fade" id="modalForm">
		<div class="modal-dialog modal-full">
			<div class="modal-content">

				<div class="card-header" style="font-family:Cambria;" >
					<h4 class="card-title" style="color:#4e73df;" id="judul"></h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
						<div class="card-body">
							<div class="col-md-12">
								<br>
									
								<div class="card-body row" style="padding-bottom:1px;font-weight:bold">						
									<div class="col-md-2">No Voucher</div>
									<div class="col-md-3">			
										<input type="text" class="angka form-control" name="m_no_voucher" id="m_no_voucher" value="AUTO" readonly>
									</div>
									<div class="col-md-1"></div>
									<div class="col-md-2">Supplier</div>
									<div class="col-md-3">
										<input class="form-control" type="text" name="m_id_supp" id="m_id_supp" readonly>
									</div>
			
								</div>
								
								<div class="card-body row" style="padding-bottom:1px;font-weight:bold">			
								<div class="col-md-2">Tanggal Voucher</div>
									<div class="col-md-3">
										<input type="date" class="form-control" name="m_tgl_inv" id="m_tgl_inv" value ="<?= date('Y-m-d') ?>" readonly>
									</div>
									<div class="col-md-1"></div>
			
									<div class="col-md-2">ATTN</div>
										<div class="col-md-3">
											<input class="form-control" type="text" name="m_id_hub" id="m_id_hub" readonly>
										</div>
								</div>
								
								<div class="card-body row" style="padding-bottom:1px;font-weight:bold">			
								<div class="col-md-2">Diskon</div>
									<div class="col-md-3">
										<div class="input-group mb-1">
											<div class="input-group-append">
												<span class="input-group-text"><b>Rp</b>
												</span>
											</div>	
											<input type="text" class="angka form-control" name="m_diskon" id="m_diskon"  readonly>
												
										</div>
									</div>
									<div class="col-md-1"></div>
			
									<div class="col-md-2">PPN</div>
									<div class="col-md-3">
										<input type="text" name="m_pajak" id="m_pajak" class="form-control" readonly>
									</div>
								</div>
								
								<div class="card-body row" style="padding-bottom:1px;font-weight:bold">			
								<div class="col-md-2">Keterangan</div>
									<div class="col-md-3">
										<textarea type="text" class="form-control" name="m_ket" id="m_ket" readonly></textarea>
									</div>
									<div class="col-md-6"></div>
								</div>
								<br>
								
								<!-- detail PO-->
								<hr>
								<div class="card-body row" style="padding:0 20px 20px;font-weight:bold">
									<div class="col-md-4" style="padding-right:0">List Item Pembelian</div>
									<div class="col-md-8">&nbsp;
									</div>
								</div>
			
			
								<div style="overflow:auto;white-space:nowrap;" >
									<table class="table table-hover table-striped table-bordered table-scrollable table-condensed" id="m_table_list_item" width="100%">
									</table>


									<span id="modal_btn_verif"></span>

									<button type="button" class="btn btn-danger" data-dismiss="modal"  ><i class="fa fa-undo"></i> <b> Batal</b></button>

									<br>
								</div>
			
								<!-- end detail PO-->
								
							<input type="hidden" name="m_bucket" id="m_bucket" value="0">
			
							
								
								<br>
								
							</div>
						</div>
					
				</div>
			</div>
		</div>
	</div>
	<!-- /.MODAL -->


<script type="text/javascript">

	const urlAuth = '<?= $this->session->userdata('level')?>';

	$(document).ready(function ()
	{
		kosong()
		load_data()
		load_hub()
		load_supp()
		load_kd_rek(0)
		$('.select2').select2();
	});
	
	var rowNum = 0;

	function load_hub() 
	{
		option = "";
		$.ajax({
			type       : 'POST',
			url        : "<?= base_url(); ?>Logistik/load_hub",
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

	function load_kd_rek(rowNum) 
	{
		option = "";
		$.ajax({
			type       : 'POST',
			url        : "<?= base_url(); ?>Keuangan/load_rek",
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
					option += `<option value="${val.kd}" data-nm="${val.nm}" >${val.nm}</option>`;

					});

					$('#nm_rek'+rowNum).html(option);
					$('.select2').select2({
						containerCssClass: "wrap",
						placeholder: '--- Pilih ---',
						dropdownAutoWidth: true
					});
					swal.close();
				}else{	
					option += "<option value=''></option>";
					$('#nm_rek'+rowNum).html(option);					
					swal.close();
				}
			}
		});
	}
	
	function jenis_beban2(rowNum,jns_beban) 
	{
		option = "";
		$.ajax({
			type       : 'POST',
			url        : "<?= base_url(); ?>Logistik/load_jenis_beban",
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
					if(val.kd==jns_beban)
					{
						option += `<option value="${val.kd}" selected data-nm="${val.nm}" >${val.nm}</option>`;
					}else{
						option += `<option value="${val.kd}" data-nm="${val.nm}" >${val.nm}</option>`;
					}

					});

					$('#jns_beban'+rowNum).html(option);
					$('.select2').select2({
						containerCssClass: "wrap",
						placeholder: '--- Pilih ---',
						dropdownAutoWidth: true
					});
					swal.close();
				}else{	
					option += "<option value=''></option>";
					$('#jns_beban'+rowNum).html(option);					
					swal.close();
				}
			}
		});
	}
	
	function addRow() 
	{
		var b = $('#bucket').val();

		if (b == -1) {
			b = 0;
			rowNum = 0;
		}
		var kd_rek    = $('#kd_rek' + b).val();
		var nm_rek    = $('#nm_rek' + b).val();
		var debit     = $('#debit' + b).val();
		var kredit    = $('#kredit' + b).val();
			
		// if (nominal != '0' && nominal != '' && jns_beban != '' && ket != '') 
		// {
			
			rowNum++;
			var x = rowNum + 1;
			
				$('#table_list_item').append(
					`<tr id="itemRow${ rowNum }">
						<td id="detail-hapus-${ rowNum }">
							<div class="text-center">
								<a class="btn btn-danger" id="btn-hapus-${ rowNum }" onclick="removeRow(${ rowNum })">
									<i class="far fa-trash-alt" style="color:#fff"></i> 
								</a>
							</div>
						</td>
						<td style="padding : 12px 20px">
							<div class="input-group mb-1">
								<input type="text" class="form-control" name="kd_rek[${ rowNum }]" id="kd_rek${ rowNum }" readonly>
							</div>
						</td>		
						<td style="padding : 12px 20px">
							<div class="input-group mb-1">
								<select name="nm_rek[${ rowNum }]"  id="nm_rek${ rowNum }" class="form-control select2" style="width: 100%">
								</select>	
							</div>
						</td>		
						<td style="padding : 12px 20px">
							<div class="input-group mb-1">
								<div class="input-group-append">
									<span class="input-group-text"><b>Rp</b>
									</span>
								</div>	
								<input type="text" size="5" name="debit[${ rowNum }]" id="debit${ rowNum }" class="angka form-control" onkeyup="ubah_angka(this.value,this.id),hitung_total()" value='0'>
							</div>										
						</td>		
						<td style="padding : 12px 20px">
							<div class="input-group mb-1">
								<div class="input-group-append">
									<span class="input-group-text"><b>Rp</b>
									</span>
								</div>	
								<input type="text" size="5" name="kredit[${ rowNum }]" id="kredit${ rowNum }" class="angka form-control" onkeyup="ubah_angka(this.value,this.id),hitung_total()" value='0'>
							</div>										
						</td>		
					</tr>
					`);
				load_kd_rek(rowNum) 
				$('#bucket').val(rowNum);
				$('#list' + rowNum).focus();
		// }else{
		// 	swal({
		// 		title               : "Cek Kembali",
		// 		html                : "Isi form diatas terlebih dahulu",
		// 		type                : "info",
		// 		confirmButtonText   : "OK"
		// 	});
		// 	return;
		// }
	}

	function removeRow(e) 
	{
		if (rowNum > 0) {
			jQuery('#itemRow' + e).remove();
			// rowNum--;
		} else {
			// toastr.error('Baris pertama tidak bisa dihapus');
			// return;

			swal({
					title               : "Cek Kembali",
					html                : "Baris pertama tidak bisa dihapus",
					type                : "error",
					confirmButtonText   : "OK"
				});
			return;
		}
		// $('#bucket').val(rowNum);
	}

	function clearRow() 
	{
		var bucket = $('#bucket').val();
		for (var e = bucket; e > 0; e--) {
			jQuery('#itemRow' + e).remove();
			rowNum--;
		}		
		$('#bucket').val(rowNum);
	}

	function hitung_total()
	{

		var total_debit   = 0
		var total_kredit  = 0
		for(loop = 0; loop <= rowNum; loop++)
		{
			var debit        = $("#debit"+loop).val()
			var kredit       = $("#kredit"+loop).val()

			debit_ok         = (debit=='' || isNaN(debit) || debit == null) ? '0' : debit;
			kredit_ok        = (kredit=='' || isNaN(kredit) || kredit == null) ? '0' : kredit;

			var debit_oke    = parseInt(debit_ok.split('.').join(''))
			var kredit_oke   = parseInt(kredit_ok.split('.').join(''))
			
			total_debit      += debit_oke
			total_kredit     += kredit_oke
		}		

		total_debit_ok    = (total_debit=='' || isNaN(total_debit) || total_debit == null) ? 0 : total_debit
		total_kredit_ok   = (total_kredit=='' || isNaN(total_kredit) || total_kredit == null) ? 0 : total_kredit
		
		$("#debit_all").val(format_angka(total_debit_ok))		
		$("#kredit_all").val(format_angka(total_kredit_ok))
		
	}
	
	function m_hitung_total()
	{
		var diskon        = $("#m_diskon").val()
		diskon_ok     = (diskon=='' || isNaN(diskon) || diskon == null) ? '0' : diskon;
		var disk_total    = parseInt(diskon_ok.split('.').join(''))
		var pajak         = $("#m_pajak").val()
		
		var total_nominal = 0
		for(loop = 0; loop <= rowNum; loop++)
		{
			var nom = $("#m_nominal"+loop).val()
			if(nom=='')
			{
				nom1 = 0;
			}else{
				nom1 = nom;
			}
			var nominal   = parseInt(nom1.split('.').join(''))
			total_nominal += nominal
		}		
		total_nominal_ok = (total_nominal=='' || isNaN(total_nominal) || total_nominal == null) ? 0 : total_nominal
		
		if(pajak=='PPN')
		{
			var pajak_total   = (total_nominal_ok *0.11).toFixed(0);
		}else{
			var pajak_total   = 0
		}
		
		var total_all     = parseInt(total_nominal_ok)-parseInt(disk_total)+parseInt(pajak_total)

		$("#m_total_nom").val(format_angka(total_nominal_ok))		
		$("#m_disk_total").val(format_angka(disk_total))
		$("#m_pajak_total").val(format_angka(pajak_total))
		$("#m_total_all").val(format_angka(total_all))
		
	}

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
				"url": '<?php echo base_url('Logistik/load_data/inv_beli')?>',
				"type": "POST",
			},
			"aLengthMenu": [
				[5, 10, 50, 100, -1],
				[5, 10, 50, 100, "Semua"]
			],	
			"responsive": false,
			"pageLength": 10,
			"language": {
				"emptyTable": "TIDAK ADA DATA.."
			}
		})
	}
	
	function edit_data(id,no_po)
	{
		$(".row-input").attr('style', '');
		$(".row-list").attr('style', 'display:none');
		$("#sts_input").val('edit');

		$("#btn-simpan").html(`<button type="button" onclick="simpan()" class="btn-tambah-produk btn  btn-primary"><b><i class="fa fa-save" ></i> Update</b> </button>`)

		$.ajax({
			url        : '<?= base_url(); ?>Logistik/load_data_1',
			type       : "POST",
			data       : { id, jenis :'edit_inv_beli' },
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
				if(data){
					// header
					$("#id_jurnal").val(data.header.id_jurnal);
					$("#no_voucher").val(data.header.no_voucher);
					$("#id_hub").val(data.header.id_hub).trigger('change');
					$("#id_supp").val(data.header.id_supp).trigger('change');
					$("#tgl_inv").val(data.header.tgl_inv_beli);
					$("#pajak").val(data.header.pajak);
					$("#ket").val(data.header.ket);
					$("#diskon").val(format_angka(data.header.diskon));	
					
					swal.close();
					// detail

					var list = `
						<table class="table table-hover table-striped table-bordered table-scrollable table-condensed" id="table_list_item" width="100%">
							<thead class="color-tabel">
								<tr>
									<th id="header_del">Delete</th>
									<th style="padding : 12px 50px">Transaksi</th>
									<th style="padding : 12px 70px" >Jenis Beban</th>
									<th style="padding : 12px 50px" >Nominal</th>
								</tr>
							</thead>`;
						
					var no   = 0;
					$.each(data.detail, function(index, val) {
						
						jenis_beban2(no,val.jns_beban)	
						list += `
							<tr id="itemRow${ no }">
								<td id="detail-hapus-${ no }">
									<div class="text-center">
										<a class="btn btn-danger" id="btn-hapus-${ no }" onclick="removeRow(${ no })">
											<i class="far fa-trash-alt" style="color:#fff"></i> 
										</a>
									</div>
								</td>
								<td style="padding : 12px 20px">
									<div class="input-group mb-1">
										<input type="text" size="5" name="transaksi[${ no }]" id="transaksi${ no }" class="form-control" value="${(val.transaksi)}">
									</div>
								</td>		

								<td style="padding : 12px 20px">
									<div class="input-group mb-1">
										<select name="jns_beban[${ no }]"  id="jns_beban${ no }" class="form-control select2" style="width: 100%">
											<option value="${val.jns_beban}" selected data-nm="${val.nm}" >${val.jns_beban}</option>
										</select>	
									</div>
								</td>		
								<td style="padding : 12px 20px">
									<div class="input-group mb-1">
										<div class="input-group-append">
											<span class="input-group-text"><b>Rp</b>
											</span>
										</div>	
										<input type="text" size="5" name="nominal[${ no }]" id="nominal${ no }" class="angka form-control" onkeyup="ubah_angka(this.value,this.id),hitung_total()" value="${format_angka(val.nominal)}">
											
									</div>
									
								</td>		
							</tr>
						`;
						no ++;
					})
					
					list +=`<tfoot>
								<tr>
									<td colspan="3" class="text-right">
									</td>	
									<td>
										<label for="total">DEBIT</label>
										<br>
										<div class="input-group mb-1">
											<div class="input-group-append">
												<span class="input-group-text"><b>Rp</b>
												</span>
											</div>		
											<input type="text" size="5" name="debit_all" id="debit_all" class="angka form-control" value='0' readonly>
										</div>
										
									</td>	
									<td>
										<label for="total">KREDIT</label>
										<br>
										<div class="input-group mb-1">
											<div class="input-group-append">
												<span class="input-group-text"><b>Rp</b>
												</span>
											</div>		
											<input type="text" size="5" name="kredit_all" id="kredit_all" class="angka form-control" value='0' readonly>
										</div>
										
									</td>	
								</tr>
							</tfoot>`;
					rowNum = no-1 
					$('#bucket').val(rowNum);					
					$("#table_list_item").html(list);
					hitung_total()	
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

	// MODAL //
	function open_modal(id,no_invoice) 
	{		
		$("#modalForm").modal("show");
		$("#judul").html('<h3> VERIFIKASI OWNER </h3>');
		
		$.ajax({
			url        : '<?= base_url(); ?>Logistik/load_data_1',
			type       : "POST",
			data       : { id, jenis :'edit_inv_beli' },
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
				if(data){
					// header
					$("#m_id_jurnal").val(data.header.id_jurnal);
					$("#m_no_voucher").val(data.header.no_voucher);
					$("#m_id_hub").val(data.header.nm_hub);
					$("#m_id_supp").val(data.header.nm_supp);
					$("#m_tgl_inv").val(data.header.tgl_inv_beli);
					$("#m_pajak").val(data.header.pajak); 
					$("#m_ket").val(data.header.ket);
					$("#m_diskon").val(format_angka(data.header.diskon));	
					
					swal.close();

					if(data.header.acc_owner == 'Y')
					{
						$("#modal_btn_verif").html(`<button type="button" class="btn btn-success" id="modal_btn_verif" onclick="acc_inv('Y')"><i class="fas fa-lock"></i><b> BATAL VERIFIKASI </b></button>`)
					}else{
						$("#modal_btn_verif").html(`<button type="button" class="btn btn-success" id="modal_btn_verif" onclick="acc_inv('N')"><i class="fas fa-check"></i><b> VERIFIKASI </b></button>`)

					}
					// detail

					var list = `
						<table class="table table-hover table-striped table-bordered table-scrollable table-condensed" id="m_table_list_item" width="100%">
							<thead class="color-tabel">
								<tr>
									<th style="padding : 12px 50px">Transaksi</th>
									<th style="padding : 12px 70px" >Jenis Beban</th>
									<th style="padding : 12px 50px" >Nominal</th>
								</tr>
							</thead>`;
						
					var no   = 0;
					$.each(data.detail, function(index, val) {
							
						list += `
							<tr id="m_itemRow${ no }">
								<td style="padding : 12px 20px">
									<div class="input-group mb-1">
										<input type="text" size="5" name="m_transaksi[${ no }]" id="m_transaksi${ no }" class="form-control" value="${(val.transaksi)}" readonly>
									</div>
								</td>		

								<td style="padding : 12px 20px">
									<div class="input-group mb-1">
										<input type="text"  name="m_jns_beban[${ no }]" id="m_jns_beban${ no }" class="form-control" value="${(val.nm)}" readonly>
									</div>
								</td>		
								<td style="padding : 12px 20px">
									<div class="input-group mb-1">
										<div class="input-group-append">
											<span class="input-group-text"><b>Rp</b>
											</span>
										</div>	
										<input type="text" size="5" name="m_nominal[${ no }]" id="m_nominal${ no }" class="angka form-control" onkeyup="ubah_angka(this.value,this.id),m_hitung_total()" value="${format_angka(val.nominal)}" readonly>
											
									</div>
									
								</td>		
							</tr>
						`;
						no ++;
					})
					
					list +=`<tfoot>
								<tr>
									<td colspan="3" class="text-right">
									</td>	
									<td>
										<label for="total">DEBIT</label>
										<br>
										<div class="input-group mb-1">
											<div class="input-group-append">
												<span class="input-group-text"><b>Rp</b>
												</span>
											</div>		
											<input type="text" size="5" name="m_debit_all" id="m_debit_all" class="angka form-control" value='0' readonly>
										</div>
										
									</td>	
									<td>
										<label for="total">KREDIT</label>
										<br>
										<div class="input-group mb-1">
											<div class="input-group-append">
												<span class="input-group-text"><b>Rp</b>
												</span>
											</div>		
											<input type="text" size="5" name="m_kredit_all" id="m_kredit_all" class="angka form-control" value='0' readonly>
										</div>
										
									</td>	
								</tr>
							</tfoot>`;
					rowNum = no-1 
					$('#m_bucket').val(rowNum);					
					$("#m_table_list_item").html(list);
					m_hitung_total()	
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

	function acc_inv(acc_owner) 
	{	
		var user        = "<?= $this->session->userdata('username')?>"
		var no_inv      = $('#m_no_voucher').val()
		
		if(user=='bumagda' || user=='developer')
		{
			acc = acc_owner
		}else{
			acc = ''
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
						no_inv    : no_inv,
						acc       : acc,
						jenis     : 'verif_inv_beli'
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
						// location.href = "<?= base_url()?>Logistik/Voucher";
						// location.href = "<?= base_url()?>Logistik/Voucher_edit?id="+id+"&statuss=Y&no_inv="+no_inv+"&acc=1";
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
	
	function kosong()
	{
		$tgl = '<?= date('Y-m-d') ?>'	
		rowNum = 0
		$("#id_hub").val('').trigger('change');	
		$("#id_supp").val('').trigger('change');	
		$("#pajak").val('').trigger('change');	
		$("#diskon").val('') 
		$("#diskon").val('') 
		$("#ket").val('') 		
		$("#tgl_inv").val($tgl) 
		$("#no_voucher").val('AUTO') 

		$("#transaksi0").val('');			
		$("#jns_beban0").val('').trigger('change');	
		$("#nominal0").val(0);		
		load_hub()
		clearRow()
		hitung_total()
		
		swal.close()
	}

	function simpan() 
	{
		var id_supp   = $("#id_supp").val();
		var tgl_inv   = $("#tgl_inv").val();
		var id_hub    = $("#id_hub").val();
		var pajak     = $("#pajak").val();
		
		if ( id_supp=='' || id_hub== '' || pajak =='') 
		{
			swal({
				title               : "Cek Kembali",
				html                : "Harap Lengkapi Form Dahulu",
				type                : "info",
				confirmButtonText   : "OK"
			});
			return;
		}

		$.ajax({
			url        : '<?= base_url(); ?>Logistik/insert_inv_beli',
			type       : "POST",
			data       : $('#myForm').serialize(),
			dataType   : "JSON",
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
				if(data == true){
					// toastr.success('Berhasil Disimpan');						
					kosong();
					swal({
						title               : "Data",
						html                : "Berhasil Disimpan",
						type                : "success",
						confirmButtonText   : "OK"
					});
					kembaliList()
					
				} else {
					// toastr.error('Gagal Simpan');
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

	function deleteData(id,no_voucher) 
	{
		// let cek = confirm("Apakah Anda Yakin?");
		swal({
			title: "HAPUS PEMBAYARAN",
			html: "<p> Apakah Anda yakin ingin menghapus file ini ?</p><br>"
			+"<strong>" +no_voucher+ " </strong> ",
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
					id         : no_voucher,
					jenis      : 'inv_beli',
					field      : 'no_voucher'
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
</script>
