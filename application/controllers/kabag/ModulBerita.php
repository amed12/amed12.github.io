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
		$this->load->model('Kasubag/Berita');
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
		redirect('kasubag/Kasubag/daftarBerita');

	}

	public function editBerita()
	{
		$berita = $this->Berita->editBerita();
		echo json_encode($berita);
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
		redirect('kasubag/Kasubag/daftarBerita');
	}

	public function hapusBerita($idBerita)
	{
		$datahapus = $this->Berita->hapusBerita($idBerita);
		if ($datahapus) {
			$this->session->set_flashdata('sukses','data berita berhasil dihapus');
			redirect('kasubag/Kasubag/daftarBerita');
		}
	}

} ?>