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
							<input type="hidden" class="angka form-control" name="sts_input" id="sts_input" >
							<input type="hidden" class="angka form-control" name="id_kelompok" id="id_kelompok" >
							
							<input type="hidden" class="angka form-control" name="kd_kelompok_old" id="kd_kelompok_old" maxlength="2">

							<input type="text" class="angka form-control" name="kd_kelompok" id="kd_kelompok" value="AUTO" readonly>
						</div>

						<div class="col-md-5"></div>
					</div>

					<div class="card-body row" style="padding : 5px;font-weight:bold">
						<div class="col-md-1"></div>
							
						<div class="col-md-2">JENIS</div>
						<div class="col-md-4">
							<select class="form-control select2" name="kd_akun" id="kd_akun">
								<option value="stok">STOK PPI</option>
								<option value="po">BAHAN BAKU PO</option>
							</select>
						</div>

						<div class="col-md-5"></div>
					</div>
					
					<div class="card-body row" style="padding : 5px;font-weight:bold">
						<div class="col-md-1"></div>
							
						<div class="col-md-2">TANGGAL</div>
						<div class="col-md-4">
							<input type="date" class="form-control" name="nm_kelompok" id="nm_kelompok" oninput="this.value = this.value.toUpperCase()" >
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
							<table class="table table-hover table-striped table-bordered table-scrollable table-condensed" id="table-produk" width="100%">
								<thead class="color-tabel">
									<tr>
										<th id="header_del">Delete</th>
										<th style="padding : 12px 20px" >LIST </th>
										<th style="padding : 12px 20px" >Customer </th>
										<th style="padding : 12px 40px" >KODE PO</th>
										<th style="padding : 12px 40px" >ITEM</th>
										<th style="padding : 12px 15px" >QTY</th>
										<th style="padding : 12px 15px" >TON</th>
										<th style="padding : 12px 15px" >Kebutuhan</th>
										<th style="padding : 12px 15px" >History</th>
										<th style="padding : 12px 15px" >Kedatangan</th>
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
												<button type="button" title="PILIH"  onclick="load_item(this.id)" class="btn btn-success btn-sm" data-toggle="modal"  data-target=".list_item" name="list[0]" id="list0">
													<i class="fas fa-check-circle"></i>
												</button> 
												
											</div>
										</td>
										<td style="padding : 12px 20px" >
											<input type="text" name="id_pelanggan[0]" id="id_pelanggan0" class="angka form-control" placeholder="CUST" readonly>

											<input type="text" name="nm_pelanggan[0]" id="nm_pelanggan0" class="angka form-control" placeholder="CUST" readonly>

										</td>
										<td style="padding : 12px 20px">
											<input type="text" name="kode_po[0]" id="kode_po0" class="angka form-control" placeholder="kode_po" readonly>

										</td>										
										<td style="padding : 12px 20px">
											<input type="hidden" name="id_po_detail[0]" id="id_po_detail0" class="angka form-control" readonly>
											
											<input type="hidden" name="id_produk[0]" id="id_produk0" class="angka form-control" readonly>

											<input type="text" name="item[0]" id="item0" class="angka form-control" placeholder="ITEM" readonly>
										</td>		

										<td style="padding : 12px 20px">
											<input type="text" name="qty[0]" id="qty0" class="angka form-control" value='0' readonly>
										</td>		

										<td style="padding : 12px 20px">
											<input type="text" name="ton[0]" id="ton0" class="angka form-control" value='0' readonly>
										</td>		

										<td style="padding : 12px 20px">
											<input type="text" name="kebutuhan[0]" id="kebutuhan0" class="angka form-control"  value='0' readonly>
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
                <h5><b>Pilih Invoice</b></h5>
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
	let statusInput = 'insert';
	const urlAuth = '<?= $this->session->userdata('level')?>';

	$(document).ready(function ()
	{
		kosong()
		load_data()
		$('.select2').select2();
	});

	function load_item(id)
	{
		var id1   = id.substr(0,4);
		var id2   = id.substr(4,1);
		
		var table = $('#tbl_po').DataTable();
		table.destroy();
		tabel = $('#tbl_po').DataTable({
			"processing": true,
			"pageLength": true,
			"paging": true,
			"ajax": {
				"url"   : '<?php echo base_url('Logistik/load_item_po')?>',
				"type"  : "POST",
				"data"  : { id:id2, jenis:'load_po_stok' },
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
		alert(id)
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
		statusInput = 'insert'
		$("#sts_input").val("")
		$("#id_akun").val("")
		$("#kode_akun").val("")
		$("#nm_akun").val("")
		swal.close()
	}

	function simpan() 
	{
		var kd_akun       = $("#kd_akun").val();
		var kd_kelompok   = $("#kd_kelompok").val();
		var nm_kelompok   = $("#nm_kelompok").val();

		if ( kd_akun=='' || kd_kelompok=='' || nm_kelompok== '' ) 
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
			url        : '<?= base_url(); ?>Logistik/Insert_kode_kelompok',
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