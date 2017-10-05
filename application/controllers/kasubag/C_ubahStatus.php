<?php defined('BASEPATH')OR exit('tidak ada akses diizinkan');
/**
 *
 */
class C_ubahStatus extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->library('Loginauth');
    $this->loginauth->view_page();
    
    $this->load->model("kasubag/UbahStatus",'mdl');
  }

  public function index()
  {
    $this->load->view('attribute/header_kasubag');
    $this->load->view('kasubag/ubahStatus');
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
      $namaBea = $this->mdl->namaBea($row->idBea);
      $nmr+=1;
      $status=   $row->status;

      if ($status == 1){
        $hai2 = "<div class='chip blue accent-1 white-text'>
        Diterima
      </div>";
    }
    else {
      $hai2 = "<div class='chip red accent-1 white-text'>Ditolak</div>";
    }

    $sub_array = array();
    $sub_array[] = $nmr;
    $sub_array[] = $row->nim;
    $sub_array[] = $namaBea;
    $sub_array[] = $hai2;

    $sub_array[] = $row->waktuDiubah;
    /*$sub_array[] = '
    <button type="button" name="remove" id="'.$row->id.'" onclick="remove('."'".$row->id."','".$row->userId."'".')" class="btn-floating waves-effect waves-light red" title="Hapus"><i class="mdi-action-delete">delete</i></button>
    ';*/
    if ($row->status== 1) {
      $sub_array[] = '
      <button class="btn-floating waves-effect waves-light primary-color" title="Change Status" type="submit" name="idPengaturan" onclick="seleksi('."'".$row->id."'".','."'".$row->status."'".');"><i class="mdi-action-done"></i></button>
      ';
    }elseif ($row->status== 0) {
      $sub_array[] = '
      <button class="btn-floating waves-effect waves-light red" title="Change Status" type="submit" name="idPengaturan" onclick="seleksi('."'".$row->id."'".','."'".$row->status."'".');"><i class="mdi-content-clear"></i></button>
      ';
    }


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
public function seleksi($id, $status)
{
  $change_status;
  if ($status==1) {
    $change_status = 0;
  }else if ($status==0) {
    $change_status = 1;
  }
  $data = array(
    'status' => $change_status
    );
  $this->mdl->change_status(array('id' => $id), $data);
  echo json_encode(array("status" => TRUE));
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
}
?>
