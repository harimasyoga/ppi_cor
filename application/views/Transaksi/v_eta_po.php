<div class="content-wrapper">
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
			<div class="col-sm-6" style="font-family:Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;" >
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right"></ol>
			</div>
			</div>
		</div>
	</section>
	
	<section class="content" style="padding-bottom:30px">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-6">
					<div class="card card-info card-outline">
						<div class="card-header">
							<h3 class="card-title" style="font-weight:bold">PILIH</h3>
						</div>
						<div class="card-body row" style="padding-bottom:17px;font-weight:bold">
							<div class="col-md-6" style="margin-bottom:3px">
								<button type="button" class="btn btn-block btn-info" onclick="pilihan('tgl','tanggal')"><b>CUST, TANGGAL</b></button>
							</div>
							<div class="col-md-6" style="margin-bottom:3px">
								<button type="button" class="btn btn-block btn-info" onclick="pilihan('all','semua')"><b>SEMUA</b></button>
							</div>
						</div>
					</div>
					<div class="card card-info card-outline">
						<div class="card-header">
							<h3 class="card-title" style="font-weight:bold">RINCIAN</h3>
						</div>
						<div id="tampil-rincian"></div>
					</div>
				</div>
				<div class="col-md-6">
					<div id="tampil-data"></div>
				</div>
			</div>
		</div>
	</section>
</div>

<div class="modal fade" id="modalFormDetail">
	<div class="modal-dialog modal-full">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="judul-detail"></h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" style="overflow:auto;white-space:nowrap">
				<div id="modal-detail-so"></div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function () {
		$("#tampil-rincian").html(``)
		$("#tampil-data").html(``)
		$('.select2').select2();
	});

	function pilihan(ket ,opsi)
	{
		$("#tampil-data").html(``)
		if(ket == 'tgl' && opsi == 'tanggal'){
			$("#tampil-rincian").html(`
				<div class="card-body row" style="padding:12px 12px 6px;font-weight:bold">
					<div class="col-md-2" style="margin-bottom:4px">CUST</div>
					<div class="col-md-10" style="margin-bottom:4px">
						<select id="id_pelanggan" name="id_pelanggan" class="form-control select2">
							<option value="">SEMUA</option>
							<?php
								$query = $this->db->query("SELECT*FROM m_pelanggan ORDER BY nm_pelanggan");
								$html = '';
								foreach($query->result() as $r){
									if($r->attn == '-' && $r->nm_pelanggan != '-'){
										$nm = $r->nm_pelanggan;
									}else if($r->attn != '-' && $r->nm_pelanggan != '-'){
										$nm = $r->nm_pelanggan.' - '.$r->attn;
									}
									$html .= '<option value="'.$r->id_pelanggan.'">'.$nm.' ('.$r->kode_unik.')</option>';
								}
								echo $html;
							?>
						</select>
					</div>
				</div>
				<div class="card-body row" style="padding:0 12px 6px;font-weight:bold">
					<div class="col-md-2" style="margin-bottom:4px">TGL</div>
					<div class="col-md-4" style="margin-bottom:4px">
						<input type="date" id="tgl_po" class="form-control">
					</div>
					<div class="col-md-6"></div>
				</div>
				<div class="card-body row" style="padding:0 12px 12px;font-weight:bold">
					<div class="col-md-2"></div>
					<div class="col-md-10" style="margin-bottom:4px">
						<button type="button" class="btn btn-sm btn-primary" style="font-weight:bold" onclick="cariAllEtaCust()"><i class="fas fa-search"></i> CARI</button>
					</div>
				</div>
			`)
		}else{
			$.ajax({
				url: '<?php echo base_url('Transaksi/pilihanEtaPO')?>',
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
					opsi
				}),
				success: function(res){
					$("#tampil-rincian").html(res)
					swal.close()
				}
			})
		}
		$('.select2').select2();
	}

	function cariAllEtaCust()
	{
		let id_pelanggan = $("#id_pelanggan").val()
		let tgl_po = $("#tgl_po").val()
		$.ajax({
			url: '<?php echo base_url('Transaksi/cariAllEtaCust')?>',
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
				id_pelanggan, tgl_po
			}),
			success: function(res){
				$("#tampil-rincian").html(res)
				swal.close()
			}
		})
	}

	function pilihanEtaPO()
	{
		let id_pelanggan = $("#id_pelanggan").val()
		let tgl_po = $("#tgl_po").val()
		tampilDataEtaPO(id_pelanggan, tgl_po)
	}

	function tampilDataEtaPO(id_pelanggan, tgl)
	{
		$.ajax({
			url: '<?php echo base_url('Transaksi/tampilDataEtaPO')?>',
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
				id_pelanggan, tgl
			}),
			success: function(res){
				$("#tampil-data").html(res)
				swal.close()
			}
		})
	}

</script>
