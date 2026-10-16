<div class="content-wrapper">
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6" style="font-family:Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;" ></div>
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
		<div class="card shadow mb-3 card-list-so">
			<div class="card-header" style="font-family:Cambria;" >
				<h3 class="card-title" style="color:#4e73df;"><b><?= $judul ?></b></h3>
				<div class="card-tools">
					<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
					<i class="fas fa-minus"></i></button>
				</div>
			</div>
			<div class="card-body" style="padding:12px">
				<div style="margin:12px 0;display:flex">
					<!-- <button type="button" class="btn btn-sm btn-info" onclick="kembali()"><i class="fa fa-arrow-left"></i> <b>LIST SO</b></button><div id="btn-header" style="margin-left:6px"></div> -->
					<button type="button" class="btn btn-sm btn-primary" onclick="pRoll('list')"><i class="fas fa-list-ul"></i> <b>LIST</b></button><div id="btn-header" style="margin-left:6px"></div>
					<button type="button" class="btn btn-sm btn-primary" onclick="pRoll('add')"><i class="fas fa-plus"></i> <b>ADD</b></button><div id="btn-header" style="margin-left:6px"></div>
					<button type="button" class="btn btn-sm btn-primary" onclick="pRoll('guna')"><i class="fas fa-minus"></i> <b>PENGGUNAAN</b></button><div id="btn-header" style="margin-left:6px"></div>
				</div>
				<!-- list -->
				<div class="card-list" style="display:none">
					<div class="card-body row" style="padding:12px 6px 3px;font-weight:bold">
						<div class="col-md-1">CORR</div>
						<div class="col-md-2">
							<select id="list_pilih" class="form-control select2">
								<option value="CA">ATAS</option>
								<option value="CB">BAWAH</option>
							</select>
						</div>
						<div class="col-md-9"></div>
					</div>
					<div class="card-body row" style="padding:3px 6px 12px;font-weight:bold">
						<div class="col-md-1">JENIS</div>
						<div class="col-md-2">
							<select id="list_nmker" class="form-control select2">
								<option value="">SEMUA</option>
								<option value="BK">BK</option>
								<option value="BL">BL</option>
								<option value="MC">MC</option>
								<option value="MF">MF</option>
								<option value="MF-A">MF-A</option>
								<option value="MF-B">MF-B</option>
								<option value="MH">MH</option>
								<option value="MH COLOR">MH COLOR</option>
								<option value="ML">ML</option>
								<option value="MN">MN</option>
								<option value="MS">MS</option>
								<option value="MS-A">MS-A</option>
								<option value="MS-B">MS-B</option>
								<option value="MS-C">MS-C</option>
								<option value="TL">TL</option>
								<option value="TL-A">TL-A</option>
								<option value="TL-B">TL-B</option>
								<option value="BKBLTL">BK, BL, TL</option>
								<option value="MHMFMC">MH, MF, MC</option>
								<option value="MLMNMS">ML, MN, MS</option>
							</select>
						</div>
						<div class="col-md-9">
							<button type="button" class="btn btn-primary" onclick="cariListRoll()"><i class="fas fa-search"></i></button>
						</div>
					</div>
					<div class="list-list"></div>
					<div class="list-roll"></div>
				</div>
				<!-- add -->
				<div class="card-add" style="padding-bottom:12px;display:none">
					<div class="card-body row" style="padding:6px;font-weight:bold">
						<div class="col-md-1">PILIH</div>
						<div class="col-md-2">
							<select id="add_pilih" class="form-control select2" onchange="pRoll('add','pilih')">
								<option value="">PILIH</option>
								<option value="PM">PM</option>
								<option value="GUDANG">GUDANG</option>
							</select>
						</div>
						<div class="col-md-9"></div>
					</div>
					<div class="add-pm" style="display:none">
						<div class="card-body row" style="padding:3px 6px 6px;font-weight:bold">
							<div class="col-md-1">TGL. PROD.</div>
							<div class="col-md-2">
								<input type="date" class="form-control" id="tgl_pm">
							</div>
							<div class="col-md-9">
								<button type="button" class="btn btn-primary" onclick="addCari('pm')"><i class="fas fa-search"></i></button>
							</div>
						</div>
					</div>
					<div class="add-gudang" style="display:none">
						<div class="card-body row" style="padding:3px 6px 6px;font-weight:bold">
							<div class="col-md-1">TGL.</div>
							<div class="col-md-2">
								<input type="date" class="form-control" id="tgl_gudang">
							</div>
							<div class="col-md-9">
								<button type="button" class="btn btn-primary" onclick="addCari('gudang')"><i class="fas fa-search"></i></button>
							</div>
						</div>
					</div>
					<div class="add-list"></div>
				</div>
				<!-- guna -->
				<div class="card-guna" style="display:none">
					<div class="row">

						<div class="col-md-12">
							<div class="card card-info card-outline">
								<div class="card-header" style="padding:12px">
									<h3 class="card-title" style="font-weight:bold;font-size:18px">LIST</h3>
								</div>
								<div class="card-body row" style="padding:12px;font-weight:bold">
									<div class="col-md-1">TGL.</div>
									<div class="col-md-2">
										<input type="date" class="form-control" id="tgl_guna" onchange="cariGunaRoll()">
									</div>
									<div class="col-md-9">
										<button type="button" class="btn btn-primary" onclick="cariGunaRoll()"><i class="fas fa-search"></i></button>
									</div>
								</div>
								<div class="guna-list"></div>
								<div class="guna-roll"></div>
							</div>
						</div>


						<div class="col-md-12">
							<div class="card card-success card-outline">
								<div class="card-header" style="padding:12px">
									<h3 class="card-title" style="font-weight:bold;font-size:18px">TAMBAH</h3>
								</div>
								<div class="card-body row" style="padding:12px 12px 3px;font-weight:bold">
									<div class="col-md-1">
										CORR
									</div>
									<div class="col-md-2">
										<select id="s_corr" class="form-control select2">
											<option value="CA">ATAS</option>
											<option value="CB">BAWAH</option>
										</select>
									</div>
									<div class="col-md-9"></div>
								</div>
								<div class="card-body row" style="padding:3px 12px;font-weight:bold">
									<div class="col-md-1">GSM. ROLL</div>
									<div class="col-md-2">
										<input type="number" id="s_gsm" class="form-control" placeholder="GSM" autocomplete="off"">
									</div>
									<div class="col-md-9"></div>
								</div>
								<div class="card-body row" style="padding:3px 12px;font-weight:bold">
									<div class="col-md-1">LBR. ROLL</div>
									<div class="col-md-2">
										<input type="number" id="s_lebar" class="form-control" placeholder="LEBAR" autocomplete="off">
									</div>
									<div class="col-md-9"></div>
								</div>
								<div class="card-body row" style="padding:3px 12px 12px;font-weight:bold">
									<div class="col-md-1">NO. ROLL</div>
									<div class="col-md-2">
										<input type="text" id="s_roll" class="form-control" placeholder="NO. ROLL" autocomplete="off" oninput="this.value=this.value.toUpperCase()">
									</div>
									<div class="col-md-9">
										<button type="button" onclick="planCariRoll()" class="btn btn-primary"><i class="fas fa-search"></i></button>
									</div>
								</div>
								<div class="list-roll2"></div>
							</div>
						</div>


					</div>
				</div>
			</div>
		</div>
	</section>
</div>

<script type="text/javascript">
	status ="insert";
	const urlAuth = '<?= $this->session->userdata('level')?>';

	$(document).ready(function () {
		// load_data()
		$('.select2').select2();
	});

	function reloadTable() {
		table = $('#datatable').DataTable();
		tabel.ajax.reload(null, false);
	}

	function pRoll(opsi, opsi2=''){
		$(".add-list").html('')
		$(".list-list").html('')
		$(".list-roll").html('')
		$(".guna-list").html('')
		$(".guna-roll").html('')
		if(opsi == 'list'){
			$(".card-list").show()
			$(".card-add").hide()
			$(".card-guna").hide()
		}
		if(opsi == 'add'){
			$(".card-list").hide()
			$(".card-add").show()
			$(".card-guna").hide()
			$(".add-pm").hide()
			$(".add-gudang").hide()
			
			if(opsi2 == 'pilih'){
				let add_pilih = $("#add_pilih").val()
				$("#tgl_pm").val('')
				$("#tgl_gudang").val('')
				if(add_pilih == 'PM'){
					$(".add-pm").show()
					$(".add-gudang").hide()
				}
				if(add_pilih == 'GUDANG'){
					$(".add-pm").hide()
					$(".add-gudang").show()
				}
			}
		}
		if(opsi == 'guna'){
			$(".card-list").hide()
			$(".card-add").hide()
			$(".card-guna").show()
		}
	}

	function cariListRoll(){
		$(".list-list").html('')
		$(".list-roll").html('')
		let list_pilih = $("#list_pilih").val()
		let list_nmker = $("#list_nmker").val()
		$.ajax({
			url: '<?php echo base_url('Logistik/cariListRoll')?>',
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
				list_pilih, list_nmker
			}),
			success: function(json){
				data = JSON.parse(json)
				$(".list-list").html(data.html)
				if(data.html){
					swal.close()
				}
			}
		})
	}

	function planCariRoll() {
		let tgl_guna = $("#tgl_guna").val()
		let s_corr = $("#s_corr").val()
		let s_gsm = $("#s_gsm").val()
		let s_lebar = $("#s_lebar").val()
		let s_roll = $("#s_roll").val()
		// let s_l = $("#s_l").val()
		// let s_id = $("#s_id").val()
		$(".list-roll2").html('')
		$.ajax({
			url: '<?php echo base_url('Logistik/planCariRoll')?>',
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
				tgl_guna, s_corr, s_gsm, s_lebar, s_roll
			}),
			success: function(res){
				data = JSON.parse(res)
				$(".list-roll2").html(data.html)
				if(data.html != ''){
					swal.close()
				}
			}
		})
	}

	function btnPatokanRoll(t_cor, width){
		let ptk = $("#ptk_"+t_cor+width).val()
		$.ajax({
			url: '<?php echo base_url('Logistik/btnPatokanRoll')?>',
			type: "POST",
			data: ({
				t_cor, width, ptk
			}),
			success: function(json){
				data = JSON.parse(json)
				if(data.data){
					toastr.success(`<b>${data.msg}</b>`)
					cariListRoll()
				}else{
					toastr.error(`<b>${data.msg}</b>`)
					swal.close()
				}
			}
		})
	}

	function btnListRoll(t_cor, nm_ker, g_label, width, opsi){
		$(".list-roll").html('')
		$.ajax({
			url: '<?php echo base_url('Logistik/btnListRoll')?>',
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
				t_cor, nm_ker, g_label, width, opsi
			}),
			success: function(json){
				data = JSON.parse(json)
				$(".list-roll").html(data.html)
				swal.close()
			}
		})
	}

	function addCari(opsi){
		let tgl_pm = $("#tgl_pm").val()
		let tgl_gudang = $("#tgl_gudang").val()
		$(".add-list").html('')
		$.ajax({
			url: '<?php echo base_url('Logistik/addCari')?>',
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
				opsi, tgl_pm, tgl_gudang
			}),
			success: function(json){
				data = JSON.parse(json)
				$(".add-list").html(data.html)
				swal.close()
			}
		})
	}

	function addRollCorr(opsi){
		let tgl_pm = $("#tgl_pm").val()
		let tgl_gudang = $("#tgl_gudang").val()
		$.ajax({
			url: '<?php echo base_url('Logistik/addRollCorr')?>',
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
				opsi, tgl_pm, tgl_gudang
			}),
			success: function(json){
				data = JSON.parse(json)
				if(data.data){
					toastr.success(`<b>${data.msg}</b>`)
					addCari(opsi)
				}else{
					toastr.error(`<b>${data.msg}</b>`)
					swal.close()
				}
			}
		})
	}

	function editRollCorr(id, pilihan = ''){
		if(pilihan = ''){
			let opsi = $("#add_pilih").val().toLowerCase()
		}
		let corcab = $("#corcab"+id).val()
		$.ajax({
			url: '<?php echo base_url('Logistik/editRollCorr')?>',
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
				id, corcab
			}),
			success: function(json){
				data = JSON.parse(json)
				if(pilihan = ''){
					toastr.success(`<b>BERHASIL!</b>`)
					addCari(opsi)
				}else{
					cariListRoll()
				}
			}
		})
	}

	function cariGunaRoll() {
		let tgl_guna = $("#tgl_guna").val()
		$(".guna-list").html('')
		$(".guna-roll").html('')
		$.ajax({
			url: '<?php echo base_url('Logistik/cariGunaRoll')?>',
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
				tgl_guna
			}),
			success: function(json){
				data = JSON.parse(json)
				$(".guna-list").html(data.html)
				swal.close()
			}
		})
	}

	function bGunaRoll(roll) {
		let tgl_guna = $("#tgl_guna").val()
		$(".guna-roll").html('')
		$.ajax({
			url: '<?php echo base_url('Logistik/bGunaRoll')?>',
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
				tgl_guna, roll
			}),
			success: function(json){
				data = JSON.parse(json)
				$(".guna-roll").html(data.html)
				swal.close()
			}
		})
	}

	function hitungGuna(opsi) {
		let weight = $("#add_weight").val()
		let guna = $("#add_guna").val()
		let sisa = $("#add_sisa").val();
		let hitungGuna = 0
		let hitungSisa = 0
		if(opsi == 'guna'){
			hitungGuna = guna
			hitungSisa = weight - guna;
			(guna == "" || guna == 0 || guna < 0 || hitungSisa < 0) ? $("#add_guna").val('') : $("#add_guna").val(hitungGuna);
			(guna == "" || guna == 0 || guna < 0 || hitungSisa < 0) ? $("#add_sisa").val('') : $("#add_sisa").val(hitungSisa);
		}
		if(opsi == 'sisa'){
			hitungGuna = weight - sisa
			hitungSisa = sisa;
			(sisa == "" || sisa < 0 || hitungGuna < 0 || (sisa == 0 && sisa.length == 2)) ? $("#add_guna").val('') : $("#add_guna").val(hitungGuna);
			(sisa == "" || sisa < 0 || hitungGuna < 0 || (sisa == 0 && sisa.length == 2)) ? $("#add_sisa").val('') : $("#add_sisa").val(hitungSisa);
		}
	}

	function btnGunaSisa(){
		$("#btn-guna-sisa").prop('disabled', true)
		let tgl_guna = $("#tgl_guna").val()
		let roll = $("#add_roll").val()
		let guna = $("#add_guna").val()
		let sisa = $("#add_sisa").val()
		let ket = $("#add_ket").val()
		$.ajax({
			url: '<?php echo base_url('Logistik/btnGunaSisa')?>',
			type: "POST",
			data: ({
				tgl_guna, roll, guna, sisa, ket
			}),
			success: function(json){
				data = JSON.parse(json)
				cariGunaRoll()
				bGunaRoll(roll)
			}
		})
	}

	function delRollGuna(id){
		let roll = $("#add_roll").val()
		$.ajax({
			url: '<?php echo base_url('Logistik/delRollGuna')?>',
			type: "POST",
			data: ({ id, roll }),
			success: function(json){
				data = JSON.parse(json)
				cariGunaRoll()
				bGunaRoll(roll)
			}
		})
	}

	function addListRoll(id){
		let tgl_guna = $("#tgl_guna").val()
		let s_corr = $("#s_corr").val()
		let s_gsm = $("#s_gsm").val()
		let s_lebar = $("#s_lebar").val()
		let s_roll = $("#s_roll").val()
		$.ajax({
			url: '<?php echo base_url('Logistik/addListRoll')?>',
			type: "POST",
			data: ({ tgl_guna, s_corr, s_gsm, s_lebar, s_roll, id }),
			success: function(res){
				data = JSON.parse(res)
				console.log(data)
			}
		})
	}

	function delListRoll(id){
		$.ajax({
			url: '<?php echo base_url('Logistik/delListRoll')?>',
			type: "POST",
			data: ({ id }),
			success: function(res){
				data = JSON.parse(res)
				console.log(data)
			}
		})
	}

</script>
