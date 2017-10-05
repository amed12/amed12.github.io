<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Stylesheet -->
        <link href='https://fonts.googleapis.com/css?family=Roboto:400,300,100,400italic,500,300italic,500italic,700,700italic' rel='stylesheet' type='text/css'>
        <link href="<?php echo base_url() ?>assets/css/achmad/css/materialize.min.css" rel="stylesheet">
        <link href="<?php echo base_url() ?>assets/css/achmad/css/slider.css" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url() ?>assets/css/achmad/css/animate.css" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url() ?>assets/css/achmad/css/ionicons.min.css" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url() ?>assets/css/achmad/css/style.css" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url() ?>assets/css/achmad/style.min.css" rel="stylesheet" type="text/css">

        <script src="<?php echo base_url() ?>assets/js/achmad/js/modernizr.custom.js"></script>

        <!-- Favicons -->
        <link rel="apple-touch-icon-precomposed" sizes="57x57" href="<?php echo base_url() ?>assets/img/icons/favicons/apple-touch-icon-57x57.png" />
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo base_url() ?>assets/img/icons/favicons/apple-touch-icon-114x114.png" />
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo base_url() ?>assets/img/icons/favicons/apple-touch-icon-72x72.png" />
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo base_url() ?>assets/img/icons/favicons/apple-touch-icon-144x144.png" />
        <link rel="apple-touch-icon-precomposed" sizes="60x60" href="<?php echo base_url() ?>assets/img/icons/favicons/apple-touch-icon-60x60.png" />
        <link rel="apple-touch-icon-precomposed" sizes="120x120" href="<?php echo base_url() ?>assets/img/icons/favicons/apple-touch-icon-120x120.png" />
        <link rel="apple-touch-icon-precomposed" sizes="76x76" href="<?php echo base_url() ?>assets/img/icons/favicons/apple-touch-icon-76x76.png" />
        <link rel="apple-touch-icon-precomposed" sizes="152x152" href="<?php echo base_url() ?>assets/img/icons/favicons/apple-touch-icon-152x152.png" />
        <link rel="icon" type="image/x-icon" href="<?php echo base_url() ?>assets/img/icons/favicons/favicon.ico" />
        <link rel="icon" type="image/png" href="<?php echo base_url() ?>assets/img/icons/favicons/favicon-196x196.png" sizes="196x196" />
        <link rel="icon" type="image/png" href="<?php echo base_url() ?>assets/img/icons/favicons/favicon-96x96.png" sizes="96x96" />
        <link rel="icon" type="image/png" href="<?php echo base_url() ?>assets/img/icons/favicons/favicon-32x32.png" sizes="32x32" />
        <link rel="icon" type="image/png" href="<?php echo base_url() ?>assets/img/icons/favicons/favicon-16x16.png" sizes="16x16" />
        <link rel="icon" type="image/png" href="<?php echo base_url() ?>assets/img/icons/favicons/favicon-128.png" sizes="128x128" />
        <meta name="application-name" content="Volkan"/>

        <!-- Title -->

        <title>SIB-UIN MALIKI MALANG</title>

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
                        <a href="#" class="brand-logo"><img src="<?php echo base_url() ?>assets/img/icons/uin.png" alt=""></a>
                        <div class="social-icons">
                            <ul>
                                <!-- Add links to your social profiles here -->
                                <li><a class="icon icon-google btn-floating waves-effect" href="#"><i class="ion-social-googleplus"></i></a></li>
                                <li><a class="icon icon-facebook btn-floating waves-effect" href="#"><i class="ion-social-facebook"></i></a></li>
                                <li><a class="icon icon-twitter btn-floating waves-effect" href="#"><i class="ion-social-twitter"></i></a></li>
                            </ul>
                        </div>
                        <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="ion-android-menu"></i></a>


                        <!-- Mobile sidebar navigation -->
                        <ul class="side-nav" id="mobile-demo">
                            <li><a class="waves-effect waves-light" href="#overview">Daftar Beasiswa</a></li>
                            <li><a class="waves-effect waves-light" href="#faq">Berita</a></li>
                            <li><a class="waves-effect waves-light" href="#describe">Tentang sistem beasiswa</a></li>


                            <li><a class="waves-effect waves-light" href="#location">Contact</a></li>

                            <li><a href="<?php echo base_url('Login'); ?>" class="nav-btn-download waves-effect waves-light btn red white-text"><i class="ion-android-send left"></i>&nbsp&nbspLogin sekarang</a></li>
                        </ul>
                    </div><!-- Nav-wrapper ends -->
                </div><!-- Container ends -->
            </nav><!-- Nav ends -->
        </div><!-- Navigation ends -->

        <section id="faq" class="faq-section sec-padded-1x z-depth-1">
            <div class="container">
                <div class="row">

                    <div class="section">
                        <div class="center-heading">
                            <h3 class="white-text"><?php echo $berita->judulBerita?></h3>
                            <span class="center-line red"></span>
                            <p class="white-text"><?php echo $berita->topikBerita?></p>
                        </div>
                        <div class="card card-panel">
                            <div class="card-header">
                                <div class="card-title">
                                    <?php echo $berita->penulisBerita?>
                                    <small><?php echo $berita->tglInBerita?></small>
                                </div>
                                <div class="card-content">
                                    <p><?php echo $berita->kontenBerita?></p>
                                </div>
                                <div class="row">
                                    <a href="<?php echo base_url('C_dashboard');?>" class="btn btn-info"><i class="ion-android-arrow-back"></i> Kembali</a>
                                </div>
                            </div>
                        </div>

                    </div><!-- Col ends -->
                </div><!-- Row ends -->
            </div><!-- Container ends -->
        </section><!-- Section ends -->

        <footer id="footer" class="footer-main">
            <div class="container">
                <div class="row">
                    <div class="col s12 m8 l8 offset-m2 offset-l2">
                        <div class="center-heading wow fadeIn" data-wow-delay="0.1s">
                            <!-- Replace 'src' attribute with the path to your Brand logo -->
                            <a href="index-2.html"><img src="<?php echo base_url() ?>assets/img/icons/uin.png" alt=""></a>
                            <div class="clearfix"></div>
                            <ul class="list-inline footer-social">
                                <!-- Add links to your social profiles here -->
                                <li><a href="#"><i class="ion-social-facebook waves-effect waves-light"></i></a></li>
                                <li><a href="#"><i class="ion-social-twitter waves-effect waves-light"></i></a></li>
                                <li><a href="#"><i class="ion-social-googleplus waves-effect waves-light"></i></a></li>
                            </ul>
                            <span class="copyrights">&copy; 2017. Made with <i class="ion-android-favorite"></i> by Developer GENBI UIN Maliki Malang</span>
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

        <script src="<?php echo base_url() ?>assets/js/achmad/js/jquery-1.12.3.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url() ?>assets/js/achmad/js/materialize.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url() ?>assets/js/achmad/js/jquery.smoothscroll.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url() ?>assets/js/achmad/js/typed.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url() ?>assets/js/achmad/js/wow.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url() ?>assets/js/achmad/js/waypoint.min..js" type="text/javascript"></script>
        <script src="<?php echo base_url() ?>assets/js/achmad/js/jquery.counterup.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url() ?>assets/js/achmad/js/owl.carousel.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url() ?>assets/js/achmad/js/jquery.flexslider-min.js" type="text/javascript"></script>
        <script src="<?php echo base_url() ?>assets/js/achmad/js/jquery.validate.js" type="text/javascript"></script>
        <script src="<?php echo base_url() ?>assets/js/achmad/js/classie.js" type="text/javascript"></script>
        <script src="<?php echo base_url() ?>assets/js/achmad/js/config.js" type="text/javascript"></script>
        <script type="text/javascript">
            (function titleMarquee() {


                document.title = document.title.substring(1) + document.title.substring(1, 0);


                setTimeout(titleMarquee, 500);



            })();



        </script>

    </body>



</html>
