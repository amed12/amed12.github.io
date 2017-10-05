<main>
	<div class="container">
		<h3><span class="blue-text">Profile Mahasiswa</span></h3>
		<div class="col s12 m4 l6">
			<?php echo $this->session->flashdata('pesan');?></div>
			<div id="messages" class="mailbox section">
				<div class="row">
					<div class="col s12">
						<div class="z-depth-1">
							<ul class="tabs account">
								<li class="col s6 tab"><a class="active" href="#personal">Profile</a></li>
								<li class="col s6 tab"><a href="#password">Password</a></li>
								<!-- <li class="col s4 tab"><a href="#privacy">Privacy</a></li> -->
							</ul>
						</div>
					</div>
					<div class="col s12">
						<div class="card-panel no-padding">
							<!-- Personal tab START -->
							<div id="personal">
								<form method="post" action="<?php echo base_url(); ?>mahasiswa/C_profileMhs/simpan" enctype="multipart/form-data">
									<div class="form-pad">
										<div class="row">
											<div class="col s12 m6 l6">
												<!-- <div class="col s12 m6 pull-m6" > -->
												<div class="col s12" >
													<!-- Personal info PROFILE PHOTO -->
													<div class="form-pad center-align col s12 m6 offset-m3">
														<img class="responsive-img square" src="<?=base_url()?>/assets/img/profile/<?=$fotoMhs;?>">
														<div class="file-field input-field">
															<div class="btn no-float primary-color">
																<i class="material-icons large" >file_upload</i>
																<input type="file" title="Upload Foto" name="filefoto">
																<input type="hidden" name="nimm" class="form-control" value="<?php echo $nimMhs;?>">
																<input type="hidden" name="filelama" value="<?php echo $fotoMhs;?>">
															</div>
															<div class="file-path-wrapper hide">
																<input class="file-path validate center-align" type="text">
															</div>
															<div>
																<small class="blue-text">** Max.size 100Kb, [jpeg |jpg |png]</small>
															</div>
														</div>
													</div>						
												</div>
												<!-- <div class="col s12 m6 pull-m6"> -->
												<div class="col s12">
													<div class="input-field">
														<i class="mdi-action-account-balance-wallet prefix"></i>
														<input id="angkatan" name="angkatan" type="text" class="validate" placeholder="Angkatan" value="<?php echo $angkatan;?>" readonly>
														<label for="first_name">Angkatan</label>
													</div>
													<div class="input-field">
														<i class="mdi-image-filter-1 prefix"></i>
														<input name="nim" id="nim" type="text" class="validate" placeholder="NIM" value="<?php echo $nimMhs;?>" readonly>
														<label for="last_name">NIM</label>
													</div>
													<div class="input-field">
														<i class="mdi-action-account-box prefix"></i>
														<input name="namaMhs" id="namaMhs" type="tel" class="validate" placeholder="Nama Mahasiswa" value="<?php echo $namaLengkap;?>" >
														<label for="phone">Nama Mahasiswa</label>
													</div>

													<div class="input-field">
														<i class="mdi-social-location-city prefix"></i>
														<input name="tempatLahir" id="tempatLahir" type="text" class="validate" placeholder="Tempat Lahir" value="<?php echo $tempatLahir;?>" >
														<label for="last_name">Tempat Lahir</label>
													</div>
													<div class="input-field">
														<i class="mdi-action-alarm-add prefix"></i>
														<input name="tglLahir" id="tglLahir" type="date" class="validate datepicker" placeholder="Tanggal Lahir" value="<?php echo $tglLahir;?>" >
														<label for="last_name">Tanggal Lahir  <span>*Thn-Bln-Tgl</span></label>
													</div>
													<div class="input-field">
														<i class="mdi-communication-location-on prefix"></i>
														<input id="asalKota" name="asalKota" type="text" class="validate" placeholder="Asal Kota" value="<?php echo $asalKota;?>" >
														<label for="last_name">Asal Kota</label>
													</div>
												</div>
											</div>
											<!-- <div class="col s12 m6 push-m6"> -->
											<div class="col s12 m6 l6">
												<div class="input-field">
													<i class="mdi-social-group prefix"></i>
													<input id="namaOrtu" name="namaOrtu" type="text" class="validate" placeholder="Nama Orang Tua" value="<?php echo $namaOrtu;?>">
													<label for="first_name">Nama Orang Tua</label>
												</div>
												<div class="input-field">
													<i class="mdi-action-home prefix"></i>
													<input id="alamatOrtu" name="alamatOrtu" type="text" class="validate" placeholder="Alamat Orang Tua" value="<?php echo $alamatOrtu;?>" >
													<label for="last_name">Alamat Orang Tua</label>
												</div>
												<div class="input-field">
													<i class="mdi-communication-location-on prefix"></i>
													<input id="kotaOrtu" name="kotaOrtu" type="tel" class="validate" placeholder="Kota Orang Tua" value="<?php echo $kotaOrtu;?>" >
													<label for="phone">Kota Orang Tua</label>
												</div>
												<div class="input-field">
													<i class="mdi-communication-location-off prefix"></i>
													<input id="provinsiOrtu" name="provinsiOrtu" type="text" class="validate" placeholder="Provinsi Orang Tua" value="<?php echo $propinsiOrtu;?>" >
													<label for="last_name">Provinsi Orang Tua</label>
												</div>
												<div class="input-field">
													<i class="mdi-action-home prefix"></i>
													<input id="alamat" name="alamat" type="text" class="validate" placeholder="Alamat Lengkap" value="<?php echo $alamatLengkap;?>" >
													<label for="last_name">Alamat Lengkap</label>
												</div>

												<div class="input-field with-note">
													<i class="mdi-communication-call prefix"></i>
													<input id="noTelp" name="noTelp" type="tel" class="validate" placeholder="Nomor Telephon" value="<?php echo $noTelp;?>" onkeyup="validAngka(this)" maxlength="12">
													<label for="skills">Nomor Telephon</label>
													<small class="blue-text">** Isi hanya dengan Angka</small>
												</div>
												<div class="input-field with-note">
													<i class="mdi-communication-email prefix"></i>
													<input id="email" name="email" type="text" class="validate" value="<?php echo $emailAktif;?>">
													<label for="skills">Email</label>
													<small class="blue-text">** Example : name@gmail.com</small>
												</div>
											</div>

										</div>
										<!-- Save Cancel -->
										<div class="row">
											<div class="col s12 m8 push-m4">
												<a href="<?php echo base_url('mahasiswa/C_mahasiswa/profile') ?>" class="modal-action modal-close waves-effect red btn"><i class="mdi-navigation-cancel left"></i>Cancel</a>
												<button type="submit" class="btn green"><i class="mdi-navigation-refresh left"></i>Save</button>
											</div>
										</div>
									</div>
								</form>
							</div>
							<!-- Personal tab END -->
							<!-- Password tab START -->
							<div id="password">
								<form method="post" onsubmit="return cekform();" action="<?php echo base_url(); ?>mahasiswa/C_profileMhs/simpanPassword">
									<div class="form-pad">
										<div class="row">
											<div class="col s12">
												<div class="input-field">
													<input id="current" type="text" class="validate" name="userid" value="<?php echo $this->session->userdata('username');?>" readonly>
													<label for="current">UserId</label>
												</div>
												<div class="input-field">
													<?php echo form_password(['name'=>'pwdnow','id'=>'pwdnow']); ?>
													<?php echo form_error('pwdnow','<div class="text-danger">','</div>');?>
													<label for="current">Current Password</label>
												</div>
												<div class="input-field">
													<?php echo form_password(['name'=>'pwdnew','id'=>'pwdnew']); ?>
													<?php echo form_error('pwdnew','<div class="text-danger">','</div>');?>
													<label for="new">New Password</label>
												</div>
												<div class="input-field">
													<?php echo form_password(['name'=>'retypepwd','id'=>'retypepwd']); ?>
													<?php echo form_error('retypepwd','<div class="text-danger">','</div>');?>
													<label for="re-type-new">Re-type New Password</label>
												</div>
												<div class="input-field">
													<a href="<?php echo base_url('mahasiswa/C_mahasiswa/profile') ?>" class="modal-action modal-close waves-effect red btn"><i class="mdi-navigation-cancel left"></i>Cancel</a>
													<button type="submit" class="btn green"><i class="mdi-navigation-refresh left"></i>Update Password</button>
												</div>
											</div>
										</div>
									</div>
								</form>
							</div>
							<!-- Password tab END -->
							<!-- Privacy tab START -->
						</div>
					</div>
				</div>
			</div>
		</div>
	</main>
	<script type="text/javascript">
		function sweet1() {
			swal("Update Berhasil!", "Perubahan Disimpan!", "success");
		}

		function sweet() {
			swal("SILAHKAN LOGIN!", "Perubahan Disimpan!", "success");
		}
	</script>
	<script type="text/javascript">
	function cekform() {
		if(!$("#pwdnow").val())
		{
			alert('Curret Password tidak boleh kosong');
			$("#pwdnow").focus()
			return false;
		}
		if(!$("#pwdnew").val())
		{
			alert('New Password tidak boleh kosong');
			$("#pwdnew").focus()
			return false;
		}
		if(!$("#retypepwd").val())
		{
			alert('Re-type New Password tidak boleh kosong');
			$("#retypepwd").focus()
			return false;
		}
	}
</script>