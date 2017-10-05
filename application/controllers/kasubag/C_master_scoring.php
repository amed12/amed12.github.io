<?php defined('BASEPATH')OR exit('tidak ada akses diizinkan');
class C_master_scoring extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->library('Loginauth');
    $this->loginauth->view_page();
    
    $this->load->model("kasubag/Master_scoring",'mdl');
  }

  public function index()
  {
    $this->load->view('attribute/header_kasubag');
    $this->load->view('kasubag/master_scoring');
    $this->load->view('attribute/footer');
  }

  public function datatable(){
    $fetch_data = $this->mdl->make_datatables();
    $data = array();
    $nmr = 0;
    foreach($fetch_data as $row)
    {
      $nmr+=1;
      $sub_array = array();
      $sub_array[] = $nmr;
      $sub_array[] = $row->nama;
      $sub_array[] = $this->mdl->get_sub_score($row->id);
      $sub_array[] = '
        <button type="button" name="edit" id="'.$row->id.'" onclick="edit('."'".$row->id."'".')" class="btn-floating waves-effect waves-light yellow accent-4" title="Edit"><i class="mdi-editor-mode-edit"></i></button>
        <button type="button" name="remove" id="'.$row->id.'" onclick="remove('."'".$row->id."','".$row->nama."'".')" class="btn-floating waves-effect waves-light red" title="Hapus"><i class="mdi-action-delete">delete</i></button>
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

  public function add_data()
  {
    $data_kategori = array(
      'nama' => $this->input->post('jenisScoring'),
    );
    $insert_kategori = $this->mdl->save_kategori($data_kategori);

    $count_score = count($this->input->post('score'));
    $data = array();
    for ($i=0;$i<$count_score;$i++) {
      $data[$i]= array(
        'idKategoriSkor' => $insert_kategori,
        'nama' => $this->input->post('score['.$i.']'),
        'skor' => $this->input->post('bobot['.$i.']'),
      );
    }
    $insert_sub_kategori = $this->mdl->save_sub_kategori($data);
    echo json_encode(array("status" => TRUE));
  }

  public function edit_data($id)
  {
    $kategori = $this->mdl->get_by_id($id);
    $namaKategori = $kategori->nama;
    $idKategori = $kategori->id;

    $subSkor = $this->mdl->get_by_id_sub($id);
    $data = array();
    $data [0] = array(
      'namaJenis' => $namaKategori,
      'idJenis' => $idKategori
    );
    $i = 1;
    foreach ($subSkor as $sub) {
      $data[$i] = array(
        'idSub' => $sub->id,
        'sub' => $sub->nama,
        'skor' => $sub->skor
      );
      $i+=1;
    }
    echo json_encode($data);
  }

  public function update_data()
  {
    $idKategori = $this->input->post('idJenisScoring');
    $data_kategori = array(
      'nama' => $this->input->post('jenisScoring'),
    );
    $this->mdl->update_kategori(array('id' => $idKategori), $data_kategori);

    $count_score = count($this->input->post('score'));
    for ($i=0;$i<$count_score;$i++) {
      $idSub = $this->input->post('idSub['.$i.']');
      $sub = $this->input->post('score['.$i.']');
      $skor = $this->input->post('bobot['.$i.']');
      $dataSub = array(
        'idKategoriSkor' => $idKategori,
        'nama' => $sub,
        'skor' => $skor,
      );
      if ($idSub==null && $sub!=null) {
        # insert
        $this->mdl->insert_sub_kategori($dataSub);
      }elseif ($idSub!=null && $sub!=null) {
        # update
        $this->mdl->update_sub_kategori(array('id' => $idSub), $dataSub);
      }elseif ($idSub!=null && $sub==null) {
        # delete
        $this->mdl->delete_sub_kategori($idSub);
      }
    }
    echo json_encode(array("status" => TRUE));
  }

  public function delete_data($id)
  {
    $this->mdl->delete_by_id($id);
    echo json_encode(array("status" => TRUE));
  }
}
 ?>
