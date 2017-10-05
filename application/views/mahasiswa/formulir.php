<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="msapplication-tap-highlight" content="no">
  <meta name="description" content="MateRio is a responsive Admin Template based on Material Design by Google.">
  <meta name="keywords" content="materialize, admin template, dashboard template, responsive admin template,">
  <title>Formulir</title>

  <link href="<?php echo base_url('assets/css/materialize.css')?>" type="text/css" rel="stylesheet" media="screen">
  <link rel="stylesheet" href="http://fonts.googleapis.com/icon?family=Material+Icons">
  <!-- Additional plugins styles -->
  <link href="<?php echo base_url('assets/css/plugins/prism.css')?>" type="text/css" rel="stylesheet" media="screen">
  <link href="<?php echo base_url('assets/css/plugins/simplebar.css')?>" type="text/css" rel="stylesheet" media="screen">
  <!-- Assistance.css are used only for template support. No need to use it on "production" -->
  <link href="<?php echo base_url('assets/css/assistance.css')?>" type="text/css" rel="stylesheet" media="screen">
  <style type="text/css">
  html,
  body{
    height: 100%;
  }
  main {
    padding: 0 !important;
  }
  .form-header {
    padding: 12px 24px 12px 12px;
  }
  .form-header .col{
    height:64px;
  }
  .form-body {
    padding: 12px 24px;
  }
  </style>
</head>

<body>

  <!-- Main Start -->
  <main class="valign-wrapper">
    <div class="container valign">

      <!--  Tables Section-->
      <div id="login" class="row">
        <!-- <h1 class="thin">Login</h1> -->
        <div class="col s12 m12 l12 card-panel">
          <form class="login-form" method="post" action="<?php echo base_url(); ?>mahasiswa/C_formulir/simpan">
            <div class="row primary-color form-header">
              <div class="col s2">
                <img src="<?php echo base_url('assets/img/favicon 64 uin.png')?>" alt="logo" class="logo responsive-img-height">
              </div>
              <div class="col s10 right-align">
                <h5 class="light white-text">Formulir Pendaftaran Beasiswa <span class="blue-text"> <?php echo $namaBea->namaBeasiswa; ?></span></h5>
              </div>
            </div>
            <div class="row">
              <div class="col m6 s12">
                <div class="form-body">
                  <div class="row">
                    <div class="input-field col s12">
                      <i class="mdi-action-lock-open prefix"></i>
                      <input name="nim" id="username" type="text" class="validate" value="<?php echo $nim;?>" required>
                      <label for="username" class="center-align">NIM</label>
                    </div>
                  </div>
                  <div class="row">
                    <div class="input-field col s12">
                      <i class="mdi-action-perm-identity prefix"></i>
                      <input id="email" name="nama" type="text" class="validate" value="<?php echo $nama;?>" required>
                      <label for="email" class="center-align">Nama Lengkap</label>
                    </div>
                  </div>
                  <div class="row">
                    <div class="input-field col s2 m2 l1">
                      <i class="mdi-action-label-outline prefix"></i>
                    </div>
                    <div class="input-field col s10 m10 l11">
                      <select name="jurusan" id="jurusan" required>
                        <option value="" disabled selected>-Pilihan Jurusan</option>
                        <?php
                          foreach ($jurusan as $jur) {
                            echo '<option value="'.$jur->id.'">'.$jur->namaJur.'</option>';
                          }
                         ?>
                      </select>
                      <label>Jurusan</label>
                    </div>
                  </div>
                  <div class="row">
                    <div class="input-field col s2 m2 l1">
                      <i class="mdi-action-turned-in-not prefix"></i>
                    </div>
                    <div class="input-field col s10 m10 l11">
                      <select name="semester" id="semester" required>
                        <option value="" disabled selected>-Pilihan Semester</option>
                        <?php
                        for ($i=1; $i < 15; $i++) {
                          echo '<option value="'.$i.'">'.$i.'</option>';
                        }
                        ?>
                      </select>
                      <label>Semester</label>
                    </div>
                  </div>
                  <div class="row">
                    <div class="input-field col s12">
                      <i class="mdi-action-assignment prefix"></i>
                      <input name="sks" id="sks" type="text" class="validate" required>
                      <label for="username" class="center-align">SKS</label>
                    </div>
                  </div>
                  <div class="row">
                    <div class="input-field col s12">
                      <i class="mdi-action-book prefix"></i>
                      <input name="ipk" id="username" type="text" class="validate" required>
                      <label for="username" class="center-align">IPK</label>
                    </div>
                  </div>
                  <div class="row">
                    <div class="input-field col s12">
                      <i class="mdi-action-face-unlock prefix"></i>
                      <input name="tempatLahir" id="username" type="text" class="validate" value="<?php echo $tempatLahir;?>" required>
                      <label for="username" class="center-align">Tempat Lahir</label>
                    </div>
                  </div>
                  <div class="row">
                    <div class="input-field col s12">
                      <i class="mdi-action-event prefix"></i>
                      <input name="tglLahir" id="username" type="text" class="validate" value="<?php echo $tglLahir;?>" required>
                      <label for="username" class="center-align">Tanggal Lahir</label>
                    </div>
                  </div>
                  <div class="row">
                    <div class="input-field col s12">
                      <i class="mdi-action-home prefix"></i>
                      <input name="alamatAsal" id="username" type="text" class="validate" value="<?php echo $asalKota;?>" required>
                      <label for="username" class="center-align">Alamat Asal</label>
                    </div>
                  </div>
                  <div class="row">
                    <div class="input-field col s12">
                      <i class="mdi-action-markunread-mailbox prefix"></i>
                      <input name="alamatMalang" id="username" type="text" class="validate" required>
                      <label for="username" class="center-align">Alamat Malang</label>
                    </div>
                  </div>
                  <div class="row">
                    <div class="input-field col s12">
                      <i class="mdi-action-settings-cell prefix"></i>
                      <input name="noTelp" id="username" type="text" class="validate" value="<?php echo $noTelp;?>" required>
                      <label for="username" class="center-align">Nomor Telepon</label>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col m6 s12">
                <div class="form-body">

                 <?php
                    echo $combo;
                   ?> 

                  <div class="row">
                    <small class="blue-text">
                      **Pastikan semua data yang anda masukkan adalah benar. <br>
                      **Dengan meng-klik "Daftar Sekarang", berarti anda telah menyetuji prasyarat dan ketentuan yang telah ditetapkan oleh Kemahasiswaan.
                    </small>
                    <div class="input-field col s12 right">
                      <button class="btn-large waves-effect waves-light col s12 blue" type="submit" name="action1" value="Update">Daftar Sekarang</button>
                    </div>
                    <input name="idBea" id="idBea" type="hidden" class="validate" value="<?php echo $idBea?>">
                    <input name="tanggal" id="tanggal" type="hidden" value="<?php echo date("Y-m-d");?>">
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div><!-- container end -->

  </main>
  <!-- Main End -->

  <!-- -------------------------------------------------+
  Template Scripts
  +-------------------------------------------------- -->

  <!-- jQuery Library -->
  <script type="text/javascript" src="<?php echo base_url('assets/js/bin/jquery-2.1.4.min.js')?>"></script>
  <script>if (!window.jQuery) { document.write('<script src="<?php echo base_url('assets/js/bin/jquery-2.1.4.min.js')?>"><\/script>'); }</script>
  <!-- jQuery Plugins -->
  <script type="text/javascript" src="<?php echo base_url('assets/js/bin/plugins/prism.js')?>"></script>
  <script type="text/javascript" src="<?php echo base_url('assets/js/bin/plugins/simplebar.min.js')?>"></script>
  <!--materialize js-->
  <script type="text/javascript" src="<?php echo base_url('assets/js/bin/materialize.min.js')?>"></script>
  <script type="text/javascript" src="<?php echo base_url('assets/js/bin/initialize.js')?>"></script>
  <!-- ScrollFire initialize -->

</body>
</html>
