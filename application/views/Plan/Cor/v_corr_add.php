<div class="content-wrapper">
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
			<div class="col-sm-6">
				<h1><b>Data Plan</b></h1>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
				<li class="breadcrumb-item active" ><a href="#">Corrugator</a></li>
				</ol>
			</div>
			</div>
		</div>
	</section>

	<section class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<div class="card card-info card-outline">
						<div class="card-body row" style="padding-bottom:5px;font-weight:bold">
							<div class="col-md-1">TANGGAL</div>
							<div class="col-md-3">
								<input type="date" id="tgl" class="form-control" onchange="plhShiftMesin()">
							</div>
							<div class="col-md-8" style="padding:0"></div>
						</div>
						<div class="card-body row" style="padding:0 20px 5px;font-weight:bold">
							<div class="col-md-1">SHIFT</div>
							<div class="col-md-3">
								<select id="shift" class="form-control select2" onchange="plhShiftMesin()">
									<option value="">PILIH</option>
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
								</select>
							</div>
							<div class="col-md-8" style="padding:0"></div>
						</div>
						<div class="card-body row" style="padding:0 20px 5px;font-weight:bold">
							<div class="col-md-1">MESIN</div>
							<div class="col-md-3">
								<select id="mesin" class="form-control select2" onchange="plhShiftMesin()">
									<option value="">PILIH</option>
									<option value="CORR1">CORR 1</option>
									<option value="CORR2">CORR 2</option>
								</select>
							</div>
							<div class="col-md-8"></div>
						</div>
						<div class="card-body row" style="padding:0 20px 5px;font-weight:bold">
							<div class="col-md-1"></div>
							<div class="col-md-11" style="font-size:small;font-style:italic;color:#f00">
								* NO. WO | ETA SO | ITEM | CUSTOMER
							</div>
						</div>
						<div class="card-body row" style="padding:0 20px 20px;font-weight:bold">
							<div class="col-md-1">NO. WO</div>
							<div class="col-md-11">
								<select id="no_wo" class="form-control select2" onchange="plhNoWo()"></select>
							</div>
						</div>
					</div>
				</div>

				<div class="col-md-7">
					<div class="card card-secondary card-outline" style="padding-bottom:20px">
						<div class="card-header">
							<h3 class="card-title" style="font-weight:bold">SO</h3>
						</div>
						<div class="card-body row" style="padding-bottom:5px;font-weight:bold">
							<div class="col-md-2">NO. SO</div>
							<div class="col-md-10">
								<input type="text" id="no_so" class="form-control" autocomplete="off" placeholder="NO. SO" disabled>
							</div>
						</div>
						<div class="card-body row" style="padding:0 20px 5px;font-weight:bold">
							<div class="col-md-2">ETA. SO</div>
							<div class="col-md-10">
								<input type="text" id="eta_so" class="form-control" autocomplete="off" placeholder="ETA. SO" disabled>
							</div>
						</div>
						<div class="card-body row" style="padding:0 20px 5px;font-weight:bold">
							<div class="col-md-2">NO. PO</div>
							<div class="col-md-10">
								<input type="text" id="no_po" class="form-control" autocomplete="off" placeholder="NO. PO" disabled>
							</div>
						</div>
						<div class="card-body row" style="padding:0 20px 5px;font-weight:bold">
							<div class="col-md-2">CUSTOMER</div>
							<div class="col-md-10">
								<input type="text" id="customer" class="form-control" autocomplete="off" placeholder="CUSTOMER" disabled>
							</div>
						</div>
						<div class="card-body row" style="padding:0 20px 5px;font-weight:bold">
							<div class="col-md-2">ITEM</div>
							<div class="col-md-10">
								<input type="text" id="item" class="form-control" autocomplete="off" placeholder="NAMA ITEM" disabled>
							</div>
						</div>
						<div class="card-body row" style="padding:0 20px 5px;font-weight:bold">
							<div class="col-md-2">KODE MC</div>
							<div class="col-md-10">
								<input type="text" id="kode_mc" class="form-control" autocomplete="off" placeholder="KODE MC" disabled>
							</div>
						</div>
						<div class="card-body row" style="padding:0 20px 5px;font-weight:bold">
							<div class="col-md-2">PANJANG</div>
							<div class="col-md-4">
								<input type="text" id="panjang_s" class="form-control" autocomplete="off" placeholder="PANJANG" disabled>
							</div>
							<div class="col-md-2">LEBAR</div>
							<div class="col-md-4">
								<input type="text" id="lebar_s" class="form-control" autocomplete="off" placeholder="LEBAR" disabled>
							</div>
						</div>
						<div class="card-body row" style="padding:0 20px 5px;font-weight:bold">
							<div class="col-md-2">CREASING</div>
							<div class="col-md-3">
								<input type="text" id="creasing_1" class="form-control" autocomplete="off" placeholder="0" disabled>
							</div>
							<div class="col-md-3">
								<input type="text" id="creasing_2" class="form-control" autocomplete="off" placeholder="0" disabled>
							</div>
							<div class="col-md-3">
								<input type="text" id="creasing_3" class="form-control" autocomplete="off" placeholder="0" disabled>
							</div>
							<div class="col-md-1" style="padding:0"></div>
						</div>
						<div class="card-body row" style="padding:0 20px 5px;font-weight:bold">
							<div class="col-md-2">KUALITAS</div>
							<div class="col-md-10">
								<input type="text" id="kualitas" class="form-control" autocomplete="off" placeholder="KUALITAS" disabled>
							</div>
						</div>
						<div class="card-body row" style="padding:0 20px 5px;font-weight:bold">
							<div class="col-md-2">FLUTE</div>
							<div class="col-md-10">
								<input type="text" id="flute" class="form-control" autocomplete="off" placeholder="FLUTE" disabled>
							</div>
						</div>

						<br/>
						<div class="card-body row" style="padding:0 20px 5px;font-weight:bold">
							<div class="col-md-2">QTY</div>
							<div class="col-md-10">
								<input type="text" id="qty_so" class="form-control" autocomplete="off" placeholder="QTY SO" disabled>
							</div>
						</div>
						<div class="card-body row" style="padding:0 20px 5px;font-weight:bold">
							<div class="col-md-2">RM</div>
							<div class="col-md-10">
								<input type="text" id="rm_so" class="form-control" autocomplete="off" placeholder="RM SO" disabled>
							</div>
						</div>
						<div class="card-body row" style="padding:0 20px 5px;font-weight:bold">
							<div class="col-md-2">TONASE</div>
							<div class="col-md-10">
								<input type="text" id="ton_so" class="form-control" autocomplete="off" placeholder="TONASE SO" disabled>
							</div>
						</div>
						<div class="card-body row" style="padding:0 20px 5px;font-weight:bold">
							<div class="col-md-2">KET</div>
							<div class="col-md-10">
								<textarea class="form-control" id="ket_so" rows="4" style="resize:none" placeholder="KETERANGAN SO" disabled></textarea>
							</div>
						</div>
					</div>
				</div>

				<div class="col-md-5">
					<div class="card card-info card-outline">
						<div class="card-header">
							<h3 class="card-title" style="font-weight:bold">PLAN</h3>
						</div>
						<div class="card-body row" style="padding:20px 20px 5px;font-weight:bold">
							<div class="col-md-2">SCORE</div>
							<div class="col-md-3">
								<input type="text" id="creasing_wo_1" class="form-control" autocomplete="off" placeholder="0" disabled>
							</div>
							<div class="col-md-3">
								<input type="text" id="creasing_wo_2" class="form-control" autocomplete="off" placeholder="0" disabled>
							</div>
							<div class="col-md-3">
								<input type="text" id="creasing_wo_3" class="form-control" autocomplete="off" placeholder="0" disabled>
							</div>
							<div class="col-md-1" style="padding:0"></div>
						</div>

						<div id="group_ganti_kualitas">
							<div class="card-body row" style="padding:20px 20px 5px;font-weight:bold">
								<div class="col-md-2">SUBCT</div>
								<div class="col-md-10">
									<select id="g_kualitas" class="form-control select2" onchange="ayoBerhitung()">
										<option value="PO">KUALITAS SESUAI PO</option>
										<option value="GANTI">GANTI KUALITAS</option>
									</select>
								</div>
							</div>

							<div id="group_plh_kualitas" style="display:none">
								<div class="card-body row" style="padding:0 20px 5px;font-weight:bold">
									<div class="col-md-2">TL/AL</div>
									<div class="col-md-5">
										<select id="tl_al" class="form-control select2" onchange="ayoBerhitung()">
											<option value="">-</option><option value="M">M</option><option value="K">K</option><option value="MC">MC</option><option value="MN">MN</option>
										</select>
									</div>
									<div class="col-md-5"><input type="text" id="tl_al_i" class="form-control angka" autocomplete="off" maxlength="3" onchange="ayoBerhitung()"></div>
								</div>
								<div class="card-body row" style="padding:0 20px 5px;font-weight:bold">
									<div class="col-md-2">B.MF</div>
									<div class="col-md-5">
										<select id="bmf" class="form-control select2" onchange="ayoBerhitung()">
											<option value="">-</option><option value="M">M</option><option value="K">K</option><option value="MC">MC</option><option value="MN">MN</option>
										</select>
									</div>
									<div class="col-md-5"><input type="text" id="bmf_i" class="form-control angka" autocomplete="off" maxlength="3" onchange="ayoBerhitung()"></div>
								</div>
								<div class="card-body row" style="padding:0 20px 5px;font-weight:bold">
									<div class="col-md-2">B.L</div>
									<div class="col-md-5">
										<select id="bl" class="form-control select2" onchange="ayoBerhitung()">
											<option value="">-</option><option value="M">M</option><option value="K">K</option><option value="MC">MC</option><option value="MN">MN</option>
										</select>
									</div>
									<div class="col-md-5"><input type="text" id="bl_i" class="form-control angka" autocomplete="off" maxlength="3" onchange="ayoBerhitung()"></div>
								</div>
								<div class="card-body row" style="padding:0 20px 5px;font-weight:bold">
									<div class="col-md-2">C.MF</div>
									<div class="col-md-5">
										<select id="cmf" class="form-control select2" onchange="ayoBerhitung()">
											<option value="">-</option><option value="M">M</option><option value="K">K</option><option value="MC">MC</option><option value="MN">MN</option>
										</select>
									</div>
									<div class="col-md-5"><input type="text" id="cmf_i" class="form-control angka" autocomplete="off" maxlength="3" onchange="ayoBerhitung()"></div>
								</div>
								<div class="card-body row" style="padding:0 20px 5px;font-weight:bold">
									<div class="col-md-2">C.L</div>
									<div class="col-md-5">
										<select id="cl" class="form-control select2" onchange="ayoBerhitung()">
											<option value="">-</option><option value="M">M</option><option value="K">K</option><option value="MC">MC</option><option value="MN">MN</option>
										</select>
									</div>
									<div class="col-md-5"><input type="text" id="cl_i" class="form-control angka" autocomplete="off" maxlength="3" onchange="ayoBerhitung()"></div>
								</div>
								<div class="card-body row" style="padding:0 20px 5px;font-weight:bold">
									<div class="col-md-2" style="padding:0"></div>
									<div class="col-md-10">
										<input type="text" id="group_tmpl_kualitas" class="form-control" autocomplete="off" placeholder="GANTI KUALITAS" disabled>
									</div>
								</div>
							</div>
						</div>


						<div class="card-body row" style="padding-bottom:5px;font-weight:bold">
							<div class="col-md-2" style="padding-right:0">L.ROLL</div>
							<div class="col-md-10">
								<input type="number" id="i_lebar_roll" class="form-control" autocomplete="off" placeholder="LEBAR ROLL" onchange="ayoBerhitung()">
							</div>
						</div>
						<div class="card-body row" style="padding:0 20px 5px;font-weight:bold">
							<div class="col-md-2">OUT</div>
							<div class="col-md-10">
								<input type="number" id="out_plan" class="form-control" autocomplete="off" placeholder="OUT" onchange="ayoBerhitung()">
							</div>
						</div>
						<br/>
						<div class="card-body row" style="padding:0 20px 5px;font-weight:bold">
							<div class="col-md-2">TRIM</div>
							<div class="col-md-10">
								<input type="text" id="trim" class="form-control" autocomplete="off" placeholder="TRIM" disabled>
							</div>
						</div>
						<div class="card-body row" style="padding:0 20px 5px;font-weight:bold">
							<div class="col-md-2">QTY</div>
							<div class="col-md-10">
								<input type="text" id="qty_plan" class="form-control" autocomplete="off" placeholder="QTY PLAN" disabled>
							</div>
						</div>
						<div class="card-body row" style="padding:0 20px 5px;font-weight:bold">
							<div class="col-md-2" style="padding-right:0">C.OFF</div>
							<div class="col-md-10">
								<input type="text" id="c_off" class="form-control" autocomplete="off" placeholder="NUM OF CUT" disabled>
							</div>
						</div>
						<div class="card-body row" style="padding:0 20px 5px;font-weight:bold">
							<div class="col-md-2">RM</div>
							<div class="col-md-10">
								<input type="text" id="rm" class="form-control" autocomplete="off" placeholder="RM PLAN" disabled>
							</div>
						</div>
						<div class="card-body row" style="padding:0 20px 5px;font-weight:bold">
							<div class="col-md-2">TON</div>
							<div class="col-md-10">
								<input type="text" id="ton" class="form-control" autocomplete="off" placeholder="TONASE PLAN" disabled>
							</div>
						</div>

						<br/>
						<div class="card-body row" style="padding:0 20px 5px;font-weight:bold">
							<div class="col-md-2" style="padding-right:0">KIRIM</div>
							<div class="col-md-10">
								<input type="date" id="kirim" class="form-control">
							</div>
						</div>
						<div class="card-body row" style="padding:0 20px 5px;font-weight:bold">
							<div class="col-md-2">NEXT</div>
							<div class="col-md-10">
								<select id="next_flexo" class="form-control select2">
									<option value="">PILIH</option>
									<option value="FLEXO1">FLEXO 1</option>
									<option value="FLEXO2">FLEXO 2</option>
									<option value="FLEXO3">FLEXO 3</option>
									<option value="FLEXO4">FLEXO 4</option>
								</select>
							</div>
						</div>

						<br/>
						<div class="card-body row" style="padding:0 20px 20px;font-weight:bold">
							<div class="col-md-12">
								<button type="button" class="btn btn-primary btn-block"><i class="fa fa-save"></i> <b>SIMPAN</b></button>
							</div>
						</div>
					</div>

					<div class="card card-info card-outline">
						<div class="card-header">
							<h3 class="card-title" style="font-weight:bold">PRODUKSI</h3>
						</div>
						<div class="card-body row" style="padding-bottom:5px;font-weight:bold">
							<div class="col-md-2" style="padding:0">GOOD</div>
							<div class="col-md-10">
								<input type="number" id="good" class="form-control" autocomplete="off" placeholder="GOOD">
							</div>
						</div>
						<div class="card-body row" style="padding:0 20px 5px;font-weight:bold">
							<div class="col-md-2" style="padding:0">REJECT</div>
							<div class="col-md-10">
								<input type="number" id="reject" class="form-control" autocomplete="off" placeholder="REJECT">
							</div>
						</div>
						<div class="card-body row" style="padding:0 20px 5px;font-weight:bold">
							<div class="col-md-2" style="padding:0">TOTAL</div>
							<div class="col-md-10">
								<input type="text" id="total_cor" class="form-control" autocomplete="off" placeholder="TOTAL" disabled>
							</div>
						</div>
						<div class="card-body row" style="padding:0 20px 5px;font-weight:bold">
							<div class="col-md-2" style="padding:0">KET</div>
							<div class="col-md-10">
								<textarea class="form-control" id="ket_pro" rows="4" style="resize:none"></textarea>
							</div>
						</div>

						<br/>
						<div class="card-body row" style="padding:0 20px 20px;font-weight:bold">
							<div class="col-md-12">
								<button type="button" class="btn btn-primary btn-block"><i class="fa fa-save"></i> <b>SIMPAN</b></button>
							</div>
						</div>
					</div>
				</div>

			</div>
		</div>
	</section>
</div>

<div class="modal fade" id="modalForm">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="judul"></h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>

			<div class="modal-body" style="overflow:auto;white-space:nowrap">
				
			</div>
			<div class="modal-footer">
				
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	status ="insert";
	$(document).ready(function ()
	{
		$("#no_wo").prop("disabled", true).html(`<option value="">PILIH</option>`)
		$('.select2').select2({
			dropdownAutoWidth: true
		})
	})

	function kosong()
	{
		// 
	}

	function loadPlanWo()
	{
		$("#no_wo").prop("disabled", true).html(`<option value="">PILIH</option>`)
		$.ajax({
			url: '<?php echo base_url('Plan/loadPlanWo')?>',
			type: "POST",
			success: function(res){
				data = JSON.parse(res)
				console.log(data)
				let htmlWO = ''
					htmlWO += `<option value="">PILIH</option>`
				data.wo.forEach(loadWo);
				function loadWo(r, index) {
					htmlWO += `<option value="${r.idWo}"
						id-wo="${r.idWo}"
						id-so="${r.idSoDetail}"
						id-pelanggan="${r.id_pelanggan}"
						id-produk="${r.id_produk}"
						no-wo="${r.no_wo}"
						no-so="${r.no_so}"
						eta-so="${r.eta_so}"
						no-po="${r.no_po}"
						customer="${r.nm_pelanggan}"
						item="${r.nm_produk}"
						kode-mc="${r.kode_mc}"
						panjang-s="${r.ukuran_sheet_p}"
						lebar-s="${r.ukuran_sheet_l}"
						creasing-1="${r.creasing}"
						creasing-2="${r.creasing2}"
						creasing-3="${r.creasing3}"
						kualitas="${r.kualitas}"
						kualitas-isi="${r.kualitas_isi}"
						flute="${r.flute}"
						qty-so="${r.qty_so}"
						rm-so="${r.rm}"
						ton-so="${r.ton}"
						ket-so="${r.ket_so}"
						creasing-wo1="${r.flap1}"
						creasing-wo2="${r.creasing2wo}"
						creasing-wo3="${r.flap2}"
					>
						${r.no_wo} | ${r.eta_so} | ${r.nm_produk} | ${r.nm_pelanggan}
					</option>`
				}
				$("#no_wo").prop("disabled", false).html(htmlWO)
			}
		})
	}

	function plhShiftMesin()
	{
		let tgl = $("#tgl").val()
		let shift = $("#shift").val()
		let mesin = $("#mesin").val()
		if(tgl == '' || shift == '' || mesin == ''){
			$("#no_wo").prop("disabled", true).html(`<option value="">PILIH</option>`)
		}else{
			$("#tgl").prop("disabled", true)
			$("#shift").prop("disabled", true)
			$("#mesin").prop("disabled", true)
			loadPlanWo()
		}
	}

	function plhNoWo()
	{
		let id_wo = $('#no_wo option:selected').attr('id-wo')
		let id_so = $('#no_wo option:selected').attr('id-so')
		let id_pelanggan = $('#no_wo option:selected').attr('id-pelanggan')
		let id_produk = $('#no_wo option:selected').attr('id-produk')
		let no_wo = $('#no_wo option:selected').attr('no-wo')
		let no_so = $('#no_wo option:selected').attr('no-so')
		let eta_so = $('#no_wo option:selected').attr('eta-so')
		let no_po = $('#no_wo option:selected').attr('no-po')
		let customer = $('#no_wo option:selected').attr('customer')
		let item = $('#no_wo option:selected').attr('item')
		let kode_mc = $('#no_wo option:selected').attr('kode-mc')
		let panjang_s = $('#no_wo option:selected').attr('panjang-s')
		let lebar_s = $('#no_wo option:selected').attr('lebar-s')
		let creasing_1 = $('#no_wo option:selected').attr('creasing-1')
		let creasing_2 = $('#no_wo option:selected').attr('creasing-2')
		let creasing_3 = $('#no_wo option:selected').attr('creasing-3')
		let kualitas = $('#no_wo option:selected').attr('kualitas')
		let kualitas_isi = $('#no_wo option:selected').attr('kualitas-isi')
		let flute = $('#no_wo option:selected').attr('flute')
		let qty_so = $('#no_wo option:selected').attr('qty-so')
		let rm_so = $('#no_wo option:selected').attr('rm-so')
		let ton_so = $('#no_wo option:selected').attr('ton-so')
		let ket_so = $('#no_wo option:selected').attr('ket-so')
		let creasing_wo1 = $('#no_wo option:selected').attr('creasing-wo1')
		let creasing_wo2 = $('#no_wo option:selected').attr('creasing-wo2')
		let creasing_wo3 = $('#no_wo option:selected').attr('creasing-wo3')

		$("#no_so").val(no_so)
		$("#eta_so").val(eta_so)
		$("#no_po").val(no_po)
		$("#customer").val(customer)
		$("#item").val(item)
		$("#kode_mc").val(kode_mc)
		$("#panjang_s").val(panjang_s)
		$("#lebar_s").val(lebar_s)
		$("#creasing_1").val(creasing_1)
		$("#creasing_2").val(creasing_2)
		$("#creasing_3").val(creasing_3)
		$("#kualitas").val(kualitas)
		$("#flute").val(flute)
		$("#qty_so").val(qty_so)
		$("#rm_so").val(rm_so)
		$("#ton_so").val(ton_so)
		$("#ket_so").val(ket_so)

		$("#creasing_wo_1").val(creasing_wo1)
		$("#creasing_wo_2").val(creasing_wo2)
		$("#creasing_wo_3").val(creasing_wo3)
		$("#qty_plan").val(qty_so)

		$("#g_kualitas").html(`<option value="PO">KUALITAS SESUAI PO</option><option value="GANTI">GANTI KUALITAS</option>`)
		$("#tl_al").html(`<option value="">-</option><option value="M">M</option><option value="K">K</option><option value="MC">MC</option><option value="MN">MN</option>`).prop('disabled', true)
		$("#tl_al_i").val("").prop('disabled', true)
		$("#bmf").html(`<option value="">-</option><option value="M">M</option><option value="K">K</option><option value="MC">MC</option><option value="MN">MN</option>`).prop('disabled', true)
		$("#bmf_i").val("").prop('disabled', true)
		$("#bl").html(`<option value="">-</option><option value="M">M</option><option value="K">K</option><option value="MC">MC</option><option value="MN">MN</option>`).prop('disabled', true)
		$("#bl_i").val("").prop('disabled', true)
		$("#cmf").html(`<option value="">-</option><option value="M">M</option><option value="K">K</option><option value="MC">MC</option><option value="MN">MN</option>`).prop('disabled', true)
		$("#cmf_i").val("").prop('disabled', true)
		$("#cl").html(`<option value="">-</option><option value="M">M</option><option value="K">K</option><option value="MC">MC</option><option value="MN">MN</option>`).prop('disabled', true)
		$("#cl_i").val("").prop('disabled', true)
		$("#group_plh_kualitas").hide()

		$("#i_lebar_roll").val("")
		$("#out_plan").val("")

		ayoBerhitung()
	}

	function ayoBerhitung()
	{
		let flute = $('#no_wo option:selected').attr('flute')
		let g_kualitas = $("#g_kualitas").val()
		let tl_al = $("#tl_al").val()
		let tl_al_i = $("#tl_al_i").val()
		let bmf = $("#bmf").val()
		let bmf_i = $("#bmf_i").val()
		let bl = $("#bl").val()
		let bl_i = $("#bl_i").val()
		let cmf = $("#cmf").val()
		let cmf_i = $("#cmf_i").val()
		let cl = $("#cl").val()
		let cl_i = $("#cl_i").val()

		let panjang_s = $('#no_wo option:selected').attr('panjang-s')
		let lebar_s = $('#no_wo option:selected').attr('lebar-s')
		let qty_so = $('#no_wo option:selected').attr('qty-so')
		let ton = 0

		if(g_kualitas == 'PO'){
			$("#tl_al").html(`<option value="">-</option><option value="M">M</option><option value="K">K</option><option value="MC">MC</option><option value="MN">MN</option>`).prop('disabled', true)
			$("#tl_al_i").val("").prop('disabled', true)
			$("#bmf").html(`<option value="">-</option><option value="M">M</option><option value="K">K</option><option value="MC">MC</option><option value="MN">MN</option>`).prop('disabled', true)
			$("#bmf_i").val("").prop('disabled', true)
			$("#bl").html(`<option value="">-</option><option value="M">M</option><option value="K">K</option><option value="MC">MC</option><option value="MN">MN</option>`).prop('disabled', true)
			$("#bl_i").val("").prop('disabled', true)
			$("#cmf").html(`<option value="">-</option><option value="M">M</option><option value="K">K</option><option value="MC">MC</option><option value="MN">MN</option>`).prop('disabled', true)
			$("#cmf_i").val("").prop('disabled', true)
			$("#cl").html(`<option value="">-</option><option value="M">M</option><option value="K">K</option><option value="MC">MC</option><option value="MN">MN</option>`).prop('disabled', true)
			$("#cl_i").val("").prop('disabled', true)
			$("#group_plh_kualitas").hide()
			$("#group_tmpl_kualitas").val("")

			let kualitas_isi = $('#no_wo option:selected').attr('kualitas-isi')
			let spltKualitas = kualitas_isi.split("/")
			if(flute == 'BF'){
				ton = parseFloat((parseInt(spltKualitas[0]) + (parseFloat(spltKualitas[1])*1.36) + parseInt(spltKualitas[2])) / 1000 * panjang_s / 1000 * lebar_s / 1000 * qty_so)
			}else if(flute == 'CF'){
				ton = parseFloat((parseInt(spltKualitas[0]) + (parseFloat(spltKualitas[1])*1.46) + parseInt(spltKualitas[2])) / 1000 * panjang_s / 1000 * lebar_s / 1000 * qty_so)
			}else{
				ton = parseFloat((parseInt(spltKualitas[0]) + (parseFloat(spltKualitas[1])*1.36) + parseInt(spltKualitas[2]) + (parseFloat(spltKualitas[3])*1.46) + parseInt(spltKualitas[4])) / 1000 * panjang_s / 1000 * lebar_s / 1000 * qty_so)
			}
			let i_g_kualitas = ''
		}else{
			$("#tl_al").prop('disabled', false)
			$("#tl_al_i").prop('disabled', false)
			$("#cl").prop('disabled', false)
			$("#cl_i").prop('disabled', false)
			if(flute == 'BF'){
				$("#bmf").prop('disabled', false)
				$("#bmf_i").prop('disabled', false)
				$("#bl").prop('disabled', true)
				$("#bl_i").prop('disabled', true)
				$("#cmf").prop('disabled', true)
				$("#cmf_i").prop('disabled', true)

				let editKualitas = tl_al+tl_al_i+'/'+bmf+bmf_i+'/'+cl+cl_i;
				
				(tl_al == '' || tl_al_i == '' || bmf == '' || bmf_i == '' || cl == '' || cl_i == '' || tl_al == 0 || tl_al_i == 0 || bmf == 0 || bmf_i == 0 || cl == 0 || cl_i == 0) ? $("#group_tmpl_kualitas").val("") : $("#group_tmpl_kualitas").val(editKualitas);
				(tl_al == '' || tl_al_i == '' || bmf == '' || bmf_i == '' || cl == '' || cl_i == '' || tl_al == 0 || tl_al_i == 0 || bmf == 0 || bmf_i == 0 || cl == 0 || cl_i == 0) ?
					ton = 0 :
					ton = parseFloat((parseInt(tl_al_i) + (parseFloat(bmf_i)*1.36) + parseInt(cl_i)) / 1000 * panjang_s / 1000 * lebar_s / 1000 * qty_so);
			}else if(flute == 'CF'){
				$("#bmf").prop('disabled', true)
				$("#bmf_i").prop('disabled', true)
				$("#bl").prop('disabled', true)
				$("#bl_i").prop('disabled', true)
				$("#cmf").prop('disabled', false)
				$("#cmf_i").prop('disabled', false)

				let editKualitas = tl_al+tl_al_i+'/'+cmf+cmf_i+'/'+cl+cl_i;
				(tl_al == '' || tl_al_i == '' || cmf == '' || cmf_i == '' || cl == '' || cl_i == '' || tl_al == 0 || tl_al_i == 0 || cmf == 0 || cmf_i == 0 || cl == 0 || cl_i == 0) ? $("#group_tmpl_kualitas").val("") : $("#group_tmpl_kualitas").val(editKualitas);
				(tl_al == '' || tl_al_i == '' || cmf == '' || cmf_i == '' || cl == '' || cl_i == '' || tl_al == 0 || tl_al_i == 0 || cmf == 0 || cmf_i == 0 || cl == 0 || cl_i == 0) ?
					ton = 0 :
					ton = parseFloat((parseInt(tl_al_i) + (parseFloat(cmf_i)*1.46) + parseInt(cl_i)) / 1000 * panjang_s / 1000 * lebar_s / 1000 * qty_so);
			}else if(flute == 'BCF'){
				$("#bmf").prop('disabled', false)
				$("#bmf_i").prop('disabled', false)
				$("#bl").prop('disabled', false)
				$("#bl_i").prop('disabled', false)
				$("#cmf").prop('disabled', false)
				$("#cmf_i").prop('disabled', false)

				let editKualitas = tl_al+tl_al_i+'/'+bmf+bmf_i+'/'+bl+bl_i+'/'+cmf+cmf_i+'/'+cl+cl_i;
				(tl_al == '' || tl_al_i == '' || bmf == '' || bmf_i == '' || bl == '' || bl_i == '' || cmf == '' || cmf_i == '' || cl == '' || cl_i == '' || tl_al == 0 || tl_al_i == 0 || bmf == 0 || bmf_i == 0 || bl == 0 || bl_i == 0 || cmf == 0 || cmf_i == 0 || cl == 0 || cl_i == 0) ? $("#group_tmpl_kualitas").val("") : $("#group_tmpl_kualitas").val(editKualitas);
				(tl_al == '' || tl_al_i == '' || bmf == '' || bmf_i == '' || bl == '' || bl_i == '' || cmf == '' || cmf_i == '' || cl == '' || cl_i == '' || tl_al == 0 || tl_al_i == 0 || bmf == 0 || bmf_i == 0 || bl == 0 || bl_i == 0 || cmf == 0 || cmf_i == 0 || cl == 0 || cl_i == 0) ?
					ton = 0 :
					ton = parseFloat((parseInt(tl_al_i) + (parseFloat(bmf_i)*1.36) + parseInt(bl_i) + (parseFloat(cmf_i)*1.46) + parseInt(cl_i)) / 1000 * panjang_s / 1000 * lebar_s / 1000 * qty_so) ;
			}else{
				$("#tl_al").prop('disabled', true)
				$("#tl_al_i").prop('disabled', true)
				$("#bmf").prop('disabled', true)
				$("#bmf_i").prop('disabled', true)
				$("#bl").prop('disabled', true)
				$("#bl_i").prop('disabled', true)
				$("#cmf").prop('disabled', true)
				$("#cmf_i").prop('disabled', true)
				$("#cl").prop('disabled', true)
				$("#cl_i").prop('disabled', true)
				$("#group_tmpl_kualitas").val("")
				ton = 0
			}

			$("#group_plh_kualitas").show()
			let i_g_kualitas = $("#group_tmpl_kualitas").val()
		}

		let i_lebar_roll = $("#i_lebar_roll").val()
		let out_plan = $("#out_plan").val()

		let trim = 0;
		(i_lebar_roll == '' || out_plan == '' || i_lebar_roll == 0 || out_plan == 0) ? 
			trim = 0 :
			trim = i_lebar_roll - (lebar_s * out_plan);
		
		let c_off = 0;
		(out_plan == '' || out_plan == 0) ?
			c_off = 0 :
			c_off = qty_so / out_plan;

		let rm = 0;
		(c_off == '' || c_off == 0) ?
			rm = 0 :
			rm = Math.round((c_off * panjang_s) / 1000);
		// $("#qty_plan").val()
		// $("#c_off").val()
		// $("#rm").val()
		// $("#ton").val(ton)
		// console.log("i_lebar_roll : ", i_lebar_roll)
		// console.log("out_plan : ", out_plan)
		console.log("trim : ", trim)
		// console.log("qty_plan : ", qty_plan)
		console.log("c_off : ", c_off)
		console.log("rm : ", rm)
		console.log("ton : ", ton)

		// TRIM

	}

</script>
