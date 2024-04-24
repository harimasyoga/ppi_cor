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
									<th class="text-center">NO STOK</th>
									<th class="text-center">TANGGAL</th>
									<th class="text-center">STATUS</th>
									<th class="text-center">NO TIMB</th>
									<th class="text-center">TIMBANGAN</th>
									<th class="text-center">TONASE</th>
									<th class="text-center" style="padding : 12px 50px">CUST</th>
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
						<div class="col-md-2">No Invoice</div>
						<div class="col-md-3">
							<input type="hidden" name="sts_input" id="sts_input">
							<input type="hidden" name="id_stok_h" id="id_stok_h">

							<input type="text" class="angka form-control" name="no_stok" id="no_stok" value="AUTO" readonly>
						</div>
						<div class="col-md-6"></div>

					</div>
					
					<div class="card-body row" style="padding-bottom:1px;font-weight:bold">			
					<div class="col-md-2">Tanggal Invoice</div>
						<div class="col-md-3">
							<input type="date" class="form-control" name="tgl_inv" id="tgl_inv" value ="<?= date('Y-m-d') ?>" >
						</div>
						<div class="col-md-1"></div>

						<div class="col-md-2">ATTN</div>
							<div class="col-md-3">
								<select class="form-control select2" name="id_hub" id="id_hub" style="width: 100%;" >
								</select>
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
									<th style="padding : 12px 50px">Ket Transaksi</th>
									<th style="padding : 12px 70px" >Jenis Beban</th>
									<th style="padding : 12px 50px" >Nominal</th>
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
											<input type="text" size="5" name="ket[0]" id="ket0" class="form-control">
										</div>
									</td>		

									<td style="padding : 12px 20px">
										<div class="input-group mb-1">
											<select name="jns_beban[0]"  id="jns_beban0" class="form-control select2" style="width: 100%">
											</select>	
										</div>
									</td>		
									<td style="padding : 12px 20px">
										<div class="input-group mb-1">
											<div class="input-group-append">
												<span class="input-group-text"><b>Rp</b>
												</span>
											</div>	
											<input type="text" size="5" name="nominal[0]" id="nominal0" class="angka form-control" onkeyup="ubah_angka(this.value,this.id),hitung_total()" value='0'>
												
										</div>
										
									</td>		
								</tr>
							</tbody>
							<tfoot>
								<tr>
									<td colspan="3" class="text-center">
										<label for="total">TOTAL</label>
									</td>	
									<td>
										<div class="input-group mb-1">
											<input type="text" size="5" name="total_nom" id="total_nom" class="angka form-control" value='0' readonly>
											<div class="input-group-append">
												<span class="input-group-text"><b>Kg</b>
												</span>
											</div>		
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

<!-- Modal item -->
<div class="modal fade list_item" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-full" style="width:100%;margin:auto">

        <div class="modal-content">
            <div class="modal-header">
                <h5><b>Pilih PO</b></h5>
            </div>
            <div class="modal-body">
				<div style="overflow:auto;white-space:nowrap">

                <table class="table table-bordered table-striped" id="tbl_po" style="margin:auto !important">
                    <thead>
                        <tr class="color-tabel">
                            <th class="text-center title-white">NO </th>
                            <th class="text-center title-white">CUSTOMER</th>
                            <th class="text-center title-white">NO PO</th>
                            <th class="text-center title-white">TGL PO</th>
                            <th class="text-center title-white">TONASE ORDER</th>
                            <th class="text-center title-white">HISTORY DATANG</th>
                            <th class="text-center title-white">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
				</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
            </div>
        </div>

    </div>
</div>
<!-- Modal item -->

<script type="text/javascript">

	const urlAuth = '<?= $this->session->userdata('level')?>';

	$(document).ready(function ()
	{
		kosong()
		load_data()
		load_hub()
		jenis_beban(0)
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

	function jenis_beban(rowNum) 
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
					option += `<option value="${val.kd}" data-nm="${val.nm}" >${val.nm}</option>`;

					});

					$('#jns_beban'+rowNum).html(option);
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
		var ket    = $('#ket' + b).val();
		var jns_beban = $('#jns_beban' + b).val();
		var nominal = $('#nominal' + b).val();
			
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
								<input type="text" size="5" name="ket${ rowNum }" id="ket${ rowNum }" class="form-control">
							</div>
						</td>		

						<td style="padding : 12px 20px">
							<div class="input-group mb-1">
								<select name="jns_beban${ rowNum }"  id="jns_beban${ rowNum }" class="form-control select2" style="width: 100%">
								</select>	
							</div>
						</td>		
						<td style="padding : 12px 20px">
							<div class="input-group mb-1">
								<div class="input-group-append">
									<span class="input-group-text"><b>Rp</b>
									</span>
								</div>	
								<input type="text" size="5" name="nominal${ rowNum }" id="nominal${ rowNum }" class="angka form-control" onkeyup="ubah_angka(this.value,this.id),hitung_total()" value='0'>
									
							</div>
							
						</td>		
					</tr>
					`);
				jenis_beban(rowNum);
				$('.select2').select2({
					placeholder: '--- Pilih ---',
					dropdownAutoWidth: true
				});
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

	function cetak_inv_bb(id) 
	{		
		var id2         = id.substr(9,1);
		var id_stok_h   = $("#id_stok_h").val();
		var no_stok     = $("#no_stok").val();

		if(id_stok_h=='' || id_stok_h == null)
		{
			swal({
				title               : "Cek Kembali",
				html                : "SIMPAN INPUTAN TERLEBIH DAHULU",
				type                : "info",
				confirmButtonText   : "OK"
			});
			return;
		}

		var no_po       = $("#no_po"+id2).val();
		var url         = "<?= base_url('Logistik/cetak_inv_bb'); ?>";

		window.open(url + '?no_po='+no_po+'&no_stok='+no_stok+'&id_stok_h='+id_stok_h, '_blank');
		  
	}

	function hitung_total()
	{
		var total_nominal    = 0
		for(loop = 0; loop <= rowNum; loop++)
		{
			var nom = $("#nominal"+loop).val()
			if(nom=='')
			{
				nom1 = 0;
			}else{
				nom1 = nom;
			}
			var nominal   = parseInt(nom1.split('.').join(''))
			total_nominal += nominal
		}		
		total_datang_ok = (total_nominal=='' || isNaN(total_nominal) || total_nominal == null) ? 0 : total_nominal
		
		$("#total_nom").val(format_angka(total_nominal))
		
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
				"url": '<?php echo base_url('Logistik/load_data/stok_bb')?>',
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
			data       : { id, tbl:'trs_h_stok_bb', jenis :'edit_stok_bb',field :'id_stok' },
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

					var history = data.header.history - data.header.total_item - data.header.tonase_ppi

					$("#id_stok_h").val(data.header.id_stok);
					$("#no_stok").val(data.header.no_stok);
					$("#muat_ppi").val(data.header.muatan_ppi).trigger('change');
					$("#tgl_stok").val(data.header.tgl_stok);
					$("#id_timb").val(data.header.id_timbangan);
					$("#no_timb").val(data.header.no_timbangan);
					$("#history_timb").val(format_angka(history));
					$("#jum_timb").val(format_angka(data.header.total_timb));
					$("#tonase_ppi").val(format_angka(data.header.tonase_ppi));
					$("#sisa_timb").val(format_angka(data.header.sisa_stok)); 
					swal.close();

					// detail

					var list = `
						<table class="table table-hover table-striped table-bordered table-scrollable table-condensed" id="table_list_item" width="100%">
						<thead class="color-tabel">
							<tr>
								<th id="header_del">Delete</th>
								<th style="padding : 12px 20px" >LIST </th>
								<th style="padding : 12px 150px">PO</th>
								<th style="padding : 12px 50px">Tonase PO</th>
								<th style="padding : 12px 70px" >History PO</th>
								<th style="padding : 12px 50px" >Kedatangan</th>
							</tr>
						</thead>`;
						
					var no   = 0;
					$.each(data.detail, function(index, val) {
						var history_detail = val.history - val.datang_bhn_bk
						list += `
							<tr id="itemRow${ no }">
								<td id="detail-hapus-${ no }">
									<div class="text-center">
										<a class="btn btn-danger" id="btn-hapus-${ no }" onclick="removeRow(${ no })">
											<i class="far fa-trash-alt" style="color:#fff"></i> 
										</a>
									</div>
								</td>
								<td>
									<div class="text-center">
										<button type="button" title="PILIH"  onclick="load_item(this.id)" class="btn btn-success btn-sm" data-toggle="modal"  name="list[${ no }]" id="list${ no }">
											<i class="fas fa-search"></i>
										</button> 

										<button type="button" title="PILIH"  onclick="cetak_inv_bb(this.id)" class="btn btn-danger btn-sm" name="print_inv[${ no }]" id="print_inv${ no }">
											<i class="fas fa-print"></i>
										</button> 
										
									</div>
								</td>
								<td style="padding : 12px 20px" >
									<input type="hidden" name="id_po_bhn[${ no }]" id="id_po_bhn${ no }" value="${val.id_po_bhn}">
									
									<div class="input-group mb-1">
										<div class="input-group-append">
											<span class="input-group-text"><b>&nbsp;CUST&nbsp;</b>
											</span>
										</div>								
										<input type="hidden" name="id_hub[${ no }]" id="id_hub${ no }" class="angka form-control" value="${val.id_hub}" readonly>
										
										<input type="text" name="nm_hub[${ no }]" id="nm_hub${ no }" class="angka form-control" value="${val.nm_hub}" readonly>
									</div>
									<div class="input-group mb-1">
										<div class="input-group-append">
											<span class="input-group-text"><b>NO PO</b>
											</span>
										</div>
										
										<input type="text" name="no_po[${ no }]" id="no_po${ no }" class="angka form-control" value="${val.no_po_bhn}"  readonly>
									</div>
								</td>	

								<td style="padding : 12px 20px">
									<div class="input-group mb-1">
										<input type="text" size="5" name="ton[${ no }]" id="ton${ no }" class="angka form-control" value="${format_angka(val.tonase_po)}"  readonly>
										<div class="input-group-append">
											<span class="input-group-text"><b>Kg</b>
											</span>
										</div>		
									</div>
								</td>		

								<td style="padding : 12px 20px">
									<div class="input-group mb-1">
										<input type="text" size="5" name="history[${ no }]" id="history${ no }" class="angka form-control" value="${format_angka(history_detail)}"  readonly>
										<div class="input-group-append">
											<span class="input-group-text"><b>Kg</b>
											</span>
										</div>		
									</div>
								</td>		
								<td style="padding : 12px 20px">
									<div class="input-group mb-1">
										<input type="text" size="5" name="datang[${ no }]" id="datang${ no }" class="angka form-control" onkeyup="ubah_angka(this.value,this.id),hitung_total()" value="${format_angka(val.datang_bhn_bk)}" >
										<div class="input-group-append">
											<span class="input-group-text"><b>Kg</b>
											</span>
										</div>		
									</div>
								</td>		
							</tr>
						`;

						no ++;
					})
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
		$("#tgl_inv").val($tgl) 
		load_hub()
		clearRow()
		hitung_total()
		
		swal.close()
	}

	function simpan() 
	{
		var tgl_stok    = $("#tgl_stok").val();
		var hub         = $("#id_hub").val();
		var ket0        = $("#ket0").val();
		
		if ( tgl_stok=='' || hub== '' || ket0 =='') 
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
					// swal.close();								
					kosong();
					location.href = "<?= base_url()?>Logistik/stok_bb";
					swal({
						title               : "Data",
						html                : "Berhasil Disimpan",
						type                : "success",
						confirmButtonText   : "OK"
					});
					
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

	function deleteData(id,no_stok,id_hub) 
	{
		id_hub2 = id_hub.split('/').join(',')
		// let cek = confirm("Apakah Anda Yakin?");
		swal({
			title: "HAPUS PEMBAYARAN",
			html: "<p> Apakah Anda yakin ingin menghapus file ini ?</p><br>"
			+"<strong>" +no_stok+ " </strong> ",
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
					id         : id,
					no_stok    : no_stok,
					id_hub     : id_hub2,
					jenis      : 'trs_h_stok_bb',
					field      : 'id_stok'
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
