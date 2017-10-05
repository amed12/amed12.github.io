<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="msapplication-tap-highlight" content="no">
  <meta name="description" content="Mate Rio is a responsive Admin Template based on Material Design by Google.">
  <meta name="keywords" content="materialize, admin template, google material, dashboard template, responsive admin template,">
  <link rel="icon" type="image/x-icon" href="<?php echo base_url()?>assets/img/icons/favicons/uin.ico" />
  <title>Beasiswa | Staff Kemahasiswaan</title>

  <!-- Preloader stage (extracted for first show) -->
  <link href="<?php echo base_url('assets/css/preloader-stage.css')?>" type="text/css" rel="stylesheet" media="screen">
  <link href="<?php echo base_url('assets/css/materialize.css')?>" type="text/css" rel="stylesheet" media="screen">
  <link rel="stylesheet" href="http://fonts.googleapis.com/icon?family=Material+Icons">
  <!-- Additional plugins styles -->
  <link href="<?php echo base_url('assets/css/plugins/prism.css')?>" type="text/css" rel="stylesheet" media="screen">
  <link href="<?php echo base_url('assets/css/plugins/simplebar.css')?>" type="text/css" rel="stylesheet" media="screen">
  <link href="<?php echo base_url('assets/css/plugins/justifiedGallery.css')?>" type="text/css" rel="stylesheet" media="screen">
  <!-- Assistance.css are used only for template support. No need to use it on "production" -->
  <link href="<?php echo base_url('assets/css/assistance.css')?>" type="text/css" rel="stylesheet" media="screen">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/sweetalert/sweetalert.css');?>">

  <script src="<?php echo base_url('assets/js/bin/jquery-2.1.4.min.js')?>"></script>
  <script src="<?php echo base_url('assets/chartjs/Chart.min.js');?>" type="text/javascript"></script>
  <script src="<?php echo base_url('assets/sweetalert/sweetalert.min.js');?>" charset="utf-8"></script>
  <script src="https://cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>  
  <style type="text/css"> 
    title {
      visibility: hidden;
    }
    @media print {
      @page { size: landscape; 
      }
      
      body * {
        visibility: hidden;
      }
      #diprint, #diprint * {
        visibility: visible;
      }
      #diprint {
        position: absolute;
        left: 0;
        top: 0;
      }
    }
  </style>
</head>

<body class="loading">
  <!-- Preloader START -->
  <div class="stage-wrapper">
    <div class="stage">

      <div class="preloader-wrapper big active">
        <div class="spinner-layer">
          <div class="circle-clipper left">
            <div class="circle"></div>
          </div><div class="gap-patch">
          <div class="circle"></div>
        </div><div class="circle-clipper right">
        <div class="circle"></div>
      </div>
    </div>
  </div>

</div>
</div>
<!-- Preloader END -->
<!-- Header START -->
<header>
  <!-- Navigation Bar on the top, for medium and small devices -->
  <div class="brand-logo hide-on-large-only"><img src="<?php echo base_url();?>assets/img/UIN ukuran 512.png" alt="logo" class="logo responsive-img"></div>
  <div class="navbar-fixed hide-on-large-only">
    <nav>
      <div class="nav-wrapper">
        <ul class="right">
          <!-- <li class="hide-on-small-only"><a href="#search-in-modal" class="modal-trigger"><i class="mdi-action-search"></i></a></li> -->
          <li class="hide-on-small-only"><a href="<?php echo base_url();?>staf_kemahasiswaan/C_staff/profile"><i class="mdi-action-perm-identity"></i></a></li>
          <li class="hide-on-small-only"><a href="#" onClick="logout()"><i class="mdi-action-exit-to-app"></i></a></li>
          <li class="toogle-side-nav"><a href="#" data-activates="slide-menu" class="button-collapse"><i class="mdi-navigation-menu"></i></a></li>
        </ul>
      </div>
    </nav>
  </div>
  <!-- Side Navigation - fixed for large (nice scroll with Simplebar plugin), slide/drag for medium and small devices -->
  <div id="slide-menu" class="side-nav fixed" data-simplebar-direction="vertical">
    <ul class="side-nav-main">
      <li class="logo hide-on-med-and-down"><img src="<?php echo base_url();?>assets/img/UIN ukuran 512.png" width="100" height="150" alt="logo" class="logo responsive-img"></li>
      <li class="side-nav-inline hide-on-med-only"><a href="#" onClick="logout()" class="inline waves-effect" title="Logout"><i class="mdi-action-exit-to-app"></i></a> <a href="<?php echo base_url();?>staf_kemahasiswaan/C_staff/profile" class="inline waves-effect" title="Profile"><i class="mdi-action-perm-identity"></i></a> <!-- <a href="#search-in-modal" class="inline waves-effect modal-trigger"><i class="mdi-action-search"></i></a> --></li>
      <li><a href="<?php echo base_url();?>staf_kemahasiswaan/C_staff" class="waves-effect"><i class="mdi-action-dashboard left"></i><span>Beranda</span></a></li>
      <li><a href="<?php echo base_url();?>staf_kemahasiswaan/C_staff/profile" class="waves-effect"><i class="mdi-action-account-box left"></i><span>Profile</span></a></li>
      <li><a href="<?php echo base_url();?>staf_kemahasiswaan/C_staff/daftarBerita" class="waves-effect"><i class="mdi-action-settings left"></i><span>Management Berita</span></a></li>
      <li><a href="<?php echo base_url('staf_kemahasiswaan/C_staff/Pemohon');?>" class="waves-effect"><i class="mdi-maps-local-print-shop left"></i><span>Lap.Pemohon Beasiswa</span></a></li>
      <li><a href="<?php echo base_url('staf_kemahasiswaan/C_staff/Penerima');?>" class="waves-effect"><i class="mdi-maps-local-print-shop left"></i><span>Lap.Penerima Beasiswa</span></a></li>
      <li><a href="<?php echo base_url('staf_kemahasiswaan/C_staff/viewGrafik');?>" class="waves-effect"><i class="mdi-maps-local-print-shop left"></i><span>Lap.Grafik</span></a></li>
    </ul>
  </div>
  <!-- Search in Modal START -->
  <div id="search-in-modal" class="modal">
    <div class="modal-content">
      <nav class="flat">
        <div class="nav-wrapper">
          <form>
            <div class="input-field">
              <input id="search" type="search" class="secondary-color-text white" style="margin:0;" required>
              <label for="search"><i class="material-icons secondary-color-text">search</i></label>
              <i class="material-icons modal-action modal-close">close</i> </div>
            </form>
          </div>
        </nav>
      </div>
      <div class="modal-footer"> <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Search now</a> </div>
    </div>
    <!-- Search in Modal END -->
  </header>
