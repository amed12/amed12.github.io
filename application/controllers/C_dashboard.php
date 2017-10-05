<?php defined('BASEPATH')OR exit('tidak ada akses di izinkan');
/**
 *
 */
class C_dashboard extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        
        $this->load->model('m_dashboard');
    }

    public function index()
    {
        $this->load->library('pagination');
        $config['base_url'] = base_url()    .'C_dashboard/index/';
        $config['total_rows'] = $this->m_dashboard->total_record();
        $config['per_page'] = 4;
        $config['uri_segment'] = 3;
        $this->pagination->initialize($config); 
        $pagi1 = $this->pagination->create_links();
        $config2['base_url'] = base_url()    .'C_dashboard/index/';
        $config2['total_rows'] = $this->m_dashboard->total_record2();
        $config2['per_page'] = 4;
        $config2['uri_segment'] = 3;
        $this->pagination->initialize($config2);
        $pagi2 = $this->pagination->create_links(); 
        
        $start = $this->uri->segment(3, 0);

        
        $rows = $this->m_dashboard->user_limit($config['per_page'],$start)->result();
        $rows2 = $this->m_dashboard->user_limit2($config2['per_page'],$start)->result();
        
        // $data['daftar_bea']= $this->m_dashboard->daftar_bea();
        // $data['daftar_berita']=$this->m_dashboard->daftar_berita();
        $data = array(
            'daftar_berita' => $rows2,
            'daftar_bea' => $rows,
            'pagination1' => $pagi1,
            'pagination2' => $pagi2,
            'start' => $start
        );
        $this->load->view('Dashboard',$data);
        unset($data);
    }
    public function logout()
    {
        $this->load->view('login');
    }
    
    public function DetailBerita($id) {
        $data['berita']= $this->m_dashboard->detailBerita($id)->row();
        $this->load->view('moreInfo', $data);
    }

}

