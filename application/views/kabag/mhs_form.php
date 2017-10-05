<!-- Main START -->
<main>
	<div class="container">
		<div id="dashboard">
			<div class="section">
				<div id="responsive" class="section">
					<!-- button FAB -->
					<div class="fixed-action-btn" style="bottom: 45px; right: 24px;">
						<a class="btn-floating btn-large orange darken-1">
							<i class="large mdi-navigation-unfold-less"></i>
						</a>
						<ul>
							<li><a class="btn-floating red tooltipped" data-position="left" data-delay="50" data-tooltip="Revisi" onclick="revisi()"><i class="mdi-content-clear"></i></a></li>
							<li><a class="btn-floating green tooltipped" data-position="left" data-delay="50" data-tooltip="Terima" onclick="revisi_simpan('terima')"><i class="mdi-action-done"></i></a></li>
						</ul>
					</div>
					<!-- end button FAB -->
					<div class="row">
						<h4>
							Priview Form Beasiswa <span class="blue-text"><?php echo $nama; ?></span>
						</h4>
						<?php
						if ($keterangan!=null) {
							echo '
							<div class="row">
							<div class="col m12 s12">
							<div class="card-panel primary-color">
							<span>
							Catatan: <span class="alert-text">'.$keterangan.'</span>
							</span>
							</div>
							</div>
							</div>
							';
						}
						?>
						<div class="col m12">
							<div class="row">
								<div class="col m12">
									<div class="card-panel">
										<div class="row">
											<div class="col m2 s4">
												Nama
											</div>
											<div class="col m4 s8">
												: <span class="blue-text"><?php echo $nama; ?></span>
											</div>
											<div class="col m2 s4">
												Ditutup Pada
											</div>
											<div class="col m4 s8">
												: <span class="blue-text"><?php echo $ditutup; ?></span>
											</div>
										</div>
										<div class="row">
											<div class="col m2 s4">
												Penyelenggara
											</div>
											<div class="col m4 s8">
												: <span class="blue-text"><?php echo $penyelenggara; ?></span>
											</div>
											<div class="col m2 s4">
												Periode Berakhir
											</div>
											<div class="col m4 s8">
												: <span class="blue-text"><?php echo $periodeBerakhir; ?></span>
											</div>
										</div>
										<div class="row">
											<div class="col m2 s4">
												Kuota
											</div>
											<div class="col m4 s8">
												: <span class="blue-text"><?php echo $kuota; ?></span>
											</div>
											<?php
											$sel = "";
											if ($selektor==1) {
												$sel = '<i class="mdi-toggle-radio-button-on"></i> - Kasubag. Kemahasiswaan';
											}elseif ($selektor==2) {
												$sel = '<i class="mdi-toggle-radio-button-off"></i> - Kasubag. Kemahasiswaan Fakultas';
											}elseif ($selektor==3) {
												$sel = '<i class="mdi-action-stars"></i> - Keduanya';
											}

											$nfk = "";
											if ($namaFk!="") {
												$nfk = ' <small class="red-text">('.$namaFk.')</small>';
											}
											?>
											<div class="col m2 s4">
												Selektor
											</div>
											<div class="col m4 s8">
												: <span class="blue-text"><?php echo $sel.$nfk; ?></span>
											</div>
										</div>
										<div class="row">
											<div class="col m2 s4">
												Dibuka Pada
											</div>
											<div class="col m4 s8">
												: <span class="blue-text"><?php echo $dibuka; ?></span>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col m6">
							<div class="card-panel">
								<div class="row">
									<div class="col s12">
										<div class="row">
											<input name="idSetBea" type="hidden" class="validate" value="<?php echo $idSetBea;?>">
											<div class="input-field col m12">
												<input id="nama" type="text" class="validate">
												<label for="nama">NIM</label>
											</div>
											<div class="input-field col m12">
												<input id="penyelenggara" type="text" class="validate">
												<label for="penyelenggara">Nama Lengkap</label>
											</div>
											<div class="input-field col m12">
												<input id="penyelenggara" type="text" class="validate">
												<label for="penyelenggara">Jurusan</label>
											</div>
											<div class="input-field col m12">
												<input id="penyelenggara" type="text" class="validate">
												<label for="penyelenggara">Semester</label>
											</div>
											<div class="input-field col m12">
												<input id="penyelenggara" type="text" class="validate">
												<label for="penyelenggara">SKS</label>
											</div>
											<div class="input-field col m12">
												<input id="penyelenggara" type="text" class="validate">
												<label for="penyelenggara">IPK</label>
											</div>
											<div class="input-field col m12">
												<input id="penyelenggara" type="text" class="validate">
												<label for="penyelenggara">Tempat Lahir</label>
											</div>
											<div class="input-field col m12">
												<input id="dibuka" type="date" class="validate datepicker">
												<label for="dibuka">Tanggal Lahir<span>*Thn-Bln-Tgl</span></label>
											</div>
											<div class="input-field col m12">
												<input id="penyelenggara" type="text" class="validate">
												<label for="penyelenggara">Alamat Asal</label>
											</div>
											<div class="input-field col m12">
												<input id="penyelenggara" type="text" class="validate">
												<label for="penyelenggara">Alamat Malang</label>
											</div>
											<div class="input-field col m12">
												<input id="penyelenggara" type="text" class="validate">
												<label for="penyelenggara">Nomor Telepon</label>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col m6 s12">
							<div class="card-panel">
								<div class="row">
									<div class="col s12">
										<div class="row" id="scoring">
											<!-- area scoring -->
											<?php
												echo $comboBox;
											 ?>
										</div>
										<hr><hr>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- container END -->
</main>
<script type="text/javascript">
	document.addEventListener("DOMContentLoaded", function(event) {
		// document ready
	});

	function revisi() {
		$('#modal1').openModal();
	}

	function revisi_simpan(nama) {
		var url;
		if (nama == 'terima') {
			url = "<?php echo site_url('kabag/C_request/terima')?>";
		} else {
			url = "<?php echo site_url('kabag/C_request/revisi')?>";
		}
		$.ajax({
			url: url,
			type: "POST",
			data: $('#formInput').serialize(),
			dataType: "JSON",
			success: function(data) {
				window.location.href = "<?php echo base_url('kabag/C_request')?>";
			},
			error: function(jqXHR, textStatus, errorThrown) {
				alert('Error adding/update data');
			}
		});
	}
</script>

<!-- Modal Structure -->
<div id="modal1" class="modal">
	<div class="modal-content">
		<h4>Revisi Form Beasiswa</h4>
		<form action="#" id="formInput">
			<div class="">
				<div class="input-field">
					<input type="hidden" id="idBea" name="idBea" value="<?php echo $idSetBea;?>">
					<textarea id="keterangan" name="keterangan" class="materialize-textarea"></textarea>
          <label for="keterangan">Keterangan</label>
				</div>
			</div>
		</form>
	</div>
	<div class="modal-footer">
		<button class=" modal-action modal-close waves-effect waves-green btn-flat" onclick="revisi_simpan('revisi')">Simpan</button>
	</div>
</div>
