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

	<section class="content" style="padding-bottom:30px">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<div class="card card-info card-outline">
						<div class="card-header">
							<h3 class="card-title" style="font-weight:bold;font-style:italic">WO</h3>
						</div>
						<div class="card-body row" style="padding-bottom:5px;font-weight:bold">
							<div class="col-md-1"></div>
							<div class="col-md-11" style="font-size:small;font-style:italic;color:#f00">
								* NO. WO | ETA SO | ITEM | CUSTOMER
							</div>
						</div>
						<div class="card-body row" style="padding:0 20px 5px;font-weight:bold">
							<div class="col-md-1">NO. WO</div>
							<div class="col-md-11">
								<select id="no_wo" class="form-control select2" onchange="plhNoWo()"></select>
							</div>
						</div>
						<div class="card-body row" style="padding:0 20px 5px;font-weight:bold">
							<div class="col-md-1">TGL. WO</div>
							<div class="col-md-11">
								<input type="date" id="tgl_wo" class="form-control" autocomplete="off" placeholder="TGL. WO" disabled>
							</div>
						</div>
						<div class="card-body row" style="padding:0 20px 17px;font-weight:bold">
							<div class="col-md-1">SCORE</div>
							<div class="col-md-2" style="margin-bottom:3px">
								<input type="number" id="creasing_wo_1" class="form-control" autocomplete="off" placeholder="0" disabled>
							</div>
							<div class="col-md-2" style="margin-bottom:3px">
								<input type="number" id="creasing_wo_2" class="form-control" autocomplete="off" placeholder="0" disabled>
							</div>
							<div class="col-md-2" style="margin-bottom:3px">
								<input type="number" id="creasing_wo_3" class="form-control" autocomplete="off" placeholder="0" disabled>
							</div>
							<div class="col-md-5" style="padding:0"></div>
						</div>
					</div>
				</div>

				<!-- <div class="col-md-12">
					<div id="list-rencana-plan"></div>
				</div> -->

				<div class="col-md-7">
					<div id="list-rencana-plan"></div>

					<div class="card card-secondary card-outline" style="padding-bottom:20px">
						<div class="card-header">
							<h3 class="card-title" style="font-weight:bold;font-style:italic">PO</h3>
						</div>
						<div class="card-body row" style="padding-bottom:5px;font-weight:bold">
							<div class="col-md-2" style="padding-right: 0;">CUSTOMER</div>
							<div class="col-md-10">
								<input type="text" id="customer" class="form-control" autocomplete="off" placeholder="CUSTOMER" disabled>
							</div>
						</div>
						<div class="card-body row" style="padding:0 20px 20px;font-weight:bold">
							<div class="col-md-2" style="padding-right: 0;">SALES</div>
							<div class="col-md-10">
								<input type="text" id="sales" class="form-control" autocomplete="off" placeholder="SALES" disabled>
							</div>
						</div>
						<div class="card-body row" style="padding:0 20px 5px;font-weight:bold">
							<div class="col-md-2">TGL. PO</div>
							<div class="col-md-10">
								<input type="date" id="tgl_po" class="form-control" autocomplete="off" placeholder="TANGGAL PO" disabled>
							</div>
						</div>
						<div class="card-body row" style="padding:0 20px 5px;font-weight:bold">
							<div class="col-md-2">NO. PO</div>
							<div class="col-md-10">
								<input type="text" id="no_po" class="form-control" autocomplete="off" placeholder="NO. PO" disabled>
							</div>
						</div>
						<div class="card-body row" style="padding:0 20px 5px;font-weight:bold">
							<div class="col-md-2">KODE PO</div>
							<div class="col-md-10">
								<input type="text" id="kode_po" class="form-control" autocomplete="off" placeholder="KODE PO" disabled>
							</div>
						</div>
						<div class="card-body row" style="padding:0 20px 5px;font-weight:bold">
							<div class="col-md-2">QTY PO</div>
							<div class="col-md-10">
								<input type="number" id="qty_po" class="form-control" autocomplete="off" placeholder="QTY PO" disabled>
							</div>
						</div>
					</div>

					<div class="card card-secondary card-outline" style="padding-bottom:20px">
						<div class="card-header">
							<h3 class="card-title" style="font-weight:bold;font-style:italic">SO</h3>
						</div>
						<div class="card-body row" style="padding-bottom:5px;font-weight:bold">
							<div class="col-md-2">ETA. SO</div>
							<div class="col-md-10">
								<input type="date" id="eta_so" class="form-control" autocomplete="off" placeholder="ETA. SO" disabled>
							</div>
						</div>
						<div class="card-body row" style="padding:0 20px 5px;font-weight:bold">
							<div class="col-md-2">NO. SO</div>
							<div class="col-md-10">
								<input type="text" id="no_so" class="form-control" autocomplete="off" placeholder="NO. SO" disabled>
							</div>
						</div>
						<div class="card-body row" style="padding:0 20px 20px;font-weight:bold">
							<div class="col-md-2">QTY SO</div>
							<div class="col-md-10">
								<input type="number" id="qty_so" class="form-control" autocomplete="off" placeholder="QTY SO" disabled>
							</div>
						</div>
						<div class="card-body row" style="padding:0 20px 5px;font-weight:bold">
							<div class="col-md-2">RM</div>
							<div class="col-md-10">
								<input type="number" id="rm_so" class="form-control" autocomplete="off" placeholder="RM SO" disabled>
							</div>
						</div>
						<div class="card-body row" style="padding:0 20px 5px;font-weight:bold">
							<div class="col-md-2">TONASE</div>
							<div class="col-md-10">
								<input type="number" id="ton_so" class="form-control" autocomplete="off" placeholder="TONASE SO" disabled>
							</div>
						</div>
						<div class="card-body row" style="padding:0 20px 5px;font-weight:bold">
							<div class="col-md-2">KET</div>
							<div class="col-md-10">
								<textarea class="form-control" id="ket_so" rows="2" style="resize:none" placeholder="KETERANGAN SO" disabled></textarea>
							</div>
						</div>
					</div>

					<div class="card card-secondary card-outline" style="padding-bottom:20px">
						<div class="card-header">
							<h3 class="card-title" style="font-weight:bold;font-style:italic">ITEM</h3>
						</div>
						<div class="card-body row" style="padding-bottom:5px;font-weight:bold">
							<div class="col-md-2">KODE MC</div>
							<div class="col-md-10">
								<input type="text" id="kode_mc" class="form-control" autocomplete="off" placeholder="KODE MC" disabled>
							</div>
						</div>
						<div class="card-body row" style="padding:0 20px 20px;font-weight:bold">
							<div class="col-md-2">ITEM</div>
							<div class="col-md-10">
								<input type="text" id="item" class="form-control" autocomplete="off" placeholder="NAMA ITEM" disabled>
							</div>
						</div>
						<div class="card-body row" style="padding:0 20px 5px;font-weight:bold">
							<div class="col-md-2">UK. BOX</div>
							<div class="col-md-10">
								<input type="text" id="uk_box" class="form-control" autocomplete="off" placeholder="UKURAN BOX" disabled>
							</div>
						</div>
						<div class="card-body row" style="padding:0 20px 5px;font-weight:bold">
							<div class="col-md-2">UK. SHEET</div>
							<div class="col-md-10">
								<input type="text" id="uk_sheet" class="form-control" autocomplete="off" placeholder="UKURAN SHEET" disabled>
							</div>
						</div>
						<div class="card-body row" style="padding:0 20px 2px;font-weight:bold">
							<div class="col-md-2">CREASING</div>
							<div class="col-md-3" style="margin-bottom:3px">
								<input type="number" id="creasing_1" class="form-control" autocomplete="off" placeholder="0" disabled>
							</div>
							<div class="col-md-3" style="margin-bottom:3px">
								<input type="number" id="creasing_2" class="form-control" autocomplete="off" placeholder="0" disabled>
							</div>
							<div class="col-md-3" style="margin-bottom:3px">
								<input type="number" id="creasing_3" class="form-control" autocomplete="off" placeholder="0" disabled>
							</div>
							<div class="col-md-1" style="padding:0"></div>
						</div>
						<div class="card-body row" style="padding:0 20px 5px;font-weight:bold">
							<div class="col-md-2">KUALITAS</div>
							<div class="col-md-10">
								<input type="text" id="kualitas" class="form-control" autocomplete="off" placeholder="KUALITAS" disabled>
							</div>
						</div>
						<div class="card-body row" style="padding:0 20px 20px;font-weight:bold">
							<div class="col-md-2">FLUTE</div>
							<div class="col-md-10">
								<input type="text" id="flute" class="form-control" autocomplete="off" placeholder="FLUTE" disabled>
							</div>
						</div>
						<div class="card-body row" style="padding:0 20px 5px;font-weight:bold">
							<div class="col-md-2">TIPE BOX</div>
							<div class="col-md-10">
								<input type="text" id="tipe_box" class="form-control" autocomplete="off" placeholder="TIPE BOX" disabled>
							</div>
						</div>
						<div class="card-body row" style="padding:0 20px 20px;font-weight:bold">
							<div class="col-md-2" style="padding-right:0">SAMBUNGAN</div>
							<div class="col-md-10">
								<input type="text" id="sambungan" class="form-control" autocomplete="off" placeholder="SAMBUNGAN" disabled>
							</div>
						</div>
						<div class="card-body row" style="padding:0 20px 5px;font-weight:bold">
							<div class="col-md-2" style="padding-right:0">BB</div>
							<div class="col-md-10">
								<input type="text" id="bb_box" class="form-control" autocomplete="off" placeholder="BERAT BOX" disabled>
							</div>
						</div>
						<div class="card-body row" style="padding:0 20px 5px;font-weight:bold">
							<div class="col-md-2" style="padding-right:0">LB</div>
							<div class="col-md-10">
								<input type="text" id="lb_box" class="form-control" autocomplete="off" placeholder="LUAS BOX" disabled>
							</div>
						</div>
					</div>
				</div>

				<div class="col-md-5">
					<!-- <div style="position:sticky;top:10px"> -->
					<div class="card card-info card-outline">
						<div class="card-header">
							<h3 class="card-title" style="font-weight:bold;font-style:italic">PLAN</h3>
						</div>
						<div class="card-body row" style="padding-bottom:5px;font-weight:bold">
							<div class="col-md-2">TGL</div>
							<div class="col-md-10">
								<input type="date" id="tgl" class="form-control" onchange="plhShiftMesin()">
							</div>
						</div>
						<div class="card-body row" style="padding:0 20px 5px;font-weight:bold">
							<div class="col-md-2">SHIFT</div>
							<div class="col-md-10">
								<select id="shift" class="form-control select2" onchange="plhShiftMesin()">
									<option value="">PILIH</option>
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
								</select>
							</div>
						</div>
						<div class="card-body row" style="padding:0 20px 5px;font-weight:bold">
							<div class="col-md-2">MESIN</div>
							<div class="col-md-10">
								<select id="mesin" class="form-control select2" onchange="plhShiftMesin()">
									<option value="">PILIH</option>
									<option value="CORR1">CORR 1</option>
									<option value="CORR2">CORR 2</option>
								</select>
							</div>
						</div>

						<div id="group_ganti_kualitas">
							<div class="card-body row" style="padding:20px 20px 5px;font-weight:bold">
								<input type="hidden" id="input_material_plan" value="">
								<input type="hidden" id="input_kualitas_plan" value="">
								<input type="hidden" id="input_kualitas_plan_isi" value="">
								<div class="col-md-2">GANTI</div>
								<div class="col-md-10">
									<select id="g_kualitas" class="form-control select2" onchange="ayoBerhitung()">
										<option value="PO">KUALITAS SESUAI PO</option>
										<option value="GANTI">GANTI KUALITAS</option>
									</select>
								</div>
							</div>

							<div id="group_plh_kualitas" style="display:none">
								<div class="card-body row" style="padding:0 20px 2px;font-weight:bold">
									<div class="col-md-2">TL/AL</div>
									<div class="col-md-5" style="margin-bottom:3px">
										<select id="tl_al" class="form-control select2" onchange="ayoBerhitung()">
											<option value="">-</option><option value="M">M</option><option value="K">K</option><option value="MC">MC</option><option value="MN">MN</option>
										</select>
									</div>
									<div class="col-md-5" style="margin-bottom:3px"><input type="number" id="tl_al_i" class="form-control angka" autocomplete="off" maxlength="3" onchange="ayoBerhitung()"></div>
								</div>
								<div class="card-body row" style="padding:0 20px 2px;font-weight:bold">
									<div class="col-md-2">B.MF</div>
									<div class="col-md-5" style="margin-bottom:3px">
										<select id="bmf" class="form-control select2" onchange="ayoBerhitung()">
											<option value="">-</option><option value="M">M</option><option value="K">K</option><option value="MC">MC</option><option value="MN">MN</option>
										</select>
									</div>
									<div class="col-md-5" style="margin-bottom:3px"><input type="number" id="bmf_i" class="form-control angka" autocomplete="off" maxlength="3" onchange="ayoBerhitung()"></div>
								</div>
								<div class="card-body row" style="padding:0 20px 2px;font-weight:bold">
									<div class="col-md-2">B.L</div>
									<div class="col-md-5" style="margin-bottom:3px">
										<select id="bl" class="form-control select2" onchange="ayoBerhitung()">
											<option value="">-</option><option value="M">M</option><option value="K">K</option><option value="MC">MC</option><option value="MN">MN</option>
										</select>
									</div>
									<div class="col-md-5" style="margin-bottom:3px"><input type="number" id="bl_i" class="form-control angka" autocomplete="off" maxlength="3" onchange="ayoBerhitung()"></div>
								</div>
								<div class="card-body row" style="padding:0 20px 2px;font-weight:bold">
									<div class="col-md-2">C.MF</div>
									<div class="col-md-5" style="margin-bottom:3px">
										<select id="cmf" class="form-control select2" onchange="ayoBerhitung()">
											<option value="">-</option><option value="M">M</option><option value="K">K</option><option value="MC">MC</option><option value="MN">MN</option>
										</select>
									</div>
									<div class="col-md-5" style="margin-bottom:3px"><input type="number" id="cmf_i" class="form-control angka" autocomplete="off" maxlength="3" onchange="ayoBerhitung()"></div>
								</div>
								<div class="card-body row" style="padding:0 20px 2px;font-weight:bold">
									<div class="col-md-2">C.L</div>
									<div class="col-md-5" style="margin-bottom:3px">
										<select id="cl" class="form-control select2" onchange="ayoBerhitung()">
											<option value="">-</option><option value="M">M</option><option value="K">K</option><option value="MC">MC</option><option value="MN">MN</option>
										</select>
									</div>
									<div class="col-md-5" style="margin-bottom:3px"><input type="number" id="cl_i" class="form-control angka" autocomplete="off" maxlength="3" onchange="ayoBerhitung()"></div>
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
							<div class="col-md-2" style="padding:0">PANJANG</div>
							<div class="col-md-10">
								<input type="number" id="ii_panjang" class="form-control" autocomplete="off" placeholder="PANJANG SHEET" onchange="ayoBerhitung()">
							</div>
						</div>
						<div class="card-body row" style="padding:0 20px 5px;font-weight:bold">
							<div class="col-md-2">LEBAR</div>
							<div class="col-md-10">
								<input type="number" id="ii_lebar" class="form-control" autocomplete="off" placeholder="LEBAR SHEET" onchange="ayoBerhitung()">
							</div>
						</div>
						<div class="card-body row" style="padding:0 20px 5px;font-weight:bold">
							<div class="col-md-2" style="padding-right:0">L. ROLL</div>
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
							<div class="col-md-2">QTY</div>
							<div class="col-md-10">
								<input type="number" id="qty_plan" class="form-control" autocomplete="off" placeholder="QTY PLAN" disabled>
							</div>
						</div>
						<div class="card-body row" style="padding:0 20px 5px;font-weight:bold">
							<div class="col-md-2">TRIM</div>
							<div class="col-md-10">
								<input type="number" id="trim" class="form-control" autocomplete="off" placeholder="TRIM" disabled>
							</div>
						</div>
						<div class="card-body row" style="padding:0 20px 5px;font-weight:bold">
							<div class="col-md-2" style="padding-right:0">C.OFF</div>
							<div class="col-md-10">
								<input type="number" id="c_off" class="form-control" autocomplete="off" placeholder="NUM OF CUT" disabled>
							</div>
						</div>
						<div class="card-body row" style="padding:0 20px 5px;font-weight:bold">
							<div class="col-md-2">RM</div>
							<div class="col-md-10">
								<input type="number" id="rm" class="form-control" autocomplete="off" placeholder="RM PLAN" disabled>
							</div>
						</div>
						<div class="card-body row" style="padding:0 20px 5px;font-weight:bold">
							<div class="col-md-2">TON</div>
							<div class="col-md-10">
								<input type="number" id="ton" class="form-control" autocomplete="off" placeholder="TONASE PLAN" disabled>
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
								<button type="button" class="btn btn-success btn-block" onclick="addRencanaPlan()"><i class="fa fa-plus"></i> <b>ADD PLAN</b></button>
							</div>
						</div>
					</div>
				<!-- </div> -->
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
				<div id="show-list-plh-item"></div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	status ="insert";
	$(document).ready(function ()
	{
		$("#list-rencana-plan").load("<?php echo base_url('Plan/destroyPlan') ?>")
		$("#no_wo").prop("disabled", true).html(`<option value="">PILIH</option>`)
		$('.select2').select2({
			dropdownAutoWidth: true
		})
	})

	function kosong()
	{
		// 
	}

	function addRencanaPlan()
	{
		let tgl_plan = $("#tgl").val()
		let machine_plan = $("#mesin").val()
		let shift_plan = $("#shift").val()
		if(tgl_plan == '' || machine_plan == '' || shift_plan == ''){
			toastr.error('<b>PILIH PLAN!</b>');
			return
		}

		let id_so_detail = $('#no_wo option:selected').attr('id-so')
		let id_wo = $('#no_wo option:selected').attr('id-wo')
		let id_produk = $('#no_wo option:selected').attr('id-produk')
		let id_pelanggan = $('#no_wo option:selected').attr('id-pelanggan')
		let no_wo = $('#no_wo option:selected').attr('no-wo')
		if(id_so_detail == undefined || id_wo == undefined || id_produk == undefined || id_pelanggan == undefined || no_wo == undefined){
			toastr.error('<b>PILIH NO. WO!</b>');
			return
		}
		
		let no_so = $('#no_wo option:selected').attr('no-so')
		let urut_so = $('#no_wo option:selected').attr('urut-so')
		let rpt = $('#no_wo option:selected').attr('rpt');
		(urut_so == undefined) ? urut_so = '' : urut_so = urut_so;
		(rpt == undefined) ? rpt = '' : rpt = rpt;
		(urut_so.length == 1 ) ? urut_so = '.0'+urut_so : urut_so = urut_so;
		(rpt.length == 1 ) ? rpt = '.0'+rpt : rpt = rpt;
		(no_so == undefined) ? no_so = '' : no_so = no_so+urut_so+rpt;
		if(urut_so == '' || rpt == '' || no_so == ''){
			toastr.error('<b>NO. SO KOSONG!</b>');
			return
		}
		
		let panjang_plan = $("#ii_panjang").val().split('.').join('');
		let lebar_plan = $("#ii_lebar").val().split('.').join('')
		let lebar_roll_p = $("#i_lebar_roll").val().split('.').join('')
		let out_plan = $("#out_plan").val()
		let trim_plan = $("#trim").val().split('.').join('')
		let c_off_p = $("#c_off").val().split('.').join('')
		let rm_plan = $("#rm").val().split('.').join('')
		let tonase_plan = $("#ton").val().split('.').join('')
		if(panjang_plan == '' || panjang_plan == 0 || lebar_plan == '' || lebar_plan == 0 || lebar_roll_p == '' || lebar_roll_p == 0 || out_plan == '' || out_plan == 0 || trim_plan == '' || trim_plan == 0 || c_off_p == '' || c_off_p == 0 || rm_plan == '' || rm_plan == 0 || tonase_plan == '' || tonase_plan == 0){
			toastr.error('<b>HITUNG DATA KOSONG!</b>');
			return
		}
		if(panjang_plan < 0 || lebar_plan < 0 || lebar_roll_p < 0 || out_plan < 0 || trim_plan < 0 || c_off_p < 0 || rm_plan < 0 || tonase_plan < 0){
			toastr.error('<b>HITUNG KURANG!</b>');
			return
		}

		let pcs_plan = $('#no_wo option:selected').attr('qty-so');
		(pcs_plan == undefined) ? pcs_plan = '' : pcs_plan = pcs_plan.split('.').join('');
		let kualitas_plan = $("#input_kualitas_plan").val();
		let kualitas_isi_plan = $("#input_kualitas_plan_isi").val()
		let material_plan = $("#input_material_plan").val()
		if(kualitas_plan == '' || kualitas_isi_plan == '' || material_plan == ''){
			toastr.error('<b>KUALITAS KOSONG!</b>');
			return
		}

		let tgl_kirim_plan = $("#kirim").val()
		let next_plan = $("#next_flexo").val()
		if(tgl_kirim_plan == '' || next_plan == ''){
			toastr.error('<b>TGL KIRIM / NEXT PLAN KOSONG!</b>');
			return
		}

		$.ajax({
			url: '<?php echo base_url('Plan/addRencanaPlan')?>',
			type: "POST",
			data: ({
				id_so_detail, id_wo, id_produk, id_pelanggan, no_wo, no_so, pcs_plan, tgl_plan, machine_plan, shift_plan, tgl_kirim_plan, next_plan, lebar_roll_p, out_plan, trim_plan, c_off_p, rm_plan, tonase_plan, kualitas_plan, kualitas_isi_plan, material_plan, panjang_plan, lebar_plan
			}),
			success: function(res){
				data = JSON.parse(res)
				// console.log(data)
				if(data.data){
					toastr.success(`<b>BERHASIL</b>`)
					$("#list-rencana-plan").load("<?php echo base_url('Plan/listRencanaPlan')?>")
					$("#no_wo").val("")
					plhNoWo()
				}else{
					swal(data.isi, "", "error")
					return
				}
			}
		})
	}

	function hapusCartItem(rowid){
		$.ajax({
			url: '<?php echo base_url('Plan/hapusCartItem')?>',
			type: "POST",
			data: ({
				rowid
			}),
			success: function(res){
				$("#list-rencana-plan").load("<?php echo base_url('Plan/listRencanaPlan')?>")
			}
		})
	}

	function simpanCartItem()
	{
		$.ajax({
			url: '<?php echo base_url('Plan/simpanCartItem')?>',
			type: "POST",
			success: function(res){
				// data = JSON.parse(res)
				// console.log(data)
				swal("BERHASIL!", "", "success")
				window.location.href = '<?php echo base_url('Plan/Corrugator')?>'
			}
		})
	}

	function showCartitem(rowid)
	{
		$("#show-list-plh-item").html(``)
		$("#modalForm").modal("show")
		$.ajax({
			url: '<?php echo base_url('Plan/showCartitem')?>',
			type: "POST",
			data: ({ rowid }),
			success: function(res){
				$("#show-list-plh-item").html(res)
			}
		})
	}

	function loadPlanWo()
	{
		$("#no_wo").prop("disabled", true).html(`<option value="">PILIH</option>`)
		$.ajax({
			url: '<?php echo base_url('Plan/loadPlanWo')?>',
			type: "POST",
			success: function(res){
				data = JSON.parse(res)
				// console.log(data)
				let htmlWO = ''
					htmlWO += `<option value="">PILIH</option>`
				data.wo.forEach(loadWo);
				function loadWo(r, index) {
					htmlWO += `<option value="${r.idWo}"
						id-wo="${r.idWo}"
						id-so="${r.idSoDetail}"
						id-pelanggan="${r.id_pelanggan}"
						id-produk="${r.id_produk}"
						tgl-wo="${r.tgl_wo}"
						no-wo="${r.no_wo}"
						no-so="${r.no_so}"
						urut-so="${r.urut_so}"
						rpt="${r.rpt}"
						eta-so="${r.eta_so}"
						tgl-po="${r.tgl_po}"
						no-po="${r.no_po}"
						kode-po="${r.kode_po}"
						qty-po="${r.total_qty}"
						customer="${r.nm_pelanggan}"
						nm-sales="${r.nm_sales}"
						item="${r.nm_produk}"
						kode-mc="${r.kode_mc}"
						uk-box="${r.ukuran}"
						uk-sheet="${r.ukuran_sheet}"
						panjang-s="${r.ukuran_sheet_p}"
						lebar-s="${r.ukuran_sheet_l}"
						creasing-1="${r.creasing}"
						creasing-2="${r.creasing2}"
						creasing-3="${r.creasing3}"
						material="${r.material}"
						kualitas="${r.kualitas}"
						kualitas-isi="${r.kualitas_isi}"
						flute="${r.flute}"
						tipe-box="${r.tipe_box}"
						sambungan="${r.sambungan}"
						berat-box="${r.berat_bersih}"
						luas-box="${r.luas_bersih}"
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
		let plhWo = $("#no_wo").val()
		if(plhWo == ''){
			loadPlanWo()
		}

		let id_wo = $('#no_wo option:selected').attr('id-wo')
		let id_so = $('#no_wo option:selected').attr('id-so')
		let id_pelanggan = $('#no_wo option:selected').attr('id-pelanggan')
		let id_produk = $('#no_wo option:selected').attr('id-produk')
		let tgl_wo = $('#no_wo option:selected').attr('tgl-wo')
		let no_wo = $('#no_wo option:selected').attr('no-wo')
		let no_so = $('#no_wo option:selected').attr('no-so')
		let urut_so = $('#no_wo option:selected').attr('urut-so')
		let rpt = $('#no_wo option:selected').attr('rpt')
		let eta_so = $('#no_wo option:selected').attr('eta-so')
		let tgl_po = $('#no_wo option:selected').attr('tgl-po')
		let no_po = $('#no_wo option:selected').attr('no-po')
		let kode_po = $('#no_wo option:selected').attr('kode-po')
		let qty_po = $('#no_wo option:selected').attr('qty-po')
		let customer = $('#no_wo option:selected').attr('customer')
		let nm_sales = $('#no_wo option:selected').attr('nm-sales')
		let item = $('#no_wo option:selected').attr('item')
		let kode_mc = $('#no_wo option:selected').attr('kode-mc')
		let uk_box = $('#no_wo option:selected').attr('uk-box')
		let uk_sheet = $('#no_wo option:selected').attr('uk-sheet')
		let panjang_s = $('#no_wo option:selected').attr('panjang-s')
		let lebar_s = $('#no_wo option:selected').attr('lebar-s')
		let creasing_1 = $('#no_wo option:selected').attr('creasing-1')
		let creasing_2 = $('#no_wo option:selected').attr('creasing-2')
		let creasing_3 = $('#no_wo option:selected').attr('creasing-3')
		let material = $('#no_wo option:selected').attr('material')
		let kualitas = $('#no_wo option:selected').attr('kualitas')
		let kualitas_isi = $('#no_wo option:selected').attr('kualitas-isi')
		let flute = $('#no_wo option:selected').attr('flute')
		let tipe_box = $('#no_wo option:selected').attr('tipe-box')
		let sambungan = $('#no_wo option:selected').attr('sambungan')
		let berat_box = $('#no_wo option:selected').attr('berat-box')
		let luas_box = $('#no_wo option:selected').attr('luas-box')
		let qty_so = $('#no_wo option:selected').attr('qty-so')
		let rm_so = $('#no_wo option:selected').attr('rm-so')
		let ton_so = $('#no_wo option:selected').attr('ton-so')
		let ket_so = $('#no_wo option:selected').attr('ket-so')
		let creasing_wo1 = $('#no_wo option:selected').attr('creasing-wo1')
		let creasing_wo2 = $('#no_wo option:selected').attr('creasing-wo2')
		let creasing_wo3 = $('#no_wo option:selected').attr('creasing-wo3')

		$("#tgl_wo").val(tgl_wo)
		$("#creasing_wo_1").val(creasing_wo1)
		$("#creasing_wo_2").val(creasing_wo2)
		$("#creasing_wo_3").val(creasing_wo3)
		
		$("#customer").val(customer)
		$("#sales").val(nm_sales)
		$("#tgl_po").val(tgl_po)
		$("#no_po").val(no_po)
		$("#kode_po").val(kode_po);
		(isNaN(qty_po)) ? qty_po = '' : qty_po = qty_po;
		$("#qty_po").val(new Intl.NumberFormat('id-ID', {styles: 'currency', currency: 'IDR'}).format(Math.round(qty_po)));
		
		$("#eta_so").val(eta_so);
		(urut_so == undefined) ? urut_so = '' : urut_so = urut_so;
		(rpt == undefined) ? rpt = '' : rpt = rpt;
		(urut_so.length == 1 ) ? urut_so = '.0'+urut_so : urut_so = urut_so;
		(rpt.length == 1 ) ? rpt = '.0'+rpt : rpt = rpt;
		(no_so == undefined) ? no_so = '' : no_so = no_so+urut_so+rpt;
		$("#no_so").val(no_so);

		$("#qty_so").val(new Intl.NumberFormat('id-ID', {styles: 'currency', currency: 'IDR'}).format(Math.round(qty_so)));
		$("#rm_so").val(new Intl.NumberFormat('id-ID', {styles: 'currency', currency: 'IDR'}).format(Math.round(rm_so)))
		$("#ton_so").val(new Intl.NumberFormat('id-ID', {styles: 'currency', currency: 'IDR'}).format(Math.round(ton_so)))
		$("#ket_so").val((ket_so == "") ? '-' : ket_so)

		$("#kode_mc").val(kode_mc)
		$("#item").val(item)
		$("#uk_box").val(uk_box)
		$("#uk_sheet").val(uk_sheet)
		$("#creasing_1").val(creasing_1)
		$("#creasing_2").val(creasing_2)
		$("#creasing_3").val(creasing_3)
		$("#kualitas").val(kualitas)
		$("#flute").val(flute)
		$("#tipe_box").val(tipe_box)
		if(sambungan == 'G'){
			sambungan = 'GLUE'
		}else if(sambungan == 'S'){
			sambungan = 'STICHING'
		}else if(sambungan == 'D'){
			sambungan = 'DIE CUT'
		}else{
			sambungan = ''
		}
		$("#sambungan").val(sambungan)
		$("#bb_box").val(berat_box)
		$("#lb_box").val(luas_box)

		$("#ii_panjang").val(new Intl.NumberFormat('id-ID', {styles: 'currency', currency: 'IDR'}).format(Math.round(panjang_s)))
		$("#ii_lebar").val(new Intl.NumberFormat('id-ID', {styles: 'currency', currency: 'IDR'}).format(Math.round(lebar_s)))

		$("#qty_plan").val(new Intl.NumberFormat('id-ID', {styles: 'currency', currency: 'IDR'}).format(Math.round(qty_so)))

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

		$("#kirim").val("")
		$("#next_flexo").html(`<option value="">PILIH</option><option value="FLEXO1">FLEXO 1</option><option value="FLEXO2">FLEXO 2</option><option value="FLEXO3">FLEXO 3</option><option value="FLEXO4">FLEXO 4</option>`)

		ayoBerhitung()
	}

	function ayoBerhitung()
	{
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

		let flute = $('#no_wo option:selected').attr('flute')
		let panjang_s = $("#ii_panjang").val().split('.').join('');
		(panjang_s == 0 || panjang_s < 0) ? $("#ii_panjang").val(0).attr('style', 'border-color:#d00') : $("#ii_panjang").val(new Intl.NumberFormat('id-ID', {styles: 'currency', currency: 'IDR'}).format(panjang_s)).attr('style', 'border-color:#ced4da');
		let lebar_s = $("#ii_lebar").val().split('.').join('');
		(lebar_s == 0 || lebar_s < 0) ? $("#ii_lebar").val(0).attr('style', 'border-color:#d00') : $("#ii_lebar").val(new Intl.NumberFormat('id-ID', {styles: 'currency', currency: 'IDR'}).format(lebar_s)).attr('style', 'border-color:#ced4da');
		let qty_so = $('#no_wo option:selected').attr('qty-so');
		
		let ton = 0
		let material = ''
		let kualitas = ''
		let kualitas_isi = ''
		let editMaterial = ''
		let editKualitas = ''
		let editKualitasIsi = ''

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

			editMaterial = $('#no_wo option:selected').attr('material')
			editKualitas = $('#no_wo option:selected').attr('kualitas')
			editKualitasIsi = $('#no_wo option:selected').attr('kualitas-isi')
			$("#group_tmpl_kualitas").val(editKualitas)

			kualitas_isi = $('#no_wo option:selected').attr('kualitas-isi');
			(kualitas_isi === undefined) ? kualitas_isi = '0/0/0/0/0' : kualitas_isi = kualitas_isi;
			let spltKualitas = kualitas_isi.split("/");
			if(flute == 'BF'){
				ton = parseFloat((parseInt(spltKualitas[0]) + (parseFloat(spltKualitas[1])*1.36) + parseInt(spltKualitas[2])) / 1000 * panjang_s / 1000 * lebar_s / 1000 * qty_so)
			}else if(flute == 'CF'){
				ton = parseFloat((parseInt(spltKualitas[0]) + (parseFloat(spltKualitas[1])*1.46) + parseInt(spltKualitas[2])) / 1000 * panjang_s / 1000 * lebar_s / 1000 * qty_so)
			}else if(flute == 'BCF'){
				ton = parseFloat((parseInt(spltKualitas[0]) + (parseFloat(spltKualitas[1])*1.36) + parseInt(spltKualitas[2]) + (parseFloat(spltKualitas[3])*1.46) + parseInt(spltKualitas[4])) / 1000 * panjang_s / 1000 * lebar_s / 1000 * qty_so)
			}else{
				ton = 0
			}
		}else if(g_kualitas == 'GANTI'){
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
				if(tl_al == '' || tl_al_i == '' || bmf == '' || bmf_i == '' || cl == '' || cl_i == '' || tl_al == 0 || tl_al_i == 0 || bmf == 0 || bmf_i == 0 || cl == 0 || cl_i == 0){
					$("#group_tmpl_kualitas").val("")
					ton = 0
				}else{
					editMaterial = tl_al+'/'+bmf+'/'+cl
					editKualitas = tl_al+tl_al_i+'/'+bmf+bmf_i+'/'+cl+cl_i
					editKualitasIsi = tl_al_i+'/'+bmf_i+'/'+cl_i
					$("#group_tmpl_kualitas").val(editKualitas)
					ton = parseFloat((parseInt(tl_al_i) + (parseFloat(bmf_i)*1.36) + parseInt(cl_i)) / 1000 * panjang_s / 1000 * lebar_s / 1000 * qty_so)
				} 
			}else if(flute == 'CF'){
				$("#bmf").prop('disabled', true)
				$("#bmf_i").prop('disabled', true)
				$("#bl").prop('disabled', true)
				$("#bl_i").prop('disabled', true)
				$("#cmf").prop('disabled', false)
				$("#cmf_i").prop('disabled', false)
				if(tl_al == '' || tl_al_i == '' || cmf == '' || cmf_i == '' || cl == '' || cl_i == '' || tl_al == 0 || tl_al_i == 0 || cmf == 0 || cmf_i == 0 || cl == 0 || cl_i == 0){
					$("#group_tmpl_kualitas").val("")
					ton = 0
				}else{
					editMaterial = tl_al+'/'+cmf+'/'+cl
					editKualitas = tl_al+tl_al_i+'/'+cmf+cmf_i+'/'+cl+cl_i
					editKualitasIsi = tl_al_i+'/'+cmf_i+'/'+cl_i
					$("#group_tmpl_kualitas").val(editKualitas)
					ton = parseFloat((parseInt(tl_al_i) + (parseFloat(cmf_i)*1.46) + parseInt(cl_i)) / 1000 * panjang_s / 1000 * lebar_s / 1000 * qty_so);
				}
			}else if(flute == 'BCF'){
				$("#bmf").prop('disabled', false)
				$("#bmf_i").prop('disabled', false)
				$("#bl").prop('disabled', false)
				$("#bl_i").prop('disabled', false)
				$("#cmf").prop('disabled', false)
				$("#cmf_i").prop('disabled', false)
				if(tl_al == '' || tl_al_i == '' || bmf == '' || bmf_i == '' || bl == '' || bl_i == '' || cmf == '' || cmf_i == '' || cl == '' || cl_i == '' || tl_al == 0 || tl_al_i == 0 || bmf == 0 || bmf_i == 0 || bl == 0 || bl_i == 0 || cmf == 0 || cmf_i == 0 || cl == 0 || cl_i == 0){
					$("#group_tmpl_kualitas").val("")
					ton = 0
				}else{
					editMaterial = tl_al+'/'+bmf+'/'+bl+'/'+cmf+'/'+cl
					editKualitas = tl_al+tl_al_i+'/'+bmf+bmf_i+'/'+bl+bl_i+'/'+cmf+cmf_i+'/'+cl+cl_i
					editKualitasIsi = tl_al_i+'/'+bmf_i+'/'+bl_i+'/'+cmf_i+'/'+cl_i
					$("#group_tmpl_kualitas").val(editKualitas)
					ton = parseFloat((parseInt(tl_al_i) + (parseFloat(bmf_i)*1.36) + parseInt(bl_i) + (parseFloat(cmf_i)*1.46) + parseInt(cl_i)) / 1000 * panjang_s / 1000 * lebar_s / 1000 * qty_so)
				} 
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
			}
			$("#group_plh_kualitas").show()
		}else{
			$("#g_kualitas").html(`<option value="PO">KUALITAS SESUAI PO</option><option value="GANTI">GANTI KUALITAS</option>`)
			$("#group_plh_kualitas").hide()
		}

		material = editMaterial
		kualitas = editKualitas
		kualitas_isi = editKualitasIsi
		$("#input_kualitas_plan").val(kualitas)
		$("#input_kualitas_plan_isi").val(kualitas_isi)
		$("#input_material_plan").val(material)

		let i_lebar_roll = $("#i_lebar_roll").val().split('.').join('');
		(i_lebar_roll == '' || i_lebar_roll == 0 || i_lebar_roll < 0) ? $("#i_lebar_roll").val(0).attr('style', 'border-color:#d00') : $("#i_lebar_roll").val(new Intl.NumberFormat('id-ID', {styles: 'currency', currency: 'IDR'}).format(i_lebar_roll)).attr('style', 'border-color:#ced4da');
		let out_plan = $("#out_plan").val().split('.').join('');
		(out_plan == '' || out_plan == 0 || out_plan < 0) ? $("#out_plan").val(0).attr('style', 'border-color:#d00') : $("#out_plan").val(new Intl.NumberFormat('id-ID', {styles: 'currency', currency: 'IDR'}).format(out_plan)).attr('style', 'border-color:#ced4da');
		
		let trim = 0;
		let c_off = 0;
		let rm = 0;
		(i_lebar_roll == '' || out_plan == '' || i_lebar_roll == 0 || out_plan == 0) ? trim = 0 : trim = Math.round(i_lebar_roll - (lebar_s * out_plan));
		(out_plan == '' || out_plan == 0) ? c_off = 0 : c_off = Math.round(qty_so / out_plan);
		(c_off == '' || c_off == 0) ? rm = 0 : rm = Math.round((c_off * panjang_s) / 1000);

		(trim < 0 || trim == 0) ? $("#trim").val(0).attr('style', 'border-color:#d00') : $("#trim").val(trim).attr('style', 'border-color:#ced4da');
		(c_off < 0 || isNaN(c_off) || c_off == 0) ? $("#c_off").val(0).attr('style', 'border-color:#d00') : $("#c_off").val(new Intl.NumberFormat('id-ID', {styles: 'currency', currency: 'IDR'}).format(c_off)).attr('style', 'border-color:#ced4da');
		(rm < 0 || isNaN(rm) || rm == 0) ? $("#rm").val(0).attr('style', 'border-color:#d00') : $("#rm").val(new Intl.NumberFormat('id-ID', {styles: 'currency', currency: 'IDR'}).format(rm)).attr('style', 'border-color:#ced4da');
		(ton < 0 || ton == 0) ? $("#ton").val(0).attr('style', 'border-color:#d00') : $("#ton").val(new Intl.NumberFormat('id-ID', {styles: 'currency', currency: 'IDR'}).format(Math.round(ton))).attr('style', 'border-color:#ced4da');
	}

</script>