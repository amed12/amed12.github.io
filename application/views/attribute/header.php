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
<title>Beasiswa | Admin</title>

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
<script src="<?php echo base_url('assets/js/bin/jquery-2.1.4.min.js')?>"></script>
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
  <div class="brand-logo hide-on-large-only"><img src="<?php echo base_url();?>assets/img/UIN ukuran 512.png" width="100" height="150" alt="logo" class="logo responsive-img"></div>
  <div class="navbar-fixed hide-on-large-only">
    <nav>
      <div class="nav-wrapper">
        <ul class="right">
          <li class="hide-on-small-only"><a href="#search-in-modal" class="modal-trigger"><i class="material-icons">search</i></a></li>
          <li class="hide-on-small-only"><a href="account.html"><i class="material-icons">perm_identity</i></a></li>
          <li class="hide-on-small-only"><a href="#" onClick="logout()"><i class="material-icons">exit_to_app</i></a></li>
          <li class="toogle-side-nav"><a href="#" data-activates="slide-menu" class="button-collapse"><i class="material-icons">menu</i></a></li>
        </ul>
      </div>
    </nav>
  </div>
  <!-- Side Navigation - fixed for large (nice scroll with Simplebar plugin), slide/drag for medium and small devices -->
  <div id="slide-menu" class="side-nav fixed" data-simplebar-direction="vertical">
    <ul class="side-nav-main">
      <li class="logo hide-on-med-and-down"><img src="<?php echo base_url();?>assets/img/UIN ukuran 512.png" width="100" height="150" alt="logo" class="logo responsive-img"></li>
      <li class="side-nav-inline hide-on-med-only"><a href="#" onClick="logout()" class="inline waves-effect" title="Logout"><i class="mdi-action-exit-to-app"></i></a> <a href="<?php echo base_url();?>mahasiswa/C_mahasiswa/profile" class="inline waves-effect" title="Profile"><i class="mdi-action-perm-identity"></i></a> <a href="#search-in-modal" class="inline waves-effect modal-trigger"><i class="mdi-action-search"></i></a></li>
      <li><a href="#" class="waves-effect"><i class="mdi-action-dashboard left"></i><span>Beranda</span></a></li>
      <li><a href="#" class="waves-effect"><i class="mdi-communication-email left"></i><span>Profile</span></a></li>
      <li>
        <ul class="collapsible" data-collapsible="accordion">
          <li><a class="collapsible-header waves-effect"><i class="mdi-action-description left"></i><span>Manajemen User</span><span class="neutral badge">4</span></a>
            <div class="collapsible-body">
              <ul>
                <li><a href="#">Penerima Beasiswa</a></li>
                <li class="divider"></li>
                <li><a href="#" target="_blank">Pengguna Sistem</a></li>
                <li class="divider"></li>
                <li><a href="#" target="_blank">Register</a></li>
                <li class="divider"></li>
                <li><a href="#" target="_blank"><span>Reset Password</span></a></li>
              </ul>
            </div>
          </li>
          <li><a class="collapsible-header waves-effect"><i class="mdi-editor-format-paint left"></i><span>CSS</span></a>
            <div class="collapsible-body">
              <ul>
                <li><a href="css-colors.html">Colors</a></li>
                <li class="divider"></li>
                <li><a href="css-typo.html">Typography</a></li>
                <li class="divider"></li>
                <li><a href="css-grid.html"><span>Grid</span><span class="neutral badge">12</span></a></li>
                <li class="divider"></li>
                <li><a href="css-shadow.html">Shadow</a></li>
                <li class="divider"></li>
                <li><a href="css-media.html">Media</a></li>
                <li class="divider"></li>
                <li><a href="css-table.html">Table</a></li>
                <li class="divider"></li>
                <li><a href="css-helpers.html">Helpers</a></li>
              </ul>
            </div>
          </li>
          <li><a class="collapsible-header waves-effect"><i class="mdi-av-web left"></i><span>Elements</span></a>
            <div class="collapsible-body">
              <ul>
                <li><a href="ui-badges-chips.html">Badges & Chips</a></li>
                <li class="divider"></li>
                <li><a href="ui-buttons.html">Buttons</a></li>
                <li class="divider"></li>
                <li><a href="ui-cards.html">Cards</a></li>
                <li class="divider"></li>
                <li><a href="ui-collections.html">Collections</a></li>
                <li class="divider"></li>
                <li><a href="ui-forms.html">Forms</a></li>
                <li class="divider"></li>
                <li><a href="ui-icons.html"><span>Icons</span><span class="neutral badge">740+</span></a></li>
                <li class="divider"></li>
                <li><a href="ui-navigations.html">Navigations</a></li>
                <li class="divider"></li>
                <li><a href="ui-preloaders.html">Preloaders</a></li>
              </ul>
            </div>
          </li>
          <li><a class="collapsible-header waves-effect"><i class="mdi-action-extension left"></i><span>Javascripts</span></a>
            <div class="collapsible-body">
              <ul>
                <li><a href="js-collapsible.html">Collapsible</a></li>
                <li class="divider"></li>
                <li><a href="js-dialogs.html">Dialogs</a> </li>
                <li class="divider"></li>
                <li><a href="js-dropdown.html">Dropdown</a> </li>
                <li class="divider"></li>
                <li><a href="js-media.html">Media</a> </li>
                <li class="divider"></li>
                <li><a href="js-modals.html">Modals</a> </li>
                <li class="divider"></li>
                <li><a href="js-parallax.html">Parallax</a> </li>
                <li class="divider"></li>
                <li><a href="js-pushpin.html">Pushpin</a> </li>
                <li class="divider"></li>
                <li><a href="js-scrollfire.html">ScrollFire</a> </li>
                <li class="divider"></li>
                <li><a href="js-scrollspy.html">Scrollspy</a> </li>
                <li class="divider"></li>
                <li><a href="js-sidenav.html">SideNav</a> </li>
                <li class="divider"></li>
                <li><a href="js-tabs.html">Tabs</a> </li>
                <li class="divider"></li>
                <li><a href="js-transitions.html">Transitions</a> </li>
                <li class="divider"></li>
                <li><a href="js-waves.html">Waves</a> </li>
              </ul>
            </div>
          </li>
        </ul>
      </li>
      <li><a href="sass.html" class="waves-effect"><i class="mdi-action-settings left"></i><span>SASS</span></a></li>
      <li><a href="extra.html" class="waves-effect"><i class="mdi-action-thumb-up left"></i><span>Extra</span><span class="alert badge"></span></a></li>
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
