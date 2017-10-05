<!DOCTYPE html>
<html lang="en">



<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Stylesheet -->
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,300,100,400italic,500,300italic,500italic,700,700italic' rel='stylesheet' type='text/css'>
    <link href="<?php echo base_url()?>assets/css/achmad/css/materialize.min.css" rel="stylesheet">
    <link href="<?php echo base_url()?>assets/css/achmad/css/slider.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url()?>assets/css/achmad/css/animate.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url()?>assets/css/achmad/css/ionicons.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url()?>assets/css/achmad/css/style.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url()?>assets/css/achmad/style.min.css" rel="stylesheet" type="text/css">

    <script src="<?php echo base_url()?>assets/achmad/js/modernizr.custom.js"></script>

    <!-- Favicons -->
    <link rel="apple-touch-icon-precomposed" sizes="57x57" href="<?php echo base_url()?>assets/img/icons/favicons/57.png" />
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo base_url()?>assets/img/icons/favicons/114.png" />
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo base_url()?>assets/img/icons/favicons/72.png" />
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo base_url()?>assets/img/icons/favicons/72.png" />
    <link rel="apple-touch-icon-precomposed" sizes="60x60" href="<?php echo base_url()?>assets/img/icons/favicons/144.png" />
    <link rel="apple-touch-icon-precomposed" sizes="120x120" href="<?php echo base_url()?>assets/img/icons/favicons/144.png" />
    <link rel="apple-touch-icon-precomposed" sizes="76x76" href="<?php echo base_url()?>assets/img/icons/favicons/76.png" />
    <link rel="apple-touch-icon-precomposed" sizes="152x152" href="<?php echo base_url()?>assets/img/icons/favicons/152.png" />
    <link rel="icon" type="image/x-icon" href="<?php echo base_url()?>assets/img/icons/favicons/uin.ico" />
    <link rel="icon" type="image/png" href="<?php echo base_url()?>assets/img/icons/favicons/512.png" sizes="196x196" />
    <link rel="icon" type="image/png" href="<?php echo base_url()?>assets/img/icons/favicons/114.png" sizes="96x96" />
    <link rel="icon" type="image/png" href="<?php echo base_url()?>assets/img/icons/favicons/57.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="<?php echo base_url()?>assets/img/icons/favicons/57.png" sizes="16x16" />
    <link rel="icon" type="image/png" href="<?php echo base_url()?>assets/img/icons/favicons/144.png" sizes="128x128" />
    <meta name="application-name" content="Sistem Informasi Beasiswa UIN Malang"/>

    <!-- Title -->

    <title>SIBEA</title>

</head>

<body>

<!-- Preloader -->

<!-- Preloader ends -->

<!-- Scroll-to-top Button -->
<div class="scroll-to-top waves-effect waves-light trans-effect">
    <a href="#"><i class="ion-chevron-up"></i></a>
</div><!-- Scroll-to-top Button ends -->

<!-- Site navigation -->
<div id="navigation">
    <nav>
        <div class="container">
            <div class="nav-wrapper">
                <!-- Replace 'src' attribute with the path to your Brand logo -->
                <a href="#" class="brand-logo"><img src="<?php echo base_url()?>assets/img/icons/uin.png" alt=""></a>
                <div class="social-icons">
                    <ul>
                        <!-- Add links to your social profiles here -->
                        <li><a class="icon icon-google btn-floating waves-effect" href="#"><i class="ion-social-googleplus"></i></a></li>
                        <li><a class="icon icon-facebook btn-floating waves-effect" href="https://www.facebook.com/kemahasiswaanUINMalang/"><i class="ion-social-facebook"></i></a></li>
                        <li><a class="icon icon-twitter btn-floating waves-effect" href="#"><i class="ion-social-twitter"></i></a></li>
                    </ul>
                </div>
                <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="ion-android-menu"></i></a>
                <!-- Main navigation -->
                <ul class="right main-nav">
                    <li><a class="waves-effect waves-light" href="#overview">Daftar Beasiswa</a></li>
                    <li><a class="waves-effect waves-light" href="#faq">Berita</a></li>
                    <li><a class="waves-effect waves-light" href="#describe">Tentang sistem beasiswa</a></li>

                    <li><a class="waves-effect waves-light" href="#location">Contact</a></li>

                    <li><a href="<?php echo base_url('Login');?>" class="nav-btn-download waves-effect waves-light btn red white-text"><i class="ion-android-send left"></i>&nbspLogin sekarang</a></li>
                </ul>

                <!-- Mobile sidebar navigation -->
                <ul class="side-nav" id="mobile-demo">
                    <li><a class="waves-effect waves-light" href="#overview">Daftar Beasiswa</a></li>
                    <li><a class="waves-effect waves-light" href="#faq">Berita</a></li>
                    <li><a class="waves-effect waves-light" href="#describe">Tentang sistem beasiswa</a></li>


                    <li><a class="waves-effect waves-light" href="#location">Contact</a></li>

                    <li><a href="<?php echo base_url('Login');?>" class="nav-btn-download waves-effect waves-light btn red white-text"><i class="ion-android-send left"></i>&nbsp&nbspLogin sekarang</a></li>
                </ul>
            </div><!-- Nav-wrapper ends -->
        </div><!-- Container ends -->
    </nav><!-- Nav ends -->
</div><!-- Navigation ends -->

<!-- Section home -->
<section id="home" class="home-section">
    <div class="overlay-shade"></div>
    <div class="container">
        <div class="row btm-mrgn-0">
            <div class="m8 l7 hero-text">
                <h1 class="white-text" style="text-align: center;">Sistem Informasi Beasiswa UIN Maliki Malang</h1>

                <p class="white-text" style="text-align: center;">Sistem Informasi Beasiswa (SIB) merupakan sebuah aplikasi untuk melakukan manajemen pendaftaran dan pengurusan beasiswa yang ada di Universitas Islam Negeri Maulana Malik Ibrahim Malang. Silahkan masukkan username dan password anda untuk melakukan manajemen atau pengolahan data beasiswa sesuai dengan hak akses yang anda masing-masing..</p>
                <div class="download-button scroll-to">
                    <!-- Replace 'href' attribute with the download link  -->

                    <a href="#overview" style="left: 45%;" class="btn-link white-text btn-floating waves-effect waves-light red"><i  class="ion-android-arrow-down"></i></a>
                </div>
            </div><!-- Col ends -->
            <!-- Col ends -->
        </div><!-- Row ends -->




    </div><!-- Container ends -->
</section><!-- Section ends -->

<!-- Section overview -->
<section id="overview" class="overview-section sec-padded-1x">
    <div class="container">
        <div class="row">
            <div class="col s12 l8 offset-l2">
                <div class="center-heading">
                    <h3>List Beasiswa Aktif</h3>
                    <span class="center-line red"></span>
                    <p>Berikut adalah daftar beasiswa yang sedang aktif<br> silahkan login untuk mendaftar</p>
                </div>
            </div>
        </div>
        <div class="row center">
        <?php foreach ($daftar_bea as $r): ?>
            <div class='col s12 m6 l3'>
                <div class='card-panel overview-section-box'>

                    <h3><?php echo $r->namaBeasiswa?></h3>
                    <?php 
                    $paymentDate = date('Y-m-d');
                    $hai;
                    $contractDateBegin = $r->beasiswaDibuka;
                    $contractDateEnd  = $r->beasiswaTutup;
                    if (($paymentDate > $contractDateBegin) && ($paymentDate < $contractDateEnd))
                    {
                    $hai ="<a class='waves-effect waves-light btn blue center md-trigger' >Pendaftaran Dibuka</a>";
                    }
                    else
                    {
                    $hai ="<a class='waves-effect waves-light btn red center md-trigger' >Pendaftaran Ditutup</a>";  
                    }
                    ?>
                    <p>
                        <table>
                                <tr><td><a style="color: black;">Penyelenggara bea</a> </td><td>: <?php echo $r->penyelenggaraBea?></td> </tr>
                                
                                <tr><td><a style="color: black;">Kuota Penerima </a></td><td>: <?php echo $r->kuota?></td> </tr>
                                <tr><td><a style="color: black;">Pendaftaran Dibuka </a></td><td>: <?php echo $r->beasiswaDibuka?></td> </tr>
                                <tr><td><a style="color: black;">Pendaftaran Ditutup </a></td><td>: <?php echo $r->beasiswaTutup?></td> </tr>
                                <?php echo   $hai?>
                                
                                 
                        </table>
                    </p>
                </div>
            </div>
        <?php endforeach; ?>
        
            <!-- Col ends -->
            <!-- Col ends -->
        </div><!-- Row ends -->
        <?php echo $pagination1; ?>
    </div><!-- Container ends -->
</section><!-- Section ends -->
<!-- Section faq -->
<section id="faq" class="faq-section sec-padded-1x z-depth-1">
    <div class="container">
        <div class="row">

            <div class="section">
                <div class="center-heading">
                    <h3 class="white-text">Berita</h3>
                    <span class="center-line red"></span>
                    <p class="white-text">Beberapa informasi penting yang terupdate :</p>
                </div>
                <div id="blog-post-full">
                    <!-- medium size post-->
                    <?php foreach ($daftar_berita as $r): ?>
                       <div class='card medium'>
                        <div class='card-image'>
                        <img src='<?php echo base_url()?>assets/img/fitri-01.jpg' alt='' class='responsive-img' height=10%> 
                        <span class='card-title'><a style="font-family: cambria;text-transform: capitalize;background: #42a5f5;color: white;"><?php echo $r->judulBerita?></a></span>
                        <span class='card-title blog-post-full-cat right orange'><a href='#'><?php echo $r->topikBerita?></a></span>
                        </div>
                        <div class='card-content'>
                            <p class='ultra-small'><?php echo $r->tglInBerita?></p>
                            <p><?php echo $r->kontenBerita?></p>

                        </div>
                        <div class='card-action'>
                            By <a href='#'><?php echo $r->penulisBerita?></a>
                            <a href='<?php echo base_url('C_dashboard/DetailBerita/'.$r->idBerita);?>' class='right'>Read more</a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php echo $pagination1; ?>

               


            </div><!-- Col ends -->
        </div><!-- Row ends -->
    </div><!-- Container ends -->
</section><!-- Section ends -->

<!-- Section features -->
<!-- Section ends -->

<!-- Section describe -->
<section id="describe" class="describe-section z-depth-1">
    <div class="overlay-blue-shade"></div>
    <div class="sec-padded-1x">
        <div class="container">
            <div class="row">
                <div class="col s12 l8 offset-l2">
                    <div class="center-heading">
                        <h3 class="white-text">Tentang Sistem Informasi Beasiswa</h3>
                        <span class="center-line red"></span>
                        <p class="white-text">Informasi penting mengenai sistem</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col s12">
                    <ul class="tabs z-depth-2">
                        <li class="tab col s3"><a href="#tab-video">Tips Beasiswa</a></li>
                        <li class="tab col s3"><a class="active" href="#tab-heart">Alur Pendaftaran Beasiswa</a></li>
                        <li class="tab col s3"><a href="#tab-compare">FAQ</a></li>
                    </ul>
                </div><!-- Col ends -->
                <div id="tab-video" class="col s12 tab-content wow fadeIn">
                    <div class="col s12 m10 offset-m1">
                        <div class="video-box">
                            
                            <ol>
                <li><p style="font-weight:bold ;">Sambil menunggu pengumuman, siapkan berkas-berkas persyaratan beasiswa</p></li>
                <li><p style="font-weight:bold ;">Sangat dianjurkan untuk menggunakan browser Google Chrome untuk menghindari error pada sistem</p></li>
                            </ol>
                            
                        </div>
                    </div>
                </div><!-- Tab ends -->
                <div id="tab-heart" class="col s12 tab-content wow fadeIn">
                    
                        <img src="<?php echo base_url()?>assets/img/prosesbeasiswa.png" alt="" class="responsive-img">
                    
                    
                </div><!-- Tab ends -->
                <div id="tab-compare" class="col s12 tab-content wow fadeIn">
                    <div class="col s12 m6 l6">
                        <h3>Pertanyaan Seputar Beasiswa</h3>
                        <p>Untuk saat ini karena dalam pengembangan awal silahkan isi pertanyaan didalam link berikut</p>
                       <a href="https://goo.gl/forms/OKptUymyNuFDuClK2">Form isi pertanyaan</a>
                        
                    </div>
                    <div class="col s12 m6 l6 center">
                        <img src="<?php echo base_url()?>assets/img/under-construction.png" alt="" class="responsive-img">
                    </div>
                </div><!-- Tab ends -->
            </div><!-- Row ends -->
        </div><!-- Container ends -->
    </div><!-- Sec-padded ends -->
</section><!-- Section ends -->


<section id="location" class="location-section">
    <div class="container-fluid">
        <div class="row btm-mrgn-0">
            <div class="m6 l6 address-block">
                <div class="center-heading left-align">
                    <h3>Hubungi kami</h3>
                    <span class="center-line red"></span>
                    <p>KANTOR PUSAT Kemahasiswaan dan Alumni UIN Maulana Malik Ibrahim Malang</p>
                </div>
                <ul>
                    <li><p>Jl. Gajayana No.50, Malang</p>
                        <p>Gedung Jenderal Besar H.M. Soeharto (SC Lt. 1)</p>
                        <p>Dinoyo, Kec. Lowokwaru, Kota Malang, Jawa Timur 65144</p>
                    </li>
                    <li><p>0341 569901</p></li>
                    <li><p>kemahasiswaan@uin-malang.ac.id</p></li>
                </ul>
               
            </div>

        </div><!-- Row ends -->
    </div><!-- Container ends -->
</section><!-- Section ends -->

<!-- Section download -->


<!-- Footer -->
<footer id="footer" class="footer-main">
    <div class="container">
        <div class="row">
            <div class="col s12 m8 l8 offset-m2">
                <div class="center-heading wow fadeIn" data-wow-delay="0.1s">
                <!-- Replace 'src' attribute with the path to your Brand logo -->
                <a href="index-2.html"><img src="<?php echo base_url()?>assets/img/icons/UIN512.png" alt=""></a>
                <div class="clearfix"></div>
                <ul class="list-inline footer-social">
                    <!-- Add links to your social profiles here -->
                    <li><a href="https://www.facebook.com/kemahasiswaanUINMalang/"><i class="ion-social-facebook waves-effect waves-light"></i></a></li>
                    <li><a href="#"><i class="ion-social-twitter waves-effect waves-light"></i></a></li>
                    <li><a href="#"><i class="ion-social-googleplus waves-effect waves-light"></i></a></li>
                </ul>
                <span class="copyrights">&copy; 2017. Made with <i class="ion-android-favorite"></i> Allright Reserved By Developer GENBI UIN Maliki Malang</span>
                </div>
            </div>
        </div>
    </div><!-- Container ends -->
</footer><!-- Footer ends -->

<!-- Modal for video preview -->
<div class="md-modal md-effect-1 valign-wrapper" id="m-video">
    <div class="md-content z-depth-2">
        <a class="md-close"><i class="ion-android-close"></i></a>
        <!-- Add your video iframe here -->

    </div>
</div><!-- Modal ends -->

<!-- Modal for contact from -->

<div class="md-modal md-effect-1 valign-wrapper" id="m-contact">
    <div class="md-content z-depth-2">
        <h3>Shoot Us a Message</h3>
        <a class="md-close"><i class="ion-android-close"></i></a>
        <p>We would love to hear from you. Get in touch with us now. </p>
        <div class="row">
            <form id="contactForm" class="col s12">
                <div class="row">
                    <div class="input-field col s12">
                        <input id="last_name" name="fullname" type="text">
                        <label for="last_name">Last Name</label>
                    </div>
                    <div class="input-field col s12">
                        <input id="email" name="email" type="email">
                        <label for="email">Email</label>
                    </div>
                    <div class="input-field col s12">
                        <textarea id="textarea1" name="message" class="materialize-textarea"></textarea>
                        <label for="textarea1">Textarea</label>
                    </div>
                    <div class="input-field col s12">
                        <input class="waves-effect waves-light btn red center" type="submit" value="Submit" />
                    </div>
                </div>
            </form>
        </div>
    </div>
</div><!-- Modal ends -->

<!-- Modal for subscription from -->
<div class="md-modal md-effect-1 valign-wrapper" id="m-sub">
    <div class="md-content z-depth-2">
        <h3>Subscribe to our Newsletter</h3>
        <a class="md-close"><i class="ion-android-close"></i></a>
        <p>Subscribe to the mailing list to keep up with new features & updates from us. Don't worry... we don't like spam either.</p>
        <div class="row">
            <form id="subscribeForm" class="col s12">
                <div class="row">
                    <div class="input-field col s12">
                        <input id="email-sub" name="email" type="email">
                        <label for="email-sub">Email</label>
                    </div>
                    <div class="input-field col s12">
                        <input class="waves-effect waves-light btn red center" type="submit" value="Subscribe" />
                    </div>
                </div>
            </form>
        </div>
    </div>
</div><!-- Modal ends -->

<!-- Scripts -->

<script src="<?php echo base_url()?>assets/achmad/js/jquery-1.12.3.min.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>assets/achmad/js/materialize.min.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>assets/achmad/js/jquery.smoothscroll.min.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>assets/achmad/js/typed.min.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>assets/achmad/js/wow.min.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>assets/achmad/js/waypoint.min..js" type="text/javascript"></script>
<script src="<?php echo base_url()?>assets/achmad/js/jquery.counterup.min.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>assets/achmad/js/owl.carousel.min.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>assets/achmad/js/jquery.flexslider-min.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>assets/achmad/js/jquery.validate.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>assets/achmad/js/classie.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>assets/achmad/js/config.js" type="text/javascript"></script>
<script type="text/javascript">
    (function titleScroller(text) {
    document.title = text;
    setTimeout(function () {
        titleScroller(text.substr(1) + text.substr(0, 1));
    }, 500);
}(" SIBEA - UIN Maulana Malik Ibrahim Malang "));



</script>

</body>



</html>

