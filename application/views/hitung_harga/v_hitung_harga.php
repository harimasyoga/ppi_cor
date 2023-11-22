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
			margin: ;
		}
	</style>

	<section class="content" style="padding-bottom:3px">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
						<div class="card card-info card-outline">
							<div class="card-header">
								<h3 class="card-title" style="font-weight:bold;font-style:italic"><?= $menu ?></h3>
							</div>
							<br>
							<div class="card-body row" style="padding: 2px 2px;font-weight:bold">
								<div class="col-md-3" style="margin-bottom:3px">
								Type :
									<select id="type" name="type" class="form-control select2" onchange="ayoBerhitung(), cek_type(this.value)">
										<option value="b">Box</option>
										<option value="s">Sheet</option>
									</select>
								</div>
								
								<div class="col-md-12">&nbsp;</div>
								<br>
								
								<div class="col-md-3" style="margin-bottom:3px">
								Flute :
									<select id="flute" name="flute" class="form-control select2" onchange="ayoBerhitung(),cek_flute(this.value)">
										<option value="BCF">BCF</option>
										<option value="BF">BF</option>
										<option value="CF">CF</option>
									</select>
								</div>
								
								<div class="col-md-12">&nbsp;</div>
								
								<div class="col-md-3" style="margin-bottom:3px">
								Ukuran : <br>
								</div>
								<div class="col-md-12"></div>

								<div class="col-md-3" style="margin-bottom:3px">
									<input type="text" class="form-control angka" id="l_panjang" value="0" placeholder="P" maxlength="4" onkeyup="ubah_angka(this.value,this.id)" autocomplete="off" onchange="ayoBerhitung()">
									
								</div>
								<div class="col-md-3" style="margin-bottom:3px">
									<input type="text" class="form-control angka" id="l_lebar" value="0" placeholder="L" maxlength="4" onkeyup="ubah_angka(this.value,this.id)" autocomplete="off" onchange="ayoBerhitung()">									
								</div>
								<div class="col-md-3" style="margin-bottom:3px">
									<input type="text" class="form-control angka" id="l_tinggi" value="0" placeholder="T" maxlength="4" onkeyup="ubah_angka(this.value,this.id)" autocomplete="off" onchange="ayoBerhitung()">				
								</div>
								
								<div class="col-md-12">&nbsp;</div>
								
								<div class="col-md-3" style="margin-bottom:3px">
								Ukuran Sheet : <br>
								</div>
								<div class="col-md-12"></div>

								<div class="col-md-3" style="margin-bottom:3px">
									<input type="text" class="form-control angka" id="p_sheet" placeholder="P" onkeyup="ubah_angka(this.value,this.id)" autocomplete="off" readonly>
									
								</div>
								<div class="col-md-3" style="margin-bottom:3px">
									<input type="text" class="form-control angka" id="l_sheet" placeholder="L" onkeyup="ubah_angka(this.value,this.id)" autocomplete="off" readonly>									
								</div>
								
								<div class="col-md-12">&nbsp;</div>
								<br>
								<div class="col-md-3" style="margin-bottom:3px">
								Substance :
									<select id="tl_al" name="tl_al" class="form-control select2" onchange="ayoBerhitung()">
										<option value="">-</option>
										<option value="M">M</option>
										<option value="K">K</option>
									</select>

									<select id="bmf" name="bmf" class="form-control select2" onchange="ayoBerhitung()">
										<option value="">-</option>
										<option value="M">M</option>
										<option value="K">K</option>
									</select>
									<select id="bl" name="bl" class="form-control select2" onchange="ayoBerhitung()">
										<option value="">-</option>
										<option value="M">M</option>
										<option value="K">K</option>
									</select>
									<select id="cmf" name="cmf" class="form-control select2" onchange="ayoBerhitung()">
										<option value="">-</option>
										<option value="M">M</option>
										<option value="K">K</option>
									</select>
									<select id="cl" name="cl" class="form-control select2" onchange="ayoBerhitung()">
										<option value="">-</option>
										<option value="M">M</option>
										<option value="K">K</option>
									</select>
								</div>
								<div class="col-md-3" style="margin-bottom:3px">
								Gramature : 
									<input type="text" id="tl_al_i" name="tl_al_i"  class="form-control angka" autocomplete="off" placeholder="TL/AL" onchange="ayoBerhitung()">

									<input type="text" id="bmf_i" name="bmf_i" class="form-control angka" autocomplete="off" placeholder="B.MF" onchange="ayoBerhitung()">

									<input type="text" id="bl_i" name="bl_i" class="form-control angka" autocomplete="off" placeholder="B.L" onchange="ayoBerhitung()">

									<input type="text" id="cmf_i" name="cmf_i" class="form-control angka" autocomplete="off" placeholder="C.MF" onchange="ayoBerhitung()">

									<input type="text" id="cl_i" name="cl_i" class="form-control angka" autocomplete="off" placeholder="C.L" onchange="ayoBerhitung()">
								</div>
								
								<div class="col-md-12">&nbsp;</div>

								<div class="col-md-3" style="margin-bottom:3px">
								Harga / kg : 
									<input type="text" class="form-control angka" id="hrg_kg" placeholder="Harga" onkeyup="ubah_angka(this.value,this.id)" autocomplete="off" onchange="ayoBerhitung()">
								</div>
								<div class="col-md-3" style="margin-bottom:3px">
								Include : 
									<input type="text" class="form-control angka" id="include" placeholder="Include" onkeyup="ubah_angka(this.value,this.id)" autocomplete="off" onchange="ayoBerhitung()">									
								</div>
								<div class="col-md-3" style="margin-bottom:3px">
								Excludde : 
									<input type="text" class="form-control angka" id="exclude" placeholder="Exclude" onkeyup="ubah_angka(this.value,this.id)" autocomplete="off" onchange="ayoBerhitung()">			
								</div>
								<div class="col-md-12"></div>

								<div class="col-md-12">&nbsp;</div>
								
							</div>

							<br/>
						</div>
					
				</div>

			</div>
		</div>
	</section>
</div>


<script type="text/javascript">

	$(document).ready(function ()
	{
		$('.select2').select2({
			containerCssClass: "wrap",
			placeholder: '--- Pilih ---',
			dropdownAutoWidth: true
		});
	})

	function cek_type(vall)
	{
		if(vall=='b')
		{
			$("#l_panjang").prop("disabled",false)
			$("#l_lebar").prop("disabled",false)
			$("#l_tinggi").prop("disabled",false)
		}else{

			$("#l_panjang").prop("disabled",false)
			$("#l_lebar").prop("disabled",false)
			$("#l_tinggi").prop("disabled",true)

		}
	}
	
	function cek_flute(vall)
	{
		if(vall=='BCF')
		{
			$("#tl_al").prop("disabled",false)
			$("#bmf").prop("disabled",false)
			$("#bl").prop("disabled",false)
			$("#cmf").prop("disabled",false)
			$("#cl").prop("disabled",false)

			$("#tl_al_i").prop("disabled",false)
			$("#bmf_i").prop("disabled",false)
			$("#bl_i").prop("disabled",false)
			$("#cmf_i").prop("disabled",false)
			$("#cl_i").prop("disabled",false)
		}else if(vall=='BF')
		{
			$("#tl_al").prop("disabled",false)
			$("#bmf").prop("disabled",false)
			$("#bl").prop("disabled",false)
			$("#cmf").prop("disabled",true)
			$("#cl").prop("disabled",true)

			$("#tl_al_i").prop("disabled",false)
			$("#bmf_i").prop("disabled",false)
			$("#bl_i").prop("disabled",false)
			$("#cmf_i").prop("disabled",true)
			$("#cl_i").prop("disabled",true)

		}else{

			$("#tl_al").prop("disabled",false)
			$("#bmf").prop("disabled",true)
			$("#bl").prop("disabled",true)
			$("#cmf").prop("disabled",false)
			$("#cl").prop("disabled",false)

			$("#tl_al_i").prop("disabled",false)
			$("#bmf_i").prop("disabled",true)
			$("#bl_i").prop("disabled",true)
			$("#cmf_i").prop("disabled",false)
			$("#cl_i").prop("disabled",false)

		}
	}

	function ayoBerhitung()
	{
		var type        = $("#type").val()
		var flute       = $("#flute").val()
		var l_panjang_1   = $("#l_panjang").val()
		var l_lebar_1     = $("#l_lebar").val()
		var l_tinggi_1    = $("#l_tinggi").val()

		
		var l_panjang_2   = (l_panjang_1=='') ? 0 : l_panjang_1
		var l_lebar_2     = (l_lebar_1=='') ? 0 : l_lebar_1
		var l_tinggi_2    = (l_tinggi_1=='') ? 0 : l_tinggi_1
		
		var l_panjang   = parseFloat(l_panjang_2.split('.').join(''))
		var l_lebar     = parseFloat(l_lebar_2.split('.').join(''))
		var l_tinggi    = parseFloat(l_tinggi_2.split('.').join(''))
		var tl_al       = $("#tl_al").val()
		var bmf         = $("#bmf").val()
		var bl          = $("#bl").val()
		var cmf         = $("#cmf").val()
		var cl          = $("#cl").val()
		var tl_al_i     = parseFloat( $("#tl_al_i").val() )
		var bmf_i       = parseFloat( $("#bmf_i").val() )
		var bl_i        = parseFloat( $("#bl_i").val() )
		var cmf_i       = parseFloat( $("#cmf_i").val() )
		var cl_i        = parseFloat( $("#cl_i").val() )
		var hrg_kg      = parseFloat( $("#hrg_kg").val() )
		var include     = parseFloat( $("#include").val() )
		var exclude     = parseFloat( $("#exclude").val() )

		// hitung sheet
		var p_sheet   = '';
		var ruk_l     = '';
		var tfx       = '';

		if(type == "b")
		{
			if(l_panjang == '' || l_panjang == 0 || l_lebar == '' || l_lebar == 0 || l_tinggi == 0 || l_tinggi == ''){
				p_sheet = 0 ;
				l_sheet = 0 ;
			}else{
				if(flute == ""){
					p_sheet = 0 ;
					l_sheet = 0 ;
				} else if(flute == "BCF"){
					p_sheet = 2 * (l_panjang + l_lebar) + 61;
					l_sheet = l_lebar + l_tinggi + 23;

				} else if(flute == "CF") {
					p_sheet = 2 * (l_panjang + l_lebar) + 43;
					l_sheet = l_lebar + l_tinggi + 13;

				} else if(flute == "BF") {
					p_sheet = 2 * (l_panjang + l_lebar) + 39;
					l_sheet = l_lebar + l_tinggi + 9;

				} else {
					p_sheet = 0;
					l_sheet = 0;
				}
			}
		}else{
			if(l_panjang == '' || l_panjang == 0 || l_sheet == '' || l_sheet == 0){
				p_sheet = 0;
				l_sheet = 0;
			}else{
				p_sheet = l_panjang;
				l_sheet = l_lebar;
			}
		}
		document.getElementById('p_sheet').value = format_angka(p_sheet);
		document.getElementById('l_sheet').value = format_angka(l_sheet);


		// berat box
		if(flute == 'BF'){
			bb =  parseFloat((parseInt(tl_al_i) + (parseFloat(bmf_i)*1.36) + parseInt(bl_i)) / 1000 * p_sheet / 1000 * l_sheet / 1000) ;

		}else if(flute == 'CF'){
			bb = parseFloat(parseInt(tl_al_i) + (parseFloat(cmf_i)*1.46) + parseInt(cl_i)) / 1000 * p_sheet / 1000 * l_sheet / 1000 ;

		}else if(flute == 'BCF'){

			bb = parseFloat(parseInt(tl_al_i) + (parseFloat(bmf_i)*1.36) + parseInt(bl_i) + (parseFloat(cmf_i)*1.46) + parseInt(cl_i)) / 1000 * p_sheet / 1000 * l_sheet / 1000 ;

		}else{
			bb = 0
		}
		// harga / kg

		if (include=='')
		{
			hrg_kg   = 0;
		}else{
			hrg_kg   = Math.trunc(exclude / bb); 
		}
		$('#hrg_kg'+id2).val(format_angka(hrg_kg));

	}

	function Hitung_price(val) 
	{
		var isi = val.split('.').join('');
		
		if(cek=='exclude')
		{
			inc = Math.trunc(isi *1.11);
			$('#include').val(format_angka(inc));
			
		}else {
			exc = Math.trunc(isi /1.11);
			$('#exclude'+id2).val(format_angka(exc));

		}
	}

</script>
