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
					<!-- <div style="overflow:auto;white-space:nowrap"> -->
						<table id="datatable" class="table table-bordered table-striped table-scrollable" width="100%">
							<thead class="color-tabel">
								<tr>
									<th class="text-center title-white">NO</th>
									<th class="text-center title-white">TANGGAL</th>
									<th class="text-center title-white">JENIS</th>
									<th class="text-center title-white">TONASE</th>
									<th class="text-center title-white">CUSTOMER</th>
									<th class="text-center title-white">ITEM</th>
									<th class="text-center title-white">AKSI</th>
								</tr>
							</thead>
							<tbody></tbody>
						</table>
					<!-- </div> -->
				</div>
			</div>			
		</div>
	</section>

	<section class="content">

		<!-- Default box -->
		<div class="card shadow row-input" style="display: none;">
			<div class="card-header" style="font-family:Cambria;" >
				<h3 class="card-title" style="color:#4e73df;"><b>INPUT STOK</b></h3>

				<div class="card-tools">
					<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
						<i class="fas fa-minus"></i></button>
				</div>
			</div>
			<form role="form" method="post" id="myForm">
				<div class="col-md-12">
								
						<br>
						
					<div class="card-body row" style="padding : 5px;font-weight:bold">
						<div class="col-md-1"></div>
							
						<div class="col-md-2">KODE STOK</div>
						<div class="col-md-4">
							<input type="hidden" name="sts_input" id="sts_input">
							<input type="hidden" name="id_stok_h" id="id_stok_h">
							<input type="hidden" name="kd_stok_old" id="kd_stok_old">

							<input type="text" class="angka form-control" name="kd_stok" id="kd_stok" value="AUTO" readonly>
						</div>

						<div class="col-md-5"></div>
					</div>

					<div class="card-body row" style="padding : 5px;font-weight:bold">
						<div class="col-md-1"></div>
							
						<div class="col-md-2">JENIS</div>
						<div class="col-md-4">
							<select class="form-control select2" name="jns" id="jns">
								<option value="po">BAHAN BAKU PO</option>
								<option value="stok">STOK PPI</option>
							</select>
						</div>

						<div class="col-md-5"></div>
					</div>
					
					<div class="card-body row" style="padding : 5px;font-weight:bold">
						<div class="col-md-1"></div>
							
						<div class="col-md-2">TANGGAL</div>
						<div class="col-md-4">
							<input type="date" class="form-control" name="tgl_stok" id="tgl_stok" value ="<?= date('Y-m-d') ?>" >
						</div> 

						<div class="col-md-5"></div>
					</div>
					
					<div class="card-body row" style="padding : 5px;font-weight:bold">
						<div class="col-md-1"></div>
							
						<div class="col-md-2">HUB</div>
						<div class="col-md-4">
							<select class="form-control select2" name="hub" id="hub" onchange="clearRow()">
							</select>
						</div>

						<div class="col-md-5"></div>
					</div>
					
					<br>
					<hr>

					<div class="card-body row" style="padding:0 20px 20px;font-weight:bold">
						<div class="col-md-2" style="padding-right:0">List Item</div>
						<div class="col-md-10">&nbsp;
						</div>
					</div>

					<!-- detail -->

					<div style="overflow:auto;white-space:nowrap;" >
						<table class="table table-hover table-striped table-bordered table-scrollable table-condensed" id="table_list_item" width="100%">
							<thead class="color-tabel">
								<tr>
									<th id="header_del">Delete</th>
									<th style="padding : 12px 20px" >LIST </th>
									<th style="padding : 12px 150px" >Customer </th>
									<th style="padding : 12px 100px" >KODE PO</th>
									<th style="padding : 12px 100px" >ITEM</th>
									<th style="padding : 12px 50px" >QTY</th>
									<th style="padding : 12px 50px" >TON</th>
									<th style="padding : 12px 25px" >Kebutuhan</th>
									<th style="padding : 12px 30px" >History</th>
									<th style="padding : 12px 25px" >Kedatangan</th>
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
									<td>
										<div class="text-center">
											<button type="button" title="PILIH"  onclick="load_item(this.id)" class="btn btn-success btn-sm" data-toggle="modal"  name="list[0]" id="list0">
												<i class="fas fa-check-circle"></i>
											</button> 
											
										</div>
									</td>
									<td style="padding : 12px 20px" >
										<input type="hidden" name="id_pelanggan[0]" id="id_pelanggan0" class="angka form-control" placeholder="CUST" readonly>

										<input type="text" name="nm_pelanggan[0]" id="nm_pelanggan0" class="angka form-control" placeholder="CUST" readonly>
										

									</td>
									<td style="padding : 12px 20px">
										<input type="text" name="kode_po[0]" id="kode_po0" class="angka form-control" placeholder="kode_po" readonly>

									</td>										
									<td style="padding : 12px 20px">
										<input type="hidden" name="id_po_detail[0]" id="id_po_detail0" class="angka form-control" readonly>
										
										<input type="hidden" name="id_produk[0]" id="id_produk0" class="angka form-control" readonly>

										<textarea rows="2" cols="25" name="text" name="item[0]" id="item0" wrap="soft" disabled> </textarea>

										<!-- <input type="text" name="item[0]" id="item0" class="form-control narrow wrap wrap" placeholder="ITEM" readonly> -->
									</td>		

									<td style="padding : 12px 20px">
										<div class="text-right">
											<input type="text" name="qty[0]" id="qty0" class="angka form-control" value='0' readonly>
										</div>
									</td>		

									<td style="padding : 12px 20px">
										<div class="text-right">
											<input type="text" name="ton[0]" id="ton0" class="angka form-control" value='0' readonly>
										</div>
									</td>		

									<td style="padding : 12px 20px">
										<div class="text-right">
											<input type="text" name="kebutuhan[0]" id="kebutuhan0" class="angka form-control"  value='0' readonly>
										</div>
									</td>		
									<td style="padding : 12px 20px">
										<input type="text" name="history[0]" id="history0" class="angka form-control" value='0' readonly>
									</td>		
									<td style="padding : 12px 20px">
										<input type="text" name="datang[0]" id="datang0" class="angka form-control" onkeyup="ubah_angka(this.value,this.id)" value='0'>
									</td>		
								</tr>
							</tbody>
						</table>
						<div id="add_button" >
							<button type="button" onclick="addRow()" class="btn-tambah-produk btn  btn-success"><b><i class="fa fa-plus" ></i></b></button>
							<input type="hidden" name="bucket" id="bucket" value="0">
						</div>
						<br>
					</div>

					<!-- end detail -->

				
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
                            <!-- <th class="text-center title-white">NO PO</th> -->
                            <th class="text-center title-white">TIPE</th>
                            <th class="text-center title-white">KODE PO</th>
                            <th class="text-center title-white">TGL PO</th>
                            <th class="text-center title-white">ITEM</th>
                            <th class="text-center title-white">UKURAN BOX</th>
                            <th class="text-center title-white">UKURAN SHEET</th>
                            <th class="text-center title-white">QTY PO</th>
                            <th class="text-center title-white">BAHAN BAKU</th>
                            <th class="text-center title-white">TONASE</th>
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
		$('.select2').select2();
	});

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

					$('#hub').html(option);
					swal.close();
				}else{	
					option += "<option value=''></option>";
					$('#hub').html(option);					
					swal.close();
				}
			}
		});
		
	}
	
	var rowNum = 0;

	function addRow() 
	{
		var b = $('#bucket').val();

		if (b == -1) {
			b = 0;
			rowNum = 0;
		}

		var datang          = $('#datang' + b).val();
		var id_po_detail    = $('#id_po_detail' + b).val();
		var id_produk       = $('#id_produk' + b).val();
		var idp             = $('#id_pelanggan' + b).val();
			
		if (datang != '0' && datang != '' && id_po_detail != '' && id_produk != '' && idp != '') 
		{
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
						<td>
							<div class="text-center">
								<button type="button" title="PILIH"  onclick="load_item(this.id)" class="btn btn-success btn-sm" data-toggle="modal"  name="list[${ rowNum }]" id="list${ rowNum }">
									<i class="fas fa-check-circle"></i>
								</button> 
							</div>
						</td>
						<td style="padding : 12px 20px" >
							<input type="hidden" name="id_pelanggan[${ rowNum }]" id="id_pelanggan${ rowNum }" class="angka form-control" placeholder="CUST" readonly>

							<input type="text" name="nm_pelanggan[${ rowNum }]" id="nm_pelanggan${ rowNum }" class="angka form-control" placeholder="CUST" readonly>
						</td>
						<td style="padding : 12px 20px">
							<input type="text" name="kode_po[${ rowNum }]" id="kode_po${ rowNum }" class="angka form-control" placeholder="kode_po" readonly>
						</td>	

						<td style="padding : 12px 20px">
							<input type="hidden" name="id_po_detail[${ rowNum }]" id="id_po_detail${ rowNum }" class="angka form-control" readonly>
							
							<input type="hidden" name="id_produk[${ rowNum }]" id="id_produk${ rowNum }" class="angka form-control" readonly>

							<textarea rows="2" cols="25" name="text" name="item[${ rowNum }]" id="item${ rowNum }" wrap="soft" disabled> </textarea>

							<!-- <input type="text" name="item[${ rowNum }]" id="item${ rowNum }" class="form-control narrow wrap wrap" placeholder="ITEM" readonly> -->
						</td>		

						<td style="padding : 12px 20px">
							<div class="text-right">
								<input type="text" name="qty[${ rowNum }]" id="qty${ rowNum }" class="angka form-control" value='0' readonly>
							</div>
						</td>		

						<td style="padding : 12px 20px">
							<div class="text-right">
								<input type="text" name="ton[${ rowNum }]" id="ton${ rowNum }" class="angka form-control" value='0' readonly>
							</div>
						</td>		

						<td style="padding : 12px 20px">
							<div class="text-right">
								<input type="text" name="kebutuhan[${ rowNum }]" id="kebutuhan${ rowNum }" class="angka form-control"  value='0' readonly>
							</div>
						</td>		
						<td style="padding : 12px 20px">
							<input type="text" name="history[${ rowNum }]" id="history${ rowNum }" class="angka form-control" value='0' readonly>
						</td>		
						<td style="padding : 12px 20px">
							<input type="text" name="datang[${ rowNum }]" id="datang${ rowNum }" class="angka form-control" onkeyup="ubah_angka(this.value,this.id)" value='0'>
						</td>		
					</tr>
					`);
				$('.select2').select2({
					placeholder: '--- Pilih ---',
					dropdownAutoWidth: true
				});
				$('#bucket').val(rowNum);
				$('#list' + rowNum).focus();
		}else{
			swal({
				title               : "Cek Kembali",
				html                : "Isi form diatas terlebih dahulu",
				type                : "info",
				confirmButtonText   : "OK"
			});
			return;
		}
	}

	function removeRow(e) 
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

		$("#id_pelanggan0").val("")
		$("#nm_pelanggan0").val("")
		$("#kode_po0").val("")
		$("#id_po_detail0").val("")
		$("#id_produk0").val("")
		$("#item0").val("")
		$("#qty0").val("")
		$("#ton0").val("")
		$("#kebutuhan0").val("")
		$("#history0").val("")
		$("#datang0").val("")

	}

	function load_item(id)
	{
		var id1   = id.substr(0,4);
		var id2   = id.substr(4,1);
		var hub   = $('#hub').val()
		

		if (hub == '' || hub == null) 
		{			
			swal.close();
			swal({
				title               : "Cek Kembali",
				html                : "Pilih Hub Dahulu",
				type                : "info",
				confirmButtonText   : "OK"
			});
			return;
		}else{			
			$('.list_item').modal('show');
		}
		
		var table   = $('#tbl_po').DataTable();
		table.destroy();
		tabel = $('#tbl_po').DataTable({
			"processing": true,
			"pageLength": true,
			"paging": true,
			"ajax": {
				"url"   : '<?php echo base_url('Logistik/load_item_po')?>',
				"type"  : "POST",
				"data"  : { id:id2, jenis:'load_po_stok', hub },
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

	function spilldata(id,kd_po,id_name)
	{		
		$.ajax({
			url        : '<?= base_url(); ?>Logistik/load_data_1',
			type       : "POST",
			dataType   : "JSON",
			data       : { id, no:kd_po, jenis:'spill_po' },
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
					// $("#inc_exc").val(data.header.inc_exc).trigger('change');					
					$('#id_pelanggan'+id_name).val(data.header.id_pelanggan);
					$('#nm_pelanggan'+id_name).val(data.header.nm_pelanggan);
					$('#kode_po'+id_name).val(data.header.kode_po);
					$('#id_po_detail'+id_name).val(data.header.id_detail);
					$('#id_produk'+id_name).val(data.header.id_produk);
					$('#item'+id_name).val(data.header.nm_produk);
					$('#qty'+id_name).val(format_angka(data.header.qty));
					$('#ton'+id_name).val(format_angka(data.header.ton));
					$('#kebutuhan'+id_name).val(format_angka(data.header.bhn_bk));
					$('#history'+id_name).val(format_angka(data.header.bhn_bk));
					$('#datang'+id_name).val(format_angka(data.header.bhn_bk));
					swal.close();
					$('.list_item').modal('hide');


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
			"responsive": true,
			"pageLength": 10,
			"language": {
				"emptyTable": "TIDAK ADA DATA.."
			}
		})
	}
	
	function edit_data(id,kd_po)
	{
		$(".row-input").attr('style', '');
		$(".row-list").attr('style', 'display:none');
		$("#sts_input").val('edit');

		$("#btn-simpan").html(`<button type="button" onclick="simpan()" class="btn-tambah-produk btn  btn-primary"><b><i class="fa fa-save" ></i> Update</b> </button>`)

		$.ajax({
			url        : '<?= base_url(); ?>Logistik/load_data_1',
			type       : "POST",
			data       : { id, tbl:'m_kode_kelompok', jenis :'kode_akun',field :'id_kelompok' },
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
					
					$("#id_kelompok").val(data.header.id_kelompok);
					$("#kd_akun").val(data.header.kd_akun).trigger('change');
					$("#kd_kelompok").val(data.header.kd_kelompok);
					$("#kd_kelompok_old").val(data.header.kd_kelompok);
					$("#nm_kelompok").val(data.header.nm_kelompok);

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
		$("#id_pelanggan0").val("")
		$("#nm_pelanggan0").val("")
		$("#kode_po0").val("")
		$("#id_po_detail0").val("")
		$("#id_produk0").val("")
		$("#item0").val("")
		$("#qty0").val("")
		$("#ton0").val("")
		$("#kebutuhan0").val("")
		$("#history0").val("")
		$("#datang0").val("")
		
		swal.close()
	}

	function simpan() 
	{
		var jns       = $("#jns").val();
		var tgl_stok  = $("#tgl_stok").val();
		var hub       = $("#hub").val();
		
		if ( jns== '' || tgl_stok=='' || hub== '' ) 
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
			url        : '<?= base_url(); ?>Logistik/Insert_stok_bb',
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
				if(data.status=='1'){
					// toastr.success('Berhasil Disimpan');
					// swal.close();								
					kosong();
					location.href = "<?= base_url()?>Logistik/Rek_kelompok";
					swal({
						title               : "Data",
						html                : "Berhasil Disimpan",
						type                : "success",
						confirmButtonText   : "OK"
					});
					
				} else if(data.status=='3'){
					// toastr.success('Berhasil Disimpan');
					// swal.close();								
					swal({
						title               : "Gagal Simpan",
						html                : "Kode Sudah Pernah Di Pakai !",
						type                : "error",
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

	function deleteData(id,nm_akun) 
	{
		// let cek = confirm("Apakah Anda Yakin?");
		swal({
			title: "HAPUS PEMBAYARAN",
			html: "<p> Apakah Anda yakin ingin menghapus file ini ?</p><br>"
			+"<strong>" +nm_akun+ " </strong> ",
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
					jenis: 'm_kode_kelompok',
					field: 'id_kelompok'
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
