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

	<section class="content">

		<div class="row">
			<div class="col-md-12">
				<div class="card card-success card-outline" style="padding-bottom:12px">
					<div class="card-header" style="padding:12px">
						<h3 class="card-title" style="font-weight:bold;font-size:18px">CEK PRODUKSI</h3>
					</div>
					<div class="card-body row" style="font-weight:bold;padding:16px 12px 6px">
						<div class="col-md-2">CUSTOMER</div>
						<div class="col-md-10">
							<select id="pilih_cust" class="form-control select2" onchange="pilihPilihan()">
								<?php
									$query = $this->db->query("SELECT*FROM m_pelanggan ORDER BY nm_pelanggan");
									$html ='';
									$html .='<option value="">PILIH</option>';
									foreach($query->result() as $r){
										($r->attn == "-" || $r->attn == "") ? $attn = '' : $attn = ' | '.$r->attn;
										$html .='<option value="'.$r->id_pelanggan.'">'.$r->nm_pelanggan.''.$attn.'</option>';
									}
									echo $html
								?>
							</select>
						</div>
					</div>
					<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
						<div class="col-md-2"></div>
						<div class="col-md-10">
							<div style="font-size:12px;font-style:italic;color:#f00">
								* [JENIS] NAMA ITEM | FLUTE | UKURAN | KUALITAS
							</div>
						</div>
					</div>
					<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
						<div class="col-md-2">ITEMS</div>
						<div class="col-md-10">
							<select id="pilih_items" class="form-control select2" onchange="plhItems()" disabled>
								<option value="">PILIH</option>
							</select>
						</div>
					</div>
					<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
						<div class="col-md-2">NO. PO</div>
						<div class="col-md-10">
							<select id="pilih_no_po" class="form-control select2" onchange="plhPO()" disabled>
								<option value="">PILIH</option>
							</select>
						</div>
					</div>
					<div style="overflow:auto;white-space:nowrap">
						<div class="tampil-pilih"></div>
					</div>
				</div>
			</div>
		</div>

		<div class="card card-list-so">
			<div class="card-header">
				<h3 class="card-title">Gudang</h3>
				<div class="card-tools">
					<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
					<i class="fas fa-minus"></i></button>
				</div>
			</div>

			<div class="card-body">

				<?php if(in_array($this->session->userdata('level'), ['Admin','konsul_keu', 'Gudang','User'])) { ?>
					<a href="<?php echo base_url('Logistik/Gudang/Add')?>" class="btn btn-info"><i class="fa fa-plus"></i> <b>Tambah Data</b></a>
					<br><br>
				<?php } ?>
				
				<table id="datatable" class="table table-bordered table-striped" width="100%">
					<thead class="color-tabel">
						<tr>
							<th style="width:5%">#</th>
							<th style="width:35%">CUSTOMER</th>
							<th style="width:10%">TIPE</th>
							<th style="width:40%">ITEM</th>
							<th style="width:10%">JUMLAH</th>
							<!-- <th>AKSI</th> -->
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>
		</div>
	</section>
</div>

<div class="modal fade" id="modalForm">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="judulForm">DETAIL</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" style="overflow:auto;white-space:nowrap"></div>
		</div>
	</div>
</div>

<script type="text/javascript">
	status ="insert";

	$(document).ready(function () {
		$(".select2").select2()
		load_data()
	});

	function reloadTable() {
		table = $('#datatable').DataTable();
		tabel.ajax.reload(null, false);
	}

	function load_data() {
		let table = $('#datatable').DataTable();
		table.destroy();
		tabel = $('#datatable').DataTable({
			"processing": true,
			"pageLength": true,
			"paging": true,
			"ajax": {
				"url": '<?php echo base_url('Logistik/LoaDataGudang')?>',
				"type": "POST",
			},
			"aLengthMenu": [
				[5, 10, 15, 20, -1],
				[5, 10, 15, 20, "Semua"]
			],	
			responsive: true,
			"pageLength": 10,
			"language": {
				"emptyTable": "Tidak ada data.."
			}
		})
	}

	function rincianDataGudang(gd_id_pelanggan, gd_id_produk, nm_pelanggan, nm_produk) {
		$("#modalForm").modal("show");

		$.ajax({
			url: '<?php echo base_url('Logistik/rincianDataGudang')?>',
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
				gd_id_pelanggan, gd_id_produk
			}),
			success: function(res){
				$("#judulForm").html(nm_pelanggan+' - '+nm_produk)
				$(".modal-body").html(res)
				swal.close()
			}
		})
	}

	function closeGudang(kode_po, id_gudang) {
		$.ajax({
			url: '<?php echo base_url('Logistik/closeGudang')?>',
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
				kode_po, id_gudang
			}),
			success: function(res){
				data = JSON.parse(res)
				if(data.data){
					rincianDataGudang(data.gd_id_pelanggan, data.gd_id_produk, data.nm_pelanggan, data.nm_produk)
					reloadTable()
				}
			}
		})
	}

	function openGudang(kode_po, id_gudang) {
		$.ajax({
			url: '<?php echo base_url('Logistik/openGudang')?>',
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
				kode_po, id_gudang
			}),
			success: function(res){
				data = JSON.parse(res)
				if(data.data){
					rincianDataGudang(data.gd_id_pelanggan, data.gd_id_produk, data.nm_pelanggan, data.nm_produk)
					reloadTable()
				}
			}
		})
	}

	//

	function pilihPilihan()
	{
		$("#pilih_items").html(`<option value="">PILIH</option>`).prop('disabled', true)
		$("#pilih_no_po").html(`<option value="">PILIH</option>`).prop('disabled', true)
		$(".tampil-pilih").html("")
		let pilih_cust = $("#pilih_cust").val()
		console.log("pilih_cust : ", pilih_cust)
		$.ajax({
			url: '<?php echo base_url('Logistik/pilihPilihan')?>',
			type: "POST",
			data: ({
				pilih_cust
			}),
			success: function(res){
				data = JSON.parse(res)
				console.log(data)
				$("#pilih_items").html(data.htmlItem).prop('disabled', false)
				$("#pilih_no_po").html(data.htmlPO).prop('disabled', false)
			}
		})
	}

	function plhItems()
	{
		$("#pilih_no_po").html(`<option value="">PILIH</option>`).prop('disabled', true)
		$(".tampil-pilih").html("")
		let pilih_cust = $("#pilih_cust").val()
		let pilih_items = $("#pilih_items").val()
		$.ajax({
			url: '<?php echo base_url('Logistik/tampilPilihan')?>',
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
				pilih_cust, pilih_items, pilih_no_po: ''
			}),
			success: function(res){
				data = JSON.parse(res)
				console.log(data)
				$("#pilih_no_po").html(data.htmlPO).prop('disabled', false)
				$(".tampil-pilih").html(data.html)
				swal.close()
			}
		})
	}

	function plhPO()
	{
		$(".tampil-pilih").html("")
		let pilih_cust = $("#pilih_cust").val()
		let pilih_items = $("#pilih_items").val()
		let pilih_no_po = $("#pilih_no_po").val()
		$.ajax({
			url: '<?php echo base_url('Logistik/tampilPilihan')?>',
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
				pilih_cust, pilih_items, pilih_no_po
			}),
			success: function(res){
				data = JSON.parse(res)
				console.log(data)
				$(".tampil-pilih").html(data.html)
				swal.close()
			}
		})
	}

</script>
