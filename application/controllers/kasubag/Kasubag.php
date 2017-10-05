<?php defined('BASEPATH')OR exit('tidak ada akses diizinkan');
/**
 *
 */
class Kasubag extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->library('Loginauth');
    $this->loginauth->view_page();

    $this->load->model("kasubag/ProfileKasubag",'mdl');
  }

  public function index()
  {
    $this->load->view('attribute/header_kasubag');
    $this->load->view('kasubag/Dashboard');
    $this->load->view('attribute/footer');
  }

  public function profile()
  {

    $user = $this->session->userdata('id');
    $cek = $this->mdl->getdata($user);
    if($this->mdl->getIdentitasAdmin($user) != 0){
      $data =array(
        'foto'    => $cek->foto,
        'id'      => $cek->id,
        'nama'    => $cek->nama,
        'alamat'  => $cek->alamat,
        'noTelp'  => $cek->noTelp,
        'email'   => $cek->email
        );
    }else{
      $data=array(
      'foto'    => "",
      'id'      => "",
      'nama'    => "",
      'alamat'  => "",
      'noTelp'  => "",
      'email'   => ""
      );
    }
    $this->load->view('attribute/header_kasubag');
    $this->load->view('kasubag/v_profile_kasubag',$data);
    $this->load->view('attribute/footer');
  }
}
?>
