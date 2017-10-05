<?php defined('BASEPATH')OR exit('tidak ada akses diizinkan');
/**
 *
 */
class C_admin extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->library('Loginauth');
    $this->loginauth->view_page();
    
    $this->load->model("admin/M_admin",'mdl');
    $this->load->model("admin/ProfileAdmin",'modl');
  }

  public function index()
  {
    $this->load->view('attribute/header_admin');
    $this->load->view('admin/dashboard');
    $this->load->view('attribute/footer');
  }
  public function mjm_user()
  {

    $this->load->view('attribute/header_admin');
    $this->load->view('admin/mjm_user');
    $this->load->view('attribute/footer');
  }
  public function datatable(){
    $fetch_data = $this->mdl->make_datatables();
    $data = array();
    $nmr = 0;
    $hai = null;
    $hai2 = null;
    foreach($fetch_data as $row)
    {
      $nmr+=1;
      $pilih_hitung = $row->idLevel;
      $status=   $row->status;
      if ($pilih_hitung == 1){
        $hai = "Staff kemahasiswaan";
      }
      else if ($pilih_hitung == 2){
        $hai = "Kasubag";
      }
      else if ($pilih_hitung == 3){
        $hai = "Kasubag Fakultas";
      }
      else if ($pilih_hitung == 4){
        $hai = "Kabag";
      }
      else if ($pilih_hitung == 5){
        $hai = "Mahasiswa";
      }else if ($pilih_hitung == 6){
        $hai = "Admin";
      }

      if ($status == "open"){
        $hai2 = "<div class='chip blue accent-1 white-text'>
        Aktif
      </div>";
    }
    else {
      $hai2 = "<div class='chip red accent-1 white-text'>Tidak&nbsp;Aktif</div>";
    }

    $sub_array = array();
    $sub_array[] = $nmr;
    $sub_array[] = $row->userId;
    $sub_array[] = $row->password;
    $sub_array[] = $hai;
    $sub_array[] = $hai2;
    $sub_array[] = '
    <a name="edit" id="'.$row->id.'" href="'.base_url('C_admin/ajax_edit/'.$row->id).'" class="btn-floating waves-effect waves-light yellow accent-4" title="Edit"><i class="mdi-editor-mode-edit"></i></a>
    <button type="button" name="remove" id="'.$row->id.'" onclick="remove('."'".$row->id."','".$row->userId."'".')" class="btn-floating waves-effect waves-light red" title="Hapus"><i class="mdi-action-delete">delete</i></button>
    ';
    $data[] = $sub_array;

  }
  $output = array(
    "draw"            =>  intval($_POST["draw"]),
    "recordsTotal"    =>  $this->mdl->get_all_data(),
    "recordsFiltered" =>  $this->mdl->get_filtered_data(),
    "data"            =>  $data
    );
  echo json_encode($output);
}
public function ajax_add()
{
  $data = array(
    'userId' => $this->input->post('userId'),
    'password' => $this->input->post('password'),
    'idLevel' => $this->input->post('idLevel'),
    'status' => $this->input->post('status'),
    );
  $insert = $this->mdl->save($data);
  echo json_encode(array("status" => TRUE));
}
public function ajax_edit($id)
{
  $data['mhs'] = $this->mdl->get_by_id($id);
  $data['lvl'] = $this->mdl->getLevel($id);
  $data['status'] = $this->mdl->getStatus($id);
  $this->load->view('attribute/header_admin');
  $this->load->view('admin/edit_user',$data);
  $this->load->view('attribute/footer');
  unset($data);
}
private function _validate()
{
  $data = array();
  $data['error_string'] = array();
  $data['inputerror'] = array();
  $data['status'] = TRUE;

  if($this->input->post('userId') == '')
  {
    $data['inputerror'][] = 'userId';
    $data['error_string'][] = 'User Id harus diisi';
    $data['status'] = FALSE;
  }

  if($this->input->post('password') == '')
  {
    $data['inputerror'][] = 'password';
    $data['error_string'][] = 'Password harus diisi';
    $data['status'] = FALSE;
  }

  if($this->input->post('idLevel') == '')
  {
    $data['inputerror'][] = 'idLevel';
    $data['error_string'][] = 'Posisi user harus diisi';
    $data['status'] = FALSE;
  }

  if($this->input->post('status') == '')
  {
    $data['inputerror'][] = 'status';
    $data['error_string'][] = 'Silahkan pilih status user';
    $data['status'] = FALSE;
  }



  if($data['status'] === FALSE)
  {
    echo json_encode($data);
    exit();
  }
}
public function ajax_update()
{
  $data = array(
    'userId' => $this->input->post('userId'),
    'password' => $this->input->post('password'),
    'idLevel' => $this->input->post('idLevel'),
    'status' => $this->input->post('status'),

    );
  $nim = $this->input->post('lo');
  $this->mdl->update($nim,$data);
  redirect(base_url('C_admin/mjm_user'));  
  echo json_encode(array("status" => TRUE));
}
public function ajax_delete($id)
{
  $this->mdl->delete_by_id($id);
  echo json_encode(array("status" => TRUE));
}
public function profile()
{ 
    $user = $this->session->userdata('id');
    $cek = $this->modl->getdata($user);
    if($this->modl->getIdentitasAdmin($user) != 0){
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
  $this->load->view('attribute/header_admin');
  $this->load->view('admin/profileAdmin',$data);
  $this->load->view('attribute/footer');
}
public function updateProfile(){
  $nmfile = "file_".time();
  $path   = './assets/img/profile/';
  $config['upload_path'] = $path;
  $config['allowed_types'] = 'jpg|png|jpeg|bmp|gif';
  /*$config['allowed_types'] = 'gif|jpg|jpeg|png|iso|dmg|zip|rar|doc|docx|xls|xlsx|ppt|pptx|csv|ods|odt|odp|pdf|rtf|sxc|sxi|txt|exe|avi|mpeg|mp3|mp4|3gp';*/
  $config['max_size'] = '100';
  $config['max_width']  = '900';
  $config['max_height']  = '900';
  $config['file_name'] = $nmfile;

  $this->upload->initialize($config);
  $key    = $this->input->post('id');
  $exp      = $this->input->post('filelama');

  if($_FILES['filefoto']['name'])
  {
    if ($this->upload->do_upload('filefoto'))
    { 
      $gbr = $this->upload->data();
      $data = array(
        'foto'    => $gbr['file_name'],
        'id'    => $this->input->post('id'),
        'nama'    => $this->input->post('nama'),
        'alamat'  => $this->input->post('alamat'),
        'noTelp'  => $this->input->post('noTelp'),
        'email'   => $this->input->post('email')
        );

      $row = $this->db->where('id',$key)->get('profil_admin')->row();
      unlink('assets/img/profile/'.$row->foto);

      $where =array('id'=>$key);
      $this->modl->get_update($data,$where);

      $this->session->set_flashdata("pesan", "<div class=\"card-panel success\">Data Berhasil Disimpan</div>");
      redirect('C_admin/profile');
    }else{
      $this->session->set_flashdata("pesan", "<div class=\"card-panel alert\">Gagal Upload Foto [Max.Size 100Kb] [Types : jpg, png, jpeg, bmp, gif ]</div>");
      redirect('C_admin/profile');
    }
  }else if(empty($_FILES['filefoto']['name']))
  {
    $data = array(
      'id'      => $this->input->post('id'),
      'nama'      => $this->input->post('nama'),
      'alamat'    => $this->input->post('alamat'),
      'noTelp'    => $this->input->post('noTelp'),
      'email'     => $this->input->post('email')
      );

    $this->modl->getupdate($key,$data);
    $this->session->set_flashdata("pesan", "<div class=\"card-panel success col s12 m4 l6\">Data Berhasil Disimpan</div>");
    redirect('C_admin/profile');
  }
}
public function simpanPassword()
  {   
    $this->form_validation->set_rules('pwdnow','Current Password','required|alpha_numeric|min_length[1]|max_length[20]');
    $this->form_validation->set_rules('pwdnew','New Password','required|alpha_numeric|min_length[1]|max_length[20]');
    $this->form_validation->set_rules('retypepwd','Re-Type Password','required|alpha_numeric|min_length[1]|max_length[20]');
    if ($this->form_validation->run()) {
      $currpass  = $this->input->post('pwdnow');
      $newpass  = $this->input->post('pwdnew');
      $retypepwd = $this->input->post('retypepwd');
      $userid = $this->input->post('userid');
      $passwd = $this->modl->getCurrPass($userid);
      if ($passwd->password == $currpass) {
        if ($newpass ==$retypepwd) {
          if ($this->modl->updatePass($newpass,$userid)) {
            $this->session->set_flashdata("pesan", "<div class=\"card-panel success\">Berhasil Update Password</div>");
            redirect('C_admin/profile');
          }else{
            $this->session->set_flashdata("pesan", "<div class=\"card-panel alert\">Gagal Update Password</div>");
            redirect('C_admin/profile');
          }
        }else{
          $this->session->set_flashdata("pesan", "<div class=\"card-panel alert\">New Password dan Re-Type New Password yang anda masukkan tidak sama</div>");
          redirect('C_admin/profile');
        }
      }else{
        $this->session->set_flashdata("pesan", "<div class=\"card-panel alert\">Current Password tidak ada dalam database</div>");
          redirect('C_admin/profile');
      }
    }else{
      echo validation_errors();
    }
  }

}
?>
