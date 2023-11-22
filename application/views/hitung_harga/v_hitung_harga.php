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

	<style>
		/* Chrome, Safari, Edge, Opera */
		input::-webkit-outer-spin-button,
		input::-webkit-inner-spin-button {
			-webkit-appearance: none;
			margin: 0;
		}
	</style>

	<section class="content" style="padding-bottom:30px">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
						<div class="card card-info card-outline">
							<div class="card-header">
								<h3 class="card-title" style="font-weight:bold;font-style:italic"><?= $menu ?></h3>
							</div>
							<br>
							<div class="card-body row" style="padding:0 20px 2px;font-weight:bold">
								<div class="col-md-3" style="margin-bottom:3px">
								Type :
									<select id="type" name="type" class="form-control select2" onchange="ayoBerhitung(0)">
										<option value="M">Box</option>
										<option value="K">Sheet</option>
									</select>
								</div>
								
								<div class="col-md-12">&nbsp;</div>
								<br>
								
								<div class="col-md-3" style="margin-bottom:3px">
								Flute:
									<select id="flute" name="flute" class="form-control select2" onchange="ayoBerhitung(0)">
										<option value="">-</option>
										<option value="B">BF</option>
										<option value="CF">CF</option>
										<option value="BCF">BCF</option>
									</select>
								</div>
								
								<div class="col-md-12">&nbsp;</div>
								<br>
								<div class="col-md-3" style="margin-bottom:3px">
								Substance :
									<select id="tl_al0" name="tl_al[0]" class="form-control select2" onchange="ayoBerhitung(0)">
										<option value="">-</option>
										<option value="M">M</option>
										<option value="K">K</option>
										<option value="MC">MC</option>
										<option value="MN">MN</option>
									</select>

									<select id="bmf0" name="bmf[0]" class="form-control select2" onchange="ayoBerhitung(0)">
										<option value="">-</option>
										<option value="M">M</option>
										<option value="K">K</option>
										<option value="MC">MC</option>
										<option value="MN">MN</option>
									</select>
									<select id="bl0" name="bl[0]" class="form-control select2" onchange="ayoBerhitung(0)">
										<option value="">-</option>
										<option value="M">M</option>
										<option value="K">K</option>
										<option value="MC">MC</option>
										<option value="MN">MN</option>
									</select>
									<select id="cmf0" name="cmf[0]" class="form-control select2" onchange="ayoBerhitung(0)">
										<option value="">-</option>
										<option value="M">M</option>
										<option value="K">K</option>
										<option value="MC">MC</option>
										<option value="MN">MN</option>
									</select>
									<select id="cl0" name="cl[0]" class="form-control select2" onchange="ayoBerhitung(0)">
										<option value="">-</option>
										<option value="M">M</option>
										<option value="K">K</option>
										<option value="MC">MC</option>
										<option value="MN">MN</option>
									</select>
								</div>
								<div class="col-md-3" style="margin-bottom:3px">
								Gramature : 
									<input type="text" id="tl_al_i0" name="tl_al_i[0]"  class="form-control angka" autocomplete="off" placeholder="TL/AL">

									<input type="text" id="bmf_i0" name="bmf_i[0]" class="form-control angka" autocomplete="off" placeholder="B.MF">

									<input type="text" id="bl_i0" name="bl_i[0]" class="form-control angka" autocomplete="off" placeholder="B.L">

									<input type="text" id="cmf_i0" name="cmf_i[0]" class="form-control angka" autocomplete="off" placeholder="C.MF">

									<input type="text" id="cl_i0" name="cl_i[0]" class="form-control angka" autocomplete="off" placeholder="C.L">
								</div>
								
							</div>

							<br/>
							<div class="card-body row" style="padding:0 20px 20px;font-weight:bold">
								<div class="col-md-12">
									<button type="button" class="btn btn-success btn-block" onclick="addRencanaPlan()"><i class="fa fa-plus"></i> <b>ADD PLAN</b></button>
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
	let optionsDay = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };

	$(document).ready(function ()
	{
		$("#list-rencana-plan").load("<?php echo base_url('Plan/destroyPlan') ?>")
		$("#no_wo").prop("disabled", true).html(`<option value="">PILIH</option>`)
		$('.select2').select2({
			dropdownAutoWidth: true
		})
	})

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
		let rupiah = new Intl.NumberFormat('id-ID', {styles: 'currency', currency: 'IDR'});

		let flute = $('#no_wo option:selected').attr('flute')
		let qty_so = $('#no_wo option:selected').attr('qty-so');
		let panjang_s = $("#ii_panjang").val().split('.').join('');
		(panjang_s == 0 || panjang_s < 0 || panjang_s == '') ? $("#ii_panjang").val(0).attr('style', 'border-color:#d00') : $("#ii_panjang").val(rupiah.format(panjang_s)).attr('style', 'border-color:#ced4da');
		
		let kategori = $('#no_wo option:selected').attr('kategori')
		let creasing_wo1 = $("#creasing_wo_1").val()
		let creasing_wo2 = $("#creasing_wo_2").val()
		let creasing_wo3 = $("#creasing_wo_3").val();
		let hitungScore = parseInt(creasing_wo1) + parseInt(creasing_wo2) + parseInt(creasing_wo3);
		(creasing_wo1 == 0 || creasing_wo1 < 0 || creasing_wo1 == '') ? $("#creasing_wo_1").val(0) : $("#creasing_wo_1").val();
		(creasing_wo2 == 0 || creasing_wo2 < 0 || creasing_wo2 == '') ? $("#creasing_wo_2").val(0) : $("#creasing_wo_2").val();
		(creasing_wo3 == 0 || creasing_wo3 < 0 || creasing_wo3 == '') ? $("#creasing_wo_3").val(0) : $("#creasing_wo_3").val();
		
		let lebar_s = $("#ii_lebar").val().split('.').join('');
		(lebar_s == 0 || lebar_s < 0 || lebar_s == '') ? $("#ii_lebar").val(0).attr('style', 'border-color:#d00') : $("#ii_lebar").val(rupiah.format(lebar_s)).attr('style', 'border-color:#ced4da');

		if(kategori == 'K_BOX'){
			if(hitungScore == lebar_s){
				$("#creasing_wo_1").attr('style', 'border-color:#ced4da')
				$("#creasing_wo_2").attr('style', 'border-color:#ced4da')
				$("#creasing_wo_3").attr('style', 'border-color:#ced4da')
				$("#ii_lebar").attr('style', 'border-color:#ced4da')
			}else{
				$("#creasing_wo_1").attr('style', 'border-color:#d00')
				$("#creasing_wo_2").attr('style', 'border-color:#d00')
				$("#creasing_wo_3").attr('style', 'border-color:#d00')
				$("#ii_lebar").attr('style', 'border-color:#d00')
			}
		}else if(kategori == 'K_SHEET'){
			if(creasing_wo1 != 0 || creasing_wo2 != 0 || creasing_wo3 != 0){
				if(hitungScore == lebar_s){
					$("#creasing_wo_1").attr('style', 'border-color:#ced4da')
					$("#creasing_wo_2").attr('style', 'border-color:#ced4da')
					$("#creasing_wo_3").attr('style', 'border-color:#ced4da')
					$("#ii_lebar").attr('style', 'border-color:#ced4da')
				}else{
					$("#creasing_wo_1").attr('style', 'border-color:#d00')
					$("#creasing_wo_2").attr('style', 'border-color:#d00')
					$("#creasing_wo_3").attr('style', 'border-color:#d00')
					$("#ii_lebar").attr('style', 'border-color:#d00')
				}
			}else{
				$("#creasing_wo_1").attr('style', 'border-color:#ced4da')
				$("#creasing_wo_2").attr('style', 'border-color:#ced4da')
				$("#creasing_wo_3").attr('style', 'border-color:#ced4da')
				$("#ii_lebar").attr('style', 'border-color:#ced4da')
			}
		}else{
			$("#creasing_wo_1").attr('style', 'border-color:#d00')
			$("#creasing_wo_2").attr('style', 'border-color:#d00')
			$("#creasing_wo_3").attr('style', 'border-color:#d00')
			$("#ii_lebar").attr('style', 'border-color:#d00')
		}
		
		let ton = 0;
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
		(i_lebar_roll == '' || i_lebar_roll == 0 || i_lebar_roll < 0) ? $("#i_lebar_roll").val(0).attr('style', 'border-color:#d00') : $("#i_lebar_roll").val(rupiah.format(i_lebar_roll)).attr('style', 'border-color:#ced4da');
		let out_plan = $("#out_plan").val().split('.').join('');
		(out_plan == '' || out_plan == 0 || out_plan < 0) ? $("#out_plan").val(0).attr('style', 'border-color:#d00') : $("#out_plan").val(rupiah.format(out_plan)).attr('style', 'border-color:#ced4da');
		
		let trim = 0;
		let c_off = 0;
		let rm = 0;
		(i_lebar_roll == '' || out_plan == '' || i_lebar_roll == 0 || out_plan == 0) ? trim = 0 : trim = Math.round(i_lebar_roll - (lebar_s * out_plan));
		(out_plan == '' || out_plan == 0) ? c_off = 0 : c_off = Math.round(qty_so / out_plan);
		(c_off == '' || c_off == 0) ? rm = 0 : rm = Math.round((c_off * panjang_s) / 1000);

		(trim < 0 || trim == 0) ? $("#trim").val(0).attr('style', 'border-color:#d00') : $("#trim").val(trim).attr('style', 'border-color:#ced4da');
		(c_off < 0 || isNaN(c_off) || c_off == 0) ? $("#c_off").val(0).attr('style', 'border-color:#d00') : $("#c_off").val(rupiah.format(c_off)).attr('style', 'border-color:#ced4da');
		(rm < 0 || isNaN(rm) || rm == 0) ? $("#rm").val(0).attr('style', 'border-color:#d00') : $("#rm").val(rupiah.format(rm)).attr('style', 'border-color:#ced4da');
		(ton < 0 || ton == 0) ? $("#ton").val(0).attr('style', 'border-color:#d00') : $("#ton").val(rupiah.format(Math.round(ton))).attr('style', 'border-color:#ced4da');
	}

</script>
