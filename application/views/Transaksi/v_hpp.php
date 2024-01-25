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

	<section class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-6">
					<div class="card card-success card-outline">
						<div class="card-header" style="padding:12px">
							<h3 class="card-title" style="font-weight:bold;font-size:18px">INPUT HPP</h3>
						</div>
						<div class="card-body row" style="font-weight:bold;padding:18px 12px 6px">
							<div class="col-md-3">PERIODE</div>
							<div class="col-md-4">
								<input type="date" id="tgl1_hpp" class="form-control">
							</div>
							<div class="col-md-1" style="padding:6px 0;text-align:center">s/d</div>
							<div class="col-md-4">
								<input type="date" id="tgl2_hpp" class="form-control">
							</div>
						</div>
						<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
							<div class="col-md-3">JENIS</div>
							<div class="col-md-9">
								<select id="jenis_hpp" class="form-control select2">
									<option value="">PILIH</option>
									<option value="BK">BK</option>
									<option value="MH">MH</option>
									<option value="WP">WP</option>
								</select>
							</div>
						</div>
						<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
							<div class="col-md-3">BATU BARA</div>
							<div class="col-md-9">
								<input type="text" id="batu_bara" class="form-control" autocomplete="off" placeholder="BATU BARA" onkeyup="hitungHPP()">
							</div>
						</div>
						<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
							<div class="col-md-3">BAHAN BAKU</div>
							<div class="col-md-9">
								<input type="text" id="bahan_baku" class="form-control" autocomplete="off" placeholder="BAHAN BAKU" onkeyup="hitungHPP()">
							</div>
						</div>
						<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
							<div class="col-md-3">LISTRIK</div>
							<div class="col-md-9">
								<input type="text" id="listrik" class="form-control" autocomplete="off" placeholder="LISTRIK" onkeyup="hitungHPP()">
							</div>
						</div>
						<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
							<div class="col-md-3">CHEMICAL</div>
							<div class="col-md-9">
								<input type="text" id="chemical" class="form-control" autocomplete="off" placeholder="CHEMICAL" onkeyup="hitungHPP()">
							</div>
						</div>
						<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
							<div class="col-md-3">TENAGA KERJA</div>
							<div class="col-md-9">
								<input type="text" id="tenaga_kerja" class="form-control" autocomplete="off" placeholder="TENAGA KERJA" onkeyup="hitungHPP()">
							</div>
						</div>
						<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
							<div class="col-md-3">DEPRESIASI</div>
							<div class="col-md-9">
								<input type="text" id="depresiasi" class="form-control" autocomplete="off" placeholder="DEPRESIASI" onkeyup="hitungHPP()">
							</div>
						</div>
						<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
							<div class="col-md-3">B. PEMBANTU</div>
							<div class="col-md-9">
								<input type="text" id="bahan_pembantu" class="form-control" autocomplete="off" placeholder="BAHAN PEMBANTU" onkeyup="hitungHPP()">
							</div>
						</div>
						<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
							<div class="col-md-3">SOLAR</div>
							<div class="col-md-9">
								<input type="text" id="solar" class="form-control" autocomplete="off" placeholder="SOLAR" onkeyup="hitungHPP()">
							</div>
						</div>
						<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
							<div class="col-md-3">EKSPEDISI</div>
							<div class="col-md-9">
								<input type="text" id="ekspedisi" class="form-control" autocomplete="off" placeholder="EKSPEDISI" onkeyup="hitungHPP()">
							</div>
						</div>
						<div class="card-body row" style="font-weight:bold;padding:0 12px">
							<div class="col-md-3">LAIN LAIN</div>
							<div class="col-md-9">
								<input type="text" id="lain_lain" class="form-control" autocomplete="off" placeholder="LAIN LAIN" onkeyup="hitungHPP()">
							</div>
						</div>
						<div class="card-body row" style="font-weight:bold;padding:0 12px 18px">
							<div class="col-md-3"></div>
							<div class="col-md-9" style="font-style:italic;font-size:12px">*opsional</div>
						</div>
					</div>
				</div>

				<div class="col-md-6">
					<div class="card card-primary card-outline" style="position:sticky;top:12px">
						<div class="card-header" style="padding:12px">
							<h3 class="card-title" style="font-weight:bold;font-size:18px">HITUNG HPP</h3>
						</div>
						<div class="card-body row" style="font-weight:bold;padding:18px 12px 6px">
							<div class="col-md-3">HPP</div>
							<div class="col-md-9">
								<input type="text" id="hasil_hpp" class="form-control" style="color:#000;font-weight:bold" autocomplete="off" placeholder="HPP" onkeyup="hitungHPP()" disabled>
							</div>
						</div>
						<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
							<div class="col-md-3">TONASE ORDER</div>
							<div class="col-md-9">
								<input type="text" id="tonase_order" class="form-control" autocomplete="off" placeholder="TONASE ORDER" onkeyup="hitungHPP()">
							</div>
						</div>
						<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
							<div class="col-md-3"></div>
							<div class="col-md-9">
								<input type="text" id="hasil_x_tonanse" class="form-control" style="color:#000;font-weight:bold" autocomplete="off" placeholder="HPP X TONASE ORDER" disabled onkeyup="hitungHPP()">
							</div>
						</div>
						<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
							<div class="col-md-3">PRESENTASE</div>
							<div class="col-md-9">
								<input type="number" id="presentase" class="form-control" autocomplete="off" placeholder="PRESENTASE" onkeyup="hitungHPP()">
							</div>
						</div>
						<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
							<div class="col-md-3"></div>
							<div class="col-md-9">
								<input type="text" id="hxt_x_persen" class="form-control" style="color:#000;font-weight:bold" autocomplete="off" placeholder="HxT X PRESENTASE" onkeyup="hitungHPP()">
							</div>
						</div>
						<div class="card-body row" style="font-weight:bold;padding:12px 12px 6px">
							<div class="col-md-3">HASIL AKHIR</div>
							<div class="col-md-9">
								<input type="text" id="fix_hpp" class="form-control" style="color:#000;font-weight:bold" autocomplete="off" placeholder="HASIL AKHIR" disabled onkeyup="hitungHPP()">
							</div>
						</div>
						<div class="card-body row" style="font-weight:bold;padding:0 12px 18px">
							<div class="col-md-3"></div>
							<div class="col-md-9">
								<div id="btn-simpan"></div>
							</div>
						</div>
					</div>
					<input type="hidden" id="id_hpp" value="">
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<div class="card card-secondary card-outline">
						<div class="card-header" style="padding:12px">
							<h3 class="card-title" style="font-weight:bold;font-size:18px">LIST HPP</h3>
							<div class="card-tools">
								<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
								<i class="fas fa-minus"></i></button>
							</div>
						</div>
						<div class="card-body" style="padding:12px 6px">
							<div style="margin-bottom:12px">
								<button type="button" class="btn btn-sm btn-info" onclick="addHPP()"><i class="fa fa-plus"></i> <b>TAMBAH DATA</b></button>
							</div>
							<table id="datatable" class="table table-bordered table-striped" style="width:100%">
								<thead>
									<tr>
										<th style="text-align:center;width:8%">#</th>
										<th style="text-align:center;width:12%">PERIODE</th>
										<th style="text-align:center;width:10%">JENIS</th>
										<th style="text-align:center;width:16%">HPP</th>
										<th style="text-align:center;width:16%">TONASE ORDER</th>
										<th style="text-align:center;width:8%">%</th>
										<th style="text-align:center;width:20%">HASIL AKHIR</th>
										<th style="text-align:center;width:10%">AKSI</th>
									</tr>
								</thead>
								<tbody></tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>

<script type="text/javascript">
	let statusInput = 'insert';
	const periode = '<?= date('Y-m-d')?>';

	$(document).ready(function ()
	{
		kosong()
		load_data()
		$('.select2').select2();
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
				"url": '<?php echo base_url('Transaksi/LoadDataHPP')?>',
				"type": "POST",
				// "data"  : { th_hub },
			},
			"aLengthMenu": [
				[5, 10, 15, 20, -1],
				[5, 10, 15, 20, "Semua"]
			],	
			responsive: true,
			"pageLength": 10,
			"language": {
				"emptyTable": "TIDAK ADA DATA.."
			}
		})
	}

	function kosong()
	{
		$("#id_hpp").val("")
		$("#jenis_hpp").html(`<option value="">PILIH</option><option value="BK">BK</option><option value="MH">MH</option><option value="WP">WP</option>`).prop('disabled', false)
		$("#tgl1_hpp").val(periode).prop('disabled', false).removeClass('is-invalid')
		$("#tgl2_hpp").val(periode).prop('disabled', false).removeClass('is-invalid')
		$("#batu_bara").val("").prop('disabled', false).removeClass('is-invalid')
		$("#bahan_baku").val("").prop('disabled', false).removeClass('is-invalid')
		$("#listrik").val("").prop('disabled', false).removeClass('is-invalid')
		$("#chemical").val("").prop('disabled', false).removeClass('is-invalid')
		$("#tenaga_kerja").val("").prop('disabled', false).removeClass('is-invalid')
		$("#depresiasi").val("").prop('disabled', false).removeClass('is-invalid')
		$("#bahan_pembantu").val("").prop('disabled', false).removeClass('is-invalid')
		$("#solar").val("").prop('disabled', false).removeClass('is-invalid')
		$("#ekspedisi").val("").prop('disabled', false).removeClass('is-invalid')
		$("#lain_lain").val("").prop('disabled', false).removeClass('is-invalid')
		$("#hasil_hpp").val("").prop('disabled', true).removeClass('is-invalid')
		$("#tonase_order").val("").prop('disabled', true).removeClass('is-invalid')
		$("#hasil_x_tonanse").val("").prop('disabled', true).removeClass('is-invalid')
		$("#presentase").val("").prop('disabled', true).removeClass('is-invalid')
		$("#hxt_x_persen").val("").prop('disabled', true).removeClass('is-invalid')
		$("#fix_hpp").val("").prop('disabled', true).removeClass('is-invalid')
		$("#btn-simpan").html(`<button type="button" class="btn btn-sm btn-primary" onclick="simpanHPP()"><i class="fa fa-save"></i> <b>SIMPAN</b></button>`)
		swal.close()
	}

	function addHPP()
	{
		statusInput = 'insert'
		swal({
			title: 'Loading',
			allowEscapeKey: false,
			allowOutsideClick: false,
			onOpen: () => {
				swal.showLoading();
			}
		});
		kosong()
	}

	function formatRupiah(angka)
    {
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
            split = number_string.split(','),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);
        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator+ribuan.join('.');
        }
        return rupiah = split[1] != undefined ? rupiah+','+split[1] : rupiah;
    }

	function hitungHPP()
	{
		let batu_bara = $("#batu_bara").val()
		let bahan_baku = $("#bahan_baku").val()
		let listrik = $("#listrik").val()
		let chemical = $("#chemical").val()
		let tenaga_kerja = $("#tenaga_kerja").val()
		let depresiasi = $("#depresiasi").val()
		let bahan_pembantu = $("#bahan_pembantu").val()
		let solar = $("#solar").val()
		let ekspedisi = $("#ekspedisi").val()
		let lain_lain = $("#lain_lain").val()
		$("#batu_bara").val(formatRupiah(batu_bara))
		$("#bahan_baku").val(formatRupiah(bahan_baku))
		$("#listrik").val(formatRupiah(listrik))
		$("#chemical").val(formatRupiah(chemical))
		$("#tenaga_kerja").val(formatRupiah(tenaga_kerja))
		$("#depresiasi").val(formatRupiah(depresiasi))
		$("#bahan_pembantu").val(formatRupiah(bahan_pembantu))
		$("#solar").val(formatRupiah(solar))
		$("#ekspedisi").val(formatRupiah(ekspedisi))
		$("#lain_lain").val(formatRupiah(lain_lain))
		let h_batu_bara = batu_bara.split('.').join('')
		let h_bahan_baku = bahan_baku.split('.').join('')
		let h_listrik = listrik.split('.').join('')
		let h_chemical = chemical.split('.').join('')
		let h_tenaga_kerja = tenaga_kerja.split('.').join('')
		let h_depresiasi = depresiasi.split('.').join('')
		let h_bahan_pembantu = bahan_pembantu.split('.').join('')
		let h_solar = solar.split('.').join('')
		let h_ekspedisi = ekspedisi.split('.').join('')
		let h_lain_lain = lain_lain.split('.').join('')

		if(h_batu_bara != '' && h_bahan_baku != '' && h_listrik != '' && h_chemical != '' && h_tenaga_kerja != '' && h_depresiasi != '' && h_bahan_pembantu != '' && h_solar != '' && h_ekspedisi != ''){
			$("#tonase_order").prop('disabled', false)
			$("#presentase").prop('disabled', false)
		}else{
			$("#tonase_order").val("").prop('disabled', true)
			$("#presentase").val("").prop('disabled', true)
		}

		// HPP
		let hitung_hpp = 0
		// if(lain_lain == '' || lain_lain == 0 || h_lain_lain == '' || h_lain_lain == 0){
		// 	if(h_batu_bara == '' || h_bahan_baku == '' || h_listrik == '' || h_chemical == '' || h_tenaga_kerja == '' || h_depresiasi == '' || h_bahan_pembantu == '' || h_solar == '' || h_ekspedisi == ''){
		// 		hitung_hpp = 0;
		// 	}else{
		// 		hitung_hpp = Math.round((parseInt(h_batu_bara) + parseInt(h_bahan_baku) + parseInt(h_listrik) + parseInt(h_chemical) + parseInt(h_tenaga_kerja) + parseInt(h_depresiasi) + parseInt(h_bahan_pembantu) + parseInt(h_solar) + parseInt(h_ekspedisi))) / 9;
		// 	}
		// }else{
		// 	if(h_batu_bara == '' || h_bahan_baku == '' || h_listrik == '' || h_chemical == '' || h_tenaga_kerja == '' || h_depresiasi == '' || h_bahan_pembantu == '' || h_solar == '' || h_ekspedisi == ''){
		// 		hitung_hpp = 0;
		// 	}else{
		// 		hitung_hpp = Math.round((parseInt(h_batu_bara) + parseInt(h_bahan_baku) + parseInt(h_listrik) + parseInt(h_chemical) + parseInt(h_tenaga_kerja) + parseInt(h_depresiasi) + parseInt(h_bahan_pembantu) + parseInt(h_solar) + parseInt(h_ekspedisi) + parseInt(h_lain_lain))) / 10;
		// 	}
		// }
		// $("#hasil_hpp").val(formatRupiah(hitung_hpp.toFixed()))
		if(h_batu_bara == '' || h_bahan_baku == '' || h_listrik == '' || h_chemical == '' || h_tenaga_kerja == '' || h_depresiasi == '' || h_bahan_pembantu == '' || h_solar == '' || h_ekspedisi == ''){
			hitung_hpp = 0;
		}else{
			(lain_lain == '' || lain_lain == 0 || h_lain_lain == '' || h_lain_lain == 0) ? h_lain_lain = 0 : h_lain_lain = h_lain_lain;
			hitung_hpp = (parseInt(h_batu_bara) + parseInt(h_bahan_baku) + parseInt(h_listrik) + parseInt(h_chemical) + parseInt(h_tenaga_kerja) + parseInt(h_depresiasi) + parseInt(h_bahan_pembantu) + parseInt(h_solar) + parseInt(h_ekspedisi) + parseInt(h_lain_lain));
		}
		(isNaN(hitung_hpp) || hitung_hpp == '' || hitung_hpp == 0) ? hitung_hpp = hitung_hpp : hitung_hpp = hitung_hpp;
		$("#hasil_hpp").val(formatRupiah(hitung_hpp.toString()))
		
		// HPP * TONASE ORDER
		let tonase_order =  $("#tonase_order").val()
		$("#tonase_order").val(formatRupiah(tonase_order)).removeClass('is-invalid').addClass((tonase_order == '') ? 'is-invalid' : '')
		let h_tonase_order = tonase_order.split('.').join('')

		let hasil_x_tonanse = 0;
		(hitung_hpp == 0 || h_tonase_order == '') ? hasil_x_tonanse = 0 : hasil_x_tonanse = Math.round(parseInt(hitung_hpp) / parseInt(h_tonase_order).toFixed()).toFixed();
		$("#hasil_x_tonanse").val(formatRupiah(hasil_x_tonanse.toString())).removeClass('is-invalid').addClass((hasil_x_tonanse == '') ? 'is-invalid' : '')

		// (HPP * TONASE ORDER) + PRESENTASE %
		let presentase = $("#presentase").val()
		$("#presentase").val(presentase).removeClass('is-invalid').addClass((presentase == '') ? 'is-invalid' : '')
		let h_presentase = presentase
		let fix_hpp = parseInt(hasil_x_tonanse) + Math.round((parseInt(hasil_x_tonanse) * (parseInt(h_presentase) / 100)))
		let hxt_x_persen = Math.round((parseInt(hasil_x_tonanse) * (parseInt(h_presentase) / 100)))
		$("#hxt_x_persen").val((isNaN(hxt_x_persen) || hxt_x_persen == 0) ? 0 : formatRupiah(hxt_x_persen.toString())).removeClass('is-invalid')
		$("#fix_hpp").val(isNaN(fix_hpp) ? 0 : formatRupiah(fix_hpp.toString())).removeClass('is-invalid').addClass((isNaN(fix_hpp) || fix_hpp == '' || fix_hpp == 0) ? 'is-invalid' : '');
	}

	function simpanHPP()
	{
		let id_hpp = $("#id_hpp").val()
		let tgl1_hpp = $("#tgl1_hpp").val()
		let tgl2_hpp = $("#tgl2_hpp").val()
		let jenis_hpp = $("#jenis_hpp").val()
		let batu_bara = $("#batu_bara").val().split('.').join('')
		let bahan_baku = $("#bahan_baku").val().split('.').join('')
		let listrik = $("#listrik").val().split('.').join('')
		let chemical = $("#chemical").val().split('.').join('')
		let tenaga_kerja = $("#tenaga_kerja").val().split('.').join('')
		let depresiasi = $("#depresiasi").val().split('.').join('')
		let bahan_pembantu = $("#bahan_pembantu").val().split('.').join('')
		let solar = $("#solar").val().split('.').join('')
		let ekspedisi = $("#ekspedisi").val().split('.').join('')
		let lain_lain = $("#lain_lain").val().split('.').join('')
		let hasil_hpp = $("#hasil_hpp").val().split('.').join('')
		let tonase_order = $("#tonase_order").val().split('.').join('')
		let hasil_x_tonanse = $("#hasil_x_tonanse").val().split('.').join('')
		let presentase = $("#presentase").val().split('.').join('')
		let hxt_x_persen = $("#hxt_x_persen").val().split('.').join('')
		let fix_hpp = $("#fix_hpp").val().split('.').join('')

		$.ajax({
			url: '<?php echo base_url('Transaksi/simpanHPP')?>',
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
				id_hpp, tgl1_hpp, tgl2_hpp, jenis_hpp, batu_bara, bahan_baku, listrik, chemical, tenaga_kerja, depresiasi, bahan_pembantu, solar, ekspedisi, lain_lain, hasil_hpp, tonase_order, hasil_x_tonanse, presentase, hxt_x_persen, fix_hpp, statusInput
			}),
			success: function(res){
				data = JSON.parse(res)
				if(data.insertHPP){
					statusInput = 'insert'
					toastr.success(`<b>${data.msg}</b>`)
					kosong()
					load_data()
					swal.close()
				}else{
					toastr.error(`<b>${data.msg}</b>`)

					$('#jenis_hpp').val(data.data2.jenis_hpp).trigger('change');
					$("#tgl1_hpp").val(data.data2.tgl1_hpp).removeClass('is-invalid').addClass((data.data2.tgl1_hpp == '') ? 'is-invalid' : '')
					$("#tgl2_hpp").val(data.data2.tgl2_hpp).removeClass('is-invalid').addClass((data.data2.tgl2_hpp == '') ? 'is-invalid' : '')
					$("#batu_bara").val(data.data2.batu_bara).removeClass('is-invalid').addClass((data.data2.batu_bara == '') ? 'is-invalid' : '')
					$("#bahan_baku").val(data.data2.bahan_baku).removeClass('is-invalid').addClass((data.data2.bahan_baku == '') ? 'is-invalid' : '')
					$("#listrik").val(data.data2.listrik).removeClass('is-invalid').addClass((data.data2.listrik == '') ? 'is-invalid' : '')
					$("#chemical").val(data.data2.chemical).removeClass('is-invalid').addClass((data.data2.chemical == '') ? 'is-invalid' : '')
					$("#tenaga_kerja").val(data.data2.tenaga_kerja).removeClass('is-invalid').addClass((data.data2.tenaga_kerja == '') ? 'is-invalid' : '')
					$("#depresiasi").val(data.data2.depresiasi).removeClass('is-invalid').addClass((data.data2.depresiasi == '') ? 'is-invalid' : '')
					$("#bahan_pembantu").val(data.data2.bahan_pembantu).removeClass('is-invalid').addClass((data.data2.bahan_pembantu == '') ? 'is-invalid' : '')
					$("#solar").val(data.data2.solar).removeClass('is-invalid').addClass((data.data2.solar == '') ? 'is-invalid' : '')
					$("#ekspedisi").val(data.data2.ekspedisi).removeClass('is-invalid').addClass((data.data2.ekspedisi == '') ? 'is-invalid' : '')
					$("#lain_lain").val(data.data2.lain_lain)
					$("#hasil_hpp").val(data.data2.hasil_hpp).prop('disabled', true).removeClass('is-invalid').addClass((data.data2.hasil_hpp == '') ? 'is-invalid' : '')
					$("#tonase_order").val(data.data2.tonase_order).removeClass('is-invalid').addClass((data.data2.tonase_order == '') ? 'is-invalid' : '')
					$("#hasil_x_tonanse").val(data.data2.hasil_x_tonanse).prop('disabled', true).prop('disabled', true).removeClass('is-invalid').addClass((data.data2.hasil_x_tonanse == '') ? 'is-invalid' : '')
					$("#presentase").val(data.data2.presentase).removeClass('is-invalid').addClass((data.data2.presentase == '') ? 'is-invalid' : '')
					$("#hxt_x_persen").val(data.data2.hxt_x_persen).removeClass('is-invalid').addClass((data.data2.hxt_x_persen == '') ? 'is-invalid' : '')
					$("#fix_hpp").val(data.data2.fix_hpp).prop('disabled', true).removeClass('is-invalid').addClass((data.data2.fix_hpp == '') ? 'is-invalid' : '')
					swal.close()
					return
				}
			}
		})
	}

	function editHPP(id_hpp, opsi)
	{
		$.ajax({
			url: '<?php echo base_url('Transaksi/editHPP')?>',
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
			data: ({ id_hpp, opsi }),
			success: function(res){
				data = JSON.parse(res)
				let prop = true;
				(opsi == 'edit') ? prop = false : prop = true;
				$('#jenis_hpp').val(data.jenis_hpp).prop('disabled', prop).trigger('change');
				$("#tgl1_hpp").val(data.tgl1_hpp).prop('disabled', prop).removeClass('is-invalid')
				$("#tgl2_hpp").val(data.tgl2_hpp).prop('disabled', prop).removeClass('is-invalid')
				$("#batu_bara").val(data.batu_bara).prop('disabled', prop).removeClass('is-invalid')
				$("#bahan_baku").val(data.bahan_baku).prop('disabled', prop).removeClass('is-invalid')
				$("#listrik").val(data.listrik).prop('disabled', prop).removeClass('is-invalid')
				$("#chemical").val(data.chemical).prop('disabled', prop).removeClass('is-invalid')
				$("#tenaga_kerja").val(data.tenaga_kerja).prop('disabled', prop).removeClass('is-invalid')
				$("#depresiasi").val(data.depresiasi).prop('disabled', prop).removeClass('is-invalid')
				$("#bahan_pembantu").val(data.bahan_pembantu).prop('disabled', prop).removeClass('is-invalid')
				$("#solar").val(data.solar).prop('disabled', prop).removeClass('is-invalid')
				$("#ekspedisi").val(data.ekspedisi).prop('disabled', prop).removeClass('is-invalid')
				$("#lain_lain").val((data.lain_lain == 0) ? '' : data.lain_lain).prop('disabled', prop).removeClass('is-invalid')
				$("#hasil_hpp").val(data.hasil_hpp).prop('disabled', true).removeClass('is-invalid')
				$("#tonase_order").val(data.tonase_order).prop('disabled', prop).removeClass('is-invalid')
				$("#hasil_x_tonanse").val(data.hasil_x_tonanse).prop('disabled', true).removeClass('is-invalid')
				$("#presentase").val(data.presentase).prop('disabled', prop).removeClass('is-invalid')
				$("#hxt_x_persen").val(data.hxt_x_persen).prop('disabled', true).removeClass('is-invalid')
				$("#fix_hpp").val(data.fix_hpp).prop('disabled', true).removeClass('is-invalid')
				if(opsi == 'edit'){
					$("#id_hpp").val(data.id_hpp)
					$("#btn-simpan").html(`<button type="button" class="btn btn-sm btn-warning" onclick="simpanHPP()"><i class="fa fa-edit"></i> <b>EDIT</b></button>`)
				}else{
					$("#id_hpp").val("")
					$("#btn-simpan").html('')
				}
				statusInput = 'update'
				swal.close()
			}
		})
	}

	function hapusHPP(id_hpp)
	{
		$.ajax({
			url: '<?php echo base_url('Transaksi/hapusHPP')?>',
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
			data: ({ id_hpp }),
			success: function(res){
				data = JSON.parse(res)
				if(data.data){
					statusInput = 'insert'
					toastr.success(`<b>${data.msg}</b>`)
					kosong()
					load_data()
					swal.close()
				}
			}
		})
	}
</script>
