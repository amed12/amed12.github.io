<?php defined('BASEPATH')OR exit('tidak ada akses diizinkan');
/**
*
*/
class C_kasubag extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->library('Loginauth');
    $this->loginauth->view_page();
  }

  public function index()
  {
    $this->load->view('attribute/header_kasubag');
    $this->load->view('kasubag/Dashboard');
    $this->load->view('attribute/footer');
  }
}
?>
