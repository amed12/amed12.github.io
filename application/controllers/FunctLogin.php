<?php defined('BASEPATH')OR exit('tidak ada akses di izinkan');
/**
 *
 */
class FunctLogin extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('LoginMod', 'mod');
	}

	public function filter($data)
	{	$data = preg_replace('/[^a-zA-Z0-9]/', '', $data);
	return $data; 
	unset($data);
}

public function index()
{
	$this->load->view('login');
}
public function logout()
{
	$this->mod->putus_koneksi();
	$array_sess	= $this->session->all_userdata();

	$this->session->unset_userdata($array_sess);
	unset($array_sess);
	$this->session->sess_destroy();

	redirect('login');
}

public function prosesLogin()
{
	$username = $this->input->post('username');
	$username = $this->filter($username);

	$password= $this->input->post('password');
	// $password= md5($password);
	$password = $this->filter($password);

	$level = $this->input->post('levelPengguna');
	

	$prosesLog = $this->mod->actLogin($username, $password, $level)->row();
	$result = count($prosesLog);

	if ($result>0) {
		if ($username==$prosesLog->userId) {
			if ($password==$prosesLog->password) {
				// if ($status==$prosesLog->status) {
				if ($prosesLog->idLevel==1) {
					$data = array(
						'id'		=>$prosesLog->id,
						"username"	=>$prosesLog->userId,
						"pass" 		=>$prosesLog->password,
						"level"		=>$prosesLog->idLevel,
						"status"	=>$prosesLog->status);
					$this->session->set_userdata($data);
					redirect('staf_kemahasiswaan/C_staff');
				}else if($prosesLog->idLevel==2){
					$data = array(
						"id"=>$prosesLog->id,
						"username"=>$prosesLog->userId,
						"pass" 	=>$prosesLog->password,
						"level" =>$prosesLog->idLevel,
						"status"=>$prosesLog->status);
					$this->session->set_userdata($data);
					redirect('kasubag/Kasubag');
				}else if($prosesLog->idLevel==3){
					$data = array(
						"id"=>$prosesLog->id,
						"username"=>$prosesLog->userId,
						"pass"=>$prosesLog->password,
						"level"=>$prosesLog->idLevel,
						"status"=>$prosesLog->status);
					$this->session->set_userdata($data);
					redirect('kasubag_fakultas/C_kasubagfk');
				}else if($prosesLog->idLevel==4){
					$data = array(
						"id"=>$prosesLog->id,
						"username"=>$prosesLog->userId,
						"pass" 		=>$prosesLog->password,
						"level"=>$prosesLog->idLevel,
						"status"=>$prosesLog->status);
					$this->session->set_userdata($data);

					redirect('kabag/C_kabag');
				}else if($prosesLog->idLevel==5){
					$data = array(
						"id"=>$prosesLog->id,
						"username"=>$prosesLog->userId,
						"pass" 		=>$prosesLog->password,
						"level"=>$prosesLog->idLevel,
						"status"=>$prosesLog->status);
					$this->session->set_userdata($data);

					redirect('mahasiswa/C_mahasiswa');

				}else if($prosesLog->idLevel==6){
					$data = array(
						"id"=>$prosesLog->id,
						"username"=>$prosesLog->userId,
						"pass" 		=>$prosesLog->password,
						"level"=>$prosesLog->idLevel,
						"status"=>$prosesLog->status);
					$this->session->set_userdata($data);

					redirect('C_admin');

				}else{
					$this->session->set_flashdata('gagal','Level tidak terpenuhi');
					redirect('functLogin');
				}


			/*else{
				$this->session->set_flashdata('gagal','terdaftar');
				redirect('functLogin');
			}*/
		}else{
			$this->session->set_flashdata('gagal','Password salah');
			redirect('functLogin');
		}
	}else{
		$this->session->set_flashdata('gagal','Username tidak tepat');
		redirect('functLogin');	
	}
}else{
	$this->session->set_flashdata('gagal','Data anda tidak terdaftar dalam sistem');
	redirect('functLogin');
}

}
}
?>