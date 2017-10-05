<?php defined('BASEPATH')OR exit('no direct script access allowed');
/**
 *
 */
class ModulBeasiswa extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->library('Loginauth');
		$this->loginauth->view_page();
		
		$this->load->model('Kasubag/Beasiswa');
	}

	public function index()
	{
		$data['bea']= $this->Beasiswa->daftarBeasiswa();
		$this->load->view('attribute/header_kasubag');
		$this->load->view('kasubag/Beasiswa', $data);
		$this->load->view('attribute/FooterKasubag');
	}

	public function tambahBeasiswa()
	{
		$data['nama']=$this->input->post('namaBeasiswa');
		$data['penyelenggara']=$this->input->post('penyelenggaraBea');
		$data['buka']=$this->input->post('beaDiBuka');
		$data['tutup']=$this->input->post('beaTutup');
		$data['status']=$this->input->post('statusbea');
		$data['tabel']=$this->input->post('statusTabel');
		$data['kuota'] = $this->input->post('kuotaBeasiswa');

		$this->Beasiswa->tambahBeasiswa($data);
		$this->session->set_flashdata('sukses','data beasiswa baru berhasil ditambahkan ke dalam sistem');
		redirect('kasubag/ModulBeasiswa');
	}
	public function EditBeasiswa()
	{
		$data = $this->Beasiswa->editBeasiswa();
		echo json_encode($data);
	}

	public function hapusBeasiswa($idBea)
	{
		$data = $this->Beasiswa->hapusBeasiswa($idBea);
		if ($data) {
			$this->session->set_flashdata('sukses','data beasiswa terkait berhasil dihapus');
			redirect('kasubag/ModulBeasiswa');
		}
	}
} ?>
