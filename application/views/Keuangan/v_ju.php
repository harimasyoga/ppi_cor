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
									<th class="text-center">DEBIT</th>
									<th class="text-center">KREDIT</th>
									<th class="text-center">KET</th>
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
						<div class="col-md-1"></div>
						<div class="col-md-2">ATTN</div>
						<div class="col-md-3">
							<select class="form-control select2" name="id_hub" id="id_hub" style="width: 100%;" >
							</select>
						</div>
							
						

					</div>
					
					<div class="card-body row" style="padding-bottom:1px;font-weight:bold">			
					<div class="col-md-2">Tanggal Voucher</div>
						<div class="col-md-3">
							<input type="date" class="form-control" name="tgl_voucher" id="tgl_voucher" value ="<?= date('Y-m-d') ?>" >
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
											<select name="nm_rek[0]"  id="nm_rek0" class="form-control select2" style="width: 100%" onchange="load_kd(0)">
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

<script type="text/javascript">

	const urlAuth = '<?= $this->session->userdata('level')?>';

	$(document).ready(function ()
	{
		kosong()
		load_data()
		load_hub()
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
					option += `<option value="${val.kd}" data-nm="${val.nm}" >${val.kd} - ${val.nm}</option>`;

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

	function load_kd_rek2(rowNum,kd_rek) 
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
					if(val.kd==kd_rek)
					{
						option += `<option value="${val.kd}" selected data-nm="${val.nm}" >${val.kd} - ${val.nm}</option>`;
					}else{
						option += `<option value="${val.kd}" data-nm="${val.nm}" >${val.kd} - ${val.nm}</option>`;
					}

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

	function load_kd(rowNum)
	{
		var nm_rek          = $("#nm_rek"+rowNum).val();
		$("#kd_rek"+rowNum).val(nm_rek)
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
								<select name="nm_rek[${ rowNum }]"  id="nm_rek${ rowNum }" class="form-control select2" style="width: 100%" onchange="load_kd(${ rowNum })">
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
	
	function removeRow_edit(e) 
	{
		if (rowNum > 0) {
			jQuery('#itemRow' + e).remove();
			rowNum--;
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
		$('#bucket').val(rowNum);
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
				"url": '<?php echo base_url('Keuangan/load_data/jur_umum')?>',
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
	
	function edit_data(no_voucher)
	{
		$(".row-input").attr('style', '');
		$(".row-list").attr('style', 'display:none');
		$("#sts_input").val('edit');

		$("#btn-simpan").html(`<button type="button" onclick="simpan()" class="btn-tambah-produk btn  btn-primary"><b><i class="fa fa-save" ></i> Update</b> </button>`)

		$.ajax({
			url        : '<?= base_url(); ?>Keuangan/load_data_1',
			type       : "POST",
			data       : { id : '', no : no_voucher, jenis :'edit_ju' },
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
					$("#no_voucher").val(data.header.no_voucher);
					$("#tgl_transaksi").val(data.header.tgl_transaksi);
					$("#ket").val(data.header.ket);				
					$("#id_hub").val(data.header.id_hub).trigger('change');	
					
					swal.close();
					// detail

					var list = `
						<table class="table table-hover table-striped table-bordered table-scrollable table-condensed" id="table_list_item" width="100%">
							<thead class="color-tabel">
								<tr>
									<th id="header_del">Delete</th>
									<th style="padding : 12px 70px" >Kode</th>
									<th style="padding : 12px 70px" >Nama</th>
									<th style="padding : 12px 50px" >Debit</th>
									<th style="padding : 12px 50px" >Kredit</th>
								</tr>
							</thead>`;
						
					var no   = 0;
					$.each(data.detail, function(index, val) {
						load_kd_rek2(no,val.kode_rek) 
						
						list += `
							<tr id="itemRow${ no }">
								<td id="detail-hapus-${ no }">
									<div class="text-center">
										<a class="btn btn-danger" id="btn-hapus-${ no }" onclick="removeRow_edit(${ no })">
											<i class="far fa-trash-alt" style="color:#fff"></i> 
										</a>
									</div>
								</td>
								<td style="padding : 12px 20px">
									<div class="input-group mb-1">
										<input type="text" class="form-control" name="kd_rek[${ no }]" id="kd_rek${ no }" value="${(val.kode_rek)}" readonly>
									</div>
								</td>		
								<td style="padding : 12px 20px">
									<div class="input-group mb-1">
										<select name="nm_rek[${ no }]"  id="nm_rek${ no }" class="form-control select2" style="width: 100%" onchange="load_kd(${ no })">
											<option value="${val.kode_rek}" selected data-nm="${val.nm}" >${val.kode_rek} - ${val.nm}</option>
										</select>	
									</div> 
								</td>		
								<td style="padding : 12px 20px">
									<div class="input-group mb-1">
										<div class="input-group-append">
											<span class="input-group-text"><b>Rp</b>
											</span>
										</div>	
										<input type="text" size="5" name="debit[${ no }]" id="debit${ no }" class="angka form-control" onkeyup="ubah_angka(this.value,this.id),hitung_total()" value=${format_angka(val.debet)}>
									</div>										
								</td>		
								<td style="padding : 12px 20px">
									<div class="input-group mb-1">
										<div class="input-group-append">
											<span class="input-group-text"><b>Rp</b>
											</span>
										</div>	
										<input type="text" size="5" name="kredit[${ no }]" id="kredit${ no }" class="angka form-control" onkeyup="ubah_angka(this.value,this.id),hitung_total()" value='${format_angka(val.kredit)}'>
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
											<input type="text" size="5" name="debit_all" id="debit_all" class="angka form-control" value='${(data.header.debit)}' readonly>
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
											<input type="text" size="5" name="kredit_all" id="kredit_all" class="angka form-control" value='${(data.header.kredit)}' readonly>
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
	
	function kosong()
	{
		$tgl = '<?= date('Y-m-d') ?>'	
		rowNum = 0
		$("#no_voucher").val('')  
		$("#tgl_transaksi").val('')  
		$("#ket").val('')  
		$("#id_hub").val('').trigger('change');	

		$("#kd_rek0").val('');				
		$("#nm_rek0").val('').trigger('change');	
		$("#debit0").val(0);			
		$("#kredit0").val(0);			
		load_hub()
		clearRow()
		hitung_total()
		
		swal.close()
	}

	function simpan() 
	{
		var id_hub        = $("#id_hub").val();
		var tgl_voucher   = $("#tgl_voucher").val();
		var ket           = $("#ket").val();
		
		var debit_all     = $("#debit_all").val();
		var kredit_all    = $("#kredit_all").val();
		
		if ( id_hub=='' || tgl_voucher== '' || ket =='') 
		{
			swal({
				title               : "Cek Kembali",
				html                : "Harap Lengkapi Form Dahulu",
				type                : "info",
				confirmButtonText   : "OK"
			});
			return;
		}
		
		if ( debit_all !=  kredit_all) 
		{
			swal({
				title               : "Total Debit & Kredit Tidak Sama",
				html                : "Harap Sesuaikan Form Dahulu..",
				type                : "info",
				confirmButtonText   : "OK"
			});
			return;
		}

		$.ajax({
			url        : '<?= base_url(); ?>Keuangan/insert_ju',
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
					reloadTable()
					
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

	function deleteData(no_voucher) 
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
				url: '<?= base_url(); ?>Keuangan/hapus',
				data: ({
					id         : no_voucher,
					jenis      : 'jurnal_d',
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
