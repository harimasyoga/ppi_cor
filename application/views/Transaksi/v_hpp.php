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
					<div class="card card-secondary card-outline">
						<div class="card-header" style="padding:12px">
							<h3 class="card-title" style="font-weight:bold;font-size:18px">INPUT HPP</h3>
						</div>
						<div class="card-body row" style="font-weight:bold;padding:12px 12px 6px">
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
								<select id="jenis_hpp" class="form-control select2"></select>
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
						<div class="card-body row" style="font-weight:bold;padding:0 12px 12px">
							<div class="col-md-3">LAIN LAIN</div>
							<div class="col-md-9">
								<input type="text" id="lain_lain" class="form-control" autocomplete="off" placeholder="LAIN LAIN" onkeyup="hitungHPP()">
							</div>
						</div>
					</div>
				</div>

				<div class="col-md-6">
					<div class="card card-secondary card-outline" style="position:sticky;top:12px">
						<div class="card-header" style="padding:12px">
							<h3 class="card-title" style="font-weight:bold;font-size:18px">HASIL HPP</h3>
						</div>
						<div class="card-body row" style="font-weight:bold;padding:12px 12px 6px">
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
						<div class="card-body row" style="font-weight:bold;padding:0 12px 12px">
							<div class="col-md-3">HASIL AKHIR</div>
							<div class="col-md-9">
								<input type="text" id="fix_hpp" class="form-control" style="color:#000;font-weight:bold" autocomplete="off" placeholder="HASIL AKHIR" disabled onkeyup="hitungHPP()">
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<div class="card-header">
							<h3 class="card-title">LIST HPP</h3>
							<div class="card-tools">
								<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
								<i class="fas fa-minus"></i></button>
							</div>
						</div>
						<div class="card-body p-0">
							<!-- <a href="<?php echo base_url('Logistik/Surat_Jalan/Add')?>" class="btn btn-info"><i class="fa fa-plus"></i> <b>Tambah Data</b></a>
							<br><br> -->
							<table id="datatable" class="table table-bordered table-striped" width="100%">
								<thead>
									<tr>
										<th>#</th>
										<th>CUSTOMER</th>
										<th>TIPE</th>
										<th>ITEM</th>
										<th>JUMLAH</th>
										<th>AKSI</th>
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
	status ="insert";

	$(document).ready(function ()
	{
		// load_data()
		kosong()
		$('.select2').select2();
	});

	function kosong()
	{
		$("#jenis_hpp").html(`<option value="">PILIH</option><option value="BK">BK</option><option value="MH">MH</option><option value="WP">WP</option>`)
		$("#tgl1_hpp").val("")
		$("#tgl2_hpp").val("")
		$("#jenis_hpp").val("")
		$("#batu_bara").val("")
		$("#bahan_baku").val("")
		$("#listrik").val("")
		$("#chemical").val("")
		$("#tenaga_kerja").val("")
		$("#depresiasi").val("")
		$("#bahan_pembantu").val("")
		$("#solar").val("")
		$("#ekspedisi").val("")
		$("#lain_lain").val("")

		$("#hasil_hpp").val("")
		$("#tonase_order").val("")
		$("#hasil_x_tonanse").val("")
		$("#presentase").val("")
		$("#fix_hpp").val("")
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

		// HPP
		let hitung_hpp = 0
		if(h_lain_lain == ''){
			if(h_batu_bara == '' || h_bahan_baku == '' || h_listrik == '' || h_chemical == '' || h_tenaga_kerja == '' || h_depresiasi == '' || h_bahan_pembantu == '' || h_solar == '' || h_ekspedisi == ''){
				hitung_hpp = 0;
			}else{
				hitung_hpp = Math.round((parseInt(h_batu_bara) + parseInt(h_bahan_baku) + parseInt(h_listrik) + parseInt(h_chemical) + parseInt(h_tenaga_kerja) + parseInt(h_depresiasi) + parseInt(h_bahan_pembantu) + parseInt(h_solar) + parseInt(h_ekspedisi))) / 9;
			}
		}else{
			if(h_batu_bara == '' || h_bahan_baku == '' || h_listrik == '' || h_chemical == '' || h_tenaga_kerja == '' || h_depresiasi == '' || h_bahan_pembantu == '' || h_solar == '' || h_ekspedisi == ''){
				hitung_hpp = 0;
			}else{
				hitung_hpp = Math.round((parseInt(h_batu_bara) + parseInt(h_bahan_baku) + parseInt(h_listrik) + parseInt(h_chemical) + parseInt(h_tenaga_kerja) + parseInt(h_depresiasi) + parseInt(h_bahan_pembantu) + parseInt(h_solar) + parseInt(h_ekspedisi) + parseInt(h_lain_lain))) / 10;
			}
		}
		$("#hasil_hpp").val(formatRupiah(hitung_hpp.toFixed()))
		
		// HPP * TONASE ORDER
		let tonase_order =  $("#tonase_order").val()
		$("#tonase_order").val(formatRupiah(tonase_order))
		let h_tonase_order = tonase_order.split('.').join('')
		let hasil_x_tonanse = 0;
		(hitung_hpp.toFixed() == 0 || h_tonase_order == '') ? hasil_x_tonanse = 0 : hasil_x_tonanse = parseInt(hitung_hpp.toFixed()) * parseInt(h_tonase_order);
		$("#hasil_x_tonanse").val(formatRupiah(hasil_x_tonanse.toString()))

		// (HPP * TONASE ORDER) + PRESENTASE %
		let rp = new Intl.NumberFormat('id-ID', {styles: 'currency', currency: 'IDR'});
		let presentase = $("#presentase").val().split('.').join('');
		(presentase < 0 || presentase == 0 || presentase == '' || presentase == undefined || presentase.length >= 7) ? presentase = 0 : presentase = presentase;
		$("#presentase").val(rp.format(presentase));
		let fix_hpp = parseInt(hasil_x_tonanse) + (parseInt(hasil_x_tonanse) * (parseInt(presentase) / 100))
		$("#fix_hpp").val(formatRupiah(fix_hpp.toString()));
	}

	// function reloadTable() {
	// 	table = $('#datatable').DataTable();
	// 	tabel.ajax.reload(null, false);
	// }

	// function load_data() {
	// 	let table = $('#datatable').DataTable();
	// 	table.destroy();
	// 	tabel = $('#datatable').DataTable({
	// 		"processing": true,
	// 		"pageLength": true,
	// 		"paging": true,
	// 		"ajax": {
	// 			"url": '<?php echo base_url('Logistik/LoaDataGudang')?>',
	// 			"type": "POST",
	// 		},
	// 		"aLengthMenu": [
	// 			[5, 10, 15, 20, -1],
	// 			[5, 10, 15, 20, "Semua"]
	// 		],	
	// 		responsive: true,
	// 		"pageLength": 10,
	// 		"language": {
	// 			"emptyTable": "Tidak ada data.."
	// 		}
	// 	})
	// }

</script>
