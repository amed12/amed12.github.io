<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Loginauth{

  // public $favicon = 'assets/template/img/favicon.png';

  protected $ci;

  public function __construct()
  {
    $this->ci =& get_instance();
  }

  public function view_page()
  {
    if($this->ci->session->userdata('level')=='1'){
      $url =  explode("/",$_SERVER["REQUEST_URI"]);
      if ($url[2]!="staf_kemahasiswaan") {
        redirect('staf_kemahasiswaan/C_staff');
      }
    }elseif ($this->ci->session->userdata('level')=='2') {
      $url =  explode("/",$_SERVER["REQUEST_URI"]);
      if ($url[2]!="kasubag") {
        redirect('kasubag/Kasubag');
      }
    }elseif ($this->ci->session->userdata('level')=='3') {
      $url =  explode("/",$_SERVER["REQUEST_URI"]);
      if ($url[2]!="kasubag_fakultas") {
        redirect('kasubag_fakultas/C_kasubagfk');
      }
    }elseif ($this->ci->session->userdata('level')=='4') {
      $url =  explode("/",$_SERVER["REQUEST_URI"]);
      if ($url[2]!="kabag") {
        redirect('kabag/C_kabag');
      }
    }elseif ($this->ci->session->userdata('level')=='5') {
      $url =  explode("/",$_SERVER["REQUEST_URI"]);
      if ($url[2]!="mahasiswa") {
        redirect('mahasiswa/C_mahasiswa');
      }
    }elseif ($this->ci->session->userdata('level')=='6') {
      $url =  explode("/",$_SERVER["REQUEST_URI"]);
      if ($url[2]!="C_admin") {
        redirect('C_admin');
      }
    }else{
      $url =  $_SERVER["REQUEST_URI"];
      if ($url!='/beasiswa/Login') {
        redirect('Login');
      }
    }
  }

}
?>
