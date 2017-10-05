<?php defined('BASEPATH')OR exit('no direct script access allowed');
/**
 * 
 */
 class ModulBerita extends CI_Controller
 {
 	
 	function __construct()
 	{
 		parent::__construct();
 		$this->load->library('Loginauth');
		$this->loginauth->view_page();
		
 		$this->load->model('staff_kemahasiswaan/Berita','Berita');
 	}

 	public function tambahBerita()
 	{
 		$data['judul'] = $this->input->post('judulBerita');
 		$data['topik'] = $this->input->post('TopikBerita');
 		$data['penulis'] = $this->input->post('penulisBerita');
 		$data['konten'] = $this->input->post('kontenBerita');
 		$data['tanggal'] =date('Y:m:d');

 		$this->Berita->tambahBerita($data);
 		$this->session->set_flashdata('sukses','Data Berita berhasil ditambahkan');
 		redirect('staf_kemahasiswaan/C_staff/daftarBerita');

 	}

 	public function editBerita($id)
 	{
 		$data['berita'] = $this->Berita->editBerita($id)->row();
 		$this->load->view('attribute/header_staff');
        $this->load->view('staff_kemahasiswaan/editBerita',$data);
        $this->load->view('attribute/footer');
 	}

 	public function updateBerita()
 	{
 		$idberita = $this->input->post('idBerita');
 		$data['judul'] = $this->input->post('editjudulBerita');
 		$data['topik'] = $this->input->post('editTopikBerita');
 		$data['penulis'] = $this->input->post('editpenulisBerita');
 		$data['konten'] = $this->input->post('editkontenBerita');
 		$data['tanggal'] =date('Y:m:d');
 		$this->Berita->updateBerita($idberita, $data);
 		$this->session->set_flashdata('sukses','Data Berita berhasil di perbarui');
 		redirect('staf_kemahasiswaan/C_staff/daftarBerita');
 	}

 	public function hapusBerita($idBerita)
 	{
		$datahapus = $this->Berita->hapusBerita($idBerita);
		if ($datahapus) {
			$this->session->set_flashdata('sukses','data berita berhasil dihapus');
			redirect('staf_kemahasiswaan/C_staff/daftarBerita');
		}
 	}

 } ?>