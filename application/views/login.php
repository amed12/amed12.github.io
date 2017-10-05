<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="msapplication-tap-highlight" content="no">
  <meta name="description" content="MateRio is a responsive Admin Template based on Material Design by Google.">
  <meta name="keywords" content="materialize, admin template, dashboard template, responsive admin template,">
  <link rel="icon" type="image/x-icon" href="<?php echo base_url()?>assets/img/icons/favicons/uin.ico" />
  <title>Sistem Informasi Beasiswa - Login</title>

  <link href="<?php echo base_url()?>assets/css/materialize.css" type="text/css" rel="stylesheet" media="screen">
  <link rel="stylesheet" href="http://fonts.googleapis.com/icon?family=Material+Icons">
  <link href="<?php echo base_url()?>assets/css/plugins/prism.css" type="text/css" rel="stylesheet" media="screen">
  <link href="<?php echo base_url()?>assets/css/plugins/simplebar.css" type="text/css" rel="stylesheet" media="screen">
  <link href="<?php echo base_url()?>assets/css/assistance.css" type="text/css" rel="stylesheet" media="screen">
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
       <div class="col s12 m8 l6 offset-m2 offset-l3 card-panel">
        <div class="card-panel alert" style="display: none;"></div>
        <form class="login-form" action="<?php echo base_url('functLogin/prosesLogin') ?>" method="post">
          <div class="row primary-color form-header">
            <div class="col s4">
              <img src="<?php echo base_url();?>assets/img/favicon 64 uin.png" alt="logo" class="logo responsive-img-height">
            </div>
            <div class="col s8 right-align">
              <h4 class="light white-text">Login</h4>

            </div>
          </div>
          <div class="form-body">
            <div class="row">
              <div class="input-field col s12">
                <i class="mdi-social-person prefix"></i>
                <input id="username" type="text" class="validate" name="username">
                <label for="username" class="center-align">Username</label>
              </div>
            </div>
            <div class="row">
              <div class="input-field col s12">
                <i class="mdi-action-lock prefix"></i>
                <input id="password" type="password" name="password">
                <label for="password">Password</label>
              </div>
            </div>
            <div class="row">
              <div class="input-field col s12 with-note">
                <select name="levelPengguna" id="levelPengguna">
                  <option>Pilih Level Pengguna</option>
                  <option value="6">Admin</option>
                  <option value="4">kabag</option>
                  <option value="2">Kasubag</option>
                  <option value="3">Kasubag Fakultas</option>
                  <option value="1">Staff Kemahasiswaan</option>
                  <option value="5">Mahasiswa</option>
                </select>
                <label for="levelPengguna">Level Pengguna</label>
                <small class="blue-text">Jika saat login ada notifikasi "Data anda tidak terdaftar dalam sistem"<br/> *  Pastikan Anda memasukkan userId dan Password dengan benar <br/>**  Anda Kemungkinan terdaftar sebagai penerima Beasiswa Lain di periode ini <br/>***  Hubungi Bagian Kemahasiswaan</small>
              </div>
            </div>
            <div class="row">
              <div class="input-field col s12">
                <button type="submit" class="btn-large waves-effect waves-light col s12">Login</button>
                <!-- <input type="hidden" name="status" value="<?php echo $stat?>"> -->
              </div>
            </div>
            <div class="row">
              <div class="col s6">
                <p class="margin medium-small"><a href="register.html">Register Now!</a></p>
              </div>
              <div class="col s6">
                <p class="margin right-align medium-small"><a href="reset-password.html">Forgot password?</a></p>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

</main>
<!-- Main End -->


<!-- jQuery Library -->
<script type="text/javascript" src="<?php echo base_url()?>assets/js/bin/jquery-2.1.4.min.js"></script>
<script>if (!window.jQuery) { document.write('<script src="<?php echo base_url()?>assets/js/bin/jquery-2.1.4.min.js"><\/script>'); }</script>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/bin/plugins/prism.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/bin/plugins/simplebar.min.js"></script>
<!--materialize js-->
<script type="text/javascript" src="<?php echo base_url()?>assets/js/bin/materialize.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/bin/initialize.js"></script>
<script type="text/javascript">
  <?php if ($this->session->flashdata('gagal')): ?>
  $('.alert').html('<?php echo $this->session->flashdata('gagal') ?>').fadeIn();
<?php endif ?>
</script>

</body>
</html>
