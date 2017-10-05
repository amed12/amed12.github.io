<?php defined('BASEPATH')OR exit('tidak ada akses diizinkan');
class C_beaAktif extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->library('Loginauth');
    $this->loginauth->view_page();
    $this->load->model("kabag/BeaAktif",'mdl');
  }

  public function index()
  {
    $this->load->view('attribute/header_kabag');
    $data['info_bea'] = $this->mdl->get_bea_aktif();
    $this->load->view('kabag/beaAktif', $data);
    $this->load->view('attribute/footer');
  }

}
 ?>
