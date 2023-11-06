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
				<div class="col-md-7">
					<div class="card card-info card-outline">
						<div class="card-header">
							<h3 class="card-title" style="font-weight:bold;font-style:italic">RINCIAN</h3>
						</div>
						<div class="card-body row" style="padding-bottom:5px;font-weight:bold">
							<div class="col-md-2">TGL</div>
							<div class="col-md-10">
								<input type="date" id="tgl" class="form-control">
							</div>
						</div>
					</div>
				</div>

				<div class="col-md-5">
					<div class="card card-info card-outline">
						<div class="card-header">
							<h3 class="card-title" style="font-weight:bold;font-style:italic">PLAN</h3>
						</div>

						<div id="group_ganti_kualitas">
							<div class="card-body row" style="padding:20px 20px 5px;font-weight:bold">
								<input type="hidden" id="input_material_plan" value="">
								<input type="hidden" id="input_kualitas_plan" value="">
								<input type="hidden" id="input_kualitas_plan_isi" value="">
								<div class="col-md-2">GANTI</div>
								<div class="col-md-10">
									<select id="g_kualitas" class="form-control select2">
										<option value="PO">KUALITAS SESUAI PO</option>
										<option value="GANTI">GANTI KUALITAS</option>
									</select>
								</div>
							</div>

							<div id="group_plh_kualitas" style="display:none">
								<div class="card-body row" style="padding:0 20px 2px;font-weight:bold">
									<div class="col-md-2">TL/AL</div>
									<div class="col-md-5" style="margin-bottom:3px">
										<select id="tl_al" class="form-control select2">
											<option value="">-</option><option value="M">M</option><option value="K">K</option><option value="MC">MC</option><option value="MN">MN</option>
										</select>
									</div>
									<div class="col-md-5" style="margin-bottom:3px"><input type="number" id="tl_al_i" class="form-control angka" autocomplete="off" maxlength="3"></div>
								</div>
								<div class="card-body row" style="padding:0 20px 2px;font-weight:bold">
									<div class="col-md-2">B.MF</div>
									<div class="col-md-5" style="margin-bottom:3px">
										<select id="bmf" class="form-control select2">
											<option value="">-</option><option value="M">M</option><option value="K">K</option><option value="MC">MC</option><option value="MN">MN</option>
										</select>
									</div>
									<div class="col-md-5" style="margin-bottom:3px"><input type="number" id="bmf_i" class="form-control angka" autocomplete="off" maxlength="3"></div>
								</div>
								<div class="card-body row" style="padding:0 20px 2px;font-weight:bold">
									<div class="col-md-2">B.L</div>
									<div class="col-md-5" style="margin-bottom:3px">
										<select id="bl" class="form-control select2">
											<option value="">-</option><option value="M">M</option><option value="K">K</option><option value="MC">MC</option><option value="MN">MN</option>
										</select>
									</div>
									<div class="col-md-5" style="margin-bottom:3px"><input type="number" id="bl_i" class="form-control angka" autocomplete="off" maxlength="3"></div>
								</div>
								<div class="card-body row" style="padding:0 20px 2px;font-weight:bold">
									<div class="col-md-2">C.MF</div>
									<div class="col-md-5" style="margin-bottom:3px">
										<select id="cmf" class="form-control select2">
											<option value="">-</option><option value="M">M</option><option value="K">K</option><option value="MC">MC</option><option value="MN">MN</option>
										</select>
									</div>
									<div class="col-md-5" style="margin-bottom:3px"><input type="number" id="cmf_i" class="form-control angka" autocomplete="off" maxlength="3"></div>
								</div>
								<div class="card-body row" style="padding:0 20px 2px;font-weight:bold">
									<div class="col-md-2">C.L</div>
									<div class="col-md-5" style="margin-bottom:3px">
										<select id="cl" class="form-control select2">
											<option value="">-</option><option value="M">M</option><option value="K">K</option><option value="MC">MC</option><option value="MN">MN</option>
										</select>
									</div>
									<div class="col-md-5" style="margin-bottom:3px"><input type="number" id="cl_i" class="form-control angka" autocomplete="off" maxlength="3"></div>
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
								<input type="number" id="ii_panjang" class="form-control" autocomplete="off" placeholder="PANJANG SHEET">
							</div>
						</div>
						<div class="card-body row" style="padding:0 20px 5px;font-weight:bold">
							<div class="col-md-2">LEBAR</div>
							<div class="col-md-10">
								<input type="number" id="ii_lebar" class="form-control" autocomplete="off" placeholder="LEBAR SHEET">
							</div>
						</div>
						<div class="card-body row" style="padding:0 20px 5px;font-weight:bold">
							<div class="col-md-2" style="padding-right:0">L. ROLL</div>
							<div class="col-md-10">
								<input type="number" id="i_lebar_roll" class="form-control" autocomplete="off" placeholder="LEBAR ROLL">
							</div>
						</div>
						<div class="card-body row" style="padding:0 20px 5px;font-weight:bold">
							<div class="col-md-2">OUT</div>
							<div class="col-md-10">
								<input type="number" id="out_plan" class="form-control" autocomplete="off" placeholder="OUT">
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

					<div class="card card-info card-outline">
						<div class="card-header">
							<h3 class="card-title" style="font-weight:bold;font-style:italic">PRODUKSI</h3>
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
		</div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function ()
	{
		const tgl_plan = '<?= $tgl_plan ?>';
		const shift = '<?= $shift ?>';
		const mesin = '<?= $mesin ?>';
		loadData(tgl_plan, shift, mesin)

		$('.select2').select2({
			dropdownAutoWidth: true
		})
	})

	function loadData(tgl_plan, shift, mesin)
	{
		console.log(tgl_plan)
		console.log(shift)
		console.log(mesin)
	}

</script>
